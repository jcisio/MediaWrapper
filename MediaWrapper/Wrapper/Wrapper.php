<?php
/**
 * @file
 * Youtube wrapper.
 */

namespace MediaWrapper\Wrapper;

abstract class Wrapper implements WrapperInterface {

  public static $detect;

  // API keys
  protected $key;

  // Patterns to extract media ID from URL
  protected static $patterns;

  // Info about the current media
  protected $info;

  // Options for the player
  protected $options = array(
    'mode' => 'auto',
    'width' => 560,
    'height' => 315,
  );

  function __construct($text) {
    foreach (self::$patterns as $pattern) {
      if (preg_match($pattern, $text, $match)) {
        $this->info = array('id' => $match[1]);
        return;
      }
    }
  }

  /**
   * Return a media info.
   */
  public function getInfo($key) {
    return @$this->info[$key];
  }

  /**
   * Fill default options.
   */
  public function player_options(array $options) {
    if (empty($options)) {
      $options = array();
    }
    foreach ($options as $key => $value) {
      if ($value === NULL) {
        unset($this->options[$key]);
      }
      else {
        $this->options[$key] = $value;
      }
    }
  }

  /**
   * Set API keys.
   */
  public function setKey($key) {
    $this->key = $key;
  }
}

