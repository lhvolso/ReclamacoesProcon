$(function(){
	function retornarHtmlResultados(data, paginacao)
	{
		var lis = '';
		var qtde = 0;
		paginacao = paginacao === undefined ? 0 : paginacao;
		$.each(data, function(index, item){
			if(index >= paginacao)
				switch(item.tipo)
				{
					case 'Empresa': lis += '<li>'+
												'<p class="empresas">Empresa</p>'+
												'<h3><a class="link_empresas" href="exibe-detalhe.php?empresa=' + item.titulo + '">' + item.titulo + '</a></h3>'+
												'<p>' + item.QtdeReclam + ' reclamações, em ' + item.QtdeAssuntos + ' assuntos diferentes</p>'+
												'<p class="atendimento">' + item.atendidas + '% atendidas</p>'+
											'</li>';break;
					case 'Assunto': lis += '<li>'+
												'<p class="assuntos">Assunto</p>'+
												'<h3><a class="link_assuntos" href="exibe-detalhe.php?empresa=' + item.titulo + '">' + item.titulo + '</a></h3>'+
												'<p><a href="#">' + item.QtdeReclam + ' empresas</a> reclamadas com ' + item.QtdeAssuntos + ' problemas diferentes</p>'+
												'<p class="atendimento">' + item.atendidas + '% atendidas</p>'+
											'</li>';break;
					case 'Problema': lis += '<li>'+
												'<p class="problemas">Problema</p>' +
												'<h3><a class="link_problemas" href="exibe-detalhe.php?empresa=' + item.titulo + '">' + item.titulo + '</a></h3>'+
												'<p><a href="#">' + item.QtdeReclam + ' empresas</a> reclamadas com ' + item.QtdeAssuntos + ' assuntos diferentes</p>' +
												'<p class="atendimento">' + item.atendidas + '% atendidas</p>' +
											'</li>';break;
				}

			if(qtde++ == (paginacao + 19))
				return false;
		});
		$('div.paginacao').css('display', data.length > 19 ? 'block' : 'none');
		$('#qtde_resultados').html(qtde);
		if($('section.centro').data('paginacao') === undefined)
			$('section.centro').data('paginacao', 1);

		$('div.paginacao').html('<a class="anterior">Anterior</a><a class="proxima" href="proxima">Próxima</a>');
		for(var i = 1, pg = 0; pg < data.length; i++, pg += 20)
			$('a.proxima').before('<a class="paginacao_item" ' + ($('section.centro').data('paginacao') != i ? 'href=""' : '') + ' data-paginacao="' + pg + '">' + i + '</a>');

		return lis;
	}

	$('a.paginacao_item').live('click', function(e){
		e.preventDefault();
		$('section.centro').data('paginacao', $(this).html());
		var paginacao = $(this).data('paginacao');
		$.ajax({
			url: 'controlador.php',
			data: {action:$('section.centro').data('tipo_busca'), termo: $('#buscar').val(), sessao: $('section.centro').data('sessao')},
			type: 'post'
		}).done(function(data){
			$('ul.resultados').html(retornarHtmlResultados($.parseJSON(data), paginacao));
			$('#termo_pesquisado').html($('#buscar').val());
		});
	});

	$('a.anterior').live('click', function(e){
		e.preventDefault();
		var pagina = $('.paginacao_item:not([href=""])').prev().html();
		if(pagina == 'Anterior')
			return false;

		$('section.centro').data('paginacao', pagina);
		var paginacao = $('.paginacao_item:not([href=""])').prev().data('paginacao');
		$.ajax({
			url: 'controlador.php',
			data: {action:$('section.centro').data('tipo_busca'), termo: $('#buscar').val(), sessao: $('section.centro').data('sessao')},
			type: 'post'
		}).done(function(data){
			$('ul.resultados').html(retornarHtmlResultados($.parseJSON(data), paginacao));
			$('#termo_pesquisado').html($('#buscar').val());
		});
	});

	$('a.proxima').live('click', function(e){
		e.preventDefault();
		var pagina = $('.paginacao_item:not([href=""])').next().html();
		if(pagina == 'Próxima')
			return false;

		$('section.centro').data('paginacao', pagina);
		var paginacao = $('.paginacao_item:not([href=""])').next().data('paginacao');
		$.ajax({
			url: 'controlador.php',
			data: {action:$('section.centro').data('tipo_busca'), termo: $('#buscar').val(), sessao: $('section.centro').data('sessao')},
			type: 'post'
		}).done(function(data){
			$('ul.resultados').html(retornarHtmlResultados($.parseJSON(data), paginacao));
			$('#termo_pesquisado').html($('#buscar').val());
		});
	});

	$('#efetuar_busca').on('click', function(e){
		e.preventDefault();
		if($('section.centro').data('sessao') === undefined)
			$('section.centro').data('sessao', Math.random() * 10000);
		$('section.centro').data('tipo_busca', 'todos');
		$.ajax({
			url: 'controlador.php',
			data: {action:'todos', termo: $('#buscar').val(), sessao: $('section.centro').data('sessao')},
			type: 'post'
		}).done(function(data){
			$('ul.resultados').html(retornarHtmlResultados($.parseJSON(data)));
			$('#termo_pesquisado').html($('#buscar').val());
		});
	});

	$('#efetuar_busca_detalhe').on('click', function(e){
		e.preventDefault();
		if($('section.centro').data('sessao') === undefined)
			$('section.centro').data('sessao', Math.random() * 10000);
		$('section.centro').data('tipo_busca', 'todos');
		$.ajax({
			url: 'controlador.php',
			data: {action:'todos', termo: $('#buscar').val(), sessao: $('section.centro').data('sessao')},
			type: 'post'
		}).done(function(data){
			$('ul.resultados').html(retornarHtmlResultados($.parseJSON(data)));
			$('#termo_pesquisado').html($('#buscar').val());
			$('#article_detalhe').css('display', 'none');
			$('#detalhe_section').css('display', 'block');
		});
	});

	$('a.empresas').on('click', function(e){
		e.preventDefault();
		if($('section.centro').data('sessao') === undefined)
			$('section.centro').data('sessao', Math.random() * 10000);
		$('section.centro').data('tipo_busca', 'empresa');
		$.ajax({
			url: 'controlador.php',
			data: {action:'empresa', termo: $('#buscar').val(), sessao: $('section.centro').data('sessao')},
			type: 'post'
		}).done(function(data){
			$('ul.resultados').html(retornarHtmlResultados($.parseJSON(data)));
			$('#termo_pesquisado').html($('#buscar').val());
		});
	});

	$('a.assuntos').on('click', function(e){
		e.preventDefault();
		if($('section.centro').data('sessao') === undefined)
			$('section.centro').data('sessao', Math.random() * 10000);
		$('section.centro').data('tipo_busca', 'assunto');
		$.ajax({
			url: 'controlador.php',
			data: {action:'assunto', termo: $('#buscar').val(), sessao: $('section.centro').data('sessao')},
			type: 'post'
		}).done(function(data){
			$('ul.resultados').html(retornarHtmlResultados($.parseJSON(data)));
			$('#termo_pesquisado').html($('#buscar').val());
		});
	});

	$('a.problemas').on('click', function(e){
		e.preventDefault();
		if($('section.centro').data('sessao') === undefined)
			$('section.centro').data('sessao', Math.random() * 10000);
		$('section.centro').data('tipo_busca', 'problema');
		$.ajax({
			url: 'controlador.php',
			data: {action:'problema', termo: $('#buscar').val(), sessao: $('section.centro').data('sessao')},
			type: 'post'
		}).done(function(data){
			$('ul.resultados').html(retornarHtmlResultados($.parseJSON(data)));
			$('#termo_pesquisado').html($('#buscar').val());
		});
	});

	$.urlParam = function(name){
	    var results = new RegExp('[\\?&amp;]' + name + '=([^&amp;#]*)').exec(window.location.href);
	    return results[1] || 0;
	}

	$('.link_empresas').live('click', function(e){
		e.preventDefault();
		document.location.href=$(this).attr('href') + '&sessao=' + $('section.centro').data('sessao') + '&tipo=0';
	});

	$('.link_assuntos').live('click', function(e){
		e.preventDefault();
		document.location.href=$(this).attr('href') + '&sessao=' + $('section.centro').data('sessao') + '&tipo=1';
	});

	$('.link_problemas').live('click', function(e){
		e.preventDefault();
		document.location.href=$(this).attr('href') + '&sessao=' + $('section.centro').data('sessao') + '&tipo=2';
	});

	if(document.location.href.indexOf('exibe-detalhe.php') > 0)
	{
		$.ajax({
			url: 'controlador.php',
			data: {action:'detalheempresa', url: document.location.search.toString(), tipo: $.urlParam('tipo'), 
			sessao: $.urlParam('sessao')},
			type: 'post'
		}).done(function(data){
			var lis_problemas = '';
			var dados = $.parseJSON(data);
			$.each(dados.problemas, function(index, item){
				lis_problemas += '<li>' + item.DescricaoProblema + ' (' + item.qtde_reclam + ')</li>';
			});
			var lis_assuntos = '';
			$.each(dados.assuntos, function(index, item){
				lis_assuntos += '<li>' + item.DescricaoAssunto + ' (' + item.qtde_reclam + ')</li>';
			});
			$('#problemas_listagem').append(lis_problemas);
			$('#assuntos_listagem').append(lis_assuntos);
			$('.titulo_empresa').html(dados.empresa);
			$('#qtde_reclam').html(dados.item.qtde_reclamacoes);
			$('#porc').html(dados.item.porc_atendidas);
			$('#qtde_atendidas').html(dados.item.qtde_atendidas);
			if($.urlParam('tipo') == 0)
			{
				$('#titulo1').html('da Empresa');
				$('#titulo2').html('Os principais problemas ');
				$('#titulo3').html('Assuntos mais reclamados');
			}
			else if($.urlParam('tipo') == 1)
			{
				$('#titulo1').html('do Assunto');
				$('#titulo2').html('As principais empresas ');
				$('#titulo3').html('Problemas mais reclamados');
			}
			else
			{
				$('#titulo1').html('do Problema');
				$('#titulo2').html('As principais empresas ');
				$('#titulo3').html('Assuntos mais reclamados');
			}
		});
	}
});