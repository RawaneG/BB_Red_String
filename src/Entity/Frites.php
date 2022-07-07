<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\FritesRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: FritesRepository::class)]
#[ApiResource(
    collectionOperations: [
        "get" =>
        [
            "method" => "get",
            "normalization_context" => ["groups" => ["collection:get_frites"]]
        ],
        "post" =>
        [
            "method" => "post",
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'êtes pas autorisé à utiliser ce service",
            "normalization_context" => ["groups" => ["collection:post_frites:read"]],
            "denormalization_context" => ["groups" => ["collection:post_frites:write"]]
        ]
    ],
    itemOperations: [
        "put" =>
        [
            "method" => "put",
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'êtes pas autorisé à utiliser ce service",
            "normalization_context" => ["groups" => ["item:put_frites:read"]],
            "denormalization_context" => ["groups" => ["item:put_frites:write"]]
        ],
        "get" =>
        [
            "method" => "get",
            "normalization_context" => ["groups" => ["item:get_frites"]]
        ]
    ]
)]
class Frites extends Produit
{

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups([
        "collection:post_frites:read", "collection:post_frites:write",
        "item:get_frites", "item:put_frites:read", "item:put_frites:write"
    ])]
    private $portions;

    #[ORM\OneToOne(mappedBy: 'frite', targetEntity: MenuFrites::class, cascade: ['persist', 'remove'])]
    private $menuFrites;

    public function __construct()
    {
        parent::__construct();
        $this->nom = "Frites";
    }

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

    public function getMenuFrites(): ?MenuFrites
    {
        return $this->menuFrites;
    }

    public function setMenuFrites(?MenuFrites $menuFrites): self
    {
        // unset the owning side of the relation if necessary
        if ($menuFrites === null && $this->menuFrites !== null) {
            $this->menuFrites->setFrite(null);
        }

        // set the owning side of the relation if necessary
        if ($menuFrites !== null && $menuFrites->getFrite() !== $this) {
            $menuFrites->setFrite($this);
        }

        $this->menuFrites = $menuFrites;

        return $this;
    }
}
