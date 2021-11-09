<?php

namespace App\Controller\Moderation;

use App\Repository\Moderation\BanRepository;
use App\Repository\Player\PlayersRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/moderation/ban", name="moderation_ban_")
 */
class BanController extends AbstractController
{
    private BanRepository $banRepository;
    private PlayersRepository $playersRepository;

    public function __construct(
        BanRepository $banRepository,
        PlayersRepository $playersRepository
    )
    {
        $this->banRepository = $banRepository;
        $this->playersRepository = $playersRepository;
    }

    /**
     * @Route("/", name="index")
     */
    public function index(
        Request $request,
        PaginatorInterface $paginator
    ): Response
    {
        $bans = $this->banRepository->findAll();

        $paginate = $paginator->paginate(
            $bans,
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('moderation/ban/index.html.twig',[
            'bans' => $paginate,
            'players' => $this->playersRepository->findAll()
        ]);
    }
}
