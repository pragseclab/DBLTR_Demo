<?php

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Holds class PMA\libraries\ErrorHandler
 *
 * @package PhpMyAdmin
 */
namespace PMA\libraries;

use PMA\libraries\Error;
/**
 * handling errors
 *
 * @package PhpMyAdmin
 */
class ErrorHandler
{
    /**
     * holds errors to be displayed or reported later ...
     *
     * @var Error[]
     */
    protected $errors = array();
    /**
     * Hide location of errors
     */
    protected $hide_location = false;
    /**
     * Initial error reporting state
     */
    protected $error_reporting = 0;
    /**
     * Constructor - set PHP error handler
     *
     */
    public function __construct()
    {
        /**
         * Do not set ourselves as error handler in case of testsuite.
         *
         * This behavior is not tested there and breaks other tests as they
         * rely on PHPUnit doing it's own error handling which we break here.
         */
        if (!defined('TESTSUITE')) {
            set_error_handler(array($this, 'handleError'));
        }
        $this->error_reporting = error_reporting();
    }
    /**
     * Destructor
     *
     * stores errors in session
     *
     */
    public function __destruct()
    {
        if (isset($_SESSION)) {
            if (!isset($_SESSION['errors'])) {
                $_SESSION['errors'] = array();
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
                } else {
                    if ($error instanceof Error && !$error->isDisplayed()) {
                        $_SESSION['errors'][$key] = $error;
                    }
                }
            }
        }
    }
    /**
     * Toggles location hiding
     *
     * @param boolean $hide Whether to hide
     *
     * @return void
     */
    public function setHideLocation($hide)
    {
        $this->hide_location = $hide;
    }
    /**
     * returns array with all errors
     *
     * @param bool $check Whether to check for session errors
     *
     * @return Error[]
     */
    public function getErrors($check = true)
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
    public function getCurrentErrors()
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
    public function sliceErrors($count)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("sliceErrors") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/ErrorHandler.php at line 138")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called sliceErrors:138@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/ErrorHandler.php');
        die();
    }
    /**
     * Error handler - called when errors are triggered/occurred
     *
     * This calls the addError() function, escaping the error string
     * Ignores the errors wherever Error Control Operator (@) is used.
     *
     * @param integer $errno   error number
     * @param string  $errstr  error string
     * @param string  $errfile error file
     * @param integer $errline error line
     *
     * @return void
     */
    public function handleError($errno, $errstr, $errfile, $errline)
    {
        /**
         * Check if Error Control Operator (@) was used, but still show
         * user errors even in this case.
         */
        if (error_reporting() == 0 && $this->error_reporting != 0 && ($errno & (E_USER_WARNING | E_USER_ERROR | E_USER_NOTICE)) == 0) {
            return;
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
     * @param string  $errstr  error string
     * @param integer $errno   error number
     * @param string  $errfile error file
     * @param integer $errline error line
     * @param boolean $escape  whether to escape the error string
     *
     * @return void
     */
    public function addError($errstr, $errno, $errfile, $errline, $escape = true)
    {
        if ($escape) {
            $errstr = htmlspecialchars($errstr);
        }
        // create error object
        $error = new Error($errno, $errstr, $errfile, $errline);
        $error->setHideLocation($this->hide_location);
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
     * @param string  $errorInfo   error message
     * @param integer $errorNumber error number
     *
     * @return void
     */
    public function triggerError($errorInfo, $errorNumber = null)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("triggerError") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/ErrorHandler.php at line 247")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called triggerError:247@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/ErrorHandler.php');
        die();
    }
    /**
     * display fatal error and exit
     *
     * @param Error $error the error
     *
     * @return void
     */
    protected function dispFatalError($error)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("dispFatalError") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/ErrorHandler.php at line 259")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called dispFatalError:259@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/ErrorHandler.php');
        die();
    }
    /**
     * Displays user errors not displayed
     *
     * @return void
     */
    public function dispUserErrors()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("dispUserErrors") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/ErrorHandler.php at line 274")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called dispUserErrors:274@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/ErrorHandler.php');
        die();
    }
    /**
     * Renders user errors not displayed
     *
     * @return string
     */
    public function getDispUserErrors()
    {
        $retval = '';
        foreach ($this->getErrors() as $error) {
            if ($error->isUserError() && !$error->isDisplayed()) {
                $retval .= $error->getDisplay();
            }
        }
        return $retval;
    }
    /**
     * display HTML header
     *
     * @param Error $error the error
     *
     * @return void
     */
    protected function dispPageStart($error = null)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("dispPageStart") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/ErrorHandler.php at line 302")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called dispPageStart:302@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/ErrorHandler.php');
        die();
    }
    /**
     * display HTML footer
     *
     * @return void
     */
    protected function dispPageEnd()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("dispPageEnd") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/ErrorHandler.php at line 319")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called dispPageEnd:319@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/ErrorHandler.php');
        die();
    }
    /**
     * renders errors not displayed
     *
     * @return string
     */
    public function getDispErrors()
    {
        $retval = '';
        // display errors if SendErrorReports is set to 'ask'.
        if ($GLOBALS['cfg']['SendErrorReports'] != 'never') {
            foreach ($this->getErrors() as $error) {
                if (!$error->isDisplayed()) {
                    $retval .= $error->getDisplay();
                }
            }
        } else {
            $retval .= $this->getDispUserErrors();
        }
        // if preference is not 'never' and
        // there are 'actual' errors to be reported
        if ($GLOBALS['cfg']['SendErrorReports'] != 'never' && $this->countErrors() != $this->countUserErrors()) {
            // add report button.
            $retval .= '<form method="post" action="error_report.php"' . ' id="pma_report_errors_form"';
            if ($GLOBALS['cfg']['SendErrorReports'] == 'always') {
                // in case of 'always', generate 'invisible' form.
                $retval .= ' style="display:none;"';
            }
            $retval .= '>' . '<input type="hidden" name="token" value="' . $_SESSION[' PMA_token '] . '"/>' . '<input type="hidden" name="exception_type" value="php"/>' . '<input type="hidden" name="send_error_report" value="1" />' . '<input type="submit" value="' . __('Report') . '" id="pma_report_errors" class="floatright">' . '<input type="checkbox" name="always_send"' . ' id="always_send_checkbox" value="true"/>' . '<label for="always_send_checkbox">' . __('Automatically send report next time') . '</label>';
            if ($GLOBALS['cfg']['SendErrorReports'] == 'ask') {
                // add ignore buttons
                $retval .= '<input type="submit" value="' . __('Ignore') . '" id="pma_ignore_errors_bottom" class="floatright">';
            }
            $retval .= '<input type="submit" value="' . __('Ignore All') . '" id="pma_ignore_all_errors_bottom" class="floatright">';
            $retval .= '</form>';
        }
        return $retval;
    }
    /**
     * displays errors not displayed
     *
     * @return void
     */
    public function dispErrors()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("dispErrors") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/ErrorHandler.php at line 388")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called dispErrors:388@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/ErrorHandler.php');
        die();
    }
    /**
     * look in session for saved errors
     *
     * @return void
     */
    protected function checkSavedErrors()
    {
        if (isset($_SESSION['errors'])) {
            // restore saved errors
            foreach ($_SESSION['errors'] as $hash => $error) {
                if ($error instanceof Error && !isset($this->errors[$hash])) {
                    $this->errors[$hash] = $error;
                }
            }
            // delete stored errors
            $_SESSION['errors'] = array();
            unset($_SESSION['errors']);
        }
    }
    /**
     * return count of errors
     *
     * @param bool $check Whether to check for session errors
     *
     * @return integer number of errors occurred
     */
    public function countErrors($check = true)
    {
        return count($this->getErrors($check));
    }
    /**
     * return count of user errors
     *
     * @return integer number of user errors occurred
     */
    public function countUserErrors()
    {
        $count = 0;
        if ($this->countErrors()) {
            foreach ($this->getErrors() as $error) {
                if ($error->isUserError()) {
                    $count++;
                }
            }
        }
        return $count;
    }
    /**
     * whether use errors occurred or not
     *
     * @return boolean
     */
    public function hasUserErrors()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("hasUserErrors") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/ErrorHandler.php at line 451")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called hasUserErrors:451@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/ErrorHandler.php');
        die();
    }
    /**
     * whether errors occurred or not
     *
     * @return boolean
     */
    public function hasErrors()
    {
        return (bool) $this->countErrors();
    }
    /**
     * number of errors to be displayed
     *
     * @return integer number of errors to be displayed
     */
    public function countDisplayErrors()
    {
        if ($GLOBALS['cfg']['SendErrorReports'] != 'never') {
            return $this->countErrors();
        } else {
            return $this->countUserErrors();
        }
    }
    /**
     * whether there are errors to display or not
     *
     * @return boolean
     */
    public function hasDisplayErrors()
    {
        return (bool) $this->countDisplayErrors();
    }
    /**
     * Deletes previously stored errors in SESSION.
     * Saves current errors in session as previous errors.
     * Required to save current errors in case  'ask'
     *
     * @return void
     */
    public function savePreviousErrors()
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
     *@return boolean true if there are errors to be "prompted", false otherwise
     */
    public function hasErrorsForPrompt()
    {
        return $GLOBALS['cfg']['SendErrorReports'] != 'never' && $this->countErrors() != $this->countUserErrors();
    }
    /**
     * Function to report all the collected php errors.
     * Must be called at the end of each script
     *      by the $GLOBALS['error_handler'] only.
     *
     * @return void
     */
    public function reportErrors()
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
        if ($GLOBALS['cfg']['SendErrorReports'] == 'always') {
            if ($response->isAjax()) {
                // set flag for automatic report submission.
                $response->addJSON('_sendErrorAlways', '1');
            } else {
                // send the error reports asynchronously & without asking user
                $jsCode .= '$("#pma_report_errors_form").submit();' . 'PMA_ajaxShowMessage(
                            PMA_messages["phpErrorsBeingSubmitted"], false
                        );';
                // js code to appropriate focusing,
                $jsCode .= '$("html, body").animate({
                                scrollTop:$(document).height()
                            }, "slow");';
            }
        } elseif ($GLOBALS['cfg']['SendErrorReports'] == 'ask') {
            //ask user whether to submit errors or not.
            if (!$response->isAjax()) {
                // js code to show appropriate msgs, event binding & focusing.
                $jsCode = 'PMA_ajaxShowMessage(PMA_messages["phpErrorsFound"]);' . '$("#pma_ignore_errors_popup").bind("click", function() {
                            PMA_ignorePhpErrors()
                        });' . '$("#pma_ignore_all_errors_popup").bind("click",
                            function() {
                                PMA_ignorePhpErrors(false)
                            });' . '$("#pma_ignore_errors_bottom").bind("click", function(e) {
                            e.preventDefaulut();
                            PMA_ignorePhpErrors()
                        });' . '$("#pma_ignore_all_errors_bottom").bind("click",
                            function(e) {
                                e.preventDefault();
                                PMA_ignorePhpErrors(false)
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