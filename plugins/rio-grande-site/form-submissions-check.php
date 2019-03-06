<?php


/**
 *  Do not allow duplicates in Contact Form 7, using CFDB
 *  
 *  from: https://cfdbplugin.com/?page_id=904
 */

 /*
 
add_action( 'wpcf7_before_send_mail', 'my_conversion' );
function my_conversion( $contact_form ) {
	
  $form_title = $contact_form->title();
	
	if ( $form_title != "test") {
		//or $contact_form->id() or 
		return;
		
	}
	
  $submission = WPCF7_Submission::get_instance();

   if ( $submission ) {
		$posted_data = $submission->get_posted_data();
	}

	 $email = $posted_data["your-email"];
	 $name  = $posted_data["your-name"];
	 $last  = $posted_data["your-lastname"];
	 $phone = $posted_data["tel-71"];
	 $description = $posted_data["your-message"];


} 
 
 */
 
 
function is_already_submitted($formName, $fieldName, $fieldValue) {
    require_once(ABSPATH . 'wp-content/plugins/contact-form-7-to-database-extension/CFDBFormIterator.php');
    $exp = new CFDBFormIterator();
    $atts = array();
    $atts['show'] = $fieldName;
    $atts['filter'] = "$fieldName=$fieldValue";
    $atts['unbuffered'] = 'true';
    $exp->export($formName, $atts);
    $found = false;
    while ($row = $exp->nextRow()) {
        $found = true;
    }
    return $found;
}
 
 
 
 
/**
 * @param $result WPCF7_Validation
 * @param $tag array
 * @return WPCF7_Validation
 */
function ecomaraton_validate_dni($result, $tag) {
    $formName = 'inscripcion ecomaraton'; // Change to name of the form containing this field
    $fieldName = 'dni_2da_ecomaraton'; // Change to your form's unique field name. Must be unique (global)
    $errorMessage = 'El DNI ya está ingresado'; // Change to your error message
    $name = $tag['name'];
    if ($name == $fieldName) {
        if (is_already_submitted($formName, $fieldName, $_POST[$name])) {
            $result->invalidate($tag, $errorMessage);
        }
    }
    return $result;
}
add_filter('wpcf7_validate_number*', 'ecomaraton_validate_dni', 10, 2);
 
// use the next line if your field is a **required email** field on your form
//add_filter('wpcf7_validate_email*', 'my_validate_email', 10, 2);
// use the next line if your field is an **email** field not required on your form
//add_filter('wpcf7_validate_email', 'my_validate_email', 10, 2);
 
// use the next line if your field is a **required text** field
//add_filter('wpcf7_validate_text*', 'ecomaraton_validate_dni', 10, 2);
// use the next line if your field is a **text** field field not required on your form 
//add_filter('wpcf7_validate_text', 'my_validate_email', 10, 2);


?>