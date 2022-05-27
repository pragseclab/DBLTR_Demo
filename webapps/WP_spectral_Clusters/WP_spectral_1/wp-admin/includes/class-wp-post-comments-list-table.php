<?php

/**
 * List Table API: WP_Post_Comments_List_Table class
 *
 * @package WordPress
 * @subpackage Administration
 * @since 4.4.0
 */
/**
 * Core class used to implement displaying post comments in a list table.
 *
 * @since 3.1.0
 * @access private
 *
 * @see WP_Comments_List_Table
 */
class WP_Post_Comments_List_Table extends WP_Comments_List_Table
{
    /**
     * @return array
     */
    protected function get_column_info()
    {
        return array(array('author' => __('Author'), 'comment' => _x('Comment', 'column name')), array(), array(), 'comment');
    }
    /**
     * @return array
     */
    protected function get_table_classes()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_table_classes") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-admin/includes/class-wp-post-comments-list-table.php at line 32")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_table_classes:32@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-admin/includes/class-wp-post-comments-list-table.php');
        die();
    }
    /**
     * @param bool $output_empty
     */
    public function display($output_empty = false)
    {
        $singular = $this->_args['singular'];
        wp_nonce_field('fetch-list-' . get_class($this), '_ajax_fetch_list_nonce');
        ?>
<table class="<?php 
        echo implode(' ', $this->get_table_classes());
        ?>" style="display:none;">
	<tbody id="the-comment-list"
		<?php 
        if ($singular) {
            echo " data-wp-lists='list:{$singular}'";
        }
        ?>
		>
		<?php 
        if (!$output_empty) {
            $this->display_rows_or_placeholder();
        }
        ?>
	</tbody>
</table>
		<?php 
    }
    /**
     * @param bool $comment_status
     * @return int
     */
    public function get_per_page($comment_status = false)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_per_page") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-admin/includes/class-wp-post-comments-list-table.php at line 70")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_per_page:70@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-admin/includes/class-wp-post-comments-list-table.php');
        die();
    }
}