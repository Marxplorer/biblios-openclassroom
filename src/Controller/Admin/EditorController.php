<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Editor;
use App\Form\EditorType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

final class EditorController extends AbstractController
{
    #[Route('/admin/editor', name: 'app_admin_editor')]
    public function index(): Response
    {
        return $this->render('admin/editor/index.html.twig', [
            'controller_name' => 'EditorController',
        ]);
    }
    #[Route('/admin/editor/new', name: 'app_admin_editor_new')]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $editor = new Editor();

        $form = $this->createForm(EditorType::class, $editor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($editor);
            $manager->flush();

            return $this->redirectToRoute('app_admin_editor');
        }

        return $this->render('admin/editor/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
