<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "type", type: "string")]
#[ORM\DiscriminatorMap([
    "menu" => "Menu",
    "burger" => "Burger",
    "frites" => "Frites",
    "boissons" => "Boissons"
])]
#[ApiResource(
    collectionOperations: ["get", "post"],
    itemOperations: ["put", "get"]
)]
abstract class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["item:put_burger:read"])]
    protected $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups([
        "collection:post_burger:write", "collection:post_burger:read",
        "collection:get_burger",
        "item:put_burger:write", "item:put_burger:read", "item:get_burger"
    ])]
    protected $nom;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups([
        "collection:post_burger:write", "collection:post_burger:read",
        "collection:get_burger",
        "item:put_burger:write", "item:put_burger:read", "item:get_burger"
    ])]
    protected $prix;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups([
        "collection:post_burger:write", "collection:post_burger:read",
        "collection:get_burger",
        "item:put_burger:write", "item:put_burger:read", "item:get_burger"
    ])]
    protected $image;

    #[ORM\Column(type: 'boolean')]
    #[Groups(["item:put_burger:write", "item:put_burger:read", "item:get_burger"])]
    protected $isAvailable;

    #[ORM\ManyToMany(targetEntity: Commande::class, inversedBy: 'produits')]
    private $commande;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'produits')]
    #[Groups([
        "collection:post_burger:read", "collection:get_burger",
        "item:put_burger:read", "item:get_burger"
    ])]
    private $gestionnaire;

    public function __construct()
    {
        $this->isAvailable = true;
        $this->commande = new ArrayCollection();
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

    /**
     * @return Collection<int, Commande>
     */
    public function getCommande(): Collection
    {
        return $this->commande;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commande->contains($commande)) {
            $this->commande[] = $commande;
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        $this->commande->removeElement($commande);

        return $this;
    }

    public function getGestionnaire(): ?Gestionnaire
    {
        return $this->gestionnaire;
    }

    public function setGestionnaire(?Gestionnaire $gestionnaire): self
    {
        $this->gestionnaire = $gestionnaire;

        return $this;
    }
}
