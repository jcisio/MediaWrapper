<?php
/**
 * @file
 * Internet resource thumbnailer and player.
 * @author
 * Hai-Nam Nguyen aka jcisio
 */

class MediaWrapper {
  public $info = array();
  protected static $players = array(
    'Youtube' => '#(www\.youtube\.com|youtu\.be)/#',
    'Dailymotion' => '#dailymotion\.com#',
  );

  function __construct($info) {
    $this->info = $info;
  }

  /**
   * Get the specific wrapper for a media.
   *
   * @param string $text
   *   Any string that can be used to detect the resource (url, shortened url,
   *   embedded code...)
   */
  public static function getWrapper($text) {
    foreach (self::$players as $name => $search) {
      if (preg_match($search, $text)) {
        $className = $name . 'MediaWrapper';
        require_once $className . '.class.php';
        $wrapper = new $className($text);
        $wrapper->info['provider'] = $name;
        return $wrapper;
      }
    }
  }
}

