<?php
    session_start();
	require_once "config.php";

	try {
		$accessToken = $helper->getAccessToken();
	} catch (\Facebook\Exceptions\FacebookResponseException $e) {
		echo "Response Exception: " . $e->getMessage();
		exit();
	} catch (\Facebook\Exceptions\FacebookSDKException $e) {
		echo "SDK Exception: " . $e->getMessage();
		exit();
	}

	if (!$accessToken) {
		header('Location: login.php');
		exit();
	}

	$oAuth2Client = $FB->getOAuth2Client();
	if (!$accessToken->isLongLived())
		$accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
	$response = $FB->get("/me?fields=id, first_name, last_name, email, picture.type(large)", $accessToken);
	$userData = $response->getGraphNode()->asArray();

	$imagedata = file_get_contents('fb.jpg');
	$base64img = base64_encode($imagedata);

	$_SESSION['userData'] = $userData;
	$_SESSION['access_token'] = (string) $accessToken;
    $_SESSION['email'] = $_SESSION['userData']['email'];
    $_SESSION['foto'] = $base64img;
    $_SESSION['rol'] = 1;
    $_SESSION['fb'] == 1;
	header('Location: layout2.php');
	exit();
?>