jQuery.validator.setDefaults({
	submitHandler: function() {
		document.getElementById("form_consultar").submit();
	}
});

jQuery().ready(function() {
	jQuery("#form_consultar").validate({
		rules: {
			consulta: {
				required: true,
				minlength: 5,
			},
		},
		messages: {
			consulta: {
				required: "Por favor ingrese palabra a buscar",
				minlength: "Tiene que ingresar por lo menos 5 caracteres",
			},
		}
	});
});