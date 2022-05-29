<?php

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * holds the ListDatabase class
 *
 * @package PhpMyAdmin
 */
namespace PMA\libraries;

require_once './libraries/check_user_privileges.lib.php';
/**
 * handles database lists
 *
 * <code>
 * $ListDatabase = new ListDatabase($userlink);
 * </code>
 *
 * @todo this object should be attached to the PMA_Server object
 *
 * @package PhpMyAdmin
 * @since   phpMyAdmin 2.9.10
 */
class ListDatabase extends ListAbstract
{
    /**
     * @var mixed   database link resource|object to be used
     * @access protected
     */
    protected $db_link = null;
    /**
     * @var mixed   user database link resource|object
     * @access protected
     */
    protected $db_link_user = null;
    /**
     * Constructor
     *
     * @param mixed $db_link_user user database link resource|object
     */
    public function __construct($db_link_user = null)
    {
        $this->db_link = $db_link_user;
        $this->db_link_user = $db_link_user;
        parent::__construct();
        $this->build();
    }
    /**
     * checks if the configuration wants to hide some databases
     *
     * @return void
     */
    protected function checkHideDatabase()
    {
        if (empty($GLOBALS['cfg']['Server']['hide_db'])) {
            return;
        }
        foreach ($this->getArrayCopy() as $key => $db) {
            if (preg_match('/' . $GLOBALS['cfg']['Server']['hide_db'] . '/', $db)) {
                $this->offsetUnset($key);
            }
        }
    }
    /**
     * retrieves database list from server
     *
     * @param string $like_db_name usually a db_name containing wildcards
     *
     * @return array
     */
    protected function retrieve($like_db_name = null)
    {
        $database_list = array();
        $command = "";
        if (!$GLOBALS['cfg']['Server']['DisableIS']) {
            $command .= "SELECT `SCHEMA_NAME` FROM `INFORMATION_SCHEMA`.`SCHEMATA`";
            if (null !== $like_db_name) {
                $command .= " WHERE `SCHEMA_NAME` LIKE '" . $like_db_name . "'";
            }
        } else {
            if ($GLOBALS['dbs_to_test'] === false || null !== $like_db_name) {
                $command .= "SHOW DATABASES";
                if (null !== $like_db_name) {
                    $command .= " LIKE '" . $like_db_name . "'";
                }
            } else {
                foreach ($GLOBALS['dbs_to_test'] as $db) {
                    $database_list = array_merge($database_list, $this->retrieve($db));
                }
            }
        }
        if ($command) {
            $database_list = $GLOBALS['dbi']->fetchResult($command, null, null, $this->db_link);
        }
        if ($GLOBALS['cfg']['NaturalOrder']) {
            natsort($database_list);
        } else {
            // need to sort anyway, otherwise information_schema
            // goes at the top
            sort($database_list);
        }
        return $database_list;
    }
    /**
     * builds up the list
     *
     * @return void
     */
    public function build()
    {
        if (!$this->checkOnlyDatabase()) {
            $items = $this->retrieve();
            $this->exchangeArray($items);
        }
        $this->checkHideDatabase();
    }
    /**
     * checks the only_db configuration
     *
     * @return boolean false if there is no only_db, otherwise true
     */
    protected function checkOnlyDatabase()
    {
        if (is_string($GLOBALS['cfg']['Server']['only_db']) && strlen($GLOBALS['cfg']['Server']['only_db']) > 0) {
            $GLOBALS['cfg']['Server']['only_db'] = array($GLOBALS['cfg']['Server']['only_db']);
        }
        if (!is_array($GLOBALS['cfg']['Server']['only_db'])) {
            return false;
        }
        $items = array();
        foreach ($GLOBALS['cfg']['Server']['only_db'] as $each_only_db) {
            // check if the db name contains wildcard,
            // thus containing not escaped _ or %
            if (!preg_match('/(^|[^\\\\])(_|%)/', $each_only_db)) {
                // ... not contains wildcard
                $items[] = Util::unescapeMysqlWildcards($each_only_db);
                continue;
            }
            $items = array_merge($items, $this->retrieve($each_only_db));
        }
        $this->exchangeArray($items);
        return true;
    }
    /**
     * returns default item
     *
     * @return string default item
     */
    public function getDefault()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getDefault") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/ListDatabase.php at line 179")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getDefault:179@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/ListDatabase.php');
        die();
    }
}