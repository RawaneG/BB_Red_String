<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BoissonsRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BoissonsRepository::class)]
#[ApiResource(
    collectionOperations: [
        "get" =>
        [
            "method" => "get",
            "normalization_context" => ["groups" => ["collection:get_boissons"]]
        ],
        "post" =>
        [
            "method" => "post",
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'êtes pas autorisé à utiliser ce service",
            "normalization_context" => ["groups" => ["collection:post_boissons:read"]],
            "denormalization_context" => ["groups" => ["collection:post_boissons:write"]]
        ]
    ],
    itemOperations: [
        "put" =>
        [
            "method" => "put",
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'êtes pas autorisé à utiliser ce service",
            "normalization_context" => ["groups" => ["item:put_boissons:read"]],
            "denormalization_context" => ["groups" => ["item:put_boissons:write"]]
        ],
        "get" =>
        [
            "method" => "get",
            "normalization_context" => ["groups" => ["item:get_boissons"]]
        ]
    ]
)]
class Boissons extends Produit
{

    #[ORM\ManyToMany(targetEntity: TailleBoisson::class, mappedBy: 'boissons')]
    #[Groups([
        "collection:get_boissons", "collection:post_boissons:read",
        "collection:post_boissons:write",
        "item:put_boissons:read", "item:put_boissons:write", "item:get_boissons"
    ])]
    private $tailleBoissons;

    public function __construct()
    {
        parent::__construct();
        $this->tailleBoissons = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, TailleBoisson>
     */
    public function getTailleBoissons(): Collection
    {
        return $this->tailleBoissons;
    }

    public function addTailleBoisson(TailleBoisson $tailleBoisson): self
    {
        if (!$this->tailleBoissons->contains($tailleBoisson)) {
            $this->tailleBoissons[] = $tailleBoisson;
            $tailleBoisson->addBoisson($this);
        }

        return $this;
    }

    public function removeTailleBoisson(TailleBoisson $tailleBoisson): self
    {
        if ($this->tailleBoissons->removeElement($tailleBoisson)) {
            $tailleBoisson->removeBoisson($this);
        }

        return $this;
    }
}
