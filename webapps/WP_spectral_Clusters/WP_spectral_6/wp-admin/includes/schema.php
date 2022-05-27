<?php

/**
 * WordPress Administration Scheme API
 *
 * Here we keep the DB structure and option values.
 *
 * @package WordPress
 * @subpackage Administration
 */
/**
 * Declare these as global in case schema.php is included from a function.
 *
 * @global wpdb   $wpdb            WordPress database abstraction object.
 * @global array  $wp_queries
 * @global string $charset_collate
 */
global $wpdb, $wp_queries, $charset_collate;
/**
 * The database character collate.
 */
$charset_collate = $wpdb->get_charset_collate();
/**
 * Retrieve the SQL for creating database tables.
 *
 * @since 3.3.0
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 *
 * @param string $scope   Optional. The tables for which to retrieve SQL. Can be all, global, ms_global, or blog tables. Defaults to all.
 * @param int    $blog_id Optional. The site ID for which to retrieve SQL. Default is the current site ID.
 * @return string The SQL needed to create the requested tables.
 */
function wp_get_db_schema($scope = 'all', $blog_id = null)
{
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    if ($blog_id && $blog_id != $wpdb->blogid) {
        $old_blog_id = $wpdb->set_blog_id($blog_id);
    }
    // Engage multisite if in the middle of turning it on from network.php.
    $is_multisite = is_multisite() || defined('WP_INSTALLING_NETWORK') && WP_INSTALLING_NETWORK;
    /*
     * Indexes have a maximum size of 767 bytes. Historically, we haven't need to be concerned about that.
     * As of 4.2, however, we moved to utf8mb4, which uses 4 bytes per character. This means that an index which
     * used to have room for floor(767/3) = 255 characters, now only has room for floor(767/4) = 191 characters.
     */
    $max_index_length = 191;
    // Blog-specific tables.
    $blog_tables = "CREATE TABLE {$wpdb->termmeta} (\n\tmeta_id bigint(20) unsigned NOT NULL auto_increment,\n\tterm_id bigint(20) unsigned NOT NULL default '0',\n\tmeta_key varchar(255) default NULL,\n\tmeta_value longtext,\n\tPRIMARY KEY  (meta_id),\n\tKEY term_id (term_id),\n\tKEY meta_key (meta_key({$max_index_length}))\n) {$charset_collate};\nCREATE TABLE {$wpdb->terms} (\n term_id bigint(20) unsigned NOT NULL auto_increment,\n name varchar(200) NOT NULL default '',\n slug varchar(200) NOT NULL default '',\n term_group bigint(10) NOT NULL default 0,\n PRIMARY KEY  (term_id),\n KEY slug (slug({$max_index_length})),\n KEY name (name({$max_index_length}))\n) {$charset_collate};\nCREATE TABLE {$wpdb->term_taxonomy} (\n term_taxonomy_id bigint(20) unsigned NOT NULL auto_increment,\n term_id bigint(20) unsigned NOT NULL default 0,\n taxonomy varchar(32) NOT NULL default '',\n description longtext NOT NULL,\n parent bigint(20) unsigned NOT NULL default 0,\n count bigint(20) NOT NULL default 0,\n PRIMARY KEY  (term_taxonomy_id),\n UNIQUE KEY term_id_taxonomy (term_id,taxonomy),\n KEY taxonomy (taxonomy)\n) {$charset_collate};\nCREATE TABLE {$wpdb->term_relationships} (\n object_id bigint(20) unsigned NOT NULL default 0,\n term_taxonomy_id bigint(20) unsigned NOT NULL default 0,\n term_order int(11) NOT NULL default 0,\n PRIMARY KEY  (object_id,term_taxonomy_id),\n KEY term_taxonomy_id (term_taxonomy_id)\n) {$charset_collate};\nCREATE TABLE {$wpdb->commentmeta} (\n\tmeta_id bigint(20) unsigned NOT NULL auto_increment,\n\tcomment_id bigint(20) unsigned NOT NULL default '0',\n\tmeta_key varchar(255) default NULL,\n\tmeta_value longtext,\n\tPRIMARY KEY  (meta_id),\n\tKEY comment_id (comment_id),\n\tKEY meta_key (meta_key({$max_index_length}))\n) {$charset_collate};\nCREATE TABLE {$wpdb->comments} (\n\tcomment_ID bigint(20) unsigned NOT NULL auto_increment,\n\tcomment_post_ID bigint(20) unsigned NOT NULL default '0',\n\tcomment_author tinytext NOT NULL,\n\tcomment_author_email varchar(100) NOT NULL default '',\n\tcomment_author_url varchar(200) NOT NULL default '',\n\tcomment_author_IP varchar(100) NOT NULL default '',\n\tcomment_date datetime NOT NULL default '0000-00-00 00:00:00',\n\tcomment_date_gmt datetime NOT NULL default '0000-00-00 00:00:00',\n\tcomment_content text NOT NULL,\n\tcomment_karma int(11) NOT NULL default '0',\n\tcomment_approved varchar(20) NOT NULL default '1',\n\tcomment_agent varchar(255) NOT NULL default '',\n\tcomment_type varchar(20) NOT NULL default 'comment',\n\tcomment_parent bigint(20) unsigned NOT NULL default '0',\n\tuser_id bigint(20) unsigned NOT NULL default '0',\n\tPRIMARY KEY  (comment_ID),\n\tKEY comment_post_ID (comment_post_ID),\n\tKEY comment_approved_date_gmt (comment_approved,comment_date_gmt),\n\tKEY comment_date_gmt (comment_date_gmt),\n\tKEY comment_parent (comment_parent),\n\tKEY comment_author_email (comment_author_email(10))\n) {$charset_collate};\nCREATE TABLE {$wpdb->links} (\n\tlink_id bigint(20) unsigned NOT NULL auto_increment,\n\tlink_url varchar(255) NOT NULL default '',\n\tlink_name varchar(255) NOT NULL default '',\n\tlink_image varchar(255) NOT NULL default '',\n\tlink_target varchar(25) NOT NULL default '',\n\tlink_description varchar(255) NOT NULL default '',\n\tlink_visible varchar(20) NOT NULL default 'Y',\n\tlink_owner bigint(20) unsigned NOT NULL default '1',\n\tlink_rating int(11) NOT NULL default '0',\n\tlink_updated datetime NOT NULL default '0000-00-00 00:00:00',\n\tlink_rel varchar(255) NOT NULL default '',\n\tlink_notes mediumtext NOT NULL,\n\tlink_rss varchar(255) NOT NULL default '',\n\tPRIMARY KEY  (link_id),\n\tKEY link_visible (link_visible)\n) {$charset_collate};\nCREATE TABLE {$wpdb->options} (\n\toption_id bigint(20) unsigned NOT NULL auto_increment,\n\toption_name varchar(191) NOT NULL default '',\n\toption_value longtext NOT NULL,\n\tautoload varchar(20) NOT NULL default 'yes',\n\tPRIMARY KEY  (option_id),\n\tUNIQUE KEY option_name (option_name),\n\tKEY autoload (autoload)\n) {$charset_collate};\nCREATE TABLE {$wpdb->postmeta} (\n\tmeta_id bigint(20) unsigned NOT NULL auto_increment,\n\tpost_id bigint(20) unsigned NOT NULL default '0',\n\tmeta_key varchar(255) default NULL,\n\tmeta_value longtext,\n\tPRIMARY KEY  (meta_id),\n\tKEY post_id (post_id),\n\tKEY meta_key (meta_key({$max_index_length}))\n) {$charset_collate};\nCREATE TABLE {$wpdb->posts} (\n\tID bigint(20) unsigned NOT NULL auto_increment,\n\tpost_author bigint(20) unsigned NOT NULL default '0',\n\tpost_date datetime NOT NULL default '0000-00-00 00:00:00',\n\tpost_date_gmt datetime NOT NULL default '0000-00-00 00:00:00',\n\tpost_content longtext NOT NULL,\n\tpost_title text NOT NULL,\n\tpost_excerpt text NOT NULL,\n\tpost_status varchar(20) NOT NULL default 'publish',\n\tcomment_status varchar(20) NOT NULL default 'open',\n\tping_status varchar(20) NOT NULL default 'open',\n\tpost_password varchar(255) NOT NULL default '',\n\tpost_name varchar(200) NOT NULL default '',\n\tto_ping text NOT NULL,\n\tpinged text NOT NULL,\n\tpost_modified datetime NOT NULL default '0000-00-00 00:00:00',\n\tpost_modified_gmt datetime NOT NULL default '0000-00-00 00:00:00',\n\tpost_content_filtered longtext NOT NULL,\n\tpost_parent bigint(20) unsigned NOT NULL default '0',\n\tguid varchar(255) NOT NULL default '',\n\tmenu_order int(11) NOT NULL default '0',\n\tpost_type varchar(20) NOT NULL default 'post',\n\tpost_mime_type varchar(100) NOT NULL default '',\n\tcomment_count bigint(20) NOT NULL default '0',\n\tPRIMARY KEY  (ID),\n\tKEY post_name (post_name({$max_index_length})),\n\tKEY type_status_date (post_type,post_status,post_date,ID),\n\tKEY post_parent (post_parent),\n\tKEY post_author (post_author)\n) {$charset_collate};\n";
    // Single site users table. The multisite flavor of the users table is handled below.
    $users_single_table = "CREATE TABLE {$wpdb->users} (\n\tID bigint(20) unsigned NOT NULL auto_increment,\n\tuser_login varchar(60) NOT NULL default '',\n\tuser_pass varchar(255) NOT NULL default '',\n\tuser_nicename varchar(50) NOT NULL default '',\n\tuser_email varchar(100) NOT NULL default '',\n\tuser_url varchar(100) NOT NULL default '',\n\tuser_registered datetime NOT NULL default '0000-00-00 00:00:00',\n\tuser_activation_key varchar(255) NOT NULL default '',\n\tuser_status int(11) NOT NULL default '0',\n\tdisplay_name varchar(250) NOT NULL default '',\n\tPRIMARY KEY  (ID),\n\tKEY user_login_key (user_login),\n\tKEY user_nicename (user_nicename),\n\tKEY user_email (user_email)\n) {$charset_collate};\n";
    // Multisite users table.
    $users_multi_table = "CREATE TABLE {$wpdb->users} (\n\tID bigint(20) unsigned NOT NULL auto_increment,\n\tuser_login varchar(60) NOT NULL default '',\n\tuser_pass varchar(255) NOT NULL default '',\n\tuser_nicename varchar(50) NOT NULL default '',\n\tuser_email varchar(100) NOT NULL default '',\n\tuser_url varchar(100) NOT NULL default '',\n\tuser_registered datetime NOT NULL default '0000-00-00 00:00:00',\n\tuser_activation_key varchar(255) NOT NULL default '',\n\tuser_status int(11) NOT NULL default '0',\n\tdisplay_name varchar(250) NOT NULL default '',\n\tspam tinyint(2) NOT NULL default '0',\n\tdeleted tinyint(2) NOT NULL default '0',\n\tPRIMARY KEY  (ID),\n\tKEY user_login_key (user_login),\n\tKEY user_nicename (user_nicename),\n\tKEY user_email (user_email)\n) {$charset_collate};\n";
    // Usermeta.
    $usermeta_table = "CREATE TABLE {$wpdb->usermeta} (\n\tumeta_id bigint(20) unsigned NOT NULL auto_increment,\n\tuser_id bigint(20) unsigned NOT NULL default '0',\n\tmeta_key varchar(255) default NULL,\n\tmeta_value longtext,\n\tPRIMARY KEY  (umeta_id),\n\tKEY user_id (user_id),\n\tKEY meta_key (meta_key({$max_index_length}))\n) {$charset_collate};\n";
    // Global tables.
    if ($is_multisite) {
        $global_tables = $users_multi_table . $usermeta_table;
    } else {
        $global_tables = $users_single_table . $usermeta_table;
    }
    // Multisite global tables.
    $ms_global_tables = "CREATE TABLE {$wpdb->blogs} (\n\tblog_id bigint(20) NOT NULL auto_increment,\n\tsite_id bigint(20) NOT NULL default '0',\n\tdomain varchar(200) NOT NULL default '',\n\tpath varchar(100) NOT NULL default '',\n\tregistered datetime NOT NULL default '0000-00-00 00:00:00',\n\tlast_updated datetime NOT NULL default '0000-00-00 00:00:00',\n\tpublic tinyint(2) NOT NULL default '1',\n\tarchived tinyint(2) NOT NULL default '0',\n\tmature tinyint(2) NOT NULL default '0',\n\tspam tinyint(2) NOT NULL default '0',\n\tdeleted tinyint(2) NOT NULL default '0',\n\tlang_id int(11) NOT NULL default '0',\n\tPRIMARY KEY  (blog_id),\n\tKEY domain (domain(50),path(5)),\n\tKEY lang_id (lang_id)\n) {$charset_collate};\nCREATE TABLE {$wpdb->blogmeta} (\n\tmeta_id bigint(20) unsigned NOT NULL auto_increment,\n\tblog_id bigint(20) NOT NULL default '0',\n\tmeta_key varchar(255) default NULL,\n\tmeta_value longtext,\n\tPRIMARY KEY  (meta_id),\n\tKEY meta_key (meta_key({$max_index_length})),\n\tKEY blog_id (blog_id)\n) {$charset_collate};\nCREATE TABLE {$wpdb->registration_log} (\n\tID bigint(20) NOT NULL auto_increment,\n\temail varchar(255) NOT NULL default '',\n\tIP varchar(30) NOT NULL default '',\n\tblog_id bigint(20) NOT NULL default '0',\n\tdate_registered datetime NOT NULL default '0000-00-00 00:00:00',\n\tPRIMARY KEY  (ID),\n\tKEY IP (IP)\n) {$charset_collate};\nCREATE TABLE {$wpdb->site} (\n\tid bigint(20) NOT NULL auto_increment,\n\tdomain varchar(200) NOT NULL default '',\n\tpath varchar(100) NOT NULL default '',\n\tPRIMARY KEY  (id),\n\tKEY domain (domain(140),path(51))\n) {$charset_collate};\nCREATE TABLE {$wpdb->sitemeta} (\n\tmeta_id bigint(20) NOT NULL auto_increment,\n\tsite_id bigint(20) NOT NULL default '0',\n\tmeta_key varchar(255) default NULL,\n\tmeta_value longtext,\n\tPRIMARY KEY  (meta_id),\n\tKEY meta_key (meta_key({$max_index_length})),\n\tKEY site_id (site_id)\n) {$charset_collate};\nCREATE TABLE {$wpdb->signups} (\n\tsignup_id bigint(20) NOT NULL auto_increment,\n\tdomain varchar(200) NOT NULL default '',\n\tpath varchar(100) NOT NULL default '',\n\ttitle longtext NOT NULL,\n\tuser_login varchar(60) NOT NULL default '',\n\tuser_email varchar(100) NOT NULL default '',\n\tregistered datetime NOT NULL default '0000-00-00 00:00:00',\n\tactivated datetime NOT NULL default '0000-00-00 00:00:00',\n\tactive tinyint(1) NOT NULL default '0',\n\tactivation_key varchar(50) NOT NULL default '',\n\tmeta longtext,\n\tPRIMARY KEY  (signup_id),\n\tKEY activation_key (activation_key),\n\tKEY user_email (user_email),\n\tKEY user_login_email (user_login,user_email),\n\tKEY domain_path (domain(140),path(51))\n) {$charset_collate};";
    switch ($scope) {
        case 'blog':
            $queries = $blog_tables;
            break;
        case 'global':
            $queries = $global_tables;
            if ($is_multisite) {
                $queries .= $ms_global_tables;
            }
            break;
        case 'ms_global':
            $queries = $ms_global_tables;
            break;
        case 'all':
        default:
            $queries = $global_tables . $blog_tables;
            if ($is_multisite) {
                $queries .= $ms_global_tables;
            }
            break;
    }
    if (isset($old_blog_id)) {
        $wpdb->set_blog_id($old_blog_id);
    }
    return $queries;
}
// Populate for back compat.
$wp_queries = wp_get_db_schema('all');
/**
 * Create WordPress options and set the default values.
 *
 * @since 1.5.0
 * @since 5.1.0 The $options parameter has been added.
 *
 * @global wpdb $wpdb                  WordPress database abstraction object.
 * @global int  $wp_db_version         WordPress database version.
 * @global int  $wp_current_db_version The old (current) database version.
 *
 * @param array $options Optional. Custom option $key => $value pairs to use. Default empty array.
 */
