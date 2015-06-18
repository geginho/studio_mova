<?php
/************************************************************
/* OPTIONS FRAMEWORK
/************************************************************/
define('OPTIONS', 'drone_options');
define('BACKUPS','drone_backups' );

require_once ('framework/options/index.php');

// PATHS
define('THEME_FILEPATH', get_template_directory());
define('THEME_DIRECTORY', get_template_directory_uri());
define('ADMIN_IMG_DIRECTORY', get_template_directory_uri().'/framework/options/assets/images/');


/************************************************************
/* CUSTOM POST DEFAULT VALUES
/************************************************************/

		$custompostvals['title'] = "works"; // post name / slug
		$custompostvals['singular'] = "Project"; // single name
		$custompostvals['plural'] = "Works"; // name
		$custompostvals['slug'] = "works"; // slug
		
		$custompostvals['categoryname'] = "Creative Fields"; // category name
		$custompostvals['categorytitle'] = "Add New Field"; // 
		$custompostvals['categorysingletitle'] = "Field"; // 
		$custompostvals['categoryslug'] = "field"; // 
		$custompostvals['color'] = ''; // 	
		$custompostvals['withbg'] = 0; // 	
		$custompostvals['dropdown'] = 0; // 	
		$custompostvals['dropdowntitle'] = '';
		$custompostvals['hideheader'] = 0;
		$custompostvals['thumbnail'] = 3;
		$custompostvals['removesidemargin'] = 0; // 
		$custompostvals['pagination'] = 0; // 
		$custompostvals['showcategory'] = 0; // 
		$custompostvals['showsinglecategory'] = 0; // 
		$custompostvals['showexcerpt'] = 1;
		$custompostvals['showtitle'] = 1;
		$custompostvals['showdate'] = 0; // 
		$custompostvals['showcategorypost'] = 0; // 
		$custompostvals['projectinfo'] = 0; // 
		$custompostvals['orderby'] = 0; // 
		$custompostvals['thumbnailpadding'] = 6; //
		$custompostvals['fixedthumbs'] = 0; //
		$custompostvals['thumbnailcaption'] = 'Below'; //
		$custompostvals['home_url'] = get_home_url();
		$custompostvals['thumbbgcolor'] = '#000'; //
		$custompostvals['thumbfontcolor'] = '#fff'; //
		$custompostvals['thumbbgtransparent'] = 0; //
		$custompostvals['navigation_text'] = 0; //
		$custompostvals['navigation_hide'] = 0; //
		
		$custompostvals['related_switch'] = 1; //
		$custompostvals['related_title'] = 'RELATED PROJECTS'; //
		$custompostvals['related_thumbnail'] = 'medium'; //
		$custompostvals['related_postlimit'] = 3; //
		$custompostvals['related_category'] = 0; //
		$custompostvals['related_random'] = 0; //

$optionsframework_settings = get_option('drone_options');
	
if ( !function_exists( 'of_get_option' ) ) {
	function of_get_option($name, $default = false) {
			/// for custom
			global $custompostvals;
			
			global $optionsframework_settings;
		
			if((!isset($optionsframework_settings['md_custom_posts']) || !is_array($optionsframework_settings['md_custom_posts'])) && $name=='md_custom_posts' && !$default) {
				$varm[1] = $custompostvals;
				return $varm;
			}
			
			
			if(isset($optionsframework_settings[$name])) {
				$option_name = $optionsframework_settings[$name];
			}
			
			if (isset($option_name)) {
				return $option_name;
			}else{
				return false;
			}
	}
}





/************************************************************
/* URL FILTER
/************************************************************/

	function seoUrl($url) {
		// Make sure string is in UTF-8 and strip invalid UTF-8 characters
		return sanitize_title($url);
	}


/************************************************************
/* MAKE URL FUNCTION
/*****************/

function northeme_make_clickable($w) { 
	$clickable = make_clickable($w);
	$target_blank = preg_replace('/<a /','<a target="_blank" ',$clickable);
	$make = str_replace('>http://www.','>',$target_blank);
	$make = str_replace('>http://','>',$make);
	$make = str_replace('>www.','>',$make);
	return $make;
}
	


/************************************************************
/* Theme Settings
/************************************************************/
add_theme_support( 'menus' ); // add custom menus support
add_theme_support('automatic-feed-links');
add_theme_support('post-thumbnails');
add_filter('widget_text', 'do_shortcode');

add_action('init', 'my_custom_init');

add_editor_style();

add_theme_support( 
		'post-formats', 
		array(
			'gallery',
			'image',
			'link',
			'quote',
			'video'
		) 
	);
	
		
