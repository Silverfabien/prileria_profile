<?php

namespace App\Controller\Administration;

use App\ControllerHandler\Administration\UserHandler;
use App\Entity\Security\User;
use App\Form\Administration\UserEditPasswordType;
use App\Form\Administration\UserEditType;
use App\Form\Administration\UserType;
use App\Repository\Moderation\BanRepository;
use App\Repository\Moderation\CommentsRepository;
use App\Repository\Moderation\KickRepository;
use App\Repository\Moderation\MuteRepository;
use App\Repository\Moderation\ReportRepository;
use App\Repository\Player\PlayersRepository;
use App\Repository\Security\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/administration/user", name="administration_user_")
 *
 * @IsGranted("ROLE_ADMIN")
 */
class UserController extends AbstractController
{
    private UserRepository $userRepository;
    private UserHandler $userHandler;
    private BanRepository $banRepository;
    private MuteRepository $muteRepository;
    private KickRepository $kickRepository;
    private CommentsRepository $commentsRepository;
    private ReportRepository $reportRepository;
    private PlayersRepository $playersRepository;

    public function __construct(
        UserRepository $userRepository,
        UserHandler $userHandler,
        BanRepository $banRepository,
        MuteRepository $muteRepository,
        KickRepository $kickRepository,
        CommentsRepository $commentsRepository,
        ReportRepository $reportRepository,
        PlayersRepository $playersRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->userHandler = $userHandler;
        $this->banRepository = $banRepository;
        $this->muteRepository = $muteRepository;
        $this->kickRepository = $kickRepository;
        $this->commentsRepository = $commentsRepository;
        $this->reportRepository = $reportRepository;
        $this->playersRepository = $playersRepository;
    }

    /**
     * @return Response
     *
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('administration/user/index.html.twig', [
            'users' => $this->userRepository->findAll()
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/new", name="new", methods={"GET", "POST"})
     */
    public function new(
        Request $request
    ): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user)->handleRequest($request);

        if ($this->userHandler->createUserHandle($form, $user)) {
            $this->addFlash('success', sprintf(
                "La création du compte de %s à bien été créé",
                $user->getUserIdentifier()
            ));

            return $this->redirectToRoute('administration_user_index');
        }

        return $this->render('administration/user/new.html.twig', [
            'form' => $form->createView(),
            'title' => 'Ajouter un membre du staff'
        ]);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return Response
     *
     * @Route("/edit/{id}", name="edit", methods={"GET", "POST"})
     */
    public function edit(
        Request $request,
        User $user
    ): Response
    {
        $form = $this->createForm(UserEditType::class, $user)->handleRequest($request);

        if ($this->userHandler->editUserHandle($form, $user)) {
            $this->addFlash('success', sprintf(
                "La modification du compte de %s à bien été modifié",
                $user->getUserIdentifier()
            ));

            return $this->redirectToRoute('administration_user_index');
        }

        return $this->render('administration/user/edit.html.twig', [
            'form' => $form->createView(),
            'title' => 'Modifier le membre du staff'
        ]);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return Response
     *
     * @Route("/edit/{id}/password", name="edit_password", methods={"GET", "POST"})
     */
    public function editPassword(
        Request $request,
        User $user
    ): Response
    {
        $form = $this->createForm(UserEditPasswordType::class, $user)->handleRequest($request);

        if ($this->userHandler->editUserPasswordHandle($form, $user)) {
            $this->addFlash('success', sprintf(
                "La modification du mot de passe de %s à bien été modifié",
                $user->getUserIdentifier()
            ));

            return $this->redirectToRoute('administration_user_index');
        }

        return $this->render('administration/user/edit.html.twig', [
            'form' => $form->createView(),
            'title' => 'Modifier le mot de passe du membre du staff'
        ]);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return Response
     *
     * @Route("/delete/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(
        Request $request,
        User $user
    ): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $this->userRepository->remove($user);

            $this->addFlash('success', "La suppression du compte à bien été effectué");
        }

        return $this->redirectToRoute('administration_user_index');
    }

    /**
     * @param User $user
     * @return Response
     *
     * @Route("/show/{id}", name="show", methods={"GET"})
     */
    public function show(
        User $user
    ): Response
    {
        return $this->render('administration/user/show.html.twig', [
            'user' => $user,
            'nbBan' => count($this->banRepository->findBy(['banStaff' => $user->getUserIdentifier()])),
            'nbMute' => count($this->muteRepository->findBy(['muteStaff' => $user->getUserIdentifier()])),
            'nbKick' => count($this->kickRepository->findBy(['kickStaff' => $user->getUserIdentifier()])),
            'nbCommentWarning' => count($this->commentsRepository->findBy(['staff' => $user->getUserIdentifier(), 'type' => 'WARNING'])),
            'nbCommentNote' => count($this->commentsRepository->findBy(['staff' => $user->getUserIdentifier(), 'type' => 'NOTE'])),
            'reports' => $this->reportRepository->findAll(),
            'player' => $this->playersRepository->findOneBy(['uuid' => $user->getUuid()])
        ]);
    }
}
