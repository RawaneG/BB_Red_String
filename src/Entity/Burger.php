<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BurgerRepository;
use ApiPlatform\Core\Annotation\ApiResource;

#[ORM\Entity(repositoryClass: BurgerRepository::class)]
#[ApiResource(
    normalizationContext: ["groups" => ["burger:read"]],
    denormalizationContext: ["groups" => ["burger:write"]]
)]
class Burger extends Produit
{
}
