<?php 

/// GET OPTIONS
$md_works_full =  of_get_option('md_works_full');
$md_home_full =  of_get_option('md_home_full');
$md_showbw =  of_get_option('md_custompost_showbw');


global $post;
$showtextpos = get_post_meta( $post->ID, 'page-custom-type-text', true );
$getmaincontent = do_shortcode(apply_filters('the_content', $post->post_content));


	global $page_type;
	if(!isset($page_type)) {
		$page_type = getCustomPage();
	}
	
	global $customtypes;
	if(!isset($customtypes)) {
		$customtypes = of_get_option('md_custom_posts');
	}
	
	if(!$page_type) {
		$page_type = 1;
	}
	
	$vartype = $customtypes[$page_type];
	
	$postname = $vartype['title'];
	$md_thumbcount = $vartype['thumbnail'];
	$workstitle = $vartype['plural'];
	$categoriestitle = $vartype['categoryname'];
	$categoryname = $vartype['title'].'-categories';
	$portfoliolink = @$vartype['home_url'];
	$works_pagination = ($vartype['pagination']);
	$md_fixed_thumbs = ($vartype['fixedthumbs']);
	$md_thumbnail_type = ucfirst($vartype['thumbnailcaption']);
	$showcategory = ($vartype['showcategory']);
	$showtitle = ($vartype['showtitle']);
	$showcategorypost = '';
	if(isset($vartype['showcategorypost'])) {
		$showcategorypost = ($vartype['showcategorypost']);
	}
	$vartype['showcategorypost'];
	
	$showdate = '';
	if(isset($vartype['showdate'])) {
		$showdate = ($vartype['showdate']);
	}
	
	$showexcerpt = ($vartype['showexcerpt']);
	$orderby = ($vartype['orderby']);


	if(isset($relatedworks)) {
		//$md_thumbcount = $related_thumbnail;
		$works_pagination = $related_limit;
		$md_fixed_thumbs=1;
	}
	
	if($works_pagination == 0) {
		$works_pagination = -1;
	}
	
	$pageid = $post->ID;

	$paged = md_get_page_number();


	// GET PORTFOLIO POSTS
	$args = array(
		'post_type' => $postname,
		'posts_per_page' => $works_pagination,
		'post_status' => array('publish')
	);
	
	
	/// CHECK CATEGORY
	if(isset($term)) { 
	
		$args = array_merge($args,
			array(
				 $categoryname=>$term,
				'paged' => $paged
			)
		);
		
		$paginated = 1;
	}else{
		$args = array_merge($args,
			array(
				'paged' => $paged
			)
		);
		
		/// RELATED WORKS
		if(isset($relatedworks) && isset($related_samecat) && $related_samecat==1) { 
			 $args = array_merge($args,
				array(
					 $categoryname=>$related_category
				)
			);	
		}
		
		$paginated = 1;
	}
	
	
	
	   if(isset($relatedworks) && isset($related_random) && $related_random==1){
				$args = array_merge($args,
                        array(
                        'orderby' => 'rand'
					)
				);
		
		}else{
		
				if($orderby==1) {
					$args = array_merge($args,
							array(
							'orderby' => 'menu_order',
							'order'=>'asc'
							)
						);
				}else{
					$args = array_merge($args,
							array(
							'orderby' => 'post_date',
							'order'=>'desc'
							)
						);
				}
				
		}
	
		if(isset($relatedworks)) {
			
			$args = array_merge($args,
				array(
				'post__not_in' => array($post->ID)
				)
			);
			
		}
	
	
	//query_posts($args);
	$wp_query = new WP_Query( $args );
	
	if($md_home_full==1) { 
		$divclass = 'sixteen'; 
	}else{ 
		$divclass = 'thirteen-sp'; 
	}
	if(isset($relatedworks) && $md_works_full==1) { 
		$divclass = 'sixteen'; 
	}
?>       