function populate_options(array $options = array())
{
    global $wpdb, $wp_db_version, $wp_current_db_version;
    $guessurl = wp_guess_url();
    /**
     * Fires before creating WordPress options and populating their default values.
     *
     * @since 2.6.0
     */
    do_action('populate_options');
    // If WP_DEFAULT_THEME doesn't exist, fall back to the latest core default theme.
    $stylesheet = WP_DEFAULT_THEME;
    $template = WP_DEFAULT_THEME;
    $theme = wp_get_theme(WP_DEFAULT_THEME);
    if (!$theme->exists()) {
        $theme = WP_Theme::get_core_default_theme();
    }
    // If we can't find a core default theme, WP_DEFAULT_THEME is the best we can do.
    if ($theme) {
        $stylesheet = $theme->get_stylesheet();
        $template = $theme->get_template();
    }
    $timezone_string = '';
    $gmt_offset = 0;
    /*
     * translators: default GMT offset or timezone string. Must be either a valid offset (-12 to 14)
     * or a valid timezone string (America/New_York). See https://www.php.net/manual/en/timezones.php
     * for all timezone strings supported by PHP.
     */
    $offset_or_tz = _x('0', 'default GMT offset or timezone string');
    // phpcs:ignore WordPress.WP.I18n.NoEmptyStrings
    if (is_numeric($offset_or_tz)) {
        $gmt_offset = $offset_or_tz;
    } elseif ($offset_or_tz && in_array($offset_or_tz, timezone_identifiers_list(), true)) {
        $timezone_string = $offset_or_tz;
    }
    $defaults = array(
        'siteurl' => $guessurl,
        'home' => $guessurl,
        'blogname' => __('My Site'),
        /* translators: Site tagline. */
        'blogdescription' => __('Just another WordPress site'),
        'users_can_register' => 0,
        'admin_email' => 'you@example.com',
        /* translators: Default start of the week. 0 = Sunday, 1 = Monday. */
        'start_of_week' => _x('1', 'start of week'),
        'use_balanceTags' => 0,
        'use_smilies' => 1,
        'require_name_email' => 1,
        'comments_notify' => 1,
        'posts_per_rss' => 10,
        'rss_use_excerpt' => 0,
        'mailserver_url' => 'mail.example.com',
        'mailserver_login' => 'login@example.com',
        'mailserver_pass' => 'password',
        'mailserver_port' => 110,
        'default_category' => 1,
        'default_comment_status' => 'open',
        'default_ping_status' => 'open',
        'default_pingback_flag' => 1,
        'posts_per_page' => 10,
        /* translators: Default date format, see https://www.php.net/manual/datetime.format.php */
        'date_format' => __('F j, Y'),
        /* translators: Default time format, see https://www.php.net/manual/datetime.format.php */
        'time_format' => __('g:i a'),
        /* translators: Links last updated date format, see https://www.php.net/manual/datetime.format.php */
        'links_updated_date_format' => __('F j, Y g:i a'),
        'comment_moderation' => 0,
        'moderation_notify' => 1,
        'permalink_structure' => '',
        'rewrite_rules' => '',
        'hack_file' => 0,
        'blog_charset' => 'UTF-8',
        'moderation_keys' => '',
        'active_plugins' => array(),
        'category_base' => '',
        'ping_sites' => 'http://rpc.pingomatic.com/',
        'comment_max_links' => 2,
        'gmt_offset' => $gmt_offset,
        // 1.5.0
        'default_email_category' => 1,
        'recently_edited' => '',
        'template' => $template,
        'stylesheet' => $stylesheet,
        'comment_registration' => 0,
        'html_type' => 'text/html',
        // 1.5.1
        'use_trackback' => 0,
        // 2.0.0
        'default_role' => 'subscriber',
        'db_version' => $wp_db_version,
        // 2.0.1
        'uploads_use_yearmonth_folders' => 1,
        'upload_path' => '',
        // 2.1.0
        'blog_public' => '1',
        'default_link_category' => 2,
        'show_on_front' => 'posts',
        // 2.2.0
        'tag_base' => '',
        // 2.5.0
        'show_avatars' => '1',
        'avatar_rating' => 'G',
        'upload_url_path' => '',
        'thumbnail_size_w' => 150,
        'thumbnail_size_h' => 150,
        'thumbnail_crop' => 1,
        'medium_size_w' => 300,
        'medium_size_h' => 300,
        // 2.6.0
        'avatar_default' => 'mystery',
        // 2.7.0
        'large_size_w' => 1024,
        'large_size_h' => 1024,
        'image_default_link_type' => 'none',
        'image_default_size' => '',
        'image_default_align' => '',
        'close_comments_for_old_posts' => 0,
        'close_comments_days_old' => 14,
        'thread_comments' => 1,
        'thread_comments_depth' => 5,
        'page_comments' => 0,
        'comments_per_page' => 50,
        'default_comments_page' => 'newest',
        'comment_order' => 'asc',
        'sticky_posts' => array(),
        'widget_categories' => array(),
        'widget_text' => array(),
        'widget_rss' => array(),
        'uninstall_plugins' => array(),
        // 2.8.0
        'timezone_string' => $timezone_string,
        // 3.0.0
        'page_for_posts' => 0,
        'page_on_front' => 0,
        // 3.1.0
        'default_post_format' => 0,
        // 3.5.0
        'link_manager_enabled' => 0,
        // 4.3.0
        'finished_splitting_shared_terms' => 1,
        'site_icon' => 0,
        // 4.4.0
        'medium_large_size_w' => 768,
        'medium_large_size_h' => 0,
        // 4.9.6
        'wp_page_for_privacy_policy' => 0,
        // 4.9.8
        'show_comments_cookies_opt_in' => 1,
        // 5.3.0
        'admin_email_lifespan' => time() + 6 * MONTH_IN_SECONDS,
        // 5.5.0
        'disallowed_keys' => '',
        'comment_previously_approved' => 1,
        'auto_plugin_theme_update_emails' => array(),
        // 5.6.0
        'auto_update_core_dev' => 'enabled',
        'auto_update_core_minor' => 'enabled',
        // Default to enabled for new installs.
        // See https://core.trac.wordpress.org/ticket/51742.
        'auto_update_core_major' => 'enabled',
    );
    // 3.3.0
    if (!is_multisite()) {
        $defaults['initial_db_version'] = !empty($wp_current_db_version) && $wp_current_db_version < $wp_db_version ? $wp_current_db_version : $wp_db_version;
    }
    // 3.0.0 multisite.
    if (is_multisite()) {
        /* translators: %s: Network title. */
        $defaults['blogdescription'] = sprintf(__('Just another %s site'), get_network()->site_name);
        $defaults['permalink_structure'] = '/%year%/%monthnum%/%day%/%postname%/';
    }
    $options = wp_parse_args($options, $defaults);
    // Set autoload to no for these options.
    $fat_options = array('moderation_keys', 'recently_edited', 'disallowed_keys', 'uninstall_plugins', 'auto_plugin_theme_update_emails');
    $keys = "'" . implode("', '", array_keys($options)) . "'";
    $existing_options = $wpdb->get_col("SELECT option_name FROM {$wpdb->options} WHERE option_name in ( {$keys} )");
    // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
    $insert = '';
    foreach ($options as $option => $value) {
        if (in_array($option, $existing_options, true)) {
            continue;
        }
        if (in_array($option, $fat_options, true)) {
            $autoload = 'no';
        } else {
            $autoload = 'yes';
        }
        if (is_array($value)) {
            $value = serialize($value);
        }
        if (!empty($insert)) {
            $insert .= ', ';
        }
        $insert .= $wpdb->prepare('(%s, %s, %s)', $option, $value, $autoload);
    }
    if (!empty($insert)) {
        $wpdb->query("INSERT INTO {$wpdb->options} (option_name, option_value, autoload) VALUES " . $insert);
        // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
    }
    // In case it is set, but blank, update "home".
    if (!__get_option('home')) {
        update_option('home', $guessurl);
    }
    // Delete unused options.
    $unusedoptions = array('blodotgsping_url', 'bodyterminator', 'emailtestonly', 'phoneemail_separator', 'smilies_directory', 'subjectprefix', 'use_bbcode', 'use_blodotgsping', 'use_phoneemail', 'use_quicktags', 'use_weblogsping', 'weblogs_cache_file', 'use_preview', 'use_htmltrans', 'smilies_directory', 'fileupload_allowedusers', 'use_phoneemail', 'default_post_status', 'default_post_category', 'archive_mode', 'time_difference', 'links_minadminlevel', 'links_use_adminlevels', 'links_rating_type', 'links_rating_char', 'links_rating_ignore_zero', 'links_rating_single_image', 'links_rating_image0', 'links_rating_image1', 'links_rating_image2', 'links_rating_image3', 'links_rating_image4', 'links_rating_image5', 'links_rating_image6', 'links_rating_image7', 'links_rating_image8', 'links_rating_image9', 'links_recently_updated_time', 'links_recently_updated_prepend', 'links_recently_updated_append', 'weblogs_cacheminutes', 'comment_allowed_tags', 'search_engine_friendly_urls', 'default_geourl_lat', 'default_geourl_lon', 'use_default_geourl', 'weblogs_xml_url', 'new_users_can_blog', '_wpnonce', '_wp_http_referer', 'Update', 'action', 'rich_editing', 'autosave_interval', 'deactivated_plugins', 'can_compress_scripts', 'page_uris', 'update_core', 'update_plugins', 'update_themes', 'doing_cron', 'random_seed', 'rss_excerpt_length', 'secret', 'use_linksupdate', 'default_comment_status_page', 'wporg_popular_tags', 'what_to_show', 'rss_language', 'language', 'enable_xmlrpc', 'enable_app', 'embed_autourls', 'default_post_edit_rows', 'gzipcompression', 'advanced_edit');
    foreach ($unusedoptions as $option) {
        delete_option($option);
    }
    // Delete obsolete magpie stuff.
    $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name REGEXP '^rss_[0-9a-f]{32}(_ts)?\$'");
    // Clear expired transients.
    delete_expired_transients(true);
}
/**
 * Execute WordPress role creation for the various WordPress versions.
 *
 * @since 2.0.0
 */
