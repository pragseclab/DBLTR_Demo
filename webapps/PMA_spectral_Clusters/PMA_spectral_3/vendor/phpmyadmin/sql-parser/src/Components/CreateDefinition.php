<?php

/**
 * Parses the create definition of a column or a key.
 *
 * Used for parsing `CREATE TABLE` statement.
 */
declare (strict_types=1);
namespace PhpMyAdmin\SqlParser\Components;

use PhpMyAdmin\SqlParser\Component;
use PhpMyAdmin\SqlParser\Context;
use PhpMyAdmin\SqlParser\Parser;
use PhpMyAdmin\SqlParser\Token;
use PhpMyAdmin\SqlParser\TokensList;
use function implode;
use function is_array;
use function trim;
/**
 * Parses the create definition of a column or a key.
 *
 * Used for parsing `CREATE TABLE` statement.
 */
class CreateDefinition extends Component
{
    /**
     * All field options.
     *
     * @var array
     */
    public static $FIELD_OPTIONS = array(
        // Tells the `OptionsArray` to not sort the options.
        // See the note below.
        '_UNSORTED' => true,
        'NOT NULL' => 1,
        'NULL' => 1,
        'DEFAULT' => array(2, 'expr', array('breakOnAlias' => true)),
        /* Following are not according to grammar, but MySQL happily accepts
         * these at any location */
        'CHARSET' => array(2, 'var'),
        'COLLATE' => array(3, 'var'),
        'AUTO_INCREMENT' => 3,
        'PRIMARY' => 4,
        'PRIMARY KEY' => 4,
        'UNIQUE' => 4,
        'UNIQUE KEY' => 4,
        'COMMENT' => array(5, 'var'),
        'COLUMN_FORMAT' => array(6, 'var'),
        'ON UPDATE' => array(7, 'expr'),
        // Generated columns options.
        'GENERATED ALWAYS' => 8,
        'AS' => array(9, 'expr', array('parenthesesDelimited' => true)),
        'VIRTUAL' => 10,
        'PERSISTENT' => 11,
        'STORED' => 11,
        'CHECK' => array(12, 'expr', array('parenthesesDelimited' => true)),
        'INVISIBLE' => 13,
    );
    /**
     * The name of the new column.
     *
     * @var string
     */
    public $name;
    /**
     * Whether this field is a constraint or not.
     *
     * @var bool
     */
    public $isConstraint;
    /**
     * The data type of thew new column.
     *
     * @var DataType
     */
    public $type;
    /**
     * The key.
     *
     * @var Key
     */
    public $key;
    /**
     * The table that is referenced.
     *
     * @var Reference
     */
    public $references;
    /**
     * The options of this field.
     *
     * @var OptionsArray
     */
    public $options;
    /**
     * @param string       $name         the name of the field
     * @param OptionsArray $options      the options of this field
     * @param DataType|Key $type         the data type of this field or the key
     * @param bool         $isConstraint whether this field is a constraint or not
     * @param Reference    $references   references
     */
    public function __construct($name = null, $options = null, $type = null, $isConstraint = false, $references = null)
    {
        $this->name = $name;
        $this->options = $options;
        if ($type instanceof DataType) {
            $this->type = $type;
        } elseif ($type instanceof Key) {
            $this->key = $type;
            $this->isConstraint = $isConstraint;
            $this->references = $references;
        }
    }
    /**
     * @param Parser     $parser  the parser that serves as context
     * @param TokensList $list    the list of tokens that are being parsed
     * @param array      $options parameters for parsing
     *
     * @return CreateDefinition[]
     */
    public static function parse(Parser $parser, TokensList $list, array $options = array())
    {
        $ret = [];
        $expr = new static();
        /**
         * The state of the parser.
         *
         * Below are the states of the parser.
         *
         *      0 -----------------------[ ( ]------------------------> 1
         *
         *      1 --------------------[ CONSTRAINT ]------------------> 1
         *      1 -----------------------[ key ]----------------------> 2
         *      1 -------------[ constraint / column name ]-----------> 2
         *
         *      2 --------------------[ data type ]-------------------> 3
         *
         *      3 ---------------------[ options ]--------------------> 4
         *
         *      4 --------------------[ REFERENCES ]------------------> 4
         *
         *      5 ------------------------[ , ]-----------------------> 1
         *      5 ------------------------[ ) ]-----------------------> 6 (-1)
         *
         * @var int
         */
        $state = 0;
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
                if ($token->type === Token::TYPE_OPERATOR && $token->value === '(') {
                    $state = 1;
                } else {
                    $parser->error('An opening bracket was expected.', $token);
                    break;
                }
            } elseif ($state === 1) {
                if ($token->type === Token::TYPE_KEYWORD && $token->keyword === 'CONSTRAINT') {
                    $expr->isConstraint = true;
                } elseif ($token->type === Token::TYPE_KEYWORD && $token->flags & Token::FLAG_KEYWORD_KEY) {
                    $expr->key = Key::parse($parser, $list);
                    $state = 4;
                } elseif ($token->type === Token::TYPE_SYMBOL || $token->type === Token::TYPE_NONE) {
                    $expr->name = $token->value;
                    if (!$expr->isConstraint) {
                        $state = 2;
                    }
                } elseif ($token->type === Token::TYPE_KEYWORD) {
                    if ($token->flags & Token::FLAG_KEYWORD_RESERVED) {
                        // Reserved keywords can't be used
                        // as field names without backquotes
                        $parser->error('A symbol name was expected! ' . 'A reserved keyword can not be used ' . 'as a column name without backquotes.', $token);
                        return $ret;
                    }
                    // Non-reserved keywords are allowed without backquotes
                    $expr->name = $token->value;
                    $state = 2;
                } else {
                    $parser->error('A symbol name was expected!', $token);
                    return $ret;
                }
            } elseif ($state === 2) {
                $expr->type = DataType::parse($parser, $list);
                $state = 3;
            } elseif ($state === 3) {
                $expr->options = OptionsArray::parse($parser, $list, static::$FIELD_OPTIONS);
                $state = 4;
            } elseif ($state === 4) {
                if ($token->type === Token::TYPE_KEYWORD && $token->keyword === 'REFERENCES') {
                    ++$list->idx;
                    // Skipping keyword 'REFERENCES'.
                    $expr->references = Reference::parse($parser, $list);
                } else {
                    --$list->idx;
                }
                $state = 5;
            } elseif ($state === 5) {
                if (!empty($expr->type) || !empty($expr->key)) {
                    $ret[] = $expr;
                }
                $expr = new static();
                if ($token->value === ',') {
                    $state = 1;
                } elseif ($token->value === ')') {
                    $state = 6;
                    ++$list->idx;
                    break;
                } else {
                    $parser->error('A comma or a closing bracket was expected.', $token);
                    $state = 0;
                    break;
                }
            }
        }
        // Last iteration was not saved.
        if (!empty($expr->type) || !empty($expr->key)) {
            $ret[] = $expr;
        }
        if ($state !== 0 && $state !== 6) {
            $parser->error('A closing bracket was expected.', $list->tokens[$list->idx - 1]);
        }
        --$list->idx;
        return $ret;
    }
    /**
     * @param CreateDefinition|CreateDefinition[] $component the component to be built
     * @param array                               $options   parameters for building
     *
     * @return string
     */
    public static function build($component, array $options = array())
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("build") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/phpmyadmin/sql-parser/src/Components/CreateDefinition.php at line 246")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called build:246@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/phpmyadmin/sql-parser/src/Components/CreateDefinition.php');
        die();
    }
}