<?php

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * hold the ListAbstract base class
 *
 * @package PhpMyAdmin
 */
namespace PMA\libraries;

use ArrayObject;
/**
 * Generic list class
 *
 * @todo add caching
 * @abstract
 * @package PhpMyAdmin
 * @since   phpMyAdmin 2.9.10
 */
abstract class ListAbstract extends ArrayObject
{
    /**
     * @var mixed   empty item
     */
    protected $item_empty = '';
    /**
     * ListAbstract constructor
     *
     * @param array  $array          The input parameter accepts an array or an
     *                               Object.
     * @param int    $flags          Flags to control the behaviour of the
     *                               ArrayObject object.
     * @param string $iterator_class Specify the class that will be used for
     *                               iteration of the ArrayObject object.
     *                               ArrayIterator is the default class used.
     */
    public function __construct($array = array(), $flags = 0, $iterator_class = "ArrayIterator")
    {
        parent::__construct($array, $flags, $iterator_class);
    }
    /**
     * defines what is an empty item (0, '', false or null)
     *
     * @return mixed   an empty item
     */
    public function getEmpty()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getEmpty") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/ListAbstract.php at line 51")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getEmpty:51@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/ListAbstract.php');
        die();
    }
    /**
     * checks if the given db names exists in the current list, if there is
     * missing at least one item it returns false otherwise true
     *
     * @return boolean true if all items exists, otherwise false
     */
    public function exists()
    {
        $this_elements = $this->getArrayCopy();
        foreach (func_get_args() as $result) {
            if (!in_array($result, $this_elements)) {
                return false;
            }
        }
        return true;
    }
    /**
     * returns HTML <option>-tags to be used inside <select></select>
     *
     * @param mixed   $selected                   the selected db or true for
     *                                            selecting current db
     * @param boolean $include_information_schema whether include information schema
     *
     * @return string  HTML option tags
     */
    public function getHtmlOptions($selected = '', $include_information_schema = true)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getHtmlOptions") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/ListAbstract.php at line 84")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getHtmlOptions:84@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/ListAbstract.php');
        die();
    }
    /**
     * returns default item
     *
     * @return string  default item
     */
    public function getDefault()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getDefault") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/ListAbstract.php at line 112")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getDefault:112@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/ListAbstract.php');
        die();
    }
    /**
     * builds up the list
     *
     * @return void
     */
    public abstract function build();
}