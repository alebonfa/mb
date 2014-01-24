<div data-role="page" data-url="contact.html" data-overlay-theme="e">
	<div data-role="header">
		<h1>Contato</h1>
	</div>
	<div data-role="content">
		<form action="" id="frmContact" method="post" autocomplete="off">
			<fieldset data-role="controlgroup">
				<input type="radio" name="contactTarget" id="target01" value="T01" checked="checked" />
				<label for="target01">Sugestões</label>
				<input type="radio" name="contactTarget" id="target02" value="T02" />
				<label for="target02">Reclamações</label>
				<input type="radio" name="contactTarget" id="target03" value="T03" />
				<label for="target03">Dúvidas</label>
				<input type="radio" name="contactTarget" id="target04" value="T04" />
				<label for="target04">Outros</label>
			</fieldset>
			<input type="button" id="btnContact" value="Escrever"/>
		</form>
	</div>

	<script>
		$(document).on('click','#btnContact', function(){
			emailTarget = document.querySelector('input[name="contactTarget"]:checked').value;
			switch (emailTarget)
			{
				case "T01":
					document.location.href = "mailto:sugestoes@magicbandit.com";
					break;
				case "T02":
					document.location.href = "mailto:reclamacoes@magicbandit.com";
					break;
				case "T03":
					document.location.href = "mailto:duvidas@magicbandit.com";
					break;
				default:
					document.location.href = "mailto:master@magicbandit.com";
					break;
			}
	    });
	</script>

</div>

