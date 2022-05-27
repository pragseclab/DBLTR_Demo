<?php

/**
 * WordPress Upgrade API
 *
 * Most of the functions are pluggable and can be overwritten.
 *
 * @package WordPress
 * @subpackage Administration
 */
/** Include user installation customization script. */
if (file_exists(WP_CONTENT_DIR . '/install.php')) {
    require WP_CONTENT_DIR . '/install.php';
}
/** WordPress Administration API */
require_once ABSPATH . 'wp-admin/includes/admin.php';
/** WordPress Schema API */
require_once ABSPATH . 'wp-admin/includes/schema.php';
if (!function_exists('wp_install')) {
    /**
     * Installs the site.
     *
     * Runs the required functions to set up and populate the database,
     * including primary admin user and initial options.
     *
     * @since 2.1.0
     *
     * @param string $blog_title    Site title.
     * @param string $user_name     User's username.
     * @param string $user_email    User's email.
     * @param bool   $public        Whether site is public.
     * @param string $deprecated    Optional. Not used.
     * @param string $user_password Optional. User's chosen password. Default empty (random password).
     * @param string $language      Optional. Language chosen. Default empty.
     * @return array {
     *     Data for the newly installed site.
     *
     *     @type string $url              The URL of the site.
     *     @type int    $user_id          The ID of the site owner.
     *     @type string $password         The password of the site owner, if their user account didn't already exist.
     *     @type string $password_message The explanatory message regarding the password.
     * }
     */
    function wp_install($blog_title, $user_name, $user_email, $public, $deprecated = '', $user_password = '', $language = '')
    {
        if (!empty($deprecated)) {
            _deprecated_argument(__FUNCTION__, '2.6.0');
        }
        wp_check_mysql_version();
        wp_cache_flush();
        make_db_current_silent();
        populate_options();
        populate_roles();
        update_option('blogname', $blog_title);
        update_option('admin_email', $user_email);
        update_option('blog_public', $public);
        // Freshness of site - in the future, this could get more specific about actions taken, perhaps.
        update_option('fresh_site', 1);
        if ($language) {
            update_option('WPLANG', $language);
        }
        $guessurl = wp_guess_url();
        update_option('siteurl', $guessurl);
        // If not a public site, don't ping.
        if (!$public) {
            update_option('default_pingback_flag', 0);
        }
        /*
         * Create default user. If the user already exists, the user tables are
         * being shared among sites. Just set the role in that case.
         */
        $user_id = username_exists($user_name);
        $user_password = trim($user_password);
        $email_password = false;
        $user_created = false;
        if (!$user_id && empty($user_password)) {
            $user_password = wp_generate_password(12, false);
            $message = __('<strong><em>Note that password</em></strong> carefully! It is a <em>random</em> password that was generated just for you.');
            $user_id = wp_create_user($user_name, $user_password, $user_email);
            update_user_option($user_id, 'default_password_nag', true, true);
            $email_password = true;
            $user_created = true;
        } elseif (!$user_id) {
            // Password has been provided.
            $message = '<em>' . __('Your chosen password.') . '</em>';
            $user_id = wp_create_user($user_name, $user_password, $user_email);
            $user_created = true;
        } else {
            $message = __('User already exists. Password inherited.');
        }
        $user = new WP_User($user_id);
        $user->set_role('administrator');
        if ($user_created) {
            $user->user_url = $guessurl;
            wp_update_user($user);
        }
        wp_install_defaults($user_id);
        wp_install_maybe_enable_pretty_permalinks();
        flush_rewrite_rules();
        wp_new_blog_notification($blog_title, $guessurl, $user_id, $email_password ? $user_password : __('The password you chose during installation.'));
        wp_cache_flush();
        /**
         * Fires after a site is fully installed.
         *
         * @since 3.9.0
         *
         * @param WP_User $user The site owner.
         */
        do_action('wp_install', $user);
        return array('url' => $guessurl, 'user_id' => $user_id, 'password' => $user_password, 'password_message' => $message);
    }
}
if (!function_exists('wp_install_defaults')) {
    /**
     * Creates the initial content for a newly-installed site.
     *
     * Adds the default "Uncategorized" category, the first post (with comment),
     * first page, and default widgets for default theme for the current version.
     *
     * @since 2.1.0
     *
     * @global wpdb       $wpdb         WordPress database abstraction object.
     * @global WP_Rewrite $wp_rewrite   WordPress rewrite component.
     * @global string     $table_prefix
     *
     * @param int $user_id User ID.
     */
    function wp_install_defaults($user_id)
    {
        global $wpdb, $wp_rewrite, $table_prefix;
        // Default category.
        $cat_name = __('Uncategorized');
        /* translators: Default category slug. */
        $cat_slug = sanitize_title(_x('Uncategorized', 'Default category slug'));
        if (global_terms_enabled()) {
            $cat_id = $wpdb->get_var($wpdb->prepare("SELECT cat_ID FROM {$wpdb->sitecategories} WHERE category_nicename = %s", $cat_slug));
            if (null == $cat_id) {
                $wpdb->insert($wpdb->sitecategories, array('cat_ID' => 0, 'cat_name' => $cat_name, 'category_nicename' => $cat_slug, 'last_updated' => current_time('mysql', true)));
                $cat_id = $wpdb->insert_id;
            }
            update_option('default_category', $cat_id);
        } else {
            $cat_id = 1;
        }
        $wpdb->insert($wpdb->terms, array('term_id' => $cat_id, 'name' => $cat_name, 'slug' => $cat_slug, 'term_group' => 0));
        $wpdb->insert($wpdb->term_taxonomy, array('term_id' => $cat_id, 'taxonomy' => 'category', 'description' => '', 'parent' => 0, 'count' => 1));
        $cat_tt_id = $wpdb->insert_id;
        // First post.
        $now = current_time('mysql');
        $now_gmt = current_time('mysql', 1);
        $first_post_guid = get_option('home') . '/?p=1';
        if (is_multisite()) {
            $first_post = get_site_option('first_post');
            if (!$first_post) {
                $first_post = "<!-- wp:paragraph -->\n<p>" . __('Welcome to %s. This is your first post. Edit or delete it, then start writing!') . "</p>\n<!-- /wp:paragraph -->";
            }
            $first_post = sprintf($first_post, sprintf('<a href="%s">%s</a>', esc_url(network_home_url()), get_network()->site_name));
            // Back-compat for pre-4.4.
            $first_post = str_replace('SITE_URL', esc_url(network_home_url()), $first_post);
            $first_post = str_replace('SITE_NAME', get_network()->site_name, $first_post);
        } else {
            $first_post = "<!-- wp:paragraph -->\n<p>" . __('Welcome to WordPress. This is your first post. Edit or delete it, then start writing!') . "</p>\n<!-- /wp:paragraph -->";
        }
        $wpdb->insert($wpdb->posts, array(
            'post_author' => $user_id,
            'post_date' => $now,
            'post_date_gmt' => $now_gmt,
            'post_content' => $first_post,
            'post_excerpt' => '',
            'post_title' => __('Hello world!'),
            /* translators: Default post slug. */
            'post_name' => sanitize_title(_x('hello-world', 'Default post slug')),
            'post_modified' => $now,
            'post_modified_gmt' => $now_gmt,
            'guid' => $first_post_guid,
            'comment_count' => 1,
            'to_ping' => '',
            'pinged' => '',
            'post_content_filtered' => '',
        ));
        $wpdb->insert($wpdb->term_relationships, array('term_taxonomy_id' => $cat_tt_id, 'object_id' => 1));
        // Default comment.
        if (is_multisite()) {
            $first_comment_author = get_site_option('first_comment_author');
            $first_comment_email = get_site_option('first_comment_email');
            $first_comment_url = get_site_option('first_comment_url', network_home_url());
            $first_comment = get_site_option('first_comment');
        }
        $first_comment_author = !empty($first_comment_author) ? $first_comment_author : __('A WordPress Commenter');
        $first_comment_email = !empty($first_comment_email) ? $first_comment_email : 'wapuu@wordpress.example';
        $first_comment_url = !empty($first_comment_url) ? $first_comment_url : 'https://wordpress.org/';
        $first_comment = !empty($first_comment) ? $first_comment : __('Hi, this is a comment.
To get started with moderating, editing, and deleting comments, please visit the Comments screen in the dashboard.
Commenter avatars come from <a href="https://gravatar.com">Gravatar</a>.');
        $wpdb->insert($wpdb->comments, array('comment_post_ID' => 1, 'comment_author' => $first_comment_author, 'comment_author_email' => $first_comment_email, 'comment_author_url' => $first_comment_url, 'comment_date' => $now, 'comment_date_gmt' => $now_gmt, 'comment_content' => $first_comment, 'comment_type' => 'comment'));
        // First page.
        if (is_multisite()) {
            $first_page = get_site_option('first_page');
        }
        if (empty($first_page)) {
            $first_page = "<!-- wp:paragraph -->\n<p>";
            /* translators: First page content. */
            $first_page .= __("This is an example page. It's different from a blog post because it will stay in one place and will show up in your site navigation (in most themes). Most people start with an About page that introduces them to potential site visitors. It might say something like this:");
            $first_page .= "</p>\n<!-- /wp:paragraph -->\n\n";
            $first_page .= "<!-- wp:quote -->\n<blockquote class=\"wp-block-quote\"><p>";
            /* translators: First page content. */
            $first_page .= __("Hi there! I'm a bike messenger by day, aspiring actor by night, and this is my website. I live in Los Angeles, have a great dog named Jack, and I like pi&#241;a coladas. (And gettin' caught in the rain.)");
            $first_page .= "</p></blockquote>\n<!-- /wp:quote -->\n\n";
            $first_page .= "<!-- wp:paragraph -->\n<p>";
            /* translators: First page content. */
            $first_page .= __('...or something like this:');
            $first_page .= "</p>\n<!-- /wp:paragraph -->\n\n";
            $first_page .= "<!-- wp:quote -->\n<blockquote class=\"wp-block-quote\"><p>";
            /* translators: First page content. */
            $first_page .= __('The XYZ Doohickey Company was founded in 1971, and has been providing quality doohickeys to the public ever since. Located in Gotham City, XYZ employs over 2,000 people and does all kinds of awesome things for the Gotham community.');
            $first_page .= "</p></blockquote>\n<!-- /wp:quote -->\n\n";
            $first_page .= "<!-- wp:paragraph -->\n<p>";
            $first_page .= sprintf(
                /* translators: First page content. %s: Site admin URL. */
                __('As a new WordPress user, you should go to <a href="%s">your dashboard</a> to delete this page and create new pages for your content. Have fun!'),
                admin_url()
            );
            $first_page .= "</p>\n<!-- /wp:paragraph -->";
        }
        $first_post_guid = get_option('home') . '/?page_id=2';
        $wpdb->insert($wpdb->posts, array(
            'post_author' => $user_id,
            'post_date' => $now,
            'post_date_gmt' => $now_gmt,
            'post_content' => $first_page,
            'post_excerpt' => '',
            'comment_status' => 'closed',
            'post_title' => __('Sample Page'),
            /* translators: Default page slug. */
            'post_name' => __('sample-page'),
            'post_modified' => $now,
            'post_modified_gmt' => $now_gmt,
            'guid' => $first_post_guid,
            'post_type' => 'page',
            'to_ping' => '',
            'pinged' => '',
            'post_content_filtered' => '',
        ));
        $wpdb->insert($wpdb->postmeta, array('post_id' => 2, 'meta_key' => '_wp_page_template', 'meta_value' => 'default'));
        // Privacy Policy page.
        if (is_multisite()) {
            // Disable by default unless the suggested content is provided.
            $privacy_policy_content = get_site_option('default_privacy_policy_content');
        } else {
            if (!class_exists('WP_Privacy_Policy_Content')) {
                include_once ABSPATH . 'wp-admin/includes/class-wp-privacy-policy-content.php';
            }
            $privacy_policy_content = WP_Privacy_Policy_Content::get_default_content();
        }
        if (!empty($privacy_policy_content)) {
            $privacy_policy_guid = get_option('home') . '/?page_id=3';
            $wpdb->insert($wpdb->posts, array(
                'post_author' => $user_id,
                'post_date' => $now,
                'post_date_gmt' => $now_gmt,
                'post_content' => $privacy_policy_content,
                'post_excerpt' => '',
                'comment_status' => 'closed',
                'post_title' => __('Privacy Policy'),
                /* translators: Privacy Policy page slug. */
                'post_name' => __('privacy-policy'),
                'post_modified' => $now,
                'post_modified_gmt' => $now_gmt,
                'guid' => $privacy_policy_guid,
                'post_type' => 'page',
                'post_status' => 'draft',
                'to_ping' => '',
                'pinged' => '',
                'post_content_filtered' => '',
            ));
            $wpdb->insert($wpdb->postmeta, array('post_id' => 3, 'meta_key' => '_wp_page_template', 'meta_value' => 'default'));
            update_option('wp_page_for_privacy_policy', 3);
        }
        // Set up default widgets for default theme.
        update_option('widget_search', array(2 => array('title' => ''), '_multiwidget' => 1));
        update_option('widget_recent-posts', array(2 => array('title' => '', 'number' => 5), '_multiwidget' => 1));
        update_option('widget_recent-comments', array(2 => array('title' => '', 'number' => 5), '_multiwidget' => 1));
        update_option('widget_archives', array(2 => array('title' => '', 'count' => 0, 'dropdown' => 0), '_multiwidget' => 1));
        update_option('widget_categories', array(2 => array('title' => '', 'count' => 0, 'hierarchical' => 0, 'dropdown' => 0), '_multiwidget' => 1));
        update_option('widget_meta', array(2 => array('title' => ''), '_multiwidget' => 1));
        update_option('sidebars_widgets', array('wp_inactive_widgets' => array(), 'sidebar-1' => array(0 => 'search-2', 1 => 'recent-posts-2', 2 => 'recent-comments-2'), 'sidebar-2' => array(0 => 'archives-2', 1 => 'categories-2', 2 => 'meta-2'), 'array_version' => 3));
        if (!is_multisite()) {
            update_user_meta($user_id, 'show_welcome_panel', 1);
        } elseif (!is_super_admin($user_id) && !metadata_exists('user', $user_id, 'show_welcome_panel')) {
            update_user_meta($user_id, 'show_welcome_panel', 2);
        }
        if (is_multisite()) {
            // Flush rules to pick up the new page.
            $wp_rewrite->init();
            $wp_rewrite->flush_rules();
            $user = new WP_User($user_id);
            $wpdb->update($wpdb->options, array('option_value' => $user->user_email), array('option_name' => 'admin_email'));
            // Remove all perms except for the login user.
            $wpdb->query($wpdb->prepare("DELETE FROM {$wpdb->usermeta} WHERE user_id != %d AND meta_key = %s", $user_id, $table_prefix . 'user_level'));
            $wpdb->query($wpdb->prepare("DELETE FROM {$wpdb->usermeta} WHERE user_id != %d AND meta_key = %s", $user_id, $table_prefix . 'capabilities'));
            // Delete any caps that snuck into the previously active blog. (Hardcoded to blog 1 for now.)
            // TODO: Get previous_blog_id.
            if (!is_super_admin($user_id) && 1 != $user_id) {
                $wpdb->delete($wpdb->usermeta, array('user_id' => $user_id, 'meta_key' => $wpdb->base_prefix . '1_capabilities'));
            }
        }
    }
}
/**
 * Maybe enable pretty permalinks on installation.
 *
 * If after enabling pretty permalinks don't work, fallback to query-string permalinks.
 *
 * @since 4.2.0
 *
 * @global WP_Rewrite $wp_rewrite WordPress rewrite component.
 *
 * @return bool Whether pretty permalinks are enabled. False otherwise.
 */
function wp_install_maybe_enable_pretty_permalinks()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_install_maybe_enable_pretty_permalinks") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php at line 322")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_install_maybe_enable_pretty_permalinks:322@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php');
    die();
}
if (!function_exists('wp_new_blog_notification')) {
    /**
     * Notifies the site admin that the installation of WordPress is complete.
     *
     * Sends an email to the new administrator that the installation is complete
     * and provides them with a record of their login credentials.
     *
     * @since 2.1.0
     *
     * @param string $blog_title Site title.
     * @param string $blog_url   Site URL.
     * @param int    $user_id    Administrator's user ID.
     * @param string $password   Administrator's password. Note that a placeholder message is
     *                           usually passed instead of the actual password.
     */
    function wp_new_blog_notification($blog_title, $blog_url, $user_id, $password)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_new_blog_notification") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php at line 388")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_new_blog_notification:388@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php');
        die();
    }
}
if (!function_exists('wp_upgrade')) {
    /**
     * Runs WordPress Upgrade functions.
     *
     * Upgrades the database if needed during a site update.
     *
     * @since 2.1.0
     *
     * @global int  $wp_current_db_version The old (current) database version.
     * @global int  $wp_db_version         The new database version.
     * @global wpdb $wpdb                  WordPress database abstraction object.
     */
    function wp_upgrade()
    {
        global $wp_current_db_version, $wp_db_version, $wpdb;
        $wp_current_db_version = __get_option('db_version');
        // We are up to date. Nothing to do.
        if ($wp_db_version == $wp_current_db_version) {
            return;
        }
        if (!is_blog_installed()) {
            return;
        }
        wp_check_mysql_version();
        wp_cache_flush();
        pre_schema_upgrade();
        make_db_current_silent();
        upgrade_all();
        if (is_multisite() && is_main_site()) {
            upgrade_network();
        }
        wp_cache_flush();
        if (is_multisite()) {
            update_site_meta(get_current_blog_id(), 'db_version', $wp_db_version);
            update_site_meta(get_current_blog_id(), 'db_last_updated', microtime());
        }
        /**
         * Fires after a site is fully upgraded.
         *
         * @since 3.9.0
         *
         * @param int $wp_db_version         The new $wp_db_version.
         * @param int $wp_current_db_version The old (current) $wp_db_version.
         */
        do_action('wp_upgrade', $wp_db_version, $wp_current_db_version);
    }
}
/**
 * Functions to be called in installation and upgrade scripts.
 *
 * Contains conditional checks to determine which upgrade scripts to run,
 * based on database version and WP version being updated-to.
 *
 * @ignore
 * @since 1.0.1
 *
 * @global int $wp_current_db_version The old (current) database version.
 * @global int $wp_db_version         The new database version.
 */
