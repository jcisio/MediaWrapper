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
    $wrappers = array();
    foreach (glob(dirname(__FILE__) . '/Wrapper/*.php') as $filename) {
      require_once $filename;
      $wrappers[] = basename($filename, '.php');
    }

    // Loops through each wrapper to get the URL detect patterns.
    self::register($wrappers);
  }

  /**
   * Registers a list of wrappers.
   *
   * @param mixed $wrappers
   *   List of wrappers to registered. Pass an empty list to register all
   *   defined wrappers.
   */
  public static function register($wrappers = array()) {
    foreach (get_declared_classes() as $class) {
      if (preg_match('/^MediaWrapper\\\\Wrapper\\\\(\S+)$/', $class, $match)) {
        $name = $match[1];

        // We skip our abstract class
        if ($name === 'Wrapper') {
          continue;
        }

        // We skip also non specified classes.
        if ($wrappers && !in_array($name, $wrappers)) {
          continue;
        }

        if ($pattern = $class::$detect) {
          self::$wrappers[$name] = $pattern;
        }
      }
    }
  }

  /**
   * Removes one or more wrappers.
   *
   * It is useful because you want to make another wrapper for the same
   * pattern).
   *
   * @param mixed $name
   *   (optional) a wrapper or an array of wrapper. Pass an empty list to remove
   *   all wrappers.
   */
  public static function unregister($name = NULL) {
    if (!$name) {
      self::$wrappers = array();
    }
    else {
      if (!is_array($name)) {
        $name = array($name);
      }
      foreach ($name as $class) {
        unset(self::$wrappers[$class]);
      }
    }
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
  public static function getWrapper($text) {
    foreach (self::$wrappers as $name => $search) {
      if (preg_match($search, $text)) {
        $className = 'MediaWrapper\Wrapper\\' . $name;
        return new $className($text);
      }
    }
  }

}

