<?php

/**
 * Parses an array.
 */
declare (strict_types=1);
namespace PhpMyAdmin\SqlParser\Components;

use PhpMyAdmin\SqlParser\Component;
use PhpMyAdmin\SqlParser\Parser;
use PhpMyAdmin\SqlParser\Token;
use PhpMyAdmin\SqlParser\TokensList;
use function implode;
use function is_array;
use function strlen;
use function trim;
/**
 * Parses an array.
 */
class ArrayObj extends Component
{
    /**
     * The array that contains the unprocessed value of each token.
     *
     * @var array
     */
    public $raw = array();
    /**
     * The array that contains the processed value of each token.
     *
     * @var array
     */
    public $values = array();
    /**
     * @param array $raw    the unprocessed values
     * @param array $values the processed values
     */
    public function __construct(array $raw = array(), array $values = array())
    {
        $this->raw = $raw;
        $this->values = $values;
    }
    /**
     * @param Parser     $parser  the parser that serves as context
     * @param TokensList $list    the list of tokens that are being parsed
     * @param array      $options parameters for parsing
     *
     * @return ArrayObj|Component[]
     */
    public static function parse(Parser $parser, TokensList $list, array $options = array())
    {
        $ret = empty($options['type']) ? new static() : [];
        /**
         * The last raw expression.
         *
         * @var string
         */
        $lastRaw = '';
        /**
         * The last value.
         *
         * @var string
         */
        $lastValue = '';
        /**
         * Counts brackets.
         *
         * @var int
         */
        $brackets = 0;
        /**
         * Last separator (bracket or comma).
         *
         * @var bool
         */
        $isCommaLast = false;
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
                $lastRaw .= $token->token;
                $lastValue = trim($lastValue) . ' ';
                continue;
            }
            if ($brackets === 0 && ($token->type !== Token::TYPE_OPERATOR || $token->value !== '(')) {
                $parser->error('An opening bracket was expected.', $token);
                break;
            }
            if ($token->type === Token::TYPE_OPERATOR) {
                if ($token->value === '(') {
                    if (++$brackets === 1) {
                        // 1 is the base level.
                        continue;
                    }
                } elseif ($token->value === ')') {
                    if (--$brackets === 0) {
                        // Array ended.
                        break;
                    }
                } elseif ($token->value === ',') {
                    if ($brackets === 1) {
                        $isCommaLast = true;
                        if (empty($options['type'])) {
                            $ret->raw[] = trim($lastRaw);
                            $ret->values[] = trim($lastValue);
                            $lastRaw = $lastValue = '';
                        }
                    }
                    continue;
                }
            }
            if (empty($options['type'])) {
                $lastRaw .= $token->token;
                $lastValue .= $token->value;
            } else {
                $ret[] = $options['type']::parse($parser, $list, empty($options['typeOptions']) ? [] : $options['typeOptions']);
            }
        }
        // Handling last element.
        //
        // This is treated differently to treat the following cases:
        //
        //           => []
        //      [,]  => ['', '']
        //      []   => []
        //      [a,] => ['a', '']
        //      [a]  => ['a']
        $lastRaw = trim($lastRaw);
        if (empty($options['type']) && (strlen($lastRaw) > 0 || $isCommaLast)) {
            $ret->raw[] = $lastRaw;
            $ret->values[] = trim($lastValue);
        }
        return $ret;
    }
    /**
     * @param ArrayObj|ArrayObj[] $component the component to be built
     * @param array               $options   parameters for building
     *
     * @return string
     */
    public static function build($component, array $options = array())
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("build") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/phpmyadmin/sql-parser/src/Components/ArrayObj.php at line 152")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called build:152@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/phpmyadmin/sql-parser/src/Components/ArrayObj.php');
        die();
    }
}