function upgrade_all()
{
    global $wp_current_db_version, $wp_db_version;
    $wp_current_db_version = __get_option('db_version');
    // We are up to date. Nothing to do.
    if ($wp_db_version == $wp_current_db_version) {
        return;
    }
    // If the version is not set in the DB, try to guess the version.
    if (empty($wp_current_db_version)) {
        $wp_current_db_version = 0;
        // If the template option exists, we have 1.5.
        $template = __get_option('template');
        if (!empty($template)) {
            $wp_current_db_version = 2541;
        }
    }
    if ($wp_current_db_version < 6039) {
        upgrade_230_options_table();
    }
    populate_options();
    if ($wp_current_db_version < 2541) {
        upgrade_100();
        upgrade_101();
        upgrade_110();
        upgrade_130();
    }
    if ($wp_current_db_version < 3308) {
        upgrade_160();
    }
    if ($wp_current_db_version < 4772) {
        upgrade_210();
    }
    if ($wp_current_db_version < 4351) {
        upgrade_old_slugs();
    }
    if ($wp_current_db_version < 5539) {
        upgrade_230();
    }
    if ($wp_current_db_version < 6124) {
        upgrade_230_old_tables();
    }
    if ($wp_current_db_version < 7499) {
        upgrade_250();
    }
    if ($wp_current_db_version < 7935) {
        upgrade_252();
    }
    if ($wp_current_db_version < 8201) {
        upgrade_260();
    }
    if ($wp_current_db_version < 8989) {
        upgrade_270();
    }
    if ($wp_current_db_version < 10360) {
        upgrade_280();
    }
    if ($wp_current_db_version < 11958) {
        upgrade_290();
    }
    if ($wp_current_db_version < 15260) {
        upgrade_300();
    }
    if ($wp_current_db_version < 19389) {
        upgrade_330();
    }
    if ($wp_current_db_version < 20080) {
        upgrade_340();
    }
    if ($wp_current_db_version < 22422) {
        upgrade_350();
    }
    if ($wp_current_db_version < 25824) {
        upgrade_370();
    }
    if ($wp_current_db_version < 26148) {
        upgrade_372();
    }
    if ($wp_current_db_version < 26691) {
        upgrade_380();
    }
    if ($wp_current_db_version < 29630) {
        upgrade_400();
    }
    if ($wp_current_db_version < 33055) {
        upgrade_430();
    }
    if ($wp_current_db_version < 33056) {
        upgrade_431();
    }
    if ($wp_current_db_version < 35700) {
        upgrade_440();
    }
    if ($wp_current_db_version < 36686) {
        upgrade_450();
    }
    if ($wp_current_db_version < 37965) {
        upgrade_460();
    }
    if ($wp_current_db_version < 44719) {
        upgrade_510();
    }
    if ($wp_current_db_version < 45744) {
        upgrade_530();
    }
    if ($wp_current_db_version < 48575) {
        upgrade_550();
    }
    if ($wp_current_db_version < 49752) {
        upgrade_560();
    }
    maybe_disable_link_manager();
    maybe_disable_automattic_widgets();
    update_option('db_version', $wp_db_version);
    update_option('db_upgraded', true);
}
/**
 * Execute changes made in WordPress 1.0.
 *
 * @ignore
 * @since 1.0.0
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 */
function upgrade_100()
{
    global $wpdb;
    // Get the title and ID of every post, post_name to check if it already has a value.
    $posts = $wpdb->get_results("SELECT ID, post_title, post_name FROM {$wpdb->posts} WHERE post_name = ''");
    if ($posts) {
        foreach ($posts as $post) {
            if ('' === $post->post_name) {
                $newtitle = sanitize_title($post->post_title);
                $wpdb->query($wpdb->prepare("UPDATE {$wpdb->posts} SET post_name = %s WHERE ID = %d", $newtitle, $post->ID));
            }
        }
    }
    $categories = $wpdb->get_results("SELECT cat_ID, cat_name, category_nicename FROM {$wpdb->categories}");
    foreach ($categories as $category) {
        if ('' === $category->category_nicename) {
            $newtitle = sanitize_title($category->cat_name);
            $wpdb->update($wpdb->categories, array('category_nicename' => $newtitle), array('cat_ID' => $category->cat_ID));
        }
    }
    $sql = "UPDATE {$wpdb->options}\n\t\tSET option_value = REPLACE(option_value, 'wp-links/links-images/', 'wp-images/links/')\n\t\tWHERE option_name LIKE %s\n\t\tAND option_value LIKE %s";
    $wpdb->query($wpdb->prepare($sql, $wpdb->esc_like('links_rating_image') . '%', $wpdb->esc_like('wp-links/links-images/') . '%'));
    $done_ids = $wpdb->get_results("SELECT DISTINCT post_id FROM {$wpdb->post2cat}");
    if ($done_ids) {
        $done_posts = array();
        foreach ($done_ids as $done_id) {
            $done_posts[] = $done_id->post_id;
        }
        $catwhere = ' AND ID NOT IN (' . implode(',', $done_posts) . ')';
    } else {
        $catwhere = '';
    }
    $allposts = $wpdb->get_results("SELECT ID, post_category FROM {$wpdb->posts} WHERE post_category != '0' {$catwhere}");
    if ($allposts) {
        foreach ($allposts as $post) {
            // Check to see if it's already been imported.
            $cat = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->post2cat} WHERE post_id = %d AND category_id = %d", $post->ID, $post->post_category));
            if (!$cat && 0 != $post->post_category) {
                // If there's no result.
                $wpdb->insert($wpdb->post2cat, array('post_id' => $post->ID, 'category_id' => $post->post_category));
            }
        }
    }
}
/**
 * Execute changes made in WordPress 1.0.1.
 *
 * @ignore
 * @since 1.0.1
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 */
function upgrade_101()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("upgrade_101") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php at line 675")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called upgrade_101:675@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php');
    die();
}
/**
 * Execute changes made in WordPress 1.2.
 *
 * @ignore
 * @since 1.2.0
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 */
function upgrade_110()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("upgrade_110") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php at line 695")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called upgrade_110:695@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php');
    die();
}
/**
 * Execute changes made in WordPress 1.5.
 *
 * @ignore
 * @since 1.5.0
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 */
function upgrade_130()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("upgrade_130") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php at line 749")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called upgrade_130:749@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php');
    die();
}
/**
 * Execute changes made in WordPress 2.0.
 *
 * @ignore
 * @since 2.0.0
 *
 * @global wpdb $wpdb                  WordPress database abstraction object.
 * @global int  $wp_current_db_version The old (current) database version.
 */
