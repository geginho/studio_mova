<?php

add_action('init','of_options');

if (!function_exists('of_options'))
{
	function of_options()
	{
		//Access the WordPress Categories via an Array
		$of_categories = array();  
		$of_categories_obj = get_categories('hide_empty=0');
		foreach ($of_categories_obj as $of_cat) {
		    $of_categories[$of_cat->cat_ID] = $of_cat->cat_name;}
		$categories_tmp = array_unshift($of_categories, "Select a category:");    
	       
		//Access the WordPress Pages via an Array
		$of_pages = array();
		$of_pages_obj = get_pages('sort_column=post_parent,menu_order');    
		foreach ($of_pages_obj as $of_page) {
		    $of_pages[$of_page->ID] = $of_page->post_name; }
		$of_pages_tmp = array_unshift($of_pages, "Select a page:");       
	
		//Testing 
		$of_options_select = array("one","two","three","four","five"); 
		$of_options_radio = array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five");
		
		//Sample Homepage blocks for the layout manager (sorter)
		$of_options_homepage_blocks = array
		( 
			"disabled" => array (
				"placebo" 		=> "placebo", //REQUIRED!
				"block_one"		=> "Block One",
				"block_two"		=> "Block Two",
				"block_three"	=> "Block Three",
			), 
			"enabled" => array (
				"placebo" => "placebo", //REQUIRED!
				"block_four"	=> "Block Four",
			),
		);


		//Stylesheets Reader
		$alt_stylesheet_path = LAYOUT_PATH;
		$alt_stylesheets = array();
		
		if ( is_dir($alt_stylesheet_path) ) 
		{
		    if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) 
		    { 
		        while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) 
		        {
		            if(stristr($alt_stylesheet_file, ".css") !== false)
		            {
		                $alt_stylesheets[] = $alt_stylesheet_file;
		            }
		        }    
		    }
		}


		//Background Images Reader
		$bg_images_path = STYLESHEETPATH. '/images/bg/'; // change this to where you store your bg images
		$bg_images_url = get_bloginfo('template_url').'/images/bg/'; // change this to where you store your bg images
		$bg_images = array();
		
		if ( is_dir($bg_images_path) ) {
		    if ($bg_images_dir = opendir($bg_images_path) ) { 
		        while ( ($bg_images_file = readdir($bg_images_dir)) !== false ) {
		            if(stristr($bg_images_file, ".png") !== false || stristr($bg_images_file, ".jpg") !== false) {
		                $bg_images[] = $bg_images_url . $bg_images_file;
		            }
		        }    
		    }
		}
		

		/*-----------------------------------------------------------------------------------*/
		/* TO DO: Add options/functions that use these */
		/*-----------------------------------------------------------------------------------*/
		
		//More Options
		$uploads_arr = wp_upload_dir();
		$all_uploads_path = $uploads_arr['path'];
		$all_uploads = get_option('of_uploads');
		$other_entries = array("Select a number:","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19");
		$body_repeat = array("no-repeat","repeat-x","repeat-y","repeat");
		$body_pos = array("top left","top center","top right","center left","center center","center right","bottom left","bottom center","bottom right");
		
		// Image Alignment radio box
		$of_options_thumb_align = array("alignleft" => "Left","alignright" => "Right","aligncenter" => "Center"); 
		
		// Image Links to Options
		$of_options_image_link_to = array("image" => "The Image","post" => "The Post"); 




/// GET BG PATTERNS
if ($handle = opendir(THEME_FILEPATH.'/images/bgpatterns')) {
	$bgpatterns = array('--No Pattern--');
    while (false !== ($entry = readdir($handle))) {
		$ext = pathinfo($entry, PATHINFO_EXTENSION);
		if($ext=="png" || $ext=="jpeg" || $ext=="jpg" || $ext=="gif")
        array_push($bgpatterns,$entry);
    }
    closedir($handle);
}




/// GET FONT FACES
if ($handles = opendir(THEME_FILEPATH.'/fonts')) {
	
	$fontfaces = array();
	
	while (false !== ($entry = readdir($handles))) {
		
		$files = '';
		
		if($entry!='.' && $entry!='..') {
			$sm=1;
			
			$handle2 = @opendir(THEME_FILEPATH.'/fonts/'.$entry);
				
			while (false !== ($filename = @readdir($handle2))) {
				if($filename!='.' && $filename!='..') {
					$files = $filename;
					
					$sm++;
					
						if($sm > 1) { 
							break;
						}
				}
			}
				
			$fname = pathinfo($files, PATHINFO_FILENAME);
			$fontfaces = array_merge($fontfaces, array($entry.'/'.$fname=>ucfirst($entry)));
		}
		
	}
	
	asort($fontfaces);
	closedir($handles);
}



/*-----------------------------------------------------------------------------------*/
/* The Options Array */
/*-----------------------------------------------------------------------------------*/

// Set the Options Array
global $of_options;
$of_options = array();
													
	

		
				
								
$of_options[] = array("name" => "Custom Posts",
					"type" => "heading",
					"icon"=>'magic');
						

				
