<?php

namespace App\Entity;

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
    }
    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["livreur:write"])]
    private $matriculeMoto;

    public function getMatriculeMoto(): ?string
    {
        return $this->matriculeMoto;
    }

    public function setMatriculeMoto(string $matriculeMoto): self
    {
        $this->matriculeMoto = $matriculeMoto;

        return $this;
    }
}
