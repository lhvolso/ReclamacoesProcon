function carregarGrafico(e,t,n){var r=converterRadianos(t);if(e==true){var i=["#FF4D4D","#76CCF3"]}else{var i=["#FCAF17","#3C5C9A"]}var s=document.getElementById(n);var o=s.getContext("2d");for(var u=0;u<t.length;u++)desenharSegmento(s,o,u,i,r);e&&desenharCirculo(s,o)}function converterRadianos(e){var t=[];for(var n=0;n<e.length;n++)t[n]=e[n]*3.6;return t}function obterRadianos(e){return e*Math.PI/180}function somarPonto(e,t){var n=0;for(var r=0;r<t;r++)n+=e[r];return n}function desenharSegmento(e,t,n,r,i){t.save();var s=Math.floor(e.width/2);var o=Math.floor(e.height/2);var u=-1.57+obterRadianos(somarPonto(i,n));t.beginPath();t.moveTo(s,o);t.arc(s,o,Math.floor(e.width/2),u,u+obterRadianos(i[n]),false);t.closePath();t.fillStyle=r[n];t.fill();t.restore()}function desenharCirculo(e,t){t.beginPath();t.fillStyle="#FFF";t.arc(Math.floor(e.width/2),Math.floor(e.height/2),55,0,2*Math.PI);t.fill()}if(navigator.userAgent.match(/Version\/[54321]/i)){(function(e){function o(){s.content="width=device-width,minimum-scale="+i[0]+",maximum-scale="+i[1];e.removeEventListener(n,o,true)}var t="addEventListener",n="gesturestart",r="querySelectorAll",i=[1,1],s=r in e?e[r]("meta[name=viewport]"):[];if((s=s[s.length-1])&&t in e){o();i=[.25,1.6];e[t](n,o,true)}})(document)}(function(e){function r(t){var n=(t||"").split(/ /);var r={center:"50%",left:"0%",right:"100%",top:"0%",bottom:"100%"};var i=function(e){var t=(r[n[e]]||n[e]||"50%").match(/^([+-]=)?([+-]?\d+(\.\d*)?)(.*)$/);n[e]=[t[1],parseFloat(t[2]),t[4]||"px"]};if(n.length==1&&e.inArray(n[0],["top","bottom"])>-1){n[1]=n[0];n[0]="50%"}i(0);i(1);return n}function i(t){if(!t.set){s(t)}e(t.elem).css("background-position",t.pos*(t.end[0][1]-t.start[0][1])+t.start[0][1]+t.end[0][2]+" "+(t.pos*(t.end[1][1]-t.start[1][1])+t.start[1][1]+t.end[1][2]))}function s(n){var i=e(n.elem);var s=i.data(t);i.css("backgroundPosition",s);n.start=r(s);n.end=r(e.fn.jquery>="1.6"?n.end:n.options.curAnim["backgroundPosition"]||n.options.curAnim["background-position"]);for(var o=0;o<n.end.length;o++){if(n.end[o][0]){n.end[o][1]=n.start[o][1]+(n.end[o][0]=="-="?-1:+1)*n.end[o][1]}}n.set=true}var t="bgPos";var n=!!e.Tween;if(n){e.Tween.propHooks["backgroundPosition"]={get:function(t){return r(e(t.elem).css(t.prop))},set:function(e){i(e)}}}else{e.fx.step["backgroundPosition"]=i}e.fn.animate=function(e){return function(n,r,i,s){if(n["backgroundPosition"]||n["background-position"]){this.data(t,this.css("backgroundPosition")||"left top")}return e.apply(this,[n,r,i,s])}}(e.fn.animate)})(jQuery);$("document").ready(function(){var e=Array();var t=Array();var n=0;$("#graficoidade tr").each(function(){var r=parseInt($(this).children("td.valor").html());e.push(r);t.push(r);n=n+r});t.sort(function(e,t){return t-e});var r=122/t[0];for(x=0;x<4;x++){var i=142-r*e[x];var s=r*e[x];if(s<25){s=25}var o=122-s;if(i>122){i=117}$("#graficoidade tr:nth-child("+(x+1)+") td.valor").animate({backgroundPosition:"center "+i,height:s+"px",padding:o+"px 0 0 0"},500)}var u=Array();var a=Array();var f=0;$("#graficoproblema tr").each(function(){var e=parseInt($(this).children("td.valor").html());u.push(e);a.push(e);f=f+e});a.sort(function(e,t){return t-e});var l=228/a[0];for(x=0;x<4;x++){var c=-(238-l*u[x]);$("#graficoproblema tr:nth-child("+(x+1)+") td.variavel").animate({backgroundPosition:c+" 0"},500)}var h=Array();var p=Array();var d=0;$("#graficoassunto tr").each(function(){var e=parseInt($(this).children("td.valor").html());h.push(e);p.push(e);d=d+e});p.sort(function(e,t){return t-e});var v=228/p[0];for(x=0;x<4;x++){var m=-(238-v*h[x]);$("#graficoassunto tr:nth-child("+(x+1)+") td.variavel").animate({backgroundPosition:m+" 0"},500)}var g=$(document).width();console.log(g);if(g<=608){$(".busca").click(function(){$(".buscainterna").fadeIn(50);$("#busca").focus();$(".logo").hide()});$("#busca").blur(function(){$(".buscainterna").fadeOut(50);$(".logo").fadeIn(120)})}})