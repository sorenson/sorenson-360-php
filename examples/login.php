<?php

ini_set('display_errors', 1);

include '../sorenson_360.php';
S360::$debug = true;

$account = S360_Account::login('chloe@chloe.com', 'whatever');

print_r($account);

// print_r($account->ratePlan());

print_r(S360_Asset::find_all($account));
?>