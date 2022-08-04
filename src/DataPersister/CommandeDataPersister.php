<?php

namespace App\DataPersister;

use DateTime;
use App\Entity\Commande;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints\Date;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

class CommandeDataPersister implements ContextAwareDataPersisterInterface
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof Commande;
    }

    public function persist($data, array $context = [])
    {
        foreach ($data->getLigneDeCommandes() as $value) {
            $prix = $value->getProduit()->getPrix();
            $value->setPrix($prix);
            $this->manager->persist($value);
            $maDate = $data->setDate(new Date());
            $this->manager->persist($maDate);
        }
        $this->manager->flush();
    }

    public function remove($data, array $context = [])
    {
    }
}
