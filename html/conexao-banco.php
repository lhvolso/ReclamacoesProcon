<?php
	$raiz = "/ReclamacoesProcon/html/";
	function conectarBanco()
	{
		$ini = parse_ini_file('config.ini');
		$link = mysql_connect($ini['host'], $ini['usuario'], $ini['senha']);
		if (!$link)
		    die('Não foi possível conectar: ' . mysql_error());
		mysql_select_db($ini['banco'], $link); 
		return $link;
	}
?>