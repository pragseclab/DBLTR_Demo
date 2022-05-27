<?php

declare (strict_types=1);
namespace PhpMyAdmin;

use const E_COMPILE_ERROR;
use const E_COMPILE_WARNING;
use const E_CORE_ERROR;
use const E_CORE_WARNING;
use const E_DEPRECATED;
use const E_ERROR;
use const E_NOTICE;
use const E_PARSE;
use const E_RECOVERABLE_ERROR;
use const E_STRICT;
use const E_USER_DEPRECATED;
use const E_USER_ERROR;
use const E_USER_NOTICE;
use const E_USER_WARNING;
use const E_WARNING;
use function array_splice;
use function count;
use function defined;
use function error_reporting;
use function headers_sent;
use function htmlspecialchars;
use function set_error_handler;
use function trigger_error;
/**
 * handling errors
 */
class ErrorHandler
{
    /**
     * holds errors to be displayed or reported later ...
     *
     * @var Error[]
     */
    protected $errors = [];
    /**
     * Hide location of errors
     *
     * @var bool
     */
    protected $hideLocation = false;
    /**
     * Initial error reporting state
     *
     * @var int
     */
    protected $errorReporting = 0;
    public function __construct()
    {
        /**
         * Do not set ourselves as error handler in case of testsuite.
         *
         * This behavior is not tested there and breaks other tests as they
         * rely on PHPUnit doing it's own error handling which we break here.
         */
        if (!defined('TESTSUITE')) {
            set_error_handler([$this, 'handleError']);
        }
        if (!Util::isErrorReportingAvailable()) {
            return;
        }
        $this->errorReporting = error_reporting();
    }
    /**
     * Destructor
     *
     * stores errors in session
     */
    public function __destruct()
    {
        $stop_coverage = false;
        if (function_exists('end_coverage_cav39s8hca')) {
            $stop_coverage = !xdebug_code_coverage_started();
            if (!xdebug_code_coverage_started()) {
                xdebug_start_code_coverage();
            }
        }
        if (!isset($_SESSION['errors'])) {
            $_SESSION['errors'] = [];
        }
        // remember only not displayed errors
        foreach ($this->errors as $key => $error) {
            /**
             * We don't want to store all errors here as it would
             * explode user session.
             */
            if (count($_SESSION['errors']) >= 10) {
                $error = new Error(0, __('Too many error messages, some are not displayed.'), __FILE__, __LINE__);
                $_SESSION['errors'][$error->getHash()] = $error;
                break;
            }
            if (!$error instanceof Error || $error->isDisplayed()) {
                continue;
            }
            $_SESSION['errors'][$key] = $error;
        }
        if (function_exists('end_coverage_cav39s8hca')) {
            if ($stop_coverage) {
                end_coverage_cav39s8hca($stop_coverage);
            }
        }
    }
    /**
     * Toggles location hiding
     *
     * @param bool $hide Whether to hide
     */
    public function setHideLocation(bool $hide) : void
    {
        $this->hideLocation = $hide;
    }
    /**
     * returns array with all errors
     *
     * @param bool $check Whether to check for session errors
     *
     * @return Error[]
     */
    public function getErrors(bool $check = true) : array
    {
        if ($check) {
            $this->checkSavedErrors();
        }
        return $this->errors;
    }
    /**
     * returns the errors occurred in the current run only.
     * Does not include the errors saved in the SESSION
     *
     * @return Error[]
     */
    public function getCurrentErrors() : array
    {
        return $this->errors;
    }
    /**
     * Pops recent errors from the storage
     *
     * @param int $count Old error count
     *
     * @return Error[]
     */
    public function sliceErrors(int $count) : array
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("sliceErrors") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/ErrorHandler.php at line 149")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called sliceErrors:149@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/ErrorHandler.php');
        die();
    }
    /**
     * Error handler - called when errors are triggered/occurred
     *
     * This calls the addError() function, escaping the error string
     * Ignores the errors wherever Error Control Operator (@) is used.
     *
     * @param int    $errno   error number
     * @param string $errstr  error string
     * @param string $errfile error file
     * @param int    $errline error line
     */
    public function handleError(int $errno, string $errstr, string $errfile, int $errline) : void
    {
        if (Util::isErrorReportingAvailable()) {
            /**
             * Check if Error Control Operator (@) was used, but still show
             * user errors even in this case.
             */
            if (error_reporting() == 0 && $this->errorReporting != 0 && ($errno & (E_USER_WARNING | E_USER_ERROR | E_USER_NOTICE | E_USER_DEPRECATED)) == 0) {
                return;
            }
        } else {
            if (($errno & (E_USER_WARNING | E_USER_ERROR | E_USER_NOTICE | E_USER_DEPRECATED)) == 0) {
                return;
            }
        }
        $this->addError($errstr, $errno, $errfile, $errline, true);
    }
    /**
     * Add an error; can also be called directly (with or without escaping)
     *
     * The following error types cannot be handled with a user defined function:
     * E_ERROR, E_PARSE, E_CORE_ERROR, E_CORE_WARNING, E_COMPILE_ERROR,
     * E_COMPILE_WARNING,
     * and most of E_STRICT raised in the file where set_error_handler() is called.
     *
     * Do not use the context parameter as we want to avoid storing the
     * complete $GLOBALS inside $_SESSION['errors']
     *
     * @param string $errstr  error string
     * @param int    $errno   error number
     * @param string $errfile error file
     * @param int    $errline error line
     * @param bool   $escape  whether to escape the error string
     */
    public function addError(string $errstr, int $errno, string $errfile, int $errline, bool $escape = true) : void
    {
        if ($escape) {
            $errstr = htmlspecialchars($errstr);
        }
        // create error object
        $error = new Error($errno, $errstr, $errfile, $errline);
        $error->setHideLocation($this->hideLocation);
        // do not repeat errors
        $this->errors[$error->getHash()] = $error;
        switch ($error->getNumber()) {
            case E_STRICT:
            case E_DEPRECATED:
            case E_NOTICE:
            case E_WARNING:
            case E_CORE_WARNING:
            case E_COMPILE_WARNING:
            case E_RECOVERABLE_ERROR:
                /* Avoid rendering BB code in PHP errors */
                $error->setBBCode(false);
                break;
            case E_USER_NOTICE:
            case E_USER_WARNING:
            case E_USER_ERROR:
            case E_USER_DEPRECATED:
                // just collect the error
                // display is called from outside
                break;
            case E_ERROR:
            case E_PARSE:
            case E_CORE_ERROR:
            case E_COMPILE_ERROR:
            default:
                // FATAL error, display it and exit
                $this->dispFatalError($error);
                exit;
        }
    }
    /**
     * trigger a custom error
     *
     * @param string $errorInfo   error message
     * @param int    $errorNumber error number
     */
    public function triggerError(string $errorInfo, ?int $errorNumber = null) : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("triggerError") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/ErrorHandler.php at line 246")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called triggerError:246@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/ErrorHandler.php');
        die();
    }
    /**
     * display fatal error and exit
     *
     * @param Error $error the error
     */
    protected function dispFatalError(Error $error) : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("dispFatalError") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/ErrorHandler.php at line 255")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called dispFatalError:255@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/ErrorHandler.php');
        die();
    }
    /**
     * Displays user errors not displayed
     */
    public function dispUserErrors() : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("dispUserErrors") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/ErrorHandler.php at line 267")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called dispUserErrors:267@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/ErrorHandler.php');
        die();
    }
    /**
     * Renders user errors not displayed
     */
    public function getDispUserErrors() : string
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getDispUserErrors") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/ErrorHandler.php at line 274")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getDispUserErrors:274@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/ErrorHandler.php');
        die();
    }
    /**
     * display HTML header
     *
     * @param Error $error the error
     */
    protected function dispPageStart(?Error $error = null) : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("dispPageStart") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/ErrorHandler.php at line 290")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called dispPageStart:290@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/ErrorHandler.php');
        die();
    }
    /**
     * display HTML footer
     */
    protected function dispPageEnd() : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("dispPageEnd") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/ErrorHandler.php at line 304")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called dispPageEnd:304@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/ErrorHandler.php');
        die();
    }
    /**
     * renders errors not displayed
     */
    public function getDispErrors() : string
    {
        $retval = '';
        // display errors if SendErrorReports is set to 'ask'.
        if ($GLOBALS['cfg']['SendErrorReports'] !== 'never') {
            foreach ($this->getErrors() as $error) {
                if ($error->isDisplayed()) {
                    continue;
                }
                $retval .= $error->getDisplay();
            }
        } else {
            $retval .= $this->getDispUserErrors();
        }
        // if preference is not 'never' and
        // there are 'actual' errors to be reported
        if ($GLOBALS['cfg']['SendErrorReports'] !== 'never' && $this->countErrors() != $this->countUserErrors()) {
            // add report button.
            $retval .= '<form method="post" action="' . Url::getFromRoute('/error-report') . '" id="pma_report_errors_form"';
            if ($GLOBALS['cfg']['SendErrorReports'] === 'always') {
                // in case of 'always', generate 'invisible' form.
                $retval .= ' class="hide"';
            }
            $retval .= '>';
            $retval .= Url::getHiddenFields(['exception_type' => 'php', 'send_error_report' => '1', 'server' => $GLOBALS['server']]);
            $retval .= '<input type="submit" value="' . __('Report') . '" id="pma_report_errors" class="btn btn-primary floatright">' . '<input type="checkbox" name="always_send"' . ' id="always_send_checkbox" value="true">' . '<label for="always_send_checkbox">' . __('Automatically send report next time') . '</label>';
            if ($GLOBALS['cfg']['SendErrorReports'] === 'ask') {
                // add ignore buttons
                $retval .= '<input type="submit" value="' . __('Ignore') . '" id="pma_ignore_errors_bottom" class="btn btn-secondary floatright">';
            }
            $retval .= '<input type="submit" value="' . __('Ignore All') . '" id="pma_ignore_all_errors_bottom" class="btn btn-secondary floatright">';
            $retval .= '</form>';
        }
        return $retval;
    }
    /**
     * look in session for saved errors
     */
    protected function checkSavedErrors() : void
    {
        if (!isset($_SESSION['errors'])) {
            return;
        }
        // restore saved errors
        foreach ($_SESSION['errors'] as $hash => $error) {
            if (!$error instanceof Error || isset($this->errors[$hash])) {
                continue;
            }
            $this->errors[$hash] = $error;
        }
        // delete stored errors
        $_SESSION['errors'] = [];
        unset($_SESSION['errors']);
    }
    /**
     * return count of errors
     *
     * @param bool $check Whether to check for session errors
     *
     * @return int number of errors occurred
     */
    public function countErrors(bool $check = true) : int
    {
        return count($this->getErrors($check));
    }
    /**
     * return count of user errors
     *
     * @return int number of user errors occurred
     */
    public function countUserErrors() : int
    {
        $count = 0;
        if ($this->countErrors()) {
            foreach ($this->getErrors() as $error) {
                if (!$error->isUserError()) {
                    continue;
                }
                $count++;
            }
        }
        return $count;
    }
    /**
     * whether use errors occurred or not
     */
    public function hasUserErrors() : bool
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("hasUserErrors") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/ErrorHandler.php at line 397")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called hasUserErrors:397@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/ErrorHandler.php');
        die();
    }
    /**
     * whether errors occurred or not
     */
    public function hasErrors() : bool
    {
        return (bool) $this->countErrors();
    }
    /**
     * number of errors to be displayed
     *
     * @return int number of errors to be displayed
     */
    public function countDisplayErrors() : int
    {
        if ($GLOBALS['cfg']['SendErrorReports'] !== 'never') {
            return $this->countErrors();
        }
        return $this->countUserErrors();
    }
    /**
     * whether there are errors to display or not
     */
    public function hasDisplayErrors() : bool
    {
        return (bool) $this->countDisplayErrors();
    }
    /**
     * Deletes previously stored errors in SESSION.
     * Saves current errors in session as previous errors.
     * Required to save current errors in case  'ask'
     */
    public function savePreviousErrors() : void
    {
        unset($_SESSION['prev_errors']);
        $_SESSION['prev_errors'] = $GLOBALS['error_handler']->getCurrentErrors();
    }
    /**
     * Function to check if there are any errors to be prompted.
     * Needed because user warnings raised are
     *      also collected by global error handler.
     * This distinguishes between the actual errors
     *      and user errors raised to warn user.
     *
     * @return bool true if there are errors to be "prompted", false otherwise
     */
    public function hasErrorsForPrompt() : bool
    {
        return $GLOBALS['cfg']['SendErrorReports'] !== 'never' && $this->countErrors() != $this->countUserErrors();
    }
    /**
     * Function to report all the collected php errors.
     * Must be called at the end of each script
     *      by the $GLOBALS['error_handler'] only.
     */
    public function reportErrors() : void
    {
        // if there're no actual errors,
        if (!$this->hasErrors() || $this->countErrors() == $this->countUserErrors()) {
            // then simply return.
            return;
        }
        // Delete all the prev_errors in session & store new prev_errors in session
        $this->savePreviousErrors();
        $response = Response::getInstance();
        $jsCode = '';
        if ($GLOBALS['cfg']['SendErrorReports'] === 'always') {
            if ($response->isAjax()) {
                // set flag for automatic report submission.
                $response->addJSON('sendErrorAlways', '1');
            } else {
                // send the error reports asynchronously & without asking user
                $jsCode .= '$("#pma_report_errors_form").submit();' . 'Functions.ajaxShowMessage(
                            Messages.phpErrorsBeingSubmitted, false
                        );';
                // js code to appropriate focusing,
                $jsCode .= '$("html, body").animate({
                                scrollTop:$(document).height()
                            }, "slow");';
            }
        } elseif ($GLOBALS['cfg']['SendErrorReports'] === 'ask') {
            //ask user whether to submit errors or not.
            if (!$response->isAjax()) {
                // js code to show appropriate msgs, event binding & focusing.
                $jsCode = 'Functions.ajaxShowMessage(Messages.phpErrorsFound);' . '$("#pma_ignore_errors_popup").on("click", function() {
                            Functions.ignorePhpErrors()
                        });' . '$("#pma_ignore_all_errors_popup").on("click",
                            function() {
                                Functions.ignorePhpErrors(false)
                            });' . '$("#pma_ignore_errors_bottom").on("click", function(e) {
                            e.preventDefault();
                            Functions.ignorePhpErrors()
                        });' . '$("#pma_ignore_all_errors_bottom").on("click",
                            function(e) {
                                e.preventDefault();
                                Functions.ignorePhpErrors(false)
                            });' . '$("html, body").animate({
                            scrollTop:$(document).height()
                        }, "slow");';
            }
        }
        // The errors are already sent from the response.
        // Just focus on errors division upon load event.
        $response->getFooter()->getScripts()->addCode($jsCode);
    }
}