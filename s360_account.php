<?php

class S360_Account extends S360
{
  
  public $username, $status, $customerId, $token, $goto360URL, $ratePlanExpirationDate, $dateLastModified, $sorensonId, $lastLoginTime, $dateRetrieved, $sessionId, $ratePlan, $id;
  public $encoded    = array();
  public $assetList  = array();
  
  public $totalAssetCount = 0; 
  
  public static function fromJSON($data) {
    $account = new S360_Account;
    $account->init($data);
    return $account;
  }
  
  private static function _do_login($url, $data) {
    $data = parent::do_post($url, $data);

    if (!$data || array_key_exists('errorCode', $data) && $data['errorCode']) {
      return $data;
    } else {
      S360::$auth_token = $data['account_id'] . ':' . $data['token'];
      return S360_Account::fromJSON($data);
    }
  }
  
  public static function login($username, $password) {
    return S360_Account::_do_login('/sessions', array('username' => $username, 'password' => $password));
  }
  
  public static function find_json($id) {
    return parent::do_get('/accounts/' . $id);
  }
  
  public static function find($id) {
    $data = S360_Account::find_json($id);
    return S360_Account::fromJSON($data);
  }
  
  private function init($data) {
    
    $this->sessionId                 = $data['session_id'];
    $this->token                     = $data['token'];
    $this->id                        = $data['account_id'];
    
    if (!array_key_exists('username', $data)) {
      $account = S360_Account::find_json($this->id);
    } else {
      $account = $data;
    }

    $this->username                  = $account['username'];
    $this->status                    = $account['status'];
    $this->customerId                = $account['customer_id'];
    $this->ratePlanExpirationDate    = $account['rate_plan_expiration_date'];
    $this->dateLastModified          = $account['date_last_modified'];
    $this->lastLoginTime             = $account['last_login_time'];
    $this->dateRetrieved             = $account['date_retrieved'];
    $this->totalAssetCount           = $account['total_asset_count'];
    
  }

  public function ratePlan() {
    $data = parent::do_get('/accounts/' . $this->id . '/rate_plan');
    $this->ratePlan = S360_RatePlan::fromJSON($data);
    return $this->ratePlan;
  }
  
  public function getAssets($offset = null, $numToRetrieve = null) {
    $this->assetList = S360_Asset::find_all($this, $offset, $numToRetrieve);
    return $this->assetList;
  }
    
  public function overageAction() {
    $data = parent::do_get("/accounts/" . $this->id . "/overage_action");
    return $data['overage_action'];
  }
  
  public function setPassword($password, $old_password) {
    $data = parent::do_put('/accounts/' . $this->id, array('account' => array('password' => $password, 'old_password' => $old_password)));
    return $data['success'];
  }

  public function emptyTrash() {
    $data = parent::do_post('/accounts/' . $this->id . '/empty_trash');
    return $data['status'];
  }

  public function getSubaccounts() {
    $data = parent::do_get('/subaccounts');
    return $data;
  }

  public function createSubaccount($username, $email, $password) {
    $data = parent::do_post('/subaccounts', array('subaccount' => array('username' => $username, 'email' => $email, 'password' => $password)));
    return $data;
  }
}

?>
