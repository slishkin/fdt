<?php

namespace Drupal\fdt_mbkk\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\AlertCommand;
use Drupal\Core\Ajax\OpenModalDialogCommand;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\webform\Entity\Webform;

class FdtmbkkContoller extends ControllerBase {

  public function getContent() {

    $webformid = 'help_un_desa';
    $webform = Webform::load($webformid);
    $title = $webform->label();
    $build['webform'] = [
      '#type' => 'webform',
      '#webform' => $webformid,
    ];
    $renderer = \Drupal::service('renderer');
    $rendered = $renderer->renderRoot($build);

    $content['#markup'] = $rendered;
    $content['#attached']['library'][] = 'core/drupal.dialog.ajax';
    $response = new AjaxResponse();
    $response->addCommand(new OpenModalDialogCommand($title, $content, ['dialogClass' => 'remindme']));
    return $response;
  }

}
