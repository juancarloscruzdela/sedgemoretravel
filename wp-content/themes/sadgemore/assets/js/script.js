// http://paulirish.com/2011/requestanimationframe-for-smart-animating/
// http://my.opera.com/emoller/blog/2011/12/20/requestanimationframe-for-smart-er-animating

// requestAnimationFrame polyfill by Erik Möller. fixes from Paul Irish and Tino Zijdel

// MIT license

(function () {
	var lastTime = 0;
	var vendors = ["ms", "moz", "webkit", "o"];
	for (var x = 0; x < vendors.length && !window.requestAnimationFrame; ++x) {
		window.requestAnimationFrame = window[vendors[x] + "RequestAnimationFrame"];
		window.cancelAnimationFrame = window[vendors[x] + "CancelAnimationFrame"] || window[vendors[x] + "CancelRequestAnimationFrame"];
	}

	if (!window.requestAnimationFrame)
		window.requestAnimationFrame = function (callback, element) {
			var currTime = new Date().getTime();
			var timeToCall = Math.max(0, 16 - (currTime - lastTime));
			var id = window.setTimeout(function () {
				callback(currTime + timeToCall);
			}, timeToCall);
			lastTime = currTime + timeToCall;
			return id;
		};

	if (!window.cancelAnimationFrame)
		window.cancelAnimationFrame = function (id) {
			clearTimeout(id);
		};
})();

$ = jQuery;

//ios adjust height
function appHeight() {
	var doc = document.documentElement;
	doc.style.setProperty("--app-height", window.innerHeight + "px");
}
window.addEventListener("resize", appHeight);

//function adjust banner height
function adjustBannerHeight() {
	//banner height - bottom nav height
	// var bannerHeight = $(window).height() - $(".header_nav").height();
	var bannerHeight = $(window).height() - $(".header_nav").outerHeight(true);

	// console.log("height",$(window).height()," header_nav", $(".header_nav").outerHeight(true));
	// console.log({bannerHeight});
	var doc = document.documentElement;
	doc.style.setProperty("--banner-height", bannerHeight + "px");
	// $('.owl-stage-outer').css('height', bannerHeight + "px !important;");
	// $('.owl-stage').css('height', bannerHeight + "px !important;");
}
window.addEventListener("resize", adjustBannerHeight);

