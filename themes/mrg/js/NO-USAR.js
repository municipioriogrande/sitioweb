var locationMap;
var homeMap;
var mapIcon = "http://www.hotel-icon.com/public/themes/hotelicon/css/themes/map-marker.png";

function initializeHomeMap(){
	try {
		var latlng = new google.maps.LatLng(22.300832, 114.179739);
		var latlngBounds = new google.maps.LatLngBounds();

		var myOptions = {
			zoom: 18,
			center: latlng,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			scrollwheel: false,
			styles: [{"featureType":"landscape","stylers":[{"saturation":-100},{"lightness":65},{"visibility":"on"}]},{"featureType":"poi","stylers":[{"saturation":-100},{"lightness":51},{"visibility":"simplified"}]},{"featureType":"road.highway","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"road.arterial","stylers":[{"saturation":-100},{"lightness":30},{"visibility":"on"}]},{"featureType":"road.local","stylers":[{"saturation":-100},{"lightness":40},{"visibility":"on"}]},{"featureType":"transit","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"administrative.province","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":-25},{"saturation":-100}]},{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#ffff00"},{"lightness":-25},{"saturation":-97}]}]
		};
		homeMap = new google.maps.Map(document.getElementById("home-map"), myOptions);

		if (isMobileDevice()){
			latlng = new google.maps.LatLng(22.300832, 114.179739); 
			homeMap.setZoom(17);
			homeMap.setCenter(latlng);
		}
		
		// hotelicon marker
		var hoteliconPnt = new google.maps.LatLng(22.300832, 114.179739);
		var hoteliconMarker = new google.maps.Marker({
			position: hoteliconPnt,
			map: homeMap
		});
	}
	catch (e) {  }
}
function initializeMap(){
	try {
		var latlng = new google.maps.LatLng(22.300832, 114.179739);
		var latlngBounds = new google.maps.LatLngBounds();

		var myOptions = {
			zoom: 16,
			center: latlng,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			scrollwheel: false,
			styles: [{"featureType":"landscape","stylers":[{"saturation":-100},{"lightness":65},{"visibility":"on"}]},{"featureType":"poi","stylers":[{"saturation":-100},{"lightness":51},{"visibility":"simplified"}]},{"featureType":"road.highway","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"road.arterial","stylers":[{"saturation":-100},{"lightness":30},{"visibility":"on"}]},{"featureType":"road.local","stylers":[{"saturation":-100},{"lightness":40},{"visibility":"on"}]},{"featureType":"transit","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"administrative.province","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":-25},{"saturation":-100}]},{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#ffff00"},{"lightness":-25},{"saturation":-97}]}]
		};
		locationMap = new google.maps.Map(document.getElementById("location-map"), myOptions);

		if (isMobileDevice()){
			latlng = new google.maps.LatLng(22.300832, 114.179739); 
			locationMap.setZoom(17);
			locationMap.setCenter(latlng);
		}
		if ($('body.location').length) {
			locationMap.setZoom(14);
		}
		// hotelicon marker
		var hoteliconPnt = new google.maps.LatLng(22.300832, 114.179739);
		var hoteliconMarker = new google.maps.Marker({
			position: hoteliconPnt,
			map: locationMap
		});
	}
	catch (e) {  }
}

function resizeMap() {
	try {
		if ($('#home-map').length) {
			latlng = new google.maps.LatLng(22.300832, 114.179739); 
			homeMap.setCenter(latlng);
		}
		
		if ($('#location-map').length) {
			latlng = new google.maps.LatLng(22.300832, 114.179739); 
			locationMap.setCenter(latlng);
		}
	} catch (e) {
		
	}
}
$(window).load(function() {
	positionInstagram();
	initializeHomeMap();
	initializeMap();
	initSlugShare();
	positionHomeFacility();
	positionTransportation();
	positionHighlight();
	positionRoomList();
	positionRoomInfoList();
	positionRoomMayLike();
	positionFacilityList();
	positionFacilityInfoList();
	positionEventList();
	positionEventInfoList();
	positionAboutInfoList();
	positionDineList();
	positionDineInfoList();
	positionDineMayLike();
	positionMayLike();
	initBookingLayout();
	
	positionAwardList();
	positionPressList();
	// positionHomeRoom();
	positionOfferList();
	positionOfferMayLike();
	
	positionArticleList();
	positionArticleMayLike();
	
	setContactFormDefaultValue();
	setAttractionEffect();
	
	
	$('#mask').bind('click', function() {
	});
	
	$('#mobile-menu a.slicknav_btn').bind('click', function() {
		if ($('.slicknav_nav').is(":visible")) {
			$('#mobile-close').show();
			$('#mask').show();
			$('body').addClass('modal');
			$(document).bind( 'touchmove', touchScroll );
		} else {
			$('#mobile-close').hide();
			$('#mask').hide();
			$('body').removeClass('modal');
			$( document ).unbind( 'touchmove', touchScroll );
		}
	});
	$('#mobile-close').bind('click', function() {
		$('#mobile-menu a.slicknav_btn').click();
		$(this).hide();
		$('#mask').hide();
		$('body').removeClass('modal');
		$( document ).unbind( 'touchmove', touchScroll );
	});
	
	// ## booking form
	$('#header-holder #right-sect a.book-online').bind('click', function() {
		if (!isMobileMode()) {
			$(this).toggle("slide", { direction: "right" }, 300);
		}
		setTimeout(function(){ 
			$("#booking-wrapper").toggle("slide", { direction: "right" }, 500);
		}, 300);
		
		if (isMobileMode()) {
			$('#mask').show();
			$('body').addClass('modal');
			$(document).bind( 'touchmove', touchScroll );
		}
		return false;
	});
	$('#booking-wrapper #close-btn').bind('click', function() {
		$("#booking-wrapper").toggle("slide", { direction: "right" }, 500);
		if (!isMobileMode()) {
			setTimeout(function(){ 
				$('#header-holder #right-sect a.book-online').toggle("slide", { direction: "right" }, 300);
			}, 500);
		}
		
		if (isMobileMode()) {
			$('#mask').hide();
			$('body').removeClass('modal');
			$( document ).unbind( 'touchmove', touchScroll );
		}
	});
	
	// ## footer map
	$('#f-sect1 #menu-left a.location').bind('click', function() {
		$("#map-wrapper").animate({'margin-bottom':'0px'},1000);
		$('#scroll-up').fadeIn();
		
		return false;
	});
	$("#map-wrapper a.close").bind('click', function() {
		if (isMobileMode()){ 
			$("#map-wrapper").animate({'margin-bottom':'-350px'},1000);
		} else {
			$("#map-wrapper").animate({'margin-bottom':'-620px'},1000);
		}
		$('#scroll-up').fadeOut();
		return false;
	});
	
	$('#mobile-attraction-category p.selected-item').bind('click', function() {
		$("#mobile-attraction-category ul").toggle("slide", { direction: "up"} , 1000);
	});
	$('#mobile-article-category p.selected-item').bind('click', function() {
		$("#mobile-article-category ul").toggle("slide", { direction: "up"} , 1000);
	});
	$('#mobile-offer-category p.selected-item').bind('click', function() {
		$("#mobile-offer-category ul").toggle("slide", { direction: "up"} , 1000);
	});
	$('#mobile-location-category p.selected-item').bind('click', function() {
		$("#mobile-location-category ul").toggle("slide", { direction: "up"} , 1000);
	});
	$('#mobile-award-category p.selected-item').bind('click', function() {
		$("#mobile-award-category ul").toggle("slide", { direction: "up"} , 1000);
	});
	$('#mobile-press-category p.selected-item').bind('click', function() {
		$("#mobile-press-category ul").toggle("slide", { direction: "up"} , 1000);
	});
	
	$('#mobile-menu .slicknav_item').bind('click', function() {
		var link = $(this).parent();
		if ($(link).hasClass('slicknav_collapsed')) { // collapsed
			$(link).find('a.slicknav_item span').addClass('expanded');
		} else { // expanded
			$(link).find('a.slicknav_item span').removeClass('expanded');
		}
	});

	$('#scroll-down a').bind('click', function() {
		target = $('#wapper');
		$('html,body').animate({
			scrollTop: (target.offset().top - $('#header-holder').height())
        }, 500);
		return false;
	});
	$('#scroll-down-2 a').bind('click', function() {
		target = $('#h-attractions');
		$('html,body').animate({
			scrollTop: (target.offset().top - 50)
        }, 500);
		return false;
	});
	$('#scroll-down-3 a').bind('click', function() {
		target = $('.our-location');
		$('html,body').animate({
			scrollTop: (target.offset().top - 81)
        }, 500);
		return false;
	});
	$('#scroll-up a').bind('click', function() {
		target = $('#h-facility');
		$('html,body').animate({
			scrollTop: (target.offset().top - 80)
        }, 500);
		return false;
	});
	$('#scroll-up2 a').bind('click', function() {
		var height = '1800'; 

		$('#menu').removeClass('expand');
		$("#submenu").animate({'margin-top':'-'+height+'px'},1000);
		$('#scroll-up2').fadeOut();
		$('#mask').hide();
		$('body').removeClass('modal');
		
		return false;
	});
	
	$('#tbNewsletterform #checkall').change(function() {
		if(this.checked) {
			$('#pf_Demographicfield19').prop('checked', true);
			$('#pf_Demographicfield18').prop('checked', true);
			$('#pf_Demographicfield24').prop('checked', true);
			$('#pf_Demographicfield10').prop('checked', true);
			$('#pf_Demographicfield23').prop('checked', true);
			$('#pf_Demographicfield22').prop('checked', true);
		}
	});

	
	if ($('#menulist').length){
		$('#menulist > li').last().attr('class', 'last');
	}

});

function triggerNewsletterPopup(){
	if(window.location.hash){
		if(window.location.hash=='#newsletter'){
			$('.open-newsletter-popup').click();
		}
	}
}

