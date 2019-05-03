/**
 * @author     Garda Informatica <info@gardainformatica.it>
 * @copyright  Copyright (C) 2015 Garda Informatica. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-3.0.html  GNU General Public License version 3
 * @package    giWeather Wordpress Widget
 * @link       http://www.gardainformatica.it
 */


function GIWeatherWidget(giweather_element,options)
{
	
  giweather_element=jQuery(giweather_element);
	
	
	
  var self = this;
  var carousel_element = jQuery(".giw-fc-thumb-list-container", giweather_element);
  
  var giw_btns_element= jQuery(".giw-btns", giweather_element);
  var giw_btns = jQuery(".giw-btn", giw_btns_element);
  
  
  var giw_ts_btns_element= jQuery(".giw-ts-btns", giweather_element);
  var giw_ts_btns = jQuery(".giw-ts-btn", giw_ts_btns_element);
  
  var giw_arrow_left = jQuery(".giw-arrow-left", giweather_element);  
  var giw_arrow_right = jQuery(".giw-arrow-right", giweather_element);  

  var giwlist = jQuery(">div", carousel_element);
  var giwthumbs = jQuery(">div>div", carousel_element);

  var giwthumb_width = giwthumbs.first().outerWidth();
  var giwthumb_count = giwthumbs.length;
  
	giwlist.width(giwthumb_width*giwthumb_count);
  
  var num_visible_giwthumb=Math.ceil(carousel_element.width()/giwthumb_width);

  var px=0;
  
  var current_giwthumb = 0;

  this.setCurrentThumb=function(thumb){
		var num_to_slide=(carousel_element.width()/giwthumb_width)/2;

		var num_prev=thumb.prevAll().length;
		px=-num_prev*giwthumb_width-giwthumb_width*0.5+giwthumb_width*num_to_slide;
	  
		px=Math.round(px/giwthumb_width)*giwthumb_width;
		
		var ww=Math.floor(carousel_element.width()/giwthumb_width)*giwthumb_width;
		var minpx=ww-giwthumb_width*giwthumb_count;
		var maxpx=0;
		
		
		px=Math.max(px,minpx);
		px=Math.min(px,0);
		
		giwlist.css("left", px+"px");
		giwlist.addClass("animate");
	
		giwthumbs.removeClass('giw-fc-thumb-current');
		thumb.addClass('giw-fc-thumb-current');
		
		//setCurrentThumb
		jQuery('.giw-fc-current-date',giweather_element).text(jQuery('.giw-fc-thumb-day',thumb).text());
		jQuery('.giw-fc-current-desc',giweather_element).text(jQuery('.giw-fc-thumb-img',thumb).attr("title"));
		jQuery('.giw-fc-current-temp .giw-tc',giweather_element).text(jQuery('.giw-fc-thumb-perc-temp .giw-tc',thumb).text().slice(0, - 1));//max
		jQuery('.giw-fc-current-temp .giw-tf',giweather_element).text(jQuery('.giw-fc-thumb-perc-temp .giw-tf',thumb).text().slice(0, - 1));//max
		
		var el=jQuery('.giw-fc-thumb-humidity-val',thumb);
		if (el.length==1){
			jQuery('.giw-fc-cur-humidity > span',giweather_element).text(el.text());
			jQuery('.giw-fc-cur-humidity',giweather_element).show();
		}else{
			jQuery('.giw-fc-cur-humidity',giweather_element).hide();
		}
		
		var el_metric=jQuery('.giw-fc-thumb-pressure-val > .giw-metric',thumb);
		var el_imperial=jQuery('.giw-fc-thumb-pressure-val > .giw-imperial',thumb);
		if (el_metric.length==1){
			jQuery('.giw-fc-cur-pressure > span.giw-metric',giweather_element).text(el_metric.text());
			jQuery('.giw-fc-cur-pressure > span.giw-imperial',giweather_element).text(el_imperial.text());
			jQuery('.giw-fc-cur-pressure',giweather_element).show();
		}else{
			jQuery('.giw-fc-cur-pressure',giweather_element).hide();
		}
		
		el_metric=jQuery('.giw-fc-thumb-wind-val > .giw-metric',thumb);
		el_imperial=jQuery('.giw-fc-thumb-wind-val > .giw-imperial',thumb);
		if (el_metric.length==1){
			jQuery('.giw-fc-cur-wind > span.giw-metric',giweather_element).text(el_metric.text());
			jQuery('.giw-fc-cur-wind > span.giw-imperial',giweather_element).text(el_imperial.text());
			jQuery('.giw-fc-cur-wind',giweather_element).show();
		}else{
			jQuery('.giw-fc-cur-wind',giweather_element).hide();
		}
		
		var full_img=jQuery('.giw-fc-full-img',thumb).clone();
		full_img.removeClass('giw-fc-full-img');
		full_img.addClass('giw-fc-current-icon');
		
		jQuery('.giw-fc-current-icon',giweather_element).replaceWith(full_img);
		
		
	}


  var hc=new Hammer(carousel_element[0]);
  hc.get('pan').set({ direction: Hammer.DIRECTION_HORIZONTAL });
  hc.on("panleft panright panend pancancel tap", function (ev){
    switch(ev.type) {
      case 'panend':
      case 'pancancel':
		//console.log("end"+ev.deltaX+" vel"+ev.velocityX);
		px=px+ev.deltaX;
		px=Math.round(px/giwthumb_width)*giwthumb_width;
		
		var ww=Math.floor(carousel_element.width()/giwthumb_width)*giwthumb_width;
		var minpx=ww-giwthumb_width*giwthumb_count;
		var maxpx=0;
		
		
		px=Math.max(px,minpx);
		px=Math.min(px,0);
		
		giwlist.css("left", px+"px");
	    giwlist.addClass("animate");
		break;
      case 'panleft':
      case 'panright':
	  //console.log("pan"+ev.deltaX+" vel"+ev.velocityX);
		//break;
		var tmpx=px+ev.deltaX;
		
		var ww=Math.floor(carousel_element.width()/giwthumb_width)*giwthumb_width;
		var minpx=ww-giwthumb_width*giwthumb_count;
		var maxpx=0;
		
		if (tmpx<minpx){
			tmpx=minpx+(tmpx-minpx)*0.3;
		}else if (tmpx>maxpx){
			tmpx=maxpx+(tmpx-maxpx)*0.3;
		}
		
	    giwlist.removeClass("animate");
		giwlist.css("left", (tmpx)+"px");
		
        break;
      case 'tap':
	  
			var thumb=jQuery(ev.target).closest('.giw-fc-thumb');
			if (thumb.length==1){
				self.setCurrentThumb(thumb);
			}
			
			
	  
		break;

    }	  
  });
  

  
  this.setBtnView=function(btn){
	giw_btns.removeClass('giw-btn-clicked');
	giw_btns.addClass('giw-btn-notclicked');
	btn.addClass('giw-btn-clicked');
	btn.removeClass('giw-btn-notclicked');
	
	if (btn.hasClass('giw-btn-temp')){
		jQuery('.giw-fc-thumb-temp-hist',giwthumbs).show();
		jQuery('.giw-fc-thumb-wind',giwthumbs).hide();
	}else{
		jQuery('.giw-fc-thumb-temp-hist',giwthumbs).hide();
		jQuery('.giw-fc-thumb-wind',giwthumbs).show();
	}
	  
  }
  
  
  var hb=new Hammer(giw_btns_element[0]);
  hb.on("tap", function(ev){
	  
		var btn=jQuery(ev.target).closest('.giw-btn');
		if (btn.length==1){
			self.setBtnView(btn);
		}
  });
  
  this.setTemperatureScaleBtnView=function(btn){
	giw_ts_btns.removeClass('giw-ts-btn-active');
	btn.addClass('giw-ts-btn-active');
	
	if (btn.hasClass('giw-ts-btn-celsius')){
		jQuery('.giw-imperial',giweather_element).hide();
		jQuery('.giw-metric',giweather_element).show();
		jQuery('.giw-tf',giweather_element).hide();
		jQuery('.giw-tc',giweather_element).show();
	}else{
		jQuery('.giw-imperial',giweather_element).show();
		jQuery('.giw-metric',giweather_element).hide();
		jQuery('.giw-tf',giweather_element).show();
		jQuery('.giw-tc',giweather_element).hide();
	}
	  
  }
  
  var ht=new Hammer(giw_ts_btns_element[0]);
  ht.on("tap", function(ev){
	  
		var btn=jQuery(ev.target).closest('.giw-ts-btn');
		if (btn.length==1){
			self.setTemperatureScaleBtnView(btn);
		}
  });
  
  this.prevOrNext=function(is_prev){
		
		var num_visible_thumb=Math.floor(carousel_element.width()/giwthumb_width);
		
		var num_to_slide=Math.max(Math.floor(num_visible_thumb/2),1);
		
		var ww=num_visible_thumb*giwthumb_width;
		var minpx=ww-giwthumb_width*giwthumb_count;
		var maxpx=0;
		
	  deltax=-num_to_slide*giwthumb_width;
	  if (is_prev){
		  //prev
		  deltax=deltax*-1;;
	  }
	  
		px=px+deltax;
		px=Math.round(px/giwthumb_width)*giwthumb_width;
		
		px=Math.max(px,minpx);
		px=Math.min(px,0);
		
		giwlist.css("left", px+"px");
		giwlist.addClass("animate");
	  
  }
  
  var hl=new Hammer(giw_arrow_left[0]);
  hl.on("tap", function(ev){
		//left
		self.prevOrNext(true);
  });
  
  var hr=new Hammer(giw_arrow_right[0]);
  hr.on("tap", function(ev){
		//right
		self.prevOrNext(false);
  });
  
  self.setCurrentThumb(jQuery('.giw-fc-thumb:first',giwlist));
  self.setBtnView(jQuery('.giw-btn-temp',giw_btns_element));
  
  if (options['unitofmeasure']=='metric'){
	self.setTemperatureScaleBtnView(jQuery('.giw-ts-btn-celsius',giw_ts_btns_element));
  }else{
	self.setTemperatureScaleBtnView(jQuery('.giw-ts-btn-fahrenheit',giw_ts_btns_element));
  }
  
  if (!options['show_head_details']){
	   jQuery('.giw-fc-current-city',giweather_element).hide();
	   jQuery('.giw-fc-current-date',giweather_element).hide();
	   jQuery('.giw-fc-current-desc',giweather_element).hide();
	   
	   jQuery('.giw-fc-current-main',giweather_element).css('padding-top',0);
  }
  if (!options['show_right_details']){
	  jQuery('.giw-fc-current-right',giweather_element).hide();
  }
  if (!options['show_forecasts']){
	  jQuery('.giw-fc-thumb-list-pane',giweather_element).hide();
  }
  if (!options['show_forecasts_tempwind']){
	  jQuery('.giw-fc-thumb-temp',giweather_element).hide();
	  jQuery('.giw-fc-thumb-wind',giweather_element).hide();
	  jQuery('.giw-fc-thumb-temp-hist',giweather_element).hide();
	  jQuery('.giw-btns',giweather_element).hide();
  }
  
	
	
  var list_height=jQuery('.giw-fc-thumb-list',giweather_element).outerHeight(true);
  
  
  
  var arrow_height=jQuery('.giw-arrow:first',giweather_element).outerHeight();

  jQuery('.giw-fc-thumb-list-pane',giweather_element).height(list_height);
  
  var arrow_top=(list_height-arrow_height)/2;
  jQuery('.giw-arrow',giweather_element).css('top',arrow_top+'px');
  
  /*
  if (options['show_mode']=='full'){
	  //all displayed
  }else if (options['show_mode']=='no_thumbs'){
	  jQuery('.giw-fc-thumb-list-pane',giweather_element).hide();
	  jQuery('.giw-btns',giweather_element).hide();
  }else if (options['show_mode']=='minimal'){
	  jQuery('.giw-fc-thumb-list-pane',giweather_element).hide();
	  jQuery('.giw-fc-current-right',giweather_element).hide();
  }
  */
    
  var initial_width=giweather_element.outerWidth();
  
  
	jQuery(window).on("load resize orientationchange", function() {
	  var list_width = jQuery('.giw-fc-thumb-list',giweather_element).width();
	  var list_container_width = jQuery('.giw-fc-thumb-list-pane',giweather_element).width();
	  if (list_width<=list_container_width){
		  jQuery('.giw-fc-thumb-list-container',giweather_element).css('left','0');
		  jQuery('.giw-fc-thumb-list-container',giweather_element).css('right','0');
		  jQuery('.giw-arrow',giweather_element).hide();
	  }else{
		  jQuery('.giw-fc-thumb-list-container',giweather_element).css('left','28px');
		  jQuery('.giw-fc-thumb-list-container',giweather_element).css('right','28px');
		  jQuery('.giw-arrow',giweather_element).show();
	  }


		//aggiusto il px!
		px=Math.round(px/giwthumb_width)*giwthumb_width;
		
		var ww=Math.floor(carousel_element.width()/giwthumb_width)*giwthumb_width;
		var minpx=ww-giwthumb_width*giwthumb_count;
		var maxpx=0;
		
		
		px=Math.max(px,minpx);
		px=Math.min(px,0);
		
		giwlist.css("left", px+"px");
	    giwlist.addClass("animate");
		
		  if (options['widget_align']=='right'){
				var container_width=giweather_element.parent().width();
				
				var margin_left=Math.max(container_width-initial_width,0);
				giweather_element.css("margin-left",margin_left+"px");
				
		  }
		
		
		
		
	}).resize();
  
  
}


