/* Função com as configurações e chamadas para desenho do gráfico */
function carregarGrafico(sexo, dados, id) {
    //Dados que representam o tamanho do gráfico, sempre o total deverá dar 360, portanto, com os nossos dados
    //Bastará apenas fazermos regras de 3 simples para obter os valores e deverão ser carregados por ajax
    var dadosEmRadianos = converterRadianos(dados);
    if(sexo == true){
        var cores = ["#EE0000", "#007DB5"];    
    } else {
        var cores = ["#D06B36", "#415781"];
    }
    
    var canvas = document.getElementById(id);
    var contexto = canvas.getContext("2d");
    for (var i = 0; i < dados.length; i++)
        desenharSegmento(canvas, contexto, i, cores, dadosEmRadianos);
    sexo && desenharCirculo(canvas, contexto);
}

/* Função que realiza a regra de 3 simples e converte os dados passados em porcentagem para radianos para desenhar o gráfico de pizza */
function converterRadianos(dados) {
    var dadosEmRadianos = [];
    for (var i = 0; i < dados.length; i++)
        dadosEmRadianos[i] = dados[i] * 3.6;

    return dadosEmRadianos;
}

/* Função utilizada para obter o ângulo para desenhar o segmento */
function obterRadianos(grau) {
    return (grau * Math.PI) / 180;
}

/* Função para encontrar o último ponto utilizado pelo gráfico */
function somarPonto(dados, i) {
    var soma = 0;
    for (var j = 0; j < i; j++)
        soma += dados[j];
    return soma;
}

/* Função que desenha o segmento no gráfico a cada dado passado */
function desenharSegmento(canvas, contexto, i, cores, dados) {
    contexto.save();
    //Encontra o centro do gráfico com base na altura e largura
    var centroX = Math.floor(canvas.width / 2);
    var centroY = Math.floor(canvas.height / 2);
    //Busca o ângulo que deve começar a desenhar
    var anguloInicio = -1.57 + obterRadianos(somarPonto(dados, i));

    //Inicia o desenho
    contexto.beginPath();
    //Vai para o centro
    contexto.moveTo(centroX, centroY);
    //Desenha o arco do início do ângulo obtido até o final com base nos dados passados
    contexto.arc(centroX, centroY, Math.floor(canvas.width / 2), anguloInicio, anguloInicio + obterRadianos(dados[i]), false);
    contexto.closePath();

    //Define a cor de fundo do segmento
    contexto.fillStyle = cores[i];

    //Preenche todo ele
    contexto.fill();
    contexto.restore();
}

//Função que sobrescreve o gráfico de pizza para simular o gráfico de sexo
function desenharCirculo(canvas, contexto) {
    contexto.beginPath();
    contexto.fillStyle = "#FFF"
    contexto.arc(Math.floor(canvas.width / 2), Math.floor(canvas.height / 2), 55, 0, 2 * Math.PI);
    contexto.fill();
}

/* BUG DO ZOOM NO IOS */
if(navigator.userAgent.match(/Version\/[54321]/i)){
    (function(doc) {
        var addEvent = 'addEventListener',
            type = 'gesturestart',
            qsa = 'querySelectorAll',
            scales = [1, 1],
            meta = qsa in doc ? doc[qsa]('meta[name=viewport]') : [];
        function fix() {
            meta.content = 'width=device-width,minimum-scale=' + scales[0] + ',maximum-scale=' + scales[1];
            doc.removeEventListener(type, fix, true);
        }
        if ((meta = meta[meta.length - 1]) && addEvent in doc) {
            fix();
            scales = [.25, 1.6];
            doc[addEvent](type, fix, true);
        }
    }(document));
}

/* POSICIONAMENTO DE BACKGROUND */
/* http://keith-wood.name/backgroundPos.html
   Background position animation for jQuery v1.1.0.
   Written by Keith Wood (kbwood{at}iinet.com.au) November 2010.
   Dual licensed under the GPL (http://dev.jquery.com/browser/trunk/jquery/GPL-LICENSE.txt) and 
   MIT (http://dev.jquery.com/browser/trunk/jquery/MIT-LICENSE.txt) licenses. 
   Please attribute the author if you use it. */

