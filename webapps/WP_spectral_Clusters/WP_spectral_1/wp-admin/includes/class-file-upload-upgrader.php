<?php

/**
 * Upgrade API: File_Upload_Upgrader class
 *
 * @package WordPress
 * @subpackage Upgrader
 * @since 4.6.0
 */
/**
 * Core class used for handling file uploads.
 *
 * This class handles the upload process and passes it as if it's a local file
 * to the Upgrade/Installer functions.
 *
 * @since 2.8.0
 * @since 4.6.0 Moved to its own file from wp-admin/includes/class-wp-upgrader.php.
 */
class File_Upload_Upgrader
{
    /**
     * The full path to the file package.
     *
     * @since 2.8.0
     * @var string $package
     */
    public $package;
    /**
     * The name of the file.
     *
     * @since 2.8.0
     * @var string $filename
     */
    public $filename;
    /**
     * The ID of the attachment post for this file.
     *
     * @since 3.3.0
     * @var int $id
     */
    public $id = 0;
    /**
     * Construct the upgrader for a form.
     *
     * @since 2.8.0
     *
     * @param string $form      The name of the form the file was uploaded from.
     * @param string $urlholder The name of the `GET` parameter that holds the filename.
     */
    public function __construct($form, $urlholder)
    {
        if (empty($_FILES[$form]['name']) && empty($_GET[$urlholder])) {
            wp_die(__('Please select a file'));
        }
        // Handle a newly uploaded file. Else, assume it's already been uploaded.
        if (!empty($_FILES)) {
            $overrides = array('test_form' => false, 'test_type' => false);
            $file = wp_handle_upload($_FILES[$form], $overrides);
            if (isset($file['error'])) {
                wp_die($file['error']);
            }
            $this->filename = $_FILES[$form]['name'];
            $this->package = $file['file'];
            // Construct the object array.
            $object = array('post_title' => $this->filename, 'post_content' => $file['url'], 'post_mime_type' => $file['type'], 'guid' => $file['url'], 'context' => 'upgrader', 'post_status' => 'private');
            // Save the data.
            $this->id = wp_insert_attachment($object, $file['file']);
            // Schedule a cleanup for 2 hours from now in case of failed installation.
            wp_schedule_single_event(time() + 2 * HOUR_IN_SECONDS, 'upgrader_scheduled_cleanup', array($this->id));
        } elseif (is_numeric($_GET[$urlholder])) {
            // Numeric Package = previously uploaded file, see above.
            $this->id = (int) $_GET[$urlholder];
            $attachment = get_post($this->id);
            if (empty($attachment)) {
                wp_die(__('Please select a file'));
            }
            $this->filename = $attachment->post_title;
            $this->package = get_attached_file($attachment->ID);
        } else {
            // Else, It's set to something, Back compat for plugins using the old (pre-3.3) File_Uploader handler.
            $uploads = wp_upload_dir();
            if (!($uploads && false === $uploads['error'])) {
                wp_die($uploads['error']);
            }
            $this->filename = sanitize_file_name($_GET[$urlholder]);
            $this->package = $uploads['basedir'] . '/' . $this->filename;
            if (0 !== strpos(realpath($this->package), realpath($uploads['basedir']))) {
                wp_die(__('Please select a file'));
            }
        }
    }
    /**
     * Delete the attachment/uploaded file.
     *
     * @since 3.2.2
     *
     * @return bool Whether the cleanup was successful.
     */
    public function cleanup()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("cleanup") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-admin/includes/class-file-upload-upgrader.php at line 101")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called cleanup:101@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-admin/includes/class-file-upload-upgrader.php');
        die();
    }
}