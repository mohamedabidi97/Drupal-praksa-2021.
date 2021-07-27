<?php
/**
 * @file
 * Contains \Drupal\movie_module\Controller\MovieController
 * Class controllerBase : https://bit.ly/3kWzk4d
 */

namespace Drupal\movie_module\Controller;
use Drupal\Core\Controller\ControllerBase;


/**
 * An example controller.
 */

class MovieController extends ControllerBase
{


    public function content() :array
    {
      return [
        '#theme' => 'movie_page',
        '#test_var' => $this->t('Test Test'),
      ];
    }

}
