/**
 * SMOF js
 *
 * contains the core functionalities to be used
 * inside SMOF
 */

jQuery.noConflict();

	
var googf = false;
function loadGooglef() { 
	// FOR GOOGLE FONTS REALTIME VIEWING
	if(!googf) {
	jQuery('.gfontscomehead').fontselect().change(function(){
        
          // replace + signs with spaces for css
          var font = jQuery(this).val().replace(/\+/g, ' ');
          // split font into family and weight
          font = font.split(':');
          // set family on heading 
          jQuery('h1.gfontsviewhead').css('font-family', font[0]);
        });;
		
	jQuery('.gfontscome').fontselect().change(function(){
        
          // replace + signs with spaces for css
          var font = jQuery(this).val().replace(/\+/g, ' ');
          // split font into family and weight
          font = font.split(':');
          // set family on paragraphs 
          jQuery('p.gfontsview').css('font-family', font[0]);
    });
	googf = true;
	}
}

function changePresetColors(arr) { 

	jQuery("#md_body_bgcolor").val(arr[0]);
	jQuery("#md_body_framecolor").val(arr[1]);
	jQuery("#md_css_heading").val(arr[2]);
	jQuery("#md_css_sitetextcolor").val(arr[3]);
	jQuery("#md_css_linkcolor").val(arr[4]);
	jQuery("#md_css_linkcolorhover").val(arr[5]);
	jQuery("#md_css_menucolor").val(arr[6]);
	jQuery("#md_css_menucolorhover").val(arr[7]);
	jQuery("#md_css_bordercolor").val(arr[8]);
	jQuery("#md_css_iconcolors").val(arr[9]);
	jQuery("#md_css_scrollbar").val(arr[10]);
	jQuery("#md_css_worksthumbbg").val(arr[11]);
	jQuery("#md_css_worksthumbtext").val(arr[12]);
	jQuery("#md_css_formelementbg").val(arr[13]);
	jQuery("#md_css_formelementborder").val(arr[14]);
	jQuery("#md_css_formelementtext").val(arr[15]);
	jQuery("#md_css_formbuttonbg").val(arr[16]);
	jQuery("#md_css_formbuttontext").val(arr[17]);
	jQuery("#md_css_logotext").val(arr[18]);
	jQuery("#md_css_tabsbg").val(arr[19]);
	jQuery("#md_css_tabstext").val(arr[20]);

					
}
					
function checkAllFields() { 
		if(jQuery('#of-radio-img-md_css_presets1').is(':checked')) { 
			jQuery('select[name=md_css_bgpattern]').val('--No Pattern--');
			var a = new Array(
			'#fff',
			'#fff',
			'#000',
			'#000',
			'#000',
			'#000',
			'#000',
			'#000',
			'#ccc',
			'#000',
			'#000',
			'#000',
			'#fff',
			'#f0f0f0',
			'#f0f0f0',
			'#000',
			'#000',
			'#fff',
			'#000',
			'#f9f9f9',
			'#000'
			);
			changePresetColors(a);
		}
		if(jQuery('#of-radio-img-md_css_presets2').is(':checked')) { 
			jQuery('select[name=md_css_bgpattern]').val('gray.jpg');
			var a = new Array(
			'#f5f5f5',
			'#fff',
			'#000',
			'#666',
			'#666',
			'#000',
			'#000',
			'#000',
			'#ccc',
			'#000',
			'#000',
			'#000',
			'#fff',
			'#fff',
			'#fff',
			'#000',
			'#000',
			'#fff',
			'#666',
			'#fff',
			'#000'
			);
			changePresetColors(a);
		}
		if(jQuery('#of-radio-img-md_css_presets3').is(':checked')) { 
			jQuery('select[name=md_css_bgpattern]').val('--No Pattern--');
			var a = new Array(
			'#000',
			'#fff',
			'#fff',
			'#ccc',
			'#fff',
			'#f0f0f0',
			'#fff',
			'#ccc',
			'#333',
			'#ccc',
			'#666',
			'#000',
			'#f0f0f0',
			'#333',
			'#333',
			'#fff',
			'#333',
			'#fff',
			'#ccc',
			'#333',
			'#fff'
			);
			changePresetColors(a);
		}
		
		if(jQuery('#of-radio-img-md_css_presets4').is(':checked')) { 
			jQuery('.presethidden').fadeIn();
		}else{
			jQuery('.presethidden').fadeOut();
		}
}
/** Fire up jQuery - let's dance! 
 */
