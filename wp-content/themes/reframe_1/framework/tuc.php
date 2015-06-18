<?php
/**
 * Provides a notification everytime the theme is updated
 * Original code courtesy of João Araújo of Unisphere Design - http://themeforest.net/user/unisphere
 */

$checkint = 21000;

add_action('admin_menu', 'update_notifier_menu');

function update_notifier() { 
	global $checkint;
	
	$xml = get_latest_theme_version($checkint); // This tells the function to cache the remote call for 21600 seconds (6 hours)
	$theme_data = wp_get_theme(); // Get theme data from style.css (current version is what we want) 
	
	$tempdir = explode('/',get_template_directory());
	$tempdir = end($tempdir);
	
	?>
	
	<style>
		.update-nag {display: none;}
		#instructions {max-width: 800px;}
		h3.title {margin: 30px 0 0 0; padding: 30px 0 20px 0; border-top: 1px solid #ddd;}
	</style>

	<div class="wrap">
	
		<div id="icon-tools" class="icon32"></div>
		<h2><?php echo $theme_data->Name; ?> Theme Updates</h2>
	    <div id="message" class="updated below-h2"><p><strong>There is a new version of the <?php echo $theme_data->Name; ?> theme available.</strong> You have version <?php echo $theme_data->Version; ?> installed. Update to version <?php echo $xml->latest; ?>.</p></div>
        
        <img style="float: left; margin: 0 20px 20px 0; border: 1px solid #ddd;" src="<?php echo get_bloginfo( 'template_url' ) . '/screenshot.png'; ?>" />
        
        <div id="instructions" style="max-width: 800px;">
            <h3>Update Download and Instructions</h3>
            <p><strong>Please note:</strong> make a <strong>backup</strong> of the Theme inside your WordPress installation folder <strong>/wp-content/themes/<?php echo $tempdir ?>/</strong></p>
           <p>To download latest version of your theme, visit <a href="http://northeme.com">http://northeme.com</a> and log in to your account. You can find more information about upgrading your theme in your account section.</p>
        </div>
        
            <div class="clear"></div>
	    
	    <h3 class="title">Changelog</h3>
	    <div style="width:70%"><?php echo $xml->changelog; ?></div>

	</div>
    
<?php } 



function update_notifier_menu() { 
	global $checkint; 
	
	$xml = get_latest_theme_version($checkint); // This tells the function to cache the remote call for 21600 seconds (6 hours)
	$theme_data = wp_get_theme(); // Get theme data from style.css (current version is what we want)
	
	$rdata = @$theme_data->parent()->Version;
	
	if(isset($rdata)) {
		$themever = $theme_data->parent()->Version;
		$themenames = $theme_data->parent()->Name;
	}else{
		$themever = $theme_data->Version;
		$themenames = $theme_data->Name;
	}
	
	$tempdir = explode('/',get_template_directory());
	$tempdir = end($tempdir);
	
	if(@version_compare($themever, $xml->latest) == -1) {
		add_dashboard_page( $themenames . 'Theme Updates',  $themenames. '<span class="update-plugins count-1" style="background-color:#cc0000"><span class="update-count">'.$xml->latest.'</span></span>', 'administrator', $tempdir.'-updates', 'update_notifier');
	}
}  


// This function retrieves a remote xml file on my server to see if there's a new update 
// For performance reasons this function caches the xml content in the database for XX seconds ($interval variable)
function get_latest_theme_version($interval) {
	// remote xml file location
	$notifier_file_url = 'http://northeme.com/theme-updater/reframe';
	
	$db_cache_field = 'contempo-notifier-cache';
	$db_cache_field_last_updated = 'contempo-notifier-last-updated';
	$last = get_option( $db_cache_field_last_updated );
	$now = time();
	// check the cache
	if ( !$last || (( $now - $last ) > $interval) ) {
		// cache doesn't exist, or is old, so refresh it
		if( function_exists('curl_init') ) { // if cURL is available, use it...
			$ch = curl_init($notifier_file_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			$cache = curl_exec($ch);
			curl_close($ch);
		} else {
			$cache = file_get_contents($notifier_file_url); // ...if not, use the common file_get_contents()
		}
		
		if ($cache) {			
			// we got good results
			update_option( $db_cache_field, $cache );
			update_option( $db_cache_field_last_updated, time() );			
		}
		// read from the cache file
		$notifier_data = get_option( $db_cache_field );
	}
	else {
		// cache file is fresh enough, so read from it
		$notifier_data = get_option( $db_cache_field );
	}
	
	$xml = @simplexml_load_string($notifier_data); 
	return $xml;
}

?>