(function ($) {
	"use strict";

	appHeight();
	adjustBannerHeight();

	//Hide Loading Box (Preloader)

	function handlePreloader() {
		if ($(".preloader").length) {
			$(".preloader").delay(200).fadeOut(500);
		}
	}

	//Update Header Style and Scroll to Top

	function headerStyle() {
		if ($(".main-header").length) {
			var windowpos = $(window).scrollTop();

			var siteHeader = $(".main-header");

			var scrollLink = $(".scroll-to-top");

			var HeaderHight = $(".main-header").height();

			if (windowpos >= HeaderHight) {
				siteHeader.addClass("fixed-header");

				scrollLink.fadeIn(300);
			} else {
				siteHeader.removeClass("fixed-header");

				scrollLink.fadeOut(300);
			}
		}
	}

	headerStyle();

	//Submenu Dropdown Toggle

	if ($(".main-header li.dropdown ul").length) {
		$(".main-header li.dropdown").append('<div class="dropdown-btn"><span class="fa fa-angle-down"></span></div>');

		//Dropdown Button

		$(".main-header li.dropdown .dropdown-btn").on("click", function () {
			$(this).prev("ul").slideToggle(500);
		});

		//Dropdown Menu / Fullscreen Nav

		$(".fullscreen-menu .navigation li.dropdown > a").on("click", function () {
			$(this).next("ul").slideToggle(500);
		});

		//Disable dropdown parent link

		$(".navigation li.dropdown > a").on("click", function (e) {
			e.preventDefault();
		});

		//Disable dropdown parent link

		$(".main-header .navigation li.dropdown > a,.hidden-bar .side-menu li.dropdown > a").on("click", function (e) {
			e.preventDefault();
		});
	}

	//Mobile Nav Hide Show

	if ($(".mobile-menu").length) {
		$(".mobile-menu .menu-box").mCustomScrollbar();

		var mobileMenuContent = $(".main-header .nav-outer .main-menu").html();

		$(".mobile-menu .menu-box .menu-outer").append(mobileMenuContent);

		$(".sticky-header .main-menu").append(mobileMenuContent);

		//Dropdown Button

		$(".mobile-menu li.dropdown .dropdown-btn").on("click", function () {
			$(this).toggleClass("open");

			$(this).prev("ul").slideToggle(500);
		});

		//Menu Toggle Btn

		$(".mobile-nav-toggler").on("click", function () {
			$("body").addClass("mobile-menu-visible");
		});

		//Menu Toggle Btn

		$(".mobile-menu .menu-backdrop,.mobile-menu .close-btn").on("click", function () {
			$("body").removeClass("mobile-menu-visible");
		});
	}

	//Header Search

	if ($(".search-box-outer").length) {
		$(".search-box-outer").on("click", function () {
			$("body").addClass("search-active");
		});

		$(".close-search").on("click", function () {
			$("body").removeClass("search-active");
		});
	}

	//Hidden Sidebar

	if ($(".hidden-bar,.fullscreen-menu").length) {
		var hiddenBar = $(".hidden-bar");

		var hiddenBarOpener = $(".nav-toggler");

		var hiddenBarCloser = $(".hidden-bar-closer,.close-menu");

		$(".hidden-bar-wrapper").mCustomScrollbar();

		//Show Sidebar

		hiddenBarOpener.on("click", function () {
			$("body").addClass("visible-menu-bar");

			hiddenBar.addClass("visible-sidebar");
		});

		//Hide Sidebar

		hiddenBarCloser.on("click", function () {
			$("body").removeClass("visible-menu-bar");

			hiddenBar.removeClass("visible-sidebar");
		});
	}

	//Hidden Sidebar

	if ($(".hidden-bar").length) {
		var hiddenBar = $(".hidden-bar");

		var hiddenBarOpener = $(".nav-toggler");

		var hiddenBarCloser = $(".hidden-bar-closer");

		$(".hidden-bar-wrapper").mCustomScrollbar();

		//Show Sidebar

		hiddenBarOpener.on("click", function () {
			hiddenBar.addClass("visible-sidebar");
		});

		//Hide Sidebar

		hiddenBarCloser.on("click", function () {
			hiddenBar.removeClass("visible-sidebar");
		});
	}

	//Hidden Bar Menu Config

	function hiddenBarMenuConfig() {
		var menuWrap = $(".hidden-bar .side-menu");

		// appending expander button

		menuWrap
			.find(".dropdown")
			.children("a")
			.append(function () {
				return '<button type="button" class="btn expander"><i class="icon fa fa-angle-right"></i></button>';
			});

		// hidding submenu

		menuWrap.find(".dropdown").children("ul").hide();

		// toggling child ul

		menuWrap.find(".btn.expander").each(function () {
			$(this).on("click", function () {
				$(this)
					.parent() // return parent of .btn.expander (a)

					.parent() // return parent of a (li)

					.children("ul")
					.slideToggle();

				// adding class to expander container

				$(this).parent().toggleClass("current");

				// toggling arrow of expander

				$(this).find("i").toggleClass("fa-angle-right fa-angle-down");

				return false;
			});
		});
	}

	hiddenBarMenuConfig();

	//Custom Seclect Box

	if ($(".custom-select-box").length) {
		$(".custom-select-box").selectmenu().selectmenu("menuWidget").addClass("overflow");
	}

	//Parallax Scene for Icons

	if ($(".parallax-scene-1").length) {
		var scene = $(".parallax-scene-1").get(0);

		var parallaxInstance = new Parallax(scene);
	}

	if ($(".parallax-scene-2").length) {
		var scene = $(".parallax-scene-2").get(0);

		var parallaxInstance = new Parallax(scene);
	}

	if ($(".parallax-scene-3").length) {
		var scene = $(".parallax-scene-3").get(0);

		var parallaxInstance = new Parallax(scene);
	}

	if ($(".parallax-scene-4").length) {
		var scene = $(".parallax-scene-4").get(0);

		var parallaxInstance = new Parallax(scene);
	}

	if ($(".paroller").length) {
		$(".paroller").paroller({
			factor: 0.2, // multiplier for scrolling speed and offset, +- values for direction control

			factorLg: 0.4, // multiplier for scrolling speed and offset if window width is less than 1200px, +- values for direction control

			type: "foreground", // background, foreground

			direction: "horizontal", // vertical, horizontal
		});
	}

	//Gallery Filters

	if ($(".filter-list").length) {
		$(".filter-list").mixItUp({});
	}

	//Fact Counter + Text Count

	if ($(".count-box").length) {
		$(".count-box").appear(
			function () {
				var $t = $(this),
					n = $t.find(".count-text").attr("data-stop"),
					r = parseInt($t.find(".count-text").attr("data-speed"), 10);

				if (!$t.hasClass("counted")) {
					$t.addClass("counted");

					$({
						countNum: $t.find(".count-text").text(),
					}).animate(
						{
							countNum: n,
						},
						{
							duration: r,

							easing: "linear",

							step: function () {
								$t.find(".count-text").text(Math.floor(this.countNum));
							},

							complete: function () {
								$t.find(".count-text").text(this.countNum);
							},
						}
					);
				}
			},
			{ accY: 0 }
		);
	}

	//Main Slider Carousel

	//Banner Carousel

	if ($(".banner-carousel").length) {
		$(".banner-carousel").owlCarousel({
			animateOut: "fadeOut",

			animateIn: "fadeIn",

			loop: true,

			margin: 0,

			nav: true,

			smartSpeed: 700,

			autoHeight: true,

			autoplay: true,

			autoplayTimeout: 10000,

			navText: ['<span class="fa fa-long-arrow-left"></span> prev', 'next<span class="fa fa-long-arrow-right"></span>'],

			responsive: {
				0: {
					items: 1,
				},

				600: {
					items: 1,
				},

				1024: {
					items: 1,
				},
			},
		});
	}

	// Single Item Carousel

	if ($(".single-item-carousel").length) {
		$(".single-item-carousel").owlCarousel({
			loop: true,

			margin: 0,

			nav: true,

			smartSpeed: 500,

			autoplay: 4000,

			navText: ['<span class="fa fa-angle-left"></span>', '<span class="fa fa-angle-right"></span>'],

			responsive: {
				0: {
					items: 1,
				},

				480: {
					items: 1,
				},

				600: {
					items: 1,
				},

				800: {
					items: 1,
				},

				1024: {
					items: 1,
				},
			},
		});
	}

	// Three Item Carousel

	if ($(".three-item-carousel").length) {
		$(".three-item-carousel").owlCarousel({
			loop: true,

			margin: 30,

			nav: true,

			smartSpeed: 500,

			autoplay: 4000,

			navText: ['<span class="fa fa-angle-left"></span>', '<span class="fa fa-angle-right"></span>'],

			responsive: {
				0: {
					items: 1,
				},

				480: {
					items: 1,
				},

				600: {
					items: 2,
				},

				800: {
					items: 3,
				},

				1024: {
					items: 3,
				},
			},
		});
	}

	// Five Item Carousel

	if ($(".five-item-carousel").length) {
		$(".five-item-carousel").owlCarousel({
			loop: true,

			margin: 15,

			nav: true,

			smartSpeed: 500,

			autoplay: 4000,

			navText: ['<span class="fa fa-angle-left"></span>', '<span class="fa fa-angle-right"></span>'],

			responsive: {
				0: {
					items: 1,
				},

				480: {
					items: 1,
				},

				600: {
					items: 2,
				},

				800: {
					items: 3,
				},

				1024: {
					items: 4,
				},

				1224: {
					items: 5,
				},

				1424: {
					items: 5,
				},
			},
		});
	}

	// Testimonial Carousel

	if ($(".testimonial-carousel").length) {
		$(".testimonial-carousel").owlCarousel({
			loop: true,

			margin: 0,

			nav: true,

			smartSpeed: 500,

			autoplay: 4000,

			navText: ['<span class="fa fa-angle-left"></span>', '<span class="fa fa-angle-right"></span>'],

			responsive: {
				0: {
					items: 1,
				},

				480: {
					items: 1,
				},

				600: {
					items: 1,
				},

				800: {
					items: 2,
				},

				1024: {
					items: 2,
				},
			},
		});
	}

	if ($(".clock-wrapper").length) {
		(function () {
			//generate clock animations

			var now = new Date(),
				hourDeg = (now.getHours() / 12) * 360 + (now.getMinutes() / 60) * 30,
				minuteDeg = (now.getMinutes() / 60) * 360 + (now.getSeconds() / 60) * 6,
				secondDeg = (now.getSeconds() / 60) * 360,
				stylesDeg = [
					"@-webkit-keyframes rotate-hour{from{transform:rotate(" + hourDeg + "deg);}to{transform:rotate(" + (hourDeg + 360) + "deg);}}",

					"@-webkit-keyframes rotate-minute{from{transform:rotate(" + minuteDeg + "deg);}to{transform:rotate(" + (minuteDeg + 360) + "deg);}}",

					"@-webkit-keyframes rotate-second{from{transform:rotate(" + secondDeg + "deg);}to{transform:rotate(" + (secondDeg + 360) + "deg);}}",

					"@-moz-keyframes rotate-hour{from{transform:rotate(" + hourDeg + "deg);}to{transform:rotate(" + (hourDeg + 360) + "deg);}}",

					"@-moz-keyframes rotate-minute{from{transform:rotate(" + minuteDeg + "deg);}to{transform:rotate(" + (minuteDeg + 360) + "deg);}}",

					"@-moz-keyframes rotate-second{from{transform:rotate(" + secondDeg + "deg);}to{transform:rotate(" + (secondDeg + 360) + "deg);}}",
				].join("");

			document.getElementById("clock-animations").innerHTML = stylesDeg;
		})();
	}

	//Progress Bar

	if ($(".progress-line").length) {
		$(".progress-line").appear(
			function () {
				var el = $(this);

				var percent = el.data("width");

				$(el).css("width", percent + "%");
			},
			{ accY: 0 }
		);
	}

	// Sponsors Item Carousel

	if ($(".sponsors-carousel").length) {
		$(".sponsors-carousel").owlCarousel({
			loop: true,

			margin: 0,

			nav: true,

			smartSpeed: 500,

			autoplay: 4000,

			navText: ['<span class="fa fa-angle-left"></span>', '<span class="fa fa-angle-right"></span>'],

			responsive: {
				0: {
					items: 1,
				},

				480: {
					items: 2,
				},

				600: {
					items: 3,
				},

				800: {
					items: 4,
				},

				1024: {
					items: 4,
				},
			},
		});
	}

	//Event Countdown Timer

	if ($(".time-countdown").length) {
		$(".time-countdown").each(function () {
			var $this = $(this),
				finalDate = $(this).data("countdown");

			$this.countdown(finalDate, function (event) {
				var $this = $(this).html(event.strftime("" + '<div class="counter-column"><span class="count">%D</span>Days</div> ' + '<div class="counter-column"><span class="count">%H</span>Hours</div>  ' + '<div class="counter-column"><span class="count">%M</span>Minutes</div>  ' + '<div class="counter-column"><span class="count">%S</span>Seconds</div>'));
			});
		});
	}

	if ($(".clock-wrapper").length) {
		(function () {
			//generate clock animations

			var now = new Date(),
				hourDeg = (now.getHours() / 12) * 360 + (now.getMinutes() / 60) * 30,
				minuteDeg = (now.getMinutes() / 60) * 360 + (now.getSeconds() / 60) * 6,
				secondDeg = (now.getSeconds() / 60) * 360,
				stylesDeg = [
					"@-webkit-keyframes rotate-hour{from{transform:rotate(" + hourDeg + "deg);}to{transform:rotate(" + (hourDeg + 360) + "deg);}}",

					"@-webkit-keyframes rotate-minute{from{transform:rotate(" + minuteDeg + "deg);}to{transform:rotate(" + (minuteDeg + 360) + "deg);}}",

					"@-webkit-keyframes rotate-second{from{transform:rotate(" + secondDeg + "deg);}to{transform:rotate(" + (secondDeg + 360) + "deg);}}",

					"@-moz-keyframes rotate-hour{from{transform:rotate(" + hourDeg + "deg);}to{transform:rotate(" + (hourDeg + 360) + "deg);}}",

					"@-moz-keyframes rotate-minute{from{transform:rotate(" + minuteDeg + "deg);}to{transform:rotate(" + (minuteDeg + 360) + "deg);}}",

					"@-moz-keyframes rotate-second{from{transform:rotate(" + secondDeg + "deg);}to{transform:rotate(" + (secondDeg + 360) + "deg);}}",
				].join("");

			document.getElementById("clock-animations").innerHTML = stylesDeg;
		})();
	}

	// Product Carousel Slider

	if ($(".shop-page .image-carousel").length && $(".shop-page .thumbs-carousel").length) {
		var $sync1 = $(".shop-page .image-carousel"),
			$sync2 = $(".shop-page .thumbs-carousel"),
			flag = false,
			duration = 500;

		$sync1

			.owlCarousel({
				loop: true,

				items: 1,

				margin: 0,

				nav: false,

				navText: ['<span class="icon fa fa-angle-left"></span>', '<span class="icon fa fa-angle-right"></span>'],

				dots: false,

				autoplay: true,

				autoplayTimeout: 5000,
			})

			.on("changed.owl.carousel", function (e) {
				if (!flag) {
					flag = false;

					$sync2.trigger("to.owl.carousel", [e.item.index, duration, true]);

					flag = false;
				}
			});

		$sync2

			.owlCarousel({
				loop: true,

				margin: 20,

				items: 1,

				nav: true,

				navText: ['<span class="icon fa fa-angle-left"></span>', '<span class="icon fa fa-angle-right"></span>'],

				dots: false,

				center: false,

				autoplay: true,

				autoplayTimeout: 5000,

				responsive: {
					0: {
						items: 2,

						autoWidth: false,
					},

					400: {
						items: 3,

						autoWidth: false,
					},

					600: {
						items: 4,

						autoWidth: false,
					},

					900: {
						items: 5,

						autoWidth: false,
					},

					1000: {
						items: 4,

						autoWidth: false,
					},
				},
			})

			.on("click", ".owl-item", function () {
				$sync1.trigger("to.owl.carousel", [$(this).index(), duration, true]);
			})

			.on("changed.owl.carousel", function (e) {
				if (!flag) {
					flag = true;

					$sync1.trigger("to.owl.carousel", [e.item.index, duration, true]);

					flag = false;
				}
			});
	}

	//Jquery Spinner / Quantity Spinner

	if ($(".quantity-spinner").length) {
		$("input.quantity-spinner").TouchSpin({
			verticalbuttons: true,
		});
	}

	//Tabs Box

	if ($(".tabs-box").length) {
		$(".tabs-box .tab-buttons .tab-btn").on("click", function (e) {
			e.preventDefault();

			var target = $($(this).attr("data-tab"));

			if ($(target).is(":visible")) {
				return false;
			} else {
				target.parents(".tabs-box").find(".tab-buttons").find(".tab-btn").removeClass("active-btn");

				$(this).addClass("active-btn");

				target.parents(".tabs-box").find(".tabs-content").find(".tab").fadeOut(0);

				target.parents(".tabs-box").find(".tabs-content").find(".tab").removeClass("active-tab");

				$(target).fadeIn(300);

				$(target).addClass("active-tab");
			}
		});
	}

	//Accordion Box

	if ($(".accordion-box").length) {
		$(".accordion-box").on("click", ".acc-btn", function () {
			var outerBox = $(this).parents(".accordion-box");

			var target = $(this).parents(".accordion");

			if ($(this).hasClass("active") !== true) {
				$(outerBox).find(".accordion .acc-btn").removeClass("active");
			}

			if ($(this).next(".acc-content").is(":visible")) {
				return false;
			} else {
				$(this).addClass("active");

				$(outerBox).children(".accordion").removeClass("active-block");

				$(outerBox).find(".accordion").children(".acc-content").slideUp(300);

				target.addClass("active-block");

				$(this).next(".acc-content").slideDown(300);
			}
		});
	}

	//LightBox / Fancybox

	if ($(".lightbox-image").length) {
		$(".lightbox-image").fancybox({
			openEffect: "fade",

			closeEffect: "fade",

			helpers: {
				media: {},
			},
		});
	}

	//Contact Form Validation
	if ($("#contact-form").length) {
		$("#contact-form").validate({
			rules: {
				username: {
					required: true,
				},
				surname: {
					required: true,
				},
				email: {
					required: function (element) {
						return $("#phone").val() === "";
					},
					email: true,
				},
				phone: {
					required: function (element) {
						return $("#email").val() === "";
					},
				},
				subject: {
					required: true,
				},
				message: {
					required: true,
				},
			},
		});
	}

	// Scroll to a Specific Div

	if ($(".scroll-to-target").length) {
		$(".scroll-to-target").on("click", function () {
			var target = $(this).attr("data-target");

			// animate

			$("html, body").animate(
				{
					scrollTop: $(target).offset().top,
				},
				1500
			);
		});
	}

	// Elements Animation
/*
	if ($(".wow").length) {
		var wow = new WOW({
			boxClass: "wow", // animated element css class (default is wow)

			animateClass: "animated", // animation css class (default is animated)

			offset: 0, // distance to the element when triggering the animation (default is 0)

			mobile: true, // trigger animations on mobile devices (default is true)

			live: true, // act on asynchronously loaded content (default is true)
		});

		wow.init();
	}*/

	/* ==========================================================================

   When document is Scrollig, do

   ========================================================================== */

	$(window).on("scroll", function () {
		headerStyle();
	});

	/* ==========================================================================

   When document is loading, do

   ========================================================================== */

	$(window).on("load", function () {
		handlePreloader();
	});
})(window.jQuery);
/*
$(window).scroll(function () {
	var scroll = $(window).scrollTop();

	if (scroll >= 10) {
		$(".header_nav").addClass("header_nav_fixed___a");
	} else {
		$(".header_nav").removeClass("header_nav_fixed___a");
	}
});
*/
/*
$(window).scroll(function () {
	var scroll = $(window).scrollTop();

	if (scroll >= 50) { 
		$(".header_new").addClass("aply_black_hedr");
	} else {
		$(".header_new").removeClass("aply_black_hedr");
	}
});*/

