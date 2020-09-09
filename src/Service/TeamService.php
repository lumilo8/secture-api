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

    public function create(Team $team)
    {
        return $this->repository->create($team);
    }

    public function update()
    {
        $this->repository->update();
    }

    public function remove(Team $team)
    {
        $this->repository->remove($team);
    }

    public function getOneByName($name)
    {
        return $this->repository->findOneByName($name);
    }
}