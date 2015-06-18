<?php

// loads wordpress
require_once('get_wp.php'); // loads wordpress stuff

// gets shortcode
$shortcode = base64_decode(trim($_GET['sc']));

?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" media="all"/>
    <?php wp_head(); ?>
    <style type="text/css">
        html {
            margin: 0 !important;
        }

        body {
            padding: 20px 15px;
 			font-family: "HelveticaNeue", "Helvetica Neue", Helvetica, Arial, sans-serif;
        }
    </style>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript" src="../../js/jquery.gmap.min.js"></script>
</head>
<body>
<?php echo do_shortcode($shortcode); ?>
</body>
</html>