var touchScroll = function( event ) {
    event.preventDefault();
};
function scrollDiscover(){
	target = $('#wapper');
	$('html,body').animate({
		scrollTop: (target.offset().top - $('#header-holder').height())
	}, 500);
	return false;
}
function openSubMenu() {
	if (isMobileMode()) {
		return true;
	} else {
		$('#mask').show();
		$('body').addClass('modal');
		$('#menu').addClass('expand');
		$("#submenu").animate({'margin-top':'0px'},1000);
		$('#scroll-up2').fadeIn();
		
		return false;
	}
}
$(window).scroll(function(){
	if ($(window).scrollTop() == 0) {
		$('#scroll-down').fadeIn();
	} else {
		$('#scroll-down').fadeOut();
	}
	
	if ($(window).scrollTop() >= 80) {
		$('#header-holder').addClass('whitebg');
	} else {
		$('#header-holder').removeClass('whitebg');
	}
	
	if ($('#h-attractions').length) {
		var target = $('#h-attractions');
		var offset = Math.floor(target.offset().top - 50);
		if ($(window).scrollTop() >= offset) {
			$('#scroll-down-2').fadeOut();
		} else {
			$('#scroll-down-2').fadeIn();
		}
	}
	
	if ($(window).width() < $('body').width()) {
		$('#header-holder').css({
			'left': '-'+$(this).scrollLeft() //Use it later
		});	
	}
	
	if ($('#banner-zone').length) {
		var scrollTop = $(window).scrollTop();
		var bannerHeight = $('#banner-contant').height();
		
		if (scrollTop < bannerHeight) {
			$('#banner-zone').css('top', -(scrollTop/5));
		}
	}
});
$( window ).resize(function() {
	resizeMap();
	positionInstagram();
	positionHomeAttraction();
	positionTransportation();
	positionHomeFacility();
	resizeHomeFacility();
	resizeHighlights();
	positionHighlight();
	positionRoomList();
	positionRoomInfoList();
	positionRoomMayLike();
	resizeRoomMayLike();
	positionFacilityList();
	positionFacilityInfoList();
	positionDineList();
	positionDineInfoList();
	positionDineMayLike();
	positionMayLike();
	initBannerNav();
	initBookingLayout();
	positionAwardList();
	positionPressList();
	
	positionEventList();
	positionEventInfoList();
	
	positionAboutInfoList();
	
	// positionHomeRoom();
	positionOfferList();
	positionOfferMayLike();
	
	positionArticleList();
	positionArticleMayLike();
	resizeArticleMayLike();
	
	setAttractionEffect();
	
	if ($("#map-wrapper").css('margin-bottom') != '0px') {
		if (isMobileMode()){ 
			$("#map-wrapper").css('margin-bottom', '-350px');
		} else {
			$("#map-wrapper").css('margin-bottom', '-620px');
		}
	}
	
	if (!isMobileMode()){
		if ($('body').hasClass('modal')) { // mobile menu is open
			$('#mobile-close').click();
			$('#mobile-close').hide();
		}
	}
});

$(document).ready(function() {
	initBookingForm();
	
	//Instagram Feed
	if ($('#instafeed').length) {
		var feed = new Instafeed({
			get: 'user',
			userId: '42999910',
			accessToken: '42999910.1677ed0.1b3f86ef429c4436b3f61fc9840ab8e4',
			sortBy: 'most-recent',
			limit : 4,
			resolution: 'standard_resolution',
			template: '<div class="instagram-container"><a class="instagram-{{orientation}}" href="{{link}}" target="_blank" title="{{model.user.full_name}}" ><img src="{{image}}" class="instagram-pic" /></a></div>'
		}); 
		feed.run();
	}

	$('#submenu div.lvl2 a').each(function(e) {
		if ($(this).hasClass('open-third')) {
			$(this).bind('mouseover', function(e) {
				$('#submenu div.lvl2 a').removeClass('active');
				$(this).addClass('active');
				
				var id = $(this).attr('data-id');
				$('#submenu div.lvl2 div.lvl3').hide();
				$('#submenu div.lvl2').find('#'+id).show();
			});
		}
	});
	
	if (isMobileMode()){
		if ($('#highlights').length) {
			$('#highlights div.items').slick({
				draggable: false,
				slidesToShow: 1,
				slidesToScroll: 1,
				adaptiveHeight: false,
				focusOnSelect: true,
				arrows: true
			});
		}
	} else {
		if ($('#highlights').length) {
			$('#highlights div.items').slick({
				draggable: false,
				slidesToShow: 3,
				slidesToScroll: 1,
				adaptiveHeight: false,
				focusOnSelect: true,
				arrows: true
			});
		}
	}
	
	if ($('#h-attractions').length){
		$('#h-attractions .a-cat').each(function() {
			if ($(this).find('div.attraction').length > 1) {
				$(this).slick({
					draggable: false,
					slidesToShow: 1,
					slidesToScroll: 1,
					adaptiveHeight: false,
					focusOnSelect: true
				});
			} 
		});
		
		$('#h-attractions .attraction .images').each(function() {
			$(this).slick({
				draggable: false,
				slidesToShow: 1,
				slidesToScroll: 1,
				adaptiveHeight: false,
				focusOnSelect: true,
				dots: true,
				autoplay: true,
				arrows: false
			});
		});
		
		positionHomeAttraction();
		setTimeout(function(){ 
			filter_attraction('views');
		}, 1500);
	}
	
	if ($('#room-maylike .items').length) {
		if (isMobileMode()){
			$('#room-maylike .items').slick({
				draggable: false,
				slidesToShow: 1,
				slidesToScroll: 1,
				adaptiveHeight: false,
				focusOnSelect: true,
				dots: true,
				autoplay: true,
				arrows: false
			});
		} else {
			$('#room-maylike .items').slick({
				draggable: false,
				slidesToShow: 3,
				slidesToScroll: 1,
				adaptiveHeight: false,
				focusOnSelect: true,
				dots: false,
				autoplay: false,
				arrows: false
			});
		}
	}
	
	if ($('#article-maylike .items').length) {
		if (isMobileMode()){
			$('#article-maylike .items').slick({
				draggable: false,
				slidesToShow: 1,
				slidesToScroll: 1,
				adaptiveHeight: false,
				focusOnSelect: true,
				dots: true,
				autoplay: true,
				arrows: false
			});
		} else {
			$('#article-maylike .items').slick({
				draggable: false,
				slidesToShow: 3,
				slidesToScroll: 1,
				adaptiveHeight: false,
				focusOnSelect: true,
				dots: false,
				autoplay: false,
				arrows: false
			});
		}
	}
	
	if ($('#h-facility').length){
		if (isMobileMode()){
			$('#h-facility .facilityTitle').slick({
				asNavFor: '#h-facility .nav',
				draggable: false,
				centerMode: true,
				slidesToShow: 1,
				slidesToScroll: 1,
				centerPadding: '0px',
				adaptiveHeight: false,
				focusOnSelect: true
			}).on('beforeChange', function(event, slick, currentSlide, nextSlide) {
				hidevideo();
			});
		} else {
			$('#h-facility .facilityTitle').slick({
				asNavFor: '#h-facility .nav',
				draggable: false,
				centerMode: true,
				slidesToShow: 3,
				slidesToScroll: 1,
				centerPadding: '0px',
				adaptiveHeight: false,
				focusOnSelect: true
			}).on('beforeChange', function(event, slick, currentSlide, nextSlide) {
				if (currentSlide != nextSlide) {
					hidevideo();
				}
			});
		}
		$('#h-facility .facilityImages').slick({
			asNavFor: '#h-facility .facilityTitle',
			draggable: false,
			slidesToShow: 1,
			slidesToScroll: 1,
			swipe: false,
			adaptiveHeight: false,
			focusOnSelect: true,
			arrows: false
		});
		
		$('#h-facility .facilityContent > div').slick({
			asNavFor: '#h-facility .facilityTitle',
			draggable: false,
			slidesToShow: 1,
			slidesToScroll: 1,
			swipe: false,
			adaptiveHeight: false,
			focusOnSelect: true,
			arrows: false
		});
	}
	
	if ($('#room-detail').length) {
		$('#room-detail .lr-layout-item .infoImages').each(function() {
			$(this).slick({
				draggable: false,
				slidesToShow: 1,
				slidesToScroll: 1,
				adaptiveHeight: false,
				focusOnSelect: true,
				dots: true,
				autoplay: true,
				arrows: false
			});
		});
		$('#room-detail .highlight > div.roomtype').slick({
			draggable: false,
			slidesToShow: 1,
			slidesToScroll: 1,
			adaptiveHeight: false,
			focusOnSelect: true,
			arrows: true
		});
		/*
		$('#room-detail .highlight > div.content').each(function() {
			$(this).slick({
				draggable: false,
				slidesToShow: 1,
				slidesToScroll: 1,
				adaptiveHeight: false,
				focusOnSelect: true,
				arrows: true
			});
		}); */
	}
	
	if ($('#dine-detail').length) {
		$('#dine-detail .lr-layout-item .infoImages').each(function() {
			$(this).slick({
				draggable: false,
				slidesToShow: 1,
				slidesToScroll: 1,
				adaptiveHeight: false,
				focusOnSelect: true,
				dots: true,
				autoplay: true,
				arrows: false
			});
		});
		$('#dine-detail .highlight > div.dinetype').slick({
			draggable: false,
			slidesToShow: 1,
			slidesToScroll: 1,
			adaptiveHeight: false,
			focusOnSelect: true,
			arrows: true
		});
	}
	
	if ($('#facility-detail').length) {
		$('#facility-detail .lr-layout-item .infoImages').each(function() {
			$(this).slick({
				draggable: false,
				slidesToShow: 1,
				slidesToScroll: 1,
				adaptiveHeight: false,
				focusOnSelect: true,
				dots: true,
				autoplay: true,
				arrows: false
			});
		});
	}
	
	if ($('#offer-detail').length) {
		$('#offer-detail .lr-layout-item .infoImages').each(function() {
			$(this).slick({
				draggable: false,
				slidesToShow: 1,
				slidesToScroll: 1,
				adaptiveHeight: false,
				focusOnSelect: true,
				dots: true,
				arrows: false
			});
		});
	}
	
	if ($('#event-detail').length) {
		$('#event-detail .lr-layout-item .infoImages').each(function() {
			$(this).slick({
				draggable: false,
				slidesToShow: 1,
				slidesToScroll: 1,
				adaptiveHeight: false,
				focusOnSelect: true,
				dots: true,
				autoplay: true,
				arrows: false
			});
		});
	}
	
	if ($('#about-detail').length) {
		$('#about-detail .lr-layout-item .infoImages').each(function() {
			$(this).slick({
				draggable: false,
				slidesToShow: 1,
				slidesToScroll: 1,
				adaptiveHeight: false,
				focusOnSelect: true,
				dots: true,
				autoplay: true,
				arrows: false
			});
		});
	}
	
	if ($('.open-popup-link').length) {
		initPopUp();
	}
	
	if ($('.open-newsletter-popup').length) {
		initNewsletterForm();
	}
    
	filter_transportation('from_airport');
	
	setTimeout(function() {
		positionInstagram();
	}, 1000);

	triggerNewsletterPopup();
});

