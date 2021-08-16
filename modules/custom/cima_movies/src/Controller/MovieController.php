<?php

namespace Drupal\cima_movies\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class MovieController extends ControllerBase
{

  protected $fetchService;

  public function __construct($fetchService)
  {
    $this->fetchService = $fetchService;
  }

  public static function create(ContainerInterface $container)
  {
    return new static($container->get('cima_movies.custom_services'));
  }

  /**
   * Render Title, Description, Image of movies
   */
  public function list()
  {
    $contentData = [];
    try {
      $contentData = $this->fetchService->getServiceData('movie');
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
    $taxonomyData = $contentData = $listMovies =[];
    $dataGenre = \Drupal::request()->query->get('genreSelected');
    try {
      $taxonomyData = $this->fetchData->getTaxonomyTerms('genre');
      if (empty($dataGenre)) {
        $listMovies = $this->fetchData->getServiceData('movie');
        return array(
          '#theme' => 'movie_reservation',
          '#movies' => $listMovies,
          '#taxonomy' => $taxonomyData
        );
      }
      $contentData = $this->fetchData->getMoviesGenre($dataGenre);
      if (empty($contentData)){
        $contentData= $this->fetchData->getServiceData('movie');
      }
      foreach ($contentData as $data) {
        $json[] = array(
          'name' => $data->title->value,
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


