<?php get_header(); ?>
<?php 
	$md_home_full =  of_get_option('md_home_full');
?>
<div class="columns <?php if($md_home_full==1) { echo 'sixteen'; }else{ echo 'thirteen-sp'; }?>">

        <div class="noresults p404">
        
            <h1><?php _e( 'OOPS...', 'northeme' ); ?></h1>
        
                <p><?php _e( 'Sorry... but the page you requested could not be found. <br />Perhaps searching will help.', 'northeme' ); ?></p>
                
                <div id="not-found-form">
                    <?php get_search_form(); ?>
                </div>
        </div>
     
     <br class="clear" />
     
                <div class="row searchpage p404" style="display:none"> 
                		<h1 class="border-color">
							<?php _e( 'Recent blog posts', 'northeme' ); ?>
                        </h1>
                          
					<?php  	
                         
                    $args = array(
                        'post_type' => 'post',
                        'cat'=>$cat,
                        'post_status' => array('publish',
                        'posts_per_page'=>1
                        )
                    );
						query_posts( $args );
						
						// GET ITEMS
						get_template_part( 'loop', 'item' ); 
                   ?>
               </div>
               
</div>

<?php get_footer(); ?>