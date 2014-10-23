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
      '#http://www\.dailymotion\.com/video/(?<id>[a-zA-Z0-9]+)_#',
      '#http://www\.dailymotion\.com/[a-z]+/video/(?<id>[a-zA-Z0-9]+)#',
    );

    parent::__construct($text);

    if (!($this->info)) {
      $pattern = '#http://www\.dailymotion\.com/video/([a-zA-Z0-9]+)#';
      if (preg_match($pattern, $text, $match)) {
        $long_id = $match[1];
        $url = 'https://api.dailymotion.com/video/' . $long_id;
        $cache_id = md5($url);
        if (!$data = $this->cache->get($cache_id)) {
          $data = json_decode(file_get_contents($url));
          if ($data) {
            $this->cache->set($cache_id, $data);
          }
        }
        $this->info = array('id' => $data->id);
      }
    }
  }

  function thumbnail($absolute = TRUE) {
    return ($absolute ? 'http:' : '') . '//www.dailymotion.com/thumbnail/video/' . $this->info['id'];
  }

  function player(array $options = array()) {
    $options = $this->player_options($options, FALSE);
    switch ($this->options['mode']) {
      default:
        return '<iframe class="dailymotion-player" type="text/html" width="' . $options['width'] . '" height="' . $options['height'] . '" src="//www.dailymotion.com/embed/video/' . $this->info['id'] . '" frameborder="0"></iframe>';
    }
  }
}
