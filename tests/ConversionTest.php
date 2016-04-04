<?php
namespace Tests;

require 'vendor/autoload.php';

use Acme\Conversion as Conversion;

class ConversionTest extends \PHPUnit_Framework_TestCase
{

    public function testDecToBin()
    {
        $conversion = new Conversion();

        $this->assertEquals(decbin(1), $conversion->dec_to_bin(1));

        $this->assertEquals(decbin(99), $conversion->dec_to_bin(99));

        $this->assertEquals(decbin(0), $conversion->dec_to_bin(0));

        $this->assertEquals(decbin(64), $conversion->dec_to_bin(64));

        $this->assertEquals(decbin(512), $conversion->dec_to_bin(512));

        $this->assertEquals(decbin(77868426984269842), $conversion->dec_to_bin(77868426984269842));
    }

    public function testDecToHex()
    {
        $conversion = new Conversion();

        $this->assertEquals(dechex(1), $conversion->dec_to_hex(1));

        $this->assertEquals(dechex(99), $conversion->dec_to_hex(99));

        $this->assertEquals(dechex(0), $conversion->dec_to_hex(0));

        $this->assertEquals(dechex(64), $conversion->dec_to_hex(64));

        $this->assertEquals(dechex(512), $conversion->dec_to_hex(512));

    }

    public function testHexToDec()
    {
        $conversion = new Conversion();

        $this->assertEquals(hexdec("BC"), $conversion->hex_to_dec("BC"));

        $this->assertEquals(hexdec("399"), $conversion->hex_to_dec("399"));

        $this->assertEquals(hexdec("A2DE"), $conversion->hex_to_dec("A2DE"));

    }

    public function testBinToDec()
    {
        $conversion = new Conversion();

        $this->assertEquals(bindec("0"), $conversion->bin_to_dec("0"));

        $this->assertEquals(bindec("1"), $conversion->bin_to_dec("1"));

        $this->assertEquals(bindec("1010101"), $conversion->bin_to_dec("1010101"));

        $this->assertEquals(bindec("1111111"), $conversion->bin_to_dec("1111111"));

        $this->assertEquals(bindec("1111110101010111"), $conversion->bin_to_dec("1111110101010111"));

    }

    public function testHexToBin()
    {
        // We add ltrim because base_convert php don't show leading 0
        
        $conversion = new Conversion();
        $this->assertEquals(base_convert("70", 16, 2), $conversion->hex_to_bin("70"));
        $this->assertEquals(base_convert("70C558", 16, 2), ltrim($conversion->hex_to_bin("70C558"), 0));

        // hex_to_bin alternative lookup array
        $this->assertEquals(base_convert("70", 16, 2), $conversion->hex_to_bin_simple("70"));
        $this->assertEquals(base_convert("70C558", 16, 2), ltrim($conversion->hex_to_bin_simple("70C558"), 0));


    }
}