function upgrade_160()
{
    global $wpdb, $wp_current_db_version;
    populate_roles_160();
    $users = $wpdb->get_results("SELECT * FROM {$wpdb->users}");
    foreach ($users as $user) {
        if (!empty($user->user_firstname)) {
            update_user_meta($user->ID, 'first_name', wp_slash($user->user_firstname));
        }
        if (!empty($user->user_lastname)) {
            update_user_meta($user->ID, 'last_name', wp_slash($user->user_lastname));
        }
        if (!empty($user->user_nickname)) {
            update_user_meta($user->ID, 'nickname', wp_slash($user->user_nickname));
        }
        if (!empty($user->user_level)) {
            update_user_meta($user->ID, $wpdb->prefix . 'user_level', $user->user_level);
        }
        if (!empty($user->user_icq)) {
            update_user_meta($user->ID, 'icq', wp_slash($user->user_icq));
        }
        if (!empty($user->user_aim)) {
            update_user_meta($user->ID, 'aim', wp_slash($user->user_aim));
        }
        if (!empty($user->user_msn)) {
            update_user_meta($user->ID, 'msn', wp_slash($user->user_msn));
        }
        if (!empty($user->user_yim)) {
            update_user_meta($user->ID, 'yim', wp_slash($user->user_icq));
        }
        if (!empty($user->user_description)) {
            update_user_meta($user->ID, 'description', wp_slash($user->user_description));
        }
        if (isset($user->user_idmode)) {
            $idmode = $user->user_idmode;
            if ('nickname' === $idmode) {
                $id = $user->user_nickname;
            }
            if ('login' === $idmode) {
                $id = $user->user_login;
            }
            if ('firstname' === $idmode) {
                $id = $user->user_firstname;
            }
            if ('lastname' === $idmode) {
                $id = $user->user_lastname;
            }
            if ('namefl' === $idmode) {
                $id = $user->user_firstname . ' ' . $user->user_lastname;
            }
            if ('namelf' === $idmode) {
                $id = $user->user_lastname . ' ' . $user->user_firstname;
            }
            if (!$idmode) {
                $id = $user->user_nickname;
            }
            $wpdb->update($wpdb->users, array('display_name' => $id), array('ID' => $user->ID));
        }
        // FIXME: RESET_CAPS is temporary code to reset roles and caps if flag is set.
        $caps = get_user_meta($user->ID, $wpdb->prefix . 'capabilities');
        if (empty($caps) || defined('RESET_CAPS')) {
            $level = get_user_meta($user->ID, $wpdb->prefix . 'user_level', true);
            $role = translate_level_to_role($level);
            update_user_meta($user->ID, $wpdb->prefix . 'capabilities', array($role => true));
        }
    }
    $old_user_fields = array('user_firstname', 'user_lastname', 'user_icq', 'user_aim', 'user_msn', 'user_yim', 'user_idmode', 'user_ip', 'user_domain', 'user_browser', 'user_description', 'user_nickname', 'user_level');
    $wpdb->hide_errors();
    foreach ($old_user_fields as $old) {
        $wpdb->query("ALTER TABLE {$wpdb->users} DROP {$old}");
    }
    $wpdb->show_errors();
    // Populate comment_count field of posts table.
    $comments = $wpdb->get_results("SELECT comment_post_ID, COUNT(*) as c FROM {$wpdb->comments} WHERE comment_approved = '1' GROUP BY comment_post_ID");
    if (is_array($comments)) {
        foreach ($comments as $comment) {
            $wpdb->update($wpdb->posts, array('comment_count' => $comment->c), array('ID' => $comment->comment_post_ID));
        }
    }
    /*
     * Some alpha versions used a post status of object instead of attachment
     * and put the mime type in post_type instead of post_mime_type.
     */
    if ($wp_current_db_version > 2541 && $wp_current_db_version <= 3091) {
        $objects = $wpdb->get_results("SELECT ID, post_type FROM {$wpdb->posts} WHERE post_status = 'object'");
        foreach ($objects as $object) {
            $wpdb->update($wpdb->posts, array('post_status' => 'attachment', 'post_mime_type' => $object->post_type, 'post_type' => ''), array('ID' => $object->ID));
            $meta = get_post_meta($object->ID, 'imagedata', true);
            if (!empty($meta['file'])) {
                update_attached_file($object->ID, $meta['file']);
            }
        }
    }
}
/**
 * Execute changes made in WordPress 2.1.
 *
 * @ignore
 * @since 2.1.0
 *
 * @global int  $wp_current_db_version The old (current) database version.
 * @global wpdb $wpdb                  WordPress database abstraction object.
 */
function upgrade_210()
{
    global $wp_current_db_version, $wpdb;
    if ($wp_current_db_version < 3506) {
        // Update status and type.
        $posts = $wpdb->get_results("SELECT ID, post_status FROM {$wpdb->posts}");
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $status = $post->post_status;
                $type = 'post';
                if ('static' === $status) {
                    $status = 'publish';
                    $type = 'page';
                } elseif ('attachment' === $status) {
                    $status = 'inherit';
                    $type = 'attachment';
                }
                $wpdb->query($wpdb->prepare("UPDATE {$wpdb->posts} SET post_status = %s, post_type = %s WHERE ID = %d", $status, $type, $post->ID));
            }
        }
    }
    if ($wp_current_db_version < 3845) {
        populate_roles_210();
    }
    if ($wp_current_db_version < 3531) {
        // Give future posts a post_status of future.
        $now = gmdate('Y-m-d H:i:59');
        $wpdb->query("UPDATE {$wpdb->posts} SET post_status = 'future' WHERE post_status = 'publish' AND post_date_gmt > '{$now}'");
        $posts = $wpdb->get_results("SELECT ID, post_date FROM {$wpdb->posts} WHERE post_status ='future'");
        if (!empty($posts)) {
            foreach ($posts as $post) {
                wp_schedule_single_event(mysql2date('U', $post->post_date, false), 'publish_future_post', array($post->ID));
            }
        }
    }
}
/**
 * Execute changes made in WordPress 2.3.
 *
 * @ignore
 * @since 2.3.0
 *
 * @global int  $wp_current_db_version The old (current) database version.
 * @global wpdb $wpdb                  WordPress database abstraction object.
 */
