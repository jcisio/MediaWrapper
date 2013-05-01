## Introduction ##

* Author: Hai-Nam Nguyen (jcisio)
* Homepage: https://github.com/jcisio/MediaWrapper
* Requires **PHP 5.3** or later (because namespace is used)
* It is used by Drupal modules like [Internet Sources field](http://drupal.org/project/isfield) or [Content Attachment](http://drupal.org/project/attach).

## Quick start ##

Example:

    include 'MediaWrapper/MediaWrapper.php';
    $m = MediaWrapper::getInstance()->getWrapper('http://www.youtube.com/watch?v=vyfzw09jjEo');
    print $m->thumbnail();

See example.php for more examples.

Test with PHPUnit:

    Composer install --dev
    vendor/phpunit/phpunit/phpunit.php Tests/MediaWrapperTest.php

or simply

    phpunit

## Use cases ##

MediaWrapper is extensible.

### Write your own wrapper ###

You can look at the MediaWrapper/Wrapper folder for examples. Once you have
your wrapper, include that file and register that wrapper using

    MediaWrapper::getInstance()->register();

### Override the output ###

You can extend a wrapper, keep the pattern and override the player() function.
Do not forget to unregister the old wrapper so that only yours takes care of
that pattern.

