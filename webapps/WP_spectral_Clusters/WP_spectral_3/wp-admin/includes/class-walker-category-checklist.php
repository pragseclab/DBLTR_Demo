<?php

/**
 * Taxonomy API: Walker_Category_Checklist class
 *
 * @package WordPress
 * @subpackage Administration
 * @since 4.4.0
 */
/**
 * Core walker class to output an unordered list of category checkbox input elements.
 *
 * @since 2.5.1
 *
 * @see Walker
 * @see wp_category_checklist()
 * @see wp_terms_checklist()
 */
class Walker_Category_Checklist extends Walker
{
    public $tree_type = 'category';
    public $db_fields = array('parent' => 'parent', 'id' => 'term_id');
    // TODO: Decouple this.
    /**
     * Starts the list before the elements are added.
     *
     * @see Walker:start_lvl()
     *
     * @since 2.5.1
     *
     * @param string $output Used to append additional content (passed by reference).
     * @param int    $depth  Depth of category. Used for tab indentation.
     * @param array  $args   An array of arguments. @see wp_terms_checklist()
     */
    public function start_lvl(&$output, $depth = 0, $args = array())
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("start_lvl") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-walker-category-checklist.php at line 37")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called start_lvl:37@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-walker-category-checklist.php');
        die();
    }
    /**
     * Ends the list of after the elements are added.
     *
     * @see Walker::end_lvl()
     *
     * @since 2.5.1
     *
     * @param string $output Used to append additional content (passed by reference).
     * @param int    $depth  Depth of category. Used for tab indentation.
     * @param array  $args   An array of arguments. @see wp_terms_checklist()
     */
    public function end_lvl(&$output, $depth = 0, $args = array())
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("end_lvl") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-walker-category-checklist.php at line 53")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called end_lvl:53@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-walker-category-checklist.php');
        die();
    }
    /**
     * Start the element output.
     *
     * @see Walker::start_el()
     *
     * @since 2.5.1
     *
     * @param string  $output   Used to append additional content (passed by reference).
     * @param WP_Term $category The current term object.
     * @param int     $depth    Depth of the term in reference to parents. Default 0.
     * @param array   $args     An array of arguments. @see wp_terms_checklist()
     * @param int     $id       ID of the current term.
     */
    public function start_el(&$output, $category, $depth = 0, $args = array(), $id = 0)
    {
        if (empty($args['taxonomy'])) {
            $taxonomy = 'category';
        } else {
            $taxonomy = $args['taxonomy'];
        }
        if ('category' === $taxonomy) {
            $name = 'post_category';
        } else {
            $name = 'tax_input[' . $taxonomy . ']';
        }
        $args['popular_cats'] = !empty($args['popular_cats']) ? array_map('intval', $args['popular_cats']) : array();
        $class = in_array($category->term_id, $args['popular_cats'], true) ? ' class="popular-category"' : '';
        $args['selected_cats'] = !empty($args['selected_cats']) ? array_map('intval', $args['selected_cats']) : array();
        if (!empty($args['list_only'])) {
            $aria_checked = 'false';
            $inner_class = 'category';
            if (in_array($category->term_id, $args['selected_cats'], true)) {
                $inner_class .= ' selected';
                $aria_checked = 'true';
            }
            $output .= "\n" . '<li' . $class . '>' . '<div class="' . $inner_class . '" data-term-id=' . $category->term_id . ' tabindex="0" role="checkbox" aria-checked="' . $aria_checked . '">' . esc_html(apply_filters('the_category', $category->name, '', '')) . '</div>';
        } else {
            $is_selected = in_array($category->term_id, $args['selected_cats'], true);
            $is_disabled = !empty($args['disabled']);
            $output .= "\n<li id='{$taxonomy}-{$category->term_id}'{$class}>" . '<label class="selectit"><input value="' . $category->term_id . '" type="checkbox" name="' . $name . '[]" id="in-' . $taxonomy . '-' . $category->term_id . '"' . checked($is_selected, true, false) . disabled($is_disabled, true, false) . ' /> ' . esc_html(apply_filters('the_category', $category->name, '', '')) . '</label>';
        }
    }
    /**
     * Ends the element output, if needed.
     *
     * @see Walker::end_el()
     *
     * @since 2.5.1
     *
     * @param string  $output   Used to append additional content (passed by reference).
     * @param WP_Term $category The current term object.
     * @param int     $depth    Depth of the term in reference to parents. Default 0.
     * @param array   $args     An array of arguments. @see wp_terms_checklist()
     */
    public function end_el(&$output, $category, $depth = 0, $args = array())
    {
        $output .= "</li>\n";
    }
}