<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Trick;
use App\Entity\User;
use App\Entity\Video;
use App\Form\TrickType;
use App\Repository\TrickRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class TrickController extends AbstractController
{
    #[Route('/trick', name: 'app_trick')]
    public function index(): Response
    {
        return $this->render('trick/index.html.twig', [
            'controller_name' => 'TrickController',
        ]);
    }

    #[Route('/trick/add', name: 'app_trick_add')]
    public function add(Request $request, ManagerRegistry $doctrine, SluggerInterface $slugger)
    {
        $trick = new Trick();
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $doctrine->getRepository(User::class)->find(1);
            $trick->setUser($user);

            $imgs = $form->get('image')->getData();

            $entityManager = $doctrine->getManager();

            foreach ($imgs as $img) {
                $originalFilename = pathinfo($img->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $img->guessExtension();

                // Move the file to the directory where images are stored
                try {
                    $img->move(
                        $this->getParameter('img_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Handle exception if something happens during file upload
                    return 'Error upload.';
                }

                $image = new Image();
                $image->setTrick($trick);
                $image->setUrl("/img/" . $newFilename);

                $entityManager->persist($image);

                $trick->setImage($image);
                $trick->addImage($image);
            }

            $videos = $form->get('video')->getData();

            if ($videos) {
                $video = new Video();
                $video->setTrick($trick);
                $video->setUrl($videos);

                $entityManager->persist($video);

                $trick->setVideo($video);
                $trick->addVideo($video);
            }

            $trick->setDeleted(0);

            $trickRepository = new TrickRepository($doctrine);
            $trick->setDateAdd($trickRepository->CurrentDate);
            $trick->setDateUpdated($trickRepository->CurrentDate);

            $entityManager->persist($trick);
            $entityManager->flush();

            return $this->redirectToRoute('home_page');
        }

        return $this->render('form/add-trick.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
