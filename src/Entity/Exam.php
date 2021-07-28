<?php

namespace App\Entity;

use App\Repository\ExamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExamRepository::class)
 */
class Exam
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $trimester;


    /**
     * @ORM\ManyToOne(targetEntity=Subject::class, inversedBy="exams")
     */
    private $subject;

    /**
     * @ORM\OneToMany(targetEntity=Note::class, mappedBy="exam")
     */
    private $notes;

    /**
     * @ORM\OneToMany(targetEntity=DocumentExam::class, mappedBy="exam")
     */
    private $documentExams;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255 ,  nullable=true)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity=ClassSchool::class, inversedBy="exams")
     */
    private $classSchool;

    public function __construct()
    {
        $this->notes = new ArrayCollection();
        $this->documentExams = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSubject(): ?Subject
    {
        return $this->subject;
    }

    public function setSubject(?Subject $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return Collection|Note[]
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes[] = $note;
            $note->setExam($this);
        }

        return $this;
    }

    public function removeNote(Note $note): self
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getExam() === $this) {
                $note->setExam(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|DocumentExam[]
     */
    public function getDocumentExams(): Collection
    {
        return $this->documentExams;
    }

    public function addDocumentExam(DocumentExam $documentExam): self
    {
        if (!$this->documentExams->contains($documentExam)) {
            $this->documentExams[] = $documentExam;
            $documentExam->setExam($this);
        }

        return $this;
    }

    public function removeDocumentExam(DocumentExam $documentExam): self
    {
        if ($this->documentExams->removeElement($documentExam)) {
            // set the owning side to null (unless already changed)
            if ($documentExam->getExam() === $this) {
                $documentExam->setExam(null);
            }
        }

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(?bool $status): self
    {
        $this->status = $status;

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

    public function getClassSchool(): ?ClassSchool
    {
        return $this->classSchool;
    }

    public function setClassSchool(?ClassSchool $classSchool): self
    {
        $this->classSchool = $classSchool;

        return $this;
    }
}
