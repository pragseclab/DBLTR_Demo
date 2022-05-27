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
            parent::enqueue();
            // Enqueue background image cropping script.
            wp_enqueue_script('background-image-cropper', plugin_dir_url(__FILE__) . 'background-image-cropper.js', array('jquery', 'customize-controls'));
            // Load core background JS options.
            $custom_background = get_theme_support('custom-background');
            wp_localize_script('customize-controls', '_wpCustomizeBackground', array('defaults' => !empty($custom_background[0]) ? $custom_background[0] : array(), 'nonces' => array('add' => wp_create_nonce('background-add'))));
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
            parent::to_json();
            $value = $this->value();
            if ($value) {
                // Get the attachment model for the existing file.
                $attachment_id = attachment_url_to_postid($value);
                if ($attachment_id) {
                    $this->json['attachment'] = wp_prepare_attachment_for_js($attachment_id);
                }
            }
        }
    }
    $wp_customize->register_control_type('WP_Customize_Cropped_Background_Image_Control');
    $wp_customize->remove_control('background_image');
    $wp_customize->add_control(new WP_Customize_Cropped_Background_Image_Control($wp_customize, 'background_image', array('section' => 'background_image', 'label' => __('Background Image', 'background-image-cropper'), 'priority' => 0, 'flex_width' => true, 'flex_height' => true, 'width' => 1920, 'height' => 1080)));
}