<?php

namespace Drupal\cima_movies\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use function PHPUnit\Framework\throwException;

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
    try {
      $data = $this->fetchService->getServiceData('movie');
      return array(
        '#theme' => 'movie_list',
        '#data' => $data
      );
    } catch
    (\Exception $e) {
      throwException($e);
    }
  }

  /**
   * Movies Reservation
   */
  public function reservation(): array
  {
    $data = $this->fetchService->getServiceData('movie');
    return array(
      '#theme' => 'movie_reservation',
      '#data' => $data
    );
  }
}

