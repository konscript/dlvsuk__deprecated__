<?php 
// Safety first.
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'functions.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly!');

// load up jQuery from Google CDN
if( !is_admin()){
   wp_deregister_script('jquery'); 
   wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"), false, '1.6.2'); 
   wp_enqueue_script('jquery');
}

// Add awesome browser classes to body tag
add_filter('body_class','browser_body_class');
function browser_body_class($classes) {
	global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

	if($is_lynx) $classes[] = 'lynx';
	elseif($is_gecko) $classes[] = 'gecko';
	elseif($is_opera) $classes[] = 'opera';
	elseif($is_NS4) $classes[] = 'ns4';
	elseif($is_safari) $classes[] = 'safari';
	elseif($is_chrome) $classes[] = 'chrome';
	elseif($is_IE) $classes[] = 'ie';
	else $classes[] = 'unknown';

	if($is_iphone) $classes[] = 'iphone';
	return $classes;
}

// Remove useless the_generator meta tag - whoops
add_filter( 'the_generator', create_function('$a', "return null;") );

// Custom Logo
function custom_logo() { ?> 
	<style type="text/css">
		h1 a { background-image: url(
			<?php get_bloginfo('template_directory'); ?>/img/logo-login.gif
		) !important; }
    </style>
<?php }

add_action('login_head', 'custom_logo');

// Admin Footer
function remove_footer_admin () {
	echo 'Powered by Konscript';
}

add_filter('admin_footer_text', 'remove_footer_admin');

// Sidebars
if ( function_exists('register_sidebar') )
	register_sidebar(array('name'=>'Sidebar'));

// menu support
function theme_addmenus() {
	register_nav_menus(
		array(
			'main' => 'Main Menu',
			'about' => 'About submenu',
			'travel' => 'Travel submenu',			
			'unicef' => 'empty menu',		
		)
	);
}
add_action( 'init', 'theme_addmenus' );

// primary menu with search
function primary_menu(){
    wp_nav_menu(array(
		'theme_location' 	=> 'main',
		'container'=> false
	));
	get_search_form(); 
}

require_once( get_template_directory() . '/lib/admin/theme-options.php' );
