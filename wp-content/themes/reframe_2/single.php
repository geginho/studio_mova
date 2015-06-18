<?php
global $wp_query;
$post_obj = $wp_query->get_queried_object();
?>
<?php get_header(); ?>
	
<div id="loadintothis">
	<?php 
		if($post_obj->post_type=='post') {
			get_template_part( 'single', 'blog-content' );	
		}elseif($post_obj->post_type=='attachment') {
			get_template_part( 'single', 'image-content' );	
		}else{
			get_template_part( 'single', 'works-content' );	
		}
		
	?>
</div>    

<?php get_footer(); ?>
