<?php
/*
Plugin Name: Yacaré
Description: Conexión de WordPress con Yacaré para Municipio de Río Grande.
Version: 1.0
Author: Ernesto Carrea
License: GPL2
*/

defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

class Yacare {
	public static function run() {
		// Exit early
		if ( ( 'wp-login.php' === basename( $_SERVER['SCRIPT_FILENAME'] ) ) // Login screen
			|| ( defined( 'XMLRPC_REQUEST' ) && XMLRPC_REQUEST )
			|| ( defined( 'DOING_CRON' ) && DOING_CRON ) ) {
			return;
		}
		
	    add_shortcode( 'yacare-calles', array( 'Yacare', 'Calles' ) );
	    add_shortcode( 'yacare-barrios', array( 'Yacare', 'Barrios' ) );
	    add_shortcode( 'yacare-pa-matriculados', array( 'Yacare', 'PaMatriculados' ) );
	}


    private static function ConectarBd() {
        return new PDO('mysql:host=geminis.dir.riogrande.gob.ar;dbname=yacare_prod;charset=utf8', 'yacare_pub', '123456');
    }


    // [yacare-barrios]
    public static function Barrios($atts) {
		wp_enqueue_style( 'yacare-tables-default', '//cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css', array() );
		wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'yacare-tables-datatables', '//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js', array( 'jquery' ), null, true );
        wp_enqueue_script( 'yacare-tables-datatables', '//cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js', array( 'jquery' ), null, true );
        
        add_action('wp_footer', array ( 'Yacare', 'dataTablesFooter' ) );
    
        $dbyacare = self::ConectarBd();
ob_start(); ?>
<div id="tabla-yacare-calles_wrapper" class="dataTables_wrapper no-footer">
<table id="tabla-yacare-calles" class="tablepress dataTable no-footer tabla-yacare-datatables" role="grid">
    <thead>
    <tr role="row">
        <th  class="column-1 sorting" aria-controls="tabla-yacare-calles">Nombre</th>
        <th  class="column-2 sorting" aria-controls="tabla-yacare-calles">Nombre alternativo</th>
        <th  class="column-3 sorting" aria-controls="tabla-yacare-calles">Límites</th>
    </tr>
    </thead>
    <tbody class="row-hover">
<?php
    foreach ($dbyacare->query("SELECT * FROM Catastro_Barrio ORDER BY Nombre") as $Row) {
?>
    <tr role="row">
        <td class="column-1"><?php echo $Row['Nombre']; ?></td>
        <td class="column-1"><?php echo $Row['NombreOriginal']; ?></td>
        <td class="column-1"><?php echo $Row['Notas']; ?></td>
    </tr>
<?php
    }
?>
    </tbody>
</table>
</div>
<?php
        
        $res .= ob_get_clean();
        $dbyacare = null;
        return $res;
    }

	
    // [yacare-calles]
    public static function Calles($atts) {
		wp_enqueue_style( 'yacare-tables-default', '//cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css', array() );
		wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'yacare-tables-datatables', '//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js', array( 'jquery' ), null, true );
        wp_enqueue_script( 'yacare-tables-datatables', '//cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js', array( 'jquery' ), null, true );
        
        add_action('wp_footer', array ( 'Yacare', 'dataTablesFooter' ) );
    
        $dbyacare = self::ConectarBd();
ob_start(); ?>
<div id="tabla-yacare-calles_wrapper" class="dataTables_wrapper no-footer">
<table id="tabla-yacare-calles" class="tablepress dataTable no-footer tabla-yacare-datatables" role="grid">
    <thead>
    <tr role="row">
        <th  class="column-1 sorting" aria-controls="tabla-yacare-calles">Nombre</th>
    </tr>
    </thead>
    <tbody class="row-hover">
<?php
    foreach ($dbyacare->query("SELECT * FROM Catastro_Calle ORDER BY Nombre") as $Row) {
?>
    <tr role="row">
        <td class="column-1"><?php echo $Row['Nombre']; ?></td>
    </tr>
<?php
    }
?>
    </tbody>
</table>
</div>
<?php
        $res .= ob_get_clean();
        $dbyacare = null;
        return $res;
    }



    // [yacare-pa-matriculados]
    public static function PaMatriculados($atts) {
		wp_enqueue_style( 'yacare-tables-default', '//cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css', array() );
		wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'yacare-tables-datatables', '//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js', array( 'jquery' ), null, true );
        wp_enqueue_script( 'yacare-tables-datatables', '//cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js', array( 'jquery' ), null, true );
        
        add_action('wp_footer', array ( 'Yacare', 'dataTablesFooter' ) );
        ob_start();
?>
<table id="tabla-yacare-calles" class="tablepress dataTable tabla-yacare-datatables" role="grid">
    <thead>
    <tr role="row">
        <th  class="column-1 sorting" aria-controls="tabla-yacare-calles">Nombre</th>
        <th  class="column-2 sorting" aria-controls="tabla-yacare-calles">Profesión</th>
        <th  class="column-3 sorting" aria-controls="tabla-yacare-calles">Teléfono</th>
        <th  class="column-4 sorting" aria-controls="tabla-yacare-calles">Domicilio</th>
    </tr>
    </thead>
    <tbody class="row-hover">
<?php
    $dbyacare = self::ConectarBd();
    $Rows = $dbyacare->query("SELECT * FROM v_opart_matriculados");
    foreach ($Rows as $Row) {
    
    // ORDER BY p.NombreVisible, FIELD(d.Tipo, 3) DESC
    // Significa ordenar por NombreVisible
    // y tipo de domicilio 3 (comercial) primero, luego otros si no hay 3
?>
    <tr role="row">
        <td class="column-1"><?php echo $Row['NombreVisible']; ?></td>
        <td class="column-2"><?php echo $Row['Profesion']; ?></td>
        <td class="column-3"><?php echo $Row['TelefonoNumero']; ?></td>
        <td class="column-4"><?php 
            echo $Row['DomicilioCalleNombre'];
            if($Row['DomicilioNumero']) {
                echo ' ' . $Row['DomicilioNumero'];
            }
            if($Row['DomicilioPiso']) {
                echo ', piso ' . $Row['DomicilioPiso'];
            }
            if($Row['DomicilioPuerta']) {
                echo ', pta. ' . $Row['DomicilioPuerta'];
            }
?></td>
    </tr>
<?php
    }
?>
    </tbody>
</table>
<?php
        
        $res .= ob_get_clean();
        $dbyacare = null;
        return $res;
    }


    public static function dataTablesFooter() {
        echo <<<END_SCRIPT
<script type="text/javascript">
$(document).ready(function(){
    $('.tabla-yacare-datatables').DataTable( { 
        paging: false,
        pageLength: 100,
        language: {
            search:        "Buscar:",
            lengthMenu:    "Mostrar _MENU_ elementos",
        }
    } );
});
</script>        
END_SCRIPT;
    }

}
