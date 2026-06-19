<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BookController extends AbstractController
{
    #[Route('/admin/book', name: 'app_admin_book', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('admin/book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    #[Route('/admin/book/new', name: 'app_admin_book_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $book = new Book();

        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $coverFile = $form->get('coverImage')->getData();

            if ($coverFile) {
                $newFilename = uniqid().'.'.$coverFile->guessExtension();

                $coverFile->move(
                    $this->getParameter('kernel.project_dir').'/public/uploads/covers',
                    $newFilename
                );

                $book->setCoverImage($newFilename);
            }

            $manager->persist($book);
            $manager->flush();

            return $this->redirectToRoute('app_admin_book');
        }

        return $this->render('admin/book/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/book', name: 'app_book_index', methods: ['GET'])]
    public function publicIndex(BookRepository $repository, Request $request): Response
    {
        $queryBuilder = $repository
            ->createQueryBuilder('b')
            ->orderBy('b.editedAt', 'DESC');

        $pager = new Pagerfanta(
            new QueryAdapter($queryBuilder)
        );

        $pager->setMaxPerPage(6);
        $pager->setCurrentPage($request->query->getInt('page', 1));

        return $this->render('book/index.html.twig', [
            'pager' => $pager,
        ]);
    }

    #[Route('/book/{id}', name: 'app_book_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function publicShow(?Book $book): Response
    {
        return $this->render('book/show.html.twig', [
            'book' => $book,
        ]);
    }
}