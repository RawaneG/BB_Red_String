<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TailleBoissonRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TailleBoissonRepository::class)]
#[ApiResource(
    collectionOperations: [
        "get" =>
        [
            "method" => "get",
            "normalization_context" => ["groups" => ["collection:get_taille"]]
        ],
        "post" =>
        [
            "method" => "post",
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'êtes pas autorisé à utiliser ce service",
            "normalization_context" => ["groups" => ["collection:post_taille:read"]],
            "denormalization_context" => ["groups" => ["collection:post_taille:write"]]
        ]
    ],
    itemOperations: [
        "put" =>
        [
            "method" => "put",
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'êtes pas autorisé à utiliser ce service",
            "normalization_context" => ["groups" => ["item:put_taille:read"]],
            "denormalization_context" => ["groups" => ["item:put_taille:write"]]
        ],
        "get" =>
        [
            "method" => "get",
            "normalization_context" => ["groups" => ["item:get_taille"]]
        ]
    ]
)]
class TailleBoisson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups([
        "collection:get_boissons", "collection:post_boissons:read",
        "collection:post_boissons:write",
        "item:put_boissons:read", "item:put_boissons:write", "item:get_boissons",
        "post:write:menu"
    ])]
    private $id;

    #[ORM\ManyToMany(targetEntity: Boissons::class, inversedBy: 'tailleBoissons', cascade: ["persist"])]
    private $boissons;

    #[ORM\ManyToMany(targetEntity: Menu::class, inversedBy: 'tailleBoissons')]
    private $menus;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups([
        "collection:get_taille", "collection:post_taille:read",
        "collection:post_taille:write",
        "item:put_taille:read", "item:put_taille:write", "item:get_taille",
    ])]
    private $valeurs;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'tailleBoissons')]
    #[Groups([
        "collection:post_taille:read",
        "item:put_taille:read", "item:get_taille"
    ])]
    private $gestionnaire;

    #[ORM\Column(type: 'integer')]
    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'tailleBoissons', cascade: ['persist', 'remove'])]
    #[Groups([
        "collection:post_taille:read", "collection:post_taille:write",
        "item:put_taille:read", "item:get_taille", "item:put_taille:write",
    ])]
    private $prix;

    #[ORM\OneToOne(mappedBy: 'tailleBoisson', targetEntity: MenuBoissons::class, cascade: ['persist', 'remove'])]
    private $menuBoissons;

    public function __construct()
    {
        $this->boissons = new ArrayCollection();
        $this->menus = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Boissons>
     */
    public function getBoissons(): Collection
    {
        return $this->boissons;
    }

    public function addBoisson(Boissons $boisson): self
    {
        if (!$this->boissons->contains($boisson)) {
            $this->boissons[] = $boisson;
        }

        return $this;
    }

    public function removeBoisson(Boissons $boisson): self
    {
        $this->boissons->removeElement($boisson);

        return $this;
    }

    /**
     * @return Collection<int, Menu>
     */
    public function getMenus(): Collection
    {
        return $this->menus;
    }

    public function addMenu(Menu $menu): self
    {
        if (!$this->menus->contains($menu)) {
            $this->menus[] = $menu;
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        $this->menus->removeElement($menu);

        return $this;
    }

    public function getValeurs(): ?string
    {
        return $this->valeurs;
    }

    public function setValeurs(string $valeurs): self
    {
        $this->valeurs = $valeurs;

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

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getMenuBoissons(): ?MenuBoissons
    {
        return $this->menuBoissons;
    }

    public function setMenuBoissons(?MenuBoissons $menuBoissons): self
    {
        // unset the owning side of the relation if necessary
        if ($menuBoissons === null && $this->menuBoissons !== null) {
            $this->menuBoissons->setTailleBoisson(null);
        }

        // set the owning side of the relation if necessary
        if ($menuBoissons !== null && $menuBoissons->getTailleBoisson() !== $this) {
            $menuBoissons->setTailleBoisson($this);
        }

        $this->menuBoissons = $menuBoissons;

        return $this;
    }
}
