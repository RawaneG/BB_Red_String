<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ZoneRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ZoneRepository::class)]
#[ApiResource(
    collectionOperations: [
        "get" => [
            "normalization_context" => ["groups" => ["collection:get:zone"]]
        ],
        "post" => [
            "normalization_context" => ["groups" => ["post:read:zone"]],
            "denormalization_context" => ["groups" => ["post:write:zone"]]
        ]
    ],
    itemOperations: [
        "get" => [
            "normalization_context" => ["groups" => ["item:get:zone"]]
        ],
    ]
)]
class Zone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups([
        "item:livraison",
        // -- Normalisation et Denormalisation Zone
        "collection:get:zone", "post:read:zone",
        // -- Normalisation et Denormalisation Livraison
        "collection:livraison", "post:livraison:write",
        // -- Normalisation et Denormalisation Commande
        "commande:get:collection", "commande:read:post", "commande:write:post", "commande:get:item"
    ])]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups([
        "item:livraison",
        // -- Normalisation et Denormalisation Zone
        "collection:get:zone", "post:read:zone", "post:write:zone",
        // -- Normalisation et Denormalisation Commande
        "commande:get:collection", "commande:read:post", "commande:read:write", "commande:get:item"
    ])]
    private $nom;

    #[ORM\Column(type: 'float', nullable: true)]
    #[Groups([
        // -- Normalisation et Denormalisation Zone
        "collection:get:zone", "post:read:zone", "post:write:zone",
        // -- Normalisation et Denormalisation Commande
        "commande:get:collection", "commande:read:post", "commande:read:write", "commande:get:item"
    ])]
    private $prix_zone;

    #[ORM\OneToMany(mappedBy: 'zone', targetEntity: Livraison::class)]
    private $livraisons;

    #[ORM\OneToMany(mappedBy: 'zone', targetEntity: Commande::class)]
    #[Groups(
        // -- Normalisation et Denormalisation Zone
        "collection:get:zone"
    )]
    private Collection $commandes;

    public function __construct()
    {
        $this->livraisons = new ArrayCollection();
        $this->prix_zone = 2500;
        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrixZone(): ?int
    {
        return $this->prix_zone;
    }

    public function setPrixZone(int $prix_zone): self
    {
        $this->prix_zone = $prix_zone;

        return $this;
    }

    /**
     * @return Collection<int, Livraison>
     */
    public function getLivraisons(): Collection
    {
        return $this->livraisons;
    }

    public function addLivraison(Livraison $livraison): self
    {
        if (!$this->livraisons->contains($livraison)) {
            $this->livraisons[] = $livraison;
            $livraison->setZone($this);
        }

        return $this;
    }

    public function removeLivraison(Livraison $livraison): self
    {
        if ($this->livraisons->removeElement($livraison)) {
            // set the owning side to null (unless already changed)
            if ($livraison->getZone() === $this) {
                $livraison->setZone(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes->add($commande);
            $commande->setZone($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getZone() === $this) {
                $commande->setZone(null);
            }
        }

        return $this;
    }
}
