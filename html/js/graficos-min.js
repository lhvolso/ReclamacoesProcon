function carregarGrafico(e,t,n){var r=converterRadianos(t);if(e==true){var i=["#FF4D4D","#76CCF3"]}else{var i=["#FCAF17","#3C5C9A"]}var s=document.getElementById(n);var o=s.getContext("2d");for(var u=0;u<t.length;u++)desenharSegmento(s,o,u,i,r);e&&desenharCirculo(s,o)}function converterRadianos(e){var t=[];for(var n=0;n<e.length;n++)t[n]=e[n]*3.6;return t}function obterRadianos(e){return e*Math.PI/180}function somarPonto(e,t){var n=0;for(var r=0;r<t;r++)n+=e[r];return n}function desenharSegmento(e,t,n,r,i){t.save();var s=Math.floor(e.width/2);var o=Math.floor(e.height/2);var u=-1.57+obterRadianos(somarPonto(i,n));t.beginPath();t.moveTo(s,o);t.arc(s,o,Math.floor(e.width/2),u,u+obterRadianos(i[n]),false);t.closePath();t.fillStyle=r[n];t.fill();t.restore()}function desenharCirculo(e,t){t.beginPath();t.fillStyle="#FFF";t.arc(Math.floor(e.width/2),Math.floor(e.height/2),55,0,2*Math.PI);t.fill()}