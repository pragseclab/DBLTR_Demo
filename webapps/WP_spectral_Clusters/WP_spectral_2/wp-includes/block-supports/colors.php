<?php

/**
 * Colors block support flag.
 *
 * @package WordPress
 * @since 5.6.0
 */
/**
 * Registers the style and colors block attributes for block types that support it.
 *
 * @since 5.6.0
 * @access private
 *
 * @param WP_Block_Type $block_type Block Type.
 */
function wp_register_colors_support($block_type)
{
    $color_support = false;
    if (property_exists($block_type, 'supports')) {
        $color_support = _wp_array_get($block_type->supports, array('color'), false);
    }
    $has_text_colors_support = true === $color_support || is_array($color_support) && _wp_array_get($color_support, array('text'), true);
    $has_background_colors_support = true === $color_support || is_array($color_support) && _wp_array_get($color_support, array('background'), true);
    $has_gradients_support = _wp_array_get($color_support, array('gradients'), false);
    $has_link_colors_support = _wp_array_get($color_support, array('link'), false);
    $has_color_support = $has_text_colors_support || $has_background_colors_support || $has_gradients_support || $has_link_colors_support;
    if (!$block_type->attributes) {
        $block_type->attributes = array();
    }
    if ($has_color_support && !array_key_exists('style', $block_type->attributes)) {
        $block_type->attributes['style'] = array('type' => 'object');
    }
    if ($has_background_colors_support && !array_key_exists('backgroundColor', $block_type->attributes)) {
        $block_type->attributes['backgroundColor'] = array('type' => 'string');
    }
    if ($has_text_colors_support && !array_key_exists('textColor', $block_type->attributes)) {
        $block_type->attributes['textColor'] = array('type' => 'string');
    }
    if ($has_gradients_support && !array_key_exists('gradient', $block_type->attributes)) {
        $block_type->attributes['gradient'] = array('type' => 'string');
    }
}
/**
 * Add CSS classes and inline styles for colors to the incoming attributes array.
 * This will be applied to the block markup in the front-end.
 *
 * @since 5.6.0
 * @access private
 *
 * @param  WP_Block_Type $block_type       Block type.
 * @param  array         $block_attributes Block attributes.
 *
 * @return array Colors CSS classes and inline styles.
 */
function wp_apply_colors_support($block_type, $block_attributes)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_apply_colors_support") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/block-supports/colors.php at line 58")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_apply_colors_support:58@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/block-supports/colors.php');
    die();
}
// Register the block support.
WP_Block_Supports::get_instance()->register('colors', array('register_attribute' => 'wp_register_colors_support', 'apply' => 'wp_apply_colors_support'));