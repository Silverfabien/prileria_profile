<?php

namespace App\Controller\Administration;

use App\ControllerHandler\Administration\LockedHandler;
use App\Entity\Player\Locked;
use App\Entity\Player\Players;
use App\Form\Administration\LockedType;
use App\Repository\Player\LockedRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/administration/locked", name="administration_locked_")
 */
class LockedController extends AbstractController
{
    private LockedRepository $lockedRepository;
    private LockedHandler $lockedHandler;

    public function __construct(
        LockedRepository $lockedRepository,
        LockedHandler $lockedHandler
    )
    {
        $this->lockedRepository = $lockedRepository;
        $this->lockedHandler = $lockedHandler;
    }

    /**
     * @return Response
     *
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('administration/locked/index.html.twig', [
            'lockeds' => $this->lockedRepository->findAll()
        ]);
    }

    /**
     * @param Request $request
     * @param UserInterface $user
     * @param Players $players
     * @return Response
     *
     * @Route("/lock/{player_id}", name="lock", methods={"GET", "POST"})
     * @ParamConverter("players", options={"id" = "player_id"})
     *
     * @IsGranted("ROLE_RESP")
     */
    public function lock(
        Request $request,
        UserInterface $user,
        Players $players
    ): Response
    {
        $locked = new Locked();
        $form = $this->createForm(LockedType::class, $locked)->handleRequest($request);

        if ($this->lockedHandler->createLockedHandle($form, $user, $locked, $players)) {
            $this->addFlash('success', sprintf(
                'Le blocage du joueur "%s" a bien été ajouté !',
                $players->getBatPlayer()
            ));

            return $this->redirectToRoute('administration_player_index');
        }

        return $this->render('administration/locked/new.html.twig', [
            'form' => $form->createView(),
            'title' => 'Bloquer le compte'
        ]);
    }

    /**
     * @param Request $request
     * @param Locked $locked
     * @return Response
     *
     * @Route("/unlock/{id}", name="unlock", methods={"POST"})
     *
     * @IsGranted("ROLE_RESP")
     */
    public function unlock(
        Request $request,
        Locked $locked
    ): Response
    {
        if ($this->isCsrfTokenValid('unlock'.$locked->getId(), $request->request->get('_token'))) {
            $this->lockedHandler->deleteLockedHandle($locked);

            $this->addFlash('success', 'Le blocage du joueur a bien été supprimer !');
        }

        return $this->redirectToRoute('administration_player_index');
    }

    /**
     * @param Request $request
     * @param Locked $locked
     * @return Response
     *
     * @Route("/edit/{id}", name="edit", methods={"GET", "POST"})
     *
     * @IsGranted("ROLE_RESP")
     */
    public function edit(
        Request $request,
        Locked $locked
    ): Response
    {
        $form = $this->createForm(LockedType::class, $locked)->handleRequest($request);

        if ($this->lockedHandler->editLockedHandle($form, $locked)) {
            $this->addFlash('success', sprintf(
                'Le blocage du joueur "%s" a bien été modifier !',
                $locked->getPlayer()->getBatPlayer()
            ));

            return $this->redirectToRoute('administration_locked_index');
        }

        return $this->render('administration/locked/edit.html.twig', [
            'form' => $form->createView(),
            'title' => 'Modifier le blocage du compte'
        ]);
    }
}
