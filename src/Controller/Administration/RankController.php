<?php

namespace App\Controller\Administration;

use App\ControllerHandler\Administration\RankHandler;
use App\Entity\Security\Rank;
use App\Form\Administration\RankType;
use App\Repository\Security\RankRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/administration/rank", name="administration_rank_")
 *
 * @IsGranted("ROLE_ADMIN")
 */
class RankController extends AbstractController
{
    private RankRepository $rankRepository;
    private RankHandler $rankHandler;

    public function __construct(
        RankRepository $rankRepository,
        RankHandler $rankHandler
    )
    {
        $this->rankRepository = $rankRepository;
        $this->rankHandler = $rankHandler;
    }

    /**
     * @return Response
     *
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('administration/rank/index.html.twig', [
            'ranks' => $this->rankRepository->findAll()
        ]);
    }

    /**
     * @param Request $request
     * @param Rank $rank
     * @return Response
     *
     * @Route("/edit/{id}", name="edit", methods={"GET", "POST"})
     */
    public function edit(
        Request $request,
        Rank $rank
    ): Response
    {
        $form = $this->createForm(RankType::class, $rank)->handleRequest($request);

        if ($this->rankHandler->editRankHandle($form, $rank)) {
            return $this->redirectToRoute('administration_rank_index');
        }

        return $this->render('administration/rank/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
