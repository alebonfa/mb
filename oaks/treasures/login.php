<?php require 'header.php' ?>

	<div data-role="page" id="pageone">

		<div data-role="header">
			<h1>Login</h1>
		</div>
		<div data-role="content">
			<form action="authentication.php" method="post">
				<input type="text" name="playerName" id="playerName" value="" placeholder="Jogador"/>
				<input type="password" name="playerPwd" id="playerPwd" value="" placeholder="Senha"/>
				<input type="submit" value="Entrar"/>
			</form>
		</div>

<?php require 'footer.php' ?>