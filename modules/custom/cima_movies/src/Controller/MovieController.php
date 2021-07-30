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
      $query = \Drupal::entityTypeManager()->getStorage('node');
      $conditions = $query->getQuery()
        ->condition('type', 'movie')
        ->condition('status', 1)
        ->execute();
      $data = $query->loadMultiple($conditions);
    } catch (\Exception $e) {
      throwException($e);
    }

    try {
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
    return array(
      '#theme' => 'movie_reservation',
      '#text' => 'Hello from movies reservation'
    );
  }
}

