<?php

namespace Psalm\Internal\Type;

use Psalm\Type\Atomic;
use Psalm\Type\Union;
/**
 * @internal
 */
class TypeCombination
{
    /** @var array<string, Atomic> */
    public $value_types = array();
    /** @var array<string, Atomic\TNamedObject>|null */
    public $named_object_types = array();
    /** @var list<Union> */
    public $array_type_params = array();
    /** @var array<string, non-empty-list<Union>> */
    public $builtin_type_params = array();
    /** @var array<string, non-empty-list<Union>> */
    public $object_type_params = array();
    /** @var array<string, bool> */
    public $object_static = array();
    /** @var array<int, bool>|null */
    public $array_counts = array();
    /** @var bool */
    public $array_sometimes_filled = false;
    /** @var bool */
    public $array_always_filled = true;
    /** @var array<string|int, Union> */
    public $objectlike_entries = array();
    /** @var array<string, bool> */
    public $objectlike_class_strings = array();
    /** @var bool */
    public $objectlike_sealed = true;
    /** @var ?Union */
    public $objectlike_key_type = null;
    /** @var ?Union */
    public $objectlike_value_type = null;
    /** @var bool */
    public $has_mixed = false;
    /** @var bool */
    public $empty_mixed = false;
    /** @var bool */
    public $non_empty_mixed = false;
    /** @var ?bool */
    public $mixed_from_loop_isset = null;
    /** @var array<string, Atomic\TLiteralString>|null */
    public $strings = array();
    /** @var array<string, Atomic\TLiteralInt>|null */
    public $ints = array();
    /** @var array<string, Atomic\TLiteralFloat>|null */
    public $floats = array();
    /** @var array<string, Atomic\TNamedObject|Atomic\TObject>|null */
    public $class_string_types = array();
    /**
     * @var array<string, Atomic\TNamedObject|Atomic\TTemplateParam|Atomic\TIterable|Atomic\TObject>|null
     */
    public $extra_types;
    /** @var ?bool */
    public $all_arrays_lists;
    /** @var ?bool */
    public $all_arrays_callable;
    /** @var ?bool */
    public $all_arrays_class_string_maps;
    /** @var array<string, bool> */
    public $class_string_map_names = array();
    /** @var array<string, ?Atomic\TNamedObject> */
    public $class_string_map_as_types = array();
}