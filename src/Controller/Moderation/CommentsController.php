<?php

namespace App\Controller\Moderation;

use App\ControllerHandler\Moderation\CommentsHandler;
use App\Entity\Moderation\Comments;
use App\Form\Moderation\CommentsType;
use App\Repository\Moderation\CommentsRepository;
use App\Repository\Player\PlayersRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/moderation/comments", name="moderation_comments_")
 */
class CommentsController extends AbstractController
{
    private CommentsRepository $commentsRepository;
    private PlayersRepository $playersRepository;
    private CommentsHandler $commentsHandler;

    public function __construct(
        CommentsRepository $commentsRepository,
        PlayersRepository $playersRepository,
        CommentsHandler $commentsHandler
    ) {
        $this->commentsRepository = $commentsRepository;
        $this->playersRepository = $playersRepository;
        $this->commentsHandler = $commentsHandler;
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
        $comments = $this->commentsRepository->findAllDesc();

        $paginate = $paginator->paginate(
            $comments,
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('moderation/comments/index.html.twig', [
            'comments' => $paginate,
            'players' => $this->playersRepository->findAll()
        ]);
    }

    /**
     * @param Request $request
     * @param UserInterface $user
     * @return Response
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
        $comments = new Comments();
        $form = $this->createForm(CommentsType::class, $comments)->handleRequest($request);

        if ($this->commentsHandler->createCommentsHandle($form, $comments, $user)) {
            $this->addFlash('success', sprintf(
                "Le commentaire du joueur avec l'uuid %s a bien été effectué",
                $comments->getEntity()
            ));

            return $this->redirectToRoute('moderation_comments_index');
        }

        return $this->render('moderation/comments/new.html.twig', [
            'form' => $form->createView(),
            'title' => 'Ajouter un commentaire'
        ]);
    }

    /**
     * @param Request $request
     * @param Comments $comments
     * @return Response
     *
     * @Route("/edit/{id}", name="edit", methods={"GET", "POST"})
     *
     * @IsGranted("ROLE_RESP")
     */
    public function edit(
        Request $request,
        Comments $comments
    ): Response
    {
        $form = $this->createForm(CommentsType::class, $comments)->handleRequest($request);

        if ($this->commentsHandler->editCommentsHandle($form, $comments)) {
            $this->addFlash('success', sprintf(
                "Le commentaire du joueur avec l'uuid %s a bien été modifié",
                $comments->getEntity()
            ));

            return $this->redirectToRoute('moderation_comments_index');
        }

        return $this->render('moderation/comments/edit.html.twig', [
            'form' => $form->createView(),
            'title' => 'Modifier le commentaire'
        ]);
    }

    /**
     * @param Request $request
     * @param Comments $comments
     * @return Response
     *
     * @Route("/delete/{id}", name="delete", methods={"DELETE"})
     *
     * @IsGranted("ROLE_RESP")
     */
    public function delete(
        Request $request,
        Comments $comments
    ): Response
    {
        if ($this->isCsrfTokenValid('delete'.$comments->getId(), $request->request->get('_token'))) {
            $this->commentsHandler->deleteCommentsHandle($comments);

            $this->addFlash('success', sprintf(
                "Le comments du joueur avec l'uuid %s a bien été supprimé",
                $comments->getEntity()
            ));
        }

        return $this->redirectToRoute('moderation_comments_index');
    }

    /**
     * @param Comments $comments
     * @return Response
     *
     * @Route("/show/{id}", name="show", methods={"GET"})
     */
    public function show(
        Comments $comments
    ): Response
    {
        return $this->render('moderation/comments/show.html.twig', [
            'comment' => $comments,
            'playerByUuid' => $this->playersRepository->findOneBy(['uuid' => $comments->getEntity()])
        ]);
    }
}
