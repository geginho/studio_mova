<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>

	<!-- Basic Page Needs
  ================================================== -->
	<meta charset="utf-8">
	<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged, $post;
	
	if(is_category() || is_tag() || is_archive() || is_search() || is_tax()) {
		global $wp_query, $term, $taxonomy;
		
		if(is_tax()) { 
			
			$title_name = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); 
			
			echo $title_name->name." | ";
		
		}elseif(is_author()) {
            
			_e(  'Author Archives : '.get_the_author(), 'northeme' );
			
		}elseif(is_archive() && !is_tag() && !is_category()) { 
		
			if ( is_day() ) :
				printf( __( 'Daily Archives: %s', 'twentythirteen' ), get_the_date() );
			elseif ( is_month() ) :
				printf( __( 'Monthly Archives: %s', 'twentythirteen' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'twentythirteen' ) ) );
			elseif ( is_year() ) :
				printf( __( 'Yearly Archives: %s', 'twentythirteen' ), get_the_date( _x( 'Y', 'yearly archives date format', 'twentythirteen' ) ) );
			else :
				_e( 'Archives', 'twentythirteen' );
			endif;
			
			echo " | ";
			
		}elseif(is_search()) { 
		
			echo get_search_query()." | ";
		
		}elseif(is_tag()) { 
		
			echo single_tag_title()." | ";
		
		}else{
		
			echo $catparent = trim(get_category_parents($cat, false, ' / '),' / ')." | ";
			//echo single_cat_title()." | ";
		}
				
	}elseif(isset($post->ID)) {
		
		$page_title = esc_attr(get_post_meta( $post->ID, 'seo-title', true ));
		$descrip = esc_attr(get_post_meta( $post->ID, 'seo-desc', true ));
		$seokeywords = esc_attr(get_post_meta( $post->ID, 'seo-keywords', true ));
		
		if($page_title=="") {
			wp_title( '|', true, 'right' ); 
		}else{
			echo $page_title." | ";
		}
	}else{
		wp_title( '|', true, 'right' );	
	}
	
	
	// Add the blog name.
	echo strip_tags(get_bloginfo( 'name' ));
	
	
	
	if(!is_single()) { 
		if(of_get_option('md_header_logo_subtext')) { 
			echo " - ".strip_tags(of_get_option('md_header_logo_subtext')); 
			} 
	}
	
	/// CREATE DESCRIPTION
	if(!isset($descrip) || $descrip=="") {
		if(is_single()) { 
			$post = $wp_query->post;
			$descrip = strip_tags($post->post_content);
			$descrip_more = '';
				if (strlen($descrip) > 155) {
					$descrip = substr($descrip,0,155);
					$descrip_more = ' ...';
				}
			$descrip = str_replace('"', '', $descrip);
			$descrip = str_replace("'", '', $descrip);
			$descripwords = preg_split('/[\n\r\t ]+/', $descrip, -1, PREG_SPLIT_NO_EMPTY);
			array_pop($descripwords);
			$descrip = implode(' ', $descripwords) . $descrip_more; 
		}else{ 
			if(of_get_option('md_header_seo_description')!='') { 
				$descrip = of_get_option('md_header_seo_description');
			}else{
				$descrip = get_bloginfo( 'description' );
			}
		}
	}
	
	
	
	if(isset($seokeywords) && $seokeywords=="") {
		$seokeywords = of_get_option('md_header_seo_keywords');
	}
	  ?></title>
	<meta name="description" content="<?php echo esc_attr($descrip); ?>">
	<meta name="keywords" content="<?php if(isset($seokeywords)) echo ($seokeywords); ?>">

	<!-- Mobile Specific Metas
  ================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    
 
 <?php 
 	/// GET SITE COLORS & GOOGLE FONTS
	$scolors = siteColors();
	
	/// BG COLOR / BG PATTERN
	$md_bgpattern = $scolors['bgpattern'];
	$md_bgcolor = $scolors['bgcolor'];
	if(!$md_bgcolor) $md_bgcolor ='#fff';
	if($md_bgpattern!='--No Pattern--')  { $md_bgpattern = ' url('. get_template_directory_uri().'/images/bgpatterns/'. $md_bgpattern.')'; }else {  $md_bgpattern= '';}
 
 ?>
	<!-- CSS
  ================================================== -->
    <?php 
  	 if($scolors['md_font_type']=='googlefonts') {
    ?>
  <link href='http://fonts.googleapis.com/css?family=<?php echo str_replace('"','',str_replace(' ','+',$scolors['body_font']))?>:400,700|<?php echo str_replace('"','',str_replace(' ','+',$scolors['header_font']))?>' rel='stylesheet' type='text/css'>
	<?php
	 }
	?>
    
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
    