jQuery(document).ready(function($){
		
	
	jQuery(".showhideselect select").live('change',function() { 
		$('.hideoptions').hide();
		$('.'+$(this).val()).show();	
	});
	
	jQuery("input.ibutton").iButton();

	///
	jQuery('[name=md_css_bgpattern]').change(function() { 
		if(jQuery(this).val()=='--No Pattern--') {
		jQuery('div.bgpatterndiv').css('background','#fff');
		}else{
		jQuery('div.bgpatterndiv').css('background','url('+wpurl.siteurl+'/images/bgpatterns/'+jQuery(this).val()+')');
		}
	})
	
	/// PRESETS	
	if(jQuery('#of-radio-img-md_css_presets4').is(':checked')) {
		jQuery('.presethidden').show();
	}else{
		jQuery('.presethidden').hide();
	}
	
	//(un)fold options in a checkbox-group
  	jQuery('.fld').click(function() {
    	var $fold='.f_'+this.id;
    	$($fold).slideToggle('normal', "swing");
  	});
	
	//delays until AjaxUpload is finished loading
	//fixes bug in Safari and Mac Chrome
	if (typeof AjaxUpload != 'function') { 
			return ++counter < 6 && window.setTimeout(init, counter * 500);
	}
	
	//hides warning if js is enabled			
	$('#js-warning').hide();
	
	//Tabify Options			
	$('.group').hide();
	
	// Display last current tab	
	if ($.cookie("of_current_opt") === null) {
		
		$('.group:first').fadeIn('fast');	
		$('#of-nav li:first').addClass('current');
	} else {
	
		var hooks = $('#hooks').html();
		hooks = jQuery.parseJSON(hooks);
		
		$.each(hooks, function(key, value) { 
		
			if ($.cookie("of_current_opt") == '#of-option-'+ value) {
				$('.group#of-option-' + value).fadeIn();
				$('#of-nav li.' + value).addClass('current');
				
					if(value=='fonts') { 
						loadGooglef();
					}
					
			}
			
		});
	
	}
				
	//Current Menu Class
	$('#of-nav li a').click(function(evt){
		if($(this).parent().attr('class')=='fonts') { 
			loadGooglef();
		}
	// event.preventDefault();
				
		$('#of-nav li').removeClass('current');
		$(this).parent().addClass('current');
							
		var clicked_group = $(this).attr('href');
		
		$.cookie('of_current_opt', clicked_group, { expires: 7, path: '/' });
			
		$('.group').hide();
							
		$(clicked_group).fadeIn('fast');
		return false;
						
	});

	//Expand Options 
	var flip = 0;
				
	$('#expand_options').click(function(){
		if(flip == 0){
			flip = 1;
			$('#of_container #of-nav').hide();
			$('#of_container #content').width(755);
			$('#of_container .group').add('#of_container .group h2').show();
	
			$(this).removeClass('expand');
			$(this).addClass('close');
			$(this).text('Close');
					
		} else {
			flip = 0;
			$('#of_container #of-nav').show();
			$('#of_container #content').width(595);
			$('#of_container .group').add('#of_container .group h2').hide();
			$('#of_container .group:first').show();
			$('#of_container #of-nav li').removeClass('current');
			$('#of_container #of-nav li:first').addClass('current');
					
			$(this).removeClass('close');
			$(this).addClass('expand');
			$(this).text('Expand');
				
		}
			
	});
	
	//Update Message popup
	$.fn.center = function () {
		this.animate({"top":( $(window).height() - this.height() - 200 ) / 2+$(window).scrollTop() + "px"},100);
		this.css("left", 250 );
		return this;
	}
		
			
	$('#of-popup-save').center();
	$('#of-popup-reset').center();
	$('#of-popup-fail').center();
			
	$(window).scroll(function() { 
		$('#of-popup-save').center();
		$('#of-popup-reset').center();
		$('#of-popup-fail').center();
	});
			

	//Masked Inputs (images as radio buttons)
	$('.of-radio-img-img').click(function(){
		$(this).parent().parent().find('.of-radio-img-img').removeClass('of-radio-img-selected');
		$(this).addClass('of-radio-img-selected');
	});
	$('.of-radio-img-label').hide();
	$('.of-radio-img-img').show();
	$('.of-radio-img-radio').hide();
	
	//Masked Inputs (background images as radio buttons)
	$('.of-radio-tile-img').click(function(){
		$(this).parent().parent().find('.of-radio-tile-img').removeClass('of-radio-tile-selected');
		$(this).addClass('of-radio-tile-selected');
	});
	$('.of-radio-tile-label').hide();
	$('.of-radio-tile-img').show();
	$('.of-radio-tile-radio').hide();

	//AJAX Upload
	function of_image_upload() {
	$('.image_upload_button').each(function(){
			
	var clickedObject = $(this);
	var clickedID = $(this).attr('id');	
			
	var nonce = $('#security').val();
			
	new AjaxUpload(clickedID, {
		action: ajaxurl,
		name: clickedID, // File upload name
		data: { // Additional data to send
			action: 'of_ajax_post_action',
			type: 'upload',
			security: nonce,
			data: clickedID },
		autoSubmit: true, // Submit file after selection
		responseType: false,
		onChange: function(file, extension){},
		onSubmit: function(file, extension){
			clickedObject.text('Uploading'); // change button text, when user selects file	
			this.disable(); // If you want to allow uploading only 1 file at time, you can disable upload button
			interval = window.setInterval(function(){
				var text = clickedObject.text();
				if (text.length < 13){	clickedObject.text(text + '.'); }
				else { clickedObject.text('Uploading'); } 
				}, 200);
		},
		onComplete: function(file, response) {
			window.clearInterval(interval);
			clickedObject.text('Upload Image');	
			this.enable(); // enable upload button
				
	
			// If nonce fails
			if(response==-1){
				var fail_popup = $('#of-popup-fail');
				fail_popup.fadeIn();
				window.setTimeout(function(){
				fail_popup.fadeOut();                        
				}, 2000);
			}				
					
			// If there was an error
			else if(response.search('Upload Error') > -1){
				var buildReturn = '<span class="upload-error">' + response + '</span>';
				$(".upload-error").remove();
				clickedObject.parent().after(buildReturn);
				
				}
			else{
				var buildReturn = '<img class="hide of-option-image" id="image_'+clickedID+'" src="'+response+'" alt="" />';

				$(".upload-error").remove();
				$("#image_" + clickedID).remove();	
				clickedObject.parent().after(buildReturn);
				$('img#image_'+clickedID).fadeIn();
				clickedObject.next('span').fadeIn();
				clickedObject.parent().prev('input').val(response);
			}
		}
	});
			
	});
	
	}
	
	of_image_upload();
			
	//AJAX Remove Image (clear option value)
	$('.image_reset_button').live('click', function(){
	
		var clickedObject = $(this);
		var clickedID = $(this).attr('id');
		var theID = $(this).attr('title');	
				
		var nonce = $('#security').val();
	
		var data = {
			action: 'of_ajax_post_action',
			type: 'image_reset',
			security: nonce,
			data: theID
		};
					
		$.post(ajaxurl, data, function(response) {
						
			//check nonce
			if(response==-1){ //failed
							
				var fail_popup = $('#of-popup-fail');
				fail_popup.fadeIn();
				window.setTimeout(function(){
					fail_popup.fadeOut();                        
				}, 2000);
			}
						
			else {
						
				var image_to_remove = $('#image_' + theID);
				var button_to_hide = $('#reset_' + theID);
				image_to_remove.fadeOut(500,function(){ $(this).remove(); });
				button_to_hide.fadeOut();
				clickedObject.parent().prev('input').val('');
			}
						
						
		});
					
	}); 

	// Style Select
	(function ($) {
	styleSelect = {
		init: function () {
		$('.select_wrapper').each(function () {
			$(this).prepend('<span>' + $(this).find('.select option:selected').text() + '</span>');
		});
		$('.select').live('change', function () {
			$(this).prev('span').replaceWith('<span>' + $(this).find('option:selected').text() + '</span>');
		});
		$('.select').bind($.browser.msie ? 'click' : 'change', function(event) {
			$(this).prev('span').replaceWith('<span>' + $(this).find('option:selected').text() + '</span>');
		}); 
		}
	};
	$(document).ready(function () {
		styleSelect.init()
	})
	})(jQuery);
	
	
	/** Aquagraphite Slider MOD */
	
	//Hide (Collapse) the toggle containers on load
	$(".slide_body").hide(); 

	//Switch the "Open" and "Close" state per click then slide up/down (depending on open/close state)
	$(".slide_edit_button").live( 'click', function(){
		$(this).parent().toggleClass("active").next().slideToggle("fast");
		return false; //Prevent the browser jump to the link anchor
	});	
	
	// Update slide title upon typing		
	function update_slider_title(e) {
		var element = e;
		if ( this.timer ) {
			clearTimeout( element.timer );
		}
		this.timer = setTimeout( function() {
			$(element).parent().prev().find('strong').text( element.value );
		}, 100);
		return true;
	}
	
	$('.of-slider-title').live('keyup', function(){
		update_slider_title(this);
	});
		
	
	//Remove individual slide
	$('.slide_delete_button').live('click', function(){
	// event.preventDefault();
	if($(this).data('w')=='posttype') { 
		var agree = confirm("Are you sure you wish to delete this Custom Post Type?");
	}else if($(this).data('w')=='socialicon') { 
		var agree = confirm("Are you sure you wish to remove this social link?");
	}else{
		var agree = confirm("Are you sure you wish to delete this slide?");
	}
		if (agree) {
			var $trash = $(this).parents('li');
			//$trash.slideUp('slow', function(){ $trash.remove(); }); //chrome + confirm bug made slideUp not working...
			$trash.animate({
					opacity: 0.25,
					height: 0,
				}, 500, function() {
					$(this).remove();
			});
			return false; //Prevent the browser jump to the link anchor
		} else {
		return false;
		}	
	});
	
	
	
	
		
	//Add new social icon
	$(".socialicon_add_button").live('click', function(){		
		var slidesContainer = $('ul.socialiconscontent');
		var sliderId = slidesContainer.attr('id');
		var sliderInt = $('#'+sliderId).attr('rel');
		
		var numArr = $('#'+sliderId +' li').find('.order').map(function() { 
			var str = this.id; 
			str = str.replace(/\D/g,'');
			str = parseFloat(str);
			return str;			
		}).get();
		
		var maxNum = Math.max.apply(Math, numArr);
		if (maxNum < 1 ) { maxNum = 0};
		var newNum = maxNum + 1;
		
		/*var newSlide = '<li class="temphide" style="border-top:none"><div class="slide_header posttype"><strong>Custom Post Type : ' + newNum + '</strong><input type="hidden" class="slide of-input order" name="'+ sliderId +'['+newNum+'][order]" id="'+ sliderId +'_' + newNum +'_slide_order" value="'+newNum+'" /> \
		<a class="slide_edit_button" href="#">Edit</a></div> \
		<div class="slide_body">';*/
		
		var newSlide = $('div.socialiconsdiv').html();
	
		slidesContainer.append(newSlide);
		
		$('input, select',slidesContainer).removeAttr('disabled');
		
	    jQuery("input.ibutton").iButton();
	
		$('.temphide').fadeIn('fast', function() {
			$(this).removeClass('temphide');
		});
				
		of_image_upload(); // re-initialise upload image..
		
		return false; //prevent jumps, as always..
	});	
	
	
	
	
	
	
	//Add new slide
	$(".slide_add_button").live('click', function(){		
		var slidesContainer = $(this).prev();
		var sliderId = slidesContainer.attr('id');
		var sliderInt = $('#'+sliderId).attr('rel');
		
		var numArr = $('#'+sliderId +' li').find('.order').map(function() { 
			var str = this.id; 
			str = str.replace(/\D/g,'');
			str = parseFloat(str);
			return str;			
		}).get();
		
		var maxNum = Math.max.apply(Math, numArr);
		if (maxNum < 1 ) { maxNum = 0};
		var newNum = maxNum + 1;
		
		var newSlide = '<li class="temphide"><div class="slide_header"><strong>Slide ' + newNum + '</strong><input type="hidden" class="slide of-input order" name="' + sliderId + '[' + newNum + '][order]" id="' + sliderId + '_slide_order-' + newNum + '" value="' + newNum + '"><a class="slide_edit_button" href="#">Edit</a></div><div class="slide_body" style="display: none; "><label>Title</label><input class="slide of-input of-slider-title" name="' + sliderId + '[' + newNum + '][title]" id="' + sliderId + '_' + newNum + '_slide_title" value=""><label>Image URL</label><input class="slide of-input" name="' + sliderId + '[' + newNum + '][url]" id="' + sliderId + '_' + newNum + '_slide_url" value=""><div class="upload_button_div"><span class="button media_upload_button" id="' + sliderId + '_' + newNum + '" rel="'+sliderInt+'">Upload</span><span class="button mlu_remove_button hide" id="reset_' + sliderId + '_' + newNum + '" title="' + sliderId + '_' + newNum + '">Remove</span></div><div class="screenshot"></div><label>Video Embed Code <br><small>(if you add video code, Image URL will be ignored)</small></label><textarea class="slide of-input" name="' + sliderId + '[' + newNum + '][video]" id="' + sliderId + '_' + newNum + '_slide_video" cols="8" rows="8"></textarea><label>Link URL (optional)</label><input class="slide of-input" name="' + sliderId + '[' + newNum + '][link]" id="' + sliderId + '_' + newNum + '_slide_link" value=""><label>Link Target (optional)</label><select class="select of-input" name="' + sliderId + '[' + newNum + '][target]" style="width:320px" id="' + sliderId + '_' + newNum +'_slide_target"><option value="_self">_self</option><option value="_blank">_blank</option></select><label>Caption (optional)</label><textarea class="slide of-input" name="' + sliderId + '[' + newNum + '][description]" id="' + sliderId + '_' + newNum + '_slide_description" cols="8" rows="8"></textarea><a class="slide_delete_button" href="#">Delete</a><div class="clear"></div></div></li>';
		
		slidesContainer.append(newSlide);
		$('.temphide').fadeIn('fast', function() {
			$(this).removeClass('temphide');
		});
				
		of_image_upload(); // re-initialise upload image..
		
		return false; //prevent jumps, as always..
	});	
	
	
	//Add new slide
	$(".slide_add_button_intro").live('click', function(){		
		var slidesContainer = $(this).prev();
		var sliderId = slidesContainer.attr('id');
		var sliderInt = $('#'+sliderId).attr('rel');
		
		var numArr = $('#'+sliderId +' li').find('.order').map(function() { 
			var str = this.id; 
			str = str.replace(/\D/g,'');
			str = parseFloat(str);
			return str;			
		}).get();
		
		var maxNum = Math.max.apply(Math, numArr);
		if (maxNum < 1 ) { maxNum = 0};
		var newNum = maxNum + 1;
		
		var newSlide = '<li class="temphide"><div class="slide_header"><strong>Slide ' + newNum + '</strong><input type="hidden" class="slide of-input order" name="' + sliderId + '[' + newNum + '][order]" id="' + sliderId + '_slide_order-' + newNum + '" value="' + newNum + '"><a class="slide_edit_button" href="#">Edit</a></div><div class="slide_body" style="display: none; "><select class="slide of-input" name="' + sliderId + '[' + newNum + '][type]" id="' + sliderId + '[' + newNum + ']_slide_type" style="width:320px"><option value="IMAGE">Image</option><option value="VIMEO">Vimeo</option><option value="YOUTUBE">Youtube</option></select><label>Title</label><input class="slide of-input of-slider-title" name="' + sliderId + '[' + newNum + '][title]" id="' + sliderId + '_' + newNum + '_slide_title" value=""><label>Video ID</label><input class="slide of-input of-slider-video" name="' + sliderId + '[' + newNum + '][video]" id="' + sliderId + '_' + newNum + '_slide_video" value=""><br class="clear"><small>* If this is a video slide, enter the video ID ; E.g. video URL is : http://vimeo.com/76253725 - Video ID is <strong>76253725</strong> or video URL is http://www.youtube.com/watch?v=KLpkXtM-VI8 - Video ID is <strong>KLpkXtM-VI8</strong></small><br><label>Image URL</label><input class="slide of-input" name="' + sliderId + '[' + newNum + '][url]" id="' + sliderId + '_' + newNum + '_slide_url" value=""><div class="upload_button_div"><span class="button media_upload_button" id="' + sliderId + '_' + newNum + '" rel="'+sliderInt+'">Upload</span><span class="button mlu_remove_button hide" id="reset_' + sliderId + '_' + newNum + '" title="' + sliderId + '_' + newNum + '">Remove</span></div><div class="screenshot"></div><label>Caption (optional)</label><input class="slide of-input" name="' + sliderId + '[' + newNum + '][caption]" id="' + sliderId + '_' + newNum + '_caption" value=""><label>Link URL (optional)</label><input class="slide of-input" name="' + sliderId + '[' + newNum + '][link]" id="' + sliderId + '_' + newNum + '_slide_link" value=""><label>Link Target (optional)</label><select class="select of-input" name="' + sliderId + '[' + newNum + '][target]" style="width:320px" id="' + sliderId + '_' + newNum +'_slide_target"><option value="_self">_self</option><option value="_blank">_blank</option></select><a class="slide_delete_button" href="#">Delete</a><div class="clear"></div></div></li>';
		
		slidesContainer.append(newSlide);
		$('.temphide').fadeIn('fast', function() {
			$(this).removeClass('temphide');
		});
				
		of_image_upload(); // re-initialise upload image..
		
		return false; //prevent jumps, as always..
	});	
	
	
	
	
	//Add new custom post type
	$(".custompost_add_button").live('click', function(){		
		var slidesContainer = $(this).prev();
		var sliderId = slidesContainer.attr('id');
		var sliderInt = $('#'+sliderId).attr('rel');
		
		var numArr = $('#'+sliderId +' li').find('.order').map(function() { 
			var str = this.id; 
			str = str.replace(/\D/g,'');
			str = parseFloat(str);
			return str;			
		}).get();
		
		var maxNum = Math.max.apply(Math, numArr);
		if (maxNum < 1 ) { maxNum = 0};
		var newNum = maxNum + 1;
		
		var newSlide = '<li class="temphide" style="border-top:none"><div class="slide_header posttype"><strong>Custom Post Type : ' + newNum + '</strong><input type="hidden" class="slide of-input order" name="'+ sliderId +'['+newNum+'][order]" id="'+ sliderId +'_' + newNum +'_slide_order" value="'+newNum+'" /> \
		<a class="slide_edit_button" href="#">Edit</a></div> \
		<div class="slide_body"> \
		<h3 style="float:left">STEP 1 : PREFERENCES</h3> <a class="slide_delete_button" data-w="posttype" href="#" style="float:right;margin-top:20px;">Delete</a><br style="clear:both" ><label class="title">Thumbnail Columns</label> \
		<select class="slide of-input" name="'+ sliderId +'['+newNum+'][thumbnail]" id="'+ sliderId +'_' + newNum +'_slide_title" style="width:320px"> \
				<option value="5">5 Columns</option> \
				<option value="4">4 Columns</option> \
				<option value="3" selected="selected">3 Columns</option> \
				<option value="2">2 Columns</option> \
				<option value="1">1 Columns</option> \
			</select> \
		<small>You can change your thumbnail size through this option. According to thumbnail quantity in a row, your thumbnail sizes will be changed automatically.</small> \
		<label class="title">Thumbnail Padding</label> \
		<select class="slide of-input" name="'+ sliderId +'['+newNum+'][thumbnailpadding]" id="'+ sliderId +'_' + newNum +'_slide_title" style="width:320px"> \
				<option value="1">1</option> \
				<option value="2">2</option> \
				<option value="3">3</option> \
				<option value="4">4</option> \
				<option value="5">5</option> \
				<option value="6" selected="selected">6</option> \
				<option value="7">7</option> \
				<option value="8">8</option> \
				<option value="9">9</option> \
				<option value="10">10</option> \
				<option value="11">11</option> \
				<option value="12">12</option> \
				<option value="13">13</option> \
				<option value="14">14</option> \
				<option value="15">15</option> \
				<option value="16">16</option> \
				<option value="17">17</option> \
				<option value="18">18</option> \
				<option value="19">19</option> \
				<option value="20">20</option> \
			</select> \
		<small>You can change your thumbnail size through this option. According to thumbnail quantity in a row, your thumbnail sizes will be changed automatically.</small> \
		<br style="clear:both"><br><label class="title">Fixed Thumbnail Height</label> \
		<input type="hidden" class="checkbox aq-input" name="'+ sliderId +'['+newNum+'][fixedthumbs]" value="0"/> \
		<div class="ibuttonwrap"><input type="checkbox" class="checkbox of-input ibutton" name="'+ sliderId +'['+newNum+'][fixedthumbs]" value="1" /></div> \
		<br style="clear:both"><br><small>This theme is using masonry (pinterest style) thumbnail placement with variable height by default. However, if you wish to display project thumbnails with fixed height, you may prefer to activate this option. Fixed thumnail sizes are calculated automatically as 4:3 ratio.</small> \
		<br style="clear:both"><label class="title">Display Categories</label> \
		<input type="hidden" class="checkbox aq-input" name="'+ sliderId +'['+newNum+'][showcategory]" value="0"/> \
		<div class="ibuttonwrap"><input type="checkbox" class="checkbox of-input ibutton" name="'+ sliderId +'['+newNum+'][showcategory]" value="1" /></div> \
		<br style="clear:both"><br><label class="title">Disable Navigation Arrows on Single Post Page</label> \
		<input type="hidden" class="checkbox aq-input" name="'+ sliderId +'['+newNum+'][navigation_hide]" value="0"/> \
		<div class="ibuttonwrap"><input type="checkbox" class="checkbox of-input ibutton" name="'+ sliderId +'['+newNum+'][navigation_hide]" value="1" /></div> \
		<br style="clear:both"><br><small>Allows you to disable navigation arrows</small> \
		<br style="clear:both"><label class="title">Hide Navigation Arrow Text</label> \
		<input type="hidden" class="checkbox aq-input" name="'+ sliderId +'['+newNum+'][navigation_text]" value="0"/> \
		<div class="ibuttonwrap"><input type="checkbox" class="checkbox of-input ibutton" name="'+ sliderId +'['+newNum+'][navigation_text]" value="1" /></div> \
		<br style="clear:both"><br><small>Allows you to hide Home, Next, Back text on Full width single post page</small> \
		<br style="clear:both"><label class="title">Hide Categories on Single Post Pages</label> \
		<input type="hidden" class="checkbox aq-input" name="'+ sliderId +'['+newNum+'][showsinglecategory]" value="0"/> \
		<div class="ibuttonwrap"><input type="checkbox" class="checkbox of-input ibutton" name="'+ sliderId +'['+newNum+'][showsinglecategory]" value="1" /></div> \
		<br style="clear:both"><br><small>This option allows you to hide categories in single custom post pages</small> \
		<label class="title">Post Display Limit</label> \
		<input class="slide of-input" name="'+ sliderId +'['+newNum+'][pagination]" id="'+sliderId+'_'+newNum+'_slide_title" value="0" /><small>Allows you to specify a limit for pagination. By default, it\'s 0 (unlimited)</small> \
		<br> \
		<br><label class="title">Order By</label> \
		<select class="slide of-input" name="'+ sliderId +'['+newNum+'][orderby]" id="'+ sliderId +'_' + newNum +'_slide_title" style="width:320px"> \
				<option value="2">Date (Newer to older)</option> \
				<option value="1" selected="selected">Custom Ordering</option> \
			</select> <small>Date option is default. Custom Ordering allows you to specify your ordering for posts via "Posts Ordering" section</small> \
		<br style="clear:both"><br><label class="title">Thumbnail Caption in Post Type Overview Page</label> \
		<input type="hidden" class="checkbox aq-input" name="'+ sliderId +'['+newNum+'][showtitle]" value="0"/> \
		<div class="ibuttonwrap"><input type="checkbox" class="checkbox of-input ibutton" name="'+ sliderId +'['+newNum+'][showtitle]" value="1" /></div><span style="float:left;margin:5px 0 0 5px">Show Title</span><br class="clear:both"><br> \
		<input type="hidden" class="checkbox aq-input" name="'+ sliderId +'['+newNum+'][showexcerpt]" value="0"/> \
		<div class="ibuttonwrap"><input type="checkbox" class="checkbox of-input ibutton" name="'+ sliderId +'['+newNum+'][showexcerpt]" value="1" /></div><span style="float:left;margin:5px 0 0 5px">Show Excerpt</span><br class="clear:both"><br> \
		<input type="hidden" class="checkbox aq-input" name="'+ sliderId +'['+newNum+'][showcategorypost]" value="0"/> \
		<div class="ibuttonwrap"><input type="checkbox" class="checkbox of-input ibutton" name="'+ sliderId +'['+newNum+'][showcategorypost]" value="1" /></div><span style="float:left;margin:5px 0 0 5px">Show Category</span><br class="clear:both"><br> \
		<input type="hidden" class="checkbox aq-input" name="'+ sliderId +'['+newNum+'][showdate]" value="0"/> \
		<div class="ibuttonwrap"><input type="checkbox" class="checkbox of-input ibutton" name="'+ sliderId +'['+newNum+'][showdate]" value="1" /></div><span style="float:left;margin:5px 0 0 5px">Show Date</span><br class="clear:both"><br> \
		<br><label class="title">Thumbnail Caption Replacement</label> \
		<select class="slide of-input" name="'+ sliderId +'['+newNum+'][thumbnailcaption]" id="'+ sliderId +'_' + newNum +'_slide_title" style="width:320px"> \
				<option value="Inside">Inside</option> \
				<option value="Below" selected="selected">Below</option> \
				<option value="None">None</option> \
			</select> \
		<br style="clear:both"><label class="title">Thumbnail Font & BG Color</label> \
		<div class="colorSelector"><div style="background-color: #000"></div></div> \
		<input class="of-color" name="'+ sliderId +'['+newNum+'][thumbbgcolor]" type="text" value="#000" /><small style="margin: 1px 0 0 5px; \
display: inline-block;">BG Color</small> \
		<br class="clear"><div class="colorSelector"><div style="background-color: #fff"></div></div> \
		<input class="of-color" name="'+ sliderId +'['+newNum+'][thumbfontcolor]" type="text" value="#fff" /><small style="margin: 1px 0 0 5px; \
display: inline-block;">Font Color</small> \
		<input type="hidden" class="checkbox aq-input" name="'+ sliderId +'['+newNum+'][thumbbgtransparent]" value="0"/> \
		<br style="clear:both"><br><div class="ibuttonwrap"><input type="checkbox" class="checkbox of-input ibutton" name="'+ sliderId +'['+newNum+'][thumbbgtransparent]" value="0" /></div> \
		<span style="float:left;margin:5px 0 0 5px">Transparent Thumbnail Overlay</span><br class="clear:both"><br> \
		<br style="clear:both"><br><small>This option allows you to hide categories in single custom post pages</small> \
		<br style="clear:both"><h3>RELATED POSTS SETTINGS</h3> \
		<br><input type="hidden" class="checkbox aq-input" name="'+ sliderId +'['+ newNum +'][related_switch]" id="'+sliderId+'_'+newNum+'_related" value="0"/> \
		<div class="ibuttonwrap"><input type="checkbox" class="checkbox of-input ibutton" name="'+ sliderId +'['+ newNum +'][related_switch]" value="1"  /></div><span style="float:left;margin:5px 0 0 5px">Display Related Posts</span> \
		<br style="clear:both"><br><label>Title</label><input class="slide of-input" name="'+ sliderId +'['+ newNum +'][related_title]" id="'+sliderId+'_'+newNum+'_slide_title" value="" /><small>E.g. RELATED POSTS</small> \
		<br style="clear:both"><label>Related Posts Display Limit</label> \
		<input class="slide of-input" name="'+ sliderId +'['+ newNum +'][related_postlimit]" id="'+ sliderId +'_'+ newNum +'_slide_title" value="" /><small>Allows you to specify a limit for pagination. By default, it\'s 0 (unlimited)</small> \
		<br><input type="hidden" class="checkbox aq-input" name="'+ sliderId +'['+ newNum +'][related_category]" id="'+sliderId+'_'+newNum+'_related" value="0"/> \
		<div class="ibuttonwrap"><input type="checkbox" class="checkbox of-input ibutton" name="'+ sliderId +'['+ newNum +'][related_category]" value="1" /></div><span style="float:left;margin:5px 0 0 5px">Show Posts from Same Category</span> \
		<br class="clear"><br><small>If this option is switched on, only the posts with the same category will be displayed. Otherwise, all posts will be listed regardless their category</small> \
		<input type="hidden" class="checkbox aq-input" name="'+ sliderId +'['+ newNum +'][related_random]" id="'+sliderId+'_'+newNum+'_random" value="0"/> \
		<div class="ibuttonwrap"><input type="checkbox" class="checkbox of-input ibutton" name="'+ sliderId +'['+ newNum +'][related_random]" value="1" /></div><span style="float:left;margin:5px 0 0 5px">Random Posts</span> \
		<br class="clear"><br><small>Turn on this feature to display random posts</small> \
		<br><hr><h3>STEP 2 : CUSTOM FIELD VALUES<br><small>* All fields are required</small></h3><label class="title">Post Type Name</label> \
		<input class="slide of-input of-slider-title" name="'+ sliderId +'['+newNum+'][title]" id="'+ sliderId +'_' + newNum +'_slide_title" value="" /><small>Post name must contain only letters and/or numbers.<br>E.g. : <strong>portfolio</strong></small> \
		<label class="title">Singular Post name</label> \
		<input class="slide of-input" name="'+ sliderId +'['+newNum+'][singular]" id="'+ sliderId +'_' + newNum +'_slide_title" value="" /><small>E.g. : <strong>Project</strong></small> \
		<label class="title">Plural Post name</label> \
		<input class="slide of-input" name="'+ sliderId +'['+newNum+'][plural]" id="'+ sliderId +'_' + newNum +'_slide_title" value="" /><small>This also will be your project overview page title<br>E.g. : <strong>Projects</strong> or <strong>Portfolio</strong></small> \
		<label class="title">Slug</label> \
		<input class="slide of-input" name="'+ sliderId +'['+newNum+'][slug]" id="'+ sliderId +'_' + newNum +'_slide_title" value="" /> <small>Allows you to set your post type URL. By default, it\'s your Post Name. <br>E.g. : <strong>portfolio</strong><br>URLs will be displayed like -> /portfolio/my-project-title</strong></small>	\
		<hr><h3>STEP 3 : CATEGORY SETTINGS<br><small>* All fields are required</small></h3><label class="title">Category Name</label> \
		<input class="slide of-input" name="'+ sliderId +'['+newNum+'][categoryname]" id="'+ sliderId +'_' + newNum +'_slide_title" value="" /><small>Category name of your post type. <br>E.g. : <strong>Creative Fields</strong></small>	\
		<label class="title">New Category Title</label> \
		<input class="slide of-input" name="'+ sliderId +'['+newNum+'][categorytitle]" id="'+ sliderId +'_' + newNum +'_slide_title" value="" /><small>E.g. : <strong>Add New Field</strong></small> \
		<label class="title">Single Category Name</label> \
		<input class="slide of-input" name="'+ sliderId +'['+newNum+'][categorysingletitle]" id="'+ sliderId +'_' + newNum +'_slide_title" value="" /><small>E.g. : <strong>Field</strong></small> \
		<label class="title">Category Slug</label> \
		<input class="slide of-input" name="'+ sliderId +'['+newNum+'][categoryslug]" id="'+ sliderId +'_' + newNum +'_slide_title" value="" /><small>Allows you to set your category URL. <br>E.g. : <strong>field</strong><br>URLs will be displayed like -> /field/videos</strong></small>	\
		<a class="slide_delete_button" data-w="posttype" href="#">Delete</a><div class="clear"></div></div></li>';
		
		
		slidesContainer.append(newSlide);
		
	    jQuery("input.ibutton").iButton();
	
		$('.temphide').fadeIn('fast', function() {
			$(this).removeClass('temphide');
		});
				
		of_image_upload(); // re-initialise upload image..
		
		return false; //prevent jumps, as always..
	});	
	
	
	
	
	
	
	//Sort slides
	jQuery('.sliderordering').find('ul').each( function() {
		var id = jQuery(this).attr('id');
		$('#'+ id).sortable({
			placeholder: "placeholder",
			opacity: 0.6
		});	
	});
	
	
	/**	Sorter (Layout Manager) */
	jQuery('.sorter').each( function() {
		var id = jQuery(this).attr('id');
		$('#'+ id).find('ul').sortable({
			items: 'li',
			placeholder: "placeholder",
			connectWith: '.sortlist_' + id,
			opacity: 0.6,
			update: function() {
				$(this).find('.position').each( function() {
				
					var listID = $(this).parent().attr('id');
					var parentID = $(this).parent().parent().attr('id');
					parentID = parentID.replace(id + '_', '')
					var optionID = $(this).parent().parent().parent().attr('id');
					$(this).prop("name", optionID + '[' + parentID + '][' + listID + ']');
					
				});
			}
		});	
	});
	
	
	/**	Ajax Backup & Restore MOD */
	//backup button
	$('#of_backup_button').live('click', function(){
	
		var answer = confirm("Click OK to backup your current saved options.")
		
		if (answer){
	
			var clickedObject = $(this);
			var clickedID = $(this).attr('id');
					
			var nonce = $('#security').val();
		
			var data = {
				action: 'of_ajax_post_action',
				type: 'backup_options',
				security: nonce
			};
						
			$.post(ajaxurl, data, function(response) {
							
				//check nonce
				if(response==-1){ //failed
								
					var fail_popup = $('#of-popup-fail');
					fail_popup.fadeIn();
					window.setTimeout(function(){
						fail_popup.fadeOut();                        
					}, 2000);
				}
							
				else {
							
					var success_popup = $('#of-popup-save');
					success_popup.fadeIn();
					window.setTimeout(function(){
						location.reload();                        
					}, 1000);
				}
							
			});
			
		}
		
	return false;
					
	}); 
	
	
	//restore button
	$('#of_restore_button').live('click', function(){
	
		var answer = confirm("'Warning: All of your current options will be replaced with the data from your last backup! Proceed?")
		
		if (answer){
	
			var clickedObject = $(this);
			var clickedID = $(this).attr('id');
					
			var nonce = $('#security').val();
		
			var data = {
				action: 'of_ajax_post_action',
				type: 'restore_options',
				security: nonce
			};
						
			$.post(ajaxurl, data, function(response) {
			
				//check nonce
				if(response==-1){ //failed
								
					var fail_popup = $('#of-popup-fail');
					fail_popup.fadeIn();
					window.setTimeout(function(){
						fail_popup.fadeOut();                        
					}, 2000);
				}
							
				else {
							
					var success_popup = $('#of-popup-save');
					success_popup.fadeIn();
					window.setTimeout(function(){
						location.reload();                        
					}, 1000);
				}	
						
			});
	
		}
	
	return false;
					
	});
	
	/**	Ajax Transfer (Import/Export) Option */
	$('#of_import_button').live('click', function(){
	
		var answer = confirm("Click OK to import options.")
		
		if (answer){
	
			var clickedObject = $(this);
			var clickedID = $(this).attr('id');
					
			var nonce = $('#security').val();
			
			var import_data = $('#export_data').val();
		
			var data = {
				action: 'of_ajax_post_action',
				type: 'import_options',
				security: nonce,
				data: import_data
			};
						
			$.post(ajaxurl, data, function(response) {
				var fail_popup = $('#of-popup-fail');
				var success_popup = $('#of-popup-save');
				
				//check nonce
				if(response==-1){ //failed
					fail_popup.fadeIn();
					window.setTimeout(function(){
						fail_popup.fadeOut();                        
					}, 2000);
				}		
				else 
				{
					success_popup.fadeIn();
					window.setTimeout(function(){
						location.reload();                        
					}, 1000);
				}
							
			});
			
		}
		
	return false;
					
	});
	
	
	
	/**	Ajax Transfer (Import/Export) Option */
	$('#of_migrate_button').live('click', function(){
	
		var answer = confirm("Click OK to replace URLs")
		
		if (answer){
	
			var clickedObject = $(this);
			var clickedID = $(this).attr('id');
					
			var nonce = $('#security').val();
			
			var import_data = $('input[name=md_migrate_old]').val();
			var import_data2 = $('input[name=md_migrate_new]').val();
		
			var data = {
				action: 'of_ajax_post_action',
				type: 'migrate_works',
				security: nonce,
				oldlink: import_data,
				newlink: import_data2
			};
						
			$.post(ajaxurl, data, function(response) {
				var fail_popup = $('#of-popup-fail');
				var success_popup = $('#of-popup-save');
				//check nonce
				if(response==-1){ //failed
					fail_popup.fadeIn();
					window.setTimeout(function(){
						fail_popup.fadeOut();                        
					}, 2000);
				}		
				else 
				{
					success_popup.fadeIn();
					window.setTimeout(function(){
						location.reload();                        
					}, 1000);
				}
							
			});
			
		}
		
	return false;
					
	});
	
	
	
	/** AJAX Save Options */
	$('#of_save').live('click',function() {
			
		var nonce = $('#security').val();
					
		$('.ajax-loading-img').fadeIn();
		
		//get serialized data from all our option fields			
		var serializedReturn = $('#of_form :input[name][name!="security"][name!="of_reset"]').serialize();
						
		var data = {
			type: 'save',
			action: 'of_ajax_post_action',
			security: nonce,
			data: serializedReturn
		};
					
		$.post(ajaxurl, data, function(response) {
			var success = $('#of-popup-save');
			var fail = $('#of-popup-fail');
			var loading = $('.ajax-loading-img');
			loading.fadeOut();  
			
			success.fadeIn();
			window.setTimeout(function(){
				window.location=response;
				//success.fadeOut(); 
				//fail.fadeOut();				
			}, 1000);
			
			/*			
			if (response==1) {
				success.fadeIn();
			} else { 
				fail.fadeIn();
			}
						
			window.setTimeout(function(){
				success.fadeOut(); 
				fail.fadeOut();				
			}, 2000);
			*/
		});
			
	return false; 
					
	});   
	
	
	/**	Move Posts Option */
	$('#of_movepost_button').live('click', function(){
	
		var answer = confirm("Click OK to move posts")
		
		if (answer){
	
			var clickedObject = $(this);
			var clickedID = $(this).attr('id');
					
			var nonce = $('#security').val();
			
			var import_data = $('select[name=md_movepost_old]').val();
			var import_data2 = $('select[name=md_movepost_new]').val();
		
			var data = {
				action: 'of_ajax_post_action',
				type: 'movepost_works',
				security: nonce,
				oldpost: import_data,
				newpost: import_data2
			};
						
			$.post(ajaxurl, data, function(response) {
				var fail_popup = $('#of-popup-fail');
				var success_popup = $('#of-popup-save');
				//check nonce
				if(response==-1){ //failed
					fail_popup.fadeIn();
					window.setTimeout(function(){
						fail_popup.fadeOut();                        
					}, 2000);
				}		
				else 
				{
					success_popup.fadeIn();
					window.setTimeout(function(){
						location.reload();                        
					}, 1000);
				}
							
			});
			
		}
		
	return false;
					
	});
	
	
	
	/* AJAX Options Reset */	
	$('#of_reset').click(function() {
		
		//confirm reset
		var answer = confirm("Click OK to reset. All settings will be lost and replaced with default settings!");
		
		//ajax reset
		if (answer){
			
			var nonce = $('#security').val();
						
			$('.ajax-reset-loading-img').fadeIn();
							
			var data = {
			
				type: 'reset',
				action: 'of_ajax_post_action',
				security: nonce,
			};
						
			$.post(ajaxurl, data, function(response) {
				var success = $('#of-popup-reset');
				var fail = $('#of-popup-fail');
				var loading = $('.ajax-reset-loading-img');
				loading.fadeOut();  
							
				if (response==1)
				{
					success.fadeIn();
					window.setTimeout(function(){
						location.reload();                        
					}, 1000);
				} 
				else 
				{ 
					fail.fadeIn();
					window.setTimeout(function(){
						fail.fadeOut();				
					}, 2000);
				}
							

			});
			
		}
			
	return false;
		
	});


	/**	Tipsy @since v1.3 */
	if (jQuery().tipsy) {
		$('.typography-size, .typography-height, .typography-face, .typography-style, .of-typography-color').tipsy({
			fade: true,
			gravity: 's',
			opacity: 0.7,
		});
	}
	
}); //end doc ready