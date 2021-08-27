<?php

namespace App\Controller;

use App\Entity\Blogpost;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\BlogpostRepository;
use App\Repository\CommentaireRepository;
use App\Repository\UserRepository;
use App\Service\CommentaireService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogpostController extends AbstractController
{
    /**
     * @Route("/actualites", name="actualites")
     */
    public function actualites(BlogpostRepository $blogpostRepository,
    PaginatorInterface $paginator,
    Request $request
    ): Response
    {
        $data = $blogpostRepository->findBy([], ['id'=>'DESC']);
        $actualites = $paginator->paginate(
            $data,
        $request->query->getInt('page', 1),
            3
        );
        return $this->render('blogpost/actualites.html.twig', [
            'actualites' => $actualites,
        ]);
    }

    /**
     * @Route("/actualites/{slug}", name="actualites_details")
     */
    public function detail(
        Blogpost $blogpost,
        UserRepository $userRepository,
        Request $request,
        CommentaireService $commentaireService,
        CommentaireRepository $commentaireRepository
    ) : Response {

        $commentaires = $commentaireRepository->findCommentaires($blogpost);
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentaire = $form->getData();
            $commentaireService->persistCommentaire($commentaire, $blogpost, null);

            return $this->redirectToRoute('actualites_details', ['slug' => $blogpost->getSlug()]);
        }

        return $this->render('blogpost/detail.html.twig', [
            'actualite' => $blogpost,
            'form' => $form->createView(),
            'commentaires' => $commentaires,
            'user' => $userRepository->findAll()
        ]);
    }
}
