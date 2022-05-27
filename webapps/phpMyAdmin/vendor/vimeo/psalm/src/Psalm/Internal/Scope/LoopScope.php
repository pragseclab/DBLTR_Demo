<?php

namespace Psalm\Internal\Scope;

use Psalm\Context;
use Psalm\Type;
/**
 * @internal
 */
class LoopScope
{
    /**
     * @var int
     */
    public $iteration_count = 0;
    /**
     * @var Context
     */
    public $loop_context;
    /**
     * @var Context
     */
    public $loop_parent_context;
    /**
     * @var array<string, Type\Union>|null
     */
    public $redefined_loop_vars = array();
    /**
     * @var array<string, Type\Union>
     */
    public $possibly_redefined_loop_vars = array();
    /**
     * @var array<string, Type\Union>|null
     */
    public $possibly_redefined_loop_parent_vars = null;
    /**
     * @var array<string, Type\Union>
     */
    public $possibly_defined_loop_parent_vars = array();
    /**
     * @var array<string, bool>
     */
    public $vars_possibly_in_scope = array();
    /**
     * @var array<string, bool>
     */
    public $protected_var_ids = array();
    /**
     * @var string[]
     */
    public $final_actions = array();
    public function __construct(Context $loop_context, Context $parent_context)
    {
        $this->loop_context = $loop_context;
        $this->loop_parent_context = $parent_context;
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
        $this->loop_context = null;
        $this->loop_parent_context = null;
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