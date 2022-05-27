<?php

namespace Amp;

use React\Promise\PromiseInterface as ReactPromise;
/**
 * Returns a new function that wraps $callback in a promise/coroutine-aware function that automatically runs
 * Generators as coroutines. The returned function always returns a promise when invoked. Errors have to be handled
 * by the callback caller or they will go unnoticed.
 *
 * Use this function to create a coroutine-aware callable for a promise-aware callback caller.
 *
 * @template TReturn
 * @template TPromise
 * @template TGeneratorReturn
 * @template TGeneratorPromise
 *
 * @template TGenerator as TGeneratorReturn|Promise<TGeneratorPromise>
 * @template T as TReturn|Promise<TPromise>|\Generator<mixed, mixed, mixed, TGenerator>
 *
 * @formatter:off
 *
 * @param callable(...mixed): T $callback
 *
 * @return callable
 * @psalm-return (T is Promise ? (callable(mixed...): Promise<TPromise>) : (T is \Generator ? (TGenerator is Promise ? (callable(mixed...): Promise<TGeneratorPromise>) : (callable(mixed...): Promise<TGeneratorReturn>)) : (callable(mixed...): Promise<TReturn>)))
 *
 * @formatter:on
 *
 * @see asyncCoroutine()
 *
 * @psalm-suppress InvalidReturnType
 */
function coroutine(callable $callback) : callable
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("coroutine") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/amphp/amp/lib/functions.php at line 37")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called coroutine:37@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/amphp/amp/lib/functions.php');
    die();
}
/**
 * Returns a new function that wraps $callback in a promise/coroutine-aware function that automatically runs
 * Generators as coroutines. The returned function always returns void when invoked. Errors are forwarded to the
 * loop's error handler using `Amp\Promise\rethrow()`.
 *
 * Use this function to create a coroutine-aware callable for a non-promise-aware callback caller.
 *
 * @param callable(...mixed): mixed $callback
 *
 * @return callable
 * @psalm-return callable(mixed...): void
 *
 * @see coroutine()
 */
function asyncCoroutine(callable $callback) : callable
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("asyncCoroutine") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/amphp/amp/lib/functions.php at line 57")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called asyncCoroutine:57@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/amphp/amp/lib/functions.php');
    die();
}
/**
 * Calls the given function, always returning a promise. If the function returns a Generator, it will be run as a
 * coroutine. If the function throws, a failed promise will be returned.
 *
 * @template TReturn
 * @template TPromise
 * @template TGeneratorReturn
 * @template TGeneratorPromise
 *
 * @template TGenerator as TGeneratorReturn|Promise<TGeneratorPromise>
 * @template T as TReturn|Promise<TPromise>|\Generator<mixed, mixed, mixed, TGenerator>
 *
 * @formatter:off
 *
 * @param callable(...mixed): T $callback
 * @param mixed ...$args Arguments to pass to the function.
 *
 * @return Promise
 * @psalm-return (T is Promise ? Promise<TPromise> : (T is \Generator ? (TGenerator is Promise ? Promise<TGeneratorPromise> : Promise<TGeneratorReturn>) : Promise<TReturn>))
 *
 * @formatter:on
 */
function call(callable $callback, ...$args) : Promise
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("call") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/amphp/amp/lib/functions.php at line 85")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called call:85@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/amphp/amp/lib/functions.php');
    die();
}
/**
 * Calls the given function. If the function returns a Generator, it will be run as a coroutine. If the function
 * throws or returns a failing promise, the failure is forwarded to the loop error handler.
 *
 * @param callable(...mixed): mixed $callback
 * @param mixed ...$args Arguments to pass to the function.
 *
 * @return void
 */
function asyncCall(callable $callback, ...$args)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("asyncCall") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/amphp/amp/lib/functions.php at line 112")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called asyncCall:112@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/amphp/amp/lib/functions.php');
    die();
}
/**
 * Sleeps for the specified number of milliseconds.
 *
 * @param int $milliseconds
 *
 * @return Delayed
 */
function delay(int $milliseconds) : Delayed
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("delay") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/amphp/amp/lib/functions.php at line 123")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called delay:123@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/amphp/amp/lib/functions.php');
    die();
}
/**
 * Returns the current time relative to an arbitrary point in time.
 *
 * @return int Time in milliseconds.
 */
function getCurrentTime() : int
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getCurrentTime") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/amphp/amp/lib/functions.php at line 132")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called getCurrentTime:132@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/amphp/amp/lib/functions.php');
    die();
}
namespace Amp\Promise;

use Amp\Deferred;
use Amp\Loop;
use Amp\MultiReasonException;
use Amp\Promise;
use Amp\Success;
use Amp\TimeoutException;
use React\Promise\PromiseInterface as ReactPromise;
use function Amp\call;
use function Amp\Internal\createTypeError;
/**
 * Registers a callback that will forward the failure reason to the event loop's error handler if the promise fails.
 *
 * Use this function if you neither return the promise nor handle a possible error yourself to prevent errors from
 * going entirely unnoticed.
 *
 * @param Promise|ReactPromise $promise Promise to register the handler on.
 *
 * @return void
 * @throws \TypeError If $promise is not an instance of \Amp\Promise or \React\Promise\PromiseInterface.
 *
 */
