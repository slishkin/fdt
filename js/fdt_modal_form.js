(function ($, Drupal, drupalSettings) {

  'use strict';

  Drupal.behaviors.fdtModalForm = {
    attach: function (context, settings) {
      $('.pubfile .publications a', context).click(function () {
        var endpoint = Drupal.url('fdt/openform');
        Drupal.ajax({ url: endpoint }).execute();
      });

      $(".help-us-form-remind", context).on('click', (function (e) {
        e.preventDefault();
        $(".help-us-form-remind-wrapper", context).toggleClass('hidden');
      }));
    }
  }

} (jQuery, Drupal, drupalSettings));
