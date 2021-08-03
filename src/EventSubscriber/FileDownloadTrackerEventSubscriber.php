<?php
/**
 * @file
 * Contains \Drupal\fdt_mbkk\FileDownloadTrackerEventSubscriber.
 */
namespace Drupal\fdt_mbkk\EventSubscriber;

use Drupal\fdt_mbkk\FileDownloadTracker;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\fdt_mbkk\Entity\FileDownloadEntity;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class FileDownloadTrackerEventSubscriber.
 *
 * @package Drupal\fdt_mbkk
 */
class FileDownloadTrackerEventSubscriber implements EventSubscriberInterface {
  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[FileDownloadTracker::SUBMIT][] = array('tracking', 800);
    return $events;
  }

  /**
   * Subscriber Callback for the event.
   * @param FileDownloadTracker $event
   */
  public function tracking(FileDownloadTracker $event) {
    $FileID = $event->getFileID();

    if (is_array($FileID)) $fid = reset($FileID);
    else $fid = $FileID;

    $database = \Drupal::database();
    $query = $database->select('file_usage', 'fu');
    $query->condition('fu.fid', $fid);
    $query->condition('fu.type', 'node');
    $query->fields('fu', ['id']);
    $query->range(0, 1);
    $source_id = $query->execute()->fetchField();

    if (!empty($source_id)){
      // To get the node id from last URL.
      $ref = $_SERVER['HTTP_REFERER'];
      if (empty($ref)) $ref = 'undefinde';
      // Get the URL without domain name.
      $req = Request::create($ref)->getRequestUri();
      // Get the node id from path alias.
      $path = \Drupal::service('path.alias_manager')->getPathByAlias($req);

      // To get the ip address of the system.
      $ip_address = \Drupal::request()->getClientIp();
      // Сheck the request is internal or external
      $inside = 0;
      $inside_pub = 0;
      $outside = 1;
      if ($pattern = \Drupal::state()->get('mbkk_fdt_pattern', '')){
        if (preg_match('/' . $pattern . '/', $ref)) {
          $inside = 1;
          $outside = 0;
          if ($pattern_second = \Drupal::state()->get('mbkk_fdt_pattern_second', '')){
            if (preg_match('/' . $pattern_second . '/', $ref)) {
              $inside = 0;
              $inside_pub = 1;
            }
          }
        }
      }
      // Get the current user id
      $user_id = \Drupal::currentUser()->id();
      // To save entity for Page.
      $file_download_entity_page = FileDownloadEntity::create([
        'entity_type' => 'page',
        'entity_id' => $source_id,
        'source_id' => $source_id,
        'ip_address' => $ip_address,
        'referer' => $ref,
        'inside' => $inside,
        'inside_pub' => $inside_pub,
        'outside' => $outside,
        'user_id' => $user_id,
      ]);
      $file_download_entity_page->save();
    }
    else{
      \Drupal::logger('fdt_mbkk')->error("The node to which the file FID = @fid is attached was not found.", array('@fid' => $fid));
    }
  }
}