// Excerpt
function my_custom_init() {
	add_post_type_support( 'page', 'excerpt' );
	add_post_type_support( 'post', 'excerpt' );
	add_post_type_support( 'works', 'excerpt' );
}

// Remove rel attribute from the category list
function remove_category_list_rel($output)
{
  $output = str_replace(' rel="category tag"', '', $output);
  return $output;
}
add_filter('wp_list_categories', 'remove_category_list_rel');
add_filter('the_category', 'remove_category_list_rel');



/// INCLUDE WORKS INTO SEARCH
$customtypes = of_get_option('md_custom_posts');
		
//$i=1;
$posttypes = array();
if(is_array($customtypes)) {
	foreach($customtypes as $k => $v) {
		array_push($posttypes,$v['title']);
	}	
}

if(!is_admin()) {
	add_filter('pre_get_posts', 'filter_search');
				
	if ( ! function_exists( 'filter_search' ) ) {
		function filter_search($query) {
			
			global $posttypes;
			
			if ($query->is_search) {
			
			array_push($posttypes,'post');
			array_push($posttypes,'page');
			
			$query->set('post_type', $posttypes);
			};
			return $query;
		};
	}	
}




// Translation files can be added to /languages directory
load_theme_textdomain( 'northeme', TEMPLATEPATH . '/languages' );

$locale = get_locale();
$locale_file = TEMPLATEPATH."/languages/$locale.php";
if ( is_readable($locale_file) )
	require_once($locale_file);
	




function is_any_single($tp) {
  global $posttypes;
  $post_type = get_post_type();
  if(is_single() && in_array($post_type,$posttypes)) {
  	return 1;
  }
}

/************************************************************
/* Featured Image Sizes
/************************************************************/

	
	$thumbs_mini_w = 150;
	$thumbs_mini_h = 100;
	
	$thumbs_small_w = 260;
	$thumbs_small_h = 99999;
	
	$thumbs_medium_w = 420;
	$thumbs_medium_h = 99999;
	
	$thumbs_large_w = 620;
	$thumbs_large_h = 99999;
	
	$thumbs_fixed_w = 650;
	$thumbs_fixed_h = 470;
	
	$thumbs_blog_w = 800;
	$thumbs_blog_h = 99999;
	
	
	set_post_thumbnail_size(100, 100, true);
	add_image_size('md_post_thumb_mini', $thumbs_mini_w, $thumbs_mini_w, true);
	add_image_size('md_post_thumb_small', $thumbs_small_w, $thumbs_small_h, false);
	add_image_size('md_post_thumb_medium', $thumbs_medium_w, $thumbs_medium_h, false);
	add_image_size('md_post_thumb_large', $thumbs_large_w, $thumbs_large_h, false);
	add_image_size('md_post_thumb_fixed', $thumbs_fixed_w, $thumbs_fixed_h, true);
	add_image_size('md_post_thumb_blog', $thumbs_blog_w, $thumbs_blog_h, false);
	
	
	/************************************************************
	/* Create @2x Images for Retina Display
	/************************************************************/
	if(of_get_option('md_retina_support')!=1) { 
		add_image_size( 'md_post_thumb_mini@2x', $thumbs_mini_w * 2, $thumbs_mini_w * 2, true );
		add_image_size( 'md_post_thumb_small@2x', $thumbs_small_w * 2, $thumbs_small_h * 2, false );
		add_image_size( 'md_post_thumb_medium@2x', $thumbs_medium_w * 2, $thumbs_medium_h * 2, false );
		add_image_size( 'md_post_thumb_large@2x', $thumbs_large_w * 2, $thumbs_large_h * 2, false );
		add_image_size( 'md_post_thumb_fixed@2x', $thumbs_fixed_w * 2, $thumbs_fixed_h * 2, true );
		add_image_size( 'md_post_thumb_blog@2x', $thumbs_blog_w * 2, $thumbs_blog_h * 2, false );
	}


// IMAGE QUALITY
function gpp_jpeg_quality_callback($arg) {
	return (int)98; // change 100 to whatever you prefer, but don't go below 60
}

add_filter('jpeg_quality', 'gpp_jpeg_quality_callback');

add_filter( 'post_thumbnail_html', 'remove_width_attribute', 10 );
add_filter( 'image_send_to_editor', 'remove_width_attribute', 10 );

function remove_width_attribute( $html ) {
   $html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
   return $html;
}


