(function ($, Drupal, drupalSettings) {

  'use strict';

  Drupal.behaviors.fdtModalForm = {
    attach: function (context, settings) {
      $('.pubfile a', context).click(function () {
        var endpoint = Drupal.url('fdt/openform');
        Drupal.ajax({ url: endpoint }).execute();
      });
    }
  }

} (jQuery, Drupal, drupalSettings));
