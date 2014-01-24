<?php require 'elements/header.php' ?>

	<div data-role="page" id="pageone">

		<div data-role="header" data-position="fixed">
			<h1>Login</h1>
		</div>
		<div data-role="content">
			<form action="" id="frmLogin" method="post" autocomplete="off">
				<input type="text" name="playerName" id="playerName" pattern="^[a-zA-Z][a-zA-Z0-9]{3,30}" value="" placeholder="Jogador" required/>
				<input type="password" name="playerPwd" id="playerPwd" value="" placeholder="Senha" required/>
				<div style="display:none">
					<input type="submit" id="sbmLogin" value=""/>
				</div>
				<input type="button" id="btnLogin" value="Jogar"/>
			</form>
			<a href="newPlayer.html" data-rel="dialog" data-transition="pop" data-role="button">Registrar</a>
		</div>

		<script>mbPage = "login";</script>

<?php require 'elements/footer.php' ?>

