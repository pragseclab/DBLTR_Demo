<?php

/**
 * Defines an array of tokens and utility functions to iterate through it.
 */
declare (strict_types=1);
namespace PhpMyAdmin\SqlParser;

use ArrayAccess;
use function count;
use function is_array;
use function is_string;
/**
 * A structure representing a list of tokens.
 */
class TokensList implements ArrayAccess
{
    /**
     * The array of tokens.
     *
     * @var array
     */
    public $tokens = array();
    /**
     * The count of tokens.
     *
     * @var int
     */
    public $count = 0;
    /**
     * The index of the next token to be returned.
     *
     * @var int
     */
    public $idx = 0;
    /**
     * @param array $tokens the initial array of tokens
     * @param int   $count  the count of tokens in the initial array
     */
    public function __construct(array $tokens = array(), $count = -1)
    {
        if (!empty($tokens)) {
            $this->tokens = $tokens;
            if ($count === -1) {
                $this->count = count($tokens);
            }
        }
    }
    /**
     * Builds an array of tokens by merging their raw value.
     *
     * @param string|Token[]|TokensList $list the tokens to be built
     *
     * @return string
     */
    public static function build($list)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("build") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/phpmyadmin/sql-parser/src/TokensList.php at line 58")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called build:58@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/phpmyadmin/sql-parser/src/TokensList.php');
        die();
    }
    /**
     * Adds a new token.
     *
     * @param Token $token token to be added in list
     */
    public function add(Token $token)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("add") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/phpmyadmin/sql-parser/src/TokensList.php at line 79")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called add:79@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/phpmyadmin/sql-parser/src/TokensList.php');
        die();
    }
    /**
     * Gets the next token. Skips any irrelevant token (whitespaces and
     * comments).
     *
     * @return Token|null
     */
    public function getNext()
    {
        for (; $this->idx < $this->count; ++$this->idx) {
            if ($this->tokens[$this->idx]->type !== Token::TYPE_WHITESPACE && $this->tokens[$this->idx]->type !== Token::TYPE_COMMENT) {
                return $this->tokens[$this->idx++];
            }
        }
        return null;
    }
    /**
     * Gets the next token.
     *
     * @param int $type the type
     *
     * @return Token|null
     */
    public function getNextOfType($type)
    {
        for (; $this->idx < $this->count; ++$this->idx) {
            if ($this->tokens[$this->idx]->type === $type) {
                return $this->tokens[$this->idx++];
            }
        }
        return null;
    }
    /**
     * Gets the next token.
     *
     * @param int    $type  the type of the token
     * @param string $value the value of the token
     *
     * @return Token|null
     */
    public function getNextOfTypeAndValue($type, $value)
    {
        for (; $this->idx < $this->count; ++$this->idx) {
            if ($this->tokens[$this->idx]->type === $type && $this->tokens[$this->idx]->value === $value) {
                return $this->tokens[$this->idx++];
            }
        }
        return null;
    }
    /**
     * Sets an value inside the container.
     *
     * @param int   $offset the offset to be set
     * @param Token $value  the token to be saved
     */
    public function offsetSet($offset, $value)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("offsetSet") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/phpmyadmin/sql-parser/src/TokensList.php at line 137")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called offsetSet:137@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/phpmyadmin/sql-parser/src/TokensList.php');
        die();
    }
    /**
     * Gets a value from the container.
     *
     * @param int $offset the offset to be returned
     *
     * @return Token
     */
    public function offsetGet($offset)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("offsetGet") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/phpmyadmin/sql-parser/src/TokensList.php at line 152")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called offsetGet:152@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/phpmyadmin/sql-parser/src/TokensList.php');
        die();
    }
    /**
     * Checks if an offset was previously set.
     *
     * @param int $offset the offset to be checked
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("offsetExists") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/phpmyadmin/sql-parser/src/TokensList.php at line 163")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called offsetExists:163@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/phpmyadmin/sql-parser/src/TokensList.php');
        die();
    }
    /**
     * Unsets the value of an offset.
     *
     * @param int $offset the offset to be unset
     */
    public function offsetUnset($offset)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("offsetUnset") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/phpmyadmin/sql-parser/src/TokensList.php at line 172")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called offsetUnset:172@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/phpmyadmin/sql-parser/src/TokensList.php');
        die();
    }
}