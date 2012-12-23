<!doctype html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<title>Reclamações Procon - Consulte antes da sua próxima compra!</title>
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
		<h1>Reclamações Procon</h1>
		<form action="#">
			<input type="text" name="busca" id="buscar" placeholder="Busque aqui a empresa, o assunto ou problema">
			<button id="efetuar_busca" type="submit">Buscar</button>
		</form>
	</header>
	<section class="centro">
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