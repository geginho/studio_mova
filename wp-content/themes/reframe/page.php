<?php get_header(); ?>
<?php 
	$md_home_full =  of_get_option('md_home_full');

	if($md_home_full==1) { 
		$divclass = 'twelve'; 
	}else{ 
		$divclass = 'nine';  
	}

?>    
	<div class="defaultpage">
  
  

    <?php 
		if ( post_password_required() ) {
							
			echo '<div class="'.$divclass.' columns passprotectpage">';
			$excerpt = get_the_password_form();
			echo $excerpt;
			echo '</div>';
			
		}else{				
	?>
        
		<?php if ( have_posts() ) { the_post(); ?>
            <div class="columns fitvids <?php echo $divclass ?>">
                <?php the_content(); ?>
            </div>
        <?php } ?>
    
	<?php } ?>
    
        <div class="four columns">
             <?php get_template_part( 'sidebar', 'page' ); ?>
        </div>
	</div>	
<?php get_footer(); ?>
	