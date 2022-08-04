<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ClientRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ApiResource(
    normalizationContext: ["groups" => ["client:read"]],
    denormalizationContext: ["groups" => ["client:write"]]
)]
class Client extends User
{
    public function __construct()
    {
        parent::__construct();
        $this->roles = ['ROLE_CLIENT'];
        $this->commandes = new ArrayCollection();
    }
    #[ORM\Column(type: 'string', length: 255)]
    #[Groups([
        "client:read", "client:write",
        "commande:read:post", "commande:get:collection"
    ])]
    private $telephone;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Commande::class)]
    private $commandes;

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

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
            $this->commandes[] = $commande;
            $commande->setClient($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getClient() === $this) {
                $commande->setClient(null);
            }
        }

        return $this;
    }
}
