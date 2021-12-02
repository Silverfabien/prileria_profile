<?php

namespace App\Controller;

use App\Repository\Moderation\BanRepository;
use App\Repository\Moderation\CommentsRepository;
use App\Repository\Player\PlayersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    private PlayersRepository $playersRepository;
    private CommentsRepository $commentsRepository;
    private BanRepository $banRepository;

    public function __construct(
        PlayersRepository $playersRepository,
        CommentsRepository $commentsRepository,
        BanRepository $banRepository
    ) {
        $this->playersRepository = $playersRepository;
        $this->commentsRepository = $commentsRepository;
        $this->banRepository = $banRepository;
    }


    /**
     * @Route("/", name="default", methods={"GET"})
     */
    public function index(): Response
    {
        $players = $this->playersRepository->findAll();
        $warns = $this->commentsRepository->findBy(['type' => 'WARNING']);
        $bans = $this->banRepository->findBy(['banState' => true]);

        return $this->render('default/index.html.twig', [
            'nbPlayer' => count($players),
            'nbWarn' => count($warns),
            'nbBan' => count($bans),
        ]);
    }
}
