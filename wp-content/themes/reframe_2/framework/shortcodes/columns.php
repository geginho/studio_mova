<?php

/************************************************************
/* Columns - 16 Column Grid System
/************************************************************/

function md_row_break( $atts, $content = null ) {
	extract(shortcode_atts(array('pos' => ''), $atts));
   return '<div class="row">'.do_shortcode( $content ).'</div>';
}

function md_col_one_third( $atts, $content = null ) {
	extract(shortcode_atts(array('pos' => ''), $atts));
	
   	return '<div class="one-third column '.$pos.'">'.do_shortcode( $content ).'</div>';
}
function md_col_two_third( $atts, $content = null ) {
	extract(shortcode_atts(array('pos' => ''), $atts));
   return '<div class="two-thirds column '.$pos.'">'.do_shortcode( $content ).'</div>';
}

function md_col_one( $atts, $content = null ) {
	extract(shortcode_atts(array('pos' => ''), $atts));
   	return '<div class="one columns '.$pos.'">'.do_shortcode( $content ).'</div>';
}
function md_col_two( $atts, $content = null ) {
	extract(shortcode_atts(array('pos' => ''), $atts));
   	return '<div class="two columns '.$pos.'">'.do_shortcode( $content ).'</div>';
}
function md_col_three( $atts, $content = null ) {
	extract(shortcode_atts(array('pos' => ''), $atts));
   	return '<div class="three columns '.$pos.'">'.do_shortcode( $content ).'</div>';
}
function md_col_four( $atts, $content = null ) {
	extract(shortcode_atts(array('pos' => ''), $atts));
   	return '<div class="four columns '.$pos.'">'.do_shortcode( $content ).'</div>';
}
function md_col_five( $atts, $content = null ) {
	extract(shortcode_atts(array('pos' => ''), $atts));
   	return '<div class="five columns '.$pos.'">'.do_shortcode( $content ).'</div>';
}
function md_col_six( $atts, $content = null ) {
	extract(shortcode_atts(array('pos' => ''), $atts));
   	return '<div class="six columns '.$pos.'">'.do_shortcode( $content ).'</div>';
}
function md_col_seven( $atts, $content = null ) {
	extract(shortcode_atts(array('pos' => ''), $atts));
   	return '<div class="seven columns '.$pos.'">'.do_shortcode( $content ).'</div>';
}
function md_col_eight( $atts, $content = null ) {
	extract(shortcode_atts(array('pos' => ''), $atts));
   	return '<div class="eight columns '.$pos.'">'.do_shortcode( $content ).'</div>';
}
function md_col_nine( $atts, $content = null ) {
	extract(shortcode_atts(array('pos' => ''), $atts));
  	return '<div class="nine columns '.$pos.'">'.do_shortcode( $content ).'</div>';
}
function md_col_ten( $atts, $content = null ) {
	extract(shortcode_atts(array('pos' => ''), $atts));
   	return '<div class="ten columns '.$pos.'">'.do_shortcode( $content ).'</div>';
}
function md_col_eleven( $atts, $content = null ) {
	extract(shortcode_atts(array('pos' => ''), $atts));
   	return '<div class="eleven columns '.$pos.'">'.do_shortcode( $content ).'</div>';
}
function md_col_twelve( $atts, $content = null ) {
	extract(shortcode_atts(array('pos' => ''), $atts));
   	return '<div class="twelve columns '.$pos.'">'.do_shortcode( $content ).'</div>';
}
function md_col_thirteen( $atts, $content = null ) {
	extract(shortcode_atts(array('pos' => ''), $atts));
   	return '<div class="thirteen columns '.$pos.'">'.do_shortcode( $content ).'</div>';
}
function md_col_fourteen( $atts, $content = null ) {
	extract(shortcode_atts(array('pos' => ''), $atts));
   	return '<div class="fourteen columns '.$pos.'">'.do_shortcode( $content ).'</div>';
}
function md_col_fifteen( $atts, $content = null ) {
	extract(shortcode_atts(array('pos' => ''), $atts));
   	return '<div class="fifteen columns '.$pos.'">'.do_shortcode( $content ).'</div>';
}
function md_col_sixteen( $atts, $content = null ) {
	extract(shortcode_atts(array('pos' => ''), $atts));
   	return '<div class="sixteen columns '.$pos.'">'.do_shortcode( $content ).'</div>';
}

