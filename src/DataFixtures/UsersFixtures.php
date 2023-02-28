<?php

namespace App\DataFixtures;


use App\Entity\Availability;
use App\Entity\AvailabilityGlobal;
use App\Entity\Game;
use App\Entity\GameUser;
use App\Entity\Message;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UsersFixtures extends Fixture implements FixtureInterface
{
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');


        // fausse liste de jeux
        $game = new Game;
        $allgame = [];
        $game->setGameNum('GAME01')
            ->setGameName('Divinity: Original Sin 2')
            ->setNumberOfPlayer(4)
            ->setCategory('Jeu de roles');
        $allgame[] = $game;
        $manager->persist($game);
        $manager->flush();

        $game = new Game;
        $game->setGameNum('GAME02')
            ->setGameName('Minecraft')
            ->setNumberOfPlayer(100)
            ->setCategory('Jeu de survie');
        $allgame[] = $game;
        $manager->persist($game);
        $manager->flush();

        $game = new Game;
        $game->setGameNum('GAME03')
            ->setGameName('Total War : Warhammer 3')
            ->setNumberOfPlayer(100)
            ->setCategory('Jeu de roles');
        $allgame[] = $game;
        $manager->persist($game);
        $manager->flush();

        $game = new Game;
        $game->setGameNum('GAME04')
            ->setGameName('Csgo')
            ->setNumberOfPlayer(4)
            ->setCategory('Jeu de stratègie');
        $allgame[] = $game;
        $manager->persist($game);
        $manager->flush();

        $game = new Game;
        $game->setGameNum('GAME05')
            ->setGameName('Warhammer 40 000: Darktide')
            ->setNumberOfPlayer(4)
            ->setCategory('FPS');
        $allgame[] = $game;
        $manager->persist($game);
        $manager->flush();

        $game = new Game;
        $game->setGameNum('GAME06')
            ->setGameName('Chivalry 2')
            ->setNumberOfPlayer(100)
            ->setCategory('Jeu de combat médiéval');
        $allgame[] = $game;
        $manager->persist($game);
        $manager->flush();

        $game = new Game;
        $game->setGameNum('GAME07')
            ->setGameName('Escape From Tarkov')
            ->setNumberOfPlayer(5)
            ->setCategory('Hardcode FPS');
        $allgame[] = $game;
        $manager->persist($game);
        $manager->flush();

        $game = new Game;
        $game->setGameNum('GAME08')
            ->setGameName('GTA 5')
            ->setNumberOfPlayer(100)
            ->setCategory("Jeu d'action-aventure");
        $allgame[] = $game;
        $manager->persist($game);
        $manager->flush();

        $game = new Game;
        $game->setGameNum('GAME09')
            ->setGameName('Valheim')
            ->setNumberOfPlayer(100)
            ->setCategory('Jeu de survie');
        $allgame[] = $game;
        $manager->persist($game);
        $manager->flush();

        $game = new Game;
        $game->setGameNum('GAME10')
            ->setGameName('Valorant')
            ->setNumberOfPlayer(5)
            ->setCategory('FPS');
        $allgame[] = $game;
        $manager->persist($game);
        $manager->flush();

        $game = new Game;
        $game->setGameNum('GAME11')
            ->setGameName('Elden Ring')
            ->setNumberOfPlayer(3)
            ->setCategory('Jeu d\'aventure');
        $allgame[] = $game;
        $manager->persist($game);
        $manager->flush();

        $game = new Game;
        $game->setGameNum('GAME12')
            ->setGameName('Mario Kart 8')
            ->setNumberOfPlayer(4)
            ->setCategory('Jeu de course');
        $allgame[] = $game;
        $manager->persist($game);
        $manager->flush();

        $game = new Game;
        $game->setGameNum('GAME13')
            ->setGameName('Trackmania')
            ->setNumberOfPlayer(100)
            ->setCategory('Jeu de course');
        $allgame[] = $game;
        $manager->persist($game);
        $manager->flush();

        $game = new Game;
        $game->setGameNum('GAME14')
            ->setGameName('Factorio')
            ->setNumberOfPlayer(100)
            ->setCategory('Jeu de gestion');
        $allgame[] = $game;
        $manager->persist($game);
        $manager->flush();

        $game = new Game;
        $game->setGameNum('GAME15')
            ->setGameName('Satisfactory')
            ->setNumberOfPlayer(100)
            ->setCategory('Jeu de gestion');
        $allgame[] = $game;
        $manager->persist($game);
        $manager->flush();

        $game = new Game;
        $game->setGameNum('GAME16')
            ->setGameName('Among Us')
            ->setNumberOfPlayer(10)
            ->setCategory('Jeu de déduction');
        $allgame[] = $game;
        $manager->persist($game);
        $manager->flush();

        $game = new Game;
        $game->setGameNum('GAME17')
            ->setGameName('Borderlands 3')
            ->setNumberOfPlayer(4)
            ->setCategory('FPS');
        $allgame[] = $game;
        $manager->persist($game);
        $manager->flush();

        $game = new Game;
        $game->setGameNum('GAME18')
            ->setGameName('GTFO')
            ->setNumberOfPlayer(4)
            ->setCategory('Hardcore FPS');
        $allgame[] = $game;
        $manager->persist($game);
        $manager->flush();

        $game = new Game;
        $game->setGameNum('GAME19')
            ->setGameName('Orcs Must Die!3')
            ->setNumberOfPlayer(2)
            ->setCategory('Tower Defence, FPS');
        $allgame[] = $game;
        $manager->persist($game);
        $manager->flush();

        $game = new Game;
        $game->setGameNum('GAME20')
            ->setGameName('Deep Rock Galactic')
            ->setNumberOfPlayer(4)
            ->setCategory('FPS');
        $allgame[] = $game;
        $num = 0;
        $manager->persist($game);
        $manager->flush();

        // fausse liste d'utilisateur avec useradmin en mdp
        for ($i = 1; $i <= 100; $i++) {
            $user = new User;
            $user->setUsername($faker->userName())
                ->setEmail($faker->email())
                ->setPassword($this->userPasswordHasher->hashPassword($user, 'useradmin'))
                ->setIsVerified(true);
            $manager->persist($user);


            //fausse liste de message par utilisateur
            for ($m = 0; $m <= mt_rand(0, 4); $m++) {
                $message = new Message;

                $message->setContent($faker->sentence(10))
                    ->setIdUser($user);

                $manager->persist($message);
            }
            //fausse liste de disponibilité par jeux aléatoire et par utilisateur 
            for ($j = 1; $j <= mt_rand(1, 10); $j++) {
                $availability = new Availability;
                $key = array_rand($allgame);

                $gameUser = new GameUser;

                $gameUser->setShowGame(false)
                    ->setIdUser($user)
                    ->setIdGame($allgame[$key]);
                $manager->persist($gameUser);

                $dateStart = $faker->dateTimeBetween('now', '+1 months');

                $availability->setStartDate($dateStart)
                    ->setEndDate($faker->dateTimeInInterval($dateStart, '+1 weeks'))
                    ->setIdUser($user)
                    ->setGame($allgame[$key]);
                $manager->persist($availability);
            }
            //fausse liste de disponibilité par utilisateur
            for ($o = 1; $o <= mt_rand(1, 5); $o++) {
                $availability = new AvailabilityGlobal;

                $dateStart = $faker->dateTimeBetween('now', '+1 months');

                $availability->setStartDate($dateStart)
                    ->setEndDate($faker->dateTimeInInterval($dateStart, '+1 weeks'))
                    ->setUserId($user);
                $manager->persist($availability);
            }

            $manager->flush();
            $name = 'USER'.$i;
            $this->addReference($name, $user);
        }
    }
}
