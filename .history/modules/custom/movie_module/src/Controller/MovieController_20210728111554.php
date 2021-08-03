<?php

namespace Drupal\movie_module\Controller;
use Drupal\Core\Controller\ControllerBase;
/**
 * An example controller.
 */
class MovieController extends ControllerBase {
 /*Example 
  public function page() {
    $items = array(
      array('name' => 'Movie one'),
      array('name' => 'Movie two'),
      array('name' => 'Movie three'),
      array('name' => 'Movie four'),
    );
    return array(
      // Your theme hook name.
      '#theme' => 'movie_list',
      // Your variables.
      '#items' => $items,
      '#title' => 'Our movies list'
    );
  }

}
