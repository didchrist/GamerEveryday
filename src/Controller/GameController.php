<?php

namespace App\Controller;

use App\Repository\GameRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_USER')]
class GameController extends AbstractController
{
    #[Route('/game', name: 'app_game')]
    public function index(GameRepository $gameRepository): Response
    {
        $user = $this->getUser();
        $games = $gameRepository->findAllGameByUser($user->getId());
        dd($games);
        return $this->render('game/index.html.twig', [
            'games' => $games,
            'user' => $user
        ]);
    }
}
