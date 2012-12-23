<!doctype html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<title>Reclamações da Empresa: SUBMARINO/SHOPTIME/AMERICANAS.COM</title>
	<meta name="keywords" content="">
	<meta name="description" content="">
	<meta name="author" content="Group VOID">
	<meta name="robots" content="noindex">
	<link rel="stylesheet" href="css/reset.css">
	<link rel="stylesheet" href="css/layout.css">
	<link href="http://fonts.googleapis.com/css?family=Maven+Pro:400,700" rel="stylesheet" type="text/css">
	<script src="js/html5shiv.js"></script>
	<script src="js/jquery.js"></script>
	<script src="js/scripts.js"></script>
</head>
<body>
	<header>
		<a href="index.php" class="logo">Página Inicial - Reclamações Procon</a>
		<form action="#">
			<input type="text" name="busca" id="buscar" placeholder="Busque aqui a empresa, o assunto ou problema">
			<button id="efetuar_busca_detalhe" type="submit">Buscar</button>
		</form>
	</header>
	<article id="article_detalhe" class="centro interna">
		<h1>Reclamações <span id="titulo1"></span>: <strong class="titulo_empresa"></strong></h1>
		<p>A empresa <strong class="titulo_empresa"></strong> possui um número total de 
			<strong><span id="qtde_reclam"></span> reclamaç(ão)ões fundamentada(s)</strong>, e, 
			<strong><span id="porc"></span>% não foi(ram) atendida(s)</strong>, totalizando 
			<strong><span id="qtde_atendidas"></span> reclamaç(ão)ões sem atendimento</strong>.</p>
		<h2><span id="titulo2"></span> são:</h2>
		<ul id="problemas_listagem">
		</ul>
		<h2><span id="titulo3"></span>:</h2>
		<ul id="assuntos_listagem">
		</ul>
		<a href="javascript:history.go(-1)" class="voltar">&laquo; Voltar</a>
	</article>
	<section id="detalhe_section" class="centro">
		<!--<a href="#" class="ajuda">Ajuda</a>-->
		<p class="ajuda">As reclamações são divididas em Nome da Empresa, Assunto e Descrição do Problema, utilize os filtros à direita para refinar a busca.</p>
		<p class="titulofiltros">Filtros:</p>
		<ul class="filtros">
			<li><a href="#" class="empresas">Empresas</a></li>
			<li><a href="#" class="assuntos">Assuntos</a></li>
			<li><a href="#" class="problemas">Problemas</a></li>
		</ul>
		<h2 class="numeros">Sua busca por <strong id="termo_pesquisado">digite a palavra</strong> retornou <span id="qtde_resultados">0</span> resultados</h2>
		<ul class="resultados">
		</ul>
		<div class="paginacao">
		</div>
	</section>
</body>
</html>