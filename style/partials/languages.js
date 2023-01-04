(function($) {
	function languageSlide() {
		var iL = $('.current-language').width();
		var lW = $('.languages').width();
		var lC = $('.languages a').length;
		$('.languages').css({
			"width": '0vw',
			"left": -iL * lC
		});
		$('.languages a').css({
			width: iL
		});
		$('.languagewrapper').mouseover(function() {
			$('.languages').css({
				"left": iL
			});
		});
		$('.languagewrapper').mouseout(function() {
			$('.languages').css({
				"left": -iL * lC
			});
		});
	};
	$(window).on('load', function() {});
	$(document).ready(function() { languageSlide(); });
})(jQuery);