function upgrade_230()
{
    global $wp_current_db_version, $wpdb;
    if ($wp_current_db_version < 5200) {
        populate_roles_230();
    }
    // Convert categories to terms.
    $tt_ids = array();
    $have_tags = false;
    $categories = $wpdb->get_results("SELECT * FROM {$wpdb->categories} ORDER BY cat_ID");
    foreach ($categories as $category) {
        $term_id = (int) $category->cat_ID;
        $name = $category->cat_name;
        $description = $category->category_description;
        $slug = $category->category_nicename;
        $parent = $category->category_parent;
        $term_group = 0;
        // Associate terms with the same slug in a term group and make slugs unique.
        $exists = $wpdb->get_results($wpdb->prepare("SELECT term_id, term_group FROM {$wpdb->terms} WHERE slug = %s", $slug));
        if ($exists) {
            $term_group = $exists[0]->term_group;
            $id = $exists[0]->term_id;
            $num = 2;
            do {
                $alt_slug = $slug . "-{$num}";
                $num++;
                $slug_check = $wpdb->get_var($wpdb->prepare("SELECT slug FROM {$wpdb->terms} WHERE slug = %s", $alt_slug));
            } while ($slug_check);
            $slug = $alt_slug;
            if (empty($term_group)) {
                $term_group = $wpdb->get_var("SELECT MAX(term_group) FROM {$wpdb->terms} GROUP BY term_group") + 1;
                $wpdb->query($wpdb->prepare("UPDATE {$wpdb->terms} SET term_group = %d WHERE term_id = %d", $term_group, $id));
            }
        }
        $wpdb->query($wpdb->prepare("INSERT INTO {$wpdb->terms} (term_id, name, slug, term_group) VALUES\n\t\t(%d, %s, %s, %d)", $term_id, $name, $slug, $term_group));
        $count = 0;
        if (!empty($category->category_count)) {
            $count = (int) $category->category_count;
            $taxonomy = 'category';
            $wpdb->query($wpdb->prepare("INSERT INTO {$wpdb->term_taxonomy} (term_id, taxonomy, description, parent, count) VALUES ( %d, %s, %s, %d, %d)", $term_id, $taxonomy, $description, $parent, $count));
            $tt_ids[$term_id][$taxonomy] = (int) $wpdb->insert_id;
        }
        if (!empty($category->link_count)) {
            $count = (int) $category->link_count;
            $taxonomy = 'link_category';
            $wpdb->query($wpdb->prepare("INSERT INTO {$wpdb->term_taxonomy} (term_id, taxonomy, description, parent, count) VALUES ( %d, %s, %s, %d, %d)", $term_id, $taxonomy, $description, $parent, $count));
            $tt_ids[$term_id][$taxonomy] = (int) $wpdb->insert_id;
        }
        if (!empty($category->tag_count)) {
            $have_tags = true;
            $count = (int) $category->tag_count;
            $taxonomy = 'post_tag';
            $wpdb->insert($wpdb->term_taxonomy, compact('term_id', 'taxonomy', 'description', 'parent', 'count'));
            $tt_ids[$term_id][$taxonomy] = (int) $wpdb->insert_id;
        }
        if (empty($count)) {
            $count = 0;
            $taxonomy = 'category';
            $wpdb->insert($wpdb->term_taxonomy, compact('term_id', 'taxonomy', 'description', 'parent', 'count'));
            $tt_ids[$term_id][$taxonomy] = (int) $wpdb->insert_id;
        }
    }
    $select = 'post_id, category_id';
    if ($have_tags) {
        $select .= ', rel_type';
    }
    $posts = $wpdb->get_results("SELECT {$select} FROM {$wpdb->post2cat} GROUP BY post_id, category_id");
    foreach ($posts as $post) {
        $post_id = (int) $post->post_id;
        $term_id = (int) $post->category_id;
        $taxonomy = 'category';
        if (!empty($post->rel_type) && 'tag' === $post->rel_type) {
            $taxonomy = 'tag';
        }
        $tt_id = $tt_ids[$term_id][$taxonomy];
        if (empty($tt_id)) {
            continue;
        }
        $wpdb->insert($wpdb->term_relationships, array('object_id' => $post_id, 'term_taxonomy_id' => $tt_id));
    }
    // < 3570 we used linkcategories. >= 3570 we used categories and link2cat.
    if ($wp_current_db_version < 3570) {
        /*
         * Create link_category terms for link categories. Create a map of link
         * category IDs to link_category terms.
         */
        $link_cat_id_map = array();
        $default_link_cat = 0;
        $tt_ids = array();
        $link_cats = $wpdb->get_results('SELECT cat_id, cat_name FROM ' . $wpdb->prefix . 'linkcategories');
        foreach ($link_cats as $category) {
            $cat_id = (int) $category->cat_id;
            $term_id = 0;
            $name = wp_slash($category->cat_name);
            $slug = sanitize_title($name);
            $term_group = 0;
            // Associate terms with the same slug in a term group and make slugs unique.
            $exists = $wpdb->get_results($wpdb->prepare("SELECT term_id, term_group FROM {$wpdb->terms} WHERE slug = %s", $slug));
            if ($exists) {
                $term_group = $exists[0]->term_group;
                $term_id = $exists[0]->term_id;
            }
            if (empty($term_id)) {
                $wpdb->insert($wpdb->terms, compact('name', 'slug', 'term_group'));
                $term_id = (int) $wpdb->insert_id;
            }
            $link_cat_id_map[$cat_id] = $term_id;
            $default_link_cat = $term_id;
            $wpdb->insert($wpdb->term_taxonomy, array('term_id' => $term_id, 'taxonomy' => 'link_category', 'description' => '', 'parent' => 0, 'count' => 0));
            $tt_ids[$term_id] = (int) $wpdb->insert_id;
        }
        // Associate links to categories.
        $links = $wpdb->get_results("SELECT link_id, link_category FROM {$wpdb->links}");
        if (!empty($links)) {
            foreach ($links as $link) {
                if (0 == $link->link_category) {
                    continue;
                }
                if (!isset($link_cat_id_map[$link->link_category])) {
                    continue;
                }
                $term_id = $link_cat_id_map[$link->link_category];
                $tt_id = $tt_ids[$term_id];
                if (empty($tt_id)) {
                    continue;
                }
                $wpdb->insert($wpdb->term_relationships, array('object_id' => $link->link_id, 'term_taxonomy_id' => $tt_id));
            }
        }
        // Set default to the last category we grabbed during the upgrade loop.
        update_option('default_link_category', $default_link_cat);
    } else {
        $links = $wpdb->get_results("SELECT link_id, category_id FROM {$wpdb->link2cat} GROUP BY link_id, category_id");
        foreach ($links as $link) {
            $link_id = (int) $link->link_id;
            $term_id = (int) $link->category_id;
            $taxonomy = 'link_category';
            $tt_id = $tt_ids[$term_id][$taxonomy];
            if (empty($tt_id)) {
                continue;
            }
            $wpdb->insert($wpdb->term_relationships, array('object_id' => $link_id, 'term_taxonomy_id' => $tt_id));
        }
    }
    if ($wp_current_db_version < 4772) {
        // Obsolete linkcategories table.
        $wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'linkcategories');
    }
    // Recalculate all counts.
    $terms = $wpdb->get_results("SELECT term_taxonomy_id, taxonomy FROM {$wpdb->term_taxonomy}");
    foreach ((array) $terms as $term) {
        if ('post_tag' === $term->taxonomy || 'category' === $term->taxonomy) {
            $count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->term_relationships}, {$wpdb->posts} WHERE {$wpdb->posts}.ID = {$wpdb->term_relationships}.object_id AND post_status = 'publish' AND post_type = 'post' AND term_taxonomy_id = %d", $term->term_taxonomy_id));
        } else {
            $count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->term_relationships} WHERE term_taxonomy_id = %d", $term->term_taxonomy_id));
        }
        $wpdb->update($wpdb->term_taxonomy, array('count' => $count), array('term_taxonomy_id' => $term->term_taxonomy_id));
    }
}
/**
 * Remove old options from the database.
 *
 * @ignore
 * @since 2.3.0
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 */
function upgrade_230_options_table()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("upgrade_230_options_table") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php at line 1141")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called upgrade_230_options_table:1141@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php');
    die();
}
/**
 * Remove old categories, link2cat, and post2cat database tables.
 *
 * @ignore
 * @since 2.3.0
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 */
function upgrade_230_old_tables()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("upgrade_230_old_tables") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php at line 1159")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called upgrade_230_old_tables:1159@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php');
    die();
}
/**
 * Upgrade old slugs made in version 2.2.
 *
 * @ignore
 * @since 2.2.0
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 */
function upgrade_old_slugs()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("upgrade_old_slugs") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php at line 1175")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called upgrade_old_slugs:1175@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php');
    die();
}
/**
 * Execute changes made in WordPress 2.5.0.
 *
 * @ignore
 * @since 2.5.0
 *
 * @global int $wp_current_db_version The old (current) database version.
 */
function upgrade_250()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("upgrade_250") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php at line 1188")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called upgrade_250:1188@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php');
    die();
}
/**
 * Execute changes made in WordPress 2.5.2.
 *
 * @ignore
 * @since 2.5.2
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 */
function upgrade_252()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("upgrade_252") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php at line 1203")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called upgrade_252:1203@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php');
    die();
}
/**
 * Execute changes made in WordPress 2.6.
 *
 * @ignore
 * @since 2.6.0
 *
 * @global int $wp_current_db_version The old (current) database version.
 */
function upgrade_260()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("upgrade_260") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php at line 1216")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called upgrade_260:1216@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php');
    die();
}
/**
 * Execute changes made in WordPress 2.7.
 *
 * @ignore
 * @since 2.7.0
 *
 * @global int  $wp_current_db_version The old (current) database version.
 * @global wpdb $wpdb                  WordPress database abstraction object.
 */
function upgrade_270()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("upgrade_270") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php at line 1232")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called upgrade_270:1232@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php');
    die();
}
/**
 * Execute changes made in WordPress 2.8.
 *
 * @ignore
 * @since 2.8.0
 *
 * @global int  $wp_current_db_version The old (current) database version.
 * @global wpdb $wpdb                  WordPress database abstraction object.
 */
function upgrade_280()
{
    global $wp_current_db_version, $wpdb;
    if ($wp_current_db_version < 10360) {
        populate_roles_280();
    }
    if (is_multisite()) {
        $start = 0;
        while ($rows = $wpdb->get_results("SELECT option_name, option_value FROM {$wpdb->options} ORDER BY option_id LIMIT {$start}, 20")) {
            foreach ($rows as $row) {
                $value = $row->option_value;
                if (!@unserialize($value)) {
                    $value = stripslashes($value);
                }
                if ($value !== $row->option_value) {
                    update_option($row->option_name, $value);
                }
            }
            $start += 20;
        }
        clean_blog_cache(get_current_blog_id());
    }
}
/**
 * Execute changes made in WordPress 2.9.
 *
 * @ignore
 * @since 2.9.0
 *
 * @global int $wp_current_db_version The old (current) database version.
 */
function upgrade_290()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("upgrade_290") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php at line 1283")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called upgrade_290:1283@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php');
    die();
}
/**
 * Execute changes made in WordPress 3.0.
 *
 * @ignore
 * @since 3.0.0
 *
 * @global int  $wp_current_db_version The old (current) database version.
 * @global wpdb $wpdb                  WordPress database abstraction object.
 */
function upgrade_300()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("upgrade_300") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php at line 1304")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called upgrade_300:1304@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php');
    die();
}
/**
 * Execute changes made in WordPress 3.3.
 *
 * @ignore
 * @since 3.3.0
 *
 * @global int   $wp_current_db_version The old (current) database version.
 * @global wpdb  $wpdb                  WordPress database abstraction object.
 * @global array $wp_registered_widgets
 * @global array $sidebars_widgets
 */
function upgrade_330()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("upgrade_330") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php at line 1331")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called upgrade_330:1331@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php');
    die();
}
/**
 * Execute changes made in WordPress 3.4.
 *
 * @ignore
 * @since 3.4.0
 *
 * @global int  $wp_current_db_version The old (current) database version.
 * @global wpdb $wpdb                  WordPress database abstraction object.
 */
function upgrade_340()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("upgrade_340") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php at line 1400")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called upgrade_340:1400@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php');
    die();
}
/**
 * Execute changes made in WordPress 3.5.
 *
 * @ignore
 * @since 3.5.0
 *
 * @global int  $wp_current_db_version The old (current) database version.
 * @global wpdb $wpdb                  WordPress database abstraction object.
 */