function resizeRoomMayLike() {
	if (isMobileMode()){
		$('#room-maylike .items').slick('slickSetOption', 'slidesToShow', 1, true);
		$('#room-maylike .items').slick('slickSetOption', 'dots', true, true);
		$('#room-maylike .items').slick('slickSetOption', 'autoplay', true, true);
	} else {
		$('#room-maylike .items').slick('slickSetOption', 'slidesToShow', 3, true);
		$('#room-maylike .items').slick('slickSetOption', 'dots', false, true);
		$('#room-maylike .items').slick('slickSetOption', 'autoplay', false, true);
	}
}
function resizeArticleMayLike() {
	if (isMobileMode()){
		$('#article-maylike .items').slick('slickSetOption', 'slidesToShow', 1, true);
		$('#article-maylike .items').slick('slickSetOption', 'dots', true, true);
		$('#article-maylike .items').slick('slickSetOption', 'autoplay', true, true);
	} else {
		$('#article-maylike .items').slick('slickSetOption', 'slidesToShow', 3, true);
		$('#article-maylike .items').slick('slickSetOption', 'dots', false, true);
		$('#article-maylike .items').slick('slickSetOption', 'autoplay', false, true);
	}
}
function initPopUp() {
	$('.open-popup-link').magnificPopup({
	  type:'inline',
	  closeBtnInside: true,
	  midClick: true, // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
	  fixedBgPos: true
	});
}
function initNewsletterForm() {
	$('.open-newsletter-popup').click(function(){
		if ($('#newsletter #EMAIL').val() == '') {
			$('#newsletter span.msg').text('Please fill in your email address');
			return false;
		} else {
			$('form.newsform #email').val($('#newsletter #EMAIL').val());
		}
	});
	$('.open-newsletter-popup').magnificPopup({
	  type:'inline',
	  closeBtnInside: true,
	  midClick: true, // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
	  fixedBgPos: true
	});
	
	if ($('#newsletter-popup').length) {
		$("#newsletter-popup input#dob").datepicker({
			dateFormat: "dd, M, yy"
		});
	}
}

function showbannervideo(videourl) {
	var videoid = videourl.split('v=')[1];
	var youtubelink = videourl.replace('watch?v=', 'embed/')+'?enablejsapi=1&showinfo=0&autoplay=1&loop=1&playlist='+videoid+'&controls=0&rel=0&wmode=opague&html5=1';
	
	$('#banner-contant #youtubevideo iframe.video').attr('src',youtubelink);
	$('#banner-contant #youtubevideo').show();

	return false;
}
function playbannervideo(){
	$('.nivo-caption').find('.video a').click();
	
	// if mobile
	if ($('body.inner .nivo-html-caption.mobile').length) {
		var nextSlide = $('#slider').data('nivo:vars').currentImage.attr('title');
		$(nextSlide+'.nivo-html-caption.mobile').fadeIn('fast');
	}
}
function hidebannervideo(){ 
	// call before slide change
	$('#banner-contant #youtubevideo iframe.video').attr('src','');
	$('#banner-contant #youtubevideo').hide();
	
	// if mobile
	if ($('body.inner .nivo-html-caption.mobile').length) {
		$('body.inner .nivo-html-caption.mobile').fadeOut();
	}
}
function showsubbannervideo(videourl) {
	var videoid = videourl.split('v=')[1];
	var youtubelink = videourl.replace('watch?v=', 'embed/')+'?enablejsapi=1&showinfo=0&autoplay=1&loop=1&playlist='+videoid+'&controls=0&rel=0&wmode=opague&html5=1';
	
	$('#subbanner #youtubevideo iframe.video').attr('src',youtubelink);
	$('#subbanner #youtubevideo').show();

	return false;
}
function showvideo(videourl) {
    //$('#h-facility iframe.video').hide();
	var videoid = videourl.split('v=')[1];
	var youtubelink = videourl.replace('watch?v=', 'embed/')+'?enablejsapi=1&showinfo=0&autoplay=1&loop=1&playlist='+videoid+'&controls=0&rel=0&wmode=opague&html5=1';
	
	$('#h-facility #youtubevideo iframe.video').attr('src',youtubelink);
	$('#h-facility #youtubevideo').show();

	return false;
}
function hidevideo(){ 
	$('#h-facility #youtubevideo iframe.video').attr('src','');
	$('#h-facility #youtubevideo').hide();
}
function resizeHighlights(){
	if (isMobileMode()){
		$('#highlights div.items').slick('slickSetOption', 'slidesToShow', 1, true);
	} else {
		$('#highlights div.items').slick('slickSetOption', 'slidesToShow', 3, true);
	}
}
function positionHighlight(){ // *pending
	var ratio = 301 / 424; // height/width
	if ($('#highlights div.item').length) {
		var width = $('#highlights div.item.idx1').innerWidth();
		var height = width * ratio;
		$('#highlights div.item div.img').css('height', height);
	}
	if (isMobileMode()) {
		if ($('#highlights .slick-prev').length) {
			var bottom = $('#highlights .info').outerHeight();
			$('#highlights .slick-prev').css('bottom', bottom / 2);
			$('#highlights .slick-next').css('bottom', bottom / 2);
		}
	}
}

function positionInstagram() {
	$('#instafeed .instagram-container').each(function(){
		$(this).css('height', $(this).width());
	});
}
function initSlugShare(){
	var obj = $('#slugbar .sharethis');
	var hover = $(obj).find('.hover');
	var icon = $(obj).find('.icon');
	$(obj).hover(function() {
		$(icon).hide();
		$(hover).show();
	}, function() {
		$(icon).show();
		$(hover).hide();
	});
}
		
function initBannerNav(){
	if ($('.nivoSlider')[0]){
		var marginBottom = 28; // half height of "down" icon
		var screenHeight = $(window).height() - marginBottom;

		//var top = (bannerHeight - 50) / 2;
		var isIE8 = $('html.ie8').length;
		if ($('body').hasClass('inner')) {
			// innerpage
			if (!isMobileMode()) {
				var ratio = 570 / 1270;
				var bannerWidth = $('#slider').css('width', 'auto').outerWidth(true);
				var bannerHeight = ratio * bannerWidth;
				
				$('#banner-contant').css('height', bannerHeight);
				$('#banner-contant').css('min-height', bannerHeight);
				$('#wapper').css('margin-top', bannerHeight);
				$('#banner-contant').css('margin-bottom', '');
					
				$('.nivo-caption').css('top', (bannerHeight / 2) - ($('.nivo-caption').outerHeight() / 2));
				$('#banner-contant #youtubevideo').css('height', bannerHeight);
			
			} else {
				var captionHeight = $('body.inner .nivo-html-caption.mobile').css('height', 'auto').outerHeight();
				var navHeight = 0;
				if ($('body.inner .nivo-controlNav').length) {
					navHeight = $('body.inner .nivo-controlNav').css('height', 'auto').outerHeight();
					$('body.inner .nivo-controlNav').css('bottom', '-'+navHeight+'px');
					
					if ($('body.inner .nivo-html-caption.mobile').length) {
						navHeight = navHeight - 20;
					}
					$('body.inner .nivo-html-caption.mobile').css('margin-top', navHeight);
				}
				screenHeight = screenHeight + marginBottom; 
				var bannerHeight = screenHeight - captionHeight - navHeight; 
				
				$('#banner-contant').css('height', bannerHeight);
				$('#banner-contant').css('min-height', bannerHeight);
				
				$('#wapper').css('margin-top', bannerHeight);
				$('#banner-contant').css('margin-bottom', captionHeight + navHeight);
				
				$('.nivo-caption').css('top', (bannerHeight / 2) - ($('.nivo-caption').outerHeight() / 2));
				//$('#banner-contant #youtubevideo').css('height', screenHeight);
				
				$('#banner-contant #youtubevideo').css('height', bannerHeight);
				
				// show caption
				if ($('body.inner .nivo-html-caption.mobile').length) {
					var nextSlide = $('#slider').data('nivo:vars').currentImage.attr('title');
					$(nextSlide+'.nivo-html-caption.mobile').fadeIn('fast');
				}
			}
			
			// video ratio, width and height setting
			ratio = 360 / 640; // height / width
			width = $('#banner-contant #youtubevideo').width();
			height = ratio * width;
			$('#banner-contant #youtubevideo iframe.video').css('height', height);
			$('#banner-contant #youtubevideo iframe.video').css('margin-top', -(height/2));	
			
			if ($('.nivo-caption').find('.video').length) {
				$('.nivo-caption').find('.video a').click();
			}
		} else {
			if (isMobileMode()) {
				screenHeight = screenHeight * 0.9;
			}
			
			$('#banner-contant').css('height', screenHeight);
			$('#banner-contant').css('min-height', screenHeight);
			$('#wapper').css('margin-top', screenHeight);
			
			$('.nivo-caption').css('top', (screenHeight / 2) - ($('.nivo-caption').outerHeight() / 2));
			
			if ($(window).scrollTop() == 0) {
				$('#scroll-down').show();			
			}
		}
		
		// subbanner video ratio, width and height setting
		if ($('#subbanner #youtubevideo').length) {
			$('#subbanner #youtubevideo').css('height', $('#subbanner').height());
			ratio = 360 / 640; // height / width
			width = $('#subbanner #youtubevideo').width();
			height = ratio * width;
			$('#subbanner #youtubevideo iframe.video').css('height', height);
			$('#subbanner #youtubevideo iframe.video').css('margin-top', -(height/2));	
			
		}
		if ($('#subbanner').length) {
			$('#subbanner .caption').css('margin-top', -($('#subbanner .caption').height()/2));
			// $('#subbanner .video').css('margin-top', -($('#subbanner .video').height()/2));
		}
	}
}

