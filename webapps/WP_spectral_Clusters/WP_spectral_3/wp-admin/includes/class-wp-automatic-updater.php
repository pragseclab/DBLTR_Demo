<?php

/**
 * Upgrade API: WP_Automatic_Updater class
 *
 * @package WordPress
 * @subpackage Upgrader
 * @since 4.6.0
 */
/**
 * Core class used for handling automatic background updates.
 *
 * @since 3.7.0
 * @since 4.6.0 Moved to its own file from wp-admin/includes/class-wp-upgrader.php.
 */
class WP_Automatic_Updater
{
    /**
     * Tracks update results during processing.
     *
     * @var array
     */
    protected $update_results = array();
    /**
     * Whether the entire automatic updater is disabled.
     *
     * @since 3.7.0
     */
    public function is_disabled()
    {
        // Background updates are disabled if you don't want file changes.
        if (!wp_is_file_mod_allowed('automatic_updater')) {
            return true;
        }
        if (wp_installing()) {
            return true;
        }
        // More fine grained control can be done through the WP_AUTO_UPDATE_CORE constant and filters.
        $disabled = defined('AUTOMATIC_UPDATER_DISABLED') && AUTOMATIC_UPDATER_DISABLED;
        /**
         * Filters whether to entirely disable background updates.
         *
         * There are more fine-grained filters and controls for selective disabling.
         * This filter parallels the AUTOMATIC_UPDATER_DISABLED constant in name.
         *
         * This also disables update notification emails. That may change in the future.
         *
         * @since 3.7.0
         *
         * @param bool $disabled Whether the updater should be disabled.
         */
        return apply_filters('automatic_updater_disabled', $disabled);
    }
    /**
     * Check for version control checkouts.
     *
     * Checks for Subversion, Git, Mercurial, and Bazaar. It recursively looks up the
     * filesystem to the top of the drive, erring on the side of detecting a VCS
     * checkout somewhere.
     *
     * ABSPATH is always checked in addition to whatever `$context` is (which may be the
     * wp-content directory, for example). The underlying assumption is that if you are
     * using version control *anywhere*, then you should be making decisions for
     * how things get updated.
     *
     * @since 3.7.0
     *
     * @param string $context The filesystem path to check, in addition to ABSPATH.
     * @return bool True if a VCS checkout was discovered at `$context` or ABSPATH,
     *              or anywhere higher. False otherwise.
     */
    public function is_vcs_checkout($context)
    {
        $context_dirs = array(untrailingslashit($context));
        if (ABSPATH !== $context) {
            $context_dirs[] = untrailingslashit(ABSPATH);
        }
        $vcs_dirs = array('.svn', '.git', '.hg', '.bzr');
        $check_dirs = array();
        foreach ($context_dirs as $context_dir) {
            // Walk up from $context_dir to the root.
            do {
                $check_dirs[] = $context_dir;
                // Once we've hit '/' or 'C:\', we need to stop. dirname will keep returning the input here.
                if (dirname($context_dir) === $context_dir) {
                    break;
                }
                // Continue one level at a time.
            } while ($context_dir = dirname($context_dir));
        }
        $check_dirs = array_unique($check_dirs);
        // Search all directories we've found for evidence of version control.
        foreach ($vcs_dirs as $vcs_dir) {
            foreach ($check_dirs as $check_dir) {
                $checkout = @is_dir(rtrim($check_dir, '\\/') . "/{$vcs_dir}");
                if ($checkout) {
                    break 2;
                }
            }
        }
        /**
         * Filters whether the automatic updater should consider a filesystem
         * location to be potentially managed by a version control system.
         *
         * @since 3.7.0
         *
         * @param bool $checkout  Whether a VCS checkout was discovered at `$context`
         *                        or ABSPATH, or anywhere higher.
         * @param string $context The filesystem context (a path) against which
         *                        filesystem status should be checked.
         */
        return apply_filters('automatic_updates_is_vcs_checkout', $checkout, $context);
    }
    /**
     * Tests to see if we can and should update a specific item.
     *
     * @since 3.7.0
     *
     * @global wpdb $wpdb WordPress database abstraction object.
     *
     * @param string $type    The type of update being checked: 'core', 'theme',
     *                        'plugin', 'translation'.
     * @param object $item    The update offer.
     * @param string $context The filesystem context (a path) against which filesystem
     *                        access and status should be checked.
     * @return bool True if the item should be updated, false otherwise.
     */
    public function should_update($type, $item, $context)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("should_update") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-automatic-updater.php at line 131")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called should_update:131@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-automatic-updater.php');
        die();
    }
    /**
     * Notifies an administrator of a core update.
     *
     * @since 3.7.0
     *
     * @param object $item The update offer.
     * @return bool True if the site administrator is notified of a core update,
     *              false otherwise.
     */
    protected function send_core_update_notification_email($item)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("send_core_update_notification_email") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-automatic-updater.php at line 231")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called send_core_update_notification_email:231@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-automatic-updater.php');
        die();
    }
    /**
     * Update an item, if appropriate.
     *
     * @since 3.7.0
     *
     * @param string $type The type of update being checked: 'core', 'theme', 'plugin', 'translation'.
     * @param object $item The update offer.
     * @return null|WP_Error
     */
    public function update($type, $item)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("update") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-automatic-updater.php at line 274")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called update:274@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-automatic-updater.php');
        die();
    }
    /**
     * Kicks off the background update process, looping through all pending updates.
     *
     * @since 3.7.0
     */
    public function run()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("run") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-automatic-updater.php at line 393")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called run:393@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-automatic-updater.php');
        die();
    }
    /**
     * If we tried to perform a core update, check if we should send an email,
     * and if we need to avoid processing future updates.
     *
     * @since 3.7.0
     *
     * @param object $update_result The result of the core update. Includes the update offer and result.
     */
    protected function after_core_update($update_result)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("after_core_update") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-automatic-updater.php at line 510")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called after_core_update:510@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-automatic-updater.php');
        die();
    }
    /**
     * Sends an email upon the completion or failure of a background core update.
     *
     * @since 3.7.0
     *
     * @param string $type        The type of email to send. Can be one of 'success', 'fail', 'manual', 'critical'.
     * @param object $core_update The update offer that was attempted.
     * @param mixed  $result      Optional. The result for the core update. Can be WP_Error.
     */
    protected function send_email($type, $core_update, $result = null)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("send_email") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-automatic-updater.php at line 578")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called send_email:578@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-automatic-updater.php');
        die();
    }
    /**
     * If we tried to perform plugin or theme updates, check if we should send an email.
     *
     * @since 5.5.0
     *
     * @param array $update_results The results of update tasks.
     */
    protected function after_plugin_theme_update($update_results)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("after_plugin_theme_update") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-automatic-updater.php at line 783")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called after_plugin_theme_update:783@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-automatic-updater.php');
        die();
    }
    /**
     * Sends an email upon the completion or failure of a plugin or theme background update.
     *
     * @since 5.5.0
     *
     * @param string $type               The type of email to send. Can be one of 'success', 'fail', 'mixed'.
     * @param array  $successful_updates A list of updates that succeeded.
     * @param array  $failed_updates     A list of updates that failed.
     */
    protected function send_plugin_theme_email($type, $successful_updates, $failed_updates)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("send_plugin_theme_email") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-automatic-updater.php at line 850")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called send_plugin_theme_email:850@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-automatic-updater.php');
        die();
    }
    /**
     * Prepares and sends an email of a full log of background update results, useful for debugging and geekery.
     *
     * @since 3.7.0
     */
    protected function send_debug_email()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("send_debug_email") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-automatic-updater.php at line 1100")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called send_debug_email:1100@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-automatic-updater.php');
        die();
    }
}