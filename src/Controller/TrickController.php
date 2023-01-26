<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Message;
use App\Entity\Trick;
use App\Entity\Video;
use App\Form\AddTrickMessageType;
use App\Form\AddTrickType;
use App\Form\EditTrickImageType;
use App\Form\EditTrickType;
use App\Form\EditTrickVideoType;
use App\Form\RemoveTrickType;
use App\Repository\TrickRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Service\ImageService;
use App\Service\MessageService;
use App\Service\TrickService;
use App\Service\VideoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class TrickController extends AbstractController
{
    private TrickRepository $trickRepository;

    private TrickService $trickService;

    private ImageService $imageService;

    private MessageService $messageService;

    private VideoService $videoService;

    public function __construct(TrickRepository $trickRepository, TrickService $trickService, ImageService $imageService, MessageService $messageService, VideoService $videoService)
    {
        $this->trickRepository = $trickRepository;
        $this->trickService = $trickService;
        $this->imageService = $imageService;
        $this->messageService = $messageService;
        $this->videoService = $videoService;
    }

    #[Route('/trick/add', name: 'app_trick_add')]
    public function add(Request $request, ManagerRegistry $doctrine, SluggerInterface $slugger): Response
    {
        $user = $this->getUser();
        $userVerified = $user->isIsVerified();

        $trick = new Trick();

        $form = $this->createForm(AddTrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();

            $imgs = $form->get('image')->getData();

            if ($imgs) {
                $addTrickImage = $this->imageService->addTrickImage($entityManager, $slugger, $trick, $imgs, $this->getParameter('img_directory'));
            }

            $slug = $form->get('title')->getData();

            $videos = $form->get('video')->getData();

            if ($videos) {
                $addTrickVideo = $this->videoService->addTrickVideo($entityManager, $trick, $videos);
            }

            $addTrick = $this->trickService->addTrick($entityManager, $trick, $user, $slug, $this->trickRepository->currentDate);

            $entityManager->flush();

            $type = 'success';
            $message = 'Enregistrement de la figure réussi.';

            $this->addFlash($type, $message);

            return $this->redirectToRoute('app_home_page');
        }

        return $this->render('form/add-trick.html.twig', [
            'userVerified' => $userVerified,
            'form' => $form->createView()
        ]);
    }

    #[Route('/trick/edit/{slug}', name: 'app_trick_edit')]
    public function edit(Request $request, ManagerRegistry $doctrine, SluggerInterface $slugger, string $slug): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $userVerified = $user->isIsVerified();

        $trick = $this->trickRepository->getTrick($slug);

        if ($trick) {
            $trickId = $trick->getId();
        } else {
            $trickId = false;
        }

        $imageForm = $this->createForm(EditTrickImageType::class, $trick);
        $form = $this->createForm(EditTrickType::class, $trick);
        $videoForm = $this->createForm(EditTrickVideoType::class, $trick);
        $removeForm = $this->createForm(RemoveTrickType::class, $trick);

        $imageRepository = $doctrine->getRepository(Image::class);
        $images = $imageRepository->getImages($trickId);

        $videoRepository = $doctrine->getRepository(Video::class);
        $videos = $videoRepository->getVideos($slug);

        $imageForm->handleRequest($request);
        $form->handleRequest($request);
        $videoForm->handleRequest($request);
        $removeForm->handleRequest($request);

        $entityManager = $doctrine->getManager();

        if ($imageForm->isSubmitted() && $imageForm->isValid()) {
            $imgs = $imageForm->get('image')->getData();

            $addTrickImage = $this->imageService->addTrickImage($entityManager, $slugger, $trick, $imgs, $this->getParameter('img_directory'));

            $entityManager->persist($trick);
            $entityManager->flush();

            $type = 'success';
            $message = 'Modification de la figure réussie.';

            $this->addFlash($type, $message);

            return $this->redirectToRoute('app_home_page');
        }

        if ($videoForm->isSubmitted() && $videoForm->isValid()) {
            $videos = $videoForm->get('video');

            $addTrickVideo = $this->videoService->addTrickVideo($entityManager, $trick, $videos, true);

            $entityManager->flush();

            $type = 'success';
            $message = 'Modification de la figure réussie.';

            $this->addFlash($type, $message);

            return $this->redirectToRoute('app_home_page');
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $form->get('title')->getData();

            $editTrick = $this->trickService->editTrick($entityManager, $trick, $user, $slug, $this->trickRepository->currentDate);

            $type = 'success';
            $message = 'Modification de la figure réussie.';

            $this->addFlash($type, $message);

            return $this->redirectToRoute('app_index_page');
        }

        if ($removeForm->isSubmitted() && $removeForm->isValid()) {
            $removeTrick = $this->trickService->removeTrick($entityManager, $trick, $this->trickRepository->currentDate);

            $type = 'success';
            $message = 'Suppression de la figure réussie.';

            $this->addFlash($type, $message);

            return $this->redirectToRoute('app_home_page');
        }

        return $this->render('form/edit-trick.html.twig', [
            'userVerified' => $userVerified,
            'trick' => $trick,
            'images' => $images,
            'videos' => $videos,
            'form' => $form->createView(),
            'imageForm' => $imageForm->createView(),
            'videoForm' => $videoForm->createView(),
            'removeForm' => $removeForm->createView()
        ]);
    }

    #[Route('/trick/delete/{slug}', name: 'app_trick_delete', methods: ['post'])]
    public function delete(ManagerRegistry $doctrine, string $slug): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $userVerified = $user->isIsVerified();

        if ($userVerified) {
            $trick = $this->trickRepository->getTrick($slug);

            $entityManager = $doctrine->getManager();

            $removeTrick = $this->trickService->removeTrick($entityManager, $trick, $this->trickRepository->currentDate);

            return new JsonResponse(true);
        } else {
            return new JsonResponse(false);
        }
    }

    #[Route('/trick/{slug}', name: 'app_trick_show')]
    public function show(Request $request, ManagerRegistry $doctrine, string $slug): Response
    {
        $user = $this->getUser();

        if ($user) {
            $userVerified = $user->isIsVerified();
            $trick = $this->trickRepository->getTrick($slug);
        } else {
            $userVerified = false;
            $trick = $this->trickRepository->getPublishedTrick($slug);
        }

        if ($trick) {
            $trickId = $trick->getId();
        } else {
            $trickId = false;
        }

        $page = $request->query->get('page');

        $imageRepository = $doctrine->getRepository(Image::class);
        $images = $imageRepository->getImages($trickId);

        $videoRepository = $doctrine->getRepository(Video::class);
        $videos = $videoRepository->getVideos($slug);

        $messageRepository = $doctrine->getRepository(Message::class);
        $messages = $messageRepository->getMessages($trickId, $page);

        $limit = 10;
        $maxPages = ceil($messages->count() / $limit);
        $thisPage = $page;

        $messageForm = $this->createForm(AddTrickMessageType::class, $trick);
        $messageForm->handleRequest($request);

        if ($messageForm->isSubmitted() && $messageForm->isValid()) {
            $entityManager = $doctrine->getManager();

            $contents = $messageForm->get('contents')->getData();

            $addMessage = $this->messageService->addMessage($entityManager, $trick, $user, $contents, $this->trickRepository->currentDate);

            $type = 'success';
            $flashMessage = 'Votre message a été ajouté.';

            $this->addFlash($type, $flashMessage);

            return $this->redirectToRoute('app_trick_show', [
                'slug' => $slug,
                'page' => 1,
                '_fragment' => 'comment'
            ]);
        }

        return $this->render('trick/trick.html.twig', [
            'userVerified' => $userVerified,
            'trick' => $trick,
            'images' => $images,
            'videos' => $videos,
            'messages' => $messages,
            'messageForm' => $messageForm->createView(),
            'maxPages' => $maxPages,
            'thisPage' => $thisPage
        ]);
    }
}
