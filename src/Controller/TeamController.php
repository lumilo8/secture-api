<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\TeamService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Team;

/**
 * Class TeamController
 * @package App\Controller
 *
 * @Route("/team", name="team_")
 */
class TeamController extends AbstractController
{
    /** @var TeamService */
    private $teamService;

    public function __construct(TeamService $teamService)
    {
        $this->teamService = $teamService;
    }

    /**
     * @Route("", name="create", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function createTeam(Request $request): JsonResponse
    {
        $name = $request->get('name');

        $team = $this->teamService->create($name);

        return new JsonResponse(sprintf('Equipo %s creado correctamente', $team->getName()), Response::HTTP_OK);
    }

    /**
     * @Route("/{id}", name="update", methods={"PUT"})
     * @param Team $team
     * @param Request $request
     * @return JsonResponse
     */
    public function updateTeam(Team $team, Request $request): JsonResponse
    {
        $name = $request->get('name');

        $team->setName($name);
        $this->teamService->update();

        return new JsonResponse(sprintf('Equipo %s actualizado correctamente', $name), Response::HTTP_OK);
    }

    /**
     * @Route("", name="all", methods={"GET"})
     */
    public function listTeam(): JsonResponse
    {
        $teams = $this->teamService->list();

        $data = [];
        foreach ($teams as $team) {
            $data[] = [
                'id' => $team->getId(),
                'name' => $team->getName(),
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/{id}", name="get", methods={"GET"})
     * @param Team $team
     * @return JsonResponse
     */
    public function getTeam(Team $team): JsonResponse
    {
        $data = [
            'id' => $team->getId(),
            'name' => $team->getName(),
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * @param Team $team
     * @return JsonResponse
     */
    public function deleteTeam(Team $team): JsonResponse
    {
        $this->teamService->remove($team);

        return new JsonResponse(sprintf('Equipo %s eliminado correctamente', $team->getName()), Response::HTTP_OK);
    }
}
