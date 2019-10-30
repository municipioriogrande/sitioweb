function popUp(url,ancho,alto,id,extras){
	if(navigator.userAgent.indexOf("Mac")>0){ancho=parseInt(ancho)+15;alto=parseInt(alto)+15;}
	var left = (screen.availWidth-ancho)/2;
	var top = (screen.availHeight-alto)/2;
	if(extras!=""){extras=","+extras;};
	var ventana = window.open(url,id,'width='+ancho+',height='+alto+',left='+left+',top='+top+',screenX='+left+',screenY='+top+extras);
	var bloqueado = "AVISO:\n\nPara ver este contenido es necesario que desactive\nel Bloqueo de Ventanas para este Sitio."
	if(ventana==null || typeof(ventana.document)=="undefined"){ alert(bloqueado) }else{ return ventana; };
}

function share(destiny, title, subtitulo, imagen, urls)
{
	if(imagen!=''){
		img = encodeURIComponent(imagen);
	}else{
		img = '';
	}
	if(subtitulo!=''){
		subtitle = encodeURIComponent(subtitulo);
	}else{
		subtitle ='';
	}
	
	if(title!=''){
		titulo = encodeURIComponent(title);
	}else{
		titulo ='';
	}
	
	if(urls!=''){
		url = encodeURIComponent(urls);
	}else{
		url ='';
	}
	
	if(destiny=='facebook')
	{
		popUp('http://www.facebook.com/sharer.php?s=100&p[url]='+url+'&p[title]='+title+'&p[images][0]='+img+'&p[summary][0]='+subtitle+'&','600','400','pop_facebook','toolbar=no,menubar=no,status=no,scrollbars=yes,resizable=no,location=no,left=250,top=70');
	}
	else if(destiny=='twitter')
	{
		popUp('http://twitter.com/share?original_referer='+url+'&text='+title+'&','500','400','pop_twitter','toolbar=no,menubar=no,status=no,scrollbars=yes,resizable=no,location=no,left=250,top=70');
	}
	else if(destiny=='pinterest')
	{
		popUp('http://www.pinterest.com/pin/create/button/?url='+url+'&media='+img+'&description='+titulo+'&','500','400','pop_pinterest','toolbar=no,menubar=no,status=no,scrollbars=yes,resizable=no,location=no,left=250,top=70');
	}
	else if(destiny=='email')
	{
		document.location.href = "mailto:?subject=<?php echo $site_language[$session_language]['social']['email_subject']; ?>&body=<?php echo $site_language[$session_language]['social']['email_body']; ?> "+url+"";
	}
	
};
window.addEventListener('DOMContentLoaded', function() {
	jQuery(document).on('mouseenter', '.social',  function(){
		jQuery(this).find('.social-buttons').toggleClass('open');
		return false;
	}).on('mouseleave', '.social', function() {
		jQuery(this).find('.social-buttons').toggleClass('open');
		return false;
	});
});