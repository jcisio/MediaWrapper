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
  public static $detect = '#(www\.youtube\.com|youtu\.be)/#';

  public static $allowed_options = array(
    'wmode',
    'autoplay',
    'cc_load_policy',
    'controls',
    'loop',
    'showinfo',
    'start',
    'theme',
  );

  function __construct($text) {
    self::$patterns = array(
      '#https?://youtu\.be/([a-zA-Z0-9\-_]+)#',
      '#https?://www\.youtube\.com/\S+[\?&]v=([a-zA-Z0-9\-_]+)#',
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
    $options = $this->player_options($options, FALSE);
    $query = array_intersect_key($options, array_fill_keys(self::$allowed_options, 0));

    switch ($options['mode']) {
      default:
        return '<iframe class="youtube-player" type="text/html" width="' . $options['width'] . '" height="' . $options['height'] . '" src="http://www.youtube.com/embed/' . $this->info['id'] . ($query ? '?' . http_build_query($query) : ''). '" frameborder="0"></iframe>';
    }
  }
}

