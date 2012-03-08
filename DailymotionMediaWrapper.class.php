<?php
/**
 * @file
 * Dailymotion wrapper.
 */

class DailymotionMediaWrapper extends MediaWrapper {
  private static $patterns = array(
    '#http://www\.dailymotion\.com/video/([a-zA-Z0-9]+)_#',
    '#http://www\.dailymotion\.com/embed/video/([a-zA-Z0-9]+)#',
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
    return 'http://www.dailymotion.com/thumbnail/video/' . $this->info['id'];
  }

  function player($options = array()) {
    parent::player_options($options);
    switch ($options['mode']) {
      default:
        return '<iframe class="dailymotion-player" type="text/html" width="' . $options['width'] . '" height="' . $options['height'] . '" src="http://www.dailymotion.com/embed/video/' . $this->info['id'] . '" frameborder="0"></iframe>';
    }
  }
}