function rethrow($promise)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("rethrow") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/amphp/amp/lib/functions.php at line 159")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called rethrow:159@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/amphp/amp/lib/functions.php');
    die();
}
/**
 * Runs the event loop until the promise is resolved. Should not be called within a running event loop.
 *
 * Use this function only in synchronous contexts to wait for an asynchronous operation. Use coroutines and yield to
 * await promise resolution in a fully asynchronous application instead.
 *
 * @template TPromise
 * @template T as Promise<TPromise>|ReactPromise
 *
 * @param Promise|ReactPromise $promise Promise to wait for.
 *
 * @return mixed Promise success value.
 *
 * @psalm-param T $promise
 * @psalm-return (T is Promise ? TPromise : mixed)
 *
 * @throws \TypeError If $promise is not an instance of \Amp\Promise or \React\Promise\PromiseInterface.
 * @throws \Error If the event loop stopped without the $promise being resolved.
 * @throws \Throwable Promise failure reason.
 */
function wait($promise)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wait") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/amphp/amp/lib/functions.php at line 194")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wait:194@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/amphp/amp/lib/functions.php');
    die();
}
/**
 * Creates an artificial timeout for any `Promise`.
 *
 * If the timeout expires before the promise is resolved, the returned promise fails with an instance of
 * `Amp\TimeoutException`.
 *
 * @template TReturn
 *
 * @param Promise<TReturn>|ReactPromise $promise Promise to which the timeout is applied.
 * @param int                           $timeout Timeout in milliseconds.
 *
 * @return Promise<TReturn>
 *
 * @throws \TypeError If $promise is not an instance of \Amp\Promise or \React\Promise\PromiseInterface.
 */
function timeout($promise, int $timeout) : Promise
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("timeout") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/amphp/amp/lib/functions.php at line 239")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called timeout:239@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/amphp/amp/lib/functions.php');
    die();
}
/**
 * Creates an artificial timeout for any `Promise`.
 *
 * If the promise is resolved before the timeout expires, the result is returned
 *
 * If the timeout expires before the promise is resolved, a default value is returned
 *
 * @template TReturn
 *
 * @param Promise<TReturn>|ReactPromise $promise Promise to which the timeout is applied.
 * @param int                           $timeout Timeout in milliseconds.
 * @param TReturn                       $default
 *
 * @return Promise<TReturn>
 *
 * @throws \TypeError If $promise is not an instance of \Amp\Promise or \React\Promise\PromiseInterface.
 */
function timeoutWithDefault($promise, int $timeout, $default = null) : Promise
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("timeoutWithDefault") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/amphp/amp/lib/functions.php at line 281")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called timeoutWithDefault:281@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/amphp/amp/lib/functions.php');
    die();
}
/**
 * Adapts any object with a done(callable $onFulfilled, callable $onRejected) or then(callable $onFulfilled,
 * callable $onRejected) method to a promise usable by components depending on placeholders implementing
 * \AsyncInterop\Promise.
 *
 * @param object $promise Object with a done() or then() method.
 *
 * @return Promise Promise resolved by the $thenable object.
 *
 * @throws \Error If the provided object does not have a then() method.
 */
function adapt($promise) : Promise
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("adapt") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/amphp/amp/lib/functions.php at line 303")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called adapt:303@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/amphp/amp/lib/functions.php');
    die();
}
/**
 * Returns a promise that is resolved when all promises are resolved. The returned promise will not fail.
 * Returned promise succeeds with a two-item array delineating successful and failed promise results,
 * with keys identical and corresponding to the original given array.
 *
 * This function is the same as some() with the notable exception that it will never fail even
 * if all promises in the array resolve unsuccessfully.
 *
 * @template TValue
 *
 * @param Promise<TValue>[]|ReactPromise[] $promises
 *
 * @return Promise<array{0: \Throwable[], 1: TValue[]}>
 *
 * @throws \Error If a non-Promise is in the array.
 */
function any(array $promises) : Promise
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("any") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/amphp/amp/lib/functions.php at line 331")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called any:331@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/amphp/amp/lib/functions.php');
    die();
}
/**
 * Returns a promise that succeeds when all promises succeed, and fails if any promise fails. Returned
 * promise succeeds with an array of values used to succeed each contained promise, with keys corresponding to
 * the array of promises.
 *
 * @param Promise[]|ReactPromise[] $promises Array of only promises.
 *
 * @return Promise
 *
 * @throws \Error If a non-Promise is in the array.
 *
 * @template TValue
 *
 * @psalm-param array<array-key, Promise<TValue>|ReactPromise> $promises
 * @psalm-assert array<array-key, Promise<TValue>|ReactPromise> $promises $promises
 * @psalm-return Promise<array<array-key, TValue>>
 */
