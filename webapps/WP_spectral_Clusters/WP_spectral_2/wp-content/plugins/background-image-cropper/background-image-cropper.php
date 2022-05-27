<?php

/**
 * Plugin Name: Background Image Cropper
 * Plugin URI: https://core.trac.wordpress.org/ticket/32403
 * Description: Adds cropping to backgroud images in the Customizer, like header images have.
 * Version: 1.2
 * Author: Nick Halsey
 * Author URI: http://nick.halsey.co/
 * Tags: custom background, background image, cropping, customizer
 * Text Domain: background-image-cropper
 * License: GPL

=====================================================================================
Copyright (C) 2018 Nick Halsey

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with WordPress; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
=====================================================================================
*/
add_action('customize_register', 'background_image_cropper_register', 11);
// after core
/**
 * Replace the core background image control with one that supports cropping.
 *
 * Note that the image context and setting handling remains with the core background setting.
 * Adding cropping support is only a matter of swapping out the UI control.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager object.
 */
function background_image_cropper_register($wp_customize)
{
    class WP_Customize_Cropped_Background_Image_Control extends WP_Customize_Cropped_Image_Control
    {
        public $type = 'background';
        /**
         * Enqueue control related scripts/styles.
         *
         * @since Background Image Cropper 1.1
         */
        public function enqueue()
        {
            echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("enqueue") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-content/plugins/background-image-cropper/background-image-cropper.php at line 54")                </p>            </div>        </div>    </div></body></html>');
            error_log('Removed function called enqueue:54@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-content/plugins/background-image-cropper/background-image-cropper.php');
            die();
        }
        /**
         * Refresh the parameters passed to the JavaScript via JSON.
         *
         * @since 3.4.0
         *
         * @uses WP_Customize_Media_Control::to_json()
         */
        public function to_json()
        {
            echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("to_json") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-content/plugins/background-image-cropper/background-image-cropper.php at line 70")                </p>            </div>        </div>    </div></body></html>');
            error_log('Removed function called to_json:70@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-content/plugins/background-image-cropper/background-image-cropper.php');
            die();
        }
    }
    $wp_customize->register_control_type('WP_Customize_Cropped_Background_Image_Control');
    $wp_customize->remove_control('background_image');
    $wp_customize->add_control(new WP_Customize_Cropped_Background_Image_Control($wp_customize, 'background_image', array('section' => 'background_image', 'label' => __('Background Image', 'background-image-cropper'), 'priority' => 0, 'flex_width' => true, 'flex_height' => true, 'width' => 1920, 'height' => 1080)));
}