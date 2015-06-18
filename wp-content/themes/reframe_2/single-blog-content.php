<?php

$md_home_full =  of_get_option('md_home_full');
$md_info_align =  of_get_option('md_blog_info_align_single');
$md_blog_hide_sidebar =  of_get_option('md_blog_hide_sidebar');
$md_social_post_disable_bottom =  of_get_option('md_social_post_disable_bottom');
$hidenav =  of_get_option('md_blog_hide_postnavigation');
$blogtitlealignment =  of_get_option('md_blog_titlealignment');


if(have_posts()) the_post(); 
	
	$prev_post = getNextBack('prev','post',$post->menu_order,$post->post_date,0);
	$next_post = getNextBack('next','post',$post->menu_order,$post->post_date,0);
	

if($md_home_full==1) { 
	if(!$md_blog_hide_sidebar && $md_info_align=='Bottom') {
		$divclass = 'twelve'; 
	}else{
		$divclass = 'sixteen';
	}
}else{ 
	if(!$md_blog_hide_sidebar && $md_info_align=='Bottom') {
		$divclass = 'nine'; 
	}else{ 
		$divclass = 'thirteen-sp'; 
	} 
}	

$navlinks = '';
	
	/// BACK LINK
	if(!empty( $prev_post['ID'] )) {
	
	$navlinks .= '<a href="'.get_permalink($prev_post['ID']).'" title="'. htmlspecialchars($prev_post['post_title']).'"><i class="icon-angle-left"></i> <span>'. __('BACK','northeme').'</span></a>';
	
	}
	
	/// NEXT LINK		
	if(!empty( $next_post['ID'] )) {
	
	$navlinks .= '<a href="'.get_permalink($next_post['ID']).'" title="'. htmlspecialchars($next_post['post_title']).'"><span>'. __('NEXT','northeme').'</span> <i class="icon-angle-right"></i></a>';
	
	}
	
	
?>
   
