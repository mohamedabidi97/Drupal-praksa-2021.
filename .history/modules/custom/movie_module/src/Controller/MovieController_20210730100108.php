<?php

namespace Drupal\movie_module\Controller;

use Drupal\node\Entity\Node;
use mysql_xdevapi\Exception;

/**
 * Render Title, Description, Image of movies
 */

class MovieController
{
  public function list(): array
  {
    try {
      $query = \Drupal::entityTypeManager()->getStorage('node');
      $conditions = $query->getQuery()
        ->condition('type', 'movie')
        ->condition('status', 1)
        ->execute();
      $data = $query->loadMultiple($conditions);
    } catch (Exception $e) {
      echo 'Caught exception: ', $e->getMessage(), "\n";
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
}

