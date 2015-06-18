<?php
get_header(); 

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

?>

	<div class="columns fitvids bloglistcontainer <?php echo $divclass ?>">
    
<?php if ( have_posts() ) : ?>
                <h2 class="archivetitle">
                    <?php _e( 'Search Results for', 'northeme' ); ?> : <?php echo '<strong>'.get_search_query().'</strong>';?>
                </h2>
                
				 <?php 
					query_posts( 'posts_per_page=-1&s='.$_REQUEST['s']);
					
                    include(locate_template('loop-search.php'));	
                ?>
        
        
<?php else : ?>
            <h2 class="archivetitle">
				<?php _e( 'No results for', 'northeme' ); ?> <?php echo get_search_query(); ?>
            </h2>
            <div class="noresults">
            	<p><?php _e( 'Sorry, but nothing matched your search criteria. <br>Please try again with different keywords.', 'northeme' ); ?></p>
                <br />
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
