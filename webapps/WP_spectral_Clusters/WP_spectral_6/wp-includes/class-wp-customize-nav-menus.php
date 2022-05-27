<?php

/**
 * WordPress Customize Nav Menus classes
 *
 * @package WordPress
 * @subpackage Customize
 * @since 4.3.0
 */
/**
 * Customize Nav Menus class.
 *
 * Implements menu management in the Customizer.
 *
 * @since 4.3.0
 *
 * @see WP_Customize_Manager
 */
final class WP_Customize_Nav_Menus
{
    /**
     * WP_Customize_Manager instance.
     *
     * @since 4.3.0
     * @var WP_Customize_Manager
     */
    public $manager;
    /**
     * Original nav menu locations before the theme was switched.
     *
     * @since 4.9.0
     * @var array
     */
    protected $original_nav_menu_locations;
    /**
     * Constructor.
     *
     * @since 4.3.0
     *
     * @param WP_Customize_Manager $manager Customizer bootstrap instance.
     */
    public function __construct($manager)
    {
        $this->manager = $manager;
        $this->original_nav_menu_locations = get_nav_menu_locations();
        // See https://github.com/xwp/wp-customize-snapshots/blob/962586659688a5b1fd9ae93618b7ce2d4e7a421c/php/class-customize-snapshot-manager.php#L469-L499
        add_action('customize_register', array($this, 'customize_register'), 11);
        add_filter('customize_dynamic_setting_args', array($this, 'filter_dynamic_setting_args'), 10, 2);
        add_filter('customize_dynamic_setting_class', array($this, 'filter_dynamic_setting_class'), 10, 3);
        add_action('customize_save_nav_menus_created_posts', array($this, 'save_nav_menus_created_posts'));
        // Skip remaining hooks when the user can't manage nav menus anyway.
        if (!current_user_can('edit_theme_options')) {
            return;
        }
        add_filter('customize_refresh_nonces', array($this, 'filter_nonces'));
        add_action('wp_ajax_load-available-menu-items-customizer', array($this, 'ajax_load_available_items'));
        add_action('wp_ajax_search-available-menu-items-customizer', array($this, 'ajax_search_available_items'));
        add_action('wp_ajax_customize-nav-menus-insert-auto-draft', array($this, 'ajax_insert_auto_draft_post'));
        add_action('customize_controls_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('customize_controls_print_footer_scripts', array($this, 'print_templates'));
        add_action('customize_controls_print_footer_scripts', array($this, 'available_items_template'));
        add_action('customize_preview_init', array($this, 'customize_preview_init'));
        add_action('customize_preview_init', array($this, 'make_auto_draft_status_previewable'));
        // Selective Refresh partials.
        add_filter('customize_dynamic_partial_args', array($this, 'customize_dynamic_partial_args'), 10, 2);
    }
    /**
     * Adds a nonce for customizing menus.
     *
     * @since 4.5.0
     *
     * @param string[] $nonces Array of nonces.
     * @return string[] Modified array of nonces.
     */
    public function filter_nonces($nonces)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("filter_nonces") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-customize-nav-menus.php at line 77")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called filter_nonces:77@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-customize-nav-menus.php');
        die();
    }
    /**
     * Ajax handler for loading available menu items.
     *
     * @since 4.3.0
     */
    public function ajax_load_available_items()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("ajax_load_available_items") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-customize-nav-menus.php at line 87")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called ajax_load_available_items:87@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-customize-nav-menus.php');
        die();
    }
    /**
     * Performs the post_type and taxonomy queries for loading available menu items.
     *
     * @since 4.3.0
     *
     * @param string $type   Optional. Accepts any custom object type and has built-in support for
     *                         'post_type' and 'taxonomy'. Default is 'post_type'.
     * @param string $object Optional. Accepts any registered taxonomy or post type name. Default is 'page'.
     * @param int    $page   Optional. The page number used to generate the query offset. Default is '0'.
     * @return array|WP_Error An array of menu items on success, a WP_Error object on failure.
     */
    public function load_available_items_query($type = 'post_type', $object = 'page', $page = 0)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("load_available_items_query") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-customize-nav-menus.php at line 129")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called load_available_items_query:129@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-customize-nav-menus.php');
        die();
    }
    /**
     * Ajax handler for searching available menu items.
     *
     * @since 4.3.0
     */
    public function ajax_search_available_items()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("ajax_search_available_items") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-customize-nav-menus.php at line 230")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called ajax_search_available_items:230@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-customize-nav-menus.php');
        die();
    }
    /**
     * Performs post queries for available-item searching.
     *
     * Based on WP_Editor::wp_link_query().
     *
     * @since 4.3.0
     *
     * @param array $args Optional. Accepts 'pagenum' and 's' (search) arguments.
     * @return array Menu items.
     */
    public function search_available_items_query($args = array())
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("search_available_items_query") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-customize-nav-menus.php at line 261")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called search_available_items_query:261@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-customize-nav-menus.php');
        die();
    }
    /**
     * Enqueue scripts and styles for Customizer pane.
     *
     * @since 4.3.0
     */
    public function enqueue_scripts()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("enqueue_scripts") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-customize-nav-menus.php at line 332")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called enqueue_scripts:332@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-customize-nav-menus.php');
        die();
    }
    /**
     * Filters a dynamic setting's constructor args.
     *
     * For a dynamic setting to be registered, this filter must be employed
     * to override the default false value with an array of args to pass to
     * the WP_Customize_Setting constructor.
     *
     * @since 4.3.0
     *
     * @param false|array $setting_args The arguments to the WP_Customize_Setting constructor.
     * @param string      $setting_id   ID for dynamic setting, usually coming from `$_POST['customized']`.
     * @return array|false
     */
    public function filter_dynamic_setting_args($setting_args, $setting_id)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("filter_dynamic_setting_args") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-customize-nav-menus.php at line 417")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called filter_dynamic_setting_args:417@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-customize-nav-menus.php');
        die();
    }
    /**
     * Allow non-statically created settings to be constructed with custom WP_Customize_Setting subclass.
     *
     * @since 4.3.0
     *
     * @param string $setting_class WP_Customize_Setting or a subclass.
     * @param string $setting_id    ID for dynamic setting, usually coming from `$_POST['customized']`.
     * @param array  $setting_args  WP_Customize_Setting or a subclass.
     * @return string
     */
    public function filter_dynamic_setting_class($setting_class, $setting_id, $setting_args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("filter_dynamic_setting_class") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-customize-nav-menus.php at line 436")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called filter_dynamic_setting_class:436@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-customize-nav-menus.php');
        die();
    }
    /**
     * Add the customizer settings and controls.
     *
     * @since 4.3.0
     */
    public function customize_register()
    {
        $changeset = $this->manager->unsanitized_post_values();
        // Preview settings for nav menus early so that the sections and controls will be added properly.
        $nav_menus_setting_ids = array();
        foreach (array_keys($changeset) as $setting_id) {
            if (preg_match('/^(nav_menu_locations|nav_menu|nav_menu_item)\\[/', $setting_id)) {
                $nav_menus_setting_ids[] = $setting_id;
            }
        }
        $settings = $this->manager->add_dynamic_settings($nav_menus_setting_ids);
        if ($this->manager->settings_previewed()) {
            foreach ($settings as $setting) {
                $setting->preview();
            }
        }
        // Require JS-rendered control types.
        $this->manager->register_panel_type('WP_Customize_Nav_Menus_Panel');
        $this->manager->register_control_type('WP_Customize_Nav_Menu_Control');
        $this->manager->register_control_type('WP_Customize_Nav_Menu_Name_Control');
        $this->manager->register_control_type('WP_Customize_Nav_Menu_Locations_Control');
        $this->manager->register_control_type('WP_Customize_Nav_Menu_Auto_Add_Control');
        $this->manager->register_control_type('WP_Customize_Nav_Menu_Item_Control');
        // Create a panel for Menus.
        $description = '<p>' . __('This panel is used for managing navigation menus for content you have already published on your site. You can create menus and add items for existing content such as pages, posts, categories, tags, formats, or custom links.') . '</p>';
        if (current_theme_supports('widgets')) {
            $description .= '<p>' . sprintf(
                /* translators: %s: URL to the Widgets panel of the Customizer. */
                __('Menus can be displayed in locations defined by your theme or in <a href="%s">widget areas</a> by adding a &#8220;Navigation Menu&#8221; widget.'),
                "javascript:wp.customize.panel( 'widgets' ).focus();"
            ) . '</p>';
        } else {
            $description .= '<p>' . __('Menus can be displayed in locations defined by your theme.') . '</p>';
        }
        /*
         * Once multiple theme supports are allowed in WP_Customize_Panel,
         * this panel can be restricted to themes that support menus or widgets.
         */
        $this->manager->add_panel(new WP_Customize_Nav_Menus_Panel($this->manager, 'nav_menus', array('title' => __('Menus'), 'description' => $description, 'priority' => 100)));
        $menus = wp_get_nav_menus();
        // Menu locations.
        $locations = get_registered_nav_menus();
        $num_locations = count($locations);
        if (1 == $num_locations) {
            $description = '<p>' . __('Your theme can display menus in one location. Select which menu you would like to use.') . '</p>';
        } else {
            /* translators: %s: Number of menu locations. */
            $description = '<p>' . sprintf(_n('Your theme can display menus in %s location. Select which menu you would like to use.', 'Your theme can display menus in %s locations. Select which menu appears in each location.', $num_locations), number_format_i18n($num_locations)) . '</p>';
        }
        if (current_theme_supports('widgets')) {
            /* translators: URL to the Widgets panel of the Customizer. */
            $description .= '<p>' . sprintf(__('If your theme has widget areas, you can also add menus there. Visit the <a href="%s">Widgets panel</a> and add a &#8220;Navigation Menu widget&#8221; to display a menu in a sidebar or footer.'), "javascript:wp.customize.panel( 'widgets' ).focus();") . '</p>';
        }
        $this->manager->add_section('menu_locations', array('title' => 1 === $num_locations ? _x('View Location', 'menu locations') : _x('View All Locations', 'menu locations'), 'panel' => 'nav_menus', 'priority' => 30, 'description' => $description));
        $choices = array('0' => __('&mdash; Select &mdash;'));
        foreach ($menus as $menu) {
            $choices[$menu->term_id] = wp_html_excerpt($menu->name, 40, '&hellip;');
        }
        // Attempt to re-map the nav menu location assignments when previewing a theme switch.
        $mapped_nav_menu_locations = array();
        if (!$this->manager->is_theme_active()) {
            $theme_mods = get_option('theme_mods_' . $this->manager->get_stylesheet(), array());
            // If there is no data from a previous activation, start fresh.
            if (empty($theme_mods['nav_menu_locations'])) {
                $theme_mods['nav_menu_locations'] = array();
            }
            $mapped_nav_menu_locations = wp_map_nav_menu_locations($theme_mods['nav_menu_locations'], $this->original_nav_menu_locations);
        }
        foreach ($locations as $location => $description) {
            $setting_id = "nav_menu_locations[{$location}]";
            $setting = $this->manager->get_setting($setting_id);
            if ($setting) {
                $setting->transport = 'postMessage';
                remove_filter("customize_sanitize_{$setting_id}", 'absint');
                add_filter("customize_sanitize_{$setting_id}", array($this, 'intval_base10'));
            } else {
                $this->manager->add_setting($setting_id, array('sanitize_callback' => array($this, 'intval_base10'), 'theme_supports' => 'menus', 'type' => 'theme_mod', 'transport' => 'postMessage', 'default' => 0));
            }
            // Override the assigned nav menu location if mapped during previewed theme switch.
            if (empty($changeset[$setting_id]) && isset($mapped_nav_menu_locations[$location])) {
                $this->manager->set_post_value($setting_id, $mapped_nav_menu_locations[$location]);
            }
            $this->manager->add_control(new WP_Customize_Nav_Menu_Location_Control($this->manager, $setting_id, array('label' => $description, 'location_id' => $location, 'section' => 'menu_locations', 'choices' => $choices)));
        }
        // Used to denote post states for special pages.
        if (!function_exists('get_post_states')) {
            require_once ABSPATH . 'wp-admin/includes/template.php';
        }
        // Register each menu as a Customizer section, and add each menu item to each menu.
        foreach ($menus as $menu) {
            $menu_id = $menu->term_id;
            // Create a section for each menu.
            $section_id = 'nav_menu[' . $menu_id . ']';
            $this->manager->add_section(new WP_Customize_Nav_Menu_Section($this->manager, $section_id, array('title' => html_entity_decode($menu->name, ENT_QUOTES, get_bloginfo('charset')), 'priority' => 10, 'panel' => 'nav_menus')));
            $nav_menu_setting_id = 'nav_menu[' . $menu_id . ']';
            $this->manager->add_setting(new WP_Customize_Nav_Menu_Setting($this->manager, $nav_menu_setting_id, array('transport' => 'postMessage')));
            // Add the menu contents.
            $menu_items = (array) wp_get_nav_menu_items($menu_id);
            foreach (array_values($menu_items) as $i => $item) {
                // Create a setting for each menu item (which doesn't actually manage data, currently).
                $menu_item_setting_id = 'nav_menu_item[' . $item->ID . ']';
                $value = (array) $item;
                if (empty($value['post_title'])) {
                    $value['title'] = '';
                }
                $value['nav_menu_term_id'] = $menu_id;
                $this->manager->add_setting(new WP_Customize_Nav_Menu_Item_Setting($this->manager, $menu_item_setting_id, array('value' => $value, 'transport' => 'postMessage')));
                // Create a control for each menu item.
                $this->manager->add_control(new WP_Customize_Nav_Menu_Item_Control($this->manager, $menu_item_setting_id, array('label' => $item->title, 'section' => $section_id, 'priority' => 10 + $i)));
            }
            // Note: other controls inside of this section get added dynamically in JS via the MenuSection.ready() function.
        }
        // Add the add-new-menu section and controls.
        $this->manager->add_section('add_menu', array('type' => 'new_menu', 'title' => __('New Menu'), 'panel' => 'nav_menus', 'priority' => 20));
        $this->manager->add_setting(new WP_Customize_Filter_Setting($this->manager, 'nav_menus_created_posts', array(
            'transport' => 'postMessage',
            'type' => 'option',
            // To prevent theme prefix in changeset.
            'default' => array(),
            'sanitize_callback' => array($this, 'sanitize_nav_menus_created_posts'),
        )));
    }
    /**
     * Get the base10 intval.
     *
     * This is used as a setting's sanitize_callback; we can't use just plain
     * intval because the second argument is not what intval() expects.
     *
     * @since 4.3.0
     *
     * @param mixed $value Number to convert.
     * @return int Integer.
     */
    public function intval_base10($value)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("intval_base10") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-customize-nav-menus.php at line 584")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called intval_base10:584@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-customize-nav-menus.php');
        die();
    }
    /**
     * Return an array of all the available item types.
     *
     * @since 4.3.0
     * @since 4.7.0  Each array item now includes a `$type_label` in addition to `$title`, `$type`, and `$object`.
     *
     * @return array The available menu item types.
     */
    public function available_item_types()
    {
        $item_types = array();
        $post_types = get_post_types(array('show_in_nav_menus' => true), 'objects');
        if ($post_types) {
            foreach ($post_types as $slug => $post_type) {
                $item_types[] = array('title' => $post_type->labels->name, 'type_label' => $post_type->labels->singular_name, 'type' => 'post_type', 'object' => $post_type->name);
            }
        }
        $taxonomies = get_taxonomies(array('show_in_nav_menus' => true), 'objects');
        if ($taxonomies) {
            foreach ($taxonomies as $slug => $taxonomy) {
                if ('post_format' === $taxonomy && !current_theme_supports('post-formats')) {
                    continue;
                }
                $item_types[] = array('title' => $taxonomy->labels->name, 'type_label' => $taxonomy->labels->singular_name, 'type' => 'taxonomy', 'object' => $taxonomy->name);
            }
        }
        /**
         * Filters the available menu item types.
         *
         * @since 4.3.0
         * @since 4.7.0  Each array item now includes a `$type_label` in addition to `$title`, `$type`, and `$object`.
         *
         * @param array $item_types Navigation menu item types.
         */
        $item_types = apply_filters('customize_nav_menu_available_item_types', $item_types);
        return $item_types;
    }
    /**
     * Add a new `auto-draft` post.
     *
     * @since 4.7.0
     *
     * @param array $postarr {
     *     Post array. Note that post_status is overridden to be `auto-draft`.
     *
     * @var string $post_title   Post title. Required.
     * @var string $post_type    Post type. Required.
     * @var string $post_name    Post name.
     * @var string $post_content Post content.
     * }
     * @return WP_Post|WP_Error Inserted auto-draft post object or error.
     */
    public function insert_auto_draft_post($postarr)
    {
        if (!isset($postarr['post_type'])) {
            return new WP_Error('unknown_post_type', __('Invalid post type.'));
        }
        if (empty($postarr['post_title'])) {
            return new WP_Error('empty_title', __('Empty title.'));
        }
        if (!empty($postarr['post_status'])) {
            return new WP_Error('status_forbidden', __('Status is forbidden.'));
        }
        /*
         * If the changeset is a draft, this will change to draft the next time the changeset
         * is updated; otherwise, auto-draft will persist in autosave revisions, until save.
         */
        $postarr['post_status'] = 'auto-draft';
        // Auto-drafts are allowed to have empty post_names, so it has to be explicitly set.
        if (empty($postarr['post_name'])) {
            $postarr['post_name'] = sanitize_title($postarr['post_title']);
        }
        if (!isset($postarr['meta_input'])) {
            $postarr['meta_input'] = array();
        }
        $postarr['meta_input']['_customize_draft_post_name'] = $postarr['post_name'];
        $postarr['meta_input']['_customize_changeset_uuid'] = $this->manager->changeset_uuid();
        unset($postarr['post_name']);
        add_filter('wp_insert_post_empty_content', '__return_false', 1000);
        $r = wp_insert_post(wp_slash($postarr), true);
        remove_filter('wp_insert_post_empty_content', '__return_false', 1000);
        if (is_wp_error($r)) {
            return $r;
        } else {
            return get_post($r);
        }
    }
    /**
     * Ajax handler for adding a new auto-draft post.
     *
     * @since 4.7.0
     */
    public function ajax_insert_auto_draft_post()
    {
        if (!check_ajax_referer('customize-menus', 'customize-menus-nonce', false)) {
            wp_send_json_error('bad_nonce', 400);
        }
        if (!current_user_can('customize')) {
            wp_send_json_error('customize_not_allowed', 403);
        }
        if (empty($_POST['params']) || !is_array($_POST['params'])) {
            wp_send_json_error('missing_params', 400);
        }
        $params = wp_unslash($_POST['params']);
        $illegal_params = array_diff(array_keys($params), array('post_type', 'post_title'));
        if (!empty($illegal_params)) {
            wp_send_json_error('illegal_params', 400);
        }
        $params = array_merge(array('post_type' => '', 'post_title' => ''), $params);
        if (empty($params['post_type']) || !post_type_exists($params['post_type'])) {
            status_header(400);
            wp_send_json_error('missing_post_type_param');
        }
        $post_type_object = get_post_type_object($params['post_type']);
        if (!current_user_can($post_type_object->cap->create_posts) || !current_user_can($post_type_object->cap->publish_posts)) {
            status_header(403);
            wp_send_json_error('insufficient_post_permissions');
        }
        $params['post_title'] = trim($params['post_title']);
        if ('' === $params['post_title']) {
            status_header(400);
            wp_send_json_error('missing_post_title');
        }
        $r = $this->insert_auto_draft_post($params);
        if (is_wp_error($r)) {
            $error = $r;
            if (!empty($post_type_object->labels->singular_name)) {
                $singular_name = $post_type_object->labels->singular_name;
            } else {
                $singular_name = __('Post');
            }
            $data = array(
                /* translators: 1: Post type name, 2: Error message. */
                'message' => sprintf(__('%1$s could not be created: %2$s'), $singular_name, $error->get_error_message()),
            );
            wp_send_json_error($data);
        } else {
            $post = $r;
            $data = array('post_id' => $post->ID, 'url' => get_permalink($post->ID));
            wp_send_json_success($data);
        }
    }
    /**
     * Print the JavaScript templates used to render Menu Customizer components.
     *
     * Templates are imported into the JS use wp.template.
     *
     * @since 4.3.0
     */
    public function print_templates()
    {
        ?>
		<script type="text/html" id="tmpl-available-menu-item">
			<li id="menu-item-tpl-{{ data.id }}" class="menu-item-tpl" data-menu-item-id="{{ data.id }}">
				<div class="menu-item-bar">
					<div class="menu-item-handle">
						<span class="item-type" aria-hidden="true">{{ data.type_label }}</span>
						<span class="item-title" aria-hidden="true">
							<span class="menu-item-title<# if ( ! data.title ) { #> no-title<# } #>">{{ data.title || wp.customize.Menus.data.l10n.untitled }}</span>
						</span>
						<button type="button" class="button-link item-add">
							<span class="screen-reader-text">
							<?php 
        /* translators: 1: Title of a menu item, 2: Type of a menu item. */
        printf(__('Add to menu: %1$s (%2$s)'), '{{ data.title || wp.customize.Menus.data.l10n.untitled }}', '{{ data.type_label }}');
        ?>
							</span>
						</button>
					</div>
				</div>
			</li>
		</script>

		<script type="text/html" id="tmpl-menu-item-reorder-nav">
			<div class="menu-item-reorder-nav">
				<?php 
        printf('<button type="button" class="menus-move-up">%1$s</button><button type="button" class="menus-move-down">%2$s</button><button type="button" class="menus-move-left">%3$s</button><button type="button" class="menus-move-right">%4$s</button>', __('Move up'), __('Move down'), __('Move one level up'), __('Move one level down'));
        ?>
			</div>
		</script>

		<script type="text/html" id="tmpl-nav-menu-delete-button">
			<div class="menu-delete-item">
				<button type="button" class="button-link button-link-delete">
					<?php 
        _e('Delete Menu');
        ?>
				</button>
			</div>
		</script>

		<script type="text/html" id="tmpl-nav-menu-submit-new-button">
			<p id="customize-new-menu-submit-description"><?php 
        _e('Click &#8220;Next&#8221; to start adding links to your new menu.');
        ?></p>
			<button id="customize-new-menu-submit" type="button" class="button" aria-describedby="customize-new-menu-submit-description"><?php 
        _e('Next');
        ?></button>
		</script>

		<script type="text/html" id="tmpl-nav-menu-locations-header">
			<span class="customize-control-title customize-section-title-menu_locations-heading">{{ data.l10n.locationsTitle }}</span>
			<p class="customize-control-description customize-section-title-menu_locations-description">{{ data.l10n.locationsDescription }}</p>
		</script>

		<script type="text/html" id="tmpl-nav-menu-create-menu-section-title">
			<p class="add-new-menu-notice">
				<?php 
        _e('It doesn&#8217;t look like your site has any menus yet. Want to build one? Click the button to start.');
        ?>
			</p>
			<p class="add-new-menu-notice">
				<?php 
        _e('You&#8217;ll create a menu, assign it a location, and add menu items like links to pages and categories. If your theme has multiple menu areas, you might need to create more than one.');
        ?>
			</p>
			<h3>
				<button type="button" class="button customize-add-menu-button">
					<?php 
        _e('Create New Menu');
        ?>
				</button>
			</h3>
		</script>
		<?php 
    }
    /**
     * Print the HTML template used to render the add-menu-item frame.
     *
     * @since 4.3.0
     */
    public function available_items_template()
    {
        ?>
		<div id="available-menu-items" class="accordion-container">
			<div class="customize-section-title">
				<button type="button" class="customize-section-back" tabindex="-1">
					<span class="screen-reader-text"><?php 
        _e('Back');
        ?></span>
				</button>
				<h3>
					<span class="customize-action">
						<?php 
        /* translators: &#9656; is the unicode right-pointing triangle. %s: Section title in the Customizer. */
        printf(__('Customizing &#9656; %s'), esc_html($this->manager->get_panel('nav_menus')->title));
        ?>
					</span>
					<?php 
        _e('Add Menu Items');
        ?>
				</h3>
			</div>
			<div id="available-menu-items-search" class="accordion-section cannot-expand">
				<div class="accordion-section-title">
					<label class="screen-reader-text" for="menu-items-search"><?php 
        _e('Search Menu Items');
        ?></label>
					<input type="text" id="menu-items-search" placeholder="<?php 
        esc_attr_e('Search menu items&hellip;');
        ?>" aria-describedby="menu-items-search-desc" />
					<p class="screen-reader-text" id="menu-items-search-desc"><?php 
        _e('The search results will be updated as you type.');
        ?></p>
					<span class="spinner"></span>
				</div>
				<div class="search-icon" aria-hidden="true"></div>
				<button type="button" class="clear-results"><span class="screen-reader-text"><?php 
        _e('Clear Results');
        ?></span></button>
				<ul class="accordion-section-content available-menu-items-list" data-type="search"></ul>
			</div>
			<?php 
        // Ensure the page post type comes first in the list.
        $item_types = $this->available_item_types();
        $page_item_type = null;
        foreach ($item_types as $i => $item_type) {
            if (isset($item_type['object']) && 'page' === $item_type['object']) {
                $page_item_type = $item_type;
                unset($item_types[$i]);
            }
        }
        $this->print_custom_links_available_menu_item();
        if ($page_item_type) {
            $this->print_post_type_container($page_item_type);
        }
        // Containers for per-post-type item browsing; items are added with JS.
        foreach ($item_types as $item_type) {
            $this->print_post_type_container($item_type);
        }
        ?>
		</div><!-- #available-menu-items -->
		<?php 
    }
    /**
     * Print the markup for new menu items.
     *
     * To be used in the template #available-menu-items.
     *
     * @since 4.7.0
     *
     * @param array $available_item_type Menu item data to output, including title, type, and label.
     * @return void
     */
    protected function print_post_type_container($available_item_type)
    {
        $id = sprintf('available-menu-items-%s-%s', $available_item_type['type'], $available_item_type['object']);
        ?>
		<div id="<?php 
        echo esc_attr($id);
        ?>" class="accordion-section">
			<h4 class="accordion-section-title" role="presentation">
				<?php 
        echo esc_html($available_item_type['title']);
        ?>
				<span class="spinner"></span>
				<span class="no-items"><?php 
        _e('No items');
        ?></span>
				<button type="button" class="button-link" aria-expanded="false">
					<span class="screen-reader-text">
					<?php 
        /* translators: %s: Title of a section with menu items. */
        printf(__('Toggle section: %s'), esc_html($available_item_type['title']));
        ?>
						</span>
					<span class="toggle-indicator" aria-hidden="true"></span>
				</button>
			</h4>
			<div class="accordion-section-content">
				<?php 
        if ('post_type' === $available_item_type['type']) {
            ?>
					<?php 
            $post_type_obj = get_post_type_object($available_item_type['object']);
            ?>
					<?php 
            if (current_user_can($post_type_obj->cap->create_posts) && current_user_can($post_type_obj->cap->publish_posts)) {
                ?>
						<div class="new-content-item">
							<label for="<?php 
                echo esc_attr('create-item-input-' . $available_item_type['object']);
                ?>" class="screen-reader-text"><?php 
                echo esc_html($post_type_obj->labels->add_new_item);
                ?></label>
							<input type="text" id="<?php 
                echo esc_attr('create-item-input-' . $available_item_type['object']);
                ?>" class="create-item-input" placeholder="<?php 
                echo esc_attr($post_type_obj->labels->add_new_item);
                ?>">
							<button type="button" class="button add-content"><?php 
                _e('Add');
                ?></button>
						</div>
					<?php 
            }
            ?>
				<?php 
        }
        ?>
				<ul class="available-menu-items-list" data-type="<?php 
        echo esc_attr($available_item_type['type']);
        ?>" data-object="<?php 
        echo esc_attr($available_item_type['object']);
        ?>" data-type_label="<?php 
        echo esc_attr(isset($available_item_type['type_label']) ? $available_item_type['type_label'] : $available_item_type['type']);
        ?>"></ul>
			</div>
		</div>
		<?php 
    }
    /**
     * Print the markup for available menu item custom links.
     *
     * @since 4.7.0
     *
     * @return void
     */
    protected function print_custom_links_available_menu_item()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("print_custom_links_available_menu_item") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-customize-nav-menus.php at line 967")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called print_custom_links_available_menu_item:967@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-customize-nav-menus.php');
        die();
    }
    //
    // Start functionality specific to partial-refresh of menu changes in Customizer preview.
    //
    /**
     * Nav menu args used for each instance, keyed by the args HMAC.
     *
     * @since 4.3.0
     * @var array
     */
    public $preview_nav_menu_instance_args = array();
    /**
     * Filters arguments for dynamic nav_menu selective refresh partials.
     *
     * @since 4.5.0
     *
     * @param array|false $partial_args Partial args.
     * @param string      $partial_id   Partial ID.
     * @return array Partial args.
     */
    public function customize_dynamic_partial_args($partial_args, $partial_id)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("customize_dynamic_partial_args") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-customize-nav-menus.php at line 1026")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called customize_dynamic_partial_args:1026@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-customize-nav-menus.php');
        die();
    }
    /**
     * Add hooks for the Customizer preview.
     *
     * @since 4.3.0
     */
    public function customize_preview_init()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("customize_preview_init") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-customize-nav-menus.php at line 1048")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called customize_preview_init:1048@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-customize-nav-menus.php');
        die();
    }
    /**
     * Make the auto-draft status protected so that it can be queried.
     *
     * @since 4.7.0
     *
     * @global array $wp_post_statuses List of post statuses.
     */
    public function make_auto_draft_status_previewable()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("make_auto_draft_status_previewable") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-customize-nav-menus.php at line 1063")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called make_auto_draft_status_previewable:1063@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-customize-nav-menus.php');
        die();
    }
    /**
     * Sanitize post IDs for posts created for nav menu items to be published.
     *
     * @since 4.7.0
     *
     * @param array $value Post IDs.
     * @return array Post IDs.
     */
    public function sanitize_nav_menus_created_posts($value)
    {
        $post_ids = array();
        foreach (wp_parse_id_list($value) as $post_id) {
            if (empty($post_id)) {
                continue;
            }
            $post = get_post($post_id);
            if ('auto-draft' !== $post->post_status && 'draft' !== $post->post_status) {
                continue;
            }
            $post_type_obj = get_post_type_object($post->post_type);
            if (!$post_type_obj) {
                continue;
            }
            if (!current_user_can($post_type_obj->cap->publish_posts) || !current_user_can('edit_post', $post_id)) {
                continue;
            }
            $post_ids[] = $post->ID;
        }
        return $post_ids;
    }
    /**
     * Publish the auto-draft posts that were created for nav menu items.
     *
     * The post IDs will have been sanitized by already by
     * `WP_Customize_Nav_Menu_Items::sanitize_nav_menus_created_posts()` to
     * remove any post IDs for which the user cannot publish or for which the
     * post is not an auto-draft.
     *
     * @since 4.7.0
     *
     * @param WP_Customize_Setting $setting Customizer setting object.
     */
    public function save_nav_menus_created_posts($setting)
    {
        $post_ids = $setting->post_value();
        if (!empty($post_ids)) {
            foreach ($post_ids as $post_id) {
                // Prevent overriding the status that a user may have prematurely updated the post to.
                $current_status = get_post_status($post_id);
                if ('auto-draft' !== $current_status && 'draft' !== $current_status) {
                    continue;
                }
                $target_status = 'attachment' === get_post_type($post_id) ? 'inherit' : 'publish';
                $args = array('ID' => $post_id, 'post_status' => $target_status);
                $post_name = get_post_meta($post_id, '_customize_draft_post_name', true);
                if ($post_name) {
                    $args['post_name'] = $post_name;
                }
                // Note that wp_publish_post() cannot be used because unique slugs need to be assigned.
                wp_update_post(wp_slash($args));
                delete_post_meta($post_id, '_customize_draft_post_name');
            }
        }
    }
    /**
     * Keep track of the arguments that are being passed to wp_nav_menu().
     *
     * @since 4.3.0
     *
     * @see wp_nav_menu()
     * @see WP_Customize_Widgets::filter_dynamic_sidebar_params()
     *
     * @param array $args An array containing wp_nav_menu() arguments.
     * @return array Arguments.
     */
    public function filter_wp_nav_menu_args($args)
    {
        /*
         * The following conditions determine whether or not this instance of
         * wp_nav_menu() can use selective refreshed. A wp_nav_menu() can be
         * selective refreshed if...
         */
        $can_partial_refresh = !empty($args['echo']) && (empty($args['fallback_cb']) || is_string($args['fallback_cb'])) && (empty($args['walker']) || is_string($args['walker'])) && (!empty($args['theme_location']) || !empty($args['menu']) && (is_numeric($args['menu']) || is_object($args['menu']))) && (!empty($args['container']) || isset($args['items_wrap']) && '<' === substr($args['items_wrap'], 0, 1));
        $args['can_partial_refresh'] = $can_partial_refresh;
        $exported_args = $args;
        // Empty out args which may not be JSON-serializable.
        if (!$can_partial_refresh) {
            $exported_args['fallback_cb'] = '';
            $exported_args['walker'] = '';
        }
        /*
         * Replace object menu arg with a term_id menu arg, as this exports better
         * to JS and is easier to compare hashes.
         */
        if (!empty($exported_args['menu']) && is_object($exported_args['menu'])) {
            $exported_args['menu'] = $exported_args['menu']->term_id;
        }
        ksort($exported_args);
        $exported_args['args_hmac'] = $this->hash_nav_menu_args($exported_args);
        $args['customize_preview_nav_menus_args'] = $exported_args;
        $this->preview_nav_menu_instance_args[$exported_args['args_hmac']] = $exported_args;
        return $args;
    }
    /**
     * Prepares wp_nav_menu() calls for partial refresh.
     *
     * Injects attributes into container element.
     *
     * @since 4.3.0
     *
     * @see wp_nav_menu()
     *
     * @param string $nav_menu_content The HTML content for the navigation menu.
     * @param object $args             An object containing wp_nav_menu() arguments.
     * @return string Nav menu HTML with selective refresh attributes added if partial can be refreshed.
     */
    public function filter_wp_nav_menu($nav_menu_content, $args)
    {
        if (isset($args->customize_preview_nav_menus_args['can_partial_refresh']) && $args->customize_preview_nav_menus_args['can_partial_refresh']) {
            $attributes = sprintf(' data-customize-partial-id="%s"', esc_attr('nav_menu_instance[' . $args->customize_preview_nav_menus_args['args_hmac'] . ']'));
            $attributes .= ' data-customize-partial-type="nav_menu_instance"';
            $attributes .= sprintf(' data-customize-partial-placement-context="%s"', esc_attr(wp_json_encode($args->customize_preview_nav_menus_args)));
            $nav_menu_content = preg_replace('#^(<\\w+)#', '$1 ' . str_replace('\\', '\\\\', $attributes), $nav_menu_content, 1);
        }
        return $nav_menu_content;
    }
    /**
     * Hashes (hmac) the nav menu arguments to ensure they are not tampered with when
     * submitted in the Ajax request.
     *
     * Note that the array is expected to be pre-sorted.
     *
     * @since 4.3.0
     *
     * @param array $args The arguments to hash.
     * @return string Hashed nav menu arguments.
     */
    public function hash_nav_menu_args($args)
    {
        return wp_hash(serialize($args));
    }
    /**
     * Enqueue scripts for the Customizer preview.
     *
     * @since 4.3.0
     */
    public function customize_preview_enqueue_deps()
    {
        wp_enqueue_script('customize-preview-nav-menus');
        // Note that we have overridden this.
    }
    /**
     * Exports data from PHP to JS.
     *
     * @since 4.3.0
     */
    public function export_preview_data()
    {
        // Why not wp_localize_script? Because we're not localizing, and it forces values into strings.
        $exports = array('navMenuInstanceArgs' => $this->preview_nav_menu_instance_args);
        printf('<script>var _wpCustomizePreviewNavMenusExports = %s;</script>', wp_json_encode($exports));
    }
    /**
     * Export any wp_nav_menu() calls during the rendering of any partials.
     *
     * @since 4.5.0
     *
     * @param array $response Response.
     * @return array Response.
     */
    public function export_partial_rendered_nav_menu_instances($response)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("export_partial_rendered_nav_menu_instances") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-customize-nav-menus.php at line 1238")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called export_partial_rendered_nav_menu_instances:1238@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-customize-nav-menus.php');
        die();
    }
    /**
     * Render a specific menu via wp_nav_menu() using the supplied arguments.
     *
     * @since 4.3.0
     *
     * @see wp_nav_menu()
     *
     * @param WP_Customize_Partial $partial       Partial.
     * @param array                $nav_menu_args Nav menu args supplied as container context.
     * @return string|false
     */
    public function render_nav_menu_partial($partial, $nav_menu_args)
    {
        unset($partial);
        if (!isset($nav_menu_args['args_hmac'])) {
            // Error: missing_args_hmac.
            return false;
        }
        $nav_menu_args_hmac = $nav_menu_args['args_hmac'];
        unset($nav_menu_args['args_hmac']);
        ksort($nav_menu_args);
        if (!hash_equals($this->hash_nav_menu_args($nav_menu_args), $nav_menu_args_hmac)) {
            // Error: args_hmac_mismatch.
            return false;
        }
        ob_start();
        wp_nav_menu($nav_menu_args);
        $content = ob_get_clean();
        return $content;
    }
}