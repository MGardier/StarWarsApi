<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

enum TypeReturnData
{
  case ITEM;
  case COLLECTION;
}

enum TypeData
{
  case CHARACTER;
  case MOVIE;
  case PLANET;
  case STARSHIP;
  case VEHICLE;
}

class StarWarsApiService
{
  public function __construct(private  HttpClientInterface $httpClient)
  {
    $this->httpClient = $httpClient->withOptions(['base_uri' => 'https://swapi.dev/api/']);
  }

  /* ----------------------- GETTERS FUNCTIONS ---------------------------------------------------------- */

  /**
   * Get all characters from api
   * @return array
   */
  public function getCharacters(): array
  {
    return $this->makeRequest(TypeReturnData::COLLECTION, TypeData::CHARACTER);
  }

  /**
   * Get one character from api by id
   *
   * @param integer $id
   * @return array
   */
  public function getCharacter(int $id): array
  {
    return $this->makeRequest(TypeReturnData::ITEM, TypeData::CHARACTER, $id);
  }

  /**
   * Get all movies from api
   * @return array
   */
  public function getMovies(): array
  {
    return $this->makeRequest(TypeReturnData::COLLECTION, TypeData::MOVIE);
  }

  /**
   * Get one movie from api by id
   *
   * @param integer $id
   * @return array
   */
  public function getMovie(int $id): array
  {
    return $this->makeRequest(TypeReturnData::ITEM, TypeData::MOVIE, $id);
  }

  /**
   * Get all characters from api
   * @return array
   */
  public function getPlanets(): array
  {
    return $this->makeRequest(TypeReturnData::COLLECTION, TypeData::PLANET);
  }

  /**
   * Get one planet from api by id
   *
   * @param integer $id
   * @return array
   */
  public function getPlanet(int $id): array
  {
    return $this->makeRequest(TypeReturnData::ITEM, TypeData::PLANET, $id);
  }

  /**
   * Get all starships from api
   * @return array
   */
  public function getStarships(): array
  {
    return $this->makeRequest(TypeReturnData::COLLECTION, TypeData::STARSHIP);
  }

  /**
   * Get one starship from api by id
   *
   * @param integer $id
   * @return array
   */
  public function getStarship(int $id): array
  {
    return $this->makeRequest(TypeReturnData::ITEM, TypeData::STARSHIP, $id);
  }

  /**
   * Get all vehicles from api
   * @return array
   */
  public function getVehicles(): array
  {
    return $this->makeRequest(TypeReturnData::COLLECTION, TypeData::VEHICLE);
  }

  /**
   * Get one vehicle from api by id
   *
   * @param integer $id
   * @return array
   */
  public function getVehicle(int $id): array
  {
    return $this->makeRequest(TypeReturnData::ITEM, TypeData::VEHICLE, $id);
  }


  /* ----------------------- GETTERS FUNCTIONS ---------------------------------------------------------- */




  /* ----------------------- REQUEST FUNCTIONS ---------------------------------------------------------- */


  /**
   * This function execute the request to api and return data in array
   *
   * @param TypeReturnData $typeReturnData
   * @param TypeData $typeData
   * @param integer|null $id
   * @return array
   */
  private function makeRequest(TypeReturnData $typeReturnData, TypeData $typeData, ?int $id = null): array
  {
    $endpoints = $this->getEndpoints($typeReturnData, $typeData, $id);
    $response = $this->httpClient->request(
      'GET',
      $endpoints
    );



    $data = match ($typeReturnData) {
      TypeReturnData::ITEM => $response->toArray(),
      TypeReturnData::COLLECTION => $response->toArray()['results'],
    };
    return $data;
  }




  /**
   * This function get endpoints for request api by specifiy 
   * which data we want , 
   * which type of data we want to get 
   * and id if  we needed
   *
   * @param TypeReturnData $typeReturnData
   * @param TypeData $typeData
   * @param integer|null $id
   * @return string  $endpoints
   */
  private function getEndpoints(TypeReturnData $typeReturnData, TypeData $typeData, ?int $id): string
  {
    $endpoints = match ($typeData) {
      TypeData::CHARACTER => 'people/',
      TypeData::MOVIE => 'films/',
      TypeData::PLANET => 'planets/',
      TypeData::STARSHIP => 'starships/',
      TypeData::VEHICLE => 'vehicles/',
    };

    if ($typeReturnData === TypeReturnData::ITEM && $id !== null) {
      $endpoints .= $id;
    }

    return $endpoints;
  }


  /* ----------------------- END OF REQUEST FUNCTIONS ---------------------------------------------------------- */
}
