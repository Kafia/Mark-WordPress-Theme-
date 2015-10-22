/* ========================== */
/* ==== HELPER FUNCTIONS ==== */


isIE = false;


jQuery.fn.isAfter = function (sel) {
	return this.prevAll(sel).length !== 0;
}
jQuery.fn.isBefore = function (sel) {
	return this.nextAll(sel).length !== 0;
}


function validatedata(jQueryattr, jQuerydefaultValue) {
	if (jQueryattr !== undefined) {
		return jQueryattr
	}
	return jQuerydefaultValue;
}

function parseBoolean(str, jQuerydefaultValue) {
	if (str == 'true') {
		return true;
	}
	return jQuerydefaultValue;
	//return /true/i.test(str);
}

/* ============================================= */
/* ==== GOOGLE MAP - Asynchronous Loading  ==== */

function initmap() {
	"use strict";
	jQuery(".googleMap").each(function () {
		var atcenter = "";
		var jQuerythis = jQuery(this);
		var location = jQuerythis.data("location");
		var zoommap = jQuerythis.data("zoom");
		
		var offset = -30;

		if (validatedata(jQuerythis.data("offset"))) {
			offset = jQuerythis.data("offset");
		}

		if (validatedata(location)) {

			jQuerythis.gmap3({
				marker: {
					//latLng: [40.616439, -74.035540],
					address: location,
					options: {
						visible: false
					},
					callback: function (marker) {
						atcenter = marker.getPosition();
					}
				},
				map: {
					options: {
						//maxZoom:11,
						zoom: zoommap,
						mapTypeId: google.maps.MapTypeId.SATELLITE,
						// ('ROADMAP', 'SATELLITE', 'HYBRID','TERRAIN');
						scrollwheel: false,
						disableDoubleClickZoom: false,
						//disableDefaultUI: true,
						mapTypeControlOptions: {
							//mapTypeIds: [google.maps.MapTypeId.ROADMAP, google.maps.MapTypeId.HYBRID],
							//style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
							//position: google.maps.ControlPosition.RIGHT_CENTER
							mapTypeIds: []
						}
					},
					events: {
						idle: function () {
							if (!jQuerythis.data('idle')) {
								jQuerythis.gmap3('get').panBy(0, offset);
								jQuerythis.data('idle', true);
							}
						}
					}
				},
				overlay: {
					//latLng: [40.616439, -74.035540],
					address: location,
					options: {
						content: '<div class="customMarker"><span class="fa fa-map-marker"></span><i></i></div>',
						offset: {
							y: -70,
							x: -25
						}
					}
				}
				//},"autofit"
			});

			// center on resize
			google.maps.event.addDomListener(window, "resize", function () {
				//var userLocation = new google.maps.LatLng(53.8018,-1.553);
				setTimeout(function () {
					jQuerythis.gmap3('get').setCenter(atcenter);
					jQuerythis.gmap3('get').panBy(0, offset);
				}, 400);

			});

			// set height
			jQuerythis.css("min-height", jQuerythis.data("height") + "px");
		}

	})
}

function loadScript() {
	"use strict";
	var script = document.createElement('script');
	script.type = 'text/javascript';
	script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&' + 'callback=initmap';
	document.body.appendChild(script);
}


if (jQuery(".googleMap").length > 0) {
	window.onload = loadScript;
}