<?php 
	
	if(is_single()) {
		
		global $post;
		$customtypes = of_get_option('md_custom_posts');
	
		//$i=1;
		foreach($customtypes as $k => $v) {
			if($v['title']==$post->post_type) { 
				$page_type = $k;
				break;
			}
			//$i++;
		}
		
	}else{
		global $page_type;
		if(!isset($page_type)) {
			$page_type = getCustomPage();
		}
		
		global $customtypes;
		if(!isset($customtypes)) {
			$customtypes = of_get_option('md_custom_posts');
		}
	}
	
	if(isset($page_type) && isset($customtypes[$page_type])) {
		$vartype = @$customtypes[$page_type];
	}
	
	
	/// MAIN SETTINGS
	$md_works_full =  of_get_option('md_works_full');
	$md_home_full =  of_get_option('md_home_full');
	
	$md_border_disable = of_get_option('md_border_disable');
	
	if(isset($vartype)) { 
		$postname = $vartype['title'];
		$md_thumbcount = $vartype['thumbnail'];
		$workstitle = $vartype['plural'];
		$categoriestitle = $vartype['categoryname'];
		$categoryname = $vartype['title'].'-categories';
		$portfoliolink = @$vartype['home_url'];
		$works_pagination = ($vartype['pagination']);
		$md_fixed_thumbs = ($vartype['fixedthumbs']);
		$md_thumbnail_type = ($vartype['thumbnailcaption']);
		$md_perc_gap = ($vartype['thumbnailpadding']);
		$showtitle = intval($vartype['showtitle']);
		$showexcerpt = intval($vartype['showexcerpt']);
		$orderby = intval($vartype['orderby']);
		
		// TOTAL WIDTH
		$md_perc = 100-$md_perc_gap;
			
		/// CALCULATE THUMBNAIL WIDTH
		if($md_thumbcount-1 > 0) {
			$md_widthpercent = $md_perc/$md_thumbcount;
			$md_widthpercent_margin = $md_perc_gap/($md_thumbcount-1);
		}else{
			$md_widthpercent = 100;
			$md_widthpercent_margin = 0;
		}
		
	
	}
	
	
	$iconvarcolor = of_get_option('md_css_socialiconcolors');

	global $slider_temp;
	
