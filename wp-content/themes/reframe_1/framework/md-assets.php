<?php
/************************************************************
/* Admin Area Scripts & Styles
/************************************************************/

add_action('admin_print_scripts', 'md_admin_scripts');
add_action('admin_print_styles', 'md_admin_styles');


if ( ! function_exists( 'strip_array_indices' ) ) {	
	function strip_array_indices( $ArrayToStrip ) {
		foreach( $ArrayToStrip as $objArrayItem) {
			$NewArray[] =  $objArrayItem;
		}
	 
		return( $NewArray );
	}
}

if ( ! function_exists( 'date_format_php_to_js' ) ) {	
	function date_format_php_to_js( $sFormat ) {
		switch($sFormat) {
			case 'F j, Y':
				return( 'MM dd, yy' );
			break;
			case 'Y/m/d':
				return( 'yy/mm/dd' );
			break;
			case 'm/d/Y':
				return( 'mm/dd/yy' );
			break;
			case 'd/m/Y':
				return( 'dd/mm/yy' );
			break;
		}
	}
}

if ( ! function_exists( 'md_admin_scripts' ) ) {	
	function md_admin_scripts() {
				
				global $pagenow, $current_screen, $post, $wp_locale;
				
				if (($pagenow=="post.php" || $pagenow=="post-new.php")) {
					
					/***************************************
					/* SCRIPTS
					/***************************************/
					//add the jQuery UI elements shipped with WP
					
					/// upload scripts
					wp_enqueue_script( 'media-upload' );
					wp_enqueue_script(
						'upload-js', 
						get_template_directory_uri().'/framework/field_upload.js', 
						array('jquery', 'thickbox', 'media-upload','jquery-ui-core', 'jquery-ui-datepicker'),
						time(),
						true
					);
					
					wp_localize_script('upload-js', 'wpurl', array( 'siteurl' => ADMIN_IMG_DIRECTORY ));
					
					wp_enqueue_style('thickbox');
					
					wp_enqueue_style('color-picker', get_template_directory_uri() . '/framework/options/assets/css/colorpicker.css');
				
				}
				
	}
}
	
if ( ! function_exists( 'md_admin_styles' ) ) {	
	function md_admin_styles() {
				global $pagenow, $current_screen;
				
				if (($pagenow=="post.php" || $pagenow=="post-new.php")) {
				/***************************************
				/* STYLES
				/***************************************/
				wp_enqueue_style( 'thickbox' ); /// upload
				wp_enqueue_style( 'custom', get_template_directory_uri() . '/framework/css/custom-fields.css' ); /// custom styles
				
				if($current_screen->post_type == 'post') {
					wp_enqueue_style( 'custom-blog', get_template_directory_uri() . '/framework/css/custom-fields-blog.css' ); /// custom styles
				}
				wp_enqueue_style( 'jquery-ui-css', get_template_directory_uri() . '/framework/css/jquery-ui-aristo/aristo.css' ); /// date picker
				wp_enqueue_script('color-picker-js', get_template_directory_uri() .'/framework/options/assets/js/colorpicker.js', array('jquery'));
				}
				
				wp_register_script( 'includes', get_template_directory_uri() . '/js/include.js');
				wp_enqueue_script( 'includes' );
				
		
	}
}


/************************************************************
/* wp_head() Front-End Scripts & Styles
/************************************************************/

add_action( 'wp_enqueue_scripts', 'md_add_wphead'); 
add_action( 'wp_footer', 'md_add_footer' ); 


if ( ! function_exists( 'md_add_wphead' ) ) {
	function md_add_wphead() {
		
		// Modernizr
		wp_register_script( 'modernizr', get_template_directory_uri() . '/js/modernizr.js' );
		wp_enqueue_script( 'modernizr' );
		
		// JQuery (Remove bundle ver. and include new)
		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', get_template_directory_uri() . '/js/jquery-1.11.0.min.js' );
		wp_enqueue_script( 'jquery' );
		
		wp_register_script( 'jquerymigrate', get_template_directory_uri() . '/js/jquery-migrate-1.2.1.js' );
		wp_enqueue_script( 'jquerymigrate' );
		
		wp_register_script( 'isotope', get_template_directory_uri() . '/js/jquery.isotope.min.js');
		wp_enqueue_script( 'isotope' );
		
		wp_register_script( 'galleria', get_template_directory_uri() . '/js/galleria-1.2.9.min.js');
		wp_enqueue_script( 'galleria' );
		
			
		?>
        <script type="text/javascript">// <![CDATA[
			if( window.devicePixelRatio !== undefined ) document.cookie = 'devicePixelRatio = ' + window.devicePixelRatio;
		// ]]></script>
        <?php
		
	}  
}


