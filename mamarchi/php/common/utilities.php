<?php

namespace Utilities;

class Utilities {

    public static function checkCounter(&$counter, &$tabIndex) {
        if ($counter > 0) {
            $counter = 0;
            $tabIndex++;
        }
    }

    public static function validazione($input, $value, &$page) {
        $page = str_replace("*" . $input['id'] . "*", $_POST[$input['id']], $page);
        if (!preg_match($input['regexp'], $value)) {
            $page = str_replace("*error" . $input['id'] . "*", '<p class="col4 error">' . $input['output'] . '</p>', $page);
            return false;
        } else {
            $page = str_replace("*error" . $input['id'] . "*", '', $page);
            return true;
        }
    }

    public static function checkData($giorno, $mese, $anno) {
        $data = $anno . '-' . $mese . '-' . $giorno;
        if (preg_match('/^[1|2][0-9]{3,3}-([1-9]|1[0|1|2])-([1-9]|[1|2][0-9]|3[0|1])$/', $data)) {
            if ($giorno == 31 && ($mese == 4 || $mese == 6 || $mese == 9 || $mese == 11))
                return false;
            if ($giorno > 29 && $mese == 2)
                return false;
            if ($giorno == 29 && $mese == 2 && !($anno % 4 == 0 && ($anno % 100 != 0 || $anno % 400 == 0)))
                return false;
            return true;
        }
        return false;
    }

    public static function checkBoundLimit($element, $min, $max) {
        return $min <= $element && $element <= $max;
    }

    public static function getMonthName($n) {
        switch ($n) {
            case 1:
                return "Gennaio";
            case 2:
                return "Febbraio";
            case 3:
                return "Marzo";
            case 4:
                return "Aprile";
            case 5:
                return "Maggio";
            case 6:
                return "Giugno";
            case 7:
                return "Luglio";
            case 8:
                return "Agosto";
            case 9:
                return "Settembre";
            case 10:
                return "Ottobre";
            case 11:
                return "Novembre";
            case 12:
                return "Dicembre";
        }
    }

    public static function checkEmptyInput($input, &$page) {
        if (!isset($_POST[$input['id']]) || empty($_POST[$input['id']])) {
            $page = str_replace("*error" . $input['id'] . "*", "<p class=\"col4 error\">Il campo " . $input['id'] . " è richiesto. Si prega di inserirlo.</p>", $page);
        }
    }

    public static function checkEmptyInputs($inputs, &$page) {
        foreach ($inputs as $input) {
            self::checkEmptyInput($input, $page);
        }
    }

}
