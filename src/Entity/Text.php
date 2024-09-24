<?php

namespace App\Entity;

use App\Repository\TextRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TextRepository::class)]
class Text extends Element
{
    #[ORM\Column(length: 255)]
    private ?string $textColor = null;

    #[ORM\Column(length: 255)]
    private ?string $backgroundColor = null;

    #[ORM\Column(length: 255)]
    private ?string $placeholder = null;

    #[ORM\Column(length: 255)]
    private ?string $align = null;

    #[ORM\Column]
    private ?bool $bold = null;

    #[ORM\Column]
    private ?bool $italic = null;

    #[ORM\Column]
    private ?float $fontSize = null;

    #[ORM\Column(length: 255)]
    private ?string $fontFamily = null;

    public function getTextColor(): ?string
    {
        return $this->textColor;
    }

    public function setTextColor(string $textColor): static
    {
        $this->textColor = $textColor;

        return $this;
    }

    public function getBackgroundColor(): ?string
    {
        return $this->backgroundColor;
    }

    public function setBackgroundColor(string $backgroundColor): static
    {
        $this->backgroundColor = $backgroundColor;

        return $this;
    }

    public function getPlaceholder(): ?string
    {
        return $this->placeholder;
    }

    public function setPlaceholder(string $placeholder): static
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    public function getAlign(): ?string
    {
        return $this->align;
    }

    public function setAlign(string $align): static
    {
        $this->align = $align;

        return $this;
    }

    public function isBold(): ?bool
    {
        return $this->bold;
    }

    public function setBold(bool $bold): static
    {
        $this->bold = $bold;

        return $this;
    }

    public function isItalic(): ?bool
    {
        return $this->italic;
    }

    public function setItalic(bool $italic): static
    {
        $this->italic = $italic;

        return $this;
    }

    public function getFontSize(): ?float
    {
        return $this->fontSize;
    }

    public function setFontSize(float $fontSize): static
    {
        $this->fontSize = $fontSize;

        return $this;
    }

    public function getFontFamily(): ?string
    {
        return $this->fontFamily;
    }

    public function setFontFamily(string $fontFamily): static
    {
        $this->fontFamily = $fontFamily;

        return $this;
    }
}