jQuery(document).ready(function () {
	"use strict";
	jQuery = jQuery.noConflict();


	/* ===================== */
	/* ==== TIMELINE JS ==== */

	if (jQuery("#timeline-embed").length > 0) {

		createStoryJS({
			width: '100%',
			height: '600',
			source: 'js/timeline/source/timeline.json',
			embed_id: 'timeline-embed',               //OPTIONAL USE A DIFFERENT DIV ID FOR EMBED
			start_at_end: false,                          //OPTIONAL START AT LATEST DATE
			start_at_slide: '2',                            //OPTIONAL START AT SPECIFIC SLIDE
			start_zoom_adjust: '2',                            //OPTIONAL TWEAK THE DEFAULT ZOOM LEVEL
			hash_bookmark: false,                           //OPTIONAL LOCATION BAR HASHES
			debug: false,                           //OPTIONAL DEBUG TO CONSOLE
			lang: 'en',                           //OPTIONAL LANGUAGE
			maptype: 'HYBRID',                   //OPTIONAL MAP STYLE
			css: 'js/timeline/css/timeline.css',     //OPTIONAL PATH TO CSS
			js: 'js/timeline/js/timeline-min.js'    //OPTIONAL PATH TO JS
		});
	}


	/* ============================= */
	/* ==== SET ELEMENTS HEIGHT ==== */
	// flexslider
	jQuery('.flexslider.std-slider').each(function () {
		var jQuerythis = jQuery(this);
		jQuerythis.css('min-height', jQuerythis.attr('data-height') + "px");
	})

	// spacer element
	jQuery('.spacer').each(function () {
		var jQuerythis = jQuery(this);
		jQuerythis.css('height', jQuerythis.attr('data-height') + "px");
	})

	/* ================================== */
	/* ==== SET PADDING FOR SECTIONS ==== */

	jQuery(".content-area, .parallaxSection").each(function () {
		var jQuerythis = jQuery(this);
		var bottomSpace = jQuerythis.attr("data-btmspace");
		var topSpace = jQuerythis.attr("data-topspace");
		var bg = jQuerythis.attr("data-bg");

		if (validatedata(bottomSpace, false)) {
			jQuerythis.css("padding-bottom", bottomSpace + "px");
		}
		if (validatedata(topSpace, false)) {
			jQuerythis.css("padding-top", topSpace + "px");
		}
		if (validatedata(bg, false)) {
			jQuerythis.css('background-image', 'url("' + bg + '")');
		}
	})


	if (jQuery(".parallaxSection.height100").length > 0) {

		jQuery(".parallaxSection.height100").each(function () {

			var jQuerythis = jQuery(this);
			jQuery("#boxedWrapper, body").css("height", "100%");

			var menuHeight = 0;
			if (jQuerythis.isAfter(".navbar-default")) {
				menuHeight = jQuery(".navbar-default").outerHeight();
			}
			if (jQuery(".navbar-default").hasClass("navbar-fixed-top")) {
				menuHeight = 0;
			}


			var sliderHeight = jQuerythis.outerHeight() - menuHeight;
			var jQueryslider = jQuerythis.find(".flexslider");

			jQuery(jQuerythis, jQueryslider).css("height", sliderHeight);

		})
	}


	/* ========================= */
	/* ==== CLICKABLE TABLE ==== */

	jQuery('.table-responsive tr').click(function () {
		var jQuerythis = jQuery(this);
		if (jQuerythis.attr('data-link') !== undefined) {
			window.location = jQuerythis.attr('data-link');
		}
	});

	/* ========================== */
	/* ==== SCROLL TO ANCHOR ==== */

	jQuery('a.local[href*=#]:not([href=#])').click(function () {
		if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
			var target = jQuery(this.hash);
			target = target.length ? target : jQuery('[name=' + this.hash.slice(1) + ']');

			var menuOffset = 0;
			if (jQuery(this).hasClass("menuOffset")) {
				if (!(jQuery.browser.mobile)) {
					menuOffset = parseInt(jQuery('.navbar-default').height());
				} else {

				}
			}

			if (target.length) {
				jQuery('html,body').animate({
					scrollTop: target.offset().top - menuOffset
				}, 1000, 'swing');
				return false;
			}
		}
	});


	/* ================== */
	/* ==== COUNT TO ==== */

	if ((jQuery().appear) && (jQuery(".timerCounter").length > 0)) {
		jQuery('.timerCounter').appear(function () {
			jQuery('.timerVal').each(function () {
				jQuery(this).countTo();
			})
		})
	}

	/* =============================== */
	/* ==== PLACEHOLDERS FALLBACK ==== */

	if (jQuery().placeholder) {
		jQuery("input[placeholder],textarea[placeholder]").placeholder();
	}

	/* ======================================= */
	/* === CLICKABLE MAIN PARENT ITEM MENU === */
	jQuery(".navbar-default li.dropdown > .dropdown-toggle").removeAttr("data-toggle data-target");


	/* ======================== */
	/* ==== ANIMATION INIT ==== */

	if (jQuery().appear) {

		if (jQuery.browser.mobile) {
			// disable animation on mobile
			jQuery("body").removeClass("withAnimation");
		} else {

			jQuery('.withAnimation .animated').appear(function () {
				var jQuerythis = jQuery(this);
				jQuerythis.each(function () {
					jQuerythis.addClass('activate');
					jQuerythis.addClass(jQuerythis.data('fx'));
				});
			}, {accX: 50, accY: -150});

		}
	}

	/* ======================== */
	/* === VIDEO BACKGROUND === */

	// helper function

	jQuery.fn.isOnScreen = function () {
		var win = jQuery(window);
		var viewport = {
			top: win.scrollTop(),
			left: win.scrollLeft()
		};
		viewport.right = viewport.left + win.width();
		viewport.bottom = viewport.top + win.height();
		var bounds = this.offset();
		bounds.right = bounds.left + this.outerWidth();
		bounds.bottom = bounds.top + this.outerHeight();
		return (!(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom));
	};

	if ((jQuery().mb_YTPlayer) && (jQuery(".videoSection").length > 0)) {
		if (jQuery.browser.mobile) {
			// disable on mobile
			jQuery(".videoSection").hide();
			jQuery("#ct_preloader").fadeOut(600);

		} else {
			jQuery(".videoSection").mb_YTPlayer();
			jQuery('.videoSection').on("YTPStart", function () {
				setTimeout(function () {
					jQuery("#ct_preloader").fadeOut(300);
					jQuery(".videoSection").find(".flexslider").fadeIn(1000);
				}, 1050);
			})
			// if wait long - hide preloader
			setTimeout(function () {
				jQuery("#ct_preloader").fadeOut(300);
			}, 9000);

			// chrome parallax section fix
			if (jQuery('.videoSection.parallaxEffect').isOnScreen()) {
				jQuery('.videoSection.parallaxEffect .innerVideo').css("position", "fixed");
			} else {
				jQuery('.videoSection.parallaxEffect .innerVideo').css("position", "absolute");
			}
			jQuery(window).on('scroll', function () {
				if (jQuery('.videoSection.parallaxEffect').isOnScreen()) {
					jQuery('.videoSection.parallaxEffect .innerVideo').css("position", "fixed");
				} else {
					jQuery('.videoSection.parallaxEffect .innerVideo').css("position", "absolute");
				}
			});

			jQuery('.videoSection.parallaxEffect').each(function () {
				var jQuerythis = jQuery(this);
				jQuerythis.siblings(":not([data-bg], .navbar-default)").css({
					"position": "relative",
					"z-index": "1"
				})

			})

		}
	}

	/* ======================= */
	/* ==== TOOLTIPS INIT ==== */

	jQuery("[data-toggle='tooltip']").tooltip();


	/* ======================= */
	/* ==== TO TOP BUTTON ==== */


	jQuery('#toTop').click(function () {
		jQuery("body,html").animate({scrollTop: 0}, 600);
		return false;
	});

	jQuery(window).scroll(function () {
		if (jQuery(this).scrollTop() != 0) {
			jQuery("#toTop").fadeIn(300);
		} else {
			jQuery("#toTop").fadeOut(250);
		}
	});


	/* ======================== */
	/* ==== MAGNIFIC POPUP ==== */

	if (jQuery().magnificPopup) {

		jQuery(".popup-iframe").magnificPopup({
			disableOn: 700,
			type: 'iframe',
			mainClass: 'mfp-fade',
			removalDelay: 160,
			preloader: false,
			fixedContentPos: false
		});

		jQuery('.imgpopup').magnificPopup({
			type: 'image',
			closeOnContentClick: true,
			closeBtnInside: false,
			fixedContentPos: false,
			mainClass: 'mfp-fade', // class to remove default margin from left and right side
			image: {
				verticalFit: true
			}
		});
	}

	/* ========================= */
	/* ==== LOAD SVG IMAGES ==== */

	if (jQuery(".octagon").length > 0) {
		jQuery(".octagon .svg-load").load("images/octagon1.svg");
	}

	/* ============================ */
	/* ==== SHOW HEADER SEARCH ==== */

	jQuery("#showHeaderSearch").click(function () {
		var jQuerythis = jQuery(this);
		var jQuerysearchform = jQuerythis.parent().find(".header-search");
		jQuerysearchform.fadeToggle(250, function () {

			if ((jQuerysearchform).is(":visible")) {
				jQuerythis.find(".fa-search").removeClass("fa-search").addClass("fa-times");

				if (!isIE) {
					jQuerysearchform.find("[type=text]").focus();
				}
			} else {
				jQuerythis.find(".fa-times").removeClass("fa-times").addClass("fa-search");
			}
		});

		return false;
	})

	/* =========================== */
	/* ==== SHOW MAP ON CLICK ==== */

	jQuery(".showMap").click(function () {
		var jQuerythis = jQuery(this);
		var jQueryparent = jQuerythis.closest(".content-layer");
		var jQueryform = jQueryparent.find(".placeOver");

		jQueryparent.find(".bg-layer, .placeOver").fadeToggle(250, function () {
			if ((jQueryform).is(":visible")) {
				jQuerythis.text(jQuerythis.attr("data-old"));
			} else {
				jQuerythis.attr("data-old", jQuerythis.text());
				jQuerythis.text(jQuerythis.attr("data-text"));
			}
		});

		return false;
	})

	/* ==================================== */
	/* ==== FITVIDS - responsive video ==== */

	if ((jQuery().fitVids) && (jQuery(".responsiveVideo").length > 0)) {
		jQuery(".responsiveVideo").fitVids();
	}


	/* ==================== */
	/* === PROGRESS BAR === */

	if ((jQuery().appear) && (jQuery(".progress").length > 0)) {
		jQuery('.progress').appear(function () {
			var jQuerythis = jQuery(this);
			jQuerythis.each(function () {
				var jQueryinnerbar = jQuerythis.find(".progress-bar");
				var percentage = jQueryinnerbar.attr("data-percentage");

				jQueryinnerbar.addClass("animating").css("width", percentage + "%");

				jQueryinnerbar.on('transitionend webkitTransitionEnd oTransitionEnd otransitionend MSTransitionEnd', function () {
					jQuerythis.find(".pro-level").fadeIn(600);
				});

			});
		}, {accY: -100});
	}

	/* ================== */
	/* ==== ISOTOPE ==== */

	if ((jQuery.Isotope) && (jQuery('#blog-list.withMasonry').length > 0)) {

		jQuery(window).load(function () {

			// blog masonry

			var jQueryblogContainer = jQuery('#blog-list.withMasonry'), // object that will keep track of options
							isotopeOptions = {}, // defaults, used if not explicitly set in hash
							defaultOptions = {
								itemSelector: '.blog-item',
								layoutMode: 'sloppyMasonry',
								resizable: false, // disable normal resizing
								// set columnWidth to a percentage of container width
								masonry: { }
							};


			jQuery(window).smartresize(function () {
				jQueryblogContainer.isotope({
					// update columnWidth to a percentage of container width
					masonry: { }
				});
			});

			// set up Isotope
			jQueryblogContainer.isotope(defaultOptions, function () {

				// fix for height dynamic content
				setTimeout(function () {
					jQueryblogContainer.isotope('reLayout');
				}, 1000);

			});
		});
	}


	if ((jQuery.Isotope) && (jQuery('#galleryContainer').length > 0)) {
		// gallery isotope

		jQuery(window).load(function () {

			var jQuerycontainer = jQuery('#galleryContainer'), // object that will keep track of options
							isotopeOptions = {}, // defaults, used if not explicitly set in hash
							defaultOptions = {
								filter: '*',
								itemSelector: '.galleryItem',
								sortBy: 'original-order',
								layoutMode: 'sloppyMasonry',
								sortAscending: true,
								resizable: false, // disable normal resizing
								// set columnWidth to a percentage of container width
								masonry: { }
							};


			jQuery(window).smartresize(function () {
				jQuerycontainer.isotope({
					// update columnWidth to a percentage of container width
					masonry: { }
				});
			});

			// set up Isotope
			jQuerycontainer.isotope(defaultOptions);

			var jQueryoptionSets = jQuery('#galleryFilters'), isOptionLinkClicked = false;

			// switches selected class on buttons
			function changeSelectedLink(jQueryelem) {
				// remove selected class on previous item
				jQueryelem.parents('.option-set').find('.btn-primary').removeClass('btn-primary');
				// set selected class on new item
				jQueryelem.addClass('btn-primary');
			}


			jQueryoptionSets.find('a').click(function () {
				var jQuerythis = jQuery(this);
				// don't proceed if already selected
				if (jQuerythis.hasClass('btn-primary')) {
					return;
				}
				changeSelectedLink(jQuerythis);
				// get href attr, remove leading #
				var href = jQuerythis.attr('href').replace(/^#/, ''), // convert href into object
				// i.e. 'filter=.inner-transition' -> { filter: '.inner-transition' }
								option = jQuery.deparam(href, true);
				// apply new option to previous
				jQuery.extend(isotopeOptions, option);
				// set hash, triggers hashchange on window
				jQuery.bbq.pushState(isotopeOptions);
				isOptionLinkClicked = true;
				return false;
			});


			var hashChanged = false;

			jQuery(window).bind('hashchange', function (event) {
				// get options object from hash
				var hashOptions = window.location.hash ? jQuery.deparam.fragment(window.location.hash, true) : {}, // do not animate first call
								aniEngine = hashChanged ? 'best-available' : 'none', // apply defaults where no option was specified
								options = jQuery.extend({}, defaultOptions, hashOptions, { animationEngine: aniEngine });
				// apply options from hash
				jQuerycontainer.isotope(options);
				// save options
				isotopeOptions = hashOptions;

				// if option link was not clicked
				// then we'll need to update selected links
				if (!isOptionLinkClicked) {
					// iterate over options
					var hrefObj, hrefValue, jQueryselectedLink;
					for (var key in options) {
						hrefObj = {};
						hrefObj[ key ] = options[ key ];
						// convert object into parameter string
						// i.e. { filter: '.inner-transition' } -> 'filter=.inner-transition'
						hrefValue = jQuery.param(hrefObj);
						// get matching link
						jQueryselectedLink = jQueryoptionSets.find('a[href="#' + hrefValue + '"]');
						changeSelectedLink(jQueryselectedLink);
					}
				}

				isOptionLinkClicked = false;
				hashChanged = true;
			})// trigger hashchange to capture any hash data on init
							.trigger('hashchange');

		});
	}


	jQuery(window).load(function () {


		/* ==================== */
		/* ==== FLEXSLIDER ==== */

		if ((jQuery().flexslider) && (jQuery(".flexslider").length > 0)) {

			jQuery('.flexslider.std-slider').each(function () {
				var jQuerythis = jQuery(this);

				// initialize
				jQuerythis.find(".slides > li").each(function () {
					var jQueryslide_item = jQuery(this);
					var bg = validatedata(jQueryslide_item.attr('data-bg'), false);
					if (bg) {
						jQueryslide_item.css('background-image', 'url("' + bg + '")');
					}
					jQueryslide_item.css('min-height', jQuerythis.attr('data-height') + "px");

					// hide slider content due to fade animation
					jQueryslide_item.find(".inner").hide();

					jQueryslide_item.find(".inner [data-fx]").each(function () {
						jQuery(this).removeClass("animated");
					})
				})

				var loop = validatedata(parseBoolean(jQuerythis.attr("data-loop")), false);
				var smooth = validatedata(parseBoolean(jQuerythis.attr("data-smooth")), false);
				var slideshow = validatedata(parseBoolean(jQuerythis.attr("data-slideshow")), false);
				var speed = validatedata(parseInt(jQuerythis.attr('data-speed')), 7000);
				var animspeed = validatedata(parseInt(jQuerythis.attr("data-animspeed")), 600);
				//var itemwidth = validatedata(parseInt(jQuerythis.attr("data-itemwidth")), 870);
				var controls = validatedata(parseBoolean(jQuerythis.attr('data-controls')), false);
				var dircontrols = validatedata(parseBoolean(jQuerythis.attr('data-dircontrols')), false);
				var animation = jQuerythis.attr('data-animation');

				jQuerythis.flexslider({
					animation: animation,              //String: Select your animation type, "fade" or "slide"
					animationLoop: loop,             //Boolean: Should the animation loop? If false, directionNav will received "disable" classes at either end
					smoothHeight: smooth,            //{NEW} Boolean: Allow height of the slider to animate smoothly in horizontal mode
					slideshow: slideshow,                //Boolean: Animate slider automatically
					slideshowSpeed: speed,           //Integer: Set the speed of the slideshow cycling, in milliseconds
					animationSpeed: animspeed,            //Integer: Set the speed of animations, in milliseconds
					itemWidth: '100%',
					// Primary Controls
					controlNav: controls,               //Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
					directionNav: dircontrols,             //Boolean: Create navigation for previous/next navigation? (true/false)

					pauseOnHover: true,            //Boolean: Pause the slideshow when hovering over slider, then resume when no longer hovering
					prevText: " ",           //String: Set the text for the "previous" directionNav item
					nextText: " ",
					useCSS: false,

					// Callback API
					start: function () {
						setTimeout(function () {
							jQuerythis.find(".slides > li.flex-active-slide .inner").each(function () {
								var jQuerycontent = jQuery(this);
								if (!isIE) {
									jQuerycontent.closest(".inner").show();
								} else {
									jQuerycontent.closest(".inner").fadeIn(300);
								}
							});
							jQuerythis.find(".slides > li.flex-active-slide .inner [data-fx]").each(function () {
								var jQuerycontent = jQuery(this);
								jQuerycontent.addClass(jQuerycontent.data('fx')).show().addClass("animated activate");
							})
						}, 600);

					},
					before: function () {

						jQuerythis.find(".slides > li.flex-active-slide .inner [data-fx]").each(function () {
							var jQuerycontent = jQuery(this);
							jQuerycontent.closest(".inner").fadeOut(400);
							jQuerycontent.removeClass(jQuerycontent.data('fx')).removeClass("animated activate");
						})
					},           //Callback: function(slider) - Fires asynchronously with each slider animation
					after: function () {
						setTimeout(function () {
							jQuerythis.find(".slides > li.flex-active-slide .inner").each(function () {
								var jQuerycontent = jQuery(this);
								if (!isIE) {
									jQuerycontent.closest(".inner").show();
								} else {
									jQuerycontent.closest(".inner").fadeIn(300);
								}
							});
							jQuerythis.find(".slides > li.flex-active-slide .inner [data-fx]").each(function () {
								var jQuerycontent = jQuery(this);
								jQuerycontent.addClass(jQuerycontent.data('fx')).show().addClass("animated activate");
							})
						}, 150);
					},            //Callback: function(slider) - Fires after each slider animation completes
					end: function () {
					},              //Callback: function(slider) - Fires when the slider reaches the last slide (asynchronous)
					added: function () {
					},            //{NEW} Callback: function(slider) - Fires after a slide is added
					removed: function () {
					}           //{NEW} Callback: function(slider) - Fires after a slide is removed
				});
			});

			jQuery('.flexslider.carousel-slider').each(function () {
				var jQuerythis = jQuery(this);

				var slideshow = validatedata(parseBoolean(jQuerythis.attr("data-slideshow")), false);
				var speed = validatedata(parseInt(jQuerythis.attr('data-speed')), 7000);
				var animspeed = validatedata(parseInt(jQuerythis.attr("data-animspeed")), 600);
				var loop = validatedata(parseBoolean(jQuerythis.attr("data-loop")), false);
				var min = validatedata(parseInt(jQuerythis.attr('data-min')), 1);
				var max = validatedata(parseInt(jQuerythis.attr("data-max")), 3);
				var move = validatedata(parseInt(jQuerythis.attr("data-move")), 0);
				var controls = validatedata(parseBoolean(jQuerythis.attr('data-controls')), false);
				var dircontrols = validatedata(parseBoolean(jQuerythis.attr('data-dircontrols')), false);

				jQuerythis.flexslider({
					animation: "slide",
					slideshow: slideshow,
					slideshowSpeed: speed,
					animationSpeed: animspeed,
					animationLoop: loop,
					itemWidth: 370,
					itemMargin: 30,
					minItems: min,
					maxItems: max,
					move: move,
					controlNav: controls,
					directionNav: dircontrols
				});
			});
		}


		/* =========================== */
		/* === BIG ARROW ANIMATION === */

		function animateArrow() {

			setTimeout(function () {
				jQuery(".bigArrow i").css('opacity', 1).stop(true, true).animate({ opacity: 0, top: "15px" }, { queue: false, duration: 350, complete: function () {

					jQuery(".bigArrow i").css("top", "-15px").stop(true, true).delay(200).animate({ opacity: 1, top: 0 }, { queue: false, duration: 450, complete: function () {
						animateArrow();
					}})
				}})
			}, 1800);
		}

		animateArrow();

	});
	/* / window load */

	/* =================== */
	/* ==== ONE PAGER ==== */


	var jQuerylogoimage = '';
	var oldsrc = '';

	function swapMenu(mode) {

		if (mode == "init") {
			jQuerylogoimage = jQuery(".navbar-brand img");
			oldsrc = jQuerylogoimage.attr('src');
		}

		if ((mode == "standardMenu")&&(!(jQuery.browser.mobile))) {
			jQueryonepagerNav.removeClass("navbar-transparent");
			if (!(jQuerylogoimage.hasClass("swaped"))) {

				jQuerylogoimage.fadeOut(50, function () {
					jQuerylogoimage.attr('src', jQuerylogoimage.parent().attr("data-logo"));
					jQuerylogoimage.fadeIn(50).addClass("swaped");
				});
			}
		}
		if ((mode == "fixedMenu")&&(!(jQuery.browser.mobile))) {
			jQueryonepagerNav.addClass("navbar-transparent");
			jQuerylogoimage.attr('src', oldsrc);
			jQuerylogoimage.removeClass("swaped");
		}
	}


	var onepagerNavClass = "navbar-fixed-top";
	var jQueryonepagerNav = jQuery("."+onepagerNavClass);

	if ((jQueryonepagerNav.length > 0)) {

		var scrollOffset = 0;

		if (!(jQuery.browser.mobile)) {

		} else {
			jQuery(".navbar-fixed-top").removeClass(onepagerNavClass).removeClass("navbar-transparent").addClass("navbar-static-top");
			jQuerylogoimage = jQuery(".navbar-brand img");
			jQuerylogoimage.fadeOut(50, function () {
				jQuerylogoimage.attr('src', jQuerylogoimage.parent().attr("data-logo"));
				jQuerylogoimage.fadeIn(50).addClass("swaped");
			});

			scrollOffset = parseInt(jQuery('.navbar-default').height());
		}

		jQuery('.nav.navbar-nav li a').click(function () {
			// if mobile and menu open - hide it after click
			var jQuerytogglebtn = jQuery(".navbar-toggle")

			if (!(jQuerytogglebtn.hasClass("collapsed")) && (jQuerytogglebtn.is(":visible"))) {
				jQuery(".navbar-toggle").trigger("click");
			}

			var jQuerythis = jQuery(this);

			var content = jQuerythis.attr('href');

			var myUrl = content.match(/^#([^\/]+)jQuery/i);

			if (jQuery(content).length > 0) {
				if (myUrl) {

					var goPosition = jQuery(content).offset().top + scrollOffset - parseInt(jQuery('.navbar-default').height());

					jQuery('html,body').stop().animate({ scrollTop: goPosition}, 1000, 'easeInOutExpo', function () {
						jQuerythis.closest("li").addClass("active");
					});


				} else {
					window.location = content;
				}

				return false;
			}
		});


		jQuery(window).on('scroll', function () {

			var menuEl, mainMenu = jQueryonepagerNav, mainMenuHeight = mainMenu.outerHeight() + 5;
			var menuElements = mainMenu.find('a');

			var scrollElements = menuElements.map(function () {

				var content = jQuery(this).attr("href");
				var myUrl = content.match(/^#([^\/]+)jQuery/i);

				if (myUrl) {

					var item = jQuery(jQuery(this).attr("href"));
					if (item.length) {
						return item;
					}

				}
			});

			var fromTop = jQuery(window).scrollTop() + mainMenuHeight;

			var currentEl = scrollElements.map(function () {
				if (jQuery(this).offset().top < fromTop) {
					return this;
				}
			});

			currentEl = currentEl[currentEl.length - 1];
			var id = currentEl && currentEl.length ? currentEl[0].id : "";
			if (menuEl !== id) {
				menuElements.parent().removeClass("active").end().filter("[href=#" + id + "]").parent().addClass("active");
			}

			var scroll = jQuery(window).scrollTop();
			if (scroll > 0) {
				swapMenu("standardMenu");
			} else {
				swapMenu("fixedMenu");
			}

		});


		swapMenu("init");
		var scroll = jQuery(window).scrollTop();
		if (scroll > 0) {
			swapMenu("standardMenu");
		}
	}


	/* ================================ */
	/* === AJAX PORTFOLIO ONE PAGER === */

	jQuery("body").on("click", ".getAjaxItem", function () {
		var jQuerythis = jQuery(this);
		var jQuerygalDetails = jQuery("#galleryAjaxDetails");

		if (jQuerygalDetails.length <= 0) {
			return true;
		}

		var url = jQuerythis.attr("href") + " #ajaxContent";

		if ((jQuerygalDetails).is(":visible")) {
			jQuerygalDetails.animate({opacity: 0}, 400, function () {
				jQuerygalDetails.load(url, function () {


					jQuerygalDetails.delay(300).animate({opacity: 1}, 400, function () {
						jQuery('html,body').animate({
							scrollTop: jQuerygalDetails.offset().top - parseInt(jQuery('.navbar-fixed-top').height())
						}, 600, 'swing');
					});
				});
			});
		} else {
			jQuerygalDetails.slideUp(300, function () {
				jQuerygalDetails.load(url, function () {
					jQuerygalDetails.delay(300).slideDown(700, function () {
						jQuery('html,body').animate({
							scrollTop: jQuerygalDetails.offset().top - parseInt(jQuery('.navbar-fixed-top').height())
						}, 600, 'swing');
					});
				});
			});
		}

		return false;
	})

	jQuery("body").on("click", ".closeAjaxPortfolio", function () {
		var jQuerygalDetails = jQuery("#galleryAjaxDetails");
		jQuerygalDetails.slideUp(300, function () {
			jQuery('html,body').animate({
				scrollTop: jQuery("#portfolio").offset().top - parseInt(jQuery('.navbar-fixed-top').height())
			}, 600, 'swing');
		});
		return false;
	});


	jQuery(document).ajaxStart(function () {
		jQuery("#ct_preloader").addClass("ajax-inprogress").show();

	});

	jQuery(document).ajaxStop(function () {
		setTimeout(function () {
			jQuery("#ct_preloader").removeClass("ajax-inprogress").hide();
		}, 300);

		// init js after ajax stop
		jQuery("#galleryAjaxDetails .content-area").each(function () {
			var jQuerythis = jQuery(this);
			var bottomSpace = jQuerythis.attr("data-btmspace");
			var topSpace = jQuerythis.attr("data-topspace");

			if (validatedata(bottomSpace, false)) {
				jQuerythis.css("padding-bottom", bottomSpace + "px");
			}
			if (validatedata(topSpace, false)) {
				jQuerythis.css("padding-top", topSpace + "px");
			}
		})
		jQuery("[data-toggle='tooltip']").tooltip();

	});



});
/* / document ready */

