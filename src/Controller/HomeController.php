<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home_page')]
    #[Route('/index', name: 'index_page')]
    public function home()
    {
        $tricks = ["mute", "sad", "indy", "stalefish", "tail grab ", "nose grab", "japan", "seat belt", "truck driver"];

        return $this->render('home.html.twig', [
            'tricks' => $tricks
        ]);
    }
}