function populate_roles()
{
    populate_roles_160();
    populate_roles_210();
    populate_roles_230();
    populate_roles_250();
    populate_roles_260();
    populate_roles_270();
    populate_roles_280();
    populate_roles_300();
}
/**
 * Create the roles for WordPress 2.0
 *
 * @since 2.0.0
 */
function populate_roles_160()
{
    // Add roles.
    add_role('administrator', 'Administrator');
    add_role('editor', 'Editor');
    add_role('author', 'Author');
    add_role('contributor', 'Contributor');
    add_role('subscriber', 'Subscriber');
    // Add caps for Administrator role.
    $role = get_role('administrator');
    $role->add_cap('switch_themes');
    $role->add_cap('edit_themes');
    $role->add_cap('activate_plugins');
    $role->add_cap('edit_plugins');
    $role->add_cap('edit_users');
    $role->add_cap('edit_files');
    $role->add_cap('manage_options');
    $role->add_cap('moderate_comments');
    $role->add_cap('manage_categories');
    $role->add_cap('manage_links');
    $role->add_cap('upload_files');
    $role->add_cap('import');
    $role->add_cap('unfiltered_html');
    $role->add_cap('edit_posts');
    $role->add_cap('edit_others_posts');
    $role->add_cap('edit_published_posts');
    $role->add_cap('publish_posts');
    $role->add_cap('edit_pages');
    $role->add_cap('read');
    $role->add_cap('level_10');
    $role->add_cap('level_9');
    $role->add_cap('level_8');
    $role->add_cap('level_7');
    $role->add_cap('level_6');
    $role->add_cap('level_5');
    $role->add_cap('level_4');
    $role->add_cap('level_3');
    $role->add_cap('level_2');
    $role->add_cap('level_1');
    $role->add_cap('level_0');
    // Add caps for Editor role.
    $role = get_role('editor');
    $role->add_cap('moderate_comments');
    $role->add_cap('manage_categories');
    $role->add_cap('manage_links');
    $role->add_cap('upload_files');
    $role->add_cap('unfiltered_html');
    $role->add_cap('edit_posts');
    $role->add_cap('edit_others_posts');
    $role->add_cap('edit_published_posts');
    $role->add_cap('publish_posts');
    $role->add_cap('edit_pages');
    $role->add_cap('read');
    $role->add_cap('level_7');
    $role->add_cap('level_6');
    $role->add_cap('level_5');
    $role->add_cap('level_4');
    $role->add_cap('level_3');
    $role->add_cap('level_2');
    $role->add_cap('level_1');
    $role->add_cap('level_0');
    // Add caps for Author role.
    $role = get_role('author');
    $role->add_cap('upload_files');
    $role->add_cap('edit_posts');
    $role->add_cap('edit_published_posts');
    $role->add_cap('publish_posts');
    $role->add_cap('read');
    $role->add_cap('level_2');
    $role->add_cap('level_1');
    $role->add_cap('level_0');
    // Add caps for Contributor role.
    $role = get_role('contributor');
    $role->add_cap('edit_posts');
    $role->add_cap('read');
    $role->add_cap('level_1');
    $role->add_cap('level_0');
    // Add caps for Subscriber role.
    $role = get_role('subscriber');
    $role->add_cap('read');
    $role->add_cap('level_0');
}
/**
 * Create and modify WordPress roles for WordPress 2.1.
 *
 * @since 2.1.0
 */
