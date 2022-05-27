<?php

/**
 * Value object class for a character set
 */
declare (strict_types=1);
namespace PhpMyAdmin\Charsets;

/**
 * Value object class for a character set
 */
final class Charset
{
    /**
     * The character set name
     *
     * @var string
     */
    private $name;
    /**
     * A description of the character set
     *
     * @var string
     */
    private $description;
    /**
     * The default collation for the character set
     *
     * @var string
     */
    private $defaultCollation;
    /**
     * The maximum number of bytes required to store one character
     *
     * @var int
     */
    private $maxLength;
    /**
     * @param string $name             Charset name
     * @param string $description      Description
     * @param string $defaultCollation Default collation
     * @param int    $maxLength        Maximum length
     */
    private function __construct(string $name, string $description, string $defaultCollation, int $maxLength)
    {
        $this->name = $name;
        $this->description = $description;
        $this->defaultCollation = $defaultCollation;
        $this->maxLength = $maxLength;
    }
    /**
     * @param array $state State obtained from the database server
     *
     * @return Charset
     */
    public static function fromServer(array $state) : self
    {
        return new self($state['Charset'] ?? '', $state['Description'] ?? '', $state['Default collation'] ?? '', (int) ($state['Maxlen'] ?? 0));
    }
    public function getName() : string
    {
        return $this->name;
    }
    public function getDescription() : string
    {
        return $this->description;
    }
    public function getDefaultCollation() : string
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getDefaultCollation") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Charsets/Charset.php at line 70")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getDefaultCollation:70@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Charsets/Charset.php');
        die();
    }
    public function getMaxLength() : int
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getMaxLength") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Charsets/Charset.php at line 74")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getMaxLength:74@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Charsets/Charset.php');
        die();
    }
}