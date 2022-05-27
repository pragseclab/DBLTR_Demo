<?php

namespace Psalm\Storage;

use Psalm\CodeLocation;
use Psalm\Internal\MethodIdentifier;
use Psalm\Type;
class ClassLikeStorage
{
    use CustomMetadataTrait;
    /**
     * @var array<string, ClassConstantStorage>
     */
    public $constants = array();
    /**
     * Aliases to help Psalm understand constant refs
     *
     * @var ?\Psalm\Aliases
     */
    public $aliases;
    /**
     * @var bool
     */
    public $populated = false;
    /**
     * @var bool
     */
    public $stubbed = false;
    /**
     * @var bool
     */
    public $deprecated = false;
    /**
     * @var string
     */
    public $internal = '';
    /**
     * @var null|Type\Atomic\TTemplateParam|Type\Atomic\TNamedObject
     * @deprecated
     */
    public $mixin = null;
    /**
     * @var Type\Atomic\TTemplateParam[]
     */
    public $templatedMixins = array();
    /**
     * @var list<Type\Atomic\TNamedObject>
     */
    public $namedMixins = array();
    /**
     * @var ?string
     */
    public $mixin_declaring_fqcln = null;
    /**
     * @var bool
     */
    public $sealed_properties = false;
    /**
     * @var bool
     */
    public $sealed_methods = false;
    /**
     * @var bool
     */
    public $override_property_visibility = false;
    /**
     * @var bool
     */
    public $override_method_visibility = false;
    /**
     * @var array<int, string>
     */
    public $suppressed_issues = array();
    /**
     * @var string
     */
    public $name;
    /**
     * Is this class user-defined
     *
     * @var bool
     */
    public $user_defined = false;
    /**
     * Interfaces this class implements directly
     *
     * @var array<lowercase-string, string>
     */
    public $direct_class_interfaces = array();
    /**
     * Interfaces this class implements explicitly and implicitly
     *
     * @var array<lowercase-string, string>
     */
    public $class_implements = array();
    /**
     * Parent interfaces listed explicitly
     *
     * @var array<lowercase-string, string>
     */
    public $direct_interface_parents = array();
    /**
     * Parent interfaces
     *
     * @var  array<lowercase-string, string>
     */
    public $parent_interfaces = array();
    /**
     * There can only be one direct parent class
     *
     * @var ?string
     */
    public $parent_class;
    /**
     * Parent classes
     *
     * @var array<lowercase-string, string>
     */
    public $parent_classes = array();
    /**
     * @var CodeLocation|null
     */
    public $location;
    /**
     * @var CodeLocation|null
     */
    public $stmt_location;
    /**
     * @var CodeLocation|null
     */
    public $namespace_name_location;
    /**
     * @var bool
     */
    public $abstract = false;
    /**
     * @var bool
     */
    public $final = false;
    /**
     * @var bool
     */
    public $final_from_docblock = false;
    /**
     * @var array<lowercase-string, string>
     */
    public $used_traits = array();
    /**
     * @var array<lowercase-string, lowercase-string>
     */
    public $trait_alias_map = array();
    /**
     * @var array<lowercase-string, bool>
     */
    public $trait_final_map = array();
    /**
     * @var array<string, int>
     */
    public $trait_visibility_map = array();
    /**
     * @var bool
     */
    public $is_trait = false;
    /**
     * @var bool
     */
    public $is_interface = false;
    /**
     * @var bool
     */
    public $external_mutation_free = false;
    /**
     * @var bool
     */
    public $mutation_free = false;
    /**
     * @var bool
     */
    public $specialize_instance = false;
    /**
     * @var array<lowercase-string, MethodStorage>
     */
    public $methods = array();
    /**
     * @var array<lowercase-string, MethodStorage>
     */
    public $pseudo_methods = array();
    /**
     * @var array<lowercase-string, MethodStorage>
     */
    public $pseudo_static_methods = array();
    /**
     * @var array<lowercase-string, MethodIdentifier>
     */
    public $declaring_method_ids = array();
    /**
     * @var array<lowercase-string, MethodIdentifier>
     */
    public $appearing_method_ids = array();
    /**
     * @var array<lowercase-string, array<string, MethodIdentifier>>
     */
    public $overridden_method_ids = array();
    /**
     * @var array<lowercase-string, MethodIdentifier>
     */
    public $documenting_method_ids = array();
    /**
     * @var array<lowercase-string, MethodIdentifier>
     */
    public $inheritable_method_ids = array();
    /**
     * @var array<lowercase-string, array<string, bool>>
     */
    public $potential_declaring_method_ids = array();
    /**
     * @var array<string, PropertyStorage>
     */
    public $properties = array();
    /**
     * @var array<string, Type\Union>
     */
    public $pseudo_property_set_types = array();
    /**
     * @var array<string, Type\Union>
     */
    public $pseudo_property_get_types = array();
    /**
     * @var array<string, string>
     */
    public $declaring_property_ids = array();
    /**
     * @var array<string, string>
     */
    public $appearing_property_ids = array();
    /**
     * @var array<string, string>
     */
    public $inheritable_property_ids = array();
    /**
     * @var array<string, array<string>>
     */
    public $overridden_property_ids = array();
    /**
     * An array holding the class template "as" types.
     *
     * It's the de-facto list of all templates on a given class.
     *
     * The name of the template is the first key. The nested array is keyed by the defining class
     * (i.e. the same as the class name). This allows operations with the same-named template defined
     * across multiple classes to not run into trouble.
     *
     * @var array<string, non-empty-array<string, Type\Union>>|null
     */
    public $template_types;
    /**
     * @var array<int, bool>|null
     */
    public $template_covariants;
    /**
     * A map of which generic classlikes are extended or implemented by this class or interface.
     *
     * This is only used in the populator, which poulates the $template_extended_params property below.
     *
     * @internal
     *
     * @var array<string, non-empty-array<int, Type\Union>>|null
     */
    public $template_extended_offsets;
    /**
     * A map of which generic classlikes are extended or implemented by this class or interface.
     *
     * The annotation "@extends Traversable<SomeClass, SomeOtherClass>" would generate an entry of
     *
     * [
     *     "Traversable" => [
     *         "TKey" => new Union([new TNamedObject("SomeClass")]),
     *         "TValue" => new Union([new TNamedObject("SomeOtherClass")])
     *     ]
     * ]
     *
     * @var array<string, array<string, Type\Union>>|null
     */
    public $template_extended_params;
    /**
     * @var ?int
     */
    public $template_extended_count;
    /**
     * @var array<string, int>|null
     */
    public $template_type_implements_count;
    /**
     * @var ?Type\Union
     */
    public $yield;
    /**
     * @var array<string, int>|null
     */
    public $template_type_uses_count;
    /**
     * @var array<string, bool>
     */
    public $initialized_properties = array();
    /**
     * @var array<string>
     */
    public $invalid_dependencies = array();
    /**
     * @var array<lowercase-string, bool>
     */
    public $dependent_classlikes = array();
    /**
     * A hash of the source file's name, contents, and this file's modified on date
     *
     * @var string
     */
    public $hash = '';
    /**
     * @var bool
     */
    public $has_visitor_issues = false;
    /**
     * @var list<\Psalm\Issue\CodeIssue>
     */
    public $docblock_issues = array();
    /**
     * @var array<string, \Psalm\Internal\Type\TypeAlias\ClassTypeAlias>
     */
    public $type_aliases = array();
    /**
     * @var bool
     */
    public $preserve_constructor_signature = false;
    /**
     * @var null|string
     */
    public $extension_requirement;
    /**
     * @var array<int, string>
     */
    public $implementation_requirements = array();
    /**
     * @var list<AttributeStorage>
     */
    public $attributes = array();
    public function __construct(string $name)
    {
        $this->name = $name;
    }
}