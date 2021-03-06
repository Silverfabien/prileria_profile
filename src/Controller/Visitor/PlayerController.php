<?php

namespace App\Controller\Visitor;

use App\Entity\Player\Players;
use App\Repository\Moderation\BanRepository;
use App\Repository\Moderation\CommentsRepository;
use App\Repository\Moderation\KickRepository;
use App\Repository\Moderation\MuteRepository;
use App\Repository\Moderation\ReportRepository;
use App\Repository\Player\LockedRepository;
use App\Repository\Player\PlayersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/player", name="player_")
 */
class PlayerController extends AbstractController
{
    private PlayersRepository $playersRepository;
    private BanRepository $banRepository;
    private MuteRepository $muteRepository;
    private KickRepository $kickRepository;
    private CommentsRepository $commentsRepository;
    private ReportRepository $reportRepository;
    private LockedRepository $lockedRepository;

    public function __construct(
        PlayersRepository $playersRepository,
        BanRepository $banRepository,
        MuteRepository $muteRepository,
        KickRepository $kickRepository,
        CommentsRepository $commentsRepository,
        ReportRepository $reportRepository,
        LockedRepository $lockedRepository
    )
    {
        $this->playersRepository = $playersRepository;
        $this->banRepository = $banRepository;
        $this->muteRepository = $muteRepository;
        $this->kickRepository = $kickRepository;
        $this->commentsRepository = $commentsRepository;
        $this->reportRepository = $reportRepository;
        $this->lockedRepository = $lockedRepository;
    }

    /**
     * @param Players $players
     * @return Response
     *
     * @Route("/show/{batPlayer}", name="show", methods={"GET"})
     */
    public function show(
        Players $players
    ): Response
    {
        $bans = $this->banRepository->findBy(['uuid' => $players->getUuid()]);
        $bansIp = $this->banRepository->findBy(['banIp' => $players->getLastip()]);
        $mutes = $this->muteRepository->findBy(['uuid' => $players->getUuid()]);
        $mutesIp = $this->muteRepository->findBy(['muteIp' => $players->getLastip()]);
        $kicks = $this->kickRepository->findBy(['uuid' => $players->getUuid()]);
        $warnings = $this->commentsRepository->findBy(['entity' => $players->getUuid(), 'type' => 'WARNING']);
        $notes = $this->commentsRepository->findBy(['entity' => $players->getUuid(), 'type' => 'NOTE']);
        $reports = $this->reportRepository->findAll();
        $allPlayers = $this->playersRepository->findAll();
        $locked = $this->lockedRepository->findOneBy(['player' => $players]);

        return $this->render('visitor/player/show.html.twig', [
            'player' => $players,
            'bans' => $bans,
            'bansIp' => $bansIp,
            'nbBan' => count($bans) + count($bansIp),
            'mutes' => $mutes,
            'mutesIp' => $mutesIp,
            'nbMute' => count($mutes) + count($mutesIp),
            'kicks' => $kicks,
            'nbKick' => count($kicks),
            'warnings' => $warnings,
            'notes' => $notes,
            'nbComments' => count($warnings) + count($notes),
            'reports' => $reports,
            'allPlayers' => $allPlayers,
            'locked' => $locked
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @Route("/search_player/", name="search_player", options={"expose"=true})
     */
    public function search(
        Request $request
    ): JsonResponse
    {
        $search = $request->get('search');

        if (!$search) {
            return new JsonResponse();
        }

        if ($this->isGranted('ROLE_RESP')) {
            $playersByIp = $this->playersRepository->searchByIp($search);
        }

        $players = $this->playersRepository->searchByPseudo($search);

        $output = '';

        if ($this->isGranted('ROLE_RESP') && $playersByIp) {
            $output .='<ul class="dropdown-menu menu-black show menu-search">';
            foreach ($playersByIp as $key => $playerByIp) {
                $output .=
                    '<li class="dropdown-item">
                            <a class="link-profil" href="https://profils.prileria.net/player/show/'.$playerByIp->getBatPlayer().'">'.$playerByIp->getBatPlayer().'</a>
                        </li>';
            }
            $output .='</ul>';
        } elseif ($players) {
            $output .='<ul class="dropdown-menu menu-black show menu-search">';
            foreach ($players as $key => $player) {
                $output .=
                    '<li class="dropdown-item">
                    <a class="link-profil" href="https://profils.prileria.net/player/show/'.$player->getBatPlayer().'">'.$player->getBatPlayer().'</a>
                </li>'
                ;
            }
            $output .='</ul>';
        }

        return new JsonResponse($output);
    }
}