add_shortcode( 'row_break', 'md_row_break' );

add_shortcode( 'one_third', 'md_col_one_third' );
add_shortcode( 'two_third', 'md_col_two_third' );

add_shortcode( 'one_col', 'md_col_one' );
add_shortcode( 'two_col', 'md_col_two' );
add_shortcode( 'three_col', 'md_col_three' );
add_shortcode( 'four_col', 'md_col_four' );
add_shortcode( 'five_col', 'md_col_five' );
add_shortcode( 'six_col', 'md_col_six' );
add_shortcode( 'seven_col', 'md_col_seven' );
add_shortcode( 'eight_col', 'md_col_eight' );
add_shortcode( 'nine_col', 'md_col_nine' );
add_shortcode( 'ten_col', 'md_col_ten' );
add_shortcode( 'eleven_col', 'md_col_eleven' );
add_shortcode( 'twelve_col', 'md_col_twelve' );
add_shortcode( 'thirteen_col', 'md_col_thirteen' );
add_shortcode( 'fourteen_col', 'md_col_fourteen' );
add_shortcode( 'fifteen_col', 'md_col_fifteen' );
add_shortcode( 'sixteen_col', 'md_col_sixteen' );

		
		
		
/************************************************************
/* Buttons
/************************************************************/

function md_button( $atts, $content = null ) {
	
	extract(shortcode_atts(array(
		'url'     	 => '#',
		'target'     => '_self',
		'size'	=> '',
		'name' =>'',
		'color'   => ''		
    ), $atts));
	
   return '<a href="'.$url.'" class="button button-'.$color.' button-'.$size.'" target="'.$target.'">' . $name . '</a>';
}

add_shortcode('button', 'md_button');


	
/************************************************************
/* Icons
/************************************************************/

function md_icon( $atts) {
	
	$forwh='';
	$col = siteColors();
	
	extract(shortcode_atts(array(
		'name'  => '',
		'size'  => ''
    ), $atts));
	
	$name = str_replace('icon-','',$name);
	$name = str_replace('fa-','',$name);
   
   return '<i class="icon-'.$name.' '.$size.'"></i>';
}

add_shortcode('icon', 'md_icon');

	
/************************************************************
/* Alerts
/************************************************************/

function md_alert( $atts, $content = null ) {
	
	extract(shortcode_atts(array(
		'color'   => ''
    ), $atts));

   return '<div class="alert alert-'.$color.'"><a href="#" class="closealert"><i class="icon-remove"></i></a>' . do_shortcode($content) . '</div>';
}

add_shortcode('alert', 'md_alert');




 
/************************************************************
/* GALLERY
/************************************************************/

function md_gallery( $atts, $content = null ) {

	 $result = '<div class="forgallerydiv"><a href="#" class="gallery_fullscreen">&nbsp;</a><div class="galleria galleria_shortcode">';
                 
     $result .= do_shortcode( $content );
	 
     $result .= '</div></div><br class="clear"><style type="text/css">.galleria_shortcode .galleria-container { background-color:'.of_get_option('md_gallery_defbg').'; }</style>';
     return $result;           
}

add_shortcode('nor_gallery', 'md_gallery');

