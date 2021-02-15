<?php

namespace App\Controller;

use App\Repository\PositionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */
class LandingController extends AbstractController
{
    /**
     * @Route("/", name="landing_index", methods={"GET"})
     */
    public function index(PositionRepository $positionRepository): Response
    {
        return $this->render('landing/index.html.twig', [
            'positions' => $positionRepository->githubFindPhpPaginated(),
        ]);
    }
}