<?php
get_header(); 
global $md_info_align;
$md_home_full =  of_get_option('md_home_full');
$md_info_align =  of_get_option('md_blog_info_align');
$md_blog_hide_sidebar =  of_get_option('md_blog_hide_sidebar');

if($md_home_full==1) { 
	if(!$md_blog_hide_sidebar) {
		$divclass = 'twelve'; 
	}else{
		$divclass = 'sixteen';
	}
}else{ 
	
	if(!$md_blog_hide_sidebar) { 
		$divclass = 'nine'; 
	}else{ 
		$divclass = 'thirteen-sp'; 
	} 
	
}


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
	
	
	$page = md_get_page_number();
	
	// GET POSTS
	// Check the query variable is available
	if(!$wp_query) global $wp_query; // If not, global it so it can be read from
	// Your custom args
	$args = array( 'posts_per_page' => $bloglimit,'paged'=>$page);
	// Merge the custom args with any for the query already
	$args = array_merge( $args , $wp_query->query );
	// Now do the query
	//query_posts($args);
	$wp_query = new WP_Query( $args );

?>

	<div class="columns fitvids bloglistcontainer <?php echo $divclass ?>">
    
<?php if ( have_posts() ) : ?>
                <h2 class="archivetitle">
               		<?php printf( __( 'Tag : %s', 'northeme' ), '<span>' . single_tag_title( '', false ) . '</span>' ); ?>
                </h2>
				<?php 
                // GET ITEMS
                    get_template_part( 'loop', 'item' ); 
                
                ?>
                <?php
				 $chk = get_next_posts_link(__( 'NEXT <span class="meta-nav">&rarr;</span>', 'northeme' ));
				 if($chk) { ?>
                <nav id="page_nav">
                	<?php echo $chk;?>
                </nav>
				<?php } ?>
        
        
<?php else : ?>
            <h2 class="archivetitle">
				<?php _e( 'No results for', 'northeme' ); ?> <?php echo get_search_query(); ?>
            </h2>
            <div class="noresults">
            	<p><?php _e( 'Sorry, but nothing matched with this tag. <br>Please try to use search form : ', 'northeme' ); ?></p>
                <?php get_search_form(); ?>
            </div>
            
            
<?php endif; ?>

		</div>
		
       
		  <?php if(!$md_blog_hide_sidebar) { ?>
          <div class="four columns">
             <div class="widget_wrapper blogsidebar border-color">
				<?php if ( is_active_sidebar( 'blog-right' ) ) : ?>
                    <?php dynamic_sidebar( 'blog-right' ); ?>
                <?php endif; ?>
               </div>
          </div> 
          <?php } ?>
          
<?php get_footer(); ?>