/* blur other team members on hover */
$(".item .wrap_team_all")
	.on("mouseenter", ".prof_layer", function () {
		$(this).siblings(".prof_layer").addClass("blur");
		$(this).removeClass("blur");
	})
	.on("mouseleave", ".prof_layer", function () {
		$(this).siblings(".prof_layer").removeClass("blur");
	});

$(function () {
	$(".nav_a")
		.mouseenter(function () {
			$(".activ_home").addClass("activ_home_remove");
		})
		.mouseleave(function () {
			$(".activ_home").removeClass("activ_home_remove");
		});
});

/* $(function () {
	$(".enqry_btn")
		.mouseenter(function () {
			$(".center_slider_text_iner").addClass("center_slider_text_iner_border");
		})
		.mouseleave(function () {
			$(".center_slider_text_iner").removeClass("center_slider_text_iner_border");
		});
}); */

$(function () {
	function enquireButton() {
		if ($(window).width() > 767) {
			var elementWidth = 144;
			var elementHeight = 38;
			$(".enqry_btn")
				.mouseenter(function () {
					var parentWidth = $(this).parent().parent(".center_slider_text_iner").width();
					var parentHeight = $(this).parent().parent(".center_slider_text_iner").outerHeight()+20;
					$(".enqry_btn_overlay").css({ width: parentWidth + "px", height: parentHeight + "px" });
					$(".enqry_btn_overlay").addClass("enqry_btn_overlay_hover");
					//console.log("mouseenter", { width: parentWidth + "px", height: parentHeight + "px" });
				})
				.mouseleave(function () {
					$(".enqry_btn_overlay").css({ width: elementWidth + "px", height: elementHeight + "px" });
					$(".enqry_btn_overlay").removeClass("enqry_btn_overlay_hover");
					//console.log("mouseleave", { width: elementWidth + "px", height: elementHeight + "px" });
				});
		}
	}
	enquireButton();

	function enquireButton2() {
		if ($(window).width() > 767) {
			var elementWidth = 144;
			var elementHeight = 38;
			$(".enqry_btn2")
				.mouseenter(function () {
					var parentWidth = $(this).parent().parent(".center_slider_text_iner").width();
					var parentHeight = $(this).parent().parent(".center_slider_text_iner").outerHeight() + 20;
					$(".enqry_btn2_overlay").css({ width: parentWidth + "px", height: parentHeight + "px" });
					$(".enqry_btn2_overlay").addClass("enqry_btn2_overlay_hover");
					//console.log("mouseenter", { width: parentWidth + "px", height: parentHeight + "px" });
				})
				.mouseleave(function () {
					$(".enqry_btn2_overlay").css({ width: elementWidth + "px", height: elementHeight + "px" });
					$(".enqry_btn2_overlay").removeClass("enqry_btn2_overlay_hover");
					//console.log("mouseleave", { width: elementWidth + "px", height: elementHeight + "px" });
				});
		}
	}
	enquireButton2();
});

