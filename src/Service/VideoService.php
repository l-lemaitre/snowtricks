<?php

namespace App\Service;

use App\Entity\Trick;
use App\Entity\Video;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Form\Form;

class VideoService
{
    public function addTrickVideo(ObjectManager $entityManager, Trick $trick, object $videos, bool $editTrick = false): void
    {
        if ($editTrick) {
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
        } else {
            $videos = array_unique($videos, SORT_REGULAR);

            foreach ($videos as $videoUrl) {
                $video = new Video();
                $video->setTrick($trick);
                $video->setUrl($videoUrl);

                $entityManager->persist($video);
            }
        }
    }
}
