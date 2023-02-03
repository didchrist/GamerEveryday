<?php

namespace App\Controller;

use App\Repository\GameRepository;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_USER')]
class GameController extends AbstractController
{
    #[Route('/game', name: 'app_game')]
    public function index(UserRepository $userRepository, GameRepository $gameRepository): Response
    {
        $games = $gameRepository->findAll();
        $user = $this->getUser();
        dd($user->getGameUsers());
        return $this->render('game/index.html.twig', [
            'games' => $games,
            'user' => $user
        ]);
    }
}
