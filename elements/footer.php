		<div data-role="footer" data-position="fixed" data-id="mainMenu" data-tap-toggle="false">
			<div data-role="navbar">
				<ul>
					<li><a href='closeAcorns.php' data-icon="grid" data-ajax="false" data-transition="slidefade">Coleta</a></li>
					<li><a href='ranking.php' data-icon="star" data-ajax="false" data-transition="slidefade">Ranking</a></li>
					<li><a href="contact.php" data-rel="dialog" data-icon="gear" data-transition="pop">Contato</a></li>
					<!--
					<li><a href='mailto:master@magicbandit.com' data-ajax="false" data-icon="gear" data-transition="slidefade">Contato</a></li>
					-->
				</ul>
			</div>
		</div>

		<div data-role="panel" data-position-fixed="true" data-theme="a" id="nav-panel">
	        <ul data-role="listview" data-theme="a" class="nav-search">
	            <li data-icon="delete"><a href="#" data-rel="close">Fechar Menu</a></li>
	            <li><a href="#">Meu Perfil</a></li>
	            <li><a id="btnLogout" href=""  data-ajax="false">Sair</a></li>
	            <h4>Administração</h4>
	            <li><a id="admNewPlayers" href="admNewPlayers.php">Novos Jogadores</a></li>
	            <li><a href="admNewColects.php" data-ajax="false">Coletas / Cidades</a></li>
	            <li><a href="admColPlaces.php" data-ajax="false">Coletas / Places</a></li>
	            <li><a href="" data-ajax="false">Perguntas Bônus</a></li>
	        </ul>
	    </div>

	</div>

	<script src="js/modernizr.js"></script>
    <script src="js/underscore-min.js"></script>
	<script src="js/jquery-1.10.2.min.js"></script>
	<script src="js/jquery.mobile-1.3.2.min.js"></script>
    <script src="http://maps.googleapis.com/maps/api/js?sensor=true"></script> 
    <script src="countdown/jquery.countdown.js"></script>
	<script src="countdown/jquery.countdown-pt-BR.js"></script>

    <script src="js/app.js"></script>

    <script>
		$(document).on('click','#btnLogout', function(){
			mbDeviceID = localStorage.getItem('magicBanditID');
			$.ajax({
				type: "POST",
				dataType: "json",
				url: "php/removeDevice.php",
				data: {
					myGuid: mbDeviceID,
				},
				cache: false,
		        success: function(msg){
		            if (msg['status'] == "success") {
		            	sessionStorage.clear();
					    window.location.href="index.php";
		            }
		        }
			});
		});
    </script>

</body>
</html>
