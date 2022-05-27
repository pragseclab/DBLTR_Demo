<?php

/**
 * Base WordPress Filesystem
 *
 * @package WordPress
 * @subpackage Filesystem
 */
/**
 * Base WordPress Filesystem class which Filesystem implementations extend.
 *
 * @since 2.5.0
 */
class WP_Filesystem_Base
{
    /**
     * Whether to display debug data for the connection.
     *
     * @since 2.5.0
     * @var bool
     */
    public $verbose = false;
    /**
     * Cached list of local filepaths to mapped remote filepaths.
     *
     * @since 2.7.0
     * @var array
     */
    public $cache = array();
    /**
     * The Access method of the current connection, Set automatically.
     *
     * @since 2.5.0
     * @var string
     */
    public $method = '';
    /**
     * @var WP_Error
     */
    public $errors = null;
    /**
     */
    public $options = array();
    /**
     * Returns the path on the remote filesystem of ABSPATH.
     *
     * @since 2.7.0
     *
     * @return string The location of the remote path.
     */
    public function abspath()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("abspath") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php at line 53")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called abspath:53@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php');
        die();
    }
    /**
     * Returns the path on the remote filesystem of WP_CONTENT_DIR.
     *
     * @since 2.7.0
     *
     * @return string The location of the remote path.
     */
    public function wp_content_dir()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_content_dir") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php at line 70")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_content_dir:70@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php');
        die();
    }
    /**
     * Returns the path on the remote filesystem of WP_PLUGIN_DIR.
     *
     * @since 2.7.0
     *
     * @return string The location of the remote path.
     */
    public function wp_plugins_dir()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_plugins_dir") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php at line 81")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_plugins_dir:81@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php');
        die();
    }
    /**
     * Returns the path on the remote filesystem of the Themes Directory.
     *
     * @since 2.7.0
     *
     * @param string|false $theme Optional. The theme stylesheet or template for the directory.
     *                            Default false.
     * @return string The location of the remote path.
     */
    public function wp_themes_dir($theme = false)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_themes_dir") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php at line 94")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_themes_dir:94@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php');
        die();
    }
    /**
     * Returns the path on the remote filesystem of WP_LANG_DIR.
     *
     * @since 3.2.0
     *
     * @return string The location of the remote path.
     */
    public function wp_lang_dir()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_lang_dir") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php at line 110")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_lang_dir:110@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php');
        die();
    }
    /**
     * Locates a folder on the remote filesystem.
     *
     * @since 2.5.0
     * @deprecated 2.7.0 use WP_Filesystem_Base::abspath() or WP_Filesystem_Base::wp_*_dir() instead.
     * @see WP_Filesystem_Base::abspath()
     * @see WP_Filesystem_Base::wp_content_dir()
     * @see WP_Filesystem_Base::wp_plugins_dir()
     * @see WP_Filesystem_Base::wp_themes_dir()
     * @see WP_Filesystem_Base::wp_lang_dir()
     *
     * @param string $base The folder to start searching from.
     * @param bool   $echo True to display debug information.
     *                     Default false.
     * @return string The location of the remote path.
     */
    public function find_base_dir($base = '.', $echo = false)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("find_base_dir") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php at line 130")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called find_base_dir:130@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php');
        die();
    }
    /**
     * Locates a folder on the remote filesystem.
     *
     * @since 2.5.0
     * @deprecated 2.7.0 use WP_Filesystem_Base::abspath() or WP_Filesystem_Base::wp_*_dir() methods instead.
     * @see WP_Filesystem_Base::abspath()
     * @see WP_Filesystem_Base::wp_content_dir()
     * @see WP_Filesystem_Base::wp_plugins_dir()
     * @see WP_Filesystem_Base::wp_themes_dir()
     * @see WP_Filesystem_Base::wp_lang_dir()
     *
     * @param string $base The folder to start searching from.
     * @param bool   $echo True to display debug information.
     * @return string The location of the remote path.
     */
    public function get_base_dir($base = '.', $echo = false)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_base_dir") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php at line 151")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_base_dir:151@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php');
        die();
    }
    /**
     * Locates a folder on the remote filesystem.
     *
     * Assumes that on Windows systems, Stripping off the Drive
     * letter is OK Sanitizes \\ to / in Windows filepaths.
     *
     * @since 2.7.0
     *
     * @param string $folder the folder to locate.
     * @return string|false The location of the remote path, false on failure.
     */
    public function find_folder($folder)
    {
        if (isset($this->cache[$folder])) {
            return $this->cache[$folder];
        }
        if (stripos($this->method, 'ftp') !== false) {
            $constant_overrides = array('FTP_BASE' => ABSPATH, 'FTP_CONTENT_DIR' => WP_CONTENT_DIR, 'FTP_PLUGIN_DIR' => WP_PLUGIN_DIR, 'FTP_LANG_DIR' => WP_LANG_DIR);
            // Direct matches ( folder = CONSTANT/ ).
            foreach ($constant_overrides as $constant => $dir) {
                if (!defined($constant)) {
                    continue;
                }
                if ($folder === $dir) {
                    return trailingslashit(constant($constant));
                }
            }
            // Prefix matches ( folder = CONSTANT/subdir ),
            foreach ($constant_overrides as $constant => $dir) {
                if (!defined($constant)) {
                    continue;
                }
                if (0 === stripos($folder, $dir)) {
                    // $folder starts with $dir.
                    $potential_folder = preg_replace('#^' . preg_quote($dir, '#') . '/#i', trailingslashit(constant($constant)), $folder);
                    $potential_folder = trailingslashit($potential_folder);
                    if ($this->is_dir($potential_folder)) {
                        $this->cache[$folder] = $potential_folder;
                        return $potential_folder;
                    }
                }
            }
        } elseif ('direct' === $this->method) {
            $folder = str_replace('\\', '/', $folder);
            // Windows path sanitisation.
            return trailingslashit($folder);
        }
        $folder = preg_replace('|^([a-z]{1}):|i', '', $folder);
        // Strip out Windows drive letter if it's there.
        $folder = str_replace('\\', '/', $folder);
        // Windows path sanitisation.
        if (isset($this->cache[$folder])) {
            return $this->cache[$folder];
        }
        if ($this->exists($folder)) {
            // Folder exists at that absolute path.
            $folder = trailingslashit($folder);
            $this->cache[$folder] = $folder;
            return $folder;
        }
        $return = $this->search_for_folder($folder);
        if ($return) {
            $this->cache[$folder] = $return;
        }
        return $return;
    }
    /**
     * Locates a folder on the remote filesystem.
     *
     * Expects Windows sanitized path.
     *
     * @since 2.7.0
     *
     * @param string $folder The folder to locate.
     * @param string $base   The folder to start searching from.
     * @param bool   $loop   If the function has recursed. Internal use only.
     * @return string|false The location of the remote path, false to cease looping.
     */
    public function search_for_folder($folder, $base = '.', $loop = false)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("search_for_folder") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php at line 235")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called search_for_folder:235@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php');
        die();
    }
    /**
     * Returns the *nix-style file permissions for a file.
     *
     * From the PHP documentation page for fileperms().
     *
     * @link https://www.php.net/manual/en/function.fileperms.php
     *
     * @since 2.5.0
     *
     * @param string $file String filename.
     * @return string The *nix-style representation of permissions.
     */
    public function gethchmod($file)
    {
        $perms = intval($this->getchmod($file), 8);
        if (($perms & 0xc000) === 0xc000) {
            // Socket.
            $info = 's';
        } elseif (($perms & 0xa000) === 0xa000) {
            // Symbolic Link.
            $info = 'l';
        } elseif (($perms & 0x8000) === 0x8000) {
            // Regular.
            $info = '-';
        } elseif (($perms & 0x6000) === 0x6000) {
            // Block special.
            $info = 'b';
        } elseif (($perms & 0x4000) === 0x4000) {
            // Directory.
            $info = 'd';
        } elseif (($perms & 0x2000) === 0x2000) {
            // Character special.
            $info = 'c';
        } elseif (($perms & 0x1000) === 0x1000) {
            // FIFO pipe.
            $info = 'p';
        } else {
            // Unknown.
            $info = 'u';
        }
        // Owner.
        $info .= $perms & 0x100 ? 'r' : '-';
        $info .= $perms & 0x80 ? 'w' : '-';
        $info .= $perms & 0x40 ? $perms & 0x800 ? 's' : 'x' : ($perms & 0x800 ? 'S' : '-');
        // Group.
        $info .= $perms & 0x20 ? 'r' : '-';
        $info .= $perms & 0x10 ? 'w' : '-';
        $info .= $perms & 0x8 ? $perms & 0x400 ? 's' : 'x' : ($perms & 0x400 ? 'S' : '-');
        // World.
        $info .= $perms & 0x4 ? 'r' : '-';
        $info .= $perms & 0x2 ? 'w' : '-';
        $info .= $perms & 0x1 ? $perms & 0x200 ? 't' : 'x' : ($perms & 0x200 ? 'T' : '-');
        return $info;
    }
    /**
     * Gets the permissions of the specified file or filepath in their octal format.
     *
     * @since 2.5.0
     *
     * @param string $file Path to the file.
     * @return string Mode of the file (the last 3 digits).
     */
    public function getchmod($file)
    {
        return '777';
    }
    /**
     * Converts *nix-style file permissions to a octal number.
     *
     * Converts '-rw-r--r--' to 0644
     * From "info at rvgate dot nl"'s comment on the PHP documentation for chmod()
     *
     * @link https://www.php.net/manual/en/function.chmod.php#49614
     *
     * @since 2.5.0
     *
     * @param string $mode string The *nix-style file permission.
     * @return int octal representation
     */
    public function getnumchmodfromh($mode)
    {
        $realmode = '';
        $legal = array('', 'w', 'r', 'x', '-');
        $attarray = preg_split('//', $mode);
        for ($i = 0, $c = count($attarray); $i < $c; $i++) {
            $key = array_search($attarray[$i], $legal, true);
            if ($key) {
                $realmode .= $legal[$key];
            }
        }
        $mode = str_pad($realmode, 10, '-', STR_PAD_LEFT);
        $trans = array('-' => '0', 'r' => '4', 'w' => '2', 'x' => '1');
        $mode = strtr($mode, $trans);
        $newmode = $mode[0];
        $newmode .= $mode[1] + $mode[2] + $mode[3];
        $newmode .= $mode[4] + $mode[5] + $mode[6];
        $newmode .= $mode[7] + $mode[8] + $mode[9];
        return $newmode;
    }
    /**
     * Determines if the string provided contains binary characters.
     *
     * @since 2.7.0
     *
     * @param string $text String to test against.
     * @return bool True if string is binary, false otherwise.
     */
    public function is_binary($text)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("is_binary") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php at line 402")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called is_binary:402@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php');
        die();
    }
    /**
     * Changes the owner of a file or directory.
     *
     * Default behavior is to do nothing, override this in your subclass, if desired.
     *
     * @since 2.5.0
     *
     * @param string     $file      Path to the file or directory.
     * @param string|int $owner     A user name or number.
     * @param bool       $recursive Optional. If set to true, changes file owner recursively.
     *                              Default false.
     * @return bool True on success, false on failure.
     */
    public function chown($file, $owner, $recursive = false)
    {
        return false;
    }
    /**
     * Connects filesystem.
     *
     * @since 2.5.0
     * @abstract
     *
     * @return bool True on success, false on failure (always true for WP_Filesystem_Direct).
     */
    public function connect()
    {
        return true;
    }
    /**
     * Reads entire file into a string.
     *
     * @since 2.5.0
     * @abstract
     *
     * @param string $file Name of the file to read.
     * @return string|false Read data on success, false on failure.
     */
    public function get_contents($file)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_contents") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php at line 445")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_contents:445@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php');
        die();
    }
    /**
     * Reads entire file into an array.
     *
     * @since 2.5.0
     * @abstract
     *
     * @param string $file Path to the file.
     * @return array|false File contents in an array on success, false on failure.
     */
    public function get_contents_array($file)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_contents_array") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php at line 458")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_contents_array:458@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php');
        die();
    }
    /**
     * Writes a string to a file.
     *
     * @since 2.5.0
     * @abstract
     *
     * @param string    $file     Remote path to the file where to write the data.
     * @param string    $contents The data to write.
     * @param int|false $mode     Optional. The file permissions as octal number, usually 0644.
     *                            Default false.
     * @return bool True on success, false on failure.
     */
    public function put_contents($file, $contents, $mode = false)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("put_contents") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php at line 474")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called put_contents:474@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php');
        die();
    }
    /**
     * Gets the current working directory.
     *
     * @since 2.5.0
     * @abstract
     *
     * @return string|false The current working directory on success, false on failure.
     */
    public function cwd()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("cwd") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php at line 486")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called cwd:486@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php');
        die();
    }
    /**
     * Changes current directory.
     *
     * @since 2.5.0
     * @abstract
     *
     * @param string $dir The new current directory.
     * @return bool True on success, false on failure.
     */
    public function chdir($dir)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("chdir") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php at line 499")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called chdir:499@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php');
        die();
    }
    /**
     * Changes the file group.
     *
     * @since 2.5.0
     * @abstract
     *
     * @param string     $file      Path to the file.
     * @param string|int $group     A group name or number.
     * @param bool       $recursive Optional. If set to true, changes file group recursively.
     *                              Default false.
     * @return bool True on success, false on failure.
     */
    public function chgrp($file, $group, $recursive = false)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("chgrp") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php at line 515")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called chgrp:515@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php');
        die();
    }
    /**
     * Changes filesystem permissions.
     *
     * @since 2.5.0
     * @abstract
     *
     * @param string    $file      Path to the file.
     * @param int|false $mode      Optional. The permissions as octal number, usually 0644 for files,
     *                             0755 for directories. Default false.
     * @param bool      $recursive Optional. If set to true, changes file permissions recursively.
     *                             Default false.
     * @return bool True on success, false on failure.
     */
    public function chmod($file, $mode = false, $recursive = false)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("chmod") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php at line 532")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called chmod:532@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php');
        die();
    }
    /**
     * Gets the file owner.
     *
     * @since 2.5.0
     * @abstract
     *
     * @param string $file Path to the file.
     * @return string|false Username of the owner on success, false on failure.
     */
    public function owner($file)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("owner") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php at line 545")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called owner:545@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php');
        die();
    }
    /**
     * Gets the file's group.
     *
     * @since 2.5.0
     * @abstract
     *
     * @param string $file Path to the file.
     * @return string|false The group on success, false on failure.
     */
    public function group($file)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("group") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php at line 558")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called group:558@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php');
        die();
    }
    /**
     * Copies a file.
     *
     * @since 2.5.0
     * @abstract
     *
     * @param string    $source      Path to the source file.
     * @param string    $destination Path to the destination file.
     * @param bool      $overwrite   Optional. Whether to overwrite the destination file if it exists.
     *                               Default false.
     * @param int|false $mode        Optional. The permissions as octal number, usually 0644 for files,
     *                               0755 for dirs. Default false.
     * @return bool True on success, false on failure.
     */
    public function copy($source, $destination, $overwrite = false, $mode = false)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("copy") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php at line 576")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called copy:576@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php');
        die();
    }
    /**
     * Moves a file.
     *
     * @since 2.5.0
     * @abstract
     *
     * @param string $source      Path to the source file.
     * @param string $destination Path to the destination file.
     * @param bool   $overwrite   Optional. Whether to overwrite the destination file if it exists.
     *                            Default false.
     * @return bool True on success, false on failure.
     */
    public function move($source, $destination, $overwrite = false)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("move") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php at line 592")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called move:592@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php');
        die();
    }
    /**
     * Deletes a file or directory.
     *
     * @since 2.5.0
     * @abstract
     *
     * @param string       $file      Path to the file or directory.
     * @param bool         $recursive Optional. If set to true, deletes files and folders recursively.
     *                                Default false.
     * @param string|false $type      Type of resource. 'f' for file, 'd' for directory.
     *                                Default false.
     * @return bool True on success, false on failure.
     */
    public function delete($file, $recursive = false, $type = false)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("delete") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php at line 609")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called delete:609@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php');
        die();
    }
    /**
     * Checks if a file or directory exists.
     *
     * @since 2.5.0
     * @abstract
     *
     * @param string $file Path to file or directory.
     * @return bool Whether $file exists or not.
     */
    public function exists($file)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("exists") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php at line 622")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called exists:622@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php');
        die();
    }
    /**
     * Checks if resource is a file.
     *
     * @since 2.5.0
     * @abstract
     *
     * @param string $file File path.
     * @return bool Whether $file is a file.
     */
    public function is_file($file)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("is_file") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php at line 635")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called is_file:635@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php');
        die();
    }
    /**
     * Checks if resource is a directory.
     *
     * @since 2.5.0
     * @abstract
     *
     * @param string $path Directory path.
     * @return bool Whether $path is a directory.
     */
    public function is_dir($path)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("is_dir") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php at line 648")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called is_dir:648@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php');
        die();
    }
    /**
     * Checks if a file is readable.
     *
     * @since 2.5.0
     * @abstract
     *
     * @param string $file Path to file.
     * @return bool Whether $file is readable.
     */
    public function is_readable($file)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("is_readable") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php at line 661")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called is_readable:661@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php');
        die();
    }
    /**
     * Checks if a file or directory is writable.
     *
     * @since 2.5.0
     * @abstract
     *
     * @param string $file Path to file or directory.
     * @return bool Whether $file is writable.
     */
    public function is_writable($file)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("is_writable") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php at line 674")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called is_writable:674@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php');
        die();
    }
    /**
     * Gets the file's last access time.
     *
     * @since 2.5.0
     * @abstract
     *
     * @param string $file Path to file.
     * @return int|false Unix timestamp representing last access time, false on failure.
     */
    public function atime($file)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("atime") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php at line 687")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called atime:687@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php');
        die();
    }
    /**
     * Gets the file modification time.
     *
     * @since 2.5.0
     * @abstract
     *
     * @param string $file Path to file.
     * @return int|false Unix timestamp representing modification time, false on failure.
     */
    public function mtime($file)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("mtime") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php at line 700")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called mtime:700@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php');
        die();
    }
    /**
     * Gets the file size (in bytes).
     *
     * @since 2.5.0
     * @abstract
     *
     * @param string $file Path to file.
     * @return int|false Size of the file in bytes on success, false on failure.
     */
    public function size($file)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("size") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php at line 713")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called size:713@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php');
        die();
    }
    /**
     * Sets the access and modification times of a file.
     *
     * Note: If $file doesn't exist, it will be created.
     *
     * @since 2.5.0
     * @abstract
     *
     * @param string $file  Path to file.
     * @param int    $time  Optional. Modified time to set for file.
     *                      Default 0.
     * @param int    $atime Optional. Access time to set for file.
     *                      Default 0.
     * @return bool True on success, false on failure.
     */
    public function touch($file, $time = 0, $atime = 0)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("touch") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php at line 732")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called touch:732@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php');
        die();
    }
    /**
     * Creates a directory.
     *
     * @since 2.5.0
     * @abstract
     *
     * @param string           $path  Path for new directory.
     * @param int|false        $chmod Optional. The permissions as octal number (or false to skip chmod).
     *                                Default false.
     * @param string|int|false $chown Optional. A user name or number (or false to skip chown).
     *                                Default false.
     * @param string|int|false $chgrp Optional. A group name or number (or false to skip chgrp).
     *                                Default false.
     * @return bool True on success, false on failure.
     */
    public function mkdir($path, $chmod = false, $chown = false, $chgrp = false)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("mkdir") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php at line 751")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called mkdir:751@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php');
        die();
    }
    /**
     * Deletes a directory.
     *
     * @since 2.5.0
     * @abstract
     *
     * @param string $path      Path to directory.
     * @param bool   $recursive Optional. Whether to recursively remove files/directories.
     *                          Default false.
     * @return bool True on success, false on failure.
     */
    public function rmdir($path, $recursive = false)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("rmdir") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php at line 766")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called rmdir:766@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php');
        die();
    }
    /**
     * Gets details for files in a directory or a specific file.
     *
     * @since 2.5.0
     * @abstract
     *
     * @param string $path           Path to directory or file.
     * @param bool   $include_hidden Optional. Whether to include details of hidden ("." prefixed) files.
     *                               Default true.
     * @param bool   $recursive      Optional. Whether to recursively include file details in nested directories.
     *                               Default false.
     * @return array|false {
     *     Array of files. False if unable to list directory contents.
     *
     *     @type string $name        Name of the file or directory.
     *     @type string $perms       *nix representation of permissions.
     *     @type int    $permsn      Octal representation of permissions.
     *     @type string $owner       Owner name or ID.
     *     @type int    $size        Size of file in bytes.
     *     @type int    $lastmodunix Last modified unix timestamp.
     *     @type mixed  $lastmod     Last modified month (3 letter) and day (without leading 0).
     *     @type int    $time        Last modified time.
     *     @type string $type        Type of resource. 'f' for file, 'd' for directory.
     *     @type mixed  $files       If a directory and $recursive is true, contains another array of files.
     * }
     */
    public function dirlist($path, $include_hidden = true, $recursive = false)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("dirlist") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php at line 796")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called dirlist:796@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-filesystem-base.php');
        die();
    }
}