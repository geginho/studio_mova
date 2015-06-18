<?php 

function optionsframework_admin_init() 
{
	// Rev up the Options Machine
	global $of_options, $options_machine;
	$options_machine = new Options_Machine($of_options);
}

/**
 * Create Options page
 *
 * @uses add_theme_page()
 * @uses add_action()
 *
 * @since 1.0.0
 */

/* 
 add_action('admin_menu', 'register_test_plugin');
 
	function register_test_plugin() {
		add_submenu_page( 'northeme_framework', 'Settings', 'Settings', 'administrator', 'northeme_framework_settings', 'northeme_framework_settings' );
	}

	function northeme_framework_settings() {
		 
	}
*/

function optionsframework_add_admin() {
	
    $of_page = add_menu_page( THEMENAME, THEMENAME, 'edit_theme_options', 'northeme_framework', 'optionsframework_options_page',ADMIN_DIR.'/assets/images/northeme_admin.png',58);

	// Add framework functionaily to the head individually
	add_action("admin_print_scripts-$of_page", 'of_load_only');
	add_action("admin_print_styles-$of_page",'of_style_only');
	add_action( "admin_print_styles-$of_page", 'optionsframework_mlu_css', 0 );
	add_action( "admin_print_scripts-$of_page", 'optionsframework_mlu_js', 0 );	
	
}

/**
 * Build Options page
 *
 * @since 1.0.0
 */
function optionsframework_options_page(){
	
	global $options_machine;
	/*
	//for debugging
	$data = get_option(OPTIONS);
	print_r($data);
	*/	
	
	include_once( ADMIN_PATH . 'front-end/options.php' );

}

/**
 * Create Options page
 *
 * @uses wp_enqueue_style()
 *
 * @since 1.0.0
 */
function of_style_only(){
	wp_enqueue_style('admin-style', ADMIN_DIR . 'assets/css/admin-style.css');
	wp_enqueue_style('fontselect', ADMIN_DIR . 'assets/css/fontselect.css');
	wp_enqueue_style('color-picker', ADMIN_DIR . 'assets/css/colorpicker.css');
}	

/**
 * Create Options page
 *
 * @uses add_action()
 * @uses wp_enqueue_script()
 *
 * @since 1.0.0
 */
function of_load_only() 
{
	add_action('admin_head', 'of_admin_head');
	
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-sortable');
	wp_enqueue_script('jquery-input-mask', ADMIN_DIR .'assets/js/jquery.maskedinput-1.2.2.js', array( 'jquery' ));
	wp_enqueue_script('tipsy', ADMIN_DIR .'assets/js/jquery.tipsy.js', array( 'jquery' ));
	wp_enqueue_script('color-picker', ADMIN_DIR .'assets/js/colorpicker.js', array('jquery'));
	wp_enqueue_script('ibutton', ADMIN_DIR .'assets/js/ibutton.js', array('jquery'));
	wp_enqueue_script('fontselect-js', ADMIN_DIR .'assets/js/jquery.fontselect.js', array('jquery'));
	wp_localize_script('fontselect-js', 'wpurl', array( 'siteurl' => get_template_directory_uri() ));
	wp_enqueue_script('ajaxupload', ADMIN_DIR .'assets/js/ajaxupload.js', array('jquery'));
	wp_enqueue_script('cookie', ADMIN_DIR . 'assets/js/cookie.js', 'jquery');
	wp_enqueue_script('smof', ADMIN_DIR .'assets/js/smof.js', array( 'jquery' ));
	wp_localize_script('smof', 'wpurl', array( 'siteurl' => get_template_directory_uri() ));
}

/**
 * Front end inline jquery scripts
 *
 * @since 1.0.0
 */
function of_admin_head() { ?>
		
	<script type="text/javascript" language="javascript">

	jQuery.noConflict();
	jQuery(document).ready(function($){
	
		// COLOR Picker			
		$('.colorSelector').each(function(){
			var Othis = this; //cache a copy of the this variable for use inside nested function
				
			$(this).ColorPicker({
					color: '<?php if(isset($color)) echo $color; ?>',
					onShow: function (colpkr) {
						$(colpkr).fadeIn(500);
						return false;
					},
					onHide: function (colpkr) {
						$(colpkr).fadeOut(500);
						return false;
					},
					onChange: function (hsb, hex, rgb) {
						$(Othis).children('div').css('backgroundColor', '#' + hex);
						$(Othis).next('input').attr('value','#' + hex);
						
					}
			});
				  
		}); //end color picker

	}); //end doc ready
	
	</script>
	
<?php }