<div class="columns fitvids <?php echo $divclass ?>">
               
				<?php  
                
				if ( post_password_required() ) {
							
					echo '<div class="'.$divclass.' columns passprotectpage">';
					$excerpt = get_the_password_form();
					echo $excerpt;
					echo '</div>';
					
				}else{	
				
		
                // THUMBNAIL & CSS CLASS
				if($md_info_align=='Bottom') { 
					$tmb = 'full';
				}else{
					$tmb = 'blog';
				}
				// GET APPROPIATE IMAGE
                $cthumbnail = getThumb($tmb); 
				
				// GET POST FORMAT
                $format = get_post_format(); 
                
                // AJAX TOKEN
                $token = wp_create_nonce("wp_token");
    
				$getdate = get_the_time( get_option('date_format') );
				  
				 
				 $thetitlecontent = '';
				 
				 if($hidenav!=1) {
                 	$thetitlecontent .= '<span class="navigation">'.$navlinks.'</span>';
                 } 
                 
				 if($format!='quote' && $format!='link') {
                    $thetitlecontent .= '<h5><a href="'. get_permalink() .'">'. get_the_title().'</a></h5>';
                 }
                        
                 $thetitlecontent .= '<span class="extra">';
				 
					if(of_get_option('md_post_show_category')) { 
						$sep=1;
						$pcategories = get_the_category();
						$separator = ', ';
						$output = '';
						if($pcategories){
							foreach($pcategories as $category) {
								$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
							}
						$thetitlecontent .= trim($output, $separator);
						}
 
					 } 
                     
					
					if(of_get_option('md_post_show_comments')) { 
						if(isset($sep)) $thetitlecontent .= ' / ';
						$sep=1;
						$commentcount = get_comments_number($post->ID);
						
						if($commentcount > 0) {
							$commentcount_text = __('<strong>('.$commentcount.')</strong> Comment', 'northeme');
						}else{
							$commentcount_text = __('No Comments', 'northeme');
						}
						$thetitlecontent .= '<a href="'. get_comments_link() .'">'. $commentcount_text .'</a>';
					
					 } 
					 
					if(of_get_option('md_post_show_author')) { 
						if(isset($sep)) $thetitlecontent .= ' / ';
						$sep=1;
						$thetitlecontent .=  __('by '.get_the_author_link(), 'northeme'); 
					}
					
					
						if(of_get_option('md_post_show_date')) {
						if(isset($sep)) $thetitlecontent .= ' / ';
						$sep=1; 
				
				 
						if(str_replace(' ','',get_option('date_format'))=='d/m/Y') {
							$thetitlecontent .= get_the_date();
						}else{
							$thetitlecontent .= get_the_time( get_option('date_format') );
						}
						
					}
					
					$thetitlecontent .= '</span>';
                                       
                ?>
               
               	<div class="blogbox <?php if($md_info_align=='Bottom') echo 'full';?>">
                	
                    <?php if($md_info_align=='Bottom' && $blogtitlealignment=='Top'){ ?>
                    <div class="infoside <?php if(!$format && $md_info_align!='Bottom') { echo 'forstandard1';}?> singlepage">
                    <?php echo $thetitlecontent; ?>
                    </div>
                    <?php } ?>
                    
                    <?php if(($format) || $md_info_align=='Right') { ?>
                	<div class="imgside">
                         <?php 
						 if($format=='image') {
						 ?>
                            <a href="<?php the_permalink() ?>" class="imgpost">
                                <?php echo $cthumbnail[0];?>
                            </a>    
                         <?php 
						 }elseif($format=='video') { 
						    
							echo htmlspecialchars_decode(get_post_meta( $post->ID, 'work-video', true ));
						 
						  }elseif($format=='quote') { 
						    echo '<h4 class="quotes border-color">';
							echo get_post_meta( $post->ID, 'work-quote', true );
							echo '<br /><a href="'.get_permalink().'" class="links">'.get_the_title().'</a>';
						 	echo '</h4>';
						 }elseif($format=='link') { 
						    
							$tlink = get_post_meta( $post->ID, 'work-link', true );
							$tlinktarget = get_post_meta( $post->ID, 'work-link-target', true );
						    echo '<h4 class="quotes border-color"><a href="'.$tlink.'">';
							
							echo get_the_title();
							
							if($tlinktarget) {
								$r_tlinktarget = $tlinktarget;
							}else{
								$r_tlinktarget = '_blank';
							}
							
							echo '</a><br /><a href="'.$tlink.'" target="'.$r_tlinktarget.'" class="links">'.$tlink.'</a>';
						 	echo '</h4>';
						  
						 }elseif($format=='gallery'){ 
						 	$slider_blog_content = unserialize(get_post_meta( $post->ID, 'work-media', true ));
                            $mediavideo = unserialize(get_post_meta( $post->ID, 'work-media-video', true ));
							$medialink = unserialize(get_post_meta( $post->ID, 'work-media-link', true ));
							$mediatarget = unserialize(get_post_meta( $post->ID, 'work-media-link-target', true ));
							$mediacaption = unserialize(get_post_meta( $post->ID, 'work-media-caption', true ));
							
							
							$wgallery = get_post_meta( $post->ID , 'work-comp-type', true );
							
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
								
								$s1=0;
								$s2=0;
								$s3=0;
								
								echo '<div class="contentimages forgallerydiv"><a href="#" class="gallery_fullscreen">&nbsp;</a><div class="galleria">';
								
								foreach($slider_blog_content as $v) {
								   
								   if($v!='textarea') {
									   
									   if($v=='videoembed') {
										   
										  $imlink = get_template_directory_uri().'/images/playbutton.jpg';
										  $imlink1 = stripslashes($mediavideo[$s1]);
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
                             ?>
                            <div class="flexslider">
                              <ul class="slides">
                                <?php 
									$s=0;
                                    foreach($slider_blog_content as $foo) {
                                ?>
                                    <li>
                                         <?php if($foo=='videoembed') {?>
                                            <?php echo stripslashes($mediavideo[$s]); ?>
                                        <?php }else{ 
												if(isset($medialink[$s]) && $medialink[$s]!="") {
													echo '<a href="'.$medialink[$s].'" target="'.$mediatarget[$s].'">';
												}
											?>
											   <img src="<?php echo $foo ?>" alt="" />
											<?php
												if(isset($medialink[$s]) && $medialink[$s]!="") {
													echo '</a>';
												}
											?>
											
											<?php if(isset($mediacaption[$s]) && $mediacaption[$s]!='') {?>
												<p class="flex-caption"><?php echo $mediacaption[$s]; ?></p>
											<?php } ?>
                                            
                                        <?php }?>
                                    </li>
								   <?php 
                                      $s++;
                                    } 
                                   ?>
                              </ul>
                            </div>
                          
                         <?php 
							   }
							   
						 	}else{
							
								if($md_info_align=='Right') { 
                       				the_content();
								}
								
							}
						 ?>
                        <br class="clear" />
						<?php if(comments_open() && $md_info_align=='Right') { comments_template(); } ?>
                    </div>
                    
                    <?php } ?>
                    
                    <div class="infoside <?php if(!$format && $md_info_align!='Bottom') { echo 'forstandard1';}?> singlepage">
                    	
                        <?php if($md_info_align=='Bottom' && $blogtitlealignment!='Top'){ echo $thetitlecontent; }elseif($md_info_align!='Bottom') { echo $thetitlecontent; }  ?>
                        
						<?php if($format) { the_content(); }elseif($md_info_align=='Bottom'){ the_content(); } ?>
                
                      <div class="bottom singlepage">
                            <div class="sharingbottom"> 
								<?php
                                    $pimg = getThumb('large');
										preg_match( '@src="([^"]+)"@' , $pimg[0] , $pimg ); 
                                    $ptitle = get_the_title();
                                    $permalink = get_permalink();
                                    $sharingbutton = showshareingpost($permalink,$pimg[1], $ptitle,false); 
                                
									if($sharingbutton!='' && !$md_social_post_disable_bottom) { 
								?>
                                <div class="resdontshow shr"><strong><?php _e('SHARE : ','northeme');?></strong></div>
                                <?php
									echo $sharingbutton;
								 	} 
								?>
                                
                            </div>
                            
                            <span class="loop-tags" <?php if($md_info_align=='Bottom'){ echo 'style="margin-top:0;"'; }?>>
                            <?php 
                                $posttags = get_the_tags();
                                    if ($posttags) {
									   $t=1;
									   $tottag = count($posttags);
                                      foreach($posttags as $tag) {
                                        echo '<a href="'.get_tag_link($tag->term_id).'" class="tags">#'.$tag->name . '</a>';
										$t++;
                                      }
                                    }
                            ?>
                            </span>
                            
                            
                        <br class="clear" />
                            
                        <?php if(comments_open() && ($md_info_align=='Bottom')) { comments_template(); } ?>
                        
                       </div>
            
                        <br class="clear" />
                        
                  
                  </div>
              </div>
              
			  <?php } ?>
              
          </div>      
          
          
		  <?php if(!$md_blog_hide_sidebar && $md_info_align=='Bottom') { ?>
          <div class="four columns">
             <div class="widget_wrapper blogsidebar border-color">
				<?php if ( is_active_sidebar( 'blog-right' ) ) : ?>
                    <?php dynamic_sidebar( 'blog-right' ); ?>
                <?php endif; ?>
               </div>
          </div> 
          <?php } ?>