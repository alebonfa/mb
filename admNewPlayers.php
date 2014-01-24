<?php require 'elements/header.php' ?>

	<div data-role="page" id="pageone">

	    <div data-role="header" data-position="fixed" data-tap-toggle="false">
	        <a href="#nav-panel" data-icon="bars" data-iconpos="notext">Menu</a>
			<h1>ADM Novos Jogadores</h1>
	        <div data-role="navbar">
	        	<ul>
	        		<li><a href="#" id="adm01Day" class="ui-btn-active ui-state-persist">Dia</a></li>
	        		<li><a href="#" id="adm01Week">Semana</a></li>
	        		<li><a href="#" id="adm01Always">Sempre</a></li>
	        	</ul>
	        </div>
	    </div>

		<div data-role="content">
		    <ul id="admList" data-role="listview"></ul>
		</div>

		<script>mbPage = "adm01"</script>

<?php require 'elements/footer.php' ?>