<?php
	
	/// CHECK IF FULL SIZE
	$md_works_full =  of_get_option('md_works_full');
	$md_home_full =  of_get_option('md_home_full');
	$md_works_single_top =  of_get_option('md_works_single_top');
	$md_social_post_disable_top =  of_get_option('md_social_post_disable_top');
	$md_social_post_disable_bottom =  of_get_option('md_social_post_disable_cptbottom');
	
	$md_home_full = 0;
	
	if(have_posts()) { 
		the_post(); 
	}elseif(wp_verify_nonce( $_REQUEST['token'], "wp_token" )) { 
		$post = get_post( $_REQUEST['id'] );
		setup_postdata($post);
	}	
	
	
	$customtypes = of_get_option('md_custom_posts');

	
	foreach($customtypes as $k => $v) {
		if($v['title']==$post->post_type) { 
			$page_type = $k;
			break;
		}
	}
	
	$vartype = $customtypes[$page_type];
	
	
	$postname = $vartype['title'];
	$md_thumbcount = $vartype['thumbnail'];
	$workstitle = $vartype['plural'];
	$categoriestitle = $vartype['categoryname'];
	$categoryname = $vartype['title'].'-categories';
	$portfoliolink = @$vartype['home_url'];
	$categoryshow = @$vartype['showsinglecategory'];
	$works_pagination = ($vartype['pagination']);
	$md_fixed_thumbs = ($vartype['fixedthumbs']);
	$md_thumbnail_type = ($vartype['thumbnailcaption']);
	$showtitle = intval($vartype['showtitle']);
	$showexcerpt = intval($vartype['showexcerpt']);
	$orderby = ($vartype['orderby']);
	
	
	// Related Posts
	$related_switch = intval($vartype['related_switch']);
	$related_title = ($vartype['related_title']);
	$related_limit = ($vartype['related_postlimit']);
	$related_samecat = ($vartype['related_category']);
	$related_random = (@$vartype['related_random']);
	$related_thumbnail = (@$vartype['related_thumbnail']);

	// CUSTOM FIELDS
	$work_custom_name = unserialize(get_post_meta( $post->ID, 'work-customs-name', true ));
	$work_custom_values = unserialize(get_post_meta( $post->ID, 'work-customs-val', true ));
	
	// AJAX TOKEN
	$token = wp_create_nonce("wp_token");
	$permalink = get_permalink( $post->ID );
	
	$postcontent = get_the_content();
	$postcontent = apply_filters('the_content', $postcontent);
	$postcontent = str_replace(']]>', ']]&gt;', $postcontent);
	
	// CATEGORIES
	$terms = get_the_terms( $post->ID , $categoryname, 'string' );
	$descpos = get_post_meta( $post->ID , 'work-desc-position', true );
	  
	// IF DESCRIPTION POSITIONING WASN'T SET 
	if(!$descpos) { 
		$descpos = 'bottom';
	}
	
	$categories = '';
	$fordefault = '';
		
	if ( $terms && ! is_wp_error( $terms ) ) {
		
		$draught_links = array();
		
		foreach ( $terms as $termz1 ) {
			$related_category = $termz1->slug;
			$draught_links[] = '<a href="'.esc_attr(get_term_link( $termz1, $categoryname )).'">#'.$termz1->name.'</a>';
		}
		
		$categories = join( " ", $draught_links );
	
	}
	
	if ( $categoryshow ) {
		$categories = '';
	}
	
	
	/////////
	$infoline = '';
	$infoline_right = '';
	$totalvals = count($work_custom_values);
	$s=0;

	if(is_array($work_custom_values)) {
		
		foreach($work_custom_values as $foo) {
			
			if($foo!='') {
				if($s==0 && $categories=='') {
					/// don't add slash
				}else{
				$infoline .= ' / ';
				}
			}
			if($work_custom_name[$s]) { 
				$infoline .= '<strong>'.stripslashes($work_custom_name[$s]).'</strong> '; 
				$infoline_right .= '<strong>'.stripslashes($work_custom_name[$s]).'</strong> '; 
			}
			
			$infoline .= html_entity_decode(northeme_make_clickable(stripslashes($foo)));
			$infoline_right .= html_entity_decode(northeme_make_clickable(stripslashes($foo)));
			
			$s++;
			if(($s < $totalvals) && $foo!="") {
					$infoline_right .= '<br>';
			}
		}
	}
	/////////
	
	    
                          
	/// NAVIGATION 
	global $post;
	$prev_post = getNextBack('prev',$postname,$post->menu_order,$post->post_date,$orderby);
	$next_post = getNextBack('next',$postname,$post->menu_order,$post->post_date,$orderby);

	
	if($portfoliolink) {
		$hmurl = get_permalink($portfoliolink);	
	}else{
		$hmurl = '/';
	}
	/// ALL LINK
	$navlinkshome = '<a href="'.$hmurl.'" data-title="All" title="'. __("All Projects","northeme").'" data-type="'.$postname.'" data-token="'.$token.'" class="fback gohome"><i class="icon-double-angle-left"></i> <span>'.__('HOME','northeme').'</span></a>';
	
	$navlinks = '';
	
	/// BACK LINK
	if(!empty( $prev_post['ID'] )) {
	
	$navlinks .= '<a href="'.get_permalink($prev_post['ID']).'" data-type="'.$postname.'" data-token="'.$token.'" data-id="'. $prev_post['ID'].'" title="'. htmlspecialchars($prev_post['post_title']).'" class="getworks-nextback"><i class="icon-angle-left"></i> <span>'. __('BACK','northeme').'</span></a>';
	
	}
	
	/// NEXT LINK		
	if(!empty( $next_post['ID'] )) {
	
	$navlinks .= '<a href="'.get_permalink($next_post['ID']).'" data-type="'.$postname.'" data-token="'. $token .'" data-id="'. $next_post['ID'].'" title="'. htmlspecialchars($next_post['post_title']).'" class="getworks-nextback"><span>'. __('NEXT','northeme').'</span> <i class="icon-angle-right"></i></a>';
	
	}
	
	if($md_works_full==1 || $md_home_full==1) {
		$fordefault = '';
		$showinfull = 1;
	}elseif($md_works_single_top){
		$fordefault = 'default';
	}

	$ptitle = get_the_title();
	$pimg = getThumb('large');
	preg_match( '@src="([^"]+)"@' , $pimg[0] , $pimg ); 
	if(isset($pimg[1])) {
		$pimg = $pimg[1];								
	}else{
		$pimg = '';	
	}
	
	/// Sharing buttons
	$sharingbuttons = showshareingpost($permalink,$pimg, $ptitle,false); 
		
            		 
	$descpos = get_post_meta( $post->ID , 'work-desc-position', true );
	
	if(isset($showinfull)) { 
		$divclass = 'sixteen'; 
	}else{ 
		$divclass = 'thirteen-sp'; 
	}
