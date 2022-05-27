<?php

if ( (!empty( $_SERVER['HTTP_X_FORWARDED_HOST'])) ||
     (!empty( $_SERVER['HTTP_X_FORWARDED_FOR'])) ) {

    // http://wordpress.org/support/topic/wordpress-behind-reverse-proxy-1
    $_SERVER['HTTP_HOST'] = $_SERVER['HTTP_X_FORWARDED_HOST'];

    define('WP_HOME', 'http://localhost:8080');
    define('WP_SITEURL', 'http://localhost:8080');
}

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress');
/** MySQL database username */
define('DB_USER', 'root');
/** MySQL database password */
define('DB_PASSWORD', 'root');
/** MySQL hostname */
define('DB_HOST', 'db');
/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');
/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');
/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', 'sEL@E{Wuu^FyTV2[A3.@FxR[hGd$NGftCj9tF]F47Q 9,>,m1>Fgt]6U=G]uX: d');
define('SECURE_AUTH_KEY', 'Fb6:G^rg;dS>J~-:9,T#A 9D5MKCR93@,pF.=A&JhcapLbnR_V/P^kz4[IT.-BA9');
define('LOGGED_IN_KEY', 'rg?bnB7CK<!A8DrnG6SZ=Lz8L1>k@~1?PGOSV:x3l=Ze=HZsdXe{{}wdDN2U8J,O');
define('NONCE_KEY', 'T .hN4m9`R=u%9lv+JQ>rf_7R3ZfGs{x22IWRoAfzcL3j~AmvICT> d/z=8zc]fb');
define('AUTH_SALT', 'zA6#.4V}5Xem9zO5ima!(=Homq7LV90xs fmpHNCRKOdy`)tI94yJ6EOx^M60J}G');
define('SECURE_AUTH_SALT', 'P6SfRx`FO70CY}593,Ump(ANcF!#qjNSWDQx<}W^mV9:_4z/!<|6bpsc)cEoW)H3');
define('LOGGED_IN_SALT', 'AiS!=Azdmvf^$!hI1`1TuJ]dFBF(X$)|q<FpVUsi!?zmOGh8C^7*:QM9Yr}~D+Q9');
define('NONCE_SALT', 'P8q 5=F&;g=]/QvIr#NK{@P$*hZkO#*BV<S@J1aiDwn#ZFJLC!7`qZ6VvAz)pPZ+');
/**#@-*/
/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';
/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define('WP_DEBUG', false);
/* That's all, stop editing! Happy publishing. */
/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}
/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
