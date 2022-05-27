<?php

namespace Amp;

use function Amp\Internal\formatStacktrace;
/**
 * A TimeoutCancellationToken automatically requests cancellation after the timeout has elapsed.
 */
final class TimeoutCancellationToken implements CancellationToken
{
    /** @var string */
    private $watcher;
    /** @var CancellationToken */
    private $token;
    /**
     * @param int    $timeout Milliseconds until cancellation is requested.
     * @param string $message Message for TimeoutException. Default is "Operation timed out".
     */
    public function __construct(int $timeout, string $message = "Operation timed out")
    {
        $source = new CancellationTokenSource();
        $this->token = $source->getToken();
        $trace = \debug_backtrace(\DEBUG_BACKTRACE_IGNORE_ARGS);
        $this->watcher = Loop::delay($timeout, static function () use($source, $message, $trace) {
            $trace = formatStacktrace($trace);
            $source->cancel(new TimeoutException("{$message}\r\nTimeoutCancellationToken was created here:\r\n{$trace}"));
        });
        Loop::unreference($this->watcher);
    }
    /**
     * Cancels the delay watcher.
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
        Loop::cancel($this->watcher);
        if (function_exists('end_coverage_cav39s8hca')) {
            if ($stop_coverage) {
                end_coverage_cav39s8hca($stop_coverage);
            }
        }
    }
    /**
     * {@inheritdoc}
     */
    public function subscribe(callable $callback) : string
    {
        return $this->token->subscribe($callback);
    }
    /**
     * {@inheritdoc}
     */
    public function unsubscribe(string $id)
    {
        $this->token->unsubscribe($id);
    }
    /**
     * {@inheritdoc}
     */
    public function isRequested() : bool
    {
        return $this->token->isRequested();
    }
    /**
     * {@inheritdoc}
     */
    public function throwIfRequested()
    {
        $this->token->throwIfRequested();
    }
}