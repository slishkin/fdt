<?php

namespace Drupal\fdt_mbkk\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class FileDownloadTrackerForm extends ConfigFormBase
{

  /**
  * {@inheritdoc}
  */
  public function getFormId() {
    return 'fdt_mbkk_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Form constructor.
    $form = parent::buildForm($form, $form_state);
    // Default settings.
    $config = $this->config('fdt_mbkk.settings');

    if (!empty($config->get('fdt_mbkk.pattern'))){
      $default_pattern = $config->get('fdt_mbkk.pattern');
    }
    else{
      $host = \Drupal::request()->getHost();
      $default_pattern = 'https?:\/\/' . $host . '.*';
      \Drupal::state()->set('mbkk_fdt_pattern', $default_pattern);
    }

    // Source text field.
    $form['pattern'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Inside Pattern for HTTP Referer'),
      '#default_value' => $default_pattern ,
      '#description' => $this->t('Specify regex line by line what counts as an internal download request.<br/>For example: http[s?]:\/\/sitename.*'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('fdt_mbkk.settings');
    $config->set('fdt_mbkk.pattern', $form_state->getValue('pattern'));
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
      'fdt_mbkk.settings',
    ];
  }

}
