<?php
/**
 * @file
 * Dailymotion wrapper.
 */

namespace MediaWrapper\Wrapper;

class Dailymotion extends Wrapper {

  // Pattern to detect if an URL be longs to us
  public static $detect = '#dailymotion\.com#';

  function __construct($text) {
    self::$patterns = array(
      '#http://www\.dailymotion\.com/video/([a-zA-Z0-9]+)_#',
      '#http://www\.dailymotion\.com/[a-z]+/video/([a-zA-Z0-9]+)#',
    );

    parent::__construct($text);
  }

  function thumbnail() {
    return 'http://www.dailymotion.com/thumbnail/video/' . $this->info['id'];
  }

  function player(array $options = array()) {
    $options = $this->player_options($options, FALSE);
    switch ($this->options['mode']) {
      default:
        return '<iframe class="dailymotion-player" type="text/html" width="' . $options['width'] . '" height="' . $options['height'] . '" src="http://www.dailymotion.com/embed/video/' . $this->info['id'] . '" frameborder="0"></iframe>';
    }
  }
}

