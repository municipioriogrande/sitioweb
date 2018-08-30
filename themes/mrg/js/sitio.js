jQuery(document).ready(function() {
	
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