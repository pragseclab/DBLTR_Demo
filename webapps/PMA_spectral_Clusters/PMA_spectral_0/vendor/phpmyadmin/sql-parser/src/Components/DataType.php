<?php

/**
 * Parses a data type.
 */
namespace PhpMyAdmin\SqlParser\Components;

use PhpMyAdmin\SqlParser\Component;
use PhpMyAdmin\SqlParser\Parser;
use PhpMyAdmin\SqlParser\Token;
use PhpMyAdmin\SqlParser\TokensList;
/**
 * Parses a data type.
 *
 * @category   Components
 *
 * @license    https://www.gnu.org/licenses/gpl-2.0.txt GPL-2.0+
 */
class DataType extends Component
{
    /**
     * All data type options.
     *
     * @var array
     */
    public static $DATA_TYPE_OPTIONS = array('BINARY' => 1, 'CHARACTER SET' => array(2, 'var'), 'CHARSET' => array(2, 'var'), 'COLLATE' => array(3, 'var'), 'UNSIGNED' => 4, 'ZEROFILL' => 5);
    /**
     * The name of the data type.
     *
     * @var string
     */
    public $name;
    /**
     * The parameters of this data type.
     *
     * Some data types have no parameters.
     * Numeric types might have parameters for the maximum number of digits,
     * precision, etc.
     * String types might have parameters for the maximum length stored.
     * `ENUM` and `SET` have parameters for possible values.
     *
     * For more information, check the MySQL manual.
     *
     * @var array
     */
    public $parameters = array();
    /**
     * The options of this data type.
     *
     * @var OptionsArray
     */
    public $options;
    /**
     * Constructor.
     *
     * @param string       $name       the name of this data type
     * @param array        $parameters the parameters (size or possible values)
     * @param OptionsArray $options    the options of this data type
     */
    public function __construct($name = null, array $parameters = array(), $options = null)
    {
        $this->name = $name;
        $this->parameters = $parameters;
        $this->options = $options;
    }
    /**
     * @param Parser     $parser  the parser that serves as context
     * @param TokensList $list    the list of tokens that are being parsed
     * @param array      $options parameters for parsing
     *
     * @return DataType
     */
    public static function parse(Parser $parser, TokensList $list, array $options = array())
    {
        $ret = new self();
        /**
         * The state of the parser.
         *
         * Below are the states of the parser.
         *
         *      0 -------------------[ data type ]--------------------> 1
         *
         *      1 ----------------[ size and options ]----------------> 2
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
            // Skipping whitespaces and comments.
            if ($token->type === Token::TYPE_WHITESPACE || $token->type === Token::TYPE_COMMENT) {
                continue;
            }
            if ($state === 0) {
                $ret->name = strtoupper($token->value);
                if ($token->type !== Token::TYPE_KEYWORD || !($token->flags & Token::FLAG_KEYWORD_DATA_TYPE)) {
                    $parser->error('Unrecognized data type.', $token);
                }
                $state = 1;
            } elseif ($state === 1) {
                if ($token->type === Token::TYPE_OPERATOR && $token->value === '(') {
                    $parameters = ArrayObj::parse($parser, $list);
                    ++$list->idx;
                    $ret->parameters = $ret->name === 'ENUM' || $ret->name === 'SET' ? $parameters->raw : $parameters->values;
                }
                $ret->options = OptionsArray::parse($parser, $list, static::$DATA_TYPE_OPTIONS);
                ++$list->idx;
                break;
            }
        }
        if (empty($ret->name)) {
            return null;
        }
        --$list->idx;
        return $ret;
    }
    /**
     * @param DataType $component the component to be built
     * @param array    $options   parameters for building
     *
     * @return string
     */
    public static function build($component, array $options = array())
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("build") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/vendor/phpmyadmin/sql-parser/src/Components/DataType.php at line 156")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called build:156@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/vendor/phpmyadmin/sql-parser/src/Components/DataType.php');
        die();
    }
}