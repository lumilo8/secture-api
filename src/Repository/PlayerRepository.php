<?php

namespace App\Repository;

use App\Entity\Player;
use App\Entity\Team;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectRepository;

/**
 * @method Player|null find($id, $lockMode = null, $lockVersion = null)
 * @method Player|null findOneBy(array $criteria, array $orderBy = null)
 * @method Player[]    findAll()
 * @method Player[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayerRepository extends ServiceEntityRepository
{
    /** @var EntityManagerInterface */
    private $manager;

    /** @var ObjectRepository */
    private $teamRepository;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Player::class);
        $this->manager = $manager;
        $this->teamRepository = $manager->getRepository(Team::class);
    }

    /**
     * @param array $params
     * @return int|mixed|string
     */
    public function getByParams(array $params)
    {
        $qb = $this->createQueryBuilder('p')
            ->where('p.name is not null');

        foreach ($params as $key => $param) {
            $qb->andWhere(sprintf('p.%s = :%s', $key, $key))->setParameter($key, $param);
        }

        return $qb->getQuery()->getResult();
    }

    /**
     * @param Player $player
     * @return Player
     */
    public function create(Player $player): Player
    {
        $this->manager->persist($player);
        $this->manager->flush();

        return $player;
    }

    /**
     * Update
     */
    public function update(): void
    {
        $this->manager->flush();
    }

    /**
     * @param Player $player
     */
    public function remove(Player $player): void
    {
        $this->manager->remove($player);
        $this->manager->flush();
    }
}
