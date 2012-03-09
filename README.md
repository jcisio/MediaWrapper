## Introduction ##

* Author: Hai-Nam Nguyen (jcisio)
* Homepage: https://github.com/jcisio/MediaWrapper

## Quick start ##

Example:

    include 'MediaWrapper/MediaWrapper.class.php';
    $m = MediaWrapper::getWrapper('http://www.youtube.com/watch?v=vyfzw09jjEo');
    print $m->thumbnail();
    print $m->player();