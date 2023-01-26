<?php

namespace App\Service;

use App\Entity\Video;

class VideoService
{
    public function addTrickVideo($entityManager, $trick, $videos, $editTrick = false)
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
