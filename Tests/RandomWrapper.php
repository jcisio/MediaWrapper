<?php
namespace MediaWrapper\Wrapper;

class RandomWrapper extends Wrapper {
  // Pattern to detect if an URL be longs to us
  public static $detect = '#(test\.com)/#';

  public static $allowed_options = array(
    'lang',
  );

  function __construct($text) {
    self::$patterns = array(
      '#https?://test\.com/(\d+)#',
    );

    parent::__construct($text);
  }

  function thumbnail($absolute = TRUE) {
    return '';
  }

  function player(array $options = array()) {
    $cache_id = 'random:' . $this->info['id'] . ':' . serialize($options);
    if (!$result = $this->cache->get($cache_id)) {
      $result = rand(1, 1000000);
      $this->cache->set($cache_id, $result);
    }
    return $result;
  }
}

