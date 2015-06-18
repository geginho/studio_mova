<div class="widget_wrapper blogsidebar border-color">
    <?php if ( is_active_sidebar( 'blog-right' ) ) { ?>
        <?php dynamic_sidebar( 'blog-right' ); ?>
        <?php }else{ ?>
            <div><h4><strong>Blog Sidebar</strong></h4>
           <p><?php printf ( __( 'This is the "Blog Sidebar" widget area. You can add widgets through Appearance > Widgets at the WP dashboard. <br><br>If you don\'t want to use a sidebar, navigate Reframe > Blog Settings and switch "Hide Blog Sidebar" on', 'northeme' ) ); ?></p>
           </div>
        <?php } ?>
</div>
            