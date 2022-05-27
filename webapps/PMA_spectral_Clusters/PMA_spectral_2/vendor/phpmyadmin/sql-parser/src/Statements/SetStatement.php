<?php

/**
 * `SET` statement.
 */
declare (strict_types=1);
namespace PhpMyAdmin\SqlParser\Statements;

use PhpMyAdmin\SqlParser\Components\OptionsArray;
use PhpMyAdmin\SqlParser\Components\SetOperation;
use PhpMyAdmin\SqlParser\Statement;
use function trim;
/**
 * `SET` statement.
 */
class SetStatement extends Statement
{
    /**
     * The clauses of this statement, in order.
     *
     * @see Statement::$CLAUSES
     *
     * @var array
     */
    public static $CLAUSES = array('SET' => array('SET', 3), '_END_OPTIONS' => array('_END_OPTIONS', 1));
    /**
     * Possible exceptions in SET statement.
     *
     * @var array
     */
    public static $OPTIONS = array('CHARSET' => array(3, 'var'), 'CHARACTER SET' => array(3, 'var'), 'NAMES' => array(3, 'var'), 'PASSWORD' => array(3, 'expr'), 'SESSION' => 3, 'GLOBAL' => 3, 'PERSIST' => 3, 'PERSIST_ONLY' => 3, '@@SESSION' => 3, '@@GLOBAL' => 3, '@@PERSIST' => 3, '@@PERSIST_ONLY' => 3);
    /** @var array */
    public static $END_OPTIONS = array('COLLATE' => array(1, 'var'), 'DEFAULT' => 1);
    /**
     * Options used in current statement.
     *
     * @var OptionsArray[]
     */
    public $options;
    /**
     * The end options of this query.
     *
     * @see static::$END_OPTIONS
     *
     * @var OptionsArray
     */
    public $end_options;
    /**
     * The updated values.
     *
     * @var SetOperation[]
     */
    public $set;
    /**
     * @return string
     */
    public function build()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("build") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/vendor/phpmyadmin/sql-parser/src/Statements/SetStatement.php at line 59")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called build:59@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/vendor/phpmyadmin/sql-parser/src/Statements/SetStatement.php');
        die();
    }
}