function getThumb($th,$pid=false) {
	global $post;
	
	$post_id = $post->ID;
	
	if($pid) {
		$post_id = $pid;
	}
	
	$thumbsize = 'full';
	
	switch($th) {
		case 'mini':
		  $thumbsize = 'md_post_thumb_mini';
		break;
		case 'small':
		  $thumbsize = 'md_post_thumb_small';
		break;
		case 'medium':
		  $thumbsize = 'md_post_thumb_medium';
		break;
		case 'large':
		  $thumbsize = 'md_post_thumb_large';
		break;
		case 'fixed':
		  $thumbsize = 'md_post_thumb_fixed';
		break;
		case 'blog':
		  $thumbsize = 'md_post_thumb_blog';
		break;
	}

	if ( isset( $_COOKIE['devicePixelRatio'] ) && $_COOKIE['devicePixelRatio'] > 1.5 && of_get_option('md_retina_support')!=1) $thumbsize = $thumbsize.'@2x';
	
	//$img = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), $thumbsize );
	//return array($img[0],$thumbsize);
	$imgsrc = get_the_post_thumbnail( $post_id, $thumbsize, '' );
	return array($imgsrc,$thumbsize);
}






/************************************************************
/* Widgets & Shortcodes
/************************************************************/

//// Excerpt Length
add_theme_support('excerpt');

function custom_excerpt_length( $length ) {
	return 20;
}
function new_excerpt_more( $more ) {
	return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');
add_filter('excerpt_length', 'custom_excerpt_length', 999 );

							
/************************************************************
/* Share Funcs
/************************************************************/
function showshareingpost($url,$img, $title, $code=false,$top=false) { 

	$output = '';
	
	if(of_get_option('md_social_post_facebook')) {
		if(!$code) {
	$output .= '<div class="facebook shr"><div class="fb-like" data-href="'.$url.'" style="top:-2px;margin-bottom:3px;position:relative" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div></div>';
	if($top) $output .= '<br class="clear">';
		}else{
	$output .='';
		}
	}
	
	if(of_get_option('md_social_post_twitter')) {
		if(!$code) {
	$output .= '<div class="twitter shr"><a href="https://twitter.com/share" class="twitter-share-button" data-count="none" data-url="'.$url.'" data-text="'.$title.'">Tweet</a></div>';
		if($top) $output .= '<br class="clear">';
		}else{
	$output .= '<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>'; 
		}
	}

	if(of_get_option('md_social_post_googleplus')) {
		if(!$code) {
	$output .= '<div class="googleplus shr"><div class="g-plusone" data-size="medium" data-annotation="none"></div></div>';
		if($top) $output .= '<br class="clear">';
		}else{
	$output .= '<script type="text/javascript">
  	(function() {
    var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true;
    po.src = \'https://apis.google.com/js/plusone.js\';
    var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s);
  	})();</script>'; 
		}
	}
	
	if(of_get_option('md_social_post_pinterest')) {
		if(!$code) {
	$output .= '<div class="pinterest shr"><a href="http://pinterest.com/pin/create/button/?url='.urlencode($url).'&amp;media='.urlencode($img).'&amp;description='.urlencode($title).'" class="pin-it-button"><img style="border:none" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a></div>';
		if($top) $output .= '<br class="clear">';
		}else{
	$output .= '<script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>'; 
		}
	}
	
	if(of_get_option('md_social_post_tumblr')) {
		if(!$code) {
	$output .= '<div class="tumblr shr"><a href="http://www.tumblr.com/share" title="Share on Tumblr" style="display:inline-block; text-indent:-9999px; overflow:hidden; width:22px; height:20px; background:url(\'http://platform.tumblr.com/v1/share_4.png\') top left no-repeat transparent;"></a></div>';
		}else{
	$output .= '<script type="text/javascript" src="http://platform.tumblr.com/v1/share.js"></script>'; 
		}
	}
	
	
	if(of_get_option('md_social_post_linkedin')) {
		if(!$code) {
	$output .= '<div class="linkedin shr"><script src="//platform.linkedin.com/in.js" type="text/javascript">lang: en_US</script><script type="IN/Share" data-url="'.urlencode($url).'" data-counter="right"></script></div>';
		}
	}
	
	
	if(of_get_option('md_social_post_vkshare')) {
		if(!$code) { 
		$output .= '<a href="http://vkontakte.ru/share.php?url='.urlencode($url).'" target="_blank"><img src="'.get_template_directory_uri().'/images/vksharing.png"></a>'; 	
		}
	}

	
	return $output;

}