?>  
    
  	<?php if(isset($slider_temp) && $slider_temp==1) {?>
    
    <link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/js/supersized/supersized.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/js/supersized/supersized.shutter.css" type="text/css" media="screen" />
    <style type="text/css">
	.videoContainer {top:0%;left:0%;height:100%;width:100%; }
	.vjs-text-track-display, .vjs-loading-spinner, .vjs-big-play-button, .vjs-control-bar { display:none!important }
	@media only screen and (max-width: 767px) { .container { position:static; } }
	</style>
    

	<?php } ?>
    
    
    
	<style type="text/css">
	<?php 
  	 if($scolors['md_font_type']=='fontface' || $scolors['md_font_type']=='') {
    ?>
	@font-face {
		font-family: 'mainfont';
		src: url('<?php echo get_template_directory_uri()?>/fonts/<?php echo $scolors['body_font_path']?>.eot');
		src: url('<?php echo get_template_directory_uri()?>/fonts/<?php echo $scolors['body_font_path']?>.eot?#iefix') format('embedded-opentype'),
			 url('<?php echo get_template_directory_uri()?>/fonts/<?php echo $scolors['body_font_path']?>.woff') format('woff'),
			 url('<?php echo get_template_directory_uri()?>/fonts/<?php echo $scolors['body_font_path']?>.ttf') format('truetype'),
			 url('<?php echo get_template_directory_uri()?>/fonts/<?php echo $scolors['body_font_path']?>.svg') format('svg');
		font-weight: normal;
		font-style: normal;
	
	}
	
	@font-face {
		font-family: 'mainfont';
		src: url('<?php echo get_template_directory_uri()?>/fonts/<?php echo $scolors['header_font_path']?>.eot');
		src: url('<?php echo get_template_directory_uri()?>/fonts/<?php echo $scolors['header_font_path']?>.eot?#iefix') format('embedded-opentype'),
			 url('<?php echo get_template_directory_uri()?>/fonts/<?php echo $scolors['header_font_path']?>.woff') format('woff'),
			 url('<?php echo get_template_directory_uri()?>/fonts/<?php echo $scolors['header_font_path']?>.ttf') format('truetype'),
			 url('<?php echo get_template_directory_uri()?>/fonts/<?php echo $scolors['header_font_path']?>.svg') format('svg');
		font-weight: bold;
		font-style: normal;
	
	}
	<?php } ?>
	
	<?php 
		$scolors['body_font'] = str_replace('+',' ',$scolors['body_font']);
		$scolors['header_font'] = str_replace('+',' ',$scolors['header_font']);
	?>
    body { 
	   font: <?php echo $scolors['bodyfontsize'] ?> <?php echo $scolors['body_font']?>, "HelveticaNeue", "Helvetica Neue", Helvetica, Arial, sans-serif;
	   background:<?php echo $scolors['bgcolor']. $md_bgpattern; ?>;
	   color:<?php echo $scolors['fontcolor'];?>;
    }
	div#maximage a span { color:<?php echo $scolors['fontcolor'];?> }
	
	.mainframeclass { background:<?php echo $scolors['framecolor'];?>!important; }
	<?php if($md_border_disable==1) { ?>
	.mainframeclass { display:none!important; }
	#maincontainer { margin:0!important;}
    .full-navigation { bottom:<?php if(of_get_option('md_removeheader')==1) { echo '180px'; }else{ echo '100px'; }?>; }
	#slidecaption { bottom:<?php if(of_get_option('md_removeheader')==1) { echo '180px'; }else{ echo '100px'; }?>; }
	<?php } ?>
	<?php 
	$hfont = of_get_option('md_header_logo_text_typo');
	if($hfont && !of_get_option('md_header_logo')) {?>
	a.main-logo { 
		font-family:<?php if(isset($hfont['face']) && $hfont['size']!='default') { echo $hfont['size']; }else{ echo $scolors['header_font']; }?>, "HelveticaNeue", "Helvetica Neue", Helvetica, Arial, sans-serif;
		font-size:<?php echo $hfont['size'];?>!important; 
		font-weight:<?php echo @$hfont['style'];?>!important; 
		line-height:<?php echo @$hfont['height'];?>!important; 
		color:<?php echo $scolors['logotext']?>!important; 
	}
	<?php } ?>
	<?php if(of_get_option('md_header_logo_size')) { ?>
	#maincontainer a.main-logo img { max-width:<?php echo of_get_option('md_header_logo_size')?>px; }
	<?php } ?>
	h1, h2, h3, h4, h5, h6, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a, a.headertag { color:<?php echo $scolors['headingcolor'];?>!important;
		font-family:<?php echo $scolors['header_font']?>, "HelveticaNeue", "Helvetica Neue", Helvetica, Arial, sans-serif;}
	[class^="icon-"],[class*=" icon-"],i.new-social-icons { color:<?php echo $scolors['iconcolors'];?>}
	.toprightshare a.makeitfull { border-color:<?php echo $iconvarcolor;?>}
	a.makeitfull i { color:<?php echo $iconvarcolor;?> }
	.wp-caption, blockquote, .navigation-bottom a, .navigation-bottom-works a, .border-color, .widget li, .widget_tag_cloud div a { border-color:<?php echo $scolors['bordercolor'];?>!important; border-style:<?php echo $scolors['borderstyle'];?>!important;}
	a { color:<?php echo $scolors['linkcolor'];?>; }
	form.contactform_ajax label.error { color:<?php echo $scolors['linkcolor'];?>!important; }
	a:hover, a:focus { color:<?php echo $scolors['linkcoloractive'];?>; }
	.btopcategories a.selected { color:<?php echo $scolors['linkcoloractive'];?>; }
	<?php if(isset($md_widthpercent) && isset($md_widthpercent_margin) && isset($md_thumbcount)) { ?>
    .projectimages .box { width:<?php echo $md_widthpercent ?>%;margin-right:<?php echo $md_widthpercent_margin ?>%;<?php if($md_thumbcount > 1) { ?>margin-bottom:<?php echo $md_widthpercent_margin ?>%;<?php } ?> }
	<?php } ?>
	<?php if(isset($md_perc) && isset($md_perc_gap)) { ?>
	@media only screen and (min-width: 768px) and (max-width: 959px) {
	/*.projectimages .box { width:<?php echo $md_perc/2?>%;margin-right:<?php echo $md_perc_gap/2 ?>%;}*/
	.projectimages .box { width:47%;margin-right:6%; margin-bottom:6%;}
	}
	<?php } ?>
	<?php if(isset($md_thumbcount) && isset($md_perc_gap)) { ?>
    .projectimages .box strong { margin-top:-<?php if($md_thumbcount > 4 ) echo $md_perc_gap/2; ?>px;}
	<?php } ?>
	input[type="text"],	input[type="password"],	textarea {background-color:<?php echo $scolors['formelementbg'];?>;border:1px solid <?php echo $scolors['formelementborder'];?>;color:<?php echo $scolors['formelementtext'];?>;} 
	input[type="submit"], button { background:<?php echo $scolors['formbuttonbg'];?>;color:<?php echo $scolors['formbuttontext'];?>;}
	button i { color:<?php echo $scolors['formbuttontext'];?>!important; }
	.section.leftmenu .main-nav a.selected, section.leftmenu .main-nav a:hover, section.leftmenu .main-nav .sub-menu a:hover, ul.main-nav a.current-menu,
	div.headright .main-nav .sub-menu a:hover, div.headright .main-nav a.parent-menu.current-parent {color:<?php echo $scolors['menufontactive'];?>!important;}
	<?php 
	if(of_get_option('md_main_menu_styling_enable')) { 
		$mainmenustyle = of_get_option('md_main_menu_styling');
	?>
	ul.main-nav a {
	  font-size:<?php echo $mainmenustyle['size']?>!important;
	  <?php if($mainmenustyle['face']!='default') { ?>font-family:<?php echo $mainmenustyle['face']?>!important;<?php } ?>
	}
	<?php } ?>
	ul.main-nav a.current-menu { color:<?php echo $scolors['menufontactive'];?>!important; }
	.leftmenu .main-nav a, div.headright .main-nav .sub-menu a, div.headright .main-nav li a, .main-nav li a i { color:<?php echo $scolors['menufont'];?>;}
	.projectimages .box span.info { background:<?php echo $scolors['worksthumbbg'];?>; }
	.projectimages .box strong.info { color:<?php echo $scolors['worksthumbtext'];?> }
	<?php if($md_border_disable) { ?>
	div.sliderfooter { bottom:80px; }
	<?php } ?>
	dl.tabs dd.active a { color:<?php echo $scolors['linkcoloractive'];?>; border-bottom:1px <?php echo $scolors['borderstyle'];?> <?php echo $scolors['bordercolor'];?>; }
	table#wp-calendar { border-color:<?php echo $scolors['bordercolor'];?>; }
	<?php if($slider_temp) {?>
	.forintroslider { display:none!important } section.leftmenu { margin-top: 6px; } #maincontainer { background:none!important }
	<?php if($scolors['intronavarrow']) { ?>.full-navigation a, .full-navigation i { color:<?php echo $scolors['intronavarrow'];?>!important; }<?php } ?>
  	<?php } ?>
	<?php if(of_get_option('md_display_submenus_always')==1) { ?>
	section.leftmenu .main-nav .sub-menu { display:block; }
  	<?php } ?>
	<?php if(of_get_option('md_gallery_caption_placement')=='bottom') { ?>
	 .galleria-info { bottom:60px; top:auto; }
	<?php } ?>
	<?php if(of_get_option('md_gallery_caption_alignment')=='center') { ?>
	.galleria-info-description { text-align:center; }
	<?php } ?>
	<?php if(of_get_option('md_gallery_align_center')==1) { ?>
	.galleria-thumbnails {
		margin-left: auto;
		margin-right: auto;
	}
	<?php } ?>
	<?php if(of_get_option('md_pagination_type')=='loadmore' || of_get_option('md_pagination_type')=='paginate') { ?>
	#page_nav { display:block; text-align:center; }
	#page_nav a { padding: 10px 18px; background:<?php echo $scolors['formbuttonbg'];?>;color:<?php echo $scolors['formbuttontext'];?>; position:relative; top:25px; margin-left:-10px; }
	<?php } ?>
	
	<?php if(isset($scolors['scolors']['thumbnail']) && isset($scolors['scolors']['worksthumbtext'])) { ?>
	div.project-item.rollover .thumb_large { 
		background-color:<?php echo $scolors['scolors']['thumbnail'];?>!important; 
		color:<?php echo $scolors['scolors']['worksthumbtext'];?>!important; 
	}
	<?php } ?>
	
	<?php if(isset($scolors['scolors']['worksthumbtext'])) { ?>
	div.project-item.rollover .thumb_large a, div.project-item.rollover .thumb_large .title { color:<?php echo $scolors['scolors']['worksthumbtext'];?>!important; }
	<?php } ?>
	<?php 
		$slfont = of_get_option('md_slider_intro_caption_styling');
		if($slfont) {
	?>
	#slidecaption { 
		<?php if(isset($slfont['face']) && $slfont['face']!='default') { ?>font-family: <?php echo $slfont['face']; ?>, "HelveticaNeue", "Helvetica Neue", Helvetica, Arial, sans-serif<?php } ?>;
		font-size:<?php echo $slfont['size'];?>!important; 
		font-weight:<?php echo $slfont['style'];?>!important;
		color:<?php echo $slfont['color'];?>!important; 
		<?php if(of_get_option('md_slider_intro_caption_shadow')) { ?>
		text-shadow:#000 1px 1px 2px;
		<?php } ?>
		<?php if(of_get_option('md_removeheader')==1) { echo 'bottom:145px'; }?>
	}
	<?php } ?>
	.full-navigation { 
		<?php if(of_get_option('md_removeheader')==1) { echo 'bottom:160px'; }?>
	}
	<?php 
	$customtypesget = of_get_option('md_custom_posts');
	
	foreach($customtypesget as $foom) {
	?>
	.posttype-<?php echo $foom['title']?> div.projectimages .box span.info {  
		<?php if($foom['thumbbgtransparent']) { ?>
		background:none!important; 
		<?php }else{ ?>
		background-color:<?php echo $foom['thumbbgcolor'];?>!important; 
		<?php } ?>
	}
	.posttype-<?php echo $foom['title']?> div.projectimages .box strong.info {
		color:<?php echo $foom['thumbfontcolor'];?>!important; 
	}
	<?php if(isset($foom['navigation_text']) && $foom['navigation_text'] == 1) {?>
	.singlepostpage-<?php echo $foom['title']?> .navigation span { 
		display:none!important;
	}
	<?php } ?>
	<?php if(isset($foom['navigation_hide']) && $foom['navigation_hide'] == 1) {?>
	.singlepostpage-<?php echo $foom['title']?> .navigation { 
		display:none!important;
	}
	<?php } ?>
	<?php } ?>
	<?php 
		if(of_get_option('md_slider_navigation_dots')==1) {
	?>
	.flex-control-nav {display:none;}
	<?php } ?>
	<?php 
	$colnav = of_get_option('md_slider_icon_colors');
	$colnavdots = of_get_option('md_slider_nav_color');
	$colnavdots = of_get_option('md_slider_nav_color');
	$colautohide = of_get_option('md_slider_autohide');
	$colcaption = of_get_option('md_slider_caption_color');
	$coltextalign = of_get_option('md_slider_caption_alignment');
	$colnavdotshover = of_get_option('md_slider_nav_color_hover');
	$colplaypause = of_get_option('md_slider_playpause');
	
	if(!$colplaypause) {
	?>
	.flex-pauseplay { display:none!important}
	<?php	
	}
	if($colnav) { 
	?>
	.flex-direction-nav a {color:<?php echo $colnav?>!important;}
	.flex-pauseplay a i {color:<?php echo $colnav?>!important;}
	<?php } 
	if($colnavdots) {
	?>
	.flex-control-paging li a {background:<?php echo $colnavdots?>!important;}
	.flex-control-paging li a.flex-active, .flex-control-paging li a:hover {background:<?php echo $colnavdotshover?>!important;}
	<?php }  
	
	?>
	p.flex-caption {
		<?php if($colcaption) { ?>color:<?php echo $colcaption?>!important; <?php } ?>
		<?php if($coltextalign) { ?>
		text-align:<?php echo $coltextalign; ?>!important;
		<?php } ?>
		<?php if($colautohide) { ?>
	    -webkit-transition: opacity .5s ease-in-out;
	    -moz-transition: opacity .5s ease-in-out;
	    -ms-transition: opacity .5s ease-in-out;
	    -o-transition: opacity .5s ease-in-out;
	    transition: opacity .5s ease-in-out;
	    filter: alpha(opacity=0);
	    opacity: 0;
		<?php } ?>
	} 
	.flexslider:hover p.flex-caption {
	    filter: alpha(opacity=100);
	    opacity: 1;
	}
	<?php 
		if(of_get_option('md_slider_navigation_arrows')==1) {
	?>
	.flex-direction-nav {display:none!important;}
	<?php } ?>
	<?php 
		$lightboxoverlaycolor = of_get_option('md_lightbox_overlay_color');
		$lightboxbgcaption = of_get_option('md_lightbox_caption_bgcolor');
		$lightboxcaptioncolor = of_get_option('md_lightbox_caption_color');
		$lightboxcaptiondisable = of_get_option('md_lightbox_caption_disable');
		$lightboxtransparency = intval(of_get_option('md_lightbox_transparency'));
		if(!isset($lightboxtransparency)) $lightboxtransparency = 100;
		if(empty($lightboxoverlaycolor)) $lightboxoverlaycolor = '#000000';
		$lcolor = hex2rgb($lightboxoverlaycolor);
	?>
	<?php if($lightboxoverlaycolor) { ?>
	#swipebox-overlay {
		background-color:rgba(<?php echo $lcolor[0]?>,<?php echo $lcolor[1]?>,<?php echo $lcolor[2]?>,<?php echo $lightboxtransparency/100?>)!important;
	}
	<?php } ?>
	#swipebox-caption { 
		<?php if($lightboxcaptiondisable) { ?>
		display:none!important;
		<?php } ?>
		<?php if($lightboxbgcaption) { ?>
		background:<?php echo $lightboxbgcaption?>!important;	
		<?php } ?>	
		<?php if($lightboxcaptioncolor) { ?>
		color:<?php echo $lightboxcaptioncolor?>!important;	
		<?php } ?>
	}
	<?php if($lightboxbgcaption) { ?>
	#swipebox-action { 
		background:<?php echo $lightboxbgcaption?>!important;	
	}
	<?php } ?>
	
	<?php if(of_get_option('md_nicescroll_disable')!=1) { ?>
	/* Browser scrollbar stylings */
	::-webkit-scrollbar {
		width: 10px;
	}
	 
	/* Track */
	::-webkit-scrollbar-track {
		background:transparent;
		opacity: 0;
	}
	 
	/* Handle */
	::-webkit-scrollbar-thumb {
		background: #000; 
	}
	::-webkit-scrollbar-thumb:window-inactive {
		opacity:.2;	 
	}
		
	::-webkit-scrollbar-thumb {
		background: <?php echo of_get_option('md_css_scrollbar')?>; 
	}
	<?php if($md_border_disable) { $frcolor = $scolors['bgcolor']; }else { $frcolor = $scolors['framecolor']; } ?>
	::-webkit-scrollbar-track {
		background: <?php echo $frcolor;?>; 
	}
	<?php } ?>
	
	<?php echo of_get_option('md_custom_css')?>
  </style>
  
  
	<!-- Favicons
	================================================== -->
    <?php if(of_get_option('md_favicon')) { ?>
    	<link rel="icon" type="image/png" href="<?php echo of_get_option('md_favicon')?>">
    <?php } ?>
    
	<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri() ?>/images/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_template_directory_uri() ?>/images/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_template_directory_uri() ?>/images/apple-touch-icon-114x114.png">
        
	<!-- RSS
  ================================================== -->
  	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> Feed" href="<?php echo home_url(); ?>/rss">
  	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    
	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
	
    <!-- Head End
  ================================================== -->
    <?php wp_head(); ?>
    
    <?php if(isset($slider_temp) && $slider_temp==1) {?>
    
    <script type="text/javascript" src="<?php echo get_template_directory_uri()?>/js/supersized/froogaloop.min.js"></script>
    <script type="text/javascript" src="<?php echo get_template_directory_uri()?>/js/supersized/supersized.3.2.7.js"></script>
    <script type="text/javascript" src="<?php echo get_template_directory_uri()?>/js/supersized/supersized.shutter.min.js"></script>
	
	<?php } ?>
    
    <!--[if lt IE 9]>
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri()?>/style_ie.css" />
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
    
    <!--[if lt IE 8]>
    <script src="<?php echo get_template_directory_uri() ?>/js/lte-ie7.js"></script>
	<![endif]-->
 
