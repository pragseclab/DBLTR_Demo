<?php

// phpcs:ignoreFile
namespace Phan\Language\Internal;

/**
 * CURRENT PHP TARGET VERSION: 8.0
 * The version above has to match Psalm\Internal\Codebase\InternalCallMapHandler::PHP_(MAJOR|MINOR)_VERSION
 *
 * Format
 *
 * '<function_name>' => ['<return_type>, '<arg_name>'=>'<arg_type>']
 * alternative signature for the same function
 * '<function_name\'1>' => ['<return_type>, '<arg_name>'=>'<arg_type>']
 *
 * A '&' in front of the <arg_name> means the arg is always passed by reference.
 * (i.e. ReflectionParameter->isPassedByReference())
 * This was previously only used in cases where the function actually created the
 * variable in the local scope.
 * Some reference arguments will have prefixes in <arg_name> to indicate the way the argument is used.
 * Currently, the only prefixes with meaning are 'rw_' (read-write) and 'w_' (write).
 * Those prefixes don't mean anything for non-references.
 * Code using these signatures should remove those prefixes from messages rendered to the user.
 * 1. '&rw_<arg_name>' indicates that a parameter with a value is expected to be passed in, and may be modified.
 *    Phan will warn if the variable has an incompatible type, or is undefined.
 * 2. '&w_<arg_name>' indicates that a parameter is expected to be passed in, and the value will be ignored, and may be overwritten.
 * 3. The absence of a prefix is treated by Phan the same way as having the prefix 'w_' (Some may be changed to 'rw_name'). These will have prefixes added later.
 *
 * So, for functions like sort() where technically the arg is by-ref,
 * indicate the reference param's signature by-ref and read-write,
 * as `'&rw_array'=>'array'`
 * so that Phan won't create it in the local scope
 *
 * However, for a function like preg_match() where the 3rd arg is an array of sub-pattern matches (and optional),
 * this arg needs to be marked as by-ref and write-only, as `'&w_matches='=>'array'`.
 *
 * A '=' following the <arg_name> indicates this arg is optional.
 *
 * The <arg_name> can begin with '...' to indicate the arg is variadic.
 * '...args=' indicates it is both variadic and optional.
 *
 * Some reference arguments will have prefixes in <arg_name> to indicate the way the argument is used.
 * Currently, the only prefixes with meaning are 'rw_' and 'w_'.
 * Code using these signatures should remove those prefixes from messages rendered to the user.
 * 1. '&rw_name' indicates that a parameter with a value is expected to be passed in, and may be modified.
 * 2. '&w_name' indicates that a parameter is expected to be passed in, and the value will be ignored, and may be overwritten.
 *
 * This file contains the signatures for the most recent minor release of PHP supported by phan (php 7.2)
 *
 * Changes:
 *
 * In Phan 0.12.3,
 *
 * - This started using array shapes for union types (array{...}).
 *
 *   \Phan\Language\UnionType->withFlattenedArrayShapeOrLiteralTypeInstances() may be of help to programmatically convert these to array<string,T1>|array<string,T2>
 *
 * - This started using array shapes with optional fields for union types (array{key?:int}).
 *   A `?` after the array shape field's key indicates that the field is optional.
 *
 * - This started adding param signatures and return signatures to `callable` types.
 *   E.g. 'usort' => ['bool', '&rw_array_arg'=>'array', 'cmp_function'=>'callable(mixed,mixed):int'].
 *   See NEWS.md for 0.12.3 for possible syntax. A suffix of `=` within `callable(...)` means that a parameter is optional.
 *
 *   (Phan assumes that callbacks with optional arguments can be cast to callbacks with/without those args (Similar to inheritance checks)
 *   (e.g. callable(T1,T2=) can be cast to callable(T1) or callable(T1,T2), in the same way that a subclass would check).
 *   For some signatures, e.g. set_error_handler, this results in repetition, because callable(T1=) can't cast to callable(T1).
 *
 * Sources of stub info:
 *
 * 1. Reflection
 * 2. docs.php.net's SVN repo or website, and examples (See internal/internalsignatures.php)
 *
 *    See https://secure.php.net/manual/en/copyright.php
 *
 *    The PHP manual text and comments are covered by the [Creative Commons Attribution 3.0 License](http://creativecommons.org/licenses/by/3.0/legalcode),
 *    copyright (c) the PHP Documentation Group
 * 3. Various websites documenting individual extensions
 * 4. PHPStorm stubs (For anything missing from the above sources)
 *    See internal/internalsignatures.php
 *
 *    Available from https://github.com/JetBrains/phpstorm-stubs under the [Apache 2 license](https://www.apache.org/licenses/LICENSE-2.0)
 *
 * @phan-file-suppress PhanPluginMixedKeyNoKey (read by Phan when analyzing this file)
 *
 * Note: Some of Phan's inferences about return types are written as plugins for functions/methods where the return type depends on the parameter types.
 * E.g. src/Phan/Plugin/Internal/DependentReturnTypeOverridePlugin.php is one plugin
 */