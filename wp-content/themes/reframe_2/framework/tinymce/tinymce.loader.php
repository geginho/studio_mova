<?php

/*-----------------------------------------------------------------------------------*/
/*	Paths Defenitions
/*-----------------------------------------------------------------------------------*/

define('COL_TINYMCE_PATH', THEME_FILEPATH . '/framework/tinymce');
define('COL_TINYMCE_URI', THEME_DIRECTORY . '/framework/tinymce');


/*-----------------------------------------------------------------------------------*/
/*	Load TinyMCE dialog
/*-----------------------------------------------------------------------------------*/

require_once( COL_TINYMCE_PATH . '/tinymce.class.php' );		// TinyMCE wrapper class
new col_tinymce();											// do the magic

?>