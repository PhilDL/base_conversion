<?php

require 'vendor/autoload.php';

$conversion = new Tools\Conversion();

echo $conversion->dec_to_bin(99);

echo PHP_EOL;

echo $conversion->dec_to_hex(99);

echo PHP_EOL;

echo $conversion->hex_to_dec("A2DE");

echo PHP_EOL;

echo $conversion->bin_to_dec("1010101");

echo PHP_EOL;

echo $conversion->hex_to_bin("70C558");

echo PHP_EOL;
