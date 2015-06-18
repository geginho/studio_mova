<?php 

	$absolute_path = __FILE__;
	$path_to_file = explode( 'wp-content', $absolute_path );
	$path_to_wp = $path_to_file[0];
	
	// Access WordPress
	require_once( $path_to_wp . '/wp-load.php' );

	header("Content-type: text/css; charset: UTF-8");
	
	$md_thumbcount = of_get_option('md_thumb_show');
	$md_fixed_thumbs = of_get_option('md_fixed_thumbs');
	$md_centered =  of_get_option('md_align_center');
	
	$md_body_bgcolor = of_get_option('md_body_bgcolor');
	$md_border_color = of_get_option('md_border_color');
	$md_border_disable = of_get_option('md_border_disable');
	
	/// DETERMINE TOTAL WIDTH (IN PERCENT)
	if($md_thumbcount < 4) {
		$md_perc = 92;
	}elseif($md_thumbcount == 4) {
		$md_perc = 88;
	}elseif($md_thumbcount == 5) {
		$md_perc = 85;
	}else{
		$md_perc = 82;
	}
	
	/// CALCULATE THUMBNAIL WIDTH
	$md_widthpercent = $md_perc/$md_thumbcount;
	
	/// CALCULATE FIXED HEIGHTS
	$res_height1400 = ((1078-(40*($md_thumbcount)))/$md_thumbcount) * 0.70;
	$res_height1200 = ((945-(30*($md_thumbcount)))/$md_thumbcount) * 0.70;
	$res_height1000 = ((760-(20*($md_thumbcount)))/$md_thumbcount) * 0.70;
	$res_height700 = ((604-(20*($md_thumbcount)))/$md_thumbcount) * 0.70;

?>  
    body { 
        background:<?php if(!$viewport) { echo $md_border_color; }?>;
    }
    #maincontainer { 
        background-color:<?php echo $md_body_bgcolor; ?>;<?php if($md_border_disable==1) { ?>margin:0;<?php } ?>
    } 
    .images .box { 
        width:<?php echo $md_widthpercent ?>%;
    }
    .images.fixed .box {
        height:<?php echo $res_height1000 ?>px;
    }
    .images .box strong { 
        margin-top:-<?php if($md_thumbcount > 4 ) echo $res_height1000/2; ?>px;
    }
            
    @media only screen and (min-width: 1350px) {
		.images.fixed .box {
			height:<?php echo $res_height1400 ?>px;
		}
	}
    @media only screen and (min-width: 1200px) and (max-width: 1345px) {
		.images.fixed .box {
			height:<?php echo $res_height1200 ?>px;
		}
	}
	@media only screen and (max-width: 959px) {
		.images.fixed .box {
			height:<?php echo $res_height700 ?>px;
		}
	}
	@media only screen and (min-width: 768px) and (max-width: 959px) {
		.images.fixed .box {
			height:<?php echo $res_height700 ?>px;
		}
	}
  