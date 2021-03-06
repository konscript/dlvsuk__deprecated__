<?php

// Safety first.
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'functions.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly!');
	
// Wordpress features setup
add_theme_support( 'post-thumbnails', array( 'page' ) );

// Getting page ID of current Custom Post Type
function getPageIDOfCurrentCustomPostType(){
	global $wpdb;
	global $post;		
	
	// get current post type		
	$post_type = get_post_type($post);
	
	// get id of page with current custom post type template		
	$post_id = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE meta_value = 'template-".$post_type.".php'");		
	return $post_id;
}

// Shorten excerpt
function konscript_excerpt($length, $str) {
   if(strlen($str)>$length) {
       $subex = substr($str,0,$length-5);
       $exwords = explode(" ",$subex);
       $excut = -(strlen($exwords[count($exwords)-1]));
       if($excut<0) {
            $res = substr($subex,0,$excut);
       } else {
       	    $res = $subex;
       }
       $res .= "[...]";
   } else {
	   $res = $str;
   }
   
   return $res;
}

// load up jQuery from Google CDN
if( !is_admin()){
	wp_deregister_script('jquery'); 
	wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"), false, '1.6.2');    
	wp_enqueue_script('jquery');
   
	wp_deregister_script('jqueryui');   
	wp_register_script('jqueryui', ("http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"), false, '1.5.3');   
	wp_enqueue_script('jqueryui');   
}

// Remove useless the_generator meta tag - whoops
add_filter( 'the_generator', create_function('$a', "return null;") );

// Custom Logo
function custom_logo() { ?> 
	<style type="text/css">
		h1 a { background-image: url(<?php echo get_bloginfo('template_directory'); ?>/img/dlvs_logo_2012.png) !important; }
	</style>
<?php }	
add_action('login_head', 'custom_logo');

// Admin Footer
function remove_footer_admin () {
	echo 'Powered by Konscript';
}
add_filter('admin_footer_text', 'remove_footer_admin');

// debug outputting
function debug($output){
	$debug = "<hr><pre>";
	$debug .= print_r($output, true);	
	$debug .= "<pre>";	
	echo $debug; 
}
?>
