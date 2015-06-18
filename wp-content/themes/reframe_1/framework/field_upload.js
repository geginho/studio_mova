//// TINYMCE RENDERER

var nortoolbars = "bold italic | alignleft aligncenter alignright alignjustify | link unlink fontsizeselect | colShortcodes | code";

function renderTiny() {
	var i=1;
	jQuery('#works-images-fields textarea.mceEditor').each(function(e)
	{
		var id = jQuery(this).attr('id');

		if (!id)
		{
			id = 'customEditor-' + i++;
			jQuery(this).attr('id',id);
		}

		//tinyMCE.execCommand('mceAddEditor', false, id);
		tinymce.init({
			selector: '#'+id,
			plugins : "code, link, colShortcodes",
			menubar:false,
			toolbar1: nortoolbars,
    		relative_urls: false,
   			remove_script_host: false
		});
	});
}


jQuery(document).ready(function(){

	jQuery(".fitvids").fitVids();
	
	var divs = 1;
	var thisisgalleryintro = 0;
	var thisisgallery = 0;

	jQuery('.get-datepicker').datepicker({
		showButtonPanel: true
	});
	
	
	jQuery('#md-sortable-media').sortable({
	    start: function(e, ui){
			jQuery(this).find('textarea.mceEditor').each(function(){
				tinyMCE.execCommand( 'mceRemoveEditor', false, jQuery(this).attr('id') );
			});
		},
		stop: function(e,ui) {
			jQuery(this).find('textarea.mceEditor').each(function(){
				renderTiny();
				//jQuery(this).sortable("refresh");
			});
			
		}
	});
		
	
	
	/// BLOG
	var fields = jQuery('#post-video-fields, #post-image-fields, #post-link-fields, #post-quote-fields, #post-gallery-fields, #page-type, #intro-slider-fields, #page-content-show');
	fields.hide();
	var currentsel = jQuery("input[name=post_format]:radio:checked").val();
	jQuery('#post-'+currentsel+'-fields').show();
	
	var currentselpage = jQuery("select[name=page_template]").val();
	if(currentselpage == 'template-works.php') {
		jQuery('#page-type').show();
		jQuery('#page-content-show').show();
	}
	
	if(currentselpage == 'template-fullslider.php') {
		jQuery('#intro-slider-fields').show();
	}
	
	if(currentselpage == 'template-blog.php') {
		jQuery('#page-content-show').show();
	}
	
	
	jQuery('input[name=post_format]').change(function() { 
		fields.hide();
		var selectd = jQuery("input[name=post_format]:radio:checked").val();
		jQuery('#post-'+selectd+'-fields').show();
	})
	
	jQuery('select[name=page_template]').change(function() { 
		if(jQuery(this).val() == 'template-works.php') {
			jQuery('#page-type').show();
			jQuery('#page-content-show').show();
		}else if(jQuery(this).val() == 'template-blog.php') {
			jQuery('#page-type').hide();
			jQuery('#page-content-show').show();
		}else{
			jQuery('#page-type').hide();
			jQuery('#page-content-show').hide();
		}
		
		if(jQuery(this).val() == 'template-fullslider.php') {
			jQuery('#intro-slider-fields').show();
		}else{
			jQuery('#intro-slider-fields').hide();
		}
	
	});
	
				
					
	/*
	 *
	 * UPLOAD VIDEOS
	 *
	 */
	jQuery('a.add-more-videos').live('click',function() { 
		divs++;
		var ids = 'new-md-field-'+divs;
		var cont = '<div id="vdiv'+ids+'" class="imgarr"><span class="imgside"> \
					<input type="hidden" id="'+ids+'" name="work-media[]" value="videoembed" /> \
					<img width="120" class="screenshot" src="'+wpurl.siteurl+'youtube.png" /></span><span> \
					<strong>Video Embed Code</strong><br class="clear" ><small>IMPORTANT : If you\'re using Gallery as your Composition Type, Vimeo or Youtube URL MUST be used instead of embed code. <br>E.g. http://www.youtube.com/watch?v=GCZrz8siv4Q</small><br class="clear" ><textarea id="v'+ids+'" cols="60" rows="3" class="work-caption" name="work-media-video[]"></textarea> \
					<a href="javascript:void(0);" class="admin-upload-remove button-secondary" rel-id="vdiv'+ids+'">Remove</a> \
					</span><br class="clear"></div>';
		jQuery('#md-sortable-media').prepend(cont);
	});
	
	
	jQuery('select.videoelement').live('change',function() { 
		var idmv = jQuery(this).data('id');
		
		if(jQuery(this).val()=='youtube' || jQuery(this).val()=='vimeo') { 
			jQuery('.embedvideo'+idmv).show();
			jQuery('.html5video'+idmv).hide();
		}else{
			jQuery('.embedvideo'+idmv).hide();
			jQuery('.html5video'+idmv).show();
		}
	});
	
	
	jQuery('a.add-more-videos-intro').live('click',function() { 
		divs++;
		var ids = 'new-md-field-'+divs;
		var cont = '<div id="vdiv'+ids+'" class="imgarr"><span class="imgside"> \
					<input type="hidden" id="'+ids+'" name="work-media[]" value="videoembed" /> \
					<img width="120" class="screenshot" src="'+wpurl.siteurl+'youtube.png" /></span><span style="width:70%"> \
					<strong>Video Type</strong><br class="clear" > \
					<select name="work-media-video-type[]" class="urlselector videoelement" data-id="'+ids+'" style="width:120px; margin-left:0;"> \
						<option value="youtube">Youtube</option><option value="vimeo" >Vimeo</option></select> \
					<br class="clear" ><br class="clear" ><div class="embedvideo'+ids+'"><strong>Video ID</strong><br class="clear" ><small>Please enter Youtube or Vimeo ID. <br>E.g. if your video link is  : http://www.youtube.com/watch?v=GCZrz8siv4Q -> your video ID is GCZrz8siv4Q.</small><br class="clear" ><input id="v'+ids+'" name="work-media-video[]"></div> \
					<br class="clear" ><div class="html5video'+ids+'" style="display:none"><strong>Video URL (mp4)</strong><br class="clear" ><small>E.g. http://mysite.com/video.mp4</small><br class="clear" ><input id="v'+ids+'" name="work-media-video-mp4[]"> \
					<br class="clear" ><br class="clear" ><strong>Video URL (ogg - optional)</strong><br class="clear" ><small>If you have ogg version of your video, please enter the URL.</small><br class="clear" ><input id="v'+ids+'" name="work-media-video-ogg[]"></div> \
					<a href="javascript:void(0);" class="admin-upload-remove button-secondary" rel-id="vdiv'+ids+'">Remove</a> \
					</span><br class="clear"></div>';
		jQuery('#md-sortable-media').prepend(cont);
	});
	
	
	
		
	/*
	 *
	 * ADD TEXT
	 *
	 */
	renderTiny();
		
		
	jQuery('a.add-more-text').live('click',function() { 
		divs++;
		var ids = 'new-md-field-'+divs;
		var cont = '<div id="textdiv'+ids+'" class="imgarr"><span class="imgside"> \
					<input type="hidden" id="'+ids+'" name="work-media[]" value="textarea" /> \
					<textarea id="tinymceids-'+ids+'" cols="60" style="width:600px;height:300px;" class="work-text mceEditor" name="work-media-text[]"></textarea> \
					<a href="javascript:void(0);" class="admin-upload-remove button-secondary" rel-id="textdiv'+ids+'">Remove</a> \
					</span><br class="clear"></div>';
		jQuery('#md-sortable-media').prepend(cont);
		
		tinymce.init({
			selector: '#tinymceids-'+ids,
			toolbar1: nortoolbars,
			menubar:false,
			plugins : "code, link, colShortcodes",
    		relative_urls: false,
   			remove_script_host: false
		});
	});
		
		
						
	/*
	 *
	 * UPLOAD IMAGES
	 *
	 */
	
	var tgm_media_frame;
	
	
	function addto_Composition(imgurl) { 
			divs++;
			var ids = 'new-md-field-'+divs;
			var cont = '<div id="d'+ids+'" class="imgarr" style="display:none">\
						<span class="imgside"><input type="hidden" id="'+ids+'" name="work-media[]" value="'+imgurl+'" /> \
						<div class="imgwindow"><img width="120" class="screenshot" id="sc-'+ids+'" src="'+imgurl+'" /></div></span><span> \
						<strong class="bloghide">Caption</strong><br class="clear" ><textarea id="v'+ids+'" cols="60" rows="3" class="work-caption bloghide" name="work-media-caption[]"></textarea> \
						<br class="clear"><small><strong>URL</strong> (Optional. If present, image will be wrapped with this URL)</small><br class="clear" > \
						<input type="text" style="width:200px;" placeholder="E.g. http://www.northeme.com" id="work-media-link-'+ids+'" name="work-media-link[]" value="" /> \
						<select name="work-media-link-target[]" class="urlselector"> \
						<option value="_blank">Open in New Window</option><option value="_self" >Open in Same Window</option></select> \
						<a href="javascript:void(0);" class="admin-upload-remove button-secondary" rel-id="d'+ids+'">Remove</a><br class="clear"><br class="clear" >\
						<label class="radio bloghide"><input type="radio" name="work-media-photoalignment['+(divs-1)+']" checked="checked" value="landscape"> Landscape</label> \
						<label class="radio bloghide"><input type="radio" name="work-media-photoalignment['+(divs-1)+']" value="portrait"> Portrait</label> \
						<br class="clear" ><br class="clear" ><strong>Lightbox</strong><br class="clear" ><select id="work-media-fancy-'+ids+'" name="work-media-fancy[]" class="urlselector" style="margin-left:0;"> \
					<option value="0">Disabled</option> \
					<option value="1">Open in Lightbox</option></select>\
						</span><br class="clear"></div>';
			jQuery('#md-sortable-media').append(cont);
			jQuery('#d'+ids).fadeIn('slow');
			
	}
	
	
	function addto_Intro(imgurl) { 
			divs++;
			var ids = 'new-md-field-'+divs;
			var cont = '<div id="d'+ids+'" class="imgarr" style="display:none">\
						<span class="imgside"><input type="hidden" id="'+ids+'" name="work-media[]" value="'+imgurl+'" /> \
						<div class="imgwindow"><img width="120" class="screenshot" id="sc-'+ids+'" src="'+imgurl+'" /></div></span><span> \
						<strong class="bloghide">Caption</strong><br class="clear" ><textarea id="v'+ids+'" cols="60" rows="3" class="work-caption bloghide" name="work-media-caption[]"></textarea> \
						<br class="clear"><small><strong>URL</strong> (Optional. If present, image will be wrapped with this URL)</small><br class="clear" > \
						<input type="text" style="width:200px;" placeholder="E.g. http://www.northeme.com" id="work-media-link-'+ids+'" name="work-media-link[]" value="" /> \
						<select name="work-media-link-target[]" class="urlselector"> \
						<option value="_blank">Open in New Window</option><option value="_self" >Open in Same Window</option></select> \
						<a href="javascript:void(0);" class="admin-upload-remove button-secondary" rel-id="d'+ids+'">Remove</a><br class="clear">\
						</span><br class="clear"></div>';
			jQuery('#md-sortable-media').append(cont);
			jQuery('#d'+ids).fadeIn('slow');
	}
	
	
	
	
	jQuery('.nhp-opts-upload').click(function() {
		
		  if ( tgm_media_frame ) {
			tgm_media_frame.open();
			return;
		  }
		
		  tgm_media_frame = wp.media.frames.tgm_media_frame = wp.media({
			multiple: true,
			library: {
			  type: 'image'
			},
		  });
		
		  tgm_media_frame.on('select', function(){
			var selection = tgm_media_frame.state().get('selection');
			selection.map( function( attachment ) {
				attachment = attachment.toJSON();
				addto_Composition(attachment.url);
			});
		  });
		
		  tgm_media_frame.open();
       
	});
	

	
	jQuery('.nhp-opts-upload-intro').click(function() {
		
		  if ( tgm_media_frame ) {
			tgm_media_frame.open();
			return;
		  }
		
		  tgm_media_frame = wp.media.frames.tgm_media_frame = wp.media({
			multiple: true,
			library: {
			  type: 'image'
			},
		  });
		
		  tgm_media_frame.on('select', function(){
			var selection = tgm_media_frame.state().get('selection');
			selection.map( function( attachment ) {
				attachment = attachment.toJSON();
				addto_Intro(attachment.url);
			});
		  });
		
		  tgm_media_frame.open();
       
	});
	
	jQuery('.admin-upload-remove').live('click',function(){
		jQuery(this).parent().parent().fadeOut('slow',function() {
		jQuery(this).remove();
		});
	});


	/*
	jQuery('.nhp-opts-upload-intro').click(function() {
	 thisisgalleryintro = 1;
	 post_id = jQuery('#post_ID').val();
	 tb_show('', 'media-upload.php?post_id='+post_id+'&amp;type=image&amp;TB_iframe=true');
	 return false;
	});
	
	jQuery('.nhp-opts-upload').click(function() {
	 thisisgallery = 1;
	 post_id = jQuery('#post_ID').val();
	 tb_show('', 'media-upload.php?post_id='+post_id+'&amp;type=image&amp;TB_iframe=true');
	 return false;
	});
	
	
	window.original_send_to_editor = window.send_to_editor;
	
	
	window.send_to_editor = function(html) {
		if(thisisgalleryintro) {
			imgurl = jQuery('img',html).attr('src');
			divs++;
			var ids = 'new-md-field-'+divs;
			var cont = '<div id="d'+ids+'" class="imgarr" style="display:none">\
						<span class="imgside"><input type="hidden" id="'+ids+'" name="work-media[]" value="'+imgurl+'" /> \
						<div class="imgwindow"><img width="120" class="screenshot" id="sc-'+ids+'" src="'+imgurl+'" /></div></span><span> \
						<strong class="bloghide">Caption</strong><br class="clear" ><textarea id="v'+ids+'" cols="60" rows="3" class="work-caption bloghide" name="work-media-caption[]"></textarea> \
						<br class="clear"><small><strong>URL</strong> (Optional. If present, image will be wrapped with this URL)</small><br class="clear" > \
						<input type="text" style="width:200px;" placeholder="E.g. http://www.northeme.com" id="work-media-link-'+ids+'" name="work-media-link[]" value="" /> \
						<select name="work-media-link-target[]" class="urlselector"> \
						<option value="_blank">Open in New Window</option><option value="_self" >Open in Same Window</option></select> \
						<a href="javascript:void(0);" class="admin-upload-remove button-secondary" rel-id="d'+ids+'">Remove</a><br class="clear">\
						</span><br class="clear"></div>';
			jQuery('#md-sortable-media').append(cont);
			jQuery('#d'+ids).fadeIn('slow');
			
			thisisgalleryintro = 0;
			tb_remove();
		
		}else if(thisisgallery) {
			imgurl = jQuery('img',html).attr('src');
			divs++;
			var ids = 'new-md-field-'+divs;
			var cont = '<div id="d'+ids+'" class="imgarr" style="display:none">\
						<span class="imgside"><input type="hidden" id="'+ids+'" name="work-media[]" value="'+imgurl+'" /> \
						<div class="imgwindow"><img width="120" class="screenshot" id="sc-'+ids+'" src="'+imgurl+'" /></div></span><span> \
						<strong class="bloghide">Caption</strong><br class="clear" ><textarea id="v'+ids+'" cols="60" rows="3" class="work-caption bloghide" name="work-media-caption[]"></textarea> \
						<br class="clear"><small><strong>URL</strong> (Optional. If present, image will be wrapped with this URL)</small><br class="clear" > \
						<input type="text" style="width:200px;" placeholder="E.g. http://www.northeme.com" id="work-media-link-'+ids+'" name="work-media-link[]" value="" /> \
						<select name="work-media-link-target[]" class="urlselector"> \
						<option value="_blank">Open in New Window</option><option value="_self" >Open in Same Window</option></select> \
						<a href="javascript:void(0);" class="admin-upload-remove button-secondary" rel-id="d'+ids+'">Remove</a><br class="clear">\
						<label class="radio bloghide"><input type="radio" name="work-media-photoalignment['+(divs-1)+']" checked="checked" value="landscape"> Landscape</label> \
						<label class="radio bloghide"><input type="radio" name="work-media-photoalignment['+(divs-1)+']" value="portrait"> Portrait</label> \
						</span><br class="clear"></div>';
			jQuery('#md-sortable-media').append(cont);
			jQuery('#d'+ids).fadeIn('slow');
			
			thisisgallery = 0;
			tb_remove();
		}else{
			window.original_send_to_editor(html);
		}
	}

	*/

	
					
	/*
	 *
	 * COLOR PICKER
	 *
	 */
	 
		
	jQuery('.colorSelector').each(function(){
			var Othis = this; //cache a copy of the this variable for use inside nested function
				
			jQuery(this).ColorPicker({
					color: '#ff0000',
					onShow: function (colpkr) {
						jQuery(colpkr).fadeIn(500);
						return false;
					},
					onHide: function (colpkr) {
						jQuery(colpkr).fadeOut(500);
						return false;
					},
					onChange: function (hsb, hex, rgb) {
						jQuery(Othis).children('div').css('backgroundColor', '#' + hex);
						jQuery(Othis).next('input').attr('value','#' + hex);
						
					}
			});
				  
	}); //end color picker
	
	
});