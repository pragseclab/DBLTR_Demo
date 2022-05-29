<?php

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Hold the PMA\libraries\Util class
 *
 * @package PhpMyAdmin
 */
namespace PMA\libraries;

use PMA\libraries\plugins\ImportPlugin;
use PhpMyAdmin\SqlParser\Context;
use PhpMyAdmin\SqlParser\Lexer;
use PhpMyAdmin\SqlParser\Parser;
use PhpMyAdmin\SqlParser\Token;
use stdClass;
use PMA\libraries\URL;
use PMA\libraries\Sanitize;
use PMA\libraries\Template;
use PhpMyAdmin\SqlParser\Utils\Error as ParserError;
if (!defined('PHPMYADMIN')) {
    exit;
}
/**
 * Misc functions used all over the scripts.
 *
 * @package PhpMyAdmin
 */
class Util
{
    /**
     * Checks whether configuration value tells to show icons.
     *
     * @param string $value Configuration option name
     *
     * @return boolean Whether to show icons.
     */
    public static function showIcons($value)
    {
        return in_array($GLOBALS['cfg'][$value], array('icons', 'both'));
    }
    /**
     * Checks whether configuration value tells to show text.
     *
     * @param string $value Configuration option name
     *
     * @return boolean Whether to show text.
     */
    public static function showText($value)
    {
        return in_array($GLOBALS['cfg'][$value], array('text', 'both'));
    }
    /**
     * Returns an HTML IMG tag for a particular icon from a theme,
     * which may be an actual file or an icon from a sprite.
     * This function takes into account the ActionLinksMode
     * configuration setting and wraps the image tag in a span tag.
     *
     * @param string  $icon          name of icon file
     * @param string  $alternate     alternate text
     * @param boolean $force_text    whether to force alternate text to be displayed
     * @param boolean $menu_icon     whether this icon is for the menu bar or not
     * @param string  $control_param which directive controls the display
     *
     * @return string an html snippet
     */
    public static function getIcon($icon, $alternate = '', $force_text = false, $menu_icon = false, $control_param = 'ActionLinksMode')
    {
        $include_icon = $include_text = false;
        if (self::showIcons($control_param)) {
            $include_icon = true;
        }
        if ($force_text || self::showText($control_param)) {
            $include_text = true;
        }
        // Sometimes use a span (we rely on this in js/sql.js). But for menu bar
        // we don't need a span
        $button = $menu_icon ? '' : '<span class="nowrap">';
        if ($include_icon) {
            $button .= self::getImage($icon, $alternate);
        }
        if ($include_icon && $include_text) {
            $button .= '&nbsp;';
        }
        if ($include_text) {
            $button .= $alternate;
        }
        $button .= $menu_icon ? '' : '</span>';
        return $button;
    }
    /**
     * Returns an HTML IMG tag for a particular image from a theme,
     * which may be an actual file or an icon from a sprite
     *
     * @param string $image      The name of the file to get
     * @param string $alternate  Used to set 'alt' and 'title' attributes
     *                           of the image
     * @param array  $attributes An associative array of other attributes
     *
     * @return string an html IMG tag
     */
    public static function getImage($image, $alternate = '', $attributes = array())
    {
        static $sprites;
        // cached list of available sprites (if any)
        if (defined('TESTSUITE')) {
            // prevent caching in testsuite
            unset($sprites);
        }
        $is_sprite = false;
        $alternate = htmlspecialchars($alternate);
        // If it's the first time this function is called
        if (!isset($sprites)) {
            $sprites = array();
            // Try to load the list of sprites
            if (isset($_SESSION['PMA_Theme'])) {
                $sprites = $_SESSION['PMA_Theme']->getSpriteData();
            }
        }
        // Check if we have the requested image as a sprite
        //  and set $url accordingly
        $class = str_replace(array('.gif', '.png'), '', $image);
        if (array_key_exists($class, $sprites)) {
            $is_sprite = true;
            $url = (defined('PMA_TEST_THEME') ? '../' : '') . 'themes/dot.gif';
        } elseif (isset($GLOBALS['pmaThemeImage'])) {
            $url = $GLOBALS['pmaThemeImage'] . $image;
        } else {
            $url = './themes/pmahomme/' . $image;
        }
        // set class attribute
        if ($is_sprite) {
            if (isset($attributes['class'])) {
                $attributes['class'] = "icon ic_{$class} " . $attributes['class'];
            } else {
                $attributes['class'] = "icon ic_{$class}";
            }
        }
        // set all other attributes
        $attr_str = '';
        foreach ($attributes as $key => $value) {
            if (!in_array($key, array('alt', 'title'))) {
                $attr_str .= " {$key}=\"{$value}\"";
            }
        }
        // override the alt attribute
        if (isset($attributes['alt'])) {
            $alt = $attributes['alt'];
        } else {
            $alt = $alternate;
        }
        // override the title attribute
        if (isset($attributes['title'])) {
            $title = $attributes['title'];
        } else {
            $title = $alternate;
        }
        // generate the IMG tag
        $template = '<img src="%s" title="%s" alt="%s"%s />';
        $retval = sprintf($template, $url, $title, $alt, $attr_str);
        return $retval;
    }
    /**
     * Returns the formatted maximum size for an upload
     *
     * @param integer $max_upload_size the size
     *
     * @return string the message
     *
     * @access  public
     */
    public static function getFormattedMaximumUploadSize($max_upload_size)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getFormattedMaximumUploadSize") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php at line 197")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getFormattedMaximumUploadSize:197@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php');
        die();
    }
    /**
     * Generates a hidden field which should indicate to the browser
     * the maximum size for upload
     *
     * @param integer $max_size the size
     *
     * @return string the INPUT field
     *
     * @access  public
     */
    public static function generateHiddenMaxFileSize($max_size)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("generateHiddenMaxFileSize") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php at line 213")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called generateHiddenMaxFileSize:213@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php');
        die();
    }
    /**
     * Add slashes before "_" and "%" characters for using them in MySQL
     * database, table and field names.
     * Note: This function does not escape backslashes!
     *
     * @param string $name the string to escape
     *
     * @return string the escaped string
     *
     * @access  public
     */
    public static function escapeMysqlWildcards($name)
    {
        return strtr($name, array('_' => '\\_', '%' => '\\%'));
    }
    // end of the 'escapeMysqlWildcards()' function
    /**
     * removes slashes before "_" and "%" characters
     * Note: This function does not unescape backslashes!
     *
     * @param string $name the string to escape
     *
     * @return string   the escaped string
     *
     * @access  public
     */
    public static function unescapeMysqlWildcards($name)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("unescapeMysqlWildcards") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php at line 245")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called unescapeMysqlWildcards:245@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php');
        die();
    }
    // end of the 'unescapeMysqlWildcards()' function
    /**
     * removes quotes (',",`) from a quoted string
     *
     * checks if the string is quoted and removes this quotes
     *
     * @param string $quoted_string string to remove quotes from
     * @param string $quote         type of quote to remove
     *
     * @return string unqoted string
     */
    public static function unQuote($quoted_string, $quote = null)
    {
        $quotes = array();
        if ($quote === null) {
            $quotes[] = '`';
            $quotes[] = '"';
            $quotes[] = "'";
        } else {
            $quotes[] = $quote;
        }
        foreach ($quotes as $quote) {
            if (mb_substr($quoted_string, 0, 1) === $quote && mb_substr($quoted_string, -1, 1) === $quote) {
                $unquoted_string = mb_substr($quoted_string, 1, -1);
                // replace escaped quotes
                $unquoted_string = str_replace($quote . $quote, $quote, $unquoted_string);
                return $unquoted_string;
            }
        }
        return $quoted_string;
    }
    /**
     * format sql strings
     *
     * @param string  $sqlQuery raw SQL string
     * @param boolean $truncate truncate the query if it is too long
     *
     * @return string the formatted sql
     *
     * @global array  $cfg the configuration array
     *
     * @access  public
     * @todo    move into PMA_Sql
     */
    public static function formatSql($sqlQuery, $truncate = false)
    {
        global $cfg;
        if ($truncate && mb_strlen($sqlQuery) > $cfg['MaxCharactersInDisplayedSQL']) {
            $sqlQuery = mb_substr($sqlQuery, 0, $cfg['MaxCharactersInDisplayedSQL']) . '[...]';
        }
        return '<code class="sql"><pre>' . "\n" . htmlspecialchars($sqlQuery) . "\n" . '</pre></code>';
    }
    // end of the "formatSql()" function
    /**
     * Displays a link to the documentation as an icon
     *
     * @param string  $link   documentation link
     * @param string  $target optional link target
     * @param boolean $bbcode optional flag indicating whether to output bbcode
     *
     * @return string the html link
     *
     * @access public
     */
    public static function showDocLink($link, $target = 'documentation', $bbcode = false)
    {
        if ($bbcode) {
            return "[a@{$link}@{$target}][dochelpicon][/a]";
        } else {
            return '<a href="' . $link . '" target="' . $target . '">' . self::getImage('b_help.png', __('Documentation')) . '</a>';
        }
    }
    // end of the 'showDocLink()' function
    /**
     * Get a URL link to the official MySQL documentation
     *
     * @param string $link   contains name of page/anchor that is being linked
     * @param string $anchor anchor to page part
     *
     * @return string  the URL link
     *
     * @access  public
     */
    public static function getMySQLDocuURL($link, $anchor = '')
    {
        // Fixup for newly used names:
        $link = str_replace('_', '-', mb_strtolower($link));
        if (empty($link)) {
            $link = 'index';
        }
        $mysql = '5.5';
        $lang = 'en';
        if (defined('PMA_MYSQL_INT_VERSION')) {
            if (PMA_MYSQL_INT_VERSION >= 50700) {
                $mysql = '5.7';
            } elseif (PMA_MYSQL_INT_VERSION >= 50600) {
                $mysql = '5.6';
            } elseif (PMA_MYSQL_INT_VERSION >= 50500) {
                $mysql = '5.5';
            }
        }
        $url = 'https://dev.mysql.com/doc/refman/' . $mysql . '/' . $lang . '/' . $link . '.html';
        if (!empty($anchor)) {
            $url .= '#' . $anchor;
        }
        return PMA_linkURL($url);
    }
    /**
     * Displays a link to the official MySQL documentation
     *
     * @param string $link      contains name of page/anchor that is being linked
     * @param bool   $big_icon  whether to use big icon (like in left frame)
     * @param string $anchor    anchor to page part
     * @param bool   $just_open whether only the opening <a> tag should be returned
     *
     * @return string  the html link
     *
     * @access  public
     */
    public static function showMySQLDocu($link, $big_icon = false, $anchor = '', $just_open = false)
    {
        $url = self::getMySQLDocuURL($link, $anchor);
        $open_link = '<a href="' . $url . '" target="mysql_doc">';
        if ($just_open) {
            return $open_link;
        } elseif ($big_icon) {
            return $open_link . self::getImage('b_sqlhelp.png', __('Documentation')) . '</a>';
        } else {
            return self::showDocLink($url, 'mysql_doc');
        }
    }
    // end of the 'showMySQLDocu()' function
    /**
     * Returns link to documentation.
     *
     * @param string $page   Page in documentation
     * @param string $anchor Optional anchor in page
     *
     * @return string URL
     */
    public static function getDocuLink($page, $anchor = '')
    {
        /* Construct base URL */
        $url = $page . '.html';
        if (!empty($anchor)) {
            $url .= '#' . $anchor;
        }
        /* Check if we have built local documentation */
        if (defined('TESTSUITE')) {
            /* Provide consistent URL for testsuite */
            return PMA_linkURL('https://docs.phpmyadmin.net/en/latest/' . $url);
        } elseif (@file_exists('doc/html/index.html')) {
            if (defined('PMA_SETUP')) {
                return '../doc/html/' . $url;
            } else {
                return './doc/html/' . $url;
            }
        } else {
            /* TODO: Should link to correct branch for released versions */
            return PMA_linkURL('https://docs.phpmyadmin.net/en/latest/' . $url);
        }
    }
    /**
     * Displays a link to the phpMyAdmin documentation
     *
     * @param string  $page   Page in documentation
     * @param string  $anchor Optional anchor in page
     * @param boolean $bbcode Optional flag indicating whether to output bbcode
     *
     * @return string  the html link
     *
     * @access  public
     */
    public static function showDocu($page, $anchor = '', $bbcode = false)
    {
        return self::showDocLink(self::getDocuLink($page, $anchor), 'documentation', $bbcode);
    }
    // end of the 'showDocu()' function
    /**
     * Displays a link to the PHP documentation
     *
     * @param string $target anchor in documentation
     *
     * @return string  the html link
     *
     * @access  public
     */
    public static function showPHPDocu($target)
    {
        $url = PMA_getPHPDocLink($target);
        return self::showDocLink($url);
    }
    // end of the 'showPHPDocu()' function
    /**
     * Returns HTML code for a tooltip
     *
     * @param string $message the message for the tooltip
     *
     * @return string
     *
     * @access  public
     */
    public static function showHint($message)
    {
        if ($GLOBALS['cfg']['ShowHint']) {
            $classClause = ' class="pma_hint"';
        } else {
            $classClause = '';
        }
        return '<span' . $classClause . '>' . self::getImage('b_help.png') . '<span class="hide">' . $message . '</span>' . '</span>';
    }
    /**
     * Displays a MySQL error message in the main panel when $exit is true.
     * Returns the error message otherwise.
     *
     * @param string|bool $server_msg     Server's error message.
     * @param string      $sql_query      The SQL query that failed.
     * @param bool        $is_modify_link Whether to show a "modify" link or not.
     * @param string      $back_url       URL for the "back" link (full path is
     *                                    not required).
     * @param bool        $exit           Whether execution should be stopped or
     *                                    the error message should be returned.
     *
     * @return string
     *
     * @global string $table The current table.
     * @global string $db    The current database.
     *
     * @access public
     */
    public static function mysqlDie($server_msg = '', $sql_query = '', $is_modify_link = true, $back_url = '', $exit = true)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("mysqlDie") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php at line 521")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called mysqlDie:521@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php');
        die();
    }
    /**
     * Check the correct row count
     *
     * @param string $db    the db name
     * @param array  $table the table infos
     *
     * @return int $rowCount the possibly modified row count
     *
     */
    private static function _checkRowCount($db, $table)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_checkRowCount") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php at line 707")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called _checkRowCount:707@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php');
        die();
    }
    /**
     * returns array with tables of given db with extended information and grouped
     *
     * @param string   $db           name of db
     * @param string   $tables       name of tables
     * @param integer  $limit_offset list offset
     * @param int|bool $limit_count  max tables to return
     *
     * @return array    (recursive) grouped table list
     */
    public static function getTableList($db, $tables = null, $limit_offset = 0, $limit_count = false)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getTableList") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php at line 746")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getTableList:746@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php');
        die();
    }
    /* ----------------------- Set of misc functions ----------------------- */
    /**
     * Adds backquotes on both sides of a database, table or field name.
     * and escapes backquotes inside the name with another backquote
     *
     * example:
     * <code>
     * echo backquote('owner`s db'); // `owner``s db`
     *
     * </code>
     *
     * @param mixed   $a_name the database, table or field name to "backquote"
     *                        or array of it
     * @param boolean $do_it  a flag to bypass this function (used by dump
     *                        functions)
     *
     * @return mixed    the "backquoted" database, table or field name
     *
     * @access  public
     */
    public static function backquote($a_name, $do_it = true)
    {
        if (is_array($a_name)) {
            foreach ($a_name as &$data) {
                $data = self::backquote($data, $do_it);
            }
            return $a_name;
        }
        if (!$do_it) {
            if (!(Context::isKeyword($a_name) & Token::FLAG_KEYWORD_RESERVED)) {
                return $a_name;
            }
        }
        // '0' is also empty for php :-(
        if (strlen($a_name) > 0 && $a_name !== '*') {
            return '`' . str_replace('`', '``', $a_name) . '`';
        } else {
            return $a_name;
        }
    }
    // end of the 'backquote()' function
    /**
     * Adds backquotes on both sides of a database, table or field name.
     * in compatibility mode
     *
     * example:
     * <code>
     * echo backquoteCompat('owner`s db'); // `owner``s db`
     *
     * </code>
     *
     * @param mixed   $a_name        the database, table or field name to
     *                               "backquote" or array of it
     * @param string  $compatibility string compatibility mode (used by dump
     *                               functions)
     * @param boolean $do_it         a flag to bypass this function (used by dump
     *                               functions)
     *
     * @return mixed the "backquoted" database, table or field name
     *
     * @access  public
     */
    public static function backquoteCompat($a_name, $compatibility = 'MSSQL', $do_it = true)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("backquoteCompat") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php at line 905")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called backquoteCompat:905@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php');
        die();
    }
    // end of the 'backquoteCompat()' function
    /**
     * Prepare the message and the query
     * usually the message is the result of the query executed
     *
     * @param Message|string $message   the message to display
     * @param string         $sql_query the query to display
     * @param string         $type      the type (level) of the message
     *
     * @return string
     *
     * @access  public
     */
    public static function getMessage($message, $sql_query = null, $type = 'notice')
    {
        global $cfg;
        $retval = '';
        if (null === $sql_query) {
            if (!empty($GLOBALS['display_query'])) {
                $sql_query = $GLOBALS['display_query'];
            } elseif (!empty($GLOBALS['unparsed_sql'])) {
                $sql_query = $GLOBALS['unparsed_sql'];
            } elseif (!empty($GLOBALS['sql_query'])) {
                $sql_query = $GLOBALS['sql_query'];
            } else {
                $sql_query = '';
            }
        }
        $render_sql = $cfg['ShowSQL'] == true && !empty($sql_query) && $sql_query !== ';';
        if (isset($GLOBALS['using_bookmark_message'])) {
            $retval .= $GLOBALS['using_bookmark_message']->getDisplay();
            unset($GLOBALS['using_bookmark_message']);
        }
        if ($render_sql) {
            $retval .= '<div class="result_query"' . ' style="text-align: ' . $GLOBALS['cell_align_left'] . '"' . '>' . "\n";
        }
        if ($message instanceof Message) {
            if (isset($GLOBALS['special_message'])) {
                $message->addText($GLOBALS['special_message']);
                unset($GLOBALS['special_message']);
            }
            $retval .= $message->getDisplay();
        } else {
            $retval .= '<div class="' . $type . '">';
            $retval .= Sanitize::sanitize($message);
            if (isset($GLOBALS['special_message'])) {
                $retval .= Sanitize::sanitize($GLOBALS['special_message']);
                unset($GLOBALS['special_message']);
            }
            $retval .= '</div>';
        }
        if ($render_sql) {
            $query_too_big = false;
            $queryLength = mb_strlen($sql_query);
            if ($queryLength > $cfg['MaxCharactersInDisplayedSQL']) {
                // when the query is large (for example an INSERT of binary
                // data), the parser chokes; so avoid parsing the query
                $query_too_big = true;
                $query_base = mb_substr($sql_query, 0, $cfg['MaxCharactersInDisplayedSQL']) . '[...]';
            } else {
                $query_base = $sql_query;
            }
            // Html format the query to be displayed
            // If we want to show some sql code it is easiest to create it here
            /* SQL-Parser-Analyzer */
            if (!empty($GLOBALS['show_as_php'])) {
                $new_line = '\\n"<br />' . "\n" . '&nbsp;&nbsp;&nbsp;&nbsp;. "';
                $query_base = '$sql  = \'' . $query_base;
                $query_base = '<code class="php"><pre>' . "\n" . htmlspecialchars(addslashes($query_base));
                $query_base = preg_replace('/((\\015\\012)|(\\015)|(\\012))/', $new_line, $query_base);
                $query_base = '$sql  = \'' . $query_base . '"';
            } elseif ($query_too_big) {
                $query_base = htmlspecialchars($query_base);
            } else {
                $query_base = self::formatSql($query_base);
            }
            // Prepares links that may be displayed to edit/explain the query
            // (don't go to default pages, we must go to the page
            // where the query box is available)
            // Basic url query part
            $url_params = array();
            if (!isset($GLOBALS['db'])) {
                $GLOBALS['db'] = '';
            }
            if (strlen($GLOBALS['db']) > 0) {
                $url_params['db'] = $GLOBALS['db'];
                if (strlen($GLOBALS['table']) > 0) {
                    $url_params['table'] = $GLOBALS['table'];
                    $edit_link = 'tbl_sql.php';
                } else {
                    $edit_link = 'db_sql.php';
                }
            } else {
                $edit_link = 'server_sql.php';
            }
            // Want to have the query explained
            // but only explain a SELECT (that has not been explained)
            /* SQL-Parser-Analyzer */
            $explain_link = '';
            $is_select = preg_match('@^SELECT[[:space:]]+@i', $sql_query);
            if (!empty($cfg['SQLQuery']['Explain']) && !$query_too_big) {
                $explain_params = $url_params;
                if ($is_select) {
                    $explain_params['sql_query'] = 'EXPLAIN ' . $sql_query;
                    $explain_link = ' [' . self::linkOrButton('import.php' . URL::getCommon($explain_params), __('Explain SQL')) . ']';
                } elseif (preg_match('@^EXPLAIN[[:space:]]+SELECT[[:space:]]+@i', $sql_query)) {
                    $explain_params['sql_query'] = mb_substr($sql_query, 8);
                    $explain_link = ' [' . self::linkOrButton('import.php' . URL::getCommon($explain_params), __('Skip Explain SQL')) . ']';
                    $url = 'https://mariadb.org/explain_analyzer/analyze/' . '?client=phpMyAdmin&raw_explain=' . urlencode(self::_generateRowQueryOutput($sql_query));
                    $explain_link .= ' [' . self::linkOrButton(htmlspecialchars('url.php?url=' . urlencode($url)), sprintf(__('Analyze Explain at %s'), 'mariadb.org'), array(), true, false, '_blank') . ']';
                }
            }
            //show explain
            $url_params['sql_query'] = $sql_query;
            $url_params['show_query'] = 1;
            // even if the query is big and was truncated, offer the chance
            // to edit it (unless it's enormous, see linkOrButton() )
            if (!empty($cfg['SQLQuery']['Edit']) && empty($GLOBALS['show_as_php'])) {
                $edit_link .= URL::getCommon($url_params) . '#querybox';
                $edit_link = ' [' . self::linkOrButton($edit_link, __('Edit')) . ']';
            } else {
                $edit_link = '';
            }
            // Also we would like to get the SQL formed in some nice
            // php-code
            if (!empty($cfg['SQLQuery']['ShowAsPHP']) && !$query_too_big) {
                if (!empty($GLOBALS['show_as_php'])) {
                    $php_link = ' [' . self::linkOrButton('import.php' . URL::getCommon($url_params), __('Without PHP code'), array(), true, false, '', true) . ']';
                    $php_link .= ' [' . self::linkOrButton('import.php' . URL::getCommon($url_params), __('Submit query'), array(), true, false, '', true) . ']';
                } else {
                    $php_params = $url_params;
                    $php_params['show_as_php'] = 1;
                    $_message = __('Create PHP code');
                    $php_link = ' [' . self::linkOrButton('import.php' . URL::getCommon($php_params), $_message) . ']';
                }
            } else {
                $php_link = '';
            }
            //show as php
            // Refresh query
            if (!empty($cfg['SQLQuery']['Refresh']) && !isset($GLOBALS['show_as_php']) && preg_match('@^(SELECT|SHOW)[[:space:]]+@i', $sql_query)) {
                $refresh_link = 'import.php' . URL::getCommon($url_params);
                $refresh_link = ' [' . self::linkOrButton($refresh_link, __('Refresh')) . ']';
            } else {
                $refresh_link = '';
            }
            //refresh
            $retval .= '<div class="sqlOuter">';
            $retval .= $query_base;
            //Clean up the end of the PHP
            if (!empty($GLOBALS['show_as_php'])) {
                $retval .= '\';' . "\n" . '</pre></code>';
            }
            $retval .= '</div>';
            $retval .= '<div class="tools print_ignore">';
            $retval .= '<form action="sql.php" method="post">';
            $retval .= URL::getHiddenInputs($GLOBALS['db'], $GLOBALS['table']);
            $retval .= '<input type="hidden" name="sql_query" value="' . htmlspecialchars($sql_query) . '" />';
            // avoid displaying a Profiling checkbox that could
            // be checked, which would reexecute an INSERT, for example
            if (!empty($refresh_link) && self::profilingSupported()) {
                $retval .= '<input type="hidden" name="profiling_form" value="1" />';
                $retval .= Template::get('checkbox')->render(array('html_field_name' => 'profiling', 'label' => __('Profiling'), 'checked' => isset($_SESSION['profiling']), 'onclick' => true, 'html_field_id' => ''));
            }
            $retval .= '</form>';
            /**
             * TODO: Should we have $cfg['SQLQuery']['InlineEdit']?
             */
            if (!empty($cfg['SQLQuery']['Edit']) && !$query_too_big && empty($GLOBALS['show_as_php'])) {
                $inline_edit_link = ' [' . self::linkOrButton('#', _pgettext('Inline edit query', 'Edit inline'), array('class' => 'inline_edit_sql')) . ']';
            } else {
                $inline_edit_link = '';
            }
            $retval .= $inline_edit_link . $edit_link . $explain_link . $php_link . $refresh_link;
            $retval .= '</div>';
            $retval .= '</div>';
        }
        return $retval;
    }
    // end of the 'getMessage()' function
    /**
     * Execute an EXPLAIN query and formats results similar to MySQL command line
     * utility.
     *
     * @param string $sqlQuery EXPLAIN query
     *
     * @return string query resuls
     */
    private static function _generateRowQueryOutput($sqlQuery)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_generateRowQueryOutput") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php at line 1237")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called _generateRowQueryOutput:1237@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php');
        die();
    }
    /**
     * Verifies if current MySQL server supports profiling
     *
     * @access  public
     *
     * @return boolean whether profiling is supported
     */
    public static function profilingSupported()
    {
        if (!self::cacheExists('profiling_supported')) {
            // 5.0.37 has profiling but for example, 5.1.20 does not
            // (avoid a trip to the server for MySQL before 5.0.37)
            // and do not set a constant as we might be switching servers
            if (defined('PMA_MYSQL_INT_VERSION') && $GLOBALS['dbi']->fetchValue("SELECT @@have_profiling")) {
                self::cacheSet('profiling_supported', true);
            } else {
                self::cacheSet('profiling_supported', false);
            }
        }
        return self::cacheGet('profiling_supported');
    }
    /**
     * Formats $value to byte view
     *
     * @param double|int $value the value to format
     * @param int        $limes the sensitiveness
     * @param int        $comma the number of decimals to retain
     *
     * @return array    the formatted value and its unit
     *
     * @access  public
     */
    public static function formatByteDown($value, $limes = 6, $comma = 0)
    {
        if ($value === null) {
            return null;
        }
        $byteUnits = array(
            /* l10n: shortcuts for Byte */
            __('B'),
            /* l10n: shortcuts for Kilobyte */
            __('KiB'),
            /* l10n: shortcuts for Megabyte */
            __('MiB'),
            /* l10n: shortcuts for Gigabyte */
            __('GiB'),
            /* l10n: shortcuts for Terabyte */
            __('TiB'),
            /* l10n: shortcuts for Petabyte */
            __('PiB'),
            /* l10n: shortcuts for Exabyte */
            __('EiB'),
        );
        $dh = pow(10, $comma);
        $li = pow(10, $limes);
        $unit = $byteUnits[0];
        for ($d = 6, $ex = 15; $d >= 1; $d--, $ex -= 3) {
            $unitSize = $li * pow(10, $ex);
            if (isset($byteUnits[$d]) && $value >= $unitSize) {
                // use 1024.0 to avoid integer overflow on 64-bit machines
                $value = round($value / (pow(1024, $d) / $dh)) / $dh;
                $unit = $byteUnits[$d];
                break 1;
            }
            // end if
        }
        // end for
        if ($unit != $byteUnits[0]) {
            // if the unit is not bytes (as represented in current language)
            // reformat with max length of 5
            // 4th parameter=true means do not reformat if value < 1
            $return_value = self::formatNumber($value, 5, $comma, true);
        } else {
            // do not reformat, just handle the locale
            $return_value = self::formatNumber($value, 0);
        }
        return array(trim($return_value), $unit);
    }
    // end of the 'formatByteDown' function
    /**
     * Formats $value to the given length and appends SI prefixes
     * with a $length of 0 no truncation occurs, number is only formatted
     * to the current locale
     *
     * examples:
     * <code>
     * echo formatNumber(123456789, 6);     // 123,457 k
     * echo formatNumber(-123456789, 4, 2); //    -123.46 M
     * echo formatNumber(-0.003, 6);        //      -3 m
     * echo formatNumber(0.003, 3, 3);      //       0.003
     * echo formatNumber(0.00003, 3, 2);    //       0.03 m
     * echo formatNumber(0, 6);             //       0
     * </code>
     *
     * @param double  $value          the value to format
     * @param integer $digits_left    number of digits left of the comma
     * @param integer $digits_right   number of digits right of the comma
     * @param boolean $only_down      do not reformat numbers below 1
     * @param boolean $noTrailingZero removes trailing zeros right of the comma
     *                                (default: true)
     *
     * @return string   the formatted value and its unit
     *
     * @access  public
     */
    public static function formatNumber($value, $digits_left = 3, $digits_right = 0, $only_down = false, $noTrailingZero = true)
    {
        if ($value == 0) {
            return '0';
        }
        $originalValue = $value;
        //number_format is not multibyte safe, str_replace is safe
        if ($digits_left === 0) {
            $value = number_format(
                $value,
                $digits_right,
                /* l10n: Decimal separator */
                __('.'),
                /* l10n: Thousands separator */
                __(',')
            );
            if ($originalValue != 0 && floatval($value) == 0) {
                $value = ' <' . 1 / pow(10, $digits_right);
            }
            return $value;
        }
        // this units needs no translation, ISO
        $units = array(-8 => 'y', -7 => 'z', -6 => 'a', -5 => 'f', -4 => 'p', -3 => 'n', -2 => '&micro;', -1 => 'm', 0 => ' ', 1 => 'k', 2 => 'M', 3 => 'G', 4 => 'T', 5 => 'P', 6 => 'E', 7 => 'Z', 8 => 'Y');
        // check for negative value to retain sign
        if ($value < 0) {
            $sign = '-';
            $value = abs($value);
        } else {
            $sign = '';
        }
        $dh = pow(10, $digits_right);
        /*
         * This gives us the right SI prefix already,
         * but $digits_left parameter not incorporated
         */
        $d = floor(log10($value) / 3);
        /*
         * Lowering the SI prefix by 1 gives us an additional 3 zeros
         * So if we have 3,6,9,12.. free digits ($digits_left - $cur_digits)
         * to use, then lower the SI prefix
         */
        $cur_digits = floor(log10($value / pow(1000, $d)) + 1);
        if ($digits_left > $cur_digits) {
            $d -= floor(($digits_left - $cur_digits) / 3);
        }
        if ($d < 0 && $only_down) {
            $d = 0;
        }
        $value = round($value / (pow(1000, $d) / $dh)) / $dh;
        $unit = $units[$d];
        // number_format is not multibyte safe, str_replace is safe
        $formattedValue = number_format(
            $value,
            $digits_right,
            /* l10n: Decimal separator */
            __('.'),
            /* l10n: Thousands separator */
            __(',')
        );
        // If we don't want any zeros, remove them now
        if ($noTrailingZero && strpos($formattedValue, '.') !== false) {
            $formattedValue = preg_replace('/\\.?0+$/', '', $formattedValue);
        }
        if ($originalValue != 0 && floatval($value) == 0) {
            return ' <' . number_format(
                1 / pow(10, $digits_right),
                $digits_right,
                /* l10n: Decimal separator */
                __('.'),
                /* l10n: Thousands separator */
                __(',')
            ) . ' ' . $unit;
        }
        return $sign . $formattedValue . ' ' . $unit;
    }
    // end of the 'formatNumber' function
    /**
     * Returns the number of bytes when a formatted size is given
     *
     * @param string $formatted_size the size expression (for example 8MB)
     *
     * @return integer  The numerical part of the expression (for example 8)
     */
    public static function extractValueFromFormattedSize($formatted_size)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("extractValueFromFormattedSize") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php at line 1497")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called extractValueFromFormattedSize:1497@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php');
        die();
    }
    // end of the 'extractValueFromFormattedSize' function
    /**
     * Writes localised date
     *
     * @param integer $timestamp the current timestamp
     * @param string  $format    format
     *
     * @return string   the formatted date
     *
     * @access  public
     */
    public static function localisedDate($timestamp = -1, $format = '')
    {
        $month = array(
            /* l10n: Short month name */
            __('Jan'),
            /* l10n: Short month name */
            __('Feb'),
            /* l10n: Short month name */
            __('Mar'),
            /* l10n: Short month name */
            __('Apr'),
            /* l10n: Short month name */
            _pgettext('Short month name', 'May'),
            /* l10n: Short month name */
            __('Jun'),
            /* l10n: Short month name */
            __('Jul'),
            /* l10n: Short month name */
            __('Aug'),
            /* l10n: Short month name */
            __('Sep'),
            /* l10n: Short month name */
            __('Oct'),
            /* l10n: Short month name */
            __('Nov'),
            /* l10n: Short month name */
            __('Dec'),
        );
        $day_of_week = array(
            /* l10n: Short week day name */
            _pgettext('Short week day name', 'Sun'),
            /* l10n: Short week day name */
            __('Mon'),
            /* l10n: Short week day name */
            __('Tue'),
            /* l10n: Short week day name */
            __('Wed'),
            /* l10n: Short week day name */
            __('Thu'),
            /* l10n: Short week day name */
            __('Fri'),
            /* l10n: Short week day name */
            __('Sat'),
        );
        if ($format == '') {
            /* l10n: See https://secure.php.net/manual/en/function.strftime.php */
            $format = __('%B %d, %Y at %I:%M %p');
        }
        if ($timestamp == -1) {
            $timestamp = time();
        }
        $date = preg_replace('@%[aA]@', $day_of_week[(int) strftime('%w', $timestamp)], $format);
        $date = preg_replace('@%[bB]@', $month[(int) strftime('%m', $timestamp) - 1], $date);
        /* Fill in AM/PM */
        $hours = (int) date('H', $timestamp);
        if ($hours >= 12) {
            $am_pm = _pgettext('AM/PM indication in time', 'PM');
        } else {
            $am_pm = _pgettext('AM/PM indication in time', 'AM');
        }
        $date = preg_replace('@%[pP]@', $am_pm, $date);
        $ret = strftime($date, $timestamp);
        // Some OSes such as Win8.1 Traditional Chinese version did not produce UTF-8
        // output here. See https://sourceforge.net/p/phpmyadmin/bugs/4207/
        if (mb_detect_encoding($ret, 'UTF-8', true) != 'UTF-8') {
            $ret = date('Y-m-d H:i:s', $timestamp);
        }
        return $ret;
    }
    // end of the 'localisedDate()' function
    /**
     * returns a tab for tabbed navigation.
     * If the variables $link and $args ar left empty, an inactive tab is created
     *
     * @param array $tab        array with all options
     * @param array $url_params tab specific URL parameters
     *
     * @return string  html code for one tab, a link if valid otherwise a span
     *
     * @access  public
     */
    public static function getHtmlTab($tab, $url_params = array())
    {
        // default values
        $defaults = array('text' => '', 'class' => '', 'active' => null, 'link' => '', 'sep' => '?', 'attr' => '', 'args' => '', 'warning' => '', 'fragment' => '', 'id' => '');
        $tab = array_merge($defaults, $tab);
        // determine additional style-class
        if (empty($tab['class'])) {
            if (!empty($tab['active']) || PMA_isValid($GLOBALS['active_page'], 'identical', $tab['link'])) {
                $tab['class'] = 'active';
            } elseif (is_null($tab['active']) && empty($GLOBALS['active_page']) && basename($GLOBALS['PMA_PHP_SELF']) == $tab['link']) {
                $tab['class'] = 'active';
            }
        }
        // If there are any tab specific URL parameters, merge those with
        // the general URL parameters
        if (!empty($tab['url_params']) && is_array($tab['url_params'])) {
            $url_params = array_merge($url_params, $tab['url_params']);
        }
        // build the link
        if (!empty($tab['link'])) {
            $tab['link'] = htmlentities($tab['link']);
            $tab['link'] = $tab['link'] . URL::getCommon($url_params);
            if (!empty($tab['args'])) {
                foreach ($tab['args'] as $param => $value) {
                    $tab['link'] .= URL::getArgSeparator('html') . urlencode($param) . '=' . urlencode($value);
                }
            }
        }
        if (!empty($tab['fragment'])) {
            $tab['link'] .= $tab['fragment'];
        }
        // display icon
        if (isset($tab['icon'])) {
            // avoid generating an alt tag, because it only illustrates
            // the text that follows and if browser does not display
            // images, the text is duplicated
            $tab['text'] = self::getIcon($tab['icon'], $tab['text'], false, true, 'TabsMode');
        } elseif (empty($tab['text'])) {
            // check to not display an empty link-text
            $tab['text'] = '?';
            trigger_error('empty linktext in function ' . __FUNCTION__ . '()', E_USER_NOTICE);
        }
        //Set the id for the tab, if set in the params
        $tabId = empty($tab['id']) ? null : $tab['id'];
        $item = array();
        if (!empty($tab['link'])) {
            $item = array('content' => $tab['text'], 'url' => array('href' => empty($tab['link']) ? null : $tab['link'], 'id' => $tabId, 'class' => 'tab' . htmlentities($tab['class'])));
        } else {
            $item['content'] = '<span class="tab' . htmlentities($tab['class']) . '"' . $tabId . '>' . $tab['text'] . '</span>';
        }
        $item['class'] = $tab['class'] == 'active' ? 'active' : '';
        return Template::get('list/item')->render($item);
    }
    // end of the 'getHtmlTab()' function
    /**
     * returns html-code for a tab navigation
     *
     * @param array  $tabs       one element per tab
     * @param array  $url_params additional URL parameters
     * @param string $menu_id    HTML id attribute for the menu container
     * @param bool   $resizable  whether to add a "resizable" class
     *
     * @return string  html-code for tab-navigation
     */
    public static function getHtmlTabs($tabs, $url_params, $menu_id, $resizable = false)
    {
        $class = '';
        if ($resizable) {
            $class = ' class="resizable-menu"';
        }
        $tab_navigation = '<div id="' . htmlentities($menu_id) . 'container" class="menucontainer">' . '<ul id="' . htmlentities($menu_id) . '" ' . $class . '>';
        foreach ($tabs as $tab) {
            $tab_navigation .= self::getHtmlTab($tab, $url_params);
        }
        $tab_navigation .= '<div class="clearfloat"></div>' . '</ul>' . "\n" . '</div>' . "\n";
        return $tab_navigation;
    }
    /**
     * Displays a link, or a button if the link's URL is too large, to
     * accommodate some browsers' limitations
     *
     * @param string  $url          the URL
     * @param string  $message      the link message
     * @param mixed   $tag_params   string: js confirmation
     *                              array: additional tag params (f.e. style="")
     * @param boolean $new_form     we set this to false when we are already in
     *                              a  form, to avoid generating nested forms
     * @param boolean $strip_img    whether to strip the image
     * @param string  $target       target
     * @param boolean $force_button use a button even when the URL is not too long
     *
     * @return string  the results to be echoed or saved in an array
     */
    public static function linkOrButton($url, $message, $tag_params = array(), $new_form = true, $strip_img = false, $target = '', $force_button = false)
    {
        $url_length = mb_strlen($url);
        // with this we should be able to catch case of image upload
        // into a (MEDIUM) BLOB; not worth generating even a form for these
        if ($url_length > $GLOBALS['cfg']['LinkLengthLimit'] * 100) {
            return '';
        }
        if (!is_array($tag_params)) {
            $tmp = $tag_params;
            $tag_params = array();
            if (!empty($tmp)) {
                $tag_params['onclick'] = 'return confirmLink(this, \'' . Sanitize::escapeJsString($tmp) . '\')';
            }
            unset($tmp);
        }
        if (!empty($target)) {
            $tag_params['target'] = htmlentities($target);
            if ($target === '_blank' && strncmp($url, 'url.php?', 8) == 0) {
                $tag_params['rel'] = 'noopener noreferrer';
            }
        }
        $displayed_message = '';
        // Add text if not already added
        if (stristr($message, '<img') && (!$strip_img || $GLOBALS['cfg']['ActionLinksMode'] == 'icons') && strip_tags($message) == $message) {
            $displayed_message = '<span>' . htmlspecialchars(preg_replace('/^.*\\salt="([^"]*)".*$/si', '\\1', $message)) . '</span>';
        }
        // Suhosin: Check that each query parameter is not above maximum
        $in_suhosin_limits = true;
        if ($url_length <= $GLOBALS['cfg']['LinkLengthLimit']) {
            $suhosin_get_MaxValueLength = ini_get('suhosin.get.max_value_length');
            if ($suhosin_get_MaxValueLength) {
                $query_parts = self::splitURLQuery($url);
                foreach ($query_parts as $query_pair) {
                    if (strpos($query_pair, '=') === false) {
                        continue;
                    }
                    list(, $eachval) = explode('=', $query_pair);
                    if (mb_strlen($eachval) > $suhosin_get_MaxValueLength) {
                        $in_suhosin_limits = false;
                        break;
                    }
                }
            }
        }
        if ($url_length <= $GLOBALS['cfg']['LinkLengthLimit'] && $in_suhosin_limits && !$force_button) {
            $tag_params_strings = array();
            foreach ($tag_params as $par_name => $par_value) {
                // htmlspecialchars() only on non javascript
                $par_value = mb_substr($par_name, 0, 2) == 'on' ? $par_value : htmlspecialchars($par_value);
                $tag_params_strings[] = $par_name . '="' . $par_value . '"';
            }
            // no whitespace within an <a> else Safari will make it part of the link
            $ret = "\n" . '<a href="' . $url . '" ' . implode(' ', $tag_params_strings) . '>' . $message . $displayed_message . '</a>' . "\n";
        } else {
            // no spaces (line breaks) at all
            // or after the hidden fields
            // IE will display them all
            if (!isset($query_parts)) {
                $query_parts = self::splitURLQuery($url);
            }
            $url_parts = parse_url($url);
            if ($new_form) {
                if ($target) {
                    $target = ' target="' . $target . '"';
                }
                $ret = '<form action="' . $url_parts['path'] . '" class="link"' . ' method="post"' . $target . ' style="display: inline;">';
                $subname_open = '';
                $subname_close = '';
                $submit_link = '#';
            } else {
                $query_parts[] = 'redirect=' . $url_parts['path'];
                if (empty($GLOBALS['subform_counter'])) {
                    $GLOBALS['subform_counter'] = 0;
                }
                $GLOBALS['subform_counter']++;
                $ret = '';
                $subname_open = 'subform[' . $GLOBALS['subform_counter'] . '][';
                $subname_close = ']';
                $submit_link = '#usesubform[' . $GLOBALS['subform_counter'] . ']=1';
            }
            foreach ($query_parts as $query_pair) {
                list($eachvar, $eachval) = explode('=', $query_pair);
                $ret .= '<input type="hidden" name="' . $subname_open . $eachvar . $subname_close . '" value="' . htmlspecialchars(urldecode($eachval)) . '" />';
            }
            // end while
            if (empty($tag_params['class'])) {
                $tag_params['class'] = 'formLinkSubmit';
            } else {
                $tag_params['class'] .= ' formLinkSubmit';
            }
            $tag_params_strings = array();
            foreach ($tag_params as $par_name => $par_value) {
                // htmlspecialchars() only on non javascript
                $par_value = mb_substr($par_name, 0, 2) == 'on' ? $par_value : htmlspecialchars($par_value);
                $tag_params_strings[] = $par_name . '="' . $par_value . '"';
            }
            $ret .= "\n" . '<a href="' . $submit_link . '" ' . implode(' ', $tag_params_strings) . '>' . $message . ' ' . $displayed_message . '</a>' . "\n";
            if ($new_form) {
                $ret .= '</form>';
            }
        }
        // end if... else...
        return $ret;
    }
    // end of the 'linkOrButton()' function
    /**
     * Splits a URL string by parameter
     *
     * @param string $url the URL
     *
     * @return array  the parameter/value pairs, for example [0] db=sakila
     */
    public static function splitURLQuery($url)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("splitURLQuery") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php at line 1921")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called splitURLQuery:1921@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php');
        die();
    }
    /**
     * Returns a given timespan value in a readable format.
     *
     * @param int $seconds the timespan
     *
     * @return string  the formatted value
     */
    public static function timespanFormat($seconds)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("timespanFormat") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php at line 1950")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called timespanFormat:1950@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php');
        die();
    }
    /**
     * Function added to avoid path disclosures.
     * Called by each script that needs parameters, it displays
     * an error message and, by default, stops the execution.
     *
     * Not sure we could use a strMissingParameter message here,
     * would have to check if the error message file is always available
     *
     * @param string[] $params  The names of the parameters needed by the calling
     *                          script
     * @param bool     $request Whether to include this list in checking for
     *                          special params
     *
     * @return void
     *
     * @global boolean $checked_special flag whether any special variable
     *                                       was required
     *
     * @access public
     */
    public static function checkParameters($params, $request = true)
    {
        global $checked_special;
        if (!isset($checked_special)) {
            $checked_special = false;
        }
        $reported_script_name = basename($GLOBALS['PMA_PHP_SELF']);
        $found_error = false;
        $error_message = '';
        foreach ($params as $param) {
            if ($request && $param != 'db' && $param != 'table') {
                $checked_special = true;
            }
            if (!isset($GLOBALS[$param])) {
                $error_message .= $reported_script_name . ': ' . __('Missing parameter:') . ' ' . $param . self::showDocu('faq', 'faqmissingparameters', true) . '[br]';
                $found_error = true;
            }
        }
        if ($found_error) {
            PMA_fatalError($error_message);
        }
    }
    // end function
    /**
     * Function to generate unique condition for specified row.
     *
     * @param resource       $handle               current query result
     * @param integer        $fields_cnt           number of fields
     * @param array          $fields_meta          meta information about fields
     * @param array          $row                  current row
     * @param boolean        $force_unique         generate condition only on pk
     *                                             or unique
     * @param string|boolean $restrict_to_table    restrict the unique condition
     *                                             to this table or false if
     *                                             none
     * @param array          $analyzed_sql_results the analyzed query
     *
     * @access public
     *
     * @return array the calculated condition and whether condition is unique
     */
    public static function getUniqueCondition($handle, $fields_cnt, $fields_meta, $row, $force_unique = false, $restrict_to_table = false, $analyzed_sql_results = null)
    {
        $primary_key = '';
        $unique_key = '';
        $nonprimary_condition = '';
        $preferred_condition = '';
        $primary_key_array = array();
        $unique_key_array = array();
        $nonprimary_condition_array = array();
        $condition_array = array();
        for ($i = 0; $i < $fields_cnt; ++$i) {
            $con_val = '';
            $field_flags = $GLOBALS['dbi']->fieldFlags($handle, $i);
            $meta = $fields_meta[$i];
            // do not use a column alias in a condition
            if (!isset($meta->orgname) || strlen($meta->orgname) === 0) {
                $meta->orgname = $meta->name;
                if (!empty($analyzed_sql_results['statement']->expr)) {
                    foreach ($analyzed_sql_results['statement']->expr as $expr) {
                        if (empty($expr->alias) || empty($expr->column)) {
                            continue;
                        }
                        if (strcasecmp($meta->name, $expr->alias) == 0) {
                            $meta->orgname = $expr->column;
                            break;
                        }
                    }
                }
            }
            // Do not use a table alias in a condition.
            // Test case is:
            // select * from galerie x WHERE
            //(select count(*) from galerie y where y.datum=x.datum)>1
            //
            // But orgtable is present only with mysqli extension so the
            // fix is only for mysqli.
            // Also, do not use the original table name if we are dealing with
            // a view because this view might be updatable.
            // (The isView() verification should not be costly in most cases
            // because there is some caching in the function).
            if (isset($meta->orgtable) && $meta->table != $meta->orgtable && !$GLOBALS['dbi']->getTable($GLOBALS['db'], $meta->table)->isView()) {
                $meta->table = $meta->orgtable;
            }
            // If this field is not from the table which the unique clause needs
            // to be restricted to.
            if ($restrict_to_table && $restrict_to_table != $meta->table) {
                continue;
            }
            // to fix the bug where float fields (primary or not)
            // can't be matched because of the imprecision of
            // floating comparison, use CONCAT
            // (also, the syntax "CONCAT(field) IS NULL"
            // that we need on the next "if" will work)
            if ($meta->type == 'real') {
                $con_key = 'CONCAT(' . self::backquote($meta->table) . '.' . self::backquote($meta->orgname) . ')';
            } else {
                $con_key = self::backquote($meta->table) . '.' . self::backquote($meta->orgname);
            }
            // end if... else...
            $condition = ' ' . $con_key . ' ';
            if (!isset($row[$i]) || is_null($row[$i])) {
                $con_val = 'IS NULL';
            } else {
                // timestamp is numeric on some MySQL 4.1
                // for real we use CONCAT above and it should compare to string
                if ($meta->numeric && $meta->type != 'timestamp' && $meta->type != 'real') {
                    $con_val = '= ' . $row[$i];
                } elseif (($meta->type == 'blob' || $meta->type == 'string') && stristr($field_flags, 'BINARY') && !empty($row[$i])) {
                    // hexify only if this is a true not empty BLOB or a BINARY
                    // do not waste memory building a too big condition
                    if (mb_strlen($row[$i]) < 1000) {
                        // use a CAST if possible, to avoid problems
                        // if the field contains wildcard characters % or _
                        $con_val = '= CAST(0x' . bin2hex($row[$i]) . ' AS BINARY)';
                    } elseif ($fields_cnt == 1) {
                        // when this blob is the only field present
                        // try settling with length comparison
                        $condition = ' CHAR_LENGTH(' . $con_key . ') ';
                        $con_val = ' = ' . mb_strlen($row[$i]);
                    } else {
                        // this blob won't be part of the final condition
                        $con_val = null;
                    }
                } elseif (in_array($meta->type, self::getGISDatatypes()) && !empty($row[$i])) {
                    // do not build a too big condition
                    if (mb_strlen($row[$i]) < 5000) {
                        $condition .= '=0x' . bin2hex($row[$i]) . ' AND';
                    } else {
                        $condition = '';
                    }
                } elseif ($meta->type == 'bit') {
                    $con_val = "= b'" . self::printableBitValue($row[$i], $meta->length) . "'";
                } else {
                    $con_val = '= \'' . $GLOBALS['dbi']->escapeString($row[$i]) . '\'';
                }
            }
            if ($con_val != null) {
                $condition .= $con_val . ' AND';
                if ($meta->primary_key > 0) {
                    $primary_key .= $condition;
                    $primary_key_array[$con_key] = $con_val;
                } elseif ($meta->unique_key > 0) {
                    $unique_key .= $condition;
                    $unique_key_array[$con_key] = $con_val;
                }
                $nonprimary_condition .= $condition;
                $nonprimary_condition_array[$con_key] = $con_val;
            }
        }
        // end for
        // Correction University of Virginia 19991216:
        // prefer primary or unique keys for condition,
        // but use conjunction of all values if no primary key
        $clause_is_unique = true;
        if ($primary_key) {
            $preferred_condition = $primary_key;
            $condition_array = $primary_key_array;
        } elseif ($unique_key) {
            $preferred_condition = $unique_key;
            $condition_array = $unique_key_array;
        } elseif (!$force_unique) {
            $preferred_condition = $nonprimary_condition;
            $condition_array = $nonprimary_condition_array;
            $clause_is_unique = false;
        }
        $where_clause = trim(preg_replace('|\\s?AND$|', '', $preferred_condition));
        return array($where_clause, $clause_is_unique, $condition_array);
    }
    // end function
    /**
     * Generate the charset query part
     *
     * @param string           $collation Collation
     * @param boolean optional $override  force 'CHARACTER SET' keyword
     *
     * @return string
     */
    static function getCharsetQueryPart($collation, $override = false)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getCharsetQueryPart") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php at line 2215")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getCharsetQueryPart:2215@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php');
        die();
    }
    /**
     * Generate a button or image tag
     *
     * @param string $button_name  name of button element
     * @param string $button_class class of button or image element
     * @param string $text         text to display
     * @param string $image        image to display
     * @param string $value        value
     *
     * @return string              html content
     *
     * @access  public
     */
    public static function getButtonOrImage($button_name, $button_class, $text, $image, $value = '')
    {
        if ($value == '') {
            $value = $text;
        }
        if ($GLOBALS['cfg']['ActionLinksMode'] == 'text') {
            return ' <input type="submit" name="' . $button_name . '"' . ' value="' . htmlspecialchars($value) . '"' . ' title="' . htmlspecialchars($text) . '" />' . "\n";
        }
        return '<button class="' . $button_class . '" type="submit"' . ' name="' . $button_name . '" value="' . htmlspecialchars($value) . '" title="' . htmlspecialchars($text) . '">' . "\n" . self::getIcon($image, $text) . '</button>' . "\n";
    }
    // end function
    /**
     * Generate a pagination selector for browsing resultsets
     *
     * @param string $name        The name for the request parameter
     * @param int    $rows        Number of rows in the pagination set
     * @param int    $pageNow     current page number
     * @param int    $nbTotalPage number of total pages
     * @param int    $showAll     If the number of pages is lower than this
     *                            variable, no pages will be omitted in pagination
     * @param int    $sliceStart  How many rows at the beginning should always
     *                            be shown?
     * @param int    $sliceEnd    How many rows at the end should always be shown?
     * @param int    $percent     Percentage of calculation page offsets to hop to a
     *                            next page
     * @param int    $range       Near the current page, how many pages should
     *                            be considered "nearby" and displayed as well?
     * @param string $prompt      The prompt to display (sometimes empty)
     *
     * @return string
     *
     * @access  public
     */
    public static function pageselector($name, $rows, $pageNow = 1, $nbTotalPage = 1, $showAll = 200, $sliceStart = 5, $sliceEnd = 5, $percent = 20, $range = 10, $prompt = '')
    {
        $increment = floor($nbTotalPage / $percent);
        $pageNowMinusRange = $pageNow - $range;
        $pageNowPlusRange = $pageNow + $range;
        $gotopage = $prompt . ' <select class="pageselector ajax"';
        $gotopage .= ' name="' . $name . '" >';
        if ($nbTotalPage < $showAll) {
            $pages = range(1, $nbTotalPage);
        } else {
            $pages = array();
            // Always show first X pages
            for ($i = 1; $i <= $sliceStart; $i++) {
                $pages[] = $i;
            }
            // Always show last X pages
            for ($i = $nbTotalPage - $sliceEnd; $i <= $nbTotalPage; $i++) {
                $pages[] = $i;
            }
            // Based on the number of results we add the specified
            // $percent percentage to each page number,
            // so that we have a representing page number every now and then to
            // immediately jump to specific pages.
            // As soon as we get near our currently chosen page ($pageNow -
            // $range), every page number will be shown.
            $i = $sliceStart;
            $x = $nbTotalPage - $sliceEnd;
            $met_boundary = false;
            while ($i <= $x) {
                if ($i >= $pageNowMinusRange && $i <= $pageNowPlusRange) {
                    // If our pageselector comes near the current page, we use 1
                    // counter increments
                    $i++;
                    $met_boundary = true;
                } else {
                    // We add the percentage increment to our current page to
                    // hop to the next one in range
                    $i += $increment;
                    // Make sure that we do not cross our boundaries.
                    if ($i > $pageNowMinusRange && !$met_boundary) {
                        $i = $pageNowMinusRange;
                    }
                }
                if ($i > 0 && $i <= $x) {
                    $pages[] = $i;
                }
            }
            /*
            Add page numbers with "geometrically increasing" distances.
            
            This helps me a lot when navigating through giant tables.
            
            Test case: table with 2.28 million sets, 76190 pages. Page of interest
            is between 72376 and 76190.
            Selecting page 72376.
            Now, old version enumerated only +/- 10 pages around 72376 and the
            percentage increment produced steps of about 3000.
            
            The following code adds page numbers +/- 2,4,8,16,32,64,128,256 etc.
            around the current page.
            */
            $i = $pageNow;
            $dist = 1;
            while ($i < $x) {
                $dist = 2 * $dist;
                $i = $pageNow + $dist;
                if ($i > 0 && $i <= $x) {
                    $pages[] = $i;
                }
            }
            $i = $pageNow;
            $dist = 1;
            while ($i > 0) {
                $dist = 2 * $dist;
                $i = $pageNow - $dist;
                if ($i > 0 && $i <= $x) {
                    $pages[] = $i;
                }
            }
            // Since because of ellipsing of the current page some numbers may be
            // double, we unify our array:
            sort($pages);
            $pages = array_unique($pages);
        }
        foreach ($pages as $i) {
            if ($i == $pageNow) {
                $selected = 'selected="selected" style="font-weight: bold"';
            } else {
                $selected = '';
            }
            $gotopage .= '                <option ' . $selected . ' value="' . ($i - 1) * $rows . '">' . $i . '</option>' . "\n";
        }
        $gotopage .= ' </select>';
        return $gotopage;
    }
    // end function
    /**
     * Prepare navigation for a list
     *
     * @param int      $count       number of elements in the list
     * @param int      $pos         current position in the list
     * @param array    $_url_params url parameters
     * @param string   $script      script name for form target
     * @param string   $frame       target frame
     * @param int      $max_count   maximum number of elements to display from
     *                              the list
     * @param string   $name        the name for the request parameter
     * @param string[] $classes     additional classes for the container
     *
     * @return string $list_navigator_html the  html content
     *
     * @access  public
     *
     * @todo    use $pos from $_url_params
     */
    public static function getListNavigator($count, $pos, $_url_params, $script, $frame, $max_count, $name = 'pos', $classes = array())
    {
        $class = $frame == 'frame_navigation' ? ' class="ajax"' : '';
        $list_navigator_html = '';
        if ($max_count < $count) {
            $classes[] = 'pageselector';
            $list_navigator_html .= '<div class="' . implode(' ', $classes) . '">';
            if ($frame != 'frame_navigation') {
                $list_navigator_html .= __('Page number:');
            }
            // Move to the beginning or to the previous page
            if ($pos > 0) {
                $caption1 = '';
                $caption2 = '';
                if (self::showIcons('TableNavigationLinksMode')) {
                    $caption1 .= '&lt;&lt; ';
                    $caption2 .= '&lt; ';
                }
                if (self::showText('TableNavigationLinksMode')) {
                    $caption1 .= _pgettext('First page', 'Begin');
                    $caption2 .= _pgettext('Previous page', 'Previous');
                }
                $title1 = ' title="' . _pgettext('First page', 'Begin') . '"';
                $title2 = ' title="' . _pgettext('Previous page', 'Previous') . '"';
                $_url_params[$name] = 0;
                $list_navigator_html .= '<a' . $class . $title1 . ' href="' . $script . URL::getCommon($_url_params) . '">' . $caption1 . '</a>';
                $_url_params[$name] = $pos - $max_count;
                $list_navigator_html .= ' <a' . $class . $title2 . ' href="' . $script . URL::getCommon($_url_params) . '">' . $caption2 . '</a>';
            }
            $list_navigator_html .= '<form action="' . basename($script) . '" method="post">';
            $list_navigator_html .= URL::getHiddenInputs($_url_params);
            $list_navigator_html .= self::pageselector($name, $max_count, floor(($pos + 1) / $max_count) + 1, ceil($count / $max_count));
            $list_navigator_html .= '</form>';
            if ($pos + $max_count < $count) {
                $caption3 = '';
                $caption4 = '';
                if (self::showText('TableNavigationLinksMode')) {
                    $caption3 .= _pgettext('Next page', 'Next');
                    $caption4 .= _pgettext('Last page', 'End');
                }
                if (self::showIcons('TableNavigationLinksMode')) {
                    $caption3 .= ' &gt;';
                    $caption4 .= ' &gt;&gt;';
                    if (!self::showText('TableNavigationLinksMode')) {
                    }
                }
                $title3 = ' title="' . _pgettext('Next page', 'Next') . '"';
                $title4 = ' title="' . _pgettext('Last page', 'End') . '"';
                $_url_params[$name] = $pos + $max_count;
                $list_navigator_html .= '<a' . $class . $title3 . ' href="' . $script . URL::getCommon($_url_params) . '" >' . $caption3 . '</a>';
                $_url_params[$name] = floor($count / $max_count) * $max_count;
                if ($_url_params[$name] == $count) {
                    $_url_params[$name] = $count - $max_count;
                }
                $list_navigator_html .= ' <a' . $class . $title4 . ' href="' . $script . URL::getCommon($_url_params) . '" >' . $caption4 . '</a>';
            }
            $list_navigator_html .= '</div>' . "\n";
        }
        return $list_navigator_html;
    }
    /**
     * replaces %u in given path with current user name
     *
     * example:
     * <code>
     * $user_dir = userDir('/var/pma_tmp/%u/'); // '/var/pma_tmp/root/'
     *
     * </code>
     *
     * @param string $dir with wildcard for user
     *
     * @return string  per user directory
     */
    public static function userDir($dir)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("userDir") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php at line 2518")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called userDir:2518@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php');
        die();
    }
    /**
     * returns html code for db link to default db page
     *
     * @param string $database database
     *
     * @return string  html link to default db page
     */
    public static function getDbLink($database = null)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getDbLink") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php at line 2534")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getDbLink:2534@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php');
        die();
    }
    /**
     * Prepare a lightbulb hint explaining a known external bug
     * that affects a functionality
     *
     * @param string $functionality   localized message explaining the func.
     * @param string $component       'mysql' (eventually, 'php')
     * @param string $minimum_version of this component
     * @param string $bugref          bug reference for this component
     *
     * @return String
     */
    public static function getExternalBug($functionality, $component, $minimum_version, $bugref)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getExternalBug") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php at line 2571")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getExternalBug:2571@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php');
        die();
    }
    /**
     * Generates a set of radio HTML fields
     *
     * @param string  $html_field_name the radio HTML field
     * @param array   $choices         the choices values and labels
     * @param string  $checked_choice  the choice to check by default
     * @param boolean $line_break      whether to add HTML line break after a choice
     * @param boolean $escape_label    whether to use htmlspecialchars() on label
     * @param string  $class           enclose each choice with a div of this class
     * @param string  $id_prefix       prefix for the id attribute, name will be
     *                                 used if this is not supplied
     *
     * @return string                  set of html radio fiels
     */
    public static function getRadioFields($html_field_name, $choices, $checked_choice = '', $line_break = true, $escape_label = true, $class = '', $id_prefix = '')
    {
        $radio_html = '';
        foreach ($choices as $choice_value => $choice_label) {
            if (!empty($class)) {
                $radio_html .= '<div class="' . $class . '">';
            }
            if (!$id_prefix) {
                $id_prefix = $html_field_name;
            }
            $html_field_id = $id_prefix . '_' . $choice_value;
            $radio_html .= '<input type="radio" name="' . $html_field_name . '" id="' . $html_field_id . '" value="' . htmlspecialchars($choice_value) . '"';
            if ($choice_value == $checked_choice) {
                $radio_html .= ' checked="checked"';
            }
            $radio_html .= ' />' . "\n" . '<label for="' . $html_field_id . '">' . ($escape_label ? htmlspecialchars($choice_label) : $choice_label) . '</label>';
            if ($line_break) {
                $radio_html .= '<br />';
            }
            if (!empty($class)) {
                $radio_html .= '</div>';
            }
            $radio_html .= "\n";
        }
        return $radio_html;
    }
    /**
     * Generates and returns an HTML dropdown
     *
     * @param string $select_name   name for the select element
     * @param array  $choices       choices values
     * @param string $active_choice the choice to select by default
     * @param string $id            id of the select element; can be different in
     *                              case the dropdown is present more than once
     *                              on the page
     * @param string $class         class for the select element
     * @param string $placeholder   Placeholder for dropdown if nothing else
     *                              is selected
     *
     * @return string               html content
     *
     * @todo    support titles
     */
    public static function getDropdown($select_name, $choices, $active_choice, $id, $class = '', $placeholder = null)
    {
        $result = '<select' . ' name="' . htmlspecialchars($select_name) . '"' . ' id="' . htmlspecialchars($id) . '"' . (!empty($class) ? ' class="' . htmlspecialchars($class) . '"' : '') . '>';
        $resultOptions = '';
        $selected = false;
        foreach ($choices as $one_choice_value => $one_choice_label) {
            $resultOptions .= '<option value="' . htmlspecialchars($one_choice_value) . '"';
            if ($one_choice_value == $active_choice) {
                $resultOptions .= ' selected="selected"';
                $selected = true;
            }
            $resultOptions .= '>' . htmlspecialchars($one_choice_label) . '</option>';
        }
        if (!empty($placeholder)) {
            $resultOptions = '<option value="" disabled="disabled"' . (!$selected ? ' selected="selected"' : '') . '>' . $placeholder . '</option>' . $resultOptions;
        }
        $result .= $resultOptions . '</select>';
        return $result;
    }
    /**
     * Generates a slider effect (jQjuery)
     * Takes care of generating the initial <div> and the link
     * controlling the slider; you have to generate the </div> yourself
     * after the sliding section.
     *
     * @param string $id      the id of the <div> on which to apply the effect
     * @param string $message the message to show as a link
     *
     * @return string         html div element
     *
     */
    public static function getDivForSliderEffect($id = '', $message = '')
    {
        return Template::get('div_for_slider_effect')->render(['id' => $id, 'InitialSlidersState' => $GLOBALS['cfg']['InitialSlidersState'], 'message' => $message]);
    }
    /**
     * Creates an AJAX sliding toggle button
     * (or and equivalent form when AJAX is disabled)
     *
     * @param string $action      The URL for the request to be executed
     * @param string $select_name The name for the dropdown box
     * @param array  $options     An array of options (see rte_footer.lib.php)
     * @param string $callback    A JS snippet to execute when the request is
     *                            successfully processed
     *
     * @return string   HTML code for the toggle button
     */
    public static function toggleButton($action, $select_name, $options, $callback)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("toggleButton") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php at line 2733")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called toggleButton:2733@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php');
        die();
    }
    // end toggleButton()
    /**
     * Clears cache content which needs to be refreshed on user change.
     *
     * @return void
     */
    public static function clearUserCache()
    {
        self::cacheUnset('is_superuser');
        self::cacheUnset('is_createuser');
        self::cacheUnset('is_grantuser');
    }
    /**
     * Calculates session cache key
     *
     * @return string
     */
    public static function cacheKey()
    {
        if (isset($GLOBALS['cfg']['Server']['user'])) {
            return 'server_' . $GLOBALS['server'] . '_' . $GLOBALS['cfg']['Server']['user'];
        } else {
            return 'server_' . $GLOBALS['server'];
        }
    }
    /**
     * Verifies if something is cached in the session
     *
     * @param string $var variable name
     *
     * @return boolean
     */
    public static function cacheExists($var)
    {
        return isset($_SESSION['cache'][self::cacheKey()][$var]);
    }
    /**
     * Gets cached information from the session
     *
     * @param string   $var      variable name
     * @param \Closure $callback callback to fetch the value
     *
     * @return mixed
     */
    public static function cacheGet($var, $callback = null)
    {
        if (self::cacheExists($var)) {
            return $_SESSION['cache'][self::cacheKey()][$var];
        } else {
            if ($callback) {
                $val = $callback();
                self::cacheSet($var, $val);
                return $val;
            }
            return null;
        }
    }
    /**
     * Caches information in the session
     *
     * @param string $var variable name
     * @param mixed  $val value
     *
     * @return mixed
     */
    public static function cacheSet($var, $val = null)
    {
        $_SESSION['cache'][self::cacheKey()][$var] = $val;
    }
    /**
     * Removes cached information from the session
     *
     * @param string $var variable name
     *
     * @return void
     */
    public static function cacheUnset($var)
    {
        unset($_SESSION['cache'][self::cacheKey()][$var]);
    }
    /**
     * Converts a bit value to printable format;
     * in MySQL a BIT field can be from 1 to 64 bits so we need this
     * function because in PHP, decbin() supports only 32 bits
     * on 32-bit servers
     *
     * @param integer $value  coming from a BIT field
     * @param integer $length length
     *
     * @return string  the printable value
     */
    public static function printableBitValue($value, $length)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("printableBitValue") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php at line 2859")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called printableBitValue:2859@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php');
        die();
    }
    /**
     * Verifies whether the value contains a non-printable character
     *
     * @param string $value value
     *
     * @return integer
     */
    public static function containsNonPrintableAscii($value)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("containsNonPrintableAscii") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php at line 2896")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called containsNonPrintableAscii:2896@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php');
        die();
    }
    /**
     * Converts a BIT type default value
     * for example, b'010' becomes 010
     *
     * @param string $bit_default_value value
     *
     * @return string the converted value
     */
    public static function convertBitDefaultValue($bit_default_value)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("convertBitDefaultValue") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php at line 2909")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called convertBitDefaultValue:2909@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php');
        die();
    }
    /**
     * Extracts the various parts from a column spec
     *
     * @param string $columnspec Column specification
     *
     * @return array associative array containing type, spec_in_brackets
     *          and possibly enum_set_values (another array)
     */
    public static function extractColumnSpec($columnspec)
    {
        $first_bracket_pos = mb_strpos($columnspec, '(');
        if ($first_bracket_pos) {
            $spec_in_brackets = chop(mb_substr($columnspec, $first_bracket_pos + 1, mb_strrpos($columnspec, ')') - $first_bracket_pos - 1));
            // convert to lowercase just to be sure
            $type = mb_strtolower(chop(mb_substr($columnspec, 0, $first_bracket_pos)));
        } else {
            // Split trailing attributes such as unsigned,
            // binary, zerofill and get data type name
            $type_parts = explode(' ', $columnspec);
            $type = mb_strtolower($type_parts[0]);
            $spec_in_brackets = '';
        }
        if ('enum' == $type || 'set' == $type) {
            // Define our working vars
            $enum_set_values = self::parseEnumSetValues($columnspec, false);
            $printtype = $type . '(' . str_replace("','", "', '", $spec_in_brackets) . ')';
            $binary = false;
            $unsigned = false;
            $zerofill = false;
        } else {
            $enum_set_values = array();
            /* Create printable type name */
            $printtype = mb_strtolower($columnspec);
            // Strip the "BINARY" attribute, except if we find "BINARY(" because
            // this would be a BINARY or VARBINARY column type;
            // by the way, a BLOB should not show the BINARY attribute
            // because this is not accepted in MySQL syntax.
            if (preg_match('@binary@', $printtype) && !preg_match('@binary[\\(]@', $printtype)) {
                $printtype = preg_replace('@binary@', '', $printtype);
                $binary = true;
            } else {
                $binary = false;
            }
            $printtype = preg_replace('@zerofill@', '', $printtype, -1, $zerofill_cnt);
            $zerofill = $zerofill_cnt > 0;
            $printtype = preg_replace('@unsigned@', '', $printtype, -1, $unsigned_cnt);
            $unsigned = $unsigned_cnt > 0;
            $printtype = trim($printtype);
        }
        $attribute = ' ';
        if ($binary) {
            $attribute = 'BINARY';
        }
        if ($unsigned) {
            $attribute = 'UNSIGNED';
        }
        if ($zerofill) {
            $attribute = 'UNSIGNED ZEROFILL';
        }
        $can_contain_collation = false;
        if (!$binary && preg_match("@^(char|varchar|text|tinytext|mediumtext|longtext|set|enum)@", $type)) {
            $can_contain_collation = true;
        }
        // for the case ENUM('&#8211;','&ldquo;')
        $displayed_type = htmlspecialchars($printtype);
        if (mb_strlen($printtype) > $GLOBALS['cfg']['LimitChars']) {
            $displayed_type = '<abbr title="' . htmlspecialchars($printtype) . '">';
            $displayed_type .= htmlspecialchars(mb_substr($printtype, 0, $GLOBALS['cfg']['LimitChars']) . '...');
            $displayed_type .= '</abbr>';
        }
        return array('type' => $type, 'spec_in_brackets' => $spec_in_brackets, 'enum_set_values' => $enum_set_values, 'print_type' => $printtype, 'binary' => $binary, 'unsigned' => $unsigned, 'zerofill' => $zerofill, 'attribute' => $attribute, 'can_contain_collation' => $can_contain_collation, 'displayed_type' => $displayed_type);
    }
    /**
     * Verifies if this table's engine supports foreign keys
     *
     * @param string $engine engine
     *
     * @return boolean
     */
    public static function isForeignKeySupported($engine)
    {
        $engine = strtoupper($engine);
        if ($engine == 'INNODB' || $engine == 'PBXT') {
            return true;
        } elseif ($engine == 'NDBCLUSTER' || $engine == 'NDB') {
            $ndbver = strtolower($GLOBALS['dbi']->fetchValue("SELECT @@ndb_version_string"));
            if (substr($ndbver, 0, 4) == 'ndb-') {
                $ndbver = substr($ndbver, 4);
            }
            return version_compare($ndbver, 7.3, '>=');
        } else {
            return false;
        }
    }
    /**
     * Is Foreign key check enabled?
     *
     * @return bool
     */
    public static function isForeignKeyCheck()
    {
        if ($GLOBALS['cfg']['DefaultForeignKeyChecks'] === 'enable') {
            return true;
        } else {
            if ($GLOBALS['cfg']['DefaultForeignKeyChecks'] === 'disable') {
                return false;
            }
        }
        return $GLOBALS['dbi']->getVariable('FOREIGN_KEY_CHECKS') == 'ON';
    }
    /**
     * Get HTML for Foreign key check checkbox
     *
     * @return string HTML for checkbox
     */
    public static function getFKCheckbox()
    {
        $checked = self::isForeignKeyCheck();
        $html = '<input type="hidden" name="fk_checks" value="0" />';
        $html .= '<input type="checkbox" name="fk_checks"' . ' id="fk_checks" value="1"' . ($checked ? ' checked="checked"' : '') . '/>';
        $html .= '<label for="fk_checks">' . __('Enable foreign key checks') . '</label>';
        return $html;
    }
    /**
     * Handle foreign key check request
     *
     * @return bool Default foreign key checks value
     */
    public static function handleDisableFKCheckInit()
    {
        $default_fk_check_value = $GLOBALS['dbi']->getVariable('FOREIGN_KEY_CHECKS') == 'ON';
        if (isset($_REQUEST['fk_checks'])) {
            if (empty($_REQUEST['fk_checks'])) {
                // Disable foreign key checks
                $GLOBALS['dbi']->setVariable('FOREIGN_KEY_CHECKS', 'OFF');
            } else {
                // Enable foreign key checks
                $GLOBALS['dbi']->setVariable('FOREIGN_KEY_CHECKS', 'ON');
            }
        }
        // else do nothing, go with default
        return $default_fk_check_value;
    }
    /**
     * Cleanup changes done for foreign key check
     *
     * @param bool $default_fk_check_value original value for 'FOREIGN_KEY_CHECKS'
     *
     * @return void
     */
    public static function handleDisableFKCheckCleanup($default_fk_check_value)
    {
        $GLOBALS['dbi']->setVariable('FOREIGN_KEY_CHECKS', $default_fk_check_value ? 'ON' : 'OFF');
    }
    /**
     * Converts GIS data to Well Known Text format
     *
     * @param string $data        GIS data
     * @param bool   $includeSRID Add SRID to the WKT
     *
     * @return string GIS data in Well Know Text format
     */
    public static function asWKT($data, $includeSRID = false)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("asWKT") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php at line 3130")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called asWKT:3130@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php');
        die();
    }
    /**
     * If the string starts with a \r\n pair (0x0d0a) add an extra \n
     *
     * @param string $string string
     *
     * @return string with the chars replaced
     */
    public static function duplicateFirstNewline($string)
    {
        $first_occurence = mb_strpos($string, "\r\n");
        if ($first_occurence === 0) {
            $string = "\n" . $string;
        }
        return $string;
    }
    /**
     * Get the action word corresponding to a script name
     * in order to display it as a title in navigation panel
     *
     * @param string $target a valid value for $cfg['NavigationTreeDefaultTabTable'],
     *                       $cfg['NavigationTreeDefaultTabTable2'],
     *                       $cfg['DefaultTabTable'] or $cfg['DefaultTabDatabase']
     *
     * @return string Title for the $cfg value
     */
    public static function getTitleForTarget($target)
    {
        $mapping = array(
            'structure' => __('Structure'),
            'sql' => __('SQL'),
            'search' => __('Search'),
            'insert' => __('Insert'),
            'browse' => __('Browse'),
            'operations' => __('Operations'),
            // For backward compatiblity
            // Values for $cfg['DefaultTabTable']
            'tbl_structure.php' => __('Structure'),
            'tbl_sql.php' => __('SQL'),
            'tbl_select.php' => __('Search'),
            'tbl_change.php' => __('Insert'),
            'sql.php' => __('Browse'),
            // Values for $cfg['DefaultTabDatabase']
            'db_structure.php' => __('Structure'),
            'db_sql.php' => __('SQL'),
            'db_search.php' => __('Search'),
            'db_operations.php' => __('Operations'),
        );
        return isset($mapping[$target]) ? $mapping[$target] : false;
    }
    /**
     * Get the script name corresponding to a plain English config word
     * in order to append in links on navigation and main panel
     *
     * @param string $target   a valid value for
     *                         $cfg['NavigationTreeDefaultTabTable'],
     *                         $cfg['NavigationTreeDefaultTabTable2'],
     *                         $cfg['DefaultTabTable'], $cfg['DefaultTabDatabase'] or
     *                         $cfg['DefaultTabServer']
     * @param string $location one out of 'server', 'table', 'database'
     *
     * @return string script name corresponding to the config word
     */
    public static function getScriptNameForOption($target, $location)
    {
        if ($location == 'server') {
            // Values for $cfg['DefaultTabServer']
            switch ($target) {
                case 'welcome':
                    return 'index.php';
                case 'databases':
                    return 'server_databases.php';
                case 'status':
                    return 'server_status.php';
                case 'variables':
                    return 'server_variables.php';
                case 'privileges':
                    return 'server_privileges.php';
            }
        } elseif ($location == 'database') {
            // Values for $cfg['DefaultTabDatabase']
            switch ($target) {
                case 'structure':
                    return 'db_structure.php';
                case 'sql':
                    return 'db_sql.php';
                case 'search':
                    return 'db_search.php';
                case 'operations':
                    return 'db_operations.php';
            }
        } elseif ($location == 'table') {
            // Values for $cfg['DefaultTabTable'],
            // $cfg['NavigationTreeDefaultTabTable'] and
            // $cfg['NavigationTreeDefaultTabTable2']
            switch ($target) {
                case 'structure':
                    return 'tbl_structure.php';
                case 'sql':
                    return 'tbl_sql.php';
                case 'search':
                    return 'tbl_select.php';
                case 'insert':
                    return 'tbl_change.php';
                case 'browse':
                    return 'sql.php';
            }
        }
        return $target;
    }
    /**
     * Formats user string, expanding @VARIABLES@, accepting strftime format
     * string.
     *
     * @param string       $string  Text where to do expansion.
     * @param array|string $escape  Function to call for escaping variable values.
     *                          Can also be an array of:
     *                          - the escape method name
     *                          - the class that contains the method
     *                          - location of the class (for inclusion)
     * @param array        $updates Array with overrides for default parameters
     *                     (obtained from GLOBALS).
     *
     * @return string
     */
    public static function expandUserString($string, $escape = null, $updates = array())
    {
        /* Content */
        $vars = array();
        $vars['http_host'] = PMA_getenv('HTTP_HOST');
        $vars['server_name'] = $GLOBALS['cfg']['Server']['host'];
        $vars['server_verbose'] = $GLOBALS['cfg']['Server']['verbose'];
        if (empty($GLOBALS['cfg']['Server']['verbose'])) {
            $vars['server_verbose_or_name'] = $GLOBALS['cfg']['Server']['host'];
        } else {
            $vars['server_verbose_or_name'] = $GLOBALS['cfg']['Server']['verbose'];
        }
        $vars['database'] = $GLOBALS['db'];
        $vars['table'] = $GLOBALS['table'];
        $vars['phpmyadmin_version'] = 'phpMyAdmin ' . PMA_VERSION;
        /* Update forced variables */
        foreach ($updates as $key => $val) {
            $vars[$key] = $val;
        }
        /* Replacement mapping */
        /*
         * The __VAR__ ones are for backward compatibility, because user
         * might still have it in cookies.
         */
        $replace = array('@HTTP_HOST@' => $vars['http_host'], '@SERVER@' => $vars['server_name'], '__SERVER__' => $vars['server_name'], '@VERBOSE@' => $vars['server_verbose'], '@VSERVER@' => $vars['server_verbose_or_name'], '@DATABASE@' => $vars['database'], '__DB__' => $vars['database'], '@TABLE@' => $vars['table'], '__TABLE__' => $vars['table'], '@PHPMYADMIN@' => $vars['phpmyadmin_version']);
        /* Optional escaping */
        if (!is_null($escape)) {
            if (is_array($escape)) {
                $escape_class = new $escape[1]();
                $escape_method = $escape[0];
            }
            foreach ($replace as $key => $val) {
                if (is_array($escape)) {
                    $replace[$key] = $escape_class->{$escape_method}($val);
                } else {
                    $replace[$key] = $escape == 'backquote' ? self::$escape($val) : $escape($val);
                }
            }
        }
        /* Backward compatibility in 3.5.x */
        if (mb_strpos($string, '@FIELDS@') !== false) {
            $string = strtr($string, array('@FIELDS@' => '@COLUMNS@'));
        }
        /* Fetch columns list if required */
        if (mb_strpos($string, '@COLUMNS@') !== false) {
            $columns_list = $GLOBALS['dbi']->getColumns($GLOBALS['db'], $GLOBALS['table']);
            // sometimes the table no longer exists at this point
            if (!is_null($columns_list)) {
                $column_names = array();
                foreach ($columns_list as $column) {
                    if (!is_null($escape)) {
                        $column_names[] = self::$escape($column['Field']);
                    } else {
                        $column_names[] = $column['Field'];
                    }
                }
                $replace['@COLUMNS@'] = implode(',', $column_names);
            } else {
                $replace['@COLUMNS@'] = '*';
            }
        }
        /* Do the replacement */
        return strtr(strftime($string), $replace);
    }
    /**
     * Prepare the form used to browse anywhere on the local server for a file to
     * import
     *
     * @param string $max_upload_size maximum upload size
     *
     * @return String
     */
    public static function getBrowseUploadFileBlock($max_upload_size)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getBrowseUploadFileBlock") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php at line 3381")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getBrowseUploadFileBlock:3381@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php');
        die();
    }
    /**
     * Prepare the form used to select a file to import from the server upload
     * directory
     *
     * @param ImportPlugin[] $import_list array of import plugins
     * @param string         $uploaddir   upload directory
     *
     * @return String
     */
    public static function getSelectUploadFileBlock($import_list, $uploaddir)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getSelectUploadFileBlock") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php at line 3411")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getSelectUploadFileBlock:3411@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php');
        die();
    }
    /**
     * Build titles and icons for action links
     *
     * @return array   the action titles
     */
    public static function buildActionTitles()
    {
        $titles = array();
        $titles['Browse'] = self::getIcon('b_browse.png', __('Browse'));
        $titles['NoBrowse'] = self::getIcon('bd_browse.png', __('Browse'));
        $titles['Search'] = self::getIcon('b_select.png', __('Search'));
        $titles['NoSearch'] = self::getIcon('bd_select.png', __('Search'));
        $titles['Insert'] = self::getIcon('b_insrow.png', __('Insert'));
        $titles['NoInsert'] = self::getIcon('bd_insrow.png', __('Insert'));
        $titles['Structure'] = self::getIcon('b_props.png', __('Structure'));
        $titles['Drop'] = self::getIcon('b_drop.png', __('Drop'));
        $titles['NoDrop'] = self::getIcon('bd_drop.png', __('Drop'));
        $titles['Empty'] = self::getIcon('b_empty.png', __('Empty'));
        $titles['NoEmpty'] = self::getIcon('bd_empty.png', __('Empty'));
        $titles['Edit'] = self::getIcon('b_edit.png', __('Edit'));
        $titles['NoEdit'] = self::getIcon('bd_edit.png', __('Edit'));
        $titles['Export'] = self::getIcon('b_export.png', __('Export'));
        $titles['NoExport'] = self::getIcon('bd_export.png', __('Export'));
        $titles['Execute'] = self::getIcon('b_nextpage.png', __('Execute'));
        $titles['NoExecute'] = self::getIcon('bd_nextpage.png', __('Execute'));
        // For Favorite/NoFavorite, we need icon only.
        $titles['Favorite'] = self::getIcon('b_favorite.png', '');
        $titles['NoFavorite'] = self::getIcon('b_no_favorite.png', '');
        return $titles;
    }
    /**
     * This function processes the datatypes supported by the DB,
     * as specified in Types->getColumns() and either returns an array
     * (useful for quickly checking if a datatype is supported)
     * or an HTML snippet that creates a drop-down list.
     *
     * @param bool   $html     Whether to generate an html snippet or an array
     * @param string $selected The value to mark as selected in HTML mode
     *
     * @return mixed   An HTML snippet or an array of datatypes.
     *
     */
    public static function getSupportedDatatypes($html = false, $selected = '')
    {
        if ($html) {
            // NOTE: the SELECT tag in not included in this snippet.
            $retval = '';
            foreach ($GLOBALS['PMA_Types']->getColumns() as $key => $value) {
                if (is_array($value)) {
                    $retval .= "<optgroup label='" . htmlspecialchars($key) . "'>";
                    foreach ($value as $subvalue) {
                        if ($subvalue == $selected) {
                            $retval .= sprintf('<option selected="selected" title="%s">%s</option>', $GLOBALS['PMA_Types']->getTypeDescription($subvalue), $subvalue);
                        } else {
                            if ($subvalue === '-') {
                                $retval .= '<option disabled="disabled">';
                                $retval .= $subvalue;
                                $retval .= '</option>';
                            } else {
                                $retval .= sprintf('<option title="%s">%s</option>', $GLOBALS['PMA_Types']->getTypeDescription($subvalue), $subvalue);
                            }
                        }
                    }
                    $retval .= '</optgroup>';
                } else {
                    if ($selected == $value) {
                        $retval .= sprintf('<option selected="selected" title="%s">%s</option>', $GLOBALS['PMA_Types']->getTypeDescription($value), $value);
                    } else {
                        $retval .= sprintf('<option title="%s">%s</option>', $GLOBALS['PMA_Types']->getTypeDescription($value), $value);
                    }
                }
            }
        } else {
            $retval = array();
            foreach ($GLOBALS['PMA_Types']->getColumns() as $value) {
                if (is_array($value)) {
                    foreach ($value as $subvalue) {
                        if ($subvalue !== '-') {
                            $retval[] = $subvalue;
                        }
                    }
                } else {
                    if ($value !== '-') {
                        $retval[] = $value;
                    }
                }
            }
        }
        return $retval;
    }
    // end getSupportedDatatypes()
    /**
     * Returns a list of datatypes that are not (yet) handled by PMA.
     * Used by: tbl_change.php and libraries/db_routines.inc.php
     *
     * @return array   list of datatypes
     */
    public static function unsupportedDatatypes()
    {
        $no_support_types = array();
        return $no_support_types;
    }
    /**
     * Return GIS data types
     *
     * @param bool $upper_case whether to return values in upper case
     *
     * @return string[] GIS data types
     */
    public static function getGISDatatypes($upper_case = false)
    {
        $gis_data_types = array('geometry', 'point', 'linestring', 'polygon', 'multipoint', 'multilinestring', 'multipolygon', 'geometrycollection');
        if ($upper_case) {
            for ($i = 0, $nb = count($gis_data_types); $i < $nb; $i++) {
                $gis_data_types[$i] = mb_strtoupper($gis_data_types[$i]);
            }
        }
        return $gis_data_types;
    }
    /**
     * Generates GIS data based on the string passed.
     *
     * @param string $gis_string GIS string
     *
     * @return string GIS data enclosed in 'GeomFromText' function
     */
    public static function createGISData($gis_string)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("createGISData") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php at line 3621")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called createGISData:3621@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php');
        die();
    }
    /**
     * Returns the names and details of the functions
     * that can be applied on geometry data types.
     *
     * @param string $geom_type if provided the output is limited to the functions
     *                          that are applicable to the provided geometry type.
     * @param bool   $binary    if set to false functions that take two geometries
     *                          as arguments will not be included.
     * @param bool   $display   if set to true separators will be added to the
     *                          output array.
     *
     * @return array names and details of the functions that can be applied on
     *               geometry data types.
     */
    public static function getGISFunctions($geom_type = null, $binary = true, $display = false)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getGISFunctions") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php at line 3650")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getGISFunctions:3650@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php');
        die();
    }
    /**
     * Returns default function for a particular column.
     *
     * @param array $field       Data about the column for which
     *                           to generate the dropdown
     * @param bool  $insert_mode Whether the operation is 'insert'
     *
     * @global   array    $cfg            PMA configuration
     * @global   mixed    $data           data of currently edited row
     *                                    (used to detect whether to choose defaults)
     *
     * @return string   An HTML snippet of a dropdown list with function
     *                    names appropriate for the requested column.
     */
    public static function getDefaultFunctionForField($field, $insert_mode)
    {
        /*
         * @todo Except for $cfg, no longer use globals but pass as parameters
         *       from higher levels
         */
        global $cfg, $data;
        $default_function = '';
        // Can we get field class based values?
        $current_class = $GLOBALS['PMA_Types']->getTypeClass($field['True_Type']);
        if (!empty($current_class)) {
            if (isset($cfg['DefaultFunctions']['FUNC_' . $current_class])) {
                $default_function = $cfg['DefaultFunctions']['FUNC_' . $current_class];
            }
        }
        // what function defined as default?
        // for the first timestamp we don't set the default function
        // if there is a default value for the timestamp
        // (not including CURRENT_TIMESTAMP)
        // and the column does not have the
        // ON UPDATE DEFAULT TIMESTAMP attribute.
        if ($field['True_Type'] == 'timestamp' && $field['first_timestamp'] && empty($field['Default']) && empty($data) && $field['Extra'] != 'on update CURRENT_TIMESTAMP' && $field['Null'] == 'NO') {
            $default_function = $cfg['DefaultFunctions']['first_timestamp'];
        }
        // For primary keys of type char(36) or varchar(36) UUID if the default
        // function
        // Only applies to insert mode, as it would silently trash data on updates.
        if ($insert_mode && $field['Key'] == 'PRI' && ($field['Type'] == 'char(36)' || $field['Type'] == 'varchar(36)')) {
            $default_function = $cfg['DefaultFunctions']['FUNC_UUID'];
        }
        return $default_function;
    }
    /**
     * Creates a dropdown box with MySQL functions for a particular column.
     *
     * @param array $field       Data about the column for which
     *                           to generate the dropdown
     * @param bool  $insert_mode Whether the operation is 'insert'
     *
     * @return string   An HTML snippet of a dropdown list with function
     *                    names appropriate for the requested column.
     */
    public static function getFunctionsForField($field, $insert_mode, $foreignData)
    {
        $default_function = self::getDefaultFunctionForField($field, $insert_mode);
        $dropdown_built = array();
        // Create the output
        $retval = '<option></option>' . "\n";
        // loop on the dropdown array and print all available options for that
        // field.
        $functions = $GLOBALS['PMA_Types']->getFunctions($field['True_Type']);
        foreach ($functions as $function) {
            $retval .= '<option';
            if (isset($foreignData['foreign_link']) && $foreignData['foreign_link'] !== false && $default_function === $function) {
                $retval .= ' selected="selected"';
            }
            $retval .= '>' . $function . '</option>' . "\n";
            $dropdown_built[$function] = true;
        }
        // Create separator before all functions list
        if (count($functions) > 0) {
            $retval .= '<option value="" disabled="disabled">--------</option>' . "\n";
        }
        // For compatibility's sake, do not let out all other functions. Instead
        // print a separator (blank) and then show ALL functions which weren't
        // shown yet.
        $functions = $GLOBALS['PMA_Types']->getAllFunctions();
        foreach ($functions as $function) {
            // Skip already included functions
            if (isset($dropdown_built[$function])) {
                continue;
            }
            $retval .= '<option';
            if ($default_function === $function) {
                $retval .= ' selected="selected"';
            }
            $retval .= '>' . $function . '</option>' . "\n";
        }
        // end for
        return $retval;
    }
    // end getFunctionsForField()
    /**
     * Checks if the current user has a specific privilege and returns true if the
     * user indeed has that privilege or false if (s)he doesn't. This function must
     * only be used for features that are available since MySQL 5, because it
     * relies on the INFORMATION_SCHEMA database to be present.
     *
     * Example:   currentUserHasPrivilege('CREATE ROUTINE', 'mydb');
     *            // Checks if the currently logged in user has the global
     *            // 'CREATE ROUTINE' privilege or, if not, checks if the
     *            // user has this privilege on database 'mydb'.
     *
     * @param string $priv The privilege to check
     * @param mixed  $db   null, to only check global privileges
     *                     string, db name where to also check for privileges
     * @param mixed  $tbl  null, to only check global/db privileges
     *                     string, table name where to also check for privileges
     *
     * @return bool
     */
    public static function currentUserHasPrivilege($priv, $db = null, $tbl = null)
    {
        // Get the username for the current user in the format
        // required to use in the information schema database.
        list($user, $host) = $GLOBALS['dbi']->getCurrentUserAndHost();
        if ($user === '') {
            // MySQL is started with --skip-grant-tables
            return true;
        }
        $username = "''";
        $username .= str_replace("'", "''", $user);
        $username .= "''@''";
        $username .= str_replace("'", "''", $host);
        $username .= "''";
        // Prepare the query
        $query = "SELECT `PRIVILEGE_TYPE` FROM `INFORMATION_SCHEMA`.`%s` " . "WHERE GRANTEE='%s' AND PRIVILEGE_TYPE='%s'";
        // Check global privileges first.
        $user_privileges = $GLOBALS['dbi']->fetchValue(sprintf($query, 'USER_PRIVILEGES', $username, $priv));
        if ($user_privileges) {
            return true;
        }
        // If a database name was provided and user does not have the
        // required global privilege, try database-wise permissions.
        if ($db !== null) {
            $query .= " AND '%s' LIKE `TABLE_SCHEMA`";
            $schema_privileges = $GLOBALS['dbi']->fetchValue(sprintf($query, 'SCHEMA_PRIVILEGES', $username, $priv, $GLOBALS['dbi']->escapeString($db)));
            if ($schema_privileges) {
                return true;
            }
        } else {
            // There was no database name provided and the user
            // does not have the correct global privilege.
            return false;
        }
        // If a table name was also provided and we still didn't
        // find any valid privileges, try table-wise privileges.
        if ($tbl !== null) {
            // need to escape wildcards in db and table names, see bug #3518484
            $tbl = str_replace(array('%', '_'), array('\\%', '\\_'), $tbl);
            $query .= " AND TABLE_NAME='%s'";
            $table_privileges = $GLOBALS['dbi']->fetchValue(sprintf($query, 'TABLE_PRIVILEGES', $username, $priv, $GLOBALS['dbi']->escapeString($db), $GLOBALS['dbi']->escapeString($tbl)));
            if ($table_privileges) {
                return true;
            }
        }
        // If we reached this point, the user does not
        // have even valid table-wise privileges.
        return false;
    }
    /**
     * Returns server type for current connection
     *
     * Known types are: MariaDB and MySQL (default)
     *
     * @return string
     */
    public static function getServerType()
    {
        $server_type = 'MySQL';
        if (mb_stripos(PMA_MYSQL_STR_VERSION, 'mariadb') !== false) {
            $server_type = 'MariaDB';
            return $server_type;
        }
        if (mb_stripos(PMA_MYSQL_VERSION_COMMENT, 'percona') !== false) {
            $server_type = 'Percona Server';
            return $server_type;
        }
        return $server_type;
    }
    /**
     * Prepare HTML code for display button.
     *
     * @return String
     */
    public static function getButton()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getButton") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php at line 3989")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getButton:3989@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php');
        die();
    }
    /**
     * Parses ENUM/SET values
     *
     * @param string $definition The definition of the column
     *                           for which to parse the values
     * @param bool   $escapeHtml Whether to escape html entities
     *
     * @return array
     */
    public static function parseEnumSetValues($definition, $escapeHtml = true)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("parseEnumSetValues") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php at line 4006")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called parseEnumSetValues:4006@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php');
        die();
    }
    /**
     * Get regular expression which occur first inside the given sql query.
     *
     * @param array  $regex_array Comparing regular expressions.
     * @param String $query       SQL query to be checked.
     *
     * @return String Matching regular expression.
     */
    public static function getFirstOccurringRegularExpression($regex_array, $query)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getFirstOccurringRegularExpression") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php at line 4067")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getFirstOccurringRegularExpression:4067@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php');
        die();
    }
    /**
     * Return the list of tabs for the menu with corresponding names
     *
     * @param string $level 'server', 'db' or 'table' level
     *
     * @return array list of tabs for the menu
     */
    public static function getMenuTabList($level = null)
    {
        $tabList = array('server' => array('databases' => __('Databases'), 'sql' => __('SQL'), 'status' => __('Status'), 'rights' => __('Users'), 'export' => __('Export'), 'import' => __('Import'), 'settings' => __('Settings'), 'binlog' => __('Binary log'), 'replication' => __('Replication'), 'vars' => __('Variables'), 'charset' => __('Charsets'), 'plugins' => __('Plugins'), 'engine' => __('Engines')), 'db' => array('structure' => __('Structure'), 'sql' => __('SQL'), 'search' => __('Search'), 'qbe' => __('Query'), 'export' => __('Export'), 'import' => __('Import'), 'operation' => __('Operations'), 'privileges' => __('Privileges'), 'routines' => __('Routines'), 'events' => __('Events'), 'triggers' => __('Triggers'), 'tracking' => __('Tracking'), 'designer' => __('Designer'), 'central_columns' => __('Central columns')), 'table' => array('browse' => __('Browse'), 'structure' => __('Structure'), 'sql' => __('SQL'), 'search' => __('Search'), 'insert' => __('Insert'), 'export' => __('Export'), 'import' => __('Import'), 'privileges' => __('Privileges'), 'operation' => __('Operations'), 'tracking' => __('Tracking'), 'triggers' => __('Triggers')));
        if ($level == null) {
            return $tabList;
        } else {
            if (array_key_exists($level, $tabList)) {
                return $tabList[$level];
            } else {
                return null;
            }
        }
    }
    /**
     * Returns information with regards to handling the http request
     *
     * @param array $context Data about the context for which
     *                       to http request is sent
     *
     * @return array of updated context information
     */
    public static function handleContext(array $context)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("handleContext") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php at line 4158")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called handleContext:4158@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php');
        die();
    }
    /**
     * Add fractional seconds to time, datetime and timestamp strings.
     * If the string contains fractional seconds,
     * pads it with 0s up to 6 decimal places.
     *
     * @param string $value time, datetime or timestamp strings
     *
     * @return string time, datetime or timestamp strings with fractional seconds
     */
    public static function addMicroseconds($value)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("addMicroseconds") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php at line 4185")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called addMicroseconds:4185@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php');
        die();
    }
    /**
     * Reads the file, detects the compression MIME type, closes the file
     * and returns the MIME type
     *
     * @param resource $file the file handle
     *
     * @return string the MIME type for compression, or 'none'
     */
    public static function getCompressionMimeType($file)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getCompressionMimeType") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php at line 4211")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getCompressionMimeType:4211@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php');
        die();
    }
    /**
     * Renders a single link for the top of the navigation panel
     *
     * @param string  $link        The url for the link
     * @param bool    $showText    Whether to show the text or to
     *                             only use it for title attributes
     * @param string  $text        The text to display and use for title attributes
     * @param bool    $showIcon    Whether to show the icon
     * @param string  $icon        The filename of the icon to show
     * @param string  $linkId      Value to use for the ID attribute
     * @param boolean $disableAjax Whether to disable ajax page loading for this link
     * @param string  $linkTarget  The name of the target frame for the link
     * @param array   $classes     HTML classes to apply
     *
     * @return string HTML code for one link
     */
    public static function getNavigationLink($link, $showText, $text, $showIcon, $icon, $linkId = '', $disableAjax = false, $linkTarget = '', $classes = array())
    {
        $retval = '<a href="' . $link . '"';
        if (!empty($linkId)) {
            $retval .= ' id="' . $linkId . '"';
        }
        if (!empty($linkTarget)) {
            $retval .= ' target="' . $linkTarget . '"';
        }
        if ($disableAjax) {
            $classes[] = 'disableAjax';
        }
        if (!empty($classes)) {
            $retval .= ' class="' . join(" ", $classes) . '"';
        }
        $retval .= ' title="' . $text . '">';
        if ($showIcon) {
            $retval .= Util::getImage($icon, $text);
        }
        if ($showText) {
            $retval .= $text;
        }
        $retval .= '</a>';
        if ($showText) {
            $retval .= '<br />';
        }
        return $retval;
    }
    /**
     * Provide COLLATE clause, if required, to perform case sensitive comparisons
     * for queries on information_schema.
     *
     * @return string COLLATE clause if needed or empty string.
     */
    public static function getCollateForIS()
    {
        $names = $GLOBALS['dbi']->getLowerCaseNames();
        if ($names === '0') {
            return "COLLATE utf8_bin";
        } elseif ($names === '2') {
            return "COLLATE utf8_general_ci";
        }
        return "";
    }
    /**
     * Process the index data.
     *
     * @param array $indexes index data
     *
     * @return array processes index data
     */
    public static function processIndexData($indexes)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("processIndexData") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php at line 4309")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called processIndexData:4309@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php');
        die();
    }
    /**
     * Function to get html for the start row and number of rows panel
     *
     * @param string $sql_query sql query
     *
     * @return string html
     */
    public static function getStartAndNumberOfRowsPanel($sql_query)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getStartAndNumberOfRowsPanel") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php at line 4359")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getStartAndNumberOfRowsPanel:4359@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php');
        die();
    }
    /**
     * Returns whether the database server supports virtual columns
     *
     * @return bool
     */
    public static function isVirtualColumnsSupported()
    {
        $serverType = self::getServerType();
        return $serverType == 'MySQL' && PMA_MYSQL_INT_VERSION >= 50705 || $serverType == 'MariaDB' && PMA_MYSQL_INT_VERSION >= 50200;
    }
    /**
     * Returns the proper class clause according to the column type
     *
     * @param string $type the column type
     *
     * @return string $class_clause the HTML class clause
     */
    public static function getClassForType($type)
    {
        if ('set' == $type || 'enum' == $type) {
            $class_clause = '';
        } else {
            $class_clause = ' class="nowrap"';
        }
        return $class_clause;
    }
    /**
     * Gets the list of tables in the current db and information about these
     * tables if possible
     *
     * @param string $db       database name
     * @param string $sub_part part of script name
     *
     * @return array
     *
     */
    public static function getDbInfo($db, $sub_part)
    {
        global $cfg;
        /**
         * limits for table list
         */
        if (!isset($_SESSION['tmpval']['table_limit_offset']) || $_SESSION['tmpval']['table_limit_offset_db'] != $db) {
            $_SESSION['tmpval']['table_limit_offset'] = 0;
            $_SESSION['tmpval']['table_limit_offset_db'] = $db;
        }
        if (isset($_REQUEST['pos'])) {
            $_SESSION['tmpval']['table_limit_offset'] = (int) $_REQUEST['pos'];
        }
        $pos = $_SESSION['tmpval']['table_limit_offset'];
        /**
         * whether to display extended stats
         */
        $is_show_stats = $cfg['ShowStats'];
        /**
         * whether selected db is information_schema
         */
        $db_is_system_schema = false;
        if ($GLOBALS['dbi']->isSystemSchema($db)) {
            $is_show_stats = false;
            $db_is_system_schema = true;
        }
        /**
         * information about tables in db
         */
        $tables = array();
        $tooltip_truename = array();
        $tooltip_aliasname = array();
        // Special speedup for newer MySQL Versions (in 4.0 format changed)
        if (true === $cfg['SkipLockedTables']) {
            $db_info_result = $GLOBALS['dbi']->query('SHOW OPEN TABLES FROM ' . Util::backquote($db) . ' WHERE In_use > 0;');
            // Blending out tables in use
            if ($db_info_result && $GLOBALS['dbi']->numRows($db_info_result) > 0) {
                $tables = self::getTablesWhenOpen($db, $db_info_result);
            } elseif ($db_info_result) {
                $GLOBALS['dbi']->freeResult($db_info_result);
            }
        }
        if (empty($tables)) {
            // Set some sorting defaults
            $sort = 'Name';
            $sort_order = 'ASC';
            if (isset($_REQUEST['sort'])) {
                $sortable_name_mappings = array('table' => 'Name', 'records' => 'Rows', 'type' => 'Engine', 'collation' => 'Collation', 'size' => 'Data_length', 'overhead' => 'Data_free', 'creation' => 'Create_time', 'last_update' => 'Update_time', 'last_check' => 'Check_time', 'comment' => 'Comment');
                // Make sure the sort type is implemented
                if (isset($sortable_name_mappings[$_REQUEST['sort']])) {
                    $sort = $sortable_name_mappings[$_REQUEST['sort']];
                    if ($_REQUEST['sort_order'] == 'DESC') {
                        $sort_order = 'DESC';
                    }
                }
            }
            $groupWithSeparator = false;
            $tbl_type = null;
            $limit_offset = 0;
            $limit_count = false;
            $groupTable = array();
            if (!empty($_REQUEST['tbl_group']) || !empty($_REQUEST['tbl_type'])) {
                if (!empty($_REQUEST['tbl_type'])) {
                    // only tables for selected type
                    $tbl_type = $_REQUEST['tbl_type'];
                }
                if (!empty($_REQUEST['tbl_group'])) {
                    // only tables for selected group
                    $tbl_group = $_REQUEST['tbl_group'];
                    // include the table with the exact name of the group if such
                    // exists
                    $groupTable = $GLOBALS['dbi']->getTablesFull($db, $tbl_group, false, null, $limit_offset, $limit_count, $sort, $sort_order, $tbl_type);
                    $groupWithSeparator = $tbl_group . $GLOBALS['cfg']['NavigationTreeTableSeparator'];
                }
            } else {
                // all tables in db
                // - get the total number of tables
                //  (needed for proper working of the MaxTableList feature)
                $tables = $GLOBALS['dbi']->getTables($db);
                $total_num_tables = count($tables);
                if (isset($sub_part) && $sub_part == '_export') {
                    // (don't fetch only a subset if we are coming from
                    // db_export.php, because I think it's too risky to display only
                    // a subset of the table names when exporting a db)
                    /**
                     *
                     * @todo Page selector for table names?
                     */
                } else {
                    // fetch the details for a possible limited subset
                    $limit_offset = $pos;
                    $limit_count = true;
                }
            }
            $tables = array_merge($groupTable, $GLOBALS['dbi']->getTablesFull($db, $groupWithSeparator, $groupWithSeparator !== false, null, $limit_offset, $limit_count, $sort, $sort_order, $tbl_type));
        }
        $num_tables = count($tables);
        //  (needed for proper working of the MaxTableList feature)
        if (!isset($total_num_tables)) {
            $total_num_tables = $num_tables;
        }
        /**
         * If coming from a Show MySQL link on the home page,
         * put something in $sub_part
         */
        if (empty($sub_part)) {
            $sub_part = '_structure';
        }
        return array($tables, $num_tables, $total_num_tables, $sub_part, $is_show_stats, $db_is_system_schema, $tooltip_truename, $tooltip_aliasname, $pos);
    }
    /**
     * Gets the list of tables in the current db, taking into account
     * that they might be "in use"
     *
     * @param string $db             database name
     * @param object $db_info_result result set
     *
     * @return array $tables list of tables
     *
     */
    public static function getTablesWhenOpen($db, $db_info_result)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getTablesWhenOpen") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php at line 4599")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getTablesWhenOpen:4599@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php');
        die();
    }
    /**
     * Returs list of used PHP extensions.
     *
     * @return array of strings
     */
    public static function listPHPExtensions()
    {
        $result = array();
        if (DatabaseInterface::checkDbExtension('mysqli')) {
            $result[] = 'mysqli';
        } else {
            $result[] = 'mysql';
        }
        if (extension_loaded('curl')) {
            $result[] = 'curl';
        }
        if (extension_loaded('mbstring')) {
            $result[] = 'mbstring';
        }
        return $result;
    }
    /**
     * Converts given (request) paramter to string
     *
     * @param mixed $value Value to convert
     *
     * @return string
     */
    public static function requestString($value)
    {
        while (is_array($value) || is_object($value)) {
            $value = reset($value);
        }
        return trim((string) $value);
    }
    /**
     * Creates HTTP request using curl
     *
     * @param mixed    $response           HTTP response
     * @param interger $http_status        HTTP response status code
     * @param bool     $return_only_status If set to true, the method would only return response status
     *
     * @return mixed
     */
    public static function httpRequestReturn($response, $http_status, $return_only_status)
    {
        if ($http_status == 404) {
            return false;
        }
        if ($http_status != 200) {
            return null;
        }
        if ($return_only_status) {
            return true;
        }
        return $response;
    }
    /**
     * Creates HTTP request using curl
     *
     * @param string $url                Url to send the request
     * @param string $method             HTTP request method (GET, POST, PUT, DELETE, etc)
     * @param bool   $return_only_status If set to true, the method would only return response status
     * @param mixed  $content            Content to be sent with HTTP request
     * @param string $header             Header to be set for the HTTP request
     * @param int    $ssl                SSL mode to use
     *
     * @return mixed
     */
    public static function httprequestcurl($url, $method, $return_only_status = false, $content = null, $header = "", $ssl = 0)
    {
        $curl_handle = curl_init($url);
        if ($curl_handle === false) {
            return null;
        }
        $curl_status = true;
        if (strlen($GLOBALS['cfg']['ProxyUrl']) > 0) {
            $curl_status &= curl_setopt($curl_handle, CURLOPT_PROXY, $GLOBALS['cfg']['ProxyUrl']);
            if (strlen($GLOBALS['cfg']['ProxyUser']) > 0) {
                $curl_status &= curl_setopt($curl_handle, CURLOPT_PROXYUSERPWD, $GLOBALS['cfg']['ProxyUser'] . ':' . $GLOBALS['cfg']['ProxyPass']);
            }
        }
        $curl_status &= curl_setopt($curl_handle, CURLOPT_USERAGENT, 'phpMyAdmin');
        if ($method != "GET") {
            $curl_status &= curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, $method);
        }
        if ($header) {
            $curl_status &= curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array($header));
        }
        if ($method == "POST") {
            $curl_status &= curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $content);
        }
        $curl_status &= curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, '2');
        $curl_status &= curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, '1');
        /**
         * Configure ISRG Root X1 to be able to verify Let's Encrypt SSL
         * certificates even without properly configured curl in PHP.
         *
         * See https://letsencrypt.org/certificates/
         */
        $certs_dir = dirname(__FILE__) . '/certs/';
        /* See code below for logic */
        if ($ssl == CURLOPT_CAPATH) {
            $curl_status &= curl_setopt($curl_handle, CURLOPT_CAPATH, $certs_dir);
        } elseif ($ssl == CURLOPT_CAINFO) {
            $curl_status &= curl_setopt($curl_handle, CURLOPT_CAINFO, $certs_dir . 'isrgrootx1.pem');
        }
        $curl_status &= curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        $curl_status &= curl_setopt($curl_handle, CURLOPT_FOLLOWLOCATION, 0);
        $curl_status &= curl_setopt($curl_handle, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $curl_status &= curl_setopt($curl_handle, CURLOPT_TIMEOUT, 10);
        $curl_status &= curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 10);
        if (!$curl_status) {
            return null;
        }
        $response = @curl_exec($curl_handle);
        if ($response === false) {
            /*
             * In case of SSL verification failure let's try configuring curl
             * certificate verification. Unfortunately it is tricky as setting
             * options incompatible with PHP build settings can lead to failure.
             *
             * So let's rather try the options one by one.
             *
             * 1. Try using system SSL storage.
             * 2. Try setting CURLOPT_CAINFO.
             * 3. Try setting CURLOPT_CAPATH.
             * 4. Fail.
             */
            if (curl_getinfo($curl_handle, CURLINFO_SSL_VERIFYRESULT) != 0) {
                if ($ssl == 0) {
                    self::httpRequestCurl($url, $method, $return_only_status, $content, $header, CURLOPT_CAINFO);
                } elseif ($ssl == CURLOPT_CAINFO) {
                    self::httpRequestCurl($url, $method, $return_only_status, $content, $header, CURLOPT_CAPATH);
                }
            }
            return null;
        }
        $http_status = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);
        return Util::httpRequestReturn($response, $http_status, $return_only_status);
    }
    /**
     * Creates HTTP request using file_get_contents
     *
     * @param string $url                Url to send the request
     * @param string $method             HTTP request method (GET, POST, PUT, DELETE, etc)
     * @param bool   $return_only_status If set to true, the method would only return response status
     * @param mixed  $content            Content to be sent with HTTP request
     * @param string $header             Header to be set for the HTTP request
     *
     * @return mixed
     */
    public static function httpRequestFopen($url, $method, $return_only_status = false, $content = null, $header = "")
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("httpRequestFopen") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php at line 4842")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called httpRequestFopen:4842@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Util.php');
        die();
    }
    /**
     * Creates HTTP request
     *
     * @param string $url                Url to send the request
     * @param string $method             HTTP request method (GET, POST, PUT, DELETE, etc)
     * @param bool   $return_only_status If set to true, the method would only return response status
     * @param mixed  $content            Content to be sent with HTTP request
     * @param string $header             Header to be set for the HTTP request
     *
     * @return mixed
     */
    public static function httpRequest($url, $method, $return_only_status = false, $content = null, $header = "")
    {
        if (function_exists('curl_init')) {
            return Util::httpRequestCurl($url, $method, $return_only_status, $content, $header);
        } else {
            if (ini_get('allow_url_fopen')) {
                return Util::httpRequestFopen($url, $method, $return_only_status, $content, $header);
            }
        }
        return null;
    }
}