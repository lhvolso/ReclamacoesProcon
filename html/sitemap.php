<?php
	function conectarBanco()
	{
		$ini = parse_ini_file('config.ini');
		$link = mysql_connect($ini['host'], $ini['usuario'], $ini['senha']);
		if (!$link)
			die('Não foi possível conectar: ' . mysql_error());
		mysql_select_db($ini['banco'], $link);
		return $link;
	}

	$conexao = conectarBanco();
	$resultado = mysql_query("SELECT strNomeFantasiaUrl, COUNT(id) FROM dados_importados GROUP BY strNomeFantasiaUrl order by COUNT(id) DESC LIMIT 0,50", $conexao);

	header("Content-Type: application/xml; charset=UTF-8");	
	$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>" .
				"<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">" .
	   				"<url>" .
      					"<loc>http://www.reclamacoesprocon.com.br/</loc>" .
	      				"<lastmod>2013-04-06</lastmod>" .
	      				"<changefreq>yearly</changefreq>" .
      					"<priority>1.0</priority>" .
	   				"</url>";
	while ($linha = mysql_fetch_assoc($resultado))
			$xml .= "<url>" .
						"<loc>http://www.reclamacoesprocon.com.br/" . $linha['strNomeFantasiaUrl'] . "/</loc>" .
						"<lastmod>2013-04-06</lastmod>" .
						"<changefreq>yearly</changefreq>" .
						"<priority>0.9</priority>" .
					"</url>";
	$xml .= 	"</urlset>";
	//file_put_contents("sitemap.xml", $xml);
	echo $xml;
?>