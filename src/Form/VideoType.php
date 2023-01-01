<?php

namespace App\Form;

use App\Entity\Video;
use App\Repository\VideoRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class VideoType extends AbstractType
{
    protected $requestStack;
    protected $videoRepository;

    public function __construct(RequestStack $requestStack, VideoRepository $videoRepository)
    {
        $this->requestStack = $requestStack;
        $this->videoRepository = $videoRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $trick_id = $this->requestStack->getCurrentRequest()->attributes->get('id');
        $videos = $this->videoRepository->getVideos($trick_id);

        $builder
            ->add('url', UrlType::class, [
                'label' => false,
                'constraints' => [
                    new NotBlank(),
                    new Assert\Callback([
                        'callback' => static function (?string $value, ExecutionContextInterface $context) use ($videos) {
                            foreach ($videos as $video) {
                                if ($value == $video->getUrl()) {
                                    $context
                                        ->buildViolation("Cette vidéo existe déjà pour cette figure.")
                                        ->addViolation();
                                }
                            }
                        }
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Video::class
        ]);
    }
}
