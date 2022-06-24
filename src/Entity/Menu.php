<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuRepository;
use ApiPlatform\Core\Annotation\ApiResource;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
#[ApiResource(
    normalizationContext: ["groups" => ["menu:read"]],
    denormalizationContext: ["groups" => ["menu:write"]]
)]
class Menu extends Produit
{
}
