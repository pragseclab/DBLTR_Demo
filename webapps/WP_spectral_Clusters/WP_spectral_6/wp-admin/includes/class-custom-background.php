<?php

/**
 * The custom background script.
 *
 * @package WordPress
 * @subpackage Administration
 */
/**
 * The custom background class.
 *
 * @since 3.0.0
 */
class Custom_Background
{
    /**
     * Callback for administration header.
     *
     * @var callable
     * @since 3.0.0
     */
    public $admin_header_callback;
    /**
     * Callback for header div.
     *
     * @var callable
     * @since 3.0.0
     */
    public $admin_image_div_callback;
    /**
     * Used to trigger a success message when settings updated and set to true.
     *
     * @since 3.0.0
     * @var bool
     */
    private $updated;
    /**
     * Constructor - Register administration header callback.
     *
     * @since 3.0.0
     * @param callable $admin_header_callback
     * @param callable $admin_image_div_callback Optional custom image div output callback.
     */
    public function __construct($admin_header_callback = '', $admin_image_div_callback = '')
    {
        $this->admin_header_callback = $admin_header_callback;
        $this->admin_image_div_callback = $admin_image_div_callback;
        add_action('admin_menu', array($this, 'init'));
        add_action('wp_ajax_custom-background-add', array($this, 'ajax_background_add'));
        // Unused since 3.5.0.
        add_action('wp_ajax_set-background-image', array($this, 'wp_set_background_image'));
    }
    /**
     * Set up the hooks for the Custom Background admin page.
     *
     * @since 3.0.0
     */
    public function init()
    {
        $page = add_theme_page(__('Background'), __('Background'), 'edit_theme_options', 'custom-background', array($this, 'admin_page'));
        if (!$page) {
            return;
        }
        add_action("load-{$page}", array($this, 'admin_load'));
        add_action("load-{$page}", array($this, 'take_action'), 49);
        add_action("load-{$page}", array($this, 'handle_upload'), 49);
        if ($this->admin_header_callback) {
            add_action("admin_head-{$page}", $this->admin_header_callback, 51);
        }
    }
    /**
     * Set up the enqueue for the CSS & JavaScript files.
     *
     * @since 3.0.0
     */
    public function admin_load()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("admin_load") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/class-custom-background.php at line 78")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called admin_load:78@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/class-custom-background.php');
        die();
    }
    /**
     * Execute custom background modification.
     *
     * @since 3.0.0
     */
    public function take_action()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("take_action") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/class-custom-background.php at line 91")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called take_action:91@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/class-custom-background.php');
        die();
    }
    /**
     * Display the custom background page.
     *
     * @since 3.0.0
     */
    public function admin_page()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("admin_page") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/class-custom-background.php at line 179")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called admin_page:179@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/class-custom-background.php');
        die();
    }
    /**
     * Handle an Image upload for the background image.
     *
     * @since 3.0.0
     */
    public function handle_upload()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("handle_upload") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/class-custom-background.php at line 527")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called handle_upload:527@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/class-custom-background.php');
        die();
    }
    /**
     * Ajax handler for adding custom background context to an attachment.
     *
     * Triggers when the user adds a new background image from the
     * Media Manager.
     *
     * @since 4.1.0
     */
    public function ajax_background_add()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("ajax_background_add") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/class-custom-background.php at line 570")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called ajax_background_add:570@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/class-custom-background.php');
        die();
    }
    /**
     * @since 3.4.0
     * @deprecated 3.5.0
     *
     * @param array $form_fields
     * @return array $form_fields
     */
    public function attachment_fields_to_edit($form_fields)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("attachment_fields_to_edit") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/class-custom-background.php at line 590")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called attachment_fields_to_edit:590@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/class-custom-background.php');
        die();
    }
    /**
     * @since 3.4.0
     * @deprecated 3.5.0
     *
     * @param array $tabs
     * @return array $tabs
     */
    public function filter_upload_tabs($tabs)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("filter_upload_tabs") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/class-custom-background.php at line 601")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called filter_upload_tabs:601@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/class-custom-background.php');
        die();
    }
    /**
     * @since 3.4.0
     * @deprecated 3.5.0
     */
    public function wp_set_background_image()
    {
        check_ajax_referer('custom-background');
        if (!current_user_can('edit_theme_options') || !isset($_POST['attachment_id'])) {
            exit;
        }
        $attachment_id = absint($_POST['attachment_id']);
        $sizes = array_keys(
            /** This filter is documented in wp-admin/includes/media.php */
            apply_filters('image_size_names_choose', array('thumbnail' => __('Thumbnail'), 'medium' => __('Medium'), 'large' => __('Large'), 'full' => __('Full Size')))
        );
        $size = 'thumbnail';
        if (in_array($_POST['size'], $sizes, true)) {
            $size = esc_attr($_POST['size']);
        }
        update_post_meta($attachment_id, '_wp_attachment_is_custom_background', get_option('stylesheet'));
        $url = wp_get_attachment_image_src($attachment_id, $size);
        $thumbnail = wp_get_attachment_image_src($attachment_id, 'thumbnail');
        set_theme_mod('background_image', esc_url_raw($url[0]));
        set_theme_mod('background_image_thumb', esc_url_raw($thumbnail[0]));
        exit;
    }
}