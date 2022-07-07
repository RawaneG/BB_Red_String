<?php

namespace App\EventSubscriber;

use App\Entity\Menu;
use App\Entity\Produit;
use App\Entity\Commande;
use Doctrine\ORM\Events;
use App\Entity\TailleBoisson;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserSubscriber implements EventSubscriberInterface
{
    private ?TokenInterface $token;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->token = $tokenStorage->getToken();
    }

    public static function getSubscribedEvents(): array
    {
        return
            [
                Events::prePersist
            ];
    }

    private function getAdmin()
    {

        if (null === $token = $this->token) {
            return null;
        }
        if (!is_object($user = $token->getUser())) {
            return null;
        }
        return $user;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        if ($args->getObject() instanceof Produit) {
            if ($args->getObject() instanceof Menu) {
                $prixBurger = $args->getObject()->getMenuBurgers()[0]->getBurger()->getPrix();
                $prixFrite = $args->getObject()->getMenuFrites()[0]->getFrite()->getPrix();
                $prixBoisson = $args->getObject()->getMenuBoissons()[0]->getTailleBoisson()->getPrix();
                $prixMenu = $prixBurger + $prixFrite + $prixBoisson;
                $args->getObject()->setPrix($prixMenu);
            }
            $args->getObject()->setGestionnaire($this->getAdmin());
        }
        if ($args->getObject() instanceof TailleBoisson) {
            $args->getObject()->setGestionnaire($this->getAdmin());
        }
        if ($args->getObject() instanceof Commande) {

            $parent = $args->getObject()->getLigneDeCommandes();
            $prix = 0;
            foreach ($parent as $ldc) {

                $quantite = $ldc->getQuantite();
                $prixProduit = $ldc->getProduit()->getPrix();
                $calcul = $quantite * $prixProduit;
                $prix += $calcul;
                dd($ldc);
            }
            dd($args->getObject()->setPrix());
            $args->getObject()->setClient($this->getAdmin());
        }
    }
}
