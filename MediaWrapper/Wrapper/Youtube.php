<?php
/**
 * @file
 * Youtube wrapper.
 *
 * Reference: https://developers.google.com/youtube/player_parameters
 */

namespace MediaWrapper\Wrapper;

class Youtube extends Wrapper {

  // Pattern to detect if an URL be longs to us
  public static $detect = '#(www\.youtube(-nocookie)?\.com|youtu\.be)/#';

  public static $allowed_options = array(
    'wmode',
    'autoplay',
    'cc_load_policy',
    'color',
    'controls',
    'disablekb',
    'enablejsapi',
    'end',
    'fs',
    'hl',
    'iv_load_policy',
    'list',
    'listType',
    'loop',
    'modestbranding',
    'origin',
    'playerapiid',
    'playlist',
    'playsinline',
    'rel',
    'showinfo',
    'start',
    'theme',
  );

  /**
   * {@inheritdoc}
   */
  public function __construct($text) {
    self::$patterns = array(
      '#https?://youtu\.be/(?<id>[a-zA-Z0-9\-_]+)#',
      '#https?://www\.youtube(-nocookie)?\.com/\S+[\?&;]v=(?<id>[a-zA-Z0-9\-_]+)#',
    );

    $this->options += array(
      'wmode' => 'transparent',
    );

    parent::__construct($text);
  }

  /**
   * {@inheritdoc}
   */
  public function thumbnail($absolute = TRUE) {
    $url = 'http://img.youtube.com/vi/'. $this->info['id'] .'/maxresdefault.jpg';

    if (function_exists('curl_init')) {
      $handle = curl_init($url);
      curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
      curl_exec($handle);
      $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
      curl_close($handle);

      if ($httpCode == 404) {
        // Use the mq instead of hq thumbnail to keep the same aspect ratio (16:9)
        // with maxres thumbnail.
        $url = 'http://img.youtube.com/vi/'. $this->info['id'] .'/mqdefault.jpg';
      }
    }

    return $absolute ? $url : substr($url, 5);
  }

  /**
   * {@inheritdoc}
   */
  public function title() {
    $url = 'https://www.youtube.com/watch?v=' . $this->getInfo('id');
    if (!$data = file_get_contents($url)) {
      return '';
    }

    if (function_exists('mb_convert_encoding') && class_exists('DOMDocument')) {
      // DOMDocument does not work well with UTF-8, we need to use HTML entities
      // to be safe.
      $data = mb_convert_encoding($data, 'HTML-ENTITIES', 'UTF-8');
      $dom = new \DOMDocument();
      $dom->preserveWhiteSpace = FALSE;
      @$dom->loadHTML($data);

      foreach ($dom->getElementsByTagName('meta') as $meta) {
        if ($meta->getAttribute('name') == 'title') {
          return $meta->getAttribute('content');
        }
      }
    }

    return '';
  }

  /**
   * {@inheritdoc}
   */
  public function url() {
    return 'https://www.youtube.com/watch?v=' . $this->info['id'];
  }

  /**
   * {@inheritdoc}
   */
  public function player(array $options = array()) {
    $options = $this->player_options($options, FALSE);
    $query = array_intersect_key($options, array_fill_keys(self::$allowed_options, 0));

    return '<iframe class="youtube-player" type="text/html" width="' . $options['width'] . '" height="' . $options['height'] . '" src="//www.youtube.com/embed/' . $this->info['id'] . ($query ? '?' . http_build_query($query) : ''). '" frameborder="0"></iframe>';
  }

}
