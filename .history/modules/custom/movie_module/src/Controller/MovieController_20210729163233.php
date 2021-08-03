<?php

namespace Drupal\movie_module\Controller;
use Drupal\node\Entity\Node;

/**
 * Render Title, Description, Image of movies
 */

class MovieController {
  public function list() :array
  {
    $query = \Drupal::entityTypeManager()->getStorage('node');
    $conditions = $query->getQuery()
                        ->condition('type', 'movie')
                        ->condition('status',1)
                        ->execute();
    $data = $query->loadMultiple($conditions);
      return array(
      '#theme' => 'movie_list',
      '#data' => $data
      );
  }
}