</head>
 
 <body <?php body_class(); ?>>
  
   <div id="full-page-container">
    
   <div id="maincontainer" class="borderspace">
       
	<div class="container maincontainerdiv <?php if($md_border_disable) echo 'woframemargin';?>">
    
    <?php 
		if(of_get_option('md_menu_home_url')) { 
			if(of_get_option('md_menu_home_url')=='default') {
				$homeurl = 	get_home_url('/');
			}else{
				$homeurl = get_permalink( of_get_option('md_menu_home_url') );
			}
		}else{
			$homeurl =  get_home_url('/');
		}
		
		 if(of_get_option('md_header_logo')) { 
			$logoshow = '<a href="'.$homeurl.'" class="main-logo pull-left" title="'.get_bloginfo( 'name' ).'"><img src="'.of_get_option('md_header_logo').'" class="" alt="'.get_bloginfo( 'name' ).'"></a>';
		 }elseif(of_get_option('md_header_logo_text')) {
			$logoshow = '<a href="'.$homeurl.'" class="main-logo pull-left" title="drone">'.of_get_option('md_header_logo_text').'</a>';	
		 }else{
			$logoshow = '<a href="'.$homeurl.'" class="main-logo pull-left" title="drone">'.get_bloginfo('name').'</a>';
		 }
						 
	?>
    		 
            <div class="row topline <?php if(of_get_option('md_removeheader')==1) { echo 'smallshow';}?>">
                <div class="three-sp columns">
                     	<?php 
						
						 echo $logoshow;
						  
						 if(!of_get_option('md_social_top_hide')) { 
						 	echo '<div class="mobileshow toprightshare socialicons">';
							 	showSharing(); 
							echo '</div>';
						 }
						
						 ?>	
                </div>
                <div class="thirteen-sp columns headright">
                		<div class="<?php if(!$md_home_full) { echo 'eight'; }else{ echo 'five';}?> columns alpha hometext forintroslider">
                        	  <?php echo do_shortcode(nl2br(of_get_option('md_header_msg_text'))) ?>
                		</div> 
                     
                		 <div class="<?php if($md_home_full) { echo 'eight'; }else{ echo 'five';}?> columns omega pull-right toprightshare socialicons <?php if($md_home_full) { echo 'smalldontshow'; }else{ echo 'smalldevicedontshow'; } ?>">
                         	
                           		 <?php if(!of_get_option('md_header_disable_search') && $md_home_full) { ?>
                                    <form action="<?php echo get_site_url()?>" class="smalldontshow">
                                        <input type="text" name="s" class="medium" value=""><button type="submit"><i class='icon-search'></i></button>
                                    </form>
                                 <?php $addtopmarginmenu = 1; } ?>
                                 
                                 <div>
								 <?php if(!of_get_option('md_social_top_hide')) { showSharing(); $addtopmarginmenu = 1; }?>
                                 
                                 <?php if(!of_get_option('md_fullscreen_disabled')) {?>
                                         <a href="#" class="makeitfull" title="<?php _e('Fullscreen','northeme');?>"><i class="icon-fullscreen"></i></a>
                                 <?php $addtopmarginmenu = 1; } ?>
                                 </div> 
                                  
							  <?php 
                                if($md_home_full) { 
									
									$addtopmarginmenuclass = '';
									if(isset($addtopmarginmenu)) $addtopmarginmenuclass = ' givemargin';
									
                                    wp_nav_menu(array(
                                        'theme_location' => 'main_menu',
                                        'container' => '',
                                        'menu_class' => 'main-nav'.$addtopmarginmenuclass,
                                        'before' => '',
                                        'fallback_cb' => '',
                                        'walker' => new northeme_walker()
                                    ));
									
                                } 
							  ?>
                		 </div>
                </div>
                
            </div>   
            <?php 
			
			echo '<div class="container smallshow topmobile';
			if(of_get_option('md_removeheader')==1) {echo ' topmobilenoheader'; }	
			echo '">';
			if($md_home_full) {
				echo '<div class="sixteen columns">';
			}else{
				echo '<div class="thirteen-sp columns offset-by-three">';	
			}
			
			wp_nav_menu(array(
			  'theme_location' => 'main_menu', // your theme location here
			  'walker'         => new northeme_walker_selectbox(),
			  'items_wrap'     => '<select class="mobilemenu-select"><option value="#">'.__('--[ Select ]--','northeme').'</option>%3$s</select>',
			));
			
			echo '</div></div>';

			?>
            <div class="row <?php if(of_get_option('md_removeheader')==1) echo 'removeheadermargin'; ?>">
            	<div class="three-sp columns main_leftmenu smalldevicedontshow <?php if(($md_works_full==1 && is_any_single('works')) || ($md_home_full==1)) echo 'hideit';?>">
                     <section class="leftmenu three-sp columns alpha omega">
						 <?php 
							if(of_get_option('md_removeheader')==1) { 
								echo '<div class="logo-leftmenu smalldontshow">'.$logoshow.'</div>';
							} 
                       ?>
                     
                        <div class="menu smalldontshow">
                            <?php 
                            	wp_nav_menu(array(
                                    'theme_location' => 'main_menu',
                                    'container' => '',
                                    'menu_class' => 'main-nav',
                                    'before' => '',
                                    'fallback_cb' => '',
									'walker' => new northeme_walker()
                                ));
                            ?>
                        </div>
                        <?php if(!of_get_option('md_header_disable_search')) { ?>
                        <br class="clear">
                        <form action="<?php echo get_site_url()?>" class="smalldontshow leftsearchbox">
                            <input type="text" name="s" class="medium" value=""><button type="submit"><i class='icon-search'></i></button>
                        </form>
                        <?php } ?>
                        <?php
						 if(!of_get_option('md_social_left_hide')) { 
						 	echo '<br class="clear"><div class="leftshare socialicons smalldontshow">';
							 	showSharing(); 
							echo '</div>';
						 }
						 ?>
						
                
                        <div class="widget_wrapper home-left smalldontshow">
                         <?php if ( is_active_sidebar( 'home-left' ) ) : ?>
							<?php dynamic_sidebar( 'home-left' ); ?>
                         <?php endif; ?>
                        </div>
                        <span class="mobiledontshow">
                        	&nbsp;
                    	</span>
                    </section>
        
                </div>
                
