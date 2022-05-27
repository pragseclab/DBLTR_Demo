<?php

/**
 * Typography block support flag.
 *
 * @package WordPress
 * @since 5.6.0
 */
/**
 * Registers the style and typography block attributes for block types that support it.
 *
 * @since 5.6.0
 * @access private
 *
 * @param WP_Block_Type $block_type Block Type.
 */
function wp_register_typography_support($block_type)
{
    if (!property_exists($block_type, 'supports')) {
        return;
    }
    $has_font_size_support = _wp_array_get($block_type->supports, array('fontSize'), false);
    $has_font_style_support = _wp_array_get($block_type->supports, array('__experimentalFontStyle'), false);
    $has_font_weight_support = _wp_array_get($block_type->supports, array('__experimentalFontWeight'), false);
    $has_line_height_support = _wp_array_get($block_type->supports, array('lineHeight'), false);
    $has_text_decoration_support = _wp_array_get($block_type->supports, array('__experimentalTextDecoration'), false);
    $has_text_transform_support = _wp_array_get($block_type->supports, array('__experimentalTextTransform'), false);
    $has_typography_support = $has_font_size_support || $has_font_weight_support || $has_font_style_support || $has_line_height_support || $has_text_transform_support || $has_text_decoration_support;
    if (!$block_type->attributes) {
        $block_type->attributes = array();
    }
    if ($has_typography_support && !array_key_exists('style', $block_type->attributes)) {
        $block_type->attributes['style'] = array('type' => 'object');
    }
    if ($has_font_size_support && !array_key_exists('fontSize', $block_type->attributes)) {
        $block_type->attributes['fontSize'] = array('type' => 'string');
    }
}
/**
 * Add CSS classes and inline styles for typography features such as font sizes
 * to the incoming attributes array. This will be applied to the block markup in
 * the front-end.
 *
 * @since 5.6.0
 * @access private
 *
 * @param  WP_Block_Type $block_type       Block type.
 * @param  array         $block_attributes Block attributes.
 *
 * @return array Typography CSS classes and inline styles.
 */
function wp_apply_typography_support($block_type, $block_attributes)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_apply_typography_support") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/block-supports/typography.php at line 54")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_apply_typography_support:54@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/block-supports/typography.php');
    die();
}
/**
 * Generates an inline style for a typography feature e.g. text decoration,
 * text transform, and font style.
 *
 * @since 5.8.0
 * @access private
 *
 * @param array  $attributes   Block's attributes.
 * @param string $feature      Key for the feature within the typography styles.
 * @param string $css_property Slug for the CSS property the inline style sets.
 *
 * @return string              CSS inline style.
 */
function wp_typography_get_css_variable_inline_style($attributes, $feature, $css_property)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_typography_get_css_variable_inline_style") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/block-supports/typography.php at line 156")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_typography_get_css_variable_inline_style:156@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/block-supports/typography.php');
    die();
}
// Register the block support.
WP_Block_Supports::get_instance()->register('typography', array('register_attribute' => 'wp_register_typography_support', 'apply' => 'wp_apply_typography_support'));