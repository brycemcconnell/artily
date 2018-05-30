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


