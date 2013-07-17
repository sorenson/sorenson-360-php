<?php

class S360_RatePlan extends S360 {
  public $id, $displayName, $ratePlanType, $maxThumbnailsPerVideo, $setupCost, $monthlyCost, $allowedStreams, $basePlan, $dateLastModified, $dateRetrieved, $streamingOverageAllowed, $storageOverageAllowed, $allowedStreamingMBytes, $allowedStorageMBytes, $allowedSourceMediaTypes, $allowedOutputMediaTypes, $annualCost, $monthlyCostWithAnnualCommitment, $sorensonSku;
  
  public $formatConstraints = array();
  
  public static function fromJSON($data) {
    $rate_plan = new S360_RatePlan;
    $rate_plan->init($data);
    return $rate_plan;
  }
  
  private function init($data) {
    $this->id                              = $data['id'];
    $this->displayName                     = $data['display_name'];
    $this->ratePlanType                    = $data['rate_plan_type'];
    $this->maxThumbnailsPerVideo           = $data['max_thumbnails_per_video'];
    $this->setupCost                       = $data['setup_cost'];
    $this->monthlyCost                     = $data['monthly_cost'];
    if (array_key_exists('monthly_cost_with_annual_commitment', $data)) {
      $this->monthlyCostWithAnnualCommitment = $data['monthly_cost_with_annual_commitment'];
    }
    if (array_key_exists('annual_cost', $data)) {
      $this->annualCost                    = $data['annual_cost'];
    }
    $this->allowedStreams                  = $data['allowed_streams'];
    $this->basePlan                        = $data['base_plan'];
    $this->dateLastModified                = $data['date_last_modified'];
    $this->dateRetrieved                   = $data['date_retrieved'];
    $this->streamingOverageAllowed         = ($data['streaming_overage_allowed'] == '1');
    $this->storageOverageAllowed           = ($data['storage_overage_allowed'] == '1');
    $this->allowedStreamingMBytes          = $data['allowed_streaming_megabytes'];
    $this->allowedStorageMBytes            = $data['allowed_storage_megabytes'];
    $this->allowedSourceMediaTypes         = $data['allowed_source_media_types']; //multi param
    $this->allowedOutputMediaTypes         = $data['allowed_output_media_types']; //multi param
    if (array_key_exists('sorenson_sku', $data)) {
      $this->sorensonSku                   = $data['sorenson_sku'];
    }
    if (array_key_exists('format_constraints', $data)) {
      $this->initFormatConstraints($data['format_constraints']);
    }

  }
  
  private function initFormatConstraints($data) {
    foreach ($data as $fc) {
      $this->formatConstraints[] = S360_FormatConstraint::fromJSON($this, $fc);
    }
  }

}

?>
