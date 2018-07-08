<?php
Namespace App\Utils;

class Validation {

    function __construct() {
        
    }

    function alpha($value) {
        return ctype_alpha($value) ? '' : 'Alphabetical only';
    }

    function alpha_spaces($value) {
        $temp = str_replace(' ', '', $value);
        return ctype_alpha($temp) ? '' : 'Alphabetical and spaces only';
    }

    function alpha_num($value) {
        return ctype_alnum($value) ? '' : 'Alphanumeric only';
    }

    function alpha_num_spaces($value) {
        $temp = str_replace(' ', '', $value);
        return ctype_alnum($temp) ? '' : 'Alphanumeric and spaces only';
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

    function validateMobile($value) {
        $valid = true;
        if (strlen($value) < 10) {
            $valid = false;
        } else if (!ctype_digit($value)) {
            $valid = false;
        }
        return $valid;
    }

    function validatePassword($value) {
        $valid = true;
        if (strlen($value) < 8) {
            return 'Password too short (less than 8 characters)';
        } else if (strlen($value) > 255) {
            return 'Password too long (over 255 characters)';
        } else if (!ctype_alnum($value)) {
            return 'Password only '
        }

        return $valid;
    }
}