function initBookingLayout(){
	var height;		
	var screenHeight = $(window).height();
	var screenWidth = $(window).width();
	
	if (isTabletMode() || screenHeight > screenWidth){ 
		height = screenHeight - 90;
		width = screenWidth - 80;
		$('#booking-wrapper').css('height', height);
		$('#booking-wrapper').css('width', width);
	} else {
		var padding = $('#booking-wrapper').innerHeight() - $('#booking-wrapper').height();
		
		$('#booking-wrapper').css('height', screenHeight - padding);
		$('#booking-wrapper').css('width', '');
	}
	
	if (isTabletMode() || screenHeight > screenWidth || isMobileMode()){
		$('#booking-wrapper').addClass('fullwidth');
	}
}
function daysBetween( date1, date2 ) {
	//Get 1 day in milliseconds
	var one_day=1000*60*60*24;

	// Convert both dates to milliseconds
	var date1_ms = date1.getTime();
	var date2_ms = date2.getTime();

	// Calculate the difference in milliseconds
	var difference_ms = date2_ms - date1_ms;

	// Convert back to days and return
	return Math.round(difference_ms/one_day); 
}
function initBookingForm(){
	//Check in Check out date
	var todayDate = new Date();
	$("#booking-wrapper input#checkin").datepicker({
        dateFormat: "DD, MM dd, yy",
        minDate: todayDate,
		onSelect: function(dateText, inst) {
			//To reset checkout date if select lower checkin date
			var minDate = new Date(Date.parse(dateText));
			$('#booking-form input#arrival_date').val($.datepicker.formatDate('mm/dd/yy',minDate));
			
			minDate.setDate(minDate.getDate() + 1);
			$('#booking-wrapper input#checkout').val($.datepicker.formatDate('DD, MM dd, yy',minDate));
		}
    }).datepicker("setDate", todayDate);
	
	$("#booking-wrapper input#checkout").datepicker({
        dateFormat: "DD, MM dd, yy",
        minDate: "+1D",
		onSelect: function(dateText, inst) {
			//To reset checkout date if select lower checkin date
			var departDate = new Date(Date.parse(dateText));
			$('#booking-form input#departure_date').val($.datepicker.formatDate('mm/dd/yy',departDate));
		}
    }).datepicker("setDate", todayDate);
	
	if ($('.book-the-room').length) {
		$(".book-the-room .arrival").on("mouseover", function() {
			$(this).find('.ui-datepicker').css('visibility','visible').show(10);
			$(this).datepicker({
				dateFormat: "dd, M, yy",
				minDate: todayDate,
				onSelect: function(dateText, inst) {
					var selDate = new Date(dateText);
					$('.book-the-room input#checkin2').val($.datepicker.formatDate('dd, M, yy',selDate));
					
					//To reset checkout date if select lower checkin date
					var minDate = new Date(Date.parse(dateText));
					$('.book-the-room input#arrival_date2').val($.datepicker.formatDate('mm/dd/yy',minDate));
					
					var checkIn = $('#checkin2').val();
					var checkOut = $('#checkout2').val();
					var checkInDate = new Date(checkIn);
					var checkOutDate = new Date(checkOut);
					
					minDate.setDate(minDate.getDate() + 1);
					if(daysBetween(checkInDate, checkOutDate) < 1){
						$(".book-the-room .departure").datepicker("option", "minDate", minDate);
						$('.book-the-room input#checkout2').val($.datepicker.formatDate('dd, M, yy',minDate));
					}
				},
				beforeShow: function(input, inst) {
					var height = $('.book-the-room div.arrival').outerHeight() - $('.book-the-room input#checkin2').innerHeight();
				}
			});
		})
		.on("mouseleave", function() {
			$(this).find('.ui-datepicker').hide(10);
		});
		var selDate = new Date(todayDate);
		$('.book-the-room input#checkin2').val($.datepicker.formatDate('dd, M, yy',selDate));
		
		selDate.setDate(selDate.getDate() + 1);
		$('.book-the-room input#checkout2').val($.datepicker.formatDate('dd, M, yy',selDate));
		
		$(".book-the-room .departure").on("mouseover", function() {
			$(this).find('.ui-datepicker').css('visibility','visible').show(10);
			$(this).datepicker({
				dateFormat: "dd, M, yy",
				minDate: "+1D",
				onSelect: function(dateText, inst) {					
					//To reset checkout date if select lower checkin date
					var departDate = new Date(Date.parse(dateText));
					$('.book-the-room input#checkout2').val($.datepicker.formatDate('dd, M, yy',departDate));
					$('.book-the-room input#departure_date2').val($.datepicker.formatDate('mm/dd/yy',departDate));
				},
				beforeShow: function(input, inst) {
					var height = $('.book-the-room div.departure').outerHeight() - $('.book-the-room input#checkout2').innerHeight();
				}
			});
		})
		.on("mouseleave", function() {
			$(this).find('.ui-datepicker').hide(10);
		});
	}
}
function submitBooking(){
	var hotelLink = 'https://gc.synxis.com/rez.aspx?Hotel=51197&Chain=12116';	
	var arrival = $('#arrival_date').val();
	var departure = $('#departure_date').val();
	var promo = document.getElementById("promo").value;
	
	var submission_link = hotelLink+"&arrive="+arrival+"&depart="+departure+"&promo="+promo;
	window.open(submission_link,'_blank');	
}
function submitRoomBooking() {
	var hotelLink = 'https://gc.synxis.com/rez.aspx?Hotel=51197&Chain=12116';	
	var arrival = $('#arrival_date2').val();
	var departure = $('#departure_date2').val();
	var promo = $('#b-promo').val();
	
	var submission_link = hotelLink+"&arrive="+arrival+"&depart="+departure+"&promo="+promo;
	window.open(submission_link,'_blank');	
}

function positionTransportation () { // *pending
	var ratio = 380 / 506; // height/width
	
	if ($('#location-list div.image').length) {
		var width = $('#location-list').innerWidth() / 2;
		var height = Math.floor(width * ratio);
		var infoHeight = 0;
		
		infoHeight = $('#location-list div.a-cat:visible').find('.info').css('height', 'auto').outerHeight(true);
		if (infoHeight > height) {
			height = Math.floor(infoHeight);
		}
		var padding = 100;
		if (isMobileMode() && window.innerWidth <= 550) {
			$('#location-list .image').css('height', height);
			$('#location-list .info').css('height', '');
		} else {
			if (infoHeight > height) {
				$('#location-list .image').css('height', height);
				$('#location-list .info').css('height', height - padding);
			} else {
				$('#location-list .image').css('height', infoHeight);
				$('#location-list .info').css('height', '');
			}
		}
	}
	
	// maps
	$('body #main-content div.our-location .map').height($('body #main-content div.our-location .text').outerHeight());
	$('body #main-content div.our-location #location-map').height($('body #main-content div.our-location .text').outerHeight());
}
function filter_transportation(category){ // *pending
	// item filtering
	var ratio = 380 / 506; // height/width
	var width = $('#location-list').innerWidth() / 2;
	var height = Math.floor(width * ratio);
	
	$('#location-list div.a-cat.'+category).show(0, function() {
		var padding = 100;
		var infoHeight = $(this).find('.info').css('height', 'auto').outerHeight(true);
		if (infoHeight > height) {
			height = Math.floor(infoHeight);
		}
		if (isMobileMode() && window.innerWidth <= 550) {
			$(this).find('.image').css('height', height);
			$(this).find('.info').css('height', '');
		} else {
			$(this).find('.image').css('height', height);
			$(this).find('.info').css('height', height - padding);
		}
	}).hide();
	$('#location-list div.a-cat.'+category).fadeIn();	
	$('#location-list div.a-cat:not(.'+category+')').hide();
	
	var obj = $('#a-'+category);
	$('#mobile-location-category p.selected-item').text($(obj).text());
	$(obj).addClass('selected-item');
	
	// category
	$('#cat-from_airport').attr('class', (category == 'from_airport' ? 'cat-sel' : 'cat'));
	$('#cat-from_transportation').attr('class', (category == 'from_transportation' ? 'cat-sel' : 'cat'));
	$('#cat-shuttle_services').attr('class', (category == 'shuttle_services' ? 'cat-sel' : 'cat'));

}
function filter_mobile_transportation(category){
	filter_transportation(category);
	var obj = $('#a-'+category);
	
	$('#mobile-transportation-category ul li a').removeClass('selected-item');
	$(obj).addClass('selected-item');
	$('#mobile-transportation-category ul').hide();
}

function setContactFormDefaultValue() {
	if ($('#contact-form #name').length > 0){
		$('#contact-form #name')
		.focus(function() {
			if (this.value == '') { $('label[for="'+this.id+'"] > div').css('opacity', 0.3); }
		}) 
		.keyup(function() {
			if (this.value != '') { 
				$('label[for="'+this.id+'"] > div').css('opacity', 0);
			} else {
				$('label[for="'+this.id+'"] > div').css('opacity', 0.3);
			}
		}) 
		.keypress(function() {
			if (this.value == '') { $('label[for="'+this.id+'"] > div').css('opacity', 0); } 
		})	
		.blur(function() {
			if (this.value == '') { 
				$('label[for="'+this.id+'"] > div').css('opacity', 0.60);
			}
		});
		$('#contact-form #phone')
		.focus(function() {
			if (this.value == '') { $('label[for="'+this.id+'"] > div').css('opacity', 0.3); }
		}) 
		.keyup(function() {
			if (this.value != '') { 
				$('label[for="'+this.id+'"] > div').css('opacity', 0);
			} else {
				$('label[for="'+this.id+'"] > div').css('opacity', 0.3);
			}
		}) 
		.keypress(function() {
			if (this.value == '') { $('label[for="'+this.id+'"] > div').css('opacity', 0); } 
		})	
		.blur(function() {
			if (this.value == '') { 
				$('label[for="'+this.id+'"] > div').css('opacity', 0.60);
			}
		});
		$('#contact-form #email')
		.focus(function() {
			if (this.value == '') { $('label[for="'+this.id+'"] > div').css('opacity', 0.3); }
		}) 
		.keyup(function() {
			if (this.value != '') { 
				$('label[for="'+this.id+'"] > div').css('opacity', 0);
			} else {
				$('label[for="'+this.id+'"] > div').css('opacity', 0.3);
			}
		}) 
		.keypress(function() {
			if (this.value == '') { $('label[for="'+this.id+'"] > div').css('opacity', 0); } 
		})	
		.blur(function() {
			if (this.value == '') { 
				$('label[for="'+this.id+'"] > div').css('opacity', 0.60);
			}
		});
		$('#contact-form #message')
		.focus(function() {
			if (this.value == '') { $('label[for="'+this.id+'"] > div').css('opacity', 0.3); }
		}) 
		.keyup(function() {
			if (this.value != '') { 
				$('label[for="'+this.id+'"] > div').css('opacity', 0);
			} else {
				$('label[for="'+this.id+'"] > div').css('opacity', 0.3);
			}
		}) 
		.keypress(function() {
			if (this.value == '') { $('label[for="'+this.id+'"] > div').css('opacity', 0); } 
		})	
		.blur(function() {
			if (this.value == '') { 
				$('label[for="'+this.id+'"] > div').css('opacity', 0.60);
			}
		});
	}
}

