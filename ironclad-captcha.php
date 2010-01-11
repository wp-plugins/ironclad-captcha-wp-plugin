<?php
/*
Plugin Name: Ironclad CAPTCHA
Plugin URI: http://www.securitystronghold.com/products/ironclad-captcha/
Description: 3D objects-based CAPTCHA to get rid of spam in comments. Totally unpenetrable because of 3D objects rendered in realtime. Easy for humans, impossible for bots.
Version: 1.0
Author: Andrey Yeriomin
Copyright 2010 Security Stronghold
*/

register_activation_hook(__FILE__,'aymetatags_install');

function ironclad_captcha_css()
{
	if (!defined('WP_CONTENT_URL')) define('WP_CONTENT_URL', get_option('siteurl').'/wp-content');
	$path = WP_CONTENT_URL.'/plugins/ironclad-captcha/captcha.css';
	print '<link rel="stylesheet" type="text/css" href="'.$path.'" />'."\r\n";
}

function ironclad_captcha_admin()
{
	add_options_page('Ironclad CAPTCHA','Ironclad CAPTCHA',8,__FILE__,'ironclad_captcha_options');
}

function ironclad_captcha_options()
{
	if (!defined('WP_CONTENT_URL')) define('WP_CONTENT_URL', get_option('siteurl').'/wp-content');
	global $IroncladCaptcha;
	$text = '';
	if (isset($_POST['ironclad_captcha_button']))
	{
		update_option('ironclad_captcha_api_key',$_POST['apikey']);
		$text .= 'API key saved.<br /><br />';
	}
	$apikey = get_option('ironclad_captcha_api_key');
	if (!$IroncladCaptcha->check_api_key($apikey)) $text .= '<span style="color: #DD0000; font-weight: bold;">Ironclad CAPTCHA is not active now. Please enter a valid API key.</span><br />You can get it in Ironclad CAPTCHA control panel fo free. Sign up or log in with the links below.';
?>
<form id="ironclad_captcha_options_form" name="ironclad_captcha_options_form" method="post" action="">
<div align="center">
<h3>Ironclad CAPTCHA</h3>
<?php if (!empty($text)) print '<p>'.$text.'</p>'; ?>
<p>API key for <strong><?=$_SERVER['HTTP_HOST'];?></strong>:</p>
<p><input type="text" name="apikey" id="apikey" value="<?=$apikey;?>" maxlength="33" style="width: 300px;" /></p>
<p><input type="submit" name="ironclad_captcha_button" id="ironclad_captcha_button" /></p>
<p>Important installation and look and feel tweaking notes are contained in <a href="<?=WP_CONTENT_URL.'/plugins/ironclad-captcha/readme.txt';?>">Readme</a>.</p>
<p><a href="http://www.securitystronghold.com/products/ironclad-captcha/">About Ironclad CAPTCHA</a></p>
<p><a href="http://www.securitystronghold.com/products/ironclad-captcha/signup/">Sign up for API key (required)</a> | <a href="http://www.securitystronghold.com/products/ironclad-captcha/login/">Log in</a></p>
<p><a href="http://www.securitystronghold.com/">Security Stronghold</a></p>
</div>
</form>
<?php
}

add_option('ironclad_captcha_api_key', '');
add_action('admin_menu', 'ironclad_captcha_admin');
add_action('wp_head', 'ironclad_captcha_css');

include_once('ironclad_captcha_lib.php');

class ironclad_captcha
{

	function ironclad_captcha()
	{
		add_action('comment_form', array('ironclad_captcha', 'print_form'), 10);
		add_action('comment_post', array('ironclad_captcha', 'comment_post'));
	}

	function get_api_key()
	{
		global $IroncladCaptcha;
		return get_option('ironclad_captcha_api_key');
	}

	function print_form($post_id)
	{
		global $IroncladCaptcha,$apikey;
		$api_key = $IroncladCaptcha->get_api_key();
		if (!$IroncladCaptcha->check_api_key($api_key)) return;
		print ironclad_captcha_get_form($api_key);
	}
	
	function check_api_key($key)
	{
		$p = '/^IRONCLAD-CAPTCHA-[A-Z]{5}-[0-9]{10}$/ix';
		return preg_match($p,$key);
	}

	function comment_post($id)
	{
		global $IroncladCaptcha;
		$api_key = $IroncladCaptcha->get_api_key();
		if (!$IroncladCaptcha->check_api_key($api_key)) return $id;
		$result = ironclad_captcha_check($api_key,$_POST['ironclad_captcha_vx'],$_POST['ironclad_captcha_input1'],$_POST['ironclad_captcha_input2'],$_POST['ironclad_captcha_input3']);
		if ($result) return $id;
		wp_set_comment_status($id, 'delete');
?>
<html>
<head>
<title>You did not pass a test</title>
</head>
<body>
<p>You did not pass a human test.</p>
<p><a href="javascript:history.go(-1);">&laquo; Go back and try again</a></p>
<script type="text/javascript">
<!--
alert("You did not pass a human test. Please try again.");
history.go(-1);
-->
</script>					
</body>
</html>
<?php
		exit();
	}

}

$IroncladCaptcha = new ironclad_captcha;
?>