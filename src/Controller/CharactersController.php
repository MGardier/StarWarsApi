<?php

namespace App\Controller;

use App\Service\StarWarsApiService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CharactersController extends AbstractController
{
    public function __construct(private readonly StarWarsApiService $starWarsApiService)
    {
    }


    /**
     * Get character by request api and show data to user
     *
     * @return Response
     */
    #[Route('personnage/{id}', name: 'app_character', requirements: ['id' => '\d+'])]
    public function show(int $id): Response
    {
        return $this->render('characters/show.html.twig', [
            'character' => $this->starWarsApiService->getCharacter($id),
        ]);
    }

    /**
     * Request api and show all data from characters  to user
     *
     * @return Response
     */
    #[Route('/', name: 'app_characters')]
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $results = $this->starWarsApiService->getCharacters();

        $pagination = $paginator->paginate(
            $results, /* tableau des résultats */
            $request->query->getInt('page', 1), /* numéro de page */
            5 /* limite par page */
        );
        return $this->render('characters/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }
}