function upgrade_350()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("upgrade_350") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php at line 1433")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called upgrade_350:1433@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php');
    die();
}
/**
 * Execute changes made in WordPress 3.7.
 *
 * @ignore
 * @since 3.7.0
 *
 * @global int $wp_current_db_version The old (current) database version.
 */
function upgrade_370()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("upgrade_370") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php at line 1467")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called upgrade_370:1467@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php');
    die();
}
/**
 * Execute changes made in WordPress 3.7.2.
 *
 * @ignore
 * @since 3.7.2
 * @since 3.8.0
 *
 * @global int $wp_current_db_version The old (current) database version.
 */
function upgrade_372()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("upgrade_372") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php at line 1483")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called upgrade_372:1483@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php');
    die();
}
/**
 * Execute changes made in WordPress 3.8.0.
 *
 * @ignore
 * @since 3.8.0
 *
 * @global int $wp_current_db_version The old (current) database version.
 */
function upgrade_380()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("upgrade_380") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php at line 1498")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called upgrade_380:1498@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php');
    die();
}
/**
 * Execute changes made in WordPress 4.0.0.
 *
 * @ignore
 * @since 4.0.0
 *
 * @global int $wp_current_db_version The old (current) database version.
 */
function upgrade_400()
{
    global $wp_current_db_version;
    if ($wp_current_db_version < 29630) {
        if (!is_multisite() && false === get_option('WPLANG')) {
            if (defined('WPLANG') && '' !== WPLANG && in_array(WPLANG, get_available_languages(), true)) {
                update_option('WPLANG', WPLANG);
            } else {
                update_option('WPLANG', '');
            }
        }
    }
}
/**
 * Execute changes made in WordPress 4.2.0.
 *
 * @ignore
 * @since 4.2.0
 */
function upgrade_420()
{
}
/**
 * Executes changes made in WordPress 4.3.0.
 *
 * @ignore
 * @since 4.3.0
 *
 * @global int  $wp_current_db_version The old (current) database version.
 * @global wpdb $wpdb                  WordPress database abstraction object.
 */
function upgrade_430()
{
    global $wp_current_db_version, $wpdb;
    if ($wp_current_db_version < 32364) {
        upgrade_430_fix_comments();
    }
    // Shared terms are split in a separate process.
    if ($wp_current_db_version < 32814) {
        update_option('finished_splitting_shared_terms', 0);
        wp_schedule_single_event(time() + 1 * MINUTE_IN_SECONDS, 'wp_split_shared_term_batch');
    }
    if ($wp_current_db_version < 33055 && 'utf8mb4' === $wpdb->charset) {
        if (is_multisite()) {
            $tables = $wpdb->tables('blog');
        } else {
            $tables = $wpdb->tables('all');
            if (!wp_should_upgrade_global_tables()) {
                $global_tables = $wpdb->tables('global');
                $tables = array_diff_assoc($tables, $global_tables);
            }
        }
        foreach ($tables as $table) {
            maybe_convert_table_to_utf8mb4($table);
        }
    }
}
/**
 * Executes comments changes made in WordPress 4.3.0.
 *
 * @ignore
 * @since 4.3.0
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 */
function upgrade_430_fix_comments()
{
    global $wpdb;
    $content_length = $wpdb->get_col_length($wpdb->comments, 'comment_content');
    if (is_wp_error($content_length)) {
        return;
    }
    if (false === $content_length) {
        $content_length = array('type' => 'byte', 'length' => 65535);
    } elseif (!is_array($content_length)) {
        $length = (int) $content_length > 0 ? (int) $content_length : 65535;
        $content_length = array('type' => 'byte', 'length' => $length);
    }
    if ('byte' !== $content_length['type'] || 0 === $content_length['length']) {
        // Sites with malformed DB schemas are on their own.
        return;
    }
    $allowed_length = (int) $content_length['length'] - 10;
    $comments = $wpdb->get_results("SELECT `comment_ID` FROM `{$wpdb->comments}`\n\t\t\tWHERE `comment_date_gmt` > '2015-04-26'\n\t\t\tAND LENGTH( `comment_content` ) >= {$allowed_length}\n\t\t\tAND ( `comment_content` LIKE '%<%' OR `comment_content` LIKE '%>%' )");
    foreach ($comments as $comment) {
        wp_delete_comment($comment->comment_ID, true);
    }
}
/**
 * Executes changes made in WordPress 4.3.1.
 *
 * @ignore
 * @since 4.3.1
 */
function upgrade_431()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("upgrade_431") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php at line 1608")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called upgrade_431:1608@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php');
    die();
}
/**
 * Executes changes made in WordPress 4.4.0.
 *
 * @ignore
 * @since 4.4.0
 *
 * @global int  $wp_current_db_version The old (current) database version.
 * @global wpdb $wpdb                  WordPress database abstraction object.
 */
function upgrade_440()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("upgrade_440") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php at line 1625")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called upgrade_440:1625@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php');
    die();
}
/**
 * Executes changes made in WordPress 4.5.0.
 *
 * @ignore
 * @since 4.5.0
 *
 * @global int  $wp_current_db_version The old (current) database version.
 * @global wpdb $wpdb                  WordPress database abstraction object.
 */
function upgrade_450()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("upgrade_450") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php at line 1648")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called upgrade_450:1648@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php');
    die();
}
/**
 * Executes changes made in WordPress 4.6.0.
 *
 * @ignore
 * @since 4.6.0
 *
 * @global int $wp_current_db_version The old (current) database version.
 */
function upgrade_460()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("upgrade_460") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php at line 1669")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called upgrade_460:1669@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php');
    die();
}
/**
 * Executes changes made in WordPress 5.0.0.
 *
 * @ignore
 * @since 5.0.0
 * @deprecated 5.1.0
 */
function upgrade_500()
{
}
/**
 * Executes changes made in WordPress 5.1.0.
 *
 * @ignore
 * @since 5.1.0
 */
function upgrade_510()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("upgrade_510") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php at line 1705")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called upgrade_510:1705@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php');
    die();
}
/**
 * Executes changes made in WordPress 5.3.0.
 *
 * @ignore
 * @since 5.3.0
 */
function upgrade_530()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("upgrade_530") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php at line 1722")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called upgrade_530:1722@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php');
    die();
}
/**
 * Executes changes made in WordPress 5.5.0.
 *
 * @ignore
 * @since 5.5.0
 */
function upgrade_550()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("upgrade_550") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php at line 1734")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called upgrade_550:1734@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php');
    die();
}
/**
 * Executes changes made in WordPress 5.6.0.
 *
 * @ignore
 * @since 5.6.0
 */
function upgrade_560()
{
    global $wp_current_db_version, $wpdb;
    if ($wp_current_db_version < 49572) {
        /*
         * Clean up the `post_category` column removed from schema in version 2.8.0.
         * Its presence may conflict with `WP_Post::__get()`.
         */
        $post_category_exists = $wpdb->get_var("SHOW COLUMNS FROM {$wpdb->posts} LIKE 'post_category'");
        if (!is_null($post_category_exists)) {
            $wpdb->query("ALTER TABLE {$wpdb->posts} DROP COLUMN `post_category`");
        }
        /*
         * When upgrading from WP < 5.6.0 set the core major auto-updates option to `unset` by default.
         * This overrides the same option from populate_options() that is intended for new installs.
         * See https://core.trac.wordpress.org/ticket/51742.
         */
        update_option('auto_update_core_major', 'unset');
    }
    if ($wp_current_db_version < 49632) {
        /*
         * Regenerate the .htaccess file to add the `HTTP_AUTHORIZATION` rewrite rule.
         * See https://core.trac.wordpress.org/ticket/51723.
         */
        save_mod_rewrite_rules();
    }
    if ($wp_current_db_version < 49735) {
        delete_transient('dirsize_cache');
    }
    if ($wp_current_db_version < 49752) {
        $results = $wpdb->get_results($wpdb->prepare("SELECT 1 FROM {$wpdb->usermeta} WHERE meta_key = %s LIMIT 1", WP_Application_Passwords::USERMETA_KEY_APPLICATION_PASSWORDS));
        if (!empty($results)) {
            $network_id = get_main_network_id();
            update_network_option($network_id, WP_Application_Passwords::OPTION_KEY_IN_USE, 1);
        }
    }
}
/**
 * Executes network-level upgrade routines.
 *
 * @since 3.0.0
 *
 * @global int  $wp_current_db_version The old (current) database version.
 * @global wpdb $wpdb                  WordPress database abstraction object.
 */
