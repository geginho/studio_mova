
 <div class="addblogposts">
       
        <?php  while ( have_posts() ) : the_post(); ?>	
        
        
             
         <?php 
			$ptype = get_post_type();
			if($ptype=="post")  { 
				$ptype_echo = __('Blog','dronetv');
			}elseif($ptype=="page")  { 
				$ptype_echo = __('Page','dronetv');
			}else{
				
				$customtypes = of_get_option('md_custom_posts');
				
				foreach($customtypes as $k => $v) {
					if($v['title']==$ptype) { 
						$page_type = $k;
						break;
					}
					//$i++;
				}	
				$vartype = $customtypes[$page_type];
				
				$singluar = $vartype['plural'];
				
				$ptype_echo = $singluar;
				$thumb = getThumb('mini');
			}
			
			$posttype = $ptype_echo;
	
        
			// THUMBNAIL & CSS CLASS
			$cthumbnail = getThumb('large'); 
			
			// AJAX TOKEN
			$token = wp_create_nonce("wp_token");

        ?>
       
        <div class="blogbox full" style="margin-bottom:70px;">
        	<table>
                <tr>
                    <td>     
                        <div class="infoside infosideleft">
                            <h5><a href="<?php the_permalink() ?>"><?php the_title()?></a></h5>
                            
                            <span class="extra">
                            	<strong><?php echo $posttype?></strong>
                            </span>
                            
                            <?php the_excerpt(); ?>
                            
                            <a href="<?php the_permalink() ?>" class="readmore"><i class="icon-caret-right"></i> <?php _e('View','northeme') ?></a>
                        </div>
                    </td>
                    <?php if($cthumbnail[0]) { ?>
                    <td width="200" class="imgsidem">
                        <a href="<?php the_permalink() ?>" class="imgpost">
                            <?php echo $cthumbnail[0];?>
                        </a>
                    </td>
                    <?php } ?>
                 </tr>
             </table>   
        </div>
        
        <?php endwhile; ?>
            
                
   </div>