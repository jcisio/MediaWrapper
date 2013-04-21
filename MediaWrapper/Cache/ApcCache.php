<?php
/**
 * @file
 * Cache using APC.
 */

namespace MediaWrapper\Cache;

class ApcCache {

  protected $prefix = 'mediawrapper:';

  public function get($id) {
    return apc_fetch($this->prefix . $id);
  }

  public function set($id, $value) {
    apc_store($this->prefix . $id, $value);
  }

}

