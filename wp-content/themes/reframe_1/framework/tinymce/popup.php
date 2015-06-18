<?php

// loads the shortcodes class, wordpress is loaded with it
require_once( 'shortcodes.class.php' );

// get popup type
$popup = trim( $_GET['popup'] );
$id = trim( $_GET['id'] );
$shortcode = new col_shortcodes( $popup );

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
</head>
<body>
<div id="col-popup">

	<div id="col-shortcode-wrap">
    
		<div id="col-sc-preview-wrap">
		
			<div id="col-sc-preview-head">
				Preview	
			</div>
			<!-- /#col-sc-preview-head -->
			
			<?php if( $shortcode->no_preview ) : ?>
			<div id="col-sc-nopreview">Shortcode has no preview</div>		
			<?php else : ?>			
			<iframe src="<?php echo COL_TINYMCE_URI; ?>/preview.php?sc=" width="249" frameborder="0" id="col-sc-preview"></iframe>
			<?php endif; ?>
			
		</div>
        
		<div id="col-sc-form-wrap">
		
			<div id="col-sc-form-head">
			
				<?php echo $shortcode->popup_title; ?>
			
			</div>
			<!-- /#col-sc-form-head -->
			
			<form method="post" id="col-sc-form">
			
				<table id="col-sc-form-table">
				
					<?php echo $shortcode->output; ?>
					
					<tbody>
						<tr class="form-row">
							<?php if( ! $shortcode->has_child ) : ?><td class="label">&nbsp;</td><?php endif; ?>
							<td class="field"><a href="#" class="button-primary col-insert" data-rel="<?php echo str_replace('_col_button','',$id)?>">Insert Shortcode</a></td>							
						</tr>
					</tbody>
				
				</table>
				<!-- /#col-sc-form-table -->
				
			</form>
			<!-- /#col-sc-form -->
		
		</div>
		<!-- /#col-sc-form-wrap -->
		
		<!-- /#col-sc-preview-wrap -->
		
		<div class="clear"></div>
		
	</div>
	<!-- /#col-shortcode-wrap -->

</div>
<!-- /#col-popup -->

</body>
</html>