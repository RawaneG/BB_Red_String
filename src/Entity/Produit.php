<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation\Vich;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "type", type: "string")]
#[ORM\DiscriminatorMap([
    "menu" => "Menu",
    "burger" => "Burger",
    "frites" => "Frites",
    "boissons" => "Boissons"
])]
#[ApiResource()]
abstract class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups([
        "item:put_burger:read",
        "commande:write:post", "commande:read:post",
        "post:write:menu"
    ])]
    protected $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups([
        "collection:post_burger:write", "collection:post_burger:read", "collection:get_burger",
        "item:put_burger:write", "item:put_burger:read", "item:get_burger",
        "collection:post_frites:read", "collection:post_frites:write", "collection:get_frites",
        "item:put_frites:write", "item:put_frites:read", "item:get_frites",
        "collection:post_boissons:read", "collection:post_boissons:write", "collection:get_boissons",
        "item:put_boissons:write", "item:put_boissons:read", "item:get_boissons",
        "commande:get:collection",
        "post:write:menu", "post:read:menu"
    ])]
    protected $nom;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups([
        "collection:post_burger:write", "collection:post_burger:read", "collection:get_burger",
        "item:put_burger:write", "item:put_burger:read", "item:get_burger",
        "collection:post_frites:read", "collection:post_frites:write", "collection:get_frites",
        "item:put_frites:write", "item:put_frites:read", "item:get_frites",
        "collection:post_boissons:read", "collection:post_boissons:write", "collection:get_boissons",
        "item:put_boissons:write", "item:put_boissons:read", "item:get_boissons",
        "commande:get:collection",
        "post:read:menu"
    ])]
    protected $prix;

    #[ORM\Column(type: 'blob')]
    protected $image;

    #[SerializedName('image')]
    #[Groups([
        "collection:post_burger:write", "collection:post_burger:read", "collection:get_burger",
        "item:put_burger:write", "item:put_burger:read", "item:get_burger",
        "collection:post_frites:read", "collection:post_frites:write", "collection:get_frites",
        "item:put_frites:write", "item:put_frites:read", "item:get_frites",
        "collection:post_boissons:read", "collection:post_boissons:write", "collection:get_boissons",
        "item:put_boissons:write", "item:put_boissons:read", "item:get_boissons",
        "commande:get:collection",
        "post:write:menu", "post:read:menu"
    ])]
    protected $vraiImage;

    #[ORM\Column(type: 'boolean')]
    #[Groups([
        "item:put_burger:write", "item:put_burger:read", "item:get_burger",
        "item:put_frites:write", "item:put_frites:read", "item:get_frites",
        "item:put_boissons:write", "item:put_boissons:read", "item:get_boissons",
    ])]
    protected $isAvailable;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'produits')]
    #[Groups([
        "collection:post_burger:read",
        "item:put_burger:read", "item:get_burger",
        "collection:post_frites:read",
        "item:put_frites:read", "item:get_frites",
        "collection:post_boissons:read",
        "item:put_boissons:read", "item:get_boissons",
        "post:read:menu"
    ])]
    private $gestionnaire;

    #[ORM\OneToOne(mappedBy: 'produit', targetEntity: LigneDeCommande::class, cascade: ['persist', 'remove'])]
    private $ligneDeCommande;

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

    public function getGestionnaire(): ?Gestionnaire
    {
        return $this->gestionnaire;
    }

    public function setGestionnaire(?Gestionnaire $gestionnaire): self
    {
        $this->gestionnaire = $gestionnaire;

        return $this;
    }

    public function getLigneDeCommande(): ?LigneDeCommande
    {
        return $this->ligneDeCommande;
    }

    public function setLigneDeCommande(?LigneDeCommande $ligneDeCommande): self
    {
        // unset the owning side of the relation if necessary
        if ($ligneDeCommande === null && $this->ligneDeCommande !== null) {
            $this->ligneDeCommande->setProduit(null);
        }

        // set the owning side of the relation if necessary
        if ($ligneDeCommande !== null && $ligneDeCommande->getProduit() !== $this) {
            $ligneDeCommande->setProduit($this);
        }

        $this->ligneDeCommande = $ligneDeCommande;

        return $this;
    }

    /**
     * Get the value of vraiImage
     */
    public function getVraiImage()
    {
        return $this->vraiImage;
    }

    /**
     * Set the value of vraiImage
     *
     * @return  self
     */
    public function setVraiImage($vraiImage)
    {
        $this->vraiImage = $vraiImage;

        return $this;
    }
}