(function($) { // Hide scope, no $ conflict

var BG_POS = 'bgPos';

var usesTween = !!$.Tween;

if (usesTween) { // jQuery 1.8+
    $.Tween.propHooks['backgroundPosition'] = {
        get: function(tween) {
            return parseBackgroundPosition($(tween.elem).css(tween.prop));
        },
        set: function(tween) {
            setBackgroundPosition(tween);
        }
    };
}
else { // jQuery 1.7-
    // Enable animation for the background-position attribute
    $.fx.step['backgroundPosition'] = setBackgroundPosition;
};

/* Parse a background-position definition: horizontal [vertical]
   @param  value  (string) the definition
   @return  ([2][string, number, string]) the extracted values - relative marker, amount, units */
function parseBackgroundPosition(value) {
    var bgPos = (value || '').split(/ /);
    var presets = {center: '50%', left: '0%', right: '100%', top: '0%', bottom: '100%'};
    var decodePos = function(index) {
        var pos = (presets[bgPos[index]] || bgPos[index] || '50%').
            match(/^([+-]=)?([+-]?\d+(\.\d*)?)(.*)$/);
        bgPos[index] = [pos[1], parseFloat(pos[2]), pos[4] || 'px'];
    };
    if (bgPos.length == 1 && $.inArray(bgPos[0], ['top', 'bottom']) > -1) {
        bgPos[1] = bgPos[0];
        bgPos[0] = '50%';
    }
    decodePos(0);
    decodePos(1);
    return bgPos;
}

/* Set the value for a step in the animation.
   @param  fx  (object) the animation properties */
function setBackgroundPosition(fx) {
    if (!fx.set) {
        initBackgroundPosition(fx);
    }
    $(fx.elem).css('background-position',
        ((fx.pos * (fx.end[0][1] - fx.start[0][1]) + fx.start[0][1]) + fx.end[0][2]) + ' ' +
        ((fx.pos * (fx.end[1][1] - fx.start[1][1]) + fx.start[1][1]) + fx.end[1][2]));
}

/* Initialise the animation.
   @param  fx  (object) the animation properties */
function initBackgroundPosition(fx) {
    var elem = $(fx.elem);
    var bgPos = elem.data(BG_POS); // Original background position
    elem.css('backgroundPosition', bgPos); // Restore original position
    fx.start = parseBackgroundPosition(bgPos);
    fx.end = parseBackgroundPosition($.fn.jquery >= '1.6' ? fx.end :
        fx.options.curAnim['backgroundPosition'] || fx.options.curAnim['background-position']);
    for (var i = 0; i < fx.end.length; i++) {
        if (fx.end[i][0]) { // Relative position
            fx.end[i][1] = fx.start[i][1] + (fx.end[i][0] == '-=' ? -1 : +1) * fx.end[i][1];
        }
    }
    fx.set = true;
}

/* Wrap jQuery animate to preserve original backgroundPosition. */
$.fn.animate = function(origAnimate) {
    return function(prop, speed, easing, callback) {
        if (prop['backgroundPosition'] || prop['background-position']) {
            this.data(BG_POS, this.css('backgroundPosition') || 'left top');
        }
        return origAnimate.apply(this, [prop, speed, easing, callback]);
    };
}($.fn.animate);

})(jQuery);

/* FUNCOES JQUERY */
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
    var largura = $(document).width();
    if(largura <= 608){
        $('.buscainterna').after('<a class="busca">Exibir Busca</a>');
        $('.busca').click(function(){
            $('.buscainterna').fadeIn(50);
            $('#busca').focus();
            $('.logo').hide();
        });
        $('#pesquisa').blur(function(){
            $('.buscainterna').fadeOut(50);
            $('.logo').fadeIn(120);
        });
    }
    $(window).resize(function() {
        var largura = $(document).width();
        if(largura <= 608){
            $('.buscainterna').after('<a class="busca">Exibir Busca</a>');
        }
    });
});