<?php 

class Options_Machine {

	/**
	 * PHP5 contructor
	 *
	 * @since 1.0.0
	 */
	function __construct($options) {
		
		$return = $this->optionsframework_machine($options);
		
		$this->Inputs = $return[0];
		$this->Menu = $return[1];
		$this->Defaults = $return[2];
		
	}


	/**
	 * Process options data and build option fields
	 *
	 * @uses get_option()
	 *
	 * @access public
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function optionsframework_machine($options) {
		
	    @$data = get_option(OPTIONS);
		
		$defaults = array();   
	    $counter = 0;
		$menu = '';
		$output = '';
		
		foreach ($options as $value) {
		
			$counter++;
			$val = '';
			
			//create array of defaults		
			if ($value['type'] == 'multicheck'){
				if (is_array($value['std'])){
					foreach($value['std'] as $i=>$key){
						$defaults[$value['id']][$key] = true;
					}
				} else {
						$defaults[$value['id']][$value['std']] = true;
				}
			} else {
				if (isset($value['id'])) $defaults[$value['id']] = $value['std'];
			}
			
			//Start Heading
			 if ( $value['type'] != "heading" )
			 {
			 	$class = ''; if(isset( $value['class'] )) { $class = $value['class']; }
				
				//hide items in checkbox group
				$fold='';
				if (array_key_exists("fold",$value)) {
					if (@$data[$value['fold']]) {
						$fold="f_".$value['fold']." ";
					} else {
						$fold="f_".$value['fold']." temphide ";
					}
				}
				
				
				$addclass = '';
				if(isset($value['commonclass'])) { 
					$addclass = $value['commonclass'].' hideoptions';
					if(isset($value['showfirst']) && !($value['showfirst'])) { 
						$addclass .= ' hidethisoption';
					}
				}
				
				if(isset($value['selectorclass'])) { 
					$addclass .= ' showhideselect';
				}
				
				
				if(isset($value['display'])) {
				$output .= '<div id="section-'.$value['id'].'" class="'.$fold.'section '.$addclass.' '.$value['display'].' section-'.$value['type'].' '. $class .'">'."\n";
				}else{
				$output .= '<div id="section-'.$value['id'].'" class="'.$fold.'section '.$addclass.' section-'.$value['type'].' '. $class .'">'."\n";
				}
				//only show header if 'name' value exists
				if($value['name']) $output .= '<h3 class="heading">'. $value['name'] .'</h3>'."\n";
				
				$output .= '<div class="option">'."\n" . '<div class="controls">'."\n";
	
			 } 
			 //End Heading
			
			//switch statement to handle various options type                              
			switch ( $value['type'] ) {
			
				//text input
				case 'text':
					$t_value = '';
					$t_value = htmlspecialchars(stripslashes(@$data[$value['id']]), ENT_QUOTES, "UTF-8");
					
					$mini ='';
					if(!isset($value['mod'])) $value['mod'] = '';
					if($value['mod'] == 'mini') { $mini = 'mini';}
					if(!isset($value['googlefont'])) $value['googlefont']="";
					
						if($value['googlefont']=='text') { 
							$scclass='gfontscome '; 
						}elseif($value['googlefont']=='heading'){ 
							$scclass='gfontscomehead '; 
						}else{
							$scclass='';	
						}
					
					
					$output .= '<input class="of-input '.$scclass.$mini.'" name="'.$value['id'].'" id="'. $value['id'] .'" type="'. $value['type'] .'" value="'. $t_value .'" />';
					
					if($value['googlefont']=='text') { 
					$output .= '<p class="gfontsview" style="font-family:\''.str_replace('+',' ',$t_value).'\'">Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
								 Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, 
								 when an unknown printer took a galley of type and scrambled it to make a type 
								 specimen book. It has survived not only five centuries, but also the leap into
								 electronic typesetting, remaining essentially unchanged.</p><br><br>';
					}elseif($value['googlefont']=='heading') {
					$output .= '<br><h1 class="gfontsviewhead" style="font-size:34px; font-family:\''.str_replace('+',' ',$t_value).'\'; line-height:1.4em">Grumpy wizards make toxic brew for the evil Queen and Jack</h1><br><br><br><br><br><br>';	
					}
					
					$scclass='';
				break;
				
				//select option
				case 'select':
					$mini ='';
					if(!isset($value['mod'])) $value['mod'] = '';
					if($value['mod'] == 'mini') { $mini = 'mini';}
					$output .= '<div class="select_wrapper ' . $mini . '">';
					$output .= '<select class="select of-input" name="'.$value['id'].'" id="'. $value['id'] .'">';
					foreach ($value['options'] as $select_ID => $option) {	
						
						if($select_ID!='') {
							$myval = $select_ID;
						}else{
							$myval = $option;
						}
						$selecteds=selected(@$data[$value['id']], $option, false);
						
						$output .= '<option id="' . $select_ID . '" value="'.$option.'" ' . $selecteds. ' />'.$option.'</option>';	 
						if($selecteds) {
							$moption = $option;
						}
					 } 
					$output .= '</select></div>';
					if(isset($value['bgpatterns'])==1) {
					$output .= '<br><br><div class="bgpatterndiv" style="background:url('.get_template_directory_uri().'/images/bgpatterns/'.@$moption.');width:338px;border:1px solid #ccc; height:200px; float:left"></div>';
					}
					$moption = '';
				break;
				
				
				//select option
				case 'selectkey':
					$mini ='';
					if(!isset($value['mod'])) $value['mod'] = '';
					if($value['mod'] == 'mini') { $mini = 'mini';}
					$output .= '<div class="select_wrapper ' . $mini . '">';
					$output .= '<select class="select of-input" name="'.$value['id'].'" id="'. $value['id'] .'">';
					foreach ($value['options'] as $select_ID => $option) {	
						
						$selecteds=selected(@$data[$value['id']], $select_ID, false);	
						$output .= '<option id="' . $select_ID . '" value="'.$select_ID.'" ' . $selecteds. ' />'.$option.'</option>';	 
						if($selecteds) {
							$moption = $option;
						}
						
					 } 
					$output .= '</select></div>';
					if(isset($value['bgpatterns'])==1) {
					$output .= '<br><br><div class="bgpatterndiv" style="background:url('.get_template_directory_uri().'/images/bgpatterns/'.@$moption.');width:338px;border:1px solid #ccc; height:200px; float:left"></div>';
					}
					$moption = '';
				break;
				
				
				//select option
				case 'pagesselect':
					$mini ='';
					if(!isset($value['mod'])) $value['mod'] = '';
					if($value['mod'] == 'mini') { $mini = 'mini';}
					$output .= '<div class="select_wrapper ' . $mini . '">';
					$output .= '<select class="select of-input" name="'.$value['id'].'" id="'. $value['id'] .'">';
					
					$output .= '<option id="default" value="default" ' . @$selecteds. ' />default</option>';
					
					$parr = get_pages( array('post_type'=>'page') );
					
					foreach($parr as $foo) {
						
						$selecteds=selected(@$data[$value['id']],$foo->ID, false);	
						$output .= '<option id="' . $foo->ID. '" value="'.$foo->ID.'" ' . $selecteds. ' />'.$foo->post_name.'</option>';	 
						
					 } 
					$output .= '</select></div>';
					$moption = '';
				break;
				
				//textarea option
				case 'textarea':	
					$cols = '8';
					$ta_value = '';
					
					if(isset($value['options'])){
							$ta_options = $value['options'];
							if(isset($ta_options['cols'])){
							$cols = $ta_options['cols'];
							} 
						}
						
						$ta_value = stripslashes(@$data[$value['id']]);			
						$output .= '<textarea class="of-input" name="'.$value['id'].'" id="'. $value['id'] .'" cols="'. $cols .'" rows="8">'.$ta_value.'</textarea>';		
				break;
				
				//radiobox option
				case "radio":
					
					 foreach($value['options'] as $option=>$name) {
						$output .= '<input class="of-input of-radio" name="'.$value['id'].'" type="radio" value="'.$option.'" ' . checked(@$data[$value['id']], $option, false) . ' /><label class="radio">'.$name.'</label><br/>';				
					}
				break;
				
				//checkbox option
				case 'checkbox':
					if (!isset($data[$value['id']])) {
						@$data[$value['id']] = 0;
					}
					
					$fold = '';
					if (array_key_exists("folds",$value)) $fold="fld ";
		
					$output .= '<input type="hidden" class="'.$fold.'checkbox aq-input" name="'.$value['id'].'" id="'. $value['id'] .'" value="0"/>';
					$output .= '<div class="ibuttonwrap"><input type="checkbox" class="'.$fold.'checkbox of-input ibutton" name="'.$value['id'].'" id="'. $value['id'] .'" value="1" '. checked(@$data[$value['id']], 1, false) .' /></div>';
				break;
                                      
				
				//multiple checkbox option
				case 'multicheck': 			
					$multi_stored = @$data[$value['id']];
								
					foreach ($value['options'] as $key => $option) {
						if (!isset($multi_stored[$key])) {$multi_stored[$key] = '';}
						$of_key_string = $value['id'] . '_' . $key;
						$output .= '<input type="checkbox" class="checkbox of-input" name="'.$value['id'].'['.$key.']'.'" id="'. $of_key_string .'" value="1" '. checked($multi_stored[$key], 1, false) .' /><label class="multicheck" for="'. $of_key_string .'">'. $option .'</label><br />';								
					}			 
				break;
				
				//ajax image upload option
				case 'upload':
					if(!isset($value['mod'])) $value['mod'] = '';
					$output .= Options_Machine::optionsframework_uploader_function($value['id'],$value['std'],$value['mod']);			
				break;
				
				// native media library uploader - @uses optionsframework_media_uploader_function()
				case 'media':
					$_id = strip_tags( strtolower($value['id']) );
					$int = '';
					$int = optionsframework_mlu_get_silentpost( $_id );
					if(!isset($value['mod'])) $value['mod'] = '';
					$output .= Options_Machine::optionsframework_media_uploader_function( $value['id'], $value['std'], $int, $value['mod'] ); // New AJAX Uploader using Media Library			
				break;
				
				//colorpicker option
				case 'color':		
					$output .= '<div id="' . $value['id'] . '_picker" class="colorSelector"><div style="background-color: '.@$data[$value['id']].'"></div></div>';
					$output .= '<input class="of-color" name="'.$value['id'].'" id="'. $value['id'] .'" type="text" value="'. @$data[$value['id']] .'" />';
				break;
				
				//typography option	
				case 'typography':
				
					$typography_stored = isset($data[$value['id']]) ? @$data[$value['id']] : $value['std'];
					
					/* Font Size */
					
