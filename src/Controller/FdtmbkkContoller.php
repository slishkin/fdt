<?php

namespace Drupal\fdt_mbkk\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\AlertCommand;
use Drupal\Core\Ajax\OpenModalDialogCommand;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class FdtmbkkContoller extends ControllerBase {

  public function getContent() {

    $webformid = 'help_un_desa';

    $build['webform'] = [
      '#type' => 'webform',
      '#webform' => $webformid,
    ];

    $renderer = \Drupal::service('renderer');
    $rendered = $renderer->renderRoot($build);

    $content['#markup'] = $rendered;
    $content['#attached']['library'][] = 'core/drupal.dialog.ajax';
    $title = 'Help UN DESA - Publication Download Survey';
    $response = new AjaxResponse();
    $response->addCommand(new OpenModalDialogCommand($title, $content, ['width' => '400', 'height' => '400']));
    return $response;
  }

}
