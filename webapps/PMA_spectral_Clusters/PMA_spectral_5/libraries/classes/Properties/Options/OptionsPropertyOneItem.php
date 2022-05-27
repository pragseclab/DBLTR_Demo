<?php

/**
 * Superclass for the single Property Item classes.
 */
declare (strict_types=1);
namespace PhpMyAdmin\Properties\Options;

/**
 * Parents only single property items (not groups).
 * Defines possible options and getters and setters for them.
 */
abstract class OptionsPropertyOneItem extends OptionsPropertyItem
{
    /**
     * Whether to force or not
     *
     * @var bool|string
     */
    private $forceOne;
    /**
     * Values
     *
     * @var array
     */
    private $values;
    /**
     * Doc
     *
     * @var string
     */
    private $doc;
    /**
     * Length
     *
     * @var int
     */
    private $len;
    /**
     * Size
     *
     * @var int
     */
    private $size;
    /* ~~~~~~~~~~~~~~~~~~~~ Getters and Setters ~~~~~~~~~~~~~~~~~~~~ */
    /**
     * Gets the force parameter
     *
     * @return bool|string
     */
    public function getForce()
    {
        return $this->forceOne;
    }
    /**
     * Sets the force parameter
     *
     * @param bool|string $force force parameter
     *
     * @return void
     */
    public function setForce($force)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("setForce") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Properties/Options/OptionsPropertyOneItem.php at line 64")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called setForce:64@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Properties/Options/OptionsPropertyOneItem.php');
        die();
    }
    /**
     * Gets the values
     *
     * @return array
     */
    public function getValues()
    {
        return $this->values;
    }
    /**
     * Sets the values
     *
     * @param array $values values
     *
     * @return void
     */
    public function setValues(array $values)
    {
        $this->values = $values;
    }
    /**
     * Gets MySQL documentation pointer
     *
     * @return string
     */
    public function getDoc()
    {
        return $this->doc;
    }
    /**
     * Sets the doc
     *
     * @param string $doc MySQL documentation pointer
     *
     * @return void
     */
    public function setDoc($doc)
    {
        $this->doc = $doc;
    }
    /**
     * Gets the length
     *
     * @return int
     */
    public function getLen()
    {
        return $this->len;
    }
    /**
     * Sets the length
     *
     * @param int $len length
     *
     * @return void
     */
    public function setLen($len)
    {
        $this->len = $len;
    }
    /**
     * Gets the size
     *
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }
    /**
     * Sets the size
     *
     * @param int $size size
     *
     * @return void
     */
    public function setSize($size)
    {
        $this->size = $size;
    }
}