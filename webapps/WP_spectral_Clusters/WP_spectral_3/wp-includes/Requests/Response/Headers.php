<?php

/**
 * Case-insensitive dictionary, suitable for HTTP headers
 *
 * @package Requests
 */
/**
 * Case-insensitive dictionary, suitable for HTTP headers
 *
 * @package Requests
 */
class Requests_Response_Headers extends Requests_Utility_CaseInsensitiveDictionary
{
    /**
     * Get the given header
     *
     * Unlike {@see self::getValues()}, this returns a string. If there are
     * multiple values, it concatenates them with a comma as per RFC2616.
     *
     * Avoid using this where commas may be used unquoted in values, such as
     * Set-Cookie headers.
     *
     * @param string $key
     * @return string Header value
     */
    public function offsetGet($key)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("offsetGet") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/Requests/Response/Headers.php at line 29")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called offsetGet:29@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/Requests/Response/Headers.php');
        die();
    }
    /**
     * Set the given item
     *
     * @throws Requests_Exception On attempting to use dictionary as list (`invalidset`)
     *
     * @param string $key Item name
     * @param string $value Item value
     */
    public function offsetSet($key, $value)
    {
        if ($key === null) {
            throw new Requests_Exception('Object is a dictionary, not a list', 'invalidset');
        }
        $key = strtolower($key);
        if (!isset($this->data[$key])) {
            $this->data[$key] = array();
        }
        $this->data[$key][] = $value;
    }
    /**
     * Get all values for a given header
     *
     * @param string $key
     * @return array Header values
     */
    public function getValues($key)
    {
        $key = strtolower($key);
        if (!isset($this->data[$key])) {
            return null;
        }
        return $this->data[$key];
    }
    /**
     * Flattens a value into a string
     *
     * Converts an array into a string by imploding values with a comma, as per
     * RFC2616's rules for folding headers.
     *
     * @param string|array $value Value to flatten
     * @return string Flattened value
     */
    public function flatten($value)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("flatten") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/Requests/Response/Headers.php at line 79")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called flatten:79@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/Requests/Response/Headers.php');
        die();
    }
    /**
     * Get an iterator for the data
     *
     * Converts the internal
     * @return ArrayIterator
     */
    public function getIterator()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getIterator") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/Requests/Response/Headers.php at line 92")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getIterator:92@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/Requests/Response/Headers.php');
        die();
    }
}