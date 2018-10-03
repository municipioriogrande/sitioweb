jQuery(document).ready(function() {
	// page: congreso 
	jQuery("body.page-1er-congreso-internacional-educacion-e-inclusion-desde-el-sur .accordion .mesas-container").hide();
	jQuery("body.page-1er-congreso-internacional-educacion-e-inclusion-desde-el-sur .accordion .time").css("cursor","pointer");
	jQuery("body.page-1er-congreso-internacional-educacion-e-inclusion-desde-el-sur .accordion .time").append('<span class="arrow arrow-down"></span>');
	jQuery("body.page-1er-congreso-internacional-educacion-e-inclusion-desde-el-sur .accordion .time").on("click",function(){
		
		jQuery(this).next().slideToggle();
			//alert(jQuery(this).children("arrow"));
		if ( jQuery(this).children("span").hasClass("arrow-down") ) {
			jQuery(this).children("span").addClass("arrow-left");
			jQuery(this).children("span").removeClass("arrow-down");
		}
		else {
			jQuery(this).children("span").addClass("arrow-down");
			jQuery(this).children("span").removeClass("arrow-left");
		}
	});
	
	jQuery("body.page-1er-congreso-internacional-educacion-e-inclusion-desde-el-sur .profesionales-videos video").css("display","none");
	
	
	
	
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
	
	
});