function showSharing() {
	

	$iconvar = of_get_option('md_social_icons');
	$iconvarcolor = of_get_option('md_css_socialiconcolors');
	

	$s=0;
	
	if(isset($iconvar['type']) && is_array($iconvar['type'])) {
		foreach($iconvar['type'] as $v) {
			
			 if(strpos($v,'icon-')===false) {
				echo '<a href="'.$iconvar['link'][$s].'" target="_blank"><i class="new-social-icons" style="color:'.$iconvarcolor.'">'.($v).'</i></a>';	
			  }else{
				echo '<a href="'.$iconvar['link'][$s].'" target="_blank"><i class="'.$v.' fawsome" style="color:'.$iconvarcolor.'"></i></a>';	
			  }

			  $s++;
		}
	
	}
	
}                 
	

		
						
/************************************************************
/* PROJECT NAVIGATION
/************************************************************/

if ( ! function_exists( 'getNextBack' ) ) {
	function getNextBack($w, $type, $current, $current2,$oby) {
		
		global $wpdb;
		
		if($type!='blog' && $oby==1) {
			
			$ordering1 = "menu_order";	
			$take = $current;	
			if($w=="next") { 
				$whr = ">";
				$ordering = "asc";
			}else{
				$whr = "<";	
				$ordering = "desc";
			}
			
		}else{
			
			$ordering1 = "post_date";
			$take = $current2;	
			if($w=="prev") { 
				$whr = ">";
				$ordering = "asc";
			}else{
				$whr = "<";	
				$ordering = "desc";
			}
		
		}
		
	  	$myrows = $wpdb->get_row( "SELECT ID, post_title FROM ".$wpdb->posts." WHERE post_type='$type' AND post_status='publish' AND $ordering1 $whr '$take' order by $ordering1 $ordering limit 1" );
		
		
		if(isset($myrows->ID)) {
				return array(
				'post_title'=>$myrows->post_title,
				'ID'=>$myrows->ID
				);
		}
	}
}


	
	
if ( ! function_exists( 'getCustomPage' ) ) {
	function getCustomPage() { 	
		global $post;
		global $wpdb;
		global $wp_query;
		
		if(isset($post) && $post->post_type=='page') {
			
			$page_type = get_post_meta( $post->ID, 'page-custom-type', true );
			
		}elseif(isset($_REQUEST['type'])){
			
			$page_type = $_REQUEST['type'];
			
		}elseif(isset($wp_query)){
			
			$customtypes = of_get_option('md_custom_posts');
			
			$post_obj = $wp_query->get_queried_object();
			
			$post_title_by = '';
			
			if(isset($post_obj->post_type)) {
				$post_title_by = $post_obj->post_type;
			}elseif(isset($post_obj->taxonomy)) {
				$post_title_by = str_replace('-categories','',$post_obj->taxonomy);
			}
			
			//$i=1;
			
			if(is_array($customtypes)) {
				foreach($customtypes as $k => $v) {
					if($v['title']==$post_title_by) { 
						$page_type = $k;
						break;
					}
					//$i++;
				}
			}
			
		}
		if(isset($page_type))
			return $page_type;	
	}
}	
		
		

/************************************************************
/* MAKE URL
/************************************************************/


if ( ! function_exists( 'makeClickableLinks' ) ) {	
	function makeClickableLinks($s) {
	  return preg_replace_callback('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', 'makeClickableLinkscallbackFunc', $s);
	}
}

if ( ! function_exists( 'makeClickableLinkscallbackFunc' ) ) {	
	function makeClickableLinkscallbackFunc($matches) {
		
		if(strlen($matches[1]) > 32) {
			$lnk = substr($matches[1],0,32).'...';
		}else{
			$lnk = $matches[1];
		}
	
		return '<a href="'.$matches[1].'" target="_blank">'.$lnk.'</a>';
	}
}


						
/************************************************************
/* SITE COLORS
/************************************************************/


