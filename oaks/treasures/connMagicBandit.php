<?php
	$servidor2 = "www.magicbandit.com";
	$user2 = "magicban_tricker";
	$senha2 = "trickyheroes";
	$db2 = "magicban_01";
	$connMB = mysql_connect($servidor2, $user2, $senha2) or die("<h1>Falha na Conexão com o Database! </h1>" . mysql_error());
	$bancoMB = mysql_select_db($db2, $connMB) or die("<h1>Falha na Conexão com a Tabela! </h1>" . mysql_error());
	mysql_query("SET NAMES 'utf8'");
	mysql_query('SET character_set_connection=utf8');
	mysql_query('SET character_set_client=utf8');
	mysql_query('SET character_results=utf8');
?>