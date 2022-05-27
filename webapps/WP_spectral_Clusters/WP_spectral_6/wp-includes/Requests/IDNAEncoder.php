<?php

/**
 * IDNA URL encoder
 *
 * Note: Not fully compliant, as nameprep does nothing yet.
 *
 * @package Requests
 * @subpackage Utilities
 * @see https://tools.ietf.org/html/rfc3490 IDNA specification
 * @see https://tools.ietf.org/html/rfc3492 Punycode/Bootstrap specification
 */
class Requests_IDNAEncoder
{
    /**
     * ACE prefix used for IDNA
     *
     * @see https://tools.ietf.org/html/rfc3490#section-5
     * @var string
     */
    const ACE_PREFIX = 'xn--';
    /**#@+
     * Bootstrap constant for Punycode
     *
     * @see https://tools.ietf.org/html/rfc3492#section-5
     * @var int
     */
    const BOOTSTRAP_BASE = 36;
    const BOOTSTRAP_TMIN = 1;
    const BOOTSTRAP_TMAX = 26;
    const BOOTSTRAP_SKEW = 38;
    const BOOTSTRAP_DAMP = 700;
    const BOOTSTRAP_INITIAL_BIAS = 72;
    const BOOTSTRAP_INITIAL_N = 128;
    /**#@-*/
    /**
     * Encode a hostname using Punycode
     *
     * @param string $string Hostname
     * @return string Punycode-encoded hostname
     */
    public static function encode($string)
    {
        $parts = explode('.', $string);
        foreach ($parts as &$part) {
            $part = self::to_ascii($part);
        }
        return implode('.', $parts);
    }
    /**
     * Convert a UTF-8 string to an ASCII string using Punycode
     *
     * @throws Requests_Exception Provided string longer than 64 ASCII characters (`idna.provided_too_long`)
     * @throws Requests_Exception Prepared string longer than 64 ASCII characters (`idna.prepared_too_long`)
     * @throws Requests_Exception Provided string already begins with xn-- (`idna.provided_is_prefixed`)
     * @throws Requests_Exception Encoded string longer than 64 ASCII characters (`idna.encoded_too_long`)
     *
     * @param string $string ASCII or UTF-8 string (max length 64 characters)
     * @return string ASCII string
     */
    public static function to_ascii($string)
    {
        // Step 1: Check if the string is already ASCII
        if (self::is_ascii($string)) {
            // Skip to step 7
            if (strlen($string) < 64) {
                return $string;
            }
            throw new Requests_Exception('Provided string is too long', 'idna.provided_too_long', $string);
        }
        // Step 2: nameprep
        $string = self::nameprep($string);
        // Step 3: UseSTD3ASCIIRules is false, continue
        // Step 4: Check if it's ASCII now
        if (self::is_ascii($string)) {
            // Skip to step 7
            if (strlen($string) < 64) {
                return $string;
            }
            throw new Requests_Exception('Prepared string is too long', 'idna.prepared_too_long', $string);
        }
        // Step 5: Check ACE prefix
        if (strpos($string, self::ACE_PREFIX) === 0) {
            throw new Requests_Exception('Provided string begins with ACE prefix', 'idna.provided_is_prefixed', $string);
        }
        // Step 6: Encode with Punycode
        $string = self::punycode_encode($string);
        // Step 7: Prepend ACE prefix
        $string = self::ACE_PREFIX . $string;
        // Step 8: Check size
        if (strlen($string) < 64) {
            return $string;
        }
        throw new Requests_Exception('Encoded string is too long', 'idna.encoded_too_long', $string);
    }
    /**
     * Check whether a given string contains only ASCII characters
     *
     * @internal (Testing found regex was the fastest implementation)
     *
     * @param string $string
     * @return bool Is the string ASCII-only?
     */
    protected static function is_ascii($string)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("is_ascii") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/Requests/IDNAEncoder.php at line 106")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called is_ascii:106@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/Requests/IDNAEncoder.php');
        die();
    }
    /**
     * Prepare a string for use as an IDNA name
     *
     * @todo Implement this based on RFC 3491 and the newer 5891
     * @param string $string
     * @return string Prepared string
     */
    protected static function nameprep($string)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("nameprep") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/Requests/IDNAEncoder.php at line 117")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called nameprep:117@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/Requests/IDNAEncoder.php');
        die();
    }
    /**
     * Convert a UTF-8 string to a UCS-4 codepoint array
     *
     * Based on Requests_IRI::replace_invalid_with_pct_encoding()
     *
     * @throws Requests_Exception Invalid UTF-8 codepoint (`idna.invalidcodepoint`)
     * @param string $input
     * @return array Unicode code points
     */
    protected static function utf8_to_codepoints($input)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("utf8_to_codepoints") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/Requests/IDNAEncoder.php at line 130")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called utf8_to_codepoints:130@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/Requests/IDNAEncoder.php');
        die();
    }
    /**
     * RFC3492-compliant encoder
     *
     * @internal Pseudo-code from Section 6.3 is commented with "#" next to relevant code
     * @throws Requests_Exception On character outside of the domain (never happens with Punycode) (`idna.character_outside_domain`)
     *
     * @param string $input UTF-8 encoded string to encode
     * @return string Punycode-encoded string
     */
    public static function punycode_encode($input)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("punycode_encode") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/Requests/IDNAEncoder.php at line 187")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called punycode_encode:187@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/Requests/IDNAEncoder.php');
        die();
    }
    /**
     * Convert a digit to its respective character
     *
     * @see https://tools.ietf.org/html/rfc3492#section-5
     * @throws Requests_Exception On invalid digit (`idna.invalid_digit`)
     *
     * @param int $digit Digit in the range 0-35
     * @return string Single character corresponding to digit
     */
    protected static function digit_to_char($digit)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("digit_to_char") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/Requests/IDNAEncoder.php at line 292")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called digit_to_char:292@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/Requests/IDNAEncoder.php');
        die();
    }
    /**
     * Adapt the bias
     *
     * @see https://tools.ietf.org/html/rfc3492#section-6.1
     * @param int $delta
     * @param int $numpoints
     * @param bool $firsttime
     * @return int New bias
     */
    protected static function adapt($delta, $numpoints, $firsttime)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("adapt") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/Requests/IDNAEncoder.php at line 312")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called adapt:312@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/Requests/IDNAEncoder.php');
        die();
    }
}