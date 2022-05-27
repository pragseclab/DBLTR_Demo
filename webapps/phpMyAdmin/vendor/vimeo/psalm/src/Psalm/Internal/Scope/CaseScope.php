<?php

namespace Psalm\Internal\Scope;

use Psalm\Context;
use Psalm\Type;
/**
 * @internal
 */
class CaseScope
{
    /**
     * @var Context
     */
    public $parent_context;
    /**
     * @var array<string, Type\Union>|null
     */
    public $break_vars;
    public function __construct(Context $parent_context)
    {
        $this->parent_context = $parent_context;
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
        $stop_coverage = false;
        if (function_exists('end_coverage_cav39s8hca')) {
            $stop_coverage = !xdebug_code_coverage_started();
            if (!xdebug_code_coverage_started()) {
                xdebug_start_code_coverage();
            }
        }
        $stop_coverage = false;
        if (function_exists('end_coverage_cav39s8hca')) {
            $stop_coverage = !xdebug_code_coverage_started();
            if (!xdebug_code_coverage_started()) {
                xdebug_start_code_coverage();
            }
        }
        $this->parent_context = null;
        if (function_exists('end_coverage_cav39s8hca')) {
            if ($stop_coverage) {
                end_coverage_cav39s8hca($stop_coverage);
            }
        }
        if (function_exists('end_coverage_cav39s8hca')) {
            if ($stop_coverage) {
                end_coverage_cav39s8hca($stop_coverage);
            }
        }
        if (function_exists('end_coverage_cav39s8hca')) {
            if ($stop_coverage) {
                end_coverage_cav39s8hca($stop_coverage);
            }
        }
    }
}