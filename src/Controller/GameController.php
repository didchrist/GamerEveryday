<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    #[Route('/game', name: 'app_game')]
    public function index(UserRepository $userRepository): Response
    {
        $user = $userRepository->findBy();
        return $this->render('game/index.html.twig', [
            'controller_name' => 'GameController',
        ]);
    }
}