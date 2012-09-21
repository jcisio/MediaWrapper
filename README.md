## Introduction ##

* Author: Hai-Nam Nguyen (jcisio)
* Homepage: https://github.com/jcisio/MediaWrapper

## Quick start ##

Example:

    include 'MediaWrapper/MediaWrapper.php';
    $m = MediaWrapper::getInstance()->getWrapper('http://www.youtube.com/watch?v=vyfzw09jjEo');
    print $m->thumbnail();

See example.php for more examples.

