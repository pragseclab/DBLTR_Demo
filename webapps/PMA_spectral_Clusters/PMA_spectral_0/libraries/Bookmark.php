<?php

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Handles bookmarking SQL queries
 *
 * @package PhpMyAdmin
 */
namespace PMA\libraries;

use PMA\libraries\Util;
use PMA\libraries\DatabaseInterface;
/**
 * Handles bookmarking SQL queries
 *
 * @package PhpMyAdmin
 */
class Bookmark
{
    /**
     * ID of the bookmark
     *
     * @var int
     */
    private $_id;
    /**
     * Database the bookmark belongs to
     *
     * @var string
     */
    private $_database;
    /**
     * The user to whom the bookmark belongs, empty for public bookmarks
     *
     * @var string
     */
    private $_user;
    /**
     * Label of the bookmark
     *
     * @var string
     */
    private $_label;
    /**
     * SQL query that is bookmarked
     *
     * @var string
     */
    private $_query;
    /**
     * Returns the ID of the bookmark
     *
     * @return int
     */
    public function getId()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getId") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Bookmark.php at line 58")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getId:58@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Bookmark.php');
        die();
    }
    /**
     * Returns the database of the bookmark
     *
     * @return string
     */
    public function getDatabase()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getDatabase") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Bookmark.php at line 68")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getDatabase:68@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Bookmark.php');
        die();
    }
    /**
     * Returns the user whom the bookmark belongs to
     *
     * @return string
     */
    public function getUser()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getUser") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Bookmark.php at line 78")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getUser:78@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Bookmark.php');
        die();
    }
    /**
     * Returns the label of the bookmark
     *
     * @return string
     */
    public function getLabel()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getLabel") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Bookmark.php at line 88")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getLabel:88@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Bookmark.php');
        die();
    }
    /**
     * Returns the query
     *
     * @return string
     */
    public function getQuery()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getQuery") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Bookmark.php at line 98")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getQuery:98@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Bookmark.php');
        die();
    }
    /**
     * Adds a bookmark
     *
     * @return boolean whether the INSERT succeeds or not
     *
     * @access public
     *
     * @global resource $controllink the controluser db connection handle
     */
    public function save()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("save") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Bookmark.php at line 112")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called save:112@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Bookmark.php');
        die();
    }
    /**
     * Deletes a bookmark
     *
     * @return bool true if successful
     *
     * @access public
     *
     * @global resource $controllink the controluser db connection handle
     */
    public function delete()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("delete") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Bookmark.php at line 140")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called delete:140@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Bookmark.php');
        die();
    }
    /**
     * Returns the number of variables in a bookmark
     *
     * @return number number of variables
     */
    public function getVariableCount()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getVariableCount") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Bookmark.php at line 160")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getVariableCount:160@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Bookmark.php');
        die();
    }
    /**
     * Replace the placeholders in the bookmark query with variables
     *
     * @param  array $variables array of variables
     *
     * @return string query with variables applied
     */
    public function applyVariables($variables)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("applyVariables") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Bookmark.php at line 175")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called applyVariables:175@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Bookmark.php');
        die();
    }
    /**
     * Defines the bookmark parameters for the current user
     *
     * @return array the bookmark parameters for the current user
     * @access  public
     */
    public static function getParams()
    {
        static $cfgBookmark = null;
        if (null !== $cfgBookmark) {
            return $cfgBookmark;
        }
        $cfgRelation = PMA_getRelationsParam();
        if ($cfgRelation['bookmarkwork']) {
            $cfgBookmark = array('user' => $GLOBALS['cfg']['Server']['user'], 'db' => $cfgRelation['db'], 'table' => $cfgRelation['bookmark']);
        } else {
            $cfgBookmark = false;
        }
        return $cfgBookmark;
    }
    /**
     * Creates a Bookmark object from the parameters
     *
     * @param array   $bkm_fields the properties of the bookmark to add; here,
     *                            $bkm_fields['bkm_sql_query'] is urlencoded
     * @param boolean $all_users  whether to make the bookmark available
     *                            for all users
     *
     * @return Bookmark|false
     */
    public static function createBookmark($bkm_fields, $all_users = false)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("createBookmark") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Bookmark.php at line 236")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called createBookmark:236@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Bookmark.php');
        die();
    }
    /**
     * Gets the list of bookmarks defined for the current database
     *
     * @param string|bool $db the current database name or false
     *
     * @return Bookmark[] the bookmarks list
     *
     * @access public
     *
     * @global resource $controllink the controluser db connection handle
     */
    public static function getList($db = false)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getList") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Bookmark.php at line 266")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getList:266@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Bookmark.php');
        die();
    }
    /**
     * Retrieve a specific bookmark
     *
     * @param string  $db                  the current database name
     * @param mixed   $id                  an identifier of the bookmark to get
     * @param string  $id_field            which field to look up the identifier
     * @param boolean $action_bookmark_all true: get all bookmarks regardless
     *                                     of the owning user
     * @param boolean $exact_user_match    whether to ignore bookmarks with no user
     *
     * @return Bookmark the bookmark
     *
     * @access  public
     *
     * @global  resource $controllink the controluser db connection handle
     *
     */
    public static function get($db, $id, $id_field = 'id', $action_bookmark_all = false, $exact_user_match = false)
    {
        global $controllink;
        $cfgBookmark = self::getParams();
        if (empty($cfgBookmark)) {
            return null;
        }
        $query = "SELECT * FROM " . Util::backquote($cfgBookmark['db']) . "." . Util::backquote($cfgBookmark['table']) . " WHERE dbase = '" . $GLOBALS['dbi']->escapeString($db) . "'";
        if (!$action_bookmark_all) {
            $query .= " AND (user = '" . $GLOBALS['dbi']->escapeString($cfgBookmark['user']) . "'";
            if (!$exact_user_match) {
                $query .= " OR user = ''";
            }
            $query .= ")";
        }
        $query .= " AND " . Util::backquote($id_field) . " = " . $GLOBALS['dbi']->escapeString($id) . " LIMIT 1";
        $result = $GLOBALS['dbi']->fetchSingleRow($query, 'ASSOC', $controllink);
        if (!empty($result)) {
            $bookmark = new Bookmark();
            $bookmark->_id = $result['id'];
            $bookmark->_database = $result['dbase'];
            $bookmark->_user = $result['user'];
            $bookmark->_label = $result['label'];
            $bookmark->_query = $result['query'];
            return $bookmark;
        }
        return null;
    }
}