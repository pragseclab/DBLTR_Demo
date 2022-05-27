<?php

/**
 * XML-RPC protocol support for WordPress
 *
 * @package WordPress
 * @subpackage Publishing
 */
/**
 * WordPress XMLRPC server implementation.
 *
 * Implements compatibility for Blogger API, MetaWeblog API, MovableType, and
 * pingback. Additional WordPress API for managing comments, pages, posts,
 * options, etc.
 *
 * As of WordPress 3.5.0, XML-RPC is enabled by default. It can be disabled
 * via the {@see 'xmlrpc_enabled'} filter found in wp_xmlrpc_server::login().
 *
 * @since 1.5.0
 *
 * @see IXR_Server
 */
class wp_xmlrpc_server extends IXR_Server
{
    /**
     * Methods.
     *
     * @var array
     */
    public $methods;
    /**
     * Blog options.
     *
     * @var array
     */
    public $blog_options;
    /**
     * IXR_Error instance.
     *
     * @var IXR_Error
     */
    public $error;
    /**
     * Flags that the user authentication has failed in this instance of wp_xmlrpc_server.
     *
     * @var bool
     */
    protected $auth_failed = false;
    /**
     * Registers all of the XMLRPC methods that XMLRPC server understands.
     *
     * Sets up server and method property. Passes XMLRPC
     * methods through the {@see 'xmlrpc_methods'} filter to allow plugins to extend
     * or replace XML-RPC methods.
     *
     * @since 1.5.0
     */
    public function __construct()
    {
        $this->methods = array(
            // WordPress API.
            'wp.getUsersBlogs' => 'this:wp_getUsersBlogs',
            'wp.newPost' => 'this:wp_newPost',
            'wp.editPost' => 'this:wp_editPost',
            'wp.deletePost' => 'this:wp_deletePost',
            'wp.getPost' => 'this:wp_getPost',
            'wp.getPosts' => 'this:wp_getPosts',
            'wp.newTerm' => 'this:wp_newTerm',
            'wp.editTerm' => 'this:wp_editTerm',
            'wp.deleteTerm' => 'this:wp_deleteTerm',
            'wp.getTerm' => 'this:wp_getTerm',
            'wp.getTerms' => 'this:wp_getTerms',
            'wp.getTaxonomy' => 'this:wp_getTaxonomy',
            'wp.getTaxonomies' => 'this:wp_getTaxonomies',
            'wp.getUser' => 'this:wp_getUser',
            'wp.getUsers' => 'this:wp_getUsers',
            'wp.getProfile' => 'this:wp_getProfile',
            'wp.editProfile' => 'this:wp_editProfile',
            'wp.getPage' => 'this:wp_getPage',
            'wp.getPages' => 'this:wp_getPages',
            'wp.newPage' => 'this:wp_newPage',
            'wp.deletePage' => 'this:wp_deletePage',
            'wp.editPage' => 'this:wp_editPage',
            'wp.getPageList' => 'this:wp_getPageList',
            'wp.getAuthors' => 'this:wp_getAuthors',
            'wp.getCategories' => 'this:mw_getCategories',
            // Alias.
            'wp.getTags' => 'this:wp_getTags',
            'wp.newCategory' => 'this:wp_newCategory',
            'wp.deleteCategory' => 'this:wp_deleteCategory',
            'wp.suggestCategories' => 'this:wp_suggestCategories',
            'wp.uploadFile' => 'this:mw_newMediaObject',
            // Alias.
            'wp.deleteFile' => 'this:wp_deletePost',
            // Alias.
            'wp.getCommentCount' => 'this:wp_getCommentCount',
            'wp.getPostStatusList' => 'this:wp_getPostStatusList',
            'wp.getPageStatusList' => 'this:wp_getPageStatusList',
            'wp.getPageTemplates' => 'this:wp_getPageTemplates',
            'wp.getOptions' => 'this:wp_getOptions',
            'wp.setOptions' => 'this:wp_setOptions',
            'wp.getComment' => 'this:wp_getComment',
            'wp.getComments' => 'this:wp_getComments',
            'wp.deleteComment' => 'this:wp_deleteComment',
            'wp.editComment' => 'this:wp_editComment',
            'wp.newComment' => 'this:wp_newComment',
            'wp.getCommentStatusList' => 'this:wp_getCommentStatusList',
            'wp.getMediaItem' => 'this:wp_getMediaItem',
            'wp.getMediaLibrary' => 'this:wp_getMediaLibrary',
            'wp.getPostFormats' => 'this:wp_getPostFormats',
            'wp.getPostType' => 'this:wp_getPostType',
            'wp.getPostTypes' => 'this:wp_getPostTypes',
            'wp.getRevisions' => 'this:wp_getRevisions',
            'wp.restoreRevision' => 'this:wp_restoreRevision',
            // Blogger API.
            'blogger.getUsersBlogs' => 'this:blogger_getUsersBlogs',
            'blogger.getUserInfo' => 'this:blogger_getUserInfo',
            'blogger.getPost' => 'this:blogger_getPost',
            'blogger.getRecentPosts' => 'this:blogger_getRecentPosts',
            'blogger.newPost' => 'this:blogger_newPost',
            'blogger.editPost' => 'this:blogger_editPost',
            'blogger.deletePost' => 'this:blogger_deletePost',
            // MetaWeblog API (with MT extensions to structs).
            'metaWeblog.newPost' => 'this:mw_newPost',
            'metaWeblog.editPost' => 'this:mw_editPost',
            'metaWeblog.getPost' => 'this:mw_getPost',
            'metaWeblog.getRecentPosts' => 'this:mw_getRecentPosts',
            'metaWeblog.getCategories' => 'this:mw_getCategories',
            'metaWeblog.newMediaObject' => 'this:mw_newMediaObject',
            // MetaWeblog API aliases for Blogger API.
            // See http://www.xmlrpc.com/stories/storyReader$2460
            'metaWeblog.deletePost' => 'this:blogger_deletePost',
            'metaWeblog.getUsersBlogs' => 'this:blogger_getUsersBlogs',
            // MovableType API.
            'mt.getCategoryList' => 'this:mt_getCategoryList',
            'mt.getRecentPostTitles' => 'this:mt_getRecentPostTitles',
            'mt.getPostCategories' => 'this:mt_getPostCategories',
            'mt.setPostCategories' => 'this:mt_setPostCategories',
            'mt.supportedMethods' => 'this:mt_supportedMethods',
            'mt.supportedTextFilters' => 'this:mt_supportedTextFilters',
            'mt.getTrackbackPings' => 'this:mt_getTrackbackPings',
            'mt.publishPost' => 'this:mt_publishPost',
            // Pingback.
            'pingback.ping' => 'this:pingback_ping',
            'pingback.extensions.getPingbacks' => 'this:pingback_extensions_getPingbacks',
            'demo.sayHello' => 'this:sayHello',
            'demo.addTwoNumbers' => 'this:addTwoNumbers',
        );
        $this->initialise_blog_option_info();
        /**
         * Filters the methods exposed by the XML-RPC server.
         *
         * This filter can be used to add new methods, and remove built-in methods.
         *
         * @since 1.5.0
         *
         * @param string[] $methods An array of XML-RPC methods, keyed by their methodName.
         */
        $this->methods = apply_filters('xmlrpc_methods', $this->methods);
    }
    /**
     * Make private/protected methods readable for backward compatibility.
     *
     * @since 4.0.0
     *
     * @param string $name      Method to call.
     * @param array  $arguments Arguments to pass when calling.
     * @return array|IXR_Error|false Return value of the callback, false otherwise.
     */
    public function __call($name, $arguments)
    {
        if ('_multisite_getUsersBlogs' === $name) {
            return $this->_multisite_getUsersBlogs(...$arguments);
        }
        return false;
    }
    /**
     * Serves the XML-RPC request.
     *
     * @since 2.9.0
     */
    public function serve_request()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("serve_request") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 184")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called serve_request:184@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Test XMLRPC API by saying, "Hello!" to client.
     *
     * @since 1.5.0
     *
     * @return string Hello string response.
     */
    public function sayHello()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("sayHello") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 195")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called sayHello:195@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Test XMLRPC API by adding two numbers for client.
     *
     * @since 1.5.0
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int $number1 A number to add.
     *     @type int $number2 A second number to add.
     * }
     * @return int Sum of the two given numbers.
     */
    public function addTwoNumbers($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("addTwoNumbers") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 212")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called addTwoNumbers:212@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Log user in.
     *
     * @since 2.8.0
     *
     * @param string $username User's username.
     * @param string $password User's password.
     * @return WP_User|false WP_User object if authentication passed, false otherwise
     */
    public function login($username, $password)
    {
        /*
         * Respect old get_option() filters left for back-compat when the 'enable_xmlrpc'
         * option was deprecated in 3.5.0. Use the 'xmlrpc_enabled' hook instead.
         */
        $enabled = apply_filters('pre_option_enable_xmlrpc', false);
        if (false === $enabled) {
            $enabled = apply_filters('option_enable_xmlrpc', true);
        }
        /**
         * Filters whether XML-RPC methods requiring authentication are enabled.
         *
         * Contrary to the way it's named, this filter does not control whether XML-RPC is *fully*
         * enabled, rather, it only controls whether XML-RPC methods requiring authentication - such
         * as for publishing purposes - are enabled.
         *
         * Further, the filter does not control whether pingbacks or other custom endpoints that don't
         * require authentication are enabled. This behavior is expected, and due to how parity was matched
         * with the `enable_xmlrpc` UI option the filter replaced when it was introduced in 3.5.
         *
         * To disable XML-RPC methods that require authentication, use:
         *
         *     add_filter( 'xmlrpc_enabled', '__return_false' );
         *
         * For more granular control over all XML-RPC methods and requests, see the {@see 'xmlrpc_methods'}
         * and {@see 'xmlrpc_element_limit'} hooks.
         *
         * @since 3.5.0
         *
         * @param bool $enabled Whether XML-RPC is enabled. Default true.
         */
        $enabled = apply_filters('xmlrpc_enabled', $enabled);
        if (!$enabled) {
            $this->error = new IXR_Error(405, sprintf(__('XML-RPC services are disabled on this site.')));
            return false;
        }
        if ($this->auth_failed) {
            $user = new WP_Error('login_prevented');
        } else {
            $user = wp_authenticate($username, $password);
        }
        if (is_wp_error($user)) {
            $this->error = new IXR_Error(403, __('Incorrect username or password.'));
            // Flag that authentication has failed once on this wp_xmlrpc_server instance.
            $this->auth_failed = true;
            /**
             * Filters the XML-RPC user login error message.
             *
             * @since 3.5.0
             *
             * @param IXR_Error $error The XML-RPC error message.
             * @param WP_Error  $user  WP_Error object.
             */
            $this->error = apply_filters('xmlrpc_login_error', $this->error, $user);
            return false;
        }
        wp_set_current_user($user->ID);
        return $user;
    }
    /**
     * Check user's credentials. Deprecated.
     *
     * @since 1.5.0
     * @deprecated 2.8.0 Use wp_xmlrpc_server::login()
     * @see wp_xmlrpc_server::login()
     *
     * @param string $username User's username.
     * @param string $password User's password.
     * @return bool Whether authentication passed.
     */
    public function login_pass_ok($username, $password)
    {
        return (bool) $this->login($username, $password);
    }
    /**
     * Escape string or array of strings for database.
     *
     * @since 1.5.2
     *
     * @param string|array $data Escape single string or array of strings.
     * @return string|void Returns with string is passed, alters by-reference
     *                     when array is passed.
     */
    public function escape(&$data)
    {
        if (!is_array($data)) {
            return wp_slash($data);
        }
        foreach ($data as &$v) {
            if (is_array($v)) {
                $this->escape($v);
            } elseif (!is_object($v)) {
                $v = wp_slash($v);
            }
        }
    }
    /**
     * Retrieve custom fields for post.
     *
     * @since 2.5.0
     *
     * @param int $post_id Post ID.
     * @return array Custom fields, if exist.
     */
    public function get_custom_fields($post_id)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_custom_fields") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 332")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_custom_fields:332@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Set custom fields for post.
     *
     * @since 2.5.0
     *
     * @param int   $post_id Post ID.
     * @param array $fields  Custom fields.
     */
    public function set_custom_fields($post_id, $fields)
    {
        $post_id = (int) $post_id;
        foreach ((array) $fields as $meta) {
            if (isset($meta['id'])) {
                $meta['id'] = (int) $meta['id'];
                $pmeta = get_metadata_by_mid('post', $meta['id']);
                if (!$pmeta || $pmeta->post_id != $post_id) {
                    continue;
                }
                if (isset($meta['key'])) {
                    $meta['key'] = wp_unslash($meta['key']);
                    if ($meta['key'] !== $pmeta->meta_key) {
                        continue;
                    }
                    $meta['value'] = wp_unslash($meta['value']);
                    if (current_user_can('edit_post_meta', $post_id, $meta['key'])) {
                        update_metadata_by_mid('post', $meta['id'], $meta['value']);
                    }
                } elseif (current_user_can('delete_post_meta', $post_id, $pmeta->meta_key)) {
                    delete_metadata_by_mid('post', $meta['id']);
                }
            } elseif (current_user_can('add_post_meta', $post_id, wp_unslash($meta['key']))) {
                add_post_meta($post_id, $meta['key'], $meta['value']);
            }
        }
    }
    /**
     * Retrieve custom fields for a term.
     *
     * @since 4.9.0
     *
     * @param int $term_id Term ID.
     * @return array Array of custom fields, if they exist.
     */
    public function get_term_custom_fields($term_id)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_term_custom_fields") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 388")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_term_custom_fields:388@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Set custom fields for a term.
     *
     * @since 4.9.0
     *
     * @param int   $term_id Term ID.
     * @param array $fields  Custom fields.
     */
    public function set_term_custom_fields($term_id, $fields)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("set_term_custom_fields") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 408")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called set_term_custom_fields:408@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Set up blog options property.
     *
     * Passes property through {@see 'xmlrpc_blog_options'} filter.
     *
     * @since 2.6.0
     */
    public function initialise_blog_option_info()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("initialise_blog_option_info") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 439")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called initialise_blog_option_info:439@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Retrieve the blogs of the user.
     *
     * @since 2.6.0
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type string $username Username.
     *     @type string $password Password.
     * }
     * @return array|IXR_Error Array contains:
     *  - 'isAdmin'
     *  - 'isPrimary' - whether the blog is the user's primary blog
     *  - 'url'
     *  - 'blogid'
     *  - 'blogName'
     *  - 'xmlrpc' - url of xmlrpc endpoint
     */
    public function wp_getUsersBlogs($args)
    {
        if (!$this->minimum_args($args, 2)) {
            return $this->error;
        }
        // If this isn't on WPMU then just use blogger_getUsersBlogs().
        if (!is_multisite()) {
            array_unshift($args, 1);
            return $this->blogger_getUsersBlogs($args);
        }
        $this->escape($args);
        $username = $args[0];
        $password = $args[1];
        $user = $this->login($username, $password);
        if (!$user) {
            return $this->error;
        }
        /**
         * Fires after the XML-RPC user has been authenticated but before the rest of
         * the method logic begins.
         *
         * All built-in XML-RPC methods use the action xmlrpc_call, with a parameter
         * equal to the method's name, e.g., wp.getUsersBlogs, wp.newPost, etc.
         *
         * @since 2.5.0
         * @since 5.7.0 Added the `$args` and `$server` parameters.
         *
         * @param string           $name   The method name.
         * @param array|string     $args   The escaped arguments passed to the method.
         * @param wp_xmlrpc_server $server The XML-RPC server instance.
         */
        do_action('xmlrpc_call', 'wp.getUsersBlogs', $args, $this);
        $blogs = (array) get_blogs_of_user($user->ID);
        $struct = array();
        $primary_blog_id = 0;
        $active_blog = get_active_blog_for_user($user->ID);
        if ($active_blog) {
            $primary_blog_id = (int) $active_blog->blog_id;
        }
        foreach ($blogs as $blog) {
            // Don't include blogs that aren't hosted at this site.
            if (get_current_network_id() != $blog->site_id) {
                continue;
            }
            $blog_id = $blog->userblog_id;
            switch_to_blog($blog_id);
            $is_admin = current_user_can('manage_options');
            $is_primary = (int) $blog_id === $primary_blog_id;
            $struct[] = array('isAdmin' => $is_admin, 'isPrimary' => $is_primary, 'url' => home_url('/'), 'blogid' => (string) $blog_id, 'blogName' => get_option('blogname'), 'xmlrpc' => site_url('xmlrpc.php', 'rpc'));
            restore_current_blog();
        }
        return $struct;
    }
    /**
     * Checks if the method received at least the minimum number of arguments.
     *
     * @since 3.4.0
     *
     * @param array $args  An array of arguments to check.
     * @param int   $count Minimum number of arguments.
     * @return bool True if `$args` contains at least `$count` arguments, false otherwise.
     */
    protected function minimum_args($args, $count)
    {
        if (!is_array($args) || count($args) < $count) {
            $this->error = new IXR_Error(400, __('Insufficient arguments passed to this XML-RPC method.'));
            return false;
        }
        return true;
    }
    /**
     * Prepares taxonomy data for return in an XML-RPC object.
     *
     * @param WP_Taxonomy $taxonomy The unprepared taxonomy data.
     * @param array       $fields   The subset of taxonomy fields to return.
     * @return array The prepared taxonomy data.
     */
    protected function _prepare_taxonomy($taxonomy, $fields)
    {
        $_taxonomy = array('name' => $taxonomy->name, 'label' => $taxonomy->label, 'hierarchical' => (bool) $taxonomy->hierarchical, 'public' => (bool) $taxonomy->public, 'show_ui' => (bool) $taxonomy->show_ui, '_builtin' => (bool) $taxonomy->_builtin);
        if (in_array('labels', $fields, true)) {
            $_taxonomy['labels'] = (array) $taxonomy->labels;
        }
        if (in_array('cap', $fields, true)) {
            $_taxonomy['cap'] = (array) $taxonomy->cap;
        }
        if (in_array('menu', $fields, true)) {
            $_taxonomy['show_in_menu'] = (bool) $taxonomy->show_in_menu;
        }
        if (in_array('object_type', $fields, true)) {
            $_taxonomy['object_type'] = array_unique((array) $taxonomy->object_type);
        }
        /**
         * Filters XML-RPC-prepared data for the given taxonomy.
         *
         * @since 3.4.0
         *
         * @param array       $_taxonomy An array of taxonomy data.
         * @param WP_Taxonomy $taxonomy  Taxonomy object.
         * @param array       $fields    The subset of taxonomy fields to return.
         */
        return apply_filters('xmlrpc_prepare_taxonomy', $_taxonomy, $taxonomy, $fields);
    }
    /**
     * Prepares term data for return in an XML-RPC object.
     *
     * @param array|object $term The unprepared term data.
     * @return array The prepared term data.
     */
    protected function _prepare_term($term)
    {
        $_term = $term;
        if (!is_array($_term)) {
            $_term = get_object_vars($_term);
        }
        // For integers which may be larger than XML-RPC supports ensure we return strings.
        $_term['term_id'] = (string) $_term['term_id'];
        $_term['term_group'] = (string) $_term['term_group'];
        $_term['term_taxonomy_id'] = (string) $_term['term_taxonomy_id'];
        $_term['parent'] = (string) $_term['parent'];
        // Count we are happy to return as an integer because people really shouldn't use terms that much.
        $_term['count'] = (int) $_term['count'];
        // Get term meta.
        $_term['custom_fields'] = $this->get_term_custom_fields($_term['term_id']);
        /**
         * Filters XML-RPC-prepared data for the given term.
         *
         * @since 3.4.0
         *
         * @param array        $_term An array of term data.
         * @param array|object $term  Term object or array.
         */
        return apply_filters('xmlrpc_prepare_term', $_term, $term);
    }
    /**
     * Convert a WordPress date string to an IXR_Date object.
     *
     * @param string $date Date string to convert.
     * @return IXR_Date IXR_Date object.
     */
    protected function _convert_date($date)
    {
        if ('0000-00-00 00:00:00' === $date) {
            return new IXR_Date('00000000T00:00:00Z');
        }
        return new IXR_Date(mysql2date('Ymd\\TH:i:s', $date, false));
    }
    /**
     * Convert a WordPress GMT date string to an IXR_Date object.
     *
     * @param string $date_gmt WordPress GMT date string.
     * @param string $date     Date string.
     * @return IXR_Date IXR_Date object.
     */
    protected function _convert_date_gmt($date_gmt, $date)
    {
        if ('0000-00-00 00:00:00' !== $date && '0000-00-00 00:00:00' === $date_gmt) {
            return new IXR_Date(get_gmt_from_date(mysql2date('Y-m-d H:i:s', $date, false), 'Ymd\\TH:i:s'));
        }
        return $this->_convert_date($date_gmt);
    }
    /**
     * Prepares post data for return in an XML-RPC object.
     *
     * @param array $post   The unprepared post data.
     * @param array $fields The subset of post type fields to return.
     * @return array The prepared post data.
     */
    protected function _prepare_post($post, $fields)
    {
        // Holds the data for this post. built up based on $fields.
        $_post = array('post_id' => (string) $post['ID']);
        // Prepare common post fields.
        $post_fields = array('post_title' => $post['post_title'], 'post_date' => $this->_convert_date($post['post_date']), 'post_date_gmt' => $this->_convert_date_gmt($post['post_date_gmt'], $post['post_date']), 'post_modified' => $this->_convert_date($post['post_modified']), 'post_modified_gmt' => $this->_convert_date_gmt($post['post_modified_gmt'], $post['post_modified']), 'post_status' => $post['post_status'], 'post_type' => $post['post_type'], 'post_name' => $post['post_name'], 'post_author' => $post['post_author'], 'post_password' => $post['post_password'], 'post_excerpt' => $post['post_excerpt'], 'post_content' => $post['post_content'], 'post_parent' => (string) $post['post_parent'], 'post_mime_type' => $post['post_mime_type'], 'link' => get_permalink($post['ID']), 'guid' => $post['guid'], 'menu_order' => (int) $post['menu_order'], 'comment_status' => $post['comment_status'], 'ping_status' => $post['ping_status'], 'sticky' => 'post' === $post['post_type'] && is_sticky($post['ID']));
        // Thumbnail.
        $post_fields['post_thumbnail'] = array();
        $thumbnail_id = get_post_thumbnail_id($post['ID']);
        if ($thumbnail_id) {
            $thumbnail_size = current_theme_supports('post-thumbnail') ? 'post-thumbnail' : 'thumbnail';
            $post_fields['post_thumbnail'] = $this->_prepare_media_item(get_post($thumbnail_id), $thumbnail_size);
        }
        // Consider future posts as published.
        if ('future' === $post_fields['post_status']) {
            $post_fields['post_status'] = 'publish';
        }
        // Fill in blank post format.
        $post_fields['post_format'] = get_post_format($post['ID']);
        if (empty($post_fields['post_format'])) {
            $post_fields['post_format'] = 'standard';
        }
        // Merge requested $post_fields fields into $_post.
        if (in_array('post', $fields, true)) {
            $_post = array_merge($_post, $post_fields);
        } else {
            $requested_fields = array_intersect_key($post_fields, array_flip($fields));
            $_post = array_merge($_post, $requested_fields);
        }
        $all_taxonomy_fields = in_array('taxonomies', $fields, true);
        if ($all_taxonomy_fields || in_array('terms', $fields, true)) {
            $post_type_taxonomies = get_object_taxonomies($post['post_type'], 'names');
            $terms = wp_get_object_terms($post['ID'], $post_type_taxonomies);
            $_post['terms'] = array();
            foreach ($terms as $term) {
                $_post['terms'][] = $this->_prepare_term($term);
            }
        }
        if (in_array('custom_fields', $fields, true)) {
            $_post['custom_fields'] = $this->get_custom_fields($post['ID']);
        }
        if (in_array('enclosure', $fields, true)) {
            $_post['enclosure'] = array();
            $enclosures = (array) get_post_meta($post['ID'], 'enclosure');
            if (!empty($enclosures)) {
                $encdata = explode("\n", $enclosures[0]);
                $_post['enclosure']['url'] = trim(htmlspecialchars($encdata[0]));
                $_post['enclosure']['length'] = (int) trim($encdata[1]);
                $_post['enclosure']['type'] = trim($encdata[2]);
            }
        }
        /**
         * Filters XML-RPC-prepared date for the given post.
         *
         * @since 3.4.0
         *
         * @param array $_post  An array of modified post data.
         * @param array $post   An array of post data.
         * @param array $fields An array of post fields.
         */
        return apply_filters('xmlrpc_prepare_post', $_post, $post, $fields);
    }
    /**
     * Prepares post data for return in an XML-RPC object.
     *
     * @since 3.4.0
     * @since 4.6.0 Converted the `$post_type` parameter to accept a WP_Post_Type object.
     *
     * @param WP_Post_Type $post_type Post type object.
     * @param array        $fields    The subset of post fields to return.
     * @return array The prepared post type data.
     */
    protected function _prepare_post_type($post_type, $fields)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_prepare_post_type") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 742")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called _prepare_post_type:742@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Prepares media item data for return in an XML-RPC object.
     *
     * @param WP_Post $media_item     The unprepared media item data.
     * @param string  $thumbnail_size The image size to use for the thumbnail URL.
     * @return array The prepared media item data.
     */
    protected function _prepare_media_item($media_item, $thumbnail_size = 'thumbnail')
    {
        $_media_item = array('attachment_id' => (string) $media_item->ID, 'date_created_gmt' => $this->_convert_date_gmt($media_item->post_date_gmt, $media_item->post_date), 'parent' => $media_item->post_parent, 'link' => wp_get_attachment_url($media_item->ID), 'title' => $media_item->post_title, 'caption' => $media_item->post_excerpt, 'description' => $media_item->post_content, 'metadata' => wp_get_attachment_metadata($media_item->ID), 'type' => $media_item->post_mime_type);
        $thumbnail_src = image_downsize($media_item->ID, $thumbnail_size);
        if ($thumbnail_src) {
            $_media_item['thumbnail'] = $thumbnail_src[0];
        } else {
            $_media_item['thumbnail'] = $_media_item['link'];
        }
        /**
         * Filters XML-RPC-prepared data for the given media item.
         *
         * @since 3.4.0
         *
         * @param array   $_media_item    An array of media item data.
         * @param WP_Post $media_item     Media item object.
         * @param string  $thumbnail_size Image size.
         */
        return apply_filters('xmlrpc_prepare_media_item', $_media_item, $media_item, $thumbnail_size);
    }
    /**
     * Prepares page data for return in an XML-RPC object.
     *
     * @param WP_Post $page The unprepared page data.
     * @return array The prepared page data.
     */
    protected function _prepare_page($page)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_prepare_page") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 805")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called _prepare_page:805@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Prepares comment data for return in an XML-RPC object.
     *
     * @param WP_Comment $comment The unprepared comment data.
     * @return array The prepared comment data.
     */
    protected function _prepare_comment($comment)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_prepare_comment") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 852")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called _prepare_comment:852@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Prepares user data for return in an XML-RPC object.
     *
     * @param WP_User $user   The unprepared user object.
     * @param array   $fields The subset of user fields to return.
     * @return array The prepared user data.
     */
    protected function _prepare_user($user, $fields)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_prepare_user") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 882")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called _prepare_user:882@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Create a new post for any registered post type.
     *
     * @since 3.4.0
     *
     * @link https://en.wikipedia.org/wiki/RSS_enclosure for information on RSS enclosures.
     *
     * @param array $args {
     *     Method arguments. Note: top-level arguments must be ordered as documented.
     *
     *     @type int    $blog_id        Blog ID (unused).
     *     @type string $username       Username.
     *     @type string $password       Password.
     *     @type array  $content_struct {
     *         Content struct for adding a new post. See wp_insert_post() for information on
     *         additional post fields
     *
     *         @type string $post_type      Post type. Default 'post'.
     *         @type string $post_status    Post status. Default 'draft'
     *         @type string $post_title     Post title.
     *         @type int    $post_author    Post author ID.
     *         @type string $post_excerpt   Post excerpt.
     *         @type string $post_content   Post content.
     *         @type string $post_date_gmt  Post date in GMT.
     *         @type string $post_date      Post date.
     *         @type string $post_password  Post password (20-character limit).
     *         @type string $comment_status Post comment enabled status. Accepts 'open' or 'closed'.
     *         @type string $ping_status    Post ping status. Accepts 'open' or 'closed'.
     *         @type bool   $sticky         Whether the post should be sticky. Automatically false if
     *                                      `$post_status` is 'private'.
     *         @type int    $post_thumbnail ID of an image to use as the post thumbnail/featured image.
     *         @type array  $custom_fields  Array of meta key/value pairs to add to the post.
     *         @type array  $terms          Associative array with taxonomy names as keys and arrays
     *                                      of term IDs as values.
     *         @type array  $terms_names    Associative array with taxonomy names as keys and arrays
     *                                      of term names as values.
     *         @type array  $enclosure      {
     *             Array of feed enclosure data to add to post meta.
     *
     *             @type string $url    URL for the feed enclosure.
     *             @type int    $length Size in bytes of the enclosure.
     *             @type string $type   Mime-type for the enclosure.
     *         }
     *     }
     * }
     * @return int|IXR_Error Post ID on success, IXR_Error instance otherwise.
     */
    public function wp_newPost($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_newPost") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 954")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_newPost:954@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Helper method for filtering out elements from an array.
     *
     * @since 3.4.0
     *
     * @param int $count Number to compare to one.
     * @return bool True if the number is greater than one, false otherwise.
     */
    private function _is_greater_than_one($count)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_is_greater_than_one") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 995")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called _is_greater_than_one:995@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Encapsulate the logic for sticking a post
     * and determining if the user has permission to do so
     *
     * @since 4.3.0
     *
     * @param array $post_data
     * @param bool  $update
     * @return void|IXR_Error
     */
    private function _toggle_sticky($post_data, $update = false)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_toggle_sticky") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 1009")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called _toggle_sticky:1009@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Helper method for wp_newPost() and wp_editPost(), containing shared logic.
     *
     * @since 3.4.0
     *
     * @see wp_insert_post()
     *
     * @param WP_User         $user           The post author if post_author isn't set in $content_struct.
     * @param array|IXR_Error $content_struct Post data to insert.
     * @return IXR_Error|string
     */
    protected function _insert_post($user, $content_struct)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_insert_post") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 1044")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called _insert_post:1044@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Edit a post for any registered post type.
     *
     * The $content_struct parameter only needs to contain fields that
     * should be changed. All other fields will retain their existing values.
     *
     * @since 3.4.0
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id        Blog ID (unused).
     *     @type string $username       Username.
     *     @type string $password       Password.
     *     @type int    $post_id        Post ID.
     *     @type array  $content_struct Extra content arguments.
     * }
     * @return true|IXR_Error True on success, IXR_Error on failure.
     */
    public function wp_editPost($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_editPost") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 1275")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_editPost:1275@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Delete a post for any registered post type.
     *
     * @since 3.4.0
     *
     * @see wp_delete_post()
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id  Blog ID (unused).
     *     @type string $username Username.
     *     @type string $password Password.
     *     @type int    $post_id  Post ID.
     * }
     * @return true|IXR_Error True on success, IXR_Error instance on failure.
     */
    public function wp_deletePost($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_deletePost") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 1346")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_deletePost:1346@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Retrieve a post.
     *
     * @since 3.4.0
     *
     * The optional $fields parameter specifies what fields will be included
     * in the response array. This should be a list of field names. 'post_id' will
     * always be included in the response regardless of the value of $fields.
     *
     * Instead of, or in addition to, individual field names, conceptual group
     * names can be used to specify multiple fields. The available conceptual
     * groups are 'post' (all basic fields), 'taxonomies', 'custom_fields',
     * and 'enclosure'.
     *
     * @see get_post()
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id  Blog ID (unused).
     *     @type string $username Username.
     *     @type string $password Password.
     *     @type int    $post_id  Post ID.
     *     @type array  $fields   The subset of post type fields to return.
     * }
     * @return array|IXR_Error Array contains (based on $fields parameter):
     *  - 'post_id'
     *  - 'post_title'
     *  - 'post_date'
     *  - 'post_date_gmt'
     *  - 'post_modified'
     *  - 'post_modified_gmt'
     *  - 'post_status'
     *  - 'post_type'
     *  - 'post_name'
     *  - 'post_author'
     *  - 'post_password'
     *  - 'post_excerpt'
     *  - 'post_content'
     *  - 'link'
     *  - 'comment_status'
     *  - 'ping_status'
     *  - 'sticky'
     *  - 'custom_fields'
     *  - 'terms'
     *  - 'categories'
     *  - 'tags'
     *  - 'enclosure'
     */
    public function wp_getPost($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_getPost") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 1423")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_getPost:1423@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Retrieve posts.
     *
     * @since 3.4.0
     *
     * @see wp_get_recent_posts()
     * @see wp_getPost() for more on `$fields`
     * @see get_posts() for more on `$filter` values
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id  Blog ID (unused).
     *     @type string $username Username.
     *     @type string $password Password.
     *     @type array  $filter   Optional. Modifies the query used to retrieve posts. Accepts 'post_type',
     *                            'post_status', 'number', 'offset', 'orderby', 's', and 'order'.
     *                            Default empty array.
     *     @type array  $fields   Optional. The subset of post type fields to return in the response array.
     * }
     * @return array|IXR_Error Array contains a collection of posts.
     */
    public function wp_getPosts($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_getPosts") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 1482")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_getPosts:1482@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Create a new term.
     *
     * @since 3.4.0
     *
     * @see wp_insert_term()
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id        Blog ID (unused).
     *     @type string $username       Username.
     *     @type string $password       Password.
     *     @type array  $content_struct Content struct for adding a new term. The struct must contain
     *                                  the term 'name' and 'taxonomy'. Optional accepted values include
     *                                  'parent', 'description', and 'slug'.
     * }
     * @return int|IXR_Error The term ID on success, or an IXR_Error object on failure.
     */
    public function wp_newTerm($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_newTerm") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 1567")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_newTerm:1567@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Edit a term.
     *
     * @since 3.4.0
     *
     * @see wp_update_term()
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id        Blog ID (unused).
     *     @type string $username       Username.
     *     @type string $password       Password.
     *     @type int    $term_id        Term ID.
     *     @type array  $content_struct Content struct for editing a term. The struct must contain the
     *                                  term ''taxonomy'. Optional accepted values include 'name', 'parent',
     *                                  'description', and 'slug'.
     * }
     * @return true|IXR_Error True on success, IXR_Error instance on failure.
     */
    public function wp_editTerm($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_editTerm") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 1649")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_editTerm:1649@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Delete a term.
     *
     * @since 3.4.0
     *
     * @see wp_delete_term()
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id      Blog ID (unused).
     *     @type string $username     Username.
     *     @type string $password     Password.
     *     @type string $taxnomy_name Taxonomy name.
     *     @type int    $term_id      Term ID.
     * }
     * @return true|IXR_Error True on success, IXR_Error instance on failure.
     */
    public function wp_deleteTerm($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_deleteTerm") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 1739")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_deleteTerm:1739@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Retrieve a term.
     *
     * @since 3.4.0
     *
     * @see get_term()
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id  Blog ID (unused).
     *     @type string $username Username.
     *     @type string $password Password.
     *     @type string $taxnomy  Taxonomy name.
     *     @type string $term_id  Term ID.
     * }
     * @return array|IXR_Error IXR_Error on failure, array on success, containing:
     *  - 'term_id'
     *  - 'name'
     *  - 'slug'
     *  - 'term_group'
     *  - 'term_taxonomy_id'
     *  - 'taxonomy'
     *  - 'description'
     *  - 'parent'
     *  - 'count'
     */
    public function wp_getTerm($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_getTerm") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 1805")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_getTerm:1805@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Retrieve all terms for a taxonomy.
     *
     * @since 3.4.0
     *
     * The optional $filter parameter modifies the query used to retrieve terms.
     * Accepted keys are 'number', 'offset', 'orderby', 'order', 'hide_empty', and 'search'.
     *
     * @see get_terms()
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id  Blog ID (unused).
     *     @type string $username Username.
     *     @type string $password Password.
     *     @type string $taxnomy  Taxonomy name.
     *     @type array  $filter   Optional. Modifies the query used to retrieve posts. Accepts 'number',
     *                            'offset', 'orderby', 'order', 'hide_empty', and 'search'. Default empty array.
     * }
     * @return array|IXR_Error An associative array of terms data on success, IXR_Error instance otherwise.
     */
    public function wp_getTerms($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_getTerms") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 1859")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_getTerms:1859@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Retrieve a taxonomy.
     *
     * @since 3.4.0
     *
     * @see get_taxonomy()
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id  Blog ID (unused).
     *     @type string $username Username.
     *     @type string $password Password.
     *     @type string $taxnomy  Taxonomy name.
     *     @type array  $fields   Optional. Array of taxonomy fields to limit to in the return.
     *                            Accepts 'labels', 'cap', 'menu', and 'object_type'.
     *                            Default empty array.
     * }
     * @return array|IXR_Error An array of taxonomy data on success, IXR_Error instance otherwise.
     */
    public function wp_getTaxonomy($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_getTaxonomy") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 1933")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_getTaxonomy:1933@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Retrieve all taxonomies.
     *
     * @since 3.4.0
     *
     * @see get_taxonomies()
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id  Blog ID (unused).
     *     @type string $username Username.
     *     @type string $password Password.
     *     @type array  $filter   Optional. An array of arguments for retrieving taxonomies.
     *     @type array  $fields   Optional. The subset of taxonomy fields to return.
     * }
     * @return array|IXR_Error An associative array of taxonomy data with returned fields determined
     *                         by `$fields`, or an IXR_Error instance on failure.
     */
    public function wp_getTaxonomies($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_getTaxonomies") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 1989")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_getTaxonomies:1989@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Retrieve a user.
     *
     * The optional $fields parameter specifies what fields will be included
     * in the response array. This should be a list of field names. 'user_id' will
     * always be included in the response regardless of the value of $fields.
     *
     * Instead of, or in addition to, individual field names, conceptual group
     * names can be used to specify multiple fields. The available conceptual
     * groups are 'basic' and 'all'.
     *
     * @uses get_userdata()
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id (unused)
     *     @type string $username
     *     @type string $password
     *     @type int    $user_id
     *     @type array  $fields (optional)
     * }
     * @return array|IXR_Error Array contains (based on $fields parameter):
     *  - 'user_id'
     *  - 'username'
     *  - 'first_name'
     *  - 'last_name'
     *  - 'registered'
     *  - 'bio'
     *  - 'email'
     *  - 'nickname'
     *  - 'nicename'
     *  - 'url'
     *  - 'display_name'
     *  - 'roles'
     */
    public function wp_getUser($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_getUser") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 2058")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_getUser:2058@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Retrieve users.
     *
     * The optional $filter parameter modifies the query used to retrieve users.
     * Accepted keys are 'number' (default: 50), 'offset' (default: 0), 'role',
     * 'who', 'orderby', and 'order'.
     *
     * The optional $fields parameter specifies what fields will be included
     * in the response array.
     *
     * @uses get_users()
     * @see wp_getUser() for more on $fields and return values
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id (unused)
     *     @type string $username
     *     @type string $password
     *     @type array  $filter (optional)
     *     @type array  $fields (optional)
     * }
     * @return array|IXR_Error users data
     */
    public function wp_getUsers($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_getUsers") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 2119")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_getUsers:2119@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Retrieve information about the requesting user.
     *
     * @uses get_userdata()
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id (unused)
     *     @type string $username
     *     @type string $password
     *     @type array  $fields (optional)
     * }
     * @return array|IXR_Error (@see wp_getUser)
     */
    public function wp_getProfile($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_getProfile") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 2185")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_getProfile:2185@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Edit user's profile.
     *
     * @uses wp_update_user()
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id (unused)
     *     @type string $username
     *     @type string $password
     *     @type array  $content_struct It can optionally contain:
     *      - 'first_name'
     *      - 'last_name'
     *      - 'website'
     *      - 'display_name'
     *      - 'nickname'
     *      - 'nicename'
     *      - 'bio'
     * }
     * @return true|IXR_Error True, on success.
     */
    public function wp_editProfile($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_editProfile") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 2233")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_editProfile:2233@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Retrieve page.
     *
     * @since 2.2.0
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id (unused)
     *     @type int    $page_id
     *     @type string $username
     *     @type string $password
     * }
     * @return array|IXR_Error
     */
    public function wp_getPage($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_getPage") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 2300")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_getPage:2300@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Retrieve Pages.
     *
     * @since 2.2.0
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id (unused)
     *     @type string $username
     *     @type string $password
     *     @type int    $num_pages
     * }
     * @return array|IXR_Error
     */
    public function wp_getPages($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_getPages") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 2342")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_getPages:2342@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Create new page.
     *
     * @since 2.2.0
     *
     * @see wp_xmlrpc_server::mw_newPost()
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id (unused)
     *     @type string $username
     *     @type string $password
     *     @type array  $content_struct
     * }
     * @return int|IXR_Error
     */
    public function wp_newPage($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_newPage") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 2389")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_newPage:2389@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Delete page.
     *
     * @since 2.2.0
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id (unused)
     *     @type string $username
     *     @type string $password
     *     @type int    $page_id
     * }
     * @return true|IXR_Error True, if success.
     */
    public function wp_deletePage($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_deletePage") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 2419")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_deletePage:2419@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Edit page.
     *
     * @since 2.2.0
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id (unused)
     *     @type int    $page_id
     *     @type string $username
     *     @type string $password
     *     @type string $content
     *     @type string $publish
     * }
     * @return array|IXR_Error
     */
    public function wp_editPage($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_editPage") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 2476")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_editPage:2476@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Retrieve page list.
     *
     * @since 2.2.0
     *
     * @global wpdb $wpdb WordPress database abstraction object.
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id (unused)
     *     @type string $username
     *     @type string $password
     * }
     * @return array|IXR_Error
     */
    public function wp_getPageList($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_getPageList") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 2523")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_getPageList:2523@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Retrieve authors list.
     *
     * @since 2.2.0
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id (unused)
     *     @type string $username
     *     @type string $password
     * }
     * @return array|IXR_Error
     */
    public function wp_getAuthors($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_getAuthors") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 2565")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_getAuthors:2565@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Get list of all tags
     *
     * @since 2.7.0
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id (unused)
     *     @type string $username
     *     @type string $password
     * }
     * @return array|IXR_Error
     */
    public function wp_getTags($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_getTags") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 2599")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_getTags:2599@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Create new category.
     *
     * @since 2.2.0
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id (unused)
     *     @type string $username
     *     @type string $password
     *     @type array  $category
     * }
     * @return int|IXR_Error Category ID.
     */
    public function wp_newCategory($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_newCategory") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 2644")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_newCategory:2644@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Remove category.
     *
     * @since 2.5.0
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id (unused)
     *     @type string $username
     *     @type string $password
     *     @type int    $category_id
     * }
     * @return bool|IXR_Error See wp_delete_term() for return info.
     */
    public function wp_deleteCategory($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_deleteCategory") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 2712")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_deleteCategory:2712@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Retrieve category list.
     *
     * @since 2.2.0
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id (unused)
     *     @type string $username
     *     @type string $password
     *     @type array  $category
     *     @type int    $max_results
     * }
     * @return array|IXR_Error
     */
    public function wp_suggestCategories($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_suggestCategories") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 2758")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_suggestCategories:2758@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Retrieve comment.
     *
     * @since 2.7.0
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id (unused)
     *     @type string $username
     *     @type string $password
     *     @type int    $comment_id
     * }
     * @return array|IXR_Error
     */
    public function wp_getComment($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_getComment") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 2796")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_getComment:2796@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Retrieve comments.
     *
     * Besides the common blog_id (unused), username, and password arguments, it takes a filter
     * array as last argument.
     *
     * Accepted 'filter' keys are 'status', 'post_id', 'offset', and 'number'.
     *
     * The defaults are as follows:
     * - 'status' - Default is ''. Filter by status (e.g., 'approve', 'hold')
     * - 'post_id' - Default is ''. The post where the comment is posted. Empty string shows all comments.
     * - 'number' - Default is 10. Total number of media items to retrieve.
     * - 'offset' - Default is 0. See WP_Query::query() for more.
     *
     * @since 2.7.0
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id (unused)
     *     @type string $username
     *     @type string $password
     *     @type array  $struct
     * }
     * @return array|IXR_Error Contains a collection of comments. See wp_xmlrpc_server::wp_getComment() for a description of each item contents
     */
    public function wp_getComments($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_getComments") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 2843")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_getComments:2843@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Delete a comment.
     *
     * By default, the comment will be moved to the Trash instead of deleted.
     * See wp_delete_comment() for more information on this behavior.
     *
     * @since 2.7.0
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id (unused)
     *     @type string $username
     *     @type string $password
     *     @type int    $comment_ID
     * }
     * @return bool|IXR_Error See wp_delete_comment().
     */
    public function wp_deleteComment($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_deleteComment") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 2910")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_deleteComment:2910@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Edit comment.
     *
     * Besides the common blog_id (unused), username, and password arguments, it takes a
     * comment_id integer and a content_struct array as last argument.
     *
     * The allowed keys in the content_struct array are:
     *  - 'author'
     *  - 'author_url'
     *  - 'author_email'
     *  - 'content'
     *  - 'date_created_gmt'
     *  - 'status'. Common statuses are 'approve', 'hold', 'spam'. See get_comment_statuses() for more details
     *
     * @since 2.7.0
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id (unused)
     *     @type string $username
     *     @type string $password
     *     @type int    $comment_ID
     *     @type array  $content_struct
     * }
     * @return true|IXR_Error True, on success.
     */
    public function wp_editComment($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_editComment") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 2970")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_editComment:2970@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Create new comment.
     *
     * @since 2.7.0
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int        $blog_id (unused)
     *     @type string     $username
     *     @type string     $password
     *     @type string|int $post
     *     @type array      $content_struct
     * }
     * @return int|IXR_Error See wp_new_comment().
     */
    public function wp_newComment($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_newComment") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 3052")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_newComment:3052@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Retrieve all of the comment status.
     *
     * @since 2.7.0
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id (unused)
     *     @type string $username
     *     @type string $password
     * }
     * @return array|IXR_Error
     */
    public function wp_getCommentStatusList($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_getCommentStatusList") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 3171")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_getCommentStatusList:3171@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Retrieve comment count.
     *
     * @since 2.5.0
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id (unused)
     *     @type string $username
     *     @type string $password
     *     @type int    $post_id
     * }
     * @return array|IXR_Error
     */
    public function wp_getCommentCount($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_getCommentCount") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 3202")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_getCommentCount:3202@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Retrieve post statuses.
     *
     * @since 2.5.0
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id (unused)
     *     @type string $username
     *     @type string $password
     * }
     * @return array|IXR_Error
     */
    public function wp_getPostStatusList($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_getPostStatusList") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 3238")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_getPostStatusList:3238@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Retrieve page statuses.
     *
     * @since 2.5.0
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id (unused)
     *     @type string $username
     *     @type string $password
     * }
     * @return array|IXR_Error
     */
    public function wp_getPageStatusList($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_getPageStatusList") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 3268")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_getPageStatusList:3268@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Retrieve page templates.
     *
     * @since 2.6.0
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id (unused)
     *     @type string $username
     *     @type string $password
     * }
     * @return array|IXR_Error
     */
    public function wp_getPageTemplates($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_getPageTemplates") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 3298")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_getPageTemplates:3298@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Retrieve blog options.
     *
     * @since 2.6.0
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id (unused)
     *     @type string $username
     *     @type string $password
     *     @type array  $options
     * }
     * @return array|IXR_Error
     */
    public function wp_getOptions($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_getOptions") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 3329")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_getOptions:3329@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Retrieve blog options value from list.
     *
     * @since 2.6.0
     *
     * @param array $options Options to retrieve.
     * @return array
     */
    public function _getOptions($options)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_getOptions") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 3353")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called _getOptions:3353@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Update blog options.
     *
     * @since 2.6.0
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id (unused)
     *     @type string $username
     *     @type string $password
     *     @type array  $options
     * }
     * @return array|IXR_Error
     */
    public function wp_setOptions($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_setOptions") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 3387")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_setOptions:3387@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Retrieve a media item by ID
     *
     * @since 3.1.0
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id (unused)
     *     @type string $username
     *     @type string $password
     *     @type int    $attachment_id
     * }
     * @return array|IXR_Error Associative array contains:
     *  - 'date_created_gmt'
     *  - 'parent'
     *  - 'link'
     *  - 'thumbnail'
     *  - 'title'
     *  - 'caption'
     *  - 'description'
     *  - 'metadata'
     */
    public function wp_getMediaItem($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_getMediaItem") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 3437")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_getMediaItem:3437@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Retrieves a collection of media library items (or attachments)
     *
     * Besides the common blog_id (unused), username, and password arguments, it takes a filter
     * array as last argument.
     *
     * Accepted 'filter' keys are 'parent_id', 'mime_type', 'offset', and 'number'.
     *
     * The defaults are as follows:
     * - 'number' - Default is 5. Total number of media items to retrieve.
     * - 'offset' - Default is 0. See WP_Query::query() for more.
     * - 'parent_id' - Default is ''. The post where the media item is attached. Empty string shows all media items. 0 shows unattached media items.
     * - 'mime_type' - Default is ''. Filter by mime type (e.g., 'image/jpeg', 'application/pdf')
     *
     * @since 3.1.0
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id (unused)
     *     @type string $username
     *     @type string $password
     *     @type array  $struct
     * }
     * @return array|IXR_Error Contains a collection of media items. See wp_xmlrpc_server::wp_getMediaItem() for a description of each item contents
     */
    public function wp_getMediaLibrary($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_getMediaLibrary") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 3484")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_getMediaLibrary:3484@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Retrieves a list of post formats used by the site.
     *
     * @since 3.1.0
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id (unused)
     *     @type string $username
     *     @type string $password
     * }
     * @return array|IXR_Error List of post formats, otherwise IXR_Error object.
     */
    public function wp_getPostFormats($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_getPostFormats") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 3524")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_getPostFormats:3524@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Retrieves a post type
     *
     * @since 3.4.0
     *
     * @see get_post_type_object()
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id (unused)
     *     @type string $username
     *     @type string $password
     *     @type string $post_type_name
     *     @type array  $fields (optional)
     * }
     * @return array|IXR_Error Array contains:
     *  - 'labels'
     *  - 'description'
     *  - 'capability_type'
     *  - 'cap'
     *  - 'map_meta_cap'
     *  - 'hierarchical'
     *  - 'menu_position'
     *  - 'taxonomies'
     *  - 'supports'
     */
    public function wp_getPostType($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_getPostType") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 3580")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_getPostType:3580@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Retrieves a post types
     *
     * @since 3.4.0
     *
     * @see get_post_types()
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id (unused)
     *     @type string $username
     *     @type string $password
     *     @type array  $filter (optional)
     *     @type array  $fields (optional)
     * }
     * @return array|IXR_Error
     */
    public function wp_getPostTypes($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_getPostTypes") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 3635")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_getPostTypes:3635@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Retrieve revisions for a specific post.
     *
     * @since 3.5.0
     *
     * The optional $fields parameter specifies what fields will be included
     * in the response array.
     *
     * @uses wp_get_post_revisions()
     * @see wp_getPost() for more on $fields
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id (unused)
     *     @type string $username
     *     @type string $password
     *     @type int    $post_id
     *     @type array  $fields (optional)
     * }
     * @return array|IXR_Error contains a collection of posts.
     */
    public function wp_getRevisions($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_getRevisions") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 3688")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_getRevisions:3688@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Restore a post revision
     *
     * @since 3.5.0
     *
     * @uses wp_restore_post_revision()
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id (unused)
     *     @type string $username
     *     @type string $password
     *     @type int    $revision_id
     * }
     * @return bool|IXR_Error false if there was an error restoring, true if success.
     */
    public function wp_restoreRevision($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_restoreRevision") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 3761")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_restoreRevision:3761@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /*
     * Blogger API functions.
     * Specs on http://plant.blogger.com/api and https://groups.yahoo.com/group/bloggerDev/
     */
    /**
     * Retrieve blogs that user owns.
     *
     * Will make more sense once we support multiple blogs.
     *
     * @since 1.5.0
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id (unused)
     *     @type string $username
     *     @type string $password
     * }
     * @return array|IXR_Error
     */
    public function blogger_getUsersBlogs($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("blogger_getUsersBlogs") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 3817")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called blogger_getUsersBlogs:3817@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Private function for retrieving a users blogs for multisite setups
     *
     * @since 3.0.0
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type string $username Username.
     *     @type string $password Password.
     * }
     * @return array|IXR_Error
     */
    protected function _multisite_getUsersBlogs($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_multisite_getUsersBlogs") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 3851")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called _multisite_getUsersBlogs:3851@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Retrieve user's data.
     *
     * Gives your client some info about you, so you don't have to.
     *
     * @since 1.5.0
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id (unused)
     *     @type string $username
     *     @type string $password
     * }
     * @return array|IXR_Error
     */
    public function blogger_getUserInfo($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("blogger_getUserInfo") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 3889")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called blogger_getUserInfo:3889@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Retrieve post.
     *
     * @since 1.5.0
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id (unused)
     *     @type int    $post_ID
     *     @type string $username
     *     @type string $password
     * }
     * @return array|IXR_Error
     */
    public function blogger_getPost($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("blogger_getPost") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 3921")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called blogger_getPost:3921@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Retrieve list of recent posts.
     *
     * @since 1.5.0
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type string $appkey (unused)
     *     @type int    $blog_id (unused)
     *     @type string $username
     *     @type string $password
     *     @type int    $numberposts (optional)
     * }
     * @return array|IXR_Error
     */
    public function blogger_getRecentPosts($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("blogger_getRecentPosts") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 3963")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called blogger_getRecentPosts:3963@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Deprecated.
     *
     * @since 1.5.0
     * @deprecated 3.5.0
     *
     * @param array $args Unused.
     * @return IXR_Error Error object.
     */
    public function blogger_getTemplate($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("blogger_getTemplate") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 4011")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called blogger_getTemplate:4011@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Deprecated.
     *
     * @since 1.5.0
     * @deprecated 3.5.0
     *
     * @param array $args Unused.
     * @return IXR_Error Error object.
     */
    public function blogger_setTemplate($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("blogger_setTemplate") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 4024")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called blogger_setTemplate:4024@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Creates new post.
     *
     * @since 1.5.0
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type string $appkey (unused)
     *     @type int    $blog_id (unused)
     *     @type string $username
     *     @type string $password
     *     @type string $content
     *     @type string $publish
     * }
     * @return int|IXR_Error
     */
    public function blogger_newPost($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("blogger_newPost") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 4045")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called blogger_newPost:4045@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Edit a post.
     *
     * @since 1.5.0
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id (unused)
     *     @type int    $post_ID
     *     @type string $username
     *     @type string $password
     *     @type string $content
     *     @type bool   $publish
     * }
     * @return true|IXR_Error true when done.
     */
    public function blogger_editPost($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("blogger_editPost") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 4107")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called blogger_editPost:4107@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Remove a post.
     *
     * @since 1.5.0
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id (unused)
     *     @type int    $post_ID
     *     @type string $username
     *     @type string $password
     * }
     * @return true|IXR_Error True when post is deleted.
     */
    public function blogger_deletePost($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("blogger_deletePost") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 4172")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called blogger_deletePost:4172@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /*
     * MetaWeblog API functions.
     * Specs on wherever Dave Winer wants them to be.
     */
    /**
     * Create a new post.
     *
     * The 'content_struct' argument must contain:
     *  - title
     *  - description
     *  - mt_excerpt
     *  - mt_text_more
     *  - mt_keywords
     *  - mt_tb_ping_urls
     *  - categories
     *
     * Also, it can optionally contain:
     *  - wp_slug
     *  - wp_password
     *  - wp_page_parent_id
     *  - wp_page_order
     *  - wp_author_id
     *  - post_status | page_status - can be 'draft', 'private', 'publish', or 'pending'
     *  - mt_allow_comments - can be 'open' or 'closed'
     *  - mt_allow_pings - can be 'open' or 'closed'
     *  - date_created_gmt
     *  - dateCreated
     *  - wp_post_thumbnail
     *
     * @since 1.5.0
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id (unused)
     *     @type string $username
     *     @type string $password
     *     @type array  $content_struct
     *     @type int    $publish
     * }
     * @return int|IXR_Error
     */
    public function mw_newPost($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("mw_newPost") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 4249")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called mw_newPost:4249@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Adds an enclosure to a post if it's new.
     *
     * @since 2.8.0
     *
     * @param int   $post_ID   Post ID.
     * @param array $enclosure Enclosure data.
     */
    public function add_enclosure_if_new($post_ID, $enclosure)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("add_enclosure_if_new") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 4530")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called add_enclosure_if_new:4530@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Attach upload to a post.
     *
     * @since 2.1.0
     *
     * @global wpdb $wpdb WordPress database abstraction object.
     *
     * @param int    $post_ID      Post ID.
     * @param string $post_content Post Content for attachment.
     */
    public function attach_uploads($post_ID, $post_content)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("attach_uploads") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 4560")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called attach_uploads:4560@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Edit a post.
     *
     * @since 1.5.0
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id (unused)
     *     @type string $username
     *     @type string $password
     *     @type array  $content_struct
     *     @type int    $publish
     * }
     * @return true|IXR_Error True on success.
     */
    public function mw_editPost($args)
    {
        $this->escape($args);
        $post_ID = (int) $args[0];
        $username = $args[1];
        $password = $args[2];
        $content_struct = $args[3];
        $publish = isset($args[4]) ? $args[4] : 0;
        $user = $this->login($username, $password);
        if (!$user) {
            return $this->error;
        }
        /** This action is documented in wp-includes/class-wp-xmlrpc-server.php */
        do_action('xmlrpc_call', 'metaWeblog.editPost', $args, $this);
        $postdata = get_post($post_ID, ARRAY_A);
        /*
         * If there is no post data for the give post ID, stop now and return an error.
         * Otherwise a new post will be created (which was the old behavior).
         */
        if (!$postdata || empty($postdata['ID'])) {
            return new IXR_Error(404, __('Invalid post ID.'));
        }
        if (!current_user_can('edit_post', $post_ID)) {
            return new IXR_Error(401, __('Sorry, you are not allowed to edit this post.'));
        }
        // Use wp.editPost to edit post types other than post and page.
        if (!in_array($postdata['post_type'], array('post', 'page'), true)) {
            return new IXR_Error(401, __('Invalid post type.'));
        }
        // Thwart attempt to change the post type.
        if (!empty($content_struct['post_type']) && $content_struct['post_type'] != $postdata['post_type']) {
            return new IXR_Error(401, __('The post type may not be changed.'));
        }
        // Check for a valid post format if one was given.
        if (isset($content_struct['wp_post_format'])) {
            $content_struct['wp_post_format'] = sanitize_key($content_struct['wp_post_format']);
            if (!array_key_exists($content_struct['wp_post_format'], get_post_format_strings())) {
                return new IXR_Error(404, __('Invalid post format.'));
            }
        }
        $this->escape($postdata);
        $ID = $postdata['ID'];
        $post_content = $postdata['post_content'];
        $post_title = $postdata['post_title'];
        $post_excerpt = $postdata['post_excerpt'];
        $post_password = $postdata['post_password'];
        $post_parent = $postdata['post_parent'];
        $post_type = $postdata['post_type'];
        $menu_order = $postdata['menu_order'];
        $ping_status = $postdata['ping_status'];
        $comment_status = $postdata['comment_status'];
        // Let WordPress manage slug if none was provided.
        $post_name = $postdata['post_name'];
        if (isset($content_struct['wp_slug'])) {
            $post_name = $content_struct['wp_slug'];
        }
        // Only use a password if one was given.
        if (isset($content_struct['wp_password'])) {
            $post_password = $content_struct['wp_password'];
        }
        // Only set a post parent if one was given.
        if (isset($content_struct['wp_page_parent_id'])) {
            $post_parent = $content_struct['wp_page_parent_id'];
        }
        // Only set the 'menu_order' if it was given.
        if (isset($content_struct['wp_page_order'])) {
            $menu_order = $content_struct['wp_page_order'];
        }
        $page_template = null;
        if (!empty($content_struct['wp_page_template']) && 'page' === $post_type) {
            $page_template = $content_struct['wp_page_template'];
        }
        $post_author = $postdata['post_author'];
        // If an author id was provided then use it instead.
        if (isset($content_struct['wp_author_id'])) {
            // Check permissions if attempting to switch author to or from another user.
            if ($user->ID != $content_struct['wp_author_id'] || $user->ID != $post_author) {
                switch ($post_type) {
                    case 'post':
                        if (!current_user_can('edit_others_posts')) {
                            return new IXR_Error(401, __('Sorry, you are not allowed to change the post author as this user.'));
                        }
                        break;
                    case 'page':
                        if (!current_user_can('edit_others_pages')) {
                            return new IXR_Error(401, __('Sorry, you are not allowed to change the page author as this user.'));
                        }
                        break;
                    default:
                        return new IXR_Error(401, __('Invalid post type.'));
                }
                $post_author = $content_struct['wp_author_id'];
            }
        }
        if (isset($content_struct['mt_allow_comments'])) {
            if (!is_numeric($content_struct['mt_allow_comments'])) {
                switch ($content_struct['mt_allow_comments']) {
                    case 'closed':
                        $comment_status = 'closed';
                        break;
                    case 'open':
                        $comment_status = 'open';
                        break;
                    default:
                        $comment_status = get_default_comment_status($post_type);
                        break;
                }
            } else {
                switch ((int) $content_struct['mt_allow_comments']) {
                    case 0:
                    case 2:
                        $comment_status = 'closed';
                        break;
                    case 1:
                        $comment_status = 'open';
                        break;
                    default:
                        $comment_status = get_default_comment_status($post_type);
                        break;
                }
            }
        }
        if (isset($content_struct['mt_allow_pings'])) {
            if (!is_numeric($content_struct['mt_allow_pings'])) {
                switch ($content_struct['mt_allow_pings']) {
                    case 'closed':
                        $ping_status = 'closed';
                        break;
                    case 'open':
                        $ping_status = 'open';
                        break;
                    default:
                        $ping_status = get_default_comment_status($post_type, 'pingback');
                        break;
                }
            } else {
                switch ((int) $content_struct['mt_allow_pings']) {
                    case 0:
                        $ping_status = 'closed';
                        break;
                    case 1:
                        $ping_status = 'open';
                        break;
                    default:
                        $ping_status = get_default_comment_status($post_type, 'pingback');
                        break;
                }
            }
        }
        if (isset($content_struct['title'])) {
            $post_title = $content_struct['title'];
        }
        if (isset($content_struct['description'])) {
            $post_content = $content_struct['description'];
        }
        $post_category = array();
        if (isset($content_struct['categories'])) {
            $catnames = $content_struct['categories'];
            if (is_array($catnames)) {
                foreach ($catnames as $cat) {
                    $post_category[] = get_cat_ID($cat);
                }
            }
        }
        if (isset($content_struct['mt_excerpt'])) {
            $post_excerpt = $content_struct['mt_excerpt'];
        }
        $post_more = isset($content_struct['mt_text_more']) ? $content_struct['mt_text_more'] : null;
        $post_status = $publish ? 'publish' : 'draft';
        if (isset($content_struct["{$post_type}_status"])) {
            switch ($content_struct["{$post_type}_status"]) {
                case 'draft':
                case 'pending':
                case 'private':
                case 'publish':
                    $post_status = $content_struct["{$post_type}_status"];
                    break;
                default:
                    $post_status = $publish ? 'publish' : 'draft';
                    break;
            }
        }
        $tags_input = isset($content_struct['mt_keywords']) ? $content_struct['mt_keywords'] : null;
        if ('publish' === $post_status || 'private' === $post_status) {
            if ('page' === $post_type && !current_user_can('publish_pages')) {
                return new IXR_Error(401, __('Sorry, you are not allowed to publish this page.'));
            } elseif (!current_user_can('publish_posts')) {
                return new IXR_Error(401, __('Sorry, you are not allowed to publish this post.'));
            }
        }
        if ($post_more) {
            $post_content = $post_content . '<!--more-->' . $post_more;
        }
        $to_ping = null;
        if (isset($content_struct['mt_tb_ping_urls'])) {
            $to_ping = $content_struct['mt_tb_ping_urls'];
            if (is_array($to_ping)) {
                $to_ping = implode(' ', $to_ping);
            }
        }
        // Do some timestamp voodoo.
        if (!empty($content_struct['date_created_gmt'])) {
            // We know this is supposed to be GMT, so we're going to slap that Z on there by force.
            $dateCreated = rtrim($content_struct['date_created_gmt']->getIso(), 'Z') . 'Z';
        } elseif (!empty($content_struct['dateCreated'])) {
            $dateCreated = $content_struct['dateCreated']->getIso();
        }
        // Default to not flagging the post date to be edited unless it's intentional.
        $edit_date = false;
        if (!empty($dateCreated)) {
            $post_date = iso8601_to_datetime($dateCreated);
            $post_date_gmt = iso8601_to_datetime($dateCreated, 'gmt');
            // Flag the post date to be edited.
            $edit_date = true;
        } else {
            $post_date = $postdata['post_date'];
            $post_date_gmt = $postdata['post_date_gmt'];
        }
        // We've got all the data -- post it.
        $newpost = compact('ID', 'post_content', 'post_title', 'post_category', 'post_status', 'post_excerpt', 'comment_status', 'ping_status', 'edit_date', 'post_date', 'post_date_gmt', 'to_ping', 'post_name', 'post_password', 'post_parent', 'menu_order', 'post_author', 'tags_input', 'page_template');
        $result = wp_update_post($newpost, true);
        if (is_wp_error($result)) {
            return new IXR_Error(500, $result->get_error_message());
        }
        if (!$result) {
            return new IXR_Error(500, __('Sorry, the post could not be updated.'));
        }
        // Only posts can be sticky.
        if ('post' === $post_type && isset($content_struct['sticky'])) {
            $data = $newpost;
            $data['sticky'] = $content_struct['sticky'];
            $data['post_type'] = 'post';
            $error = $this->_toggle_sticky($data, true);
            if ($error) {
                return $error;
            }
        }
        if (isset($content_struct['custom_fields'])) {
            $this->set_custom_fields($post_ID, $content_struct['custom_fields']);
        }
        if (isset($content_struct['wp_post_thumbnail'])) {
            // Empty value deletes, non-empty value adds/updates.
            if (empty($content_struct['wp_post_thumbnail'])) {
                delete_post_thumbnail($post_ID);
            } else {
                if (set_post_thumbnail($post_ID, $content_struct['wp_post_thumbnail']) === false) {
                    return new IXR_Error(404, __('Invalid attachment ID.'));
                }
            }
            unset($content_struct['wp_post_thumbnail']);
        }
        // Handle enclosures.
        $thisEnclosure = isset($content_struct['enclosure']) ? $content_struct['enclosure'] : null;
        $this->add_enclosure_if_new($post_ID, $thisEnclosure);
        $this->attach_uploads($ID, $post_content);
        // Handle post formats if assigned, validation is handled earlier in this function.
        if (isset($content_struct['wp_post_format'])) {
            set_post_format($post_ID, $content_struct['wp_post_format']);
        }
        /**
         * Fires after a post has been successfully updated via the XML-RPC MovableType API.
         *
         * @since 3.4.0
         *
         * @param int   $post_ID ID of the updated post.
         * @param array $args    An array of arguments to update the post.
         */
        do_action('xmlrpc_call_success_mw_editPost', $post_ID, $args);
        // phpcs:ignore WordPress.NamingConventions.ValidHookName.NotLowercase
        return true;
    }
    /**
     * Retrieve post.
     *
     * @since 1.5.0
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id (unused)
     *     @type int    $post_ID
     *     @type string $username
     *     @type string $password
     * }
     * @return array|IXR_Error
     */
    public function mw_getPost($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("mw_getPost") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 4875")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called mw_getPost:4875@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Retrieve list of recent posts.
     *
     * @since 1.5.0
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id (unused)
     *     @type string $username
     *     @type string $password
     *     @type int    $numberposts
     * }
     * @return array|IXR_Error
     */
    public function mw_getRecentPosts($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("mw_getRecentPosts") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 4998")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called mw_getRecentPosts:4998@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Retrieve the list of categories on a given blog.
     *
     * @since 1.5.0
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id (unused)
     *     @type string $username
     *     @type string $password
     * }
     * @return array|IXR_Error
     */
    public function mw_getCategories($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("mw_getCategories") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 5107")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called mw_getCategories:5107@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Uploads a file, following your settings.
     *
     * Adapted from a patch by Johann Richard.
     *
     * @link http://mycvs.org/archives/2004/06/30/file-upload-to-wordpress-in-ecto/
     *
     * @since 1.5.0
     *
     * @global wpdb $wpdb WordPress database abstraction object.
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id (unused)
     *     @type string $username
     *     @type string $password
     *     @type array  $data
     * }
     * @return array|IXR_Error
     */
    public function mw_newMediaObject($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("mw_newMediaObject") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 5159")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called mw_newMediaObject:5159@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /*
     * MovableType API functions.
     * Specs on http://www.movabletype.org/docs/mtmanual_programmatic.html
     */
    /**
     * Retrieve the post titles of recent posts.
     *
     * @since 1.5.0
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id (unused)
     *     @type string $username
     *     @type string $password
     *     @type int    $numberposts
     * }
     * @return array|IXR_Error
     */
    public function mt_getRecentPostTitles($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("mt_getRecentPostTitles") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 5254")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called mt_getRecentPostTitles:5254@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Retrieve list of all categories on blog.
     *
     * @since 1.5.0
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $blog_id (unused)
     *     @type string $username
     *     @type string $password
     * }
     * @return array|IXR_Error
     */
    public function mt_getCategoryList($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("mt_getCategoryList") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 5300")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called mt_getCategoryList:5300@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Retrieve post categories.
     *
     * @since 1.5.0
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $post_ID
     *     @type string $username
     *     @type string $password
     * }
     * @return array|IXR_Error
     */
    public function mt_getPostCategories($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("mt_getPostCategories") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 5340")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called mt_getPostCategories:5340@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Sets categories for a post.
     *
     * @since 1.5.0
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $post_ID
     *     @type string $username
     *     @type string $password
     *     @type array  $categories
     * }
     * @return true|IXR_Error True on success.
     */
    public function mt_setPostCategories($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("mt_setPostCategories") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 5383")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called mt_setPostCategories:5383@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Retrieve an array of methods supported by this server.
     *
     * @since 1.5.0
     *
     * @return array
     */
    public function mt_supportedMethods()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("mt_supportedMethods") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 5417")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called mt_supportedMethods:5417@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Retrieve an empty array because we don't support per-post text filters.
     *
     * @since 1.5.0
     */
    public function mt_supportedTextFilters()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("mt_supportedTextFilters") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 5428")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called mt_supportedTextFilters:5428@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Retrieve trackbacks sent to a given post.
     *
     * @since 1.5.0
     *
     * @global wpdb $wpdb WordPress database abstraction object.
     *
     * @param int $post_ID
     * @return array|IXR_Error
     */
    public function mt_getTrackbackPings($post_ID)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("mt_getTrackbackPings") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 5450")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called mt_getTrackbackPings:5450@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Sets a post's publish status to 'publish'.
     *
     * @since 1.5.0
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type int    $post_ID
     *     @type string $username
     *     @type string $password
     * }
     * @return int|IXR_Error
     */
    public function mt_publishPost($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("mt_publishPost") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 5487")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called mt_publishPost:5487@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /*
     * Pingback functions.
     * Specs on www.hixie.ch/specs/pingback/pingback
     */
    /**
     * Retrieves a pingback and registers it.
     *
     * @since 1.5.0
     *
     * @param array $args {
     *     Method arguments. Note: arguments must be ordered as documented.
     *
     *     @type string $pagelinkedfrom
     *     @type string $pagelinkedto
     * }
     * @return string|IXR_Error
     */
    public function pingback_ping($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("pingback_ping") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 5529")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called pingback_ping:5529@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Retrieve array of URLs that pingbacked the given URL.
     *
     * Specs on http://www.aquarionics.com/misc/archives/blogite/0198.html
     *
     * @since 1.5.0
     *
     * @global wpdb $wpdb WordPress database abstraction object.
     *
     * @param string $url
     * @return array|IXR_Error
     */
    public function pingback_extensions_getPingbacks($url)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("pingback_extensions_getPingbacks") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 5728")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called pingback_extensions_getPingbacks:5728@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
    /**
     * Sends a pingback error based on the given error code and message.
     *
     * @since 3.6.0
     *
     * @param int    $code    Error code.
     * @param string $message Error message.
     * @return IXR_Error Error object.
     */
    protected function pingback_error($code, $message)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("pingback_error") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php at line 5772")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called pingback_error:5772@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-xmlrpc-server.php');
        die();
    }
}