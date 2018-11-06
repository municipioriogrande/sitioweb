<?php 

/*
Plugin Name: Río Grande plugin
Description: Agrega funcionalidad extra para el sitio
*/

//include('form-submissions-check.php');

add_action( 'after_setup_theme', 'crb_load' );
function crb_load() {
    require_once( 'vendor/autoload.php' );
    \Carbon_Fields\Carbon_Fields::boot();
}


include "centros-salud.php";





// remove comments option
add_action( 'admin_menu', 'my_remove_admin_menus' );
function my_remove_admin_menus() {
	remove_menu_page( 'edit-comments.php' );
}

// Removes from post and pages
add_action('init', 'remove_comment_support', 100);
function remove_comment_support() {
	remove_post_type_support( 'post', 'comments' );
	remove_post_type_support( 'page', 'comments' );
}
// Removes from admin bar
add_action( 'wp_before_admin_bar_render', 'mytheme_admin_bar_render' );
function mytheme_admin_bar_render() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('comments');
}








// Add Shortcode
function mautic_form_edlt_info_shortcode() {

	return '
	<script type="text/javascript">
    /** This section is only needed once per page if manually copying **/
    if (typeof MauticSDKLoaded == "undefined") {
        var MauticSDKLoaded = true;
        var head            = document.getElementsByTagName("head")[0];
        var script          = document.createElement("script");
        script.type         = "text/javascript";
        script.src          = "https://mautic.dir.riogrande.gob.ar/media/js/mautic-form.js";
        script.onload       = function() {
            MauticSDK.onLoad();
        };
        head.appendChild(script);
        var MauticDomain = "https://mautic.dir.riogrande.gob.ar";
        var MauticLang   = {
            "submittingMessage": "Por favor espere..."
        }
    }
</script>

	
	
	<style type="text/css" scoped>
	 
	.mauticform-input {
		width:100% !important;
	}

	.form-subscribe .row {
		justify-content: space-between;
	}

	.mauticform_wrapper_edltinformacioncursos {
		font-size: 0.9em;
	}
	
	.mauticform_wrapper_edltinformacioncursos .row #mauticform_edltinformacioncursos_nombre,
	.mauticform_wrapper_edltinformacioncursos .row #mauticform_edltinformacioncursos_apellido {
		width: 50%;
	}
	
	.mauticform-message {
		font-size: 1.4em;
		text-align: center;
		padding-top: 1em;
	}
</style>


