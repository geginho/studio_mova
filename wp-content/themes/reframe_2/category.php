<?php
global $wp_query;
$post_obj = $wp_query->get_queried_object();
?>
<?php get_header(); ?>

	<?php 
        if(isset($post_obj->taxonomy) && strpos($post_obj->taxonomy,"-categories")!==false) {
			get_template_part( 'template', 'works' );
		}else{
			get_template_part( 'template', 'blog' ); 
		}
	?>

<?php get_footer(); ?>
