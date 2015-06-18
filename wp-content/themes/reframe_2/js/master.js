(function($){
	
	// MINIMUM HEIGHT ADJUSTMENT
	var columncountmaster = scvars.thumbcount;	
	var columncount = scvars.thumbcount;
	var $container = $('.projectimages');
	var initialwidth = $(window).width();
	
	var fixed_thumbsval = scvars.fixed_thumbs;
	var custompost_transition = scvars.custompost_transition;
	var showbw = scvars.showbw;
	
	var pagination_type = scvars.pagination_type;
	var disableinfinite = 0;
	
	if(pagination_type=='loadmore' || pagination_type=='paginate') {
		disableinfinite = 1;
	}
	
	var total_column = scvars.total_width;
	var total_gutter = scvars.total_padding;
	
	
	/// DETECT MOBILE
	var $doc = $(document),
	Modernizr = window.Modernizr;
	
	/// VARS
	var loaded = false;
	
	/// BACK BUTTONS ACTIVE
	$(window).bind('popstate', function(event) {
		var dlink = document.URL;
		dlink = dlink.split('#');
		//if (!Modernizr.touch) {
			if(!loaded) {
				loaded = true;
				return;	
			}else{
				if (typeof dlink[1] == 'undefined' || typeof dlink[1] == '') {
					window.location =location.pathname;
				}
			}
		//}
	});
	
	
	/// CHECK CPT
	
	function check_cpt(v1,v2,v3,v4) {
		columncountmaster = v1;
		columncount = v1;
		total_column = v2;
		total_gutter = v3;
		fixed_thumbsval = v4;
		if(columncountmaster==1) {
			$('.projectimages .box').css('width','100%');
		}else{
			$('.projectimages .box').css('width',(v2/v1)+'%');
		}
	}
		
	/// UPDATE LINKS
	var bid = 1;
	
	function updatelinks(m) { 
		if(history.pushState && history.replaceState && !screenfull.element) {
			bid++;
			history.pushState({"id":bid}, '', m);
		}	
	}
	
	
  	  // modified Isotope methods for gutters in masonry
      $.Isotope.prototype._getMasonryGutterColumns = function() {
		var gutter = this.options.masonry && this.options.masonry.gutterWidth || 0;
			containerWidth = this.element.width();
	  
		this.masonry.columnWidth = this.options.masonry && this.options.masonry.columnWidth ||
					  // or use the size of the first item
					  this.$filteredAtoms.outerWidth(true) ||
					  // if there's no items, use size of container
					  containerWidth;
	
		this.masonry.columnWidth += gutter;
	
		this.masonry.cols = Math.floor( ( containerWidth + gutter ) / this.masonry.columnWidth );
		this.masonry.cols = Math.max( this.masonry.cols, 1 );
	  };
	
	  $.Isotope.prototype._masonryReset = function() {
		// layout-specific props
		this.masonry = {};
		// FIXME shouldn't have to call this again
		this._getMasonryGutterColumns();
		var i = this.masonry.cols;
		this.masonry.colYs = [];
		while (i--) {
		  this.masonry.colYs.push( 0 );
		}
	  };
	
	  $.Isotope.prototype._masonryResizeChanged = function() {
		var prevSegments = this.masonry.cols;
		// update cols/rows
		this._getMasonryGutterColumns();
		// return if updated cols/rows is not equal to previous
		return ( this.masonry.cols !== prevSegments );
	  };
	
	
	
		
	function updateinfoAlign() {
		$('.projectimages .box strong.info').each(function() { 
			$(this).css('margin-top',-($(this).height()/2));
		});
	}
	
	
	Galleria.loadTheme(scvars.tempdir + '/js/galleria/galleria.classic.js');
	
	/// SLIDERS
	function reviveSliders() { 
		
		 if ( $.browser.mozilla && scvars.flexanimation=='slide') {
			 var useCSSval = false;
		 }else{
			 var useCSSval = true;
		 }
		
		activateswipebox();
			
		$('.flexslider').fitVids().flexslider({
			animation: scvars.slider_anim_type,
			animationSpeed: scvars.slider_fade_duration,
			slideshowSpeed: scvars.slider_duration,
			slideshow: Number(scvars.slider_autostart),
			useCSS: useCSSval,
			pauseText: "<i class=\"icon-pause\"></i>",
			playText: "<i class=\"icon-play\"></i>", 
			prevText: "<i class=\"useicon\"><</i>",
			nextText: "<i class=\"useicon\">></i>"
		});
		
		
		var galtiming = parseInt(scvars.gallery_slideshow_speed);
		
	   Galleria.run('.galleria', {
			autoplay:galtiming,
			preload : scvars.gallery_preload,
			transition: scvars.gallery_transition,
			transitionSpeed : scvars.gallery_transition_speed,
			debug:false,
			maxScaleRatio:1,
			youtube:{
				modestbranding: 1,
				autohide: 1,
				color: 'white',
				hd: 1,
				rel: 0,
				showinfo: 0
			},
			vimeo:{
				title: 0,
				byline: 0,
				portrait: 0,
				color: 'aaaaaa'
			},
			extend: function() {
				
				var gallery = this; // "this" is the gallery instance
				var gallery2 = $(this.get('stage')).parent().parent().parent().find('.gallery_fullscreen');
				
				$(gallery2).click(function() {
					gallery.toggleFullscreen(); // call the play method
				});
			},
			imageCrop: scvars.gallery_crop
		});
		
	}
	
	reviveSliders();
	
	
		
	//// MENU FLOAT
	function mainmenuFloat() {
		
		if(scvars.removeheader==1) {
			var martop = 70;	
		}else{
			var martop = 40;	
		}
		if(scvars.thisisfullslider!=1) {
			$('section.leftmenu').stickyMojo({footerID: 'footer', contentID: '#main', topMarg:martop});
		}
	}
	
	//// PROJECT INFO FLOAT
	function projectinfoFloat() {
		
		if($('#post-list').length > 0) {
				var dist = '#post-list'
		}else{
				var dist = 'footer'
		}
		
		if(scvars.thisisfullslider!=1) {
			$('.workspost .projectinfo .wrapmsg').stickyMojo({footerID: dist, contentID: '#main', topMarg:30});
		}
	}
	
	
	
	/// LOAD SOCIAL SHARING PLUGINS
	function socialRevive() {
		$.ajax({ url: 'http://platform.twitter.com/widgets.js', dataType: 'script', cache:true});
		$.ajax({ url: 'http://platform.tumblr.com/v1/share.js', dataType: 'script', cache:true});
		$.ajax({ url: 'http://assets.pinterest.com/js/pinit.js', dataType: 'script', cache:true}); 
		$.ajax({ url: 'https://apis.google.com/js/plusone.js', dataType: 'script', cache:true}); 
	}
	
	/// RESPONSIVE IMG
	if(scvars.home_full==1) {
		var resimgw = 961;	
	}else{
		var resimgw = 767;	
	}
	
	function responsiveIMG() {
			$('.projectimages img').each(function() { 
				var smalls = $(this).attr('data-small');
				var large = $(this).attr('data-large');
				if($(window).width() < resimgw) {
					$(this).attr('src',large);
				}else{
					$(this).attr('src',smalls);
				}
			});
			updateinfoAlign();
			triggerBW();
	}
	
	
	/// PROJECT LOAD CALLBACK
	function loadProject(data,murl) {
			//$('#singlecontent').hide().html(data).fadeIn('normal');
			$(".fitvids").fitVids();
			showLoader(0);
			//$('#post-list').remove();
			socialRevive(); 
			reviveSliders();
			updatelinks(murl);
			
			mainmenuFloat();
			isoTheme(1);
			projectinfoFloat();
			updateinfoAlign();
	}
		/// PROJECT LOAD CALLBACK
	function loadProjectFirst(w) {
	
			if((scvars.home_full!=1)) {
				if(scvars.works_full==1 && w==-1) {
					$('.main_leftmenu').addClass('hideit').hide();
				}else{
					$('.main_leftmenu').removeClass('hideit').show();
				} 
			}
			
	}
	
	
	function triggerBW() { 
		
		var showbws = 1;
		
		if ($.browser.msie && $.browser.version < 9.0) {
			showbws = 0
		}
		
		if(showbws) {
			$('.bwWrapper').BlackAndWhite({
				hoverEffect : true, // default true
				// set the path to BnWWorker.js for a superfast implementation
				webworkerPath : false,
				// for the images with a fluid width and height 
				responsive:true,
				// to invert the hover effect
				invertHoverEffect: false,
				// this option works only on the modern browsers ( on IE lower than 9 it remains always 1)
				intensity:1,
				speed: { //this property could also be just speed: value for both fadeIn and fadeOut
					fadeIn: 200, // 200ms for fadeIn animations
					fadeOut: 800 // 800ms for fadeOut animations
				},
				onImageReady:function(img) {
					// this callback gets executed anytime an image is converted
				}
			});
		}
	}
	
	
	if(showbw == 1) {
		$('.projectimages').imagesLoaded(function(){
			triggerBW();
		});
	}


	//// ISOTOPE WORKS
	function isoTheme(wt) {	
		
		$(".fitvids").fitVids();
		var $boxcontainer = $('.projectimages');
		
		if(scvars.home_full==1) {
			var tabletw = 760;
		}else{
			var tabletw = 650;
		}
		
		columncount = scvars.thumbcount;
		
		if($boxcontainer.width() < tabletw && $boxcontainer.width() > 420) {
				columncount = 2;
			}else if($boxcontainer.width() < 421) {
				columncount = 1;
		}
			
		if(fixed_thumbsval !=1 && $boxcontainer.length > 0) {
			
			// COLUMN MARGIN ADJUSTMENT
				//$('.box:nth-child('+columncount+'n+'+columncount+')').addClass('odd');
				//$('.projectimages .box').hide();
			
			if((columncount > 1)) {
				$boxcontainer.imagesLoaded( function(){
					//$('.projectimages .box').fadeIn();
					
					$('.box').css('left',0).css('top',0).css('position','absolute');
				
					var bwidth = ($boxcontainer.width());
					
					var conw = Math.floor(((bwidth/100) * total_column) / columncount);
					var gw = Math.floor(((bwidth/100)*total_gutter) / (columncount-1));
					
					if(columncount==1) {
						var gwe = 20;
					}else{
						var gwe = gw;
					}
					
					
					$('.box').addClass('odd').css('margin-bottom',gwe);
					
						$boxcontainer.isotope({
						  itemSelector : '.box',
						  masonry: {
							columnWidth: conw,
							gutterWidth : gw
						  }
						}, function() { 
						if(custompost_transition!=1) {
							$('.box').addClass('effects');
						}
						setTimeout("$('.box').fadeIn('normal',function() { \
							$('.box').removeClass('initialize'); \
						}); \
						$('#masterajaxloader').fadeOut();",500); 
						});
						
						// filter items when filter link is clicked
						$('.btopcategories a').click(function(e){
						  var selector = $(this).data('filter');
						  var tax = $(this).data('tax');
						  if(tax!=1) { 
						  	$('.btopcategories a').removeClass('selected');
						  	$(this).addClass('selected');
						  	$boxcontainer.isotope({ filter: selector });
						  	e.preventDefault();
						  }
						});
						
								
				});
			}else{
				$('.box').fadeIn('normal',function() {
					$('.box').removeClass('initialize');
				});
				$('#post-list .box').removeAttr('style');
				$('.projectimages').css('height','auto');
				
				$('.btopcategories a').unbind( "click" );
				
			}
			
			if($('nav#page_nav').length > 0 && disableinfinite!=1 && wt!=1) {
				
				 $boxcontainer.infinitescroll({
					navSelector  : '#page_nav',    // selector for the paged navigation 
					nextSelector : '#page_nav a',  // selector for the NEXT link (to page 2)
					itemSelector : '.box',     // selector for all items you'll retrieve
					extraScrollPx: 0,
					loading: {
						finishedMsg : '',
						img: scvars.tempdir+'/images/ajaxloader.gif'
					  }
					},
					// call Isotope as a callback
					function ( newElements ) {
						if(columncount > 1) {
							  var $newElems = jQuery( newElements ); // hide to begin with
							  // ensure that images load before adding to masonry layout
							  $newElems.imagesLoaded(function(){
								$newElems.fadeIn(); // fade in when ready
								$boxcontainer.isotope( 'appended', $newElems );
								isoTheme(1);
							  });
	
						}
								
					}
				  );
			  
			}
	 	
	   }else{
		   
		   if($('nav#page_nav').length > 0 && disableinfinite!=1) {
			 
				$boxcontainer.infinitescroll({
					navSelector  : '#page_nav',    // selector for the paged navigation 
					nextSelector : '#page_nav a',  // selector for the NEXT link (to page 2)
					itemSelector : '.box',     // selector for all items you'll retrieve
					loading: {
						finishedMsg : '',
						img: scvars.tempdir+'/images/ajaxloader.gif',
						finishedMsg: "",
						msg: '',
						msgText: ''
					  }
					},function(newElements) {
						 
						 $('nav#page_nav,#infscr-loading').remove();
						 $boxcontainer.append(newElements);
						 $('.box').removeClass('odd');
						 $('.box').fadeIn('normal',function() {
							$('.box').removeClass('initialize');
						});
						 if($('.projectimages').width() < 960) {
						 	$('.box:nth-child(2n+2)').addClass('odd');
						 }else{
						 	$('.box:nth-child('+columncount+'n+'+columncount+')').addClass('odd');
						 }
					}
				  ); 
		   }
		   
	   }
		
	}	
	
	
	/// SHOW LOADER 
	function showLoader(w) {
		if(w==1) {
			$('#masterajaxloader').fadeIn();
			$('.footerlogo img').fadeOut();
		}else{
			$('#masterajaxloader').fadeOut();
			$('.footerlogo img').fadeIn();
		}
	}
	
	// FIX MIN HEIGHT
	function fixtheheight(w) { 
		//$('#maincontainer, .container').css('min-height',($(window).height()-w)+'px');
	}
	
	fixtheheight(scvars.withborder);
  
	
	/// PROJECT LOAD CALLBACK
	function activateswipebox() { 
	
		if(scvars.disablelightbox!=1) {
		
				var getthumbnails = jQuery(".defaultpage a:has(img), .postwraps a:has(img), .blogpage a:has(img)").not(".nolightbox").filter( function() { return /\.(jpe?g|png|gif|bmp)$/i.test(jQuery(this).attr('href')) });
				getthumbnails.attr("data-light","swipebox");
				jQuery(".gallery-item a:has(img)").attr("data-light","swipebox");
				
				jQuery(".gallery-item").addClass("border-color");
				//jQuery(".gallery-item").addClass("border");
				//jQuery(".gallery-item").addClass("border-radius");
		
			
			$("[data-light=swipebox]").swipebox();
		}
		
	}
	
		
		
	//// ONLOAD	
	$(function(){
		
		///	BACK TO TOP
		$(window).scroll(function() {
			if($(this).scrollTop() > 800) {
				//if (!Modernizr.touch) {
					$('a.backtotop').fadeIn();
				//}
			} else {
				//if (!Modernizr.touch) {
				$('a.backtotop').fadeOut();
				//}
			}
		});
		$('body').on('click','a.backtotop',function(e) { 
			$('html, body').animate({scrollTop:0}, 1000, "easeInOutExpo"); 
			e.preventDefault(); 
		});
		
		
		
		/// LEFT MENU ACCORDION	
		var allPanels = $('section.leftmenu .main-nav ul.sub-menu');
			
		$('section.leftmenu .main-nav a[href=#]').click(function() {
			if($(this).next().is(":hidden") && $(this).parent().parent().hasClass('sub-menu')) {
				$(this).next().slideDown();
			}else if($(this).next().is(":hidden")){
				allPanels.slideUp();
				$(this).next().slideDown();
			}
			return false;
		});
		  
		/// MOBILE MENU
		$('body').on('change','select.mobilemenu-select',function() { 
			var gourl = $(this).val();
			if(gourl!='#') { 
				window.location=gourl;
			}
		})
		
		/// TABS
		$(document).foundationTabs();
		
		/// CLOSE ALERT
		$('body').on('click','.closealert', function(e) { 
			$(this).parent().slideUp(); 
			e.preventDefault();
		})
		 
		  
	  	/// INFINITE SCROLL FOR BLOG
		if($('nav#page_nav').length > 0 && $('.bloglistcontainer').length > 0 && disableinfinite!=1) {
		   
			$('.bloglistcontainer').infinitescroll({
				navSelector  : '#page_nav',    // selector for the paged navigation 
				nextSelector : '#page_nav a',  // selector for the NEXT link (to page 2)
				itemSelector : '.blogbox',     // selector for all items you'll retrieve
				loading: {
					finishedMsg : '',
					img: scvars.tempdir+'/images/ajaxloader.gif',
					finishedMsg: "",
					msg: '',
					msgText: ''
				  }
				},
				function(arrayOfNewElems)
				{
					reviveSliders();
					$(".fitvids").fitVids();
				}
			  );   
		}
		
		
		
		// MENU FOLLOWS
		mainmenuFloat();
		projectinfoFloat();
		
		/// RESPONSIVE IMG
		responsiveIMG();
	
		/// ISOTOPE/MASONRY
		if(columncountmaster > 1) {
			if($('.projectimages').width() > 420) {
				isoTheme();
			}else{
				$('.box').removeClass('initialize').show();
			}
		}else{
			$('.box').removeClass('initialize').show();
		}
		
		/// RE-ARRANGE ODD CLASSES FOR FIXED VIEW
		function addoddclass() { 
			if(fixed_thumbsval == 1) {
				
				var columncount = columncountmaster;
				
				if($(window).width() > 420 && $(window).width() < 960) {
						columncount = 2;
					}else if($(window).width() < 421) {
						columncount = 1;
				}
				
				$('.box').removeClass('odd');
				$('.box:nth-child('+columncount+'n+'+columncount+')').addClass('odd');
			}
		}
		
		
		$(window).smartresize(function(){
			if(columncountmaster > 1) {
				isoTheme();
			}	
							
			responsiveIMG();			
			/// RE-ARRANGE ODD
			addoddclass();
		});
		
		/// RE-ARRANGE ODD
		addoddclass();
		
		// SCROLLBAR
		if(scvars.nicescroll!=1) {
			if(scvars.thisisfullslider!=1) {
				$("body").niceScroll({
					cursorwidth : 10,
					cursoropacitymin:.6,
					cursorborder:0,
					cursorborderradius : 0,
					scrollspeed:40,
					cursorcolor: scvars.scrollbarcolor
				});
			}
		}

	
		/// RESPONSIVE VIDEO
		$(".fitvids").fitVids();

		
	
		if(scvars.withajax==1) {
			
			/// GET POSTS
			$('body').on('click','a.getworks',function(e) { 
				var id = $(this).attr('data-id');
				var token = $(this).attr('data-token');
				var murl = $(this).attr('href');
				var type = $(this).attr('data-type');
				var homeurl = $(this).data('home');
				
				$('html, body').animate({scrollTop:0}, 'slow', "easeInOutExpo");
				showLoader(1);
				
				$.post(murl,function(data) { 
				
					$('#loadintothis').fadeOut('normal',function() { 
						
						var div = $('#loadintothis', $(data)).html();
						
						loadProjectFirst(-1);
						
						$('#loadintothis').html(div).fadeIn('normal',function() { 
							loadProject(data,murl);
						});
						
					});
				});
				
				e.preventDefault();
			});
			
			
			/// MENU NAVIGATION
			
			$('body').on('click','.main-nav a[data-rel=menuloader]',function(e) { 
				var el = $(this);
				var token = $(this).attr('data-token');
				var types = $(this).attr('data-type');
				var slug = $(this).attr('data-slug');
				var cpt = $(this).attr('data-cpt');
				cpt = cpt.split('-');
				var murl = $(this).attr('href');
				var mpost = $(this).data('post');
				
				var type = types.split('-',1);
				
				var el2 = $('.projectimages');
				
				$('html, body').animate({scrollTop:0}, 'slow', "easeInOutExpo");
				
				showLoader(1);
					
				$.post(murl,function(data) { 
				
					$('#loadintothis').fadeOut('normal',function() { 
						
						var div = $('#loadintothis', $(data)).html();
							
						var ns=types.indexOf("-categories");
						
						loadProjectFirst(ns);
								
						$('#loadintothis').html(div);
								
						if (cpt instanceof Array) {
							check_cpt(cpt[0],cpt[1],cpt[2],cpt[3]);
						}
									
						$('#loadintothis').fadeIn('normal',function() { 
						 					
									
									el2.remove();
									
									el.parent().parent().find('a').removeClass('current-menu');
									el.addClass('current-menu');
									
									showLoader(0)
									responsiveIMG();
									isoTheme();
									updatelinks(murl);
									projectinfoFloat();
						
						});
					});
				});
				
				if($('.projectimages').length > 0 || $('.workspost').length > 0) {	
					e.preventDefault();
				}
			});	
			
			
			
			
				
			/// GO HOME
			$('body').on('click','a.gohome',function(e) { 
				var token = $(this).attr('data-token');
				var type = $(this).attr('data-type');
				var murl = $(this).attr('href');
				
				var el = $('#singlecontent');
				
				$('html, body').animate({scrollTop:0}, 'slow', "easeInOutExpo");
				
				showLoader(1);
					
						
					$.post(murl,function(data) { 
					
						$('#loadintothis').fadeOut('normal',function() { 
							
							var div = $('#loadintothis', $(data)).html();
							
							loadProjectFirst(); 
								
							if(scvars.home_full==1) {
								$('.main_leftmenu').addClass('hideit').hide();
							}else{
								$('.main_leftmenu').removeClass('hideit').show();
								mainmenuFloat();
							}
							
							$('#loadintothis').html(div).fadeIn('normal',function() { 
				
									el.remove();
									$(".fitvids").fitVids();
									showLoader(0)
									socialRevive();
									responsiveIMG();
									
									if($('#post-list').width() > 419) {
										isoTheme();
									}
									updatelinks(murl);
											
								
							});
						});
					});
							
				e.preventDefault();
			});	
			
			
			
				
			/// GET POSTS
			$('body').on('click','#post-list nav#page_nav a',function(e) { 
			
				var murl = $(this).attr('href');
				
				$(this).remove();
				
				var columncount = columncountmaster;
				
				if($('.projectimages').width() > 420 && $('.projectimages').width() < 650) {
						columncount = 2;
					}else if($('.projectimages').width() < 421) {
						columncount = 1;
				}
					
				$.post(murl,function(data) { 
				
					var div = $('.projectimages', $(data)).html();
					var navdiv = $('#post-list nav', $(data)).html();
					
					if($('#post-list').width() < 421) {
						$('.projectimages').append(div); 
					}else if(fixed_thumbsval == 1) {
						$('.projectimages').append(div); 
						$('.box').removeClass('odd');
						$('.box:nth-child('+columncount+'n+'+columncount+')').addClass('odd');
					}else{
						$('.projectimages').isotope( 'insert', $(div) ); 
						isoTheme(1);
					}
					
					$('#post-list nav').html(navdiv);
					socialRevive();
					responsiveIMG();
					reviveSliders();
						
				 });
			
				e.preventDefault();
			});
			
				
			/// GET BLOG POSTS
			$('body').on('click','.bloglistcontainer nav#page_nav a',function(e) { 
			
				var murl = $(this).attr('href');
				
				$(this).remove();
				
				$.post(murl,function(data) { 
				
					var div = $('.addblogposts', $(data)).html();
					var navdiv = $('.bloglistcontainer nav', $(data)).html();
					
					$('.addblogposts').append(div); 
					$('.bloglistcontainer nav').html(navdiv);
					$(".addblogposts").fitVids();
					socialRevive();
					responsiveIMG();
					reviveSliders();
						
				});
			
				e.preventDefault();
			});
			
		
					
			/// POST NAVIGATION
			$('body').on('click','a.getworks-nextback',function(e) { 
				var id = $(this).attr('data-id');
				var token = $(this).attr('data-token');
				var murl = $(this).attr('href');
				var type = $(this).attr('data-type');
				
				showLoader(1);
					
				$('html, body').animate({scrollTop:0}, 'slow', "easeInOutExpo");
			
				
				$.post(murl,function(data) { 
					$('#loadintothis').fadeOut('normal',function() { 
						var div = $('#loadintothis', $(data)).html();
							
						loadProjectFirst(-1);
					
						$('#loadintothis').html(div).fadeIn('normal',function() { 
							loadProject(data,murl);
						});
					});
				});
				
				
				if($('.main-nav a[data-id='+id+']').length > 0) {	
					$('.main-nav a').removeClass('current-menu');	
					$('.main-nav a[data-id='+id+']').addClass('current-menu');
				}
				
				return false;
				e.preventDefault();
			});
		
		
		
		}
		
		
		// HTML5 FULLSCREEN TOGGLE
		$('.makeitfull').click(function() {
				screenfull.toggle();
		});
	
	});
})(jQuery);

