<?php

namespace App\Entity;

use App\Repository\ScheduleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ScheduleRepository::class)
 */
class Schedule
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=ClassSchool::class, inversedBy="schedule", cascade={"persist", "remove"})
     */
    private $classschool;

    /**
     * @ORM\Column(type="text")
     */
    private $programm;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getProgramm(): ?string
    {
        return $this->programm;
    }

    public function setProgramm(string $programm): self
    {
        $this->programm = $programm;

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
}
