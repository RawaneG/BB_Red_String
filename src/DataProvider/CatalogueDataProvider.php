<?php

namespace App\DataProvider;

use App\Entity\Catalogue;
use App\Repository\MenuRepository;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Repository\BurgerRepository;

final class CatalogueDataProvider implements
    ContextAwareCollectionDataProviderInterface,
    RestrictedDataProviderInterface
{
    public function __construct(MenuRepository $menu, BurgerRepository $burger)
    {
        $this->menu = $menu;
        $this->burger = $burger;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Catalogue::class === $resourceClass;
    }

    public function getCollection(string $resourceClass, string $operationName = null,  array $context = []): iterable
    {
        $liste_menu = $this->menu->findAll();
        $liste_burger = $this->burger->findAll();
        return [$liste_menu, $liste_burger];
    }
}
