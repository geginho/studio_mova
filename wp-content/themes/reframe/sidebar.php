   <div class="widget_wrapper blogsidebar border-color">
		<?php if ( is_active_sidebar( 'page-right' ) ) { ?>
            <?php dynamic_sidebar( 'page-right' ); ?>
        <?php }else{ ?>
            <div><h4><strong>Page Sidebar</strong></h4>
           <p><?php printf ( __( 'This is the "Page Sidebar" widget area. You can add widgets through Appearance > Widgets at the WP dashboard.<br><br>If you don\'t want to use a sidebar, edit this page through Pages section and select "Full Width" template from Page Attributes', 'northeme' ) ); ?></p>
           </div>
        <?php } ?>
   </div>