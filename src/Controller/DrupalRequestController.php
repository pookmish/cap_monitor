<?php

namespace Drupal\cap_monitor\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;

class DrupalRequestController extends ControllerBase {

  public function post() {

    $this->getLogger('cap_monitor')->info(var_export(\Drupal::request()->request, true));
    return new JsonResponse(['foo' => 'bar']);
  }

}
