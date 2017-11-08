<?php
/**
 * @file
 * Dailymotion wrapper.
 */

namespace MediaWrapper\Wrapper;

class Dailymotion extends Wrapper {

  // Pattern to detect if an URL be longs to us
  public static $detect = '#(dailymotion\.com|dai\.ly)#';

  /**
   * {@inheritdoc}
   */
  public function __construct($text) {
    self::$patterns = array(
      '#https?://www\.dailymotion\.com/video/(?<id>[a-zA-Z0-9]{3,8})(_|$)#',
      '#https?://www\.dailymotion\.com/[a-z]+/video/(?<id>[a-zA-Z0-9]+)#',
      '#https?://dai\.ly/(?<id>[a-zA-Z0-9]+)#',
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

  /**
   * {@inheritdoc}
   */
  public function thumbnail($absolute = TRUE) {
    return ($absolute ? 'http:' : '') . '//www.dailymotion.com/thumbnail/video/' . $this->info['id'];
  }

  /**
   * {@inheritdoc}
   */
  public function url() {
    return 'https://www.dailymotion.com/video/' . $this->info['id'];
  }

  /**
   * {@inheritdoc}
   */
  public function player(array $options = array()) {
    $options = $this->player_options($options, FALSE);
    return '<iframe class="dailymotion-player" type="text/html" width="' . $options['width'] . '" height="' . $options['height'] . '" src="//www.dailymotion.com/embed/video/' . $this->info['id'] . '" frameborder="0"></iframe>';
  }

}