$(function () {
	$(".owl-next")
		.mouseenter(function () {
			$(".visn_rigth").addClass("visn_rigth_hover");
		})
		.mouseleave(function () {
			$(".visn_rigth").removeClass("visn_rigth_hover");
		});
});

$(function () {
	$(".owl-prev")
		.mouseenter(function () {
			$(".visn_left").addClass("visn_left_hover");
		})
		.mouseleave(function () {
			$(".visn_left").removeClass("visn_left_hover");
		});
});

$(document).ready(function () {
	$(window).scroll(function () {
		$(".header_nav").removeClass("header_nav_hide");

		if ($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
			//you are at bottom

			$(".header_nav").addClass("header_nav_hide");
		}
	});

	$(".hit_btn1").click(function () {
		$(".show_page_1").addClass("show_page_show");
	});

	$(".hit_btn1").click(function () {
		$(".main-footer").addClass("footer_spacing");
	});

	$(".hit_btn2").click(function () {
		$(".show_page_2").addClass("show_page_show");
	});

	$(".hit_btn2").click(function () {
		$(".main-footer").addClass("footer_spacing");
	});

	$(".hit_btn3").click(function () {
		$(".show_page_3").addClass("show_page_show");
	});

	$(".hit_btn3").click(function () {
		$(".main-footer").addClass("footer_spacing");
	});

	$(".hit_btn4").click(function () {
		$(".show_page_4").addClass("show_page_show");
	});

	$(".hit_btn4").click(function () {
		$(".main-footer").addClass("footer_spacing");
	});

	$(".hit_btn5").click(function () {
		$(".show_page_5").addClass("show_page_show");
	});

	$(".hit_btn5").click(function () {
		$(".main-footer").addClass("footer_spacing");
	});

	$("button").click(function () {
		$("#div1").fadeIn();

		$("#div2").fadeIn("slow");

		$("#div3").fadeIn(3000);
	});

	$(".remove_all_pages").click(function () {
		$(".show_page_2").removeClass("show_page_show");
	});

	$(".hit_btn1").click(function () {
		$(".show_page_2").removeClass("show_page_show");

		$(".show_page_3").removeClass("show_page_show");

		$(".show_page_4").removeClass("show_page_show");

		$(".show_page_5").removeClass("show_page_show");
	});

	$(".hit_btn2").click(function () {
		$(".show_page_1").removeClass("show_page_show");

		$(".show_page_3").removeClass("show_page_show");

		$(".show_page_4").removeClass("show_page_show");

		$(".show_page_5").removeClass("show_page_show");
	});

	$(".hit_btn3").click(function () {
		$(".show_page_1").removeClass("show_page_show");

		$(".show_page_2").removeClass("show_page_show");

		$(".show_page_4").removeClass("show_page_show");

		$(".show_page_5").removeClass("show_page_show");
	});

	$(".hit_btn4").click(function () {
		$(".show_page_1").removeClass("show_page_show");

		$(".show_page_2").removeClass("show_page_show");

		$(".show_page_3").removeClass("show_page_show");

		$(".show_page_5").removeClass("show_page_show");
	});

	$(".hit_btn5").click(function () {
		$(".show_page_1").removeClass("show_page_show");

		$(".show_page_2").removeClass("show_page_show");

		$(".show_page_3").removeClass("show_page_show");

		$(".show_page_4").removeClass("show_page_show");
	});
});

/*
$(document).ready(function () {
	if ($(window).width() > 600) {
		$(".right_search").click(function () {
			$(".dwlnd").addClass("s-dwlnd");
			setTimeout(function () {
				$(".backgrnd_color_serch").addClass("backgrnd_color_serch_show");
			}, 60); // Delay of 3 seconds
		});

		$(".right_search").click(function () {
			$(".header_nav").addClass("header_nav_search");
			$(".search_wrap_main").addClass("search_wrap_main_show");
			$("body").addClass("search_bar_on");
		});
	}

	$(".right_search_close").click(function () {
		$(".header_nav").removeClass("header_nav_search");

		$(".search_wrap_main").removeClass("search_wrap_main_show");

		$("body").removeClass("search_bar_on");
	});
});

$(document).ready(function () {
	$(".right_search_close").click(function () {
		$(".dwlnd").removeClass("s-dwlnd");

		setTimeout(function () {
			$(".backgrnd_color_serch").removeClass("backgrnd_color_serch_show");
		}, 60); // Delay of 3 seconds
	});
});

$(document).ready(function () {
	if ($(window).width() > 600) {
		$(".right_search").click(function () {
			$(".dwlnd").addClass("s-dwlnd");
			setTimeout(function () {
				$(".aply_black_hedr").addClass("aply_black_hedr_smoth");
			}, 100); // Delay of 3 seconds
		});
	}
});

$(document).ready(function () {
	$(".right_search_close").click(function () {
		$(".dwlnd").addClass("s-dwlnd");

		setTimeout(function () {
			$(".aply_black_hedr").removeClass("aply_black_hedr_smoth");
		}, 100); // Delay of 3 seconds
	});

	if ($(window).width() > 600) {
		$(".right_search").click(function () {
			$(".dwlnd").addClass("s-dwlnd");
			setTimeout(function () {
				$(".search_wrap_iner").addClass("search_wrap_iner_norml");
			}, 2000); // Delay of 3 seconds
		});

		$(".right_search").click(function () {
			$(".search_bar_input").focus();
		});
	}
});

*/

$(document).ready(function () {
	$(".owl-next").click(function () {
		setTimeout(function () {
			$(".mangmnt_team_line_left").addClass("mangmnt_team_line_left_hide");
			$(".mangmnt_team_line_rigth").addClass("mangmnt_team_line_rigth_hide");
		}, 1000); // Delay of 3 seconds
	});
});

