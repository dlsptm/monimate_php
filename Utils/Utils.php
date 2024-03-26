<?php

namespace App\Utils;

class Utils
{
    static public function debug($error)
    {
        $format = '<pre>' . $error . '</pre>';
        return $format;
    }

    static public function numberFormat($number)
    {
        // Formate le number avec deux décimales
        $number_formate = number_format($number, 2);

        // Vérifie si les deux derniers caractères sont "00"
        if (substr($number_formate, -2) == "00") {
            // Si oui, retourner le number entier
            return intval($number);
        } else {
            // Sinon, retourner le number avec les décimales
            return $number_formate;
        }
    }
}
