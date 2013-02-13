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

	$str_filtros = "";

	if(isset($_GET['atendidas']))
		switch (strtolower($_GET['atendidas'])) {
			case "atendidas":
				$str_filtros .= " AND Atendida = 'S' ";
				break;
			
			case "nao-atendidas":
				$str_filtros .= " AND Atendida = 'N' ";
				break;

			case "feminino":
				$str_filtros .= " AND SexoConsumidor = 'F' ";
				break;

			case "masculino":
				$str_filtros .= " AND SexoConsumidor = 'M' ";
				break;
		}

	if(isset($_GET['sexo']))
		switch (strtolower($_GET['sexo'])) {
			case "feminino":
				$str_filtros .= " AND SexoConsumidor = 'F' ";
				break;

			case "masculino":
				$str_filtros .= " AND SexoConsumidor = 'M' ";
				break;

			case "atendidas":
				$str_filtros .= " AND Atendida = 'S' ";
				break;
			
			case "nao-atendidas":
				$str_filtros .= " AND Atendida = 'N' ";
				break;
		}

	$conexao = conectarBanco();
	$resultado = mysql_query("select sum(case when Atendida = 'S' then 1 else 0 end) / count(id) * 100 atendidas, 
								sum(case when Atendida = 'N' then 1 else 0 end) / count(id) * 100 nao_atendidas,
								sum(case when SexoConsumidor = 'M' then 1 else 0 end) / count(id) * 100 masculino,
								sum(case when SexoConsumidor = 'F' then 1 else 0 end) / count(id) * 100 feminino,
								count(id) total, strNomeFantasia,
								sum(case when FaixaEtariaConsumidor = 'até 20 anos' or FaixaEtariaConsumidor = 'entre 21 a 30 anos' then 1 else 0 end) ate_30,
								sum(case when FaixaEtariaConsumidor = 'entre 31 a 40 anos' or FaixaEtariaConsumidor = 'entre 41 a 50 anos' or FaixaEtariaConsumidor = 'entre 51 a 60 anos' then 1 else 0 end) 31_60,
								sum(case when FaixaEtariaConsumidor = 'entre 61 a 70 anos' or FaixaEtariaConsumidor = 'mais de 70 anos' then 1 else 0 end) mais_60,
								sum(case when FaixaEtariaConsumidor = 'Nao Informada' then 1 else 0 end) nao_consta,
								datediff(DataArquivamento, DataAbertura) tempo
							from dados_importados 
							where lower(replace(strNomeFantasia, ',', '')) = lower(replace('" . $_GET['empresa'] . "', '-', ' ')) " . $str_filtros . " group by strNomeFantasia", $conexao);

	while ($linha = mysql_fetch_assoc($resultado))
	{
		$atendidas = $linha['atendidas'];
		$nao_atendidas = $linha['nao_atendidas'];
		$masculino = $linha['masculino'];
		$feminino = $linha['feminino'];
		$total = $linha['total'];
		$nome = $linha['strNomeFantasia'];
		$ate_30 = $linha['ate_30'];
		$mais_31 = $linha['31_60'];
		$mais_60 = $linha['mais_60'];
		$nao_consta = $linha['nao_consta'];
		$tempo = $linha['tempo'];
	}

	mysql_free_result($resultado);
	mysql_close($conexao);
?>
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
	<?php $raiz = "/ReclamacoesProcon/html/"; ?>
	<link rel="stylesheet" href="<?php echo $raiz; ?>css/reset.css">
	<link rel="stylesheet" href="<?php echo $raiz; ?>css/layout.css">
	<!--[if lt IE 10]><link rel="stylesheet" href="<?php echo $raiz; ?>css/ie.css"><![endif]-->
	<!--[if IE 7]><link rel="stylesheet" href="<?php echo $raiz; ?>css/ie7.css"><![endif]-->
	<link href="http://fonts.googleapis.com/css?family=Maven+Pro:400,700" rel="stylesheet" type="text/css">
	<script src="<?php echo $raiz; ?>js/html5.js"></script> 
	<!--[if lt IE 9]><script type="text/javascript" src="<?php echo $raiz; ?>js/excanvas.min.js"></script><![endif]-->
	<script src="<?php echo $raiz; ?>js/graficos.js"></script>
	<script src="<?php echo $raiz; ?>js/ios-bug.js"></script>
	<script src="<?php echo $raiz; ?>js/jquery.js"></script>
	<script src="<?php echo $raiz; ?>js/bgpos.js"></script>
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
			if($(window).width() <= 600)
				$('.buscainterna').css('top', '-37px');
		});

		if(document.location.href.indexOf('/masculino') > 0)
			$('.filtros').append('<li class="wrap">Filtrando somente sexo masculino<a id="remover_masculino" href="#">remover este filtro</a></li>');
		else if(document.location.href.indexOf('/feminino') > 0)
			$('.filtros').append('<li class="wrap">Filtrando somente sexo feminino<a id="remover_feminino" href="#">remover este filtro</a></li>');

		if(document.location.href.indexOf('/atendidas') > 0)
			$('.filtros').append('<li class="wrap">Filtrando somente atendidas<a id="remover_atendidas" href="#">remover este filtro</a></li>');
		else if(document.location.href.indexOf('/nao-atendidas') > 0)
			$('.filtros').append('<li class="wrap">Filtrando somente não atendidas<a id="remover_nao_atendidas" href="#">remover este filtro</a></li>');

		$('.filtros li').length == 2 && $('.filtros li:first-child').addClass('divisao');

		$('#filtrar_atendidas').on('click', function(){
			document.location.href = document.location.href.replace('/atendidas', '').replace('/nao-atendidas', '') + '/atendidas';
		});

		$('#filtrar_nao_atendidas').on('click', function(){
			document.location.href = document.location.href.replace('/atendidas', '').replace('/nao-atendidas', '') + '/nao-atendidas';
		});

		$('#filtrar_masculino').on('click', function(){
			document.location.href = document.location.href.replace('/masculino', '').replace('/feminino', '') + '/masculino';
		});

		$('#filtrar_feminino').on('click', function(){
			document.location.href = document.location.href.replace('/masculino', '').replace('/feminino', '') + '/feminino';
		});

		$('#remover_atendidas').on('click', function(){
			document.location.href = document.location.href.replace('/atendidas', '');
		});

		$('#remover_nao_atendidas').on('click', function(){
			document.location.href = document.location.href.replace('/nao-atendidas', '');
		});

		$('#remover_feminino').on('click', function(){
			document.location.href = document.location.href.replace('/feminino', '');
		});

		$('#remover_masculino').on('click', function(){
			document.location.href = document.location.href.replace('/masculino', '');
		});
	});
	</script>
