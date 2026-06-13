<?php
$w = (int)($_GET['w'] ?? 800);
$h = (int)($_GET['h'] ?? 600);
$text = $_GET['text'] ?? 'Property Image';
$img = imagecreatetruecolor($w, $h);
$bg = imagecolorallocate($img, 30, 30, 46);
$accent = imagecolorallocate($img, 201, 168, 76);
$white = imagecolorallocate($img, 255, 255, 255);
imagefill($img, 0, 0, $bg);
imagestring($img, 5, ($w/2)-strlen($text)*4, $h/2-8, $text, $accent);
header('Content-Type: image/png');
imagepng($img);
imagedestroy($img);