?>
   
<div class="columns fitvids workspost <?php echo $divclass?> singlepostpage-<?php echo $postname?>">
    
    <?php
	
		if ( post_password_required() ) {
							
			echo '<div class="'.$divclass.' columns passprotectpage">';
			$excerpt = get_the_password_form();
			echo $excerpt;
			echo '</div>';
			
		}else{	
        
        
         
		//// IF DON'T...
		if($md_works_single_top=='top') {
			$fordefault = '';
			$showinfull = 1;
		}
		
		/// TOP NAVIGATION
		$navigation = '
		<div class="projectheader '.$fordefault.'">
		   <div class="left">
				  <span class="title">'.get_the_title().'</span>';
		
		$negativemargin = '';
		
		if((isset($categories) && $categories!='') || (isset($infoline) && $infoline!='') || (isset($sharingbuttons) && $sharingbuttons!='')) {
			$navigation .= '<div class="info">
								'.@$categories . $infoline;
			
			if(isset($sharingbuttons) && $sharingbuttons && !$md_social_post_disable_top) {					
				$navigation .= '<div class="topsharing">'.$sharingbuttons.'</div>';
			}
			
			$navigation .= '</div>';
			
		}else{
			/// ADD NEGATIVE MARGIN IF CATEGORIES AND ADDITIONAL INFO WILL NOT BE DISPLAYED
			$negativemargin = ' style="margin-top:-18px;"';	
		}
		
		$navigation .= '</div>
		   <div class="right navigation" '.$negativemargin.'>
				'.$navlinkshome.$navlinks.'
		   </div>';
		   
		   if($descpos=='right') {
				$navigation .=  '<div class="thecontent">'.$postcontent.'</div>';
		   }
		   
		$navigation .= '</div>';
						


	?>          
             <div class="<?php if(isset($showinfull)) echo 'full'; ?> showajaxcontent">
             
               	  <?php 
					 echo $navigation;
				  ?>
                    
                 <div class="projectassets fitvids">
                 	
						<?php 
					  		/// PRINT THE CONTENT IF IT'S SET AS TOP
							if($descpos=='top') {
								echo '<div class="contentimages">';
								echo $postcontent;
								echo '</div>';
							}
							
                            $s1=0;
                            $s2=0;
                            $s3=0;
							$portrt = 1;
							$mediatext = @unserialize(get_post_meta( $post->ID, 'work-media-text', true ));
							$work_media = @unserialize(get_post_meta( $post->ID, 'work-media', true ));
                            $mediacaption = @unserialize(get_post_meta( $post->ID, 'work-media-caption', true ));
                            $mediavideo = @unserialize(get_post_meta( $post->ID, 'work-media-video', true ));
                            $mediaalign = @unserialize(get_post_meta( $post->ID, 'work-media-photoalignment', true ));
							$medialink = unserialize(get_post_meta( $post->ID, 'work-media-link', true ));
							$mediatarget = unserialize(get_post_meta( $post->ID, 'work-media-link-target', true ));
							$medialinkfancy = unserialize(get_post_meta( $post->ID, 'work-media-fancy', true ));
							
							$wgallery = get_post_meta( $post->ID , 'work-comp-type', true );
                           
						    if(is_array($work_media)) {
								
									
							if($wgallery==2) { 
							
								$mediagallerybg = (get_post_meta( $post->ID, 'work-gallery-bg', true ));
								$mediagallerybgtransparent = (get_post_meta( $post->ID, 'work-gallery-canvas-transparent', true ));
								$mediagallerytr = (get_post_meta( $post->ID, 'work-gallery-transition', true ));
								$mediagallerytrsp = (get_post_meta( $post->ID, 'work-gallery-transition-speed', true ));
								
								if($mediagallerybg=='') {
									$mediagallerybg = '#000';
								}
								if($mediagallerytr=='') {
									$mediagallerytr = 'fade';
								}
								
								echo '<div class="contentimages forgallerydiv"><a href="#" class="gallery_fullscreen">&nbsp;</a><div class="galleria">';
								foreach($work_media as $v) {
								   
								   if($v!='textarea') {
									   
									   if($v=='videoembed') {
										   
										  $imlink = get_template_directory_uri().'/images/playbutton.jpg';
										  $imlink1 = do_shortcode(stripslashes($mediavideo[$s1]));
										  $imdesc = '';
										  $s1++; 
										  
									   }else{
										   
										  $imlink = stripslashes($v);
										  $imlink1 = stripslashes($v);
										  $imdesc = @$mediacaption[$s2];
										  $s2++;
									   }
										   
										   echo '<a href="'.$imlink1.'"><img src="'.$imlink.'" data-big="'.$imlink.'" data-description="'.stripslashes($imdesc).'"></a>';
										  
								   }
								
								}
								echo '</div></div><br class="clear">';
							?>	
								<style type="text/css">.galleria-container { 
								<?php if($mediagallerybgtransparent==1) { ?>
									background:none;
								<?php }else{ ?>
									background-color:<?php echo $mediagallerybg?>;
								<?php } ?>
								}</style>
							<?php
							
							}else{
						
						
									foreach($work_media as $v) {
										if($v=='textarea') {
											echo '<div class="contenttext">'.do_shortcode(stripslashes($mediatext[$s3])).'</div>';
											$s3++;
										}elseif($v=='videoembed') {
											echo '<div class="contentvideos">'.do_shortcode(stripslashes($mediavideo[$s1])).'</div>';
											$s1++;
										}else{
											
										if(isset($mediaalign[$s2]) && $mediaalign[$s2] == 'portrait') {
											
											
											if($portrt==2) { $addit = 'odd'; }else{ $addit = ''; }
											echo '<div class="contentimages portrait '.$addit.'">';
											$portrt++;
											if($portrt==3) $portrt = 1;
										}else{ 
											
											echo '<div class="contentimages landscape">';
										}
										
										if($medialink[$s2]!="" || $medialinkfancy[$s2]==1) {
											$rel = '';
											$ltarget = 'target="'.$mediatarget[$s2].'"';
											if($medialinkfancy[$s2]==1) {
												
												$rel = 'data-light="swipebox"';	
												
												if($mediacaption[$s2]!="") {
													$rel .= ' title="'.esc_attr($mediacaption[$s2]).'"';
												}
												$ltarget = '';
											}
											
											$linka = $medialink[$s2];
											if($linka=='' && $medialinkfancy[$s2]==1) {
												$linka = $v;	
											}
											
											echo '<a href="'.$linka.'" '.$ltarget.' '.$rel.'>';
										}
											
											$imgalt = esc_attr(get_the_title());
											
											if($mediacaption[$s2]!="") {
												$imgalt = $mediacaption[$s2];
											}
											echo '<img src="'.stripslashes($v).'" alt="'.str_replace('"', '',strip_tags(stripslashes($imgalt))).'" />';
												
										if($medialink[$s2]!="" || $medialinkfancy[$s2]==1) {
											echo '</a>';
										}
				
										if($mediacaption[$s2]!="") {
											echo '<div class="caption">'.stripslashes(nl2br($mediacaption[$s2])).'</div>';
										}
										
										echo '</div>';
										$s2++;	
										}
									}
								}
							
							}
                        ?>
                        <br class="clear" />
                        <div class="bottominfo border-color">
                        <?php 
					  		/// PRINT THE CONTENT IF IT'S SET AS BOTTOM
							if($postcontent!='' && $descpos=='bottom') { 
						 ?>
                          <div class="info">	
							<?php 
								if($descpos=='bottom') {
										echo $postcontent;
								}
                            ?>
                            &nbsp;
                          </div> 
                    	<?php } ?>
                        
                        <br class="clear" />
                        <div class="navigation">
                         
                          <?php if(isset($showinfull) && !$md_social_post_disable_bottom) { ?>
                          <div class="sharingbottom">
                                <?php 
									echo $sharingbuttons; 
                            	?>
                          </div>
                          <?php } ?>
                          
                            <div class="pull-right smalldevicedontshow">
                            <?php 
                            if(!empty( $next_post['ID'] )) {
									$thumbn = getThumb('mini',$next_post['ID']);
									?>
                                 <a href="<?php echo get_permalink($next_post['ID']) ?>" data-type="<?php echo $postname?>" data-token="<?php echo $token ?>" 
                                 data-id="<?php echo $next_post['ID'] ?>" title="<?php echo htmlspecialchars($next_post['post_title']) ?>" class="getworks-nextback nxt">
                                          <i class="icon-angle-right"></i>
                                          <?php echo $thumbn[0];?>
									 </a>
                            <?php } ?>
                        
							<?php echo $navlinkshome?>
                        	</div>
                        </div>
                            
                        <br class="clear" />
                        <?php 
						  if(comments_open()) {
								  comments_template(); 
						  }
						?>
                        
                      </div>
                </div>     
                
                <?php if(!isset($showinfull)) { ?>
                 <div class="projectinfo right">
                 	<div class="wrapmsg">
                    	<span class="navigation">
                        	<?php echo $navlinks?>
                        </span>
                        <h5><a href="<?php the_permalink() ?>"><?php the_title()?></a></h5>
                        <span class="extra">
							<?php echo @$categories?>
                        </span>
                        <div class="content">
                        	<?php 
								if($descpos=='right') {
										echo $postcontent.'<br class="clear">';
								}
                            ?>
                            <?php echo $infoline_right ?>
                            <br />
                            <?php 
								if(!$md_social_post_disable_top) {
									echo $sharingbuttons;
								}
							?>
                        </div>    
                    </div>
                </div>
                <?php } ?>
          
            </div>
            
          <?php } ?>  
          
          
			<?php 
                if($related_switch==1 && !post_password_required()) { 
            ?>
                    <div class="<?php echo $divclass?> columns border-color relatedworks alpha omega">
                        <h4><?php echo $related_title?></h4>
                    </div>        
            <?php
                    $relatedworks = 1;
                    include(locate_template('template-works-content.php'));	
                }
            ?>  
            
 	</div>      
    