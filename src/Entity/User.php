<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use App\Controller\MailerController;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Serializer\Annotation\Groups as Groups;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "type", type: "string")]
#[ORM\DiscriminatorMap([
    "livreur" => "Livreur",
    "client" => "Client",
    "gestionnaire" => "Gestionnaire"
])]
#[ApiResource(
    collectionOperations: [
        "patch" =>
        [
            "method" => "patch",
            "deserialize" => false,
            "path" => "/rawane/{token}",
            "controller" => MailerController::class
        ]
    ]
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups([
        // -- Normalisation et Denormalisation Zone
        "collection:get:zone", "post:read:zone",
        // -- Normalisation Livraison
        "collection:livraison",
        // -- Normalisation User
        "client:read", "livreur:read", "livreur:write",
        // -- Normalisation Burger
        "collection:post_burger:read", "item:put_burger:read",
        // -- Normalisation Frites
        "collection:post_frites:read", "item:put_frites:read",
        // -- Normalisation Boissons
        "collection:post_boissons:read", "item:put_boissons:read",
        // -- Normalisation Taille de Boissons
        "collection:post_taille:read", "item:put_taille:read",
        // -- Normalisation et Denormalisation Commande
        "commande:write:post", "commande:read:post", "commande:get:collection",
        // -- Normalisation et Denormalisation Livraison
        "post:livraison:read", "post:livraison:write"
    ])]
    protected $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    #[Groups([
        // -- Normalisation et Denormalisation User
        "client:read", "client:write", "gestionnaire:read", "gestionnaire:write", "livreur:read", "livreur:write",
        // -- Normalisation Burger
        "collection:post_burger:read", "item:put_burger:read",
        // -- Normalisation Frites
        "collection:post_frites:read", "item:put_frites:read",
        // -- Normalisation Boissons
        "collection:post_boissons:read", "item:put_boissons:read",
        // -- Normalisation Taille Boissons
        "collection:post_taille:read", "item:put_taille:read",
        // -- Normalisation Commande
        "commande:read:post", "commande:get:item"
    ])]
    protected $login;

    #[ORM\Column(type: 'json')]
    #[Groups([
        // -- Normalisation User
        "client:read", "gestionnaire:read", "livreur:read"
    ])]
    protected $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;

    #[SerializedName("password")]
    #[Groups([
        // -- Denormalisation User
        "client:write", "gestionnaire:write", "livreur:write"
    ])]
    private $plainPassword;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups([
        // -- Normalisation et Denormalisation Zone
        "collection:get:zone", "post:read:zone",
        // -- Normalisation et Denormalisation User
        "client:read", "client:write", "gestionnaire:read", "gestionnaire:write", "livreur:read", "livreur:write",
        // -- Normalisation Burger
        "collection:post_burger:read", "item:put_burger:read",
        // -- Normalisation Frites
        "collection:post_frites:read", "item:put_frites:read",
        // -- Normalisation Boissons
        "collection:post_boissons:read", "item:put_boissons:read",
        // -- Normalisation Tailles Boissons
        "collection:post_taille:read", "item:put_taille:read",
        // -- Normalisation Commande
        "commande:read:post", "commande:get:item", "commande:get:collection",
        // -- Normalisation Livraison
        "post:livraison:read"
    ])]
    protected $nom;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups([
        // -- Normalisation et Denormalisation Zone
        "collection:get:zone", "post:read:zone",
        // -- Normalisation et Denormalisation User
        "client:read", "client:write", "gestionnaire:read", "gestionnaire:write", "livreur:read", "livreur:write",
        // -- Normalisation Burger
        "collection:post_burger:read", "item:put_burger:read",
        // -- Normalisation Frites
        "collection:post_frites:read", "item:put_frites:read",
        // -- Normalisation Boissons
        "collection:post_boissons:read", "item:put_boissons:read",
        // -- Normalisation Tailles Boissons
        "collection:post_taille:read", "item:put_taille:read",
        // -- Normalisation Commande
        "commande:read:post", "commande:get:item", "commande:get:collection",
        // -- Normalisation Livraison
        "post:livraison:read"
    ])]
    protected $prenom;

    #[ORM\Column(type: 'string', length: 255)]
    protected $token;

    #[ORM\Column(type: 'boolean')]
    protected $isEnabled;

    #[ORM\Column(type: 'datetime')]
    protected $expiredAt;

    public function generateToken()
    {
        $this->expiredAt = new \DateTime("+1 day");
        $this->token = rtrim(strtr(base64_encode(random_bytes(128)), '+/', '-_'), '=');
    }

    public function __construct()
    {
        $this->isEnabled = false;
        $this->generateToken();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->login;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_VISITEUR';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        $this->plainPassword = null;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get the value of plainPassword
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * Set the value of plainPassword
     *
     * @return  self
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function isIsEnabled(): ?bool
    {
        return $this->isEnabled;
    }

    public function setIsEnabled(bool $isEnabled): self
    {
        $this->isEnabled = $isEnabled;

        return $this;
    }

    public function getExpiredAt(): ?\DateTimeInterface
    {
        return $this->expiredAt;
    }

    public function setExpiredAt(\DateTimeInterface $expiredAt): self
    {
        $this->expiredAt = $expiredAt;

        return $this;
    }
}
