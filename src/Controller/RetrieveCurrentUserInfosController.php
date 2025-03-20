<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

final class RetrieveCurrentUserInfosController extends AbstractController
{
    public function __invoke(array $context = []): Response
    {
        /** @var App\Entity\User $user current connected user */
        $user = $this->getUser();

        if (!$user) {
            throw new AccessDeniedException('You must be logged in to access this resource.');
        }

        return $this->json([
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
        ]);
    }
}
