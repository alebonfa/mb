<?php require 'elements/header.php' ?>

	<div data-role="page" id="pageone">

	    <div data-role="header" data-position="fixed" data-tap-toggle="false">
	        <a href="#nav-panel" data-icon="bars" data-iconpos="notext">Menu</a>
			<h1>ADM Coletas / Cidades</h1>
	        <div data-role="navbar">
	        	<ul>
	        		<li><a href="#" id="adm02Day" class="ui-btn-active ui-state-persist">Dia</a></li>
	        		<li><a href="#" id="adm02Week">Semana</a></li>
	        		<li><a href="#" id="adm02Always">Sempre</a></li>
	        	</ul>
	        </div>
	    </div>

		<div data-role="content">
		    <ul id="admList" data-role="listview"></ul>
		</div>

		<script>mbPage = "adm02"</script>

<?php require 'elements/footer.php' ?>