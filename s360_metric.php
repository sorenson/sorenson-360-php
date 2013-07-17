<?php

class S360_Metric extends S360 {

  public static function all() {
    function get_event($n) {
      return S360_Event::fromJSON($n);
    }
    $data = parent::do_get('/metrics');
    return asset_map('get_event', $data);
  }
  
  public static function totalPlays() {
    $data = parent::do_get('/metrics/total_plays');
    return $data['total_plays'];
  }
  
  public static function storageUsed($startDate = NULL, $endDate = NULL) {
    if ($startDate && $endDate) {
      $data = parent::do_get('/metrics/storage?start_date=' . $startDate . '&end_date=' . $endDate);
    } else {
      $data = parent::do_get('/metrics/storage');
    }
    return $data['storage_used'];
  }
}

?>