					if(isset($typography_stored['size'])) {
						$output .= '<div class="select_wrapper typography-size" original-title="Font size">';
						$output .= '<select class="of-typography of-typography-size select" name="'.$value['id'].'[size]" id="'. $value['id'].'_size">';
						if($value['id'] == 'md_body_fontsize' || $value['id'] == 'md_main_menu_styling') {
							$mini = '10';
							$maxi = '28';
						}else{
							$mini = '14';
							$maxi = '72';
						}
							for ($i = $mini; $i < $maxi; $i++){ 
								$test = $i.'px';
								$output .= '<option value="'. $i .'px" ' . selected($typography_stored['size'], $test, false) . '>'. $i .'px</option>'; 
								}
				
						$output .= '</select></div>';
					
					}
					
					/* Line Height */
					if(isset($typography_stored['height'])) {
					
						$output .= '<div class="select_wrapper typography-height" original-title="Line height">';
						$output .= '<select class="of-typography of-typography-height select" name="'.$value['id'].'[height]" id="'. $value['id'].'_height">';
							for ($i = 18; $i < 90; $i++){ 
								$test = $i.'px';
								$output .= '<option value="'. $i .'px" ' . selected($typography_stored['height'], $test, false) . '>'. $i .'px</option>'; 
								}
				
						$output .= '</select></div>';
					
					}
						
					/* Font Face */
					if(isset($typography_stored['face'])) {
					
						$output .= '<div class="select_wrapper typography-face" original-title="Font family">';
						$output .= '<select class="of-typography of-typography-face select" name="'.$value['id'].'[face]" id="'. $value['id'].'_face">';
						
						$faces = array('default'=>'Default',
										'Helvetica Neue,Helvetica,Arial'=>'Helvetica Neue',
										'arial'=>'Arial',
										'verdana, geneva'=>'Verdana, Geneva',
										'trebuchet'=>'Trebuchet',
										'georgia' =>'Georgia',
										'times'=>'Times New Roman',
										'tahoma'=>'Tahoma, Geneva',
										'palatino'=>'Palatino',
										'helvetica'=>'Helvetica' );			
						foreach ($faces as $i=>$face) {
							$output .= '<option value="'. $i .'" ' . selected($typography_stored['face'], $i, false) . '>'. $face .'</option>';
						}			
										
						$output .= '</select></div>';
					
					}
					
					/* Font Weight */
					if(isset($typography_stored['style'])) {
					
						$output .= '<div class="select_wrapper typography-style" original-title="Font style">';
						$output .= '<select class="of-typography of-typography-style select" name="'.$value['id'].'[style]" id="'. $value['id'].'_style">';
						$styles = array('normal'=>'Normal',
										'bold'=>'Bold'
										//'italic'=>'Italic',
										//'bold italic'=>'Bold Italic'
										);
										
						foreach ($styles as $i=>$style){
						
							$output .= '<option value="'. $i .'" ' . selected($typography_stored['style'], $i, false) . '>'. $style .'</option>';		
						}
						$output .= '</select></div>';
					
					}
					
					/* Font Color */
					if(isset($typography_stored['color'])) {
					
						$output .= '<div id="' . $value['id'] . '_color_picker" class="colorSelector typography-color"><div style="background-color: '.$typography_stored['color'].'"></div></div>';
						$output .= '<input class="of-color of-typography of-typography-color" original-title="Font color" name="'.$value['id'].'[color]" id="'. $value['id'] .'_color" type="text" value="'. $typography_stored['color'] .'" />';
					
					}
					
				break;
				
				//border option
				case 'border':
						
					/* Border Width */
					$border_stored = @$data[$value['id']];
					
					$output .= '<div class="select_wrapper border-width">';
					$output .= '<select class="of-border of-border-width select" name="'.$value['id'].'[width]" id="'. $value['id'].'_width">';
						for ($i = 0; $i < 21; $i++){ 
							$output .= '<option value="'. $i .'" ' . selected($border_stored['width'], $i, false) . '>'. $i .'</option>'; 
						}
					$output .= '</select></div>';
					
					/* Border Style */
					$output .= '<div class="select_wrapper border-style">';
					$output .= '<select class="of-border of-border-style select" name="'.$value['id'].'[style]" id="'. $value['id'].'_style">';
					
					$styles = array('none'=>'None',
									'solid'=>'Solid',
									'dashed'=>'Dashed',
									'dotted'=>'Dotted');
									
					foreach ($styles as $i=>$style){
						$output .= '<option value="'. $i .'" ' . selected($border_stored['style'], $i, false) . '>'. $style .'</option>';		
					}
					
					$output .= '</select></div>';
					
					/* Border Color */		
					$output .= '<div id="' . $value['id'] . '_color_picker" class="colorSelector"><div style="background-color: '.$border_stored['color'].'"></div></div>';
					$output .= '<input class="of-color of-border of-border-color" name="'.$value['id'].'[color]" id="'. $value['id'] .'_color" type="text" value="'. $border_stored['color'] .'" />';
					
				break;
				
				//images checkbox - use image as checkboxes
				case 'images':
				
					$i = 0;
					
					$select_value = @$data[$value['id']];
					
					foreach ($value['options'] as $key => $option) 
					{ 
					$i++;
			
						$checked = '';
						$selected = '';
						if(NULL!=checked($select_value, $key, false)) {
							$checked = checked($select_value, $key, false);
							$selected = 'of-radio-img-selected';  
						}
						$output .= '<span>';
						$output .= '<input type="radio" id="of-radio-img-' . $value['id'] . $i . '" class="checkbox of-radio-img-radio" value="'.$key.'" name="'.$value['id'].'" '.$checked.' />';
						$output .= '<div class="of-radio-img-label">'. $key .'</div>';
						$output .= '<img src="'.$option.'" alt="" class="of-radio-img-img '. $selected .'" onClick="document.getElementById(\'of-radio-img-'. $value['id'] . $i.'\').checked = true; checkAllFields();" />';
						$output .= '</span>';				
					}
					
				break;
				
				//info (for small intro box etc)
				case "info":
					$info_text = $value['std'];
					$output .= '<div class="of-info">'.$info_text.'</div>';
				break;
				
				//display a single image
				case "image":
					$src = $value['std'];
					$output .= '<img src="'.$src.'">';
				break;
				
				//tab heading
				case 'heading':
					if($counter >= 2){
					   $output .= '</div>'."\n";
					}
					$header_class = str_replace(' ','',strtolower($value['name']));
					$icon_class = str_replace(' ','',strtolower(@$value['icon']));
					$jquery_click_hook = str_replace(' ', '', strtolower($value['name']) );
					$jquery_click_hook = "of-option-" . $jquery_click_hook;
					$menu .= '<li class="'.$header_class.'"><a title="'.  $value['name'] .'" href="#'.  $jquery_click_hook  .'"><i class="icon-'. $icon_class .'"></i> '.  $value['name'] .'</a></li>';
					$output .= '<div class="group" id="'. $jquery_click_hook  .'"><h2>'.$value['name'].'</h2>'."\n";
				break;
				
