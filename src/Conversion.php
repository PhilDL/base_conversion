<?php
namespace Tools;

/**
 * Conversion class
 *
 * Conversion contient différentes functions de conversion entre différent
 * systèmes de numérations, plus précisément ici binaire (base 2),
 * décimal (base 10) et hexadecimal (base 16)
 * @package Acme
 * @author Philippe L'ATTENTION <philippe.lattention@hotmail.fr>
 * @version 1.0
 */
class Conversion
{
    protected $hex_table = [
        "0", "1", "2", "3", "4", "5", "6", "7",
        "8", "9", "A", "B", "C", "D", "E", "F"
    ];

    protected $bin_table = [
        "0", "1"
    ];

    protected $hex_bin_table = [
        "0" => "0000", "1" => "0001", "2" => "0010", "3" => "0011",
        "4" => "0100", "5" => "0101", "6" => "0110", "7" => "0111",
        "8" => "1000", "9" => "1001", "A" => "1010", "B" => "1011",
        "C" => "1100", "D" => "1101", "E" => "1110", "F" => "1111"
    ];


    /**
     * Convertit un décimal en binaire
     * @param  Integer  $decimal
     * @return String   binaire
     */
    public function dec_to_bin($decimal)
    {
        return $this->dec_to_base_rc($decimal, $this->bin_table, 2);
    }


    /**
     * Convertit un décimal en hexadécimal
     * @param  Integer  $decimal
     * @return String   hexadécimal
     */
    public function dec_to_hex($decimal)
    {
        return $this->dec_to_base_rc($decimal, $this->hex_table, 16);
    }


    /**
     * Convertit un binaire en décimal
     * @param  String   $bin   binaire
     * @return Integer  décimal
     */
    public function bin_to_dec($bin)
    {
        return $this->base_to_dec($bin, $this->bin_table, 2);
    }

    /**
     * Convertit un hexadécimal en décimal
     * @param  String   $hex   hexadécimal
     * @return Integer  décimal
     */
    public function hex_to_dec($hex)
    {
        return $this->base_to_dec($hex, $this->hex_table, 16);
    }


    /**
     * Fonction générique permettant de convertir un décimal vers une
     * autre base. La fonction prend en paramètres la base de conversion
     * (2, 16, etc.) et les symbols de la base visée et concatène à l'envers
     * les symbols pour avoir la chaine complète.
     *
     * @param  Integer   $decimal
     * @param  Array     $symbols  contient les symbols de la base visée
     * @param  Integer   $base
     * @return String    $out
     */
    public function dec_to_base($decimal, array $symbols, $base)
    {
        $out = "";

        while ($decimal >= $base) {
            $out = $symbols[($decimal % $base)] . $out;
            $decimal = (int) $decimal / $base;
        }
        $out = $symbols[($decimal)] . $out;

        return $out;
    }


    /**
     * Version recursive du while de la function dec_to_base. La concaténation
     * se fait automatiquement en "sens" inverse grace à de la récursivitée.
     *
     * @param  Integer   $decimal
     * @param  Array     $symbols  contient les symbols de la base visée.
     * @param  Integer   $base
     * @param  String    $out      chaine formée récursivement.
     * @return String    $out
     */
    public function dec_to_base_rc($decimal, array $symbols, $base, $out ="")
    {
        if ($decimal < $base)
        	return $out .= $symbols[$decimal];
        else
        	return $this->dec_to_base_rc((int)$decimal/$base, $symbols, $base, $out) . $symbols[($decimal % $base)];
    }


    /**
     * Fonction permettant de transformer un input d'une base donnée vers
     * un décimal. La fonction regarde l'équivalent du symbole en décimal grace
     * à son index, et le multiplie par la base à la puissance décrémentée.
     *
     * @param  String    $input
     * @param  Array     $symbols  contient les symbols de la base visée.
     * @param  Integer   $base
     * @return String    $dec      décimal
     */
    public function base_to_dec($input, array $symbols, $base)
    {
        $input  = str_split($input);
        $power  = count($input) - 1;
        $dec    = 0;

        foreach ($input as $char) {
            $dec += ($this->find_dec_lookup_in($char, $symbols) * ($base ** $power));
            $power--;
        }
        return $dec;
    }


    /**
     * Retourne l'index dans le tableau de base du char en entrée correspondant
     * au décimal
     *
     * @param  String   $char
     * @param  Array    $symbols
     * @return Integer  indice correspondant au décimal
     */
    public function find_dec_lookup_in($char, array $symbols)
    {
        for ($i=0; $i < count($symbols); $i++) {
            if($symbols[$i] == $char)
                return (int) $i;
        }
    }


    /**
     * Fonction qui retourne le binaire correspondant à l'hexadécimal en
     * allant chercher dans un tableau de mapping l'équivalant décimal du
     * hex pour le convertir en binaire.
     *
     * @param  String   $hex
     * @return String   binaire
     */
    public function hex_to_bin($hex)
    {
        $bin = "";
        $hex = str_split($hex);

        foreach ($hex as $char) {
            //$tmp = $this->dec_to_bin($this->find_dec_lookup($char));
            //$bin .= $this->add_leading_char($tmp, 4, "0"); // version sans sprintf
            $bin .= sprintf('%04d', $this->dec_to_bin($this->find_dec_lookup_in($char, $this->hex_table)));
        }

        return $bin;
    }


    /**
     * Remplace la fonction sprintf() si jamais on n'a pas le droit de l'utiliser
     * Permet formatter une chaine sur un nombre donné de caractères en la "comblant"
     * avec le char voulu.
     *
     * @param  String    $input
     * @param  Integer   $format         longueur de la chaine retournée qu'on doit remplir
     * @param  String    $leading_char   char avec lequel la chaine est comblée
     * @return String                    chaine formatée
     */
    public function add_leading_char($input, $format, $leading_char)
    {
        //TODO exception format has to be higher
        $nb_of_chars_to_add = $format - strlen($input);

        for ($i=1; $i <= $nb_of_chars_to_add; $i++) {
            $input = $leading_char . $input;
        }

        return $input;
    }


    /**
     * Fonction hex_to_bin plus simple regardant juste un tableau de correspondance
     * hexadecimal => binaire
     *
     * @param  String    $hex
     * @return String    binaire
     */
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
