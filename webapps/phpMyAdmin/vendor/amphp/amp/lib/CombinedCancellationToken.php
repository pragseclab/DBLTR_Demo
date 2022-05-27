<?php

namespace Amp;

final class CombinedCancellationToken implements CancellationToken
{
    /** @var array{0: CancellationToken, 1: string}[] */
    private $tokens = array();
    /** @var string */
    private $nextId = "a";
    /** @var callable[] */
    private $callbacks = array();
    /** @var CancelledException|null */
    private $exception;
    public function __construct(CancellationToken ...$tokens)
    {
        foreach ($tokens as $token) {
            $id = $token->subscribe(function (CancelledException $exception) {
                $this->exception = $exception;
                $callbacks = $this->callbacks;
                $this->callbacks = [];
                foreach ($callbacks as $callback) {
                    asyncCall($callback, $this->exception);
                }
            });
            $this->tokens[] = [$token, $id];
        }
    }
    public function __destruct()
    {
        $stop_coverage = false;
        if (function_exists('end_coverage_cav39s8hca')) {
            $stop_coverage = !xdebug_code_coverage_started();
            if (!xdebug_code_coverage_started()) {
                xdebug_start_code_coverage();
            }
        }
        foreach ($this->tokens as list($token, $id)) {
            /** @var CancellationToken $token */
            $token->unsubscribe($id);
        }
        if (function_exists('end_coverage_cav39s8hca')) {
            if ($stop_coverage) {
                end_coverage_cav39s8hca($stop_coverage);
            }
        }
    }
    /** @inheritdoc */
    public function subscribe(callable $callback) : string
    {
        $id = $this->nextId++;
        if ($this->exception) {
            asyncCall($callback, $this->exception);
        } else {
            $this->callbacks[$id] = $callback;
        }
        return $id;
    }
    /** @inheritdoc */
    public function unsubscribe(string $id)
    {
        unset($this->callbacks[$id]);
    }
    /** @inheritdoc */
    public function isRequested() : bool
    {
        foreach ($this->tokens as list($token)) {
            if ($token->isRequested()) {
                return true;
            }
        }
        return false;
    }
    /** @inheritdoc */
    public function throwIfRequested()
    {
        foreach ($this->tokens as list($token)) {
            $token->throwIfRequested();
        }
    }
}