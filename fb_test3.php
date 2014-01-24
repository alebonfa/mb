<?php

$appID = '390907424378928';

setcookie('fbsr_' . $appID, '', time()-3600, '/', '.'.$_SERVER['SERVER_NAME']);

include_once 'libs/facebook/src/facebook.php';

$facebook = new Facebook(array(
  'appId'  => '390907424378928',
  'secret' => 'cb62dc04dd6104b49ef5049bed89183f',
  'cookie' => true
));
$accessToken = $facebook->getAccessToken();

// Get User ID
$user = $facebook->getUser();

// We may or may not have this data based on whether the user is logged in.
// If we have a $user id here, it means we know the user is logged into
// Facebook, but we don't know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}

// Login or logout url will be needed depending on current user state.
if ($user) {
  $params = array(
    'next' => 'http://localhost:81/mb/fb_logout.php?appID='.$appID,
    'redirect_uri' => 'http://localhost:81/mb/fb_test3.php'
  );
  $logoutUrl = $facebook->getLogoutUrl($params);
} else {
  $params = array(
    'scope' => 'email,user_birthday,status_update,read_stream,publish_stream',
    'redirect_uri' => 'http://localhost:81/mb/fb_test3.php'
  );
  $loginUrl = $facebook->getLoginUrl($params);
}

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    // $statusUpdate = $facebook->api("/".$user."/feed", "POST", array('message' => 'FACEBOOK SDK'));
    $statusUpdate = $facebook->api("/me/feed", "POST", array('message' => 'CHOBA WORKS!!!'));
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}

?>

<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
    <title></title>
  </head>
  <body>    
    <?php if ($user): ?>
      <a href="<?php echo $logoutUrl; ?>">Logout</a>
    <?php else: ?>
      <div>
        <a href="<?php echo $loginUrl; ?>">Login with Facebook</a>
      </div>
    <?php endif ?>

    <h3>PHP Session</h3>

    <pre><?php print_r($_SESSION); ?></pre>

    <pre><?php 'CHOBA SENSE ' . print_r($statusUpdate); ?></pre>

    <?php if ($user): ?>
      <h3>You</h3>
      <img src="https://graph.facebook.com/<?php echo $user; ?>/picture">

      <h3>Your User Object (/me)</h3>
      <pre><?php print_r($user_profile); ?></pre>
    <?php else: ?>
      <strong><em>You are not Connected.</em></strong>
    <?php endif ?>

  </body>
</html>