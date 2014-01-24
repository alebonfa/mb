<?php

	include_once 'php/fbmain.php';
	$config['baseurl'] = "localhost:81/mb/profile.php";

	if($fbme) {
		try {
			$movies = $facebook->api('/me/movies');
		} catch(Exception $o) {
			d($o);
		}
	}

	try {
		$param = array(
			'method'   => 'users.getinfo',
			'uids'     => $fbme['id'],
			'fields'   => 'name, current_location, profile_url',
			'callback' => ''
		);
		$userInfo = $facebook->api($param);
	} catch(Exception $o) {
		d($o);
	}

	if (isset($_POST['tt'])) {
		try {
			$statusUpdate = $facebook->api("/me/feed", "POST", array('message' => $_POST['tt']));
		} catch (FacebookApiException $e) {
			d($e);
		}
	}

	try {
		$uid = $facebook->getUser();
		$fql = "select name, hometown_location, sex, pic_square from user where uid=" . $uid;
		$param = array(
			'method'   => 'fql.query',
			'query'    => $fql,
			'callback' => ''
		);
		$fqlResult = $facebook->api($param);
	} catch(Exception $o) {
		d($o);
	}
?>

<?php require 'elements/header.php' ?>

	<div data-role="page" id="pageone">

	    <div data-role="header" data-position="fixed" data-tap-toggle="false">
	        <a href="#nav-panel" data-icon="bars" data-iconpos="notext">Menu</a>
			<h1>Profile</h1>
	        <a id="btnPlayerName" href="#" class="ui-btn-right">Player</a>
	    </div>

		<div data-role="content">

			<div id='fb-root'></div>
			<script>
				window.fbAsyncInit = function() {
					FB.init({appId: '<?=$fbconfig['appid']?>', status: true, cookie: true, xfbml: true});
					FB.Event.subscribe('auth.login', function(response) {
						login();
					});
					FB.Event.subscribe('auth.logout', function(response) {
						logout();
					});
				};
				(function() {
					var e = document.createElement('script');
					e.type = 'text/javascript';
					e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
					e.async = true;
					document.getElementById('fb-root').appendChild(e);
				}());
				function login(){
					document.location.href = "<?=$config['baseurl']?>";
				}
				function logout(){
					document.location.href = "<?=$config['baseurl']?>";
				}
			</script>

			<style type="text/css">
				.box{
					margin: 5px;
					border: 1px solid #60729b;
					padding: 5px;
					width: 500px;
					height: 200px;
					overflow: auto;
					background-color: #e6ebf8;
				}
			</style>

			<h3>PHP SDK & Graph API</h3>

			<?php if(!$fbme) { ?>
				Voce precisa se logar para ver os resultados
			<?php } ?>
			<p>
				<fb:login-button autologoutlink="true" perms="email,user_birthday,status_update,publish_stream"></fb:login-button>
			</p>

			<?php if($fbme) { ?>

				<table border="0" cellspacing="3" cellpadding="3">
					<tr>
						<td>
							<div class="box">
								<b>User likes these movies</b>
								<?php d($movies); ?>
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="box">
								<b>User Information</b>
								<?php d($userInfo); ?>
							</div>
						</td>
						<td>
							<div class="box">
								<b>FQL Query Example</b>
								<?php d($fqlResult); ?>
							</div>
						</td>
					</tr>
				</table>
				<div class="box">
					<form name="" action="<?=$config['baseurl']?>" method="post">
						<label for="tt"> Status update using Graph API</label>
						<br />
						<textarea id="tt" name="tt" cols="50" rows="5">Write your status</textarea>
						<br />
						<input type="submit" value="Upadte My Status" />
					</form>
					<?php if(isset($statusUpdate)) { ?>
						<br />
						<b style="color: red">Status Updated Sucessfully! Status id is <?=$statusUpdate['id']?></b>
					<?php } ?>
				</div>
			<?php } ?>
		</div>

		<script>mbPage = "profile";</script>

<?php require 'elements/footer.php' ?>