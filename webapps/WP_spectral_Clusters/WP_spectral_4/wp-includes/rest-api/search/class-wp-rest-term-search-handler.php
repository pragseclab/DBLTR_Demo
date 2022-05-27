<?php

/**
 * REST API: WP_REST_Term_Search_Handler class
 *
 * @package WordPress
 * @subpackage REST_API
 * @since 5.6.0
 */
/**
 * Core class representing a search handler for terms in the REST API.
 *
 * @since 5.6.0
 *
 * @see WP_REST_Search_Handler
 */
class WP_REST_Term_Search_Handler extends WP_REST_Search_Handler
{
    /**
     * Constructor.
     *
     * @since 5.6.0
     */
    public function __construct()
    {
        $this->type = 'term';
        $this->subtypes = array_values(get_taxonomies(array('public' => true, 'show_in_rest' => true), 'names'));
    }
    /**
     * Searches the object type content for a given search request.
     *
     * @since 5.6.0
     *
     * @param WP_REST_Request $request Full REST request.
     * @return array Associative array containing an `WP_REST_Search_Handler::RESULT_IDS` containing
     *               an array of found IDs and `WP_REST_Search_Handler::RESULT_TOTAL` containing the
     *               total count for the matching search results.
     */
    public function search_items(WP_REST_Request $request)
    {
        $taxonomies = $request[WP_REST_Search_Controller::PROP_SUBTYPE];
        if (in_array(WP_REST_Search_Controller::TYPE_ANY, $taxonomies, true)) {
            $taxonomies = $this->subtypes;
        }
        $page = (int) $request['page'];
        $per_page = (int) $request['per_page'];
        $query_args = array('taxonomy' => $taxonomies, 'hide_empty' => false, 'offset' => ($page - 1) * $per_page, 'number' => $per_page);
        if (!empty($request['search'])) {
            $query_args['search'] = $request['search'];
        }
        /**
         * Filters the query arguments for a REST API search request.
         *
         * Enables adding extra arguments or setting defaults for a term search request.
         *
         * @since 5.6.0
         *
         * @param array           $query_args Key value array of query var to query value.
         * @param WP_REST_Request $request    The request used.
         */
        $query_args = apply_filters('rest_term_search_query', $query_args, $request);
        $query = new WP_Term_Query();
        $found_terms = $query->query($query_args);
        $found_ids = wp_list_pluck($found_terms, 'term_id');
        unset($query_args['offset'], $query_args['number']);
        $total = wp_count_terms($query_args);
        // wp_count_terms() can return a falsey value when the term has no children.
        if (!$total) {
            $total = 0;
        }
        return array(self::RESULT_IDS => $found_ids, self::RESULT_TOTAL => $total);
    }
    /**
     * Prepares the search result for a given ID.
     *
     * @since 5.6.0
     *
     * @param int   $id     Item ID.
     * @param array $fields Fields to include for the item.
     * @return array Associative array containing all fields for the item.
     */
    public function prepare_item($id, array $fields)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("prepare_item") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/search/class-wp-rest-term-search-handler.php at line 84")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called prepare_item:84@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/search/class-wp-rest-term-search-handler.php');
        die();
    }
    /**
     * Prepares links for the search result of a given ID.
     *
     * @since 5.6.0
     *
     * @param int $id Item ID.
     * @return array Links for the given item.
     */
    public function prepare_item_links($id)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("prepare_item_links") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/search/class-wp-rest-term-search-handler.php at line 110")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called prepare_item_links:110@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/search/class-wp-rest-term-search-handler.php');
        die();
    }
}