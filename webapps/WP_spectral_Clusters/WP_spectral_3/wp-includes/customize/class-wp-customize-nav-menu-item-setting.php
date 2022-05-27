<?php

/**
 * Customize API: WP_Customize_Nav_Menu_Item_Setting class
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
 * @see WP_Customize_Setting
 */
class WP_Customize_Nav_Menu_Item_Setting extends WP_Customize_Setting
{
    const ID_PATTERN = '/^nav_menu_item\\[(?P<id>-?\\d+)\\]$/';
    const POST_TYPE = 'nav_menu_item';
    const TYPE = 'nav_menu_item';
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
     * @see wp_setup_nav_menu_item()
     */
    public $default = array(
        // The $menu_item_data for wp_update_nav_menu_item().
        'object_id' => 0,
        'object' => '',
        // Taxonomy name.
        'menu_item_parent' => 0,
        // A.K.A. menu-item-parent-id; note that post_parent is different, and not included.
        'position' => 0,
        // A.K.A. menu_order.
        'type' => 'custom',
        // Note that type_label is not included here.
        'title' => '',
        'url' => '',
        'target' => '',
        'attr_title' => '',
        'description' => '',
        'classes' => '',
        'xfn' => '',
        'status' => 'publish',
        'original_title' => '',
        'nav_menu_term_id' => 0,
        // This will be supplied as the $menu_id arg for wp_update_nav_menu_item().
        '_invalid' => false,
    );
    /**
     * Default transport.
     *
     * @since 4.3.0
     * @since 4.5.0 Default changed to 'refresh'
     * @var string
     */
    public $transport = 'refresh';
    /**
     * The post ID represented by this setting instance. This is the db_id.
     *
     * A negative value represents a placeholder ID for a new menu not yet saved.
     *
     * @since 4.3.0
     * @var int
     */
    public $post_id;
    /**
     * Storage of pre-setup menu item to prevent wasted calls to wp_setup_nav_menu_item().
     *
     * @since 4.3.0
     * @var array|null
     */
    protected $value;
    /**
     * Previous (placeholder) post ID used before creating a new menu item.
     *
     * This value will be exported to JS via the customize_save_response filter
     * so that JavaScript can update the settings to refer to the newly-assigned
     * post ID. This value is always negative to indicate it does not refer to
     * a real post.
     *
     * @since 4.3.0
     * @var int
     *
     * @see WP_Customize_Nav_Menu_Item_Setting::update()
     * @see WP_Customize_Nav_Menu_Item_Setting::amend_customize_save_response()
     */
    public $previous_post_id;
    /**
     * When previewing or updating a menu item, this stores the previous nav_menu_term_id
     * which ensures that we can apply the proper filters.
     *
     * @since 4.3.0
     * @var int
     */
    public $original_nav_menu_term_id;
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
     * When status is inserted, the placeholder post ID is stored in $previous_post_id.
     * When status is error, the error is stored in $update_error.
     *
     * @since 4.3.0
     * @var string updated|inserted|deleted|error
     *
     * @see WP_Customize_Nav_Menu_Item_Setting::update()
     * @see WP_Customize_Nav_Menu_Item_Setting::amend_customize_save_response()
     */
    public $update_status;
    /**
     * Any error object returned by wp_update_nav_menu_item() when setting is updated.
     *
     * @since 4.3.0
     * @var WP_Error
     *
     * @see WP_Customize_Nav_Menu_Item_Setting::update()
     * @see WP_Customize_Nav_Menu_Item_Setting::amend_customize_save_response()
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
        if (empty($manager->nav_menus)) {
            throw new Exception('Expected WP_Customize_Manager::$nav_menus to be set.');
        }
        if (!preg_match(self::ID_PATTERN, $id, $matches)) {
            throw new Exception("Illegal widget setting ID: {$id}");
        }
        $this->post_id = (int) $matches['id'];
        add_action('wp_update_nav_menu_item', array($this, 'flush_cached_value'), 10, 2);
        parent::__construct($manager, $id, $args);
        // Ensure that an initially-supplied value is valid.
        if (isset($this->value)) {
            $this->populate_value();
            foreach (array_diff(array_keys($this->default), array_keys($this->value)) as $missing) {
                throw new Exception("Supplied nav_menu_item value missing property: {$missing}");
            }
        }
    }
    /**
     * Clear the cached value when this nav menu item is updated.
     *
     * @since 4.3.0
     *
     * @param int $menu_id       The term ID for the menu.
     * @param int $menu_item_id  The post ID for the menu item.
     */
    public function flush_cached_value($menu_id, $menu_item_id)
    {
        unset($menu_id);
        if ($menu_item_id === $this->post_id) {
            $this->value = null;
        }
    }
    /**
     * Get the instance data for a given nav_menu_item setting.
     *
     * @since 4.3.0
     *
     * @see wp_setup_nav_menu_item()
     *
     * @return array|false Instance data array, or false if the item is marked for deletion.
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
            if (!empty($value) && empty($value['original_title'])) {
                $value['original_title'] = $this->get_original_title((object) $value);
            }
        } elseif (isset($this->value)) {
            $value = $this->value;
        } else {
            $value = false;
            // Note that a ID of less than one indicates a nav_menu not yet inserted.
            if ($this->post_id > 0) {
                $post = get_post($this->post_id);
                if ($post && self::POST_TYPE === $post->post_type) {
                    $is_title_empty = empty($post->post_title);
                    $value = (array) wp_setup_nav_menu_item($post);
                    if ($is_title_empty) {
                        $value['title'] = '';
                    }
                }
            }
            if (!is_array($value)) {
                $value = $this->default;
            }
            // Cache the value for future calls to avoid having to re-call wp_setup_nav_menu_item().
            $this->value = $value;
            $this->populate_value();
            $value = $this->value;
        }
        if (!empty($value) && empty($value['type_label'])) {
            $value['type_label'] = $this->get_type_label((object) $value);
        }
        return $value;
    }
    /**
     * Get original title.
     *
     * @since 4.7.0
     *
     * @param object $item Nav menu item.
     * @return string The original title.
     */
    protected function get_original_title($item)
    {
        $original_title = '';
        if ('post_type' === $item->type && !empty($item->object_id)) {
            $original_object = get_post($item->object_id);
            if ($original_object) {
                /** This filter is documented in wp-includes/post-template.php */
                $original_title = apply_filters('the_title', $original_object->post_title, $original_object->ID);
                if ('' === $original_title) {
                    /* translators: %d: ID of a post. */
                    $original_title = sprintf(__('#%d (no title)'), $original_object->ID);
                }
            }
        } elseif ('taxonomy' === $item->type && !empty($item->object_id)) {
            $original_term_title = get_term_field('name', $item->object_id, $item->object, 'raw');
            if (!is_wp_error($original_term_title)) {
                $original_title = $original_term_title;
            }
        } elseif ('post_type_archive' === $item->type) {
            $original_object = get_post_type_object($item->object);
            if ($original_object) {
                $original_title = $original_object->labels->archives;
            }
        }
        $original_title = html_entity_decode($original_title, ENT_QUOTES, get_bloginfo('charset'));
        return $original_title;
    }
    /**
     * Get type label.
     *
     * @since 4.7.0
     *
     * @param object $item Nav menu item.
     * @return string The type label.
     */
    protected function get_type_label($item)
    {
        if ('post_type' === $item->type) {
            $object = get_post_type_object($item->object);
            if ($object) {
                $type_label = $object->labels->singular_name;
            } else {
                $type_label = $item->object;
            }
        } elseif ('taxonomy' === $item->type) {
            $object = get_taxonomy($item->object);
            if ($object) {
                $type_label = $object->labels->singular_name;
            } else {
                $type_label = $item->object;
            }
        } elseif ('post_type_archive' === $item->type) {
            $type_label = __('Post Type Archive');
        } else {
            $type_label = __('Custom Link');
        }
        return $type_label;
    }
    /**
     * Ensure that the value is fully populated with the necessary properties.
     *
     * Translates some properties added by wp_setup_nav_menu_item() and removes others.
     *
     * @since 4.3.0
     *
     * @see WP_Customize_Nav_Menu_Item_Setting::value()
     */
    protected function populate_value()
    {
        if (!is_array($this->value)) {
            return;
        }
        if (isset($this->value['menu_order'])) {
            $this->value['position'] = $this->value['menu_order'];
            unset($this->value['menu_order']);
        }
        if (isset($this->value['post_status'])) {
            $this->value['status'] = $this->value['post_status'];
            unset($this->value['post_status']);
        }
        if (!isset($this->value['original_title'])) {
            $this->value['original_title'] = $this->get_original_title((object) $this->value);
        }
        if (!isset($this->value['nav_menu_term_id']) && $this->post_id > 0) {
            $menus = wp_get_post_terms($this->post_id, WP_Customize_Nav_Menu_Setting::TAXONOMY, array('fields' => 'ids'));
            if (!empty($menus)) {
                $this->value['nav_menu_term_id'] = array_shift($menus);
            } else {
                $this->value['nav_menu_term_id'] = 0;
            }
        }
        foreach (array('object_id', 'menu_item_parent', 'nav_menu_term_id') as $key) {
            if (!is_int($this->value[$key])) {
                $this->value[$key] = (int) $this->value[$key];
            }
        }
        foreach (array('classes', 'xfn') as $key) {
            if (is_array($this->value[$key])) {
                $this->value[$key] = implode(' ', $this->value[$key]);
            }
        }
        if (!isset($this->value['title'])) {
            $this->value['title'] = '';
        }
        if (!isset($this->value['_invalid'])) {
            $this->value['_invalid'] = false;
            $is_known_invalid = ('post_type' === $this->value['type'] || 'post_type_archive' === $this->value['type']) && !post_type_exists($this->value['object']) || 'taxonomy' === $this->value['type'] && !taxonomy_exists($this->value['object']);
            if ($is_known_invalid) {
                $this->value['_invalid'] = true;
            }
        }
        // Remove remaining properties available on a setup nav_menu_item post object which aren't relevant to the setting value.
        $irrelevant_properties = array('ID', 'comment_count', 'comment_status', 'db_id', 'filter', 'guid', 'ping_status', 'pinged', 'post_author', 'post_content', 'post_content_filtered', 'post_date', 'post_date_gmt', 'post_excerpt', 'post_mime_type', 'post_modified', 'post_modified_gmt', 'post_name', 'post_parent', 'post_password', 'post_title', 'post_type', 'to_ping');
        foreach ($irrelevant_properties as $property) {
            unset($this->value[$property]);
        }
    }
    /**
     * Handle previewing the setting.
     *
     * @since 4.3.0
     * @since 4.4.0 Added boolean return value.
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
        $is_placeholder = $this->post_id < 0;
        $is_dirty = $undefined !== $this->post_value($undefined);
        if (!$is_placeholder && !$is_dirty) {
            return false;
        }
        $this->is_previewed = true;
        $this->_original_value = $this->value();
        $this->original_nav_menu_term_id = $this->_original_value['nav_menu_term_id'];
        $this->_previewed_blog_id = get_current_blog_id();
        add_filter('wp_get_nav_menu_items', array($this, 'filter_wp_get_nav_menu_items'), 10, 3);
        $sort_callback = array(__CLASS__, 'sort_wp_get_nav_menu_items');
        if (!has_filter('wp_get_nav_menu_items', $sort_callback)) {
            add_filter('wp_get_nav_menu_items', array(__CLASS__, 'sort_wp_get_nav_menu_items'), 1000, 3);
        }
        // @todo Add get_post_metadata filters for plugins to add their data.
        return true;
    }
    /**
     * Filters the wp_get_nav_menu_items() result to supply the previewed menu items.
     *
     * @since 4.3.0
     *
     * @see wp_get_nav_menu_items()
     *
     * @param WP_Post[] $items An array of menu item post objects.
     * @param WP_Term   $menu  The menu object.
     * @param array     $args  An array of arguments used to retrieve menu item objects.
     * @return WP_Post[] Array of menu item objects.
     */
    public function filter_wp_get_nav_menu_items($items, $menu, $args)
    {
        $this_item = $this->value();
        $current_nav_menu_term_id = null;
        if (isset($this_item['nav_menu_term_id'])) {
            $current_nav_menu_term_id = $this_item['nav_menu_term_id'];
            unset($this_item['nav_menu_term_id']);
        }
        $should_filter = $menu->term_id === $this->original_nav_menu_term_id || $menu->term_id === $current_nav_menu_term_id;
        if (!$should_filter) {
            return $items;
        }
        // Handle deleted menu item, or menu item moved to another menu.
        $should_remove = false === $this_item || isset($this_item['_invalid']) && true === $this_item['_invalid'] || $this->original_nav_menu_term_id === $menu->term_id && $current_nav_menu_term_id !== $this->original_nav_menu_term_id;
        if ($should_remove) {
            $filtered_items = array();
            foreach ($items as $item) {
                if ($item->db_id !== $this->post_id) {
                    $filtered_items[] = $item;
                }
            }
            return $filtered_items;
        }
        $mutated = false;
        $should_update = is_array($this_item) && $current_nav_menu_term_id === $menu->term_id;
        if ($should_update) {
            foreach ($items as $item) {
                if ($item->db_id === $this->post_id) {
                    foreach (get_object_vars($this->value_as_wp_post_nav_menu_item()) as $key => $value) {
                        $item->{$key} = $value;
                    }
                    $mutated = true;
                }
            }
            // Not found so we have to append it..
            if (!$mutated) {
                $items[] = $this->value_as_wp_post_nav_menu_item();
            }
        }
        return $items;
    }
    /**
     * Re-apply the tail logic also applied on $items by wp_get_nav_menu_items().
     *
     * @since 4.3.0
     *
     * @see wp_get_nav_menu_items()
     *
     * @param WP_Post[] $items An array of menu item post objects.
     * @param WP_Term   $menu  The menu object.
     * @param array     $args  An array of arguments used to retrieve menu item objects.
     * @return WP_Post[] Array of menu item objects.
     */
    public static function sort_wp_get_nav_menu_items($items, $menu, $args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("sort_wp_get_nav_menu_items") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/customize/class-wp-customize-nav-menu-item-setting.php at line 468")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called sort_wp_get_nav_menu_items:468@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/customize/class-wp-customize-nav-menu-item-setting.php');
        die();
    }
    /**
     * Get the value emulated into a WP_Post and set up as a nav_menu_item.
     *
     * @since 4.3.0
     *
     * @return WP_Post With wp_setup_nav_menu_item() applied.
     */
    public function value_as_wp_post_nav_menu_item()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("value_as_wp_post_nav_menu_item") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/customize/class-wp-customize-nav-menu-item-setting.php at line 491")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called value_as_wp_post_nav_menu_item:491@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/customize/class-wp-customize-nav-menu-item-setting.php');
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
     * @param array $menu_item_value The value to sanitize.
     * @return array|false|null|WP_Error Null or WP_Error if an input isn't valid. False if it is marked for deletion.
     *                                   Otherwise the sanitized value.
     */
    public function sanitize($menu_item_value)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("sanitize") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/customize/class-wp-customize-nav-menu-item-setting.php at line 554")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called sanitize:554@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/customize/class-wp-customize-nav-menu-item-setting.php');
        die();
    }
    /**
     * Creates/updates the nav_menu_item post for this setting.
     *
     * Any created menu items will have their assigned post IDs exported to the client
     * via the {@see 'customize_save_response'} filter. Likewise, any errors will be
     * exported to the client via the customize_save_response() filter.
     *
     * To delete a menu, the client can send false as the value.
     *
     * @since 4.3.0
     *
     * @see wp_update_nav_menu_item()
     *
     * @param array|false $value The menu item array to update. If false, then the menu item will be deleted
     *                           entirely. See WP_Customize_Nav_Menu_Item_Setting::$default for what the value
     *                           should consist of.
     * @return null|void
     */
    protected function update($value)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("update") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/customize/class-wp-customize-nav-menu-item-setting.php at line 621")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called update:621@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/customize/class-wp-customize-nav-menu-item-setting.php');
        die();
    }
    /**
     * Export data for the JS client.
     *
     * @since 4.3.0
     *
     * @see WP_Customize_Nav_Menu_Item_Setting::update()
     *
     * @param array $data Additional information passed back to the 'saved' event on `wp.customize`.
     * @return array Save response data.
     */
    public function amend_customize_save_response($data)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("amend_customize_save_response") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/customize/class-wp-customize-nav-menu-item-setting.php at line 716")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called amend_customize_save_response:716@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/customize/class-wp-customize-nav-menu-item-setting.php');
        die();
    }
}