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
    $data = [];
    try {
      $data = $this->fetchService->getServiceData('movie');
    } catch
    (\Exception $e) {
      throw new \Exception($e->getMessage());
    }
    return array(
      '#theme' => 'movie_list',
      '#data' => $data
    );
  }

  /**
   * Movies Reservation
   */
  public function reservation(): array
  {
    return array(
      '#theme' => 'movie_reservation',
    );
  }
}

