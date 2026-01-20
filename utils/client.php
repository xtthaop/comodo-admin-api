<?php

Class Client {
  public function getIpAddress(){
    // 1. 优先使用 REMOTE_ADDR (最安全)
    $ip = $_SERVER['REMOTE_ADDR'];

    // 如果确认服务器在代理/负载均衡后面才查看 X-Forwarded-For
    if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
      // X-Forwarded-For 可能是 "client, proxy1, proxy2" 格式
      $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
      // 取第一个 IP (通常是客户端原始 IP)
      $temp_ip = trim($ips[0]);
      
      // 验证 IP 格式是否合法
      if(filter_var($temp_ip, FILTER_VALIDATE_IP)){
        $ip = $temp_ip;
      }
    }

    return $ip;
  }

  public function getBrowser(){
    $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $browser = "未知浏览器";
    $version = "";

    if(stripos($ua, 'MSIE') !== false){ // IE 10 or below
      $browser = 'IE';
      preg_match('/MSIE\s+([^;)]+)/i', $ua, $regs);
      $version = $regs[1] ?? '';
    }elseif(stripos($ua, 'rv:') !== false && stripos($ua, 'Gecko') !== false){ // IE 11
      $browser = 'IE';
      preg_match('/rv:([\d\.]+)/i', $ua, $regs);
      $version = $regs[1] ?? '';
    }elseif(stripos($ua, 'Edg/') !== false){ // Chromium Edge
      $browser = 'Edge';
      preg_match('/Edg\/([\d\.]+)/i', $ua, $regs);
      $version = $regs[1] ?? '';
    }elseif(stripos($ua, 'OPR/') !== false || stripos($ua, 'Opera/') !== false){
      $browser = 'Opera';
      preg_match('/(OPR|Opera)\/([\d\.]+)/i', $ua, $regs);
      $version = $regs[2] ?? '';
    }elseif(stripos($ua, 'Firefox/') !== false){
      $browser = 'Firefox';
      preg_match('/Firefox\/([\d\.]+)/i', $ua, $regs);
      $version = $regs[1] ?? '';
    }elseif(stripos($ua, 'Chrome/') !== false){
      $browser = 'Chrome';
      preg_match('/Chrome\/([\d\.]+)/i', $ua, $regs);
      $version = $regs[1] ?? '';
    }elseif(stripos($ua, 'Safari/') !== false){
      $browser = 'Safari';
      preg_match('/Version\/([\d\.]+)/i', $ua, $regs);
      $version = $regs[1] ?? '';
    }

    return $version ? "$browser($version)" : $browser;
  }

  public function getOs(){
    $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
    
    // 1. 先判断移动端系统 (因为它们往往包含桌面系统的关键字)
    if(preg_match('/android/i', $ua)){
      return 'Android';
    } 
    if(preg_match('/(iPhone|iPad|iPod)/i', $ua)){
      return 'iOS';
    }

    // 2. 再判断桌面端
    if(preg_match('/window/i', $ua)){ // 匹配 Windows
      return 'Windows';
    } 
    if(preg_match('/mac os x/i', $ua)){ // 明确匹配 Mac 桌面系统
      return 'macOS';
    } 
    if(preg_match('/linux/i', $ua)){
      return 'Linux';
    } 
    if(preg_match('/unix/i', $ua)){
      return 'Unix';
    } 
    if(preg_match('/bsd/i', $ua)){
      return 'BSD';
    }

    return 'Other';
  }
}