<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
#[ApiResource(
    collectionOperations: [
        "get" =>
        [
            "method" => "get",
            "normalization_context" => ["groups" => ["commande:get:collection"]]
        ],
        "post" =>
        [
            "method" => "post",
            "normalization_context" => ["groups" => ["commande:read:post"]],
            "denormalization_context" => ["groups" => ["commande:write:post"]]
        ]

    ],
    itemOperations: [
        "get" =>
        [
            "method" => "get",
            "normalization_context" => ["groups" => ["commande:get:item"]]
        ],
        "put" =>
        [
            "method" => "put",
            "normalization_context" => ["groups" => ["commande:read:put"]],
            "denormalization_context" => ["groups" => ["commande:write:put"]]
        ]
    ]
)]
class Commande
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups([
        "livreur:read",
        // -- Normalisation et Denormalisation Zone
        "collection:get:zone", "post:read:zone",
        // -- Normalisation et Denormalisation Livraison
        "collection:livraison", "post:livraison:read", "post:livraison:write",
        // -- Normalisation et Denormalisation Commande
        "commande:read:post", "commande:get:collection"
    ])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups([
        // -- Normalisation et Denormalisation Zone
        "collection:get:zone", "post:read:zone",
        // -- Normalisation et Denormalisation Commande
        "commande:get:collection", "commande:read:put", "commande:write:put", "commande:get:item"
    ])]
    private $etat;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'commande')]
    private $gestionnaire;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'commandes')]
    #[Groups([
        // -- Normalisation et Denormalisation Zone
        "collection:get:zone", "post:read:zone",
        // -- Normalisation Livraison
        "collection:livraison",
        // -- Normalisation et Denormalisation Commande
        "commande:read:post", "commande:get:collection", "commande:write:post"
    ])]
    private $client;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: LigneDeCommande::class, cascade: ['persist'])]
    #[Groups([
        // -- Normalisation et Denormalisation Commande
        "commande:write:post", "commande:read:post", "commande:get:collection"
    ])]
    #[SerializedName('produits')]
    private $ligneDeCommandes;

    #[ORM\Column(type: 'integer')]
    #[Groups([
        "livreur:read",
        // -- Normalisation et Denormalisation Zone
        "collection:get:zone", "post:read:zone",
        // -- Normalisation et Denormalisation Commande
        "commande:read:post", "commande:get:collection"

    ])]
    private $prix;

    #[ORM\ManyToOne(targetEntity: Livraison::class, inversedBy: 'commandes', cascade: ['persist'])]
    #[Groups([
        "commande:get:collection",
        // -- Normalisation et Denormalisation Zone
        "collection:get:zone", "post:read:zone",
    ])]
    private $livraison;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups([
        // -- Normalisation et Denormalisation Zone
        "collection:get:zone",
        // -- Normalisation Commande
        "commande:get:collection"
    ])]
    private ?\DateTimeInterface $date;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    #[Groups([
        // -- Normalisation et Denormalisation Commande
        "commande:read:post", "commande:get:collection", "commande:write:post"
    ])]
    private ?Zone $zone = null;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
        $this->etat = "En Cours";
        $this->ligneDeCommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

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

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection<int, LigneDeCommande>
     */
    public function getLigneDeCommandes(): Collection
    {
        return $this->ligneDeCommandes;
    }

    public function addLigneDeCommande(LigneDeCommande $ligneDeCommande): self
    {
        if (!$this->ligneDeCommandes->contains($ligneDeCommande)) {
            $this->ligneDeCommandes[] = $ligneDeCommande;
            $ligneDeCommande->setCommande($this);
        }

        return $this;
    }

    public function removeLigneDeCommande(LigneDeCommande $ligneDeCommande): self
    {
        if ($this->ligneDeCommandes->removeElement($ligneDeCommande)) {
            // set the owning side to null (unless already changed)
            if ($ligneDeCommande->getCommande() === $this) {
                $ligneDeCommande->setCommande(null);
            }
        }

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

    public function getLivraison(): ?Livraison
    {
        return $this->livraison;
    }

    public function setLivraison(?Livraison $livraison): self
    {
        $this->livraison = $livraison;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getZone(): ?Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): self
    {
        $this->zone = $zone;

        return $this;
    }
}
