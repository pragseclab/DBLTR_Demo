<?php

/**
 * `INTO` keyword parser.
 */
declare (strict_types=1);
namespace PhpMyAdmin\SqlParser\Components;

use PhpMyAdmin\SqlParser\Component;
use PhpMyAdmin\SqlParser\Parser;
use PhpMyAdmin\SqlParser\Token;
use PhpMyAdmin\SqlParser\TokensList;
use function implode;
use function trim;
/**
 * `INTO` keyword parser.
 */
class IntoKeyword extends Component
{
    /**
     * FIELDS/COLUMNS Options for `SELECT...INTO` statements.
     *
     * @var array
     */
    public static $FIELDS_OPTIONS = array('TERMINATED BY' => array(1, 'expr'), 'OPTIONALLY' => 2, 'ENCLOSED BY' => array(3, 'expr'), 'ESCAPED BY' => array(4, 'expr'));
    /**
     * LINES Options for `SELECT...INTO` statements.
     *
     * @var array
     */
    public static $LINES_OPTIONS = array('STARTING BY' => array(1, 'expr'), 'TERMINATED BY' => array(2, 'expr'));
    /**
     * Type of target (OUTFILE or SYMBOL).
     *
     * @var string
     */
    public $type;
    /**
     * The destination, which can be a table or a file.
     *
     * @var string|Expression
     */
    public $dest;
    /**
     * The name of the columns.
     *
     * @var array
     */
    public $columns;
    /**
     * The values to be selected into (SELECT .. INTO @var1).
     *
     * @var Expression[]
     */
    public $values;
    /**
     * Options for FIELDS/COLUMNS keyword.
     *
     * @see static::$FIELDS_OPTIONS
     *
     * @var OptionsArray
     */
    public $fields_options;
    /**
     * Whether to use `FIELDS` or `COLUMNS` while building.
     *
     * @var bool
     */
    public $fields_keyword;
    /**
     * Options for OPTIONS keyword.
     *
     * @see static::$LINES_OPTIONS
     *
     * @var OptionsArray
     */
    public $lines_options;
    /**
     * @param string            $type           type of destination (may be OUTFILE)
     * @param string|Expression $dest           actual destination
     * @param array             $columns        column list of destination
     * @param array             $values         selected fields
     * @param OptionsArray      $fields_options options for FIELDS/COLUMNS keyword
     * @param bool              $fields_keyword options for OPTIONS keyword
     */
    public function __construct($type = null, $dest = null, $columns = null, $values = null, $fields_options = null, $fields_keyword = null)
    {
        $this->type = $type;
        $this->dest = $dest;
        $this->columns = $columns;
        $this->values = $values;
        $this->fields_options = $fields_options;
        $this->fields_keyword = $fields_keyword;
    }
    /**
     * @param Parser     $parser  the parser that serves as context
     * @param TokensList $list    the list of tokens that are being parsed
     * @param array      $options parameters for parsing
     *
     * @return IntoKeyword
     */
    public static function parse(Parser $parser, TokensList $list, array $options = array())
    {
        $ret = new static();
        /**
         * The state of the parser.
         *
         * Below are the states of the parser.
         *
         *      0 -----------------------[ name ]----------------------> 1
         *      0 ---------------------[ OUTFILE ]---------------------> 2
         *
         *      1 ------------------------[ ( ]------------------------> (END)
         *
         *      2 ---------------------[ filename ]--------------------> 1
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
            if ($token->type === Token::TYPE_KEYWORD && $token->flags & Token::FLAG_KEYWORD_RESERVED) {
                if ($state === 0 && $token->keyword === 'OUTFILE') {
                    $ret->type = 'OUTFILE';
                    $state = 2;
                    continue;
                }
                // No other keyword is expected except for $state = 4, which expects `LINES`
                if ($state !== 4) {
                    break;
                }
            }
            if ($state === 0) {
                if (isset($options['fromInsert']) && $options['fromInsert'] || isset($options['fromReplace']) && $options['fromReplace']) {
                    $ret->dest = Expression::parse($parser, $list, ['parseField' => 'table', 'breakOnAlias' => true]);
                } else {
                    $ret->values = ExpressionArray::parse($parser, $list);
                }
                $state = 1;
            } elseif ($state === 1) {
                if ($token->type === Token::TYPE_OPERATOR && $token->value === '(') {
                    $ret->columns = ArrayObj::parse($parser, $list)->values;
                    ++$list->idx;
                }
                break;
            } elseif ($state === 2) {
                $ret->dest = $token->value;
                $state = 3;
            } elseif ($state === 3) {
                $ret->parseFileOptions($parser, $list, $token->value);
                $state = 4;
            } elseif ($state === 4) {
                if ($token->type === Token::TYPE_KEYWORD && $token->keyword !== 'LINES') {
                    break;
                }
                $ret->parseFileOptions($parser, $list, $token->value);
                $state = 5;
            }
        }
        --$list->idx;
        return $ret;
    }
    /**
     * @param Parser     $parser  The parser
     * @param TokensList $list    A token list
     * @param string     $keyword They keyword
     *
     * @return void
     */
    public function parseFileOptions(Parser $parser, TokensList $list, $keyword = 'FIELDS')
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("parseFileOptions") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/vendor/phpmyadmin/sql-parser/src/Components/IntoKeyword.php at line 185")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called parseFileOptions:185@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/vendor/phpmyadmin/sql-parser/src/Components/IntoKeyword.php');
        die();
    }
    /**
     * @param IntoKeyword $component the component to be built
     * @param array       $options   parameters for building
     *
     * @return string
     */
    public static function build($component, array $options = array())
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("build") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/vendor/phpmyadmin/sql-parser/src/Components/IntoKeyword.php at line 203")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called build:203@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/vendor/phpmyadmin/sql-parser/src/Components/IntoKeyword.php');
        die();
    }
}