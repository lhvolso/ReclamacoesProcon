/* Função com as configurações e chamadas para desenho do gráfico */
function carregarGrafico(sexo, dados, id) {
    //Dados que representam o tamanho do gráfico, sempre o total deverá dar 360, portanto, com os nossos dados
    //Bastará apenas fazermos regras de 3 simples para obter os valores e deverão ser carregados por ajax
    var dadosEmRadianos = converterRadianos(dados);
    if(sexo == true){
        var cores = ["#FF4D4D", "#76CCF3"];    
    } else {
        var cores = ["#FCAF17", "#3C5C9A"];
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