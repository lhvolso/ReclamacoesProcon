<?php
header('Content-type: text/html; charset=utf-8');
include "conexao-banco.php";
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
						where SexoConsumidor <> 'N' AND strNomeFantasiaUrl = lower('" . $_GET['empresa'] . "') " . $str_filtros . " group by strNomeFantasia", $conexao);

if(mysql_num_rows($resultado) <= 0)
					header("location:pagina-nao-encontrada.php");

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
	<title><?php echo ucwords(utf8_encode($nome)); ?> - Reclamações Procon</title>
	<meta name="keywords" content="<?php echo ucwords(utf8_encode($nome)); ?>, reclamação, procon, problemas, assuntos, idade, sexo">
	<meta name="description" content="<?php echo ucwords(utf8_encode($nome)); ?> possui um total de <?php echo number_format($total, 0, ',', '.'); ?> reclamações no PROCON, veja mais detalhes sobre elas!">
	<meta name="revisit-after" content="7 days">
	<meta name="robots" content="index, follow">
	<meta name="author" content="Group VOID">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0">
	<meta property="og:image" content="imagens/logo-reclamacoes-procon-facebook.png">
	<link rel="stylesheet" href="<?php echo $raiz; ?>css/layout.css">
	<!--[if lt IE 10]><link rel="stylesheet" href="<?php echo $raiz; ?>css/ie.css"><![endif]-->
	<link href="http://fonts.googleapis.com/css?family=Maven+Pro" rel="stylesheet" type="text/css">
	<!--[if lt IE 9]>
	<script type="text/javascript" src="<?php echo $raiz; ?>js/html5.js"></script>
	<noscript><link type="text/plain" rel="author" href="funcoes-scripts.txt"></noscript>
	<![endif]-->
	<script type="text/javascript" src="<?php echo $raiz; ?>js/jquery.js"></script>
	<noscript><link type="text/plain" rel="author" href="funcoes-scripts.txt"></noscript>
	<!--[if lt IE 9]>
	<script type="text/javascript" src="<?php echo $raiz; ?>js/excanvas-min.js"></script>
	<noscript><link type="text/plain" rel="author" href="funcoes-scripts.txt"></noscript>
	<![endif]-->
	<!--[if lt IE 9]>
	<script type="text/javascript" src="<?php echo $raiz; ?>js/mediaqueries-min.js"></script>
	<noscript><link type="text/plain" rel="author" href="funcoes-scripts.txt"></noscript>
	<![endif]-->
	<script type="text/javascript" src="<?php echo $raiz; ?>js/js-functions-min.js"></script>
	<noscript><link type="text/plain" rel="author" href="funcoes-scripts.txt"></noscript>
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
	<noscript><link type="text/plain" rel="author" href="funcoes-scripts.txt"></noscript>
