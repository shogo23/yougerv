/*
*	Copyright (c) 2017 Scroll Animate Scroll Animate. Created by Victor Caviteno.
*	http://onegerv.cf
*	https://www.github.com/shogo23
*	GPL (http://www.opensource.org/licenses/gpl-license.php) licenses.
*	Version 1.0;
*/


(function($) {
	$.fn.scrollAnimate = function(param) {

		//Global window width.
		var window_width;

		//Global window height.
		var window_height;

		//Current window width.
		window_width = $(window).width();

		//Current window height.
		window_height = $(window).height();

		//If window resized, values change.
		$(window).resize(function() {

			//Current window width.
			window_width = $(window).width();

			//Current window height.
			window_height = $(window).height();
		});

		//Get scrollTop current position.
		var top = $(window).scrollTop();

		//Set Height bottom size.
		var bottom = window_height;

		//Get scrollLeft current position.
		var left = $(window).scrollLeft();

		//Set width size.
		var l_bottom = window_width;

		//This element into value.
		var element = $(this);

		//Global offset top.
		var offset_top;

		//Global offset left.
		var offset_left;

		//If param is empty/null.
		if (!param) {

			//Set default option.
			var option = {
				animation: "pulse",
				delay: 0
			};
		} else {

			//If animation option is not null. Set value.
			if (param['animation']) {

				//Set animation option value.
				var animation = param["animation"];
			} else {

				//Set default animation.
				var animation = "pulse";
			}

			//If delay option is not null.
			if (param["delay"]) {

				//Set delay value.
				var delay = param["delay"] * 1000;
			} else {

				//set delay value.
				var deley = 0;
			}

			//Option values.
			var option = {
				animation: animation,
				delay: delay
			};
		}

		//Loop and hide selected elements.
		element.each(function() {
			$(this).addClass("hidden");
		});


		//Loop selected elements
		element.each(function() {

			//Get element offset top.
			offset_top = $(this).offset().top;

			//Get element offset left.
			offset_left =  $(this).offset().left;

			//Selected element to a value.
			var elm = $(this);

			//Check elemement if is in range. Animate elements if true.
			if (offset_top >= top && offset_top <= bottom && offset_left >= left && offset_left <= l_bottom) {
				setTimeout(function() {
					elm.addClass("visible").addClass("animated").addClass(option["animation"]);
				}, option["delay"]);
			}
		});

		//Window scroll event.
		$(window).scroll(function() {

			//Get scrollTop.
			top = $(window).scrollTop();

			//Get scrollTop + window height.
			bottom = $(window).scrollTop() + window_height;

			//Get scrollLeft.
			left = $(window).scrollLeft();

			//Get scrollLeft + window width.
			l_bottom = $(window).scrollLeft() + window_width;

			//Loop selected elements.
			element.each(function(i) {

				//Get element offset top.
				offset_top = $(this).offset().top;

				//Get element offset left.
				offset_left = $(this).offset().left;

				var offset_height = offset_top + $(this).height() - 30;
				var offset_width = offset_left + $(this).width() - 30;

				//Check elemement if is in range. Animate elements if true.
				if ((offset_top >= top && offset_top <= bottom && offset_left >= left && offset_left <= l_bottom) || (offset_height >= top && offset_height <= bottom && offset_width >= left && offset_width <= l_bottom)) {

					var elm = $(this)

					setTimeout(function() {
						elm.addClass("visible").addClass("animated").addClass(option["animation"]);
					}, option["delay"]);
				}
			});
		});
	}
})(jQuery);