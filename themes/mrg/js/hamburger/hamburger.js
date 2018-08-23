jQuery(document).ready(function(e) {
	
	var status_menu = false;
	
	var mozillaPresente = false,
	    mozilla = (function detectarNavegador(navegador) {
		if(navegador.indexOf("Firefox") != -1 ) {
			mozillaPresente = true;
		}	
	})(navigator.userAgent);
	function darEfecto(efecto) {
		el = jQuery('.cajainterna');
		el.addClass(efecto);
		el.one('webkitAnimationEnd oanimationend msAnimationEnd animationend',
		function (e) {
			el.removeClass(efecto);
		});
	}
	function mostrar(e) {
		jQuery(".cajaexterna").show();
		jQuery("body").addClass("overflowHidden");
		darEfecto("fadeIn"); 
		status_menu = true;     
	}
	function ocultar() {
		jQuery("body").removeClass("overflowHidden");
		jQuery(".cajaexterna").fadeOut("fast", function() {
			if(mozillaPresente) {
			setTimeout(function() {
				jQuery(".cajainterna").removeClass("fadeIn");
			}, 5);
		}
		});	
		status_menu = false;		
	}
	/*jQuery("a.mostrarmodal").click(mostrar);
	jQuery("a.cerrarmodal").click(ocultar);*/
	function eventHandler(event, selector) {
		event.stopPropagation();
		event.preventDefault();
		if (event.type === 'touchend') selector.off('click');
	}
	
	
	jQuery(".hamburger").on('touchend click', function(event) {
		eventHandler(event, jQuery(this));
		if(status_menu == false)
		  {
			  mostrar();
			  jQuery(".hamburger").addClass("is-active");
		  }
		  else
		  {
			  ocultar();
			  jQuery(".hamburger").removeClass("is-active");
		  }
		
	});
	
	jQuery("a.mostrarmodal").on('touchend click', function(event) {
		eventHandler(event, jQuery(this));
		mostrar();
		jQuery(".hamburger").addClass("is-active");
	});
	jQuery("a.cerrarmodal").on('touchend click', function(event) {
		eventHandler(event, jQuery(this));
		ocultar();
		jQuery(".hamburger").removeClass("is-active");
	});
	
}); 