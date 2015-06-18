<?php
/*
Template Name: Full Page Slider
*/
$slider_temp=1;

	if(of_get_option('md_border_disable')) { 
		$wborder = 0; 
	}else{ 
		$wborder = 40;
	}
?>
<?php get_header(); ?>

<script type="text/javascript">
 	
	jQuery(function($){
		
		var extramargin = <?php echo $wborder?>;
		if($(window).width() < 959) {
			extramargin = 0;	
		}
	  
	  var framesize = 0;
	  var framesizenegative = 20;
	  
	  <?php if(!of_get_option('md_border_disable')) { ?> framesize=20; framesizenegative = 0; <?php } ?>
		
		var theheight;
	
		if($(window).width() < 760) {
			theheight = 'auto';
		}else{
			theheight = ($(window).height()-extramargin)+'px';
		}
		
		$('#maincontainer, .maincontainerdiv').css('height',theheight);
		
		$('.full-navigation').show();
		$('.sliderfooter').fadeIn();
		
	  
		$(window).resize(function() {
				
			if($(window).width() < 760) {
				theheight = 'auto';
			}else{
				theheight = ($(window).height()-extramargin)+'px';
			}
		
			$('#maincontainer, .maincontainerdiv').css('height',theheight);
		});
		
	
		$.supersized({
	
			// Functionality
			autoplay				:	<?php if(of_get_option('md_slider_intro_disable_autoplay')) { echo 0; }else{ echo 1; }?>,			// Slideshow starts playing automatically
			start_slide             :   <?php if(of_get_option('md_slider_intro_random')) { echo 0; }else{ echo 1;}?>,			// Start slide (0 is random)
			slide_interval          :   <?php if(of_get_option('md_slider_intro_speed')) { echo of_get_option('md_slider_intro_speed'); }else{ echo 7000; }?>,		// Length between transitions
			transition              :   <?php echo intval(of_get_option('md_slider_intro_animation_type'))?>, // 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
			transition_speed		:	<?php if(of_get_option('md_slider_intro_duration')) { echo of_get_option('md_slider_intro_duration'); }else{ echo 1000; }?>,		// Speed of transition
			slides 					:  	[			// Slideshow Images
			<?php 
			
				$slider_media = unserialize(get_post_meta( $post->ID, 'work-media', true ));
				$mediacaption = unserialize(get_post_meta( $post->ID, 'work-media-caption', true ));
				$medialink = unserialize(get_post_meta( $post->ID, 'work-media-link', true ));
				$medialinktarget = unserialize(get_post_meta( $post->ID, 'work-media-link-target', true ));
				$mediavideo = unserialize(get_post_meta( $post->ID, 'work-media-video', true ));
				$mediavideoogg = unserialize(get_post_meta( $post->ID, 'work-media-video-ogg', true ));
				$mediavideomp4 = unserialize(get_post_meta( $post->ID, 'work-media-video-mp4', true ));
				$mediavideothumb = unserialize(get_post_meta( $post->ID, 'work-media-video-thumb', true ));
				$mediavideotype = unserialize(get_post_meta( $post->ID, 'work-media-video-type', true ));
					
				$says = count($slider_media);
				$ss = 1;
				$s1=0;
				$s2=0;
				
				if(is_array($slider_media)) {
					
					foreach($slider_media as $k => $foo) {	
				
						if($foo=='videoembed') {
							$type = strtoupper($mediavideotype[$s1]);
						}else{
							$type = 'IMAGE';
						}
				
			?>{type:'<?php echo $type?>', <?php if($type!='IMAGE') { ?>video_id : '<?php echo $mediavideo[$s1]?>', video_mp4 : '<?php echo $mediavideomp4[$s1]?>', video_ogv : '<?php echo $mediavideoogg[$s1]?>'<?php }else{ ?>image : '<?php echo $foo?>'<?php } ?>, title : '<?php echo @$mediacaption[$s2]?>', thumb : '<?php echo @$mediavideothumb[$s1]?>',url : '<?php if(isset($medialink[$s2]) && $medialink[$s2]!='') { echo @$medialink[$s2]; }?>', target : '<?php if(isset($medialink[$s2]) && $medialink[$s2]!='' && isset($medialinktarget[$s2]) && $medialinktarget[$s2]!='') { echo @$medialinktarget[$s2]; }?>'<?php if($foo=='videoembed') { $s1++; }else{ $s2++; } ?>}<?php if($says > $ss) { echo ','; }$ss++;?><?php }} ?>],
	
			// Theme Options			   
			progress_bar			:	0,			// Timer for each slide							
			mouse_scrub				:	0
	
		});
	
			
	});
	

 </script>
 <!--Arrow Navigation-->
    <div class="full-navigation">
 	<?php if(!of_get_option('md_slider_intro_disableplaypause')) { ?>
    	<a href="#" class="load-item playpause"><i class="icon-pause"></i><i class="icon-play" style="display:none"></i></a>
	<?php } ?>	
	<?php if(!of_get_option('md_slider_intro_disablearrow')) { ?>
        <a id="prevslide" class="load-item"><i class="icon-angle-left"></i></a>
        <a id="nextslide" class="load-item"><i class="icon-angle-right"></i></a>
    <?php } ?>
    </div>
    
    <!--Slide captions displayed here-->
    <div id="slidecaption"></div>
    
    <!--Control Bar-->
    <div id="controls-wrapper" class="load-item">
        <div id="controls">
        </div>
    </div>

<div class="sliderfooter">
   <?php echo of_get_option('md_footer_text'); ?>&nbsp;
</div>
<?php get_footer(); ?>
