<?php

namespace App\Entity;

use App\Repository\FritesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FritesRepository::class)]
class Frites extends Complement
{
    #[ORM\Column(type: 'string', length: 255)]
    private $portions;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPortions(): ?string
    {
        return $this->portions;
    }

    public function setPortions(string $portions): self
    {
        $this->portions = $portions;

        return $this;
    }
}
