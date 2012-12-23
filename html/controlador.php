<?php
	if(isset($_POST['action']) && !empty($_POST['action'])) {
	    $action = $_POST['action'];
	    switch($action) {
	        case "todos" : efetuarBusca($_POST['termo'], 'todos', $_POST['sessao']);break;
	        case "empresa" : efetuarBusca($_POST['termo'], 'empresa', $_POST['sessao']);break;
	        case "assunto" : efetuarBusca($_POST['termo'], 'assunto', $_POST['sessao']);break;
	        case "problema" : efetuarBusca($_POST['termo'], 'problema', $_POST['sessao']);break;
	        case "detalheempresa":
	        	parse_str(urldecode(str_replace("?", "", $_POST['url'])), $empresa);
	        	if($_POST['tipo'] == 2)
	         		detalheProblema($empresa['empresa'], $_POST['sessao']);
	         	else if($_POST['tipo'] == 1)
	         		detalheAssunto($empresa['empresa'], $_POST['sessao']);
	         	else
	         		detalheEmpresa($empresa['empresa'], $_POST['sessao']);
	         	break;
	    }
	}

	function efetuarBusca($termo, $tipo, $sessao)
	{
		$conexao = conectarBanco();
		switch ($tipo) {
			case 'todos': 
			$sql = "SELECT * FROM ((SELECT 'Empresa' AS tipo, dados_importados.strNomeFantasia AS titulo, MATCH(dados_importados.strNomeFantasia) AGAINST ('" . $termo . "' IN BOOLEAN MODE) AS relevancia, " .
			"COUNT(dados_importados.id) AS QtdeReclam," .
			"COUNT(distinct dados_importados.DescricaoAssunto) AS QtdeAssuntos," .
			"(SUM((" .
			"SELECT COUNT(" .
				"(" .
					"CASE WHEN di.Atendida = 'S' THEN " .
						"di.id" .
					" ELSE " .
						"NULL" .
					" END " .
				")" .
			") FROM dados_importados di " .
			"WHERE di.id = dados_importados.id" .
			")) / COUNT(dados_importados.id)) * 100 AS atendidas " .
			"FROM dados_importados " .
			"WHERE " .
    
			"strRazaoSocial LIKE '%" . $termo . "%'" .
			" OR strNomeFantasia LIKE '%" . $termo . "%' " .
    
			"OR RazaoSocialRFB LIKE '%" . $termo . "%' ".
			"OR NomeFantasiaRFB LIKE '%" . $termo . "%' ".
			" GROUP BY titulo )" .
			"UNION" .
			"(SELECT 'Assunto' AS tipo, dados_importados.DescricaoAssunto AS titulo, MATCH(dados_importados.strNomeFantasia) AGAINST ('" . $termo . "' IN BOOLEAN MODE) AS relevancia, " .
			"COUNT(DISTINCT dados_importados.strRazaoSocial) AS QtdeReclam," .
			"COUNT(DISTINCT dados_importados.DescricaoProblema) AS QtdeAssuntos," .
			"(SUM((" .
			"SELECT COUNT(".
				"(" .
					"CASE WHEN di.Atendida = 'S' THEN " .
						"di.id" .
					" ELSE " .
						"NULL" .
					" END " .
				")" .
			") FROM dados_importados di" .
			" WHERE di.id = dados_importados.id" .
			")) / COUNT(dados_importados.id)) * 100 AS atendidas" .
			" FROM dados_importados ".
			" WHERE ".
			"DescCNAEPrincipal LIKE '%" . $termo . "%' " .
			"OR DescricaoAssunto LIKE '%" . $termo . "%' ".
			" GROUP BY titulo )".
			"union" .
			"(" .
			"SELECT 'Problema' as tipo, dados_importados.DescricaoProblema AS titulo, MATCH(dados_importados.strNomeFantasia) AGAINST ('" . $termo . "' IN BOOLEAN MODE) AS relevancia, ".
			"COUNT(distinct dados_importados.strRazaoSocial) AS QtdeReclam," .
			"COUNT(distinct dados_importados.DescricaoAssunto) AS QtdeAssuntos," .
			"(SUM((" .
			"SELECT COUNT(" .
				"(".
					"CASE WHEN di.Atendida = 'S' THEN ".
						"di.id".
					" ELSE ".
						"NULL".
					" END ".
				")".
			") FROM dados_importados di".
			" WHERE di.id = dados_importados.id" .
			")) / COUNT(dados_importados.id)) * 100 AS atendidas".
			" FROM dados_importados ".
			"WHERE ".
			"DescricaoProblema LIKE '%" . $termo . "%'".
			" GROUP BY titulo " .
			")".
			") AS tabela ".
			"WHERE titulo <> '' AND titulo IS NOT NULL" .
			" ORDER BY relevancia DESC ";
				# code...
				break;
			
			case 'empresa': 
			$sql = "SELECT 'Empresa' AS tipo, dados_importados.strNomeFantasia AS titulo, MATCH(dados_importados.strNomeFantasia) AGAINST ('" . $termo . "' IN BOOLEAN MODE) AS relevancia, " .
			"COUNT(dados_importados.id) AS QtdeReclam," .
			"COUNT(distinct dados_importados.DescricaoAssunto) AS QtdeAssuntos," .
			"(SUM((" .
			"SELECT COUNT(" .
				"(" .
					"CASE WHEN di.Atendida = 'S' THEN " .
						"di.id" .
					" ELSE " .
						"NULL" .
					" END " .
				")" .
			") FROM dados_importados di " .
			"WHERE di.id = dados_importados.id" .
			")) / COUNT(dados_importados.id)) * 100 AS atendidas " .
			"FROM dados_importados " .
			"WHERE " .
    
			"strRazaoSocial LIKE '%" . $termo . "%'" .
			" OR strNomeFantasia LIKE '%" . $termo . "%' " .
    
			"OR RazaoSocialRFB LIKE '%" . $termo . "%' ".
			"OR NomeFantasiaRFB LIKE '%" . $termo . "%' ".
			" GROUP BY titulo " .
			" ORDER BY relevancia DESC ";break;

			case 'assunto':
			$sql = "SELECT 'Assunto' AS tipo, dados_importados.DescricaoAssunto AS titulo, MATCH(dados_importados.strNomeFantasia) AGAINST ('" . $termo . "' IN BOOLEAN MODE) AS relevancia, " .
			"COUNT(DISTINCT dados_importados.strRazaoSocial) AS QtdeReclam," .
			"COUNT(DISTINCT dados_importados.DescricaoProblema) AS QtdeAssuntos," .
			"(SUM((" .
			"SELECT COUNT(".
				"(" .
					"CASE WHEN di.Atendida = 'S' THEN " .
						"di.id" .
					" ELSE " .
						"NULL" .
					" END " .
				")" .
			") FROM dados_importados di" .
			" WHERE di.id = dados_importados.id" .
			")) / COUNT(dados_importados.id)) * 100 AS atendidas" .
			" FROM dados_importados ".
			" WHERE ".
			"DescCNAEPrincipal LIKE '%" . $termo . "%' " .
			"OR DescricaoAssunto LIKE '%" . $termo . "%' ".
			" GROUP BY titulo " .
			" ORDER BY relevancia DESC ";break;

			case 'problema':
			$sql = "SELECT 'Problema' as tipo, dados_importados.DescricaoProblema AS titulo, MATCH(dados_importados.strNomeFantasia) AGAINST ('" . $termo . "' IN BOOLEAN MODE) AS relevancia, ".
			"COUNT(distinct dados_importados.strRazaoSocial) AS QtdeReclam," .
			"COUNT(distinct dados_importados.DescricaoAssunto) AS QtdeAssuntos," .
			"(SUM((" .
			"SELECT COUNT(" .
				"(".
					"CASE WHEN di.Atendida = 'S' THEN ".
						"di.id".
					" ELSE ".
						"NULL".
					" END ".
				")".
			") FROM dados_importados di".
			" WHERE di.id = dados_importados.id" .
			")) / COUNT(dados_importados.id)) * 100 AS atendidas".
			" FROM dados_importados ".
			"WHERE ".
			"DescricaoProblema LIKE '%" . $termo . "%'".
			" GROUP BY titulo " .
			" ORDER BY relevancia DESC ";break;
		}

		$resultado = mysql_query(
			$sql
		, $conexao);
		mysql_query("INSERT INTO termos_pesquisados(termo, sessao, data_hora, tipo_pesquisa) VALUES('" . $termo . "', " . $sessao . ", (SELECT NOW()), '" . $tipo . "')");
		$itens = array();
		while ($linha = mysql_fetch_assoc($resultado))
		    $itens[] = array('titulo' => utf8_encode($linha['titulo']), 'QtdeReclam' => $linha['QtdeReclam'], 'QtdeAssuntos' => $linha['QtdeAssuntos'], 'atendidas' => $linha['atendidas'], 'tipo' => $linha['tipo']);
		mysql_free_result($resultado);
		mysql_close($conexao);
		echo json_encode($itens);
	}

	function detalheEmpresa($empresa, $sessao)
	{
		$conexao = conectarBanco();
		$resultado = mysql_query(
			"SELECT COUNT(id) qtde_reclamacoes,".
		"(SUM((".
			"SELECT COUNT(".
				"(".
					"CASE WHEN di.Atendida = 'S' THEN ".
						"di.id".
					 " ELSE ".
						"NULL ".
					 "END ".
				")".
			") FROM dados_importados di ".
			"WHERE di.id = dados_importados.id".
			")) / COUNT(dados_importados.id)".
		") * 100 porc_atendidas,".
		"(".
			"SELECT COUNT(".
				"(".
					"CASE WHEN di.Atendida = 'S' THEN ".
						"di.id".
					 " ELSE ".
						"NULL ".
					 "END ".
				")".
			") FROM dados_importados di ".
			"WHERE di.id = dados_importados.id".
		") qtde_atendidas ".
		" FROM dados_importados ".
		"WHERE strRazaoSocial = '" . urldecode($empresa) . "' ".
		"OR strNomeFantasia = '" . urldecode($empresa) . "' ".
		"OR RazaoSocialRFB = '" . urldecode($empresa) . "' ".
		"OR NomeFantasiaRFB = '" . urldecode($empresa) . "'"
		, $conexao);
		while ($linha = mysql_fetch_assoc($resultado))
		    $item = array('qtde_reclamacoes' => utf8_encode($linha['qtde_reclamacoes']), 'porc_atendidas' => $linha['porc_atendidas'], 
		    	'qtde_atendidas' => $linha['qtde_atendidas']);

		mysql_query("INSERT INTO termos_pesquisados(termo, sessao, data_hora, tipo_pesquisa, e_detalhe) VALUES('" . $empresa . "', " . $sessao . ", (SELECT NOW()), 'empresa', 1)");
		$resultado = mysql_query(
			"SELECT DescricaoProblema, COUNT(id) qtde_reclam" .
		" FROM dados_importados ".
		"WHERE strRazaoSocial = '" . urldecode($empresa) . "' ".
		"OR strNomeFantasia = '" . urldecode($empresa) . "' ".
		"OR RazaoSocialRFB = '" . urldecode($empresa) . "' ".
		"OR NomeFantasiaRFB = '" . urldecode($empresa) . "' " .
		"GROUP BY DescricaoProblema ORDER BY qtde_reclam DESC LIMIT 0,5"
		, $conexao);
		$problemas = array();
		while ($linha = mysql_fetch_assoc($resultado))
		    $problemas[] = array('DescricaoProblema' => utf8_encode($linha['DescricaoProblema']), 'qtde_reclam' => $linha['qtde_reclam']);
		mysql_free_result($resultado);
		$resultado = mysql_query(
			"SELECT DescricaoAssunto, COUNT(id) qtde_reclam" .
		" FROM dados_importados ".
		"WHERE strRazaoSocial = '" . urldecode($empresa) . "' ".
		"OR strNomeFantasia = '" . urldecode($empresa) . "' ".
		"OR RazaoSocialRFB = '" . urldecode($empresa) . "' ".
		"OR NomeFantasiaRFB = '" . urldecode($empresa) . "' " .
		"GROUP BY DescricaoAssunto ORDER BY qtde_reclam DESC LIMIT 0,5"
		, $conexao);
		$assuntos = array();
		while ($linha = mysql_fetch_assoc($resultado))
		    $assuntos[] = array('DescricaoAssunto' => utf8_encode($linha['DescricaoAssunto']), 'qtde_reclam' => $linha['qtde_reclam']);
		mysql_free_result($resultado);
		mysql_close($conexao);
		echo json_encode(array('item' => $item, 'problemas' => $problemas, 'assuntos' => $assuntos, 'empresa' => urldecode($empresa)));
	}

	function detalheProblema($empresa, $sessao)
	{
		$conexao = conectarBanco();
		$resultado = mysql_query(
			"SELECT COUNT(id) qtde_reclamacoes,".
		"(SUM((".
			"SELECT COUNT(".
				"(".
					"CASE WHEN di.Atendida = 'S' THEN ".
						"di.id".
					 " ELSE ".
						"NULL ".
					 "END ".
				")".
			") FROM dados_importados di ".
			"WHERE di.id = dados_importados.id".
			")) / COUNT(dados_importados.id)".
		") * 100 porc_atendidas,".
		"(".
			"SELECT COUNT(".
				"(".
					"CASE WHEN di.Atendida = 'S' THEN ".
						"di.id".
					 " ELSE ".
						"NULL ".
					 "END ".
				")".
			") FROM dados_importados di ".
			"WHERE di.id = dados_importados.id".
		") qtde_atendidas ".
		" FROM dados_importados ".
		"WHERE DescricaoProblema LIKE '%" . urldecode($empresa) . "%'"
		, $conexao);
		while ($linha = mysql_fetch_assoc($resultado))
		    $item = array('qtde_reclamacoes' => utf8_encode($linha['qtde_reclamacoes']), 'porc_atendidas' => $linha['porc_atendidas'], 
		    	'qtde_atendidas' => $linha['qtde_atendidas']);

		mysql_query("INSERT INTO termos_pesquisados(termo, sessao, data_hora, tipo_pesquisa, e_detalhe) VALUES('" . $empresa . "', " . $sessao . ", (SELECT NOW()), 'problema', 1)");
		$resultado = mysql_query(
			"SELECT strRazaoSocial, COUNT(id) qtde_reclam" .
		" FROM dados_importados ".
		"WHERE DescricaoProblema LIKE '%" . urldecode($empresa) . "%'".
		"GROUP BY strRazaoSocial ORDER BY qtde_reclam DESC LIMIT 0,5"
		, $conexao);
		$problemas = array();
		while ($linha = mysql_fetch_assoc($resultado))
		    $problemas[] = array('DescricaoProblema' => utf8_encode($linha['strRazaoSocial']), 'qtde_reclam' => $linha['qtde_reclam']);
		mysql_free_result($resultado);
		$resultado = mysql_query(
			"SELECT DescricaoAssunto, COUNT(id) qtde_reclam" .
		" FROM dados_importados ".
		"WHERE DescricaoProblema LIKE '%" . urldecode($empresa) . "%'".
		"GROUP BY DescricaoAssunto ORDER BY qtde_reclam DESC LIMIT 0,5"
		, $conexao);
		$assuntos = array();
		while ($linha = mysql_fetch_assoc($resultado))
		    $assuntos[] = array('DescricaoAssunto' => utf8_encode($linha['DescricaoAssunto']), 'qtde_reclam' => $linha['qtde_reclam']);
		mysql_free_result($resultado);
		mysql_close($conexao);
		echo json_encode(array('item' => $item, 'problemas' => $problemas, 'assuntos' => $assuntos, 'empresa' => urldecode($empresa)));
	}

	function detalheAssunto($empresa, $sessao)
	{
		$conexao = conectarBanco();
		$resultado = mysql_query(
			"SELECT COUNT(id) qtde_reclamacoes,".
		"(SUM((".
			"SELECT COUNT(".
				"(".
					"CASE WHEN di.Atendida = 'S' THEN ".
						"di.id".
					 " ELSE ".
						"NULL ".
					 "END ".
				")".
			") FROM dados_importados di ".
			"WHERE di.id = dados_importados.id".
			")) / COUNT(dados_importados.id)".
		") * 100 porc_atendidas,".
		"(".
			"SELECT COUNT(".
				"(".
					"CASE WHEN di.Atendida = 'S' THEN ".
						"di.id".
					 " ELSE ".
						"NULL ".
					 "END ".
				")".
			") FROM dados_importados di ".
			"WHERE di.id = dados_importados.id".
		") qtde_atendidas ".
		" FROM dados_importados ".
		"WHERE DescCNAEPrincipal LIKE '%" . urldecode($empresa) . "%' " .
			"OR DescricaoAssunto LIKE '%" . urldecode($empresa) . "%' "
		, $conexao);
		while ($linha = mysql_fetch_assoc($resultado))
		    $item = array('qtde_reclamacoes' => utf8_encode($linha['qtde_reclamacoes']), 'porc_atendidas' => $linha['porc_atendidas'], 
		    	'qtde_atendidas' => $linha['qtde_atendidas']);

		mysql_query("INSERT INTO termos_pesquisados(termo, sessao, data_hora, tipo_pesquisa, e_detalhe) VALUES('" . $empresa . "', " . $sessao . ", (SELECT NOW()), 'assunto', 1)");
		$resultado = mysql_query(
			"SELECT strRazaoSocial, COUNT(id) qtde_reclam" .
		" FROM dados_importados ".
		"WHERE DescCNAEPrincipal LIKE '%" . urldecode($empresa) . "%' " .
			"OR DescricaoAssunto LIKE '%" . urldecode($empresa) . "%' ".
		"GROUP BY strRazaoSocial ORDER BY qtde_reclam DESC LIMIT 0,5"
		, $conexao);
		$problemas = array();
		while ($linha = mysql_fetch_assoc($resultado))
		    $problemas[] = array('DescricaoProblema' => utf8_encode($linha['strRazaoSocial']), 'qtde_reclam' => $linha['qtde_reclam']);
		mysql_free_result($resultado);
		$resultado = mysql_query(
			"SELECT DescricaoProblema, COUNT(id) qtde_reclam" .
		" FROM dados_importados ".
		"WHERE DescCNAEPrincipal LIKE '%" . urldecode($empresa) . "%' " .
			"OR DescricaoAssunto LIKE '%" . urldecode($empresa) . "%' ".
		"GROUP BY DescricaoProblema ORDER BY qtde_reclam DESC LIMIT 0,5"
		, $conexao);
		$assuntos = array();
		while ($linha = mysql_fetch_assoc($resultado))
		    $assuntos[] = array('DescricaoAssunto' => utf8_encode($linha['DescricaoProblema']), 'qtde_reclam' => $linha['qtde_reclam']);
		mysql_free_result($resultado);
		mysql_close($conexao);
		echo json_encode(array('item' => $item, 'problemas' => $problemas, 'assuntos' => $assuntos, 'empresa' => urldecode($empresa)));
	}

	function conectarBanco()
	{
		$ini = parse_ini_file('config.ini');
		$link = mysql_connect($ini['host'], $ini['usuario'], $ini['senha']);
		if (!$link) {
		    die('Não foi possível conectar: ' . mysql_error());
		}
		mysql_select_db($ini['banco'], $link); 
		return $link;
	}
?>