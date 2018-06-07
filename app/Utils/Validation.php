<?php
Namespace App\Utils;
/**
 * Description of Validation Class
 * Provides validation service for form fields
 * @author Stefan Batsas
 * @date 23/09/2017
 * @version 1.23092017
 * Added function validate_form_data
 * Updated validate Date function
 * Update this version by appending date
 */
class Validation {

    function __construct() {
        
    }

    /**
     * Validate Form Data
     * @param type $fields contains arrays of associative arrays for all fields
     * $field = [ 'name' => 'firstname', 'valid_type' =>  'alpha_spaces', 'required' => true ]
     * @param type $post copy of $_POST array
     * @return array Error messages
     */
    function validate_form_data($fields, $post) {


        $errors = [];

        foreach ($fields as $field) {

            // check if $key exists in $_POST
            if (isset($post[$field['name']])) {

                $errorMessage = $this->validate($post[$field['name']], $field['valid_type'], $field['required']);
                if (strlen($errorMessage) > 0) {
                    $errors[$field['name']] = $errorMessage;
                }
            } else {
                // if key is not set in post then it may be a select/radio/checkbox field
                $errors[$field['name']] = "Please select " . $field['name'];
            }
        } // end foreach

        return $errors;
    }

// end function

    /**
     * 
     * @param type $value
     * @param type $validtype is the type of data we consider to be valid for this field
     * @param type $isRequired true of false if the form field is a required field
     * eg. Name field - alpha, Phone field - digits
     * #return $errorMessage 
     */
    function validate($value, $valid_type, $required) {
        $errorMessage = '';

        // trim leading and trailing spaces
        $value = trim($value);

        if (strlen($value) == 0) {
            if ($required) {
                $errorMessage = ' Missing input';
            }
        } else {

            $errorMessage = call_user_func_array([$this, $valid_type], [$value]);
        } // end if
        return $errorMessage;
    }

    function alpha($value) {
        return ctype_alpha($value) ? '' : 'Alpha input only';
    }

    function alpha_spaces($value) {
        $temp = str_replace(' ', '', $value);
        return ctype_alpha($temp) ? '' : 'Alpha and spaces input only';
    }

    function alpha_num($value) {

        return ctype_alnum($value) ? '' : 'Alpha and numeric input only';
    }

    function alpha_num_spaces($value) {
        $temp = str_replace(' ', '', $value);
        return ctype_alnum($temp) ? '' : 'Alpha numeric and spaces input only';
    }

    function complex_name($value) {
        return $this->validate_complex_name($value) ? '' : 'Enter a valid name';
    }

    function date($value) {
        return $this->validateDate($value) ? '' : 'Enter a valid date';
    }

    function digits($value) {
        return ctype_digit($value) ? '' : 'Enter digits only';
    }

    function email($value) {
        return filter_var($value, FILTER_VALIDATE_EMAIL) ? '' : 'Enter valid email address';
    }

    function decimal($value) {
        return filter_var($value, FILTER_VALIDATE_FLOAT) ? '' : 'Decimal input only';
    }

    function mobile($value) {
        return $this->validateMobile($value) ? '' : 'Mobile must be at least 10 digits';
    }

    function password($value) {
        return $this->validatePassword($value) ? 'Must be at least 8 Alpha Numeric Characters' : '';
    }

    function month_year_date($value) {
        return $this->validateMonthYearDate($value) ? '' : 'Enter a valid month/year date';
    }

    function street_address($value) {
        return $this->validateStreetAddress($value) ? '' : 'Enter a valid street address';
    }

    function time($value) {
        return strtotime($value)? '':'Enter a valid time';
    }

    /**
     * Cleans the string of leading and trailings spaces
     * slashes and html special characters 
     * @param type $value
     * @return type
     */
    function sanitize($value) {

        $value = trim($value);
        $value = stripslashes($value);
        $value = htmlspecialchars($value);
        $value = strip_tags($value);
        return $value;
    }

// end function

