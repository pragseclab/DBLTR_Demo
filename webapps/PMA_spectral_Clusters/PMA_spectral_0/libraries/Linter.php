<?php

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Analyzes a query and gives user feedback.
 *
 * @package PhpMyAdmin
 */
namespace PMA\libraries;

use PhpMyAdmin\SqlParser\Lexer;
use PhpMyAdmin\SqlParser\Parser;
use PhpMyAdmin\SqlParser\UtfString;
use PhpMyAdmin\SqlParser\Utils\Error as ParserError;
/**
 * The linter itself.
 *
 * @package PhpMyAdmin
 */
class Linter
{
    /**
     * Gets the starting position of each line.
     *
     * @param string $str String to be analyzed.
     *
     * @return array
     */
    public static function getLines($str)
    {
        if (!$str instanceof UtfString && defined('USE_UTF_STRINGS') && USE_UTF_STRINGS) {
            // If the lexer uses UtfString for processing then the position will
            // represent the position of the character and not the position of
            // the byte.
            $str = new UtfString($str);
        }
        // The reason for using the strlen is that the length
        // required is the length in bytes, not characters.
        //
        // Given the following string: `????+`, where `?` represents a
        // multi-byte character (lets assume that every `?` is a 2-byte
        // character) and `+` is a newline, the first value of `$i` is `0`
        // and the last one is `4` (because there are 5 characters). Bytes
        // `$str[0]` and `$str[1]` are the first character, `$str[2]` and
        // `$str[3]` are the second one and `$str[4]` is going to be the
        // first byte of the third character. The fourth and the last one
        // (which is actually a new line) aren't going to be processed at
        // all.
        $len = $str instanceof UtfString ? $str->length() : strlen($str);
        $lines = array(0);
        for ($i = 0; $i < $len; ++$i) {
            if ($str[$i] === "\n") {
                $lines[] = $i + 1;
            }
        }
        return $lines;
    }
    /**
     * Computes the number of the line and column given an absolute position.
     *
     * @param array $lines The starting position of each line.
     * @param int   $pos   The absolute position
     *
     * @return array
     */
    public static function findLineNumberAndColumn($lines, $pos)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("findLineNumberAndColumn") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Linter.php at line 75")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called findLineNumberAndColumn:75@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Linter.php');
        die();
    }
    /**
     * Runs the linting process.
     *
     * @param string $query The query to be checked.
     *
     * @return array
     */
    public static function lint($query)
    {
        // Disabling lint for huge queries to save some resources.
        if (mb_strlen($query) > 10000) {
            return array(array('message' => __('Linting is disabled for this query because it exceeds the ' . 'maximum length.'), 'fromLine' => 0, 'fromColumn' => 0, 'toLine' => 0, 'toColumn' => 0, 'severity' => 'warning'));
        }
        /**
         * Lexer used for tokenizing the query.
         *
         * @var Lexer
         */
        $lexer = new Lexer($query);
        /**
         * Parsed used for analysing the query.
         *
         * @var Parser
         */
        $parser = new Parser($lexer->list);
        /**
         * Array containing all errors.
         *
         * @var array
         */
        $errors = ParserError::get(array($lexer, $parser));
        /**
         * The response containing of all errors.
         *
         * @var array
         */
        $response = array();
        /**
         * The starting position for each line.
         *
         * CodeMirror requires relative position to line, but the parser stores
         * only the absolute position of the character in string.
         *
         * @var array
         */
        $lines = static::getLines($query);
        // Building the response.
        foreach ($errors as $idx => $error) {
            // Starting position of the string that caused the error.
            list($fromLine, $fromColumn) = static::findLineNumberAndColumn($lines, $error[3]);
            // Ending position of the string that caused the error.
            list($toLine, $toColumn) = static::findLineNumberAndColumn($lines, $error[3] + mb_strlen($error[2]));
            // Building the response.
            $response[] = array('message' => sprintf(__('%1$s (near <code>%2$s</code>)'), $error[0], $error[2]), 'fromLine' => $fromLine, 'fromColumn' => $fromColumn, 'toLine' => $toLine, 'toColumn' => $toColumn, 'severity' => 'error');
        }
        // Sending back the answer.
        return $response;
    }
}