<?php
/**
 * global.func.php 公共方法
 * ----------------------------------------------------------------
 * OldCMS,site:http://www.oldcms.com
 */
if(!defined('IN_OLDCMS')) die('Access Denied');


function UrlInvite($inviteKey){
	return URL_ROOT.(URL_REWRITE ? "/register/{$inviteKey}" : "/xss.php?do=register&key={$inviteKey}");
}

//获取IP QQ:411161555   哥不能在详细了，这个获取脚本已经几乎可以了。
function get_ipip() {
	$ip = "";
	if(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown') && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['REMOTE_ADDR'])){
		$ip = $_SERVER['REMOTE_ADDR'];
	} elseif(isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR']) AND preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
		foreach ($matches[0] AS $xip) {
			if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
				$ip = $xip;
				break;
			}
		}
	} elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')){
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}

/*把IP地址转化为实际地址 QQ:411161555*/
function adders($str) {
$ip = file_get_contents("http://ip.taobao.com/service/getIpInfo.php?ip=".$str);
$ip = json_decode($ip,true);    //翻译JSON格式
/* if(empty($ip)){
	$ip = file_get_contents("http://ip.taobao.com/service/getIpInfo.php?ip=".$str);
	$ip = json_decode($ip,true);    //翻译JSON格式
} */
//$ip = $ip['data']['country'].$ip['data']['region']." ".$ip['data']['city'].$ip['data']['isp'];   //调用数组
        // 这里是调用国家              省                     市                  ISP服务商
	if($ip['data']['region']){
		$ip = $ip['data']['region']." ".$ip['data']['city'];  
	}else{
		$ip = $ip['data']['country']." ".$ip['data']['country_id'];   
	}
return $ip;
}
?>