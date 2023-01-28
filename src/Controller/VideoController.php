<?php

namespace App\Controller;

use App\Repository\VideoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VideoController extends AbstractController
{
    #[Route('/video/delete/{id}', name: 'app_video_delete', methods: ['delete'])]
    public function delete(int $id, VideoRepository $videoRepository): Response
    {
        $video = $videoRepository->find($id);

        $videoRepository->remove($video, true);

        return new JsonResponse(true);
    }
}
