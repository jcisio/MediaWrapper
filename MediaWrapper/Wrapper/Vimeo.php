<?php
/**
 * @file
 * Vimeo wrapper.
 */

namespace MediaWrapper\Wrapper;

class Vimeo extends Wrapper {

  // Pattern to detect if an URL be longs to us
  public static $detect = '#vimeo\.com#';

  function __construct($text) {
    self::$patterns = array(
      '#http://vimeo.com/([0-9]+)#',
    );

    parent::__construct($text);
  }

  function thumbnail() {
    $data = unserialize(file_get_contents('http://vimeo.com/api/v2/video/' . $this->info['id'] . '.php'));
    return $data[0]['thumbnail_large'];
  }

  function player(array $options = array()) {
    $this->player_options($options);
    switch ($this->options['mode']) {
      default:
        return '<iframe class="vimeo-player" type="text/html" width="' . $this->options['width'] . '" height="' . $this->options['height'] . '" src="http://player.vimeo.com/video/' . $this->info['id'] . '?title=0&amp;byline=0&amp;portrait=0" frameborder="0"></iframe>';
    }
  }
}

