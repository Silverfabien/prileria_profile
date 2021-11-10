<?php

namespace App\Controller\Moderation;

use App\ControllerHandler\MuteHandler;
use App\Entity\Moderation\Mute;
use App\Form\Moderation\MuteType;
use App\Repository\Moderation\MuteRepository;
use App\Repository\Player\PlayersRepository;
use Exception;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/moderation/mute", name="moderation_mute_")
 */
class MuteController extends AbstractController
{
    private MuteRepository $muteRepository;
    private PlayersRepository $playersRepository;
    private MuteHandler $muteHandler;

    public function __construct(
        MuteRepository $muteRepository,
        PlayersRepository $playersRepository,
        MuteHandler $muteHandler
    )
    {
        $this->muteRepository = $muteRepository;
        $this->playersRepository = $playersRepository;
        $this->muteHandler = $muteHandler;
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
        $mutes = $this->muteRepository->findAllDesc();

        $paginate = $paginator->paginate(
            $mutes,
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('moderation/mute/index.html.twig', [
            'mutes' => $paginate,
            'players' => $this->playersRepository->findAll()
        ]);
    }

    /**
     * @param Request $request
     * @param UserInterface $user
     * @return Response
     * @throws Exception
     *
     * @Route("/new", name="new", methods={"GET", "POST"})
     *
     * @IsGranted("ROLE_RESP")
     */
    public function new(
        Request $request,
        UserInterface $user
    ): Response
    {
        $mute = new Mute();
        $form = $this->createForm(MuteType::class, $mute)->handleRequest($request);

        if ($this->muteHandler->createMuteHandle($form, $mute, $user)) {
            $this->addFlash('success', sprintf(
                "Le mute du joueur avec l'uuid %s a bien été effectué",
                $mute->getUuid()
            ));

            return $this->redirectToRoute('moderation_mute_index');
        }

        return $this->render('moderation/mute/new.html.twig', [
            'form' => $form->createView(),
            'title' => 'Ajouter un mute'
        ]);
    }

    /**
     * @param Request $request
     * @param Mute $mute
     * @return Response
     * @throws Exception
     *
     * @Route("/edit/{id}", name="edit", methods={"GET", "POST"})
     *
     * @IsGranted("ROLE_RESP")
     */
    public function edit(
        Request $request,
        Mute $mute
    ): Response
    {
        $form = $this->createForm(MuteType::class, $mute)->handleRequest($request);

        if ($this->muteHandler->editMuteHandle($form, $mute)) {
            $this->addFlash('success', sprintf(
                "Le mute du joueur avec l'uuid %s a bien été modifié",
                $mute->getUuid()
            ));

            return $this->redirectToRoute('moderation_mute_index');
        }

        return $this->render('moderation/mute/edit.html.twig', [
            'form' => $form->createView(),
            'title' => 'Modifier un mute'
        ]);
    }

    /**
     * @param Request $request
     * @param Mute $mute
     * @return Response
     *
     * @Route("/delete/{id}", name="delete", methods={"DELETE"})
     *
     * @IsGranted("ROLE_RESP")
     */
    public function delete(
        Request $request,
        Mute $mute
    ): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mute->getId(), $request->request->get('_token'))) {
            $this->muteHandler->deleteMuteHandle($mute);

            $this->addFlash('success', sprintf(
                "Le mute du joueur avec l'uuid %s a bien été supprimé",
                $mute->getUuid()
            ));
        }

        return $this->redirectToRoute('moderation_mute_index');
    }

    /**
     * @param Mute $mute
     * @return Response
     *
     * @Route("/show/{id}", name="show", methods={"GET"})
     */
    public function show(
        Mute $mute
    ): Response
    {
        return $this->render('moderation/mute/show.html.twig', [
            'mute' => $mute,
            'firstPlayer' => $this->playersRepository->findOneBy(['lastip' => $mute->getMuteIp()]),
            'playersByIp' => $this->playersRepository->findBy(['lastip' => $mute->getMuteIp()]),
            'playerByUuid' => $this->playersRepository->findOneBy(['uuid' => $mute->getUuid()])
        ]);
    }
}
