<?php
/*
Template Name: Full Width
*/
?>
<?php get_header(); ?>
<?php 
	$md_home_full =  of_get_option('md_home_full');

	if($md_home_full==1) { 
		$divclass = 'sixteen'; 
	}else{ 
		$divclass = 'thirteen-sp';  
	}

?> 
	 
	<?php 
        if ( post_password_required() ) {
                            
            echo '<div class="'.$divclass.' columns passprotectpage">';
            $excerpt = get_the_password_form();
            echo $excerpt;
            echo '</div>';
            
        }else{				
    ?>
            
      <div class="columns fitvids defaultpage <?php echo $divclass ?>">
                
            <?php if ( have_posts() ) { the_post(); ?>
            
                    <?php the_content(); ?>
                    
            <?php } ?>
            
        
      </div>	
  
  <?php } ?>
    
    
<?php get_footer(); ?>
	