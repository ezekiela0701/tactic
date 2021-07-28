<?php

namespace App\Entity;

use App\Repository\DocumentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DocumentRepository::class)
 */
class Document
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $file;

    /**
     * @ORM\ManyToOne(targetEntity=Lesson::class, inversedBy="documents")
     */
    private $Lesson;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(string $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getLesson(): ?Lesson
    {
        return $this->Lesson;
    }

    public function setLesson(?Lesson $Lesson): self
    {
        $this->Lesson = $Lesson;

        return $this;
    }
}
