<?php

namespace App\DataPersister;

use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;

class ProduitDataPersister implements DataPersisterInterface
{
    private $_entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->_entityManager = $entityManager;
    }

    public function supports($data): bool
    {
        return $data instanceof Produit;
    }

    public function persist($data)
    {
        if ($data->getVraiImage()) {
            $image = $data->getVraiImage();
            $image_converti = $data->setImage(file_get_contents($image));
        }
        $this->_entityManager->persist($data);
        $this->_entityManager->flush();
    }

    public function remove($data)
    {
        $this->_entityManager->remove($data);
        $this->_entityManager->flush();
    }
}
