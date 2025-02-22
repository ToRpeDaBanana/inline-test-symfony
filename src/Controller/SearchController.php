<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route('/', name: 'search', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('search/index.html.twig');
    }

    #[Route('/search/results', name: 'search_results', methods: ['GET'])]
    public function search(Request $request, CommentRepository $commentRepository): Response
    {
        $query = trim($request->query->get('query', ''));

        if (strlen($query) < 3) {
            return $this->render('search/index.html.twig', ['error' => 'Введите минимум 3 символа.']);
        }

        $results = $commentRepository->searchByComment($query);

        return $this->render('search/results.html.twig', ['results' => $results, 'query' => $query]);
    }
}
