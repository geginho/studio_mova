<?php 
		
		$md_home_full =  of_get_option('md_home_full');
		
		if($md_home_full) {
			$fclass = 'sixteen';
		}else{
			$fclass = 'thirteen-sp';
		}
		
		
		$footer_widgets_disabled = of_get_option( 'md_footer_widgets_disabled');
		$footer_widgets_columns = of_get_option( 'md_footer_widgets_columns');
		
		if($footer_widgets_columns==4) { 
			$columnclass = "widget4";
		}elseif($footer_widgets_columns==3) {
			$columnclass = "widget3";
		}elseif($footer_widgets_columns==2) {
			$columnclass = "widget2";
		}elseif($footer_widgets_columns==1) {
			$columnclass = "widget1";
		}
	?>
        <br class="clear" />
        <footer class="forintroslider">	
            <?php if(!$md_home_full) { ?>
             <div class="three-sp columns">
              	&nbsp;
                <?php 
				$footerlogo = of_get_option('md_footer_logo');;
				
				if($footerlogo) { 
				?>
                <span class="footerlogo smalldontshow">
                	<img src="<?php echo $footerlogo?>" alt="<?php echo get_bloginfo('name')?>" />
                </span>
                <?php } ?>
             </div>
             <?php } ?>
             
        	 <div class="<?php echo $fclass?> columns">	
                <div class="<?php echo $fclass?>  alpha columns">
                   <div class="widgetwrapper">
                    <?php 
						if($footer_widgets_disabled!=1) {	
					?>
                    	<?php 
                        	for($i=1;$i <= $footer_widgets_columns; $i++) {
                        ?>
                            <div class="widgetclass <?php echo $columnclass; if($i==$footer_widgets_columns) echo ' odd'; ?>">
								<?php 
									if(is_active_sidebar( 'bottom-' . $i)) { 
									$footerok = 1;
								?>
                                    <?php dynamic_sidebar( 'bottom-'.$i ); ?>
                                <?php } ?>
                                    
                            </div>
                    	<?php } ?>
                        
                            <?php if(!isset($footerok)) { ?>
                                        <div><h4><strong>Footer Widgets</strong></h4>
                                       <p><?php printf ( __( 'Footer widgets (<strong>Bottom 1, Bottom 2, Bottom 3, Bottom 4</strong>) can be managed through <strong>Apppearance > Widgets</strong> section.<br>In order to disable footer widgets or change column type, navigate <strong>Reframe > Footer Settings</strong>', 'northeme' ) ); ?></p>
                                       </div>
                            <?php } ?>
                    
                        
					<?php } ?>
                  </div>
               </div>
                    
                    
                <div class="<?php echo $fclass?>  alpha columns border-color footertext">
                    <div class="copyright seven columns alpha">
                    	<?php if(of_get_option('md_footer_text')) { echo of_get_option('md_footer_text').'<br />'; } ?>
                        
					<?php _e('<div class="credits"> © 2015 | Studio MOVA </div>','northeme')?>
                    </div>
                        
                    <div class="sharing socialicons five columns omega">
						  <?php if(!of_get_option('md_social_footer_hide')) { showSharing(); }?>
                    </div>
                </div>
         	
            </div>
            
        </footer>
        
        
            </div>
        </div>       
    </div>

</div>


        <div id="mainframe-left" class="mainframeclass"></div>
        <div id="mainframe-right" class="mainframeclass"></div>
        <div id="mainframe-top" class="mainframeclass"></div>
        <div id="mainframe-bottom" class="mainframeclass"></div>
    
    <?php if(!of_get_option('md_backtotop_disable')) { ?>
    <a href="#" class="backtotop"></a>
    <?php } ?>
    
	<div id="masterajaxloader"><img src="<?php echo get_template_directory_uri();?>/images/ajaxloader.gif" alt="Loading" /></div>
    
<?php 
	// ADD ANALYTICS CODE
	echo of_get_option('md_footer_googleanalytics');
	
	// ADD SHARING SCRIPTS
	echo showshareingpost('','','',1);
?>

<?php wp_footer(); ?>
</body>
</html>