$(document).ready(function () {
	$(".owl-next").click(function () {
		setTimeout(function () {
			$(".mangmnt_team_line_left").removeClass("mangmnt_team_line_left_hide");
			$(".mangmnt_team_line_rigth").removeClass("mangmnt_team_line_rigth_hide");
		}, 2500); // Delay of 3 seconds
	});
});

$(document).ready(function () {
	$(".owl-prev").click(function () {
		setTimeout(function () {
			$(".mangmnt_team_line_left").addClass("mangmnt_team_line_left_hide");
			$(".mangmnt_team_line_rigth").addClass("mangmnt_team_line_rigth_hide");
		}, 500); // Delay of 3 seconds
	});
});

$(document).ready(function () {
	$(".owl-prev").click(function () {
		setTimeout(function () {
			$(".mangmnt_team_line_left").removeClass("mangmnt_team_line_left_hide");
			$(".mangmnt_team_line_rigth").removeClass("mangmnt_team_line_rigth_hide");
		}, 2000); // Delay of 3 seconds
	});
});

$(function () {
	$(".wrap_team_persn").click(function () {
		setTimeout(function () {
			$(".wrap_team_left ").addClass("wrap_team_left_big");
		}, 300); // Delay of 3 seconds
	});

	$(".wrap_team_persn")
		.mouseover(function () {
			$(".wrap_team_persn").not(this).addClass("blur");
		})
		.mouseout(function () {
			$(".wrap_team_persn").removeClass("blur");
		});
});

$(document).ready(function () {
	$(".a_cross_ancr").click(function () {
		setTimeout(function () {
			$(".wrap_team_left ").removeClass("wrap_team_left_big");
		}, 200); // Delay of 3 seconds
	});
});

$(document).ready(function () {
	$(".a_cross_ancr").click(function () {
		setTimeout(function () {
			$(".show_page_1 ").removeClass("show_page_show");
			$(".main-footer ").removeClass("footer_spacing");
			$(".show_page_2 ").removeClass("show_page_show");
			$(".show_page_3 ").removeClass("show_page_show");
			$(".show_page_4 ").removeClass("show_page_show");
			$(".show_page_5 ").removeClass("show_page_show");
		}, 1000); // Delay of 3 seconds
	});
});

$(document).ready(function () {
	$(".a_cross_ancr").click(function () {
		setTimeout(function () {
			$(".team_right_dm ").addClass("team_right_dm_gone");
		}, 200); // Delay of 3 seconds
	});
});

$(document).ready(function () {
	$(".a_cross_ancr").click(function () {
		setTimeout(function () {
			$(".show_page ").addClass("show_page_opcti_0");
		}, 800); // Delay of 3 seconds
	});
});

$(document).ready(function () {
	$(".a_cross_ancr").click(function () {
		setTimeout(function () {
			$(".show_page ").removeClass("show_page_opcti_0");
		}, 3000); // Delay of 3 seconds
	});
});

$(document).ready(function () {
	$(".owl-next").click(function () {
		setTimeout(function () {
			$(".mangmnt_team").addClass("hide_css");
		}, 1); // Delay of 3 seconds
	});
});

$(document).ready(function () {
	$(".owl-next").click(function () {
		setTimeout(function () {
			$(".mangmnt_team").removeClass("hide_css");
		}, 100); // Delay of 3 seconds
	});
});

$(document).ready(function () {
	$(".owl-prev").click(function () {
		setTimeout(function () {
			$(".mangmnt_team").addClass("hide_css");
		}, 1); // Delay of 3 seconds
	});
});

$(document).ready(function () {
	$(".owl-prev").click(function () {
		setTimeout(function () {
			$(".mangmnt_team").removeClass("hide_css");
		}, 100); // Delay of 3 seconds
	});
});

$(document).ready(function () {
	$(".owl-next").click(function () {
		setTimeout(function () {
			$(".mangmnt_team").addClass("classname");
		}, 100); // Delay of 3 seconds
	});
});

$(document).ready(function () {
	$(".owl-next").click(function () {
		setTimeout(function () {
			$(".mangmnt_team").removeClass("classname");
		}, 1000); // Delay of 3 seconds
	});
});

$(document).ready(function () {
	$(".owl-prev").click(function () {
		setTimeout(function () {
			$(".mangmnt_team").addClass("classname");
		}, 10); // Delay of 3 seconds
	});
});

$(document).ready(function () {
	$(".owl-prev").click(function () {
		setTimeout(function () {
			$(".mangmnt_team").removeClass("classname");
		}, 1000); // Delay of 3 seconds
	});
});

/*_______________________________________________*/

var lFollowX = 0,
	lFollowY = 0,
	x = 0,
	y = 0,
	friction = 1 / 1;

function animtn1() {
	x += (lFollowX - x) * friction;
	y += (lFollowY - y) * friction;

	translate = "translate(" + x + "px, " + y + "px) scale(1.1)";

	$(".travl_img_main_1_blurrr").css({
		"-webit-transform": translate,
		"-moz-transform": translate,
	});
	window.requestAnimationFrame(animtn1);
}

$(".hit_btn1").on("mousemove click", function (e) {
	var lMouseX = Math.max(-100, Math.min(100, $(window).width() / 2 - e.clientX));
	var lMouseY = Math.max(-100, Math.min(100, $(window).height() / 2 - e.clientY));
	lFollowX = (10 * lMouseX) / 100; // 100 : 12 = lMouxeX : lFollow
	lFollowY = (10 * lMouseY) / 100;
});
animtn1();

/*_______________________________________________*/

var lFollowX = 0,
	lFollowY = 0,
	x = 0,
	y = 0,
	friction = 1 / 1;

function animtn2() {
	x += (lFollowX - x) * friction;
	y += (lFollowY - y) * friction;

	translate = "translate(" + x + "px, " + y + "px) scale(1.1)";

	$(".travl_img_main_2_blurrr").css({
		"-webit-transform": translate,
		"-moz-transform": translate,
	});
	window.requestAnimationFrame(animtn2);
}

$(".hit_btn2").on("mousemove click", function (a) {
	var lMouseX = Math.max(-100, Math.min(100, $(window).width() / 2 - a.clientX));
	var lMouseY = Math.max(-100, Math.min(100, $(window).height() / 2 - a.clientY));
	lFollowX = (10 * lMouseX) / 100; // 100 : 12 = lMouxeX : lFollow
	lFollowY = (10 * lMouseY) / 100;
});
animtn2();

/*_______________________________________________*/

var lFollowX = 0,
	lFollowY = 0,
	x = 0,
	y = 0,
	friction = 1 / 1;

function animtn3() {
	x += (lFollowX - x) * friction;
	y += (lFollowY - y) * friction;

	translate = "translate(" + x + "px, " + y + "px) scale(1.1)";

	$(".travl_img_main_3_blurrr").css({
		"-webit-transform": translate,
		"-moz-transform": translate,
	});
	window.requestAnimationFrame(animtn3);
}

$(".hit_btn3").on("mousemove click", function (b) {
	var lMouseX = Math.max(-100, Math.min(100, $(window).width() / 2 - b.clientX));
	var lMouseY = Math.max(-100, Math.min(100, $(window).height() / 2 - b.clientY));
	lFollowX = (10 * lMouseX) / 100; // 100 : 12 = lMouxeX : lFollow
	lFollowY = (10 * lMouseY) / 100;
});
animtn3();

/*_______________________________________________*/

var lFollowX = 0,
	lFollowY = 0,
	x = 0,
	y = 0,
	friction = 1 / 1;

function animtn4() {
	x += (lFollowX - x) * friction;
	y += (lFollowY - y) * friction;

	translate = "translate(" + x + "px, " + y + "px) scale(1.1)";

	$(".travl_img_main_4_blurrr").css({
		"-webit-transform": translate,
		"-moz-transform": translate,
	});
	window.requestAnimationFrame(animtn4);
}

