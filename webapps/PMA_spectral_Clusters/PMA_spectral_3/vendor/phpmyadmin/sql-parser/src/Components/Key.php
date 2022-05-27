<?php

/**
 * Parses the definition of a key.
 */
declare (strict_types=1);
namespace PhpMyAdmin\SqlParser\Components;

use PhpMyAdmin\SqlParser\Component;
use PhpMyAdmin\SqlParser\Context;
use PhpMyAdmin\SqlParser\Parser;
use PhpMyAdmin\SqlParser\Token;
use PhpMyAdmin\SqlParser\TokensList;
use function implode;
use function trim;
/**
 * Parses the definition of a key.
 *
 * Used for parsing `CREATE TABLE` statement.
 */
class Key extends Component
{
    /**
     * All key options.
     *
     * @var array
     */
    public static $KEY_OPTIONS = array('KEY_BLOCK_SIZE' => array(1, 'var'), 'USING' => array(2, 'var'), 'WITH PARSER' => array(3, 'var'), 'COMMENT' => array(4, 'var='));
    /**
     * The name of this key.
     *
     * @var string
     */
    public $name;
    /**
     * Columns.
     *
     * @var array
     */
    public $columns;
    /**
     * The type of this key.
     *
     * @var string
     */
    public $type;
    /**
     * The options of this key.
     *
     * @var OptionsArray
     */
    public $options;
    /**
     * @param string       $name    the name of the key
     * @param array        $columns the columns covered by this key
     * @param string       $type    the type of this key
     * @param OptionsArray $options the options of this key
     */
    public function __construct($name = null, array $columns = array(), $type = null, $options = null)
    {
        $this->name = $name;
        $this->columns = $columns;
        $this->type = $type;
        $this->options = $options;
    }
    /**
     * @param Parser     $parser  the parser that serves as context
     * @param TokensList $list    the list of tokens that are being parsed
     * @param array      $options parameters for parsing
     *
     * @return Key
     */
    public static function parse(Parser $parser, TokensList $list, array $options = array())
    {
        $ret = new static();
        /**
         * Last parsed column.
         *
         * @var array
         */
        $lastColumn = [];
        /**
         * The state of the parser.
         *
         * Below are the states of the parser.
         *
         *      0 ----------------------[ type ]-----------------------> 1
         *
         *      1 ----------------------[ name ]-----------------------> 1
         *      1 ---------------------[ columns ]---------------------> 2
         *
         *      2 ---------------------[ options ]---------------------> 3
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
                $ret->type = $token->value;
                $state = 1;
            } elseif ($state === 1) {
                if ($token->type === Token::TYPE_OPERATOR && $token->value === '(') {
                    $state = 2;
                } else {
                    $ret->name = $token->value;
                }
            } elseif ($state === 2) {
                if ($token->type === Token::TYPE_OPERATOR) {
                    if ($token->value === '(') {
                        $state = 3;
                    } elseif ($token->value === ',' || $token->value === ')') {
                        $state = $token->value === ',' ? 2 : 4;
                        if (!empty($lastColumn)) {
                            $ret->columns[] = $lastColumn;
                            $lastColumn = [];
                        }
                    }
                } else {
                    $lastColumn['name'] = $token->value;
                }
            } elseif ($state === 3) {
                if ($token->type === Token::TYPE_OPERATOR && $token->value === ')') {
                    $state = 2;
                } else {
                    $lastColumn['length'] = $token->value;
                }
            } elseif ($state === 4) {
                $ret->options = OptionsArray::parse($parser, $list, static::$KEY_OPTIONS);
                ++$list->idx;
                break;
            }
        }
        --$list->idx;
        return $ret;
    }
    /**
     * @param Key   $component the component to be built
     * @param array $options   parameters for building
     *
     * @return string
     */
    public static function build($component, array $options = array())
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("build") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/phpmyadmin/sql-parser/src/Components/Key.php at line 158")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called build:158@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/phpmyadmin/sql-parser/src/Components/Key.php');
        die();
    }
}