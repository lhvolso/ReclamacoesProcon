<!DOCTYPE HTML>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<title>Reclamações</title>
	<meta name="keywords" content="">
	<meta name="description" content="">
	<meta name="revisit-after" content="7 days">
	<meta name="robots" content="noindex">
	<meta name="author" content="Group VOID">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0">
	<link rel="stylesheet" href="css/reset.css">
	<link rel="stylesheet" href="css/layout.css">
	<!--[if lt IE 10]><link rel="stylesheet" href="css/ie.css"><![endif]-->
	<!--[if IE 7]><link rel="stylesheet" href="css/ie7.css"><![endif]-->
	<link href="http://fonts.googleapis.com/css?family=Maven+Pro:400,700" rel="stylesheet" type="text/css">
	<script src="js/html5.js"></script> 
	<!--[if lt IE 9]><script type="text/javascript" src="js/excanvas.min.js"></script><![endif]-->
	<script src="js/graficos.js"></script>
	<script src="js/ios-bug.js"></script>
	<script src="http://code.jquery.com/jquery.min.js"></script>
	<script src="js/bgpos.js"></script>
	<script>
	$('document').ready(function(){
		var valoresIdade = Array();
		var arrayMaiorIdade = Array();
		var somaValoresIdade = 0;
		$('#graficoidade tr').each(function(){
			var valorIdade = parseInt($(this).children('td.valor').html());
			valoresIdade.push(valorIdade);
			arrayMaiorIdade.push(valorIdade);
			somaValoresIdade = somaValoresIdade + valorIdade;
		});
		arrayMaiorIdade.sort(function(a,b){return b - a});
		var constanteIdade = 122 / arrayMaiorIdade[0];
		for(x = 0; x < 4; x++){
		    var desvioIdade = 142 - (constanteIdade * valoresIdade[x]);
		    if(desvioIdade > 122){ desvioIdade = 117; }
		    $('#graficoidade tr:nth-child('+ (x + 1) +') td.valor').animate({
		    	backgroundPosition: 'center ' + desvioIdade,
		    	height: (constanteIdade * valoresIdade[x])+'px',
		    	padding: (122 - (constanteIdade * valoresIdade[x]))+'px 0 0 0'
		    }, 500 );
		}

		var valoresProblema = Array();
		var arrayMaiorProblema = Array();
		var somaValoresProblema = 0;
		$('#graficoproblema tr').each(function(){
			var valorProblema = parseInt($(this).children('td.valor').html());
			valoresProblema.push(valorProblema);
			arrayMaiorProblema.push(valorProblema);
			somaValoresProblema = somaValoresProblema + valorProblema;
		});
		arrayMaiorProblema.sort(function(a,b){return b - a});
		var constanteProblema = 228 / arrayMaiorProblema[0];
		for(x = 0; x < 4; x++){
		    var desvioProblema = -(238 - (constanteProblema * valoresProblema[x]));
		    $('#graficoproblema tr:nth-child('+ (x + 1) +') td.variavel').animate({
		    	backgroundPosition: desvioProblema + ' 0'
		    }, 500 );
		}

		var valoresAssunto = Array();
		var arrayMaiorAssunto = Array();
		var somaValoresAssunto = 0;
		$('#graficoassunto tr').each(function(){
			var valorAssunto = parseInt($(this).children('td.valor').html());
			valoresAssunto.push(valorAssunto);
			arrayMaiorAssunto.push(valorAssunto);
			somaValoresAssunto = somaValoresAssunto + valorAssunto;
		});
		arrayMaiorAssunto.sort(function(a,b){return b - a});
		var constanteAssunto = 228 / arrayMaiorAssunto[0];
		for(x = 0; x < 4; x++){
		    var desvioAssunto = -(238 - (constanteAssunto * valoresAssunto[x]));
		    $('#graficoassunto tr:nth-child('+ (x + 1) +') td.variavel').animate({
		    	backgroundPosition: desvioAssunto + ' 0'
		    }, 500 );
		}
		$('.busca').click(function(){
			$('.buscainterna').css('top', '0');
			$('#busca').focus();
		});
		$('#busca').blur(function(){
			if($(window).width() <= 600){
				$('.buscainterna').css('top', '-37px');
			}
		});
	});
	</script>