$(".hit_btn4").on("mousemove click", function (c) {
	var lMouseX = Math.max(-100, Math.min(100, $(window).width() / 2 - c.clientX));
	var lMouseY = Math.max(-100, Math.min(100, $(window).height() / 2 - c.clientY));
	lFollowX = (10 * lMouseX) / 100; // 100 : 12 = lMouxeX : lFollow
	lFollowY = (10 * lMouseY) / 100;
});
animtn4();

/*_______________________________________________*/

var lFollowX = 0,
	lFollowY = 0,
	x = 0,
	y = 0,
	friction = 1 / 1;

function animtn5() {
	x += (lFollowX - x) * friction;
	y += (lFollowY - y) * friction;

	translate = "translate(" + x + "px, " + y + "px) scale(1.1)";

	$(".travl_img_main_5_blurrr").css({
		"-webit-transform": translate,
		"-moz-transform": translate,
	});
	window.requestAnimationFrame(animtn5);
}

$(".hit_btn5").on("mousemove click", function (c) {
	var lMouseX = Math.max(-100, Math.min(100, $(window).width() / 2 - c.clientX));
	var lMouseY = Math.max(-100, Math.min(100, $(window).height() / 2 - c.clientY));
	lFollowX = (10 * lMouseX) / 100; // 100 : 12 = lMouxeX : lFollow
	lFollowY = (10 * lMouseY) / 100;
});
animtn5();

/*_______________________________________________________*/
//Custom
//block wheel or scroll of this div
$(".main_new_slier").on("mousewheel", function (e) {
	if (e.deltaY < 0) {
		e.preventDefault();
		e.stopPropagation();
		$(this).scrollLeft($(this).scrollLeft() + 100);
	} else {
		e.preventDefault();
		e.stopPropagation();
		$(this).scrollLeft($(this).scrollLeft() - 100);
	}
});

//allow scroll on .main_new_slier
/* $('.main_new_slier').on('mousewheel', function(e){
    if(e.deltaY < 0){
        e.stopPropagation();
    } else {
        e.stopPropagation();
    }
}); */
/* Slider 1 */
try {
	var track = document.getElementById("image-track");
	var singleCardImg = document.querySelector("#image-track > .custom-carousel-item > .image > img");
	var singleCardWidth = "";
	if (singleCardImg) {
		singleCardWidth = document.querySelector("#image-track > .custom-carousel-item > .image ").clientWidth;
	}

	var cardsCount = document.querySelectorAll("#image-track > .custom-carousel-item > .image ").length;
	var trackWidth = singleCardWidth * cardsCount;

	var handleOnDown = function (e) {
		track.dataset.mouseDownAt = e.clientX;
	};

	var handleOnUp = function () {
		track.dataset.mouseDownAt = "0";
		track.dataset.prevPercentage = track.dataset.percentage;
	};
	var handleMouseMove = function (e) {
		if (track.dataset.mouseDownAt === "0") return;

		var mouseDelta = parseFloat(track.dataset.mouseDownAt) - e.clientX,
			maxDelta = window.innerWidth / 2;

		var percentage = (mouseDelta / maxDelta) * -60,
			nextPercentageUnconstrained = parseFloat(track.dataset.prevPercentage) + percentage,
			nextPercentage = Math.max(Math.min(nextPercentageUnconstrained, 0), -60);

		track.dataset.percentage = nextPercentage;

		track.animate(
			{
				transform: "translate(" + nextPercentage + "%, -50%)",
			},
			{ duration: 1200, fill: "forwards" }
		);

		for (var image of track.getElementsByClassName("image")) {
			image.animate(
				{
					objectPosition: `${100 + nextPercentage}% center`,
				},
				{ duration: 1200, fill: "forwards" }
			);
		}
	};

	var handleMouseWheel = function (e) {
		var mouseDelta = e.deltaY,
			maxDelta = window.innerWidth / 2;

		var slideWidth = singleCardWidth ? singleCardWidth : 100;
		var slidesToMove = Math.floor(Math.abs(mouseDelta) / maxDelta);

		var percentage = (mouseDelta / maxDelta) * -60;
		var currentPercentage = parseFloat(track.dataset.percentage || 0);
		var nextPercentage = Math.min(Math.max(currentPercentage + percentage, -60), 0);

		track.dataset.percentage = nextPercentage;

		track.animate(
			{
				transform: "translate(" + nextPercentage + "%, -50%)",
			},
			{ duration: 1200, fill: "forwards" }
		);
		for (var image of track.getElementsByClassName("image")) {
			image.animate(
				{
					objectPosition: `${100 + nextPercentage}% center`,
				},
				{ duration: 1200, fill: "forwards" }
			);
		}

		handleOnUp();
	};

	var handleKeyMove = function (event) {
		var key = event.key;
		console.log("key", key);
		if (key === "ArrowLeft" || key === "ArrowRight") {
			var slideWidth = 10;
			var slidesToMove = key === "ArrowLeft" ? 1 : -1;

			var currentPercentage = parseFloat(track.dataset.percentage || 0);
			var nextPercentage = Math.min(Math.max(currentPercentage + slidesToMove * slideWidth, -60), 0);

			track.dataset.percentage = nextPercentage;
			console.log("currentPercentage", currentPercentage, "nextPercentage", nextPercentage);
			track.animate(
				{
					transform: "translate(" + nextPercentage + "%, -50%)",
				},
				{ duration: 1200, fill: "forwards" }
			);
			for (var image of track.getElementsByClassName("image")) {
				image.animate(
					{
						objectPosition: `${100 + nextPercentage}% center`,
					},
					{ duration: 1200, fill: "forwards" }
				);
			}

			event.preventDefault();
			handleOnUp();
		}
	};

	/* -- Had to add extra lines for touch events -- */
	track.onmousedown = function (e) {
		return handleOnDown(e);
	};

	track.ontouchstart = function (e) {
		return handleOnDown(e.touches[0]);
	};

	track.onmouseup = function (e) {
		return handleOnUp(e);
	};

	track.ontouchend = function (e) {
		return handleOnUp(e.touches[0]);
	};

	track.onmousemove = function (e) {
		return handleMouseMove(e);
	};

	track.ontouchmove = function (e) {
		return handleMouseMove(e.touches[0]);
	};

	document.addEventListener("keydown", handleKeyMove);
	track.addEventListener("wheel", handleMouseWheel);
	/* End Slider 1 */
} catch (e) {
	console.log("Error in slider 1");
}

