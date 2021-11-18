<?php

namespace App\Controller\Administration;

use App\Repository\Player\PlayersRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/administration/player", name="administration_player_")
 */
class PlayerController extends AbstractController
{
    private PlayersRepository $playersRepository;

    public function __construct(
        PlayersRepository $playersRepository
    )
    {
        $this->playersRepository = $playersRepository;
    }

    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(
        Request $request,
        PaginatorInterface $paginator
    ): Response
    {
        $players = $this->playersRepository->findAllDesc();

        $paginate = $paginator->paginate(
            $players,
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('administration/player/index.html.twig', [
            'players' => $paginate
        ]);
    }
}
