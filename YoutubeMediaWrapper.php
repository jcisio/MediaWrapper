<?php
/**
 * @file
 * Youtube wrapper.
 */

class YoutubeMediaWrapper extends MediaWrapper {
  private static $patterns = array(
    '#http://youtu\.be/([a-zA-Z0-9_]+)#',
    '#http://www\.youtube\.com/\S+[\?&]v=([a-zA-Z0-9\-_]+)#',
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
    return 'http://img.youtube.com/vi/'. $this->info['id'] .'/0.jpg';
  }
  public static function player_options(&$options) {
    if (empty($options)) {
      $options = array();
    }
    $options += array(
      'wmode' => 'transparent',
    );
    parent::player_options($options);
  }

  function player($options = array()) {
    $this->player_options($options);
    switch ($options['mode']) {
      default:
        return '<iframe class="youtube-player" type="text/html" width="' . $options['width'] . '" height="' . $options['height'] . '" src="http://www.youtube.com/embed/' . $this->info['id'] . (isset($options['wmode']) ? '?wmode=' . $options['wmode'] : '') . '" frameborder="0"></iframe>';
    }
  }
}

