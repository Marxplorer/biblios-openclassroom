<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class GreatController extends AbstractController
{
    #[Route('/great', name: 'app_great')]
    public function index(): Response
    {
        return $this->render('great/index.html.twig', [
            'controller_name' => 'GreatController',
        ]);
    }
}
