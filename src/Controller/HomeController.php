<?php

namespace App\Controller;

use App\Entity\Trick;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home_page')]
    #[Route('/index', name: 'index_page')]
    public function home(ManagerRegistry $doctrine)
    {
        $repository = $doctrine->getRepository(Trick::class);

        $tricks = $repository->findAll();

        return $this->render('home.html.twig', [
            'tricks' => $tricks
        ]);
    }
}