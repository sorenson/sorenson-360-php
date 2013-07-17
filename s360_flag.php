<?php

class S360_Flag extends S360 {

  public static function all($order = NULL) {
    $data = parent::do_get('/flags?order=' . $order);
    return $data;
  }
  
  public static function count($account_id) {
    $data = parent::do_get('/accounts/' . $account_id . '/flags/count');
    return $data['count'];
  }
  
}

?>