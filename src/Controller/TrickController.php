<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Image;
use App\Entity\Message;
use App\Entity\status;
use App\Entity\Trick;
use App\Entity\User;
use App\Entity\Video;
use App\Form\AddTrickMessageType;
use App\Form\AddTrickType;
use App\Form\EditTrickImageType;
use App\Form\EditTrickType;
use App\Form\EditTrickVideoType;
use App\Form\RemoveImageType;
use App\Form\RemoveTrickType;
use App\Repository\TrickRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class TrickController extends AbstractController
{
    /* Demo
    #[Route('/trick', name: 'app_trick')]
    public function index(): Response
    {
        return $this->render('trick/index.html.twig', [
            'controller_name' => 'TrickController'
        ]);
    }*/

    #[Route('/trick/add', name: 'app_trick_add')]
    public function add(Request $request, ManagerRegistry $doctrine, SluggerInterface $slugger)
    {
        $user = $this->getUser();
        $userVerified = $user->isIsVerified();

        $trick = new Trick();

        $form = $this->createForm(AddTrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trick->setUser($user);

            $entityManager = $doctrine->getManager();

            $imgs = $form->get('image')->getData();

            if ($imgs) {
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
            }

            $videos = $form->get('video')->getData();

            if ($videos) {
                foreach ($videos as $videoUrl) {
                    $video = new Video();
                    $video->setTrick($trick);
                    $video->setUrl($videoUrl);

                    $entityManager->persist($video);
                }
            }

            $slug = $form->get('slug')->getData();
            $slug = strtolower($slug);
            $slug = preg_replace('/[^a-z0-9]+/', '', $slug);

            $trick->setSlug($slug);
            $trick->setDeleted(0);

            $trickRepository = new TrickRepository($doctrine);
            $trick->setDateAdd($trickRepository->CurrentDate);
            $trick->setDateUpdated($trickRepository->CurrentDate);

            $entityManager->persist($trick);
            $entityManager->flush();

            $type = 'success';
            $message = 'Enregistrement de la figure réussi.';

            $this->addFlash($type, $message);

            return $this->redirectToRoute('app_home_page');
        }

        return $this->render('form/add-trick.html.twig', array(
            'userVerified' => $userVerified,
            'form' => $form->createView()
        ));
    }

    #[Route('/trick/edit/{slug}-{id}', name: 'app_trick_edit')]
    public function edit(Request $request, ManagerRegistry $doctrine, SluggerInterface $slugger, TrickRepository $trickRepository, int $id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $userVerified = $user->isIsVerified();

        $trick = $trickRepository->getTrick($id);

        $imageForm = $this->createForm(EditTrickImageType::class, $trick);
        $form = $this->createForm(EditTrickType::class, $trick);
        $videoForm = $this->createForm(EditTrickVideoType::class, $trick);
        $removeForm = $this->createForm(RemoveTrickType::class, $trick);

        $imageRepository = $doctrine->getRepository(Image::class);
        $images = $imageRepository->getImages($id);

        $videoRepository = $doctrine->getRepository(Video::class);
        $videos = $videoRepository->getVideos($id);

        $imageForm->handleRequest($request);
        $form->handleRequest($request);
        $videoForm->handleRequest($request);
        $removeForm->handleRequest($request);

        $entityManager = $doctrine->getManager();

        if ($imageForm->isSubmitted() && $imageForm->isValid()) {
            $imgs = $imageForm->get('image')->getData();

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
            }

            $entityManager->persist($trick);
            $entityManager->flush();

            $type = 'success';
            $message = 'Modification de la figure réussie.';

            $this->addFlash($type, $message);

            return $this->redirectToRoute('app_home_page');
        }

        if ($videoForm->isSubmitted() && $videoForm->isValid()) {
            $videos = $videoForm->get('video');

            foreach ($videos as $videoObject) {
                $videosUrl[] = [
                    "url" => $videoObject->get('url')->getData()
                ];
            }

            $videosUrl = array_unique($videosUrl, SORT_REGULAR);

            foreach ($videosUrl as $videoUrl) {
                $video = new Video();
                $video->setTrick($trick);
                $video->setUrl($videoUrl['url']);

                $entityManager->persist($video);
            }

            $entityManager->flush();

            $type = 'success';
            $message = 'Modification de la figure réussie.';

            $this->addFlash($type, $message);

            return $this->redirectToRoute('app_home_page');
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $form->get('slug')->getData();
            $slug = strtolower($slug);
            $slug = preg_replace('/[^a-z0-9]+/', '', $slug);

            $trick->setUser($user);
            $trick->setSlug($slug);
            $trick->setDateUpdated($trickRepository->CurrentDate);

            $entityManager->persist($trick);
            $entityManager->flush();

            $type = 'success';
            $message = 'Modification de la figure réussie.';

            $this->addFlash($type, $message);

            return $this->redirectToRoute('app_index_page');
        }

        if ($removeForm->isSubmitted() && $removeForm->isValid()) {
            $trick->setDeleted(1);
            $trick->setDateUpdated($trickRepository->CurrentDate);

            $entityManager->persist($trick);
            $entityManager->flush();

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

    #[Route('/trick/delete/{id}', name: 'app_trick_delete', methods: ['post'])]
    public function delete(ManagerRegistry $doctrine, TrickRepository $trickRepository, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $userVerified = $user->isIsVerified();

        if ($userVerified) {
            $trick = $trickRepository->getTrick($id);

            $entityManager = $doctrine->getManager();

            $trick->setDeleted(1);
            $trick->setDateUpdated($trickRepository->CurrentDate);

            $entityManager->persist($trick);
            $entityManager->flush();

            return new JsonResponse(true);
        } else {
            return new JsonResponse(false);
        }
    }

    #[Route('/trick/{slug}-{id}', name: 'app_trick_show')]
    public function show(Request $request, ManagerRegistry $doctrine, TrickRepository $trickRepository, $slug, int $id): Response
    {
        $user = $this->getUser();
        if ($user) {
            $userVerified = $user->isIsVerified();
        } else {
            $userVerified = false;
        }

        $trick = $trickRepository->getTrick($id);
        $page = $request->query->get('page');

        $imageRepository = $doctrine->getRepository(Image::class);
        $images = $imageRepository->getImages($id);

        $videoRepository = $doctrine->getRepository(Video::class);
        $videos = $videoRepository->getVideos($id);

        $messageRepository = $doctrine->getRepository(Message::class);
        $messages = $messageRepository->getMessages($id, $page);

        $limit = 5;
        $maxPages = ceil($messages->count() / $limit);
        $thisPage = $page;

        $messageForm = $this->createForm(AddTrickMessageType::class, $trick);
        $messageForm->handleRequest($request);

        if ($messageForm->isSubmitted() && $messageForm->isValid()) {
            $message = new Message();

            $message->setUser($user);

            $message->setTrick($trick);

            $status = $doctrine->getRepository(Status::class)->find(2);
            $message->setStatus($status);

            $contents = $messageForm->get('contents')->getData();
            $message->setContents($contents);

            $trickRepository = new TrickRepository($doctrine);
            $message->setDateAdd($trickRepository->CurrentDate);
            $message->setDateUpdated($trickRepository->CurrentDate);

            $entityManager = $doctrine->getManager();
            $entityManager->persist($message);
            $entityManager->flush();

            $type = 'success';
            $flashMessage = 'Votre message a été ajouté.';

            $this->addFlash($type, $flashMessage);

            return $this->redirectToRoute('app_trick_show', [
                'slug' => $slug,
                'id' => $id,
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
