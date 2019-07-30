jQuery(document).ready(function() {

	//accordions

	if ( jQuery(window).width() <= 700 ) {
		jQuery("body.page-deportes #le-damos-al-deporte-un-gran-espacio ~ .mrg-section-boxes .mrg-block-column-spaces-vertical").addClass("accordion-box");
		jQuery("body.page-deportes #le-damos-al-deporte-un-gran-espacio ~ .mrg-section-boxes .mrg-block-column-spaces-vertical .heading").addClass("accordion-title");
		jQuery("body.page-deportes #le-damos-al-deporte-un-gran-espacio ~ .mrg-section-boxes .mrg-block-column-spaces-vertical .text").addClass("accordion-description");
	}

	jQuery(".accordion-box .accordion-description").hide();
	jQuery(".accordion-box .accordion-title").append('<span class="arrow arrow-down"></span>');
	jQuery(".accordion-box .accordion-title").on("click",function(){
		jQuery(this).next().slideToggle();
		if ( jQuery(this).children("span").hasClass("arrow-down") ) {
				jQuery(this).children("span").addClass("arrow-left");
				jQuery(this).children("span").removeClass("arrow-down");
		}
		else {
				jQuery(this).children("span").addClass("arrow-down");
				jQuery(this).children("span").removeClass("arrow-left");
		}
	});

	jQuery(".videos-thumbnails-list video").css("display","none");
	jQuery(".videos-thumbnails-list iframe").css("display","none");

	// Page: ciudad
	
	jQuery('.slider.simple').flexslider({
		animation: "slide",
		selector: ".slides > div", 
		directionNav: false,
		smoothHeight: true,
	});
	  
	var slides_special = ["economia", "aves", "monumentos", "riqueza", "malvinas"];
	
	for(var i = 0; i < slides_special.length; i++) {
		jQuery("#slide-" + slides_special[i] + "-thumbnails").html(jQuery("#slide-" + slides_special[i] + " .slides").clone());
		jQuery("#slide-" + slides_special[i] + "-thumbnails").flexslider({
			animation: "slide",
			selector: ".slides > div", 
			controlNav: false,
			animationLoop: false,
			slideshow: false,
			itemWidth: 150,
			itemMargin: 2,
			directionNav: true,
			asNavFor: "#slide-" + slides_special[i],
		});

		jQuery("#slide-" + slides_special[i] ).flexslider({
			selector: ".slides > div", 
			animation: "slide",
			controlNav: false,
			animationLoop: false,
			slideshow: false,
			smoothHeight: true,
			sync: "#slide-" + slides_special[i] + "-thumbnails",
		});	 
	 
	}
	
	// page: Espacio Tecnológico 
	jQuery("body.page-espacio-tecnologico fieldset p").hide();
	jQuery("body.page-espacio-tecnologico fieldset .mauticform-checkboxgrp-row").hide();
	jQuery("body.page-espacio-tecnologico legend").css("cursor","pointer");
	jQuery("body.page-espacio-tecnologico legend").append('<span class="arrow arrow-down"></span>');
	jQuery("body.page-espacio-tecnologico legend").on("click",function(){
		
		jQuery(this).next().slideToggle();

		if ( jQuery(this).children("span").hasClass("arrow-down") ) {
			  jQuery(this).children("span").addClass("arrow-left");
			  jQuery(this).children("span").removeClass("arrow-down");
		}
		else {
			jQuery(this).children("span").addClass("arrow-down");
			jQuery(this).children("span").removeClass("arrow-left");
		}
	});
	
});