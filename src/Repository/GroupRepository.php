<?php

namespace App\Repository;

use App\Entity\Group;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Group>
 *
 * @method Group|null find($id, $lockMode = null, $lockVersion = null)
 * @method Group|null findOneBy(array $criteria, array $orderBy = null)
 * @method Group[]    findAll()
 * @method Group[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Group::class);
    }

    public function save(Group $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Group $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function findGroupById($user): array
    {
        $query2 = $this->getEntityManager()->createQueryBuilder()
            ->select('g.id')
            ->from('App\Entity\Group', 'g')
            ->join('g.userGroups', 'ug')
            ->join('ug.id_User', 'u')
            ->andWhere("u = $user")
            ->orderBy('g.id', 'ASC');

        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('g1.numGroup', 'g1.nameGroup', 'g1.accesGroup', 'g1.descriptionGroup', 'g1.id', 'ug1.role', 'u1.username')
            ->from('App\Entity\Group', 'g1')
            ->join('g1.userGroups', 'ug1')
            ->join('ug1.id_User', 'u1')
            ->orderBy('g1.id', 'ASC');
        $query = $query->add(
            'where',
            'g1.id = ' .
                $query->expr()->any(
                    $query2->getDql()
                )
        );
        $data = $query->getQuery()->getResult();

        return $data;
    }
    public function findAllGroupWithoutUser($user)
    {
        $query2 = $this->getEntityManager()->createQueryBuilder()
            ->select('g.id')
            ->from('App\Entity\Group', 'g')
            ->join('g.userGroups', 'ug')
            ->join('ug.id_User', 'u')
            ->andWhere("u = $user");

        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('g1')
            ->from('App\Entity\Group', 'g1')
            ->where('g1.id NOT IN (' . $query2->getDQL() . ')')
            ->andWhere("g1.accesGroup = true");
        $data = $query->getQuery()->getResult();

        return $data;
    }
    public function findUserWithGroup($user, $id)
    {
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('u.username', 'ug.role')
            ->from('App\Entity\Group', 'g')
            ->join('g.userGroups', 'ug')
            ->join('ug.id_User', 'u')
            ->Where("u = $user")
            ->andWhere("g.id = $id");
        $data = $query->getQuery()->getOneOrNullResult();

        return $data;
    }
    public function findIdUserGroup($idUser,  $idGroup)
    {
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('ug.id')
            ->from('App\Entity\Group', 'g')
            ->join('g.userGroups', 'ug')
            ->join('ug.id_User', 'u')
            ->Where("u.id = $idUser")
            ->andWhere("g.id = $idGroup");

        $data = $query->getQuery()->getOneOrNullResult();

        return $data;
    }
    public function findIdUsersGroup($idGroup)
    {
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('ug.id')
            ->from('App\Entity\Group', 'g')
            ->join('g.userGroups', 'ug')
            ->join('ug.id_User', 'u')
            ->where("g.id = $idGroup");

        $data = $query->getQuery()->getResult();

        return $data;
    }

    //    /**
    //     * @return Group[] Returns an array of Group objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('g')
    //            ->andWhere('g.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('g.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Group
    //    {
    //        return $this->createQueryBuilder('g')
    //            ->andWhere('g.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
