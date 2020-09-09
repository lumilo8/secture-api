<?php

namespace App\Controller;

use App\Form\PlayerType;
use App\Service\ExchangeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\PlayerService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Player;

/**
 * Class PlayerController
 * @package App\Controller
 *
 * @Route("/player", name="player_")
 */
class PlayerController extends AbstractController
{
    /** @var PlayerService */
    private $playerService;

    /** @var ExchangeService */
    private $exchangeService;

    public function __construct(PlayerService $playerService, ExchangeService $exchangeService)
    {
        $this->playerService = $playerService;
        $this->exchangeService = $exchangeService;
    }

    /**
     * @Route("", name="create", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function createPlayer(Request $request): JsonResponse
    {
        $name = $request->get('name');
        $team = $request->get('team');
        $position = $request->get('position');
        $price = $request->get('price');

        $this->playerService->create($name, $team, $position, $price);

        return new JsonResponse(sprintf('Jugador %s creado correctamente', $name), Response::HTTP_OK);
    }

    /**
     * @Route("/{id}", name="update", methods={"PUT"})
     * @param Player $player
     * @param Request $request
     * @return JsonResponse
     */
    public function updatePlayer(Player $player, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $form = $this->createForm(PlayerType::class, $player);
        $form->submit($data);

        $this->playerService->update();

        return new JsonResponse(sprintf('Jugador %s actualizado correctamente', $player->getName()), Response::HTTP_OK);
    }

    /**
     * @Route("/", name="all", methods={"GET"})
     */
    public function listPlayer(Request $request): JsonResponse
    {
        $currency = strtoupper($request->get('currency'));
        $team = $request->get('team');
        $position = $request->get('position');

        $players = $this->playerService->list($team, $position);

        $data = [];
        foreach ($players as $player) {
            $price = !empty($currency)
                ? $this->exchangeService->eurToCurrency($player->getPrice(), $currency)
                : $player->getPrice();
            $data[] = [
                'id' => $player->getId(),
                'name' => $player->getName(),
                'team' => $player->getTeam()->getName(),
                'position' => $player->getPosition(),
                'price' => $price,
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/{id}", name="get", methods={"GET"})
     * @param Player $player
     * @return JsonResponse
     */
    public function getPlayer(Player $player): JsonResponse
    {
        $data = [
            'id' => $player->getId(),
            'name' => $player->getName(),
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * @param Player $player
     * @return JsonResponse
     */
    public function deletePlayer(Player $player): JsonResponse
    {
        $this->playerService->remove($player);

        return new JsonResponse(sprintf('Jugador %s eliminado correctamente', $player->getName()), Response::HTTP_OK);
    }
}