function positionHomeFacility() {
	var ratio = 570 / 1270; // height/width
	if ($('#h-facility div.facilityImages').length) {
		var width = $('#h-facility div.facilityImages').innerWidth();
		var height = width * ratio;
		$('#h-facility .facilityImages .img').css('height', height);
		$('#h-facility .facilityImages .img .video').each(function() {
			if ($(this).find('a').length) {
				if (isMobileMode()) {
					$(this).find('a').css('margin-top', (height / 2) - 22);
				} else {
					$(this).find('a').css('margin-top', (height / 2) - 33);
				}
			} else {
				$(this).find('span').css('margin-top', (height / 2) - 33);
			}
		});
		/*
		if ($('#h-facility .facilityImages .img .video > a').length) {
			$('#h-facility .facilityImages .img .video > a').css('margin-top', (height / 2) - 33);
		} else {
			alert(1);
			$('#h-facility .facilityImages .img .video > span').css('margin-top', (height / 2) - 33);
		}*/
		
		// video ration, width and height setting
		$('#h-facility #youtubevideo').css('height', height);
		
		ratio = 360 / 640; // height / width
		width = $('#h-facility #youtubevideo').width();
		height = ratio * width;
		$('#h-facility #youtubevideo iframe.video').css('height', height);
		$('#h-facility #youtubevideo iframe.video').css('margin-top', -(height/2));		
		
		if (isMobileMode()){ 
			height = $('#h-facility .facilityTitle').height() + $('#h-facility .facilityContent').height();
			
			$('#h-facility .facilityTitle').find('.slick-prev').css('top', height/2);
			$('#h-facility .facilityTitle').find('.slick-next').css('top', height/2);
		} else {
			$('#h-facility .facilityTitle').find('.slick-prev').css('top', '');
			$('#h-facility .facilityTitle').find('.slick-next').css('top', '');
		}
	}
}
function positionFacilityInfoList() {
	var ratio = 450 / 720; // height/width
	
	if ($('#facility-detail .lr-layout-item .infoImages').length) {
		$('#facility-detail .lr-layout-item').each(function() {
			if ($(this).find('.infoImages').length) {
				var width = $(this).find('.infoImages').innerWidth();
				var height = Math.floor((width * ratio));
				var infoHeight = Math.floor($(this).find('.info').css('height', 'auto').outerHeight(true));
				
				if (isMobileMode() && window.innerWidth <= 550) {
					$(this).find('.infoImages').css('height', height);
					$(this).find('.info').css('height', '');
				} else {
					if (height > infoHeight) {
						$(this).find('.infoImages').css('height', height);
						$(this).find('.info').css('height', height - 100);
					} else {
						$(this).find('.infoImages').css('height', infoHeight);
						$(this).find('.info').css('height', '');
					}
				}
			}
		});
	}
}
function resizeHomeFacility(){
	if ($('#h-facility').length) {
		if (isMobileMode()){
			$('#h-facility div.facilityTitle').slick('slickSetOption', 'slidesToShow', 1, true);
		} else {
			$('#h-facility div.facilityTitle').slick('slickSetOption', 'slidesToShow', 3, true);
		}
		var currentSlide = $('#h-facility div.facilityTitle').slick('slickCurrentSlide');
		$('#h-facility .facilityTitle .title').removeClass('slick-current');
		$('#h-facility .facilityTitle .title[data-slick-index='+currentSlide+']').addClass('slick-current');
		
		if (isMobileMode()){ 
			height = $('#h-facility .facilityTitle').height() + $('#h-facility .facilityContent').height();
			$('#h-facility .facilityTitle').find('.slick-prev').css('top', height/2);
			$('#h-facility .facilityTitle').find('.slick-next').css('top', height/2);
		} else {
			$('#h-facility .facilityTitle').find('.slick-prev').css('top', '');
			$('#h-facility .facilityTitle').find('.slick-next').css('top', '');
		}
	}
}

function positionAboutInfoList() {
	var ratio = 450 / 720; // height/width
	
	if ($('#about-detail .lr-layout-item .infoImages').length) {
		$('#about-detail .lr-layout-item').each(function() {
			if ($(this).find('.infoImages').length) {
				var width = $(this).find('.infoImages').innerWidth();
				var height = Math.floor((width * ratio));
				var infoHeight = Math.floor($(this).find('.info').css('height', 'auto').outerHeight(true));
				
				if (isMobileMode() && window.innerWidth <= 550) {
					$(this).find('.infoImages').css('height', height);
					$(this).find('.info').css('height', '');
				} else {
					var padding = $(this).find('.info').css('height', 'auto').innerHeight() - $(this).find('.info').css('height', 'auto').height();
					if (height > infoHeight) {
						$(this).find('.infoImages').css('height', height);
						$(this).find('.info').css('height', height - padding);
					} else {
						$(this).find('.infoImages').css('height', infoHeight);
						$(this).find('.info').css('height', '');
					}
				}
			}
		});
	}
}

function positionEventInfoList() {
	var ratio = 450 / 720; // height/width
	
	if ($('#event-detail .lr-layout-item .infoImages').length) {
		$('#event-detail .lr-layout-item').each(function() {
			if ($(this).find('.infoImages').length) {
				var width = $(this).find('.infoImages').innerWidth();
				var height = Math.floor((width * ratio));
				var infoHeight = Math.floor($(this).find('.info').css('height', 'auto').outerHeight(true));
				
				if (isMobileMode() && window.innerWidth <= 550) {
					$(this).find('.infoImages').css('height', height);
					$(this).find('.info').css('height', '');
				} else {
					var padding = $(this).find('.info').css('height', 'auto').innerHeight() - $(this).find('.info').css('height', 'auto').height();
					if (height > infoHeight) {
						$(this).find('.infoImages').css('height', height);
						$(this).find('.info').css('height', height - padding);
					} else {
						$(this).find('.infoImages').css('height', infoHeight);
						$(this).find('.info').css('height', '');
					}
				}
			}
		});
	}
}

function positionHomeAttraction() {
	var ratio = 380 / 500; // height/width
	// 500 x 380
	if ($('#h-attractions div.images').length) {
		var width = $('#h-attractions').width() / 2;
		var height = width * ratio;
		var infoHeight = 0;
		
		$('#h-attractions .attraction .text').each(function() {
			infoHeight = $(this).css('height', 'auto').outerHeight(true) ;
			if (infoHeight > height) {
				height = infoHeight;
			}
		});
		
		var padding = 100;
		if (isMobileMode()) {
			width = $('#h-attractions .a-cat').width();
			$('#h-attractions .attraction .slick-track .slick-slide').css('width', width);
			$('#h-attractions div.images').css('height', '');
			$('#h-attractions div.text').css('height', '');
		} else {
			$('#h-attractions .attraction .slick-track .slick-slide').css('width', width);			
			$('#h-attractions div.images').css('height', height);
			$('#h-attractions div.text').css('height', height - padding);
		}
		
		if (isMobileMode()) {
			$('#h-attractions div.a-cat').each(function() {
				var bottom = $(this).find('.text').outerHeight();
				$(this).find('.slick-arrow').css('bottom', bottom / 2);
			});
		}
	}
}
function filter_attraction(category){
	// item filtering
	if ($('#h-attractions div.a-cat.a-'+category).length > 0) {
		$('#h-attractions div.a-cat.a-'+category).show(0, function() {
			var padding = 100;
			
			//$('#h-attractions .attraction .images').slick('slickSetOption', 'autoplay',false,false);
			positionHomeAttraction();
			$('#h-attractions .attraction .images').slick('slickGoTo', 0,true,false);
		}).hide();
		$('#h-attractions div.a-cat.a-'+category).fadeIn();
		//$('#no-attraction').hide();			
	} else {
		//$('#no-attraction').show();
	}
	$('#h-attractions div.a-cat:not(.a-'+category+')').hide();
	
	var obj = $('#a-'+category);
	$('#mobile-attraction-category p.selected-item').text($(obj).text());
	$(obj).addClass('selected-item');
	
	// category
	$('#cat-views').attr('class', (category == 'views' ? 'cat-sel' : 'cat'));
	$('#cat-shopping').attr('class', (category == 'shopping' ? 'cat-sel' : 'cat'));
	$('#cat-dining').attr('class', (category == 'dining' ? 'cat-sel' : 'cat'));
	$('#cat-recreation').attr('class', (category == 'recreation' ? 'cat-sel' : 'cat'));
	$('#cat-nightlight').attr('class', (category == 'nightlight' ? 'cat-sel' : 'cat'));
}
function filter_mobile_attraction(category){
	filter_attraction(category);
	var obj = $('#a-'+category);
	
	$('#mobile-attraction-category ul li a').removeClass('selected-item');
	$(obj).addClass('selected-item');
	$('#mobile-attraction-category ul').hide();
}

function positionAwardList() {
	var ratio = 500 / 750; // height/width
	if ($('#awardlist > div').length) {
		var width = $('#awardlist .award').width();
		var height = Math.floor(width * ratio);
		$('#awardlist .award .awardImages .awardImg').css('height', height);
			
		var infoHeight = 0;
		var idx = 1, id1 = '', id2 = '', id3 = '';
		var count = 1;
		$('#awardlist .award').each(function() {
			idx = $(this).attr('data-idx');
			if (idx == 1) {
				infoHeight = 0;
				id1 = $(this).attr('id');
			} else if (idx == 2) {
				id2 = $(this).attr('id');
			} else if (idx == 3) {
				id3 = $(this).attr('id');
			}
			$(this).find('.tag').css('margin-left', -($(this).find('.tag').outerWidth() / 2));
			
			// info height
			var itemHeight = $(this).find('.info').css('height', 'auto').height();
			if (itemHeight > infoHeight) {
				infoHeight = itemHeight;
			}
			if (idx == 3) {
				$('#awardlist #'+id1).find('.info').css('height', Math.floor(infoHeight));
				$('#awardlist #'+id2).find('.info').css('height', Math.floor(infoHeight));
				$('#awardlist #'+id3).find('.info').css('height', Math.floor(infoHeight));
				
				id1 = '';
				id2 = '';
				id3 = '';
			}
			if (count == $('#awardlist .award').length) {
				if (id1 != '') {
					$('#awardlist #'+id1).find('.info').css('height', Math.floor(infoHeight));
				}
				if (id2 != '') {
					$('#awardlist #'+id2).find('.info').css('height', Math.floor(infoHeight));
				}
				if (id3 != '') {
					$('#awardlist #'+id3).find('.info').css('height', Math.floor(infoHeight));
				}
			}
			idx += 1;
			count += 1;
		});
		//$('#awardlist .award .info').css('height', Math.floor(infoHeight));
	}
}

