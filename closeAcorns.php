<?php require 'elements/header.php' ?>

	<div data-role="page" id="pageone">

	    <div data-role="header" data-position="fixed" data-tap-toggle="false">
	        <a href="#nav-panel" data-icon="bars" data-iconpos="notext">Menu</a>
			<h1>Coleta</h1>
	        <a id="btnPlayerName" href="#" class="ui-btn-right">Player</a>
	    </div>

		<div data-role="content">
		    <ul id="placeList" data-role="listview"></ul>
		</div>

		<script>mbPage = "colect";</script>

<?php require 'elements/footer.php' ?>