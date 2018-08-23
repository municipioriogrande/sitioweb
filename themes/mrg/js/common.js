var CONTROLLER = (function() {
	var _debug = true;
	var _ready = false;
	var _load = false;
	var _DOMContentLoaded = false;
	var CLICK_TAP_EVENT_STRING 			= "click tap";
	var CLICK_TOUCH_EVENT_STRING 		= "click touch";
	var CLICK_TOUCHSTART_EVENT_STRING 	= "click touchstart";
	var NAVIGATOR = {WHITE:"WHITE", TRANSPARENT:"TRANSPARENT", STATE:false};

	function init() {
		if (_debug) console.log("init");
	}
	function ready() {
		if (_debug) console.log("ready");
		_ready = true;
		setNavigator(NAVIGATOR.TRANSPARENT);
	}
	function load() {
		if (_debug) console.log("load");
		_load = true;
	}
	
	function layout_update(){
		setHeightWidth('.box_pic_one_portrait','.box_text_one_portrait','height','','');
		//headerUpdate();
	}
	
	function DOMContentLoaded(){
		_DOMContentLoaded = true;
		layout_update();
	}
	
	function resize(){
		if (_load){
			layout_update();
		}
	}
	
	function scroll(){
		if (_load){
			layout_update();
			//setNavigatorMobile();
		}
	}
	
	//{ TOOLS
	/*function setNavigatorMobile(){
		var windowHeight = jQuery(window).scrollTop();
		if(windowHeight  > 80) {
			if (_debug) console.log('FIXED!!'+ windowHeight);
			jQuery('#main-header').css('top', '0px');
			jQuery('#main-header').css('position', 'fixed');
		}else if(windowHeight  < 1){
			if (_debug) console.log('ABSOLUTE!!'+ windowHeight);
			jQuery('#main-header').css('top', 'auto');
			jQuery('#main-header').css('position', 'absolute');
		}
		if (_debug) console.log('aplica:'+referenceHeight+'|'+conteiner);
	}*/
	
	function setHeightWidth(reference, destiny, type, valor, fix){
		if (valor!='' && fix!='')
		{
			if(type=='width')
			{
				if (valor=='-'){
					var the_reference = jQuery(reference).width()-fix;
				}else{
					var the_reference = jQuery(reference).width()+fix;
				}
			}
			else
			{
				if (valor=='-'){
					var the_reference = jQuery(reference).height()-fix;
				}else{
					var the_reference = jQuery(reference).height()+fix;
				}
			}
		}
		else
		{
			if(type=='width')
			{
				var the_reference = jQuery(reference).width();
			}
			else
			{
				var the_reference = jQuery(reference).height();
			}
		}
		
		var conteiner = jQuery(destiny);
		jQuery(conteiner).css('height', (the_reference));
		if (_debug) console.log('aplica:'+type+'|'+the_reference+'|'+conteiner+'|'+destiny);
	}
	
	function headerUpdate(){
		
		var header_height = jQuery("#main-header").height();
		if (_debug) console.log("header_height: "+header_height);
		
		var height = jQuery(window).scrollTop();
		var offset_point = jQuery("#slider_top").height() - header_height;
	
		if (_debug) console.log('SCROLL HEIGHT:'+height+' | '+offset_point);
		
		// WHITE
		if(height >= offset_point) {
			
			if (_debug) console.log('WHITE | HEIGHT:'+height);
			
			setNavigator(NAVIGATOR.WHITE);
			
		}else{// TRANSPARENT
			
			if (_debug) console.log('TRANSPARENT | HEIGHT:'+height);
			
			setNavigator(NAVIGATOR.TRANSPARENT);
		}
	}
	
		function setNavigator(state){
	
			if (state == NAVIGATOR.WHITE){
				
				if (NAVIGATOR.STATE != NAVIGATOR.WHITE){
					
					if (_debug) console.log('->WHITE');
					
					jQuery("#main-header").css("background-color","#fff");
					jQuery("#main-header #logo").attr("src", "/wp-content/uploads/2016/06/loglo_proyesco_green.png");
					jQuery("#top-menu li a").css("color","#006461");
					jQuery('#main-header').css('border-bottom', '1px solid #006461');
					jQuery('head').append('<style>.mobile_menu_bar:before{color:#006461 !important;}</style>');
					//jQuery('.et_header_style_split #et-top-navigation nav > ul > li > a').css("color","#006461 !important");
					
					NAVIGATOR.STATE = NAVIGATOR.WHITE;
				}
				
			} else if (NAVIGATOR.TRANSPARENT){
				
				if (NAVIGATOR.STATE != NAVIGATOR.TRANSPARENT){
					
					if (_debug) console.log('->TRANSPARENT');
					
					jQuery("#main-header").css("background-color","rgba(2, 2, 2, 0.11)");
					jQuery("#main-header #logo").attr("src", "/wp-content/uploads/2016/08/loglo_proyesco.png");
					jQuery("#top-menu li a").css("color","#ffffff");
					jQuery('#main-header').css('border-bottom', 'none');
					jQuery('head').append('<style>.mobile_menu_bar:before{color:#ffffff !important;}</style>');
					//jQuery('.et_header_style_split #et-top-navigation nav > ul > li > a').css("color","#ffffff !important");
					
					NAVIGATOR.STATE = NAVIGATOR.TRANSPARENT;
				}
			}

	}
	//} TOOLS
	
	return { 
		init:init,
		ready:ready,
		load:load,
		DOMContentLoaded:DOMContentLoaded,
		resize:resize,
		scroll:scroll
	};

})();