function positionPressList() {
	var ratio = 500 / 750; // height/width
	if ($('#presslist > div').length) {
		var width = $('#presslist .press').width();
		var height = Math.floor(width * ratio);
		$('#presslist .press .pressImages .pressImg').css('height', height);
			
		var infoHeight = 0;
		var idx = 1, id1 = '', id2 = '', id3 = '';
		var count = 1;
		$('#presslist .press').each(function() {
			idx = $(this).attr('data-idx');
			if (idx == 1) {
				infoHeight = 0;
				id1 = $(this).attr('id');
			} else if (idx == 2) {
				id2 = $(this).attr('id');
			} else if (idx == 3) {
				id3 = $(this).attr('id');
			}
			$(this).find('.tag').css('margin-left', -($(this).find('.tag').outerWidth() / 2));
			
			// info height
			var itemHeight = $(this).find('.info').css('height', 'auto').height();
			if (itemHeight > infoHeight) {
				infoHeight = itemHeight;
			}
			if (idx == 3) {
				$('#presslist #'+id1).find('.info').css('height', Math.floor(infoHeight));
				$('#presslist #'+id2).find('.info').css('height', Math.floor(infoHeight));
				$('#presslist #'+id3).find('.info').css('height', Math.floor(infoHeight));
				
				id1 = '';
				id2 = '';
				id3 = '';
			}
			if (count == $('#presslist .press').length) {
				if (id1 != '') {
					$('#presslist #'+id1).find('.info').css('height', Math.floor(infoHeight));
				}
				if (id2 != '') {
					$('#presslist #'+id2).find('.info').css('height', Math.floor(infoHeight));
				}
				if (id3 != '') {
					$('#presslist #'+id3).find('.info').css('height', Math.floor(infoHeight));
				}
			}
			idx += 1;
			count += 1;
		});
		//$('#presslist .press .info').css('height', Math.floor(infoHeight));
	}
}

var xmlhttp = new XMLHttpRequest();
var req = '';
var rowCount = 6;
function loadmoreawards() {
	var htmlResult = '';
	var startIdx = $('#curIdx').val();
	
	req = 'loadmoreawards';
	var webservice_url = "http://www.hotel-icon.com/webservice.php?f=loadmoreawards&startidx="+startIdx+"&cnt="+rowCount;
	xmlhttp.open('POST', webservice_url, true);
	xmlhttp.send();
	return false;
}
function loadmorepress() {
	var htmlResult = '';
	var startIdx = $('#curIdx').val();
	
	req = 'loadmorepress';
	var webservice_url = "http://www.hotel-icon.com/webservice.php?f=loadmorepress&startidx="+startIdx+"&cnt="+rowCount;
	xmlhttp.open('POST', webservice_url, true);
	xmlhttp.send();
	return false;
}
xmlhttp.onreadystatechange=function() {
    try{
	    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			if (req == 'loadmoreawards') {
				setHTMLResult();
				positionAwardList();
				
				var startIdx = $('#curIdx').val();
				var newIdx = parseInt(startIdx) + rowCount;
				$('#curIdx').val(newIdx);
				
				if ($('#hddlast').length) {
					$('.loadmore').addClass('disable');
				}
				initPopUp();
			} else if (req == 'loadmorepress') {
				setPressHTMLResult();
				positionPressList();
				
				var startIdx = $('#curIdx').val();
				var newIdx = parseInt(startIdx) + rowCount;
				$('#curIdx').val(newIdx);
				
				if ($('#hddlast').length) {
					$('.loadmore').addClass('disable');
				}
				initPopUp();
			}
	    }
 	}
 	catch (e){ }
}
function setHTMLResult() {
	var htmlResult = xmlhttp.responseText;
	var oriHTML = $('#awardlist .list').html();
	
	htmlResult = oriHTML + htmlResult;
	$('#awardlist .list').html(htmlResult);
}
function setPressHTMLResult() {
	var htmlResult = xmlhttp.responseText;
	var oriHTML = $('#presslist .list').html();

	
	htmlResult = oriHTML + htmlResult;
	$('#presslist .list').html(htmlResult);
}

function positionDineList() {
	var ratio = 450 / 720; // height/width
	
	if ($('#dinelist .lr-layout-item').length) {
		$('#dinelist .lr-layout-item').each(function() {
			var width = $(this).find('.dineImg').innerWidth();
			var height = Math.floor(width * ratio);
			var infoHeight = Math.floor($(this).find('.info').css('height', 'auto').outerHeight(true));
			
			if (isMobileMode() && window.innerWidth <= 550) {
				$(this).find('.dineImg').css('height', height);
				$(this).find('.info').css('height', '');
			} else {
				if (height > infoHeight) {
					$(this).find('.dineImg').css('height', height);
					$(this).find('.info').css('height', height - 100);
				} else {
					$(this).find('.dineImg').css('height', infoHeight);
					$(this).find('.info').css('height', '');
				}
			}
		});
	}
}
function positionDineInfoList(){
	var ratio = 450 / 720; // height/width
	
	if ($('#dine-detail .lr-layout-item .infoImages').length) {
		$('#dine-detail .lr-layout-item').each(function() {
			if ($(this).find('.infoImages').length) {
				var width = $(this).find('.infoImages').innerWidth();
				var height = Math.floor((width * ratio));
				var infoHeight = Math.floor($(this).find('.info').css('height', 'auto').outerHeight(true));
				
				if (isMobileMode() && window.innerWidth <= 550) {
					$(this).find('.infoImages').css('height', height);
					$(this).find('.info').css('height', '');
				} else {
					if (height > infoHeight) {
						$(this).find('.infoImages').css('height', height);
						$(this).find('.info').css('height', height - 160);
					} else {
						$(this).find('.infoImages').css('height', infoHeight);
						$(this).find('.info').css('height', '');
					}
				}
			}
		});
	}
	if ($('#dine-detail .lr-layout-item .highlight').length) {
		var highlight = $('#dine-detail .lr-layout-item .highlight').css('height', 'auto').outerHeight(true);
		var infoHeight = $('#dine-detail .lr-layout-item .book-the-dine').css('height', 'auto').outerHeight(true);
		
		var padding = $('#dine-detail .lr-layout-item .highlight').css('height', 'auto').innerHeight() - $('#dine-detail .lr-layout-item .highlight').css('height', 'auto').height();
		if (highlight > infoHeight) {
			$('#dine-detail .lr-layout-item .highlight').css('height', '');
			$('#dine-detail .lr-layout-item .book-the-dine').css('height', highlight - padding);
		} else {
			$('#dine-detail .lr-layout-item .highlight').css('height', infoHeight - padding);
			$('#dine-detail .lr-layout-item .book-the-dine').css('height', '');			
		}
    }
	
}

function positionRoomList() {
	var ratio = 450 / 720; // height/width
	
	if ($('#roomlist .lr-layout-item').length) {
		$('#roomlist .lr-layout-item').each(function() {
			var width = $(this).find('.roomImg').innerWidth();
			var height = Math.floor(width * ratio);
			var infoHeight = Math.floor($(this).find('.info').css('height', 'auto').outerHeight(true));
			
			if (isMobileMode()) {
				$(this).find('.roomImg').css('height', height);
				$(this).find('.info').css('height', '');
			} else {
				var padding = $(this).find('.info').css('height', 'auto').innerHeight() - $(this).find('.info').css('height', 'auto').height();
				if (height > infoHeight) {
					$(this).find('.roomImg').css('height', height);
					$(this).find('.info').css('height', height - padding);
				} else {
					$(this).find('.roomImg').css('height', infoHeight);
					$(this).find('.info').css('height', '');
				}
			}
		});
	}
	if ($('#room-maylike').length) {
		$('#room-maylike').find('div.tag').each(function() {
			var width = $(this).outerWidth();
			$(this).css('margin-left', '-'+(width/2)+'px');
		});
	}
}
function positionRoomInfoList() {
	var ratio = 470/ 750; // height/width
	
	if ($('#room-detail .lr-layout-item .infoImages').length) {
		$('#room-detail .lr-layout-item').each(function() {
			if ($(this).find('.infoImages').length) {
				
				var width = $(this).find('.infoImages').innerWidth();
				var height = Math.floor((width * ratio));
				var infoHeight = Math.floor($(this).find('.info').css('height', 'auto').outerHeight(true));
				
				if (isMobileMode() && window.innerWidth <= 550) {
					$(this).find('.infoImages').css('height', height);
					$(this).find('.info').css('height', '');
				} else {
					var padding = $(this).find('.info').css('height', 'auto').innerHeight() - $(this).find('.info').css('height', 'auto').height();
					if (height > infoHeight) {
						$(this).find('.infoImages').css('height', height);
						$(this).find('.info').css('height', height - padding);
					} else {
						$(this).find('.infoImages').css('height', infoHeight);
						$(this).find('.info').css('height', '');
					}
				}
			}
		});
	}
	if ($('#room-detail .lr-layout-item .highlight').length) {
		var highlight = $('#room-detail .lr-layout-item .highlight').css('height', 'auto').outerHeight(true);
		var infoHeight = $('#room-detail .lr-layout-item .book-the-room').css('height', 'auto').outerHeight(true);

		var padding = $('#room-detail .lr-layout-item .book-the-room').css('height', 'auto').innerHeight() - $('#room-detail .lr-layout-item .book-the-room').css('height', 'auto').height();
		if ($('#room-detail .lr-layout-item .book-the-room.image').length) {
			padding = 0;
		}
		if (highlight > infoHeight) {
			$('#room-detail .lr-layout-item .highlight').css('height', '');
			$('#room-detail .lr-layout-item .book-the-room').css('height', highlight - padding);
		} else {
			$('#room-detail .lr-layout-item .highlight').css('height', infoHeight- padding);
			$('#room-detail .lr-layout-item .book-the-room').css('height', '');			
		}
    }
}
function positionRoomMayLike(){
	if ($('#room-maylike').length) {
		var height = 0; 
		$('#room-maylike .item .info').each(function() {
			var itemHeight = $(this).css('height', 'auto').height();
			
			if (itemHeight > height) {
				height = itemHeight;
			}
		});
		$('#room-maylike .item .info').css('height', height);
	}
}
function positionDineMayLike() {
	if ($('#dine-maylike').length) {
		$('#dine-maylike .item .info').css('height', $('#dine-maylike .item .dineImg').css('height', 'auto').height());
	}
}
function positionMayLike() {
	if ($('#maylike').length) {
		$('#maylike .item .info').css('height', $('#maylike .item .likeImg').css('height', 'auto').height());
	}
}


