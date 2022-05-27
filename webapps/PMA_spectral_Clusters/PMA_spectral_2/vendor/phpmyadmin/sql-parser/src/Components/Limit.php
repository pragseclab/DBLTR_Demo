<?php

/**
 * `LIMIT` keyword parser.
 */
declare (strict_types=1);
namespace PhpMyAdmin\SqlParser\Components;

use PhpMyAdmin\SqlParser\Component;
use PhpMyAdmin\SqlParser\Parser;
use PhpMyAdmin\SqlParser\Token;
use PhpMyAdmin\SqlParser\TokensList;
/**
 * `LIMIT` keyword parser.
 */
class Limit extends Component
{
    /**
     * The number of rows skipped.
     *
     * @var int
     */
    public $offset;
    /**
     * The number of rows to be returned.
     *
     * @var int
     */
    public $rowCount;
    /**
     * @param int $rowCount the row count
     * @param int $offset   the offset
     */
    public function __construct($rowCount = 0, $offset = 0)
    {
        $this->rowCount = $rowCount;
        $this->offset = $offset;
    }
    /**
     * @param Parser     $parser  the parser that serves as context
     * @param TokensList $list    the list of tokens that are being parsed
     * @param array      $options parameters for parsing
     *
     * @return Limit
     */
    public static function parse(Parser $parser, TokensList $list, array $options = array())
    {
        $ret = new static();
        $offset = false;
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
                break;
            }
            if ($token->type === Token::TYPE_KEYWORD && $token->keyword === 'OFFSET') {
                if ($offset) {
                    $parser->error('An offset was expected.', $token);
                }
                $offset = true;
                continue;
            }
            if ($token->type === Token::TYPE_OPERATOR && $token->value === ',') {
                $ret->offset = $ret->rowCount;
                $ret->rowCount = 0;
                continue;
            }
            // Skip if not a number
            if ($token->type !== Token::TYPE_NUMBER) {
                break;
            }
            if ($offset) {
                $ret->offset = $token->value;
                $offset = false;
            } else {
                $ret->rowCount = $token->value;
            }
        }
        if ($offset) {
            $parser->error('An offset was expected.', $list->tokens[$list->idx - 1]);
        }
        --$list->idx;
        return $ret;
    }
    /**
     * @param Limit $component the component to be built
     * @param array $options   parameters for building
     *
     * @return string
     */
    public static function build($component, array $options = array())
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("build") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/vendor/phpmyadmin/sql-parser/src/Components/Limit.php at line 105")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called build:105@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/vendor/phpmyadmin/sql-parser/src/Components/Limit.php');
        die();
    }
}