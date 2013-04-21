<?php
/**
 * @file
 * Array cache, not very useful.
 *
 * This is primarily used for testing.
 */

namespace MediaWrapper\Cache;

class ArrayCache {

  private $cache = array();

  public function get($id) {
    return @$this->cache[$id];
  }

  public function set($id, $value) {
    $this->cache[$id] = $value;
  }

}

