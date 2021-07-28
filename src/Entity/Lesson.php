<?php

namespace App\Entity;

use App\Repository\LessonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LessonRepository::class)
 */
class Lesson
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255 , nullable=true)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $chapter;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $trimester;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity=Subject::class, inversedBy="lessons")
     */
    private $subject;

    /**
     * @ORM\ManyToOne(targetEntity=ClassSchool::class, inversedBy="lessons")
     */
    private $classschool;

    /**
     * @ORM\OneToMany(targetEntity=Document::class, mappedBy="Lesson")
     */
    private $documents;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity=VideosLesson::class, mappedBy="lesson")
     */
    private $videosLessons;

    public function __construct()
    {
        $this->documents = new ArrayCollection();
        $this->videosLessons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getChapter(): ?string
    {
        return $this->chapter;
    }

    public function setChapter(string $chapter): self
    {
        $this->chapter = $chapter;

        return $this;
    }

    public function getTrimester(): ?string
    {
        return $this->trimester;
    }

    public function setTrimester(string $trimester): self
    {
        $this->trimester = $trimester;

        return $this;
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

    public function getSubject(): ?Subject
    {
        return $this->subject;
    }

    public function setSubject(?Subject $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getClassschool(): ?ClassSchool
    {
        return $this->classschool;
    }

    public function setClassschool(?ClassSchool $classschool): self
    {
        $this->classschool = $classschool;

        return $this;
    }

    /**
     * @return Collection|Document[]
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocument(Document $document): self
    {
        if (!$this->documents->contains($document)) {
            $this->documents[] = $document;
            $document->setLesson($this);
        }

        return $this;
    }

    public function removeDocument(Document $document): self
    {
        if ($this->documents->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getLesson() === $this) {
                $document->setLesson(null);
            }
        }

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection|VideosLesson[]
     */
    public function getVideosLessons(): Collection
    {
        return $this->videosLessons;
    }

    public function addVideosLesson(VideosLesson $videosLesson): self
    {
        if (!$this->videosLessons->contains($videosLesson)) {
            $this->videosLessons[] = $videosLesson;
            $videosLesson->setLesson($this);
        }

        return $this;
    }

    public function removeVideosLesson(VideosLesson $videosLesson): self
    {
        if ($this->videosLessons->removeElement($videosLesson)) {
            // set the owning side to null (unless already changed)
            if ($videosLesson->getLesson() === $this) {
                $videosLesson->setLesson(null);
            }
        }

        return $this;
    }
}
