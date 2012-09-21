<?php
include 'MediaWrapper/MediaWrapper.php';
$m = MediaWrapper::getInstance()->getWrapper('http://www.youtube.com/watch?v=vyfzw09jjEo');
print $m->thumbnail() . "\n\n";
print $m->player() . "\n\n";
$m->player_options(array('width' => '200', 'height' => '100'));
print $m->player() . "\n\n";

