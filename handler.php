<?php
$sender_name = stripslashes($_POST["name"]);
$sender_email = stripslashes($_POST["email"]);
$sender_message = stripslashes($_POST["msg"]);
$response = $_POST["g-recaptcha-response"];
$url = 'https://www.google.com/recaptcha/api/siteverify';
$data = array(
	'secret' => 'SECRET KEY',
	'response' => $response
);
$options = array(
	'http' => array (
		'method' => 'POST',
		'content' => http_build_query($data)
	)
);
$context  = stream_context_create($options);
$verify = file_get_contents($url, false, $context);
$captcha_success=json_decode($verify);
if ($captcha_success->success==false) {
	echo "<p>You are a bot! Go away!</p>";
} else if ($captcha_success->success==true) {
	$sendto = "beregsys@gmail.com";
	$subject  = "New letter from site";

	$headers = "From: Letter from site <admin@edelweiss-muenchen.com>\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html;charset=utf-8 \r\n";
	$msg = "Name - $sender_name <br>
			Email - $sender_email <br>
			Message - $sender_message
	";
	mail($sendto, $subject, $msg, $headers);
	echo "<p>You are not a bot!</p>";
}