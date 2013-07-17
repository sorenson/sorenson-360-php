<?php

class S360_Subaccount extends S360
{

  public $account, $id, $username, $status, $accountId, $email, $dateRetrieved;

  public static function fromJSON($account, $data) {
    $subaccount = new S360_Subaccount;
    $subaccount->init($account, $data);
    return $subaccount;
  }
  
  private function init($account, $data) {
    $this->account                   = $account;
    
    $this->id                        = $data['id'];
    $this->accountId                 = $data['accountId'];
    $this->username                  = $data['username'];
    $this->status                    = $data['status'];
    $this->email                     = $data['email'];
    $this->dateRetrieved             = $data['dateRetrieved'];
  }
  
  public function activate() {
    $data = parent::do_put('/subaccounts/' . $this->id . '/activate');
    return $data;
  }

  public function deactivate() {
    $data = parent::do_put('/subaccounts/' . $this->id . '/deactivate');
    return $data;
  }
}

?>