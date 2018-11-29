<?php
/**
 *  get external blog posts
 */

function make_file_from_external_blog($wp_response, $name_file, $context=""){
	
	$data = array();
	
	if( !is_wp_error( $wp_response ) && $wp_response['response']['code'] == 200 ) {
		$tmp = json_decode( $wp_response['body'], true ); 
		
		$data = $tmp;
		
		if ( $context == "categories" ) {
			foreach ($tmp as $cat) {
				//$data[$cat["id"]] = array("name" => $cat["name"], "link" => $cat["link"]);
				$data[] = array("id" => $cat["id"], "name" => $cat["name"], "link" => $cat["link"] );
			}
		}
		
		# Eliminamos archivo
		if(file_exists($name_file)){
			@unlink($name_file);
		}

		# Creamos archivo
		file_put_contents( $name_file , json_encode($data) );
		
		return $data;
	}	
}



/**
 *  Get blog (WP, external) categories using REST API
 *  
 *  @return array. id => array(name, link )
 *  
 */
function get_external_blog_categories(){
	
	$blog_url_cats = EXTERNAL_BLOG_URL_API . "/categories";
	
	$response_cat = wp_remote_get( add_query_arg( array(
		'per_page' => 100 //between 1 and 100
		//'page' => 1 
	), $blog_url_cats ) );
	
	$name_file 	= get_parent_theme_file_path('/json/external_blog_categories.json');	
	$make_file = true;
	
	if( !file_exists($name_file) ) {
		$make_file = true;
	}
	else {
		date_default_timezone_set('UTC');
		date_default_timezone_set("America/Argentina/Ushuaia");
		setlocale(LC_ALL,"es_ES");
		
		$hora 				= getdate();
		$segundos_menos 	= 3600*3; 									// Diferencia horaria (3hs Argentina)
		$segundos_validos = 3600; 										// Segundos validos para el archivo (5hs)
		$hora_actual 		= gmdate("H:i:s", ($hora[0]-$segundos_menos));	// Formateamos hora de sistema
		$hora_archivo 		= date("H:i:s.", filemtime($name_file));	// Formateamos hora de sistema
		$horas_resta 		= MRG_normalice_fecha($hora_actual) - MRG_normalice_fecha($hora_archivo);
		
		$make_file = ($horas_resta <= $segundos_validos) ? false : true;
	}
	
	if ( !$make_file ) {
		return json_decode(file_get_contents($name_file), true);
	}
	return make_file_from_external_blog($response_cat,$name_file, $context="categories");
}



/**
 *  Get blog (WP, external) posts using REST API
 *  
 *  @return array
 */
function get_external_blog_posts($filter_categories=array()){
	$blog_url = EXTERNAL_BLOG_URL_API . "/posts";

	$name_file 	= get_parent_theme_file_path ('/json/external_blog_posts.json');
	
	$query_args = array(
		'per_page' => 5
		, '_embed' => ''
	);
	
	if ( !empty( $filter_categories ) ) {
		$query_args['categories'] = $filter_categories;
		$tmp        = is_array( $filter_categories ) ? $filter_categories[0] : $filter_categories;
		$name_file 	= get_parent_theme_file_path('/json/external_blog_posts_cat_' . $tmp . '.json');
	}
	
	$response  = wp_remote_get( add_query_arg( $query_args, $blog_url ) );		
	$make_file = true;
	
	if(!file_exists($name_file)) {
		$make_file = true;
	}
	else {
		date_default_timezone_set('UTC');
		date_default_timezone_set("America/Argentina/Ushuaia");
		setlocale(LC_ALL,"es_ES");
		
		$hora 				= getdate();
		$segundos_menos 	= 3600*3; 		// Diferencia horaria (3hs Argentina)
		$segundos_validos = 3600; 		// Segundos validos para el archivo (5hs)
		$hora_actual 		= gmdate("H:i:s", ($hora[0]-$segundos_menos));	// Formateamos hora de sistema
		$hora_archivo 		= date("H:i:s.", filemtime($name_file));	// Formateamos hora de sistema
		$horas_resta 		= MRG_normalice_fecha($hora_actual) - MRG_normalice_fecha($hora_archivo);
		
		$make_file = ($horas_resta <= $segundos_validos) ? false : true;
	}
	
	if ( !$make_file ) {
		return json_decode(file_get_contents($name_file), true);
	}
	return make_file_from_external_blog($response,$name_file);
}


function print_external_blog_posts($posts, $section_title=""){
	
	$remote_posts = $posts;
	$remote_categories_cache = get_external_blog_categories();
	$ctr = 0;
	?>
	
	<section class="mini-posts-container blog-latest wrapper_max_width">
		<h2 class="title"><?php echo ( $section_title ) ? $section_title : "Mantenete bien informado";?></h2>
	
		<!-- mfunc FRAGMENT_CACHING -->
		<?php foreach( $remote_posts as $remote_post ) : 
			$ctr ++;
			if ( $ctr == 1 ) {
				echo '<div class="row">';
			}

			if ( $ctr == 4 ) {
				echo '<div class="row column-bigger">';
					echo '<div class="post column smaller">';
			}
			if ( $ctr == 5 ) {
				echo '<div class="post column bigger">';
			}

			if ( $ctr < 4 ) {
				echo '<div class="column">';
			}
			?>
				<div class="mini-article effect-enlarge-shadow">
					<div>
						<div <?php if ( !empty( $remote_post['_embedded']['wp:featuredmedia'][0]['media_details']['sizes']['medium_large']['source_url'] ) ) { echo 'style="background-image:url(' . $remote_post['_embedded']['wp:featuredmedia'][0]['media_details']['sizes']['medium_large']['source_url'] . ')"'; } ?> class="image"></div>

						<h3 class="title"><a href="<?php echo esc_url( $remote_post['link'] );?>"><?php echo $remote_post['title']['rendered'];?></a></h3>
					</div>

					<?php 
					$categories_list = array();

					foreach ($remote_post['categories'] as $cat) {
						
						$tmp = -1;
						
						foreach( $remote_categories_cache as $cat_d ) {
							if ( $cat == $cat_d['id'] ) {
								$tmp = $cat_d;
								break;
							}
						}
						
						if ( $tmp >= 0 ) {
							$categories_list[] = '<a href="' . esc_url( $tmp['link'] ) . '">' . $tmp['name'] . '</a>';
						}
					}

					if ( $categories_list ) : ?>
							<p class="category uppercase">
								<?php echo implode( ", ", $categories_list );?>
							</p>
					<?php	endif; ?>
				</div> <?php //article ?>
			</div> <?php //end column ?>

			<?php
			if ( $ctr == 3 || $ctr == 5 ) {
				echo '</div>'; //end row
			}
		endforeach;	
		
		if ( $ctr == 4 ) {
				echo '</div>'; //end row
		}
		?>

		<!-- /mfunc FRAGMENT_CACHING -->
		<p style="text-align: center;width:100%;"><a class="button-blog" href="http://info.riogrande.gob.ar/"><img src="https://riogrande.gob.ar/wp-content/themes/mrg/images/globa_blog.svg" alt="Blog" width="73"></a></p>
	</section>
<?php
}


function print_external_blog_posts_holder($section_title="", $filtered_cats=array()){
	$remote_posts = get_external_blog_posts($filtered_cats);
	
	if ( empty( $remote_posts ) ) {
		return "";
	}
	
   print_external_blog_posts($remote_posts, $section_title);	
}
