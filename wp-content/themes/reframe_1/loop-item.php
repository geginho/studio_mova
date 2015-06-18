
 <div class="addblogposts">
       
        <?php 
		global $md_info_align;
		while( $wp_query->have_posts()) { 
		
		$wp_query->the_post();
        
        // THUMBNAIL & CSS CLASS
        if($md_info_align=='Bottom') { 
            $tmb = 'full';
        }else{
            $tmb = 'blog';
        }
        $cthumbnail = getThumb($tmb); 
        
        // CREATE ARRAYS
        $draught_links = array();
        $draught_links_q = array();
        
        // AJAX TOKEN
        $token = wp_create_nonce("wp_token");


        /// DECIDE WHICH CATEGORY TO SHOW	
        $paste = '';
        if(isset($checkcat)) { 
                if(!in_array($checkcat,$draught_links_q)) { 
                    $paste= 'style="display:none"'; 
                }
        }
        
        // RESET TO ARRAYS
        $draught_links = array();
        $draught_links_q = array();
        
        $getdate = get_the_time( get_option('date_format') ); 
        
        $format = get_post_format();      
        ?>
       
        <div class="blogbox <?php if($md_info_align=='Bottom') echo 'full';?>">
            
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
                    echo '<br /><a href="'.get_permalink().'" class="links">'.get_the_title().'</a> ';
                    echo '<a href="'.get_permalink().'" class="links" title="'.__('Permalink to '.esc_attr(get_the_title()),'northeme').'">'. __('#','northeme') .'</a>';
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
							
							
                    echo '</a><br /><a href="'.$tlink.'" target="'.$r_tlinktarget.'" class="links">'.$tlink.'</a> 
                    <a href="'.get_permalink().'" class="links" title="'.__('Permalink to '.esc_attr(get_the_title()),'northeme').'">'. __('#','northeme') .'</a>';
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
							if(is_array($slider_blog_content)) {
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
						}
						?>
                      </ul>
                    </div>
                    
                 <?php
                      }
                 }else{
					 
                        if($md_info_align=='Right') { 
                            the_content("<i class='icon-caret-right'></i> ". __('View','northeme'));
							$dontshowview=1;
                        }
                        
                 }
                 ?>
                
            </div>
            <?php if($format!='quote' && $format!='link') { ?>
            <div class="infoside <?php if(!$format && $md_info_align!='Bottom') { echo 'forstandard1';}?> <?php if(of_get_option('md_blog_info_align_content')=='Left') { echo'infosideleft'; } ?>">
                <h5><a href="<?php the_permalink() ?>"><?php the_title()?></a></h5>
                <span class="extra">
                <?php 
                if(of_get_option('md_post_show_category')) { 
                 $sep=1;
               ?>
                <?php the_category(', '); ?> 
                <?php } ?>
                <?php 
                if(of_get_option('md_post_show_comments')) { 
                    if(isset($sep)) echo ' / ';
                    $sep=1;
                ?>
     <a href="<?php comments_link(); ?>"><?php comments_number(__('No Comments', 'northeme'), __('<strong>(1)</strong> Comment', 'northeme'), __('<strong>(%)</strong> Comments', 'northeme')); ?></a>
                <?php } ?> 
                <?php 
                    if(of_get_option('md_post_show_author')) { 
                        if(isset($sep)) echo ' / ';
                        $sep=1;
                        echo  _e('by ', 'northeme'); the_author_posts_link(); 
                    }
                ?>
                <?php 
                    if(of_get_option('md_post_show_date')) {
                    if(isset($sep)) echo ' / ';
                    $sep=1; 
                ?>
                    <?php echo the_time( get_option('date_format') ); ?> 
                <?php } ?>
                </span>
                
                <?php if($format) { the_excerpt(); }elseif($md_info_align=='Bottom'){ the_content("<i class='icon-caret-right'></i> ". __('View','northeme')); $dontshowview=1; } ?>
                
                <?php if (isset($dontshowview) && strpos($post->post_content, '<!--more-->')) { }else{ ?>
                <a href="<?php the_permalink() ?>" class="readmore"><i class="icon-caret-right"></i> <?php _e('View','northeme') ?></a>
                <?php } ?>
            </div>
            <?php } ?>
        </div>
        
        <?php } ?>
            
                
   </div>