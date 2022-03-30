<?php

namespace Drupal\cap_monitor\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;

class DrupalRequestController extends ControllerBase {

  /**
   * @var \Symfony\Component\HttpFoundation\Request|null
   */
  protected $request;

  /**
   * @var string
   */
  protected $acsfSiteUrl;

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('request_stack')
    );
  }

  public function __construct(RequestStack $requestStack) {
    $this->request = $requestStack->getCurrentRequest()->request;
  }

  public function post() {
    $action = $this->request->get('action');
    $this->acsfSiteUrl = $this->request->get('acsfSiteUrl');
    $this->findSite();
    $data = [];
    if (preg_match('/Launch/', $action)) {
      $data = $this->launchSite($this->request->get('vhostUrl'));
    }

    if (preg_match('/Minimal/', $action)) {
      $data = $this->enableMinimalTheme();
    }

    if (preg_match('/Search/', $action)) {
      $data = $this->blockSearchEngines();
    }

    if (preg_match('/Role/', $action)) {
      $data = $this->grantAdminRole($this->request->get('adminUsername'));
    }

    if (preg_match('/maintenance/', $action)) {
      $data = $this->disableMaintenanceMode();
    }
    return new JsonResponse($data);
  }

  protected function launchSite($vhost) {
    return FALSE;
  }

  protected function enableMinimalTheme() {
    return FALSE;
  }

  protected function blockSearchEngines() {
    return FALSE;
  }

  protected function grantAdminRole($username) {
    return FALSE;
  }

  protected function disableMaintenanceMode() {
    return FALSE;
  }

  protected function findSite() {
    preg_match('/\/\/([a-z0-9]+)\.sites\.stanford\.edu/', $this->acsfSiteUrl, $matches);
    if ($matches) {
      return $matches[1];
    }


  }

}
