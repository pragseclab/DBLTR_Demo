<?php

namespace Psalm\Storage;

use function array_map;
use function implode;
use Psalm\CodeLocation;
use Psalm\Internal\Analyzer\ClassLikeAnalyzer;
use Psalm\Type;
abstract class FunctionLikeStorage
{
    use CustomMetadataTrait;
    /**
     * @var CodeLocation|null
     */
    public $location;
    /**
     * @var CodeLocation|null
     */
    public $stmt_location;
    /**
     * @var array<int, FunctionLikeParameter>
     */
    public $params = array();
    /**
     * @var array<string, bool>
     */
    public $param_lookup = array();
    /**
     * @var Type\Union|null
     */
    public $return_type;
    /**
     * @var CodeLocation|null
     */
    public $return_type_location;
    /**
     * @var Type\Union|null
     */
    public $signature_return_type;
    /**
     * @var CodeLocation|null
     */
    public $signature_return_type_location;
    /**
     * @var ?string
     */
    public $cased_name;
    /**
     * @var array<int, string>
     */
    public $suppressed_issues = array();
    /**
     * @var ?bool
     */
    public $deprecated;
    /**
     * @var string
     */
    public $internal = '';
    /**
     * @var bool
     */
    public $variadic = false;
    /**
     * @var bool
     */
    public $returns_by_ref = false;
    /**
     * @var ?int
     */
    public $required_param_count;
    /**
     * @var array<string, Type\Union>
     */
    public $defined_constants = array();
    /**
     * @var array<string, bool>
     */
    public $global_variables = array();
    /**
     * @var array<string, Type\Union>
     */
    public $global_types = array();
    /**
     * An array holding the class template "as" types.
     *
     * It's the de-facto list of all templates on a given class.
     *
     * The name of the template is the first key. The nested array is keyed by a unique
     * function identifier. This allows operations with the same-named template defined
     * across multiple classes and/or functions to not run into trouble.
     *
     * @var array<string, non-empty-array<string, Type\Union>>|null
     */
    public $template_types;
    /**
     * @var array<int, bool>|null
     */
    public $template_covariants;
    /**
     * @var array<int, Assertion>
     */
    public $assertions = array();
    /**
     * @var array<int, Assertion>
     */
    public $if_true_assertions = array();
    /**
     * @var array<int, Assertion>
     */
    public $if_false_assertions = array();
    /**
     * @var bool
     */
    public $has_visitor_issues = false;
    /**
     * @var list<\Psalm\Issue\CodeIssue>
     */
    public $docblock_issues = array();
    /**
     * @var array<string, bool>
     */
    public $throws = array();
    /**
     * @var array<string, CodeLocation>
     */
    public $throw_locations = array();
    /**
     * @var bool
     */
    public $has_yield = false;
    /**
     * @var bool
     */
    public $mutation_free = false;
    /**
     * @var string|null
     */
    public $return_type_description;
    /**
     * @var array<string, CodeLocation>|null
     */
    public $unused_docblock_params;
    /**
     * @var bool
     */
    public $pure = false;
    /**
     * Whether or not the function output is dependent solely on input - a function can be
     * impure but still have this property (e.g. var_export). Useful for taint analysis.
     *
     * @var bool
     */
    public $specialize_call = false;
    /**
     * @var array<string>
     */
    public $taint_source_types = array();
    /**
     * @var array<string>
     */
    public $added_taints = array();
    /**
     * @var array<string>
     */
    public $removed_taints = array();
    /**
     * @var array<Type\Union>
     */
    public $conditionally_removed_taints = array();
    /**
     * @var array<int, string>
     */
    public $return_source_params = array();
    /**
     * @var bool
     */
    public $allow_named_arg_calls = true;
    /**
     * @var list<AttributeStorage>
     */
    public $attributes = array();
    /**
     * @var list<array{fqn: string, params: array<int>, return: bool}>|null
     */
    public $proxy_calls = array();
    public function __toString() : string
    {
        return $this->getSignature(false);
    }
    public function getSignature(bool $allow_newlines = false) : string
    {
        $newlines = $allow_newlines && !empty($this->params);
        $symbol_text = 'function ' . $this->cased_name . '(' . ($newlines ? "\n" : '') . implode(',' . ($newlines ? "\n" : ' '), array_map(function (FunctionLikeParameter $param) use($newlines) : string {
            return ($newlines ? '    ' : '') . ($param->type ?: 'mixed') . ' $' . $param->name;
        }, $this->params)) . ($newlines ? "\n" : '') . ') : ' . ($this->return_type ?: 'mixed');
        if (!$this instanceof MethodStorage) {
            return $symbol_text;
        }
        switch ($this->visibility) {
            case ClassLikeAnalyzer::VISIBILITY_PRIVATE:
                $visibility_text = 'private';
                break;
            case ClassLikeAnalyzer::VISIBILITY_PROTECTED:
                $visibility_text = 'protected';
                break;
            default:
                $visibility_text = 'public';
        }
        return $visibility_text . ' ' . $symbol_text;
    }
}