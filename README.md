[![Build Status](https://secure.travis-ci.org/jcisio/MediaWrapper.png?branch=master)](https://travis-ci.org/jcisio/MediaWrapper)

## Introduction ##

* Author: Hai-Nam Nguyen (jcisio)
* Homepage: https://github.com/jcisio/MediaWrapper
* Requires **PHP 5.3** or later (because namespace is used)
* It is used by Drupal modules like [Internet Sources field](http://drupal.org/project/isfield) or [Content Attachment](http://drupal.org/project/attach).

## Quick start ##

Example:

    include 'MediaWrapper/MediaWrapper.php';
    $m = MediaWrapper::getInstance()->getWrapper('http://www.youtube.com/watch?v=vyfzw09jjEo');
    // Print the thumbnail.
    print $m->thumbnail();
    // Print the full player.
    print $m->player();
    // Set default player options.
    $m->player_options(array('width' => '200', 'height' => '100'));
    // Print the full player again with new default options.
    print $m->player();
    // Override default options and print the full player.
    print $m->player(array('height' => '120'));

Test with PHPUnit:

    phpunit

or if you don't have PHPUnit:

    Composer install --dev
    vendor/phpunit/phpunit/phpunit.php Tests/MediaWrapperTest.php

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

### Responsive player ###

MediaWrapper in most cases uses the default player provided by each service. To make the player responsive (e.g. width = 100%), you can use CSS to make the iframe responsive. There are a lot of tutorial out there.

Another solution is to use the excellent and tiny [Fitvids JS](http://fitvidsjs.com/) jQuery plugin to make all videos responsive. It takes care of your CSS.