</head>
<body onload="carregarGrafico(false, [25, 75], 'grafico_atendimento'), carregarGrafico(true, [55, 45], 'grafico_sexo');">
	<header class="topo">
		<div class="wrap">
			<a href="/" class="logo">Reclamações Procon</a>
			<form action="#" class="buscainterna">
				<label for="busca">Buscar empresa:</label>
				<input type="text" id="busca" name="busca">
				<button type="submit">Buscar</button>
			</form>
			<a class="busca">Exibir Busca</a>
		</div>
	</header>
	<article class="infografico">
		<header>
			<div class="wrap">
				<h1><small>Reclamações da Empresa:</small> TIM Telefonia Celular</h1>
				<h2 class="nota a">Nota do tempo de resposta: <span>E</span></h2>
			</div>
			<div class="fundoheader">
				<p class="wrap">200.000 reclamações</p>
				<!-- <ul class="filtros">
					<li class="wrap divisao">Filtrando somente não atendidas<a href="#">remover este filtro</a></li>
					<li class="wrap">Filtrando somente sexo feminino<a href="#">remover este filtro</a></li>
				</ul> -->
			</div>
		</header>
		<div class="wrap">
			<section class="boxmenor">
				<h2>estado das reclamações</h2>
				<canvas id="grafico_atendimento" width="150" height="150"></canvas>
				<table class="circular atendimento">
					<tbody>
						<tr>
							<td class="variavel">atendidas</td>
							<td class="valor">100%</td>
						</tr>
						<tr>
							<td class="variavel">não atendidas</td>
							<td class="valor">100%</td>
						</tr>
					</tbody>
				</table>
				<a class="linkesq" href="#">Filtrar somente atendidas</a>
				<a class="linkdir" href="#">Filtrar somente não atendidas</a>
			</section>
			<section class="boxmenor">
				<h2>sexo</h2>
				<canvas id="grafico_sexo" width="150" height="150"></canvas>
				<table class="circular sexo">
					<tbody>
						<tr>
							<td class="variavel">masculino</td>
							<td class="valor">100%</td>
						</tr>
						<tr>
							<td class="variavel">feminino</td>
							<td class="valor">100%</td>
						</tr>
					</tbody>
				</table>
				<a class="linkesq mas" href="#">Filtrar somente masculino</a>
				<a class="linkdir fem" href="#">Filtrar somente feminino</a>
			</section>
			<section class="boxmenor margembox idade">
				<h2>idade</h2>
				<table>
					<tbody id="graficoidade">
						<tr>
							<td class="valor">678</td>
							<td class="variavel">até 30 anos</td>
						</tr>
						<tr>
							<td class="valor">896</td>
							<td class="variavel">31 a 60 anos</td>
						</tr>
						<tr>
							<td class="valor">987</td>
							<td class="variavel">mais de 60 anos</td>
						</tr>
						<tr>
							<td class="valor">532</td>
							<td class="variavel">não<br> consta</td>
						</tr>
					</tbody>
				</table>
			</section>
			<section class="boxmaior">
				<h2>principais problemas</h2>
				<table class="horizontal">
					<tbody id="graficoproblema">
						<tr>
							<td class="variavel">Problemas de entrega <small>Atraso ou não entrega</small></td>
							<td class="valor">1810</td>
						</tr>
						<tr>
							<td class="variavel">Problemas de entrega <small>Atraso ou não entrega</small></td>
							<td class="valor">556</td>
						</tr>
						<tr>
							<td class="variavel">Problemas de entrega <small>Atraso ou não entrega</small></td>
							<td class="valor">367</td>
						</tr>
						<tr>
							<td class="variavel">Problemas de entrega <small>Atraso ou não entrega</small></td>
							<td class="valor">262</td>
						</tr>
					</tbody>
				</table>
			</section>
			<section class="boxmaior margembox">
				<h2>principais assuntos</h2>
				<table class="horizontal">
					<tbody id="graficoassunto">
						<tr>
							<td class="variavel">Problemas de entrega <small>Atraso ou não entrega</small></td>
							<td class="valor">659</td>
						</tr>
						<tr>
							<td class="variavel">Problemas de entrega <small>Atraso ou não entrega</small></td>
							<td class="valor">509</td>
						</tr>
						<tr>
							<td class="variavel">Problemas de entrega <small>Atraso ou não entrega</small></td>
							<td class="valor">358</td>
						</tr>
						<tr>
							<td class="variavel">Problemas de entrega <small>Atraso ou não entrega</small></td>
							<td class="valor">193</td>
						</tr>
					</tbody>
				</table>
			</section>
		</div>
	</article>
</body>
</html>