<?php
/**
 * @file
 * Youtube wrapper.
 */

namespace MediaWrapper\Wrapper;

abstract class Wrapper implements WrapperInterface {

  public static $detect;

  public static $allowed_options = array();

  // API keys
  protected $key;

  // Patterns to extract media ID from URL
  protected static $patterns;

  // Info about the current media
  protected $info;

  // Cache handler. It must be an object with set/get methods.
  protected $cache;

  // Options for the player
  protected $options = array(
    'mode' => 'auto',
    'width' => 560,
    'height' => 315,
  );

  function __construct($text) {
    foreach (self::$patterns as $pattern) {
      if (preg_match($pattern, $text, $match)) {
        $id = isset($match['id']) ? $match['id'] : $match[1];
        $this->info = array('id' => $id);
        break;
      }
    }

    $cache = function_exists('apc_fetch') && apc_store('apc_check', 1, -1) ? 'ApcCache' : 'ArrayCache';
    require_once __DIR__ . '/../Cache/' . $cache . '.php';
    $classname = '\MediaWrapper\Cache\\' . $cache;
    $this->cache = new $classname;
  }

  /**
   * Return a media info.
   */
  public function getInfo($key) {
    return @$this->info[$key];
  }

  /**
   * Fill default options.
   *
   * @param array $options
   * @param boolean $set
   *   Whether to set the $this->options value.
   *
   * @return
   *   Combined options array.
   */
  public function player_options(array $options, $set = TRUE) {
    $options = array_filter(array_merge($this->options, $options), function($var) {return !is_null($var);});

    if ($set) {
      $this->options = $options;
    }

    return $options;
  }

  /**
   * Set API keys.
   */
  public function setKey($key) {
    $this->key = $key;
  }

  /**
   * Set cache handler.
   */
  public function setCache($cache) {
    $this->cache = $cache;
  }
}

