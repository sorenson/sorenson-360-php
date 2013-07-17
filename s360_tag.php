<?php

class S360_Tag extends S360 {

  public static function all($order = NULL) {
    $data = parent::do_get('/tags?order=' . $order);
    return $data;
  }
  
  public static function count($account_id) {
    $data = parent::do_get('/accounts/' . $account_id . '/tags/count');
    return $data['count'];
  }
  
}

?>