if ( ! function_exists( 'siteColors' ) ) {
	function siteColors() {
			
		// DEFAULT GOOGLE FONT
		$md_googlefont = "Source Sans";
		
			
		$md_font_type = of_get_option('md_font_type');
	
		/// GET SITE COLORS & GOOGLE FONTS
		
		/// FONT SIZE
		$md_body_fontsize = of_get_option('md_body_fontsize');
		if(isset($md_body_fontsize['size'])) { $md_body_fontsize = $md_body_fontsize['size']; } else { $md_body_fontsize = '14px'; }
	
		$header_font_path = '';
		$body_font_path = '';
		
		if($md_font_type=='googlefonts') {
			$header_font = '"'.of_get_option('md_css_googlefont_header').'"';
			$body_font = '"'.of_get_option('md_css_googlefont').'"';
		}elseif($md_font_type=='htmlfonts') {
			$myhtmlfont = of_get_option('md_css_htmlfont');
			$header_font = $myhtmlfont;
			$body_font = $myhtmlfont;
		}else{
			$header_font = '"mainfont"';
			$body_font = '"mainfont"';
			
			$header_font_path = of_get_option('md_css_fontface_bold');
			$body_font_path = of_get_option('md_css_fontface_regular');
			
			if(empty($header_font_path)) {
				$header_font_path = 'museo/museosans_500-webfont';
			}
			if(empty($body_font_path)) {
				$body_font_path = 'museo/museosans_500-webfont';
			}
		}
	
		
		return array(
		'bgpattern'=>of_get_option('md_css_bgpattern'),
		'fontcolor'=>of_get_option('md_css_sitetextcolor'),
		'headingcolor'=>of_get_option('md_css_heading'),
		'logotext'=>of_get_option('md_css_logotext'),
		'linkcolor'=>of_get_option('md_css_linkcolor'),
		'linkcoloractive'=>of_get_option('md_css_linkcolorhover'),
		'bordercolor'=>of_get_option('md_css_bordercolor'),
		'borderstyle'=>of_get_option('md_css_borderstyle'),
		'menufont'=>of_get_option('md_css_menucolor'),
		'menufontactive'=>of_get_option('md_css_menucolorhover'),
		'menuscrollbar'=>of_get_option('md_css_scrollbar'),
		'formelementbg'=>of_get_option('md_css_formelementbg'),
		'formelementborder'=>of_get_option('md_css_formelementborder'),
		'formelementtext'=>of_get_option('md_css_formelementtext'),
		'formbuttonbg'=>of_get_option('md_css_formbuttonbg'),
		'formbuttontext'=>of_get_option('md_css_formbuttontext'),
		'iconcolors'=>of_get_option('md_css_iconcolors'),
		'worksthumbbg'=>of_get_option('md_css_worksthumbbg'),
		'worksthumbtext'=>of_get_option('md_css_worksthumbtext'),
		'bgcolor'=>of_get_option('md_body_bgcolor'),
		'framecolor'=>of_get_option('md_body_framecolor'),
		'bodyfontsize'=>$md_body_fontsize,
		'intronavarrow'=>of_get_option('md_slider_intro_arrow_color'),
		'md_font_type'=>$md_font_type,
		'header_font'=>$header_font,
		'body_font'=>$body_font,
		'body_font_path'=>$body_font_path,
		'header_font_path'=>$header_font_path
		);
		
	}
		
}
	
	
	
						
/************************************************************
/* Navigation
/************************************************************/

register_nav_menus(  
    array(  
        'main_menu' => 'Main&amp;Mobile Menu') 
    ); 
	
			
/************************************************************
/* Custom Menu
/************************************************************/

$walkertoken = wp_create_nonce("wp_token");
				
