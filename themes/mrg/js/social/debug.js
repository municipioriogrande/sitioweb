/* Debug */
function dump(o,func)
{
	var str = "";
	for(p in o)
	{
		if(typeof o[p]!='function' || func){
			str += "\t" + p + " => " + o[p] + "\r\n";
		}
	}
	str = "(" + typeof(o) + ") " + o + " \r\n{\r\n" + str + "}";
	return str;
}

function pr(o,nombre, func)
{
	func 			= func == true;
	nombre          = (typeof(nombre) == "undefined") ? "Debug" : nombre ;
	var hw          = popup('', nombre , 600, 600, 'yes', 'yes');
	var htmlDump    = dump(o,func).replace(/<(\/)?script/gi,'< $1script');
	var htmlDoc     = '<html><body><pre style="font: 13px \'Courier New\'">'+htmlDump+'</pre></body></html>'
	hw.document.open();
	hw.document.write(htmlDoc);
	hw.document.close();
}

function popup(url, name, width, height, isResizable, hasScrollbars, hasToolbar, hasMenubar, hasStatus)
{
	isResizable   = typeof(isResizable)   =='undefined' ? 'no'  :isResizable;
	hasScrollbars = typeof(hasScrollbars) =='undefined' ? 'auto':hasScrollbars;
	hasToolbar    = typeof(hasToolbar)    =='undefined' ? 'no'  :hasToolbar;
	hasMenubar    = typeof(hasMenubar)    =='undefined' ? 'no'  :hasMenubar;
	hasStatus     = typeof(hasStatus)     =='undefined' ? 'yes' :hasStatus;

	var top = (screen.height - height) / 2;
	var left = (screen.width - width) / 2;
	var settings = 'width='+width+', height='+height+', top='+top+', left='+left+', resizable='+isResizable+', scrollbars='+hasScrollbars+', toolbar='+hasToolbar+', menubar='+hasMenubar+', status='+hasStatus;
	return window.open(url, name, settings);
}
/* Fin Debug */