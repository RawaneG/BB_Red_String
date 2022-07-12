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
        "client:read",
        "collection:post_burger:read", "collection:post_frites:read", "collection:post_boissons:read", "collection:post_taille:read",
        "item:put_burger:read", "item:put_frites:read", "item:put_taille:read", "item:put_boissons:read",
        "commande:write:post",
        "post:livraison:read", "post:livraison:write"
    ])]
    protected $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    #[Groups([
        "client:read", "client:write", "gestionnaire:read", "gestionnaire:write", "livreur:read", "livreur:write",
        "collection:post_burger:read", "collection:post_frites:read", "collection:post_boissons:read", "collection:post_taille:read",
        "item:put_burger:read", "item:put_frites:read", "item:put_taille:read", "item:put_boissons:read",
        "commande:read:post", "commande:get:item"
    ])]
    protected $login;

    #[ORM\Column(type: 'json')]
    #[Groups([
        "client:read", "gestionnaire:read", "livreur:read"
    ])]
    protected $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;

    #[SerializedName("password")]
    #[Groups([
        "client:write", "gestionnaire:write", "livreur:write"
    ])]
    private $plainPassword;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups([
        "client:read", "client:write", "gestionnaire:read", "gestionnaire:write", "livreur:read", "livreur:write",
        "collection:post_burger:read", "collection:post_frites:read", "collection:post_boissons:read", "collection:post_taille:read",
        "item:put_burger:read", "item:put_frites:read", "item:put_taille:read", "item:put_boissons:read",
        "commande:read:post", "commande:get:item", "post:livraison:read"
    ])]
    protected $nom;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups([
        "client:read", "client:write", "gestionnaire:read", "gestionnaire:write", "livreur:read", "livreur:write",
        "collection:post_burger:read", "collection:post_frites:read", "collection:post_boissons:read", "collection:post_taille:read",
        "item:put_burger:read", "item:put_frites:read", "item:put_taille:read", "item:put_boissons:read",
        "commande:read:post", "commande:get:item", "post:livraison:read"
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
