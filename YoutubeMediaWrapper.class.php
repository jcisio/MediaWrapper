<?php
/**
 * @file
 * Youtube wrapper.
 */

class YoutubeMediaWrapper extends MediaWrapper {
  private static $patterns = array(
    '#http://youtu\.be/([a-zA-Z0-9_]+)#',
    '#http://www\.youtube\.com/watch\?v=([a-zA-Z0-9_]+)#',
  );
  function __construct($text) {
    foreach (self::$patterns as $pattern) {
      if (preg_match($pattern, $text, $match)) {
        parent::__construct(array('v' => $match[1]));
        return;
      }
    }
  }
  function thumbnail() {
    return 'http://img.youtube.com/vi/'. $this->info['v'] .'/0.jpg';
  }
}

