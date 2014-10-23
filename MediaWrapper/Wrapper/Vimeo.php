<?php
/**
 * @file
 * Vimeo wrapper.
 *
 * Reference: http://developer.vimeo.com/player/embedding
 */

namespace MediaWrapper\Wrapper;

class Vimeo extends Wrapper {

  // Pattern to detect if an URL be longs to us
  public static $detect = '#vimeo\.com#';

  public static $allowed_options = array(
    'title',
    'byline',
    'portrait',
    'color',
    'autoplay',
    'loop',
  );

  function __construct($text) {
    self::$patterns = array(
      '#https?://vimeo.com/(?<id>[0-9]+)#',
      '#https?://vimeo.com/channels/.*?/(?<id>[0-9]+)#',
      '#https?://vimeo.com/groups/.*?/videos/(?<id>[0-9]+)#',
    );

    $this->options += array(
      'byline' => 0,
      'portrait' => 0,
    );

    parent::__construct($text);
  }

  function thumbnail($absolute = TRUE) {
    $data = unserialize(file_get_contents('http://vimeo.com/api/v2/video/' . $this->info['id'] . '.php'));
    $thumbnail = $absolute ? $data[0]['thumbnail_large'] : preg_replace('/^[a-z]+:/', '', $data[0]['thumbnail_large']);
    return $thumbnail;
  }

  function player(array $options = array()) {
    $options = $this->player_options($options, FALSE);
    $query = array_intersect_key($options, array_fill_keys(self::$allowed_options, '0'));

    switch ($this->options['mode']) {
      default:
        return '<iframe class="vimeo-player" type="text/html" width="' . $options['width'] . '" height="' . $options['height'] . '" src="//player.vimeo.com/video/' . $this->info['id'] . '?' . http_build_query($query) . '" frameborder="0"></iframe>';
    }
  }
}

