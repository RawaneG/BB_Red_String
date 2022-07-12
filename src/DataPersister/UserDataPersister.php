<?php

namespace App\DataPersister;

use App\Entity\User;
use App\Services\Mailer;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserDataPersister implements DataPersisterInterface
{
    private $_entityManager;
    private $_passwordEncoder;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordEncoder, Mailer $mailer)
    {
        $this->_entityManager = $entityManager;
        $this->_passwordEncoder = $passwordEncoder;
        $this->mailer = $mailer;
    }

    public function supports($data): bool
    {
        return $data instanceof User;
    }

    public function persist($data)
    {

        if ($data->getPlainPassword()) {
            $data->setPassword($this->_passwordEncoder->hashPassword($data, $data->getPlainPassword()));
            $data->eraseCredentials();
        }
        $this->_entityManager->persist($data);
        $this->_entityManager->flush();
        $this->mailer->mailSender($data);
    }

    public function remove($data)
    {
        $this->_entityManager->remove($data);
        $this->_entityManager->flush();
    }
}
