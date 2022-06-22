<?php

namespace App\Entity;

use App\Entity\User;
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

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups([
        "client:read",
        "client:write"
    ])]
    private $telephone;

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }
}
