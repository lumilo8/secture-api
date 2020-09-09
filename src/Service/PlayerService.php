<?php

namespace App\Service;

use App\Entity\Player;
use App\Repository\PlayerRepository;

class PlayerService
{
    /** @var PlayerRepository */
    private $repository;

    /** @var ExchangeService */
    private $exchangeService;

    /** @var TeamService */
    private $teamService;

    public function __construct(
        PlayerRepository $repository,
        ExchangeService $exchangeService,
        TeamService $teamService
    ) {
        $this->repository = $repository;
        $this->exchangeService = $exchangeService;
        $this->teamService = $teamService;
    }

    public function list($teamName, $position)
    {
        $params = [];
        if (null !== $teamName) {
            $params['team'] = $this->teamService->getOneByName($teamName);
        }

        if (null !== $position) {
            $params['position'] = $position;
        }

        return $this->repository->getByParams($params);
    }

    public function create(Player $player)
    {
        return $this->repository->create($player);
    }

    public function update()
    {
        $this->repository->update();
    }

    public function remove(Player $player)
    {
        $this->repository->remove($player);
    }
}