<div id="mauticform_wrapper_edltinformacioncursos" class="mauticform_wrapper">

   <form autocomplete="false" role="form" method="post" action="https://mautic.dir.riogrande.gob.ar/form/submit?formId=2" id="mauticform_edltinformacioncursos"  data-mautic-form="edltinformacioncursos" enctype="multipart/form-data" class="form-subscribe">
		
		<h3>Recibí novedades sobre nuestras capacitaciones</h3>

		
      <div class="mauticform-innerform">
         <div class="mauticform-page-wrapper mauticform-page-1" data-mautic-form-page="1">
			 
				<div class="row cols">			 
					<div id="mauticform_edltinformacioncursos_nombre" class="mauticform-row mauticform-text mauticform-field-1 mauticform-required" data-validate="nombre" data-validation-type="text">
						<label id="mauticform_label_edltinformacioncursos_nombre" for="mauticform_input_edltinformacioncursos_nombre" class="mauticform-label">Nombre</label> <input id="mauticform_input_edltinformacioncursos_nombre" name="mauticform[nombre]" value="" placeholder="Nombre" class="mauticform-input" type="text" />
						<span class="mauticform-errormsg" style="display: none;">Es obligatorio</span>
					</div>

					<div id="mauticform_edltinformacioncursos_apellido" class="mauticform-row mauticform-text mauticform-field-2">
						 <label id="mauticform_label_edltinformacioncursos_apellido" for="mauticform_input_edltinformacioncursos_apellido" class="mauticform-label">Apellido</label> <input id="mauticform_input_edltinformacioncursos_apellido" name="mauticform[apellido]" value="" placeholder="Apellido" class="mauticform-input" type="text" />
						 <span class="mauticform-errormsg" style="display: none;"></span>
					</div>
            </div>

            <div id="mauticform_edltinformacioncursos_email"  data-validate="email" data-validation-type="email" class="mauticform-row mauticform-email mauticform-field-3 mauticform-required row">
                <label id="mauticform_label_edltinformacioncursos_email" for="mauticform_input_edltinformacioncursos_email" class="mauticform-label">Email</label> <input id="mauticform_input_edltinformacioncursos_email" name="mauticform[email]" value="" placeholder="hola@email.com" class="mauticform-input" type="email" />
                <span class="mauticform-errormsg" style="display: none;">Es obligatorio</span>
            </div>

            <div id="mauticform_edltinformacioncursos_telefono"  data-validate="telefono" data-validation-type="tel" class="mauticform-row mauticform-tel mauticform-field-4 mauticform-required row">
                <label id="mauticform_label_edltinformacioncursos_telefono" for="mauticform_input_edltinformacioncursos_telefono" class="mauticform-label">Teléfono</label> <input id="mauticform_input_edltinformacioncursos_telefono" name="mauticform[telefono]" value="" placeholder="2964 444 444" class="mauticform-input" type="tel" />
                <span class="mauticform-errormsg" style="display: none;">Es obligatorio</span>
            </div>

            <div id="mauticform_edltinformacioncursos_elegi_la_categoria_de_cur"  class="mauticform-row mauticform-freetext mauticform-field-5">    
                <h3 id="mauticform_label_edltinformacioncursos_elegi_la_categoria_de_cur" for="mauticform_input_edltinformacioncursos_elegi_la_categoria_de_cur" class="mauticform-label"> </h3>
                <div id="mauticform_input_edltinformacioncursos_elegi_la_categoria_de_cur" name="mauticform[elegi_la_categoria_de_cur]" value="" class="mauticform-freetext">
                    Elegí la categoría de curso de interés
                </div>
            </div>

            <fieldset id="mauticform_edltinformacioncursos_ciudad_moderna"  class="mauticform-row mauticform-checkboxgrp mauticform-field-6 expand-sub-items">
                <legend  class="mauticform-label" >Ciudad moderna</legend>
					 
                <div class="mauticform-checkboxgrp-row">
                    <label id="mauticform_checkboxgrp_label_ciudad_moderna_Alfabetizaciondigital0" for="mauticform_checkboxgrp_checkbox_ciudad_moderna_Alfabetizaciondigital0"  class="mauticform-checkboxgrp-label">
                        <input  class="mauticform-checkboxgrp-checkbox" name="mauticform[ciudad_moderna][]" id="mauticform_checkboxgrp_checkbox_ciudad_moderna_Alfabetizaciondigital0" type="checkbox" value="Alfabetización digital" /> Alfabetización digital
                    </label>

                    <label id="mauticform_checkboxgrp_label_ciudad_moderna_Aprendeausartucelular1" for="mauticform_checkboxgrp_checkbox_ciudad_moderna_Aprendeausartucelular1"  class="mauticform-checkboxgrp-label">
                        <input  class="mauticform-checkboxgrp-checkbox" name="mauticform[ciudad_moderna][]" id="mauticform_checkboxgrp_checkbox_ciudad_moderna_Aprendeausartucelular1" type="checkbox" value="Aprende a usar tu celular" /> Aprende a usar tu celular
                    </label>

                    <label id="mauticform_checkboxgrp_label_ciudad_moderna_Teletrabajo2" for="mauticform_checkboxgrp_checkbox_ciudad_moderna_Teletrabajo2"  class="mauticform-checkboxgrp-label">
                        <input  class="mauticform-checkboxgrp-checkbox" name="mauticform[ciudad_moderna][]" id="mauticform_checkboxgrp_checkbox_ciudad_moderna_Teletrabajo2" type="checkbox" value="Teletrabajo" /> Teletrabajo
                    </label>

                    <label id="mauticform_checkboxgrp_label_ciudad_moderna_Monotributo3" for="mauticform_checkboxgrp_checkbox_ciudad_moderna_Monotributo3"  class="mauticform-checkboxgrp-label">
                        <input  class="mauticform-checkboxgrp-checkbox" name="mauticform[ciudad_moderna][]" id="mauticform_checkboxgrp_checkbox_ciudad_moderna_Monotributo3" type="checkbox" value="Monotributo" /> Monotributo
                    </label>
                </div>
                <span class="mauticform-errormsg" style="display: none;"></span>
            </fieldset>

            <fieldset id="mauticform_edltinformacioncursos_actividades_para_chicos_y"  class="mauticform-row mauticform-checkboxgrp mauticform-field-7 expand-sub-items">
               <legend  class="mauticform-label" for="mauticform_checkboxgrp_checkbox_actividades_para_chicos_y_Programacionparaninos1">Actividades para chicos y jóvenes</legend>
               <div class="mauticform-checkboxgrp-row">
                    <label id="mauticform_checkboxgrp_label_actividades_para_chicos_y_Programacionparaninos0" for="mauticform_checkboxgrp_checkbox_actividades_para_chicos_y_Programacionparaninos0"  class="mauticform-checkboxgrp-label">
                        <input  class="mauticform-checkboxgrp-checkbox" name="mauticform[actividades_para_chicos_y][]" id="mauticform_checkboxgrp_checkbox_actividades_para_chicos_y_Programacionparaninos0" type="checkbox" value="Programación para niños" /> Programación para niños
                    </label>

						  
                    <label id="mauticform_checkboxgrp_label_actividades_para_chicos_y_ElectronicayRoboticaparaninos1" for="mauticform_checkboxgrp_checkbox_actividades_para_chicos_y_ElectronicayRoboticaparaninos1"  class="mauticform-checkboxgrp-label">
                        <input  class="mauticform-checkboxgrp-checkbox" name="mauticform[actividades_para_chicos_y][]" id="mauticform_checkboxgrp_checkbox_actividades_para_chicos_y_ElectronicayRoboticaparaninos1" type="checkbox" value="Electrónica y Robótica para niños" /> Electrónica y Robótica para niños
                    </label>

						  
                    <label id="mauticform_checkboxgrp_label_actividades_para_chicos_y_ElectronicayRoboticaparajovenes2" for="mauticform_checkboxgrp_checkbox_actividades_para_chicos_y_ElectronicayRoboticaparajovenes2"  class="mauticform-checkboxgrp-label">
                        <input  class="mauticform-checkboxgrp-checkbox" name="mauticform[actividades_para_chicos_y][]" id="mauticform_checkboxgrp_checkbox_actividades_para_chicos_y_ElectronicayRoboticaparajovenes2" type="checkbox" value="Electrónica y Robótica para jóvenes" /> Electrónica y Robótica para jóvenes
                    </label>

						  
                    <label id="mauticform_checkboxgrp_label_actividades_para_chicos_y_Desarrollodevideojuegos3" for="mauticform_checkboxgrp_checkbox_actividades_para_chicos_y_Desarrollodevideojuegos3"  class="mauticform-checkboxgrp-label">
                        <input  class="mauticform-checkboxgrp-checkbox" name="mauticform[actividades_para_chicos_y][]" id="mauticform_checkboxgrp_checkbox_actividades_para_chicos_y_Desarrollodevideojuegos3" type="checkbox" value="Desarrollo de videojuegos" /> Desarrollo de videojuegos
                    </label>

						  
                    <label id="mauticform_checkboxgrp_label_actividades_para_chicos_y_Artedigital4" for="mauticform_checkboxgrp_checkbox_actividades_para_chicos_y_Artedigital4"  class="mauticform-checkboxgrp-label">
                        <input  class="mauticform-checkboxgrp-checkbox" name="mauticform[actividades_para_chicos_y][]" id="mauticform_checkboxgrp_checkbox_actividades_para_chicos_y_Artedigital4" type="checkbox" value="Arte digital" /> Arte digital
                    </label>
                </div>
                <span class="mauticform-errormsg" style="display: none;"></span>
            </fieldset>

            <fieldset id="mauticform_edltinformacioncursos_oficios_tradicionales"  class="mauticform-row mauticform-checkboxgrp mauticform-field-8 expand-sub-items">
                <legend  class="mauticform-label" for="mauticform_checkboxgrp_checkbox_oficios_tradicionales_Pinturadeobra1">Oficios tradicionales</legend>
                <div class="mauticform-checkboxgrp-row">
                    <label id="mauticform_checkboxgrp_label_oficios_tradicionales_Pinturadeobra0" for="mauticform_checkboxgrp_checkbox_oficios_tradicionales_Pinturadeobra0"  class="mauticform-checkboxgrp-label">
                        <input  class="mauticform-checkboxgrp-checkbox" name="mauticform[oficios_tradicionales][]" id="mauticform_checkboxgrp_checkbox_oficios_tradicionales_Pinturadeobra0" type="checkbox" value="Pintura de obra" /> Pintura de obra
                    </label>

						  
                    <label id="mauticform_checkboxgrp_label_oficios_tradicionales_Electricidad1" for="mauticform_checkboxgrp_checkbox_oficios_tradicionales_Electricidad1"  class="mauticform-checkboxgrp-label">
                        <input  class="mauticform-checkboxgrp-checkbox" name="mauticform[oficios_tradicionales][]" id="mauticform_checkboxgrp_checkbox_oficios_tradicionales_Electricidad1" type="checkbox" value="Electricidad" /> Electricidad
                    </label>

						  
                    <label id="mauticform_checkboxgrp_label_oficios_tradicionales_Aguaysanitarista2" for="mauticform_checkboxgrp_checkbox_oficios_tradicionales_Aguaysanitarista2"  class="mauticform-checkboxgrp-label">
                        <input  class="mauticform-checkboxgrp-checkbox" name="mauticform[oficios_tradicionales][]" id="mauticform_checkboxgrp_checkbox_oficios_tradicionales_Aguaysanitarista2" type="checkbox" value="Agua y sanitarista" /> Agua y sanitarista
                    </label>

						  
                    <label id="mauticform_checkboxgrp_label_oficios_tradicionales_SteelFraming3" for="mauticform_checkboxgrp_checkbox_oficios_tradicionales_SteelFraming3"  class="mauticform-checkboxgrp-label">
                        <input  class="mauticform-checkboxgrp-checkbox" name="mauticform[oficios_tradicionales][]" id="mauticform_checkboxgrp_checkbox_oficios_tradicionales_SteelFraming3" type="checkbox" value="Steel Framing" /> Steel Framing
                    </label>

						  
                    <label id="mauticform_checkboxgrp_label_oficios_tradicionales_Mecanicademotos4" for="mauticform_checkboxgrp_checkbox_oficios_tradicionales_Mecanicademotos4"  class="mauticform-checkboxgrp-label">
                        <input  class="mauticform-checkboxgrp-checkbox" name="mauticform[oficios_tradicionales][]" id="mauticform_checkboxgrp_checkbox_oficios_tradicionales_Mecanicademotos4" type="checkbox" value="Mecánica de motos" /> Mecánica de motos
                    </label>

						  
                    <label id="mauticform_checkboxgrp_label_oficios_tradicionales_Reboquesenlucidos5" for="mauticform_checkboxgrp_checkbox_oficios_tradicionales_Reboquesenlucidos5"  class="mauticform-checkboxgrp-label">
                        <input  class="mauticform-checkboxgrp-checkbox" name="mauticform[oficios_tradicionales][]" id="mauticform_checkboxgrp_checkbox_oficios_tradicionales_Reboquesenlucidos5" type="checkbox" value="Reboques enlucidos" /> Reboques enlucidos
                    </label>

						  
                    <label id="mauticform_checkboxgrp_label_oficios_tradicionales_Soldadura6" for="mauticform_checkboxgrp_checkbox_oficios_tradicionales_Soldadura6"  class="mauticform-checkboxgrp-label">
                        <input  class="mauticform-checkboxgrp-checkbox" name="mauticform[oficios_tradicionales][]" id="mauticform_checkboxgrp_checkbox_oficios_tradicionales_Soldadura6" type="checkbox" value="Soldadura" /> Soldadura
                    </label>
                </div>
                <span class="mauticform-errormsg" style="display: none;"></span>
            </fieldset>

            <fieldset id="mauticform_edltinformacioncursos_oficios_tecnologicos"  class="mauticform-row mauticform-checkboxgrp mauticform-field-9 expand-sub-items">
                <legend  class="mauticform-label" for="mauticform_checkboxgrp_checkbox_oficios_tecnologicos_Programacion1">Oficios tecnológicos</legend>
                <div class="mauticform-checkboxgrp-row">
                    <label id="mauticform_checkboxgrp_label_oficios_tecnologicos_Programacion0" for="mauticform_checkboxgrp_checkbox_oficios_tecnologicos_Programacion0"  class="mauticform-checkboxgrp-label">
                        <input  class="mauticform-checkboxgrp-checkbox" name="mauticform[oficios_tecnologicos][]" id="mauticform_checkboxgrp_checkbox_oficios_tecnologicos_Programacion0" type="checkbox" value="Programación" /> Programación
                    </label>

						  
                    <label id="mauticform_checkboxgrp_label_oficios_tecnologicos_DiagnosticoyreparaciondePC1" for="mauticform_checkboxgrp_checkbox_oficios_tecnologicos_DiagnosticoyreparaciondePC1"  class="mauticform-checkboxgrp-label">
                        <input  class="mauticform-checkboxgrp-checkbox" name="mauticform[oficios_tecnologicos][]" id="mauticform_checkboxgrp_checkbox_oficios_tecnologicos_DiagnosticoyreparaciondePC1" type="checkbox" value="Diagnóstico y reparación de PC" /> Diagnóstico y reparación de PC
                    </label>

						  
                    <label id="mauticform_checkboxgrp_label_oficios_tecnologicos_Autocad2" for="mauticform_checkboxgrp_checkbox_oficios_tecnologicos_Autocad2"  class="mauticform-checkboxgrp-label">
                        <input  class="mauticform-checkboxgrp-checkbox" name="mauticform[oficios_tecnologicos][]" id="mauticform_checkboxgrp_checkbox_oficios_tecnologicos_Autocad2" type="checkbox" value="Autocad" /> Autocad
                    </label>

						  
                    <label id="mauticform_checkboxgrp_label_oficios_tecnologicos_Disenoweb3" for="mauticform_checkboxgrp_checkbox_oficios_tecnologicos_Disenoweb3"  class="mauticform-checkboxgrp-label">
                        <input  class="mauticform-checkboxgrp-checkbox" name="mauticform[oficios_tecnologicos][]" id="mauticform_checkboxgrp_checkbox_oficios_tecnologicos_Disenoweb3" type="checkbox" value="Diseño web" /> Diseño web
                    </label>

						  
                    <label id="mauticform_checkboxgrp_label_oficios_tecnologicos_PaqueteOffice4" for="mauticform_checkboxgrp_checkbox_oficios_tecnologicos_PaqueteOffice4"  class="mauticform-checkboxgrp-label">
                        <input  class="mauticform-checkboxgrp-checkbox" name="mauticform[oficios_tecnologicos][]" id="mauticform_checkboxgrp_checkbox_oficios_tecnologicos_PaqueteOffice4" type="checkbox" value="Paquete Office" /> Paquete Office
                    </label>

						  
                    <label id="mauticform_checkboxgrp_label_oficios_tecnologicos_HerramientasgraficasIllustratorAfterEffectsPhotoshop5" for="mauticform_checkboxgrp_checkbox_oficios_tecnologicos_HerramientasgraficasIllustratorAfterEffectsPhotoshop5"  class="mauticform-checkboxgrp-label">
                        <input  class="mauticform-checkboxgrp-checkbox" name="mauticform[oficios_tecnologicos][]" id="mauticform_checkboxgrp_checkbox_oficios_tecnologicos_HerramientasgraficasIllustratorAfterEffectsPhotoshop5" type="checkbox" value="Herramientas gráficas (Illustrator, After Effects, Photoshop)" /> Herramientas gráficas (Illustrator, After Effects, Photoshop)
                    </label>

						  
                    <label id="mauticform_checkboxgrp_label_oficios_tecnologicos_Disenografico6" for="mauticform_checkboxgrp_checkbox_oficios_tecnologicos_Disenografico6"  class="mauticform-checkboxgrp-label">
                        <input  class="mauticform-checkboxgrp-checkbox" name="mauticform[oficios_tecnologicos][]" id="mauticform_checkboxgrp_checkbox_oficios_tecnologicos_Disenografico6" type="checkbox" value="Diseño gráfico" /> Diseño gráfico
                    </label>

						  
                    <label id="mauticform_checkboxgrp_label_oficios_tecnologicos_Impresion3D7" for="mauticform_checkboxgrp_checkbox_oficios_tecnologicos_Impresion3D7"  class="mauticform-checkboxgrp-label">
                        <input  class="mauticform-checkboxgrp-checkbox" name="mauticform[oficios_tecnologicos][]" id="mauticform_checkboxgrp_checkbox_oficios_tecnologicos_Impresion3D7" type="checkbox" value="Impresión 3D" /> Impresión 3D
                    </label>

						  
                    <label id="mauticform_checkboxgrp_label_oficios_tecnologicos_Electronica8" for="mauticform_checkboxgrp_checkbox_oficios_tecnologicos_Electronica8"  class="mauticform-checkboxgrp-label">
                        <input  class="mauticform-checkboxgrp-checkbox" name="mauticform[oficios_tecnologicos][]" id="mauticform_checkboxgrp_checkbox_oficios_tecnologicos_Electronica8" type="checkbox" value="Electrónica" /> Electrónica
                    </label>

						  
                    <label id="mauticform_checkboxgrp_label_oficios_tecnologicos_Arduino9" for="mauticform_checkboxgrp_checkbox_oficios_tecnologicos_Arduino9"  class="mauticform-checkboxgrp-label">
                        <input  class="mauticform-checkboxgrp-checkbox" name="mauticform[oficios_tecnologicos][]" id="mauticform_checkboxgrp_checkbox_oficios_tecnologicos_Arduino9" type="checkbox" value="Arduino" /> Arduino
                    </label>

						  
                    <label id="mauticform_checkboxgrp_label_oficios_tecnologicos_Redesyservidores10" for="mauticform_checkboxgrp_checkbox_oficios_tecnologicos_Redesyservidores10"  class="mauticform-checkboxgrp-label">
                        <input  class="mauticform-checkboxgrp-checkbox" name="mauticform[oficios_tecnologicos][]" id="mauticform_checkboxgrp_checkbox_oficios_tecnologicos_Redesyservidores10" type="checkbox" value="Redes y servidores" /> Redes y servidores
                    </label>

						  
                    <label id="mauticform_checkboxgrp_label_oficios_tecnologicos_Energiasrenovables11" for="mauticform_checkboxgrp_checkbox_oficios_tecnologicos_Energiasrenovables11"  class="mauticform-checkboxgrp-label">
                        <input  class="mauticform-checkboxgrp-checkbox" name="mauticform[oficios_tecnologicos][]" id="mauticform_checkboxgrp_checkbox_oficios_tecnologicos_Energiasrenovables11" type="checkbox" value="Energías renovables" /> Energías renovables
                    </label>
                </div>
                <span class="mauticform-errormsg" style="display: none;"></span>
            </fieldset>

            <div id="mauticform_edltinformacioncursos_submit"  class="mauticform-row mauticform-button-wrapper mauticform-field-10 submit-wrapper">
                <button type="submit" name="mauticform[submit]" id="mauticform_input_edltinformacioncursos_submit" name="mauticform[submit]" value="Inscribirme" class="mauticform-button btn btn-default" value="1">Inscribirme</button>
            </div>
         </div>
      </div>

		<input type="hidden" name="mauticform[formId]" id="mauticform_edltinformacioncursos_id" value="2"/>
		<input type="hidden" name="mauticform[return]" id="mauticform_edltinformacioncursos_return" value=""/>
		<input type="hidden" name="mauticform[formName]" id="mauticform_edltinformacioncursos_name" value="edltinformacioncursos"/>

		
      <div class="mauticform-error" id="mauticform_edltinformacioncursos_error"></div>
      <div class="mauticform-message" id="mauticform_edltinformacioncursos_message"></div>		
		
		
		
   </form>
