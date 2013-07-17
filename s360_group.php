<?php

class S360_Group extends S360
{
  
  public $description, $name, $account, $accountId, $id, $guid;

  public static function fromJSON(/*$account,*/ $data) {
    $group = new S360_Group;
    $group->init(/*$account,*/ $data);
    return $group;
  }
  
  public static function presets($group_id) {
    $data = parent::do_get('/groups/' . $group_id . '/presets');
    return $data;
  }

  public static function create($name, $attributes = array()) {
    $attributes['name'] = $name;
    $data = parent::do_post('/groups', array('group' => $attributes));
    return S360_Group::fromJSON($data['group']);
  }
  
  public static function update($name, $attributes = array()) {
    $attributes['name'] = $name;
    $attributes['id'] = $this->guid;
    $data = parent::do_put('/groups/' . $this->guid, array('group' => $attributes));
    return S360_Group::fromJSON($data['group']);
  }

  public static function all() {
    function find_collection($n) {
      return S360_Group::fromJSON($n['group']);
    }
    $data = parent::do_get('/groups');
    return array_map('find_collection', $data);
  }
  
  public static function find($id) {
    $data = parent::do_get('/groups/' . $id);
    return S360_Group::fromJSON($data['group']);
  }
  
  public static function findByName($name) {
    $data = parent::do_get('/groups/find_by_name?name=' . urlencode($name));
    return S360_Group::fromJSON($data['group']);
  }
  
  private function init(/*$account,*/ $data) {
    //$this->account = $account;
    
    $this->description = $data['description'];
    $this->name        = $data['name'];
    $this->parentId    = $data['parent_id'];
    $this->id          = $data['id'];
  }
  
  public function addAsset($asset) {
    $data = parent::do_put('/groups/' . $this->id . '/assets/' . $asset->id);
    return $data;
  }
  
  public function addUser($user_id) {
    $data = parent::do_put('/groups/' . $this->id . '/users/' . $user_id);
    return $data;
  }

  public function assets() {
    function get_asset($n) {
      return S360_Asset::fromJSON($n);
    }
    $data = parent::do_get('/groups/' . $this->id . '/assets');
    return array_map('get_asset', $data);
  }

  public function users() {
    $data = parent::do_get('/groups/' . $this->id . '/users');
    return $data;
  }
  

  public function delete() {
    $data = parent::do_delete('/groups/' . $this->id);
    return $data;
  }
}

?>

