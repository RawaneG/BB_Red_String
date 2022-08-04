<?php

namespace App\DataPersister;

use App\Entity\Produit;
use App\Entity\Commande;
use App\Entity\Livraison;
use App\Repository\ZoneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use DateTime;

class ProduitDataPersister implements DataPersisterInterface
{
    private $_entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->_entityManager = $entityManager;
    }

    public function supports($data): bool
    {
        return $data instanceof Produit || $data instanceof Livraison;
    }

    public function persist($data)
    {
        // -- Changement d'état de la commande
        if ($data instanceof Livraison) {
            if ($data->getZone() == null) {
                return new JsonResponse(["message" => "Veuillez rentrer une zone valide"], 400);
            }
            if ($data->getLivreur() == null) {
                return new JsonResponse(["message" => "Veuillez désigner un livreur"], 400);
            }
            foreach ($data->getCommandes() as $value) {
                if ($value->getEtat() == "Livré") {
                    return new JsonResponse(["message" => "Ces commandes ont déjà été livrées"], 400);
                    break;
                } else {
                    $etat = $value->getEtat();
                    $etat = "Livré";
                    $value->setEtat($etat);
                }
            }
        } else if ($data instanceof Produit) {
            if ($data->getVraiImage()) {
                $data->setImage(($data->getVraiImage()));
            } else {
                dd("Vous n'avez pas récupéré l'image");
            }
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
