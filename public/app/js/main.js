var App = function () {
    return {
    	preloader: function() {
	    	var b = $(".preloader");
		    $(window).load(function() {
		        b.remove()
		    });
    	},
		openCloseInfo: function() {
			var clickHandler = ("ontouchstart" in window ? "touchend" : "click")
			$('#proyecto .moreinfo').on(clickHandler, function() {
				if ($(this).hasClass('open')) {
					$(this).fadeToggle();
						setTimeout(function(){ 
							$('.cerr').fadeToggle();
						 }, 600);
				} else {
					$(this).fadeToggle();
					setTimeout(function(){ 
						$('.open').fadeToggle();
					 }, 600);

				}
				// $(this).fadeToggle()
				$('.descripcion___').fadeToggle();
				// $('#proyecto .cerrar').fadeToggle();
				$('.scroll-to-top-arrow-button').fadeToggle();
				$('.infoContainer').toggleClass('infocontopen');
			});
			// $('#proyecto .cerrar').click(function(){
			// 	$('.scroll-to-top-arrow-button').toggleClass('invisible');
			// });
		},
        init: function () {
        	App.preloader();
        	App.openCloseInfo();
        }
    }
}();

jQuery(document).ready(function () {
    App.init();
});