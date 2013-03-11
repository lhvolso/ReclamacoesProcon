<?php
include "conexao-banco.php";
$conexao = conectarBanco();
	$emp = str_replace("-", " ", strtolower($_GET['empresa']));
	$resultado = mysql_query("SELECT COUNT(DISTINCT strNomeFantasia) qtde_registros FROM dados_importados
							where lower(replace(strNomeFantasia, ',', '')) LIKE '%" . $emp . "%'", $conexao);
	while ($linha = mysql_fetch_assoc($resultado))
		$qtde_registros = $linha['qtde_registros'];

	$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

	if($qtde_registros <= 10){
		$txtPagina = ' Página única';
	}else{
		$txtPagina = ' Página ' .  $pagina;
	}

?>
<!DOCTYPE HTML>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<title>Busca por: <?php echo ucwords($_GET['empresa']) . ' - ' . $txtPagina; ?> - Reclamações Procon</title>
	<meta name="keywords" content="procon, pesquisa, reclamações">
	<meta name="description" content="Resultados da pesquisa por: <?php echo ucwords($_GET['empresa']); ?>">
	<meta name="revisit-after" content="7 days">
	<meta name="robots" content="noindex">
	<meta name="author" content="Group VOID">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0">
	<meta property="og:image" content="imagens/logo-reclamacoes-procon-facebook.png">
	<link rel="stylesheet" href="<?php echo $raiz; ?>css/layout-inicio-min.css">
	<link href="http://fonts.googleapis.com/css?family=Maven+Pro:400,700" rel="stylesheet" type="text/css">
	<!--[if lt IE 9]><script type="text/javascript" src="<?php echo $raiz; ?>js/html5.js"></script><![endif]-->
	<script src="<?php echo $raiz; ?>js/jquery.js"></script>
	<!--[if lt IE 9]><script type="text/javascript" src="<?php echo $raiz; ?>js/mediaqueries-min.js"></script><![endif]-->
	<script src="<?php echo $raiz; ?>js/ios-bug-min.js"></script>
	<script type="text/javascript">
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-16951438-4']);
	_gaq.push(['_trackPageview']);
	(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();
	</script>
</head>
<body class="resultados">
	<header>
		<div class="wrap">
			<h1><a href="/">Reclamações Procon</a></h1>
			<a href="/ajuda-sobre-conteudo.php" class="ajuda">Ajuda sobre o conteúdo</a>
		</div>
	</header>
	<form action="<?php echo $raiz; ?>" class="wrap">
		<label for="busca">Pesquise o nome da empresa</label>
		<input type="text" name="pesquisa" id="busca" placeholder="PESQUISE O NOME DA EMPRESA" autocomplete="off" required>
		<button type="submit">BUSCAR</button>
	</form>
	<div class="conteudo">
		<ol>
			<?php
				if(mysql_num_rows($resultado) <= 0)
					header("location:pagina-nao-encontrada.php");

				mysql_free_result($resultado);
				mysql_close($conexao);

				$conexao = conectarBanco();
				$relevancia = "(sum(case when strNomeFantasia = '" . $emp . "' then 10000000 else 0 end) +";
				foreach(explode(" ", $emp) as $termo)
				{
					$relevancia .= "sum(case when strNomeFantasia LIKE '% " . $termo . "' then 10000 else 0 end) + ";
					$relevancia .= "sum(case when strNomeFantasia LIKE '% " . $termo . " %' then 1000 else 0 end) + ";
					$relevancia .= "sum(case when strNomeFantasia LIKE '" . $termo . " %' then 100000 else 0 end) + ";
					$relevancia .= "sum(case when strNomeFantasia LIKE '%" . $termo . "%' then 1 else 0 end) + ";
				}

				$relevancia .= "0) imp";
				$resultado = mysql_query("select qtde_reclamacoes, strNomeFantasia, DescCNAEPrincipal,
										" . $relevancia . " 
										from (SELECT COUNT(id) qtde_reclamacoes, strNomeFantasia, DescCNAEPrincipal 
										FROM dados_importados
										where lower(replace(strNomeFantasia, ',', '')) LIKE '%" . $emp . "%'
										GROUP BY strNomeFantasia) t group by strNomeFantasia ORDER BY imp desc, qtde_reclamacoes DESC LIMIT " . 
										(($pagina - 1) * 10) . ", 10", $conexao);

				$i = 0;
				$lista_empresas = array();

				while ($linha = mysql_fetch_assoc($resultado))
				{
					$strNomeFantasia = $linha['strNomeFantasia'];
					if(in_array($strNomeFantasia, $lista_empresas))
						continue;

					$lista_empresas[$i] = $strNomeFantasia;
					$i++;

					$empresa = str_replace(array(")", "(", ".", "/", " ", ","), "-", utf8_encode($strNomeFantasia));
					$empresa = rtrim(str_replace(array('à','á','â','ã','ä', 'ç', 'è','é','ê','ë', 'ì','í','î','ï', 'ñ', 'ò','ó','ô','õ','ö', 'ù','ú','û','ü',
												'ý','ÿ', 'À','Á','Â','Ã','Ä', 'Ç', 'È','É','Ê','Ë', 'Ì','Í','Î','Ï', 'Ñ', 'Ò','Ó','Ô','Õ','Ö', 'Ù','Ú','Û','Ü', 'Ý',
												'*', '&', '"',"'", '@', '#', '$', '%', '¨', '_', '+', '!', '{', '}', '[', ']', 'ª', 'º', '|', '>', '<', ':', ';'), 
											array('a','a','a','a','a', 'c', 'e','e','e','e', 'i','i','i','i', 'n', 'o','o','o','o','o', 'u','u','u','u',
												'y','y', 'A','A','A','A','A', 'C', 'E','E','E','E', 'I','I','I','I', 'N', 'O','O','O','O','O', 'U','U','U','U', 'Y',
												'', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''), 
											$empresa), "-");
					$empresa = str_replace("--", "-", str_replace("---", "-", $empresa));
					if($qtde_registros == 1)
						header("location: /". $url . $empresa);

					echo "<li " . (($i == mysql_num_rows($resultado)) ? "class='semborda'" : "") . ">
							<a href='" . $raiz . strtolower($empresa) . "'>
								<h2>" . ucwords(utf8_encode($strNomeFantasia)) . "</h2>
								<p class='reclamacoes'>" . $linha['qtde_reclamacoes'] . ($linha['qtde_reclamacoes'] == "1" ? " reclamação" : " reclamações") . "</p>
								<p>" . utf8_encode($linha['DescCNAEPrincipal']) . "</p>
							</a>
						</li>";
				}

				if($qtde_registros == 0)
					echo "<li class='semborda'><h2 class='naoencontrado'>Não foram encontrados resultados para a empresa: <strong>" . str_replace("-", " ", strtolower($_GET['empresa'])) . "</strong></h2></li>";

				mysql_free_result($resultado);
				mysql_close($conexao);
			?>
		</ol>
		<?php 

			echo "<ul class='paginacao'>";
			if($pagina > 1)
				echo "<li class='anterior'><a href='" . "http://" . $_SERVER['HTTP_HOST'] . 
						str_replace($pagina, $pagina - 1, $_SERVER['REQUEST_URI']) . 
					"'><span>Página </span>Anterior</a></li>";

			for($i = 1; $i <= ceil($qtde_registros / 10); $i++)
				echo "<li><a href='" . "http://" . $_SERVER['HTTP_HOST'] . 
					(isset($_GET['pagina']) ? str_replace($pagina, $i, $_SERVER['REQUEST_URI']) : $_SERVER['REQUEST_URI'] . "/" . $i) . 
					"' " . ($pagina == $i ? "class='ativo'" : "") . "><span>Página </span>" . $i . "</a></li>";

			if($pagina < (int)($qtde_registros / 10))
				echo "<li class='proxima'><a href='" . "http://" . $_SERVER['HTTP_HOST'] . 
						(!isset($_GET['pagina']) ? (rtrim($_SERVER['REQUEST_URI'], "/") . "/2") : str_replace($pagina, $pagina + 1, $_SERVER['REQUEST_URI'])) . 
					"'>Próxima <span> Página</span></a></li></ul>";
		?>
	</div>
</body>
</html>