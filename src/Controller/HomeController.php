<?php

namespace App\Controller;

use App\Repository\RappelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(RappelRepository $rappelRepository): Response
    {
        $rappels = $rappelRepository->findByDateToday();

        return $this->render('home/index.html.twig', [
            'rappels' => $rappels,
        ]);
    }
}
