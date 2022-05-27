<?php

namespace Amp\Internal;

/**
 * Formats a stacktrace obtained via `debug_backtrace()`.
 *
 * @param array<array{file?: string, line: int, type?: string, class: string, function: string}> $trace Output of
 *     `debug_backtrace()`.
 *
 * @return string Formatted stacktrace.
 *
 * @codeCoverageIgnore
 * @internal
 */
function formatStacktrace(array $trace) : string
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("formatStacktrace") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/amphp/amp/lib/Internal/functions.php at line 18")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called formatStacktrace:18@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/amphp/amp/lib/Internal/functions.php');
    die();
}
/**
 * Creates a `TypeError` with a standardized error message.
 *
 * @param string[] $expected Expected types.
 * @param mixed    $given Given value.
 *
 * @return \TypeError
 *
 * @internal
 */
function createTypeError(array $expected, $given) : \TypeError
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("createTypeError") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/amphp/amp/lib/Internal/functions.php at line 41")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called createTypeError:41@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/amphp/amp/lib/Internal/functions.php');
    die();
}
/**
 * Returns the current time relative to an arbitrary point in time.
 *
 * @return int Time in milliseconds.
 */
function getCurrentTime() : int
{
    /** @var int|null $startTime */
    static $startTime;
    /** @var int|null $nextWarning */
    static $nextWarning;
    if (\PHP_INT_SIZE === 4) {
        // @codeCoverageIgnoreStart
        if ($startTime === null) {
            $startTime = \PHP_VERSION_ID >= 70300 ? \hrtime(false)[0] : \time();
            $nextWarning = \PHP_INT_MAX - 86400 * 7;
        }
        if (\PHP_VERSION_ID >= 70300) {
            list($seconds, $nanoseconds) = \hrtime(false);
            $seconds -= $startTime;
            if ($seconds >= $nextWarning) {
                $timeToOverflow = (\PHP_INT_MAX - $seconds * 1000) / 1000;
                \trigger_error("getCurrentTime() will overflow in {$timeToOverflow} seconds, please restart the process before that. " . "You're using a 32 bit version of PHP, so time will overflow about every 24 days. Regular restarts are required.", \E_USER_WARNING);
                /** @psalm-suppress PossiblyNullOperand */
                $nextWarning += 600;
                // every 10 minutes
            }
            return (int) ($seconds * 1000 + $nanoseconds / 1000000);
        }
        $seconds = \microtime(true) - $startTime;
        if ($seconds >= $nextWarning) {
            $timeToOverflow = (\PHP_INT_MAX - $seconds * 1000) / 1000;
            \trigger_error("getCurrentTime() will overflow in {$timeToOverflow} seconds, please restart the process before that. " . "You're using a 32 bit version of PHP, so time will overflow about every 24 days. Regular restarts are required.", \E_USER_WARNING);
            /** @psalm-suppress PossiblyNullOperand */
            $nextWarning += 600;
            // every 10 minutes
        }
        return (int) ($seconds * 1000);
        // @codeCoverageIgnoreEnd
    }
    if (\PHP_VERSION_ID >= 70300) {
        list($seconds, $nanoseconds) = \hrtime(false);
        return (int) ($seconds * 1000 + $nanoseconds / 1000000);
    }
    return (int) (\microtime(true) * 1000);
}