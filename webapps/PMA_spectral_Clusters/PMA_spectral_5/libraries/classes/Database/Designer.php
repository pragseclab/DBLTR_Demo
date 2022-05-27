<?php

declare (strict_types=1);
namespace PhpMyAdmin\Database;

use PhpMyAdmin\Database\Designer\DesignerTable;
use PhpMyAdmin\DatabaseInterface;
use PhpMyAdmin\Message;
use PhpMyAdmin\Plugins;
use PhpMyAdmin\Relation;
use PhpMyAdmin\Template;
use PhpMyAdmin\Util;
use stdClass;
use function count;
use function intval;
use function is_array;
use function json_decode;
use function json_encode;
use function strpos;
/**
 * Set of functions related to database designer
 */
class Designer
{
    /** @var DatabaseInterface */
    private $dbi;
    /** @var Relation */
    private $relation;
    /** @var Template */
    public $template;
    /**
     * @param DatabaseInterface $dbi      DatabaseInterface object
     * @param Relation          $relation Relation instance
     * @param Template          $template Template instance
     */
    public function __construct(DatabaseInterface $dbi, Relation $relation, Template $template)
    {
        $this->dbi = $dbi;
        $this->relation = $relation;
        $this->template = $template;
    }
    /**
     * Function to get html for displaying the page edit/delete form
     *
     * @param string $db        database name
     * @param string $operation 'edit' or 'delete' depending on the operation
     *
     * @return string html content
     */
    public function getHtmlForEditOrDeletePages($db, $operation)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getHtmlForEditOrDeletePages") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Database/Designer.php at line 52")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getHtmlForEditOrDeletePages:52@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Database/Designer.php');
        die();
    }
    /**
     * Function to get html for displaying the page save as form
     *
     * @param string $db database name
     *
     * @return string html content
     */
    public function getHtmlForPageSaveAs($db)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getHtmlForPageSaveAs") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Database/Designer.php at line 64")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getHtmlForPageSaveAs:64@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Database/Designer.php');
        die();
    }
    /**
     * Retrieve IDs and names of schema pages
     *
     * @param string $db database name
     *
     * @return array array of schema page id and names
     */
    private function getPageIdsAndNames($db)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getPageIdsAndNames") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Database/Designer.php at line 76")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getPageIdsAndNames:76@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Database/Designer.php');
        die();
    }
    /**
     * Function to get html for displaying the schema export
     *
     * @param string $db   database name
     * @param int    $page the page to be exported
     *
     * @return string
     */
    public function getHtmlForSchemaExport($db, $page)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getHtmlForSchemaExport") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Database/Designer.php at line 98")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getHtmlForSchemaExport:98@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Database/Designer.php');
        die();
    }
    /**
     * Returns array of stored values of Designer Settings
     *
     * @return array stored values
     */
    private function getSideMenuParamsArray()
    {
        /** @var DatabaseInterface $dbi */
        global $dbi;
        $params = [];
        $cfgRelation = $this->relation->getRelationsParam();
        if ($cfgRelation['designersettingswork']) {
            $query = 'SELECT `settings_data` FROM ' . Util::backquote($cfgRelation['db']) . '.' . Util::backquote($cfgRelation['designer_settings']) . ' WHERE ' . Util::backquote('username') . ' = "' . $dbi->escapeString($GLOBALS['cfg']['Server']['user']) . '";';
            $result = $this->dbi->fetchSingleRow($query);
            if (is_array($result)) {
                $params = json_decode((string) $result['settings_data'], true);
            }
        }
        return $params;
    }
    /**
     * Returns class names for various buttons on Designer Side Menu
     *
     * @return array class names of various buttons
     */
    public function returnClassNamesFromMenuButtons()
    {
        $classes_array = [];
        $params_array = $this->getSideMenuParamsArray();
        if (isset($params_array['angular_direct']) && $params_array['angular_direct'] === 'angular') {
            $classes_array['angular_direct'] = 'M_butt_Selected_down';
        } else {
            $classes_array['angular_direct'] = 'M_butt';
        }
        if (isset($params_array['snap_to_grid']) && $params_array['snap_to_grid'] === 'on') {
            $classes_array['snap_to_grid'] = 'M_butt_Selected_down';
        } else {
            $classes_array['snap_to_grid'] = 'M_butt';
        }
        if (isset($params_array['pin_text']) && $params_array['pin_text'] === 'true') {
            $classes_array['pin_text'] = 'M_butt_Selected_down';
        } else {
            $classes_array['pin_text'] = 'M_butt';
        }
        if (isset($params_array['relation_lines']) && $params_array['relation_lines'] === 'false') {
            $classes_array['relation_lines'] = 'M_butt_Selected_down';
        } else {
            $classes_array['relation_lines'] = 'M_butt';
        }
        if (isset($params_array['small_big_all']) && $params_array['small_big_all'] === 'v') {
            $classes_array['small_big_all'] = 'M_butt_Selected_down';
        } else {
            $classes_array['small_big_all'] = 'M_butt';
        }
        if (isset($params_array['side_menu']) && $params_array['side_menu'] === 'true') {
            $classes_array['side_menu'] = 'M_butt_Selected_down';
        } else {
            $classes_array['side_menu'] = 'M_butt';
        }
        return $classes_array;
    }
    /**
     * Get HTML to display tables on designer page
     *
     * @param string          $db                       The database name from the request
     * @param DesignerTable[] $designerTables           The designer tables
     * @param array           $tab_pos                  tables positions
     * @param int             $display_page             page number of the selected page
     * @param array           $tab_column               table column info
     * @param array           $tables_all_keys          all indices
     * @param array           $tables_pk_or_unique_keys unique or primary indices
     *
     * @return string html
     */
    public function getDatabaseTables(string $db, array $designerTables, array $tab_pos, $display_page, array $tab_column, array $tables_all_keys, array $tables_pk_or_unique_keys)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getDatabaseTables") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Database/Designer.php at line 181")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getDatabaseTables:181@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Database/Designer.php');
        die();
    }
    /**
     * Returns HTML for Designer page
     *
     * @param string          $db                   database in use
     * @param string          $getDb                database in url
     * @param DesignerTable[] $designerTables       The designer tables
     * @param array           $scriptTables         array on foreign key support for each table
     * @param array           $scriptContr          initialization data array
     * @param DesignerTable[] $scriptDisplayField   displayed tables in designer with their display fields
     * @param int             $displayPage          page number of the selected page
     * @param bool            $visualBuilderMode    whether this is visual query builder
     * @param string          $selectedPage         name of the selected page
     * @param array           $paramsArray          array with class name for various buttons on side menu
     * @param array|null      $tabPos               table positions
     * @param array           $tabColumn            table column info
     * @param array           $tablesAllKeys        all indices
     * @param array           $tablesPkOrUniqueKeys unique or primary indices
     *
     * @return string html
     */
    public function getHtmlForMain(string $db, string $getDb, array $designerTables, array $scriptTables, array $scriptContr, array $scriptDisplayField, $displayPage, bool $visualBuilderMode, $selectedPage, array $paramsArray, ?array $tabPos, array $tabColumn, array $tablesAllKeys, array $tablesPkOrUniqueKeys) : string
    {
        $cfgRelation = $this->relation->getRelationsParam();
        $columnsType = [];
        foreach ($designerTables as $designerTable) {
            $tableName = $designerTable->getDbTableString();
            $limit = count($tabColumn[$tableName]['COLUMN_ID']);
            for ($j = 0; $j < $limit; $j++) {
                $tableColumnName = $tableName . '.' . $tabColumn[$tableName]['COLUMN_NAME'][$j];
                if (isset($tablesPkOrUniqueKeys[$tableColumnName])) {
                    $columnsType[$tableColumnName] = 'designer/FieldKey_small';
                } else {
                    $columnsType[$tableColumnName] = 'designer/Field_small';
                    if (strpos($tabColumn[$tableName]['TYPE'][$j], 'char') !== false || strpos($tabColumn[$tableName]['TYPE'][$j], 'text') !== false) {
                        $columnsType[$tableColumnName] .= '_char';
                    } elseif (strpos($tabColumn[$tableName]['TYPE'][$j], 'int') !== false || strpos($tabColumn[$tableName]['TYPE'][$j], 'float') !== false || strpos($tabColumn[$tableName]['TYPE'][$j], 'double') !== false || strpos($tabColumn[$tableName]['TYPE'][$j], 'decimal') !== false) {
                        $columnsType[$tableColumnName] .= '_int';
                    } elseif (strpos($tabColumn[$tableName]['TYPE'][$j], 'date') !== false || strpos($tabColumn[$tableName]['TYPE'][$j], 'time') !== false || strpos($tabColumn[$tableName]['TYPE'][$j], 'year') !== false) {
                        $columnsType[$tableColumnName] .= '_date';
                    }
                }
            }
        }
        $displayedFields = [];
        foreach ($scriptDisplayField as $designerTable) {
            if ($designerTable->getDisplayField() === null) {
                continue;
            }
            $displayedFields[$designerTable->getTableName()] = $designerTable->getDisplayField();
        }
        $designerConfig = new stdClass();
        $designerConfig->db = $db;
        $designerConfig->scriptTables = $scriptTables;
        $designerConfig->scriptContr = $scriptContr;
        $designerConfig->server = $GLOBALS['server'];
        $designerConfig->scriptDisplayField = $displayedFields;
        $designerConfig->displayPage = (int) $displayPage;
        $designerConfig->tablesEnabled = $cfgRelation['pdfwork'];
        return $this->template->render('database/designer/main', ['db' => $db, 'get_db' => $getDb, 'designer_config' => json_encode($designerConfig), 'display_page' => (int) $displayPage, 'has_query' => $visualBuilderMode, 'visual_builder' => $visualBuilderMode, 'selected_page' => $selectedPage, 'params_array' => $paramsArray, 'theme' => $GLOBALS['PMA_Theme'], 'tab_pos' => $tabPos, 'tab_column' => $tabColumn, 'tables_all_keys' => $tablesAllKeys, 'tables_pk_or_unique_keys' => $tablesPkOrUniqueKeys, 'designerTables' => $designerTables, 'columns_type' => $columnsType]);
    }
}