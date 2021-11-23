<?php

namespace App\Controller\Administration;

use App\Repository\Moderation\BanRepository;
use App\Repository\Moderation\CommentsRepository;
use App\Repository\Moderation\KickRepository;
use App\Repository\Moderation\MuteRepository;
use App\Repository\Moderation\ReportRepository;
use App\Repository\Player\PlayersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/administration", name="administration_")
 */
class AdministrationController extends AbstractController
{
    private PlayersRepository $playersRepository;
    private BanRepository $banRepository;
    private MuteRepository $muteRepository;
    private KickRepository $kickRepository;
    private CommentsRepository $commentsRepository;
    private ReportRepository $reportRepository;

    public function __construct(
        PlayersRepository $playersRepository,
        BanRepository $banRepository,
        MuteRepository $muteRepository,
        KickRepository $kickRepository,
        CommentsRepository $commentsRepository,
        ReportRepository $reportRepository
    )
    {
        $this->playersRepository = $playersRepository;
        $this->banRepository = $banRepository;
        $this->muteRepository = $muteRepository;
        $this->kickRepository = $kickRepository;
        $this->commentsRepository = $commentsRepository;
        $this->reportRepository = $reportRepository;
    }

    /**
     * @return Response
     *
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(): Response
    {
        $players = $this->playersRepository->findAll();
        $bans = $this->banRepository->findAll();
        $bansActif = $this->banRepository->findBy(['banState' => true]);
        $mutes = $this->muteRepository->findAll();
        $mutesActif = $this->muteRepository->findBy(['muteState' => true]);
        $reports = $this->reportRepository->findAll();
        $reportsUnprocessed = $this->reportRepository->findBy(['status' => 'none']);
        $reportsNotArchived = $this->reportRepository->findBy(['archived' => false]);
        $kicks = $this->kickRepository->findAll();
        $comments = $this->commentsRepository->findAll();
        $warns = $this->commentsRepository->findBy(['type' => 'WARNING']);
        $notes = $this->commentsRepository->findBy(['type' => 'NOTE']);

        return $this->render('administration/index.html.twig', [
            'nbPlayers' => count($players),
            'nbBans' => count($bans),
            'nbBansActif' => count($bansActif),
            'nbMutes' => count($mutes),
            'nbMutesActif' => count($mutesActif),
            'nbReports' => count($reports),
            'nbReportsUnprocessed' => count($reportsUnprocessed),
            'nbReportsNotArchived' => count($reportsNotArchived),
            'nbKicks' => count($kicks),
            'nbComments' => count($comments),
            'nbWarns' => count($warns),
            'nbNotes' => count($notes)
        ]);
    }
}
