  <div class="commentform border-color">
<?php if ( post_password_required() ) : ?>
		<p class="nopassword"><?php _e( 'This post is password protected. In order to view any comments please enter the password.', 'northeme' ); ?></p>
	</div>
<?php return; endif; ?>


<?php if ( have_comments() ) : ?>
	<h2 id="comments" class="border-color border-color-works">
	  <?php comments_number( __( '', 'northeme' ), __( '(1) COMMENT', 'northeme' ), _n( '(%) COMMENTS', '(%) COMMENTS', get_comments_number(), 'northeme' ) ); ?>
    </h2>

	<div class="comment-list">
		<?php wp_list_comments( array( 'callback' => 'northeme_comments' ) ); ?>
	</div>
	
	<div class="comments_nav">
    	<?php paginate_comments_links(); ?> 
    </div>
	 
 <?php else : // if there is no comments or comments are closed ?>

	<?php if ( ! comments_open() ) : ?>
		
		<p class="nocomments"><?php _e( 'Comments are closed.', 'northeme' ); ?></p>
        
	<?php endif; ?>
    
<?php endif; ?>


<?php 
	if ( comments_open() ) : 
	$args = array(
		'title_reply'=> __('LEAVE A REPLY','northeme'),
		'title_reply_to'=> __('LEAVE A REPLY to %s','northeme'),
	);
?>
	<?php comment_form($args); ?> 
<?php endif;  ?>
  </div>