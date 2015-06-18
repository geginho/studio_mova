<?php
get_header(); 

$md_home_full =  of_get_option('md_home_full');
$md_info_align =  of_get_option('md_blog_info_align');
$md_blog_hide_sidebar =  of_get_option('md_blog_hide_sidebar');
 
 
if(!of_get_option('md_theblog_limit')) {
	$bloglimit = 10;
}else{
	$bloglimit = of_get_option('md_theblog_limit');
}

if($bloglimit == 0) {
	$bloglimit = -1;
}



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



if ( have_posts() ) : the_post();
	

?>

	<div class="columns fitvids bloglistcontainer <?php echo $divclass ?>">
    
            
            <table class="author-info">
              <tbody>
            	<tr>
                	<?php
					 $getavatar = get_avatar(get_the_author_meta( 'ID' ),250);
					 if($getavatar) { ?>
                	<td class="img"><?php echo $getavatar; ?></td>
                    <?php } ?>
                    <td class="info">
                    	<h2>
							<?php the_author_meta('display_name'); ?>
                        </h2>
                        <p>
							<?php 
                                the_author_meta('description');
                            ?>
                        </p>
                    </td>
                </tr>
              </tbody>
            </table>
            
                 <h2 class="archivetitle">
					<?php _e( 'Author Archives', 'northeme' ); ?>
                </h2>  
                     
                <?php 
					$page = md_get_page_number();
	
					$args = array(
							'more'=>1,
							'paged'=>$page,
							'posts_per_page' => $bloglimit
					);
					query_posts( $args );
					
                    include(locate_template('loop-item.php'));	
                ?>
              
                
                <?php
				 $chk = get_next_posts_link(__( 'LOAD MORE', 'northeme' ));
				 if($chk) { ?>
                    <nav id="page_nav">
                        <?php echo $chk;?>
                    </nav>
				<?php } ?>
    </div>
		
<?php endif; ?>
    
        
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