function all(array $promises) : Promise
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("all") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/amphp/amp/lib/functions.php at line 352")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called all:352@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/amphp/amp/lib/functions.php');
    die();
}
/**
 * Returns a promise that succeeds when the first promise succeeds, and fails only if all promises fail.
 *
 * @template TValue
 *
 * @param Promise<TValue>[]|ReactPromise[] $promises Array of only promises.
 *
 * @return Promise<TValue>
 *
 * @throws \Error If the array is empty or a non-Promise is in the array.
 */
function first(array $promises) : Promise
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("first") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/amphp/amp/lib/functions.php at line 398")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called first:398@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/amphp/amp/lib/functions.php');
    die();
}
/**
 * Resolves with a two-item array delineating successful and failed Promise results.
 *
 * The returned promise will only fail if the given number of required promises fail.
 * 
 * @template TValue
 *
 * @param Promise<TValue>[]|ReactPromise[] $promises Array of only promises.
 * @param int                              $required Number of promises that must succeed for the
 *     returned promise to succeed.
 *
 * @return Promise<array{0: \Throwable[], 1: TValue[]}>
 *
 * @throws \Error If a non-Promise is in the array.
 */
function some(array $promises, int $required = 1) : Promise
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("some") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/amphp/amp/lib/functions.php at line 448")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called some:448@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/amphp/amp/lib/functions.php');
    die();
}
/**
 * Wraps a promise into another promise, altering the exception or result.
 *
 * @param Promise|ReactPromise $promise
 * @param callable             $callback
 *
 * @return Promise
 */
function wrap($promise, callable $callback) : Promise
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wrap") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/amphp/amp/lib/functions.php at line 499")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wrap:499@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/amphp/amp/lib/functions.php');
    die();
}
namespace Amp\Iterator;

use Amp\Delayed;
use Amp\Emitter;
use Amp\Iterator;
use Amp\Producer;
use Amp\Promise;
use function Amp\call;
use function Amp\coroutine;
use function Amp\Internal\createTypeError;
/**
 * Creates an iterator from the given iterable, emitting the each value. The iterable may contain promises. If any
 * promise fails, the iterator will fail with the same reason.
 *
 * @param array|\Traversable $iterable Elements to emit.
 * @param int                $delay Delay between element emissions in milliseconds.
 *
 * @return Iterator
 *
 * @throws \TypeError If the argument is not an array or instance of \Traversable.
 */
function fromIterable($iterable, int $delay = 0) : Iterator
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("fromIterable") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/amphp/amp/lib/functions.php at line 539")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called fromIterable:539@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/amphp/amp/lib/functions.php');
    die();
}
/**
 * @template TValue
 * @template TReturn
 *
 * @param Iterator<TValue> $iterator
 * @param callable (TValue $value): TReturn $onEmit
 *
 * @return Iterator<TReturn>
 */
function map(Iterator $iterator, callable $onEmit) : Iterator
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("map") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/amphp/amp/lib/functions.php at line 567")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called map:567@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/amphp/amp/lib/functions.php');
    die();
}
/**
 * @template TValue
 *
 * @param Iterator<TValue> $iterator
 * @param callable(TValue $value):bool $filter
 *
 * @return Iterator<TValue>
 */
function filter(Iterator $iterator, callable $filter) : Iterator
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("filter") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/amphp/amp/lib/functions.php at line 583")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called filter:583@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/amphp/amp/lib/functions.php');
    die();
}
/**
 * Creates an iterator that emits values emitted from any iterator in the array of iterators.
 *
 * @param Iterator[] $iterators
 *
 * @return Iterator
 */
function merge(array $iterators) : Iterator
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("merge") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/amphp/amp/lib/functions.php at line 600")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called merge:600@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/amphp/amp/lib/functions.php');
    die();
}
/**
 * Concatenates the given iterators into a single iterator, emitting values from a single iterator at a time. The
 * prior iterator must complete before values are emitted from any subsequent iterators. Iterators are concatenated
 * in the order given (iteration order of the array).
 *
 * @param Iterator[] $iterators
 *
 * @return Iterator
 */
function concat(array $iterators) : Iterator
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("concat") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/amphp/amp/lib/functions.php at line 635")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called concat:635@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/amphp/amp/lib/functions.php');
    die();
}
/**
 * Discards all remaining items and returns the number of discarded items.
 *
 * @template TValue
 *
 * @param Iterator $iterator
 *
 * @return Promise
 *
 * @psalm-param Iterator<TValue> $iterator
 * @psalm-return Promise<int>
 */
function discard(Iterator $iterator) : Promise
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("discard") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/amphp/amp/lib/functions.php at line 692")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called discard:692@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/amphp/amp/lib/functions.php');
    die();
}
/**
 * Collects all items from an iterator into an array.
 *
 * @template TValue
 *
 * @param Iterator $iterator
 *
 * @psalm-param Iterator<TValue> $iterator
 *
 * @return Promise
 * @psalm-return Promise<array<array-key, TValue>>
 */
function toArray(Iterator $iterator) : Promise
{
    return call(static function () use($iterator) {
        /** @psalm-var list $array */
        $array = [];
        while ((yield $iterator->advance())) {
            $array[] = $iterator->getCurrent();
        }
        return $array;
    });
}