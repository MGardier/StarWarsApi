<?php

namespace App\Controller;

use App\Service\StarWarsApiService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlanetsController extends AbstractController
{
  public function __construct(private readonly StarWarsApiService $starWarsApiService)
  {
  }

  /**
   * Get planet by request api and show data to user
   *
   * @return Response
   */
  #[Route('planete/{id}', name: 'app_planet', requirements: ['id' => '\d+'])]
  public function show(int $id): Response
  {
    return $this->render('planets/show.html.twig', [
      'planet' => $this->starWarsApiService->getPlanet($id),
    ]);
  }

  /**
   * Request api and show all data from planets  to user
   *
   * @return Response
   */
  #[Route('/planetes/', name: 'app_planets')]
  public function index(PaginatorInterface $paginator, Request $request): Response
  {

    $results = $this->starWarsApiService->getPlanets();
    $pagination = $paginator->paginate(
      $results, /* tableau des résultats */
      $request->query->getInt('page', 1), /* numéro de page */
      5 /* limite par page */
    );
    return $this->render('planets/index.html.twig', [
      'pagination' => $pagination,
    ]);
  }
}
