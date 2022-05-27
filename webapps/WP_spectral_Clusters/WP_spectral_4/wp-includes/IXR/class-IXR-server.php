<?php

/**
 * IXR_Server
 *
 * @package IXR
 * @since 1.5.0
 */
class IXR_Server
{
    var $data;
    var $callbacks = array();
    var $message;
    var $capabilities;
    /**
     * PHP5 constructor.
     */
    function __construct($callbacks = false, $data = false, $wait = false)
    {
        $this->setCapabilities();
        if ($callbacks) {
            $this->callbacks = $callbacks;
        }
        $this->setCallbacks();
        if (!$wait) {
            $this->serve($data);
        }
    }
    /**
     * PHP4 constructor.
     */
    public function IXR_Server($callbacks = false, $data = false, $wait = false)
    {
        self::__construct($callbacks, $data, $wait);
    }
    function serve($data = false)
    {
        if (!$data) {
            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] !== 'POST') {
                if (function_exists('status_header')) {
                    status_header(405);
                    // WP #20986
                    header('Allow: POST');
                }
                header('Content-Type: text/plain');
                // merged from WP #9093
                die('XML-RPC server accepts POST requests only.');
            }
            $data = file_get_contents('php://input');
        }
        $this->message = new IXR_Message($data);
        if (!$this->message->parse()) {
            $this->error(-32700, 'parse error. not well formed');
        }
        if ($this->message->messageType != 'methodCall') {
            $this->error(-32600, 'server error. invalid xml-rpc. not conforming to spec. Request must be a methodCall');
        }
        $result = $this->call($this->message->methodName, $this->message->params);
        // Is the result an error?
        if (is_a($result, 'IXR_Error')) {
            $this->error($result);
        }
        // Encode the result
        $r = new IXR_Value($result);
        $resultxml = $r->getXml();
        // Create the XML
        $xml = <<<EOD
<methodResponse>
  <params>
    <param>
      <value>
      {$resultxml}
      </value>
    </param>
  </params>
</methodResponse>

EOD;
        // Send it
        $this->output($xml);
    }
    function call($methodname, $args)
    {
        if (!$this->hasMethod($methodname)) {
            return new IXR_Error(-32601, 'server error. requested method ' . $methodname . ' does not exist.');
        }
        $method = $this->callbacks[$methodname];
        // Perform the callback and send the response
        if (count($args) == 1) {
            // If only one parameter just send that instead of the whole array
            $args = $args[0];
        }
        // Are we dealing with a function or a method?
        if (is_string($method) && substr($method, 0, 5) == 'this:') {
            // It's a class method - check it exists
            $method = substr($method, 5);
            if (!method_exists($this, $method)) {
                return new IXR_Error(-32601, 'server error. requested class method "' . $method . '" does not exist.');
            }
            //Call the method
            $result = $this->{$method}($args);
        } else {
            // It's a function - does it exist?
            if (is_array($method)) {
                if (!is_callable(array($method[0], $method[1]))) {
                    return new IXR_Error(-32601, 'server error. requested object method "' . $method[1] . '" does not exist.');
                }
            } else {
                if (!function_exists($method)) {
                    return new IXR_Error(-32601, 'server error. requested function "' . $method . '" does not exist.');
                }
            }
            // Call the function
            $result = call_user_func($method, $args);
        }
        return $result;
    }
    function error($error, $message = false)
    {
        // Accepts either an error object or an error code and message
        if ($message && !is_object($error)) {
            $error = new IXR_Error($error, $message);
        }
        if (function_exists('status_header')) {
            status_header($error->code);
        }
        $this->output($error->getXml());
    }
    function output($xml)
    {
        $charset = function_exists('get_option') ? get_option('blog_charset') : '';
        if ($charset) {
            $xml = '<?xml version="1.0" encoding="' . $charset . '"?>' . "\n" . $xml;
        } else {
            $xml = '<?xml version="1.0"?>' . "\n" . $xml;
        }
        $length = strlen($xml);
        header('Connection: close');
        if ($charset) {
            header('Content-Type: text/xml; charset=' . $charset);
        } else {
            header('Content-Type: text/xml');
        }
        header('Date: ' . gmdate('r'));
        echo $xml;
        exit;
    }
    function hasMethod($method)
    {
        return in_array($method, array_keys($this->callbacks));
    }
    function setCapabilities()
    {
        // Initialises capabilities array
        $this->capabilities = array('xmlrpc' => array('specUrl' => 'http://www.xmlrpc.com/spec', 'specVersion' => 1), 'faults_interop' => array('specUrl' => 'http://xmlrpc-epi.sourceforge.net/specs/rfc.fault_codes.php', 'specVersion' => 20010516), 'system.multicall' => array('specUrl' => 'http://www.xmlrpc.com/discuss/msgReader$1208', 'specVersion' => 1));
    }
    function getCapabilities($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getCapabilities") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/IXR/class-IXR-server.php at line 159")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getCapabilities:159@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/IXR/class-IXR-server.php');
        die();
    }
    function setCallbacks()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("setCallbacks") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/IXR/class-IXR-server.php at line 163")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called setCallbacks:163@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/IXR/class-IXR-server.php');
        die();
    }
    function listMethods($args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("listMethods") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/IXR/class-IXR-server.php at line 171")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called listMethods:171@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/IXR/class-IXR-server.php');
        die();
    }
    function multiCall($methodcalls)
    {
        // See http://www.xmlrpc.com/discuss/msgReader$1208
        $return = array();
        foreach ($methodcalls as $call) {
            $method = $call['methodName'];
            $params = $call['params'];
            if ($method == 'system.multicall') {
                $result = new IXR_Error(-32600, 'Recursive calls to system.multicall are forbidden');
            } else {
                $result = $this->call($method, $params);
            }
            if (is_a($result, 'IXR_Error')) {
                $return[] = array('faultCode' => $result->code, 'faultString' => $result->message);
            } else {
                $return[] = array($result);
            }
        }
        return $return;
    }
}