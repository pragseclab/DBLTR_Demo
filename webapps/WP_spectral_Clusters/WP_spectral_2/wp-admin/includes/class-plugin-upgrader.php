<?php

/**
 * Upgrade API: Plugin_Upgrader class
 *
 * @package WordPress
 * @subpackage Upgrader
 * @since 4.6.0
 */
/**
 * Core class used for upgrading/installing plugins.
 *
 * It is designed to upgrade/install plugins from a local zip, remote zip URL,
 * or uploaded zip file.
 *
 * @since 2.8.0
 * @since 4.6.0 Moved to its own file from wp-admin/includes/class-wp-upgrader.php.
 *
 * @see WP_Upgrader
 */
class Plugin_Upgrader extends WP_Upgrader
{
    /**
     * Plugin upgrade result.
     *
     * @since 2.8.0
     * @var array|WP_Error $result
     *
     * @see WP_Upgrader::$result
     */
    public $result;
    /**
     * Whether a bulk upgrade/installation is being performed.
     *
     * @since 2.9.0
     * @var bool $bulk
     */
    public $bulk = false;
    /**
     * New plugin info.
     *
     * @since 5.5.0
     * @var array $new_plugin_data
     *
     * @see check_package()
     */
    public $new_plugin_data = array();
    /**
     * Initialize the upgrade strings.
     *
     * @since 2.8.0
     */
    public function upgrade_strings()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("upgrade_strings") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/class-plugin-upgrader.php at line 55")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called upgrade_strings:55@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/class-plugin-upgrader.php');
        die();
    }
    /**
     * Initialize the installation strings.
     *
     * @since 2.8.0
     */
    public function install_strings()
    {
        $this->strings['no_package'] = __('Installation package not available.');
        /* translators: %s: Package URL. */
        $this->strings['downloading_package'] = sprintf(__('Downloading installation package from %s&#8230;'), '<span class="code">%s</span>');
        $this->strings['unpack_package'] = __('Unpacking the package&#8230;');
        $this->strings['installing_package'] = __('Installing the plugin&#8230;');
        $this->strings['remove_old'] = __('Removing the current plugin&#8230;');
        $this->strings['remove_old_failed'] = __('Could not remove the current plugin.');
        $this->strings['no_files'] = __('The plugin contains no files.');
        $this->strings['process_failed'] = __('Plugin installation failed.');
        $this->strings['process_success'] = __('Plugin installed successfully.');
        /* translators: 1: Plugin name, 2: Plugin version. */
        $this->strings['process_success_specific'] = __('Successfully installed the plugin <strong>%1$s %2$s</strong>.');
        if (!empty($this->skin->overwrite)) {
            if ('update-plugin' === $this->skin->overwrite) {
                $this->strings['installing_package'] = __('Updating the plugin&#8230;');
                $this->strings['process_failed'] = __('Plugin update failed.');
                $this->strings['process_success'] = __('Plugin updated successfully.');
            }
            if ('downgrade-plugin' === $this->skin->overwrite) {
                $this->strings['installing_package'] = __('Downgrading the plugin&#8230;');
                $this->strings['process_failed'] = __('Plugin downgrade failed.');
                $this->strings['process_success'] = __('Plugin downgraded successfully.');
            }
        }
    }
    /**
     * Install a plugin package.
     *
     * @since 2.8.0
     * @since 3.7.0 The `$args` parameter was added, making clearing the plugin update cache optional.
     *
     * @param string $package The full local path or URI of the package.
     * @param array  $args {
     *     Optional. Other arguments for installing a plugin package. Default empty array.
     *
     *     @type bool $clear_update_cache Whether to clear the plugin updates cache if successful.
     *                                    Default true.
     * }
     * @return bool|WP_Error True if the installation was successful, false or a WP_Error otherwise.
     */
    public function install($package, $args = array())
    {
        $defaults = array('clear_update_cache' => true, 'overwrite_package' => false);
        $parsed_args = wp_parse_args($args, $defaults);
        $this->init();
        $this->install_strings();
        add_filter('upgrader_source_selection', array($this, 'check_package'));
        if ($parsed_args['clear_update_cache']) {
            // Clear cache so wp_update_plugins() knows about the new plugin.
            add_action('upgrader_process_complete', 'wp_clean_plugins_cache', 9, 0);
        }
        $this->run(array('package' => $package, 'destination' => WP_PLUGIN_DIR, 'clear_destination' => $parsed_args['overwrite_package'], 'clear_working' => true, 'hook_extra' => array('type' => 'plugin', 'action' => 'install')));
        remove_action('upgrader_process_complete', 'wp_clean_plugins_cache', 9);
        remove_filter('upgrader_source_selection', array($this, 'check_package'));
        if (!$this->result || is_wp_error($this->result)) {
            return $this->result;
        }
        // Force refresh of plugin update information.
        wp_clean_plugins_cache($parsed_args['clear_update_cache']);
        if ($parsed_args['overwrite_package']) {
            /**
             * Fires when the upgrader has successfully overwritten a currently installed
             * plugin or theme with an uploaded zip package.
             *
             * @since 5.5.0
             *
             * @param string  $package      The package file.
             * @param array   $data         The new plugin or theme data.
             * @param string  $package_type The package type ('plugin' or 'theme').
             */
            do_action('upgrader_overwrote_package', $package, $this->new_plugin_data, 'plugin');
        }
        return true;
    }
    /**
     * Upgrade a plugin.
     *
     * @since 2.8.0
     * @since 3.7.0 The `$args` parameter was added, making clearing the plugin update cache optional.
     *
     * @param string $plugin Path to the plugin file relative to the plugins directory.
     * @param array  $args {
     *     Optional. Other arguments for upgrading a plugin package. Default empty array.
     *
     *     @type bool $clear_update_cache Whether to clear the plugin updates cache if successful.
     *                                    Default true.
     * }
     * @return bool|WP_Error True if the upgrade was successful, false or a WP_Error object otherwise.
     */
    public function upgrade($plugin, $args = array())
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("upgrade") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/class-plugin-upgrader.php at line 164")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called upgrade:164@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/class-plugin-upgrader.php');
        die();
    }
    /**
     * Bulk upgrade several plugins at once.
     *
     * @since 2.8.0
     * @since 3.7.0 The `$args` parameter was added, making clearing the plugin update cache optional.
     *
     * @param string[] $plugins Array of paths to plugin files relative to the plugins directory.
     * @param array    $args {
     *     Optional. Other arguments for upgrading several plugins at once.
     *
     *     @type bool $clear_update_cache Whether to clear the plugin updates cache if successful. Default true.
     * }
     * @return array|false An array of results indexed by plugin file, or false if unable to connect to the filesystem.
     */
    public function bulk_upgrade($plugins, $args = array())
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("bulk_upgrade") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/class-plugin-upgrader.php at line 225")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called bulk_upgrade:225@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/class-plugin-upgrader.php');
        die();
    }
    /**
     * Checks that the source package contains a valid plugin.
     *
     * Hooked to the {@see 'upgrader_source_selection'} filter by Plugin_Upgrader::install().
     *
     * @since 3.3.0
     *
     * @global WP_Filesystem_Base $wp_filesystem WordPress filesystem subclass.
     * @global string             $wp_version    The WordPress version string.
     *
     * @param string $source The path to the downloaded package source.
     * @return string|WP_Error The source as passed, or a WP_Error object on failure.
     */
    public function check_package($source)
    {
        global $wp_filesystem, $wp_version;
        $this->new_plugin_data = array();
        if (is_wp_error($source)) {
            return $source;
        }
        $working_directory = str_replace($wp_filesystem->wp_content_dir(), trailingslashit(WP_CONTENT_DIR), $source);
        if (!is_dir($working_directory)) {
            // Sanity check, if the above fails, let's not prevent installation.
            return $source;
        }
        // Check that the folder contains at least 1 valid plugin.
        $files = glob($working_directory . '*.php');
        if ($files) {
            foreach ($files as $file) {
                $info = get_plugin_data($file, false, false);
                if (!empty($info['Name'])) {
                    $this->new_plugin_data = $info;
                    break;
                }
            }
        }
        if (empty($this->new_plugin_data)) {
            return new WP_Error('incompatible_archive_no_plugins', $this->strings['incompatible_archive'], __('No valid plugins were found.'));
        }
        $requires_php = isset($info['RequiresPHP']) ? $info['RequiresPHP'] : null;
        $requires_wp = isset($info['RequiresWP']) ? $info['RequiresWP'] : null;
        if (!is_php_version_compatible($requires_php)) {
            $error = sprintf(
                /* translators: 1: Current PHP version, 2: Version required by the uploaded plugin. */
                __('The PHP version on your server is %1$s, however the uploaded plugin requires %2$s.'),
                phpversion(),
                $requires_php
            );
            return new WP_Error('incompatible_php_required_version', $this->strings['incompatible_archive'], $error);
        }
        if (!is_wp_version_compatible($requires_wp)) {
            $error = sprintf(
                /* translators: 1: Current WordPress version, 2: Version required by the uploaded plugin. */
                __('Your WordPress version is %1$s, however the uploaded plugin requires %2$s.'),
                $wp_version,
                $requires_wp
            );
            return new WP_Error('incompatible_wp_required_version', $this->strings['incompatible_archive'], $error);
        }
        return $source;
    }
    /**
     * Retrieve the path to the file that contains the plugin info.
     *
     * This isn't used internally in the class, but is called by the skins.
     *
     * @since 2.8.0
     *
     * @return string|false The full path to the main plugin file, or false.
     */
    public function plugin_info()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("plugin_info") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/class-plugin-upgrader.php at line 372")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called plugin_info:372@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/class-plugin-upgrader.php');
        die();
    }
    /**
     * Deactivates a plugin before it is upgraded.
     *
     * Hooked to the {@see 'upgrader_pre_install'} filter by Plugin_Upgrader::upgrade().
     *
     * @since 2.8.0
     * @since 4.1.0 Added a return value.
     *
     * @param bool|WP_Error $return Upgrade offer return.
     * @param array         $plugin Plugin package arguments.
     * @return bool|WP_Error The passed in $return param or WP_Error.
     */
    public function deactivate_plugin_before_upgrade($return, $plugin)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("deactivate_plugin_before_upgrade") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/class-plugin-upgrader.php at line 401")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called deactivate_plugin_before_upgrade:401@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/class-plugin-upgrader.php');
        die();
    }
    /**
     * Turns on maintenance mode before attempting to background update an active plugin.
     *
     * Hooked to the {@see 'upgrader_pre_install'} filter by Plugin_Upgrader::upgrade().
     *
     * @since 5.4.0
     *
     * @param bool|WP_Error $return Upgrade offer return.
     * @param array         $plugin Plugin package arguments.
     * @return bool|WP_Error The passed in $return param or WP_Error.
     */
    public function active_before($return, $plugin)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("active_before") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/class-plugin-upgrader.php at line 432")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called active_before:432@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/class-plugin-upgrader.php');
        die();
    }
    /**
     * Turns off maintenance mode after upgrading an active plugin.
     *
     * Hooked to the {@see 'upgrader_post_install'} filter by Plugin_Upgrader::upgrade().
     *
     * @since 5.4.0
     *
     * @param bool|WP_Error $return Upgrade offer return.
     * @param array         $plugin Plugin package arguments.
     * @return bool|WP_Error The passed in $return param or WP_Error.
     */
    public function active_after($return, $plugin)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("active_after") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/class-plugin-upgrader.php at line 463")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called active_after:463@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/class-plugin-upgrader.php');
        die();
    }
    /**
     * Deletes the old plugin during an upgrade.
     *
     * Hooked to the {@see 'upgrader_clear_destination'} filter by
     * Plugin_Upgrader::upgrade() and Plugin_Upgrader::bulk_upgrade().
     *
     * @since 2.8.0
     *
     * @global WP_Filesystem_Base $wp_filesystem WordPress filesystem subclass.
     *
     * @param bool|WP_Error $removed            Whether the destination was cleared.
     *                                          True on success, WP_Error on failure.
     * @param string        $local_destination  The local package destination.
     * @param string        $remote_destination The remote package destination.
     * @param array         $plugin             Extra arguments passed to hooked filters.
     * @return bool|WP_Error
     */
    public function delete_old_plugin($removed, $local_destination, $remote_destination, $plugin)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("delete_old_plugin") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/class-plugin-upgrader.php at line 500")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called delete_old_plugin:500@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/class-plugin-upgrader.php');
        die();
    }
}