/* Slider 2 */
try {
	var track2 = document.getElementById("image-track2");
	var singleCardWidth2 = document.querySelector("#image-track2 > .custom-carousel-item > .image ").clientWidth;
	var cardsCount2 = document.querySelectorAll("#image-track2 > .custom-carousel-item > .image ").length;
	var trackWidth2 = singleCardWidth2 * cardsCount2;

	var handleOnDown2 = function (e) {
		track2.dataset.mouseDownAt = e.clientX;
	};

	var handleOnUp2 = function () {
		track2.dataset.mouseDownAt = "0";
		track2.dataset.prevPercentage = track2.dataset.percentage;
	};
	var handleMouseMove2 = function (e) {
		if (track2.dataset.mouseDownAt === "0") return;

		var mouseDelta = parseFloat(track2.dataset.mouseDownAt) - e.clientX,
			maxDelta = window.innerWidth / 2;

		var percentage = (mouseDelta / maxDelta) * -60,
			nextPercentageUnconstrained = parseFloat(track2.dataset.prevPercentage) + percentage,
			nextPercentage = Math.max(Math.min(nextPercentageUnconstrained, 0), -60);

		track2.dataset.percentage = nextPercentage;

		track2.animate(
			{
				transform: "translate(" + nextPercentage + "%, -50%)",
			},
			{ duration: 1200, fill: "forwards" }
		);

		for (var image of track2.getElementsByClassName("image")) {
			image.animate(
				{
					objectPosition: `${100 + nextPercentage}% center`,
				},
				{ duration: 1200, fill: "forwards" }
			);
		}
	};

	var handleMouseWheel2 = function (e) {
		var mouseDelta = e.deltaY,
			maxDelta = window.innerWidth / 2;

		var slideWidth = singleCardWidth2 ? singleCardWidth2 : 100;
		var slidesToMove = Math.floor(Math.abs(mouseDelta) / maxDelta);

		var percentage = (mouseDelta / maxDelta) * -60;
		var currentPercentage = parseFloat(track2.dataset.percentage || 0);
		var nextPercentage = Math.min(Math.max(currentPercentage + percentage, -60), 0);

		track2.dataset.percentage = nextPercentage;

		track2.animate(
			{
				transform: "translate(" + nextPercentage + "%, -50%)",
			},
			{ duration: 1200, fill: "forwards" }
		);
		for (var image of track2.getElementsByClassName("image")) {
			image.animate(
				{
					objectPosition: `${100 + nextPercentage}% center`,
				},
				{ duration: 1200, fill: "forwards" }
			);
		}

		handleOnUp2();
	};

	var handleKeyMove2 = function (event) {
		var key = event.key;
		console.log("key", key);
		if (key === "ArrowLeft" || key === "ArrowRight") {
			var slideWidth = 10;
			var slidesToMove = key === "ArrowLeft" ? 1 : -1;

			var currentPercentage = parseFloat(track2.dataset.percentage || 0);
			var nextPercentage = Math.min(Math.max(currentPercentage + slidesToMove * slideWidth, -60), 0);

			track2.dataset.percentage = nextPercentage;
			console.log("currentPercentage", currentPercentage, "nextPercentage", nextPercentage);
			track2.animate(
				{
					transform: "translate(" + nextPercentage + "%, -50%)",
				},
				{ duration: 1200, fill: "forwards" }
			);
			for (var image of track2.getElementsByClassName("image")) {
				image.animate(
					{
						objectPosition: `${100 + nextPercentage}% center`,
					},
					{ duration: 1200, fill: "forwards" }
				);
			}

			event.preventDefault();
			handleOnUp2();
		}
	};

	/* -- Had to add extra lines for touch events -- */

	track2.onmousedown = function (e) {
		return handleOnDown2(e);
	};

	track2.ontouchstart = function (e) {
		return handleOnDown2(e.touches[0]);
	};

	track2.onmouseup = function (e) {
		return handleOnUp2(e);
	};

	track2.ontouchend = function (e) {
		return handleOnUp2(e.touches[0]);
	};

	track2.onmousemove = function (e) {
		return handleMouseMove2(e);
	};

	track2.ontouchmove = function (e) {
		return handleMouseMove2(e.touches[0]);
	};

	document.addEventListener("keydown", handleKeyMove2);
	track2.addEventListener("wheel", handleMouseWheel2);
} catch (e) {
	console.log("Error in slider 2");
}
/* End Slider 2 */

/* Slider 3 */
try {
	var track3 = document.getElementById("image-track3");
	var singleCardImg3 = document.querySelector("#image-track3 > .custom-carousel-item > .image > img");
	var singleCardWidth3 = "";
	if (singleCardImg3) {
		singleCardWidth3 = document.querySelector("#image-track3 > .custom-carousel-item > .image ").clientWidth;
	}

	var cardsCount3 = document.querySelectorAll("#image-track3 > .custom-carousel-item > .image ").length;
	var trackWidth3 = singleCardWidth3 * cardsCount3;

	var handleOnDown3 = function (e) {
		track3.dataset.mouseDownAt = e.clientX;
	};

	var handleOnUp3 = function () {
		track3.dataset.mouseDownAt = "0";
		track3.dataset.prevPercentage = track3.dataset.percentage;
	};
	var handleMouseMove3 = function (e) {
		if (track3.dataset.mouseDownAt === "0") return;

		var mouseDelta = parseFloat(track3.dataset.mouseDownAt) - e.clientX,
			maxDelta = window.innerWidth / 2;

		var percentage = (mouseDelta / maxDelta) * -60,
			nextPercentageUnconstrained = parseFloat(track3.dataset.prevPercentage) + percentage,
			nextPercentage = Math.max(Math.min(nextPercentageUnconstrained, 0), -60);

		track3.dataset.percentage = nextPercentage;

		track3.animate(
			{
				transform: "translate(" + nextPercentage + "%, -50%)",
			},
			{ duration: 1200, fill: "forwards" }
		);

		for (var image of track3.getElementsByClassName("image")) {
			image.animate(
				{
					objectPosition: `${100 + nextPercentage}% center`,
				},
				{ duration: 1200, fill: "forwards" }
			);
		}
	};

	var handleMouseWheel3 = function (e) {
		var mouseDelta = e.deltaY,
			maxDelta = window.innerWidth / 2;

		var slideWidth = singleCardWidth3 ? singleCardWidth3 : 100;
		var slidesToMove = Math.floor(Math.abs(mouseDelta) / maxDelta);

		var percentage = (mouseDelta / maxDelta) * -60;
		var currentPercentage = parseFloat(track3.dataset.percentage || 0);
		var nextPercentage = Math.min(Math.max(currentPercentage + percentage, -60), 0);

		track3.dataset.percentage = nextPercentage;

		track3.animate(
			{
				transform: "translate(" + nextPercentage + "%, -50%)",
			},
			{ duration: 1200, fill: "forwards" }
		);
		for (var image of track3.getElementsByClassName("image")) {
			image.animate(
				{
					objectPosition: `${100 + nextPercentage}% center`,
				},
				{ duration: 1200, fill: "forwards" }
			);
		}

		handleOnUp3();
	};

	var handleKeyMove3 = function (event) {
		var key = event.key;
		console.log("key", key);
		if (key === "ArrowLeft" || key === "ArrowRight") {
			var slideWidth = 10;
			var slidesToMove = key === "ArrowLeft" ? 1 : -1;

			var currentPercentage = parseFloat(track3.dataset.percentage || 0);
			var nextPercentage = Math.min(Math.max(currentPercentage + slidesToMove * slideWidth, -60), 0);

			track3.dataset.percentage = nextPercentage;
			console.log("currentPercentage", currentPercentage, "nextPercentage", nextPercentage);
			track3.animate(
				{
					transform: "translate(" + nextPercentage + "%, -50%)",
				},
				{ duration: 1200, fill: "forwards" }
			);
			for (var image of track3.getElementsByClassName("image")) {
				image.animate(
					{
						objectPosition: `${100 + nextPercentage}% center`,
					},
					{ duration: 1200, fill: "forwards" }
				);
			}

			event.preventDefault();
			handleOnUp3();
		}
	};

	/* -- Had to add extra lines for touch events -- */
	track3.onmousedown = function (e) {
		return handleOnDown3(e);
	};

	track3.ontouchstart = function (e) {
		return handleOnDown3(e.touches[0]);
	};

	track3.onmouseup = function (e) {
		return handleOnUp3(e);
	};

	track3.ontouchend = function (e) {
		return handleOnUp3(e.touches[0]);
	};

	track3.onmousemove = function (e) {
		return handleMouseMove3(e);
	};

	track3.ontouchmove = function (e) {
		return handleMouseMove3(e.touches[0]);
	};

	document.addEventListener("keydown", handleKeyMove3);
	track3.addEventListener("wheel", handleMouseWheel3);
} catch (e) {
	console.log("Error in slider 3");
}
/* End Slider 3 */

