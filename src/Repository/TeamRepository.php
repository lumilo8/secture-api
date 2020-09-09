<?php

namespace App\Repository;

use App\Entity\Team;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Team|null find($id, $lockMode = null, $lockVersion = null)
 * @method Team|null findOneBy(array $criteria, array $orderBy = null)
 * @method Team[]    findAll()
 * @method Team[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeamRepository extends ServiceEntityRepository
{
    /** @var EntityManagerInterface */
    private $manager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Team::class);
        $this->manager = $manager;
    }

    /**
     * @param Team $team
     * @return Team
     */
    public function create(Team $team): Team
    {
        $this->manager->persist($team);
        $this->manager->flush();

        return $team;
    }

    public function update(): void
    {
        $this->manager->flush();
    }

    /**
     * @param Team $team
     */
    public function remove(Team $team): void
    {
        $this->manager->remove($team);
        $this->manager->flush();
    }
}
