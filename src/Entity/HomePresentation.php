<?php

namespace App\Entity;

use App\Repository\HomePresentationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HomePresentationRepository::class)
 */
class HomePresentation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $svg;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getSvg(): ?string
    {
        return $this->svg;
    }

    public function setSvg(?string $svg): self
    {
        $this->svg = $svg;

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
}
