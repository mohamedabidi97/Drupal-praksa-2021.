<?php

namespace Drupal\movie_module\Controller;

use Drupal;
/**
 * Render Title, Description, Image of movies
 */
class MovieController {
  public function list() :array
  {
    $ids = Drupal::entityQuery('node')
      ->condition('type', 'movie')
      ->execute();

    $nodes = Drupal::entityTypeManager()
            ->getStorage('node')
            ->loadMultiple($ids);

      return [
      '#theme' => 'movie_list',
      '#data' => $nodes
    ];
  }
}
