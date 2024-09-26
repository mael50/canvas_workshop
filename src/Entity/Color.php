<?php

namespace App\Entity;

use App\Repository\ColorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ColorRepository::class)]
class Color
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $codeHexa = null;

    /**
     * @var Collection<int, Template>
     */
    #[ORM\ManyToMany(targetEntity: Template::class, mappedBy: 'color')]
    private Collection $templates;

    public function __construct()
    {
        $this->templates = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeHexa(): ?string
    {
        return $this->codeHexa;
    }

    public function setCodeHexa(string $codeHexa): static
    {
        $this->codeHexa = $codeHexa;

        return $this;
    }

    /**
     * @return Collection<int, Template>
     */
    public function getTemplates(): Collection
    {
        return $this->templates;
    }

    public function addTemplate(Template $template): static
    {
        if (!$this->templates->contains($template)) {
            $this->templates->add($template);
            $template->addColor($this);
        }

        return $this;
    }

    public function removeTemplate(Template $template): static
    {
        if ($this->templates->removeElement($template)) {
            $template->removeColor($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->codeHexa;
    }
}