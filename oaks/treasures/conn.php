<?php
	$servidor = "mysql01.alunoqualittas.com.br";
	$user = "alunoqualittas";
	$senha = "iq976431iq";
	$db = "alunoqualittas";
	$conn = mysql_connect($servidor, $user, $senha) or die("<h1>Falha na Conexão com o Database! </h1>" . mysql_error());
	$banco = mysql_select_db($db, $conn) or die("<h1>Falha na Conexão com a Tabela! </h1>" . mysql_error());
	mysql_query("SET NAMES 'utf8'");
	mysql_query('SET character_set_connection=utf8');
	mysql_query('SET character_set_client=utf8');
	mysql_query('SET character_results=utf8');
?>