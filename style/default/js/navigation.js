$(document).ready(function(){
	var nav_visible = false;
	$(".open-navigation").click(function(event){
		if(!nav_visible){
			$(".links").slideDown(300, function() { 
				$(this).css('display', 'flex');
			});
			nav_visible = true;
		}
		else{
			$(".links").slideUp(300, function(){ 
				$(this).removeAttr("style");
			});
			nav_visible = false;
		}
	});
	$(document).mouseup(function (e){
		if ($(".open-navigation").has(e.target).length === 0 && $(".links").has(e.target).length === 0){
			if(nav_visible){
				$(".links").slideUp(300, function(){ 
				$(this).removeAttr("style");
			});
				nav_visible = false;
			}
		}
	});
});