				//drag & drop slide manager
				case 'slider':
					$_id = strip_tags( strtolower($value['id']) );
					$int = '';
					$int = optionsframework_mlu_get_silentpost( $_id );
					$output .= '<div class="slider sliderordering"><ul id="'.$value['id'].'" rel="'.$int.'">';
					$slides = @$data[$value['id']];
					$count = count($slides);
					if ($count < 2) {
						$oldorder = 1;
						$order = 1;
						$output .= Options_Machine::optionsframework_slider_function($value['id'],$value['std'],$oldorder,$order,$int);
					} else {
						$i = 0;
						foreach ($slides as $slide) {
							$oldorder = $slide['order'];
							$i++;
							$order = $i;
							$output .= Options_Machine::optionsframework_slider_function($value['id'],$value['std'],$oldorder,$order,$int);
						}
					}			
					$output .= '</ul>';
					$output .= '<a href="#" class="button slide_add_button">Add New Slide</a></div>';
					
				break;
				
				
				
				case 'sliderintro':
					$_id = strip_tags( strtolower($value['id']) );
					$int = '';
					$int = optionsframework_mlu_get_silentpost( $_id );
					$output .= '<div class="slider sliderordering"><ul id="'.$value['id'].'" rel="'.$int.'">';
					$slides = @$data[$value['id']];
					$count = count($slides);
					if ($count < 2) {
						$oldorder = 1;
						$order = 1;
						$output .= Options_Machine::optionsframework_slider_intro_function($value['id'],$value['std'],$oldorder,$order,$int);
					} else {
						$i = 0;
						foreach ($slides as $slide) {
							$oldorder = $slide['order'];
							$i++;
							$order = $i;
							$output .= Options_Machine::optionsframework_slider_intro_function($value['id'],$value['std'],$oldorder,$order,$int);
						}
					}			
					$output .= '</ul>';
					$output .= '<a href="#" class="button slide_add_button_intro">Add New Slide</a></div>';
					
				break;
				
				
				
				
					//drag & drop slide manager
				case 'customposts':
					$_id = strip_tags( strtolower($value['id']) );
					$int = '';
					$int = optionsframework_mlu_get_silentpost( $_id );
					$output .= '<div class="slider"><ul id="'.$value['id'].'" rel="'.$int.'">';
					$slides = @$data[$value['id']];
					$count = count($slides);
					if ($count < 2) {
						$oldorder = 1;
						$order = 1;
						$output .= Options_Machine::optionsframework_custompost_function($value['id'],$value['std'],$oldorder,$order,$int);
					} else {
						$i = 0;
						foreach ($slides as $slide) {
							$oldorder = $slide['order'];
							$i++;
							$order = $i;
							$output .= Options_Machine::optionsframework_custompost_function($value['id'],$value['std'],$oldorder,$order,$int);
						}
					}			
					$output .= '</ul>';
					$output .= '<a href="#" class="button custompost_add_button" style="background: #cc0000;color: #fff;text-shadow: none;">Create New Post Type</a></div>';
				break;
				
				
					//drag & drop slide manager
				case 'custompostsordering':
					$_id = strip_tags( strtolower($value['id']) );
					$int = '';
					$int = optionsframework_mlu_get_silentpost( $_id );
					
					$output .= Options_Machine::optionsframework_custompost_ordering_function($value['id'],$value['std'],$oldorder,$order,$int);	
					
				break;
				
				
					//drag & drop slide manager
				case 'customtaxonomysordering':
					$_id = strip_tags( strtolower($value['id']) );
					$int = '';
					$int = optionsframework_mlu_get_silentpost( $_id );
					
					$output .= Options_Machine::optionsframework_customtaxonomy_ordering_function($value['id'],$value['std'],$oldorder,$order,$int);	
					
				break;
				
				
				
				
				//drag & drop block manager
				case 'sorter':
				
					$sortlists = isset($data[$value['id']]) && !empty($data[$value['id']]) ? @$data[$value['id']] : $value['std'];
					
					$output .= '<div id="'.$value['id'].'" class="sorter">';
					
					
					if ($sortlists) {
					
						foreach ($sortlists as $group=>$sortlist) {
						
							$output .= '<ul id="'.$value['id'].'_'.$group.'" class="sortlist_'.$value['id'].'">';
							$output .= '<h3>'.$group.'</h3>';
							
							foreach ($sortlist as $key => $list) {
							
								$output .= '<input class="sorter-placebo" type="hidden" name="'.$value['id'].'['.$group.'][placebo]" value="placebo">';
									
								if ($key != "placebo") {
								
									$output .= '<li id="'.$key.'" class="sortee">';
									$output .= '<input class="position" type="hidden" name="'.$value['id'].'['.$group.']['.$key.']" value="'.$list.'">';
									$output .= $list;
									$output .= '</li>';
									
								}
								
							}
							
							$output .= '</ul>';
						}
					}
					
					$output .= '</div>';
				break;
				
				//background images option
				case 'tiles':
					
					$i = 0;
					$select_value = isset($data[$value['id']]) && !empty($data[$value['id']]) ? @$data[$value['id']] : '';
					
					foreach ($value['options'] as $key => $option) 
					{ 
					$i++;
			
						$checked = '';
						$selected = '';
						if(NULL!=checked($select_value, $option, false)) {
							$checked = checked($select_value, $option, false);
							$selected = 'of-radio-tile-selected';  
						}
						$output .= '<span>';
						$output .= '<input type="radio" id="of-radio-tile-' . $value['id'] . $i . '" class="checkbox of-radio-tile-radio" value="'.$option.'" name="'.$value['id'].'" '.$checked.' />';
						$output .= '<div class="of-radio-tile-img '. $selected .'" style="background: url('.$option.')" onClick="document.getElementById(\'of-radio-tile-'. $value['id'] . $i.'\').checked = true;"></div>';
						$output .= '</span>';				
					}
					
				break;
				
				
				//drag & drop slide manager
				case 'socialicons':
					$icons = '';
					if(isset($data[$value['id']]))
					$icons = @$data[$value['id']];
					
					$iconset = array(
						'A'=>'Amazon',
						'B'=>'Bebo',
						'E'=>'Behance',
						'J'=>'Deviantart',
						'D'=>'Dribble',
						'F'=>'Facebook',
						'N'=>'Flickr',
						'icon-google-plus'=>'Google',
						'I'=>'Linkedin',
						'H'=>'Skype',
						'L'=>'Twitter',
						'M'=>'My Space',
						'O'=>'Tumblr',
						'P'=>'Paypal',
						'Q'=>'Quora',
						'R'=>'RSS',
						'S'=>'StumbleUpon',
						'T'=>'Twitter (T)',
						'U'=>'Blogger',
						'V'=>'Vimeo',
						'W'=>'Wordpress',
						'X'=>'Youtube',
						'Z'=>'AOL',
						'!'=>'SoundCloud',
						'$'=>'Me',
						'&'=>'Pinterest',
						'4'=>'Picasa',
						'6'=>'Last FM',
						'icon-vk'=>'Vkontakte',
						'icon-instagram'=>'Instagram',
						'icon-xing'=>'Xing'
					);
					
					$iconselect = '<select name="'.$value['id'].'[type][]" style="width:120px;">';
					
							asort($iconset);
							
							foreach ($iconset as $a=>$b) {
								$iconselect .= '<option value="'.$a.'">'.$b.'</option>';
							}
					$iconselect .= '</select>';
					
					
					$output .= '<div class="socialiconsmaincontent">';
					
					$output .= '<ul class="socialiconscontent">';
					
					if(is_array($icons)) { 
						$s=0;
						foreach ($icons['type'] as $v) {
							$output .= '<li style="position:relative">'.str_replace('value="'.$v.'"','value="'.$v.'" selected',$iconselect).' <input class="of-input" style="width:200px;" placeholder="Link. E.g. http://facebook.com/Northeme" name="'.$value['id'].'[link][]" type="'. $value['type'] .'" value="'. $icons['link'][$s] .'" /> <a class="slide_delete_button" data-w="socialicon" href="#" style="position:absolute; right:-18px; top:6px;">Delete</a></li>';
						
						$s++;
						}
					}
					
					$output .= '</ul>';
					
					$output .= '<div class="socialiconsdiv" style="display:none">'.str_replace('<select','<select disabled="disabled"',$iconselect).' <input class="of-input" disabled="disabled" name="'.$value['id'].'[link][]" type="'. $value['type'] .'" placeholder="Link. E.g. http://facebook.com/Northeme" value="" style="width:200px;" /> <a class="slide_delete_button" data-w="socialicon" href="#" style="position:absolute; right:-18px; top:6px;">Delete</a></div>';
					
					
					$output .= '<a href="#" class="button socialicon_add_button" style="background: #cc0000;color: #fff;text-shadow: none;">Add New Social Link</a></div>';
					
				break;
				
				
				
				//backup and restore options data
				case 'backup':
				
					$instructions = $value['desc'];
					$backup = get_option(BACKUPS);
					
