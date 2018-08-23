jQuery('#datein, #dateout').datepicker({
	dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
	monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
    dateFormat:'mm/dd/yy',
    numberOfMonths: 1,
    onSelect: function(){
    	var myDate = new Date(this.value);
    	var myDateRaw = myDate.setDate(myDate.getDate());
    	jQuery('#'+jQuery(this).attr('id')+'_raw').attr('value', myDateRaw);
    }
});