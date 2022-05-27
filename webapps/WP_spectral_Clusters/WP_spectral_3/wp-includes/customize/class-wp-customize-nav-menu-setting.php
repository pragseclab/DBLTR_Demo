<?php

/**
 * Customize API: WP_Customize_Nav_Menu_Setting class
 *
 * @package WordPress
 * @subpackage Customize
 * @since 4.4.0
 */
/**
 * Customize Setting to represent a nav_menu.
 *
 * Subclass of WP_Customize_Setting to represent a nav_menu taxonomy term, and
 * the IDs for the nav_menu_items associated with the nav menu.
 *
 * @since 4.3.0
 *
 * @see wp_get_nav_menu_object()
 * @see WP_Customize_Setting
 */
class WP_Customize_Nav_Menu_Setting extends WP_Customize_Setting
{
    const ID_PATTERN = '/^nav_menu\\[(?P<id>-?\\d+)\\]$/';
    const TAXONOMY = 'nav_menu';
    const TYPE = 'nav_menu';
    /**
     * Setting type.
     *
     * @since 4.3.0
     * @var string
     */
    public $type = self::TYPE;
    /**
     * Default setting value.
     *
     * @since 4.3.0
     * @var array
     *
     * @see wp_get_nav_menu_object()
     */
    public $default = array('name' => '', 'description' => '', 'parent' => 0, 'auto_add' => false);
    /**
     * Default transport.
     *
     * @since 4.3.0
     * @var string
     */
    public $transport = 'postMessage';
    /**
     * The term ID represented by this setting instance.
     *
     * A negative value represents a placeholder ID for a new menu not yet saved.
     *
     * @since 4.3.0
     * @var int
     */
    public $term_id;
    /**
     * Previous (placeholder) term ID used before creating a new menu.
     *
     * This value will be exported to JS via the {@see 'customize_save_response'} filter
     * so that JavaScript can update the settings to refer to the newly-assigned
     * term ID. This value is always negative to indicate it does not refer to
     * a real term.
     *
     * @since 4.3.0
     * @var int
     *
     * @see WP_Customize_Nav_Menu_Setting::update()
     * @see WP_Customize_Nav_Menu_Setting::amend_customize_save_response()
     */
    public $previous_term_id;
    /**
     * Whether or not update() was called.
     *
     * @since 4.3.0
     * @var bool
     */
    protected $is_updated = false;
    /**
     * Status for calling the update method, used in customize_save_response filter.
     *
     * See {@see 'customize_save_response'}.
     *
     * When status is inserted, the placeholder term ID is stored in `$previous_term_id`.
     * When status is error, the error is stored in `$update_error`.
     *
     * @since 4.3.0
     * @var string updated|inserted|deleted|error
     *
     * @see WP_Customize_Nav_Menu_Setting::update()
     * @see WP_Customize_Nav_Menu_Setting::amend_customize_save_response()
     */
    public $update_status;
    /**
     * Any error object returned by wp_update_nav_menu_object() when setting is updated.
     *
     * @since 4.3.0
     * @var WP_Error
     *
     * @see WP_Customize_Nav_Menu_Setting::update()
     * @see WP_Customize_Nav_Menu_Setting::amend_customize_save_response()
     */
    public $update_error;
    /**
     * Constructor.
     *
     * Any supplied $args override class property defaults.
     *
     * @since 4.3.0
     *
     * @throws Exception If $id is not valid for this setting type.
     *
     * @param WP_Customize_Manager $manager Customizer bootstrap instance.
     * @param string               $id      A specific ID of the setting.
     *                                      Can be a theme mod or option name.
     * @param array                $args    Optional. Setting arguments.
     */
    public function __construct(WP_Customize_Manager $manager, $id, array $args = array())
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("__construct") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/customize/class-wp-customize-nav-menu-setting.php at line 121")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called __construct:121@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/customize/class-wp-customize-nav-menu-setting.php');
        die();
    }
    /**
     * Get the instance data for a given widget setting.
     *
     * @since 4.3.0
     *
     * @see wp_get_nav_menu_object()
     *
     * @return array Instance data.
     */
    public function value()
    {
        if ($this->is_previewed && get_current_blog_id() === $this->_previewed_blog_id) {
            $undefined = new stdClass();
            // Symbol.
            $post_value = $this->post_value($undefined);
            if ($undefined === $post_value) {
                $value = $this->_original_value;
            } else {
                $value = $post_value;
            }
        } else {
            $value = false;
            // Note that a term_id of less than one indicates a nav_menu not yet inserted.
            if ($this->term_id > 0) {
                $term = wp_get_nav_menu_object($this->term_id);
                if ($term) {
                    $value = wp_array_slice_assoc((array) $term, array_keys($this->default));
                    $nav_menu_options = (array) get_option('nav_menu_options', array());
                    $value['auto_add'] = false;
                    if (isset($nav_menu_options['auto_add']) && is_array($nav_menu_options['auto_add'])) {
                        $value['auto_add'] = in_array($term->term_id, $nav_menu_options['auto_add'], true);
                    }
                }
            }
            if (!is_array($value)) {
                $value = $this->default;
            }
        }
        return $value;
    }
    /**
     * Handle previewing the setting.
     *
     * @since 4.3.0
     * @since 4.4.0 Added boolean return value
     *
     * @see WP_Customize_Manager::post_value()
     *
     * @return bool False if method short-circuited due to no-op.
     */
    public function preview()
    {
        if ($this->is_previewed) {
            return false;
        }
        $undefined = new stdClass();
        $is_placeholder = $this->term_id < 0;
        $is_dirty = $undefined !== $this->post_value($undefined);
        if (!$is_placeholder && !$is_dirty) {
            return false;
        }
        $this->is_previewed = true;
        $this->_original_value = $this->value();
        $this->_previewed_blog_id = get_current_blog_id();
        add_filter('wp_get_nav_menus', array($this, 'filter_wp_get_nav_menus'), 10, 2);
        add_filter('wp_get_nav_menu_object', array($this, 'filter_wp_get_nav_menu_object'), 10, 2);
        add_filter('default_option_nav_menu_options', array($this, 'filter_nav_menu_options'));
        add_filter('option_nav_menu_options', array($this, 'filter_nav_menu_options'));
        return true;
    }
    /**
     * Filters the wp_get_nav_menus() result to ensure the inserted menu object is included, and the deleted one is removed.
     *
     * @since 4.3.0
     *
     * @see wp_get_nav_menus()
     *
     * @param WP_Term[] $menus An array of menu objects.
     * @param array     $args  An array of arguments used to retrieve menu objects.
     * @return WP_Term[] Array of menu objects.
     */
    public function filter_wp_get_nav_menus($menus, $args)
    {
        if (get_current_blog_id() !== $this->_previewed_blog_id) {
            return $menus;
        }
        $setting_value = $this->value();
        $is_delete = false === $setting_value;
        $index = -1;
        // Find the existing menu item's position in the list.
        foreach ($menus as $i => $menu) {
            if ((int) $this->term_id === (int) $menu->term_id || (int) $this->previous_term_id === (int) $menu->term_id) {
                $index = $i;
                break;
            }
        }
        if ($is_delete) {
            // Handle deleted menu by removing it from the list.
            if (-1 !== $index) {
                array_splice($menus, $index, 1);
            }
        } else {
            // Handle menus being updated or inserted.
            $menu_obj = (object) array_merge(array('term_id' => $this->term_id, 'term_taxonomy_id' => $this->term_id, 'slug' => sanitize_title($setting_value['name']), 'count' => 0, 'term_group' => 0, 'taxonomy' => self::TAXONOMY, 'filter' => 'raw'), $setting_value);
            array_splice($menus, $index, -1 === $index ? 0 : 1, array($menu_obj));
        }
        // Make sure the menu objects get re-sorted after an update/insert.
        if (!$is_delete && !empty($args['orderby'])) {
            $menus = wp_list_sort($menus, array($args['orderby'] => 'ASC'));
        }
        // @todo Add support for $args['hide_empty'] === true.
        return $menus;
    }
    /**
     * Temporary non-closure passing of orderby value to function.
     *
     * @since 4.3.0
     * @var string
     *
     * @see WP_Customize_Nav_Menu_Setting::filter_wp_get_nav_menus()
     * @see WP_Customize_Nav_Menu_Setting::_sort_menus_by_orderby()
     */
    protected $_current_menus_sort_orderby;
    /**
     * Sort menu objects by the class-supplied orderby property.
     *
     * This is a workaround for a lack of closures.
     *
     * @since 4.3.0
     * @deprecated 4.7.0 Use wp_list_sort()
     *
     * @param object $menu1
     * @param object $menu2
     * @return int
     *
     * @see WP_Customize_Nav_Menu_Setting::filter_wp_get_nav_menus()
     */
    protected function _sort_menus_by_orderby($menu1, $menu2)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_sort_menus_by_orderby") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/customize/class-wp-customize-nav-menu-setting.php at line 269")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called _sort_menus_by_orderby:269@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/customize/class-wp-customize-nav-menu-setting.php');
        die();
    }
    /**
     * Filters the wp_get_nav_menu_object() result to supply the previewed menu object.
     *
     * Requesting a nav_menu object by anything but ID is not supported.
     *
     * @since 4.3.0
     *
     * @see wp_get_nav_menu_object()
     *
     * @param object|null $menu_obj Object returned by wp_get_nav_menu_object().
     * @param string      $menu_id  ID of the nav_menu term. Requests by slug or name will be ignored.
     * @return object|null
     */
    public function filter_wp_get_nav_menu_object($menu_obj, $menu_id)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("filter_wp_get_nav_menu_object") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/customize/class-wp-customize-nav-menu-setting.php at line 288")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called filter_wp_get_nav_menu_object:288@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/customize/class-wp-customize-nav-menu-setting.php');
        die();
    }
    /**
     * Filters the nav_menu_options option to include this menu's auto_add preference.
     *
     * @since 4.3.0
     *
     * @param array $nav_menu_options Nav menu options including auto_add.
     * @return array (Maybe) modified nav menu options.
     */
    public function filter_nav_menu_options($nav_menu_options)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("filter_nav_menu_options") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/customize/class-wp-customize-nav-menu-setting.php at line 314")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called filter_nav_menu_options:314@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/customize/class-wp-customize-nav-menu-setting.php');
        die();
    }
    /**
     * Sanitize an input.
     *
     * Note that parent::sanitize() erroneously does wp_unslash() on $value, but
     * we remove that in this override.
     *
     * @since 4.3.0
     *
     * @param array $value The value to sanitize.
     * @return array|false|null Null if an input isn't valid. False if it is marked for deletion.
     *                          Otherwise the sanitized value.
     */
    public function sanitize($value)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("sanitize") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/customize/class-wp-customize-nav-menu-setting.php at line 336")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called sanitize:336@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/customize/class-wp-customize-nav-menu-setting.php');
        die();
    }
    /**
     * Storage for data to be sent back to client in customize_save_response filter.
     *
     * See {@see 'customize_save_response'}.
     *
     * @since 4.3.0
     * @var array
     *
     * @see WP_Customize_Nav_Menu_Setting::amend_customize_save_response()
     */
    protected $_widget_nav_menu_updates = array();
    /**
     * Create/update the nav_menu term for this setting.
     *
     * Any created menus will have their assigned term IDs exported to the client
     * via the {@see 'customize_save_response'} filter. Likewise, any errors will be exported
     * to the client via the customize_save_response() filter.
     *
     * To delete a menu, the client can send false as the value.
     *
     * @since 4.3.0
     *
     * @see wp_update_nav_menu_object()
     *
     * @param array|false $value {
     *     The value to update. Note that slug cannot be updated via wp_update_nav_menu_object().
     *     If false, then the menu will be deleted entirely.
     *
     *     @type string $name        The name of the menu to save.
     *     @type string $description The term description. Default empty string.
     *     @type int    $parent      The id of the parent term. Default 0.
     *     @type bool   $auto_add    Whether pages will auto_add to this menu. Default false.
     * }
     * @return null|void
     */
    protected function update($value)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("update") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/customize/class-wp-customize-nav-menu-setting.php at line 394")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called update:394@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/customize/class-wp-customize-nav-menu-setting.php');
        die();
    }
    /**
     * Updates a nav_menu_options array.
     *
     * @since 4.3.0
     *
     * @see WP_Customize_Nav_Menu_Setting::filter_nav_menu_options()
     * @see WP_Customize_Nav_Menu_Setting::update()
     *
     * @param array $nav_menu_options Array as returned by get_option( 'nav_menu_options' ).
     * @param int   $menu_id          The term ID for the given menu.
     * @param bool  $auto_add         Whether to auto-add or not.
     * @return array (Maybe) modified nav_menu_otions array.
     */
    protected function filter_nav_menu_options_value($nav_menu_options, $menu_id, $auto_add)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("filter_nav_menu_options_value") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/customize/class-wp-customize-nav-menu-setting.php at line 494")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called filter_nav_menu_options_value:494@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/customize/class-wp-customize-nav-menu-setting.php');
        die();
    }
    /**
     * Export data for the JS client.
     *
     * @since 4.3.0
     *
     * @see WP_Customize_Nav_Menu_Setting::update()
     *
     * @param array $data Additional information passed back to the 'saved' event on `wp.customize`.
     * @return array Export data.
     */
    public function amend_customize_save_response($data)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("amend_customize_save_response") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/customize/class-wp-customize-nav-menu-setting.php at line 518")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called amend_customize_save_response:518@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/customize/class-wp-customize-nav-menu-setting.php');
        die();
    }
}