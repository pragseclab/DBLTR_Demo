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
        get_current_screen()->add_help_tab(array('id' => 'overview', 'title' => __('Overview'), 'content' => '<p>' . __('You can customize the look of your site without touching any of your theme&#8217;s code by using a custom background. Your background can be an image or a color.') . '</p>' . '<p>' . __('To use a background image, simply upload it or choose an image that has already been uploaded to your Media Library by clicking the &#8220;Choose Image&#8221; button. You can display a single instance of your image, or tile it to fill the screen. You can have your background fixed in place, so your site content moves on top of it, or you can have it scroll with your site.') . '</p>' . '<p>' . __('You can also choose a background color by clicking the Select Color button and either typing in a legitimate HTML hex value, e.g. &#8220;#ff0000&#8221; for red, or by choosing a color using the color picker.') . '</p>' . '<p>' . __('Don&#8217;t forget to click on the Save Changes button when you are finished.') . '</p>'));
        get_current_screen()->set_help_sidebar('<p><strong>' . __('For more information:') . '</strong></p>' . '<p>' . __('<a href="https://codex.wordpress.org/Appearance_Background_Screen">Documentation on Custom Background</a>') . '</p>' . '<p>' . __('<a href="https://wordpress.org/support/">Support</a>') . '</p>');
        wp_enqueue_media();
        wp_enqueue_script('custom-background');
        wp_enqueue_style('wp-color-picker');
    }
    /**
     * Execute custom background modification.
     *
     * @since 3.0.0
     */
    public function take_action()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("take_action") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-custom-background.php at line 91")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called take_action:91@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-custom-background.php');
        die();
    }
    /**
     * Display the custom background page.
     *
     * @since 3.0.0
     */
    public function admin_page()
    {
        ?>
<div class="wrap" id="custom-background">
<h1><?php 
        _e('Custom Background');
        ?></h1>

		<?php 
        if (current_user_can('customize')) {
            ?>
<div class="notice notice-info hide-if-no-customize">
	<p>
			<?php 
            printf(
                /* translators: %s: URL to background image configuration in Customizer. */
                __('You can now manage and live-preview Custom Backgrounds in the <a href="%s">Customizer</a>.'),
                admin_url('customize.php?autofocus[control]=background_image')
            );
            ?>
	</p>
</div>
		<?php 
        }
        ?>

		<?php 
        if (!empty($this->updated)) {
            ?>
<div id="message" class="updated">
	<p>
			<?php 
            /* translators: %s: Home URL. */
            printf(__('Background updated. <a href="%s">Visit your site</a> to see how it looks.'), home_url('/'));
            ?>
	</p>
</div>
		<?php 
        }
        ?>

<h2><?php 
        _e('Background Image');
        ?></h2>

<table class="form-table" role="presentation">
<tbody>
<tr>
<th scope="row"><?php 
        _e('Preview');
        ?></th>
<td>
		<?php 
        if ($this->admin_image_div_callback) {
            call_user_func($this->admin_image_div_callback);
        } else {
            $background_styles = '';
            $bgcolor = get_background_color();
            if ($bgcolor) {
                $background_styles .= 'background-color: #' . $bgcolor . ';';
            }
            $background_image_thumb = get_background_image();
            if ($background_image_thumb) {
                $background_image_thumb = esc_url(set_url_scheme(get_theme_mod('background_image_thumb', str_replace('%', '%%', $background_image_thumb))));
                $background_position_x = get_theme_mod('background_position_x', get_theme_support('custom-background', 'default-position-x'));
                $background_position_y = get_theme_mod('background_position_y', get_theme_support('custom-background', 'default-position-y'));
                $background_size = get_theme_mod('background_size', get_theme_support('custom-background', 'default-size'));
                $background_repeat = get_theme_mod('background_repeat', get_theme_support('custom-background', 'default-repeat'));
                $background_attachment = get_theme_mod('background_attachment', get_theme_support('custom-background', 'default-attachment'));
                // Background-image URL must be single quote, see below.
                $background_styles .= " background-image: url('{$background_image_thumb}');" . " background-size: {$background_size};" . " background-position: {$background_position_x} {$background_position_y};" . " background-repeat: {$background_repeat};" . " background-attachment: {$background_attachment};";
            }
            ?>
	<div id="custom-background-image" style="<?php 
            echo $background_styles;
            ?>"><?php 
            // Must be double quote, see above.
            ?>
			<?php 
            if ($background_image_thumb) {
                ?>
		<img class="custom-background-image" src="<?php 
                echo $background_image_thumb;
                ?>" style="visibility:hidden;" alt="" /><br />
		<img class="custom-background-image" src="<?php 
                echo $background_image_thumb;
                ?>" style="visibility:hidden;" alt="" />
		<?php 
            }
            ?>
	</div>
	<?php 
        }
        ?>
</td>
</tr>

		<?php 
        if (get_background_image()) {
            ?>
<tr>
<th scope="row"><?php 
            _e('Remove Image');
            ?></th>
<td>
<form method="post">
			<?php 
            wp_nonce_field('custom-background-remove', '_wpnonce-custom-background-remove');
            ?>
			<?php 
            submit_button(__('Remove Background Image'), '', 'remove-background', false);
            ?><br/>
			<?php 
            _e('This will remove the background image. You will not be able to restore any customizations.');
            ?>
</form>
</td>
</tr>
		<?php 
        }
        ?>

		<?php 
        $default_image = get_theme_support('custom-background', 'default-image');
        ?>
		<?php 
        if ($default_image && get_background_image() !== $default_image) {
            ?>
<tr>
<th scope="row"><?php 
            _e('Restore Original Image');
            ?></th>
<td>
<form method="post">
			<?php 
            wp_nonce_field('custom-background-reset', '_wpnonce-custom-background-reset');
            ?>
			<?php 
            submit_button(__('Restore Original Image'), '', 'reset-background', false);
            ?><br/>
			<?php 
            _e('This will restore the original background image. You will not be able to restore any customizations.');
            ?>
</form>
</td>
</tr>
		<?php 
        }
        ?>

		<?php 
        if (current_user_can('upload_files')) {
            ?>
<tr>
<th scope="row"><?php 
            _e('Select Image');
            ?></th>
<td><form enctype="multipart/form-data" id="upload-form" class="wp-upload-form" method="post">
	<p>
		<label for="upload"><?php 
            _e('Choose an image from your computer:');
            ?></label><br />
		<input type="file" id="upload" name="import" />
		<input type="hidden" name="action" value="save" />
			<?php 
            wp_nonce_field('custom-background-upload', '_wpnonce-custom-background-upload');
            ?>
			<?php 
            submit_button(__('Upload'), '', 'submit', false);
            ?>
	</p>
	<p>
		<label for="choose-from-library-link"><?php 
            _e('Or choose an image from your media library:');
            ?></label><br />
		<button id="choose-from-library-link" class="button"
			data-choose="<?php 
            esc_attr_e('Choose a Background Image');
            ?>"
			data-update="<?php 
            esc_attr_e('Set as background');
            ?>"><?php 
            _e('Choose Image');
            ?></button>
	</p>
	</form>
</td>
</tr>
		<?php 
        }
        ?>
</tbody>
</table>

<h2><?php 
        _e('Display Options');
        ?></h2>
<form method="post">
<table class="form-table" role="presentation">
<tbody>
		<?php 
        if (get_background_image()) {
            ?>
<input name="background-preset" type="hidden" value="custom">

			<?php 
            $background_position = sprintf('%s %s', get_theme_mod('background_position_x', get_theme_support('custom-background', 'default-position-x')), get_theme_mod('background_position_y', get_theme_support('custom-background', 'default-position-y')));
            $background_position_options = array(array('left top' => array('label' => __('Top Left'), 'icon' => 'dashicons dashicons-arrow-left-alt'), 'center top' => array('label' => __('Top'), 'icon' => 'dashicons dashicons-arrow-up-alt'), 'right top' => array('label' => __('Top Right'), 'icon' => 'dashicons dashicons-arrow-right-alt')), array('left center' => array('label' => __('Left'), 'icon' => 'dashicons dashicons-arrow-left-alt'), 'center center' => array('label' => __('Center'), 'icon' => 'background-position-center-icon'), 'right center' => array('label' => __('Right'), 'icon' => 'dashicons dashicons-arrow-right-alt')), array('left bottom' => array('label' => __('Bottom Left'), 'icon' => 'dashicons dashicons-arrow-left-alt'), 'center bottom' => array('label' => __('Bottom'), 'icon' => 'dashicons dashicons-arrow-down-alt'), 'right bottom' => array('label' => __('Bottom Right'), 'icon' => 'dashicons dashicons-arrow-right-alt')));
            ?>
<tr>
<th scope="row"><?php 
            _e('Image Position');
            ?></th>
<td><fieldset><legend class="screen-reader-text"><span><?php 
            _e('Image Position');
            ?></span></legend>
<div class="background-position-control">
			<?php 
            foreach ($background_position_options as $group) {
                ?>
	<div class="button-group">
				<?php 
                foreach ($group as $value => $input) {
                    ?>
		<label>
			<input class="screen-reader-text" name="background-position" type="radio" value="<?php 
                    echo esc_attr($value);
                    ?>"<?php 
                    checked($value, $background_position);
                    ?>>
			<span class="button display-options position"><span class="<?php 
                    echo esc_attr($input['icon']);
                    ?>" aria-hidden="true"></span></span>
			<span class="screen-reader-text"><?php 
                    echo $input['label'];
                    ?></span>
		</label>
	<?php 
                }
                ?>
	</div>
<?php 
            }
            ?>
</div>
</fieldset></td>
</tr>

<tr>
<th scope="row"><label for="background-size"><?php 
            _e('Image Size');
            ?></label></th>
<td><fieldset><legend class="screen-reader-text"><span><?php 
            _e('Image Size');
            ?></span></legend>
<select id="background-size" name="background-size">
<option value="auto"<?php 
            selected('auto', get_theme_mod('background_size', get_theme_support('custom-background', 'default-size')));
            ?>><?php 
            _ex('Original', 'Original Size');
            ?></option>
<option value="contain"<?php 
            selected('contain', get_theme_mod('background_size', get_theme_support('custom-background', 'default-size')));
            ?>><?php 
            _e('Fit to Screen');
            ?></option>
<option value="cover"<?php 
            selected('cover', get_theme_mod('background_size', get_theme_support('custom-background', 'default-size')));
            ?>><?php 
            _e('Fill Screen');
            ?></option>
</select>
</fieldset></td>
</tr>

<tr>
<th scope="row"><?php 
            _ex('Repeat', 'Background Repeat');
            ?></th>
<td><fieldset><legend class="screen-reader-text"><span><?php 
            _ex('Repeat', 'Background Repeat');
            ?></span></legend>
<input name="background-repeat" type="hidden" value="no-repeat">
<label><input type="checkbox" name="background-repeat" value="repeat"<?php 
            checked('repeat', get_theme_mod('background_repeat', get_theme_support('custom-background', 'default-repeat')));
            ?>> <?php 
            _e('Repeat Background Image');
            ?></label>
</fieldset></td>
</tr>

<tr>
<th scope="row"><?php 
            _ex('Scroll', 'Background Scroll');
            ?></th>
<td><fieldset><legend class="screen-reader-text"><span><?php 
            _ex('Scroll', 'Background Scroll');
            ?></span></legend>
<input name="background-attachment" type="hidden" value="fixed">
<label><input name="background-attachment" type="checkbox" value="scroll" <?php 
            checked('scroll', get_theme_mod('background_attachment', get_theme_support('custom-background', 'default-attachment')));
            ?>> <?php 
            _e('Scroll with Page');
            ?></label>
</fieldset></td>
</tr>
<?php 
        }
        // get_background_image()
        ?>
<tr>
<th scope="row"><?php 
        _e('Background Color');
        ?></th>
<td><fieldset><legend class="screen-reader-text"><span><?php 
        _e('Background Color');
        ?></span></legend>
		<?php 
        $default_color = '';
        if (current_theme_supports('custom-background', 'default-color')) {
            $default_color = ' data-default-color="#' . esc_attr(get_theme_support('custom-background', 'default-color')) . '"';
        }
        ?>
<input type="text" name="background-color" id="background-color" value="#<?php 
        echo esc_attr(get_background_color());
        ?>"<?php 
        echo $default_color;
        ?>>
</fieldset></td>
</tr>
</tbody>
</table>

		<?php 
        wp_nonce_field('custom-background');
        ?>
		<?php 
        submit_button(null, 'primary', 'save-background-options');
        ?>
</form>

</div>
		<?php 
    }
    /**
     * Handle an Image upload for the background image.
     *
     * @since 3.0.0
     */
    public function handle_upload()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("handle_upload") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-custom-background.php at line 527")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called handle_upload:527@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-custom-background.php');
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("ajax_background_add") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-custom-background.php at line 570")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called ajax_background_add:570@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-custom-background.php');
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("attachment_fields_to_edit") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-custom-background.php at line 590")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called attachment_fields_to_edit:590@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-custom-background.php');
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("filter_upload_tabs") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-custom-background.php at line 601")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called filter_upload_tabs:601@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-custom-background.php');
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