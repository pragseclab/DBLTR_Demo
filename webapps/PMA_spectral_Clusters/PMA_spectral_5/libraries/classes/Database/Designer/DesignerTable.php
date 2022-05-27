<?php

declare (strict_types=1);
namespace PhpMyAdmin\Database\Designer;

use PhpMyAdmin\Util;
/**
 * Common functions for Designer
 */
class DesignerTable
{
    /** @var string */
    private $tableName;
    /** @var string */
    private $databaseName;
    /** @var string */
    private $tableEngine;
    /** @var string|null */
    private $displayField;
    /**
     * Create a new DesignerTable
     *
     * @param string      $databaseName The database name
     * @param string      $tableName    The table name
     * @param string      $tableEngine  The table engine
     * @param string|null $displayField The display field if available
     */
    public function __construct(string $databaseName, string $tableName, string $tableEngine, ?string $displayField)
    {
        $this->databaseName = $databaseName;
        $this->tableName = $tableName;
        $this->tableEngine = $tableEngine;
        $this->displayField = $displayField;
    }
    /**
     * The table engine supports or not foreign keys
     */
    public function supportsForeignkeys() : bool
    {
        return Util::isForeignKeySupported($this->tableEngine);
    }
    /**
     * Get the database name
     */
    public function getDatabaseName() : string
    {
        return $this->databaseName;
    }
    /**
     * Get the table name
     */
    public function getTableName() : string
    {
        return $this->tableName;
    }
    /**
     * Get the table engine
     */
    public function getTableEngine() : string
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getTableEngine") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Database/Designer/DesignerTable.php at line 61")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getTableEngine:61@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Database/Designer/DesignerTable.php');
        die();
    }
    /**
     * Get the displayed field
     */
    public function getDisplayField() : ?string
    {
        return $this->displayField;
    }
    /**
     * Get the db and table separated with a dot
     */
    public function getDbTableString() : string
    {
        return $this->databaseName . '.' . $this->tableName;
    }
}