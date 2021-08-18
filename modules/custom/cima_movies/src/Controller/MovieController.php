<?php

namespace Drupal\cima_movies\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;

class MovieController extends ControllerBase
{
  protected $fetchData;
  protected $request;

  public function __construct($fetchData, $request)
  {
    $this->fetchData = $fetchData;
    $this->request = $request;
  }

  public static function create(ContainerInterface $container)
  {
    return new static(
      $container->get('cima_movies.custom_services'),
      $container->get('request_stack')->getCurrentRequest()
    );
  }

  /**
   * Render Title, Description, Image of movies
   */
  public function list()
  {
    $contentData = [];
    try {
      $contentData = $this->fetchData->getServiceData('movie');
    } catch
    (\Exception $e) {
      throw new \Exception($e->getMessage());
    }
    return array(
      '#theme' => 'movie_list',
      '#data' => $contentData
    );
  }

  /**
   * Render genre terms in Movie reservation
   */
  public function reservation()
  {
    $allGenreTaxonomy = $contentData = $listMovies = [];
    $dataGenre = $this->request->get('genreSelected');
    try { 
      $allGenreTaxonomy = $this->fetchData->getTaxonomyTerms('genre');
      if (empty($dataGenre)) {
        $listMovies = $this->fetchData->getServiceData('movie');
        return array(
          '#theme' => 'movie_reservation',
          '#movies' => $listMovies,
          '#taxonomy' => $allGenreTaxonomy
        );
      }
      $contentData = $this->fetchData->getMoviesGenre($dataGenre);
      if (empty($contentData)){
        $contentData = $this->fetchData->getServiceData('movie');
      }
      foreach ($contentData as $data) {
        $json[] = array(
          'name' => $data->getTitle(),
          'description' => $data->field_description->value,
          'poster' => file_create_url($data ->field_image_movie->entity->getFileUri()),
          'days' => $this->fetchData->getNamebyId($data->get('field_days')->target_id),
          'genre' => $this->fetchData->getNamebyId($data->get('field_genre')->target_id)
        );
      }
      return new JsonResponse($json);
    } catch (\Exception $e) {
      throw new \Exception($e->getMessage());
    }
  }
}


