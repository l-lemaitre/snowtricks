<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CategoryController extends AbstractController
{
    /* Demo
    #[Route('/category', name: 'app_category')]
    public function index(): Response
    {
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }*/

    #[Route('/create-category', name: 'app_create_category')]
    public function createCategory(ManagerRegistry $doctrine, ValidatorInterface $validator): Response
    {
        $categoryRepository = new CategoryRepository($doctrine);

        $category = new Category();
        $category->setTitle('other');
        $category->setSlug('other');
        $category->setDateAdd($categoryRepository->CurrentDate);

        $errors = $validator->validate($category);
        if (count($errors) > 0) {
            return new Response((string) $errors, 400);
        }

        $entityManager = $doctrine->getManager();
        $entityManager->persist($category);
        $entityManager->flush();

        return new Response('Saved new category with id '.$category->getId());
    }
}
