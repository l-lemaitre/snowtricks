<?php

namespace App\Controller;

use App\Entity\Trick;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home_page')]
    #[Route('/index', name: 'app_index_page')]
    public function home(ManagerRegistry $doctrine)
    {
        $tricks = $doctrine->getRepository(Trick::class)->getTricks();

        return $this->render('home.html.twig', [
            'tricks' => $tricks
        ]);
    }
}