function upgrade_network()
{
    global $wp_current_db_version, $wpdb;
    // Always clear expired transients.
    delete_expired_transients(true);
    // 2.8.0
    if ($wp_current_db_version < 11549) {
        $wpmu_sitewide_plugins = get_site_option('wpmu_sitewide_plugins');
        $active_sitewide_plugins = get_site_option('active_sitewide_plugins');
        if ($wpmu_sitewide_plugins) {
            if (!$active_sitewide_plugins) {
                $sitewide_plugins = (array) $wpmu_sitewide_plugins;
            } else {
                $sitewide_plugins = array_merge((array) $active_sitewide_plugins, (array) $wpmu_sitewide_plugins);
            }
            update_site_option('active_sitewide_plugins', $sitewide_plugins);
        }
        delete_site_option('wpmu_sitewide_plugins');
        delete_site_option('deactivated_sitewide_plugins');
        $start = 0;
        while ($rows = $wpdb->get_results("SELECT meta_key, meta_value FROM {$wpdb->sitemeta} ORDER BY meta_id LIMIT {$start}, 20")) {
            foreach ($rows as $row) {
                $value = $row->meta_value;
                if (!@unserialize($value)) {
                    $value = stripslashes($value);
                }
                if ($value !== $row->meta_value) {
                    update_site_option($row->meta_key, $value);
                }
            }
            $start += 20;
        }
    }
    // 3.0.0
    if ($wp_current_db_version < 13576) {
        update_site_option('global_terms_enabled', '1');
    }
    // 3.3.0
    if ($wp_current_db_version < 19390) {
        update_site_option('initial_db_version', $wp_current_db_version);
    }
    if ($wp_current_db_version < 19470) {
        if (false === get_site_option('active_sitewide_plugins')) {
            update_site_option('active_sitewide_plugins', array());
        }
    }
    // 3.4.0
    if ($wp_current_db_version < 20148) {
        // 'allowedthemes' keys things by stylesheet. 'allowed_themes' keyed things by name.
        $allowedthemes = get_site_option('allowedthemes');
        $allowed_themes = get_site_option('allowed_themes');
        if (false === $allowedthemes && is_array($allowed_themes) && $allowed_themes) {
            $converted = array();
            $themes = wp_get_themes();
            foreach ($themes as $stylesheet => $theme_data) {
                if (isset($allowed_themes[$theme_data->get('Name')])) {
                    $converted[$stylesheet] = true;
                }
            }
            update_site_option('allowedthemes', $converted);
            delete_site_option('allowed_themes');
        }
    }
    // 3.5.0
    if ($wp_current_db_version < 21823) {
        update_site_option('ms_files_rewriting', '1');
    }
    // 3.5.2
    if ($wp_current_db_version < 24448) {
        $illegal_names = get_site_option('illegal_names');
        if (is_array($illegal_names) && count($illegal_names) === 1) {
            $illegal_name = reset($illegal_names);
            $illegal_names = explode(' ', $illegal_name);
            update_site_option('illegal_names', $illegal_names);
        }
    }
    // 4.2.0
    if ($wp_current_db_version < 31351 && 'utf8mb4' === $wpdb->charset) {
        if (wp_should_upgrade_global_tables()) {
            $wpdb->query("ALTER TABLE {$wpdb->usermeta} DROP INDEX meta_key, ADD INDEX meta_key(meta_key(191))");
            $wpdb->query("ALTER TABLE {$wpdb->site} DROP INDEX domain, ADD INDEX domain(domain(140),path(51))");
            $wpdb->query("ALTER TABLE {$wpdb->sitemeta} DROP INDEX meta_key, ADD INDEX meta_key(meta_key(191))");
            $wpdb->query("ALTER TABLE {$wpdb->signups} DROP INDEX domain_path, ADD INDEX domain_path(domain(140),path(51))");
            $tables = $wpdb->tables('global');
            // sitecategories may not exist.
            if (!$wpdb->get_var("SHOW TABLES LIKE '{$tables['sitecategories']}'")) {
                unset($tables['sitecategories']);
            }
            foreach ($tables as $table) {
                maybe_convert_table_to_utf8mb4($table);
            }
        }
    }
    // 4.3.0
    if ($wp_current_db_version < 33055 && 'utf8mb4' === $wpdb->charset) {
        if (wp_should_upgrade_global_tables()) {
            $upgrade = false;
            $indexes = $wpdb->get_results("SHOW INDEXES FROM {$wpdb->signups}");
            foreach ($indexes as $index) {
                if ('domain_path' === $index->Key_name && 'domain' === $index->Column_name && 140 != $index->Sub_part) {
                    $upgrade = true;
                    break;
                }
            }
            if ($upgrade) {
                $wpdb->query("ALTER TABLE {$wpdb->signups} DROP INDEX domain_path, ADD INDEX domain_path(domain(140),path(51))");
            }
            $tables = $wpdb->tables('global');
            // sitecategories may not exist.
            if (!$wpdb->get_var("SHOW TABLES LIKE '{$tables['sitecategories']}'")) {
                unset($tables['sitecategories']);
            }
            foreach ($tables as $table) {
                maybe_convert_table_to_utf8mb4($table);
            }
        }
    }
    // 5.1.0
    if ($wp_current_db_version < 44467) {
        $network_id = get_main_network_id();
        delete_network_option($network_id, 'site_meta_supported');
        is_site_meta_supported();
    }
}
//
// General functions we use to actually do stuff.
//
/**
 * Creates a table in the database, if it doesn't already exist.
 *
 * This method checks for an existing database and creates a new one if it's not
 * already present. It doesn't rely on MySQL's "IF NOT EXISTS" statement, but chooses
 * to query all tables first and then run the SQL statement creating the table.
 *
 * @since 1.0.0
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 *
 * @param string $table_name Database table name.
 * @param string $create_ddl SQL statement to create table.
 * @return bool True on success or if the table already exists. False on failure.
 */
function maybe_create_table($table_name, $create_ddl)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("maybe_create_table") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php at line 1954")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called maybe_create_table:1954@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php');
    die();
}
/**
 * Drops a specified index from a table.
 *
 * @since 1.0.1
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 *
 * @param string $table Database table name.
 * @param string $index Index name to drop.
 * @return true True, when finished.
 */
function drop_index($table, $index)
{
    global $wpdb;
    $wpdb->hide_errors();
    $wpdb->query("ALTER TABLE `{$table}` DROP INDEX `{$index}`");
    // Now we need to take out all the extra ones we may have created.
    for ($i = 0; $i < 25; $i++) {
        $wpdb->query("ALTER TABLE `{$table}` DROP INDEX `{$index}_{$i}`");
    }
    $wpdb->show_errors();
    return true;
}
/**
 * Adds an index to a specified table.
 *
 * @since 1.0.1
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 *
 * @param string $table Database table name.
 * @param string $index Database table index column.
 * @return true True, when done with execution.
 */
function add_clean_index($table, $index)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("add_clean_index") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php at line 2003")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called add_clean_index:2003@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php');
    die();
}
/**
 * Adds column to a database table, if it doesn't already exist.
 *
 * @since 1.3.0
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 *
 * @param string $table_name  Database table name.
 * @param string $column_name Table column name.
 * @param string $create_ddl  SQL statement to add column.
 * @return bool True on success or if the column already exists. False on failure.
 */
function maybe_add_column($table_name, $column_name, $create_ddl)
{
    global $wpdb;
    foreach ($wpdb->get_col("DESC {$table_name}", 0) as $column) {
        if ($column === $column_name) {
            return true;
        }
    }
    // Didn't find it, so try to create it.
    $wpdb->query($create_ddl);
    // We cannot directly tell that whether this succeeded!
    foreach ($wpdb->get_col("DESC {$table_name}", 0) as $column) {
        if ($column === $column_name) {
            return true;
        }
    }
    return false;
}
/**
 * If a table only contains utf8 or utf8mb4 columns, convert it to utf8mb4.
 *
 * @since 4.2.0
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 *
 * @param string $table The table to convert.
 * @return bool True if the table was converted, false if it wasn't.
 */