if ( ! function_exists( 'md_add_footer' ) ) {
	function md_add_footer() {
		global $add_the_googlemap;
		global $add_the_contactform;
 
	
		wp_register_script( 'JQ-gmap-api', 'http://maps.google.com/maps/api/js?sensor=false');	
		wp_register_script( 'gmap-main-script', get_template_directory_uri() . '/js/jquery.gmap.min.js');
		wp_enqueue_script( 'JQ-gmap-api' );
		wp_enqueue_script( 'gmap-main-script' );
	
		wp_register_script( 'swipebox', get_template_directory_uri() . '/js/jquery.swipebox.min.js');
		wp_enqueue_script( 'swipebox' );
			
		wp_register_script( 'flexslider', get_template_directory_uri() . '/js/jquery.flexslider-min.js');
		wp_enqueue_script( 'flexslider' );
		
		//wp_register_script( 'scrolltofixed', get_template_directory_uri() . '/js/jquery-scrolltofixed-min.js');
		//wp_enqueue_script( 'scrolltofixed' );
		
		wp_register_script( 'infinite', get_template_directory_uri() . '/js/jquery.infinitescroll.min.js');
		wp_enqueue_script( 'infinite' );
		
		wp_register_script( 'nicescroll', get_template_directory_uri() . '/js/jquery.nicescroll.min.js');
		wp_enqueue_script( 'nicescroll' );
		
		wp_register_script( 'fullscr', get_template_directory_uri() . '/js/screenfull.js');
		wp_enqueue_script( 'fullscr' );
		
		wp_register_script( 'includes', get_template_directory_uri() . '/js/include.js');
		wp_enqueue_script( 'includes' );
		
		wp_register_script( 'master', get_template_directory_uri() . '/js/master.js?'.rand());
		wp_enqueue_script( 'master' );
		
		
			if(of_get_option('md_master_ajax_disable')) { 
				$wajax = 0;
			}else{
				$wajax = 1;	
			}
		
		
		if(is_single()) {
			
			global $post;
			$customtypes = of_get_option('md_custom_posts');
		
			//$i=1;
			foreach($customtypes as $k => $v) {
				if($v['title']==$post->post_type) { 
					$page_type = $k;
					break;
				}
				//$i++;
			}
		
		}else{
			global $page_type;
			if(!isset($page_type)) {
				$page_type = getCustomPage();
			}
			
			global $customtypes;
			if(!isset($customtypes)) {
				$customtypes = of_get_option('md_custom_posts');
			}
		}
		
		
		
		$postname = '';
		$md_thumbcount = 3;
		$md_thumpadding = 7;
		$md_fixed_thumbs = 0;
		
		if(isset($page_type) && $page_type!='') {
			$vartype = $customtypes[$page_type];
			
			$postname = $vartype['title'];
			$md_thumbcount = $vartype['thumbnail'];
			$md_thumpadding = $vartype['thumbnailpadding'];
			$md_fixed_thumbs = ($vartype['fixedthumbs']);
		}
	
	
		// SLIDER DURATION
		if(of_get_option('md_slider_duration')) { 
			$slider_duration = of_get_option('md_slider_duration');
		}else{ 
			$slider_duration = '7000'; 
		}
		
		if(of_get_option('md_slider_speed')) { 
			$fade_duration = of_get_option('md_slider_speed');
		}else{ 
			$fade_duration = '1800'; 
		}
		
		if(of_get_option('md_slider_animation')) { 
			$slider_anim_type = of_get_option('md_slider_animation');
		}else{ 
			$slider_anim_type = 'fade'; 
		}
		
		if($md_thumbcount) { 
			$md_thumb_show = $md_thumbcount;
		}else{ 
			$md_thumb_show = 3; 
		}
				
		if(of_get_option('md_css_scrollbar')) { 
			$md_scrollbarcolor = of_get_option('md_css_scrollbar');
		}else{ 
			$md_scrollbarcolor = '#ccc'; 
		}
			
			
		if(of_get_option('md_border_disable')) { 
			$wborder = 0; 
		}else{ 
			$wborder = 40;
		}
			
		
		// TOTAL PADDING
		$md_perc_gap = $md_thumpadding;
		// TOTAL WIDTH
		$md_perc = 100-$md_perc_gap;
				
				
		//// IF IT'S FULL SLIDER PAGE
		$thisisslider=0;		
		if(is_page_template ( 'template-fullslider.php' )) {
			$thisisslider=1;
		}


			// SLIDER DURATION
		if(of_get_option('md_gallery_transition')) { $gal_tr = of_get_option('md_gallery_transition');}else{ $gal_tr = 'fade'; }
		if(of_get_option('md_gallery_transition_speed')) { $gal_tr_speed = of_get_option('md_gallery_transition_speed');}else{ $gal_tr_speed = 500; }
		if(of_get_option('md_gallery_crop')) { $gal_crop = 'true'; }else{ $gal_crop = 'false'; }
		
		if(of_get_option('md_gallery_dtap')) { $gal_tr_dtap = 'false'; }else{ $gal_tr_dtap = 'true'; }
		if(of_get_option('md_gallery_fullscreen')) { $gal_tr_fullscreen = 'false'; }else{ $gal_tr_fullscreen = 'true'; }
		
		if(of_get_option('md_gallery_slideshow_autostart')==1) { 
			$gal_slide_speed = of_get_option('md_gallery_slideshow_speed');
		}else{ 
			$gal_slide_speed = 10000000000; 
		}
				
				
		if(of_get_option('md_slider_hover')) { $flexhover = 'true'; }else{ $flexhover = 'false'; }
		
		if(of_get_option('md_gallery_preload')) { $gal_tr_preload = 0; }else{ $gal_tr_preload = 2; }
		
		
		$pagination_type = of_get_option('md_pagination_type');
		
		$nicescroll = of_get_option('md_nicescroll_disable');
		
		$showbw = of_get_option('md_custompost_showbw');
		
		$postslider = of_get_option('md_slider_disable_autoplay');
		$custompost_transition = of_get_option('md_custompost_transition');
		
		if($postslider==1) {
			$sliderautoplay = 0;	
		}else{
			$sliderautoplay = 1;	
		}
		
		$disablelightbox = 0;
		if (of_get_option('md_lightbox_itself')) {
			$disablelightbox = 1;
		}		
		
		if(of_get_option('md_removeheader')==1) { 
			$removeheader = 1;
		}else{
			$removeheader = 0;
		}
				
			$ajaxvararr = array(
				'slider_duration'=>$slider_duration,
				'slider_fade_duration'=>$fade_duration,
				'slider_anim_type'=>$slider_anim_type,
				'slider_autostart'=>$sliderautoplay,
				'flexhover'=>$flexhover,
				'gallery_preload'=>$gal_tr_preload,
				'gallery_transition'=>$gal_tr,
				'gallery_transition_speed'=>$gal_tr_speed,
				'gallery_slideshow_speed'=>$gal_slide_speed,
				'gallery_crop'=>$gal_crop,
				'gallery_dtap'=>$gal_tr_dtap,
				'gallery_fs'=>$gal_tr_fullscreen,
				'disablelightbox'=>$disablelightbox,
				'thisisfullslider'=>$thisisslider,
				'custompost_transition'=>$custompost_transition,
				'removeheader'=>$removeheader,
				'nicescroll'=>$nicescroll,
				'showbw'=>$showbw,
				'thumbcount'=>$md_thumb_show,
				'withborder'=>$wborder,
				'withajax'=>$wajax,
				'pagination_type'=>$pagination_type,
				'total_width'=>$md_perc,
				'total_padding'=>$md_perc_gap,
				'home_full'=>of_get_option('md_home_full'),
				'works_full'=>of_get_option('md_works_full'),
				'float_menu_disable'=>of_get_option('md_js_float_menu_disable'),
				'float_works_disable'=>of_get_option('md_js_float_works_disable'),
				'fixed_thumbs'=>$md_fixed_thumbs,
				'scrollbarcolor'=>$md_scrollbarcolor,
				'ajax'=>admin_url( 'admin-ajax.php'),
				'tempdir'=>get_template_directory_uri()
			);
			
		wp_localize_script('master', 'scvars', $ajaxvararr);	
		
				
			
	}  
}


?>