    /**
     * Street address example Unit 5/23-24 Page street
     * Can contain one forward slash and one dash
     * @param type $value
     * @return boolean
     */
    function validateStreetAddress($value) {

        $valid = true;

        // check for forward slashes  - 1 is permitted
        $numSlashes = $numDashes = 0;

        // number of slashes replaced stored in $numSlashes
        $temp = str_replace("/", "", $value, $numSlashes);
        // number of dashes replaced stored in $numSlashes
        $temp = str_replace("-", "", $value, $numDashes);

        if ($numSlashes > 1 || $numDashes > 1) {

            $valid = false;
        } else {

            // remove spaces
            $temp = str_replace(" ", "", $value);
            // remove slash
            $temp = str_replace("/", "", $temp);
            // remove dashes
            $temp = str_replace("-", "", $temp);

            // check for alpha numeric
            if (!ctype_alnum($temp)) {
                $valid = false;
            } // end if
        } // end if

        return $valid;
    }

// end validation of street address

    function validateEmailMessage($value) {

        $valid = true;

        // there is a lost more to validate for an email message body
        if (strlen($value) > 500) {
            $valid = false;
        }

        return $valid;
    }

// end function

    /**
     * Validates date in format yyyy-mm-dd or dd/mm/yyyy
     * @param type $date
     * @return boolean
     */
    function validateDate($date) {

        $valid = false;

        if (preg_match("/\d{4}\-\d{2}\-\d{2}/", $date)) {
            // any value returned from date picker is a valid date
            $valid = true;

            // no support for HTML5 date picker user enters input for date 
            // any other date format will not pass 
            $day = $month = $year = "";
            // split up the pieces 
            list($year, $month, $day) = explode("-", $date);

            $day = intval($day);
            $month = intval($month);
            $year = intval($year);

            // now use PHP checkdate to verify it is a valid date - 1 is supplied for day
            if (checkdate($month, $day, $year)) {
                $valid = true;
            }
        } else if (preg_match("/\d{2}\/\d{2}\/\d{4}/", $date)) {
            // if we are here user has ebtered format of dd/mm/yyyy
            $day = $month = $year = "";
            // split up the pieces 
            list($day, $month, $year) = explode("/", $date);

            $day = intval($day);
            $month = intval($month);
            $year = intval($year);

            // now use PHP checkdate to verify it is a valid date - 1 is supplied for day
            if (checkdate($month, $day, $year)) {
                $valid = true;
            }
        }
        return $valid;
    }

// end function

    /**
     * Validates date in format yyyy-mm or mm/yyyy
     * @param type $date
     * @return boolean
     */
    function validateMonthYearDate($date) {

        $valid = false;

        if (preg_match("/\d{4}\-\d{2}/", $date)) {
            // any value returned from date picker is a valid date


            $month = $year = "";
            // split up the pieces 
            list($year, $month) = explode("-", $date);

            $month = intval($month);
            $year = intval($year);
            // now use PHP checkdate to verify it is a valid date - 1 is supplied for day
            if (checkdate($month, 1, $year)) {
                $valid = true;
            }

            // no support for HTML5 date picker user enters input for date
            // any other date format will not pass 
        } else if (preg_match("/\d{2}\/\d{4}/", $date)) {
            // if we are here user has entered format of mm/yyyy
            $month = $year = "";
            // split up the pieces 
            list($month, $year) = explode("/", $date);

            $month = intval($month);
            $year = intval($year);
            // now use PHP checkdate to verify it is a valid date - 1 is supplied for day
            if (checkdate($month, 1, $year)) {
                $valid = true;
            }
        }
        return $valid;
    }

// end function

    /**
     * 
     * @param type $value
     * @return boolean
     */
    function validateMobile($value) {

        $valid = true;
        if (strlen($value) < 10) {
            $valid = false;
        } else if (!ctype_digit($value)) {
            $valid = false;
        }

        return $valid;
    }

// end function

    /**
     * 
     * @param type $value
     * @return boolean
     */
    function validatePassword($value) {

        $valid = true;

        if (strlen($value) < 8) {
            $valid = false;
        } else if (!ctype_alnum($value)) {
            $valid = false;
        }

        return $valid;
    }

// end class

    function validate_complex_name($value) {

        $valid = true;
        // remove the spaces
        $temp = str_replace(' ', '', $value);
        // remove dashes and count them
        $temp = str_replace('-', '', $temp, $hyphen_count);
        // remove periods and count them
        $temp = str_replace('.', '', $temp, $fullstop_count);
        // count the number of digits
        $digit_count = preg_match_all("/[0-9]/", $temp);

        // rules are 1 dash, 1 period, 1 digit and alpha permitted
        if (!ctype_alnum($temp) || $hyphen_count > 1 ||
                $fullstop_count > 1 || $digit_count > 1) {
            $valid = false;
        }

        return $valid;
    }

}

// end class
