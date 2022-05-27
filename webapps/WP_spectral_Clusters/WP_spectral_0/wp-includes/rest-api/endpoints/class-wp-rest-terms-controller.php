<?php

/**
 * REST API: WP_REST_Terms_Controller class
 *
 * @package WordPress
 * @subpackage REST_API
 * @since 4.7.0
 */
/**
 * Core class used to managed terms associated with a taxonomy via the REST API.
 *
 * @since 4.7.0
 *
 * @see WP_REST_Controller
 */
class WP_REST_Terms_Controller extends WP_REST_Controller
{
    /**
     * Taxonomy key.
     *
     * @since 4.7.0
     * @var string
     */
    protected $taxonomy;
    /**
     * Instance of a term meta fields object.
     *
     * @since 4.7.0
     * @var WP_REST_Term_Meta_Fields
     */
    protected $meta;
    /**
     * Column to have the terms be sorted by.
     *
     * @since 4.7.0
     * @var string
     */
    protected $sort_column;
    /**
     * Number of terms that were found.
     *
     * @since 4.7.0
     * @var int
     */
    protected $total_terms;
    /**
     * Constructor.
     *
     * @since 4.7.0
     *
     * @param string $taxonomy Taxonomy key.
     */
    public function __construct($taxonomy)
    {
        $this->taxonomy = $taxonomy;
        $this->namespace = 'wp/v2';
        $tax_obj = get_taxonomy($taxonomy);
        $this->rest_base = !empty($tax_obj->rest_base) ? $tax_obj->rest_base : $tax_obj->name;
        $this->meta = new WP_REST_Term_Meta_Fields($taxonomy);
    }
    /**
     * Registers the routes for the objects of the controller.
     *
     * @since 4.7.0
     *
     * @see register_rest_route()
     */
    public function register_routes()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("register_routes") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-terms-controller.php at line 71")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called register_routes:71@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-terms-controller.php');
        die();
    }
    /**
     * Checks if a request has access to read terms in the specified taxonomy.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True if the request has read access, otherwise false or WP_Error object.
     */
    public function get_items_permissions_check($request)
    {
        $tax_obj = get_taxonomy($this->taxonomy);
        if (!$tax_obj || !$this->check_is_taxonomy_allowed($this->taxonomy)) {
            return false;
        }
        if ('edit' === $request['context'] && !current_user_can($tax_obj->cap->edit_terms)) {
            return new WP_Error('rest_forbidden_context', __('Sorry, you are not allowed to edit terms in this taxonomy.'), array('status' => rest_authorization_required_code()));
        }
        return true;
    }
    /**
     * Retrieves terms associated with a taxonomy.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function get_items($request)
    {
        // Retrieve the list of registered collection query parameters.
        $registered = $this->get_collection_params();
        /*
         * This array defines mappings between public API query parameters whose
         * values are accepted as-passed, and their internal WP_Query parameter
         * name equivalents (some are the same). Only values which are also
         * present in $registered will be set.
         */
        $parameter_mappings = array('exclude' => 'exclude', 'include' => 'include', 'order' => 'order', 'orderby' => 'orderby', 'post' => 'post', 'hide_empty' => 'hide_empty', 'per_page' => 'number', 'search' => 'search', 'slug' => 'slug');
        $prepared_args = array('taxonomy' => $this->taxonomy);
        /*
         * For each known parameter which is both registered and present in the request,
         * set the parameter's value on the query $prepared_args.
         */
        foreach ($parameter_mappings as $api_param => $wp_param) {
            if (isset($registered[$api_param], $request[$api_param])) {
                $prepared_args[$wp_param] = $request[$api_param];
            }
        }
        if (isset($prepared_args['orderby']) && isset($request['orderby'])) {
            $orderby_mappings = array('include_slugs' => 'slug__in');
            if (isset($orderby_mappings[$request['orderby']])) {
                $prepared_args['orderby'] = $orderby_mappings[$request['orderby']];
            }
        }
        if (isset($registered['offset']) && !empty($request['offset'])) {
            $prepared_args['offset'] = $request['offset'];
        } else {
            $prepared_args['offset'] = ($request['page'] - 1) * $prepared_args['number'];
        }
        $taxonomy_obj = get_taxonomy($this->taxonomy);
        if ($taxonomy_obj->hierarchical && isset($registered['parent'], $request['parent'])) {
            if (0 === $request['parent']) {
                // Only query top-level terms.
                $prepared_args['parent'] = 0;
            } else {
                if ($request['parent']) {
                    $prepared_args['parent'] = $request['parent'];
                }
            }
        }
        /**
         * Filters get_terms() arguments when querying users via the REST API.
         *
         * The dynamic portion of the hook name, `$this->taxonomy`, refers to the taxonomy slug.
         *
         * Possible hook names include:
         *
         *  - `rest_category_query`
         *  - `rest_post_tag_query`
         *
         * Enables adding extra arguments or setting defaults for a terms
         * collection request.
         *
         * @since 4.7.0
         *
         * @link https://developer.wordpress.org/reference/functions/get_terms/
         *
         * @param array           $prepared_args Array of arguments to be
         *                                       passed to get_terms().
         * @param WP_REST_Request $request       The REST API request.
         */
        $prepared_args = apply_filters("rest_{$this->taxonomy}_query", $prepared_args, $request);
        if (!empty($prepared_args['post'])) {
            $query_result = wp_get_object_terms($prepared_args['post'], $this->taxonomy, $prepared_args);
            // Used when calling wp_count_terms() below.
            $prepared_args['object_ids'] = $prepared_args['post'];
        } else {
            $query_result = get_terms($prepared_args);
        }
        $count_args = $prepared_args;
        unset($count_args['number'], $count_args['offset']);
        $total_terms = wp_count_terms($count_args);
        // wp_count_terms() can return a falsey value when the term has no children.
        if (!$total_terms) {
            $total_terms = 0;
        }
        $response = array();
        foreach ($query_result as $term) {
            $data = $this->prepare_item_for_response($term, $request);
            $response[] = $this->prepare_response_for_collection($data);
        }
        $response = rest_ensure_response($response);
        // Store pagination values for headers.
        $per_page = (int) $prepared_args['number'];
        $page = ceil((int) $prepared_args['offset'] / $per_page + 1);
        $response->header('X-WP-Total', (int) $total_terms);
        $max_pages = ceil($total_terms / $per_page);
        $response->header('X-WP-TotalPages', (int) $max_pages);
        $base = add_query_arg(urlencode_deep($request->get_query_params()), rest_url($this->namespace . '/' . $this->rest_base));
        if ($page > 1) {
            $prev_page = $page - 1;
            if ($prev_page > $max_pages) {
                $prev_page = $max_pages;
            }
            $prev_link = add_query_arg('page', $prev_page, $base);
            $response->link_header('prev', $prev_link);
        }
        if ($max_pages > $page) {
            $next_page = $page + 1;
            $next_link = add_query_arg('page', $next_page, $base);
            $response->link_header('next', $next_link);
        }
        return $response;
    }
    /**
     * Get the term, if the ID is valid.
     *
     * @since 4.7.2
     *
     * @param int $id Supplied ID.
     * @return WP_Term|WP_Error Term object if ID is valid, WP_Error otherwise.
     */
    protected function get_term($id)
    {
        $error = new WP_Error('rest_term_invalid', __('Term does not exist.'), array('status' => 404));
        if (!$this->check_is_taxonomy_allowed($this->taxonomy)) {
            return $error;
        }
        if ((int) $id <= 0) {
            return $error;
        }
        $term = get_term((int) $id, $this->taxonomy);
        if (empty($term) || $term->taxonomy !== $this->taxonomy) {
            return $error;
        }
        return $term;
    }
    /**
     * Checks if a request has access to read or edit the specified term.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True if the request has read access for the item, otherwise false or WP_Error object.
     */
    public function get_item_permissions_check($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_item_permissions_check") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-terms-controller.php at line 241")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_item_permissions_check:241@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-terms-controller.php');
        die();
    }
    /**
     * Gets a single term from a taxonomy.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function get_item($request)
    {
        $term = $this->get_term($request['id']);
        if (is_wp_error($term)) {
            return $term;
        }
        $response = $this->prepare_item_for_response($term, $request);
        return rest_ensure_response($response);
    }
    /**
     * Checks if a request has access to create a term.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True if the request has access to create items, false or WP_Error object otherwise.
     */
    public function create_item_permissions_check($request)
    {
        if (!$this->check_is_taxonomy_allowed($this->taxonomy)) {
            return false;
        }
        $taxonomy_obj = get_taxonomy($this->taxonomy);
        if (is_taxonomy_hierarchical($this->taxonomy) && !current_user_can($taxonomy_obj->cap->edit_terms) || !is_taxonomy_hierarchical($this->taxonomy) && !current_user_can($taxonomy_obj->cap->assign_terms)) {
            return new WP_Error('rest_cannot_create', __('Sorry, you are not allowed to create terms in this taxonomy.'), array('status' => rest_authorization_required_code()));
        }
        return true;
    }
    /**
     * Creates a single term in a taxonomy.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function create_item($request)
    {
        if (isset($request['parent'])) {
            if (!is_taxonomy_hierarchical($this->taxonomy)) {
                return new WP_Error('rest_taxonomy_not_hierarchical', __('Cannot set parent term, taxonomy is not hierarchical.'), array('status' => 400));
            }
            $parent = get_term((int) $request['parent'], $this->taxonomy);
            if (!$parent) {
                return new WP_Error('rest_term_invalid', __('Parent term does not exist.'), array('status' => 400));
            }
        }
        $prepared_term = $this->prepare_item_for_database($request);
        $term = wp_insert_term(wp_slash($prepared_term->name), $this->taxonomy, wp_slash((array) $prepared_term));
        if (is_wp_error($term)) {
            /*
             * If we're going to inform the client that the term already exists,
             * give them the identifier for future use.
             */
            $term_id = $term->get_error_data('term_exists');
            if ($term_id) {
                $existing_term = get_term($term_id, $this->taxonomy);
                $term->add_data($existing_term->term_id, 'term_exists');
                $term->add_data(array('status' => 400, 'term_id' => $term_id));
            }
            return $term;
        }
        $term = get_term($term['term_id'], $this->taxonomy);
        /**
         * Fires after a single term is created or updated via the REST API.
         *
         * The dynamic portion of the hook name, `$this->taxonomy`, refers to the taxonomy slug.
         *
         * Possible hook names include:
         *
         *  - `rest_insert_category`
         *  - `rest_insert_post_tag`
         *
         * @since 4.7.0
         *
         * @param WP_Term         $term     Inserted or updated term object.
         * @param WP_REST_Request $request  Request object.
         * @param bool            $creating True when creating a term, false when updating.
         */
        do_action("rest_insert_{$this->taxonomy}", $term, $request, true);
        $schema = $this->get_item_schema();
        if (!empty($schema['properties']['meta']) && isset($request['meta'])) {
            $meta_update = $this->meta->update_value($request['meta'], $term->term_id);
            if (is_wp_error($meta_update)) {
                return $meta_update;
            }
        }
        $fields_update = $this->update_additional_fields_for_object($term, $request);
        if (is_wp_error($fields_update)) {
            return $fields_update;
        }
        $request->set_param('context', 'edit');
        /**
         * Fires after a single term is completely created or updated via the REST API.
         *
         * The dynamic portion of the hook name, `$this->taxonomy`, refers to the taxonomy slug.
         *
         * Possible hook names include:
         *
         *  - `rest_after_insert_category`
         *  - `rest_after_insert_post_tag`
         *
         * @since 5.0.0
         *
         * @param WP_Term         $term     Inserted or updated term object.
         * @param WP_REST_Request $request  Request object.
         * @param bool            $creating True when creating a term, false when updating.
         */
        do_action("rest_after_insert_{$this->taxonomy}", $term, $request, true);
        $response = $this->prepare_item_for_response($term, $request);
        $response = rest_ensure_response($response);
        $response->set_status(201);
        $response->header('Location', rest_url($this->namespace . '/' . $this->rest_base . '/' . $term->term_id));
        return $response;
    }
    /**
     * Checks if a request has access to update the specified term.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True if the request has access to update the item, false or WP_Error object otherwise.
     */
    public function update_item_permissions_check($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("update_item_permissions_check") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-terms-controller.php at line 383")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called update_item_permissions_check:383@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-terms-controller.php');
        die();
    }
    /**
     * Updates a single term from a taxonomy.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function update_item($request)
    {
        $term = $this->get_term($request['id']);
        if (is_wp_error($term)) {
            return $term;
        }
        if (isset($request['parent'])) {
            if (!is_taxonomy_hierarchical($this->taxonomy)) {
                return new WP_Error('rest_taxonomy_not_hierarchical', __('Cannot set parent term, taxonomy is not hierarchical.'), array('status' => 400));
            }
            $parent = get_term((int) $request['parent'], $this->taxonomy);
            if (!$parent) {
                return new WP_Error('rest_term_invalid', __('Parent term does not exist.'), array('status' => 400));
            }
        }
        $prepared_term = $this->prepare_item_for_database($request);
        // Only update the term if we have something to update.
        if (!empty($prepared_term)) {
            $update = wp_update_term($term->term_id, $term->taxonomy, wp_slash((array) $prepared_term));
            if (is_wp_error($update)) {
                return $update;
            }
        }
        $term = get_term($term->term_id, $this->taxonomy);
        /** This action is documented in wp-includes/rest-api/endpoints/class-wp-rest-terms-controller.php */
        do_action("rest_insert_{$this->taxonomy}", $term, $request, false);
        $schema = $this->get_item_schema();
        if (!empty($schema['properties']['meta']) && isset($request['meta'])) {
            $meta_update = $this->meta->update_value($request['meta'], $term->term_id);
            if (is_wp_error($meta_update)) {
                return $meta_update;
            }
        }
        $fields_update = $this->update_additional_fields_for_object($term, $request);
        if (is_wp_error($fields_update)) {
            return $fields_update;
        }
        $request->set_param('context', 'edit');
        /** This action is documented in wp-includes/rest-api/endpoints/class-wp-rest-terms-controller.php */
        do_action("rest_after_insert_{$this->taxonomy}", $term, $request, false);
        $response = $this->prepare_item_for_response($term, $request);
        return rest_ensure_response($response);
    }
    /**
     * Checks if a request has access to delete the specified term.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True if the request has access to delete the item, otherwise false or WP_Error object.
     */
    public function delete_item_permissions_check($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("delete_item_permissions_check") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-terms-controller.php at line 453")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called delete_item_permissions_check:453@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-terms-controller.php');
        die();
    }
    /**
     * Deletes a single term from a taxonomy.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function delete_item($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("delete_item") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-terms-controller.php at line 472")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called delete_item:472@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-terms-controller.php');
        die();
    }
    /**
     * Prepares a single term for create or update.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Request object.
     * @return object Term object.
     */
    public function prepare_item_for_database($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("prepare_item_for_database") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-terms-controller.php at line 523")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called prepare_item_for_database:523@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-terms-controller.php');
        die();
    }
    /**
     * Prepares a single term output for response.
     *
     * @since 4.7.0
     *
     * @param WP_Term         $item    Term object.
     * @param WP_REST_Request $request Request object.
     * @return WP_REST_Response Response object.
     */
    public function prepare_item_for_response($item, $request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("prepare_item_for_response") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-terms-controller.php at line 576")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called prepare_item_for_response:576@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-terms-controller.php');
        die();
    }
    /**
     * Prepares links for the request.
     *
     * @since 4.7.0
     *
     * @param WP_Term $term Term object.
     * @return array Links for the given term.
     */
    protected function prepare_links($term)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("prepare_links") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-terms-controller.php at line 640")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called prepare_links:640@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-terms-controller.php');
        die();
    }
    /**
     * Retrieves the term's schema, conforming to JSON Schema.
     *
     * @since 4.7.0
     *
     * @return array Item schema data.
     */
    public function get_item_schema()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_item_schema") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-terms-controller.php at line 675")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_item_schema:675@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-terms-controller.php');
        die();
    }
    /**
     * Retrieves the query params for collections.
     *
     * @since 4.7.0
     *
     * @return array Collection parameters.
     */
    public function get_collection_params()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_collection_params") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-terms-controller.php at line 696")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_collection_params:696@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-terms-controller.php');
        die();
    }
    /**
     * Checks that the taxonomy is valid.
     *
     * @since 4.7.0
     *
     * @param string $taxonomy Taxonomy to check.
     * @return bool Whether the taxonomy is allowed for REST management.
     */
    protected function check_is_taxonomy_allowed($taxonomy)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("check_is_taxonomy_allowed") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-terms-controller.php at line 739")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called check_is_taxonomy_allowed:739@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-terms-controller.php');
        die();
    }
}