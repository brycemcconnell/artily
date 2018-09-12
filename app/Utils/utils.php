<?php

/**
 * @param string $action
 * @param string $path
 * @param array $params
 * @param bool $absolute_path
 * @return string
 */
function url(string $action = "home", string $path = "index.php",
             array $params = [], bool $absolute_path = true)
{
    unset($params['action']); //$params cannot have key 'action' as it is already used by the first parameter


    if ($absolute_path && defined('APP_ROOT')) {
        $full_path = APP_ROOT .'/' . $path;
    }
    else{
        $full_path = $path;
    }

    $a = explode("//", $full_path); //remove erroneous '//' but leave the first one for http://
    if (count($a) > 1) {
        $full_path = "";
        if ($a[0] == "http:") {
            $full_path = "http://";
            unset($a[0]);
        }
        $full_path .= implode("/", $a);
    }
    $p['action'] = $action;
    $p = array_merge($p, $params);

    return $full_path . "?" . http_build_query($p);
}

function e(string $string)
{
    return htmlspecialchars($string, ENT_QUOTES);
}


function time_elapsed_string($datetime, $full = false) {
    /*
    @todo - Fix this for future values becoming corrupt
    Instead, perhaps just say 'from the future'
    */
    if ($datetime == NULL) {
        return "an eternity ago";
    }
    $now = new DateTime("now", new DateTimeZone('UTC'));
    $ago = new DateTime($datetime, new DateTimeZone('UTC'));
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

function redirect_back() {

    if (isset($_GET["redirect"])) {
        header("Location:".$_GET["redirect"]);
    } else {
        header("Location: /");
    }
}

function urlsafe($string) {
    return filter_var(str_replace(' ', '-', $string), FILTER_SANITIZE_URL);
}
function urlsafereverse($string) {
    return str_replace('-'," ", $string);
}