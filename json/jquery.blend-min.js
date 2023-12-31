/*
	jQuery Blend v1.1 by Jack Moore - www.colorpowered.com - MIT license
*/
(function(a){a.fn.blend=function(b,d){var c=a.extend({},a.fn.blend.settings,b);a(this).each(function(){var p=a(this),g=a(c.target?c.target:this),l,n=[],k,f,e={},h=false,j=0,m=c.opacity,o=["background-color","background-image","background-repeat","background-attachment","background-position","background-position-x","background-position-y"];f=o.length;if(g[0].style.position!="absolute"){g.css({position:"relative"})}if(!g.hasClass("hover")){g.wrapInner('<div style="position:relative" />')}for(k=0;k<f;k++){n[k]=g.css(o[k])}g.addClass("hover");e={};e.position="absolute";e.top=0;e.left=0;e.width=g.css("width");e.height=g.css("height");for(k=0;k<f;k++){e[o[k]]=g.css(o[k])}if(g.find(".jsblend").length===0){l=a('<div class="jsblend" />').css(e);if(c.top){l.appendTo(g)}else{l.prependTo(g)}}else{l=g.find(".jsblend")}e={};for(k=0;k<f;k++){e[o[k]]=n[k]}g.css(e);if(c.reverse){j=c.opacity;m=0}l.css({opacity:j});function q(i){if(h){l.fadeTo(c.speed,i,function(){q(i==j?m:j)})}}if(c.pulse&&c.active){h=true;q(m)}else{if(c.pulse){p.hover(function(){h=true;q(m)},function(){h=false;l.stop(true).fadeTo(c.speed,j)})}else{p.hover(function(){l.stop().fadeTo(c.speed,m)},function(){l.stop().fadeTo(c.speed,j)})}}});return this};a.fn.blend.settings={speed:350,opacity:1,target:false,reverse:false,pulse:false,active:false,top:false}})(jQuery);

$(document).ready(function() {
	$("#navegacao ul li a").blend();
	$("h2 a").blend({pulse:true});
	$(".eventos a").blend();
	$(".agenda_de_cursos a").blend({pulse:true});
});