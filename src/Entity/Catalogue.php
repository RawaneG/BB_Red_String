<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    collectionOperations: [
        "get" =>
        [
            "method" => "get",
            "normalization_context" => ["groups" => ["collection:catalogue"]]
        ]
    ],
    itemOperations: []
)]

class Catalogue
{
    #[ApiProperty(identifier: true)]
    #[Groups(["collection:catalogue"])]
    public $id;
}
