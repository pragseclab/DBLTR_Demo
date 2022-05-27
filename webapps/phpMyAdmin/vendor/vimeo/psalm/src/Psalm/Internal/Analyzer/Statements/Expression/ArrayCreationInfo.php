<?php

namespace Psalm\Internal\Analyzer\Statements\Expression;

use Psalm\Type;
class ArrayCreationInfo
{
    /**
     * @var list<Type\Atomic>
     */
    public $item_key_atomic_types = array();
    /**
     * @var list<Type\Atomic>
     */
    public $item_value_atomic_types = array();
    /**
     * @var array<int|string, Type\Union>
     */
    public $property_types = array();
    /**
     * @var array<string, true>
     */
    public $class_strings = array();
    /**
     * @var bool
     */
    public $can_create_objectlike = true;
    /**
     * @var array<int|string, true>
     */
    public $array_keys = array();
    /**
     * @var int
     */
    public $int_offset_diff = 0;
    /**
     * @var bool
     */
    public $all_list = true;
    /**
     * @var array<string, \Psalm\Internal\DataFlow\DataFlowNode>
     */
    public $parent_taint_nodes = array();
}