function maybe_convert_table_to_utf8mb4($table)
{
    global $wpdb;
    $results = $wpdb->get_results("SHOW FULL COLUMNS FROM `{$table}`");
    if (!$results) {
        return false;
    }
    foreach ($results as $column) {
        if ($column->Collation) {
            list($charset) = explode('_', $column->Collation);
            $charset = strtolower($charset);
            if ('utf8' !== $charset && 'utf8mb4' !== $charset) {
                // Don't upgrade tables that have non-utf8 columns.
                return false;
            }
        }
    }
    $table_details = $wpdb->get_row("SHOW TABLE STATUS LIKE '{$table}'");
    if (!$table_details) {
        return false;
    }
    list($table_charset) = explode('_', $table_details->Collation);
    $table_charset = strtolower($table_charset);
    if ('utf8mb4' === $table_charset) {
        return true;
    }
    return $wpdb->query("ALTER TABLE {$table} CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
}
/**
 * Retrieve all options as it was for 1.2.
 *
 * @since 1.2.0
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 *
 * @return stdClass List of options.
 */
function get_alloptions_110()
{
    global $wpdb;
    $all_options = new stdClass();
    $options = $wpdb->get_results("SELECT option_name, option_value FROM {$wpdb->options}");
    if ($options) {
        foreach ($options as $option) {
            if ('siteurl' === $option->option_name || 'home' === $option->option_name || 'category_base' === $option->option_name) {
                $option->option_value = untrailingslashit($option->option_value);
            }
            $all_options->{$option->option_name} = stripslashes($option->option_value);
        }
    }
    return $all_options;
}
/**
 * Utility version of get_option that is private to installation/upgrade.
 *
 * @ignore
 * @since 1.5.1
 * @access private
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 *
 * @param string $setting Option name.
 * @return mixed
 */
function __get_option($setting)
{
    // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionDoubleUnderscore,PHPCompatibility.FunctionNameRestrictions.ReservedFunctionNames.FunctionDoubleUnderscore
    global $wpdb;
    if ('home' === $setting && defined('WP_HOME')) {
        return untrailingslashit(WP_HOME);
    }
    if ('siteurl' === $setting && defined('WP_SITEURL')) {
        return untrailingslashit(WP_SITEURL);
    }
    $option = $wpdb->get_var($wpdb->prepare("SELECT option_value FROM {$wpdb->options} WHERE option_name = %s", $setting));
    if ('home' === $setting && !$option) {
        return __get_option('siteurl');
    }
    if (in_array($setting, array('siteurl', 'home', 'category_base', 'tag_base'), true)) {
        $option = untrailingslashit($option);
    }
    return maybe_unserialize($option);
}
/**
 * Filters for content to remove unnecessary slashes.
 *
 * @since 1.5.0
 *
 * @param string $content The content to modify.
 * @return string The de-slashed content.
 */
function deslash($content)
{
    // Note: \\\ inside a regex denotes a single backslash.
    /*
     * Replace one or more backslashes followed by a single quote with
     * a single quote.
     */
    $content = preg_replace("/\\\\+'/", "'", $content);
    /*
     * Replace one or more backslashes followed by a double quote with
     * a double quote.
     */
    $content = preg_replace('/\\\\+"/', '"', $content);
    // Replace one or more backslashes with one backslash.
    $content = preg_replace('/\\\\+/', '\\', $content);
    return $content;
}
/**
 * Modifies the database based on specified SQL statements.
 *
 * Useful for creating new tables and updating existing tables to a new structure.
 *
 * @since 1.5.0
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 *
 * @param string[]|string $queries Optional. The query to run. Can be multiple queries
 *                                 in an array, or a string of queries separated by
 *                                 semicolons. Default empty string.
 * @param bool            $execute Optional. Whether or not to execute the query right away.
 *                                 Default true.
 * @return array Strings containing the results of the various update queries.
 */
function dbDelta($queries = '', $execute = true)
{
    // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
    global $wpdb;
    if (in_array($queries, array('', 'all', 'blog', 'global', 'ms_global'), true)) {
        $queries = wp_get_db_schema($queries);
    }
    // Separate individual queries into an array.
    if (!is_array($queries)) {
        $queries = explode(';', $queries);
        $queries = array_filter($queries);
    }
    /**
     * Filters the dbDelta SQL queries.
     *
     * @since 3.3.0
     *
     * @param string[] $queries An array of dbDelta SQL queries.
     */
    $queries = apply_filters('dbdelta_queries', $queries);
    $cqueries = array();
    // Creation queries.
    $iqueries = array();
    // Insertion queries.
    $for_update = array();
    // Create a tablename index for an array ($cqueries) of queries.
    foreach ($queries as $qry) {
        if (preg_match('|CREATE TABLE ([^ ]*)|', $qry, $matches)) {
            $cqueries[trim($matches[1], '`')] = $qry;
            $for_update[$matches[1]] = 'Created table ' . $matches[1];
        } elseif (preg_match('|CREATE DATABASE ([^ ]*)|', $qry, $matches)) {
            array_unshift($cqueries, $qry);
        } elseif (preg_match('|INSERT INTO ([^ ]*)|', $qry, $matches)) {
            $iqueries[] = $qry;
        } elseif (preg_match('|UPDATE ([^ ]*)|', $qry, $matches)) {
            $iqueries[] = $qry;
        } else {
            // Unrecognized query type.
        }
    }
    /**
     * Filters the dbDelta SQL queries for creating tables and/or databases.
     *
     * Queries filterable via this hook contain "CREATE TABLE" or "CREATE DATABASE".
     *
     * @since 3.3.0
     *
     * @param string[] $cqueries An array of dbDelta create SQL queries.
     */
    $cqueries = apply_filters('dbdelta_create_queries', $cqueries);
    /**
     * Filters the dbDelta SQL queries for inserting or updating.
     *
     * Queries filterable via this hook contain "INSERT INTO" or "UPDATE".
     *
     * @since 3.3.0
     *
     * @param string[] $iqueries An array of dbDelta insert or update SQL queries.
     */
    $iqueries = apply_filters('dbdelta_insert_queries', $iqueries);
    $text_fields = array('tinytext', 'text', 'mediumtext', 'longtext');
    $blob_fields = array('tinyblob', 'blob', 'mediumblob', 'longblob');
    $global_tables = $wpdb->tables('global');
    foreach ($cqueries as $table => $qry) {
        // Upgrade global tables only for the main site. Don't upgrade at all if conditions are not optimal.
        if (in_array($table, $global_tables, true) && !wp_should_upgrade_global_tables()) {
            unset($cqueries[$table], $for_update[$table]);
            continue;
        }
        // Fetch the table column structure from the database.
        $suppress = $wpdb->suppress_errors();
        $tablefields = $wpdb->get_results("DESCRIBE {$table};");
        $wpdb->suppress_errors($suppress);
        if (!$tablefields) {
            continue;
        }
        // Clear the field and index arrays.
        $cfields = array();
        $indices = array();
        $indices_without_subparts = array();
        // Get all of the field names in the query from between the parentheses.
        preg_match('|\\((.*)\\)|ms', $qry, $match2);
        $qryline = trim($match2[1]);
        // Separate field lines into an array.
        $flds = explode("\n", $qryline);
        // For every field line specified in the query.
        foreach ($flds as $fld) {
            $fld = trim($fld, " \t\n\r\x00\v,");
            // Default trim characters, plus ','.
            // Extract the field name.
            preg_match('|^([^ ]*)|', $fld, $fvals);
            $fieldname = trim($fvals[1], '`');
            $fieldname_lowercased = strtolower($fieldname);
            // Verify the found field name.
            $validfield = true;
            switch ($fieldname_lowercased) {
                case '':
                case 'primary':
                case 'index':
                case 'fulltext':
                case 'unique':
                case 'key':
                case 'spatial':
                    $validfield = false;
                    /*
                     * Normalize the index definition.
                     *
                     * This is done so the definition can be compared against the result of a
                     * `SHOW INDEX FROM $table_name` query which returns the current table
                     * index information.
                     */
                    // Extract type, name and columns from the definition.
                    // phpcs:disable Squiz.Strings.ConcatenationSpacing.PaddingFound -- don't remove regex indentation
                    preg_match('/^' . '(?P<index_type>' . 'PRIMARY\\s+KEY|(?:UNIQUE|FULLTEXT|SPATIAL)\\s+(?:KEY|INDEX)|KEY|INDEX' . ')' . '\\s+' . '(?:' . '`?' . '(?P<index_name>' . '(?:[0-9a-zA-Z$_-]|[\\xC2-\\xDF][\\x80-\\xBF])+' . ')' . '`?' . '\\s+' . ')*' . '\\(' . '(?P<index_columns>' . '.+?' . ')' . '\\)' . '$/im', $fld, $index_matches);
                    // phpcs:enable
                    // Uppercase the index type and normalize space characters.
                    $index_type = strtoupper(preg_replace('/\\s+/', ' ', trim($index_matches['index_type'])));
                    // 'INDEX' is a synonym for 'KEY', standardize on 'KEY'.
                    $index_type = str_replace('INDEX', 'KEY', $index_type);
                    // Escape the index name with backticks. An index for a primary key has no name.
                    $index_name = 'PRIMARY KEY' === $index_type ? '' : '`' . strtolower($index_matches['index_name']) . '`';
                    // Parse the columns. Multiple columns are separated by a comma.
                    $index_columns = array_map('trim', explode(',', $index_matches['index_columns']));
                    $index_columns_without_subparts = $index_columns;
                    // Normalize columns.
                    foreach ($index_columns as $id => &$index_column) {
                        // Extract column name and number of indexed characters (sub_part).
                        preg_match('/' . '`?' . '(?P<column_name>' . '(?:[0-9a-zA-Z$_-]|[\\xC2-\\xDF][\\x80-\\xBF])+' . ')' . '`?' . '(?:' . '\\s*' . '\\(' . '\\s*' . '(?P<sub_part>' . '\\d+' . ')' . '\\s*' . '\\)' . ')?' . '/', $index_column, $index_column_matches);
                        // Escape the column name with backticks.
                        $index_column = '`' . $index_column_matches['column_name'] . '`';
                        // We don't need to add the subpart to $index_columns_without_subparts
                        $index_columns_without_subparts[$id] = $index_column;
                        // Append the optional sup part with the number of indexed characters.
                        if (isset($index_column_matches['sub_part'])) {
                            $index_column .= '(' . $index_column_matches['sub_part'] . ')';
                        }
                    }
                    // Build the normalized index definition and add it to the list of indices.
                    $indices[] = "{$index_type} {$index_name} (" . implode(',', $index_columns) . ')';
                    $indices_without_subparts[] = "{$index_type} {$index_name} (" . implode(',', $index_columns_without_subparts) . ')';
                    // Destroy no longer needed variables.
                    unset($index_column, $index_column_matches, $index_matches, $index_type, $index_name, $index_columns, $index_columns_without_subparts);
                    break;
            }
            // If it's a valid field, add it to the field array.
            if ($validfield) {
                $cfields[$fieldname_lowercased] = $fld;
            }
        }
        // For every field in the table.
        foreach ($tablefields as $tablefield) {
            $tablefield_field_lowercased = strtolower($tablefield->Field);
            $tablefield_type_lowercased = strtolower($tablefield->Type);
            // If the table field exists in the field array...
            if (array_key_exists($tablefield_field_lowercased, $cfields)) {
                // Get the field type from the query.
                preg_match('|`?' . $tablefield->Field . '`? ([^ ]*( unsigned)?)|i', $cfields[$tablefield_field_lowercased], $matches);
                $fieldtype = $matches[1];
                $fieldtype_lowercased = strtolower($fieldtype);
                // Is actual field type different from the field type in query?
                if ($tablefield->Type != $fieldtype) {
                    $do_change = true;
                    if (in_array($fieldtype_lowercased, $text_fields, true) && in_array($tablefield_type_lowercased, $text_fields, true)) {
                        if (array_search($fieldtype_lowercased, $text_fields, true) < array_search($tablefield_type_lowercased, $text_fields, true)) {
                            $do_change = false;
                        }
                    }
                    if (in_array($fieldtype_lowercased, $blob_fields, true) && in_array($tablefield_type_lowercased, $blob_fields, true)) {
                        if (array_search($fieldtype_lowercased, $blob_fields, true) < array_search($tablefield_type_lowercased, $blob_fields, true)) {
                            $do_change = false;
                        }
                    }
                    if ($do_change) {
                        // Add a query to change the column type.
                        $cqueries[] = "ALTER TABLE {$table} CHANGE COLUMN `{$tablefield->Field}` " . $cfields[$tablefield_field_lowercased];
                        $for_update[$table . '.' . $tablefield->Field] = "Changed type of {$table}.{$tablefield->Field} from {$tablefield->Type} to {$fieldtype}";
                    }
                }
                // Get the default value from the array.
                if (preg_match("| DEFAULT '(.*?)'|i", $cfields[$tablefield_field_lowercased], $matches)) {
                    $default_value = $matches[1];
                    if ($tablefield->Default != $default_value) {
                        // Add a query to change the column's default value
                        $cqueries[] = "ALTER TABLE {$table} ALTER COLUMN `{$tablefield->Field}` SET DEFAULT '{$default_value}'";
                        $for_update[$table . '.' . $tablefield->Field] = "Changed default value of {$table}.{$tablefield->Field} from {$tablefield->Default} to {$default_value}";
                    }
                }
                // Remove the field from the array (so it's not added).
                unset($cfields[$tablefield_field_lowercased]);
            } else {
                // This field exists in the table, but not in the creation queries?
            }
        }
        // For every remaining field specified for the table.
        foreach ($cfields as $fieldname => $fielddef) {
            // Push a query line into $cqueries that adds the field to that table.
            $cqueries[] = "ALTER TABLE {$table} ADD COLUMN {$fielddef}";
            $for_update[$table . '.' . $fieldname] = 'Added column ' . $table . '.' . $fieldname;
        }
        // Index stuff goes here. Fetch the table index structure from the database.
        $tableindices = $wpdb->get_results("SHOW INDEX FROM {$table};");
        if ($tableindices) {
            // Clear the index array.
            $index_ary = array();
            // For every index in the table.
            foreach ($tableindices as $tableindex) {
                $keyname = strtolower($tableindex->Key_name);
                // Add the index to the index data array.
                $index_ary[$keyname]['columns'][] = array('fieldname' => $tableindex->Column_name, 'subpart' => $tableindex->Sub_part);
                $index_ary[$keyname]['unique'] = 0 == $tableindex->Non_unique ? true : false;
                $index_ary[$keyname]['index_type'] = $tableindex->Index_type;
            }
            // For each actual index in the index array.
            foreach ($index_ary as $index_name => $index_data) {
                // Build a create string to compare to the query.
                $index_string = '';
                if ('primary' === $index_name) {
                    $index_string .= 'PRIMARY ';
                } elseif ($index_data['unique']) {
                    $index_string .= 'UNIQUE ';
                }
                if ('FULLTEXT' === strtoupper($index_data['index_type'])) {
                    $index_string .= 'FULLTEXT ';
                }
                if ('SPATIAL' === strtoupper($index_data['index_type'])) {
                    $index_string .= 'SPATIAL ';
                }
                $index_string .= 'KEY ';
                if ('primary' !== $index_name) {
                    $index_string .= '`' . $index_name . '`';
                }
                $index_columns = '';
                // For each column in the index.
                foreach ($index_data['columns'] as $column_data) {
                    if ('' !== $index_columns) {
                        $index_columns .= ',';
                    }
                    // Add the field to the column list string.
                    $index_columns .= '`' . $column_data['fieldname'] . '`';
                }
                // Add the column list to the index create string.
                $index_string .= " ({$index_columns})";
                // Check if the index definition exists, ignoring subparts.
                $aindex = array_search($index_string, $indices_without_subparts, true);
                if (false !== $aindex) {
                    // If the index already exists (even with different subparts), we don't need to create it.
                    unset($indices_without_subparts[$aindex]);
                    unset($indices[$aindex]);
                }
            }
        }
        // For every remaining index specified for the table.
        foreach ((array) $indices as $index) {
            // Push a query line into $cqueries that adds the index to that table.
            $cqueries[] = "ALTER TABLE {$table} ADD {$index}";
            $for_update[] = 'Added index ' . $table . ' ' . $index;
        }
        // Remove the original table creation query from processing.
        unset($cqueries[$table], $for_update[$table]);
    }
    $allqueries = array_merge($cqueries, $iqueries);
    if ($execute) {
        foreach ($allqueries as $query) {
            $wpdb->query($query);
        }
    }
    return $for_update;
}
/**
 * Updates the database tables to a new schema.
 *
 * By default, updates all the tables to use the latest defined schema, but can also
 * be used to update a specific set of tables in wp_get_db_schema().
 *
 * @since 1.5.0
 *
 * @uses dbDelta
 *
 * @param string $tables Optional. Which set of tables to update. Default is 'all'.
 */
function make_db_current($tables = 'all')
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("make_db_current") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php at line 2454")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called make_db_current:2454@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php');
    die();
}
/**
 * Updates the database tables to a new schema, but without displaying results.
 *
 * By default, updates all the tables to use the latest defined schema, but can
 * also be used to update a specific set of tables in wp_get_db_schema().
 *
 * @since 1.5.0
 *
 * @see make_db_current()
 *
 * @param string $tables Optional. Which set of tables to update. Default is 'all'.
 */
