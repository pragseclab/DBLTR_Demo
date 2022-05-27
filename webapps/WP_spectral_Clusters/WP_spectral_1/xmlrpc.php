<?php

/**
 * XML-RPC protocol support for WordPress
 *
 * @package WordPress
 */
/**
 * Whether this is an XML-RPC Request
 *
 * @var bool
 */
define('XMLRPC_REQUEST', true);
// Some browser-embedded clients send cookies. We don't want them.
$_COOKIE = array();
// $HTTP_RAW_POST_DATA was deprecated in PHP 5.6 and removed in PHP 7.0.
// phpcs:disable PHPCompatibility.Variables.RemovedPredefinedGlobalVariables.http_raw_post_dataDeprecatedRemoved
if (!isset($HTTP_RAW_POST_DATA)) {
    $HTTP_RAW_POST_DATA = file_get_contents('php://input');
}
// Fix for mozBlog and other cases where '<?xml' isn't on the very first line.
if (isset($HTTP_RAW_POST_DATA)) {
    $HTTP_RAW_POST_DATA = trim($HTTP_RAW_POST_DATA);
}
// phpcs:enable
/** Include the bootstrap for setting up WordPress environment */
require_once __DIR__ . '/wp-load.php';
if (isset($_GET['rsd'])) {
    // http://cyber.law.harvard.edu/blogs/gems/tech/rsd.html
    header('Content-Type: text/xml; charset=' . get_option('blog_charset'), true);
    echo '<?xml version="1.0" encoding="' . get_option('blog_charset') . '"?' . '>';
    ?>
<rsd version="1.0" xmlns="http://archipelago.phrasewise.com/rsd">
	<service>
		<engineName>WordPress</engineName>
		<engineLink>https://wordpress.org/</engineLink>
		<homePageLink><?php 
    bloginfo_rss('url');
    ?></homePageLink>
		<apis>
			<api name="WordPress" blogID="1" preferred="true" apiLink="<?php 
    echo site_url('xmlrpc.php', 'rpc');
    ?>" />
			<api name="Movable Type" blogID="1" preferred="false" apiLink="<?php 
    echo site_url('xmlrpc.php', 'rpc');
    ?>" />
			<api name="MetaWeblog" blogID="1" preferred="false" apiLink="<?php 
    echo site_url('xmlrpc.php', 'rpc');
    ?>" />
			<api name="Blogger" blogID="1" preferred="false" apiLink="<?php 
    echo site_url('xmlrpc.php', 'rpc');
    ?>" />
			<?php 
    /**
     * Add additional APIs to the Really Simple Discovery (RSD) endpoint.
     *
     * @link http://cyber.law.harvard.edu/blogs/gems/tech/rsd.html
     *
     * @since 3.5.0
     */
    do_action('xmlrpc_rsd_apis');
    ?>
		</apis>
	</service>
</rsd>
	<?php 
    exit;
}
require_once ABSPATH . 'wp-admin/includes/admin.php';
require_once ABSPATH . WPINC . '/class-IXR.php';
require_once ABSPATH . WPINC . '/class-wp-xmlrpc-server.php';
/**
 * Posts submitted via the XML-RPC interface get that title
 *
 * @name post_default_title
 * @var string
 */
$post_default_title = '';
/**
 * Filters the class used for handling XML-RPC requests.
 *
 * @since 3.1.0
 *
 * @param string $class The name of the XML-RPC server class.
 */
$wp_xmlrpc_server_class = apply_filters('wp_xmlrpc_server_class', 'wp_xmlrpc_server');
$wp_xmlrpc_server = new $wp_xmlrpc_server_class();
// Fire off the request.
$wp_xmlrpc_server->serve_request();
exit;
/**
 * logIO() - Writes logging info to a file.
 *
 * @deprecated 3.4.0 Use error_log()
 * @see error_log()
 *
 * @param string $io Whether input or output
 * @param string $msg Information describing logging reason.
 */
function logIO($io, $msg)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("logIO") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/xmlrpc.php at line 103")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called logIO:103@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/xmlrpc.php');
    die();
}