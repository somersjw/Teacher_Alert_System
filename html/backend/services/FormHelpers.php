<?php
namespace backend\services;

class FormHelpers
/* This class is designed to include common functions for form setup */
{
    public function __construct(){}
    // check to make sure the string hasn't already been escaped previously
    static function checkAddSlashes($str) {
        //check string for \' (escaped single quote), \" (escaped double quote), \\ (escaped backslash)
        $pattern = '/\\\\[\'"\\\\]+/';
        return (!preg_match($pattern, $str)) ? addslashes($str) : $str;
    }

    static function isSQLDate($date){
        //verifies if date is yyyy-mm-dd format
        $is_sql_date_format = true;
        $date_regexp = '/^\d{4}-\d{2}-\d{2}$/';

        if(preg_match($date_regexp, $date)){
            list($year, $month, $day) = explode('-', $date);
            $is_sql_date_format = checkdate($month, $day, $year);
        }
        else{
            $is_sql_date_format = false;
        }

        return $is_sql_date_format;

    }
}