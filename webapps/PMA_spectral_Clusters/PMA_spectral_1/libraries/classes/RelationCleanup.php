<?php

/**
 * Set of functions used for cleaning up phpMyAdmin tables
 */
declare (strict_types=1);
namespace PhpMyAdmin;

/**
 * PhpMyAdmin\RelationCleanup class
 */
class RelationCleanup
{
    /** @var Relation */
    public $relation;
    /** @var DatabaseInterface */
    public $dbi;
    /**
     * @param DatabaseInterface $dbi      DatabaseInterface object
     * @param Relation          $relation Relation object
     */
    public function __construct($dbi, Relation $relation)
    {
        $this->dbi = $dbi;
        $this->relation = $relation;
    }
    /**
     * Cleanup column related relation stuff
     *
     * @param string $db     database name
     * @param string $table  table name
     * @param string $column column name
     *
     * @return void
     */
    public function column($db, $table, $column)
    {
        $cfgRelation = $this->relation->getRelationsParam();
        if ($cfgRelation['commwork']) {
            $remove_query = 'DELETE FROM ' . Util::backquote($cfgRelation['db']) . '.' . Util::backquote($cfgRelation['column_info']) . ' WHERE db_name  = \'' . $this->dbi->escapeString($db) . '\'' . ' AND table_name = \'' . $this->dbi->escapeString($table) . '\'' . ' AND column_name = \'' . $this->dbi->escapeString($column) . '\'';
            $this->relation->queryAsControlUser($remove_query);
        }
        if ($cfgRelation['displaywork']) {
            $remove_query = 'DELETE FROM ' . Util::backquote($cfgRelation['db']) . '.' . Util::backquote($cfgRelation['table_info']) . ' WHERE db_name  = \'' . $this->dbi->escapeString($db) . '\'' . ' AND table_name = \'' . $this->dbi->escapeString($table) . '\'' . ' AND display_field = \'' . $this->dbi->escapeString($column) . '\'';
            $this->relation->queryAsControlUser($remove_query);
        }
        if (!$cfgRelation['relwork']) {
            return;
        }
        $remove_query = 'DELETE FROM ' . Util::backquote($cfgRelation['db']) . '.' . Util::backquote($cfgRelation['relation']) . ' WHERE master_db  = \'' . $this->dbi->escapeString($db) . '\'' . ' AND master_table = \'' . $this->dbi->escapeString($table) . '\'' . ' AND master_field = \'' . $this->dbi->escapeString($column) . '\'';
        $this->relation->queryAsControlUser($remove_query);
        $remove_query = 'DELETE FROM ' . Util::backquote($cfgRelation['db']) . '.' . Util::backquote($cfgRelation['relation']) . ' WHERE foreign_db  = \'' . $this->dbi->escapeString($db) . '\'' . ' AND foreign_table = \'' . $this->dbi->escapeString($table) . '\'' . ' AND foreign_field = \'' . $this->dbi->escapeString($column) . '\'';
        $this->relation->queryAsControlUser($remove_query);
    }
    /**
     * Cleanup table related relation stuff
     *
     * @param string $db    database name
     * @param string $table table name
     *
     * @return void
     */
    public function table($db, $table)
    {
        $cfgRelation = $this->relation->getRelationsParam();
        if ($cfgRelation['commwork']) {
            $remove_query = 'DELETE FROM ' . Util::backquote($cfgRelation['db']) . '.' . Util::backquote($cfgRelation['column_info']) . ' WHERE db_name  = \'' . $this->dbi->escapeString($db) . '\'' . ' AND table_name = \'' . $this->dbi->escapeString($table) . '\'';
            $this->relation->queryAsControlUser($remove_query);
        }
        if ($cfgRelation['displaywork']) {
            $remove_query = 'DELETE FROM ' . Util::backquote($cfgRelation['db']) . '.' . Util::backquote($cfgRelation['table_info']) . ' WHERE db_name  = \'' . $this->dbi->escapeString($db) . '\'' . ' AND table_name = \'' . $this->dbi->escapeString($table) . '\'';
            $this->relation->queryAsControlUser($remove_query);
        }
        if ($cfgRelation['pdfwork']) {
            $remove_query = 'DELETE FROM ' . Util::backquote($cfgRelation['db']) . '.' . Util::backquote($cfgRelation['table_coords']) . ' WHERE db_name  = \'' . $this->dbi->escapeString($db) . '\'' . ' AND table_name = \'' . $this->dbi->escapeString($table) . '\'';
            $this->relation->queryAsControlUser($remove_query);
        }
        if ($cfgRelation['relwork']) {
            $remove_query = 'DELETE FROM ' . Util::backquote($cfgRelation['db']) . '.' . Util::backquote($cfgRelation['relation']) . ' WHERE master_db  = \'' . $this->dbi->escapeString($db) . '\'' . ' AND master_table = \'' . $this->dbi->escapeString($table) . '\'';
            $this->relation->queryAsControlUser($remove_query);
            $remove_query = 'DELETE FROM ' . Util::backquote($cfgRelation['db']) . '.' . Util::backquote($cfgRelation['relation']) . ' WHERE foreign_db  = \'' . $this->dbi->escapeString($db) . '\'' . ' AND foreign_table = \'' . $this->dbi->escapeString($table) . '\'';
            $this->relation->queryAsControlUser($remove_query);
        }
        if ($cfgRelation['uiprefswork']) {
            $remove_query = 'DELETE FROM ' . Util::backquote($cfgRelation['db']) . '.' . Util::backquote($cfgRelation['table_uiprefs']) . ' WHERE db_name  = \'' . $this->dbi->escapeString($db) . '\'' . ' AND table_name = \'' . $this->dbi->escapeString($table) . '\'';
            $this->relation->queryAsControlUser($remove_query);
        }
        if (!$cfgRelation['navwork']) {
            return;
        }
        $remove_query = 'DELETE FROM ' . Util::backquote($cfgRelation['db']) . '.' . Util::backquote($cfgRelation['navigationhiding']) . ' WHERE db_name  = \'' . $this->dbi->escapeString($db) . '\'' . ' AND (table_name = \'' . $this->dbi->escapeString($table) . '\'' . ' OR (item_name = \'' . $this->dbi->escapeString($table) . '\'' . ' AND item_type = \'table\'))';
        $this->relation->queryAsControlUser($remove_query);
    }
    /**
     * Cleanup database related relation stuff
     *
     * @param string $db database name
     *
     * @return void
     */
    public function database($db)
    {
        $cfgRelation = $this->relation->getRelationsParam();
        if ($cfgRelation['commwork']) {
            $remove_query = 'DELETE FROM ' . Util::backquote($cfgRelation['db']) . '.' . Util::backquote($cfgRelation['column_info']) . ' WHERE db_name  = \'' . $this->dbi->escapeString($db) . '\'';
            $this->relation->queryAsControlUser($remove_query);
        }
        if ($cfgRelation['bookmarkwork']) {
            $remove_query = 'DELETE FROM ' . Util::backquote($cfgRelation['db']) . '.' . Util::backquote($cfgRelation['bookmark']) . ' WHERE dbase  = \'' . $this->dbi->escapeString($db) . '\'';
            $this->relation->queryAsControlUser($remove_query);
        }
        if ($cfgRelation['displaywork']) {
            $remove_query = 'DELETE FROM ' . Util::backquote($cfgRelation['db']) . '.' . Util::backquote($cfgRelation['table_info']) . ' WHERE db_name  = \'' . $this->dbi->escapeString($db) . '\'';
            $this->relation->queryAsControlUser($remove_query);
        }
        if ($cfgRelation['pdfwork']) {
            $remove_query = 'DELETE FROM ' . Util::backquote($cfgRelation['db']) . '.' . Util::backquote($cfgRelation['pdf_pages']) . ' WHERE db_name  = \'' . $this->dbi->escapeString($db) . '\'';
            $this->relation->queryAsControlUser($remove_query);
            $remove_query = 'DELETE FROM ' . Util::backquote($cfgRelation['db']) . '.' . Util::backquote($cfgRelation['table_coords']) . ' WHERE db_name  = \'' . $this->dbi->escapeString($db) . '\'';
            $this->relation->queryAsControlUser($remove_query);
        }
        if ($cfgRelation['relwork']) {
            $remove_query = 'DELETE FROM ' . Util::backquote($cfgRelation['db']) . '.' . Util::backquote($cfgRelation['relation']) . ' WHERE master_db  = \'' . $this->dbi->escapeString($db) . '\'';
            $this->relation->queryAsControlUser($remove_query);
            $remove_query = 'DELETE FROM ' . Util::backquote($cfgRelation['db']) . '.' . Util::backquote($cfgRelation['relation']) . ' WHERE foreign_db  = \'' . $this->dbi->escapeString($db) . '\'';
            $this->relation->queryAsControlUser($remove_query);
        }
        if ($cfgRelation['uiprefswork']) {
            $remove_query = 'DELETE FROM ' . Util::backquote($cfgRelation['db']) . '.' . Util::backquote($cfgRelation['table_uiprefs']) . ' WHERE db_name  = \'' . $this->dbi->escapeString($db) . '\'';
            $this->relation->queryAsControlUser($remove_query);
        }
        if ($cfgRelation['navwork']) {
            $remove_query = 'DELETE FROM ' . Util::backquote($cfgRelation['db']) . '.' . Util::backquote($cfgRelation['navigationhiding']) . ' WHERE db_name  = \'' . $this->dbi->escapeString($db) . '\'';
            $this->relation->queryAsControlUser($remove_query);
        }
        if ($cfgRelation['savedsearcheswork']) {
            $remove_query = 'DELETE FROM ' . Util::backquote($cfgRelation['db']) . '.' . Util::backquote($cfgRelation['savedsearches']) . ' WHERE db_name  = \'' . $this->dbi->escapeString($db) . '\'';
            $this->relation->queryAsControlUser($remove_query);
        }
        if (!$cfgRelation['centralcolumnswork']) {
            return;
        }
        $remove_query = 'DELETE FROM ' . Util::backquote($cfgRelation['db']) . '.' . Util::backquote($cfgRelation['central_columns']) . ' WHERE db_name  = \'' . $this->dbi->escapeString($db) . '\'';
        $this->relation->queryAsControlUser($remove_query);
    }
    /**
     * Cleanup user related relation stuff
     *
     * @param string $username username
     *
     * @return void
     */
    public function user($username)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("user") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/RelationCleanup.php at line 155")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called user:155@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/RelationCleanup.php');
        die();
    }
}