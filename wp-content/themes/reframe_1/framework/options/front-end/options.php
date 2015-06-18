   <!--[if lt IE 9]>
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo ADMIN_DIR; ?>/assets/css/font-awesome-ie7.min.css" />
	<![endif]-->
    
<div class="wrap" id="of_container">

	<div id="of-popup-save" class="of-save-popup">
		<div class="of-save-save">Options Updated</div>
	</div>
	
	<div id="of-popup-reset" class="of-save-popup">
		<div class="of-save-reset">Options Reset</div>
	</div>
	
	<div id="of-popup-fail" class="of-save-popup">
		<div class="of-save-fail">Error!</div>
	</div>
	
	<span style="display: none;" id="hooks"><?php echo json_encode(of_get_header_classes_array()); ?></span>
	<input type="hidden" id="reset" value="<?php if(isset($_REQUEST['reset'])) echo $_REQUEST['reset']; ?>" />
	<input type="hidden" id="security" name="security" value="<?php echo wp_create_nonce('of_ajax_nonce'); ?>" />

	<form id="of_form" method="post" action="<?php echo esc_attr( $_SERVER['REQUEST_URI'] ) ?>" enctype="multipart/form-data" >
	
		<div id="header">
		
			<div class="logo">
				<h2><?php echo THEMENAME; ?></h2>
				<span><?php echo ('v'. THEMEVERSION); ?></span>
			</div>
		
			<div id="js-warning">Warning- This options panel will not work properly without javascript!</div>
			<div class="icon-option"></div>
			<div class="clear"></div>
		
    	</div>

		<div id="info_bar">
			
            <a href="http://support.northeme.com" target="_blank" class="nor">
            	<i class="icon-medkit"></i> SUPPORT FORUMS
            </a>
            
            <a href="http://northeme.com/themes" target="_blank" class="nor">
            	<i class="icon-star"></i> NEW THEMES
            </a>
            
            		
			<span class="ajax-loading-img ajax-loading-img-bottom" style="display:none;color:"><i class="icon-spinner icon-spin"></i></span>
			<button id="of_save" type="button" class="button-primary">
				<?php _e('Save All Changes','northeme');?>
			</button>
			
		</div><!--.info_bar--> 	
		
		<div id="main">
		
			<div id="of-nav">
				<ul>
				  <?php echo $options_machine->Menu ?>
				</ul>
			</div>

			<div id="content">
		  		<?php echo $options_machine->Inputs /* Settings */ ?>
		  	</div>
		  	
			<div class="clear"></div>
			
		</div>
		
		<div class="save_bar"> 
		
			<span class="ajax-loading-img ajax-loading-img-bottom" style="display:none;"><i class="icon-spinner icon-spin"></i></span>
			<button id ="of_save" type="button" class="button-primary"><?php _e('Save All Changes','northeme');?></button>			
			<button id ="of_reset" type="button" class="button submit-button reset-button" ><?php _e('Options Reset','northeme');?></button>
			
		</div><!--.save_bar--> 
 
	</form>
	
	<div style="clear:both;"></div>

</div><!--wrap-->