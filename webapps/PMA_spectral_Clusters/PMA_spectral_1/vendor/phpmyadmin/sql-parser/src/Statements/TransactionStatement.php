<?php

/**
 * Transaction statement.
 */
declare (strict_types=1);
namespace PhpMyAdmin\SqlParser\Statements;

use PhpMyAdmin\SqlParser\Components\OptionsArray;
use PhpMyAdmin\SqlParser\Parser;
use PhpMyAdmin\SqlParser\Statement;
use PhpMyAdmin\SqlParser\TokensList;
/**
 * Transaction statement.
 */
class TransactionStatement extends Statement
{
    /**
     * START TRANSACTION and BEGIN.
     */
    public const TYPE_BEGIN = 1;
    /**
     * COMMIT and ROLLBACK.
     */
    public const TYPE_END = 2;
    /**
     * The type of this query.
     *
     * @var int
     */
    public $type;
    /**
     * The list of statements in this transaction.
     *
     * @var Statement[]
     */
    public $statements;
    /**
     * The ending transaction statement which may be a `COMMIT` or a `ROLLBACK`.
     *
     * @var TransactionStatement
     */
    public $end;
    /**
     * Options for this query.
     *
     * @var array
     */
    public static $OPTIONS = ['START TRANSACTION' => 1, 'BEGIN' => 1, 'COMMIT' => 1, 'ROLLBACK' => 1, 'WITH CONSISTENT SNAPSHOT' => 2, 'WORK' => 2, 'AND NO CHAIN' => 3, 'AND CHAIN' => 3, 'RELEASE' => 4, 'NO RELEASE' => 4];
    /**
     * @param Parser     $parser the instance that requests parsing
     * @param TokensList $list   the list of tokens to be parsed
     */
    public function parse(Parser $parser, TokensList $list)
    {
        parent::parse($parser, $list);
        // Checks the type of this query.
        if ($this->options->has('START TRANSACTION') || $this->options->has('BEGIN')) {
            $this->type = self::TYPE_BEGIN;
        } elseif ($this->options->has('COMMIT') || $this->options->has('ROLLBACK')) {
            $this->type = self::TYPE_END;
        }
    }
    /**
     * @return string
     */
    public function build()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("build") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/vendor/phpmyadmin/sql-parser/src/Statements/TransactionStatement.php at line 69")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called build:69@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/vendor/phpmyadmin/sql-parser/src/Statements/TransactionStatement.php');
        die();
    }
}