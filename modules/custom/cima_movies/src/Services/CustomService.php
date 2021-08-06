<?php

namespace Drupal\cima_movies\Services;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class CustomService.
 */
class CustomService
{
  protected $entityTypeManager;

  public function __contruct($entityTypeManager)
  {
    $this->entityTypeManager = $entityTypeManager;
  }

  public static function create(ContainerInterface $container)
  {
    return new static($container->get('entity_type.manager'));
  }

  public function getServiceData($type)
  {
    try {
      $query = $this->entityTypeManager()->getStorage('node');
      $conditions = $query->getQuery()
        ->condition('type', $type)
        ->condition('status', 1)
        ->execute();
      $data = $query->loadMultiple($conditions);
      return $data;
    } catch (\Exception $e) {
      throw new \Exception($e->getMessage());
    }
  }
  public function getTaxonomyTerms($vid)
  {
    try {
      $data = $this->entityTypeManager()->getStorage('taxonomy_term')->loadByProperties(['vid' => $vid]);
      return $data;
    } catch (\Exception $e) {
      throw new \Exception($e->getMessage());
    }
  }
}
