<?php

$md_home_full =  of_get_option('md_home_full');
$md_info_align =  of_get_option('md_blog_info_align_single');
$md_blog_hide_sidebar =  of_get_option('md_blog_hide_sidebar');


if(have_posts()) the_post(); 
	
if($md_home_full==1) { 
	$divclass = 'sixteen';
}else{ 
	$divclass = 'thirteen-sp'; 
}	

?>
   
<div class="columns fitvids <?php echo $divclass ?>">
		<?php  
        $tmb = 'full';
        // GET APPROPIATE IMAGE
        $cthumbnail = getThumb($tmb); 
        ?>
        <div class="blogbox full">
            
            <div class="infoside forstandard singlepage">
                
                <h4><a href="<?php the_permalink() ?>"><?php the_title()?></a></h4>
                        
                   <?php echo $cthumbnail[0];?>
          
          </div>
      </div>
</div>      