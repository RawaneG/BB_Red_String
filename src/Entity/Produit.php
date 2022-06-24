<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "type", type: "string")]
#[ORM\DiscriminatorMap([
    "menu" => "Menu",
    "burger" => "Burger",
    "complement" => "Complement"
])]
abstract class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups([
        "burger:read",
        "menu:read",
        "complement:read"
    ])]
    protected $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups([
        "burger:read", "burger:write",
        "menu:read", "menu:write",
        "complement:read", "complement:write"
    ])]
    protected $nom;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups([
        "burger:read", "burger:write",
        "menu:read", "menu:write",
        "complement:read", "complement:write"
    ])]
    protected $prix;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups([
        "burger:read", "burger:write",
        "menu:read", "menu:write",
        "complement:read", "complement:write"
    ])]
    protected $image;

    #[ORM\Column(type: 'boolean')]
    #[Groups([
        "burger:read", "burger:write",
        "menu:read", "menu:write",
        "complement:read", "complement:write"
    ])]
    protected $isAvailable;

    public function __construct()
    {
        $this->isAvailable = true;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): self
    {
        $this->image = $image;

        return $this;
    }

    public function isIsAvailable(): ?bool
    {
        return $this->isAvailable;
    }

    public function setIsAvailable(bool $isAvailable): self
    {
        $this->isAvailable = $isAvailable;

        return $this;
    }
}
