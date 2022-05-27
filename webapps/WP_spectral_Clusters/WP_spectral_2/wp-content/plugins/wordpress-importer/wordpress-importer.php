<?php

/*
Plugin Name: WordPress Importer
Plugin URI: https://wordpress.org/plugins/wordpress-importer/
Description: Import posts, pages, comments, custom fields, categories, tags and more from a WordPress export file.
Author: wordpressdotorg
Author URI: https://wordpress.org/
Version: 0.7
Text Domain: wordpress-importer
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/
if (!defined('WP_LOAD_IMPORTERS')) {
    return;
}
/** Display verbose errors */
if (!defined('IMPORT_DEBUG')) {
    define('IMPORT_DEBUG', WP_DEBUG);
}
/** WordPress Import Administration API */
require_once ABSPATH . 'wp-admin/includes/import.php';
if (!class_exists('WP_Importer')) {
    $class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
    if (file_exists($class_wp_importer)) {
        require $class_wp_importer;
    }
}
/** Functions missing in older WordPress versions. */
require_once dirname(__FILE__) . '/compat.php';
/** WXR_Parser class */
require_once dirname(__FILE__) . '/parsers/class-wxr-parser.php';
/** WXR_Parser_SimpleXML class */
require_once dirname(__FILE__) . '/parsers/class-wxr-parser-simplexml.php';
/** WXR_Parser_XML class */
require_once dirname(__FILE__) . '/parsers/class-wxr-parser-xml.php';
/** WXR_Parser_Regex class */
require_once dirname(__FILE__) . '/parsers/class-wxr-parser-regex.php';
/** WP_Import class */
require_once dirname(__FILE__) . '/class-wp-import.php';
function wordpress_importer_init()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wordpress_importer_init") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-content/plugins/wordpress-importer/wordpress-importer.php at line 43")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wordpress_importer_init:43@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-content/plugins/wordpress-importer/wordpress-importer.php');
    die();
}
add_action('admin_init', 'wordpress_importer_init');