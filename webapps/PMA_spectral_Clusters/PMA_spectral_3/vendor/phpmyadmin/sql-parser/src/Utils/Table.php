<?php

/**
 * Table utilities.
 */
declare (strict_types=1);
namespace PhpMyAdmin\SqlParser\Utils;

use PhpMyAdmin\SqlParser\Statements\CreateStatement;
use function is_array;
use function str_replace;
/**
 * Table utilities.
 */
class Table
{
    /**
     * Gets the foreign keys of the table.
     *
     * @param CreateStatement $statement the statement to be processed
     *
     * @return array
     */
    public static function getForeignKeys($statement)
    {
        if (empty($statement->fields) || !is_array($statement->fields) || !$statement->options->has('TABLE')) {
            return [];
        }
        $ret = [];
        foreach ($statement->fields as $field) {
            if (empty($field->key) || $field->key->type !== 'FOREIGN KEY') {
                continue;
            }
            $columns = [];
            foreach ($field->key->columns as $column) {
                $columns[] = $column['name'];
            }
            $tmp = ['constraint' => $field->name, 'index_list' => $columns];
            if (!empty($field->references)) {
                $tmp['ref_db_name'] = $field->references->table->database;
                $tmp['ref_table_name'] = $field->references->table->table;
                $tmp['ref_index_list'] = $field->references->columns;
                $opt = $field->references->options->has('ON UPDATE');
                if ($opt) {
                    $tmp['on_update'] = str_replace(' ', '_', $opt);
                }
                $opt = $field->references->options->has('ON DELETE');
                if ($opt) {
                    $tmp['on_delete'] = str_replace(' ', '_', $opt);
                }
            }
            $ret[] = $tmp;
        }
        return $ret;
    }
    /**
     * Gets fields of the table.
     *
     * @param CreateStatement $statement the statement to be processed
     *
     * @return array
     */
    public static function getFields($statement)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getFields") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/phpmyadmin/sql-parser/src/Utils/Table.php at line 65")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getFields:65@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/phpmyadmin/sql-parser/src/Utils/Table.php');
        die();
    }
}