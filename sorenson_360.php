<?php

class S360 {
  
  static $use_ssl = false;
  static $debug   = false;
  static $last_error = '';
  static $cookie_name = NULL;
  static $auth_token = NULL;

  private static function _new_http_connection($url, $method, $data = NULL) {

    // create curl resource 
    $ch = curl_init(); 
    
    if (S360::$debug) {
      curl_setopt($ch, CURLOPT_VERBOSE, true);
    }

    if (S360::$use_ssl) {
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    }
    
    // set url 
    curl_setopt($ch, CURLOPT_URL, $url); 
    
    //return the transfer as a string 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    
    if ($method == 'POST') {
      curl_setopt($ch, CURLOPT_POST, true);
    } elseif ($method == 'PUT') {
      curl_setopt($ch, CURLOPT_PUT, true);
    } elseif ($method == 'DELETE') {
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    }
    
    if ($data) {
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }
    
    if (S360::$auth_token) {
      curl_setopt($ch, CURLOPT_USERPWD, S360::$auth_token);
    }

    $output = curl_exec($ch);
    
    if (S360::$debug) {
      echo "/// URL /////////////////////////////////////////////////////////////////////////////////////////////////////<br/>\n";
      echo $url . "<br/>\n";
      echo "/// DATA ////////////////////////////////////////////////////////////////////////////////////////////////////<br/>\n";
      print_r($data);
      echo "<br/>\n";
      echo "/// OUTPUT ////////////////////////////////////////////////////////////////////////////////////////////////////<br/>\n";
      print_r($output);
      echo "<br/>\n<br/>\n";
    }
    
    if ($output == false) {
      S360::$last_error = curl_error($ch);
    }
    
    // close curl resource to free up system resources 
    curl_close($ch);
    
    return $output;
  }
  
  private static function _post($url, $data = NULL) {
    $output = S360::_new_http_connection($url, 'POST', $data);

    return $output;
  }
  
  private static function _get($url) {
    $output = S360::_new_http_connection($url, 'GET');

    return $output;
  }
  
  private static function _put($url, $data = NULL) {
    $output = S360::_new_http_connection($url, 'PUT', $data);

    return $output;
  }
  
  private static function _delete($url, $data = NULL) {
    $output = S360::_new_http_connection($url, 'DELETE', $data);

    return $output;
  }
  
  private static function _check_json_installed() {
    if (!function_exists('json_decode')) {
      return array('errorMessage' => 'JSON is not installed', 'errorCode' => '999');
    }
  }
  
  private static function _do_delete($url, $data = NULL) {
    S360::_check_json_installed();
    $output = S360::_delete($url, $data);
    if ($output) {
      $output = json_decode($output, true);
    } else {
      $output = S360::$last_error;
    }
    
    return $output;
  }
  
  private static function _do_post($url, $data = NULL) {
    S360::_check_json_installed();
    $output = S360::_post($url, $data);
    if ($output) {
      $output = json_decode($output, true);
    } else {
      $output = S360::$last_error;
    }
    
    return $output;
  }

  private static function _do_put($url, $data = NULL) {
    S360::_check_json_installed();
    $output = S360::_put($url, $data);
    if ($output) {
      $output = json_decode($output, true);
    } else {
      $output = S360::$last_error;
    }
    
    return $output;
  }

  private static function _do_get($url) {
    S360::_check_json_installed();
    $output = S360::_get($url);
    if ($output) {
      $output = json_decode($output, true);
    } else {
      $output = S360::$last_error;
    }
    
    return $output;
  }
  
  public static function create_token($username) {
    $salt = "sorensonmediacarlsbad" . $username;
    return sha1($salt);
  }
  
  private static function _getHost() {
    $host = '360services.sorensonmedia.com'; 
    return $host;
  }
  
  private static function _getProtocol() {
    if (S360::$use_ssl) {
      $protocol = 'https://';
    } else {
      $protocol = 'http://';
    }
    return $protocol;
  }
  
  public static function do_post($url, $data = NULL) {
    return S360::_do_post(S360::_getProtocol() . S360::_getHost() . $url, $data);
  }

  public static function do_get($url) {
    return S360::_do_get(S360::_getProtocol() . S360::_getHost() . $url);
  }
  
  public static function do_put($url, $data = NULL) {
    return S360::_do_put(S360::_getProtocol() . S360::_getHost() . $url, $data);
  }

  public static function do_delete($url, $data = NULL) {
    return S360::_do_delete(S360::_getProtocol() . S360::_getHost() . $url, $data);
  }

}

require_once('s360_account.php');
require_once('s360_subaccount.php');
require_once('s360_asset.php');
require_once('s360_tag.php');
require_once('s360_flag.php');
require_once('s360_event.php');
require_once('s360_metric.php');
require_once('s360_category.php');
require_once('s360_group.php');
require_once('s360_rate_plan.php');

?>