class northeme_walker extends Walker_Nav_Menu
{
      function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 )
      {
           global $wp_query;
		   global $walkertoken;
		   global $posttypes;
		   global $customtypes;
		   
		   $description = $append = $prepend = "";
		   
           $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

           $class_names = $value = '';

           $classes = empty( $item->classes ) ? array() : (array) $item->classes;
		   
		   $addposttype = 0;
		   $addtype = 0;
		   
		   /*
		   if($item->type=='post_type') { 
		   		$addtype = 1;	
		   }
		   */
		   //$checkstr = strpos($item->object, 'category');
		   $checkstr2 = strpos($item->object, '-categories');
		   
		   if($checkstr2 !== false || in_array($item->object,$posttypes)) { 
		   		$addtype = 1;	
		 	  	$term = get_term( $item->object_id, $item->object );
				$postname = '';
				
				/// Get the CPT settings
				$md_thumbcount = 3;
				$md_thumpadding = 7;
				$md_fixed_thumbs = 0;
				
				$pname = $item->object;
		   		$pname = str_replace('-categories','',$pname);
				
				if(is_array($customtypes )) {
					foreach($customtypes as $k => $v) {
						if(isset($v['title']) && $v['title']==$pname) { 
							$page_type = $k;
							break;
						}
						//$i++;
					}
				}
			
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
				
		   }
		  
		   
		   $addclass_names = '';
		   if(!$item->menu_item_parent) {
			   $addclass_names .= 'parent-menu ';
		   }
		  
		   if($item->current) {
			   $addclass_names .= 'current-menu';
		   }elseif($item->current_item_parent) {
			   $addclass_names .= 'current-parent';
		   }
           
		   //$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
           $class_names = ' class="'. esc_attr( $addclass_names ).'"';

           //$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';
		   $output .= $indent . '<li ' . $value.$class_names.'>';
			
           $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
           $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
           $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
           $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
           $attributes .= ! empty( $item->object_id )      ? ' data-id="'.$item->object_id.'"' : '';
           $attributes .= ! empty( $addtype )          ? ' data-rel="menuloader" data-cpt="'.$md_thumb_show.'-'.$md_perc.'-'.$md_perc_gap.'-'.$md_fixed_thumbs.'" data-type="'   . esc_attr( $item->object    ) .'"' : '';
           $attributes .= ! empty( $addtype )          ? ' data-token="'   . esc_attr( $walkertoken    ) .'"' : '';
		   if(isset($term->slug)) {
           	$attributes .= ! empty( $addtype )         ? ' data-slug="'   . esc_attr( $term->slug    ) .'"' : '';
		   }
           $attributes .= ! empty( $class_names )      ? ( $class_names    ) : '';

           $description  = ! empty( $item->description ) ? '<span>'.esc_attr( $item->description ).'</span>' : '';
		
			
		   unset($addposttype);
		   unset($addtype);
			
           if($depth != 0)
           {
                     $description = $append = $prepend = "";
           }

            $item_output = @$args->before;
            $item_output .= '<a'. $attributes .'>';
            $item_output .= @$args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append;
            $item_output .= @$description.$args->link_after;
			
			if($item->url=='#') {
            	$item_output .= '<i class="icon-caret-down"></i>';
			}
            
			$item_output .= '</a>';
            $item_output .= @$args->after;
			
			
            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        }
}



				
class northeme_walker_selectbox extends Walker_Nav_Menu
{
      function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 )
      {
           global $wp_query;
		   global $walkertoken;
		   
		   $description = $append = $prepend = "";
		   
           $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

           $class_names = $value = '';

           $classes = empty( $item->classes ) ? array() : (array) $item->classes;
		   
		   $addtype = 0;
		   
		      
			  
		   if($item->object == 'category' || strpos($item->object,"-categories")!==false) { 
		   		$addtype = 1;	
		 	  	$term = get_term( $item->object_id, $item->object );
		   }
		   
		  
		   $selected='';
		   if($item->current || $item->current_item_parent) {
			   $selected = ' selected="selected"';
		   }
		   
           //$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';
		   $output .= $indent . '<option value="'.$item->url.'"' . $selected.'>';

         
            $item_output = @$args->before;
			
		  
			   if($item->menu_item_parent) {
				  $item_output .= '- ';
			   }
		   
            $item_output .= @$args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append;
            $item_output .= @$description.$args->link_after;
            $item_output .= @$args->after;

            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
       }
}



/************************************************************
/* CUSTOM RSS
/************************************************************/

function myfeed_request($qv) {
	if (isset($qv['feed']) && !isset($qv['post_type'])) { 
			
		$customtypes = of_get_option('md_custom_posts');
		
		$posttypes = array('post');
		
		if(is_array($customtypes)) {
			foreach($customtypes as $k => $v) {
				array_push($posttypes,$v['title']);
			}	
		}
		$qv['post_type'] = $posttypes;
	
	}
		return $qv;
}
add_filter('request', 'myfeed_request');

/// RSS - ADD THUMBNAIL
function rss_post_thumbnail($content) {
global $post;
if(has_post_thumbnail($post->ID)) {
$content = '<p>' . get_the_post_thumbnail($post->ID,'md_post_thumb_large','') . '</p>' . get_the_content();
}
return $content;
}
add_filter('the_excerpt_rss', 'rss_post_thumbnail');
add_filter('the_content_feed', 'rss_post_thumbnail');

/************************************************************
/* Get Page Name
/************************************************************/

function getPageName() {
	global $post;
	global $pagename;
	
	$pagename = get_query_var('pagename');
	if ( !$pagename && $id > 0 ) {
	// If a static page is set as the front page, $pagename will not be set. Retrieve it from the queried object
	$post = $wp_query->get_queried_object();
	$pagename = $post->post_name;
	}
	return ucfirst($pagename);
}


/************************************************************
/* Comments
/************************************************************/

