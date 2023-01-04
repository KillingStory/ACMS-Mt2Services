$(document).ready(function(){
	function switchController(classButton, dataButton, classBlock, dataBlock, saveHash){
		if(saveHash){
			var anc = window.location.hash.replace("#","");
			if(anc != '' && $(classButton + '[' + dataButton + ' = ' + anc + ']').length > 0){
				$(classButton + ',' + classBlock).removeClass("active");
				$(classButton + '[' + dataButton + ' = ' + anc + ']').addClass("active");
				$(classBlock + '[' + dataBlock + ' = ' + anc + ']').addClass("active");

				$('html, body').animate({
					scrollTop: ($(classButton + '[' + dataButton + ' = ' + anc + ']').offset().top) - 55
				}, Math.abs(($(classButton + '[' + dataButton + ' = ' + anc + ']').offset().top - $('html').scrollTop()) / 2));
			}
		}
		$(classButton).click(function(event){
			$(classButton + ',' + classBlock).removeClass("active");
			$(this).addClass("active");
			$(classBlock + '[' + dataBlock + ' = ' + $(this).attr(dataButton) + ']').addClass("active");
			if(saveHash){
				window.location.hash = $(this).attr(dataButton);
			}
		});
	}
	
	switchController('.rank-switch-btn', 'data-view-table', '.rank-switch-table', 'data-id-table', false); // rankings


});

