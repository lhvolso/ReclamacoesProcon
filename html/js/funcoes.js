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
	    var altura = constanteIdade * valoresIdade[x];
	    if(altura < 25){ altura = 25; }
	    var padding = 122 - altura;
	    if(desvioIdade > 122){ desvioIdade = 117; }
	    $('#graficoidade tr:nth-child('+ (x + 1) +') td.valor').animate({
	    	backgroundPosition: 'center ' + desvioIdade,
	    	height: altura+'px',
			padding: padding+'px 0 0 0'
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
		$('.buscainterna').fadeIn(50);
		$('#busca').focus();
	});
	$('#busca').blur(function(){
		$('.buscainterna').fadeOut(50);
	});
});