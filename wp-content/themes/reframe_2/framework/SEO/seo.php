<?php

/**

	ALLOW YOU TO SET YOUR CONTENT'S TITLE AND DESCRIPTION FOR SEARCH ENGINES
	
 */
class SEO {

	/// Constructor
	
	function __construct() {
		// IMPORT SCRIPTS
		add_action( 'admin_print_styles', array( &$this, 'seo_styles' ) );
		add_action( 'admin_print_scripts', array( &$this, 'seo_scripts' ) );
		
		// CREATE / SAVE FIELDS
		add_action( 'admin_init', array( &$this, 'seo_boxes' ));
		add_action( 'save_post', array( &$this, 'save_work_custom_values'));
		
	} 
	
	
	/// CREATE FIELDS
	
	public function seo_boxes() {
	
		global $cc_types;

		add_meta_box('posts-seo',__( 'SEO', 'northeme' ),	array( &$this, 'show_fields' ),'post', 'normal','low');
		add_meta_box('posts-seo',__( 'SEO', 'northeme' ),	array( &$this, 'show_fields' ),'page', 'normal','low');
		
		foreach($cc_types as $foo) {
			add_meta_box('posts-seo',__( 'SEO', 'northeme' ),	array( &$this, 'show_fields' ),$foo, 'normal','low');
		}
		

	} // end action_method_name
	
	
	/// RENDER SEO FIELDS
	
	public function show_fields( $post ) {

		wp_nonce_field( plugin_basename( __FILE__ ), 'SEO_nonce' );
		
		$seo_title = get_post_meta( $post->ID, 'seo-title', true );
		
		if($seo_title=="") {
			$seo_title= get_the_title(); 
		}
		
		echo $html = '<div class="seo-preview custom-fields">
						<p class="info">
						This section allows you to create your meta title and description.
						<br>
						It\'s highly recommended step for search engine optimization. If not provided, default title and post/page content will be used as meta tags.
						</p>
						<br class=clear"">
						<div class="preview">
							<span class="title"><a>'.$seo_title.'</a> | '.get_bloginfo('name').'</span>
							<br>
							<span class="permalink">'.get_permalink().'</span>
							<br>
							<span class="meta">'.get_post_meta( $post->ID, 'seo-desc', true ).'</span>
							<br>
							<span class="date">' . date( get_option( 'date_format' ) ) . '</span>
						</div>
						<br class="clear">
						<div class="inputs">
							<label>' . __( 'HTML Title', 'northeme' ) . ' <small class="titlecount"></small></label>
							<br>
							<input id="seo-title" name="seo-title" maxlength="69" class="" value="' . $seo_title . '">
							<br>
							<br>
							<label>' . __( 'Meta Description', 'northeme' ) . ' <small class="desccount"></small></label>
							<textarea id="seo-desc" name="seo-desc" maxlength="140">' . get_post_meta( $post->ID, 'seo-desc', true ) . '</textarea>
							<br>
							<br>
							<label>' . __( 'Keywords', 'northeme' ) . '</label>
							<br>
							<input name="seo-keywords" maxlength="69" class="" value="' . get_post_meta( $post->ID, 'seo-keywords', true ) . '">
							<br>
						</div>
					  </div>';
		
	} // end post-Level_display
	
	
	//// SAVE RESULTS
	public function save_work_custom_values( $post_id ) {
		
		if( isset( $_POST['SEO_nonce'] ) ) {
		
			// TO PREVENT AUTO-SAVE
			if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			} 
			
			// VERIFY NONCE
			if( ! wp_verify_nonce( $_POST['SEO_nonce'], plugin_basename( __FILE__ ) ) ) {
				return;
			} 
			
			// CHECK USER PERMISSIONS
			
			  if ( 'page' == $_POST['post_type'] ) 
			  {
				if ( !current_user_can( 'edit_page', $post_id ) )
					return;
			  }
			  else
			  {
				if ( !current_user_can( 'edit_post', $post_id ) )
					return;
			  }
		  
		  
			// Read the meta description
			$seo_title = $_POST['seo-title'];
			$seo_desc = $_POST['seo-desc'];
			$seo_keywords = $_POST['seo-keywords'];

			// Update it for this post
			update_post_meta( $post_id, 'seo-title', $seo_title );
			update_post_meta( $post_id, 'seo-desc', $seo_desc );
			update_post_meta( $post_id, 'seo-keywords', $seo_keywords );

		} // end if
			
	} // end save_postdata
  


	/// SCRIPTS & STYLES
	
	public function seo_styles() {
		
		global $post;
		global $cc_types;
		
		if(isset($post->post_type)) {
			if( $post->post_type == 'post' || $post->post_type == 'page' || in_array($post->post_type,$cc_types) ) { 
				
				wp_register_style( 'seo-styles', get_template_directory_uri() . '/framework/SEO/css/seo.css' );
				wp_enqueue_style( 'seo-styles' );
				
			}
		}
	}
	
	public function seo_scripts() {
		
		global $cc_types;
		global $post;
		
		if(isset($post->post_type)) {
			if( $post->post_type == 'post' || $post->post_type == 'page' || in_array($post->post_type,$cc_types) ) { 
			
				wp_register_script( 'seo-script', get_template_directory_uri() . '/framework/SEO/js/seo.js' );
				wp_enqueue_script( 'seo-script' );
				
			}  
		}

	} 
  
}

// RUN
new SEO();
?>