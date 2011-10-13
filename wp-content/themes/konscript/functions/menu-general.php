<?php

// add "sidebar-hidden" to body class
add_filter('body_class','my_class_names');
function my_class_names($classes) {
	
	$submenu = build_submenu();
	
	if($submenu == -2){
		$classes[] = 'sidebar-hidden';
	}
	
	return $classes;
}

// output submenu 
function get_submenu() {
	$submenu = build_submenu();
	
	// submenu isn't hidden
	if($submenu != -2){
		echo '
		<div id="sidebar"> &nbsp;
			'.$submenu.'
		</div>';
	}
}

// build submenu
function build_submenu(){
	global $post;
	 
	// Get the ID of the set menu
	$menu_id = get_post_meta($post->ID, 'dpm_page-menu-id', true);
		
	// the menu is unset, look for parent menus
	if($menu_id == -1 || $menu_id == null){
		
		// single post (not page)
		if(is_single()){	
			$page_id = getPageIDOfCurrentCustomPostType();							
			
			// get menu ID
			$menu_id = get_post_meta($page_id, 'dpm_page-menu-id', true);
			
		// sub-page
		}else{
			$menu_id = get_post_meta($post->post_parent, 'dpm_page-menu-id', true);
		}						
	}
	
	// menu is found, output it
	if($menu_id > 0){
		return wp_nav_menu(array('menu' => $menu_id, 'echo' => false));
		
	// the menu is set to hide
	}elseif($menu_id == -2){
		return "-2";
	}	
} 

// include Kristians Dynamic Menus on admin page
include 'DynamicMenus.php';

/**
#############################
# REGISTER NAVIGATION AREAS #
#############################
**/
function theme_addmenus() {
	register_nav_menus(
		array('main' => 'Main Menu')
	);
}
add_action( 'init', 'theme_addmenus' );


/**
#############################
# primary menu with search  #
#############################
**/
function primary_menu(){

	/****
	 * custom post type menu ancestor fix
	 * NB. Remember to add slug as title attribute in menu manager!
	 * http://wordpress.stackexchange.com/questions/3014/highlighting-wp-nav-menu-ancestor-class-w-o-children-in-nav-structure
	 ******/
	 
	global $pageIDOfCurrentCustomPostType;
	$pageIDOfCurrentCustomPostType = getPageIDOfCurrentCustomPostType();	
	add_filter('nav_menu_css_class', 'current_type_nav_class', 10, 2 );
	
	function current_type_nav_class($classes, $item) {
		global $pageIDOfCurrentCustomPostType;
		
		// add class if post_id fits the page_id the menu item points to (object_id)
		if($item->object_id == $pageIDOfCurrentCustomPostType){
		    array_push($classes, 'current-menu-item');			
		}
		
		return $classes;
	}							
	
    $menu = wp_nav_menu(array(
		'theme_location' 	=> 'main',
		'container'=> false,
		'echo'            => true,

	));
	
	get_search_form(); 
}
?>