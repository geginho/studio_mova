<?php

class col_tinymce
{	
	function __construct()
	{
		add_action('admin_init', array( &$this, 'col_head' ));
		add_action('init', array( &$this, 'col_tinymce_rich_buttons' ));
	}
	
	// --------------------------------------------------------------------------
	
	function col_head()
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
	
	// --------------------------------------------------------------------------
	
	/**
	 * Registers TinyMCE rich editor buttons
	 *
	 * @return	void
	 */
	function col_tinymce_rich_buttons()
	{
		if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
			return;
	
		if ( get_user_option('rich_editing') == 'true' )
		{
			add_filter( 'mce_external_plugins', array( &$this, 'col_add_rich_plugins' ) );
			add_filter( 'mce_buttons', array( &$this, 'col_register_rich_buttons' ) );
		}
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Defins TinyMCE rich editor js plugin
	 *
	 * @return	void
	 */
	function col_add_rich_plugins( $plugin_array )
	{
		$plugin_array['colShortcodes'] = COL_TINYMCE_URI . '/plugin.js';
		return $plugin_array;
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Adds TinyMCE rich editor buttons
	 *
	 * @return	void
	 */
	function col_register_rich_buttons( $buttons )
	{
		array_push( $buttons, "|", 'col_button' );
		return $buttons;
	}
	
		
		
}

?>