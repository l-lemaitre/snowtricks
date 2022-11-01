<?php

namespace App\Entity;

use App\Repository\TrickRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: TrickRepository::class)]
#[UniqueEntity(fields: ['title', 'slug'])]
class Trick
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id_trick')]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contents = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $published = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $deleted = 0;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_add = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_updated = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false, referencedColumnName: 'id_category')]
    private ?Category $category = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false, referencedColumnName: 'id_user')]
    private ?User $user = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false, referencedColumnName: 'id_image')]
    private ?Image $image = null;

    #[ORM\OneToMany(mappedBy: 'trick', targetEntity: Image::class)]
    private Collection $images;

    #[ORM\OneToMany(mappedBy: 'trick', targetEntity: Video::class)]
    private Collection $videos;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false, referencedColumnName: 'id_video')]
    private ?Video $video = null;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->videos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContents(): ?string
    {
        return $this->contents;
    }

    public function setContents(string $contents): self
    {
        $this->contents = $contents;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getPublished(): ?int
    {
        return $this->published;
    }

    public function setPublished(int $published): self
    {
        $this->published = $published;

        return $this;
    }

    public function getDeleted(): ?int
    {
        return $this->deleted;
    }

    public function setDeleted(int $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }

    public function getDateAdd(): ?\DateTimeInterface
    {
        return $this->date_add;
    }

    public function setDateAdd(\DateTimeInterface $date_add): self
    {
        $this->date_add = $date_add;

        return $this;
    }

    public function getDateUpdated(): ?\DateTimeInterface
    {
        return $this->date_updated;
    }

    public function setDateUpdated(\DateTimeInterface $date_updated): self
    {
        $this->date_updated = $date_updated;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setTrick($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getTrick() === $this) {
                $image->setTrick(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Video>
     */
    public function getVideos(): Collection
    {
        return $this->videos;
    }

    public function addVideo(Video $videos): self
    {
        if (!$this->videos->contains($videos)) {
            $this->videos->add($videos);
            $videos->setTrick($this);
        }

        return $this;
    }

    public function removeVideo(Video $videos): self
    {
        if ($this->videos->removeElement($videos)) {
            // set the owning side to null (unless already changed)
            if ($videos->getTrick() === $this) {
                $videos->setTrick(null);
            }
        }

        return $this;
    }

    public function getVideo(): ?Video
    {
        return $this->video;
    }

    public function setVideo(?Video $video): self
    {
        $this->video = $video;

        return $this;
    }
}
