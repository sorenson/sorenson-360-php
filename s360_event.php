<?php

class S360_Event extends S360
{
  public $date, $accountId, $value, $type, $day, $id, $lastModified, $retrievedOn;

  private function init($data) {
    $this->date               = $data['eventDate'];
    $this->day                = $data['eventDay'];
    $this->lastModified       = $data['dateLastModified'];
    $this->retrievedOn        = $data['dateRetrieved'];
    $this->id                 = $data['id'];
    $this->accountId          = $data['accountId'];
    $this->value              = $data['eventIntegerValue'] || $data['eventDecimalValue'] || $data['eventStringValue'];
    $this->type               = $data['eventType'];
  }
}

?>