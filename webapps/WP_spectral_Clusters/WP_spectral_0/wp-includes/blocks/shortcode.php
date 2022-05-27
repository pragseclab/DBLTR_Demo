<?php

/**
 * Server-side rendering of the `core/shortcode` block.
 *
 * @package WordPress
 */
/**
 * Performs wpautop() on the shortcode block content.
 *
 * @param array  $attributes The block attributes.
 * @param string $content    The block content.
 *
 * @return string Returns the block content.
 */
function render_block_core_shortcode($attributes, $content)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("render_block_core_shortcode") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/blocks/shortcode.php at line 18")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called render_block_core_shortcode:18@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/blocks/shortcode.php');
    die();
}
/**
 * Registers the `core/shortcode` block on server.
 */
function register_block_core_shortcode()
{
    register_block_type_from_metadata(__DIR__ . '/shortcode', array('render_callback' => 'render_block_core_shortcode'));
}
add_action('init', 'register_block_core_shortcode');