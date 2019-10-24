<?php
/**
 * @file
 * PHPUnit tests for MediaWrapper.
 */

class MediaWrapperTest extends \PHPUnit\Framework\TestCase {

  public function assertImageUrl($url) {
    $size = getimagesize($url);
    $this->assertTrue(is_array($size));
    $this->assertArrayHasKey('mime', $size);
    $this->assertStringStartsWith('image/', $size['mime']);
  }

  public function testYoutube() {
    $m = MediaWrapper::getInstance()->getWrapper('http://www.youtube.com/watch?v=EJEBGf_uS_M');
    $this->assertImageUrl($m->thumbnail());

    $m = MediaWrapper::getInstance()->getWrapper('http://www.youtube.com/watch?v=9bZkp7q19f0');
    $this->assertEquals('http://img.youtube.com/vi/9bZkp7q19f0/maxresdefault.jpg', $m->thumbnail());
    $this->assertEquals('https://www.youtube.com/watch?v=9bZkp7q19f0', $m->url());
    $this->assertEquals('//img.youtube.com/vi/9bZkp7q19f0/maxresdefault.jpg', $m->thumbnail(FALSE));
    $this->assertImageUrl($m->thumbnail());
    $this->assertEquals('<iframe class="youtube-player" type="text/html" width="560" height="315" src="//www.youtube.com/embed/9bZkp7q19f0?wmode=transparent" frameborder="0"></iframe>', $m->player());

    $m->player_options(array('width' => '200', 'height' => '100'));
    $this->assertEquals('<iframe class="youtube-player" type="text/html" width="200" height="100" src="//www.youtube.com/embed/9bZkp7q19f0?wmode=transparent" frameborder="0"></iframe>', $m->player());

    // Now pass directly the options
    $this->assertEquals('<iframe class="youtube-player" type="text/html" width="400" height="200" src="//www.youtube.com/embed/9bZkp7q19f0?wmode=transparent&autoplay=1" frameborder="0"></iframe>', $m->player(array('width' => '400', 'height' => '200', 'autoplay' => 1)));

    // Test if options are overriden by the last passed option.
    $this->assertEquals('<iframe class="youtube-player" type="text/html" width="200" height="100" src="//www.youtube.com/embed/9bZkp7q19f0?wmode=transparent" frameborder="0"></iframe>', $m->player());

    // Test with extra data on the url.
    $m = MediaWrapper::getInstance()->getWrapper('http://www.youtube.com/watch?feature=player_embedded&v=IdioCTTwdw8');
    $this->assertImageUrl($m->thumbnail());

    // Test with title.
    $this->assertEquals('How to install Facebook Home on your Android phone', $m->title());
  }

  public function testYoutubeSpecial() {
    $m = MediaWrapper::getInstance()->getWrapper('http://youtu.be/f620pz-Dyk0');
    $this->assertEquals('http://img.youtube.com/vi/f620pz-Dyk0/maxresdefault.jpg', $m->thumbnail());
    $this->assertImageUrl($m->thumbnail());

    $m = MediaWrapper::getInstance()->getWrapper('https://www.youtube.com/watch?feature=player_embedded&amp;v=9bZkp7q19f0');
    $this->assertEquals('9bZkp7q19f0', $m->getInfo('id'));
  }

  public function testDailymotion() {
    $m = MediaWrapper::getInstance()->getWrapper('http://www.dailymotion.com/video/x1mun8');
    $this->assertEquals('x1mun8', $m->getInfo('id'));
    $this->assertEquals('https://www.dailymotion.com/video/x1mun8', $m->url());

    $m = MediaWrapper::getInstance()->getWrapper('http://www.dailymotion.com/video/6pU29dPYNlqCLbwiw');
    $this->assertInstanceOf('MediaWrapper\Wrapper\Dailymotion', $m);
    $this->assertEquals('x1mun8', $m->getInfo('id'));

    $m = MediaWrapper::getInstance()->getWrapper('http://dai.ly/x1mun8');
    $this->assertInstanceOf('MediaWrapper\Wrapper\Dailymotion', $m);
    $this->assertEquals('x1mun8', $m->getInfo('id'));

    $m = MediaWrapper::getInstance()->getWrapper('http://www.dailymotion.com/video/x4xvnz_the-funny-crash-compilation_fun');
    $this->assertEquals('x4xvnz', $m->getInfo('id'));
  }

  public function testVimeo() {
    $m = MediaWrapper::getInstance()->getWrapper('http://vimeo.com/56488043');
    $this->assertImageUrl($m->thumbnail());
    $this->assertEquals('http://i.vimeocdn.com/video/515444387_640.jpg', $m->thumbnail());
    $this->assertEquals('https://vimeo.com/56488043', $m->url());
    $this->assertEquals('//i.vimeocdn.com/video/515444387_640.jpg', $m->thumbnail(FALSE));
    $this->assertEquals('<iframe class="vimeo-player" type="text/html" width="560" height="315" src="//player.vimeo.com/video/56488043?byline=0&portrait=0" frameborder="0"></iframe>', $m->player());
  }

  public function testInstagram() {
    $m = MediaWrapper::getInstance()->getWrapper('http://instagram.com/p/Batz8EDlmR8');
    $this->assertImageUrl($m->thumbnail());
    $this->assertEquals('https://instagram.com/p/Batz8EDlmR8', $m->url());
    $this->assertContains('class="instagram-media"', $m->player());
  }

  public function testCacheSystem() {
    require __DIR__ . '/RandomWrapper.php';
    MediaWrapper::register(array('RandomWrapper'));
    $m = MediaWrapper::getInstance()->getWrapper('http://test.com/1982');
    $value1 = $m->player();
    $value2 = $m->player();
    $this->assertEquals($value1, $value2, 'Test if data is fetched from cache.');
  }

}
