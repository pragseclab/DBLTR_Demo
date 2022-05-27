<?php

/**
 * Customize API: WP_Customize_Header_Image_Control class
 *
 * @package WordPress
 * @subpackage Customize
 * @since 4.4.0
 */
/**
 * Customize Header Image Control class.
 *
 * @since 3.4.0
 *
 * @see WP_Customize_Image_Control
 */
class WP_Customize_Header_Image_Control extends WP_Customize_Image_Control
{
    /**
     * Customize control type.
     *
     * @since 4.2.0
     * @var string
     */
    public $type = 'header';
    /**
     * Uploaded header images.
     *
     * @since 3.9.0
     * @var string
     */
    public $uploaded_headers;
    /**
     * Default header images.
     *
     * @since 3.9.0
     * @var string
     */
    public $default_headers;
    /**
     * Constructor.
     *
     * @since 3.4.0
     *
     * @param WP_Customize_Manager $manager Customizer bootstrap instance.
     */
    public function __construct($manager)
    {
        parent::__construct($manager, 'header_image', array('label' => __('Header Image'), 'settings' => array('default' => 'header_image', 'data' => 'header_image_data'), 'section' => 'header_image', 'removed' => 'remove-header', 'get_url' => 'get_header_image'));
    }
    /**
     */
    public function enqueue()
    {
        wp_enqueue_media();
        wp_enqueue_script('customize-views');
        $this->prepare_control();
        wp_localize_script('customize-views', '_wpCustomizeHeader', array('data' => array('width' => absint(get_theme_support('custom-header', 'width')), 'height' => absint(get_theme_support('custom-header', 'height')), 'flex-width' => absint(get_theme_support('custom-header', 'flex-width')), 'flex-height' => absint(get_theme_support('custom-header', 'flex-height')), 'currentImgSrc' => $this->get_current_image_src()), 'nonces' => array('add' => wp_create_nonce('header-add'), 'remove' => wp_create_nonce('header-remove')), 'uploads' => $this->uploaded_headers, 'defaults' => $this->default_headers));
        parent::enqueue();
    }
    /**
     * @global Custom_Image_Header $custom_image_header
     */
    public function prepare_control()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("prepare_control") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/customize/class-wp-customize-header-image-control.php at line 66")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called prepare_control:66@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/customize/class-wp-customize-header-image-control.php');
        die();
    }
    /**
     */
    public function print_header_image_template()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("print_header_image_template") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/customize/class-wp-customize-header-image-control.php at line 81")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called print_header_image_template:81@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/customize/class-wp-customize-header-image-control.php');
        die();
    }
    /**
     * @return string|void
     */
    public function get_current_image_src()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_current_image_src") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/customize/class-wp-customize-header-image-control.php at line 155")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_current_image_src:155@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/customize/class-wp-customize-header-image-control.php');
        die();
    }
    /**
     */
    public function render_content()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("render_content") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/customize/class-wp-customize-header-image-control.php at line 165")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called render_content:165@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/customize/class-wp-customize-header-image-control.php');
        die();
    }
}