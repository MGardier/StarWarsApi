<?php

namespace App\Controller;

use App\Service\StarWarsApiService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StarshipsController extends AbstractController
{
  public function __construct(private readonly StarWarsApiService $starWarsApiService)
  {
  }

  /**
   * Get starship by request api and show data to user
   *
   * @return Response
   */
  #[Route('vaisseau/{id}', name: 'app_starship', requirements: ['id' => '\d+'])]
  public function show(int $id): Response
  {
    return $this->render('starships/show.html.twig', [
      'starship' => $this->starWarsApiService->getStarship($id),
    ]);
  }

  /**
   * Request api and show all data from starships  to user
   *
   * @return Response
   */
  #[Route('/vaisseaux/', name: 'app_starships')]
  public function index(PaginatorInterface $paginator, Request $request): Response
  {
    $results = $this->starWarsApiService->getStarships();
    $pagination = $paginator->paginate(
      $results, /* tableau des résultats */
      $request->query->getInt('page', 1), /* numéro de page */
      5 /* limite par page */
    );
    return $this->render('starships/index.html.twig', [
      'pagination' => $pagination,
    ]);
  }
}
