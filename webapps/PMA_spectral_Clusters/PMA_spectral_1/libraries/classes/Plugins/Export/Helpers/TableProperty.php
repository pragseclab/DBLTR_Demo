<?php

declare (strict_types=1);
namespace PhpMyAdmin\Plugins\Export\Helpers;

use PhpMyAdmin\Plugins\Export\ExportCodegen;
use const ENT_COMPAT;
use function htmlspecialchars;
use function mb_strpos;
use function mb_substr;
use function str_replace;
use function strlen;
use function trim;
/**
 * PhpMyAdmin\Plugins\Export\Helpers\TableProperty class
 */
class TableProperty
{
    /**
     * Name
     *
     * @var string
     */
    public $name;
    /**
     * Type
     *
     * @var string
     */
    public $type;
    /**
     * Whether the key is nullable or not
     *
     * @var string
     */
    public $nullable;
    /**
     * The key
     *
     * @var string
     */
    public $key;
    /**
     * Default value
     *
     * @var mixed
     */
    public $defaultValue;
    /**
     * Extension
     *
     * @var string
     */
    public $ext;
    /**
     * @param array $row table row
     */
    public function __construct(array $row)
    {
        $this->name = trim((string) $row[0]);
        $this->type = trim((string) $row[1]);
        $this->nullable = trim((string) $row[2]);
        $this->key = trim((string) $row[3]);
        $this->defaultValue = trim((string) $row[4]);
        $this->ext = trim((string) $row[5]);
    }
    /**
     * Gets the pure type
     *
     * @return string type
     */
    public function getPureType()
    {
        $pos = (int) mb_strpos($this->type, '(');
        if ($pos > 0) {
            return mb_substr($this->type, 0, $pos);
        }
        return $this->type;
    }
    /**
     * Tells whether the key is null or not
     *
     * @return string true if the key is not null, false otherwise
     */
    public function isNotNull()
    {
        return $this->nullable === 'NO' ? 'true' : 'false';
    }
    /**
     * Tells whether the key is unique or not
     *
     * @return string "true" if the key is unique, "false" otherwise
     */
    public function isUnique() : string
    {
        return $this->key === 'PRI' || $this->key === 'UNI' ? 'true' : 'false';
    }
    /**
     * Gets the .NET primitive type
     *
     * @return string type
     */
    public function getDotNetPrimitiveType()
    {
        if (mb_strpos($this->type, 'int') === 0) {
            return 'int';
        }
        if (mb_strpos($this->type, 'longtext') === 0) {
            return 'string';
        }
        if (mb_strpos($this->type, 'long') === 0) {
            return 'long';
        }
        if (mb_strpos($this->type, 'char') === 0) {
            return 'string';
        }
        if (mb_strpos($this->type, 'varchar') === 0) {
            return 'string';
        }
        if (mb_strpos($this->type, 'text') === 0) {
            return 'string';
        }
        if (mb_strpos($this->type, 'tinyint') === 0) {
            return 'bool';
        }
        if (mb_strpos($this->type, 'datetime') === 0) {
            return 'DateTime';
        }
        return 'unknown';
    }
    /**
     * Gets the .NET object type
     *
     * @return string type
     */
    public function getDotNetObjectType()
    {
        if (mb_strpos($this->type, 'int') === 0) {
            return 'Int32';
        }
        if (mb_strpos($this->type, 'longtext') === 0) {
            return 'String';
        }
        if (mb_strpos($this->type, 'long') === 0) {
            return 'Long';
        }
        if (mb_strpos($this->type, 'char') === 0) {
            return 'String';
        }
        if (mb_strpos($this->type, 'varchar') === 0) {
            return 'String';
        }
        if (mb_strpos($this->type, 'text') === 0) {
            return 'String';
        }
        if (mb_strpos($this->type, 'tinyint') === 0) {
            return 'Boolean';
        }
        if (mb_strpos($this->type, 'datetime') === 0) {
            return 'DateTime';
        }
        return 'Unknown';
    }
    /**
     * Gets the index name
     *
     * @return string containing the name of the index
     */
    public function getIndexName()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getIndexName") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Plugins/Export/Helpers/TableProperty.php at line 171")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getIndexName:171@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Plugins/Export/Helpers/TableProperty.php');
        die();
    }
    /**
     * Tells whether the key is primary or not
     *
     * @return bool true if the key is primary, false otherwise
     */
    public function isPK() : bool
    {
        return $this->key === 'PRI';
    }
    /**
     * Formats a string for C#
     *
     * @param string $text string to be formatted
     *
     * @return string formatted text
     */
    public function formatCs($text)
    {
        $text = str_replace('#name#', ExportCodegen::cgMakeIdentifier($this->name, false), $text);
        return $this->format($text);
    }
    /**
     * Formats a string for XML
     *
     * @param string $text string to be formatted
     *
     * @return string formatted text
     */
    public function formatXml($text)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("formatXml") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Plugins/Export/Helpers/TableProperty.php at line 206")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called formatXml:206@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Plugins/Export/Helpers/TableProperty.php');
        die();
    }
    /**
     * Formats a string
     *
     * @param string $text string to be formatted
     *
     * @return string formatted text
     */
    public function format($text)
    {
        $text = str_replace(['#ucfirstName#', '#dotNetPrimitiveType#', '#dotNetObjectType#', '#type#', '#notNull#', '#unique#'], [ExportCodegen::cgMakeIdentifier($this->name), $this->getDotNetPrimitiveType(), $this->getDotNetObjectType(), $this->getPureType(), $this->isNotNull(), $this->isUnique()], $text);
        return $text;
    }
}