function northeme_comments( $comment, $args, $depth ) {
   $GLOBALS['comment'] = $comment; ?>
   
   <div <?php comment_class('singlecomment'); ?> id="comment-<?php comment_ID() ?>">
       <div class="who">
       	 <span class="imgs">
		 <?php echo get_avatar( $comment, $size = '30', $default = '' );  ?>
         </span>
         	<strong><?php printf( __( '%s', 'northeme' ), sprintf( '%s', get_comment_author_link() ) ); ?></strong>
            <br />
            <?php echo human_time_diff( get_comment_time('U'), current_time('timestamp') ) . ' ago';  ?>  
			<?php edit_comment_link( __( ' · (Edit)', 'northeme' ),'  ','' ) ?>
		    · <?php comment_reply_link( array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ) ?>    
         
          <div class="ccontent"> 
           <?php if ( $comment->comment_approved == '0' ) : ?>
             <em><?php _e( 'Your comment is awaiting moderation.', 'northeme' ) ?></em>
             <br />
          <?php endif; ?>
          
            <?php comment_text() ?>
           </div> 
      </div>  
   </div>
   
<?php
}





function nor_title() { 

	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	 
	global $page, $paged, $post, $wp_query;
	
	if(isset($post->ID)) {
		$page_title = esc_attr(get_post_meta( $post->ID, 'seo-title', true ));
		$descrip = esc_attr(get_post_meta( $post->ID, 'seo-desc', true ));
		$seokeywords = esc_attr(get_post_meta( $post->ID, 'seo-keywords', true ));
	}
		
	if(is_category() || is_tag() || is_archive() || is_search() || is_tax()) {
		
		global $wp_query, $term, $taxonomy;
		
		if(is_tax()) { 
			
			$title_name = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); 
			
			$printtitle = $title_name->name." | ";
		
		}elseif(is_archive() && !is_tag() && !is_category()) { 
		
			$printtitle = wp_title( '|', false, 'right' );
			
		}elseif(is_search()) { 
		
			$printtitle = get_search_query()." | ";
		
		}elseif(is_tag()) { 
		
			$printtitle = single_tag_title('',false)." | ";
		
		}else{
			
			$printtitle = single_cat_title('',false)." | ";
			
		}
				
	}elseif(isset($post->ID)) {
		
		if($page_title=="") {
			$printtitle = wp_title( '|', false, 'right' ); 
		}else{
			$printtitle =  $page_title." | ";
		}
	}else{
		$printtitle = wp_title( '|', false, 'right' );	
	}
	
	
	// Add the blog name.
	$printtitle = $printtitle.strip_tags(get_bloginfo( 'name' ));
	
	
	
	if(!is_single()) { 
		if(of_get_option('md_header_logo_subtext')) { 
			$printtitle =  $printtitle." - ".strip_tags(of_get_option('md_header_logo_subtext')); 
			} 
	}
	
	
	/// CREATE DESCRIPTION
	if($descrip=="") {
		if(is_single()) { 
			$post = $wp_query->post;
			$descrip = strip_tags($post->post_content);
			$descrip_more = '';
				if (strlen($descrip) > 155) {
					$descrip = substr($descrip,0,155);
					$descrip_more = ' ...';
				}
			$descrip = str_replace('"', '', $descrip);
			$descrip = str_replace("'", '', $descrip);
			$descripwords = preg_split('/[\n\r\t ]+/', $descrip, -1, PREG_SPLIT_NO_EMPTY);
			array_pop($descripwords);
			$descrip = implode(' ', $descripwords) . $descrip_more; 
		}else{ 
			if(of_get_option('md_header_seo_description')!='') { 
				$descrip = of_get_option('md_header_seo_description');
			}else{
				$descrip = get_bloginfo( 'description' );
			}
		}
	}
	
	if($descrip=="") {
		$descrip = of_get_option('md_header_seo_description');
	}
	if($seokeywords=="") {
		$seokeywords = of_get_option('md_header_seo_keywords');
	}
	
	return array('title'=>$printtitle,'desc'=>$descrip,'keywords'=>$seokeywords);
}



/************************************************************
/* PASSWORD PROTECTED
/************************************************************/

function my_password_form() {
    global $post;
    $label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
    $o = ''._x('<span style="padding-top:6px;display:inline-block">Password protected content. <a href="#" onclick="jQuery(\'.pagepassform\').show();jQuery(this).parent().hide();return false">Click here to view.</a></span>','northeme').'
	<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post" class="mypassform pagepassform" style="display:none">
    <input name="post_password" id="' . $label . '" type="password" style="padding:7px; width:100px" placeholder="Password" /><input type="submit" name="Submit" value="' . esc_attr__( "Submit" ) . '" />
    </form>
    ';
    return $o;
}
add_filter( 'the_password_form', 'my_password_form' );

