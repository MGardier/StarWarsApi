<?php

namespace App\Controller;

use App\Service\StarWarsApiService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VehiclesController extends AbstractController
{
  public function __construct(private readonly StarWarsApiService $starWarsApiService)
  {
  }

  /**
   * Get vehicle by request api and show data to user
   *
   * @return Response
   */
  #[Route('vehicule/{id}', name: 'app_vehicle', requirements: ['id' => '\d+'])]
  public function show(int $id): Response
  {
    return $this->render('vehicles/show.html.twig', [
      'vehicle' => $this->starWarsApiService->getVehicle($id),
    ]);
  }

  /**
   * Request api and show all data from vehicles  to user
   *
   * @return Response
   */
  #[Route('/vehicules/', name: 'app_vehicles')]
  public function index(PaginatorInterface $paginator, Request $request): Response
  {
    $results = $this->starWarsApiService->getVehicles();

    $pagination = $paginator->paginate(
      $results, /* tableau des résultats */
      $request->query->getInt('page', 1), /* numéro de page */
      5 /* limite par page */
    );
    return $this->render('vehicles/index.html.twig', [
      'pagination' => $pagination,
    ]);
  }
}
