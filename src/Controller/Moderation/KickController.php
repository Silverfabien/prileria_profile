<?php

namespace App\Controller\Moderation;

use App\ControllerHandler\Moderation\KickHandler;
use App\Entity\Moderation\Kick;
use App\Form\Moderation\KickType;
use App\Repository\Moderation\KickRepository;
use App\Repository\Player\PlayersRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/moderation/kick", name="moderation_kick_")
 */
class KickController extends AbstractController
{
    private KickRepository $kickRepository;
    private PlayersRepository $playersRepository;
    private KickHandler $kickHandler;

    public function __construct(
        KickRepository $kickRepository,
        PlayersRepository $playersRepository,
        KickHandler $kickHandler
    )
    {
        $this->kickRepository = $kickRepository;
        $this->playersRepository = $playersRepository;
        $this->kickHandler = $kickHandler;
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
        $kick = $this->kickRepository->findAllDesc();

        $paginate = $paginator->paginate(
            $kick,
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('moderation/kick/index.html.twig', [
            'kicks' => $paginate,
            'players' => $this->playersRepository->findAll()
        ]);
    }

    /**
     * @param Request $request
     * @param Kick $kick
     * @return Response
     *
     * @Route("/edit/{id}", name="edit", methods={"GET", "POST"})
     *
     * @IsGranted("ROLE_RESP")
     */
    public function edit(
        Request $request,
        Kick $kick
    ): Response
    {
        $form = $this->createForm(KickType::class, $kick)->handleRequest($request);

        if ($this->kickHandler->editKickHandle($form, $kick)) {
            $this->addFlash('success', sprintf(
                "Le kick du joueur avec l'uuid %s a bien été modifié",
                $kick->getUuid()
            ));

            return $this->redirectToRoute('moderation_kick_index');
        }

        return $this->render('moderation/kick/edit.html.twig', [
            'form' => $form->createView(),
            'title' => 'Modifier un kick'
        ]);
    }

    /**
     * @param Request $request
     * @param Kick $kick
     * @return Response
     *
     * @Route("/delete/{id}", name="delete", methods={"DELETE"})
     *
     * @IsGranted("ROLE_RESP")
     */
    public function delete(
        Request $request,
        Kick $kick
    ): Response
    {
        if ($this->isCsrfTokenValid('delete'.$kick->getId(), $request->request->get('_token'))) {
            $this->kickHandler->deleteKickHandle($kick);

            $this->addFlash('success', sprintf(
                "Le kick du joueur avec l'uuid %s a bien été supprimé",
                $kick->getUuid()
            ));
        }

        return $this->redirectToRoute('moderation_kick_index');
    }

    /**
     * @param Kick $kick
     * @return Response
     *
     * @Route("/show/{id}", name="show", methods={"GET"})
     */
    public function show(
        Kick $kick
    ): Response
    {
        return $this->render('moderation/kick/show.html.twig', [
            'kick' => $kick,
            'playerByUuid' => $this->playersRepository->findOneBy(['uuid' => $kick->getUuid()])
        ]);
    }
}
