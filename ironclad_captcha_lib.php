<?php
/*
This is a PHP library that handles calling Ironclad CAPTCHA.
Information page: http://www.securitystronghold.com/products/ironclad-captcha/
Copyright (c) 2008-2010 Security Stronghold — http://www.securitystronghold.com/
*/

if (!class_exists('ironclad_captcha_response_class'))
{
class ironclad_captcha_response_class
{
	var $result;
	var $text;
	var $code;
}
}

$ironclad_captcha_response = new ironclad_captcha_response_class();

if (!function_exists('ironclad_captcha_arraytostr'))
{
function ironclad_captcha_arraytostr($arr)
{
	$str = '';
	foreach ($arr as $key => $value)
		$str .= $key.'='.urlencode(stripslashes($value)).'&';
	$str = substr($str,0,strlen($str)-1);
	return $str;
}
}

if (!function_exists('ironclad_captcha_post'))
{
function ironclad_captcha_post($host,$path,$data,$port = 80)
{
	$data = ironclad_captcha_arraytostr($data);
	$http_request  = "POST ".$path." HTTP/1.0\r\n";
	$http_request .= "Host: ".$host."\r\n";
	$http_request .= "Content-Type: application/x-www-form-urlencoded;\r\n";
	$http_request .= "Content-Length: ".strlen($data)."\r\n";
	$http_request .= "\r\n";
	$http_request .= $data;
	
	$response = '';
		$fs = fsockopen($host,$port,$errno,$errstr,10);
	if (!$fs) { return array('<!-- IRONCLAD_CAPTCHA: Could not open socket. -->','<!---->'); }
	fwrite($fs,$http_request);
	
	while (!feof($fs))
		$response .= fgets($fs,1160);
	fclose($fs);
	$response = explode("\r\n\r\n",$response,2);
	return $response;
}
}

if (!function_exists('ironclad_captcha_get_form'))
{
function ironclad_captcha_get_form($key,$params = array())
{
	$res = ironclad_captcha_post("captcha.securitystronghold.com","/captcha-form/",array_merge(array('api_key' => $key, 'host' => $_SERVER['HTTP_HOST']),$params));

	return $res[1];
}
}

if (!function_exists('ironclad_captcha_check'))
{
function ironclad_captcha_check($key,$vx,$a1,$a2,$a3)
{
	$res = ironclad_captcha_post("captcha.securitystronghold.com","/captcha-check/",array('api_key' => $key, 'vx' => $vx, 'a1' => $a1, 'a2' => $a2, 'a3' => $a3, 'host' => $_SERVER['HTTP_HOST']));
	$resp = trim($res[1]);
	$info = explode(":",$resp);
	$result = $info[1];
	global $ironclad_captcha_response;
	$ironclad_captcha_response->result = $result;
	$ironclad_captcha_response->text = $info[2];
	$ironclad_captcha_response->code = $info[3];
	if (($result == 1) || ($result == '<!---->')) { return true; } else { return false; }
}
}
?>