function populate_roles_210()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("populate_roles_210") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/schema.php at line 429")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called populate_roles_210:429@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/schema.php');
    die();
}
/**
 * Create and modify WordPress roles for WordPress 2.3.
 *
 * @since 2.3.0
 */
function populate_roles_230()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("populate_roles_230") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/schema.php at line 473")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called populate_roles_230:473@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/schema.php');
    die();
}
/**
 * Create and modify WordPress roles for WordPress 2.5.
 *
 * @since 2.5.0
 */
function populate_roles_250()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("populate_roles_250") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/schema.php at line 485")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called populate_roles_250:485@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/schema.php');
    die();
}
/**
 * Create and modify WordPress roles for WordPress 2.6.
 *
 * @since 2.6.0
 */
function populate_roles_260()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("populate_roles_260") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/schema.php at line 497")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called populate_roles_260:497@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/schema.php');
    die();
}
/**
 * Create and modify WordPress roles for WordPress 2.7.
 *
 * @since 2.7.0
 */
function populate_roles_270()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("populate_roles_270") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/schema.php at line 510")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called populate_roles_270:510@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/schema.php');
    die();
}
/**
 * Create and modify WordPress roles for WordPress 2.8.
 *
 * @since 2.8.0
 */
function populate_roles_280()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("populate_roles_280") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/schema.php at line 523")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called populate_roles_280:523@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/schema.php');
    die();
}
/**
 * Create and modify WordPress roles for WordPress 3.0.
 *
 * @since 3.0.0
 */
