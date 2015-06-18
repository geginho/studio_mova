<?php

/*-----------------------------------------------------------------------------------*/
/*	Paths Defenitions
/*-----------------------------------------------------------------------------------*/

define('COL_TINYMCE_PATH', THEME_FILEPATH . '/framework/tinymce');
define('COL_TINYMCE_URI', THEME_DIRECTORY . '/framework/tinymce');



	function nor_col_head()
	{
		// css
		wp_enqueue_style( 'col-popup', COL_TINYMCE_URI . '/css/popup.css', false, '1.0', 'all' );
		
		// js
		wp_enqueue_script('jquery-ui-sortable');
		wp_enqueue_script( 'jquery-livequery', COL_TINYMCE_URI . '/js/jquery.livequery.js', false, '1.1.1', false );
		
		wp_localize_script('jquery-livequery', 'drthemeurls', get_template_directory_uri());	
		
		wp_enqueue_script( 'jquery-appendo', COL_TINYMCE_URI . '/js/jquery.appendo.js', false, '1.0', false );
		wp_enqueue_script( 'base64', COL_TINYMCE_URI . '/js/base64.js', false, '1.0', false );
		wp_enqueue_script( 'col-popup', COL_TINYMCE_URI . '/js/popup.js', false, '1.0', false );
		
	}
	
	function norshortcodes_buttonhooks() {
	   // Only add hooks when the current user has permissions AND is in Rich Text editor mode
	   if ( ( current_user_can('edit_posts') || current_user_can('edit_pages') ) && get_user_option('rich_editing') ) {
		 add_filter("mce_external_plugins", "norshortcodes_register_tinymce_javascript");
		 add_filter('mce_buttons', 'norshortcodes_register_buttons');
	   }
	}
	 
	function norshortcodes_register_buttons($buttons) {
	   array_push($buttons, "separator", "colShortcodes");
	   return $buttons;
	}
	 
	// Load the TinyMCE plugin : editor_plugin.js (wp2.5)
	function norshortcodes_register_tinymce_javascript($plugin_array) {
	   $plugin_array['colShortcodes'] = COL_TINYMCE_URI . '/plugin.js';
	   $plugin_array['code'] = COL_TINYMCE_URI . '/plugin.js';
	   $plugin_array['link'] = COL_TINYMCE_URI . '/plugin.js';
	   return $plugin_array;
	}
	 
	// init process for button control
	add_action('init', 'norshortcodes_buttonhooks');
	add_action('admin_init', 'nor_col_head');
	
?>