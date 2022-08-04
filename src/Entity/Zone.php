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
        "get" =>
        [
            "method" => "get",
            "normalization_context" => ["groups" => ["collection:zone"]]
        ],
        "post" =>
        [
            "method" => "post",
            "normalization_context" => ["groups" => ["read:zone"]],
            "denormalization_context" => ["groups" => ["write:zone"]]
        ]
    ],
    itemOperations: [
        'get' =>
        [
            "method" => "get",
            "normalization_context" => ["groups" => ["item:zone"]]
        ]
    ]
)]
class Zone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["post:livraison:write", "commande:get:collection", "commande:read:post", "commande:write:post"])]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(["read:zone", "write:zone", "collection:zone", "commande:get:collection", "commande:read:post", "commande:read:write"])]
    private $nom;

    #[ORM\Column(type: 'float', nullable: true)]
    #[Groups(["read:zone", "write:zone", "collection:zone", "commande:get:collection", "commande:read:post", "commande:read:write"])]
    private $prix_zone;

    #[ORM\OneToMany(mappedBy: 'zone', targetEntity: Livraison::class)]
    private $livraisons;

    #[ORM\OneToMany(mappedBy: 'zone', targetEntity: Commande::class)]
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
