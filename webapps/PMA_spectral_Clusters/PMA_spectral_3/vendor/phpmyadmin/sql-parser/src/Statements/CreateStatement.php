<?php

/**
 * `CREATE` statement.
 */
declare (strict_types=1);
namespace PhpMyAdmin\SqlParser\Statements;

use PhpMyAdmin\SqlParser\Components\ArrayObj;
use PhpMyAdmin\SqlParser\Components\CreateDefinition;
use PhpMyAdmin\SqlParser\Components\DataType;
use PhpMyAdmin\SqlParser\Components\Expression;
use PhpMyAdmin\SqlParser\Components\OptionsArray;
use PhpMyAdmin\SqlParser\Components\ParameterDefinition;
use PhpMyAdmin\SqlParser\Components\PartitionDefinition;
use PhpMyAdmin\SqlParser\Parser;
use PhpMyAdmin\SqlParser\Statement;
use PhpMyAdmin\SqlParser\Token;
use PhpMyAdmin\SqlParser\TokensList;
use function is_array;
use function trim;
/**
 * `CREATE` statement.
 */
class CreateStatement extends Statement
{
    /**
     * Options for `CREATE` statements.
     *
     * @var array
     */
    public static $OPTIONS = array(
        // CREATE TABLE
        'TEMPORARY' => 1,
        // CREATE VIEW
        'OR REPLACE' => 2,
        'ALGORITHM' => array(3, 'var='),
        // `DEFINER` is also used for `CREATE FUNCTION / PROCEDURE`
        'DEFINER' => array(4, 'expr='),
        'SQL SECURITY' => array(5, 'var'),
        'DATABASE' => 6,
        'EVENT' => 6,
        'FUNCTION' => 6,
        'INDEX' => 6,
        'UNIQUE INDEX' => 6,
        'FULLTEXT INDEX' => 6,
        'SPATIAL INDEX' => 6,
        'PROCEDURE' => 6,
        'SERVER' => 6,
        'TABLE' => 6,
        'TABLESPACE' => 6,
        'TRIGGER' => 6,
        'USER' => 6,
        'VIEW' => 6,
        'SCHEMA' => 6,
        // CREATE TABLE
        'IF NOT EXISTS' => 7,
    );
    /**
     * All database options.
     *
     * @var array
     */
    public static $DB_OPTIONS = array('CHARACTER SET' => array(1, 'var='), 'CHARSET' => array(1, 'var='), 'DEFAULT CHARACTER SET' => array(1, 'var='), 'DEFAULT CHARSET' => array(1, 'var='), 'DEFAULT COLLATE' => array(2, 'var='), 'COLLATE' => array(2, 'var='));
    /**
     * All table options.
     *
     * @var array
     */
    public static $TABLE_OPTIONS = array('ENGINE' => array(1, 'var='), 'AUTO_INCREMENT' => array(2, 'var='), 'AVG_ROW_LENGTH' => array(3, 'var'), 'CHARACTER SET' => array(4, 'var='), 'CHARSET' => array(4, 'var='), 'DEFAULT CHARACTER SET' => array(4, 'var='), 'DEFAULT CHARSET' => array(4, 'var='), 'CHECKSUM' => array(5, 'var'), 'DEFAULT COLLATE' => array(6, 'var='), 'COLLATE' => array(6, 'var='), 'COMMENT' => array(7, 'var='), 'CONNECTION' => array(8, 'var'), 'DATA DIRECTORY' => array(9, 'var'), 'DELAY_KEY_WRITE' => array(10, 'var'), 'INDEX DIRECTORY' => array(11, 'var'), 'INSERT_METHOD' => array(12, 'var'), 'KEY_BLOCK_SIZE' => array(13, 'var'), 'MAX_ROWS' => array(14, 'var'), 'MIN_ROWS' => array(15, 'var'), 'PACK_KEYS' => array(16, 'var'), 'PASSWORD' => array(17, 'var'), 'ROW_FORMAT' => array(18, 'var'), 'TABLESPACE' => array(19, 'var'), 'STORAGE' => array(20, 'var'), 'UNION' => array(21, 'var'));
    /**
     * All function options.
     *
     * @var array
     */
    public static $FUNC_OPTIONS = array('COMMENT' => array(1, 'var='), 'LANGUAGE SQL' => 2, 'DETERMINISTIC' => 3, 'NOT DETERMINISTIC' => 3, 'CONTAINS SQL' => 4, 'NO SQL' => 4, 'READS SQL DATA' => 4, 'MODIFIES SQL DATA' => 4, 'SQL SECURITY DEFINER' => array(5, 'var'));
    /**
     * All trigger options.
     *
     * @var array
     */
    public static $TRIGGER_OPTIONS = array('BEFORE' => 1, 'AFTER' => 1, 'INSERT' => 2, 'UPDATE' => 2, 'DELETE' => 2);
    /**
     * The name of the entity that is created.
     *
     * Used by all `CREATE` statements.
     *
     * @var Expression
     */
    public $name;
    /**
     * The options of the entity (table, procedure, function, etc.).
     *
     * Used by `CREATE TABLE`, `CREATE FUNCTION` and `CREATE PROCEDURE`.
     *
     * @see static::$TABLE_OPTIONS
     * @see static::$FUNC_OPTIONS
     * @see static::$TRIGGER_OPTIONS
     *
     * @var OptionsArray
     */
    public $entityOptions;
    /**
     * If `CREATE TABLE`, a list of columns and keys.
     * If `CREATE VIEW`, a list of columns.
     *
     * Used by `CREATE TABLE` and `CREATE VIEW`.
     *
     * @var CreateDefinition[]|ArrayObj
     */
    public $fields;
    /**
     * If `CREATE TABLE ... SELECT`.
     * If `CREATE VIEW AS ` ... SELECT`.
     *
     * Used by `CREATE TABLE`, `CREATE VIEW`
     *
     * @var SelectStatement|null
     */
    public $select;
    /**
     * If `CREATE TABLE ... LIKE`.
     *
     * Used by `CREATE TABLE`
     *
     * @var Expression
     */
    public $like;
    /**
     * Expression used for partitioning.
     *
     * @var string
     */
    public $partitionBy;
    /**
     * The number of partitions.
     *
     * @var int
     */
    public $partitionsNum;
    /**
     * Expression used for subpartitioning.
     *
     * @var string
     */
    public $subpartitionBy;
    /**
     * The number of subpartitions.
     *
     * @var int
     */
    public $subpartitionsNum;
    /**
     * The partition of the new table.
     *
     * @var PartitionDefinition[]
     */
    public $partitions;
    /**
     * If `CREATE TRIGGER` the name of the table.
     *
     * Used by `CREATE TRIGGER`.
     *
     * @var Expression
     */
    public $table;
    /**
     * The return data type of this routine.
     *
     * Used by `CREATE FUNCTION`.
     *
     * @var DataType
     */
    public $return;
    /**
     * The parameters of this routine.
     *
     * Used by `CREATE FUNCTION` and `CREATE PROCEDURE`.
     *
     * @var ParameterDefinition[]
     */
    public $parameters;
    /**
     * The body of this function or procedure.
     * For views, it is the select statement that creates the view.
     * Used by `CREATE FUNCTION`, `CREATE PROCEDURE` and `CREATE VIEW`.
     *
     * @var Token[]|string
     */
    public $body = array();
    /**
     * @return string
     */
    public function build()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("build") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/phpmyadmin/sql-parser/src/Statements/CreateStatement.php at line 196")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called build:196@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/phpmyadmin/sql-parser/src/Statements/CreateStatement.php');
        die();
    }
    /**
     * @param Parser     $parser the instance that requests parsing
     * @param TokensList $list   the list of tokens to be parsed
     */
    public function parse(Parser $parser, TokensList $list)
    {
        ++$list->idx;
        // Skipping `CREATE`.
        // Parsing options.
        $this->options = OptionsArray::parse($parser, $list, static::$OPTIONS);
        ++$list->idx;
        // Skipping last option.
        $isDatabase = $this->options->has('DATABASE') || $this->options->has('SCHEMA');
        $fieldName = $isDatabase ? 'database' : 'table';
        // Parsing the field name.
        $this->name = Expression::parse($parser, $list, ['parseField' => $fieldName, 'breakOnAlias' => true]);
        if (!isset($this->name) || $this->name === '') {
            $parser->error('The name of the entity was expected.', $list->tokens[$list->idx]);
        } else {
            ++$list->idx;
            // Skipping field.
        }
        /**
         * Token parsed at this moment.
         *
         * @var Token
         */
        $token = $list->tokens[$list->idx];
        $nextidx = $list->idx + 1;
        while ($nextidx < $list->count && $list->tokens[$nextidx]->type === Token::TYPE_WHITESPACE) {
            ++$nextidx;
        }
        if ($isDatabase) {
            $this->entityOptions = OptionsArray::parse($parser, $list, static::$DB_OPTIONS);
        } elseif ($this->options->has('TABLE')) {
            if ($token->type === Token::TYPE_KEYWORD && $token->keyword === 'SELECT') {
                /* CREATE TABLE ... SELECT */
                $this->select = new SelectStatement($parser, $list);
            } elseif ($token->type === Token::TYPE_KEYWORD && $token->keyword === 'AS' && $list->tokens[$nextidx]->type === Token::TYPE_KEYWORD && $list->tokens[$nextidx]->value === 'SELECT') {
                /* CREATE TABLE ... AS SELECT */
                $list->idx = $nextidx;
                $this->select = new SelectStatement($parser, $list);
            } elseif ($token->type === Token::TYPE_KEYWORD && $token->keyword === 'LIKE') {
                /* CREATE TABLE `new_tbl` LIKE 'orig_tbl' */
                $list->idx = $nextidx;
                $this->like = Expression::parse($parser, $list, ['parseField' => 'table', 'breakOnAlias' => true]);
                // The 'LIKE' keyword was found, but no table_name was found next to it
                if ($this->like === null) {
                    $parser->error('A table name was expected.', $list->tokens[$list->idx]);
                }
            } else {
                $this->fields = CreateDefinition::parse($parser, $list);
                if (empty($this->fields)) {
                    $parser->error('At least one column definition was expected.', $list->tokens[$list->idx]);
                }
                ++$list->idx;
                $this->entityOptions = OptionsArray::parse($parser, $list, static::$TABLE_OPTIONS);
                /**
                 * The field that is being filled (`partitionBy` or
                 * `subpartitionBy`).
                 *
                 * @var string
                 */
                $field = null;
                /**
                 * The number of brackets. `false` means no bracket was found
                 * previously. At least one bracket is required to validate the
                 * expression.
                 *
                 * @var int|bool
                 */
                $brackets = false;
                /*
                 * Handles partitions.
                 */
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
                    // Skipping comments.
                    if ($token->type === Token::TYPE_COMMENT) {
                        continue;
                    }
                    if ($token->type === Token::TYPE_KEYWORD && $token->keyword === 'PARTITION BY') {
                        $field = 'partitionBy';
                        $brackets = false;
                    } elseif ($token->type === Token::TYPE_KEYWORD && $token->keyword === 'SUBPARTITION BY') {
                        $field = 'subpartitionBy';
                        $brackets = false;
                    } elseif ($token->type === Token::TYPE_KEYWORD && $token->keyword === 'PARTITIONS') {
                        $token = $list->getNextOfType(Token::TYPE_NUMBER);
                        --$list->idx;
                        // `getNextOfType` also advances one position.
                        $this->partitionsNum = $token->value;
                    } elseif ($token->type === Token::TYPE_KEYWORD && $token->keyword === 'SUBPARTITIONS') {
                        $token = $list->getNextOfType(Token::TYPE_NUMBER);
                        --$list->idx;
                        // `getNextOfType` also advances one position.
                        $this->subpartitionsNum = $token->value;
                    } elseif (!empty($field)) {
                        /*
                         * Handling the content of `PARTITION BY` and `SUBPARTITION BY`.
                         */
                        // Counting brackets.
                        if ($token->type === Token::TYPE_OPERATOR) {
                            if ($token->value === '(') {
                                // This is used instead of `++$brackets` because,
                                // initially, `$brackets` is `false` cannot be
                                // incremented.
                                $brackets += 1;
                            } elseif ($token->value === ')') {
                                --$brackets;
                            }
                        }
                        // Building the expression used for partitioning.
                        $this->{$field} .= $token->type === Token::TYPE_WHITESPACE ? ' ' : $token->token;
                        // Last bracket was read, the expression ended.
                        // Comparing with `0` and not `false`, because `false` means
                        // that no bracket was found and at least one must is
                        // required.
                        if ($brackets === 0) {
                            $this->{$field} = trim($this->{$field});
                            $field = null;
                        }
                    } elseif ($token->type === Token::TYPE_OPERATOR && $token->value === '(') {
                        if (!empty($this->partitionBy)) {
                            $this->partitions = ArrayObj::parse($parser, $list, ['type' => 'PhpMyAdmin\\SqlParser\\Components\\PartitionDefinition']);
                        }
                        break;
                    }
                }
            }
        } elseif ($this->options->has('PROCEDURE') || $this->options->has('FUNCTION')) {
            $this->parameters = ParameterDefinition::parse($parser, $list);
            if ($this->options->has('FUNCTION')) {
                $prev_token = $token;
                $token = $list->getNextOfType(Token::TYPE_KEYWORD);
                if ($token === null || $token->keyword !== 'RETURNS') {
                    $parser->error('A "RETURNS" keyword was expected.', $token ?? $prev_token);
                } else {
                    ++$list->idx;
                    $this->return = DataType::parse($parser, $list);
                }
            }
            ++$list->idx;
            $this->entityOptions = OptionsArray::parse($parser, $list, static::$FUNC_OPTIONS);
            ++$list->idx;
            for (; $list->idx < $list->count; ++$list->idx) {
                $token = $list->tokens[$list->idx];
                $this->body[] = $token;
            }
        } elseif ($this->options->has('VIEW')) {
            /** @var Token $token */
            $token = $list->getNext();
            // Skipping whitespaces and comments.
            // Parsing columns list.
            if ($token->type === Token::TYPE_OPERATOR && $token->value === '(') {
                --$list->idx;
                // getNext() also goes forward one field.
                $this->fields = ArrayObj::parse($parser, $list);
                ++$list->idx;
                // Skipping last token from the array.
                $list->getNext();
            }
            // Parsing the SELECT expression with and without the `AS` keyword
            if ($token->type === Token::TYPE_KEYWORD && $token->keyword === 'SELECT') {
                $this->select = new SelectStatement($parser, $list);
            } elseif ($token->type === Token::TYPE_KEYWORD && $token->keyword === 'AS' && $list->tokens[$nextidx]->type === Token::TYPE_KEYWORD && $list->tokens[$nextidx]->value === 'SELECT') {
                $list->idx = $nextidx;
                $this->select = new SelectStatement($parser, $list);
            } else {
                for (; $list->idx < $list->count; ++$list->idx) {
                    $token = $list->tokens[$list->idx];
                    if ($token->type === Token::TYPE_DELIMITER) {
                        break;
                    }
                    $this->body[] = $token;
                }
            }
        } elseif ($this->options->has('TRIGGER')) {
            // Parsing the time and the event.
            $this->entityOptions = OptionsArray::parse($parser, $list, static::$TRIGGER_OPTIONS);
            ++$list->idx;
            $list->getNextOfTypeAndValue(Token::TYPE_KEYWORD, 'ON');
            ++$list->idx;
            // Skipping `ON`.
            // Parsing the name of the table.
            $this->table = Expression::parse($parser, $list, ['parseField' => 'table', 'breakOnAlias' => true]);
            ++$list->idx;
            $list->getNextOfTypeAndValue(Token::TYPE_KEYWORD, 'FOR EACH ROW');
            ++$list->idx;
            // Skipping `FOR EACH ROW`.
            for (; $list->idx < $list->count; ++$list->idx) {
                $token = $list->tokens[$list->idx];
                $this->body[] = $token;
            }
        } else {
            for (; $list->idx < $list->count; ++$list->idx) {
                $token = $list->tokens[$list->idx];
                if ($token->type === Token::TYPE_DELIMITER) {
                    break;
                }
                $this->body[] = $token;
            }
        }
    }
}