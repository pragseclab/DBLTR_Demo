<?php

/**
 * Customize API: WP_Customize_Cropped_Image_Control class
 *
 * @package WordPress
 * @subpackage Customize
 * @since 4.4.0
 */
/**
 * Customize Cropped Image Control class.
 *
 * @since 4.3.0
 *
 * @see WP_Customize_Image_Control
 */
class WP_Customize_Cropped_Image_Control extends WP_Customize_Image_Control
{
    /**
     * Control type.
     *
     * @since 4.3.0
     * @var string
     */
    public $type = 'cropped_image';
    /**
     * Suggested width for cropped image.
     *
     * @since 4.3.0
     * @var int
     */
    public $width = 150;
    /**
     * Suggested height for cropped image.
     *
     * @since 4.3.0
     * @var int
     */
    public $height = 150;
    /**
     * Whether the width is flexible.
     *
     * @since 4.3.0
     * @var bool
     */
    public $flex_width = false;
    /**
     * Whether the height is flexible.
     *
     * @since 4.3.0
     * @var bool
     */
    public $flex_height = false;
    /**
     * Enqueue control related scripts/styles.
     *
     * @since 4.3.0
     */
    public function enqueue()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("enqueue") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/customize/class-wp-customize-cropped-image-control.php at line 61")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called enqueue:61@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/customize/class-wp-customize-cropped-image-control.php');
        die();
    }
    /**
     * Refresh the parameters passed to the JavaScript via JSON.
     *
     * @since 4.3.0
     *
     * @see WP_Customize_Control::to_json()
     */
    public function to_json()
    {
        parent::to_json();
        $this->json['width'] = absint($this->width);
        $this->json['height'] = absint($this->height);
        $this->json['flex_width'] = absint($this->flex_width);
        $this->json['flex_height'] = absint($this->flex_height);
    }
}