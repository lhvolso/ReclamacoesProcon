<!DOCTYPE HTML>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<title>Reclamações Procon</title>
	<meta name="keywords" content="procon, reclamações, empresas, problemas, assuntos, dados abertos">
	<meta name="description" content="Serviço de busca e visualização intuitiva de dados de reclamações fundamentadas do PROCON">
	<meta name="revisit-after" content="7 days">
	<meta name="robots" content="noindex">
	<meta name="author" content="Group VOID">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0">
	<meta property="og:image" content="imagens/logo-reclamacoes-procon-facebook.png">
	<link rel="stylesheet" href="css/reset.css">
	<link rel="stylesheet" href="css/layout-inicio.css">
	<link href="http://fonts.googleapis.com/css?family=Maven+Pro:400,700" rel="stylesheet" type="text/css">
	<!--[if lt IE 9]><script type="text/javascript" src="js/html5.js"></script><![endif]-->
	<script src="<?php echo $raiz; ?>js/jquery.js"></script>
	<!--[if lt IE 9]><script type="text/javascript" src="js/mediaqueries-min.js"></script><![endif]-->
	<script src="js/ios-bug-min.js"></script>
</head>
<body>
	<header>
		<div class="wrap">
			<h1>Reclamações Procon</h1>
			<p>O “Reclamações PROCON” é um serviço de busca e visualização intuitiva de dados abertos disponibilizados pelo PROCON relativos ao ano de 2011.</p>
			<a href="/ajuda-sobre-conteudo.php" class="ajuda">Ajuda sobre o conteúdo</a>
		</div>
	</header>
	<form action="/ReclamacoesProcon/html/" method="get" class="wrap">
		<label for="busca">Pesquise o nome da empresa</label>
		<input type="text" name="pesquisa" id="busca" placeholder="PESQUISE O NOME DA EMPRESA" autocomplete="off" required>
		<button type="submit">BUSCAR</button>
	</form>
	<div class="conteudo">
		<section>
			<h2>Quem Somos?</h2>
			<p>Somos um grupo de estudantes, programadores e designers, do curso da Especialização em Padrões Web da Universidade Tecnológica Federal do Paraná, campus Londrina.</p>
			<p>Nos unimos com o intuito de utilizar os diversos padrões e técnicas estudadas, e assim proporcionar acessibilidade e uma melhor experiência de visualização de dados por nossos usuários, buscando alcançar todo tipo de dispositivo ou tecnologia utilizada por eles.</p>
			<p>A motivação para  desenvolver o projeto surgiu em uma reunião após um dia normal de aula para participarmos de um concurso de dados abertos, neste projeto decidimos aplicar os conhecimentos adquiridos como uma forma de fixação do conteúdo e obter de experiência no uso de tecnologias inovadoras.</p>
			<p>Os colaboradores do projeto são os seguintes: <a href="http://twitter.com/lhvolso">@lhvolso</a>, <a href="http://twitter.com/limaadriano">@limaadriano</a>, <a href="http://twitter.com/thiagotakeshi">@thiagotakeshi</a>, <a href="http://twitter.com/marcoshuss">@marcoshuss</a>, <a href="http://twitter.com/dnlvichi">@dnlvichi</a>, e também como orientador e coordenador do curso <a href="http://twitter.com/thiagotpc">@thiagotpc</a>.</p>
		</section>
		<section>
			<h2>O que são Dados Abertos?</h2>
			<p>Segundo a <a href="http://opendefinition.org/">definição da Open Knowledge Foundation (em inglês)</a>:</p>
			<p><strong>"Dados são abertos quando qualquer pessoa pode livremente usá-los, reutilizá-los e redistribuí-los, estando sujeito a, no máximo, a exigência de creditar a sua autoria e compartilhar pela mesma licença."</strong></p>
			<p>Os dados abertos também são pautados pelas <a href="http://eaves.ca/2009/09/30/three-law-of-open-government-data/">Três Leis de Dados Abertos Governamentais (em inglês)</a> criadas pelo especialista em políticas públicas e ativista dos dados abertos <a href="http://eaves.ca/about/">David Eaves</a> e os <a href="http://www.opengovdata.org/home/8principles">Oito Princípios de Dados Abertos Governamentais (em inglês)</a> criados por um grupo de trabalho de 30 pessoas da Califórnia. O grupo também afirmou que a conformidade com esses princípios precisa ser verificável e uma pessoa deve ser designada como contato responsável pelos dados.</p>
			<p>As Três Leis e Oito Princípios dos Dados Abertos Governamentais traduzidas você encontra no <a href="http://dados.gov.br/dados-abertos">Portal Brasileiro de Dados Abertos</a></p>
		</section>
	</div>
</body>
</html>