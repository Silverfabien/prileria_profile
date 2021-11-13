<?php

namespace App\Controller\Moderation;

use App\ControllerHandler\Moderation\ReportHandler;
use App\Entity\Moderation\Report;
use App\Repository\Moderation\ReportRepository;
use App\Repository\Player\PlayersRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/moderation/report", name="moderation_report_")
 */
class ReportController extends AbstractController
{
    private ReportRepository $reportRepository;
    private PlayersRepository $playersRepository;
    private ReportHandler $reportHandler;

    public function __construct(
        ReportRepository $reportRepository,
        PlayersRepository $playersRepository,
        ReportHandler $reportHandler
    ) {
        $this->reportRepository = $reportRepository;
        $this->playersRepository = $playersRepository;
        $this->reportHandler = $reportHandler;
    }

    /**
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     *
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(
        Request $request,
        PaginatorInterface $paginator
    ): Response
    {
        $reports = $this->reportRepository->findAllDesc();

        $paginate = $paginator->paginate(
            $reports,
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('moderation/report/index.html.twig', [
            'reports' => $paginate,
            'players' => $this->playersRepository->findAll()
        ]);
    }

    /**
     * @param Report $report
     * @return Response
     *
     * @Route("/show/{id}", name="show", methods={"GET"})
     */
    public function show(
        Report $report
    ): Response
    {
        return $this->render('moderation/report/show.html.twig', [
            'report' => $report,
            'players' => $this->playersRepository->findAll()
        ]);
    }
}
