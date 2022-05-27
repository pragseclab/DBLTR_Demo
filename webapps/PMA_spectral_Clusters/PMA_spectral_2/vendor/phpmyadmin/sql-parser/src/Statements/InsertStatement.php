<?php

/**
 * `INSERT` statement.
 */
declare (strict_types=1);
namespace PhpMyAdmin\SqlParser\Statements;

use PhpMyAdmin\SqlParser\Components\Array2d;
use PhpMyAdmin\SqlParser\Components\ArrayObj;
use PhpMyAdmin\SqlParser\Components\IntoKeyword;
use PhpMyAdmin\SqlParser\Components\OptionsArray;
use PhpMyAdmin\SqlParser\Components\SetOperation;
use PhpMyAdmin\SqlParser\Parser;
use PhpMyAdmin\SqlParser\Statement;
use PhpMyAdmin\SqlParser\Token;
use PhpMyAdmin\SqlParser\TokensList;
use function count;
use function strlen;
use function trim;
/**
 * `INSERT` statement.
 *
 * INSERT [LOW_PRIORITY | DELAYED | HIGH_PRIORITY] [IGNORE]
 *     [INTO] tbl_name
 *     [PARTITION (partition_name,...)]
 *     [(col_name,...)]
 *     {VALUES | VALUE} ({expr | DEFAULT},...),(...),...
 *     [ ON DUPLICATE KEY UPDATE
 *       col_name=expr
 *         [, col_name=expr] ... ]
 *
 * or
 *
 * INSERT [LOW_PRIORITY | DELAYED | HIGH_PRIORITY] [IGNORE]
 *     [INTO] tbl_name
 *     [PARTITION (partition_name,...)]
 *     SET col_name={expr | DEFAULT}, ...
 *     [ ON DUPLICATE KEY UPDATE
 *       col_name=expr
 *         [, col_name=expr] ... ]
 *
 * or
 *
 * INSERT [LOW_PRIORITY | HIGH_PRIORITY] [IGNORE]
 *     [INTO] tbl_name
 *     [PARTITION (partition_name,...)]
 *     [(col_name,...)]
 *     SELECT ...
 *     [ ON DUPLICATE KEY UPDATE
 *       col_name=expr
 *         [, col_name=expr] ... ]
 */
class InsertStatement extends Statement
{
    /**
     * Options for `INSERT` statements.
     *
     * @var array
     */
    public static $OPTIONS = array('LOW_PRIORITY' => 1, 'DELAYED' => 2, 'HIGH_PRIORITY' => 3, 'IGNORE' => 4);
    /**
     * Tables used as target for this statement.
     *
     * @var IntoKeyword
     */
    public $into;
    /**
     * Values to be inserted.
     *
     * @var ArrayObj[]|null
     */
    public $values;
    /**
     * If SET clause is present
     * holds the SetOperation.
     *
     * @var SetOperation[]
     */
    public $set;
    /**
     * If SELECT clause is present
     * holds the SelectStatement.
     *
     * @var SelectStatement
     */
    public $select;
    /**
     * If ON DUPLICATE KEY UPDATE clause is present
     * holds the SetOperation.
     *
     * @var SetOperation[]
     */
    public $onDuplicateSet;
    /**
     * @return string
     */
    public function build()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("build") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/vendor/phpmyadmin/sql-parser/src/Statements/InsertStatement.php at line 100")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called build:100@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/vendor/phpmyadmin/sql-parser/src/Statements/InsertStatement.php');
        die();
    }
    /**
     * @param Parser     $parser the instance that requests parsing
     * @param TokensList $list   the list of tokens to be parsed
     */
    public function parse(Parser $parser, TokensList $list)
    {
        ++$list->idx;
        // Skipping `INSERT`.
        // parse any options if provided
        $this->options = OptionsArray::parse($parser, $list, static::$OPTIONS);
        ++$list->idx;
        /**
         * The state of the parser.
         *
         * Below are the states of the parser.
         *
         *      0 ---------------------------------[ INTO ]----------------------------------> 1
         *
         *      1 -------------------------[ VALUES/VALUE/SET/SELECT ]-----------------------> 2
         *
         *      2 -------------------------[ ON DUPLICATE KEY UPDATE ]-----------------------> 3
         *
         * @var int
         */
        $state = 0;
        /**
         * For keeping track of semi-states on encountering
         * ON DUPLICATE KEY UPDATE ...
         */
        $miniState = 0;
        for (; $list->idx < $list->count; ++$list->idx) {
            /**
             * Token parsed at this moment.
             *
             * @var Token
             */
            $token = $list->tokens[$list->idx];
            // End of statement.
            if ($token->type === Token::TYPE_DELIMITER) {
                break;
            }
            // Skipping whitespaces and comments.
            if ($token->type === Token::TYPE_WHITESPACE || $token->type === Token::TYPE_COMMENT) {
                continue;
            }
            if ($state === 0) {
                if ($token->type === Token::TYPE_KEYWORD && $token->keyword !== 'INTO') {
                    $parser->error('Unexpected keyword.', $token);
                    break;
                }
                ++$list->idx;
                $this->into = IntoKeyword::parse($parser, $list, ['fromInsert' => true]);
                $state = 1;
            } elseif ($state === 1) {
                if ($token->type === Token::TYPE_KEYWORD) {
                    if ($token->keyword === 'VALUE' || $token->keyword === 'VALUES') {
                        ++$list->idx;
                        // skip VALUES
                        $this->values = Array2d::parse($parser, $list);
                    } elseif ($token->keyword === 'SET') {
                        ++$list->idx;
                        // skip SET
                        $this->set = SetOperation::parse($parser, $list);
                    } elseif ($token->keyword === 'SELECT') {
                        $this->select = new SelectStatement($parser, $list);
                    } else {
                        $parser->error('Unexpected keyword.', $token);
                        break;
                    }
                    $state = 2;
                    $miniState = 1;
                } else {
                    $parser->error('Unexpected token.', $token);
                    break;
                }
            } elseif ($state === 2) {
                $lastCount = $miniState;
                if ($miniState === 1 && $token->keyword === 'ON') {
                    ++$miniState;
                } elseif ($miniState === 2 && $token->keyword === 'DUPLICATE') {
                    ++$miniState;
                } elseif ($miniState === 3 && $token->keyword === 'KEY') {
                    ++$miniState;
                } elseif ($miniState === 4 && $token->keyword === 'UPDATE') {
                    ++$miniState;
                }
                if ($lastCount === $miniState) {
                    $parser->error('Unexpected token.', $token);
                    break;
                }
                if ($miniState === 5) {
                    ++$list->idx;
                    $this->onDuplicateSet = SetOperation::parse($parser, $list);
                    $state = 3;
                }
            }
        }
        --$list->idx;
    }
}