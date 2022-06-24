<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\GestionnaireRepository;
use ApiPlatform\Core\Annotation\ApiResource;

#[ORM\Entity(repositoryClass: GestionnaireRepository::class)]
#[ApiResource(
    normalizationContext: ["groups" => ["gestionnaire:read"]],
    denormalizationContext: ["groups" => ["gestionnaire:write"]]
)]
class Gestionnaire extends User
{
    public function __construct()
    {
        parent::__construct();
        $this->roles = ['ROLE_GESTIONNAIRE'];
    }
}
