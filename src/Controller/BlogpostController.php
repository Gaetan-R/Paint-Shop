<?php

namespace App\Controller;

use App\Entity\Blogpost;
use App\Repository\BlogpostRepository;
use App\Repository\UserRepository;
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
    public function detail(Blogpost $blogpost, UserRepository $userRepository) : Response
    {
        return $this->render('blogpost/detail.html.twig', [
            'actualite' => $blogpost,
            'user' => $userRepository->findAll()
        ]);
    }
}
