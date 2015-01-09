<?php
/**
 * @file
 * Instagram wrapper.
 *
 * Reference: http://instagram.com/developer/embedding/
 */

namespace MediaWrapper\Wrapper;

class Instagram extends Wrapper {

  // Pattern to detect if an URL be longs to us
  public static $detect = '#(instagram\.com|instagr\.am)/p/#';

  function __construct($text) {
    self::$patterns = array(
      '#https?://(instagram\.com|instagr\.am)/p/(?<id>[a-zA-Z0-9\-_]+)#',
    );

    parent::__construct($text);
  }

  function thumbnail($absolute = TRUE) {
    $url = 'http://instagram.com/p/' . $this->info['id'] .'/media/';

    if (function_exists('curl_init')) {
      $handle = curl_init($url);
      curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($handle, CURLOPT_NOBODY, TRUE);
      curl_exec($handle);
      $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
      if ($httpCode == 302) {
        $url = curl_getinfo($handle, CURLINFO_REDIRECT_URL);
      }
      curl_close($handle);
    }

    return $absolute ? $url : substr($url, 5);
  }

  function player(array $options = array()) {
    $options = $this->player_options($options, FALSE);
    $query = array_intersect_key($options, array_fill_keys(self::$allowed_options, 0));
    $query += array('url' => 'http://instagr.am/p/' . $this->info['id']);

    $url = 'http://api.instagram.com/oembed?' . http_build_query($query);
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