/**
 * Ajax Save Options
 *
 * @uses get_option()
 * @uses update_option()
 *
 * @since 1.0.0
 */
 
function of_ajax_callback() 
{
	global $options_machine, $of_options, $wpdb;

	$nonce=$_POST['security'];
	
	if (! wp_verify_nonce($nonce, 'of_ajax_nonce') ) die('-1'); 
			
	//get options array from db
	$all = get_option(OPTIONS);
	
	$save_type = $_POST['type'];
	//echo $_POST['data'];
	
	//Uploads
	if($save_type == 'upload')
	{
		
		$clickedID = $_POST['data']; // Acts as the name
		$filename = $_FILES[$clickedID];
       	$filename['name'] = preg_replace('/[^a-zA-Z0-9._\-]/', '', $filename['name']); 
		
		$override['test_form'] = false;
		$override['action'] = 'wp_handle_upload';    
		$uploaded_file = wp_handle_upload($filename,$override);
		 
			$upload_tracking[] = $clickedID;
				
			//update $options array w/ image URL			  
			$upload_image = $all; //preserve current data
			
			$upload_image[$clickedID] = $uploaded_file['url'];
			
			update_option(OPTIONS, $upload_image ) ;
		
				
		 if(!empty($uploaded_file['error'])) {echo 'Upload Error: ' . $uploaded_file['error']; }	
		 else { echo $uploaded_file['url']; } // Is the Response
		 
	}
	elseif($save_type == 'image_reset')
	{
			
			$id = $_POST['data']; // Acts as the name
			
			$delete_image = $all; //preserve rest of data
			$delete_image[$id] = ''; //update array key with empty value	 
			update_option(OPTIONS, $delete_image ) ;
	
	}
	elseif($save_type == 'backup_options')
	{
			
		$backup = $all;
		$backup['backup_log'] = date('r');
		
		update_option(BACKUPS, $backup ) ;
			
		die('1'); 
	}
	elseif($save_type == 'restore_options')
	{
			
		$data = get_option(BACKUPS);
		
		update_option(OPTIONS, $data);
		
		die('1'); 
	}
	elseif($save_type == 'import_options'){
			
		$data = $_POST['data'];
		$data = unserialize(base64_decode($data)); //100% safe - ignore theme check nag
		update_option(OPTIONS, $data);
		
		die('1'); 
	}
	elseif($save_type == 'movepost_works'){
		
		if(isset($_POST['oldpost']) && isset($_POST['newpost'])) {
			$oldlink = esc_sql($_POST['oldpost']);
			$newlink = esc_sql($_POST['newpost']);
			
			$wpdb->query("UPDATE $wpdb->posts SET post_type='".$newlink."' WHERE post_type='".$oldlink."' AND post_status='publish'");
		
		
			if($_POST['oldpost']=="post") {
				$term1 = esc_sql("category");
			}else{
				$term1 = esc_sql($_POST['oldpost']."-categories");
			}
			
			if($_POST['newpost']=="post") {
				$term2 = esc_sql("category");
			}else{
				$term2 = esc_sql($_POST['newpost']."-categories");
			}
			
			$wpdb->query("UPDATE 
			".$wpdb->term_taxonomy."
			SET taxonomy='".$term2."'
			WHERE taxonomy='".$term1."'");
				
			die('1');
		} 
	}
	elseif($save_type == 'migrate_works'){
		
		if(isset($_POST['oldlink']) && isset($_POST['newlink'])) {
			$oldlink = $_POST['oldlink'];
			$newlink = $_POST['newlink'];
			
			if($oldlink!="" && $oldlink!="") {
				$wmedia = $wpdb->get_var("SELECT option_value FROM $wpdb->options WHERE option_name = 'drone_options'");
				
				$work_media = unserialize($wmedia);
				
				if(is_array($work_media)) {
					$work_media = str_replace($oldlink,$newlink,$work_media);
					$wpdb->query("UPDATE $wpdb->options SET option_value = '".esc_sql(serialize($work_media))."' WHERE option_name = 'drone_options'");
				}
				
				$wmedia = $wpdb->get_var("SELECT option_value FROM $wpdb->options WHERE option_name = 'drone_backups'");
				
				$work_media = unserialize($wmedia);
				
				if(is_array($work_media)) {
					$work_media = str_replace($oldlink,$newlink,$work_media);
					$wpdb->query("UPDATE $wpdb->options SET option_value = '".esc_sql(serialize($work_media))."' WHERE option_name = 'drone_backups'");
				}
				
				$wmedia = $wpdb->get_results("SELECT ID FROM $wpdb->posts WHERE post_type='works'");
				
				foreach($wmedia as $foo) {
					$work_media = unserialize(get_post_meta( $foo->ID, 'work-media', true ));
					$work_media = str_replace($oldlink,$newlink,$work_media);
					update_post_meta($foo->ID, 'work-media', serialize($work_media));
				}
			}
		}
		die('1'); 
	}
	elseif ($save_type == 'save')
	{
		global $wpdb;
		
		wp_parse_str(stripslashes($_POST['data']), $data);
		
		$osettings = get_option(OPTIONS);
		
		// create an empty array
		$cparray = array();
		
		foreach($data['md_custom_posts'] as $k => $v) {
			
			if(
			  	(
				 $data['md_custom_posts'][$k]['title']=='' || 
				 $data['md_custom_posts'][$k]['slug']=='' || 
				 $data['md_custom_posts'][$k]['singular']=='' ||
				 $data['md_custom_posts'][$k]['plural']=='' || 
				 $data['md_custom_posts'][$k]['categoryname']=='' || 
				 $data['md_custom_posts'][$k]['categorytitle']=='' || 
				 $data['md_custom_posts'][$k]['categorysingletitle']=='' || 
				 $data['md_custom_posts'][$k]['categoryslug']==''
				 )
			   ) 
			{
				$notgood = 1;
			}
			
			if(isset($osettings['md_custom_posts'][$k]['home_url'])) {
				$data['md_custom_posts'][$k]['home_url'] = $osettings['md_custom_posts'][$k]['home_url'];
			}
			if(isset($notgood) || in_array($data['md_custom_posts'][$k]['title'],$cparray)) { 
				unset($data['md_custom_posts'][$k]);
			}else{
				$data['md_custom_posts'][$k]['title'] = seoUrl(strtolower(str_replace(' ','-',$data['md_custom_posts'][$k]['title'])));
				$data['md_custom_posts'][$k]['slug'] = seoUrl(strtolower(str_replace(' ','-',$data['md_custom_posts'][$k]['slug'])));
				$data['md_custom_posts'][$k]['categoryslug'] = seoUrl(strtolower(str_replace(' ','-',$data['md_custom_posts'][$k]['categoryslug'])));
				array_push($cparray,$data['md_custom_posts'][$k]['title']);
			}
			
			unset($notgood);
		}
		
		if(isset($data['md_custom_posts_ordering']) && is_array($data['md_custom_posts_ordering'])) {
			foreach($data['md_custom_posts_ordering'] as $foo) {
				$cnt=1;
				foreach($foo as $v) {
					$wpdb->query("UPDATE ".$wpdb->posts." SET 
					menu_order='".intval($cnt)."' 
					WHERE ID='".intval($v['id'])."'");
					
					$cnt++;
				}
					
			}
		}
		
		
		/// CREATE TERMS ORDERING COLUMNS 
		$gets = $wpdb->get_var("SHOW COLUMNS FROM ".$wpdb->terms." LIKE 'term_ordering'");
		if(!$gets) {
			$wpdb->query("ALTER TABLE ".$wpdb->terms." ADD term_ordering TINYINT");
		}

		//// SAVE TERMS ORDERING
		$cnt=0;
		
		if(isset($data['md_custom_taxonomy_ordering']) && is_array($data['md_custom_taxonomy_ordering'])) {
			foreach($data['md_custom_taxonomy_ordering'] as $k => $v) {
				
				$wpdb->query("UPDATE ".$wpdb->terms." SET 
				term_ordering='".intval($cnt)."'
				WHERE term_id=".intval($v['id']));
				
				$cnt++;
			}
		}
		
		
		/// SET AS 1
		$wpdb->query("UPDATE ".$wpdb->options." SET option_value=1 WHERE option_name='posts_per_page'");
		$wpdb->query("UPDATE ".$wpdb->options." SET option_value=0 WHERE option_name='page_for_posts'");
		
		unset($data['security']);
		unset($data['of_save']);
			
		update_option(OPTIONS, $data);
		
		echo $url = admin_url( 'admin.php?page=northeme_framework&flush=1');
		
		die('1');
	}
	elseif ($save_type == 'reset')
	{
		update_option(OPTIONS,$options_machine->Defaults);
		
        die('1'); //options reset
	}

  	die();
}