<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MenuController extends AbstractController
{
    #[Route('/admin/menu', name: 'app_admin_menu')]
    public function index(): Response
    {
        return $this->render('Admin/menu/index.html.twig', [
            'controller_name' => 'MenuController',
        ]);
    }
}
