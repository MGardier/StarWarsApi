<?php

namespace App\Controller;

use App\Service\StarWarsApiService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MoviesController extends AbstractController
{
  public function __construct(private readonly StarWarsApiService $starWarsApiService)
  {
  }



  /**
   * Get movie by request api and show data to user
   *
   * @return Response
   */
  #[Route('film/{id}', name: 'app_movie', requirements: ['id' => '\d+'])]
  public function show(int $id): Response
  {
    return $this->render('movies/show.html.twig', [
      'movie' => $this->starWarsApiService->getMovie($id),
    ]);
  }

  /**
   * Request api and show all data from movies  to user
   *
   * @return Response
   */
  #[Route('/films/', name: 'app_movies')]
  public function index(PaginatorInterface $paginator, Request $request): Response
  {

    $results = $this->starWarsApiService->getMovies();
    $pagination = $paginator->paginate(
      $results, /* tableau des résultats */
      $request->query->getInt('page', 1), /* numéro de page */
      5 /* limite par page */
    );
    return $this->render('movies/index.html.twig', [
      'pagination' => $pagination,
    ]);
  }
}
