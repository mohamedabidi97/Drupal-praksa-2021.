<?php

namespace Drupal\cima_movies\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
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
    $content_data = [];
    try {
      $content_data = $this->fetchService->getServiceData('movie');
    } catch
    (\Exception $e) {
      throw new \Exception($e->getMessage());
    }
    return array(
      '#theme' => 'movie_list',
      '#data' => $content_data
    );
  }

  /**
   * Render genre terms in Movie reservation
   */
  public function reservation()
  {
    $taxonomy_data = [];
    try {
      $taxonomy_data = $this->$this->fetchService->getTaxonomyTerms('genre');
    } catch
    (\Exception $e) {
      throw new \Exception($e->getMessage());
    }
    return array(
      '#theme' => 'movie_reservation',
      '#data' => $taxonomy_data
    );
  }
}


