<?php

namespace App\Service;

use App\Entity\Team;
use App\Repository\TeamRepository;

class TeamService
{
    private $repository;

    public function __construct(TeamRepository $repository)
    {
        $this->repository = $repository;
    }

    public function list()
    {
        return $this->repository->findAll();
    }

    public function create(string $name)
    {
        return $this->repository->create($name);
    }

    public function update()
    {
        return $this->repository->update();
    }

    public function remove(Team $team)
    {
        return $this->repository->remove($team);
    }

    public function getOneByName($name)
    {
        return $this->repository->findOneByName($name);
    }
}