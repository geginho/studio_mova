<?php
global $md_info_align;
global $md_blog_hide_sidebar;

$md_home_full =  of_get_option('md_home_full');
$md_info_align =  of_get_option('md_blog_info_align');
$md_blog_hide_sidebar =  of_get_option('md_blog_hide_sidebar');


global $post;
$showtextpos = get_post_meta( $post->ID, 'page-custom-type-text', true );
$getmaincontent = do_shortcode(apply_filters('the_content', $post->post_content));


if(!of_get_option('md_theblog_limit')) {
	$bloglimit = 10;
}else{
	$bloglimit = of_get_option('md_theblog_limit');
}

if($bloglimit == 0) {
	$bloglimit = -1;
}

// SHOW SIDEBAR WHETHER OR NOT
$dontshow_sidebar = of_get_option('md_posts_sidebar');

// GET POSTS

	global $more; $more = 0; 
	
	$page = md_get_page_number();
	
	// GET POSTS
	// Check the query variable is available
	if(!$wp_query) global $wp_query; // If not, global it so it can be read from
	// Your custom args
	$args = array( 'posts_per_page' => $bloglimit,'paged'=>$page);
	// Merge the custom args with any for the query already
	$args = array_merge( $args , $wp_query->query );
	// Now do the query
	if(is_page()) {
		$args = array(
		'more'=>1,
		'post_type' => 'post',
		'orderby' => 'post_date',
		'order'=>'desc',
		'posts_per_page' => $bloglimit,
		'paged'=>$page,
		'cat'=>$cat,
		'post_status' => array('publish')
		);	
	}
	
	$wp_query = new WP_Query( $args );




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

?>
    

<div class="columns fitvids bloglistcontainer <?php echo $divclass ?>">

	<?php if(of_get_option('md_blog_display_categories')==1) { ?>
      <span class="btopcategories border-color">
		<?php 
			// GET CATEGORIES
			$cats = $wpdb->get_results("SELECT w.term_id, wp.term_taxonomy_id, w.name, w.slug FROM ".$wpdb->terms." w, ".$wpdb->term_taxonomy." wp 
			WHERE wp.term_id=w.term_id AND wp.taxonomy='category' AND wp.count > 0 order by w.term_ordering asc, w.name asc", OBJECT);
			
			$count_cats = count( $cats ); 
			if ( $count_cats > 0 ) {
			   foreach ($cats as $catd) { 
			?>
				<a href="<?php echo get_category_link( $catd->term_id ); ?>" class="activemenu-bg <?php if($catd->term_id==$cat) { echo 'selected'; } ?>" data-rel="<?php echo $catd->slug; ?>" title="<?php echo $catd->name; ?>"><?php if(function_exists('mb_strtoupper')) { echo mb_strtoupper($catd->name); }else{ echo strtoupper($catd->name); } ?></a>
			<?php } ?>
		<?php } ?>
	  </span>
     <?php } ?> 


	<?php if ($showtextpos=='top') {  ?>
	   <div>
		   <?php echo $getmaincontent ?>
       </div>
    <?php } ?>
    
                <?php if(is_archive() || is_category()) { ?>
                <h2 class="archivetitle">
				<?php 
				 if(is_author()) {
                    _e(  '<small>Author Archives :</small><br><span>'.get_the_author().'</span>', 'northeme' );
                 }elseif(is_archive()) { 
                    
                 if ( is_day() ) : ?>
                                <?php printf( __( '<small>Daily Archives :</small> <span>%s</span>', 'northeme' ), get_the_date() ); ?>
                <?php elseif ( is_month() ) : ?>
                                <?php printf( __( '<small>Monthly Archives :</small> <span>%s</span>', 'northeme' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'dronetv' ) ) ); 			?>
                <?php elseif ( is_year() ) : ?>
                                <?php printf( __( '<small>Yearly Archives :</small> <span>%s</span>', 'northeme' ), get_the_date( _x( 'Y', 'yearly archives date format', 'dronetv' ) ) ); ?>       
                <?php endif; ?>
                <?php }	 ?>
                </h2>
                <?php } ?>
                
                 
                <?php 
                    include(locate_template('loop-item.php'));	
                ?>
                
                
                <?php
				 $chk = get_paginate_page_links();
				 if($chk) { ?>
                    <nav id="page_nav">
                        <?php echo $chk;?>
                    </nav>
				<?php } ?>
       
       <?php if ($showtextpos=='bottom') {  ?>
           <div style="margin-top:50px;">
		   	<?php echo $getmaincontent ?>
           </div>
       <?php } ?>
        
       </div>     
          
		  <?php if(!$md_blog_hide_sidebar && $md_info_align=='Bottom') { ?>
          <div class="four columns">
             <div class="widget_wrapper blogsidebar border-color">
				<?php if ( is_active_sidebar( 'blog-right' ) ) { ?>
                    <?php dynamic_sidebar( 'blog-right' ); ?>
				<?php }else{ ?>
                    <div><h4><strong>Blog Sidebar</strong></h4>
                   <p><?php printf ( __( 'This is the "Blog Sidebar" widget area. You can add widgets through Appearance > Widgets at the WP dashboard.<br><br>If you don\'t want to use a sidebar, navigate Reframe > Blog Settings and switch "Hide Blog Sidebar" on', 'northeme' ) ); ?></p>
                   </div>
                <?php } ?>
               </div>
          </div> 
          <?php } ?>
              