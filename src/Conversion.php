<?php
namespace Acme;

/**
 * My Conversion Class
 */
class Conversion
{
    protected $hex_table = [
        "0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "A", "B", "C", "D", "E", "F"
    ];

    protected $hex_bin_table = [
        "0" => "0000", "1" => "0001", "2" => "0010", "3" => "0011",
        "4" => "0100", "5" => "0101", "6" => "0110", "7" => "0111",
        "8" => "1000", "9" => "1001", "A" => "1010", "B" => "1011",
        "C" => "1100", "D" => "1101", "E" => "1110", "F" => "1111"
    ];


    public function dec_to_bin($decimal)
    {
        if ($decimal == 0) return "0";
        $binary = "";

        while ($decimal >= 1) {
            $binary = ($decimal % 2) . $binary;
            $decimal = (int) $decimal / 2;
        }

        return $binary;
    }

    public function dec_to_hex($decimal)
    {
        if ($decimal == 0) return "0";
        $hex = "";

        while ($decimal >= 1) {
            $hex = $this->hex_table[($decimal % 16)] . $hex;
            $decimal = (int) $decimal / 16;
        }

        return $hex;
    }

    public function hex_to_dec($hex)
    {
        $hex = str_split($hex);
        $power = count($hex) - 1;
        $dec = 0;

        foreach ($hex as $char) {
            $dec += ($this->find_dec_lookup($char) * (16 ** $power));
            $power--;
        }
        return $dec;
    }

    protected function find_dec_lookup($char)
    {
        for ($i=0; $i < count($this->hex_table); $i++) {
            if($this->hex_table[$i] == $char)
                return (int) $i;
        }
    }

    public function bin_to_dec($bin)
    {
        $bin = str_split($bin);
        $power = count($bin) - 1;
        $dec = 0;

        foreach ($bin as $char) {
            $dec += (int) $char * (2 ** $power);
            $power--;
        }
        return $dec;
    }

    public function hex_to_bin($hex)
    {
        $bin = "";
        $hex = str_split($hex);

        foreach ($hex as $char) {
            //$tmp = $this->dec_to_bin($this->find_dec_lookup($char));
            //$bin .= $this->add_leading_char($tmp, 4, "0");
            $bin .= sprintf('%04d', $this->dec_to_bin($this->find_dec_lookup($char)));
        }

        return $bin;
    }

    public function add_leading_char($input, $format, $leading_char)
    {
        //TODO exception format has to be higher
        $nb_of_chars_to_add = $format - strlen($input);

        for ($i=1; $i <= $nb_of_chars_to_add; $i++) {
            $input = $leading_char . $input;
        }

        return $input;
    }

    public function hex_to_bin_simple($hex)
    {
        $bin = "";
        $hex = str_split($hex);

        foreach ($hex as $char) {
            $bin .= $this->hex_bin_table[$char];
        }

        return $bin;
    }
}
