<?php

namespace Drupal\fdt_mbkk;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Routing\LinkGeneratorTrait;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of File download entity entities.
 *
 * @ingroup fdt_mbkk
 */
class FileDownloadEntityListBuilder extends EntityListBuilder {

  use LinkGeneratorTrait;

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('File download entity ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\fdt_mbkk\Entity\FileDownloadEntity */
    $row['id'] = $entity->id();
    $row['name'] = $this->l(
      $entity->label(),
      new Url(
        'entity.file_download_entity.edit_form', array(
          'file_download_entity' => $entity->id(),
        )
      )
    );
    return $row + parent::buildRow($entity);
  }

}
