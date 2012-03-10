<?php
/**
 * @file
 * Vimeo wrapper.
 */

class VimeoMediaWrapper extends MediaWrapper {
  private static $patterns = array(
    '#http://vimeo.com/([0-9]+)#',
  );
  function __construct($text) {
    foreach (self::$patterns as $pattern) {
      if (preg_match($pattern, $text, $match)) {
        parent::__construct(array('id' => $match[1]));
        return;
      }
    }
  }
  function thumbnail() {
    $data = unserialize(file_get_contents('http://vimeo.com/api/v2/video/' . $this->info['id'] . '.php'));
    return $data[0]['thumbnail_large'];
  }

  function player($options = array()) {
    parent::player_options($options);
    switch ($options['mode']) {
      default:
        return '<iframe class="vimeo-player" type="text/html" width="' . $options['width'] . '" height="' . $options['height'] . '" src="http://player.vimeo.com/video/' . $this->info['id'] . '?title=0&amp;byline=0&amp;portrait=0" frameborder="0"></iframe>';
    }
  }
}

