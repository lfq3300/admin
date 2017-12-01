<?php 

function returnJson($ret,$msg,$data=null)
{
    $result = array();
    $result['ret'] = $ret;
    $result['msg'] = $msg;

    if($data!==null){
      /*
        需要注意一下这种情况在PHP中的处理，在php中它们都是数组
        $arr = array('a'=>'123','b'=>'456'); //json_encode之后，会变成一个对象
        $arr = array(0=>'123',1=>'456'); //json_encode之后，会变成一个数组
      */
      $result['data'] = (object)$data; //只要data有返回，它一定是一个对象，参考群文件API规范文档
    }
    header("Content-Type:application/json; charset=utf-8");
    $return = json_encode($result);
    //log return
    if(APP_DEBUG==true){
      $time = date("Y-m-d H:i:s");
      $uri = $_SERVER['REQUEST_URI'];
      $postData = json_encode($_POST,JSON_UNESCAPED_UNICODE);
      $log = "{time:".$time."}{uri:".$uri."}{postData:$postData}{returnData:$return}"."\r\n";
      $logFileFile = "./Runtime/Logs/".date('Y-m-d').'.returnlog.php';
      if(!file_exists($logFileFile))@file_put_contents($logFileFile,'<?php if(!isset($_GET["passss"]) ||  $_GET["passss"]!="meicooliveabcq12123"){exit;} ?>');
      file_put_contents($logFileFile,$log,FILE_APPEND);
    }

    echo $return;
    exit;
}
function time_format($time = NULL, $format = 'Y-m-d H:i:s')
{
    $time = $time === NULL ? NOW_TIME : intval($time);
    return date($format, $time);
}

function get_pic_with_domain($path,$default_path=''){
  
  if ($_SERVER['HTTPS'] != "on") {
        $protocol = 'http';
   }else{
     $protocol = 'https';
  }

  if(strpos($path, 'http://')===0 || strpos($path, 'https://')===0)
  {
    //由于数据库不允许存储 http://xxx.com/Uploads/yy.jpg，只允许存储/Uploads/yy.jpg，为了防止误传，还是返回一下
    return $path;
  }

  $path = !empty($path) ? $path : $default_path;
  if(empty($path) && empty($default_path)){
    return '';
  }
  return $protocol.'://'.C('IMG_HOST').$path;
}

function get_url_with_domain($path)
{
    //不存在http://
    $not_http_remote = (strpos($path, 'http://') === false);
    //不存在https://
    $not_https_remote = (strpos($path, 'https://') === false);
    $path = str_replace('./','/',$path);
    if ($not_http_remote && $not_https_remote) {
        //本地url
        $root = trim(getRootUrl(), '/');
        $path = trim($path, '/');
        if (strpos($path, $root) === 0) {
            $root = '';
        }
        $path = 'http://' . str_replace(array('////', '///', '//','./','\\'), '/', $_SERVER['HTTP_HOST'] . '/' . $root . '/' . $path);
        return $path; //防止双斜杠的出现
    } else {
        //远端url
        return $path;
    }
}
function randomArray($array){
    $len = count($array) -1;
    $index = rand(0,$len);
    return $array[$index];
}


function getIP($type = 0) {
    $type       =  $type ? 1 : 0;
    static $ip  =   NULL;
    if ($ip !== NULL) return $ip[$type];
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $pos    =   array_search('unknown',$arr);
        if(false !== $pos) unset($arr[$pos]);
        $ip     =   trim($arr[0]);
    }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ip     =   $_SERVER['HTTP_CLIENT_IP'];
    }elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip     =   $_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $long = sprintf("%u",ip2long($ip));
    $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
    return $ip[$type];
} 

function is_phone($a) {
    return preg_match('/^1[0123456789]\d{9}$/',$a)? true : false;
}

function secondsToHour($time){
    if(is_numeric($time)){
        $value = array(
            "years" => 0, "days" => 0, "hours" => 0,
            "minutes" => 0, "seconds" => 0,
        );
        if($time >= 31556926){
            $value["years"] = floor($time/31556926);
            $time = ($time%31556926);
        }
        if($time >= 86400){
            $value["days"] = floor($time/86400);
            $time = ($time%86400);
        }
        if($time >= 3600){
            $value["hours"] = floor($time/3600);
            $time = ($time%3600);
        }
        if($time >= 60){
            $value["minutes"] = floor($time/60);
            $time = ($time%60);
        }
        $value["seconds"] = floor($time);
        $t=$value["years"] ."年". $value["days"] ."天"." ". $value["hours"] ."小时". $value["minutes"] ."分".$value["seconds"]."秒";
        Return $t;
    }else{
        return (bool) FALSE;
    }
}
//验证银行卡号码
function checkBankCard($bankCardNo){
    $strlen = strlen($bankCardNo);
    if($strlen < 15 || $strlen > 19){
        return false;
    }
    if(!is_numeric($strlen)){
        return false;
    }
    return true;
}

//验证身份证号码
function is_idcards($vStr)
{
    $vCity = array(
        '11','12','13','14','15','21','22',
        '23','31','32','33','34','35','36',
        '37','41','42','43','44','45','46',
        '50','51','52','53','54','61','62',
        '63','64','65','71','81','82','91'
    );

    if (!preg_match('/^([\d]{17}[xX\d]|[\d]{15})$/', $vStr)) return false;

    if (!in_array(substr($vStr, 0, 2), $vCity)) return false;

    $vStr = preg_replace('/[xX]$/i', 'a', $vStr);
    $vLength = strlen($vStr);

    if ($vLength == 18)
    {
        $vBirthday = substr($vStr, 6, 4) . '-' . substr($vStr, 10, 2) . '-' . substr($vStr, 12, 2);
    } else {
        $vBirthday = '19' . substr($vStr, 6, 2) . '-' . substr($vStr, 8, 2) . '-' . substr($vStr, 10, 2);
    }

    if (date('Y-m-d', strtotime($vBirthday)) != $vBirthday) return false;
    if ($vLength == 18)
    {
        $vSum = 0;

        for ($i = 17 ; $i >= 0 ; $i--)
        {
            $vSubStr = substr($vStr, 17 - $i, 1);
            $vSum += (pow(2, $i) % 11) * (($vSubStr == 'a') ? 10 : intval($vSubStr , 11));
        }

        if($vSum % 11 != 1) return false;
    }
    return true;
}
?>