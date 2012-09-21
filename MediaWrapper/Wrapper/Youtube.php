<?php
/**
 * @file
 * Youtube wrapper.
 */

namespace MediaWrapper\Wrapper;

class Youtube extends Wrapper {

  // Pattern to detect if an URL be longs to us
  public static $detect = '#(www\.youtube\.com|youtu\.be)/#';

  function __construct($text) {
    self::$patterns = array(
      '#http://youtu\.be/([a-zA-Z0-9_]+)#',
      '#http://www\.youtube\.com/\S+[\?&]v=([a-zA-Z0-9\-_]+)#',
    );

    $this->options += array(
      'wmode' => 'transparent',
    );

    parent::__construct($text);
  }

  function thumbnail() {
    return 'http://img.youtube.com/vi/'. $this->info['id'] .'/0.jpg';
  }

  function player(array $options = array()) {
    $this->player_options($options);
    switch ($this->options['mode']) {
      default:
        return '<iframe class="youtube-player" type="text/html" width="' . $this->options['width'] . '" height="' . $this->options['height'] . '" src="http://www.youtube.com/embed/' . $this->info['id'] . (isset($this->options['wmode']) ? '?wmode=' . $this->options['wmode'] : '') . '" frameborder="0"></iframe>';
    }
  }
}

