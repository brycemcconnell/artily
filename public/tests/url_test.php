<?php

include "../../config.php";

echo url() . "\n";
echo url('home', '', [], false) . "\n";

echo url("addBooking"). "\n";
echo url("addBooking",  'index.php', ['id'=>5], false) . "\n";

$params = ['id'=>5, 'key'=>'important', 'page'=>3];
echo url("addBooking",  'managent/index.php', $params, true) . "\n";


