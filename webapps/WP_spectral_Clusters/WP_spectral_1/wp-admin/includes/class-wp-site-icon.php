<?php

/**
 * Administration API: WP_Site_Icon class
 *
 * @package WordPress
 * @subpackage Administration
 * @since 4.3.0
 */
/**
 * Core class used to implement site icon functionality.
 *
 * @since 4.3.0
 */
class WP_Site_Icon
{
    /**
     * The minimum size of the site icon.
     *
     * @since 4.3.0
     * @var int
     */
    public $min_size = 512;
    /**
     * The size to which to crop the image so that we can display it in the UI nicely.
     *
     * @since 4.3.0
     * @var int
     */
    public $page_crop = 512;
    /**
     * List of site icon sizes.
     *
     * @since 4.3.0
     * @var int[]
     */
    public $site_icon_sizes = array(
        /*
         * Square, medium sized tiles for IE11+.
         *
         * See https://msdn.microsoft.com/library/dn455106(v=vs.85).aspx
         */
        270,
        /*
         * App icon for Android/Chrome.
         *
         * @link https://developers.google.com/web/updates/2014/11/Support-for-theme-color-in-Chrome-39-for-Android
         * @link https://developer.chrome.com/multidevice/android/installtohomescreen
         */
        192,
        /*
         * App icons up to iPhone 6 Plus.
         *
         * See https://developer.apple.com/library/prerelease/ios/documentation/UserExperience/Conceptual/MobileHIG/IconMatrix.html
         */
        180,
        // Our regular Favicon.
        32,
    );
    /**
     * Registers actions and filters.
     *
     * @since 4.3.0
     */
    public function __construct()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("__construct") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-admin/includes/class-wp-site-icon.php at line 67")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called __construct:67@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-admin/includes/class-wp-site-icon.php');
        die();
    }
    /**
     * Creates an attachment 'object'.
     *
     * @since 4.3.0
     *
     * @param string $cropped              Cropped image URL.
     * @param int    $parent_attachment_id Attachment ID of parent image.
     * @return array Attachment object.
     */
    public function create_attachment_object($cropped, $parent_attachment_id)
    {
        $parent = get_post($parent_attachment_id);
        $parent_url = wp_get_attachment_url($parent->ID);
        $url = str_replace(wp_basename($parent_url), wp_basename($cropped), $parent_url);
        $size = wp_getimagesize($cropped);
        $image_type = $size ? $size['mime'] : 'image/jpeg';
        $object = array('ID' => $parent_attachment_id, 'post_title' => wp_basename($cropped), 'post_content' => $url, 'post_mime_type' => $image_type, 'guid' => $url, 'context' => 'site-icon');
        return $object;
    }
    /**
     * Inserts an attachment.
     *
     * @since 4.3.0
     *
     * @param array  $object Attachment object.
     * @param string $file   File path of the attached image.
     * @return int           Attachment ID
     */
    public function insert_attachment($object, $file)
    {
        $attachment_id = wp_insert_attachment($object, $file);
        $metadata = wp_generate_attachment_metadata($attachment_id, $file);
        /**
         * Filters the site icon attachment metadata.
         *
         * @since 4.3.0
         *
         * @see wp_generate_attachment_metadata()
         *
         * @param array $metadata Attachment metadata.
         */
        $metadata = apply_filters('site_icon_attachment_metadata', $metadata);
        wp_update_attachment_metadata($attachment_id, $metadata);
        return $attachment_id;
    }
    /**
     * Adds additional sizes to be made when creating the site icon images.
     *
     * @since 4.3.0
     *
     * @param array[] $sizes Array of arrays containing information for additional sizes.
     * @return array[] Array of arrays containing additional image sizes.
     */
    public function additional_sizes($sizes = array())
    {
        $only_crop_sizes = array();
        /**
         * Filters the different dimensions that a site icon is saved in.
         *
         * @since 4.3.0
         *
         * @param int[] $site_icon_sizes Array of sizes available for the Site Icon.
         */
        $this->site_icon_sizes = apply_filters('site_icon_image_sizes', $this->site_icon_sizes);
        // Use a natural sort of numbers.
        natsort($this->site_icon_sizes);
        $this->site_icon_sizes = array_reverse($this->site_icon_sizes);
        // Ensure that we only resize the image into sizes that allow cropping.
        foreach ($sizes as $name => $size_array) {
            if (isset($size_array['crop'])) {
                $only_crop_sizes[$name] = $size_array;
            }
        }
        foreach ($this->site_icon_sizes as $size) {
            if ($size < $this->min_size) {
                $only_crop_sizes['site_icon-' . $size] = array('width ' => $size, 'height' => $size, 'crop' => true);
            }
        }
        return $only_crop_sizes;
    }
    /**
     * Adds Site Icon sizes to the array of image sizes on demand.
     *
     * @since 4.3.0
     *
     * @param string[] $sizes Array of image size names.
     * @return string[] Array of image size names.
     */
    public function intermediate_image_sizes($sizes = array())
    {
        /** This filter is documented in wp-admin/includes/class-wp-site-icon.php */
        $this->site_icon_sizes = apply_filters('site_icon_image_sizes', $this->site_icon_sizes);
        foreach ($this->site_icon_sizes as $size) {
            $sizes[] = 'site_icon-' . $size;
        }
        return $sizes;
    }
    /**
     * Deletes the Site Icon when the image file is deleted.
     *
     * @since 4.3.0
     *
     * @param int $post_id Attachment ID.
     */
    public function delete_attachment_data($post_id)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("delete_attachment_data") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-admin/includes/class-wp-site-icon.php at line 176")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called delete_attachment_data:176@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-admin/includes/class-wp-site-icon.php');
        die();
    }
    /**
     * Adds custom image sizes when meta data for an image is requested, that happens to be used as Site Icon.
     *
     * @since 4.3.0
     *
     * @param null|array|string $value    The value get_metadata() should return a single metadata value, or an
     *                                    array of values.
     * @param int               $post_id  Post ID.
     * @param string            $meta_key Meta key.
     * @param bool              $single   Whether to return only the first value of the specified `$meta_key`.
     * @return array|null|string The attachment metadata value, array of values, or null.
     */
    public function get_post_metadata($value, $post_id, $meta_key, $single)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_post_metadata") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-admin/includes/class-wp-site-icon.php at line 195")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_post_metadata:195@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-admin/includes/class-wp-site-icon.php');
        die();
    }
}