<div id="singlecontent" class="works-single hidden"></div>

    <?php 
		if ( post_password_required() ) {
							
			echo '<div class="'.$divclass.' columns passprotectpage">';
			$excerpt = get_the_password_form();
			echo $excerpt;
			echo '</div>';
			
		}else{				
	?> 
    
   
      
<?php if(!isset($relatedworks) && $showcategory==1) { ?> 
<div class="columns <?php echo $divclass?> forintroslider <?php if($md_fixed_thumbs==1) { echo 'fixed'; } ?>">

      <span class="btopcategories border-color">
		<?php 
		  // GET CATEGORIES
			$tp = $categoryname;
		   //$cats = get_terms( $tp );

			$cats = $wpdb->get_results("SELECT w.term_id, wp.term_taxonomy_id, w.name, w.slug FROM ".$wpdb->terms." w, ".$wpdb->term_taxonomy." wp 
			WHERE wp.term_id=w.term_id AND wp.taxonomy='".esc_sql($categoryname)."' AND wp.count > 0 order by w.term_ordering asc, w.name asc", OBJECT);
			
							
			$count_cats = count( $cats ); 
			
			if ( $count_cats > 0 ) {
			   ?>
               
				<a href="<?php if($portfoliolink) { echo get_permalink($portfoliolink); }else{ echo '#'; } ?>" <?php if(is_tax()) { ?>data-tax="1"<?php } ?> data-filter="*" class="activemenu-bg <?php if(!isset($term)) { echo 'selected'; } ?>"><?php _e('SHOW ALL','northeme') ?></a>
                
               <?php
			   foreach ($cats as $catd) { 
			   ?>
				<a href="<?php echo esc_attr(get_term_link( $catd->slug, $tp )); ?>" <?php if(is_tax()) { ?>data-tax="1"<?php } ?> data-filter=".nor-<?php echo $catd->slug?>" class="activemenu-bg <?php if(isset($term) && $catd->slug==$term) { echo 'selected'; } ?>" title="<?php echo $catd->name; ?>"><?php if(function_exists('mb_strtoupper')) { echo mb_strtoupper($catd->name); }else{ echo strtoupper($catd->name); } ?></a>
			  <?php 
		  		} 
			}
		  ?>
	  </span>
</div>
<?php } ?> 
  
  
<div id="post-list" class="columns fitvids  posttype-<?php echo $postname?> <?php echo $divclass?> forintroslider <?php if(isset($relatedworks)) echo 'alpha omega';?>" <?php if(isset($relatedworks)) { ?>style="min-height:0;"<?php } ?>>


    <?php if ($showtextpos=='top') {  ?>
    	<div class="">
           <?php echo $getmaincontent ?>
       </div>     
    <?php } ?>
     
     
		<div class="projectimages <?php if($md_fixed_thumbs==1) { echo 'fixed'; } ?>" style=" <?php if(!isset($relatedworks)) { ?>min-height: 500px;<?php } ?> position:relative;">
                
				<?php  
					/// LOOP COUNTER
					$loopcnt = 1; 
					$realcnt = 1; 
					$loopcntpagination = $works_pagination*$paged;
					
					if(isset($works_pagination) && ($works_pagination < $wp_query->found_posts)) {
						$endlimit = $works_pagination;
					}else{
						$endlimit = $wp_query->found_posts;
					}
					
				while( $wp_query->have_posts()) { 
				
					$wp_query->the_post();
				?>	
				
				<?php  
                
                // THUMBNAIL & CSS CLASS
                $res_img = 'large';
				
				if($md_thumbcount == 2) {
					$tmb = 'large';
				}elseif($md_thumbcount > 2 && $md_thumbcount < 5) {
					$tmb = 'medium';
				}elseif($md_thumbcount > 4){
					$tmb = 'small';
				}else{
					$tmb = 'full';
				}
				
				if($md_fixed_thumbs) {
					if($md_thumbcount > 1) {
						$tmb = 'fixed';
					}
					$res_img = 'fixed';
				}
				
				
				// Check featured video
				$featuredvideo = get_post_meta( $post->ID , 'work-featured-video', true );
               
			  	$cthumbnail = getThumb($tmb);
				preg_match( '@src="([^"]+)"@' , $cthumbnail[0] , $cthumbnail_org );  
				
				//forresponsive
                $getfull = getThumb($res_img); 
				preg_match( '@src="([^"]+)"@' , $getfull[0] , $cthumbnail_large );  
				
                // CREATE ARRAYS
                $draught_links = array();
                $draught_links_q = array();
                
                // AJAX TOKEN
                $token = wp_create_nonce("wp_token");
    
                // POST CATEGORIES
                $categories = "";
                $categories_q = "";
                
                $terms = get_the_terms( $post->ID , $categoryname, 'string' ); 
                
                    if ( $terms && ! is_wp_error( $terms ) ) {
                        $draught_links = array();
                        $draught_links_q = array();
                        foreach ( $terms as $termz ) {
                            $draught_links[] = $termz->name;
                            $draught_links_q[] = 'nor-'.$termz->slug;
                        }
                        $categories = join( ", ", $draught_links );
                        $categories_q = join( " ", $draught_links_q );
                    }		
                
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
                
				
					/// GET DIRECT LINK OR DEFAULT
				$work_direct_link_active = get_post_meta( $post->ID , 'work-direct-link-activate', true );
				
				if($work_direct_link_active==1) {
					$work_direct_link = get_post_meta( $post->ID , 'work-direct-link', true );
					$target = get_post_meta( $post->ID , 'work-direct-link-target', true );
					$work_direct_target = '_blank';
					$work_direct_class = 'golink';
					
					$work_direct_target = $target;	
					
				}else{
					$work_direct_link = get_permalink();
					$work_direct_target = '_self';
					$work_direct_class = 'getworks';
				}
				
				
			  
				 if($loopcnt==1 && $md_fixed_thumbs) { 
				 	//echo '<div class="row">';
				 }
                ?>
                <div class="box <?php if($md_fixed_thumbs!=1) { echo 'initialize'; } ?> <?php if(($loopcnt==$md_thumbcount)) { echo 'odd'; $loopcnt=0;} ?> <?php echo $categories_q?>">
                	<?php if($md_thumbnail_type=='Below') { 
					if($featuredvideo!='') { 
							echo stripslashes(html_entity_decode($featuredvideo));
						}else{
					?>
                     <a href="<?php echo $work_direct_link ?>" <?php if($work_direct_link=='#') { echo 'onclick="return false"'; } ?> target="<?php echo $work_direct_target?>" class="<?php echo $work_direct_class?> <?php if($md_showbw==1) { echo 'bwWrapper'; } ?> img headertag" data-type="<?php echo $postname?>" data-home="<?php echo get_permalink( $pageid );?>" data-id="<?php echo $post->ID?>" data-token="<?php echo $token?>">							
                     <?php 
						if($cthumbnail[0])  {
							echo str_replace(
								'<img ',
								'<img data-small="'.$cthumbnail_org[1].'" data-large="'.$cthumbnail_large[1].'"',
								$cthumbnail[0]
								);
						}
					 ?>
                     </a> 
                  <?php } ?>         
                     <div class="info <?php if($md_fixed_thumbs) { echo 'boxfixedheight'; } ?>">
                        <a href="<?php echo $work_direct_link ?>" <?php if($work_direct_link=='#') { echo 'onclick="return false"'; } ?> target="<?php echo $work_direct_target?>" class="<?php echo $work_direct_class?> <?php if($md_showbw==1) { echo 'bwWrapper'; } ?> img headertag" data-type="<?php echo $postname?>" data-home="<?php echo get_permalink( $pageid );?>" data-id="<?php echo $post->ID?>" data-token="<?php echo $token?>"><?php if($showtitle) echo get_the_title()?></a>
					  <?php if($showcategorypost) echo $categories;?>
                      <?php 
                        if($showdate) { 
                            if($showcategorypost) echo ' • '; 
                            echo the_time( get_option('date_format') );
                        } 
                        
                        if($showdate || $showcategorypost) { echo '<br />'; }
                       ?>   
                        <?php if($showexcerpt) the_excerpt(); ?>
                     </div>
                    <?php }elseif($md_thumbnail_type=='Inside') { ?>
                     <a href="<?php echo $work_direct_link ?>" <?php if($work_direct_link=='#') { echo 'onclick="return false"'; } ?> target="<?php echo $work_direct_target?>" class="<?php echo $work_direct_class?> <?php if($md_showbw==1) { echo 'bwWrapper'; } ?> img" data-type="<?php echo $postname?>" data-home="<?php echo get_permalink( $pageid );?>" data-id="<?php echo $post->ID?>" data-token="<?php echo $token?>">
                            <strong class="info">
							<?php if($showtitle) echo get_the_title()?>
                            
                            <?php if($showcategorypost) echo '<br />'.$categories;?>
						  <?php 
                            if($showdate) { 
                                if($showcategorypost) { echo ' • '; }else{ echo '<br />'; }
                                echo the_time( get_option('date_format') );
                            } 
							
							if($showcategorypost || $showdate) { echo '<br />'; }
                           ?>    
                             <?php if($showexcerpt) the_excerpt(); ?>
                             </strong>
                            <span class="info">&nbsp;</span>
                            <?php 
								if($featuredvideo!='') { 
									echo stripslashes(html_entity_decode($featuredvideo));
								}else{
									
								if($cthumbnail[0])  {
									echo str_replace(
										'<img ',
										'<img data-small="'.$cthumbnail_org[1].'" data-large="'.$cthumbnail_large[1].'"',
										$cthumbnail[0]
										);
								}
								}
							?>
                     </a>
                    <?php }else{ ?>
                    <?php 
						if($featuredvideo!='') { 
							echo stripslashes(html_entity_decode($featuredvideo));
						}else{
					  ?>
                     <a href="<?php echo $work_direct_link ?>" <?php if($work_direct_link=='#') { echo 'onclick="return false"'; } ?> target="<?php echo $work_direct_target?>" class="<?php echo $work_direct_class?> <?php if($md_showbw==1) { echo 'bwWrapper'; } ?> img headertag" data-type="<?php echo $postname?>" data-home="<?php echo get_permalink( $pageid );?>" data-id="<?php echo $post->ID?>" data-token="<?php echo $token?>">
                             <?php 
								if($cthumbnail[0])  {
									echo str_replace(
										'<img ',
										'<img data-small="'.$cthumbnail_org[1].'" data-large="'.$cthumbnail_large[1].'"',
										$cthumbnail[0]
										);
								}
							?>
                     </a>
                    <?php } ?> 
                    <?php } ?> 
                </div>
                <?php 
					 if(($loopcnt==0 && $md_fixed_thumbs) || ($endlimit==$realcnt && $md_fixed_thumbs)) { 
						//echo '</div>';
					 }
					 
					 $loopcnt++;
					 $realcnt++;
				} 
				?>
                
 		</div>  
        
            <?php
			 $chk = get_paginate_page_links();
             if($chk && !isset($relatedworks)) { ?>
                <nav id="page_nav" style="margin-top:20px;">
                    <?php echo $chk;?>
                </nav>
            <?php } ?>
         
		<?php if ($showtextpos=='bottom') {  ?>
        		<br class="clear">
             <?php echo $getmaincontent ?>
        <?php } ?>
        
 	 </div>  
    
     <?php wp_reset_query();?>
   	 <?php } ?>
    
    