<?php

namespace App\Form;

use App\Entity\Video;
use App\Repository\VideoRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
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

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $trick_slug = $this->requestStack->getCurrentRequest()->attributes->get('slug');
        $videos = $this->videoRepository->getVideos($trick_slug);

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
                                        ->buildViolation('This video already exists for this figure.')
                                        ->addViolation();
                                }
                            }
                        }
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Video::class
        ]);
    }
}
