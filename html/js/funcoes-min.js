$("document").ready(function(){var e=Array();var t=Array();var n=0;$("#graficoidade tr").each(function(){var r=parseInt($(this).children("td.valor").html());e.push(r);t.push(r);n=n+r});t.sort(function(e,t){return t-e});var r=122/t[0];for(x=0;x<4;x++){var i=142-r*e[x];var s=r*e[x];if(s<25){s=25}var o=122-s;if(i>122){i=117}$("#graficoidade tr:nth-child("+(x+1)+") td.valor").animate({backgroundPosition:"center "+i,height:s+"px",padding:o+"px 0 0 0"},500)}var u=Array();var a=Array();var f=0;$("#graficoproblema tr").each(function(){var e=parseInt($(this).children("td.valor").html());u.push(e);a.push(e);f=f+e});a.sort(function(e,t){return t-e});var l=228/a[0];for(x=0;x<4;x++){var c=-(238-l*u[x]);$("#graficoproblema tr:nth-child("+(x+1)+") td.variavel").animate({backgroundPosition:c+" 0"},500)}var h=Array();var p=Array();var d=0;$("#graficoassunto tr").each(function(){var e=parseInt($(this).children("td.valor").html());h.push(e);p.push(e);d=d+e});p.sort(function(e,t){return t-e});var v=228/p[0];for(x=0;x<4;x++){var m=-(238-v*h[x]);$("#graficoassunto tr:nth-child("+(x+1)+") td.variavel").animate({backgroundPosition:m+" 0"},500)}$(".busca").click(function(){$(".buscainterna").fadeIn(50);$("#busca").focus()});$("#busca").blur(function(){$(".buscainterna").fadeOut(50)})})