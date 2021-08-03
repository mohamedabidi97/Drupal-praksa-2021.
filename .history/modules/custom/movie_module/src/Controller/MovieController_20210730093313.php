<?php

namespace Drupal\movie_module\Controller;
use Drupal\node\Entity\Node;

/**
 * Render Title, Description, Image of movies
 */

class MovieController {
  public function list() :array
  {
    $query =\Drupal::entityTypeManager()->getStorage('node')->getQuery();
    $nids = $query ->condition('type','movie')->execute();
    $nodes = \Drupal::entityTypeManager()->getStorage('node')->loadMultiple($nids);
      return array(
      '#theme' => 'movie_list',
      '#data' => $nodes
      );
  }
}

