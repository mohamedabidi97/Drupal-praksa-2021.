<?php

namespace Drupal\movie_module\Controller;

use mysql_xdevapi\Exception;
use function PHPUnit\Framework\throwException;

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
}