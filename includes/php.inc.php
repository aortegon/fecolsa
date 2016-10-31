<?php

function puts($puts) {
    echo '<pre>';
    print_r($puts);
    echo '</pre>';
}

function def(&$var, $default = null) {
    $var = isset($var) ? $var : $default;
    return $var;
}

function get_month($month) {
    switch ((int) $month) :
        case 1 :
            return 'Enero';
        case 2 :
            return 'Febrero';
        case 3 :
            return 'Marzo';
        case 4 :
            return 'Abril';
        case 5 :
            return 'Mayo';
        case 6 :
            return 'Junio';
        case 7 :
            return 'Julio';
        case 8 :
            return 'Agosto';
        case 9 :
            return 'Septiembre';
        case 10 :
            return 'Octubre';
        case 11 :
            return 'Noviembre';
        case 12 :
            return 'Diciembre';
    endswitch;
}

function get_monthdays($year, $month) {
    switch ((int) $month) :
        case 1 :
            return 31;
        case 2 :
            return $year % 4 === 0 ? 29 : 28;
        case 3 :
            return 31;
        case 4 :
            return 30;
        case 5 :
            return 31;
        case 6 :
            return 30;
        case 7 :
            return 31;
        case 8 :
            return 31;
        case 9 :
            return 30;
        case 10 :
            return 31;
        case 11 :
            return 30;
        case 12 :
            return 31;
    endswitch;
}

function encrypt($str) {
    return strrev(md5($str));
}

function capitalize($str, $all = true) {
    return $all === true ? ucwords(strtolower($str)) : ucfirst(strtolower($str));
}