$of_options[] = array(
					'id' => 'md_custom_posts',
					'type' => 'customposts',
					'name' => 'Custom Post Type Generator', 
					'desc' => __('This is your Custom Post Type generator. <br><br>To create a new post type, click on the <strong>Create New Post Type</strong> button and fill out the form. <br><br>
<strong style="color:#cc0000">Please note that all fields are required on Step 2 and Step 3. If you leave a field blank, your custom post type will NOT be saved!</strong><br><br>By default, Workality comes with <strong>works</strong> custom post type and it cannot be deleted but values can be changed.', ''),
					'std' => ''// 1 = on | 0 = off
				);
			
								
										
								
$of_options[] = array("name" => "Posts Ordering",
					"type" => "heading",
					"icon"=>'magic');
						

				
$of_options[] = array(
					'id' => 'md_custom_posts_ordering',
					'type' => 'custompostsordering',
					'name' => 'Custom Posts Ordering', 
					'desc' => __('<strong style="color:#ff0000!important">IMPORTANT</strong> IN ORDER TO ACTIVATE ORDERING, NAVIGATE "CUSTOM POSTS" SECTION AND SET "ORDER BY" OPTION AS "CUSTOM ORDERING" FOR THE CORRESPONDING POST TYPE.<br><br>You can re-order custom posts via drag&drop. Once you finished re-ordering, click on the SAVE ALL CHANGES button to save.', ''),
					'std' => ''// 1 = on | 0 = off
				);
			
						
					
								
$of_options[] = array("name" => "Category Ordering",
					"type" => "heading",
					"icon"=>'magic');
					
					
$of_options[] = array(
					'id' => 'md_custom_taxonomy_ordering',
					'type' => 'customtaxonomysordering',
					'name' => 'Category Ordering', 
					'desc' => __('You can re-order custom posts via drag&drop. Once you finished re-ordering, click on the SAVE ALL CHANGES button to save.', ''),
					'std' => ''// 1 = on | 0 = off
				);
			
		

		
$of_options[] = array( "name" => "Gallery",
					"type" => "heading",
					"icon" =>'desktop');	
						


$of_options[] = array( "name" => "",
                    "id" => "md_gallery_info",
                    "std" => "Following settings will be applied to custom post type galleries",
                    "type" => "info",
					"desc" => '',
					);
				

$of_options[] = array( "name" =>  "Gallery BG Color",
					"desc" => "",
					"id" => "md_gallery_defbg",
					"std" => "#000",
					"type" => "color");	
									
					
$of_options[] = 		array(
						'id' => 'md_gallery_transition',
						'type' => 'selectkey',
						'name' => __('Transition Type', ''),
						'desc' => __('', ''),
						'std' => 'fade',
						'options'=>array('fade'=>'Fade', 'flash'=>'Flash', 'pulse'=>'Pulse', 'slide'=>'Slide', 'fadeslide'=>'Fade Slide')
						);
						

$of_options[] = 		array(
						'id' => 'md_gallery_transition_speed',
						'type' => 'selectkey',
						'name' => __('Transition Speed', ''),
						'desc' => __('', ''),
						'std' => '500',
						'options'=>array('100'=>'0.1 sec', '500'=>'0.5 msec', '1000'=>'1 sec', '2000'=>'2 sec', '3000'=>'3 Sec', '5000'=>'5 Sec')
						);
		
$of_options[] = 		array(
						'id' => 'md_gallery_slideshow_speed',
						'type' => 'text',
						'name' => __('Slideshow Speed', ''),
						'desc' => __('Set the speed of the slideshow cycling, in milliseconds. E.g 7000 (for 7 seconds)', ''),
						'std' => '7000'
						);												
						

$of_options[] = array( "name" => "Slideshow Autostart",
						"desc" => "",
						"id" => "md_gallery_slideshow_autostart",
						"std" => "0",
						"type" => "checkbox"); 
									


$of_options[] = array( "name" => "Center-Aligned Thumbnails",
						"desc" => "This option allows you to align thumbnails center instead of left.",
						"id" => "md_gallery_align_center",
						"std" => "0",
						"type" => "checkbox"); 
									

$of_options[] = array( "name" => "Disable Image Preload",
						"desc" => "Disabling preload feature may accelerate the loading time if high number of images are used.",
						"id" => "md_gallery_preload",
						"std" => "0",
						"type" => "checkbox"); 		
																


$of_options[] = array( "name" => "Disable Mobile Double Tap",
						"desc" => "Disabling double tap feature that allows to switch fullscreen mode on mobile devices.",
						"id" => "md_gallery_dtap",
						"std" => "0",
						"type" => "checkbox"); 
						
	
$of_options[] = array( "name" => "Disable Fullscreen Feature",
						"desc" => "Galleria plugin allows to switch fullscreen mode on HTML5 browsers. This option disables fullscreen feature.",
						"id" => "md_gallery_fullscreen",
						"std" => "0",
						"type" => "checkbox"); 
																										
$of_options[] = array( "name" => "Crop Images",
						"desc" => "This option allows you to display your images in full width regardless to their height.",
						"id" => "md_gallery_crop",
						"std" => "0",
						"type" => "checkbox"); 
									
$of_options[] = 		array(
						'id' => 'md_gallery_caption_placement',
						'type' => 'selectkey',
						'name' => __('Caption Placement', ''),
						'desc' => __('', ''),
						'std' => 'top',
						'options'=>array('top'=>'Top', 'bottom'=>'Bottom')
						);
											
								
$of_options[] = 		array(
						'id' => 'md_gallery_caption_alignment',
						'type' => 'selectkey',
						'name' => __('Caption Text Alignment', ''),
						'desc' => __('', ''),
						'std' => 'left',
						'options'=>array('left'=>'Left', 'center'=>'Center')
						);								
							

	
					
$of_options[] = array( "name" => "Intro Slider",
					"type" => "heading",
					"icon" =>'desktop');					


$of_options[] =			array(
						'id' => 'md_slider_intro_caption_styling',
						'name' => __('Slider Caption Styling', ''),
						'desc'=> __('',''),
						"std" => array('size' => '13px','face' => 'default', 'style'=>'normal','color'=>'#ccc',),
						"type" => "typography"
						);	

										
$of_options[] = array(
						'id' => 'md_slider_intro_caption_shadow',
						'type' => 'checkbox',
						'name' => __('Enable Caption Text Shadow', ''),
						'desc' => __('', ''),
						'std' => '0'
						);	
							
$of_options[] = 		array(
						'id' => 'md_slider_intro_speed',
						'type' => 'text',
						'name' => __('Slideshow Speed', ''),
						'desc' => __('Set the speed of the animation, in milliseconds. E.g 7000 (for 7 seconds)', ''),
						'std' => '7000'
						);		
						
										
$of_options[] = 		array(
						'id' => 'md_slider_intro_duration',
						'type' => 'text',
						'name' => __('Slideshow Transition Speed', ''),
						'desc' => __('Set the speed of the slideshow cycling, in milliseconds. E.g 1500 (for 1.5 seconds)', ''),
						'std' => '1500'
						);

			
$of_options[] = 		array(
						'id' => 'md_slider_intro_animation_type',
						'type' => 'selectkey',
						'name' => __('Transition Type', ''),
						'desc' => __('', ''),
						'std' => 'fade',
						'options'=>array(
							1=>'Fade', 
							2=>'Slide Top', 
							3=>'Slide Right', 
							4=>'Slide Bottom', 
							5=>'Slide Left', 
							6=>'Carousel Right', 
							7=>'Carousel Left',
							0=>'None'
						)
						);
						
				

$of_options[] = array( "name" =>  "Navigation Arrow Color",
					"desc" => "",
					"id" => "md_slider_intro_arrow_color",
					"display"=>'',
					"std" => "#fff",
					"type" => "color");
					
									

$of_options[] = 		array(
						'id' => 'md_slider_intro_disablearrow',
						'type' => 'checkbox',
						'name' => 'Hide Navigation Arrows', 
						'desc' => __('', ''),
						'std' => '0'// 1 = on | 0 = off
						);


$of_options[] = 		array(
						'id' => 'md_slider_intro_disableplaypause',
						'type' => 'checkbox',
						'name' => 'Hide Slideshow Play/Pause Button', 
						'desc' => __('', ''),
						'std' => '0'// 1 = on | 0 = off
						);

$of_options[] = 		array(
						'id' => 'md_slider_intro_random',
						'type' => 'checkbox',
						'name' => 'Random Slides', 
						'desc' => __('This option allows you to randomize the slide ordering', ''),
						'std' => '0'// 1 = on | 0 = off
						);

$of_options[] = 		array(
						'id' => 'md_slider_intro_disable_autoplay',
						'type' => 'checkbox',
						'name' => 'Disable Autoplay', 
						'desc' => __('', ''),
						'std' => '0'// 1 = on | 0 = off
						);

		
						
					
$of_options[] = array( "name" => "Post Sliders",
					"type" => "heading",
					"icon" =>'desktop');					




$of_options[] = array( "name" => "",
                    "id" => "md_layout_info7",
                    "std" => "Following settings will be applied to shortcode sliders. In order to change Full Page slider settings, navigate to Intro Slider section",
                    "type" => "info",
					"desc" => '',
					);
					


$of_options[] = array( "name" =>  "Icon Colors",
					"desc" => "Navigation Arrows / Slideshow Pause/Play Buttons",
					"id" => "md_slider_icon_colors",
					"std" => "#000",
					"type" => "color");	
					
$of_options[] = array( "name" =>  "",
					"desc" => "Navigation Dots",
					"id" => "md_slider_nav_color",
					"std" => "#000",
					"type" => "color");	
					
$of_options[] = array( "name" =>  "",
					"desc" => "Navigation Dots Active",
					"id" => "md_slider_nav_color_hover",
					"std" => "#000",
					"type" => "color");	



$of_options[] = array( "name" =>  "Caption Alignment / Text Color",
					"desc" => "",
					"id" => "md_slider_caption_alignment",
					"type" => "selectkey",
					'std' => 'left',
					"options" => array('left'=>'Left','center'=>'Center')); 
									
$of_options[] = array( "name" =>  "",
					"desc" => "Caption Text Color",
					"id" => "md_slider_caption_color",
					"std" => "#000",
					"type" => "color");	
									
	
$of_options[] = array( "name" => "Captions Auto Hide",
						"desc" => "Display caption only on mouseover position",
						"id" => "md_slider_autohide",
						"std" => "0",
						"type" => "checkbox"); 
												

$of_options[] = array( "name" => "Pause on Mouseover",
						"desc" => "",
						"id" => "md_slider_hover",
						"std" => "0",
						"type" => "checkbox"); 
						
	
												
$of_options[] = array( "name" => "Hide Slider Navigation Arrows",
						"desc" => "Allows you to hide navigation arrows",
						"id" => "md_slider_navigation_arrows",
						"std" => "0",
						"type" => "checkbox"); 
												
																						
$of_options[] = array( "name" => "Hide Slider Navigation Dots",
						"desc" => "Allows you to hide navigation dots bottom of the slider",
						"id" => "md_slider_navigation_dots",
						"std" => "0",
						"type" => "checkbox"); 
										
					
$of_options[] =			array(
						'id' => 'md_slider_animation',
						'name' => __('Slider animation type', ''), 
						'desc' => __('', ''),
						"type" => "select",
						'std' => 'slide',
						"options" => array('slide','fade'));  	

					
$of_options[] = 		array(
						'id' => 'md_slider_speed',
						'type' => 'text',
						'name' => __('Slideshow Animation Speed', ''),
						'desc' => __('Set the speed of the animation, in milliseconds. E.g 7000 (for 7 seconds)', ''),
						'std' => '1000'
						);

					
$of_options[] = 		array(
						'id' => 'md_slider_duration',
						'type' => 'text',
						'name' => __('Slideshow Speed', ''),
						'desc' => __('Set the speed of the slideshow cycling, in milliseconds. E.g 7000 (for 7 seconds)', ''),
						'std' => '7000'
						);



$of_options[] = 		array(
						'id' => 'md_slider_disable_autoplay',
						'type' => 'checkbox',
						'name' => 'Disable Autoplay', 
						'desc' => __('', ''),
						'std' => '0'// 1 = on | 0 = off
						);

						


$of_options[] = array( "name" => "Lightbox", 
					"type" => "heading",
					"icon" =>'desktop');					


$of_options[] = array( "name" => "",
                    "id" => "md_layout_info2",
                    "std" => "<strong>Lightbox Settings</strong><br>Please see the <a href=\"http://northeme.com/documentations\" target=\"_blank\">theme documentation</a> for the lightbox instructions.",
                    "type" => "info",
					"desc" => '',
					);
					
						
$of_options[] = array( "name" =>  "Overlay BG Color",
					"desc" => "",
					"id" => "md_lightbox_overlay_color",
					"std" => "#000",
					"type" => "color");	

			
$of_options[] = array( "name" => "Overlay Transparency",
				"desc" => '',
				"id" => "md_lightbox_transparency",
				"std" => 100,
				"type" => "select", 
				"options" => array(0,10,20,30,40,50,60,70,80,90,100)); 
				
					
$of_options[] = array( "name" =>  "Caption & Action BG Color",
					"desc" => "",
					"id" => "md_lightbox_caption_bgcolor",
					"std" => "#000",
					"type" => "color");	

$of_options[] = array( "name" =>  "Caption Text Color",
					"desc" => "",
					"id" => "md_lightbox_caption_color",
					"std" => "#000",
					"type" => "color");			
										

$of_options[] = array( "name" => "Disable Captions",
						"desc" => "",
						"id" => "md_lightbox_caption_disable",
						"std" => "0",
						"type" => "checkbox"); 
																
			

$of_options[] = array( "name" => "Disable Lightbox Plugin",
						"desc" => "",
						"id" => "md_lightbox_itself",
						"std" => "0",
						"type" => "checkbox"); 
																
						
						
																								
			
$of_options[] = array( "name" => "Styling Options",
					"type" => "heading",
					"icon"=>'edit');

					
$of_options[] =   array(
						'id' => 'md_css_presets',
						'type' => 'images',
						'name' => __('Color Presets', ''), 
						'desc' => __('You can select custom in order to create your color settings', ''),
						'options' => array(
									'light' => ADMIN_IMG_DIRECTORY . 'preset1.png',
									'gray' => ADMIN_IMG_DIRECTORY . 'preset2.png',
									'dark' => ADMIN_IMG_DIRECTORY . 'preset3.png',
									'custom' => ADMIN_IMG_DIRECTORY . 'preset4.png',
									 ),
						'std' => 'gray',
          				"folds" => 1,
						);
						
						
$of_options[] = array( "name" =>  "Colors",
					"desc" => "Background Color",
					"id" => "md_body_bgcolor",
					"display"=>'presethidden',
					"std" => "#f5f5f5",
					"type" => "color");
																	          
$of_options[] = array( "name" =>  "",
					"desc" => "Frame Color",
					"id" => "md_body_framecolor",
					"display"=>'presethidden',
					"std" => "#fff",
					"type" => "color");
							
					          
$of_options[] = array( "name" =>  "",
					"desc" => "Heading Color",
					"id" => "md_css_heading",
					"display"=>'presethidden',
					"std" => "#000",
					"type" => "color");

$of_options[] = array( "name" =>  "",
					"desc" => "Logo Text Color",
					"id" => "md_css_logotext",
					"display"=>'presethidden',
					"std" => "#000",
					"type" => "color");
					
										
$of_options[] =  array( "name" =>  "",
					"desc" => "Text Color",
					"id" => "md_css_sitetextcolor",
					"display"=>'presethidden',
					"std" => "#333",
					"type" => "color"); 
					
$of_options[] = array( "name" =>  "",
					"desc" => "Link Color",
					"id" => "md_css_linkcolor",
					"display"=>'presethidden',
					"std" => "#666",
					"type" => "color");
$of_options[] = array( "name" =>  "",
					"desc" => "Link Active Color",
					"id" => "md_css_linkcolorhover",
					"display"=>'presethidden',
					"std" => "#000",
					"type" => "color");					

$of_options[] = array( "name" =>  "",
					"desc" => "Menu Text Color",
					"id" => "md_css_menucolor",
					"display"=>'presethidden',
					"std" => "#333",
					"type" => "color");
					
$of_options[] = array( "name" =>  "",
					"desc" => "Menu Text Rollover/Active",
					"id" => "md_css_menucolorhover",
					"display"=>'presethidden',
					"std" => "#000",
					"type" => "color");		
					
										
$of_options[] = array( "name" =>  "",
					"desc" => "Border Color",
					"id" => "md_css_bordercolor",
					"display"=>'presethidden',
					"std" => "#ccc",
					"type" => "color");
	
$of_options[] = array( "name" =>  "",
					"desc" => "Icon Colors",
					"id" => "md_css_iconcolors",
					"display"=>'presethidden',
					"std" => "#666",
					"type" => "color");

$of_options[] = array( "name" =>  "",
					"desc" => "Browser Scrollbar",
					"id" => "md_css_scrollbar",
					"display"=>'presethidden',
					"std" => "#666",
					"type" => "color");
					
$of_options[] = array( "name" =>  "",
					"desc" => "Thumbnail Hover Frame BG",
					"id" => "md_css_worksthumbbg",
					"display"=>'presethidden',
					"std" => "#000",
					"type" => "color");

$of_options[] = array( "name" =>  "",
					"desc" => "Thumbnail Hover Frame Text",
					"id" => "md_css_worksthumbtext",
					"display"=>'presethidden',
					"std" => "#fff",
					"type" => "color");
										
$of_options[] = array( "name" =>  "",
					"desc" => "Form Elements BG",
					"id" => "md_css_formelementbg",
					"display"=>'presethidden',
					"std" => "#fff",
					"type" => "color");

$of_options[] = array( "name" =>  "",
					"desc" => "Form Elements Border",
					"id" => "md_css_formelementborder",
					"display"=>'presethidden',
					"std" => "#fff",
					"type" => "color");
										
$of_options[] = array( "name" =>  "",
					"desc" => "Form Elements Text Color",
					"id" => "md_css_formelementtext",
					"display"=>'presethidden',
					"std" => "#000",
					"type" => "color");		

$of_options[] = array( "name" =>  "",
					"desc" => "Form Button BG Color",
					"id" => "md_css_formbuttonbg",
					"display"=>'presethidden',
					"std" => "#000",
					"type" => "color");		
					
$of_options[] = array( "name" =>  "",
					"desc" => "Form Button Text Color",
					"id" => "md_css_formbuttontext",
					"display"=>'presethidden',
					"std" => "#fff",
					"type" => "color");	


		
		

$of_options[] = array( "name" => "BG Patterns",
				"desc" => '<strong>BG Pattern Select</strong><br>You can add new BG patterns files into <strong>"images/bgpatterns"</strong> folder. BG patterns list will be updated  automatically. <br><a href="http://subtlepatterns.com" target="_blank">http://subtlepatterns.com</a>',
				"id" => "md_css_bgpattern",
				"std" => "",
				"type" => "select",
				"bgpatterns" => 1, 
				"options" => $bgpatterns); 
	
			
$of_options[] = array( "name" => "Border Type",
				"desc" => '',
				"id" => "md_css_borderstyle",
				"std" => "dashed",
				"type" => "select", 
				"options" => array('solid','dashed','dotted')); 
	
			
			
$of_options[] = array(  
					"name" => "Main Layout",
					"type" => "heading",
					"icon"=>'columns'
				 );


$of_options[] = array( "name" => "",
                    "id" => "md_layout_info1",
                    "std" => "<strong>MAIN LAYOUT SETTINGS</strong>",
                    "type" => "info",
					"desc" => '',
					);
					
				
				
$of_options[] =	array(
				'id' => 'md_removeheader',
				'type' => 'checkbox',
				'name' => __('Remove Header', ''), 
				'desc' => __('Allows you to remove website header and align logo and page content at the top. IMPORTANT : This option removes the website header (Logo, menu and social icons) and if it\'s used while Main Layout is set to Full Width (following option), main menu won\'t show up.', ''),
				'std' => '0'// 1 = on | 0 = off
				);
									
$of_options[] =	array(
				'id' => 'md_home_full',
				'type' => 'checkbox',
				'name' => __('Main Layout as Full Width', ''), 
				'desc' => __('This theme uses 2-column left aligned menu layout by default. Activate this option in order to use your website as full width.', ''),
				'std' => '0'// 1 = on | 0 = off
				);
									
							
$of_options[] =	array(
				'id' => 'md_works_full',
				'type' => 'checkbox',
				'name' => __('Custom Post Page as Full Width', ''), 
				'desc' => __('This option allows you to use single custom post type post as full width while your main layout is default. Please note that, this option will be ignored if full width layout option above is activated.', ''),
				'std' => '0'// 1 = on | 0 = off
				);

						
$of_options[] =	array(
				'id' => 'md_works_single_top',
				'name' => __('Custom Post Single Page Info/Navigation Placement', ''), 
				'desc' => __('Single custom post pages display post info/navigation as a sidebar by default. This option allows you to change its placement as top or right. Please note that this option works if your main layout and custom post page is NOT set as full width.', ''),
				"type" => "selectkey", 
				"std" => 'right',
				"options" => array('right'=>'Right','top'=>'Top')
				);

						
$of_options[] =	array(
				'id' => 'md_border_disable',
				'type' => 'checkbox',
				'name' => __('Remove the Browser Window Frame', ''), 
				'desc' => __('This theme uses a thick border to wrap your content by default. Activate this option in order to remove the frame.', ''),
				'std' => '0'// 1 = on | 0 = off
				);

									
$of_options[] =	array(
				'id' => 'md_backtotop_disable',
				'type' => 'checkbox',
				'name' => __('Disable Back to Top button', ''), 
				'desc' => __('', ''),
				'std' => '0'// 1 = on | 0 = off
				);

															
$of_options[] =	array(
				'id' => 'md_nicescroll_disable',
				'type' => 'checkbox',
				'name' => __('Disable Scrollbar Styling', ''), 
				'desc' => __('Reframe is using Nicescroll plugin to customize the browser scrollbar styling. You can enable this option in order to use default scrollbar styling.', ''),
				'std' => '0'// 1 = on | 0 = off
				);
				
$of_options[] =	array(
				'id' => 'md_fullscreen_disabled',
				'type' => 'checkbox',
				'name' => __('Disable Fullscreen Feature', ''), 
				'desc' => __('This option allows you to remove the fullscreen icon on the top right of your website in default layout.', ''),
				'std' => '0'// 1 = on | 0 = off
				);
	


$of_options[] = array( "name" => "",
                    "id" => "md_layout_info3",
                    "std" => "<strong>CUSTOM POST OVERVIEW PAGE</strong>",
                    "type" => "info",
					"desc" => '',
					);
					

$of_options[] =	array(
				'id' => 'md_custompost_showbw',
				'type' => 'checkbox',
				'name' => __('Black & White Mouseover Effect for Thumbnails', ''), 
				'desc' => __('', ''),
				'std' => '0'// 1 = on | 0 = off
				);
	


$of_options[] =	array(
				'id' => 'md_custompost_transition',
				'type' => 'checkbox',
				'name' => __('Disable Custom Post Type Transition Effects', ''), 
				'desc' => __('This option allows you to disable CSS transition effects on custom post type overview page.', ''),
				'std' => '0'// 1 = on | 0 = off
				);
	

$of_options[] = array( "name" => "",
                    "id" => "md_layout_info3",
                    "std" => "<strong>FLOATING MENU/INFO SETTINGS</strong>",
                    "type" => "info",
					"desc" => '',
					);
					
						
$of_options[] =	array(
				'id' => 'md_js_float_menu_disable',
				'type' => 'checkbox',
				'name' => __('Disable Left Menu Floating', ''), 
				'desc' => __('Left main menu follows when you\'re scrolling down. You can disable this feature', ''),
				'std' => '0'// 1 = on | 0 = off
				);
					
$of_options[] =	array(
				'id' => 'md_js_float_works_disable',
				'type' => 'checkbox',
				'name' => __('Disable Single Project Info Floating', ''), 
				'desc' => __('Single project info follows when you\'re scrolling down. You can disable this feature', ''),
				'std' => '0'// 1 = on | 0 = off
				);
	

$of_options[] = array( "name" => "",
                    "id" => "md_layout_info3",
                    "std" => "<strong>PAGINATION TYPE</strong>",
                    "type" => "info",
					"desc" => '',
					);
					

$of_options[] = array( "name" => "Pagination Type",
				"desc" => 'This option allows you to change pagination type : 
					<br><br><strong>Infinite Scroll :</strong> It\'s set by default. New posts will be loaded while you\'re scrolling down.
					<br><br><strong>Load More :</strong> New posts will be loaded when "Load More" button is clicked.
					',
				"id" => "md_pagination_type",
				"std" => '',
				"type" => "selectkey", 
				"options" => array('infinite'=>'Infinite Scroll','loadmore'=>'Load More')); 
					
																										
				
							
$of_options[] = array(  
					"name" => "Blog Layout",
					"type" => "heading",
					"icon"=>'columns'
				 );

$of_options[] = array( "name" => "",
                    "id" => "md_layout_info2",
                    "std" => "<strong>BLOG LAYOUT SETTINGS</strong>",
                    "type" => "info",
					"desc" => '',
					);
					
					
	
$of_options[] = array( "name" => "Blog content placement on List View",
				"desc" => '',
				"id" => "md_blog_info_align",
				"std" => '',
				"type" => "select", 
				"options" => array('Right','Bottom')); 

	
$of_options[] = array( "name" => "Blog content alignment on List View",
				"desc" => 'This option allows you to set your content as center or left aligned if blog info placement has been set as "Bottom"',
				"id" => "md_blog_info_align_content",
				"std" => '',
				"type" => "select", 
				"options" => array('Center','Left')); 
							
										
	
$of_options[] = array( "name" => "Blog content placement on Single Post Pages",
				"desc" => '',
				"id" => "md_blog_info_align_single",
				"std" => '',
				"type" => "select", 
				"options" => array('Right','Bottom')); 
									


$of_options[] = array( "name" => "Blog featured content alignment on Single Post Pages",
				"desc" => 'This option allows you to display the content title and info below or above the post\'s featured content if "Blog content placement on Single Post Pages" option is set to "Bottom".',
				"id" => "md_blog_titlealignment",
				"std" => '',
				"type" => "selectkey", 
				'options'=>array('Bottom'=>'Above the title', 'Top'=>'Below the title')); 

								
$of_options[] =			array(
						'id' => 'md_theblog_limit',
						'name' => __('Pagination Limit', ''), 
						'desc' => __('Set pagination limit of blog overview page. Default is 10', ''),
						"type" => "selectkey",
						'std' => '10',
						"options" => array(
									0=>'Unlimited',
									1=>1,
									2=>2,
									3=>3,
									4=>4,
									5=>5,
									6=>6,
									7=>7,
									8=>8,
									9=>9,
									10=>10,
									11=>11,
									12=>12,
									13=>13,
									14=>14,
									15=>15,
									16=>16,
									17=>17,
									18=>18,
									19=>19,
									20=>20,
									21=>21,
									22=>22,
									23=>23,
									24=>24,
									25=>25,
									26=>26,
									27=>27,
									28=>28,
									29=>29,
									30=>30
									));  	
						

$of_options[] =	array(
				'id' => 'md_blog_hideformatonsingle',
				'type' => 'checkbox',
				'name' => __('Hide Post Format Content on Single Post Pages', ''), 
				'desc' => __('This option allows you to hide post format content (video, image, gallery etc.) on the single post pages.', ''),
				'std' => '0'// 1 = on | 0 = off
				);					
							
$of_options[] =	array(
				'id' => 'md_blog_hide_postnavigation',
				'type' => 'checkbox',
				'name' => __('Hide Post Navigation', ''), 
				'desc' => __('This option allows you to hide navigation arrows on sigle post pages.', ''),
				'std' => '0'// 1 = on | 0 = off
				);
											
$of_options[] =	array(
				'id' => 'md_blog_display_categories',
				'type' => 'checkbox',
				'name' => __('Display Categories', ''), 
				'desc' => __('By default, categories are hidden on blog overview page. This option allows you to display blog categories at the top of your blog overview page.', ''),
				'std' => '0'// 1 = on | 0 = off
				);
						

											
$of_options[] =	array(
				'id' => 'md_blog_hide_sidebar',
				'type' => 'checkbox',
				'name' => __('Hide Blog Sidebar (Widgets)', ''), 
				'desc' => __('Blog widget sidebar will be displayed if blog info alignment setting above has been set as "bottom"', ''),
				'std' => '0'// 1 = on | 0 = off
				);
						

	
											
$of_options[] =			array(
						'id' => 'md_posts_sidebar',
						'type' => 'checkbox',
						'name' => 'Blog Siderbars', 
						'desc' => __('Disable sidebar in blog posts', ''),
						'std' => '0'// 1 = on | 0 = off
						);
						
					
$of_options[] =			array(
						'id' => 'md_posts_sidebar_single',
						'type' => 'checkbox',
						'name' => '', 
						'desc' => __('Disable sidebar in single post', ''),
						'std' => '0'// 1 = on | 0 = off
						);

$of_options[] = 		array(
						'id' => 'md_post_show_category',
						'type' => 'checkbox',
						'name' => 'Blog Posts', 
						'desc' => __('Show Category', ''),
						'std' => '1'// 1 = on | 0 = off
						);
$of_options[] =			array(
						'id' => 'md_post_show_date',
						'type' => 'checkbox',
						'name' => '', 
						'desc' => __('Show Date', ''),
						'std' => '1'// 1 = on | 0 = off
						);

$of_options[] = 		array(
						'id' => 'md_post_show_author',
						'type' => 'checkbox',
						'name' => '',
						'desc' => __('Show Author info', ''), 
						'std' => '0'// 1 = on | 0 = off
						);	
$of_options[] = 		array(
						'id' => 'md_post_show_comments',
						'type' => 'checkbox',
						'name' => '', 
						'desc' => __('Show Comment Count', ''),
						'std' => '0'// 1 = on | 0 = off
						);







$of_options[] = array( "name" => "Post Sharing",
					"type" => "heading",
					"icon" =>'share');
							

$of_options[] = array(  "name" => "Disable Top Share Buttons on Single Custom Post Page",
						"desc" => "This option will disable top share buttons",
						"id" => "md_social_post_disable_top",
						"std" => "0",
						"type" => "checkbox"); 

$of_options[] = array(  "name" => "Disable Bottom Share Buttons on Single Custom Post Page",
						"desc" => "This option will disable bottom share buttons",
						"id" => "md_social_post_disable_cptbottom",
						"std" => "0",
						"type" => "checkbox"); 
									
$of_options[] = array(  "name" => "Disable Share Buttons in Blog Posts",
						"desc" => "This option will disable all share buttons on bottom left of the page",
						"id" => "md_social_post_disable_bottom",
						"std" => "0",
						"type" => "checkbox"); 
													
														
$of_options[] = array(  "name" => "Show Share Buttons in Posts",
						"desc" => "Facebook",
						"id" => "md_social_post_facebook",
						"std" => "1",
						"type" => "checkbox"); 																	
$of_options[] = array( "name" => "",
					"desc" => "Twitter",
					"id" => "md_social_post_twitter",
					"std" => "1",
					"type" => "checkbox");
					
$of_options[] = array( "name" => "",
					"desc" => "Google +",
					"id" => "md_social_post_googleplus",
					"std" => "0",
					"type" => "checkbox"); 	
										
$of_options[] = array( "name" => "",
					"desc" => "Pinterest",
					"id" => "md_social_post_pinterest",
					"std" => "0",
					"type" => "checkbox"); 
					
$of_options[] = array( "name" => "",
					"desc" => "Tumblr",
					"id" => "md_social_post_tumblr",
					"std" => "0",
					"type" => "checkbox"); 	


$of_options[] = array( "name" => "",
					"desc" => "Vkontakte",
					"id" => "md_social_post_vkshare",
					"std" => "0",
					"type" => "checkbox"); 	
	
						
$of_options[] = array( "name" => "",
					"desc" => "Linkedin",
					"id" => "md_social_post_linkedin",
					"std" => "0",
					"type" => "checkbox"); 	
 	
		
	
	
				
			



$of_options[] = array( "name" => "Header Settings",
					"type" => "heading",
					"icon" =>'file-alt'
					);
	
										
$of_options[] = array(
				'id' => 'md_header_logo',
				'type' => 'upload',
				'name' => __('Site Logo Image', ''), 
				'desc' => __('Upload your logo. Even though your image will be displayed maximum 200px width, recommended image width is 400px for retina display support. Height can be vary.', ''),
				'std'=>''
				);

$of_options[] = array(
				'id' => 'md_header_logo_size',
				'type' => 'text',
				'name' => __('Logo Width', ''),
				'desc' => __('It allows you to specify maximum width value of your logo by pixel (px). By defaut : 200<br><br>For retina display, double sized image must be uploaded. E.g. 400px wide image for 200px logo width', ''),
				'std' => '100'
				);
				
										
$of_options[] =  array(
				'id' => 'md_header_logo_text',
				'type' => 'text',
				'name' => __('Site Logo Text', ''),
				'desc' => __('You may prefer to use this text instead of your logo image. If logo image is present, this field will be ignored.', ''),
				'std' => get_bloginfo('name')
				);


$of_options[] = array( "name" => "Site Logo Size",
					"desc" => "",
					"id" => "md_header_logo_text_typo",
					"std" => array('size' => '24px','style'=>'normal','height'=>'38px'),
					"type" => "typography");  


$of_options[] = array(
				'id' => 'md_header_msg_text',
				'type' => 'textarea',
				'name' => __('Site Header Text Area', ''),
				'desc' => __('You may enter your slogan, contact information etc. HTML code is accepted.', ''),
				'std' => ''
				);
				
						
$of_options[] = array(
				'id' => 'md_menu_home_url',
				'type' => 'pagesselect',
				'name' => __('Logo URL', ''),
				'desc' => __('This option allows you to specify your logo URL. By default it\'s your wordpress root, however if you\'d activate the Intro Slider as your homepage, you may prefer to use a different URL to prevent go back home slider', ''),
				'std' => 'default' 
				);



$of_options[] =   		array(
						'id' => 'md_favicon',
						'type' => 'upload',
						'name' => __('Favicon', ''), 
						'desc' => __('Upload PNG format. Recommended size is 64px X 64px', ''),
						'std'=>''
						);
	
													
$of_options[] =  array(
				'id' => 'md_footer_logo',
				'type' => 'upload',
				'name' => __('Footer Logo', ''), 
				'desc' => __('Upload a footer logo. Note that, It will appear only in left aligned layout.', ''),
				'std'=>''
				);
					
					
$of_options[] =			array(
						'id' => 'md_main_menu_styling_enable',
						'type' => 'checkbox',
						'name' => __('Main Menu Styling', ''), 
						'desc' => __('', ''),
						'std' => '0'// 1 = on | 0 = off
						);	
						
$of_options[] =			array(
						'id' => 'md_main_menu_styling',
						'name' => __('', ''),
						'desc'=> __('This option allows you to override the styling of main menu. In order to use global font family (Fonts menu on the left), select "Default" option for font family.',''),
						"std" => array('size' => '13px','face' => 'Arial'),
						"type" => "typography"
						);	
						


						
$of_options[] =			array(
						'id' => 'md_display_submenus_always',
						'type' => 'checkbox',
						'name' => __('Show Sub Menus Always', ''), 
						'desc' => __('This option allows you to show sub menus of <strong>the main left menu</strong> even though the parent menu is not currently active.', ''),
						'std' => '0'// 1 = on | 0 = off
						);
						
$of_options[] =			array(
						'id' => 'md_header_disable_search',
						'type' => 'checkbox',
						'name' => __('Disable Search Box', ''), 
						'desc' => __('', ''),
						'std' => '0'// 1 = on | 0 = off
						);
	
	
					
					
				

$of_options[] = array( "name" => "Footer Settings",
					"type" => "heading",
					"icon"=>'file-alt');
	

$of_options[] = 		array(
						'id' => 'md_footer_text',
						'type' => 'text',
						'name' => __('Footer Text', ''),
						'desc' => __('', ''),
						'std' => ''
						);


$of_options[] =			array(
						'id' => 'md_footer_widgets_disabled',
						'type' => 'checkbox',
						'name' => __('Disable Footer Widgets', ''), 
						'desc' => __('', ''),
						'std' => '0'// 1 = on | 0 = off
						);
						

$of_options[] =			array(
						'id' => 'md_footer_widgets_columns',
						'name' => __('Footer Widgets Columns', ''), 
						'desc' => __('How many columns for footer widgets', ''),
						"type" => "select",
						'std' => '4',
						"options" => array(1,2,3,4));  	
						
						
				
				
				
				
						
													
$of_options[] = array( "name" => "Fonts",
					"type" => "heading",
					"icon"=>'font');
	
								
					
$of_options[] = array(
					'id' => 'md_font_type',
					'type' => 'selectkey',
					'name' => __('Font Type', ''),
					'desc' => __('', ''),
					'std' => 'googlefonts',
					'selectorclass'=> 1,
					'options'=>array('googlefonts'=>'Google Fonts', 'fontface'=>'@font-face', 'htmlfonts'=>'HTML Fonts')
				);


$md_font_type = of_get_option('md_font_type');

if($md_font_type=='googlefonts' || $md_font_type=='') { $fonttype_google = 1; }else{ $fonttype_google = 0; }
if($md_font_type=='htmlfonts') { $fonttype_html = 1; }else{ $fonttype_html = 0; }
if($md_font_type=='fontface') { $fonttype_ff = 1; }else{ $fonttype_ff = 0; }

	
$of_options[] = array( "name" => "",
                    "id" => "md_layout_info5",
                    "std" => "<strong>@FONT-FACE</strong>",
                    "type" => "info",
					"desc" => '<strong>Adding New Fonts</strong><br>Visit <a href="http://www.fontsquirrel.com/tools/webfont-generator" target="_blank">http://www.fontsquirrel.com/tools/webfont-generator</a> and convert your fonts to @font-face. Once you\'ve converted your fonts, there will be four different font files for cross browser support ; .ttf, .eott, .woff, .swg. 
					<br><br>
					Create a new folder, put these files into it and upload this folder into "fonts" folder which you can find inside of theme folder. You can find "museo" folder inside of "fonts" as an example font directory. Uploaded font folders will automatically be recognized and shown in the select box below. If you\'d like to add different font weights (bold and regular), you\'re supposed to create separate folders ; E.g. fontname-regular, fontname-bold',
					'commonclass'=>'fontface',
					'showfirst'=>$fonttype_ff
					);
																


$of_options[] = array( "name" => "Regular Font",
				"desc" => '',
				"id" => "md_css_fontface_regular",
				"std" => "",
				"type" => "selectkey",
				'commonclass'=>'fontface',
				'showfirst'=>$fonttype_ff,
				"options" => $fontfaces); 
				


$of_options[] = array( "name" => "Bold Font",
				"desc" => '',
				"id" => "md_css_fontface_bold",
				"std" => "",
				"type" => "selectkey",
				'commonclass'=>'fontface',
				'showfirst'=>$fonttype_ff,
				"options" => $fontfaces); 	
																		

$of_options[] = array( "name" => "",
                    "id" => "md_layout_info6",
                    "std" => "<strong>GOOGLE FONTS</strong>",
                    "type" => "info",
					"desc" => '',
					'showfirst'=>$fonttype_google,
					'commonclass'=>'googlefonts'
					);
					
										
$of_options[] = array(
						'id' => 'md_css_googlefont_header',
						'type' => 'text',
						'name' => __('Header Font', ''),
						'desc' => __('You can select header font via dropdown menu. <strong>500+</strong> google fonts are ready to use', ''),
						'std' => 'Source+Code+Pro',
						'googlefont'=>'heading',
						'showfirst'=>$fonttype_google,
						'commonclass'=>'googlefonts'
						);

				
$of_options[] = array(
						'id' => 'md_css_googlefont',
						'type' => 'text',
						'name' => __('Body Font', ''),
						'desc' => __('You can select body font via dropdown menu. <strong>500+</strong> google fonts are ready to use', ''),
						'std' => 'Source+Code+Pro',
						'googlefont'=>'text',
						'showfirst'=>$fonttype_google,
						'commonclass'=>'googlefonts'
						);


$of_options[] = array( "name" => "",
                    "id" => "md_layout_info1",
                    "std" => "<strong>HTML FONTS</strong>",
                    "type" => "info",
					"desc" => '',
					'showfirst'=>$fonttype_html,
					'commonclass'=>'htmlfonts'
					);
					
								
$of_options[] = array(
						'id' => 'md_css_htmlfont',
						'type' => 'text',
						'name' => __('', ''),
						'desc' => __('Font styles. <br>E.g : "Helvetica Neue",Helvetica, Arial', ''),
						'std' => '',	
						'showfirst'=>$fonttype_html,
						'commonclass'=>'htmlfonts'
						);	
											
$of_options[] = array( "name" => "Body Font Size",
					"desc" => "",
					"id" => "md_body_fontsize",
					"std" => array('size' => '14px'),
					"type" => "typography");  

										
											
	
									

$of_options[] = array( "name" => "SEO",
					"type" => "heading",
					'icon'=>'bar-chart');
															
$of_options[] = 		array(
						'id' => 'md_header_seo_description',
						'type' => 'textarea',
						'name' => __('Site Description', ''),
						'desc' => __('Your website\'s general description. Max 160 chars', ''),
						'std' => ''
						);
$of_options[] = 		array(
						'id' => 'md_header_seo_keywords',
						'type' => 'textarea',
						'name' => __('Site Keywords', ''),
						'desc' => __('Your website keywords for SEO optimization. Seperate by comma. E.g. Design, Portfolio, Artist, Design Blog', ''),
						'std' => ''
						);
						
$of_options[] = 		array(
						'id' => 'md_footer_googleanalytics',
						'type' => 'textarea',
						'name' => __('Google Analytics Code', ''),
						'desc' => __('Simply paste your google analytics code to get statistics.', ''),
						'std' => ''
						);
						
						


	
				
$of_options[] = array( "name" => "Social Icons",
					"type" => "heading",
					"icon"=>'twitter');
	

$of_options[] = 		array(
						'id' => 'md_social_top_hide',
						'type' => 'checkbox',
						'name' => 'Hide Header Social Icons', 
						'desc' => __('', ''),
						'std' => '0'// 1 = on | 0 = off
						);


$of_options[] = 		array(
						'id' => 'md_social_footer_hide',
						'type' => 'checkbox',
						'name' => 'Hide Footer Social Icons', 
						'desc' => __('', ''),
						'std' => '0'// 1 = on | 0 = off
						);
							

$of_options[] = 		array(
						'id' => 'md_social_left_hide',
						'type' => 'checkbox',
						'name' => 'Hide Left Menu Social Icons', 
						'desc' => __('', ''),
						'std' => '0'// 1 = on | 0 = off
						);

						
$of_options[] =  array( "name" =>  "Social Icon Colors",
					"desc" => "Icon Color",
					"id" => "md_css_socialiconcolors",
					"std" => "#fff",
					"type" => "color"); 
					
														
$of_options[] = 		array(
						'id' => 'md_social_icons',
						'type' => 'socialicons',
						'name' => __('Social Icons (Header and Footer)', ''),
						'desc' => __('', ''),
						'std' => ''
						);	
						

$of_options[] = array( "name" => "Advanced",
					"type" => "heading",
					'icon'=>'wrench');

									
				
$of_options[] =			array(
						'id' => 'md_retina_support',
						'type' => 'checkbox',
						'name' => __('Disable Retina Support', ''), 
						'desc' => __('This option allows you to deactivate retina display support.', ''),
						'std' => '0'// 1 = on | 0 = off
						);


								
$of_options[] =			array(
						'id' => 'md_master_ajax_disable',
						'type' => 'checkbox',
						'name' => __('Disable Ajax Navigation', ''), 
						'desc' => __('By default, this theme is using ajax navigation for custom post type navigation, which allows to load content without refreshing the page. All ajax queries are improved for the best performance and optimized for the search engines. However, if you wish to disable ajax queries in order to load pages via traditional HTTP requests, you can activate this option.', ''),
						'std' => '0'// 1 = on | 0 = off
						);


								
$of_options[] = 		array(
						'id' => 'md_custom_css',
						'type' => 'textarea',
						'name' => __('Custom CSS', ''),
						'desc' => __('This field allows you to add your custom css styles.', ''),
						'std' => ''
						);
														


$of_options[] = array( "name" => "",
                    "id" => "md_moveposttype_info",
                    "std" => "<strong>Moving Custom Posts</strong><br>
					PLEASE USE THIS OPTION CAREFULLY, THIS ACTION CANNOT BE UNDONE.<br>
					This option allows you to move your specific custom post type posts into another one. Also old post type categories will be assigned to the new post type.<br><br>
					For example, you have 2 different post types : works and projects. To move the posts you've created for 'works' into 'projects', pick corresponding post names and run the script.
					<br><br>
					PLEASE NOTE THAT ; the categories which belong to old post type will be MOVED to the new post type along with posts.
					",
                    "type" => "info",
					"desc" => '',
					);
					
										
$of_options[] = 		array(
						'id' => 'md_moveposttype',
						'type' => 'moveposttype',
						'name' => __('Move Custom Post Types', ''),
						'desc' => __('', ''),
						'std' => '0'
						);	
				
								

// Backup Options
$of_options[] = array( "name" => "Transfer",
					"type" => "heading",
					"icon"=>'exchange'
					);
					
$of_options[] = array( "name" => "Backup and Restore Options",
                    "id" => "of_backup",
                    "std" => "",
                    "type" => "backup",
					"desc" => 'You can use the two buttons below to backup your current options, and then restore it back at a later time. This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back.',
					);
					
$of_options[] = array( "name" => "Transfer Theme Options Data",
                    "id" => "of_transfer",
                    "std" => "",
                    "type" => "transfer",
					"desc" => 'You can tranfer the saved options data between different installs by copying the text inside the text box. To import data from another install, replace the data in the text box with the one from another install and click "Import Options".
						',
					);
					
	
$of_options[] = array( "name" => "",
                    "id" => "md_migrate_info",
                    "std" => "<strong>Update Your Domain Name for Custom Post Type Images</strong><br>
					DO NOT USE THIS OPTION UNLESS YOUR DOMAIN NAME IS CHANGED<br>
					This option must be used when your Wordpress content has been moved/imported into another Wordpress (remote server/local server etc.). It allows you to update the current URLs of the custom post type images. This is a required step since custom post type images are using absolute URL paths.
					<br><br>
					In order to complete this step, enter your previous website URL and new website URL below, then click to Replace URLs button.<br><br>
					Before proceed, it's strongly recommended to backup your Database.
					",
                    "type" => "info",
					"desc" => '',
					);
					
										
$of_options[] = 		array(
						'id' => 'md_migrate_local',
						'type' => 'migrate',
						'name' => __('Replace URLs', ''),
						'desc' => __('', ''),
						'std' => '0'
						);	
				
																
	}
}
?>
