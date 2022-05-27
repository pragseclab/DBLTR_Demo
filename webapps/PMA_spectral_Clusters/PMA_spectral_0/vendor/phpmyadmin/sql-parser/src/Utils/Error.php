<?php

/**
 * Error related utilities.
 */
declare (strict_types=1);
namespace PhpMyAdmin\SqlParser\Utils;

use PhpMyAdmin\SqlParser\Exceptions\LexerException;
use PhpMyAdmin\SqlParser\Exceptions\ParserException;
use PhpMyAdmin\SqlParser\Lexer;
use PhpMyAdmin\SqlParser\Parser;
use function htmlspecialchars;
use function sprintf;
/**
 * Error related utilities.
 */
class Error
{
    /**
     * Gets the errors of a lexer and a parser.
     *
     * @param array $objs objects from where the errors will be extracted
     *
     * @return array Each element of the array represents an error.
     *               `$err[0]` holds the error message.
     *               `$err[1]` holds the error code.
     *               `$err[2]` holds the string that caused the issue.
     *               `$err[3]` holds the position of the string.
     *               (i.e. `[$msg, $code, $str, $pos]`)
     */
    public static function get($objs)
    {
        $ret = [];
        foreach ($objs as $obj) {
            if ($obj instanceof Lexer) {
                /** @var LexerException $err */
                foreach ($obj->errors as $err) {
                    $ret[] = [$err->getMessage(), $err->getCode(), $err->ch, $err->pos];
                }
            } elseif ($obj instanceof Parser) {
                /** @var ParserException $err */
                foreach ($obj->errors as $err) {
                    $ret[] = [$err->getMessage(), $err->getCode(), $err->token->token, $err->token->position];
                }
            }
        }
        return $ret;
    }
    /**
     * Formats the specified errors.
     *
     * @param array  $errors the errors to be formatted
     * @param string $format The format of an error.
     *                       '$1$d' is replaced by the position of this error.
     *                       '$2$s' is replaced by the error message.
     *                       '$3$d' is replaced by the error code.
     *                       '$4$s' is replaced by the string that caused the
     *                       issue.
     *                       '$5$d' is replaced by the position of the string.
     *
     * @return array
     */
    public static function format($errors, $format = '#%1$d: %2$s (near "%4$s" at position %5$d)')
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("format") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/phpmyadmin/sql-parser/src/Utils/Error.php at line 66")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called format:66@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/phpmyadmin/sql-parser/src/Utils/Error.php');
        die();
    }
}