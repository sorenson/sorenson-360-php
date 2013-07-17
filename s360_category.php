<?php

class S360_Category extends S360
{
  
  public $description, $name, $parentId, $parent, $id, $account;

  public static function fromJSON($data) {
    $category = new S360_Category;
    $category->init(/*$account,*/ $data);
    return $category;
  }
  
  public static function all() {
    function name($n) {
      return $n['name'];
    }
    $data = parent::do_get('/categories');
    return array_map('name', $data);
  }
  
  public static function allRoots() {
    function name($n) {
      return $n['name'];
    }
    $data = parent::do_get('/categories/roots');
    return array_map('name', $data);
  }
  
  public static function findByName($name) {
    $data = parent::do_get('/categories/find_by_name?category[name]=' . urlencode($name));
    return S360_Category::fromJSON($data);
  }
  
  public static function find($id) {
    $data = parent::do_get('/categories/' . $id);
    return S360_Category::fromJSON($data);
  }
  
  public static function create($name, $options = array()) {
    $options['name'] = $name;
    $data = parent::do_post('/categories', $options);
    return S360_Category::fromJSON($data);
  }
  
  private function init(/*$account,*/ $data) {
    //$this->account = $account;
    
    $this->description = $data['description'];
    $this->name        = $data['name'];
    $this->parentId    = $data['parent_id'];
    $this->id          = $data['id'];
  }
  
  public function save() {
    $data = parent::do_put('/categories/' . $this->id, array('category' => array('name' => $this->name, 'description' => $this->description), 'parent_name' => $this->parent_name));
    return $data;
  }

  public function destroy() {
    $data = parent::do_delete('/categories/' . $this->id);
    return $data['status'] == 'success';
  }
  
  public function assets() {
    $data = parent::do_get('/categories/' . $this->id . '/assets');
    return $data;
  }

  public function parent() {
    if ($this->parentId) {
      return S360_Category::find($this->parentId);
    }
  }

}

?>

