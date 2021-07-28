<?php

namespace Drupal\fdt_mbkk;

use Symfony\Component\EventDispatcher\Event;

/**
 * Class FileDownloadTracker.
 *
 * @package Drupal\fdt_mbkk.
 */
class FileDownloadTracker extends Event {
  protected $fileID;
  const SUBMIT = 'event.submit';

  /**
   * {@inheritdoc}
   */
  public function __construct($fileID) {
    $this->fileID = $fileID;
  }

  /**
   * {@inheritdoc}
   */
  public function getFileID() {
    return $this->fileID;
  }

}