function positionOfferList() {
	var ratio = 470 / 750; // height/width
	// 750 x 470
	if ($('#offer-list > div').length) {
		var infoHeight = 0;
		var height = 0;
		$('#offer-list .offer').each(function() {
			if ($(this).not('.highlight')) {
				var width = $(this).width();
				height = Math.floor(width * ratio);
				
				$(this).find('.tag').css('margin-left', -($(this).find('.tag').outerWidth() / 2));
				
				// info height
				var itemHeight = $(this).find('.info').css('height', 'auto').height();
				if (itemHeight > infoHeight) {
					infoHeight = itemHeight;
				}
			}
		});
		$('#offer-list .offer .offerImages .offerImg').css('height', height);
		$('#offer-list .offer .info').css('height', infoHeight);
		
			
		infoHeight = 0;
		if ($('#offer-list .highlight').length) {
			height = 0;
			$('#offer-list .highlight').each(function() {
				var width = $(this).width();
				height = Math.floor(width * ratio);
				
				$(this).find('.tag').css('margin-left', -($(this).find('.tag').outerWidth() / 2));
				
				// info height
				var itemHeight = $(this).find('.info').css('height', 'auto').height();
				if (itemHeight > infoHeight) {
					infoHeight = itemHeight;
				}
			});
			$('#offer-list .highlight .offerImages .offerImg').css('height', height);
			$('#offer-list .highlight .info').css('height', infoHeight);
		}
		
		$('#offer-list .offer').each(function() {
			var hover = $(this).find('.hover');
			var icon = $(this).find('.icon-share');
			$(this).find('.share').hover(function() {
				$(icon).hide();
				$(hover).show();
			}, function() {
				$(icon).show();
				$(hover).hide();
			});
		});
	}
	
	if ($('#offer-detail').length) {
		$('#offer-detail .lr-layout-item > div.images .infoImages').each(function() {
			ratio = 470/ 750;
			var info = $(this).parent().parent().find('.info');
			var width = $(this).innerWidth();
			var height = Math.floor(width * ratio);
			var infoHeight = Math.floor($(info).css('height', 'auto').outerHeight(true));
			
			if (isMobileMode() && window.innerWidth <= 550) {
				$(this).css('height', height);
				$(this).find('.info').css('height', '');
			} else {
				var padding = $(info).css('height', 'auto').innerHeight() - $(info).css('height', 'auto').height();
				
				if (height > infoHeight) {
					$(this).css('height', height);
					$(info).css('height', height - padding);
				} else {
					$(this).css('height', infoHeight);
					$(info).css('height', '');
				}
			}
		});
	}
}
function positionOfferMayLike() {
	if ($('#offer-maylike').length) {
		var height = 0;
		$('#offer-maylike .item').each(function() {
			var itemHeight = $(this).find('.offerImg').css('height', 'auto').height();
			if (itemHeight > height ) {
				height = itemHeight;
			}
		});
		//$('#offer-maylike .item .info').css('height', $('#offer-maylike .item .offerImg').css('height', 'auto').height());
		$('#offer-maylike .item .info').css('height', height);
		$('#offer-maylike .item .offerImg').css('height', height);
	}
}
function filter_offer(category){
	if (category == 'ALL') {
		$('#offer-list div.offer.highlight').css('width', Math.floor($('#offer-list div.offer.highlight').css('width', '46.9%').width()));
		$('#offer-list div.offer.highlgiht').css('margin', '30px 1.5%');
		positionOfferList();
		
		$('#offer-list div.offer').fadeIn();	
		//$('#no-offer').hide("slow");	
		
	} else {
		$('#offer-list div.offer.highlight').css('width', Math.floor($('#offer-list div.offer.highlight').css('width', '30%').width()));
		//$('#offer-list div.offer.highlight').css('width', '30%');
		$('#offer-list div.offer.highlight').css('margin', '30px 1.5%');
		positionOfferList();
		
		if ($('#offer-list div.offer.offer-'+category).length > 0) {
			$('#offer-list div.offer.offer-'+category).fadeIn();		
			//$('#no-offer').hide("slow");			
		} else {
			//$('#no-offer').show("slow");
		}
		$('#offer-list div.offer:not(.offer.offer-'+category+')').hide();
		
		var obj = $('#a-'+category);
		$('#mobile-offer-category p.selected-item').text($(obj).text());
		$(obj).addClass('selected-item');
		
		// category
		$('#cat-ALL').attr('class', (category == 'ALL' ? 'cat-sel' : 'cat'));
		$('#cat-ROOMS').attr('class', (category == 'ROOMS' ? 'cat-sel' : 'cat'));
		$('#cat-WINE_DINE').attr('class', (category == 'WINE_DINE' ? 'cat-sel' : 'cat'));
		$('#cat-PROMOTIONS').attr('class', (category == 'PROMOTIONS' ? 'cat-sel' : 'cat'));
	}
	
	$('#offer-list .tag').each(function() { 
		$(this).css('margin-left', -($(this).outerWidth() / 2));
	});
}
function filter_mobile_offer(category){
	filter_offer(category);
	var obj = $('#a-'+category);
	
	$('#mobile-offer-category ul li a').removeClass('selected-item');
	$(obj).addClass('selected-item');
	$('#mobile-offer-category ul').hide();
}

function positionArticleList() {
	var ratio = 470 / 750; // height/width

	if ($('#article-list > div').length) {
		var infoHeight = 0;
		$('#article-list .highlight').each(function() {
			$(this).css('width', '');
			
			var width = $(this).width();
			var height = Math.floor(width * ratio);
			
			$(this).find('.articleImages .articleImg').css('height', height);
			$(this).find('.tag').css('margin-left', -($(this).find('.tag').outerWidth() / 2));
			
			// info height
			var itemHeight = $(this).find('.info').css('height', 'auto').height();
			if (itemHeight > infoHeight) {
				infoHeight = itemHeight;
			}
		});
		$('#article-list .highlight .info').css('height', infoHeight);
			
		infoHeight = 0;
		$('#article-list .article').each(function() {
			$(this).css('width', '');
			
			var width = $(this).width();
			var height = Math.floor(width * ratio);
			
			$(this).find('.articleImages .articleImg').css('height', height);
			$(this).find('.tag').css('margin-left', -($(this).find('.tag').outerWidth() / 2));
			
			// info height
			var itemHeight = $(this).find('.info').css('height', 'auto').height();
			if (itemHeight > infoHeight) {
				infoHeight = itemHeight;
			}
		});
		$('#article-list .article .info').css('height', infoHeight);
		
		$('#article-list .article').each(function() {
			var hover = $(this).find('.hover');
			var icon = $(this).find('.icon-share');
			$(this).find('.share').hover(function() {
				$(icon).hide();
				$(hover).show();
			}, function() {
				$(icon).show();
				$(hover).hide();
			});
		});
	}
	
	if ($('#article-detail').length) {
		$('#article-detail .lr-layout-item > div.images .infoImages').each(function() {
			ratio = 470/ 750;
			var width = $(this).innerWidth();
			var height = (width * ratio);
			var infoHeight = $(this).parent().parent().find('.info').css('height', 'auto').outerHeight(true);
			
			if (isMobileMode() && window.innerWidth <= 550) {
				$(this).css('height', height);
				$(this).find('.info').css('height', '');
			} else {
				if (height > infoHeight) {
					$(this).css('height', height);
					$(this).parent().parent().find('.info').css('height', height - 160);
				} else {
					$(this).css('height', infoHeight);
					$(this).parent().parent().find('.info').css('height', '');
				}
			}
		});
	}
	
	if ($('#article-maylike').length) {
		$('#article-maylike').find('div.tag').each(function() {
			var width = $(this).outerWidth();
			$(this).css('margin-left', '-'+(width/2)+'px');
		});
	}
}
function positionArticleMayLike() {
	if ($('#article-maylike').length) {
		var height = 0; 
		$('#article-maylike .item .info').each(function() {
			var itemHeight = $(this).css('height', 'auto').height();
			
			if (itemHeight > height) {
				height = itemHeight;
			}
		});
		$('#article-maylike .item .info').css('height', height);
	}
}
function filter_article(category){
	if (category == 'ALL') {
		$('#article-list div.article.highlight').css('width', Math.floor($('#article-list div.article.highlight').css('width', '46.9%').width()));
		$('#article-list div.article.highlight').css('margin', '30px 1.5%');
		
		$('#article-list div.article.article-'+category).show(0, function() {
			var padding = 100;
			
			positionArticleList();
		}).hide();
		
		$('#article-list div.article').fadeIn();	
		//$('#no-article').hide("slow");	
		
		$('#cat-ALL').attr('class', (category == 'ALL' ? 'cat-sel' : 'cat'));
		
	} else {
		$('#article-list div.article.highlight').css('width', Math.floor($('#article-list div.article.highlight').css('width', '30%').width()));
		$('#article-list div.article.highlight').css('margin', '30px 1.5%');
		
		$('#article-list div.article.article-'+category).show(0, function() {
			var padding = 100;
			
			positionArticleList();
		}).hide();
		
		if ($('#article-list div.article.article-'+category).length > 0) {
			$('#article-list div.article.article-'+category).fadeIn();	
			//$('#no-article').hide("slow");			
		} else {
			//$('#no-article').show("slow");
		}
		$('#article-list div.article:not(.article.article-'+category+')').hide();
		
		var obj = $('#a-'+category);
		$('#mobile-article-category p.selected-item').text($(obj).text());
		$(obj).addClass('selected-item');
		
		// category
		$('#cat-ALL').attr('class', (category == 'ALL' ? 'cat-sel' : 'cat'));
		$('#cat-FOODIE').attr('class', (category == 'FOODIE' ? 'cat-sel' : 'cat'));
		$('#cat-ART_CULTURE').attr('class', (category == 'ART_CULTURE' ? 'cat-sel' : 'cat'));
		$('#cat-HAPPENINGS').attr('class', (category == 'HAPPENINGS' ? 'cat-sel' : 'cat'));
		$('#cat-SEASONAL').attr('class', (category == 'SEASONAL' ? 'cat-sel' : 'cat'));
		$('#cat-OTHERS').attr('class', (category == 'OTHERS' ? 'cat-sel' : 'cat'));
	}
	$('#article-list .tag').each(function() { 
		$(this).css('margin-left', -($(this).outerWidth() / 2));
	});
	
}
function filter_mobile_article(category){
	filter_article(category);
	var obj = $('#a-'+category);
	
	$('#mobile-article-category ul li a').removeClass('selected-item');
	$(obj).addClass('selected-item');
	$('#mobile-article-category ul').hide();
}

