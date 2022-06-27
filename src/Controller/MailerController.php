<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MailerController extends AbstractController
{
    public function __invoke(Request $request, UserRepository $userR, EntityManagerInterface $manager)
    {
        $token = $request->get("token");
        $user = $userR->findOneBy(["token" => $token]);
        if (!$user) {
            return new JsonResponse(["error" => "Token invalide"], 400);
        }
        if ($user->isIsEnabled()) {
            return new JsonResponse(["message" => "Le compte est déjà activé !"]);
        }
        if ($user->getExpiredAt() < new \DateTime()) {
            return new JsonResponse(["error" => "Token expiré"], 400);
        }
        $user->setIsEnabled(true);
        $manager->flush();
        return new JsonResponse(["message" => "Le compte a été activé avec succès ! "], 200);
    }
}
