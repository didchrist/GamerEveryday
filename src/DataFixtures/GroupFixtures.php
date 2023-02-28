<?php

namespace App\DataFixtures;



use App\Entity\Group;
use App\Entity\UserGroup;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;



class GroupFixtures extends Fixture implements FixtureInterface, DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        /* $num = 0;
        
        for ($i = 1; $i <= 100; $i++) {
            $name = 'USER'.$i;
            $users [] = $this->getReference($name);
        }


        for ($x = 1; $x <= 10; $x++) {
            $group = new Group;
            
            $num++;
            $numGroup = 'GROUP'. $num;
            $group->setNumGroup($numGroup)
                ->setNameGroup($faker->words(2,true))
                ->setAccesGroup((bool)random_int(0,1))
                ->setDescriptionGroup($faker->text(20));

            $manager->persist($group);
            $manager->flush();
            $userGroupChef = new UserGroup;
            

            $user = array_rand($users);
            $userGroupChef->setRole('createur')
                ->addIdGroup($group)
                ->addIdUser($users[$user]);

            unset($users[$user]);
            $manager->persist($userGroupChef);
            $manager->flush();
            
            

            for ($y = 1; $x <= mt_rand(1,4); $y++) {
                $userGroup = new UserGroup;
                $user = array_rand($users);

                $userGroup->setRole('membre')
                    ->addIdGroup($group)
                    ->addIdUser($users[$user]);

                $manager->persist($userGroup);
                $manager->flush();
            }
        } */
        
    }
    public function getDependencies()
    {
        return [
            UsersFixtures::class,
        ];
    }

}