					if(!isset($backup['backup_log'])) {
						$log = 'No backups yet';
					} else {
						$log = $backup['backup_log'];
					}
					
					$output .= '<div class="backup-box">';
					$output .= '<div class="instructions">'.$instructions."\n";
					$output .= '<p><strong>'. __('Last Backup : ','northeme').'<span class="backup-log">'.$log.'</span></strong></p></div>'."\n";
					$output .= '<a href="#" id="of_backup_button" class="button" title="Backup Options">Backup Options</a>';
					$output .= '<a href="#" id="of_restore_button" class="button" title="Restore Options">Restore Options</a>';
					$output .= '</div>';
				
				break;
				
				//export or import data between different installs
				case 'transfer':
				
					$instructions = $value['desc'];
					$output .= '<textarea id="export_data" rows="8">'.base64_encode(serialize(@$data)) /* 100% safe - ignore theme check nag */ .'</textarea>'."\n";
					$output .= '<a href="#" id="of_import_button" class="button" title="Restore Options">Import Options</a>';
				
				break;
			
				case 'migrate':
				
					$output .= 'Your Previous Domain (http://localhost)<br><input type="text" id="md_migrate_old" name="md_migrate_old" value=""><br>';
					$output .= 'Your New Domain (http://www.yournewsite.com)<br><input type="text" id="md_migrate_new" name="md_migrate_new" value=""><br><br>';
					$output .= '<a href="#" id="of_migrate_button" class="button" title="Replace URLs">Replace URLs</a>';
				
				break;
				
				case 'moveposttype':
					@$mydtas = get_option(OPTIONS);
	
						if(isset($data['md_custom_posts']) && !is_array($data['md_custom_posts'])) { 
							$mydtas['md_custom_posts']['works']['plural'] = "Works";
							$mydtas['md_custom_posts']['works']['title'] = "works";
						}
						
						$mydtas['md_custom_posts']['blog']['plural'] = "Blog";
						$mydtas['md_custom_posts']['blog']['title'] = "post";	
								
								
						$selects1 = '<select id="md_movepost_old" name="md_movepost_old" style="width:150px;">';
						$selects2 = '<select id="md_movepost_new" name="md_movepost_new" style="width:150px;">';
						
						$switchcat = '';
						
						foreach($mydtas['md_custom_posts'] as $foos) {
							$selects1 .= '<option value="'.$foos['title'].'">'.$foos['plural'].'</option>';
							$selects2 .= '<option value="'.$foos['title'].'">'.$foos['plural'].'</option>';
						}
						
						$selects1 .= '</select>';
						$selects2 .= '</select>';
						
						$output .= 'Old Post Name (E.g. works)<br>'.$selects1.'<br>';
						$output .= 'New Post Name (E.g. projects)<br>'.$selects2.'<br><br>';
						
						
						
					
					$output .= '<a href="#" id="of_movepost_button" class="button" title="Move Posts">Move Posts</a>';
				
