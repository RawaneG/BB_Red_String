<?php

namespace App\Entity;

use App\Repository\BoissonsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BoissonsRepository::class)]
class Boissons extends Complement
{
    #[ORM\Column(type: 'string', length: 255)]
    private $typeBoisson;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeBoisson(): ?string
    {
        return $this->typeBoisson;
    }

    public function setTypeBoisson(string $typeBoisson): self
    {
        $this->typeBoisson = $typeBoisson;

        return $this;
    }
}
