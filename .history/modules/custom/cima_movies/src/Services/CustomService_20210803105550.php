<?php

namespace Drupal\cima_movies\Services;

use function PHPUnit\Framework\throwException;

/**
 * Class CustomService.
 */

class CustomService
{
  public function getServiceData($type)
  {
    try {
      $query = \Drupal::entityTypeManager()->getStorage('node');
      $conditions = $query->getQuery()
        ->condition('type', $type)
        ->condition('status', 1)
        ->execute();
      $data = $query->loadMultiple($conditions);
      if (!empty($data)) {
        return $data;
      }
    } catch (\Exception $e) {
      throwException($e);
    }
  }
}
