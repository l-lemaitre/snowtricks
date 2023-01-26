<?php

namespace App\Controller;

use App\Form\ResetPasswordFormType;
use App\Form\ChangePasswordFormType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class SecurityController extends AbstractController
{
    #[Route('/logout', name: 'app_logout', methods: ['GET'])]
    public function logout()
    {
        // controller can be blank: it will never be called!
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }

    #[Route('/forgotten-password', name: 'app_forgotten_password')]
    public function forgottenPassword(Request $request, ManagerRegistry $doctrine, UserRepository $userRepository, MailerInterface $mailer, TokenGeneratorInterface $tokenGenerator): Response
    {
        if ($this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('app_index_page');
        }

        $form = $this->createForm(ResetPasswordFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $username = $form->get('username')->getData();

            $user = $userRepository->getUserByUsername($username);

            if ($user === null) {
                $this->addFlash('danger', 'Cet utilisateur est inconnu.');

                return $this->redirectToRoute('app_login');
            }

            $resetToken = $tokenGenerator->generateToken();

            try{
                $user->setResetToken($resetToken);
                $entityManager = $doctrine->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
            } catch (\Exception $e) {
                $this->addFlash('warning', $e->getMessage());
                return $this->redirectToRoute('app_login');
            }

            $resetPasswordUrl = $this->generateUrl('app_reset_password', array('token' => $resetToken), UrlGeneratorInterface::ABSOLUTE_URL);

            $email = (new TemplatedEmail())
                ->from(new Address('contact@llemaitre.com', 'SnowTricks'))
                ->to($user->getEmail())
                ->subject('Votre demande de réinitialisation de mot de passe')
                ->htmlTemplate('reset_password/reset_password_email.html.twig')
                ->context([
                    'resetPasswordUrl' => $resetPasswordUrl
                ])
            ;

            $mailer->send($email);

            $this->addFlash('success', 'E-mail de réinitialisation du mot de passe envoyé.');

            return $this->redirectToRoute('app_login');
        }

        return $this->render('reset_password/forgotten_password.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/reset-password/{token}', name: 'app_reset_password')]
    public function resetPassword(Request $request, ManagerRegistry $doctrine, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher, string $token)
    {
        if ($this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('app_index_page');
        }

        $user = $userRepository->findOneBy(['reset_token' => $token]);

        if ($user === null) {
            $this->addFlash('danger', 'Token inconnu.');
            return $this->redirectToRoute('app_login');
        }

        $form = $this->createForm(ChangePasswordFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setResetToken(null);

            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $doctrine->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Mot de passe mis à jour');

            return $this->redirectToRoute('app_login');
        } else {
            return $this->render('reset_password/reset_password.html.twig', [
                'token' => $token,
                'form' => $form->createView()
            ]);
        }

    }
}
