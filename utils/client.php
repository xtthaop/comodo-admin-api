<?php

Class Client {
  public function getIpAddress(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
      $ipaddr = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
      $ipaddr = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
      $ipaddr = $_SERVER['REMOTE_ADDR'];
    }
    return $ipaddr;
  }

  public function getBrowser(){
    $sys = $_SERVER['HTTP_USER_AGENT'];
    if(stripos($sys, "Firefox/") > 0){
      preg_match("/Firefox\/([^;)]+)+/i", $sys, $b);
      $exp[0] = "Firefox";
      $exp[1] = $b[1];
    }elseif(stripos($sys, "MSIE") > 0){  
      preg_match("/MSIE\s+([^;)]+)+/i", $sys, $ie);  
      $exp[0] = "IE";
      $exp[1] = $ie[1];
    }elseif(stripos($sys, "OPR") > 0){
      preg_match("/OPR\/([\d\.]+)/", $sys, $opera);
      $exp[0] = "Opera";
      $exp[1] = $opera[1]; 
    }elseif(stripos($sys, "Edge") > 0){
      preg_match("/Edge\/([\d\.]+)/", $sys, $Edge);
      $exp[0] = "Edge";
      $exp[1] = $Edge[1];
    }elseif (stripos($sys, "Chrome") > 0){  
      preg_match("/Chrome\/([\d\.]+)/", $sys, $google);
      $exp[0] = "Chrome";
      $exp[1] = $google[1];
    }elseif(stripos($sys,'rv:')>0 && stripos($sys,'Gecko')>0){
      preg_match("/rv:([\d\.]+)/", $sys, $IE);
      $exp[0] = "IE";
      $exp[1] = $IE[1];
    }else{
      $exp[0] = "未知浏览器";
      $exp[1] = "";
    }
    return $exp[0].'('.$exp[1].')';
  }

  public function getOs(){
    $OS = $_SERVER['HTTP_USER_AGENT'];
    if(preg_match('/win/i',$OS)){
      $OS = 'Windows';
    }elseif(preg_match('/mac/i',$OS)) {
      $OS = 'MAC';
    }elseif(preg_match('/linux/i',$OS)) {
      $OS = 'Linux';
    }elseif(preg_match('/unix/i',$OS)) {
      $OS = 'Unix';
    }elseif(preg_match('/bsd/i',$OS)) {
      $OS = 'BSD';
    }else{
      $OS = 'Other';
    }
    return $OS;
  }
}