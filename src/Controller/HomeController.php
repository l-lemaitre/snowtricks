<?php

namespace App\Controller;

use App\Entity\Trick;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home_page')]
    #[Route('/index', name: 'app_index_page')]
    #[Route('/tricks', name: 'app_tricks')]
    public function home(ManagerRegistry $doctrine): Response
    {
        $user = $this->getUser();
        if ($user) {
            $userVerified = $user->isIsVerified();

            $tricks = $doctrine->getRepository(Trick::class)->getTricks();
        } else {
            $userVerified = false;

            $tricks = $doctrine->getRepository(Trick::class)->getPublishedTricks();
        }

        return $this->render('home.html.twig', [
            'userVerified' => $userVerified,
            'tricks' => $tricks
        ]);
    }
}
