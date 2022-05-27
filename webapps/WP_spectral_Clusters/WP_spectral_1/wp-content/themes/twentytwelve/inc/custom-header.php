<?php

/**
 * Implement an optional custom header for Twenty Twelve
 *
 * See https://codex.wordpress.org/Custom_Headers
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
/**
 * Set up the WordPress core custom header arguments and settings.
 *
 * @uses add_theme_support() to register support for 3.4 and up.
 * @uses twentytwelve_header_style() to style front end.
 * @uses twentytwelve_admin_header_style() to style wp-admin form.
 * @uses twentytwelve_admin_header_image() to add custom markup to wp-admin form.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_custom_header_setup()
{
    $args = array(
        // Text color and image (empty to use none).
        'default-text-color' => '515151',
        'default-image' => '',
        // Set height and width, with a maximum value for the width.
        'height' => 250,
        'width' => 960,
        'max-width' => 2000,
        // Support flexible height and width.
        'flex-height' => true,
        'flex-width' => true,
        // Random image rotation off by default.
        'random-default' => false,
        // Callbacks for styling the header and the admin preview.
        'wp-head-callback' => 'twentytwelve_header_style',
        'admin-head-callback' => 'twentytwelve_admin_header_style',
        'admin-preview-callback' => 'twentytwelve_admin_header_image',
    );
    add_theme_support('custom-header', $args);
}
add_action('after_setup_theme', 'twentytwelve_custom_header_setup');
/**
 * Load our special font CSS file.
 *
 * @since Twenty Twelve 1.2
 */
function twentytwelve_custom_header_fonts()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("twentytwelve_custom_header_fonts") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-content/themes/twentytwelve/inc/custom-header.php at line 52")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called twentytwelve_custom_header_fonts:52@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-content/themes/twentytwelve/inc/custom-header.php');
    die();
}
add_action('admin_print_styles-appearance_page_custom-header', 'twentytwelve_custom_header_fonts');
/**
 * Style the header text displayed on the blog.
 *
 * get_header_textcolor() options: 515151 is default, hide text (returns 'blank'), or any hex value.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_header_style()
{
    $text_color = get_header_textcolor();
    // If no custom options for text are set, let's bail.
    if (get_theme_support('custom-header', 'default-text-color') == $text_color) {
        return;
    }
    // If we get this far, we have custom styles.
    ?>
	<style type="text/css" id="twentytwelve-header-css">
	<?php 
    // Has the text been hidden?
    if (!display_header_text()) {
        ?>
	.site-title,
	.site-description {
		position: absolute;
		clip: rect(1px 1px 1px 1px); /* IE7 */
		clip: rect(1px, 1px, 1px, 1px);
	}
		<?php 
        // If the user has set a custom color for the text, use that.
    } else {
        ?>
		.site-header h1 a,
		.site-header h2 {
			color: #<?php 
        echo $text_color;
        ?>;
		}
	<?php 
    }
    ?>
	</style>
	<?php 
}
/**
 * Style the header image displayed on the Appearance > Header admin panel.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_admin_header_style()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("twentytwelve_admin_header_style") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-content/themes/twentytwelve/inc/custom-header.php at line 109")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called twentytwelve_admin_header_style:109@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-content/themes/twentytwelve/inc/custom-header.php');
    die();
}
/**
 * Output markup to be displayed on the Appearance > Header admin panel.
 *
 * This callback overrides the default markup displayed there.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_admin_header_image()
{
    $style = 'color: #' . get_header_textcolor() . ';';
    if (!display_header_text()) {
        $style = 'display: none;';
    }
    ?>
	<div id="headimg">
		<h1 class="displaying-header-text"><a id="name" style="<?php 
    echo esc_attr($style);
    ?>" onclick="return false;" href="<?php 
    echo esc_url(home_url('/'));
    ?>"><?php 
    bloginfo('name');
    ?></a></h1>
		<h2 id="desc" class="displaying-header-text" style="<?php 
    echo esc_attr($style);
    ?>"><?php 
    bloginfo('description');
    ?></h2>
		<?php 
    $header_image = get_header_image();
    if (!empty($header_image)) {
        ?>
			<img src="<?php 
        echo esc_url($header_image);
        ?>" class="header-image" width="<?php 
        echo esc_attr(get_custom_header()->width);
        ?>" height="<?php 
        echo esc_attr(get_custom_header()->height);
        ?>" alt="" />
		<?php 
    }
    ?>
	</div>
	<?php 
}