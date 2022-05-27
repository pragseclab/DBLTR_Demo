<?php

/**
 * `DELETE` statement.
 */
declare (strict_types=1);
namespace PhpMyAdmin\SqlParser\Statements;

use PhpMyAdmin\SqlParser\Components\ArrayObj;
use PhpMyAdmin\SqlParser\Components\Condition;
use PhpMyAdmin\SqlParser\Components\Expression;
use PhpMyAdmin\SqlParser\Components\ExpressionArray;
use PhpMyAdmin\SqlParser\Components\JoinKeyword;
use PhpMyAdmin\SqlParser\Components\Limit;
use PhpMyAdmin\SqlParser\Components\OptionsArray;
use PhpMyAdmin\SqlParser\Components\OrderKeyword;
use PhpMyAdmin\SqlParser\Parser;
use PhpMyAdmin\SqlParser\Statement;
use PhpMyAdmin\SqlParser\Token;
use PhpMyAdmin\SqlParser\TokensList;
use function count;
use function stripos;
use function strlen;
/**
 * `DELETE` statement.
 *
 * DELETE [LOW_PRIORITY] [QUICK] [IGNORE] FROM tbl_name
 *     [PARTITION (partition_name,...)]
 *     [WHERE where_condition]
 *     [ORDER BY ...]
 *     [LIMIT row_count]
 *
 * Multi-table syntax
 *
 * DELETE [LOW_PRIORITY] [QUICK] [IGNORE]
 *   tbl_name[.*] [, tbl_name[.*]] ...
 *   FROM table_references
 *   [WHERE where_condition]
 *
 * OR
 *
 * DELETE [LOW_PRIORITY] [QUICK] [IGNORE]
 *   FROM tbl_name[.*] [, tbl_name[.*]] ...
 *   USING table_references
 *   [WHERE where_condition]
 */
