<?php

/**
 * Helper functions for displaying a list of items in an ajaxified HTML table.
 *
 * @package WordPress
 * @subpackage List_Table
 * @since 3.1.0
 */
/**
 * Fetches an instance of a WP_List_Table class.
 *
 * @access private
 * @since 3.1.0
 *
 * @global string $hook_suffix
 *
 * @param string $class The type of the list table, which is the class name.
 * @param array  $args  Optional. Arguments to pass to the class. Accepts 'screen'.
 * @return WP_List_Table|false List table object on success, false if the class does not exist.
 */
function _get_list_table($class, $args = array())
{
    $core_classes = array(
        // Site Admin.
        'WP_Posts_List_Table' => 'posts',
        'WP_Media_List_Table' => 'media',
        'WP_Terms_List_Table' => 'terms',
        'WP_Users_List_Table' => 'users',
        'WP_Comments_List_Table' => 'comments',
        'WP_Post_Comments_List_Table' => array('comments', 'post-comments'),
        'WP_Links_List_Table' => 'links',
        'WP_Plugin_Install_List_Table' => 'plugin-install',
        'WP_Themes_List_Table' => 'themes',
        'WP_Theme_Install_List_Table' => array('themes', 'theme-install'),
        'WP_Plugins_List_Table' => 'plugins',
        'WP_Application_Passwords_List_Table' => 'application-passwords',
        // Network Admin.
        'WP_MS_Sites_List_Table' => 'ms-sites',
        'WP_MS_Users_List_Table' => 'ms-users',
        'WP_MS_Themes_List_Table' => 'ms-themes',
        // Privacy requests tables.
        'WP_Privacy_Data_Export_Requests_List_Table' => 'privacy-data-export-requests',
        'WP_Privacy_Data_Removal_Requests_List_Table' => 'privacy-data-removal-requests',
    );
    if (isset($core_classes[$class])) {
        foreach ((array) $core_classes[$class] as $required) {
            require_once ABSPATH . 'wp-admin/includes/class-wp-' . $required . '-list-table.php';
        }
        if (isset($args['screen'])) {
            $args['screen'] = convert_to_screen($args['screen']);
        } elseif (isset($GLOBALS['hook_suffix'])) {
            $args['screen'] = get_current_screen();
        } else {
            $args['screen'] = null;
        }
        return new $class($args);
    }
    return false;
}
/**
 * Register column headers for a particular screen.
 *
 * @see get_column_headers(), print_column_headers(), get_hidden_columns()
 *
 * @since 2.7.0
 *
 * @param string    $screen The handle for the screen to register column headers for. This is
 *                          usually the hook name returned by the `add_*_page()` functions.
 * @param string[] $columns An array of columns with column IDs as the keys and translated
 *                          column names as the values.
 */
function register_column_headers($screen, $columns)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("register_column_headers") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-admin/includes/list-table.php at line 75")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called register_column_headers:75@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-admin/includes/list-table.php');
    die();
}
/**
 * Prints column headers for a particular screen.
 *
 * @since 2.7.0
 *
 * @param string|WP_Screen $screen  The screen hook name or screen object.
 * @param bool             $with_id Whether to set the ID attribute or not.
 */
function print_column_headers($screen, $with_id = true)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("print_column_headers") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-admin/includes/list-table.php at line 87")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called print_column_headers:87@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-admin/includes/list-table.php');
    die();
}