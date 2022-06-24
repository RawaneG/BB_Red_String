<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ComplementRepository;
use ApiPlatform\Core\Annotation\ApiResource;

#[ORM\Entity(repositoryClass: ComplementRepository::class)]
#[ApiResource(
    normalizationContext: ["groups" => ["complement:read"]],
    denormalizationContext: ["groups" => ["complement:write"]]
)]
class Complement extends Produit
{
}
