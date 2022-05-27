<?php

/**
 * List Table API: WP_Comments_List_Table class
 *
 * @package WordPress
 * @subpackage Administration
 * @since 3.1.0
 */
/**
 * Core class used to implement displaying comments in a list table.
 *
 * @since 3.1.0
 * @access private
 *
 * @see WP_List_Table
 */
class WP_Comments_List_Table extends WP_List_Table
{
    public $checkbox = true;
    public $pending_count = array();
    public $extra_items;
    private $user_can;
    /**
     * Constructor.
     *
     * @since 3.1.0
     *
     * @see WP_List_Table::__construct() for more information on default arguments.
     *
     * @global int $post_id
     *
     * @param array $args An associative array of arguments.
     */
    public function __construct($args = array())
    {
        global $post_id;
        $post_id = isset($_REQUEST['p']) ? absint($_REQUEST['p']) : 0;
        if (get_option('show_avatars')) {
            add_filter('comment_author', array($this, 'floated_admin_avatar'), 10, 2);
        }
        parent::__construct(array('plural' => 'comments', 'singular' => 'comment', 'ajax' => true, 'screen' => isset($args['screen']) ? $args['screen'] : null));
    }
    /**
     * Adds avatars to comment author names.
     *
     * @since 3.1.0
     *
     * @param string $name       Comment author name.
     * @param int    $comment_id Comment ID.
     * @return string Avatar with the user name.
     */
    public function floated_admin_avatar($name, $comment_id)
    {
        $comment = get_comment($comment_id);
        $avatar = get_avatar($comment, 32, 'mystery');
        return "{$avatar} {$name}";
    }
    /**
     * @return bool
     */
    public function ajax_user_can()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("ajax_user_can") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-comments-list-table.php at line 64")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called ajax_user_can:64@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-comments-list-table.php');
        die();
    }
    /**
     * @global string $mode           List table view mode.
     * @global int    $post_id
     * @global string $comment_status
     * @global string $comment_type
     * @global string $search
     */
    public function prepare_items()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("prepare_items") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-comments-list-table.php at line 75")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called prepare_items:75@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-comments-list-table.php');
        die();
    }
    /**
     * @param string $comment_status
     * @return int
     */
    public function get_per_page($comment_status = 'all')
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_per_page") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-comments-list-table.php at line 136")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_per_page:136@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-comments-list-table.php');
        die();
    }
    /**
     * @global string $comment_status
     */
    public function no_items()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("no_items") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-comments-list-table.php at line 152")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called no_items:152@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-comments-list-table.php');
        die();
    }
    /**
     * @global int $post_id
     * @global string $comment_status
     * @global string $comment_type
     */
    protected function get_views()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_views") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-comments-list-table.php at line 168")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_views:168@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-comments-list-table.php');
        die();
    }
    /**
     * @global string $comment_status
     *
     * @return array
     */
    protected function get_bulk_actions()
    {
        global $comment_status;
        $actions = array();
        if (in_array($comment_status, array('all', 'approved'), true)) {
            $actions['unapprove'] = __('Unapprove');
        }
        if (in_array($comment_status, array('all', 'moderated'), true)) {
            $actions['approve'] = __('Approve');
        }
        if (in_array($comment_status, array('all', 'moderated', 'approved', 'trash'), true)) {
            $actions['spam'] = _x('Mark as spam', 'comment');
        }
        if ('trash' === $comment_status) {
            $actions['untrash'] = __('Restore');
        } elseif ('spam' === $comment_status) {
            $actions['unspam'] = _x('Not spam', 'comment');
        }
        if (in_array($comment_status, array('trash', 'spam'), true) || !EMPTY_TRASH_DAYS) {
            $actions['delete'] = __('Delete permanently');
        } else {
            $actions['trash'] = __('Move to Trash');
        }
        return $actions;
    }
    /**
     * @global string $comment_status
     * @global string $comment_type
     *
     * @param string $which
     */
    protected function extra_tablenav($which)
    {
        global $comment_status, $comment_type;
        static $has_items;
        if (!isset($has_items)) {
            $has_items = $this->has_items();
        }
        echo '<div class="alignleft actions">';
        if ('top' === $which) {
            ob_start();
            $this->comment_type_dropdown($comment_type);
            /**
             * Fires just before the Filter submit button for comment types.
             *
             * @since 3.5.0
             */
            do_action('restrict_manage_comments');
            $output = ob_get_clean();
            if (!empty($output) && $this->has_items()) {
                echo $output;
                submit_button(__('Filter'), '', 'filter_action', false, array('id' => 'post-query-submit'));
            }
        }
        if (('spam' === $comment_status || 'trash' === $comment_status) && $has_items && current_user_can('moderate_comments')) {
            wp_nonce_field('bulk-destroy', '_destroy_nonce');
            $title = 'spam' === $comment_status ? esc_attr__('Empty Spam') : esc_attr__('Empty Trash');
            submit_button($title, 'apply', 'delete_all', false);
        }
        /**
         * Fires after the Filter submit button for comment types.
         *
         * @since 2.5.0
         * @since 5.6.0 The `$which` parameter was added.
         *
         * @param string $comment_status The comment status name. Default 'All'.
         * @param string $which          The location of the extra table nav markup: 'top' or 'bottom'.
         */
        do_action('manage_comments_nav', $comment_status, $which);
        echo '</div>';
    }
    /**
     * @return string|false
     */
    public function current_action()
    {
        if (isset($_REQUEST['delete_all']) || isset($_REQUEST['delete_all2'])) {
            return 'delete_all';
        }
        return parent::current_action();
    }
    /**
     * @global int $post_id
     *
     * @return array
     */
    public function get_columns()
    {
        global $post_id;
        $columns = array();
        if ($this->checkbox) {
            $columns['cb'] = '<input type="checkbox" />';
        }
        $columns['author'] = __('Author');
        $columns['comment'] = _x('Comment', 'column name');
        if (!$post_id) {
            /* translators: Column name or table row header. */
            $columns['response'] = __('In response to');
        }
        $columns['date'] = _x('Submitted on', 'column name');
        return $columns;
    }
    /**
     * Displays a comment type drop-down for filtering on the Comments list table.
     *
     * @since 5.5.0
     * @since 5.6.0 Renamed from `comment_status_dropdown()` to `comment_type_dropdown()`.
     *
     * @param string $comment_type The current comment type slug.
     */
    protected function comment_type_dropdown($comment_type)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("comment_type_dropdown") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-comments-list-table.php at line 354")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called comment_type_dropdown:354@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-comments-list-table.php');
        die();
    }
    /**
     * @return array
     */
    protected function get_sortable_columns()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_sortable_columns") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-comments-list-table.php at line 372")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_sortable_columns:372@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-comments-list-table.php');
        die();
    }
    /**
     * Get the name of the default primary column.
     *
     * @since 4.3.0
     *
     * @return string Name of the default primary column, in this case, 'comment'.
     */
    protected function get_default_primary_column_name()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_default_primary_column_name") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-comments-list-table.php at line 383")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_default_primary_column_name:383@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-comments-list-table.php');
        die();
    }
    /**
     * Displays the comments table.
     *
     * Overrides the parent display() method to render extra comments.
     *
     * @since 3.1.0
     */
    public function display()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("display") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-comments-list-table.php at line 394")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called display:394@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-comments-list-table.php');
        die();
    }
    /**
     * @global WP_Post    $post    Global post object.
     * @global WP_Comment $comment Global comment object.
     *
     * @param WP_Comment $item
     */
    public function single_row($item)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("single_row") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-comments-list-table.php at line 454")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called single_row:454@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-comments-list-table.php');
        die();
    }
    /**
     * Generate and display row actions links.
     *
     * @since 4.3.0
     *
     * @global string $comment_status Status for the current listed comments.
     *
     * @param WP_Comment $comment     The comment object.
     * @param string     $column_name Current column name.
     * @param string     $primary     Primary column name.
     * @return string Row actions output for comments. An empty string
     *                if the current column is not the primary column,
     *                or if the current user cannot edit the comment.
     */
    protected function handle_row_actions($comment, $column_name, $primary)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("handle_row_actions") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-comments-list-table.php at line 486")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called handle_row_actions:486@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-comments-list-table.php');
        die();
    }
    /**
     * @param WP_Comment $comment The comment object.
     */
    public function column_cb($comment)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("column_cb") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-comments-list-table.php at line 581")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called column_cb:581@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-comments-list-table.php');
        die();
    }
    /**
     * @param WP_Comment $comment The comment object.
     */
    public function column_comment($comment)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("column_comment") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-comments-list-table.php at line 601")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called column_comment:601@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-comments-list-table.php');
        die();
    }
    /**
     * @global string $comment_status
     *
     * @param WP_Comment $comment The comment object.
     */
    public function column_author($comment)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("column_author") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-comments-list-table.php at line 650")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called column_author:650@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-comments-list-table.php');
        die();
    }
    /**
     * @param WP_Comment $comment The comment object.
     */
    public function column_date($comment)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("column_date") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-comments-list-table.php at line 685")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called column_date:685@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-comments-list-table.php');
        die();
    }
    /**
     * @param WP_Comment $comment The comment object.
     */
    public function column_response($comment)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("column_response") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-comments-list-table.php at line 706")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called column_response:706@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-comments-list-table.php');
        die();
    }
    /**
     * @param WP_Comment $comment     The comment object.
     * @param string     $column_name The custom column's name.
     */
    public function column_default($comment, $column_name)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("column_default") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-comments-list-table.php at line 752")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called column_default:752@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-admin/includes/class-wp-comments-list-table.php');
        die();
    }
}