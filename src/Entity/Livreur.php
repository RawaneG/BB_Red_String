<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\LivreurRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LivreurRepository::class)]
#[ApiResource(
    normalizationContext: ["groups" => ["livreur:read"]],
    denormalizationContext: ["groups" => ["livreur:write"]]
)]
class Livreur extends User
{
    public function __construct()
    {
        parent::__construct();
        $this->roles = ['ROLE_LIVREUR'];
        $this->gestionnaires = new ArrayCollection();
    }
    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["livreur:write"])]
    private $matriculeMoto;

    #[ORM\OneToMany(mappedBy: 'livreur', targetEntity: Gestionnaire::class)]
    private $gestionnaires;

    public function getMatriculeMoto(): ?string
    {
        return $this->matriculeMoto;
    }

    public function setMatriculeMoto(string $matriculeMoto): self
    {
        $this->matriculeMoto = $matriculeMoto;

        return $this;
    }

    /**
     * @return Collection<int, Gestionnaire>
     */
    public function getGestionnaires(): Collection
    {
        return $this->gestionnaires;
    }

    public function addGestionnaire(Gestionnaire $gestionnaire): self
    {
        if (!$this->gestionnaires->contains($gestionnaire)) {
            $this->gestionnaires[] = $gestionnaire;
            $gestionnaire->setLivreur($this);
        }

        return $this;
    }

    public function removeGestionnaire(Gestionnaire $gestionnaire): self
    {
        if ($this->gestionnaires->removeElement($gestionnaire)) {
            // set the owning side to null (unless already changed)
            if ($gestionnaire->getLivreur() === $this) {
                $gestionnaire->setLivreur(null);
            }
        }

        return $this;
    }
}
