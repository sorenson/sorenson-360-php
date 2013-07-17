<?php

ini_set('display_errors', 1);

include '../sorenson_360.php';
$account = S360_Account::login('chloe@chloe.com', 'whatever');

$assets = S360_Asset::find_all($account, 0, 1);

S360::$debug = true;

$asset = $assets[0];
print_r($asset);

# NOTE: Asset Categories do not exist
//print_r($asset->addCategory('testmeout'));
//print_r($asset->category());
//print_r($asset->removeCategory());

?>
