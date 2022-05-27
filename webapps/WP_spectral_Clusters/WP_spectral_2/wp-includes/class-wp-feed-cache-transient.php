<?php

/**
 * Feed API: WP_Feed_Cache_Transient class
 *
 * @package WordPress
 * @subpackage Feed
 * @since 4.7.0
 */
/**
 * Core class used to implement feed cache transients.
 *
 * @since 2.8.0
 */
class WP_Feed_Cache_Transient
{
    /**
     * Holds the transient name.
     *
     * @since 2.8.0
     * @var string
     */
    public $name;
    /**
     * Holds the transient mod name.
     *
     * @since 2.8.0
     * @var string
     */
    public $mod_name;
    /**
     * Holds the cache duration in seconds.
     *
     * Defaults to 43200 seconds (12 hours).
     *
     * @since 2.8.0
     * @var int
     */
    public $lifetime = 43200;
    /**
     * Constructor.
     *
     * @since 2.8.0
     * @since 3.2.0 Updated to use a PHP5 constructor.
     *
     * @param string $location  URL location (scheme is used to determine handler).
     * @param string $filename  Unique identifier for cache object.
     * @param string $extension 'spi' or 'spc'.
     */
    public function __construct($location, $filename, $extension)
    {
        $this->name = 'feed_' . $filename;
        $this->mod_name = 'feed_mod_' . $filename;
        $lifetime = $this->lifetime;
        /**
         * Filters the transient lifetime of the feed cache.
         *
         * @since 2.8.0
         *
         * @param int    $lifetime Cache duration in seconds. Default is 43200 seconds (12 hours).
         * @param string $filename Unique identifier for the cache object.
         */
        $this->lifetime = apply_filters('wp_feed_cache_transient_lifetime', $lifetime, $filename);
    }
    /**
     * Sets the transient.
     *
     * @since 2.8.0
     *
     * @param SimplePie $data Data to save.
     * @return true Always true.
     */
    public function save($data)
    {
        if ($data instanceof SimplePie) {
            $data = $data->data;
        }
        set_transient($this->name, $data, $this->lifetime);
        set_transient($this->mod_name, time(), $this->lifetime);
        return true;
    }
    /**
     * Gets the transient.
     *
     * @since 2.8.0
     *
     * @return mixed Transient value.
     */
    public function load()
    {
        return get_transient($this->name);
    }
    /**
     * Gets mod transient.
     *
     * @since 2.8.0
     *
     * @return mixed Transient value.
     */
    public function mtime()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("mtime") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/class-wp-feed-cache-transient.php at line 102")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called mtime:102@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/class-wp-feed-cache-transient.php');
        die();
    }
    /**
     * Sets mod transient.
     *
     * @since 2.8.0
     *
     * @return bool False if value was not set and true if value was set.
     */
    public function touch()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("touch") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/class-wp-feed-cache-transient.php at line 113")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called touch:113@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/class-wp-feed-cache-transient.php');
        die();
    }
    /**
     * Deletes transients.
     *
     * @since 2.8.0
     *
     * @return true Always true.
     */
    public function unlink()
    {
        delete_transient($this->name);
        delete_transient($this->mod_name);
        return true;
    }
}