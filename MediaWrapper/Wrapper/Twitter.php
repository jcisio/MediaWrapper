<?php
/**
 * @file
 * Twitter wrapper.
 *
 * Reference: https://dev.twitter.com/docs/api/1/get/statuses/oembed
 */

namespace MediaWrapper\Wrapper;

class Twitter extends Wrapper {

  // Pattern to detect if an URL be longs to us
  public static $detect = '#(twitter\.com)/#';

  public static $allowed_options = array(
    'maxwidth',
    'hide_media',
    'hide_thread',
    'omit_script',
    'align',
    'related',
    'lang',
  );

  function __construct($text) {
    self::$patterns = array(
      '#https?://twitter\.com/[a-zA-Z0-9_]+/status/(?<id>\d+)#',
    );

    $this->options += array(
      'lang' => 'en',
    );

    parent::__construct($text);
  }

  function thumbnail($absolute = TRUE) {
    // Currently it is hard to return a thumbnail without using API 1.1 (that
    // requires OAuth authentication).
    return '';
  }

  function player(array $options = array()) {
    $options = $this->player_options($options, FALSE);
    $query = array_intersect_key($options, array_fill_keys(self::$allowed_options, 0));
    $query += array('id' => $this->info['id']);

    $url = 'https://api.twitter.com/1/statuses/oembed.json?' . http_build_query($query);
    $cache_id = md5($url);
    if (!$html = $this->cache->get($cache_id)) {
      $data = json_decode(file_get_contents($url));
      if ($data) {
        $html = $data->html;
        $this->cache->set($cache_id, $html);
      }
    }
    return $html;
  }
}

