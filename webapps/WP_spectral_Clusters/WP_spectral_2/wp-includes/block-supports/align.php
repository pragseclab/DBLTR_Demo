<?php

/**
 * Align block support flag.
 *
 * @package WordPress
 * @since 5.6.0
 */
/**
 * Registers the align block attribute for block types that support it.
 *
 * @since 5.6.0
 * @access private
 *
 * @param WP_Block_Type $block_type Block Type.
 */
function wp_register_alignment_support($block_type)
{
    $has_align_support = block_has_support($block_type, array('align'), false);
    if ($has_align_support) {
        if (!$block_type->attributes) {
            $block_type->attributes = array();
        }
        if (!array_key_exists('align', $block_type->attributes)) {
            $block_type->attributes['align'] = array('type' => 'string', 'enum' => array('left', 'center', 'right', 'wide', 'full', ''));
        }
    }
}
/**
 * Add CSS classes for block alignment to the incoming attributes array.
 * This will be applied to the block markup in the front-end.
 *
 * @since 5.6.0
 * @access private
 *
 * @param WP_Block_Type $block_type       Block Type.
 * @param array         $block_attributes Block attributes.
 *
 * @return array Block alignment CSS classes and inline styles.
 */
function wp_apply_alignment_support($block_type, $block_attributes)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_apply_alignment_support") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/block-supports/align.php at line 43")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_apply_alignment_support:43@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/block-supports/align.php');
    die();
}
// Register the block support.
WP_Block_Supports::get_instance()->register('align', array('register_attribute' => 'wp_register_alignment_support', 'apply' => 'wp_apply_alignment_support'));