/* Slider 4 for about page*/

    try {
        
    // Check if the browser is Safari
    var isSafari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);
    
	var track4 = document.getElementById("image-track4");
	var singleCardImg4 = document.querySelector("#image-track4 > .custom-carousel-item > img.image ");
	var singleCardWidth4 = "";
	if (singleCardImg4) {
		singleCardWidth4 = document.querySelector("#image-track4 > .custom-carousel-item > .image ").clientWidth;
	}

	var cardsCount4 = document.querySelectorAll("#image-track4 > .custom-carousel-item > .image ").length;
	var trackWidth4 = singleCardWidth4 * cardsCount4;
	
	console.info("singleCardWidth4="+singleCardWidth4);
	console.info("cardsCount4="+cardsCount4);
	console.info("trackWidth4="+trackWidth4);

	var handleOnDown4 = function (e) {
		track4.dataset.mouseDownAt = e.clientX;
	};

	var handleOnUp4 = function () {
		track4.dataset.mouseDownAt = "0";
		track4.dataset.prevPercentage = track4.dataset.percentage;
	};
	var handleMouseMove4 = function (e) {
		if (track4.dataset.mouseDownAt === "0") return;

		var mouseDelta = parseFloat(track4.dataset.mouseDownAt) - e.clientX,
			maxDelta = window.innerWidth / 2;

		var percentage = (mouseDelta / maxDelta) * -60,
			nextPercentageUnconstrained = parseFloat(track4.dataset.prevPercentage) + percentage,
			nextPercentage = Math.max(Math.min(nextPercentageUnconstrained, 0), -60);

		track4.dataset.percentage = nextPercentage;

		track4.animate(
			{
				transform: "translate(" + nextPercentage + "%, -50%)",
			},
			{ duration: 1200, fill: "forwards" }
		);

		for (var image of track4.getElementsByClassName("image")) {
			image.animate(
				{
					objectPosition: `${100 + nextPercentage}% center`,
				},
				{ duration: 1200, fill: "forwards" }
			);
		}
	};

	var handleMouseWheel4 = function (e) {
		var mouseDelta = e.deltaY,
			maxDelta = window.innerWidth / 2;

		var slideWidth = singleCardWidth4 ? singleCardWidth4 : 100;
		var slidesToMove = Math.floor(Math.abs(mouseDelta) / maxDelta);

		var percentage = (mouseDelta / maxDelta) * -60;
		var currentPercentage = parseFloat(track4.dataset.percentage || 0);
		var nextPercentage = Math.min(Math.max(currentPercentage + percentage, -60), 0);

		track4.dataset.percentage = nextPercentage;

		track4.animate(
			{
				transform: "translate(" + nextPercentage + "%, -50%)",
			},
			{ duration: 1200, fill: "forwards" }
		);
		for (var image of track4.getElementsByClassName("image")) {
			image.animate(
				{
					objectPosition: `${100 + nextPercentage}% center`,
				},
				{ duration: 1200, fill: "forwards" }
			);
		}

		handleOnUp4();
	};

	var handleKeyMove4 = function (event) {
		var key = event.key;
		console.log("key", key);
		if (key === "ArrowLeft" || key === "ArrowRight") {
			var slideWidth = 10;
			var slidesToMove = key === "ArrowLeft" ? 1 : -1;

			var currentPercentage = parseFloat(track4.dataset.percentage || 0);
			var nextPercentage = Math.min(Math.max(currentPercentage + slidesToMove * slideWidth, -60), 0);

			track4.dataset.percentage = nextPercentage;
			console.log("currentPercentage", currentPercentage, "nextPercentage", nextPercentage);
			track4.animate(
				{
					transform: "translate(" + nextPercentage + "%, -50%)",
				},
				{ duration: 1200, fill: "forwards" }
			);
			for (var image of track4.getElementsByClassName("image")) {
				image.animate(
					{
						objectPosition: `${100 + nextPercentage}% center`,
					},
					{ duration: 1200, fill: "forwards" }
				);
			}

			event.preventDefault();
			handleOnUp4();
		}
	};

	/* -- Had to add extra lines for touch events -- */
	track4.onmousedown = function (e) {
		return handleOnDown4(e);
	};

	track4.ontouchstart = function (e) {
		return handleOnDown4(e.touches[0]);
	};

	track4.onmouseup = function (e) {
		return handleOnUp4(e);
	};

	track4.ontouchend = function (e) {
		return handleOnUp4(e.touches[0]);
	};

	track4.onmousemove = function (e) {
		return handleMouseMove4(e);
	};

	track4.ontouchmove = function (e) {
		return handleMouseMove4(e.touches[0]);
	};

	document.addEventListener("keydown", handleKeyMove4);
	track4.addEventListener("wheel", handleMouseWheel4);
	
	// Additional code to apply specific behavior between 768px and 992px
    var screenWidth = window.innerWidth;
    if (screenWidth >= 768 && screenWidth <= 992) {
        // Additional code to increase track4 width by 3 slide widths for non-Safari browsers only
        if (!isSafari) {
            var extraWidth = singleCardWidth4 * 4;
            track4.style.width = (trackWidth4 + extraWidth) + 'px';
            // alert("chrome extraWidth"+extraWidth)
        }
    }
} catch (e) {
	console.log("Error in slider 4");
}

/* End Slider 4 for about page*/
/* About Us Page Team Profile */

$(function (e) {
	$(".prof_layer").on("click", function (e) {
		//get details from current element attributes
		console.info($(this).attr("data-name"));
		var name = "";
		var bigImg = "";
		var title = "";
		var description = "";

		if ($(this).attr("data-name") != "") {
			name = $(this).attr("data-name");
		}

		if ($(this).attr("data-big-image") != "") {
			bigImg = $(this).attr("data-big-image");
		}

		if ($(this).attr("data-title") != "") {
			title = $(this).attr("data-title");
		}

		if ($(this).attr("data-description") != "") {
			description = $(this).attr("data-description");
		}

		// assign all values to respective overlay body elements
		$(".overlay-body").find(".layer_image").attr("src", bigImg);
		$(".overlay-body").find(".layer_name").text(name);
		$(".overlay-body").find(".layer_title").text(title);
		$(".overlay-body").find(".layer_description").html(description);

		setTimeout(function () {
			$(".overlay-team").addClass("active");
			$(".dark_ver_2").css("display", "none");
			$(".dark_ver_1_2").css("display", "block");

			//find image selector
			var secondImage = $(".overlay-body").find(".left-image")[0];
			console.log(secondImage);

			var windowWidth = window.innerWidth,
				windowHeight = window.innerHeight;
			var secondImageWidth = secondImage.offsetWidth,
				secondImageHeight = secondImage.offsetHeight;
			var clickX = e.clientX,
				clickY = e.clientY;
			var originX = clickX - windowWidth / 2 + secondImageWidth / 2,
				originY = clickY - windowHeight / 2 + secondImageHeight / 2;
			secondImage.style.transformOrigin = [clickX, "px", " ", clickY, "px"].join("");

			if (secondImage.classList.contains("active")) {
				secondImage.classList.remove("active");
			} else {
				secondImage.classList.add("active");
			}
		}, 1000);
	});

	$(".item-overlay").on("click", function (e) {
		$(".dark_ver_1_2").css("display", "block");
	});

	$(".a_cross_ancr").click(function (e) {
		// e.preventDefault();
		setTimeout(function () {
			$(".overlay-team").removeClass("active");
			$(".dark_ver_2").css("display", "block");
			$(".dark_ver_1_2").css("display", "none");
		}, 200); // Delay of 3 seconds
	});
});
/* End About Us Page Team Profile */

/* function refreshImg0() {
	var image = document.getElementById("yourImageId0");
	var windowWidth = window.innerWidth;
	var imageWidth = image.offsetWidth;

	image.style.width = "240px";
	image.style.position = "absolute";
	image.style.marginTop = "-32px";
	image.style.left = (windowWidth - imageWidth) / 2 + "px";
}

function refreshImg() {
	var image = document.getElementById("yourImageId");
	var windowWidth = window.innerWidth;
	var imageWidth = image.offsetWidth;

	image.style.width = '24px';
	image.style.height = '24px';
	image.style.position = "absolute";
	// image.style.transition = "all 200ms linear";
	image.style.left = (windowWidth - imageWidth) / 2 + "px";
}

addEventListener("resize", refreshImg0);
addEventListener("resize", refreshImg);
 */
