<?php

namespace Drupal\cima_movies\Controller;

use function PHPUnit\Framework\throwException;


class MovieController
{
  /**
   * Render Title, Description, Image of movies
   */

  public function list(): array
  {
    try {
      $data = \Drupal::service('cima_movies.custom_services')->getServiceData('movie');
      return array(
        '#theme' => 'movie_list',
        '#data' => $data
      );
    } catch (\Exception $e) {
      throwException($e);
    }
  }

  /**
   * Movies Reservation
   */

  public function reservation(): array
  {
    $data = \Drupal::service('cima_movies.custom_services')->getServiceData('movie');
    return array(
      '#theme' => 'movie_reservation',
      '#data' => $data
    );
  }
}

