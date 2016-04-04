<?php

require 'vendor/autoload.php';

$conversion = new Acme\Conversion();

echo $conversion->dec_to_bin(77868426984269842);

echo "\r\n";
echo $conversion->dec_to_hex(45);
echo "\r\n";

echo base_convert("70C558", 16, 2);