</head>
<body onload='<?php echo "carregarGrafico(false, [" . $nao_atendidas . ", " . $atendidas . "], \"grafico_atendimento\"), carregarGrafico(true, [" . $feminino . ", " . $masculino . "], \"grafico_sexo\");"; ?>'>
	<header class="topo" role="banner">
		<div class="wrap">
			<nav role="navigation">
				<ul>
					<li><a href="#conteudo" class="salto" accesskey="1">Saltar para o conteúdo [1]</a></li>
					<li><a href="/" class="logo" accesskey="2">Voltar à página inicial [2]</a></li>
					<li><a href="/ajuda-sobre-conteudo.php" class="ajuda" accesskey="3">Ajuda sobre o conteúdo [3]</a></li>
				</ul>
			</nav>
			<form action="<?php echo $raiz; ?>" class="buscainterna" role="search" method="get">
				<div>
					<label for="pesquisa">Pesquise o nome da empresa</label>
					<input type="text" id="pesquisa" name="pesquisa" accesskey="4" required>
					<button type="submit">BUSCAR</button>
				</div>
			</form>
		</div>
	</header>
	<article class="infografico" role="main">
		<header>
			<div class="wrap">
				<h1 id="conteudo"><span>Reclamações da Empresa:</span> <?php echo ucwords(utf8_encode($nome)); ?></h1>
				<?php
				$conexao = conectarBanco();

				$resultado = mysql_query("select avg(datediff(DataArquivamento, DataAbertura)) tempo
				 						from dados_importados 
				 						where strNomeFantasiaUrl = lower('" . $_GET['empresa'] . "')", $conexao);		

				while ($linha = mysql_fetch_assoc($resultado))
					$tempo = $linha['tempo'];

				mysql_free_result($resultado);
				mysql_close($conexao);

				if($tempo < 65)
					$notaTempo = "A";
				else if($tempo >= 65 && $tempo < 120)
					$notaTempo = "B";
				else if($tempo >= 120 && $tempo < 165)
					$notaTempo = "C";
				else if($tempo >= 165 && $tempo < 250)
					$notaTempo = "D";
				else
					$notaTempo = "E";

				$uri = $_SERVER['REQUEST_URI'];
				if(substr($uri, -1) == '/'){
					$uri = substr_replace($uri, '', -1);
				}
				$filtroEstado = $filtroSexo = '';
				if(preg_match_all('/masculino|feminino/', $uri, $saida)){
					$filtroSexo = '/'.$saida[0][0];
					$uri = str_replace($filtroSexo, '', $uri);
				}
				if(preg_match_all('/atendidas|nao-atendidas/', $uri, $saida)){
					$filtroEstado = '/'.$saida[0][0];
					$uri = str_replace($filtroEstado, '', $uri);
				}
				?>
			</div>
			<div class="fundoheader">
				<?php
				if($filtroEstado != '' OR $filtroSexo != ''){ $class = 'divisao'; } else {$class = ''; }
				echo '<h2 class="wrap '.$class.'"><span>Total de </span>'.number_format($total, 0, ',', '').' reclamações</h2>';
				if($filtroEstado != '' OR $filtroSexo != ''){
					echo '<ul class="filtros">';
						if(isset($_GET['sexo'])){ $class = 'divisao'; } else { $class = ''; }
						if($_GET['atendidas'] != 'feminino' AND $_GET['atendidas'] != 'masculino'){
							echo '<li class="wrap '.$class.'"><a title="Clique para remover o filtro" href="'.str_replace($filtroEstado, '', $_SERVER['REQUEST_URI']).'">Filtrando somente '.substr(str_replace('nao-atendidas', 'não atendidas', $filtroEstado), 1).'</a></li>';
						}else{
							echo '<li class="wrap"><a title="Clique para remover o filtro" href="'.str_replace($filtroSexo, '', $_SERVER['REQUEST_URI']).'">Filtrando somente '.substr($filtroSexo, 1).'</a></li>';
						}
						if(isset($_GET['sexo'])){
							echo '<li class="wrap"><a title="Clique para remover o filtro" href="'.str_replace($filtroSexo, '', $_SERVER['REQUEST_URI']).'">Filtrando somente '.substr($filtroSexo, 1).'</a></li>';
						}
					echo '</ul>';
				}
				?>
			</div>
		</header>
		<div class="wrap">
			<section class="nota <?php echo strtolower($notaTempo); ?>">
				<h3>Nota do Tempo de resposta:</h3>
				<p>
					<span class="valor"><span>Nota: </span><?php echo $notaTempo; ?></span>
					<span class="media">(média de <?php echo floor($tempo); ?> dias)</span>
				</p>
			</section>
			<section class="boxpadrao boxmenor">
				<h3>estado das reclamações</h3>
				<canvas id="grafico_atendimento" width="150" height="150"></canvas>
				<table class="circular atendimento">
					<caption>Porcentagem de reclamações atendidas e não atendidas. Clique nos números para filtrar.</caption>
					<thead>
						<tr>
							<th id="estado_reclamacoes">Estado da reclamação</th>
							<th id="porcentagem_estado">Porcentagem</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="variavel" headers="estado_reclamacoes">atendidas</td>
							<td class="valor" headers="porcentagem_estado">
								<a title="Filtrar somente atendidas" href="<?php echo $uri.'/atendidas'.$filtroSexo; ?>">
									<?php echo number_format(round($atendidas, 1), $atendidas == 100 || $atendidas == 0 ? 0 : 1, ',', ','); ?>%
								</a>
							</td>
						</tr>
						<tr>
							<td class="variavel" headers="estado_reclamacoes">não atendidas</td>
							<td class="valor" headers="porcentagem_estado">
								<a title="Filtrar somente não atendidas" href="<?php echo $uri.'/nao-atendidas'.$filtroSexo; ?>">
									<?php echo number_format(round($nao_atendidas, 1), $nao_atendidas == 100 || $nao_atendidas == 0 ? 0 : 1, ',', ','); ?>%
								</a>
							</td>
						</tr>
					</tbody>
				</table>
			</section>
			<section class="boxpadrao boxmenor boxsexo">
				<h3>reclamações por sexo</h3>
				<canvas id="grafico_sexo" width="150" height="150"></canvas>
				<table class="circular sexo">
					<caption>Reclamações de homens e mulheres em porcentagem. Clique nos números para filtrar.</caption>
					<thead>
						<tr>
							<th id="sexo_reclamacoes">Sexo</th>
							<th id="porcentagem_sexo">Porcentagem</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="variavel" headers="sexo_reclamacoes">masculino</td>
							<td class="valor" headers="porcentagem_sexo">
								<a title="Filtrar somente masculinas" href="<?php echo $uri.$filtroEstado; ?>/masculino">
									<?php echo number_format(round($masculino, 1), $masculino == 100 || $masculino == 0 ? 0 : 1, ',', ','); ?>%
								</a>
							</td>
						</tr>
						<tr>
							<td class="variavel" headers="sexo_reclamacoes">feminino</td>
							<td class="valor" headers="porcentagem_sexo">
								<a title="Filtrar somente femininas" href="<?php echo $uri.$filtroEstado; ?>/feminino">
									<?php echo number_format(round($feminino, 1), $feminino == 100 || $feminino == 0 ? 0 : 1, ',', ','); ?>%
								</a>
							</td>
						</tr>
					</tbody>
				</table>
			</section>
			<section class="boxpadrao boxmenor margembox idade">
				<h3>reclamações por idade</h3>
				<table>
					<caption>Número de reclamações divididas por faixa etária. Algumas reclamações não tem o dado de idade que é indicado como não consta.</caption>
					<thead>
						<tr>
							<th id="numero_idade">Número de reclamações</th>
							<th id="idade_reclamacoes">Idade</th>
						</tr>
					</thead>
					<tbody id="graficoidade">
						<tr>
							<td class="valor" headers="numero_idade"><?php echo $ate_30; ?></td>
							<td class="variavel" headers="idade_reclamacoes">até 30 anos</td>
						</tr>
						<tr>
							<td class="valor" headers="numero_idade"><?php echo $mais_31; ?></td>
							<td class="variavel" headers="idade_reclamacoes">31 a 60 anos</td>
						</tr>
						<tr>
							<td class="valor" headers="numero_idade"><?php echo $mais_60; ?></td>
							<td class="variavel" headers="idade_reclamacoes">mais de 60 anos</td>
						</tr>
						<tr>
							<td class="valor" headers="numero_idade"><?php echo $nao_consta; ?></td>
							<td class="variavel" headers="idade_reclamacoes">não<br> consta</td>
						</tr>
					</tbody>
				</table>
			</section>
			<section class="boxpadrao boxmaior">
				<h3>principais problemas</h3>
				<table class="horizontal">
					<caption>Principais problemas apontados e o número referente de reclamações, essa lista é padrão do <strong>Procon</strong>.</caption>
					<thead>
						<tr>
							<th id="problema">Problema</th>
							<th id="reclamacoes_problema">Número de reclamações</th>
						</tr>
					</thead>
					<tbody id="graficoproblema">
						<?php
							$conexao = conectarBanco();
							$resultado = mysql_query("select DescricaoProblema, count(id) qtde
														from dados_importados 
														where strNomeFantasiaUrl = lower('" . $_GET['empresa'] . "')  " . $str_filtros . " 
														group by DescricaoProblema order by count(id) desc
														limit 4", 
							$conexao);

							while ($linha = mysql_fetch_assoc($resultado))
								echo "<tr>
										<td class='variavel' headers='problema'>" . utf8_encode($linha['DescricaoProblema']) . "</td>
										<td class='valor' headers='reclamacoes_problema'>" . $linha['qtde'] . "</td>
									</tr>";

							mysql_free_result($resultado);
							mysql_close($conexao);
						?>
					</tbody>
				</table>
			</section>
			<section class="boxpadrao boxmaior margembox">
				<h3>principais assuntos</h3>
				<table class="horizontal">
					<caption>Número de reclamações referentes aos principais assuntos reclamados, essa lista é padrão do <strong>Procon</strong>.</caption>
					<thead>
						<tr>
							<th id="assunto">Assunto</th>
							<th id="reclamacoes_assunto">Número de reclamações</th>
						</tr>
					</thead>
					<tbody id="graficoassunto">
						<?php
							$conexao = conectarBanco();
							$resultado = mysql_query("select DescricaoAssunto, count(id) qtde
														from dados_importados 
														where strNomeFantasiaUrl = lower('" . $_GET['empresa'] . "')  " . $str_filtros . " 
														group by DescricaoAssunto order by count(id) desc
														limit 4", 
							$conexao);

							while ($linha = mysql_fetch_assoc($resultado))
								echo "<tr>
										<td class='variavel' headers='assunto'>" . utf8_encode($linha['DescricaoAssunto']) . "</td>
										<td class='valor' headers='reclamacoes_assunto'>" . $linha['qtde'] . "</td>
									</tr>";

							mysql_free_result($resultado);
							mysql_close($conexao);
						?>
					</tbody>
				</table>
			</section>
			<a class="voltartopo" href="#" accesskey="0">Voltar ao topo [0]</a>
		</div>
	</article>
</body>
</html>