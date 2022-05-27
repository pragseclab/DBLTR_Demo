<?php

/**
 * Administration API: WP_Internal_Pointers class
 *
 * @package WordPress
 * @subpackage Administration
 * @since 4.4.0
 */
/**
 * Core class used to implement an internal admin pointers API.
 *
 * @since 3.3.0
 */
final class WP_Internal_Pointers
{
    /**
     * Initializes the new feature pointers.
     *
     * @since 3.3.0
     *
     * All pointers can be disabled using the following:
     *     remove_action( 'admin_enqueue_scripts', array( 'WP_Internal_Pointers', 'enqueue_scripts' ) );
     *
     * Individual pointers (e.g. wp390_widgets) can be disabled using the following:
     *
     *    function yourprefix_remove_pointers() {
     *        remove_action(
     *            'admin_print_footer_scripts',
     *            array( 'WP_Internal_Pointers', 'pointer_wp390_widgets' )
     *        );
     *    }
     *    add_action( 'admin_enqueue_scripts', 'yourprefix_remove_pointers', 11 );
     *
     * @param string $hook_suffix The current admin page.
     */
    public static function enqueue_scripts($hook_suffix)
    {
        /*
         * Register feature pointers
         *
         * Format:
         *     array(
         *         hook_suffix => pointer callback
         *     )
         *
         * Example:
         *     array(
         *         'themes.php' => 'wp390_widgets'
         *     )
         */
        $registered_pointers = array();
        // Check if screen related pointer is registered.
        if (empty($registered_pointers[$hook_suffix])) {
            return;
        }
        $pointers = (array) $registered_pointers[$hook_suffix];
        /*
         * Specify required capabilities for feature pointers
         *
         * Format:
         *     array(
         *         pointer callback => Array of required capabilities
         *     )
         *
         * Example:
         *     array(
         *         'wp390_widgets' => array( 'edit_theme_options' )
         *     )
         */
        $caps_required = array();
        // Get dismissed pointers.
        $dismissed = explode(',', (string) get_user_meta(get_current_user_id(), 'dismissed_wp_pointers', true));
        $got_pointers = false;
        foreach (array_diff($pointers, $dismissed) as $pointer) {
            if (isset($caps_required[$pointer])) {
                foreach ($caps_required[$pointer] as $cap) {
                    if (!current_user_can($cap)) {
                        continue 2;
                    }
                }
            }
            // Bind pointer print function.
            add_action('admin_print_footer_scripts', array('WP_Internal_Pointers', 'pointer_' . $pointer));
            $got_pointers = true;
        }
        if (!$got_pointers) {
            return;
        }
        // Add pointers script and style to queue.
        wp_enqueue_style('wp-pointer');
        wp_enqueue_script('wp-pointer');
    }
    /**
     * Print the pointer JavaScript data.
     *
     * @since 3.3.0
     *
     * @param string $pointer_id The pointer ID.
     * @param string $selector The HTML elements, on which the pointer should be attached.
     * @param array  $args Arguments to be passed to the pointer JS (see wp-pointer.js).
     */
    private static function print_js($pointer_id, $selector, $args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("print_js") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/class-wp-internal-pointers.php at line 105")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called print_js:105@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/class-wp-internal-pointers.php');
        die();
    }
    public static function pointer_wp330_toolbar()
    {
    }
    public static function pointer_wp330_media_uploader()
    {
    }
    public static function pointer_wp330_saving_widgets()
    {
    }
    public static function pointer_wp340_customize_current_theme_link()
    {
    }
    public static function pointer_wp340_choose_image_from_library()
    {
    }
    public static function pointer_wp350_media()
    {
    }
    public static function pointer_wp360_revisions()
    {
    }
    public static function pointer_wp360_locks()
    {
    }
    public static function pointer_wp390_widgets()
    {
    }
    public static function pointer_wp410_dfw()
    {
    }
    public static function pointer_wp496_privacy()
    {
    }
    /**
     * Prevents new users from seeing existing 'new feature' pointers.
     *
     * @since 3.3.0
     *
     * @param int $user_id User ID.
     */
    public static function dismiss_pointers_for_new_users($user_id)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("dismiss_pointers_for_new_users") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/class-wp-internal-pointers.php at line 186")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called dismiss_pointers_for_new_users:186@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/class-wp-internal-pointers.php');
        die();
    }
}