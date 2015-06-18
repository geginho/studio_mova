<?php 

/************************************************************
/* AJAX CALLS
/************************************************************/

add_action( "wp_ajax_md_get_mainmenu", "md_get_mainmenu" );
add_action( "wp_ajax_md_work_post", "js_cpt_type" );
add_action( "wp_ajax_md_work_post", "md_work_post" );
add_action( "wp_ajax_nopriv_md_work_post", "md_work_post" );
add_action( "wp_ajax_md_work_all_post", "md_work_all_post" );
add_action( "wp_ajax_nopriv_md_work_all_post", "md_work_all_post" );
add_action( "wp_ajax_md_quickslide", "md_quickslide" );
add_action( "wp_ajax_nopriv_md_quickslide", "md_quickslide" );
add_action('comment_post', 'ajaxify_comments',20, 2);



if ( ! function_exists( 'md_get_mainmenu' ) ) {

function md_get_mainmenu() {	
	
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
		
			 wp_nav_menu(array(
					'theme_location' => 'main_menu',
					'container' => '',
					'menu_class' => 'main-nav',
					'before' => '',
					'fallback_cb' => '',
					'walker' => new northeme_walker()
				));
						
			die();
		}
	
   }

}		
		

if ( ! function_exists( 'js_cpt_type' ) ) {

function js_cpt_type($type) {	
	
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
		
		if($md_thumbcount) { 
			$md_thumb_show = $md_thumbcount;
		}else{ 
			$md_thumb_show = 3; 
		}
		
		// TOTAL PADDING
		$md_perc_gap = $md_thumpadding;
		// TOTAL WIDTH
		$md_perc = 100-$md_perc_gap;
		
		return array($md_thumb_show, $md_perc,$md_perc_gap,$md_fixed_thumbs);
		
	}
}

		
		
if ( ! function_exists( 'md_work_post' ) ) {
	function md_work_post($type) {
		global $withcomments;
		$withcomments = true; 
		
		if ( !wp_verify_nonce( $_REQUEST['token'], "wp_token" ) ) {
			exit(0);
		}  
		
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			// GET POST
			if($_REQUEST['type']!="blog") {
				get_template_part( 'single', 'works-content' );	
			}
		}else {
			header("Location: ".$_SERVER["HTTP_REFERER"]);
		}
	
		die();
	}
}


if ( ! function_exists( 'md_work_all_post' ) ) {
	function md_work_all_post() {
	
		if ( !wp_verify_nonce( $_REQUEST['token'], "wp_token" ) ) {
			exit(0);
		}  
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			// GET POST
			
			if($_REQUEST['type']=="blog") {
				get_template_part( 'template', 'blog-content' );
			}else{
				get_template_part( 'template', 'works-content' );
			}
		}else {
			header("Location: ".$_SERVER["HTTP_REFERER"]);
		}
	
		die();
	}
}


/* Create PHP Handler ------------------------------------------------------------------[ajaxify_comments()]------- */


if ( ! function_exists( 'ajaxify_comments' ) ) {
	function ajaxify_comments($comment_ID, $comment_status){
		
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
			switch($comment_status){
				case "0":
					wp_notify_moderator($comment_ID);
				case "1": //Approved comment
				echo "success";
					$commentdata =& get_comment($comment_ID, ARRAY_A);
					$post =& get_post($commentdata['comment_post_ID']);
					wp_notify_postauthor($comment_ID, $commentdata['comment_type']);
				break;
				default:
				echo 0;
			}
		exit;
		}
	}
}

?>