function md_gallery_item( $atts, $content = null ) {
		
		$defaults = array( 'type' => 'image', 'title' => '', 'url'=>'','target'=>'_self', 'caption'=>'');
		extract( shortcode_atts( $defaults, $atts ) );
		
		$result = '';
			
			  if($atts['type']=='video') {
									   
				  $imlink = get_template_directory_uri().'/images/playbutton.jpg';
				  $imlink1 = stripslashes($content);
				  
			   }else{
				   
				  $imlink = $content;
				  $imlink1 = stripslashes($content);
			   }
				   $imdesc = @$mediacaption[$s2];
				   $result .= '<a href="'.$imlink1.'"><img src="'.$imlink.'" data-big="'.$imlink.'" data-description="'.@stripslashes($atts['caption']).'"></a>';
				  
				/*					  
									  
			// VIDEO
			if($atts['type']=='video'){ 
			$result .= '<li>'.($content);
			
			$result .= '</li>';
			
			// IMAGE
			}else{
			$result .= '<li>';
				
				// WITH LINK OR NOT
				if(isset($atts['url'])) { 
					$result .= '<a href="'.$atts['url'].'" target="'.$atts['target'].'"><img src="'.($content).'" alt="'.@$atts['title'].'"></a>';
				}else{
					$result .= '<img src="'.($content).'" alt="'.@$atts['title'].'">';
				}
				
				// ADD CAPTIONS
				if(isset($atts['caption'])) { 
					$result .= '<p class="flex-caption">'.$atts['caption'].'</p>';
				}
			$result .= '</li>';	
			}
			*/
		
		return $result;
	}
	
add_shortcode( 'nor_gallery_item', 'md_gallery_item' );

            
/************************************************************
/* SLIDER
/************************************************************/

function md_slider( $atts, $content = null ) {

	 $result = '<div class="flexslider">
                  <ul class="slides">';
                 
     $result .= do_shortcode( $content );
	 
     $result .= '</ul></div>';
     return $result;           
}

add_shortcode('slider', 'md_slider');

function md_slide( $atts, $content = null ) {
		
		$defaults = array( 'type' => 'image', 'url'=>'','target'=>'_self', 'caption'=>'');
		extract( shortcode_atts( $defaults, $atts ) );
		
		$result = '';
			
			// VIDEO
			if($atts['type']=='video'){ 
			$result .= '<li>'.($content);
			
			$result .= '</li>';
			
			// IMAGE
			}else{
			$result .= '<li>';
				
				// WITH LINK OR NOT
				if(isset($atts['url']) && $atts['url']!="") { 
					$result .= '<a href="'.$url.'" target="'.$atts['target'].'"><img src="'.($content).'"></a>';
				}else{
					$result .= '<img src="'.($content).'">';
				}
				
				// ADD CAPTIONS
				if(isset($atts['caption']) && $atts['caption']!="") { 
					$result .= '<p class="flex-caption">'.$atts['caption'].'</p>';
				}
			$result .= '</li>';	
			}
			
		
		return $result;
	}
	
add_shortcode( 'slide', 'md_slide' );

             
/************************************************************
/* TABS
/************************************************************/


function md_tabs( $atts, $content = null ) {
	global $tabcount;
	
	preg_match_all( '/tab title="([^\"]+)"/i', $content, $check, PREG_OFFSET_CAPTURE );
		
	$tab_titles = array();
	if( isset($check[1]) ){ 
		$tab_titles = $check[1]; 
	}
	$result = '<br class="clear">';
		
		if( count($tab_titles) > 0 ){
		    $result .= '<dl id="tabs-'.uniqid().'" class="tabs">';
			
			$say=1;
				foreach( $tab_titles as $tab ){
					if($say==1) { $active = 'class="active"'; }
					$result .= '<dd '.$active.'><a href="#tabs-'.sanitize_title( $tab[0] ).'">' . $tab[0] . '</a></dd>';
					$active= '';
					$say++;
				}
		    
		    $result .= '</dl>';
			$result .= '<ul class="tabs-content">';
			$result .= do_shortcode( $content );
			$result .= '<br class="clear"></ul>';
		} else {
			$result .= do_shortcode( $content );
		}
	
	$tabcount=1;
	
	return $result;
}

add_shortcode('tabs', 'md_tabs');


/// TAB CONTENTS
$tabcount = 1;
function md_tab( $atts, $content = null ) {
		global $tabcount;
		
		$result = '';
		$active = '';
		
		$defaults = array( 'title' => 'Title' );
		extract( shortcode_atts( $defaults, $atts ) );
			
			if($tabcount==1) $active = 'class="active"';
			
			$result .= '<li '.$active.' id="tabs-'.sanitize_title($title).'Tab">'.do_shortcode($content).'</li>';
		
		$tabcount++;	
		
		return $result;
	}
	
add_shortcode( 'tab', 'md_tab' );