function positionFacilityList() {
	var ratio = 450 / 720; // height/width
	var ratio2 = 510 / 900; 
	//900 x 510 and 720 x 450
	
	if ($('#facility-list .lr-layout-item-right').length) { // ratio
		$('#facility-list .lr-layout-item-right').each(function() {
			var width = $('.facilityImages').innerWidth();
			var height = Math.floor(width * ratio);
			var infoHeight = Math.floor($(this).find('.info').css('height', 'auto').outerHeight(true));
			
			if (isMobileMode() && window.innerWidth <= 550) {
				$(this).find('.facilityImages').css('height', height);
				$(this).find('.info').css('height', '');
			} else {
				if (height > infoHeight) {
					$(this).find('.facilityImages').css('height', height);
					$(this).find('.info').css('height', height - 100);
				} else {
					$(this).find('.facilityImages').css('height', infoHeight);
					$(this).find('.info').css('height', '');
				}
			}
		});
	}
	
	if ($('#facility-list .lr-layout-item-left').length) { // ratio2
		$('#facility-list .lr-layout-item-left').each(function() {
			var width = $('.facilityImages').innerWidth();
			var height = Math.floor(width * ratio);
			var infoHeight = Math.floor($(this).find('.info').css('height', 'auto').outerHeight(true));
			
			if (isMobileMode() && window.innerWidth <= 550) {
				$(this).find('.facilityImages').css('height', height);
				$(this).find('.info').css('height', '');
			} else {
				if (height > infoHeight) {
					$(this).find('.facilityImages').css('height', height);
					$(this).find('.info').css('height', height - 100);
				} else {
					$(this).find('.facilityImages').css('height', infoHeight);
					$(this).find('.info').css('height', '');
				}
			}
		});
	}
}

function positionEventList() {
	var ratio = 450 / 720; // height/width
	var ratio2 = 510 / 900; 
	
	if ($('#event-list .lr-layout-item-right').length) { // ratio
		$('#event-list .lr-layout-item-right').each(function() {
			var width = $('.eventImages').innerWidth();
			var height = Math.floor(width * ratio);
			var infoHeight = Math.floor($(this).find('.info').css('height', 'auto').outerHeight(true));
			
			if (isMobileMode() && window.innerWidth <= 550) {
				$(this).find('.eventImages').css('height', height);
				$(this).find('.info').css('height', '');
			} else {
				var padding = $(this).find('.info').css('height', 'auto').innerHeight() - $(this).find('.info').css('height', 'auto').height();
				
				if (height > infoHeight) {
					$(this).find('.eventImages').css('height', height);
					$(this).find('.info').css('height', height - padding);
				} else {
					$(this).find('.eventImages').css('height', infoHeight);
					$(this).find('.info').css('height', '');
				}
			}
		});
	}
	
	if ($('#event-list .lr-layout-item-left').length) { // ratio2
		$('#event-list .lr-layout-item-left').each(function() {
			var width = $('.eventImages').innerWidth();
			var height = Math.floor(width * ratio);
			var infoHeight = Math.floor($(this).find('.info').css('height', 'auto').outerHeight(true));
			
			if (isMobileMode() && window.innerWidth <= 550) {
				$(this).find('.eventImages').css('height', height);
				$(this).find('.info').css('height', '');
			} else {
				var padding = $(this).find('.info').css('height', 'auto').innerHeight() - $(this).find('.info').css('height', 'auto').height();
				if (height > infoHeight) {
					$(this).find('.eventImages').css('height', height);
					$(this).find('.info').css('height', height - padding);
				} else {
					$(this).find('.eventImages').css('height', infoHeight);
					$(this).find('.info').css('height', '');
				}
			}
		});
	}
}

function setAttractionEffect(){
	if ($('#mobile-menu').css('display') != 'block'){
		$("#attraction-list .item").each(function(){
			if ($(this).attr('hover') != 'true') {
				$(this).bind('mouseenter', function() {
					$(this).find("span").stop().slideDown("fast");
				});
				$(this).bind('mouseleave', function() {
					$(this).find("span").slideUp("fast");
				});
				$(this).attr('hover','true');
			}
		});
	}
	else {
		$("#attraction-list .item").each(function(){
			$(this).unbind('mouseenter mouseleave');
			$(this).attr('hover','');
		});
	}
}

function verifyNewsletter(SubscriberForm){
	// prefix
	if (SubscriberForm.pf_Demographicfield1.value == "") {
		alert("Please enter a value for the \'Prefix\' field.");
		SubscriberForm.pf_Demographicfield1.focus();
		return false; 
	}
	
	// firstname
	if (SubscriberForm.pf_Demographicfield2.value == "") {
		alert("Please enter a value for the \'First Name\' field.");
		SubscriberForm.pf_Demographicfield2.focus();
		return false; 
	}
	if (!SubscriberForm.pf_Demographicfield2.value.match(/^[a-zA-Z\s]+$/)) {
		alert("Please enter alphabet only value for the \'First Name\' field.");
		SubscriberForm.pf_Demographicfield2.focus();
		return false; 
	}
	
	// last name
	if (SubscriberForm.pf_Demographicfield3.value == "") {
		alert("Please enter a value for the \'Last Name\' field.");
		SubscriberForm.pf_Demographicfield3.focus();
		return false; 
	}
	if (!SubscriberForm.pf_Demographicfield3.value.match(/^[a-zA-Z\s]+$/)) {
		alert("Please enter alphabet only value for the \'Last Name\' field.");
		SubscriberForm.pf_Demographicfield3.focus();
		return false; 
	}
	
	// email verification
	if (SubscriberForm.pf_Email.value.length > 255) {
		alert("Please enter at most 255 characters in the \'Email address\' field.");
		SubscriberForm.pf_Email.focus();
		return false;
	}
	if (SubscriberForm.pf_Email.value == "") {
		alert("Please enter a value for the \'Email address\' field.");
		SubscriberForm.pf_Email.focus();
		return false; 
	}
	if (SubscriberForm.pf_Email.value.length < 7) {
		alert("Please enter at least 7 characters in the \'Email address\' field.");
		SubscriberForm.pf_Email.focus();
		return false; 
	}
	
	pf_Email=SubscriberForm.pf_Email.value;
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,})$/;
	if(reg.test(pf_Email) == false) {
		  alert('Your email address is not valid. Please try again.');
		  SubscriberForm.pf_Email.focus();
		  return false;
	}
	
	// dob - mm/dd
	// /^([0]?[1-9]|[1|2][0-9]|[3][0|1])[./-]([0]?[1-9]|[1][0-2])[./-]([0-9]{4}|[0-9]{2})$/ 
	// dd-mm-yy
	
	// /^([0]?[1-9]|[1|2][0-9]|[3][0|1])[./-]([0]?[1-9]|[1][0-2])$/ 
	// /^\d{1,2}\/\d{1,2}$/
	if (!SubscriberForm.pf_Demographicfield4.value.match(/^([0]?[1-9]|[1][0-2])\/([0]?[1-9]|[1|2][0-9]|[3][0|1])$/)) {
		  alert('Please enter a MM/DD format value for \'Date of Birth\' field.');
		  SubscriberForm.pf_Demographicfield4.focus();
		  return false;
	}
	
	
	// country
	if (SubscriberForm.pf_Demographicfield5.value == "") {
		alert("Please enter a value for the \'Country\' field.");
		SubscriberForm.pf_Demographicfield5.focus();
		return false; 
	}
	
	var counter = 0;
	for (i=1; i<=SubscriberForm.pf_CounterMailinglists.value; i++) {
		var checkBoxName = "pf_MailinglistName" + i;
		if (document.getElementsByName(checkBoxName)[0].checked || document.getElementsByName(checkBoxName)[0].type == "hidden") counter++; 
	}
	if (counter == 0) {
		alert("One or more mailing lists are required for this form.");
		return false;
	}
	return true;
}

function isTabletMode(){
	var windowWidth = window.innerWidth;
	return (windowWidth <= 980);
}

function isMobileMode(){
	return ($('#mobile-menu').css('display') == 'block');
}

function isMobileDevice() {
	var isMobile = false; //initiate as false
	// device detection
	if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) 
    || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) isMobile = true;

	return isMobile;
}

function changeLanguage(target) {
	var array = new Array('zh-tw', 'zh-cn', 'ja-jp','ru-ru','ko-kr');
	
	var rootpath = '/';
	var url = window.location.href;
	var hostname = window.location.hostname + rootpath;
	var enVersion = 1; 
	var currentLang = 'en';
	for (var i=0; i<array.length; i++) {
		var lang;
		
		if (url.indexOf('/' + array[i] + '/') > 0) {
			currentLang = lang; // not en version
			enVersion = 0;
		}
	}
	var path = window.location.pathname;
	path = path.replace(rootpath, '');
	
	if (target == 'en' || target == 'zh-tw' || target == 'zh-cn' || target == 'ja-jp' || target == 'ru-ru' || target == 'ko-kr') {
		if (target == 'en') {
			url = 'http://' + hostname + path + window.location.hash;
		} else {
			if (currentLang == 'en') {
				url = 'http://' + hostname + target + '/' + path + window.location.hash;
			} else {
				url = url.replace('/' + lang + '/', '/' + target + '/');
			}
		}
	} else {
		url = 'http://' + hostname + path + window.location.hash;
	}
	window.location.href = url;
}