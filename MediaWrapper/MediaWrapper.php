<?php
/**
 * @file
 * Internet resource thumbnailer and player.
 * @author
 * Hai-Nam Nguyen aka jcisio
 */

class MediaWrapper {

  // List of wrappers with their URL detect patterns.
  private static $wrappers = array();

  // Our unique instance (singleton).
  private static $instance = NULL;

  function __construct() {
    require_once 'Wrapper/WrapperInterface.php';
    require_once 'Wrapper/Wrapper.php';

    // Loads all wrappers
    foreach (glob(dirname(__FILE__) . '/Wrapper/*.php') as $filename) {
      require_once $filename;
    }

    // Loops through each wrapper to get the URL detect patterns.
    self::register();
  }

  // Scan and register all wrapper.
  public function register() {
    foreach (get_declared_classes() as $class) {
      if (preg_match('/^MediaWrapper\\\\Wrapper\\\\(\S+)$/', $class, $match)) {
        $name = $match[1];

        // We skip our abstract class
        if ($name === 'Wrapper') {
          continue;
        }

        if ($pattern = $class::$detect) {
          self::$wrappers[$name] = $pattern;
        }
      }
    }
  }

  // Removes a wrapper (because you want to make another wrapper for the same
  // pattern).
  public function unregister($name) {
    unset(self::$wrappers[$name]);
  }

  public static function getInstance() {
    if (!isset(self::$instance)) {
      self::$instance = new MediaWrapper();
    }
    return self::$instance;
  }

  /**
   * Get the specific wrapper for a media.
   *
   * @param string $text
   *   Any string that can be used to detect the resource (url, shortened url,
   *   embedded code...)
   */
  public function getWrapper($text) {
    foreach (self::$wrappers as $name => $search) {
      if (preg_match($search, $text)) {
        $className = 'MediaWrapper\Wrapper\\' . $name;
        return new $className($text);
      }
    }
  }

}

