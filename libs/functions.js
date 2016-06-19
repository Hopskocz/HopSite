var i = 0;

$(document).ready(function(){
   $("nav a").fadeTo("slow", 1);
   $("article").fadeTo("slow", 1);
	$("nav a").click(function(event){
		event.preventDefault(); //stops page from reloading on link click
		var href = $(this).attr('href');
      $("article").fadeTo("fast", 0);
      $("nav a").fadeTo("fast", 0, function() {window.location = href});
	});
	$("#admin_panel_clicker").mouseenter(function(event){
		$("#admin_panel_clicker").animate({bottom: "0px", }, 400);
	});
	$("#admin_panel_clicker").mouseleave(function(event){
		$("#admin_panel_clicker").animate({bottom: "-24px", }, 400);
	});
});

function rainbowText(text) {
	document.write(text);
	setInterval(function() {
		rainbowizer();
	},1000/20);
}

function rainbowizer() {
	if(i++ >= 25) i = 0;
	$("header").css("color","rgb("+Math.round(Math.abs(Math.sin((i/25)*3.14)*255))+","
	+Math.round(Math.abs(Math.sin(((i/25)*3.14)+0.7)*255))+","
	+Math.round(Math.abs(Math.sin(((i/25)*3.14)+1.3)*255))+")");
}

function getQueryVariable(variable)
{
       var query = window.location.search.substring(1);
       var vars = query.split("&");
       for (var i=0;i<vars.length;i++) {
               var pair = vars[i].split("=");
               if(pair[0] == variable){return pair[1];}
       }
       return(false);
}
