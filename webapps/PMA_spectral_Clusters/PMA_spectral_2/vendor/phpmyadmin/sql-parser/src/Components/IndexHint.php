<?php

/**
 * Parses an Index hint.
 */
declare (strict_types=1);
namespace PhpMyAdmin\SqlParser\Components;

use PhpMyAdmin\SqlParser\Component;
use PhpMyAdmin\SqlParser\Parser;
use PhpMyAdmin\SqlParser\Token;
use PhpMyAdmin\SqlParser\TokensList;
use function implode;
use function is_array;
/**
 * Parses an Index hint.
 */
class IndexHint extends Component
{
    /**
     * The type of hint (USE/FORCE/IGNORE)
     *
     * @var string
     */
    public $type;
    /**
     * What the hint is for (INDEX/KEY)
     *
     * @var string
     */
    public $indexOrKey;
    /**
     * The clause for which this hint is (JOIN/ORDER BY/GROUP BY)
     *
     * @var string
     */
    public $for;
    /**
     * List of indexes in this hint
     *
     * @var array
     */
    public $indexes = [];
    /**
     * @param string $type       the type of hint (USE/FORCE/IGNORE)
     * @param string $indexOrKey What the hint is for (INDEX/KEY)
     * @param string $for        the clause for which this hint is (JOIN/ORDER BY/GROUP BY)
     * @param array  $indexes    List of indexes in this hint
     */
    public function __construct(?string $type = null, ?string $indexOrKey = null, ?string $for = null, array $indexes = [])
    {
        $this->type = $type;
        $this->indexOrKey = $indexOrKey;
        $this->for = $for;
        $this->indexes = $indexes;
    }
    /**
     * @param Parser     $parser  the parser that serves as context
     * @param TokensList $list    the list of tokens that are being parsed
     * @param array      $options parameters for parsing
     *
     * @return IndexHint|Component[]
     */
    public static function parse(Parser $parser, TokensList $list, array $options = [])
    {
        $ret = [];
        $expr = new static();
        $expr->type = $options['type'] ?? null;
        /**
         * The state of the parser.
         *
         * Below are the states of the parser.
         *      0 ----------------- [ USE/IGNORE/FORCE ]-----------------> 1
         *      1 -------------------- [ INDEX/KEY ] --------------------> 2
         *      2 ----------------------- [ FOR ] -----------------------> 3
         *      2 -------------------- [ expr_list ] --------------------> 0
         *      3 -------------- [ JOIN/GROUP BY/ORDER BY ] -------------> 4
         *      4 -------------------- [ expr_list ] --------------------> 0
         *
         * @var int
         */
        $state = 0;
        // By design, the parser will parse first token after the keyword. So, the keyword
        // must be analyzed too, in order to determine the type of this index hint.
        if ($list->idx > 0) {
            --$list->idx;
        }
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
            switch ($state) {
                case 0:
                    if ($token->type === Token::TYPE_KEYWORD) {
                        if ($token->keyword === 'USE' || $token->keyword === 'IGNORE' || $token->keyword === 'FORCE') {
                            $expr->type = $token->keyword;
                            $state = 1;
                        } else {
                            break 2;
                        }
                    }
                    break;
                case 1:
                    if ($token->type === Token::TYPE_KEYWORD) {
                        if ($token->keyword === 'INDEX' || $token->keyword === 'KEY') {
                            $expr->indexOrKey = $token->keyword;
                        } else {
                            $parser->error('Unexpected keyword.', $token);
                        }
                        $state = 2;
                    } else {
                        // we expect the token to be a keyword
                        $parser->error('Unexpected token.', $token);
                    }
                    break;
                case 2:
                    if ($token->type === Token::TYPE_KEYWORD && $token->keyword === 'FOR') {
                        $state = 3;
                    } else {
                        $expr->indexes = ExpressionArray::parse($parser, $list);
                        $state = 0;
                        $ret[] = $expr;
                        $expr = new static();
                    }
                    break;
                case 3:
                    if ($token->type === Token::TYPE_KEYWORD) {
                        if ($token->keyword === 'JOIN' || $token->keyword === 'GROUP BY' || $token->keyword === 'ORDER BY') {
                            $expr->for = $token->keyword;
                        } else {
                            $parser->error('Unexpected keyword.', $token);
                        }
                        $state = 4;
                    } else {
                        // we expect the token to be a keyword
                        $parser->error('Unexpected token.', $token);
                    }
                    break;
                case 4:
                    $expr->indexes = ExpressionArray::parse($parser, $list);
                    $state = 0;
                    $ret[] = $expr;
                    $expr = new static();
                    break;
            }
        }
        --$list->idx;
        return $ret;
    }
    /**
     * @param IndexHint|IndexHint[] $component the component to be built
     * @param array                 $options   parameters for building
     *
     * @return string
     */
    public static function build($component, array $options = [])
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("build") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/vendor/phpmyadmin/sql-parser/src/Components/IndexHint.php at line 169")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called build:169@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/vendor/phpmyadmin/sql-parser/src/Components/IndexHint.php');
        die();
    }
}