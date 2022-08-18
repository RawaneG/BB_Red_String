<?php

namespace App\DataPersister;

use DateTime;
use DateTimeInterface;
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
        $prixZone = 0;
        if ($data->getZone() !== null) {
            $prixZone = $data->getZone()->getPrixZone();
        } else {
            $prixZone = 0;
            $data->setEtat("Payé");
        }
        foreach ($data->getLigneDeCommandes() as $value) {
            $prix = $value->getProduit()->getPrix();
            $quantite = $value->getQuantite();
            $value->setPrix($prix);
            $this->manager->persist($value);
            $data->setPrix($data->getPrix() + $prixZone);
            $this->manager->persist($data);
            $maDate = $data->setDate(new \DateTime('now'));
            $this->manager->persist($maDate);
        }
        $this->manager->flush();
    }

    public function remove($data, array $context = [])
    {
    }
}
