<?php require 'elements/header.php' ?>

	<div data-role="page" id="pageone">

		<div data-role="header" data-position="fixed">
			<h1>Login</h1>
		</div>
		<div data-role="content">
			<form action="php/authentication.php" method="post" autocomplete="off">
				<input type="text" name="playerName" id="playerName" value="" placeholder="Jogador"/>
				<input type="password" name="playerPwd" id="playerPwd" value="" placeholder="Senha"/>
				<input type="submit" value="Jogar"/>
			</form>
			<a href="newPlayer.html" data-rel="dialog" data-transition="pop" data-role="button">Registrar</a>
		</div>

<?php require 'elements/footer.php' ?>