<?php

namespace App\Controller;

use App\Repository\PeintureRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PeinturesController extends AbstractController
{
    /**
     * @Route("/peintures", name="peintures")
     */
    public function realisations(PeintureRepository $peintureRepository,
    PaginatorInterface $paginator,
     Request $request
    ): Response {
        $data = $peintureRepository->findAll();
        $peintures = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            6
        );
        return $this->render('peintures/index.html.twig', [
            'peintures' => $peintures
        ]);
    }
}