function populate_roles_300()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("populate_roles_300") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/schema.php at line 535")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called populate_roles_300:535@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/schema.php');
    die();
}
if (!function_exists('install_network')) {
    /**
     * Install Network.
     *
     * @since 3.0.0
     */
    function install_network()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("install_network") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/schema.php at line 554")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called install_network:554@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/schema.php');
        die();
    }
}
/**
 * Populate network settings.
 *
 * @since 3.0.0
 *
 * @global wpdb       $wpdb         WordPress database abstraction object.
 * @global object     $current_site
 * @global WP_Rewrite $wp_rewrite   WordPress rewrite component.
 *
 * @param int    $network_id        ID of network to populate.
 * @param string $domain            The domain name for the network (eg. "example.com").
 * @param string $email             Email address for the network administrator.
 * @param string $site_name         The name of the network.
 * @param string $path              Optional. The path to append to the network's domain name. Default '/'.
 * @param bool   $subdomain_install Optional. Whether the network is a subdomain installation or a subdirectory installation.
 *                                  Default false, meaning the network is a subdirectory installation.
 * @return bool|WP_Error True on success, or WP_Error on warning (with the installation otherwise successful,
 *                       so the error code must be checked) or failure.
 */
function populate_network($network_id = 1, $domain = '', $email = '', $site_name = '', $path = '/', $subdomain_install = false)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("populate_network") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/schema.php at line 581")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called populate_network:581@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/schema.php');
    die();
}
/**
 * Creates WordPress network meta and sets the default values.
 *
 * @since 5.1.0
 *
 * @global wpdb $wpdb          WordPress database abstraction object.
 * @global int  $wp_db_version WordPress database version.
 *
 * @param int   $network_id Network ID to populate meta for.
 * @param array $meta       Optional. Custom meta $key => $value pairs to use. Default empty array.
 */
