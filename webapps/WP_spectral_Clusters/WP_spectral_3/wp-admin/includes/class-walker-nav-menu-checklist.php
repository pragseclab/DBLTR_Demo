<?php

/**
 * Navigation Menu API: Walker_Nav_Menu_Checklist class
 *
 * @package WordPress
 * @subpackage Administration
 * @since 4.4.0
 */
/**
 * Create HTML list of nav menu input items.
 *
 * @since 3.0.0
 * @uses Walker_Nav_Menu
 */
class Walker_Nav_Menu_Checklist extends Walker_Nav_Menu
{
    /**
     * @param array|false $fields Database fields to use.
     */
    public function __construct($fields = false)
    {
        if ($fields) {
            $this->db_fields = $fields;
        }
    }
    /**
     * Starts the list before the elements are added.
     *
     * @see Walker_Nav_Menu::start_lvl()
     *
     * @since 3.0.0
     *
     * @param string   $output Used to append additional content (passed by reference).
     * @param int      $depth  Depth of page. Used for padding.
     * @param stdClass $args   Not used.
     */
    public function start_lvl(&$output, $depth = 0, $args = null)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("start_lvl") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-walker-nav-menu-checklist.php at line 40")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called start_lvl:40@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-walker-nav-menu-checklist.php');
        die();
    }
    /**
     * Ends the list of after the elements are added.
     *
     * @see Walker_Nav_Menu::end_lvl()
     *
     * @since 3.0.0
     *
     * @param string   $output Used to append additional content (passed by reference).
     * @param int      $depth  Depth of page. Used for padding.
     * @param stdClass $args   Not used.
     */
    public function end_lvl(&$output, $depth = 0, $args = null)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("end_lvl") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-walker-nav-menu-checklist.php at line 56")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called end_lvl:56@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-walker-nav-menu-checklist.php');
        die();
    }
    /**
     * Start the element output.
     *
     * @see Walker_Nav_Menu::start_el()
     *
     * @since 3.0.0
     *
     * @global int        $_nav_menu_placeholder
     * @global int|string $nav_menu_selected_id
     *
     * @param string   $output Used to append additional content (passed by reference).
     * @param WP_Post  $item   Menu item data object.
     * @param int      $depth  Depth of menu item. Used for padding.
     * @param stdClass $args   Not used.
     * @param int      $id     Not used.
     */
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        global $_nav_menu_placeholder, $nav_menu_selected_id;
        $_nav_menu_placeholder = 0 > $_nav_menu_placeholder ? (int) $_nav_menu_placeholder - 1 : -1;
        $possible_object_id = isset($item->post_type) && 'nav_menu_item' === $item->post_type ? $item->object_id : $_nav_menu_placeholder;
        $possible_db_id = !empty($item->ID) && 0 < $possible_object_id ? (int) $item->ID : 0;
        $indent = $depth ? str_repeat("\t", $depth) : '';
        $output .= $indent . '<li>';
        $output .= '<label class="menu-item-title">';
        $output .= '<input type="checkbox"' . wp_nav_menu_disabled_check($nav_menu_selected_id, false) . ' class="menu-item-checkbox';
        if (!empty($item->front_or_home)) {
            $output .= ' add-to-top';
        }
        $output .= '" name="menu-item[' . $possible_object_id . '][menu-item-object-id]" value="' . esc_attr($item->object_id) . '" /> ';
        if (!empty($item->label)) {
            $title = $item->label;
        } elseif (isset($item->post_type)) {
            /** This filter is documented in wp-includes/post-template.php */
            $title = apply_filters('the_title', $item->post_title, $item->ID);
        }
        $output .= isset($title) ? esc_html($title) : esc_html($item->title);
        if (empty($item->label) && isset($item->post_type) && 'page' === $item->post_type) {
            // Append post states.
            $output .= _post_states($item, false);
        }
        $output .= '</label>';
        // Menu item hidden fields.
        $output .= '<input type="hidden" class="menu-item-db-id" name="menu-item[' . $possible_object_id . '][menu-item-db-id]" value="' . $possible_db_id . '" />';
        $output .= '<input type="hidden" class="menu-item-object" name="menu-item[' . $possible_object_id . '][menu-item-object]" value="' . esc_attr($item->object) . '" />';
        $output .= '<input type="hidden" class="menu-item-parent-id" name="menu-item[' . $possible_object_id . '][menu-item-parent-id]" value="' . esc_attr($item->menu_item_parent) . '" />';
        $output .= '<input type="hidden" class="menu-item-type" name="menu-item[' . $possible_object_id . '][menu-item-type]" value="' . esc_attr($item->type) . '" />';
        $output .= '<input type="hidden" class="menu-item-title" name="menu-item[' . $possible_object_id . '][menu-item-title]" value="' . esc_attr($item->title) . '" />';
        $output .= '<input type="hidden" class="menu-item-url" name="menu-item[' . $possible_object_id . '][menu-item-url]" value="' . esc_attr($item->url) . '" />';
        $output .= '<input type="hidden" class="menu-item-target" name="menu-item[' . $possible_object_id . '][menu-item-target]" value="' . esc_attr($item->target) . '" />';
        $output .= '<input type="hidden" class="menu-item-attr-title" name="menu-item[' . $possible_object_id . '][menu-item-attr-title]" value="' . esc_attr($item->attr_title) . '" />';
        $output .= '<input type="hidden" class="menu-item-classes" name="menu-item[' . $possible_object_id . '][menu-item-classes]" value="' . esc_attr(implode(' ', $item->classes)) . '" />';
        $output .= '<input type="hidden" class="menu-item-xfn" name="menu-item[' . $possible_object_id . '][menu-item-xfn]" value="' . esc_attr($item->xfn) . '" />';
    }
}