<?php
/**
 * Contains added recaptcha_check() function for bypassing observer class if necessary
 * @created_by Jyoti Jain
 * @created_at 15 Sep, 2020
 */
$publickey = RECAPTCHA_SITE_KEY;
$privatekey = RECAPTCHA_SECRET_KEY;

/**
 * Creates the challenge HTML.
 * This is called from the browser, and the resulting reCAPTCHA HTML widget
 * is embedded within the HTML form it was called from.
 * @param boolean $fieldset Should the challenge be wrapped in a fieldset (optional, default is false)
 * @param string $theme Should the reCaptcha be shown in dark or light theme (optional, default is light)
 * @param string $size Should the reCaptcha be shown in compact or normal size (optional, default is normal)
 * @return string - The HTML to be embedded in the user's form.
 */
function recaptcha_get_html($fieldset=false, $theme='light', $size='normal'){
	global $publickey;
	// abort early if not configured
	if($publickey=='ENT'.'ER_YOU'.'R_PUB'.'LIC_K'.'EY_HE'.'RE') return '';
	if(empty($publickey)) return '';

	$recaptcha_html='';
	if($fieldset==true){
		$recaptcha_html.='<fieldset>'."\n";
	}
	$parameters=' class="g-recaptcha" data-sitekey="'.$publickey.'"';
	if($theme!='light'){
		$parameters.=' data-theme="dark"';
	}
	if($size!='normal'){
		$parameters.=' data-size="compact"';
	}
	$recaptcha_html.='<script src="https://www.google.com/recaptcha/api.js" async defer></script>'."\n";
	$recaptcha_html.='<div'.$parameters.'></div>'."\n";
	if($fieldset==true){
		$recaptcha_html.='</fieldset>'."\n";
	}
	return $recaptcha_html;
}

/**
 * Checking ReCaptcha value at Server Side
 */
function recaptcha_check($page = null){
	global $messageStack, $error, $privatekey;

	if($page===null){
		$page = $GLOBALS['current_page_base'];
	}

	require_once DIR_FS_CATALOG . DIR_WS_CLASSES . 'google/autoload.php';
	// This makes use of curl instead
	$recaptcha = new \ReCaptcha\ReCaptcha($privatekey, new \ReCaptcha\RequestMethod\Curl());
	$resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);

	if(!$resp->isSuccess()){
		$event_array = array('contact_us' => 'contact', 'driver' => 'driver', 'restaurant' => 'restaurant');
		$messageStack->add($event_array[$page], $resp->getErrors());
		$error = true;
	}
	return $error;
}