function populate_network_meta($network_id, array $meta = array())
{
    global $wpdb, $wp_db_version;
    $network_id = (int) $network_id;
    $email = !empty($meta['admin_email']) ? $meta['admin_email'] : '';
    $subdomain_install = isset($meta['subdomain_install']) ? (int) $meta['subdomain_install'] : 0;
    // If a user with the provided email does not exist, default to the current user as the new network admin.
    $site_user = !empty($email) ? get_user_by('email', $email) : false;
    if (false === $site_user) {
        $site_user = wp_get_current_user();
    }
    if (empty($email)) {
        $email = $site_user->user_email;
    }
    $template = get_option('template');
    $stylesheet = get_option('stylesheet');
    $allowed_themes = array($stylesheet => true);
    if ($template != $stylesheet) {
        $allowed_themes[$template] = true;
    }
    if (WP_DEFAULT_THEME != $stylesheet && WP_DEFAULT_THEME != $template) {
        $allowed_themes[WP_DEFAULT_THEME] = true;
    }
    // If WP_DEFAULT_THEME doesn't exist, also include the latest core default theme.
    if (!wp_get_theme(WP_DEFAULT_THEME)->exists()) {
        $core_default = WP_Theme::get_core_default_theme();
        if ($core_default) {
            $allowed_themes[$core_default->get_stylesheet()] = true;
        }
    }
    if (function_exists('clean_network_cache')) {
        clean_network_cache($network_id);
    } else {
        wp_cache_delete($network_id, 'networks');
    }
    wp_cache_delete('networks_have_paths', 'site-options');
    if (!is_multisite()) {
        $site_admins = array($site_user->user_login);
        $users = get_users(array('fields' => array('user_login'), 'role' => 'administrator'));
        if ($users) {
            foreach ($users as $user) {
                $site_admins[] = $user->user_login;
            }
            $site_admins = array_unique($site_admins);
        }
    } else {
        $site_admins = get_site_option('site_admins');
    }
    /* translators: Do not translate USERNAME, SITE_NAME, BLOG_URL, PASSWORD: those are placeholders. */
    $welcome_email = __('Howdy USERNAME,

Your new SITE_NAME site has been successfully set up at:
BLOG_URL

You can log in to the administrator account with the following information:

Username: USERNAME
Password: PASSWORD
Log in here: BLOG_URLwp-login.php

We hope you enjoy your new site. Thanks!

--The Team @ SITE_NAME');
    $misc_exts = array(
        // Images.
        'jpg',
        'jpeg',
        'png',
        'gif',
        // Video.
        'mov',
        'avi',
        'mpg',
        '3gp',
        '3g2',
        // "audio".
        'midi',
        'mid',
        // Miscellaneous.
        'pdf',
        'doc',
        'ppt',
        'odt',
        'pptx',
        'docx',
        'pps',
        'ppsx',
        'xls',
        'xlsx',
        'key',
    );
    $audio_exts = wp_get_audio_extensions();
    $video_exts = wp_get_video_extensions();
    $upload_filetypes = array_unique(array_merge($misc_exts, $audio_exts, $video_exts));
    $sitemeta = array(
        'site_name' => __('My Network'),
        'admin_email' => $email,
        'admin_user_id' => $site_user->ID,
        'registration' => 'none',
        'upload_filetypes' => implode(' ', $upload_filetypes),
        'blog_upload_space' => 100,
        'fileupload_maxk' => 1500,
        'site_admins' => $site_admins,
        'allowedthemes' => $allowed_themes,
        'illegal_names' => array('www', 'web', 'root', 'admin', 'main', 'invite', 'administrator', 'files'),
        'wpmu_upgrade_site' => $wp_db_version,
        'welcome_email' => $welcome_email,
        /* translators: %s: Site link. */
        'first_post' => __('Welcome to %s. This is your first post. Edit or delete it, then start writing!'),
        // @todo - Network admins should have a method of editing the network siteurl (used for cookie hash).
        'siteurl' => get_option('siteurl') . '/',
        'add_new_users' => '0',
        'upload_space_check_disabled' => is_multisite() ? get_site_option('upload_space_check_disabled') : '1',
        'subdomain_install' => $subdomain_install,
        'global_terms_enabled' => global_terms_enabled() ? '1' : '0',
        'ms_files_rewriting' => is_multisite() ? get_site_option('ms_files_rewriting') : '0',
        'initial_db_version' => get_option('initial_db_version'),
        'active_sitewide_plugins' => array(),
        'WPLANG' => get_locale(),
    );
    if (!$subdomain_install) {
        $sitemeta['illegal_names'][] = 'blog';
    }
    $sitemeta = wp_parse_args($meta, $sitemeta);
    /**
     * Filters meta for a network on creation.
     *
     * @since 3.7.0
     *
     * @param array $sitemeta   Associative array of network meta keys and values to be inserted.
     * @param int   $network_id ID of network to populate.
     */
    $sitemeta = apply_filters('populate_network_meta', $sitemeta, $network_id);
    $insert = '';
    foreach ($sitemeta as $meta_key => $meta_value) {
        if (is_array($meta_value)) {
            $meta_value = serialize($meta_value);
        }
        if (!empty($insert)) {
            $insert .= ', ';
        }
        $insert .= $wpdb->prepare('( %d, %s, %s)', $network_id, $meta_key, $meta_value);
    }
    $wpdb->query("INSERT INTO {$wpdb->sitemeta} ( site_id, meta_key, meta_value ) VALUES " . $insert);
    // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
}
/**
 * Creates WordPress site meta and sets the default values.
 *
 * @since 5.1.0
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 *
 * @param int   $site_id Site ID to populate meta for.
 * @param array $meta    Optional. Custom meta $key => $value pairs to use. Default empty array.
 */
function populate_site_meta($site_id, array $meta = array())
{
    global $wpdb;
    $site_id = (int) $site_id;
    if (!is_site_meta_supported()) {
        return;
    }
    if (empty($meta)) {
        return;
    }
    /**
     * Filters meta for a site on creation.
     *
     * @since 5.2.0
     *
     * @param array $meta    Associative array of site meta keys and values to be inserted.
     * @param int   $site_id ID of site to populate.
     */
    $site_meta = apply_filters('populate_site_meta', $meta, $site_id);
    $insert = '';
    foreach ($site_meta as $meta_key => $meta_value) {
        if (is_array($meta_value)) {
            $meta_value = serialize($meta_value);
        }
        if (!empty($insert)) {
            $insert .= ', ';
        }
        $insert .= $wpdb->prepare('( %d, %s, %s)', $site_id, $meta_key, $meta_value);
    }
    $wpdb->query("INSERT INTO {$wpdb->blogmeta} ( blog_id, meta_key, meta_value ) VALUES " . $insert);
    // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
    wp_cache_delete($site_id, 'blog_meta');
    wp_cache_set_sites_last_changed();
}