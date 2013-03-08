<?php
/**
 * @file
 * PHPUnit tests for MediaWrapper.
 */

include __DIR__ . '/../vendor/autoload.php';

class MediaWrapperTest extends PHPUnit_Framework_TestCase {
  function __construct() {
    include_once __DIR__ . '/../MediaWrapper/MediaWrapper.php';
  }

  public function testYoutube() {
    $m = MediaWrapper::getInstance()->getWrapper('http://www.youtube.com/watch?v=vyfzw09jjEo');
    $this->assertEquals('http://img.youtube.com/vi/vyfzw09jjEo/0.jpg', $m->thumbnail());
    $this->assertEquals('<iframe class="youtube-player" type="text/html" width="560" height="315" src="http://www.youtube.com/embed/vyfzw09jjEo?wmode=transparent" frameborder="0"></iframe>', $m->player());

    $m->player_options(array('width' => '200', 'height' => '100'));
    $this->assertEquals('<iframe class="youtube-player" type="text/html" width="200" height="100" src="http://www.youtube.com/embed/vyfzw09jjEo?wmode=transparent" frameborder="0"></iframe>', $m->player());
  }
}

