<?php

namespace Facebook\WebDriver\Exception;

use Exception;
/**
 * @see https://w3c.github.io/webdriver/#errors
 */
class WebDriverException extends Exception
{
    private $results;
    /**
     * @param string $message
     * @param mixed $results
     */
    public function __construct($message, $results = null)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("__construct") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/vendor/php-webdriver/webdriver/lib/Exception/WebDriverException.php at line 18")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called __construct:18@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/vendor/php-webdriver/webdriver/lib/Exception/WebDriverException.php');
        die();
    }
    /**
     * @return mixed
     */
    public function getResults()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getResults") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/vendor/php-webdriver/webdriver/lib/Exception/WebDriverException.php at line 26")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getResults:26@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/vendor/php-webdriver/webdriver/lib/Exception/WebDriverException.php');
        die();
    }
    /**
     * Throw WebDriverExceptions based on WebDriver status code.
     *
     * @param int|string $status_code
     * @param string $message
     * @param mixed $results
     *
     * @throws ElementClickInterceptedException
     * @throws ElementNotInteractableException
     * @throws ElementNotSelectableException
     * @throws ElementNotVisibleException
     * @throws ExpectedException
     * @throws IMEEngineActivationFailedException
     * @throws IMENotAvailableException
     * @throws IndexOutOfBoundsException
     * @throws InsecureCertificateException
     * @throws InvalidArgumentException
     * @throws InvalidCookieDomainException
     * @throws InvalidCoordinatesException
     * @throws InvalidElementStateException
     * @throws InvalidSelectorException
     * @throws InvalidSessionIdException
     * @throws JavascriptErrorException
     * @throws MoveTargetOutOfBoundsException
     * @throws NoAlertOpenException
     * @throws NoCollectionException
     * @throws NoScriptResultException
     * @throws NoStringException
     * @throws NoStringLengthException
     * @throws NoStringWrapperException
     * @throws NoSuchAlertException
     * @throws NoSuchCollectionException
     * @throws NoSuchCookieException
     * @throws NoSuchDocumentException
     * @throws NoSuchDriverException
     * @throws NoSuchElementException
     * @throws NoSuchFrameException
     * @throws NoSuchWindowException
     * @throws NullPointerException
     * @throws ScriptTimeoutException
     * @throws SessionNotCreatedException
     * @throws StaleElementReferenceException
     * @throws TimeoutException
     * @throws UnableToCaptureScreenException
     * @throws UnableToSetCookieException
     * @throws UnexpectedAlertOpenException
     * @throws UnexpectedJavascriptException
     * @throws UnknownCommandException
     * @throws UnknownErrorException
     * @throws UnknownMethodException
     * @throws UnknownServerException
     * @throws UnrecognizedExceptionException
     * @throws UnsupportedOperationException
     * @throws XPathLookupException
     */
    public static function throwException($status_code, $message, $results)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("throwException") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/vendor/php-webdriver/webdriver/lib/Exception/WebDriverException.php at line 85")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called throwException:85@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/vendor/php-webdriver/webdriver/lib/Exception/WebDriverException.php');
        die();
    }
}