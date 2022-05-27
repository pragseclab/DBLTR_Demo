<?php

/**
 * Upgrade API: Language_Pack_Upgrader class
 *
 * @package WordPress
 * @subpackage Upgrader
 * @since 4.6.0
 */
/**
 * Core class used for updating/installing language packs (translations)
 * for plugins, themes, and core.
 *
 * @since 3.7.0
 * @since 4.6.0 Moved to its own file from wp-admin/includes/class-wp-upgrader.php.
 *
 * @see WP_Upgrader
 */
class Language_Pack_Upgrader extends WP_Upgrader
{
    /**
     * Result of the language pack upgrade.
     *
     * @since 3.7.0
     * @var array|WP_Error $result
     * @see WP_Upgrader::$result
     */
    public $result;
    /**
     * Whether a bulk upgrade/installation is being performed.
     *
     * @since 3.7.0
     * @var bool $bulk
     */
    public $bulk = true;
    /**
     * Asynchronously upgrades language packs after other upgrades have been made.
     *
     * Hooked to the {@see 'upgrader_process_complete'} action by default.
     *
     * @since 3.7.0
     *
     * @param false|WP_Upgrader $upgrader Optional. WP_Upgrader instance or false. If `$upgrader` is
     *                                    a Language_Pack_Upgrader instance, the method will bail to
     *                                    avoid recursion. Otherwise unused. Default false.
     */
    public static function async_upgrade($upgrader = false)
    {
        // Avoid recursion.
        if ($upgrader && $upgrader instanceof Language_Pack_Upgrader) {
            return;
        }
        // Nothing to do?
        $language_updates = wp_get_translation_updates();
        if (!$language_updates) {
            return;
        }
        /*
         * Avoid messing with VCS installations, at least for now.
         * Noted: this is not the ideal way to accomplish this.
         */
        $check_vcs = new WP_Automatic_Updater();
        if ($check_vcs->is_vcs_checkout(WP_CONTENT_DIR)) {
            return;
        }
        foreach ($language_updates as $key => $language_update) {
            $update = !empty($language_update->autoupdate);
            /**
             * Filters whether to asynchronously update translation for core, a plugin, or a theme.
             *
             * @since 4.0.0
             *
             * @param bool   $update          Whether to update.
             * @param object $language_update The update offer.
             */
            $update = apply_filters('async_update_translation', $update, $language_update);
            if (!$update) {
                unset($language_updates[$key]);
            }
        }
        if (empty($language_updates)) {
            return;
        }
        // Re-use the automatic upgrader skin if the parent upgrader is using it.
        if ($upgrader && $upgrader->skin instanceof Automatic_Upgrader_Skin) {
            $skin = $upgrader->skin;
        } else {
            $skin = new Language_Pack_Upgrader_Skin(array('skip_header_footer' => true));
        }
        $lp_upgrader = new Language_Pack_Upgrader($skin);
        $lp_upgrader->bulk_upgrade($language_updates);
    }
    /**
     * Initialize the upgrade strings.
     *
     * @since 3.7.0
     */
    public function upgrade_strings()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("upgrade_strings") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-admin/includes/class-language-pack-upgrader.php at line 100")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called upgrade_strings:100@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-admin/includes/class-language-pack-upgrader.php');
        die();
    }
    /**
     * Upgrade a language pack.
     *
     * @since 3.7.0
     *
     * @param string|false $update Optional. Whether an update offer is available. Default false.
     * @param array        $args   Optional. Other optional arguments, see
     *                             Language_Pack_Upgrader::bulk_upgrade(). Default empty array.
     * @return array|bool|WP_Error The result of the upgrade, or a WP_Error object instead.
     */
    public function upgrade($update = false, $args = array())
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("upgrade") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-admin/includes/class-language-pack-upgrader.php at line 123")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called upgrade:123@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-admin/includes/class-language-pack-upgrader.php');
        die();
    }
    /**
     * Bulk upgrade language packs.
     *
     * @since 3.7.0
     *
     * @global WP_Filesystem_Base $wp_filesystem WordPress filesystem subclass.
     *
     * @param object[] $language_updates Optional. Array of language packs to update. @see wp_get_translation_updates().
     *                                   Default empty array.
     * @param array    $args {
     *     Other arguments for upgrading multiple language packs. Default empty array.
     *
     *     @type bool $clear_update_cache Whether to clear the update cache when done.
     *                                    Default true.
     * }
     * @return array|bool|WP_Error Will return an array of results, or true if there are no updates,
     *                             false or WP_Error for initial errors.
     */
    public function bulk_upgrade($language_updates = array(), $args = array())
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("bulk_upgrade") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-admin/includes/class-language-pack-upgrader.php at line 152")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called bulk_upgrade:152@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-admin/includes/class-language-pack-upgrader.php');
        die();
    }
    /**
     * Checks that the package source contains .mo and .po files.
     *
     * Hooked to the {@see 'upgrader_source_selection'} filter by
     * Language_Pack_Upgrader::bulk_upgrade().
     *
     * @since 3.7.0
     *
     * @global WP_Filesystem_Base $wp_filesystem WordPress filesystem subclass.
     *
     * @param string|WP_Error $source        The path to the downloaded package source.
     * @param string          $remote_source Remote file source location.
     * @return string|WP_Error The source as passed, or a WP_Error object on failure.
     */
    public function check_package($source, $remote_source)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("check_package") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-admin/includes/class-language-pack-upgrader.php at line 262")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called check_package:262@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-admin/includes/class-language-pack-upgrader.php');
        die();
    }
    /**
     * Get the name of an item being updated.
     *
     * @since 3.7.0
     *
     * @param object $update The data for an update.
     * @return string The name of the item being updated.
     */
    public function get_name_for_update($update)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_name_for_update") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-admin/includes/class-language-pack-upgrader.php at line 298")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_name_for_update:298@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-admin/includes/class-language-pack-upgrader.php');
        die();
    }
    /**
     * Clears existing translations where this item is going to be installed into.
     *
     * @since 5.1.0
     *
     * @global WP_Filesystem_Base $wp_filesystem WordPress filesystem subclass.
     *
     * @param string $remote_destination The location on the remote filesystem to be cleared.
     * @return bool|WP_Error True upon success, WP_Error on failure.
     */
    public function clear_destination($remote_destination)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("clear_destination") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-admin/includes/class-language-pack-upgrader.php at line 330")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called clear_destination:330@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-admin/includes/class-language-pack-upgrader.php');
        die();
    }
}