function make_db_current_silent($tables = 'all')
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("make_db_current_silent") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php at line 2475")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called make_db_current_silent:2475@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php');
    die();
}
/**
 * Creates a site theme from an existing theme.
 *
 * {@internal Missing Long Description}}
 *
 * @since 1.5.0
 *
 * @param string $theme_name The name of the theme.
 * @param string $template   The directory name of the theme.
 * @return bool
 */
function make_site_theme_from_oldschool($theme_name, $template)
{
    $home_path = get_home_path();
    $site_dir = WP_CONTENT_DIR . "/themes/{$template}";
    if (!file_exists("{$home_path}/index.php")) {
        return false;
    }
    /*
     * Copy files from the old locations to the site theme.
     * TODO: This does not copy arbitrary include dependencies. Only the standard WP files are copied.
     */
    $files = array('index.php' => 'index.php', 'wp-layout.css' => 'style.css', 'wp-comments.php' => 'comments.php', 'wp-comments-popup.php' => 'comments-popup.php');
    foreach ($files as $oldfile => $newfile) {
        if ('index.php' === $oldfile) {
            $oldpath = $home_path;
        } else {
            $oldpath = ABSPATH;
        }
        // Check to make sure it's not a new index.
        if ('index.php' === $oldfile) {
            $index = implode('', file("{$oldpath}/{$oldfile}"));
            if (strpos($index, 'WP_USE_THEMES') !== false) {
                if (!copy(WP_CONTENT_DIR . '/themes/' . WP_DEFAULT_THEME . '/index.php', "{$site_dir}/{$newfile}")) {
                    return false;
                }
                // Don't copy anything.
                continue;
            }
        }
        if (!copy("{$oldpath}/{$oldfile}", "{$site_dir}/{$newfile}")) {
            return false;
        }
        chmod("{$site_dir}/{$newfile}", 0777);
        // Update the blog header include in each file.
        $lines = explode("\n", implode('', file("{$site_dir}/{$newfile}")));
        if ($lines) {
            $f = fopen("{$site_dir}/{$newfile}", 'w');
            foreach ($lines as $line) {
                if (preg_match('/require.*wp-blog-header/', $line)) {
                    $line = '//' . $line;
                }
                // Update stylesheet references.
                $line = str_replace("<?php echo __get_option('siteurl'); ?>/wp-layout.css", "<?php bloginfo('stylesheet_url'); ?>", $line);
                // Update comments template inclusion.
                $line = str_replace("<?php include(ABSPATH . 'wp-comments.php'); ?>", '<?php comments_template(); ?>', $line);
                fwrite($f, "{$line}\n");
            }
            fclose($f);
        }
    }
    // Add a theme header.
    $header = "/*\nTheme Name: {$theme_name}\nTheme URI: " . __get_option('siteurl') . "\nDescription: A theme automatically created by the update.\nVersion: 1.0\nAuthor: Moi\n*/\n";
    $stylelines = file_get_contents("{$site_dir}/style.css");
    if ($stylelines) {
        $f = fopen("{$site_dir}/style.css", 'w');
        fwrite($f, $header);
        fwrite($f, $stylelines);
        fclose($f);
    }
    return true;
}
/**
 * Creates a site theme from the default theme.
 *
 * {@internal Missing Long Description}}
 *
 * @since 1.5.0
 *
 * @param string $theme_name The name of the theme.
 * @param string $template   The directory name of the theme.
 * @return void|false
 */
function make_site_theme_from_default($theme_name, $template)
{
    $site_dir = WP_CONTENT_DIR . "/themes/{$template}";
    $default_dir = WP_CONTENT_DIR . '/themes/' . WP_DEFAULT_THEME;
    // Copy files from the default theme to the site theme.
    // $files = array( 'index.php', 'comments.php', 'comments-popup.php', 'footer.php', 'header.php', 'sidebar.php', 'style.css' );
    $theme_dir = @opendir($default_dir);
    if ($theme_dir) {
        while (($theme_file = readdir($theme_dir)) !== false) {
            if (is_dir("{$default_dir}/{$theme_file}")) {
                continue;
            }
            if (!copy("{$default_dir}/{$theme_file}", "{$site_dir}/{$theme_file}")) {
                return;
            }
            chmod("{$site_dir}/{$theme_file}", 0777);
        }
        closedir($theme_dir);
    }
    // Rewrite the theme header.
    $stylelines = explode("\n", implode('', file("{$site_dir}/style.css")));
    if ($stylelines) {
        $f = fopen("{$site_dir}/style.css", 'w');
        foreach ($stylelines as $line) {
            if (strpos($line, 'Theme Name:') !== false) {
                $line = 'Theme Name: ' . $theme_name;
            } elseif (strpos($line, 'Theme URI:') !== false) {
                $line = 'Theme URI: ' . __get_option('url');
            } elseif (strpos($line, 'Description:') !== false) {
                $line = 'Description: Your theme.';
            } elseif (strpos($line, 'Version:') !== false) {
                $line = 'Version: 1';
            } elseif (strpos($line, 'Author:') !== false) {
                $line = 'Author: You';
            }
            fwrite($f, $line . "\n");
        }
        fclose($f);
    }
    // Copy the images.
    umask(0);
    if (!mkdir("{$site_dir}/images", 0777)) {
        return false;
    }
    $images_dir = @opendir("{$default_dir}/images");
    if ($images_dir) {
        while (($image = readdir($images_dir)) !== false) {
            if (is_dir("{$default_dir}/images/{$image}")) {
                continue;
            }
            if (!copy("{$default_dir}/images/{$image}", "{$site_dir}/images/{$image}")) {
                return;
            }
            chmod("{$site_dir}/images/{$image}", 0777);
        }
        closedir($images_dir);
    }
}
/**
 * Creates a site theme.
 *
 * {@internal Missing Long Description}}
 *
 * @since 1.5.0
 *
 * @return string|false
 */
function make_site_theme()
{
    // Name the theme after the blog.
    $theme_name = __get_option('blogname');
    $template = sanitize_title($theme_name);
    $site_dir = WP_CONTENT_DIR . "/themes/{$template}";
    // If the theme already exists, nothing to do.
    if (is_dir($site_dir)) {
        return false;
    }
    // We must be able to write to the themes dir.
    if (!is_writable(WP_CONTENT_DIR . '/themes')) {
        return false;
    }
    umask(0);
    if (!mkdir($site_dir, 0777)) {
        return false;
    }
    if (file_exists(ABSPATH . 'wp-layout.css')) {
        if (!make_site_theme_from_oldschool($theme_name, $template)) {
            // TODO: rm -rf the site theme directory.
            return false;
        }
    } else {
        if (!make_site_theme_from_default($theme_name, $template)) {
            // TODO: rm -rf the site theme directory.
            return false;
        }
    }
    // Make the new site theme active.
    $current_template = __get_option('template');
    if (WP_DEFAULT_THEME == $current_template) {
        update_option('template', $template);
        update_option('stylesheet', $template);
    }
    return $template;
}
/**
 * Translate user level to user role name.
 *
 * @since 2.0.0
 *
 * @param int $level User level.
 * @return string User role name.
 */
function translate_level_to_role($level)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("translate_level_to_role") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php at line 2674")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called translate_level_to_role:2674@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php');
    die();
}
/**
 * Checks the version of the installed MySQL binary.
 *
 * @since 2.1.0
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 */
function wp_check_mysql_version()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_check_mysql_version") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php at line 2703")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_check_mysql_version:2703@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php');
    die();
}
/**
 * Disables the Automattic widgets plugin, which was merged into core.
 *
 * @since 2.2.0
 */
function maybe_disable_automattic_widgets()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("maybe_disable_automattic_widgets") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php at line 2716")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called maybe_disable_automattic_widgets:2716@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php');
    die();
}
/**
 * Disables the Link Manager on upgrade if, at the time of upgrade, no links exist in the DB.
 *
 * @since 3.5.0
 *
 * @global int  $wp_current_db_version The old (current) database version.
 * @global wpdb $wpdb                  WordPress database abstraction object.
 */
function maybe_disable_link_manager()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("maybe_disable_link_manager") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php at line 2735")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called maybe_disable_link_manager:2735@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php');
    die();
}
/**
 * Runs before the schema is upgraded.
 *
 * @since 2.9.0
 *
 * @global int  $wp_current_db_version The old (current) database version.
 * @global wpdb $wpdb                  WordPress database abstraction object.
 */
function pre_schema_upgrade()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("pre_schema_upgrade") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php at line 2750")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called pre_schema_upgrade:2750@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php');
    die();
}
if (!function_exists('install_global_terms')) {
    /**
     * Install global terms.
     *
     * @since 3.0.0
     *
     * @global wpdb   $wpdb            WordPress database abstraction object.
     * @global string $charset_collate
     */
    function install_global_terms()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("install_global_terms") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php at line 2805")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called install_global_terms:2805@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php');
        die();
    }
}
/**
 * Determine if global tables should be upgraded.
 *
 * This function performs a series of checks to ensure the environment allows
 * for the safe upgrading of global WordPress database tables. It is necessary
 * because global tables will commonly grow to millions of rows on large
 * installations, and the ability to control their upgrade routines can be
 * critical to the operation of large networks.
 *
 * In a future iteration, this function may use `wp_is_large_network()` to more-
 * intelligently prevent global table upgrades. Until then, we make sure
 * WordPress is on the main site of the main network, to avoid running queries
 * more than once in multi-site or multi-network environments.
 *
 * @since 4.3.0
 *
 * @return bool Whether to run the upgrade routines on global tables.
 */
function wp_should_upgrade_global_tables()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_should_upgrade_global_tables") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php at line 2832")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_should_upgrade_global_tables:2832@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/upgrade.php');
    die();
}