function my_excerpt_password_form( $excerpt ) {
    if ( post_password_required() )
        $excerpt = get_the_password_form();
    return $excerpt;
}
add_filter( 'the_excerpt', 'my_excerpt_password_form' );




/************************************************************
/* PAGINATION GET
/************************************************************/
	
function md_get_page_number() { 
	
	if(get_query_var('paged') > 1) {
		$current = get_query_var('paged');
	}elseif(get_query_var('page') > 1) {
		$current = get_query_var('page');
	}else{
		$current = 1;
	}
		
	return $current;
		
}


/************************************************************
/* PAGINATION FUNCTION
/************************************************************/
	
	function get_paginate_page_links( $type = 'plain', $endsize = 1, $midsize = 1 ) {
		global $wp_query, $wp_rewrite;  
		$current = get_query_var( 'paged' ) > 1 ? get_query_var('paged') : 1;
	
		// Sanitize input argument values
		if ( ! in_array( $type, array( 'plain', 'list', 'array' ) ) ) $type = 'plain';
		$endsize = absint( $endsize );
		$midsize = absint( $midsize );
	
		// Setup argument array for paginate_links()
		$pagination = array(
			'base'      => @add_query_arg( 'paged', '%#%' ),
			'format'    => '',
			'total'     => $wp_query->max_num_pages,
			'current'   => $current,
			'show_all'  => false,
			'end_size'  => $endsize,
			'mid_size'  => $midsize,
			'type'      => 'array',
			'prev_text' => '&lt;&lt;',
			'next_text' => __( 'LOAD MORE', 'northeme' )
		);
	
		if ( $wp_rewrite->using_permalinks() )
			$pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ).'page/%#%/', 'paged' );
	
		if ( ! empty( $wp_query->query_vars['s'] ) )
			$pagination['add_args'] = array( 's' => get_query_var( 's' ) );
	
		$res = paginate_links( $pagination );
		 if(is_array($res)) {
			 $res = end($res); 
			 if(strpos($res,'<a')!==false) { 
				return $res;
			 }
		 }
			 
	}





/************************************************************
/* URL FUNCTION
/************************************************************/

if ( ! function_exists( 'makeClickableLinks' ) ) {	
	function makeClickableLinks($s) {
	  return preg_replace_callback('/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/', 'makeClickableLinkscallbackFunc', $s);
	}
}

if ( ! function_exists( 'makeClickableLinkscallbackFunc' ) ) {	
	function makeClickableLinkscallbackFunc($matches) {
		
		if(strlen($matches[1]) > 32) {
			$lnk = substr($matches[1],0,32).'...';
		}else{
			$lnk = $matches[1];
		}
	
		return '<a href="'.$matches[1].'" target="_blank">'.$lnk.'</a>';
	}
}


/************************************************************
/* TinyMCE Additional Buttons
/************************************************************/
function my_mce_buttons_2($buttons) {	
	/**
	 * Add in a core button that's disabled by default
	 */
	$buttons[] = 'fontsizeselect';
	$buttons[] = 'formatselect';
	
	return $buttons;
}
add_filter('mce_buttons_2', 'my_mce_buttons_2');


/************************************************************
/* Include Short Codes
/************************************************************/
require_once( THEME_FILEPATH . '/framework/shortcodes/google-map.php');
require_once( THEME_FILEPATH . '/framework/shortcodes/columns.php');
require_once( THEME_FILEPATH . '/framework/shortcodes/contact/contact-form.php');

/************************************************************
/* Admin Function Includes
/************************************************************/
require_once( THEME_FILEPATH . '/framework/custom-post-register.php' );
require_once( THEME_FILEPATH . '/framework/custom-metabox.php' );
require_once( THEME_FILEPATH . '/framework/md-assets.php' );
require_once( THEME_FILEPATH . '/framework/widgets.php' );
require_once( THEME_FILEPATH . '/framework/ajax.php' );
require_once (THEME_FILEPATH . '/framework/tinymce/tinymce.loader.php');
require_once( THEME_FILEPATH . '/framework/tuc.php' );
require_once( THEME_FILEPATH . '/framework/SEO/seo.php' );
	
	
	
/// SPECIAL CSS CLASSES FOR POST LOOP
	add_filter('post_class', 'my_post_class');
	function my_post_class($classes){
	  global $wp_query;
	  if(($wp_query->current_post+1) == $wp_query->post_count) $classes[] = 'end';
	  return $classes;
	}
	
/// HEX TO RGB
function hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   //return implode(",", $rgb); // returns the rgb values separated by commas
   return $rgb; // returns an array with the rgb values
}

?>