</head>
<body onload='<?php echo "carregarGrafico(false, [" . $nao_atendidas . ", " . $atendidas . "], \"grafico_atendimento\"), carregarGrafico(true, [" . $feminino . ", " . $masculino . "], \"grafico_sexo\");"; ?>'>
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
				<h1><small>Reclamações da Empresa:</small><?php echo utf8_encode($nome); ?></h1>
				<h2 class="nota a">Nota do tempo de resposta: <span><?php
					$conexao = conectarBanco();
					$resultado = mysql_query("select datediff(DataArquivamento, DataAbertura) tempo
											from dados_importados 
											where lower(replace(strNomeFantasia, ',', '')) = lower(replace('" . $_GET['empresa'] . "', '-', ' '))", $conexao);

					while ($linha = mysql_fetch_assoc($resultado))
						$tempo = $linha['tempo'];

					mysql_free_result($resultado);
					mysql_close($conexao);

					if($tempo <= 120)
						echo "A";
					else if($tempo > 120 && $tempo <= 140)
						echo "B";
					else if($tempo > 140 && $tempo <= 160)
						echo "C";
					else if($tempo > 160 && $tempo <= 180)
						echo "D";
					else
						echo "E";
				?></span></h2>
			</div>
			<div class="fundoheader">
				<p class="wrap"><?php echo number_format($total, 0, ',', '.'); ?> reclamações</p>
				<ul class="filtros">
				</ul>
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
							<td class="valor"><?php echo number_format(round($atendidas, 1), $atendidas == 100 || $atendidas == 0 ? 0 : 1, ',', ','); ?>%</td>
						</tr>
						<tr>
							<td class="variavel">não atendidas</td>
							<td class="valor"><?php echo number_format(round($nao_atendidas, 1), $nao_atendidas == 100 || $nao_atendidas == 0 ? 0 : 1, ',', ','); ?>%</td>
						</tr>
					</tbody>
				</table>
				<a class="linkesq" id="filtrar_atendidas" href="#">Filtrar somente atendidas</a>
				<a class="linkdir" id="filtrar_nao_atendidas" href="#">Filtrar somente não atendidas</a>
			</section>
			<section class="boxmenor">
				<h2>sexo</h2>
				<canvas id="grafico_sexo" width="150" height="150"></canvas>
				<table class="circular sexo">
					<tbody>
						<tr>
							<td class="variavel">masculino</td>
							<td class="valor"><?php echo number_format(round($masculino, 1), $masculino == 100 || $masculino == 0 ? 0 : 1, ',', ','); ?>%</td>
						</tr>
						<tr>
							<td class="variavel">feminino</td>
							<td class="valor"><?php echo number_format(round($feminino, 1), $feminino == 100 || $feminino == 0 ? 0 : 1, ',', ','); ?>%</td>
						</tr>
					</tbody>
				</table>
				<a class="linkesq mas" id="filtrar_masculino" href="#">Filtrar somente masculino</a>
				<a class="linkdir fem" id="filtrar_feminino" href="#">Filtrar somente feminino</a>
			</section>
			<section class="boxmenor margembox idade">
				<h2>idade</h2>
				<table>
					<tbody id="graficoidade">
						<tr>
							<td class="valor"><?php echo $ate_30; ?></td>
							<td class="variavel">até 30 anos</td>
						</tr>
						<tr>
							<td class="valor"><?php echo $mais_31; ?></td>
							<td class="variavel">31 a 60 anos</td>
						</tr>
						<tr>
							<td class="valor"><?php echo $mais_60; ?></td>
							<td class="variavel">mais de 60 anos</td>
						</tr>
						<tr>
							<td class="valor"><?php echo $nao_consta; ?></td>
							<td class="variavel">não<br> consta</td>
						</tr>
					</tbody>
				</table>
			</section>
			<section class="boxmaior">
				<h2>principais problemas</h2>
				<table class="horizontal">
					<tbody id="graficoproblema">
						<?php
							$conexao = conectarBanco();
							$resultado = mysql_query("select DescricaoProblema, count(id) qtde
														from dados_importados 
														where lower(replace(strNomeFantasia, ',', '')) = lower(replace('" . $_GET['empresa'] . "', '-', ' '))  " . $str_filtros . " 
														group by DescricaoProblema order by count(id) desc
														limit 4", 
							$conexao);

							while ($linha = mysql_fetch_assoc($resultado))
								echo "<tr>
										<td class='variavel'>" . utf8_encode($linha['DescricaoProblema']) . "</td>
										<td class='valor'>" . $linha['qtde'] . "</td>
									</tr>";

							mysql_free_result($resultado);
							mysql_close($conexao);
						?>
					</tbody>
				</table>
			</section>
			<section class="boxmaior margembox">
				<h2>principais assuntos</h2>
				<table class="horizontal">
					<tbody id="graficoassunto">
						<?php
							$conexao = conectarBanco();
							$resultado = mysql_query("select DescricaoAssunto, count(id) qtde
														from dados_importados 
														where lower(replace(strNomeFantasia, ',', '')) = lower(replace('" . $_GET['empresa'] . "', '-', ' '))  " . $str_filtros . " 
														group by DescricaoAssunto order by count(id) desc
														limit 4", 
							$conexao);

							while ($linha = mysql_fetch_assoc($resultado))
								echo "<tr>
										<td class='variavel'>" . utf8_encode($linha['DescricaoAssunto']) . "</td>
										<td class='valor'>" . $linha['qtde'] . "</td>
									</tr>";

							mysql_free_result($resultado);
							mysql_close($conexao);
						?>
					</tbody>
				</table>
			</section>
		</div>
	</article>
</body>
</html>