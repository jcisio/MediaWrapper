<?php
/**
 * @file
 * PHPUnit tests for MediaWrapper.
 */

class MediaWrapperTest extends PHPUnit_Framework_TestCase {
  function __construct() {
    include_once __DIR__ . '/../MediaWrapper/MediaWrapper.php';
  }

  public function testYoutube() {
    $m = MediaWrapper::getInstance()->getWrapper('http://www.youtube.com/watch?v=9bZkp7q19f0');
    $this->assertEquals('http://img.youtube.com/vi/9bZkp7q19f0/0.jpg', $m->thumbnail());
    $this->assertEquals('<iframe class="youtube-player" type="text/html" width="560" height="315" src="http://www.youtube.com/embed/9bZkp7q19f0?wmode=transparent" frameborder="0"></iframe>', $m->player());

    $m->player_options(array('width' => '200', 'height' => '100'));
    $this->assertEquals('<iframe class="youtube-player" type="text/html" width="200" height="100" src="http://www.youtube.com/embed/9bZkp7q19f0?wmode=transparent" frameborder="0"></iframe>', $m->player());
  }

  public function testVimeo() {
    $m = MediaWrapper::getInstance()->getWrapper('http://vimeo.com/56488043');
    $this->assertEquals('http://b.vimeocdn.com/ts/391/133/391133096_640.jpg', $m->thumbnail());
    $this->assertEquals('<iframe class="vimeo-player" type="text/html" width="560" height="315" src="http://player.vimeo.com/video/56488043?title=0&amp;byline=0&amp;portrait=0" frameborder="0"></iframe>', $m->player());
  }
}