				break;
			
			
			}
			
			//description of each option
			if ( $value['type'] != 'heading' ) { 
				if(!isset($value['desc'])){ $explain_value = ''; } else{ 
					$add100 = '';
					if($value['type']=='info') {
						$add100 = 'style="width:100%; margin-top:20px;"';	
					}
					
					$explain_value = '<div class="explain" '.$add100.'>'. $value['desc'] .'</div>'."\n"; 
				} 
				$output .= '</div>'.$explain_value."\n";
				$output .= '<div class="clear"> </div></div></div>'."\n";
				}
		   
		   
		}
		
	    $output .= '</div>';
	    
	    return array($output,$menu,$defaults);
	    
	}


	/**
	 * Ajax image uploader - supports various types of image types
	 *
	 * @uses get_option()
	 *
	 * @access public
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function optionsframework_uploader_function($id,$std,$mod){
	
	    $data =get_option(OPTIONS);
		
		$uploader = '';
	    $upload = @$data[$id];
		$hide = '';
		
		if ($mod == "min") {$hide ='hide';}
		
	    if ( $upload != "") { $val = $upload; } else {$val = $std;}
	    
		$uploader .= '<input class="'.$hide.' upload of-input" name="'. $id .'" id="'. $id .'_upload" value="'. $val .'" />';	
		
		$uploader .= '<div class="upload_button_div"><span class="button image_upload_button" id="'.$id.'">'._('Upload').'</span>';
		
		if(!empty($upload)) {$hide = '';} else { $hide = 'hide';}
		$uploader .= '<span class="button image_reset_button '. $hide.'" id="reset_'. $id .'" title="' . $id . '">Remove</span>';
		$uploader .='</div>' . "\n";
	    $uploader .= '<div class="clear"></div>' . "\n";
		if(!empty($upload)){
			$uploader .= '<div class="screenshot">';
	    	$uploader .= '<a class="of-uploaded-image" href="'. $upload . '">';
	    	$uploader .= '<img class="of-option-image" id="image_'.$id.'" src="'.$upload.'" alt="" />';
	    	$uploader .= '</a>';
			$uploader .= '</div>';
			}
		$uploader .= '<div class="clear"></div>' . "\n"; 
	
		return $uploader;
	
	}

	/**
	 * Native media library uploader
	 *
	 * @uses get_option()
	 *
	 * @access public
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function optionsframework_media_uploader_function($id,$std,$int,$mod){
	
	    @$data =get_option(OPTIONS);
		
		$uploader = '';
	    $upload = @$data[$id];
		$hide = '';
		
		if ($mod == "min") {$hide ='hide';}
		
	    if ( $upload != "") { $val = $upload; } else {$val = $std;}
	    
		$uploader .= '<input class="'.$hide.' upload of-input" name="'. $id .'" id="'. $id .'_upload" value="'. $val .'" />';	
		
		$uploader .= '<div class="upload_button_div"><span class="button media_upload_button" id="'.$id.'" rel="' . $int . '">Upload</span>';
		
		if(!empty($upload)) {$hide = '';} else { $hide = 'hide';}
		$uploader .= '<span class="button mlu_remove_button '. $hide.'" id="reset_'. $id .'" title="' . $id . '">Remove</span>';
		$uploader .='</div>' . "\n";
		$uploader .= '<div class="screenshot">';
		if(!empty($upload)){	
	    	$uploader .= '<a class="of-uploaded-image" href="'. $upload . '">';
	    	$uploader .= '<img class="of-option-image" id="image_'.$id.'" src="'.$upload.'" alt="" />';
	    	$uploader .= '</a>';			
			}
		$uploader .= '</div>';
		$uploader .= '<div class="clear"></div>' . "\n"; 
	
		return $uploader;
		
	}

	/**
	 * Drag and drop slides manager
	 *
	 * @uses get_option()
	 *
	 * @access public
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function optionsframework_slider_function($id,$std,$oldorder,$order,$int){
	
	    @$data = get_option(OPTIONS);
		
		$slider = '';
		$slide = array();
	    $slide = @$data[$id];
		
	    if (isset($slide[$oldorder])) { $val = $slide[$oldorder]; } else {$val = $std;}
		
		//initialize all vars
		$slidevars = array('title','url','link','description');
		
		foreach ($slidevars as $slidevar) {
			if (!isset($val[$slidevar])) {
				$val[$slidevar] = '';
			}
		}
		
		//begin slider interface	
		if (!empty($val['title'])) {
			$slider .= '<li><div class="slide_header"><strong>'.stripslashes($val['title']).'</strong>';
		} else {
			$slider .= '<li><div class="slide_header"><strong>Slide '.$order.'</strong>';
		}
		
		$slider .= '<input type="hidden" class="slide of-input order" name="'. $id .'['.$order.'][order]" id="'. $id.'_'.$order .'_slide_order" value="'.$order.'" />';
	
		$slider .= '<a class="slide_edit_button" href="#">Edit</a></div>';
		
		$slider .= '<div class="slide_body">';
		
		$slider .= '<label>Title</label>';
		$slider .= '<input class="slide of-input of-slider-title" name="'. $id .'['.$order.'][title]" id="'. $id .'_'.$order .'_slide_title" value="'. stripslashes($val['title']) .'" />';
		
		$slider .= '<label>Image URL</label>';
		$slider .= '<input class="slide of-input" name="'. $id .'['.$order.'][url]" id="'. $id .'_'.$order .'_slide_url" value="'. $val['url'] .'" />';
		
		$slider .= '<div class="upload_button_div"><span class="button media_upload_button" id="'.$id.'_'.$order .'" rel="' . $int . '">Upload</span>';
		
		if(!empty($val['url'])) {$hide = '';} else { $hide = 'hide';}
		$slider .= '<span class="button mlu_remove_button '. $hide.'" id="reset_'. $id .'_'.$order .'" title="' . $id . '_'.$order .'">Remove</span>';
		$slider .='</div>' . "\n";
		$slider .= '<div class="screenshot">';
		if(!empty($val['url'])){
			
	    	$slider .= '<a class="of-uploaded-image" href="'. $val['url'] . '">';
	    	$slider .= '<img class="of-option-image" id="image_'.$id.'_'.$order .'" src="'.$val['url'].'" alt="" />';
	    	$slider .= '</a>';
			
			}
		$slider .= '</div>';	
		
		
		$slider .= '<label>Video Embed Code <br><small>(if you add video code, Image URL will be ignored)</small></label>';
		$slider .= '<textarea class="slide of-input" name="'. $id .'['.$order.'][video]" id="'. $id .'_'.$order .'_slide_video" cols="8" rows="8">'.stripslashes(@$val['video']).'</textarea>';
		
		$slider .= '<label>Link URL (optional)</label>';
		$slider .= '<input class="slide of-input" name="'. $id .'['.$order.'][link]" id="'. $id .'_'.$order .'_slide_link" value="'. $val['link'] .'" />';
		
		$slider .= '<label>Link Target (optional)</label>';
		$slider .= '<select class="select of-input" name="'. $id .'['.$order.'][target]" style="width:320px" id="'. $id .'_'.$order .'_slide_target">';
		$selo = ''; if(@$val['target']=='_self') {  $selo = 'selected'; }
		$selo1 = ''; if(@$val['target']=='_blank') {  $selo1 = 'selected'; }
		
		$slider .= '<option value="_self" '.$selo.'>_self</option><option value="_blank" '.$selo1.'>_blank</option>';
		$slider .= '</select>';
					
		$slider .= '<label>Caption (optional)</label>';
		$slider .= '<textarea class="slide of-input" name="'. $id .'['.$order.'][description]" id="'. $id .'_'.$order .'_slide_description" cols="8" rows="8">'.stripslashes($val['description']).'</textarea>';
	
		$slider .= '<a class="slide_delete_button" href="#">Delete</a>';
	    $slider .= '<div class="clear"></div>' . "\n";
	
		$slider .= '</div>';
		$slider .= '</li>';
	
		return $slider;
		
	}
	
	
	public static function optionsframework_slider_intro_function($id,$std,$oldorder,$order,$int){
	
	    @$data = get_option(OPTIONS);
		
		$slider = '';
		$slide = array();
	    $slide = @$data[$id];
		
	    if (isset($slide[$oldorder])) { $val = $slide[$oldorder]; } else {$val = $std;}
		
		//initialize all vars
		$slidevars = array('type','video','title','url','link','description','caption');
		
		foreach ($slidevars as $slidevar) {
			if (!isset($val[$slidevar])) {
				$val[$slidevar] = '';
			}
		}
		
		//begin slider interface	
		if (!empty($val['title'])) {
			$slider .= '<li><div class="slide_header"><strong>'.stripslashes($val['title']).'</strong>';
		} else {
			$slider .= '<li><div class="slide_header"><strong>Slide '.$order.'</strong>';
		}
		
		$slider .= '<input type="hidden" class="slide of-input order" name="'. $id .'['.$order.'][order]" id="'. $id.'_'.$order .'_slide_order" value="'.$order.'" />';
	
		$slider .= '<a class="slide_edit_button" href="#">Edit</a></div>';
		
		$slider .= '<div class="slide_body">';
		
		
		$slider .= '<label>Type</label>';
		$slider .= '<select class="slide of-input" name="'. $id .'['.$order.'][type]" id="'. $id .'_'.$order .'_slide_type" style="width:320px">
					<option value="IMAGE" '.selected($val['type'],'IMAGE',false).'>Image</option>
					<option value="VIMEO" '.selected($val['type'],'VIMEO',false).'>Vimeo</option>
					<option value="YOUTUBE" '.selected($val['type'],'YOUTUBE',false).'>Youtube</option>
				</select>';
	
		
		
		$slider .= '<label>Title</label>';
		$slider .= '<input class="slide of-input of-slider-title" name="'. $id .'['.$order.'][title]" id="'. $id .'_'.$order .'_slide_title" value="'. stripslashes($val['title']) .'" />';
		
		$slider .= '<label>Video ID *</label>';
		$slider .= '<input class="slide of-input of-slider-title" name="'. $id .'['.$order.'][video]" id="'. $id .'_'.$order .'_slide_video" value="'. stripslashes($val['video']) .'" />';
		$slider .= '<br class="clear"><small>* If this is a video slide, enter the video ID ; E.g. video URL is : http://vimeo.com/76253725 - Video ID is <strong>76253725</strong> or video URL is http://www.youtube.com/watch?v=KLpkXtM-VI8 - Video ID is <strong>KLpkXtM-VI8</strong></small><br class="clear">';
		
		$slider .= '<label>Image URL / Video ID *</label>';
		$slider .= '<input class="slide of-input" name="'. $id .'['.$order.'][url]" id="'. $id .'_'.$order .'_slide_url" value="'. $val['url'] .'" />';
		
		
		$slider .= '<div class="upload_button_div"><span class="button media_upload_button" id="'.$id.'_'.$order .'" rel="' . $int . '">Upload</span>';
		
		if(!empty($val['url'])) {$hide = '';} else { $hide = 'hide';}
		$slider .= '<span class="button mlu_remove_button '. $hide.'" id="reset_'. $id .'_'.$order .'" title="' . $id . '_'.$order .'">Remove</span>';
		$slider .='</div>' . "\n";
		$slider .= '<div class="screenshot">';
		if(!empty($val['url'])){
			
	    	$slider .= '<a class="of-uploaded-image" href="'. $val['url'] . '">';
	    	$slider .= '<img class="of-option-image" id="image_'.$id.'_'.$order .'" src="'.$val['url'].'" alt="" />';
	    	$slider .= '</a>';
			
			}
		$slider .= '</div>';	
		
		
		$slider .= '<label>Caption (optional)</label>';
		$slider .= '<input class="slide of-input" name="'. $id .'['.$order.'][caption]" id="'. $id .'_'.$order .'_caption" value="'. $val['caption'] .'" />';
		
		$slider .= '<label>Link URL (optional)</label>';
		$slider .= '<input class="slide of-input" name="'. $id .'['.$order.'][link]" id="'. $id .'_'.$order .'_slide_link" value="'. $val['link'] .'" />';
		
		$slider .= '<label>Link Target (optional)</label>';
		$slider .= '<select class="select of-input" name="'. $id .'['.$order.'][target]" style="width:320px" id="'. $id .'_'.$order .'_slide_target">';
		$selo = ''; if(@$val['target']=='_self') {  $selo = 'selected'; }
		$selo1 = ''; if(@$val['target']=='_blank') {  $selo1 = 'selected'; }
		
		$slider .= '<option value="_self" '.$selo.'>_self</option><option value="_blank" '.$selo1.'>_blank</option>';
		$slider .= '</select>';
					
		$slider .= '<a class="slide_delete_button" href="#">Delete</a>';
	    $slider .= '<div class="clear"></div>' . "\n";
	
		$slider .= '</div>';
		$slider .= '</li>';
	
		return $slider;
		
	}
	
	
	
	
	
	/**
	 * Drag and drop slides manager
	 *
	 * @uses get_option()
	 *
	 * @access public
	 * @since 1.0.0
	 *
	 * @return string
	*/
	 
	public static function optionsframework_custompost_ordering_function($id,$std,$oldorder,$order,$int){
	
		global $wpdb;
		
	    @$data = get_option(OPTIONS);
		
		$slider = '';
		
		if(isset($data['md_custom_posts']) && is_array($data['md_custom_posts'])) {
			$getposts = $data['md_custom_posts'];	
		}else{
			$getposts = array('works'=>array('title'=>'works','plural'=>'Works'));	
		}
		
		$i=0;
		foreach($getposts as $foo) {
			
			$slider .= '<h3 class="heading">'.$foo['plural'].'</h3>';
			
			$myrows = $wpdb->get_results( "SELECT ID, post_title, menu_order FROM ".$wpdb->posts." WHERE post_type='".esc_sql($foo['title'])."' AND post_status='publish' order by menu_order asc, post_date desc" );
		
			$slider .= '<div class="slider sliderordering" style="margin-bottom:30px;"><ul id="'.$id.'_'.$i.'" rel="'.$int.'" class="ui-sortable">';
			
			$zi = 0;
			foreach($myrows as $foos) {
				
				$slider .= '<li><div class="slide_header slide_header_org"><strong>'.$foos->post_title.'</strong> <i class="icon-reorder" style="float:right; margin-top:10px;margin-right:-10px;"></i>';
				
				$slider .= '<input type="hidden" class="slide of-input order" name="'. $id .'['.$i.']['.$zi.'][id]" id="'. $id.'_'.$foos->ID .'_post_order" value="'.$foos->ID.'" />';
			
				$slider .= '</div>';
				$slider .= '</li>';
		
			$zi++;
			
			}	
				$slider .= '</ul></div>';
		$i++;
		}
		
		
		return $slider;
		
	}
	
	
	
	
	/**
	 * Drag and drop slides manager
	 *
	 * @uses get_option()
	 *
	 * @access public
	 * @since 1.0.0
	 *
	 * @return string
	*/
	 
	public static function optionsframework_customtaxonomy_ordering_function($id,$std,$oldorder,$order,$int){
	
		global $wpdb;
		
	    @$data = get_option(OPTIONS);
							
		$slider = '';
		
		$data['md_custom_posts']['blog']['plural'] = "Blog";
		
		$i=0;
		foreach($data['md_custom_posts'] as $foo) {
			
			$slider .= '<h3 class="heading">'.$foo['plural'].'</h3>';
			
			
			if($foo['plural']=="Blog") {
				$term = esc_sql("category");
			}else{
				$term = esc_sql($foo['title']."-categories");
			}
			
			$myrows = $wpdb->get_results("SELECT w.term_id, w.name, w.slug FROM ".$wpdb->terms." w, ".$wpdb->term_taxonomy." wp WHERE wp.term_id=w.term_id AND wp.taxonomy='".$term."' AND wp.count > 0 order by w.term_ordering asc, w.name asc");
			
			$slider .= '<div class="slider sliderordering" style="margin-bottom:30px;"><ul id="'.$id.$i.'" rel="'.$int.'">';
				
			foreach($myrows as $foos) {
				
				$slider .= '<li><div class="slide_header slide_header_org"><strong>'.$foos->name.'</strong> <i class="icon-reorder" style="float:right; margin-top:10px;margin-right:-10px;"></i>';
				
				$slider .= '<input type="hidden" class="slide of-input order" name="'. $id .'['.$foos->term_id.'][id]" value="'.$foos->term_id.'" />';
			
				$slider .= '</div>';
				$slider .= '</li>';
			
			}	
			
			$slider .= '</ul></div>';
			
			$i++;
		}
		
		
		return $slider;
		
	}
	
	
	
	
	
	
	/**
	 * Drag and drop slides manager
	 *
	 * @uses get_option()
	 *
	 * @access public
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function optionsframework_custompost_function($id,$std,$oldorder,$order,$int){
	
	    global $custompostvals;
		
	    @$data = get_option(OPTIONS);
		
		$slider = '';
		$slide = array();
	    $slide = @$data[$id];
		
	    if (isset($slide[$oldorder])) { $val = $slide[$oldorder]; } else {$val = $std;}
		
		//initialize all vars
		$slidevars = array('title','singular','plural','slug','categoryname','categorytitle','categorysingletitle','categoryslug','color','withbg','dropdown','dropdowntitle','hideheader','thumbnail','removesidemargin','pagination','showcategory','showdate','projectinfo');
		
		foreach ($slidevars as $slidevar) {
			if (!isset($val[$slidevar])) {
				$val[$slidevar] = '';
			}
		}
		
		if (empty($val['title'])) {
		
			$newval['title'] = $custompostvals['title']; // post name / slug
			$newval['singular'] = $custompostvals['singular']; // single name
			$newval['plural'] = $custompostvals['plural']; // name
			$newval['slug'] = $custompostvals['slug']; // slug
			
			$newval['categoryname'] = $custompostvals['categoryname']; // category name
			$newval['categorytitle'] = $custompostvals['categorytitle']; // 
			$newval['categorysingletitle'] = $custompostvals['categorysingletitle']; // 
			$newval['categoryslug'] = $custompostvals['categoryslug']; // 
			$newval['color'] = $custompostvals['color']; // 	
			$newval['withbg'] = $custompostvals['withbg']; // 	
			$newval['dropdown'] = $custompostvals['dropdown']; // 	
			$newval['dropdowntitle'] = $custompostvals['dropdowntitle'];
			$newval['hideheader'] = $custompostvals['hideheader']; // 
			$newval['thumbnail'] = $custompostvals['thumbnail']; // 		
			$newval['removesidemargin'] = $custompostvals['removesidemargin']; // 
			$newval['pagination'] = $custompostvals['pagination']; // 
			$newval['showcategory'] = $custompostvals['showcategory']; // 
			$newval['showsinglecategory'] = $custompostvals['showsinglecategory']; // 
			$newval['showexcerpt'] = $custompostvals['showexcerpt']; // 
			$newval['showtitle'] = $custompostvals['showtitle']; // 
			$newval['showdate'] = $custompostvals['showdate']; // 
			$newval['projectinfo'] = $custompostvals['projectinfo']; // 
			$newval['orderby'] = $custompostvals['orderby']; //
			$newval['thumbnailpadding'] = $custompostvals['thumbnailpadding']; //
			$newval['fixedthumbs'] = $custompostvals['fixedthumbs']; //
			$newval['thumbnailcaption'] = $custompostvals['thumbnailcaption']; //
			$newval['thumbbgcolor'] = $custompostvals['thumbbgcolor']; //
			$newval['thumbfontcolor'] = $custompostvals['thumbfontcolor']; //
			$newval['thumbbgtransparent'] = $custompostvals['thumbbgtransparent']; //
			
			$newval['navigation_text'] = $custompostvals['navigation_text']; //
			$newval['navigation_hide'] = $custompostvals['navigation_hide']; //
			
			
			$newval['showdate'] = $custompostvals['showdate']; // 
			$newval['showcategorypost'] = $custompostvals['showcategorypost']; // 
			
			$newval['related_switch'] = @$custompostvals['related_switch']; //
			$newval['related_title'] = @$custompostvals['related_title']; //
			$newval['related_postlimit'] = @$custompostvals['related_postlimit']; //
			$newval['related_thumbnail'] = @$custompostvals['related_thumbnail']; //
			$newval['related_category'] = @$custompostvals['related_category']; //
			$newval['related_random'] = @$custompostvals['related_random']; //
			
		}else{
			
			$newval['title'] = $val['title']; // post name / slug
			$newval['singular'] = $val['singular']; // single name
			$newval['plural'] = $val['plural']; // name
			$newval['slug'] = $val['slug']; // slug
			
			$newval['categoryname'] = $val['categoryname']; // category name
			$newval['categorytitle'] = $val['categorytitle']; // 
			$newval['categorysingletitle'] = $val['categorysingletitle']; // 
			$newval['categoryslug'] = $val['categoryslug']; // 
			$newval['color'] = $val['color']; // 	
			$newval['withbg'] = $val['withbg']; // 	
			$newval['dropdown'] = $val['dropdown']; // 	
			$newval['dropdowntitle'] = $val['dropdowntitle']; // 	
			$newval['hideheader'] = $val['hideheader']; // 	
			$newval['thumbnail'] = $val['thumbnail']; // 
			$newval['removesidemargin'] = $val['removesidemargin']; // 
			$newval['pagination'] = $val['pagination']; // 
			$newval['showdate'] = $val['showdate']; // 
			$newval['showsinglecategory'] = @$val['showsinglecategory']; // 
			$newval['showcategory'] = $val['showcategory']; //
			$newval['showexcerpt'] = $val['showexcerpt']; // 
			$newval['showtitle'] = $val['showtitle']; // 
			
			$newval['projectinfo'] = $val['projectinfo']; // 
			$newval['orderby'] = $val['orderby']; //
			$newval['thumbnailpadding'] = $val['thumbnailpadding']; //
			$newval['fixedthumbs'] = $val['fixedthumbs']; //
			$newval['thumbnailcaption'] = $val['thumbnailcaption']; //
			
			$newval['navigation_text'] = $val['navigation_text']; //
			$newval['navigation_hide'] = $val['navigation_hide']; //
			
			
			if(isset($val['showcategorypost'])) { 
				$newval['showcategorypost'] = $val['showcategorypost']; 
			}else{ 
				$newval['showcategorypost'] = $custompostvals['showcategorypost']; 
			}
			
			
			if(isset($val['showcategorypost'])) { 
				$newval['showcategorypost'] = $val['showcategorypost']; 
			}else{ 
				$newval['showcategorypost'] = $custompostvals['showcategorypost']; 
			}
			
			if(isset($val['thumbbgcolor'])) { 
				$newval['thumbbgcolor'] = $val['thumbbgcolor']; 
			}else{ 
				$newval['thumbbgcolor'] = $custompostvals['thumbbgcolor']; 
			}
			
			if(isset($val['thumbfontcolor'])) { 
				$newval['thumbfontcolor'] = $val['thumbfontcolor']; 
			}else{ 
				$newval['thumbfontcolor'] = $custompostvals['thumbfontcolor']; 
			}
			
			if(isset($val['thumbbgtransparent'])) { 
				$newval['thumbbgtransparent'] = $val['thumbbgtransparent']; 
			}else{ 
				$newval['thumbbgtransparent'] = $custompostvals['thumbbgtransparent']; 
			}
			
			
			$newval['related_switch'] = @$val['related_switch']; //
			$newval['related_title'] = @$val['related_title']; //
			$newval['related_postlimit'] = @$val['related_postlimit']; //
			$newval['related_thumbnail'] = @$val['related_thumbnail']; //
			$newval['related_category'] = @$val['related_category']; //
			$newval['related_random'] = @$val['related_random']; //
		
		}
		
		
		
		//begin slider interface	
		if (!empty($newval['title'])) {
			$slider .= '<li style="border-top:none"><div class="slide_header posttype"><strong>Custom Post Type : '.stripslashes($newval['title']).'</strong>';
		} else {
			$slider .= '<li style="border-top:none"><div class="slide_header posttype"><strong>Custom Post Type : '.$order.'</strong>';
		}
		
		
	
		$slider .= '<input type="hidden" class="slide of-input order" name="'. $id .'['.$order.'][order]" id="'. $id.'_'.$order .'_slide_order" value="'.$order.'" />';
	
		$slider .= '<a class="slide_edit_button" href="#">Edit</a></div>';
		
		$slider .= '<div class="slide_body">';
		
		
		$slider .= '<h3 style="float:left">STEP 1 : PREFERENCES</h3>';
		
		if($order > 1) {
			$slider .= '<a class="slide_delete_button" data-w="posttype" href="#" style="float:right;margin-top:20px;">Delete</a>';
		}
		
		$slider .= '<br style="clear:both"><label class="title">Thumbnail Columns</label>';
		
		$slider .= '<select class="slide of-input" name="'. $id .'['.$order.'][thumbnail]" id="'. $id .'_'.$order .'_slide_title" style="width:320px">
						<option value="5" '.selected($newval['thumbnail'],5,false).'>5 Columns</option>
						<option value="4" '.selected($newval['thumbnail'],4,false).'>4 Columns</option>
						<option value="3" '.selected($newval['thumbnail'],3,false).'>3 Columns</option>
						<option value="2" '.selected($newval['thumbnail'],2,false).'>2 Columns</option>
						<option value="1" '.selected($newval['thumbnail'],1,false).'>1 Columns</option>
					</select>';
		
		
		$slider .= '<small>You can change your thumbnail size through this option. According to thumbnail quantity in a row, your thumbnail sizes will be changed automatically.</small>';
		
		$slider .= '<br style="clear:both"><label class="title">Thumbnail Padding</label>';
		
		$slider .= '<select class="slide of-input" name="'. $id .'['.$order.'][thumbnailpadding]" id="'. $id .'_'.$order .'_slide_title" style="width:320px">';
					
		for($i=1;$i < 21; $i++) {			
			$slider .= '<option value="'.$i.'" '.selected($newval['thumbnailpadding'],$i,false).'>'.$i.'</option>';
		}
						
		$slider .= '</select>';
		
		
		$slider .= '<small>Thumbnail padding values represent total space between thumbnails in a row in percentage. This theme is using 6 (percent) by default to calculate total space between thumbnails.</small>';
			
		$slider .= '<label class="title">Fixed Thumbnail Height</label>';
		
		$slider .= '<input type="hidden" class="checkbox aq-input" name="'. $id .'['.$order.'][fixedthumbs]" id="'. $newval['fixedthumbs'] .'" value="0"/>';
		$slider .= '<div class="ibuttonwrap"><input type="checkbox" class="checkbox of-input ibutton" name="'. $id .'['.$order.'][fixedthumbs]" value="1" '. checked($newval['fixedthumbs'], 1, false) .' /></div><br style="clear:both"><br><small>This theme uses masonry (pinterest style) thumbnail placement with variable height by default. However, if you wish to display project thumbnails with fixed height, you may prefer to activate this option. Fixed thumnail sizes are calculated automatically as 4:3 ratio.</small>';
		
		$slider .= '<label class="title">Disable Navigation Arrows on Single Post Page</label>';
		
		$slider .= '<input type="hidden" class="checkbox aq-input" name="'. $id .'['.$order.'][navigation_hide]" id="'. $newval['navigation_hide'] .'" value="0"/>';
		$slider .= '<div class="ibuttonwrap"><input type="checkbox" class="checkbox of-input ibutton" name="'. $id .'['.$order.'][navigation_hide]" value="1" '. checked($newval['navigation_hide'], 1, false) .' /></div><br style="clear:both"><br><small>Allows you to disable navigation arrows</small>';
		
		$slider .= '<label class="title">Hide Navigation Arrow Text</label>';
		
		$slider .= '<input type="hidden" class="checkbox aq-input" name="'. $id .'['.$order.'][navigation_text]" id="'. $newval['navigation_text'] .'" value="0"/>';
		$slider .= '<div class="ibuttonwrap"><input type="checkbox" class="checkbox of-input ibutton" name="'. $id .'['.$order.'][navigation_text]" value="1" '. checked($newval['navigation_text'], 1, false) .' /></div><br style="clear:both"><br><small>Allows you to hide Home, Next, Back text on Full width single post page</small>';
		
		
		$slider .= '<label class="title">Display Categories</label>';
		
		$slider .= '<input type="hidden" class="checkbox aq-input" name="'. $id .'['.$order.'][showcategory]" id="'. $newval['showcategory'] .'" value="0"/>';
		$slider .= '<div class="ibuttonwrap"><input type="checkbox" class="checkbox of-input ibutton" name="'. $id .'['.$order.'][showcategory]" value="1" '. checked($newval['showcategory'], 1, false) .' /></div><br style="clear:both"><br><small>This option allows you to display categories at the top of your projects</small>';
		
		$slider .= '<label class="title">Hide Categories on Single Post Pages</label>';
		
		$slider .= '<input type="hidden" class="checkbox aq-input" name="'. $id .'['.$order.'][showsinglecategory]" id="'. $newval['showsinglecategory'] .'" value="0"/>';
		$slider .= '<div class="ibuttonwrap"><input type="checkbox" class="checkbox of-input ibutton" name="'. $id .'['.$order.'][showsinglecategory]" value="1" '. checked($newval['showsinglecategory'], 1, false) .' /></div><br style="clear:both"><br><small>This option allows you to hide categories on single custom post pages</small>';
		
		
		
		$slider .= '<label class="title">Post Display Limit</label>';
		$slider .= '<input class="slide of-input" name="'. $id .'['.$order.'][pagination]" id="'. $id .'_'.$order .'_slide_title" value="'. stripslashes($newval['pagination']) .'" /><small>Allows you to specify a limit for pagination. By default, it\'s 0 (unlimited)</small>';	
		
		$slider .= '<br style="clear:both"><label class="title">Order By</label>';
		
		$slider .= '<select class="slide of-input" name="'. $id .'['.$order.'][orderby]" id="'. $id .'_'.$order .'_slide_title" style="width:320px">
				<option value="2" '.selected($newval['orderby'],2,false).'>Date (Newer to older)</option>
				<option value="1" '.selected($newval['orderby'],1,false).'>Custom Ordering</option>
			</select>';
			
		$slider .= '<small>Date option is default. Custom Ordering allows you to specify your ordering for posts via "Posts Ordering" section</small>';
		
		
		$slider .= '<br style="clear:both"><label class="title">Thumbnail Caption on Post Type Overview Page</label>';
		
		$slider .= '<input type="hidden" class="checkbox aq-input" name="'. $id .'['.$order.'][showtitle]" id="'. $newval['showtitle'] .'" value="0"/>';
		$slider .= '<div class="ibuttonwrap"><input type="checkbox" class="checkbox of-input ibutton" name="'. $id .'['.$order.'][showtitle]" value="1" '. checked($newval['showtitle'], 1, false) .' /></div><span style="float:left;margin:5px 0 0 5px">Show Title</span><br class="clear:both"><br>';
		
		$slider .= '<input type="hidden" class="checkbox aq-input" name="'. $id .'['.$order.'][showexcerpt]" id="'. $newval['showexcerpt'] .'" value="0"/>';
		$slider .= '<div class="ibuttonwrap"><input type="checkbox" class="checkbox of-input ibutton" name="'. $id .'['.$order.'][showexcerpt]" value="1" '. checked($newval['showexcerpt'], 1, false) .' /></div><span style="float:left;margin:5px 0 0 5px">Show Excerpt</span><br class="clear:both"><br>';
		
		$slider .= '<input type="hidden" class="checkbox aq-input" name="'. $id .'['.$order.'][showcategorypost]" id="'. $newval['showcategorypost'] .'" value="0"/>';
		$slider .= '<div class="ibuttonwrap"><input type="checkbox" class="checkbox of-input ibutton" name="'. $id .'['.$order.'][showcategorypost]" value="1" '. checked($newval['showcategorypost'], 1, false) .' /></div><span style="float:left;margin:5px 0 0 5px">Show Category</span><br class="clear:both"><br>';
		
		$slider .= '<input type="hidden" class="checkbox aq-input" name="'. $id .'['.$order.'][showdate]" id="'. $newval['showdate'] .'" value="0"/>';
		$slider .= '<div class="ibuttonwrap"><input type="checkbox" class="checkbox of-input ibutton" name="'. $id .'['.$order.'][showdate]" value="1" '. checked($newval['showdate'], 1, false) .' /></div><span style="float:left;margin:5px 0 0 5px">Show Date</span>';
		
		
		$slider .= '<br style="clear:both"><br style="clear:both"><label class="title">Thumbnail Caption Placement</label>';
		
		$slider .= '<select class="slide of-input" name="'. $id .'['.$order.'][thumbnailcaption]" id="'. $id .'_'.$order .'_slide_title" style="width:320px">
						<option value="inside" '.selected($newval['thumbnailcaption'],'inside',false).'>Inside</option>
						<option value="below" '.selected($newval['thumbnailcaption'],'below',false).'>Below</option>
						<option value="none" '.selected($newval['thumbnailcaption'],'none',false).'>None</option>
					</select>';
		
		$slider .= '<br style="clear:both"><label class="title">Thumbnail Font & BG Color</label>';
		
		$slider .= '<div class="colorSelector"><div style="background-color: '.$newval['thumbbgcolor'].'"></div></div>';
		$slider .= '<input class="of-color" name="'. $id .'['.$order.'][thumbbgcolor]" type="text" value="'. $newval['thumbbgcolor'] .'" /><small style="margin: 1px 0 0 5px;
display: inline-block;">BG Color</small>';
		
		$slider .= '<br class="clear"><div class="colorSelector"><div style="background-color: '.$newval['thumbfontcolor'].'"></div></div>';
		$slider .= '<input class="of-color" name="'. $id .'['.$order.'][thumbfontcolor]" type="text" value="'. $newval['thumbfontcolor'] .'" /><small style="margin: 1px 0 0 5px;
display: inline-block;">Font Color</small>';

		
		$slider .= '<br class="clear"><br><input type="hidden" class="checkbox aq-input" name="'. $id .'['.$order.'][thumbbgtransparent]" id="'. $newval['thumbbgtransparent'] .'" value="0"/>';
		$slider .= '<div class="ibuttonwrap"><input type="checkbox" class="checkbox of-input ibutton" name="'. $id .'['.$order.'][thumbbgtransparent]" value="1" '. checked($newval['thumbbgtransparent'], 1, false) .' /></div><span style="float:left;margin:5px 0 0 5px">Transparent Thumbnail Overlay</span><br class="clear:both"><br>';
		
		
		$slider .= '<br class="clear"><br><small>BG color will be applied if Thumbnail caption placement set as "Inside". Also, BG color will be ignored if Transparent Thumbnail Overlay option is turned on.</small>';
		
		
		
		$slider .= '<br style="clear:both"><h3 style="border-bottom: 1px solid #ccc;padding-bottom: 20px;">RELATED POSTS SETTINGS</h3>';
		$slider .= '<br style="clear:both"><small>If enabled, activating <strong>Reframe > Main Layout > Disable Single Project Info Floating</strong> option is highly recommended in order to prevent overlapping.</small><br style="clear:both">';
		
		$slider .= '<br><input type="hidden" class="checkbox aq-input" name="'. $id .'['.$order.'][related_switch]" id="'. $newval['related_switch'] .'" value="0"/>';
		$slider .= '<div class="ibuttonwrap"><input type="checkbox" class="checkbox of-input ibutton" name="'. $id .'['.$order.'][related_switch]" value="1" '. checked($newval['related_switch'], 1, false) .' /></div><span style="float:left;margin:5px 0 0 5px">Display Related Posts</span>';
		
		$slider .= '<br style="clear:both"><br><label>Title</label><input class="slide of-input" name="'. $id .'['.$order.'][related_title]" id="'. $id .'_'.$order .'_slide_title" value="'. stripslashes($newval['related_title']) .'" /><small>E.g. RELATED POSTS</small>';	
		
					
		$slider .= '<br style="clear:both"><br style="clear:both"><label>Related Posts Display Limit</label>';
		$slider .= '<input class="slide of-input" name="'. $id .'['.$order.'][related_postlimit]" id="'. $id .'_'.$order .'_slide_title" value="'. stripslashes($newval['related_postlimit']) .'" /><small>Allows you to specify a limit for pagination. By default, it\'s 0 (unlimited)</small>';	
		
		
		$slider .= '<br><input type="hidden" class="checkbox aq-input" name="'. $id .'['.$order.'][related_category]" id="'. $newval['related_category'] .'" value="0"/>';
		$slider .= '<div class="ibuttonwrap"><input type="checkbox" class="checkbox of-input ibutton" name="'. $id .'['.$order.'][related_category]" value="1" '. checked($newval['related_category'], 1, false) .' /></div><span style="float:left;margin:5px 0 0 5px">Show Posts from Same Category</span>';
		
		$slider .= '<br class="clear"><br><small>If this option is switched on, only the posts with the same category will be displayed. Otherwise, all posts will be listed regardless their category</small>';
	
		$slider .= '<input type="hidden" class="checkbox aq-input" name="'. $id .'['.$order.'][related_random]" id="'. $newval['related_random'] .'" value="0"/>';
		$slider .= '<div class="ibuttonwrap"><input type="checkbox" class="checkbox of-input ibutton" name="'. $id .'['.$order.'][related_random]" value="1" '. checked($newval['related_random'], 1, false) .' /></div><span style="float:left;margin:5px 0 0 5px">Random Posts</span>';
		
		$slider .= '<br class="clear"><br><small>Turn on this feature to display random posts</small>';
		
		
		$slider .= '<br><hr><h3>STEP 2 : CUSTOM FIELD VALUES<br><small>* All fields are required</small></h3><label class="title">Post Type Name</label>';
		$slider .= '<input class="slide of-input of-slider-title" name="'. $id .'['.$order.'][title]" id="'. $id .'_'.$order .'_slide_title" value="'. stripslashes($newval['title']) .'" /><small>Post name must contain only letters and/or numbers.<br>E.g. : <strong>portfolio</strong></small>';
		
		$slider .= '<label class="title">Singular Post name</label>';
		$slider .= '<input class="slide of-input" name="'. $id .'['.$order.'][singular]" id="'. $id .'_'.$order .'_slide_title" value="'. stripslashes($newval['singular']) .'" /><small>E.g. : <strong>Project</strong></small>';	
		
		$slider .= '<label class="title">Plural Post name</label>';
		$slider .= '<input class="slide of-input" name="'. $id .'['.$order.'][plural]" id="'. $id .'_'.$order .'_slide_title" value="'. stripslashes($newval['plural']) .'" /><small>This also will be your project overview page title<br>E.g. : <strong>Projects</strong> or <strong>Portfolio</strong></small>';	
		
		$slider .= '<label class="title">Slug</label>';
		$slider .= '<input class="slide of-input" name="'. $id .'['.$order.'][slug]" id="'. $id .'_'.$order .'_slide_title" value="'. stripslashes($newval['slug']) .'" /> <small>Allows you to set your post type URL. By default, it\'s your Post Name. <br>E.g. : <strong>portfolio</strong><br>URLs will be displayed like -> /portfolio/my-project-title</strong></small>';	
		
		$slider .= '<hr><h3>STEP 3 : CATEGORY SETTINGS<br><small>* All fields are required</small></h3><label class="title">Category Name</label>';
		$slider .= '<input class="slide of-input" name="'. $id .'['.$order.'][categoryname]" id="'. $id .'_'.$order .'_slide_title" value="'. stripslashes($newval['categoryname']) .'" /><small>Category name of your post type. <br>E.g. : <strong>Creative Fields</strong></small>';	
		
		$slider .= '<label class="title">New Category Title</label>';
		$slider .= '<input class="slide of-input" name="'. $id .'['.$order.'][categorytitle]" id="'. $id .'_'.$order .'_slide_title" value="'. stripslashes($newval['categorytitle']) .'" /><small>E.g. : <strong>Add New Field</strong></small>';	
			
		$slider .= '<label class="title">Single Category Name</label>';
		$slider .= '<input class="slide of-input" name="'. $id .'['.$order.'][categorysingletitle]" id="'. $id .'_'.$order .'_slide_title" value="'. stripslashes($newval['categorysingletitle']) .'" /><small>E.g. : <strong>Field</strong></small>';
		
		$slider .= '<label class="title">Category Slug</label>';
		$slider .= '<input class="slide of-input" name="'. $id .'['.$order.'][categoryslug]" id="'. $id .'_'.$order .'_slide_title" value="'. stripslashes($newval['categoryslug']) .'" /><small>Allows you to set your category URL. <br>E.g. : <strong>field</strong><br>URLs will be displayed like -> /field/videos</strong></small>';	
		
		if($order > 1) {
			$slider .= '<a class="slide_delete_button" data-w="posttype" href="#">Delete</a>';
		}
	    $slider .= '<div class="clear"></div>' . "\n";
	
		$slider .= '</div>';
		$slider .= '</li>';
	
		return $slider;
		
	}
	
	
	
	
	
}//end Options Machine class

?>