<?php

namespace App\Controller;

use App\Entity\GameUser;
use App\Repository\GameRepository;
use App\Repository\GameUserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
        return $this->render('game/index.html.twig', [
            'games' => $games
        ]);
    }
    #[Route('/game/user/add', name: 'app_add_gameUser')]
    public function ajaxAddGameUser(GameUserRepository $gameUserRepository, GameRepository $gameRepository, Request $request): Response
    {
        $gameUser = new GameUser();

        $user = $this->getUser();

        $game = $request->get('gameId');
        $game = $gameRepository->findOneBy(['id' => $game]);

        $gameUser->setIdGame($game);
        $gameUser->setShowGame(true);
        $gameUser->setIdUser($user);

        $gameUserRepository->save($gameUser, true);

        return new Response('Modification faite');
    }
    #[Route('/game/user/delete', name: 'app_delete_gameUser')]
    public function ajaxRemoveGameUser(GameUserRepository $gameUserRepository, Request $request): Response
    {
        $user = $this->getUser();
        $game = $request->get('gameId');

        $OldGameUser = $gameUserRepository->findOneBy(['id_user' => $user->getId(), 'id_game' => $game]);

        $gameUserRepository->remove($OldGameUser, true);

        return new Response('Suppression faite');
    }
    #[Route('/game/user/modify', name: 'app_modify_gameUser')]
    public function ajaxUpdateGameUser(GameUserRepository $gameUserRepository, Request $request): Response
    {
        //Attention problème performance possible
        $user = $this->getUser();
        $data = json_decode($request->getContent(), true);

        $game = $data['idGame'];
        $showGame = $data['showGame'];


        $gameUser = $gameUserRepository->findOneBy(['id_game' => $game, 'id_user' => $user->getId()]);

        $gameUser->setShowGame($showGame);

        $gameUserRepository->save($gameUser, true);

        return new Response('modification faite');
    }
}
