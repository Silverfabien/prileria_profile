<?php

namespace App\Controller\Moderation;

use App\ControllerHandler\Moderation\BanHandler;
use App\Entity\Moderation\Ban;
use App\Form\Moderation\BanType;
use App\Repository\Moderation\BanRepository;
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
 * @Route("/moderation/ban", name="moderation_ban_")
 */
class BanController extends AbstractController
{
    private BanRepository $banRepository;
    private PlayersRepository $playersRepository;
    private BanHandler $banHandler;

    public function __construct(
        BanRepository $banRepository,
        PlayersRepository $playersRepository,
        BanHandler $banHandler
    )
    {
        $this->banRepository = $banRepository;
        $this->playersRepository = $playersRepository;
        $this->banHandler = $banHandler;
    }

    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(
        Request $request,
        PaginatorInterface $paginator
    ): Response
    {
        $bans = $this->banRepository->findAllDesc();

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
        $ban = new Ban();
        $form = $this->createForm(BanType::class, $ban)->handleRequest($request);

        if ($this->banHandler->createBanHandle($form, $ban, $user)) {
            $this->addFlash('success', sprintf(
                "Le ban du joueur avec l'uuid %s a bien été effectué",
                $ban->getUuid()
            ));

            return $this->redirectToRoute('moderation_ban_index');
        }

        return $this->render('moderation/ban/new.html.twig', [
            'form' => $form->createView(),
            'title' => 'Ajouter un ban'
        ]);
    }

    /**
     * @param Request $request
     * @param Ban $ban
     * @return Response
     * @throws Exception
     *
     * @Route("/edit/{id}", name="edit", methods={"GET", "POST"})
     *
     * @IsGranted("ROLE_RESP")
     */
    public function edit(
        Request $request,
        Ban $ban
    ): Response
    {
        $form = $this->createForm(BanType::class, $ban)->handleRequest($request);

        if ($this->banHandler->editBanHandle($form, $ban)) {
            $this->addFlash('success', sprintf(
                "Le ban du joueur avec l'uuid %s a bien été modifié",
                $ban->getUuid()
            ));

            return $this->redirectToRoute('moderation_ban_index');
        }

        return $this->render('moderation/ban/edit.html.twig', [
            'form' => $form->createView(),
            'title' => 'Modifier un ban'
        ]);
    }

    /**
     * @param Request $request
     * @param Ban $ban
     * @return Response
     *
     * @Route("/delete/{id}", name="delete", methods={"DELETE"})
     *
     * @IsGranted("ROLE_RESP")
     */
    public function delete(
        Request $request,
        Ban $ban
    ): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ban->getId(), $request->request->get('_token'))) {
            $this->banHandler->deleteBanHandle($ban);

            $this->addFlash('success', sprintf(
                "Le ban du joueur avec l'uuid %s a bien été supprimé",
                $ban->getUuid()
            ));
        }

        return $this->redirectToRoute('moderation_ban_index');
    }

    /**
     * @param Ban $ban
     * @return Response
     *
     * @Route("/show/{id}", name="show", methods={"GET"})
     */
    public function show(
        Ban $ban
    ): Response
    {
        return $this->render('moderation/ban/show.html.twig', [
            'ban' => $ban,
            'firstPlayer' => $this->playersRepository->findOneBy(['lastip' => $ban->getBanIp()]),
            'playersByIp' => $this->playersRepository->findBy(['lastip' => $ban->getBanIp()]),
            'playerByUuid' => $this->playersRepository->findOneBy(['uuid' => $ban->getUuid()])
        ]);
    }
}