class DeleteStatement extends Statement
{
    /**
     * Options for `DELETE` statements.
     *
     * @var array
     */
    public static $OPTIONS = array('LOW_PRIORITY' => 1, 'QUICK' => 2, 'IGNORE' => 3);
    /**
     * The clauses of this statement, in order.
     *
     * @see Statement::$CLAUSES
     *
     * @var array
     */
    public static $CLAUSES = array(
        'DELETE' => array('DELETE', 2),
        // Used for options.
        '_OPTIONS' => array('_OPTIONS', 1),
        'FROM' => array('FROM', 3),
        'PARTITION' => array('PARTITION', 3),
        'USING' => array('USING', 3),
        'WHERE' => array('WHERE', 3),
        'ORDER BY' => array('ORDER BY', 3),
        'LIMIT' => array('LIMIT', 3),
    );
    /**
     * Table(s) used as sources for this statement.
     *
     * @var Expression[]
     */
    public $from;
    /**
     * Joins.
     *
     * @var JoinKeyword[]
     */
    public $join;
    /**
     * Tables used as sources for this statement.
     *
     * @var Expression[]
     */
    public $using;
    /**
     * Columns used in this statement.
     *
     * @var Expression[]
     */
    public $columns;
    /**
     * Partitions used as source for this statement.
     *
     * @var ArrayObj
     */
    public $partition;
    /**
     * Conditions used for filtering each row of the result set.
     *
     * @var Condition[]
     */
    public $where;
    /**
     * Specifies the order of the rows in the result set.
     *
     * @var OrderKeyword[]
     */
    public $order;
    /**
     * Conditions used for limiting the size of the result set.
     *
     * @var Limit
     */
    public $limit;
    /**
     * @return string
     */
    public function build()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("build") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/vendor/phpmyadmin/sql-parser/src/Statements/DeleteStatement.php at line 126")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called build:126@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/vendor/phpmyadmin/sql-parser/src/Statements/DeleteStatement.php');
        die();
    }
    /**
     * @param Parser     $parser the instance that requests parsing
     * @param TokensList $list   the list of tokens to be parsed
     */
    public function parse(Parser $parser, TokensList $list)
    {
        ++$list->idx;
        // Skipping `DELETE`.
        // parse any options if provided
        $this->options = OptionsArray::parse($parser, $list, static::$OPTIONS);
        ++$list->idx;
        /**
         * The state of the parser.
         *
         * Below are the states of the parser.
         *
         *      0 ---------------------------------[ FROM ]----------------------------------> 2
         *      0 ------------------------------[ table[.*] ]--------------------------------> 1
         *      1 ---------------------------------[ FROM ]----------------------------------> 2
         *      2 --------------------------------[ USING ]----------------------------------> 3
         *      2 --------------------------------[ WHERE ]----------------------------------> 4
         *      2 --------------------------------[ ORDER ]----------------------------------> 5
         *      2 --------------------------------[ LIMIT ]----------------------------------> 6
         *
         * @var int
         */
        $state = 0;
        /**
         * If the query is multi-table or not.
         *
         * @var bool
         */
        $multiTable = false;
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
            if ($state === 0) {
                if ($token->type === Token::TYPE_KEYWORD) {
                    if ($token->keyword !== 'FROM') {
                        $parser->error('Unexpected keyword.', $token);
                        break;
                    } else {
                        ++$list->idx;
                        // Skip 'FROM'
                        $this->from = ExpressionArray::parse($parser, $list);
                        $state = 2;
                    }
                } else {
                    $this->columns = ExpressionArray::parse($parser, $list);
                    $state = 1;
                }
            } elseif ($state === 1) {
                if ($token->type === Token::TYPE_KEYWORD) {
                    if ($token->keyword !== 'FROM') {
                        $parser->error('Unexpected keyword.', $token);
                        break;
                    } else {
                        ++$list->idx;
                        // Skip 'FROM'
                        $this->from = ExpressionArray::parse($parser, $list);
                        $state = 2;
                    }
                } else {
                    $parser->error('Unexpected token.', $token);
                    break;
                }
            } elseif ($state === 2) {
                if ($token->type === Token::TYPE_KEYWORD) {
                    if (stripos($token->keyword, 'JOIN') !== false) {
                        ++$list->idx;
                        $this->join = JoinKeyword::parse($parser, $list);
                        // remain in state = 2
                    } else {
                        switch ($token->keyword) {
                            case 'USING':
                                ++$list->idx;
                                // Skip 'USING'
                                $this->using = ExpressionArray::parse($parser, $list);
                                $state = 3;
                                $multiTable = true;
                                break;
                            case 'WHERE':
                                ++$list->idx;
                                // Skip 'WHERE'
                                $this->where = Condition::parse($parser, $list);
                                $state = 4;
                                break;
                            case 'ORDER BY':
                                ++$list->idx;
                                // Skip 'ORDER BY'
                                $this->order = OrderKeyword::parse($parser, $list);
                                $state = 5;
                                break;
                            case 'LIMIT':
                                ++$list->idx;
                                // Skip 'LIMIT'
                                $this->limit = Limit::parse($parser, $list);
                                $state = 6;
                                break;
                            default:
                                $parser->error('Unexpected keyword.', $token);
                                break 2;
                        }
                    }
                }
            } elseif ($state === 3) {
                if ($token->type === Token::TYPE_KEYWORD) {
                    if ($token->keyword === 'WHERE') {
                        ++$list->idx;
                        // Skip 'WHERE'
                        $this->where = Condition::parse($parser, $list);
                        $state = 4;
                    } else {
                        $parser->error('Unexpected keyword.', $token);
                        break;
                    }
                } else {
                    $parser->error('Unexpected token.', $token);
                    break;
                }
            } elseif ($state === 4) {
                if ($multiTable === true && $token->type === Token::TYPE_KEYWORD) {
                    $parser->error('This type of clause is not valid in Multi-table queries.', $token);
                    break;
                }
                if ($token->type === Token::TYPE_KEYWORD) {
                    switch ($token->keyword) {
                        case 'ORDER BY':
                            ++$list->idx;
                            // Skip 'ORDER  BY'
                            $this->order = OrderKeyword::parse($parser, $list);
                            $state = 5;
                            break;
                        case 'LIMIT':
                            ++$list->idx;
                            // Skip 'LIMIT'
                            $this->limit = Limit::parse($parser, $list);
                            $state = 6;
                            break;
                        default:
                            $parser->error('Unexpected keyword.', $token);
                            break 2;
                    }
                }
            } elseif ($state === 5) {
                if ($token->type === Token::TYPE_KEYWORD) {
                    if ($token->keyword === 'LIMIT') {
                        ++$list->idx;
                        // Skip 'LIMIT'
                        $this->limit = Limit::parse($parser, $list);
                        $state = 6;
                    } else {
                        $parser->error('Unexpected keyword.', $token);
                        break;
                    }
                }
            }
        }
        if ($state >= 2) {
            foreach ($this->from as $from_expr) {
                $from_expr->database = $from_expr->table;
                $from_expr->table = $from_expr->column;
                $from_expr->column = null;
            }
        }
        --$list->idx;
    }
}