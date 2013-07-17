<?php

class S360_Asset extends S360 {
  public $encodeDate, $frameRate, $height, $dateLastModified, $videoBitrateMode, $mediaType, $id, $accountId, $numberOfViews, $presetXml, $application, $audioCodec, $permalinkLocation, $status, $description, $videoDuration, $abstractFileId, $versionId, $dateRetrieved, $audioDataRate, $audioBitrateMode, $videoCodec, $displayName, $name, $videoDataRate, $authorId, $width, $fileSize, $defaultEmbed, $groups, $groupId;
  
  public $filters   = array();
  public $embedList = array();
  
  public static function fromJSON($account, $data) {
    $asset = new S360_Asset;
    $asset->init($account, $data);
    return $asset;
  }
  
  public static function find_all($account, $offset = NULL, $numToRetrieve = NULL) {
    
    $data = parent::do_get("/assets?offset=" . $offset . "&quantity=" . $numToRetrieve);
    $assets = array();
    
    foreach($data['asset_list'] as $entry) {
      $assets[] = S360_Asset::fromJSON($account, $entry);
    }
    
    return $assets;
  }
  
  public static function find($account, $id) {
    $data = parent::do_get('/assets/' . $id);
    return S360_Asset::fromJSON($account, $data);
  }

  public static function findAllByTag($account, $tag_name) {
    $data = parent::do_get('/tags/' . urlencode($tag_name) . '/assets');
    return $data;
  }

  public static function findAllByFlag($account, $flag_name) {
    $data = parent::do_get('/flags/' . urlencode($flag_name) . '/assets');
    return $data;
  }

  public static function count() {
    $data = parent::do_get('/assets/count');
    return $data['count'];
  }

  private function init($account, $data) {
    $this->account                = $account;
    $this->encodeDate             = $data['encode_date'];
    $this->frameRate              = $data['frame_rate'];
    $this->height                 = $data['height'];
    $this->dateLastModified       = $data['date_last_modified'];
    $this->videoBitrateMode       = $data['video_bitrate_mode'];
    $this->mediaType              = $data['media_type'];
    $this->id                     = $data['id'];
    $this->accountId              = $data['account_id'];
    $this->numberOfViews          = $data['number_of_views'];
    $this->application            = $data['application'];
    $this->audioCodec             = $data['audio_codec'];
    $this->permalinkLocation      = $data['permalink_location'];
    $this->status                 = $data['status'];
    $this->description            = $data['description'];
    $this->videoDuration          = $data['video_duration'];
    $this->abstractFileId         = $data['abstract_file_id'];
    $this->versionId              = $data['version_id'];
    $this->dateRetrieved          = $data['date_retrieved'];
    $this->audioDataRate          = $data['audio_data_rate'];
    $this->audioBitrateMode       = $data['audio_bitrate_mode'];
    $this->videoCodec             = $data['video_codec'];
    $this->displayName            = $data['display_name'];
    $this->name                   = $data['name'];
    $this->videoDataRate          = $data['video_data_rate'];
    $this->authorId               = $data['author_id'];
    $this->width                  = $data['width'];
    $this->fileSize               = $data['file_size'];
    $this->thumbnailImageUrl      = $data['thumbnail_image_url'];
    $this->groupId                = $data['group_id'];
    $this->embedList              = $data['embed_list'];
  }


  public function presetXml() {
    $data = parent::do_get('/assets/' . $this->id . '/preset_xml');
    return $data['preset_xml'];
  }

  public function deactivate() {
    $data = parent::do_post('/assets/' . $this->id . '/deactivate');
    return $data['status'] == 'success';
  }

  public function activate() {
    $data = parent::do_post('/assets/' . $this->id . '/activate');
    return $data['status'] == 'success';
  }
  
  public function destroy() {
    $data = parent::do_delete('/assets/' . $this->id);
    return $data['status'] == 'success';
  }
  
  public function save() {
    $data = parent::do_put('/assets/' . $this->id, array('asset' => array('name' => $this->name, 'password' => $this->password, 'description' => $this->description)));
    return $data['status'] == 'success';
  }
  
  public function addCategory($name) {
    $data = parent::do_post('/assets/' . $this->id . '/categories', array('category' => array('name' => $name)));
    return S360_Category::fromJSON($this->account, $data);
  }
  
  public function removeCategory() {
    $category = $this->category();
    $data = parent::do_delete('/assets/' . $this->id . '/categories/' . $category->id);
    return $data['success'] == 'success';
  }
  
  public function category() {
    $data = parent::do_get('/assets/' . $this->id . '/categories');
    return S360_Category::fromJSON($this->account, $data);
  }

  public function embedCodes() {
    $data = parent::do_get('/assets/' . $this->id . '/embed_codes');
    return $data['embed_codes'];
  }

  public function tags() {
    $data = parent::do_get('/assets/' . $this->id . '/tags');
    return $data;
  }

  public function addTags($tags) {
    $data = parent::do_post('/assets/' . $this->id . '/tags', array('tag_list' => $tags));
    return $data;
  }

  public function flags() {
    $data = parent::do_get('/assets/' . $this->id . '/flags');
    return $data;
  }

  public function addFlags($flags) {
    $data = parent::do_post('/assets/' . $this->id . '/flags', array('flag_list' => $flags));
    return $data;
  }
  
  public function deleteMetadata($key) {
    $data = parent::do_delete('/assets/' . $this->id . '/metadata/' . $key);
    return $data['status'] == 'success';
  }
  
  public function getMetadata($key) {
    $data = parent::do_get('/assets/' . $this->id . '/metadata/' . $key);
    if ($data['status'] == '404') {
      return NULL;
    }
    return $data['result'];
  }
  
  public function setMetadata($key, $value) {
   $data = parent::do_post('/assets/' . $this->id . '/metadata', array('key' => $key, 'value' => $value));
   return $data;
  }

  public function metadata() {
    $data = parent::do_get('/assets/' . $this->id . '/metadata');
    return $data;
  }
  
  public function group() {
    if ($this->group_id == NULL) {
      return NULL;
    }
    return S360_Group::find($this->group_id);
  }
}

?>