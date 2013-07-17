<?php

ini_set('display_errors', 1);

include '../sorenson_360.php';
S360::$debug = true;

// $account = S360_Account::login('chloe@chloe.com', 'whatever');
$account = S360_Account::login('example@sorensonmedia.com', 'sorensonExample');

print_r(S360_Category::all());
?>