</div>
';


}
add_shortcode( 'mautic_form_edlt_info', 'mautic_form_edlt_info_shortcode' );








function puntos_carga_mapa_shortcode( $atts ) {

	// Attributes
	$atts = shortcode_atts(
		array(
			'tipo' => 'sube', //"sube" o "estacionamiento"
		),
		$atts
	);
	wp_enqueue_style("leaflet",     "https://unpkg.com/leaflet@1.3.4/dist/leaflet.css", false, "1.3.4", "all");
	wp_enqueue_script("leaflet-js", "https://unpkg.com/leaflet@1.3.4/dist/leaflet.js", false, "1.3.4", true);
	
	$file_url = plugins_url( 'json/puntos-carga.json', __FILE__ );
	$response = json_decode( file_get_contents( $file_url ), true);
	$points = $response;
	//var_dump($points);
	$point_popup_tpl = '<p>$name </p><dl><div><dt>Dirección:</dt><dd>$address</dd></div>$open_times</dl>';
	
	ob_start();
	?>
	<div id='map_puntos_carga' style='height:600px;width:100%;margin-bottom: 3em;'></div>
	<script type="text/javascript">
	jQuery(document).ready(function() {
		var map = L.map('map_puntos_carga').setView([-53.78903, -67.69588], 15);
		var tile_url = 'https://tiles.dir.riogrande.gob.ar/carto/{z}/{x}/{y}.png';

		var map_icon = L.icon({
			iconUrl: 'https://riogrande.gob.ar/wp-content/uploads/2017/12/marker.png',
			iconSize: [36,46],
			iconAnchor: [18, 46],
			popupAnchor: [0,-40],
		});

		L.tileLayer(tile_url,{
			attribution: 'Map data © <a href=\"http://openstreetmap.org\">OpenStreetMap</a> contributors',
			maxZoom: 18,
			minZoom: 14
		}).addTo(map);
		
		<?php
		foreach ($points as $point) {
			$tmp_times = "";
			if ( !empty( $point['open_times']) ) {
				$tmp_times = "<div><dt>Horario:</dt><dd>".$point['open_times']."</dd></div>";	
			}
			
			$tmp_name = $point['name'];
			if ( $point["place_type"] ) {
				$tmp_name = $point['name'] . ' <br><span class="smaller-font">(' . $point["place_type"] . ")</span>";
			}
			
			
			$vars = array(
				'$name'       => $tmp_name,
				'$address'    => str_replace("'", " ", $point['address']),
				'$open_times' => $tmp_times,
			);
			
			
			$js_point = "";
			
			if ( 
					( $atts['tipo'] == "estacionamiento" && $point['is_estacionamiento-medido'] == "si" ) 
					||
					( $atts['tipo'] == "sube" && !empty($point['center_type']) )
				)
				{
				echo "L.marker([".$point['geocoord']."], {icon: map_icon}).addTo(map).bindPopup('".strtr($point_popup_tpl, $vars)."');";
			}
			
			
		} ?>
	});
	</script>
	
	<?php
	return ob_get_clean();
	
}
add_shortcode( 'puntos_carga_mapa', 'puntos_carga_mapa_shortcode' );





?>