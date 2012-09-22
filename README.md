## Introduction ##

* Author: Hai-Nam Nguyen (jcisio)
* Homepage: https://github.com/jcisio/MediaWrapper
* Requires **PHP 5.3** or later (because namespace is used)

## Quick start ##

Example:

    include 'MediaWrapper/MediaWrapper.php';
    $m = MediaWrapper::getInstance()->getWrapper('http://www.youtube.com/watch?v=vyfzw09jjEo');
    print $m->thumbnail();

See example.php for more examples.

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

