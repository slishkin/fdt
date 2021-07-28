<?php

namespace Drupal\file_download_tracker\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class FileDownloadTrackerForm extends ConfigFormBase
{

  /**
  * {@inheritdoc}
  */
  public function getFormId() {
    return 'file_download_tracker_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Form constructor.
    $form = parent::buildForm($form, $form_state);
    // Default settings.
    $config = $this->config('file_download_tracker.settings');

    // Source text field.
    $form['pattern'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Inside Pattern for HTTP Referer'),
      '#default_value' => $config->get('file_download_tracker.pattern'),
      '#description' => $this->t('Specify regex line by line what counts as an internal download request.<br/>For example: http[s?]:\/\/sitename.*'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('file_download_tracker.settings');
    $config->set('file_download_tracker.pattern', $form_state->getValue('pattern'));
    \Drupal::state()->set('mbkk_fdt_pattern', $form_state->getValue('pattern'));
    $config->save();
    $this->messenger()->addStatus($this->t('Form settings have been saved'));
    return parent::submitForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'file_download_tracker.settings',
    ];
  }

}
