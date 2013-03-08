<?php
include 'MediaWrapper/MediaWrapper.php';
$m = MediaWrapper::getInstance()->getWrapper('http://www.youtube.com/watch?v=9bZkp7q19f0');
print $m->thumbnail() . "\n\n";
print $m->player() . "\n\n";
$m->player_options(array('width' => '200', 'height' => '100'));
print $m->player() . "\n\n";
print $m->player(array('height' => '120')) . "\n\n";

