<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Twig\Extension {
    use Twig\ExpressionParser;
    use Twig\Node\Expression\Binary\AddBinary;
    use Twig\Node\Expression\Binary\AndBinary;
    use Twig\Node\Expression\Binary\BitwiseAndBinary;
    use Twig\Node\Expression\Binary\BitwiseOrBinary;
    use Twig\Node\Expression\Binary\BitwiseXorBinary;
    use Twig\Node\Expression\Binary\ConcatBinary;
    use Twig\Node\Expression\Binary\DivBinary;
    use Twig\Node\Expression\Binary\EndsWithBinary;
    use Twig\Node\Expression\Binary\EqualBinary;
    use Twig\Node\Expression\Binary\FloorDivBinary;
    use Twig\Node\Expression\Binary\GreaterBinary;
    use Twig\Node\Expression\Binary\GreaterEqualBinary;
    use Twig\Node\Expression\Binary\InBinary;
    use Twig\Node\Expression\Binary\LessBinary;
    use Twig\Node\Expression\Binary\LessEqualBinary;
    use Twig\Node\Expression\Binary\MatchesBinary;
    use Twig\Node\Expression\Binary\ModBinary;
    use Twig\Node\Expression\Binary\MulBinary;
    use Twig\Node\Expression\Binary\NotEqualBinary;
    use Twig\Node\Expression\Binary\NotInBinary;
    use Twig\Node\Expression\Binary\OrBinary;
    use Twig\Node\Expression\Binary\PowerBinary;
    use Twig\Node\Expression\Binary\RangeBinary;
    use Twig\Node\Expression\Binary\SpaceshipBinary;
    use Twig\Node\Expression\Binary\StartsWithBinary;
    use Twig\Node\Expression\Binary\SubBinary;
    use Twig\Node\Expression\Filter\DefaultFilter;
    use Twig\Node\Expression\NullCoalesceExpression;
    use Twig\Node\Expression\Test\ConstantTest;
    use Twig\Node\Expression\Test\DefinedTest;
    use Twig\Node\Expression\Test\DivisiblebyTest;
    use Twig\Node\Expression\Test\EvenTest;
    use Twig\Node\Expression\Test\NullTest;
    use Twig\Node\Expression\Test\OddTest;
    use Twig\Node\Expression\Test\SameasTest;
    use Twig\Node\Expression\Unary\NegUnary;
    use Twig\Node\Expression\Unary\NotUnary;
    use Twig\Node\Expression\Unary\PosUnary;
    use Twig\NodeVisitor\MacroAutoImportNodeVisitor;
    use Twig\TokenParser\ApplyTokenParser;
    use Twig\TokenParser\BlockTokenParser;
    use Twig\TokenParser\DeprecatedTokenParser;
    use Twig\TokenParser\DoTokenParser;
    use Twig\TokenParser\EmbedTokenParser;
    use Twig\TokenParser\ExtendsTokenParser;
    use Twig\TokenParser\FilterTokenParser;
    use Twig\TokenParser\FlushTokenParser;
    use Twig\TokenParser\ForTokenParser;
    use Twig\TokenParser\FromTokenParser;
    use Twig\TokenParser\IfTokenParser;
    use Twig\TokenParser\ImportTokenParser;
    use Twig\TokenParser\IncludeTokenParser;
    use Twig\TokenParser\MacroTokenParser;
    use Twig\TokenParser\SetTokenParser;
    use Twig\TokenParser\SpacelessTokenParser;
    use Twig\TokenParser\UseTokenParser;
    use Twig\TokenParser\WithTokenParser;
    use Twig\TwigFilter;
    use Twig\TwigFunction;
    use Twig\TwigTest;
    final class CoreExtension extends AbstractExtension
    {
        private $dateFormats = array('F j, Y H:i', '%d days');
        private $numberFormat = array(0, '.', ',');
        private $timezone = null;
        private $escapers = array();
        /**
         * Defines a new escaper to be used via the escape filter.
         *
         * @param string   $strategy The strategy name that should be used as a strategy in the escape call
         * @param callable $callable A valid PHP callable
         *
         * @deprecated since Twig 2.11, to be removed in 3.0; use the same method on EscaperExtension instead
         */
        public function setEscaper($strategy, callable $callable)
        {
            echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("setEscaper") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php at line 89")                </p>            </div>        </div>    </div></body></html>');
            error_log('Removed function called setEscaper:89@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php');
            die();
        }
        /**
         * Gets all defined escapers.
         *
         * @return callable[] An array of escapers
         *
         * @deprecated since Twig 2.11, to be removed in 3.0; use the same method on EscaperExtension instead
         */
        public function getEscapers()
        {
            echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getEscapers") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php at line 101")                </p>            </div>        </div>    </div></body></html>');
            error_log('Removed function called getEscapers:101@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php');
            die();
        }
        /**
         * Sets the default format to be used by the date filter.
         *
         * @param string $format             The default date format string
         * @param string $dateIntervalFormat The default date interval format string
         */
        public function setDateFormat($format = null, $dateIntervalFormat = null)
        {
            echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("setDateFormat") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php at line 114")                </p>            </div>        </div>    </div></body></html>');
            error_log('Removed function called setDateFormat:114@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php');
            die();
        }
        /**
         * Gets the default format to be used by the date filter.
         *
         * @return array The default date format string and the default date interval format string
         */
        public function getDateFormat()
        {
            echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getDateFormat") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php at line 128")                </p>            </div>        </div>    </div></body></html>');
            error_log('Removed function called getDateFormat:128@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php');
            die();
        }
        /**
         * Sets the default timezone to be used by the date filter.
         *
         * @param \DateTimeZone|string $timezone The default timezone string or a \DateTimeZone object
         */
        public function setTimezone($timezone)
        {
            echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("setTimezone") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php at line 137")                </p>            </div>        </div>    </div></body></html>');
            error_log('Removed function called setTimezone:137@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php');
            die();
        }
        /**
         * Gets the default timezone to be used by the date filter.
         *
         * @return \DateTimeZone The default timezone currently in use
         */
        public function getTimezone()
        {
            if (null === $this->timezone) {
                $this->timezone = new \DateTimeZone(date_default_timezone_get());
            }
            return $this->timezone;
        }
        /**
         * Sets the default format to be used by the number_format filter.
         *
         * @param int    $decimal      the number of decimal places to use
         * @param string $decimalPoint the character(s) to use for the decimal point
         * @param string $thousandSep  the character(s) to use for the thousands separator
         */
        public function setNumberFormat($decimal, $decimalPoint, $thousandSep)
        {
            echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("setNumberFormat") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php at line 160")                </p>            </div>        </div>    </div></body></html>');
            error_log('Removed function called setNumberFormat:160@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php');
            die();
        }
        /**
         * Get the default format used by the number_format filter.
         *
         * @return array The arguments for number_format()
         */
        public function getNumberFormat()
        {
            echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getNumberFormat") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php at line 169")                </p>            </div>        </div>    </div></body></html>');
            error_log('Removed function called getNumberFormat:169@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php');
            die();
        }
        public function getTokenParsers()
        {
            return [new ApplyTokenParser(), new ForTokenParser(), new IfTokenParser(), new ExtendsTokenParser(), new IncludeTokenParser(), new BlockTokenParser(), new UseTokenParser(), new FilterTokenParser(), new MacroTokenParser(), new ImportTokenParser(), new FromTokenParser(), new SetTokenParser(), new SpacelessTokenParser(), new FlushTokenParser(), new DoTokenParser(), new EmbedTokenParser(), new WithTokenParser(), new DeprecatedTokenParser()];
        }
        public function getFilters()
        {
            return [
                // formatting filters
                new TwigFilter('date', 'twig_date_format_filter', ['needs_environment' => true]),
                new TwigFilter('date_modify', 'twig_date_modify_filter', ['needs_environment' => true]),
                new TwigFilter('format', 'sprintf'),
                new TwigFilter('replace', 'twig_replace_filter'),
                new TwigFilter('number_format', 'twig_number_format_filter', ['needs_environment' => true]),
                new TwigFilter('abs', 'abs'),
                new TwigFilter('round', 'twig_round'),
                // encoding
                new TwigFilter('url_encode', 'twig_urlencode_filter'),
                new TwigFilter('json_encode', 'json_encode'),
                new TwigFilter('convert_encoding', 'twig_convert_encoding'),
                // string filters
                new TwigFilter('title', 'twig_title_string_filter', ['needs_environment' => true]),
                new TwigFilter('capitalize', 'twig_capitalize_string_filter', ['needs_environment' => true]),
                new TwigFilter('upper', 'twig_upper_filter', ['needs_environment' => true]),
                new TwigFilter('lower', 'twig_lower_filter', ['needs_environment' => true]),
                new TwigFilter('striptags', 'strip_tags'),
                new TwigFilter('trim', 'twig_trim_filter'),
                new TwigFilter('nl2br', 'nl2br', ['pre_escape' => 'html', 'is_safe' => ['html']]),
                new TwigFilter('spaceless', 'twig_spaceless', ['is_safe' => ['html']]),
                // array helpers
                new TwigFilter('join', 'twig_join_filter'),
                new TwigFilter('split', 'twig_split_filter', ['needs_environment' => true]),
                new TwigFilter('sort', 'twig_sort_filter'),
                new TwigFilter('merge', 'twig_array_merge'),
                new TwigFilter('batch', 'twig_array_batch'),
                new TwigFilter('column', 'twig_array_column'),
                new TwigFilter('filter', 'twig_array_filter', ['needs_environment' => true]),
                new TwigFilter('map', 'twig_array_map', ['needs_environment' => true]),
                new TwigFilter('reduce', 'twig_array_reduce', ['needs_environment' => true]),
                // string/array filters
                new TwigFilter('reverse', 'twig_reverse_filter', ['needs_environment' => true]),
                new TwigFilter('length', 'twig_length_filter', ['needs_environment' => true]),
                new TwigFilter('slice', 'twig_slice', ['needs_environment' => true]),
                new TwigFilter('first', 'twig_first', ['needs_environment' => true]),
                new TwigFilter('last', 'twig_last', ['needs_environment' => true]),
                // iteration and runtime
                new TwigFilter('default', '_twig_default_filter', ['node_class' => DefaultFilter::class]),
                new TwigFilter('keys', 'twig_get_array_keys_filter'),
            ];
        }
        public function getFunctions()
        {
            return [new TwigFunction('max', 'max'), new TwigFunction('min', 'min'), new TwigFunction('range', 'range'), new TwigFunction('constant', 'twig_constant'), new TwigFunction('cycle', 'twig_cycle'), new TwigFunction('random', 'twig_random', ['needs_environment' => true]), new TwigFunction('date', 'twig_date_converter', ['needs_environment' => true]), new TwigFunction('include', 'twig_include', ['needs_environment' => true, 'needs_context' => true, 'is_safe' => ['all']]), new TwigFunction('source', 'twig_source', ['needs_environment' => true, 'is_safe' => ['all']])];
        }
        public function getTests()
        {
            return [new TwigTest('even', null, ['node_class' => EvenTest::class]), new TwigTest('odd', null, ['node_class' => OddTest::class]), new TwigTest('defined', null, ['node_class' => DefinedTest::class]), new TwigTest('same as', null, ['node_class' => SameasTest::class]), new TwigTest('none', null, ['node_class' => NullTest::class]), new TwigTest('null', null, ['node_class' => NullTest::class]), new TwigTest('divisible by', null, ['node_class' => DivisiblebyTest::class]), new TwigTest('constant', null, ['node_class' => ConstantTest::class]), new TwigTest('empty', 'twig_test_empty'), new TwigTest('iterable', 'twig_test_iterable')];
        }
        public function getNodeVisitors()
        {
            return [new MacroAutoImportNodeVisitor()];
        }
        public function getOperators()
        {
            return [['not' => ['precedence' => 50, 'class' => NotUnary::class], '-' => ['precedence' => 500, 'class' => NegUnary::class], '+' => ['precedence' => 500, 'class' => PosUnary::class]], ['or' => ['precedence' => 10, 'class' => OrBinary::class, 'associativity' => ExpressionParser::OPERATOR_LEFT], 'and' => ['precedence' => 15, 'class' => AndBinary::class, 'associativity' => ExpressionParser::OPERATOR_LEFT], 'b-or' => ['precedence' => 16, 'class' => BitwiseOrBinary::class, 'associativity' => ExpressionParser::OPERATOR_LEFT], 'b-xor' => ['precedence' => 17, 'class' => BitwiseXorBinary::class, 'associativity' => ExpressionParser::OPERATOR_LEFT], 'b-and' => ['precedence' => 18, 'class' => BitwiseAndBinary::class, 'associativity' => ExpressionParser::OPERATOR_LEFT], '==' => ['precedence' => 20, 'class' => EqualBinary::class, 'associativity' => ExpressionParser::OPERATOR_LEFT], '!=' => ['precedence' => 20, 'class' => NotEqualBinary::class, 'associativity' => ExpressionParser::OPERATOR_LEFT], '<=>' => ['precedence' => 20, 'class' => SpaceshipBinary::class, 'associativity' => ExpressionParser::OPERATOR_LEFT], '<' => ['precedence' => 20, 'class' => LessBinary::class, 'associativity' => ExpressionParser::OPERATOR_LEFT], '>' => ['precedence' => 20, 'class' => GreaterBinary::class, 'associativity' => ExpressionParser::OPERATOR_LEFT], '>=' => ['precedence' => 20, 'class' => GreaterEqualBinary::class, 'associativity' => ExpressionParser::OPERATOR_LEFT], '<=' => ['precedence' => 20, 'class' => LessEqualBinary::class, 'associativity' => ExpressionParser::OPERATOR_LEFT], 'not in' => ['precedence' => 20, 'class' => NotInBinary::class, 'associativity' => ExpressionParser::OPERATOR_LEFT], 'in' => ['precedence' => 20, 'class' => InBinary::class, 'associativity' => ExpressionParser::OPERATOR_LEFT], 'matches' => ['precedence' => 20, 'class' => MatchesBinary::class, 'associativity' => ExpressionParser::OPERATOR_LEFT], 'starts with' => ['precedence' => 20, 'class' => StartsWithBinary::class, 'associativity' => ExpressionParser::OPERATOR_LEFT], 'ends with' => ['precedence' => 20, 'class' => EndsWithBinary::class, 'associativity' => ExpressionParser::OPERATOR_LEFT], '..' => ['precedence' => 25, 'class' => RangeBinary::class, 'associativity' => ExpressionParser::OPERATOR_LEFT], '+' => ['precedence' => 30, 'class' => AddBinary::class, 'associativity' => ExpressionParser::OPERATOR_LEFT], '-' => ['precedence' => 30, 'class' => SubBinary::class, 'associativity' => ExpressionParser::OPERATOR_LEFT], '~' => ['precedence' => 40, 'class' => ConcatBinary::class, 'associativity' => ExpressionParser::OPERATOR_LEFT], '*' => ['precedence' => 60, 'class' => MulBinary::class, 'associativity' => ExpressionParser::OPERATOR_LEFT], '/' => ['precedence' => 60, 'class' => DivBinary::class, 'associativity' => ExpressionParser::OPERATOR_LEFT], '//' => ['precedence' => 60, 'class' => FloorDivBinary::class, 'associativity' => ExpressionParser::OPERATOR_LEFT], '%' => ['precedence' => 60, 'class' => ModBinary::class, 'associativity' => ExpressionParser::OPERATOR_LEFT], 'is' => ['precedence' => 100, 'associativity' => ExpressionParser::OPERATOR_LEFT], 'is not' => ['precedence' => 100, 'associativity' => ExpressionParser::OPERATOR_LEFT], '**' => ['precedence' => 200, 'class' => PowerBinary::class, 'associativity' => ExpressionParser::OPERATOR_RIGHT], '??' => ['precedence' => 300, 'class' => NullCoalesceExpression::class, 'associativity' => ExpressionParser::OPERATOR_RIGHT]]];
        }
    }
    class_alias('Twig\\Extension\\CoreExtension', 'Twig_Extension_Core');
}
namespace {
    use Twig\Environment;
    use Twig\Error\LoaderError;
    use Twig\Error\RuntimeError;
    use Twig\Extension\CoreExtension;
    use Twig\Extension\SandboxExtension;
    use Twig\Markup;
    use Twig\Source;
    use Twig\Template;
    /**
     * Cycles over a value.
     *
     * @param \ArrayAccess|array $values
     * @param int                $position The cycle position
     *
     * @return string The next value in the cycle
     */
    function twig_cycle($values, $position)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("twig_cycle") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php at line 258")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called twig_cycle:258@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php');
        die();
    }
    /**
     * Returns a random value depending on the supplied parameter type:
     * - a random item from a \Traversable or array
     * - a random character from a string
     * - a random integer between 0 and the integer parameter.
     *
     * @param \Traversable|array|int|float|string $values The values to pick a random item from
     * @param int|null                            $max    Maximum value used when $values is an int
     *
     * @throws RuntimeError when $values is an empty array (does not apply to an empty string which is returned as is)
     *
     * @return mixed A random value from the given sequence
     */
    function twig_random(Environment $env, $values = null, $max = null)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("twig_random") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php at line 278")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called twig_random:278@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php');
        die();
    }
    /**
     * Converts a date to the given format.
     *
     *   {{ post.published_at|date("m/d/Y") }}
     *
     * @param \DateTimeInterface|\DateInterval|string $date     A date
     * @param string|null                             $format   The target format, null to use the default
     * @param \DateTimeZone|string|false|null         $timezone The target timezone, null to use the default, false to leave unchanged
     *
     * @return string The formatted date
     */
    function twig_date_format_filter(Environment $env, $date, $format = null, $timezone = null)
    {
        if (null === $format) {
            $formats = $env->getExtension(CoreExtension::class)->getDateFormat();
            $format = $date instanceof \DateInterval ? $formats[1] : $formats[0];
        }
        if ($date instanceof \DateInterval) {
            return $date->format($format);
        }
        return twig_date_converter($env, $date, $timezone)->format($format);
    }
    /**
     * Returns a new date object modified.
     *
     *   {{ post.published_at|date_modify("-1day")|date("m/d/Y") }}
     *
     * @param \DateTimeInterface|string $date     A date
     * @param string                    $modifier A modifier string
     *
     * @return \DateTimeInterface
     */
    function twig_date_modify_filter(Environment $env, $date, $modifier)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("twig_date_modify_filter") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php at line 356")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called twig_date_modify_filter:356@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php');
        die();
    }
    /**
     * Converts an input to a \DateTime instance.
     *
     *    {% if date(user.created_at) < date('+2days') %}
     *      {# do something #}
     *    {% endif %}
     *
     * @param \DateTimeInterface|string|null  $date     A date or null to use the current time
     * @param \DateTimeZone|string|false|null $timezone The target timezone, null to use the default, false to leave unchanged
     *
     * @return \DateTimeInterface
     */
    function twig_date_converter(Environment $env, $date = null, $timezone = null)
    {
        // determine the timezone
        if (false !== $timezone) {
            if (null === $timezone) {
                $timezone = $env->getExtension(CoreExtension::class)->getTimezone();
            } elseif (!$timezone instanceof \DateTimeZone) {
                $timezone = new \DateTimeZone($timezone);
            }
        }
        // immutable dates
        if ($date instanceof \DateTimeImmutable) {
            return false !== $timezone ? $date->setTimezone($timezone) : $date;
        }
        if ($date instanceof \DateTimeInterface) {
            $date = clone $date;
            if (false !== $timezone) {
                $date->setTimezone($timezone);
            }
            return $date;
        }
        if (null === $date || 'now' === $date) {
            return new \DateTime($date, false !== $timezone ? $timezone : $env->getExtension(CoreExtension::class)->getTimezone());
        }
        $asString = (string) $date;
        if (ctype_digit($asString) || !empty($asString) && '-' === $asString[0] && ctype_digit(substr($asString, 1))) {
            $date = new \DateTime('@' . $date);
        } else {
            $date = new \DateTime($date, $env->getExtension(CoreExtension::class)->getTimezone());
        }
        if (false !== $timezone) {
            $date->setTimezone($timezone);
        }
        return $date;
    }
    /**
     * Replaces strings within a string.
     *
     * @param string             $str  String to replace in
     * @param array|\Traversable $from Replace values
     *
     * @return string
     */
    function twig_replace_filter($str, $from)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("twig_replace_filter") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php at line 416")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called twig_replace_filter:416@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php');
        die();
    }
    /**
     * Rounds a number.
     *
     * @param int|float $value     The value to round
     * @param int|float $precision The rounding precision
     * @param string    $method    The method to use for rounding
     *
     * @return int|float The rounded number
     */
    function twig_round($value, $precision = 0, $method = 'common')
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("twig_round") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php at line 432")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called twig_round:432@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php');
        die();
    }
    /**
     * Number format filter.
     *
     * All of the formatting options can be left null, in that case the defaults will
     * be used.  Supplying any of the parameters will override the defaults set in the
     * environment object.
     *
     * @param mixed  $number       A float/int/string of the number to format
     * @param int    $decimal      the number of decimal points to display
     * @param string $decimalPoint the character(s) to use for the decimal point
     * @param string $thousandSep  the character(s) to use for the thousands separator
     *
     * @return string The formatted number
     */
    function twig_number_format_filter(Environment $env, $number, $decimal = null, $decimalPoint = null, $thousandSep = null)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("twig_number_format_filter") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php at line 456")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called twig_number_format_filter:456@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php');
        die();
    }
    /**
     * URL encodes (RFC 3986) a string as a path segment or an array as a query string.
     *
     * @param string|array $url A URL or an array of query parameters
     *
     * @return string The URL encoded value
     */
    function twig_urlencode_filter($url)
    {
        if (\is_array($url)) {
            return http_build_query($url, '', '&', PHP_QUERY_RFC3986);
        }
        return rawurlencode($url);
    }
    /**
     * Merges an array with another one.
     *
     *  {% set items = { 'apple': 'fruit', 'orange': 'fruit' } %}
     *
     *  {% set items = items|merge({ 'peugeot': 'car' }) %}
     *
     *  {# items now contains { 'apple': 'fruit', 'orange': 'fruit', 'peugeot': 'car' } #}
     *
     * @param array|\Traversable $arr1 An array
     * @param array|\Traversable $arr2 An array
     *
     * @return array The merged array
     */
    function twig_array_merge($arr1, $arr2)
    {
        if (!twig_test_iterable($arr1)) {
            throw new RuntimeError(sprintf('The merge filter only works with arrays or "Traversable", got "%s" as first argument.', \gettype($arr1)));
        }
        if (!twig_test_iterable($arr2)) {
            throw new RuntimeError(sprintf('The merge filter only works with arrays or "Traversable", got "%s" as second argument.', \gettype($arr2)));
        }
        return array_merge(twig_to_array($arr1), twig_to_array($arr2));
    }
    /**
     * Slices a variable.
     *
     * @param mixed $item         A variable
     * @param int   $start        Start of the slice
     * @param int   $length       Size of the slice
     * @param bool  $preserveKeys Whether to preserve key or not (when the input is an array)
     *
     * @return mixed The sliced variable
     */
    function twig_slice(Environment $env, $item, $start, $length = null, $preserveKeys = false)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("twig_slice") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php at line 518")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called twig_slice:518@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php');
        die();
    }
    /**
     * Returns the first element of the item.
     *
     * @param mixed $item A variable
     *
     * @return mixed The first element of the item
     */
    function twig_first(Environment $env, $item)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("twig_first") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php at line 546")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called twig_first:546@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php');
        die();
    }
    /**
     * Returns the last element of the item.
     *
     * @param mixed $item A variable
     *
     * @return mixed The last element of the item
     */
    function twig_last(Environment $env, $item)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("twig_last") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php at line 558")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called twig_last:558@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php');
        die();
    }
    /**
     * Joins the values to a string.
     *
     * The separators between elements are empty strings per default, you can define them with the optional parameters.
     *
     *  {{ [1, 2, 3]|join(', ', ' and ') }}
     *  {# returns 1, 2 and 3 #}
     *
     *  {{ [1, 2, 3]|join('|') }}
     *  {# returns 1|2|3 #}
     *
     *  {{ [1, 2, 3]|join }}
     *  {# returns 123 #}
     *
     * @param array       $value An array
     * @param string      $glue  The separator
     * @param string|null $and   The separator for the last pair
     *
     * @return string The concatenated string
     */
    function twig_join_filter($value, $glue = '', $and = null)
    {
        if (!twig_test_iterable($value)) {
            $value = (array) $value;
        }
        $value = twig_to_array($value, false);
        if (0 === \count($value)) {
            return '';
        }
        if (null === $and || $and === $glue) {
            return implode($glue, $value);
        }
        if (1 === \count($value)) {
            return $value[0];
        }
        return implode($glue, \array_slice($value, 0, -1)) . $and . $value[\count($value) - 1];
    }
    /**
     * Splits the string into an array.
     *
     *  {{ "one,two,three"|split(',') }}
     *  {# returns [one, two, three] #}
     *
     *  {{ "one,two,three,four,five"|split(',', 3) }}
     *  {# returns [one, two, "three,four,five"] #}
     *
     *  {{ "123"|split('') }}
     *  {# returns [1, 2, 3] #}
     *
     *  {{ "aabbcc"|split('', 2) }}
     *  {# returns [aa, bb, cc] #}
     *
     * @param string $value     A string
     * @param string $delimiter The delimiter
     * @param int    $limit     The limit
     *
     * @return array The split string as an array
     */
    function twig_split_filter(Environment $env, $value, $delimiter, $limit = null)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("twig_split_filter") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php at line 621")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called twig_split_filter:621@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php');
        die();
    }
    // The '_default' filter is used internally to avoid using the ternary operator
    // which costs a lot for big contexts (before PHP 5.4). So, on average,
    // a function call is cheaper.
    /**
     * @internal
     */
    function _twig_default_filter($value, $default = '')
    {
        if (twig_test_empty($value)) {
            return $default;
        }
        return $value;
    }
    /**
     * Returns the keys for the given array.
     *
     * It is useful when you want to iterate over the keys of an array:
     *
     *  {% for key in array|keys %}
     *      {# ... #}
     *  {% endfor %}
     *
     * @param array $array An array
     *
     * @return array The keys
     */
    function twig_get_array_keys_filter($array)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("twig_get_array_keys_filter") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php at line 665")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called twig_get_array_keys_filter:665@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php');
        die();
    }
    /**
     * Reverses a variable.
     *
     * @param array|\Traversable|string $item         An array, a \Traversable instance, or a string
     * @param bool                      $preserveKeys Whether to preserve key or not
     *
     * @return mixed The reversed input
     */
    function twig_reverse_filter(Environment $env, $item, $preserveKeys = false)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("twig_reverse_filter") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php at line 699")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called twig_reverse_filter:699@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php');
        die();
    }
    /**
     * Sorts an array.
     *
     * @param array|\Traversable $array
     *
     * @return array
     */
    function twig_sort_filter($array, $arrow = null)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("twig_sort_filter") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php at line 726")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called twig_sort_filter:726@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php');
        die();
    }
    /**
     * @internal
     */
    function twig_in_filter($value, $compare)
    {
        if ($value instanceof Markup) {
            $value = (string) $value;
        }
        if ($compare instanceof Markup) {
            $compare = (string) $compare;
        }
        if (\is_array($compare)) {
            return \in_array($value, $compare, \is_object($value) || \is_resource($value));
        } elseif (\is_string($compare) && (\is_string($value) || \is_int($value) || \is_float($value))) {
            return '' === $value || false !== strpos($compare, (string) $value);
        } elseif ($compare instanceof \Traversable) {
            if (\is_object($value) || \is_resource($value)) {
                foreach ($compare as $item) {
                    if ($item === $value) {
                        return true;
                    }
                }
            } else {
                foreach ($compare as $item) {
                    if ($item == $value) {
                        return true;
                    }
                }
            }
            return false;
        }
        return false;
    }
    /**
     * Returns a trimmed string.
     *
     * @return string
     *
     * @throws RuntimeError When an invalid trimming side is used (not a string or not 'left', 'right', or 'both')
     */
    function twig_trim_filter($string, $characterMask = null, $side = 'both')
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("twig_trim_filter") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php at line 780")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called twig_trim_filter:780@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php');
        die();
    }
    /**
     * Removes whitespaces between HTML tags.
     *
     * @return string
     */
    function twig_spaceless($content)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("twig_spaceless") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php at line 801")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called twig_spaceless:801@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php');
        die();
    }
    function twig_convert_encoding($string, $to, $from)
    {
        if (!\function_exists('iconv')) {
            throw new RuntimeError('Unable to convert encoding: required function iconv() does not exist. You should install ext-iconv or symfony/polyfill-iconv.');
        }
        return iconv($from, $to, $string);
    }
    /**
     * Returns the length of a variable.
     *
     * @param mixed $thing A variable
     *
     * @return int The length of the value
     */
    function twig_length_filter(Environment $env, $thing)
    {
        if (null === $thing) {
            return 0;
        }
        if (is_scalar($thing)) {
            return mb_strlen($thing, $env->getCharset());
        }
        if ($thing instanceof \Countable || \is_array($thing) || $thing instanceof \SimpleXMLElement) {
            return \count($thing);
        }
        if ($thing instanceof \Traversable) {
            return iterator_count($thing);
        }
        if (method_exists($thing, '__toString') && !$thing instanceof \Countable) {
            return mb_strlen((string) $thing, $env->getCharset());
        }
        return 1;
    }
    /**
     * Converts a string to uppercase.
     *
     * @param string $string A string
     *
     * @return string The uppercased string
     */
    function twig_upper_filter(Environment $env, $string)
    {
        return mb_strtoupper($string, $env->getCharset());
    }
    /**
     * Converts a string to lowercase.
     *
     * @param string $string A string
     *
     * @return string The lowercased string
     */
    function twig_lower_filter(Environment $env, $string)
    {
        return mb_strtolower($string, $env->getCharset());
    }
    /**
     * Returns a titlecased string.
     *
     * @param string $string A string
     *
     * @return string The titlecased string
     */
    function twig_title_string_filter(Environment $env, $string)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("twig_title_string_filter") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php at line 867")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called twig_title_string_filter:867@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php');
        die();
    }
    /**
     * Returns a capitalized string.
     *
     * @param string $string A string
     *
     * @return string The capitalized string
     */
    function twig_capitalize_string_filter(Environment $env, $string)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("twig_capitalize_string_filter") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php at line 881")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called twig_capitalize_string_filter:881@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php');
        die();
    }
    /**
     * @internal
     */
    function twig_call_macro(Template $template, string $method, array $args, int $lineno, array $context, Source $source)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("twig_call_macro") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php at line 889")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called twig_call_macro:889@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php');
        die();
    }
    /**
     * @internal
     */
    function twig_ensure_traversable($seq)
    {
        if ($seq instanceof \Traversable || \is_array($seq)) {
            return $seq;
        }
        return [];
    }
    /**
     * @internal
     */
    function twig_to_array($seq, $preserveKeys = true)
    {
        if ($seq instanceof \Traversable) {
            return iterator_to_array($seq, $preserveKeys);
        }
        if (!\is_array($seq)) {
            return $seq;
        }
        return $preserveKeys ? $seq : array_values($seq);
    }
    /**
     * Checks if a variable is empty.
     *
     *    {# evaluates to true if the foo variable is null, false, or the empty string #}
     *    {% if foo is empty %}
     *        {# ... #}
     *    {% endif %}
     *
     * @param mixed $value A variable
     *
     * @return bool true if the value is empty, false otherwise
     */
    function twig_test_empty($value)
    {
        if ($value instanceof \Countable) {
            return 0 === \count($value);
        }
        if ($value instanceof \Traversable) {
            return !iterator_count($value);
        }
        if (\is_object($value) && method_exists($value, '__toString')) {
            return '' === (string) $value;
        }
        return '' === $value || false === $value || null === $value || [] === $value;
    }
    /**
     * Checks if a variable is traversable.
     *
     *    {# evaluates to true if the foo variable is an array or a traversable object #}
     *    {% if foo is iterable %}
     *        {# ... #}
     *    {% endif %}
     *
     * @param mixed $value A variable
     *
     * @return bool true if the value is traversable
     */
    function twig_test_iterable($value)
    {
        return $value instanceof \Traversable || \is_array($value);
    }
    /**
     * Renders a template.
     *
     * @param array        $context
     * @param string|array $template      The template to render or an array of templates to try consecutively
     * @param array        $variables     The variables to pass to the template
     * @param bool         $withContext
     * @param bool         $ignoreMissing Whether to ignore missing templates or not
     * @param bool         $sandboxed     Whether to sandbox the template or not
     *
     * @return string The rendered template
     */
    function twig_include(Environment $env, $context, $template, $variables = array(), $withContext = true, $ignoreMissing = false, $sandboxed = false)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("twig_include") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php at line 978")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called twig_include:978@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php');
        die();
    }
    /**
     * Returns a template content without rendering it.
     *
     * @param string $name          The template name
     * @param bool   $ignoreMissing Whether to ignore missing templates or not
     *
     * @return string The template source
     */
    function twig_source(Environment $env, $name, $ignoreMissing = false)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("twig_source") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php at line 1015")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called twig_source:1015@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php');
        die();
    }
    /**
     * Provides the ability to get constants from instances as well as class/global constants.
     *
     * @param string      $constant The name of the constant
     * @param object|null $object   The object to get the constant from
     *
     * @return string
     */
    function twig_constant($constant, $object = null)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("twig_constant") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php at line 1034")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called twig_constant:1034@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php');
        die();
    }
    /**
     * Checks if a constant exists.
     *
     * @param string      $constant The name of the constant
     * @param object|null $object   The object to get the constant from
     *
     * @return bool
     */
    function twig_constant_is_defined($constant, $object = null)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("twig_constant_is_defined") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php at line 1049")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called twig_constant_is_defined:1049@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php');
        die();
    }
    /**
     * Batches item.
     *
     * @param array $items An array of items
     * @param int   $size  The size of the batch
     * @param mixed $fill  A value used to fill missing items
     *
     * @return array
     */
    function twig_array_batch($items, $size, $fill = null, $preserveKeys = true)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("twig_array_batch") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php at line 1065")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called twig_array_batch:1065@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php');
        die();
    }
    /**
     * Returns the attribute value for a given array/object.
     *
     * @param mixed  $object            The object or array from where to get the item
     * @param mixed  $item              The item to get from the array or object
     * @param array  $arguments         An array of arguments to pass if the item is an object method
     * @param string $type              The type of attribute (@see \Twig\Template constants)
     * @param bool   $isDefinedTest     Whether this is only a defined check
     * @param bool   $ignoreStrictCheck Whether to ignore the strict attribute check or not
     * @param int    $lineno            The template line where the attribute was called
     *
     * @return mixed The attribute value, or a Boolean when $isDefinedTest is true, or null when the attribute is not set and $ignoreStrictCheck is true
     *
     * @throws RuntimeError if the attribute does not exist and Twig is running in strict mode and $isDefinedTest is false
     *
     * @internal
     */
    function twig_get_attribute(Environment $env, Source $source, $object, $item, array $arguments = array(), $type = 'any', $isDefinedTest = false, $ignoreStrictCheck = false, $sandboxed = false, int $lineno = -1)
    {
        // array
        if ('method' !== $type) {
            $arrayItem = \is_bool($item) || \is_float($item) ? (int) $item : $item;
            if ((\is_array($object) || $object instanceof \ArrayObject) && (isset($object[$arrayItem]) || \array_key_exists($arrayItem, (array) $object)) || $object instanceof ArrayAccess && isset($object[$arrayItem])) {
                if ($isDefinedTest) {
                    return true;
                }
                return $object[$arrayItem];
            }
            if ('array' === $type || !\is_object($object)) {
                if ($isDefinedTest) {
                    return false;
                }
                if ($ignoreStrictCheck || !$env->isStrictVariables()) {
                    return;
                }
                if ($object instanceof ArrayAccess) {
                    $message = sprintf('Key "%s" in object with ArrayAccess of class "%s" does not exist.', $arrayItem, \get_class($object));
                } elseif (\is_object($object)) {
                    $message = sprintf('Impossible to access a key "%s" on an object of class "%s" that does not implement ArrayAccess interface.', $item, \get_class($object));
                } elseif (\is_array($object)) {
                    if (empty($object)) {
                        $message = sprintf('Key "%s" does not exist as the array is empty.', $arrayItem);
                    } else {
                        $message = sprintf('Key "%s" for array with keys "%s" does not exist.', $arrayItem, implode(', ', array_keys($object)));
                    }
                } elseif ('array' === $type) {
                    if (null === $object) {
                        $message = sprintf('Impossible to access a key ("%s") on a null variable.', $item);
                    } else {
                        $message = sprintf('Impossible to access a key ("%s") on a %s variable ("%s").', $item, \gettype($object), $object);
                    }
                } elseif (null === $object) {
                    $message = sprintf('Impossible to access an attribute ("%s") on a null variable.', $item);
                } else {
                    $message = sprintf('Impossible to access an attribute ("%s") on a %s variable ("%s").', $item, \gettype($object), $object);
                }
                throw new RuntimeError($message, $lineno, $source);
            }
        }
        if (!\is_object($object)) {
            if ($isDefinedTest) {
                return false;
            }
            if ($ignoreStrictCheck || !$env->isStrictVariables()) {
                return;
            }
            if (null === $object) {
                $message = sprintf('Impossible to invoke a method ("%s") on a null variable.', $item);
            } elseif (\is_array($object)) {
                $message = sprintf('Impossible to invoke a method ("%s") on an array.', $item);
            } else {
                $message = sprintf('Impossible to invoke a method ("%s") on a %s variable ("%s").', $item, \gettype($object), $object);
            }
            throw new RuntimeError($message, $lineno, $source);
        }
        if ($object instanceof Template) {
            throw new RuntimeError('Accessing \\Twig\\Template attributes is forbidden.', $lineno, $source);
        }
        // object property
        if ('method' !== $type) {
            if (isset($object->{$item}) || \array_key_exists((string) $item, (array) $object)) {
                if ($isDefinedTest) {
                    return true;
                }
                if ($sandboxed) {
                    $env->getExtension(SandboxExtension::class)->checkPropertyAllowed($object, $item, $lineno, $source);
                }
                return $object->{$item};
            }
        }
        static $cache = array();
        $class = \get_class($object);
        // object method
        // precedence: getXxx() > isXxx() > hasXxx()
        if (!isset($cache[$class])) {
            $methods = get_class_methods($object);
            sort($methods);
            $lcMethods = array_map(function ($value) {
                return strtr($value, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz');
            }, $methods);
            $classCache = [];
            foreach ($methods as $i => $method) {
                $classCache[$method] = $method;
                $classCache[$lcName = $lcMethods[$i]] = $method;
                if ('g' === $lcName[0] && 0 === strpos($lcName, 'get')) {
                    $name = substr($method, 3);
                    $lcName = substr($lcName, 3);
                } elseif ('i' === $lcName[0] && 0 === strpos($lcName, 'is')) {
                    $name = substr($method, 2);
                    $lcName = substr($lcName, 2);
                } elseif ('h' === $lcName[0] && 0 === strpos($lcName, 'has')) {
                    $name = substr($method, 3);
                    $lcName = substr($lcName, 3);
                    if (\in_array('is' . $lcName, $lcMethods)) {
                        continue;
                    }
                } else {
                    continue;
                }
                // skip get() and is() methods (in which case, $name is empty)
                if ($name) {
                    if (!isset($classCache[$name])) {
                        $classCache[$name] = $method;
                    }
                    if (!isset($classCache[$lcName])) {
                        $classCache[$lcName] = $method;
                    }
                }
            }
            $cache[$class] = $classCache;
        }
        $call = false;
        if (isset($cache[$class][$item])) {
            $method = $cache[$class][$item];
        } elseif (isset($cache[$class][$lcItem = strtr($item, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz')])) {
            $method = $cache[$class][$lcItem];
        } elseif (isset($cache[$class]['__call'])) {
            $method = $item;
            $call = true;
        } else {
            if ($isDefinedTest) {
                return false;
            }
            if ($ignoreStrictCheck || !$env->isStrictVariables()) {
                return;
            }
            throw new RuntimeError(sprintf('Neither the property "%1$s" nor one of the methods "%1$s()", "get%1$s()"/"is%1$s()"/"has%1$s()" or "__call()" exist and have public access in class "%2$s".', $item, $class), $lineno, $source);
        }
        if ($isDefinedTest) {
            return true;
        }
        if ($sandboxed) {
            $env->getExtension(SandboxExtension::class)->checkMethodAllowed($object, $method, $lineno, $source);
        }
        // Some objects throw exceptions when they have __call, and the method we try
        // to call is not supported. If ignoreStrictCheck is true, we should return null.
        try {
            $ret = $object->{$method}(...$arguments);
        } catch (\BadMethodCallException $e) {
            if ($call && ($ignoreStrictCheck || !$env->isStrictVariables())) {
                return;
            }
            throw $e;
        }
        return $ret;
    }
    /**
     * Returns the values from a single column in the input array.
     *
     * <pre>
     *  {% set items = [{ 'fruit' : 'apple'}, {'fruit' : 'orange' }] %}
     *
     *  {% set fruits = items|column('fruit') %}
     *
     *  {# fruits now contains ['apple', 'orange'] #}
     * </pre>
     *
     * @param array|Traversable $array An array
     * @param mixed             $name  The column name
     * @param mixed             $index The column to use as the index/keys for the returned array
     *
     * @return array The array of values
     */
    function twig_array_column($array, $name, $index = null) : array
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("twig_array_column") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php at line 1265")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called twig_array_column:1265@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php');
        die();
    }
    function twig_array_filter(Environment $env, $array, $arrow)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("twig_array_filter") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php at line 1274")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called twig_array_filter:1274@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php');
        die();
    }
    function twig_array_map(Environment $env, $array, $arrow)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("twig_array_map") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php at line 1288")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called twig_array_map:1288@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php');
        die();
    }
    function twig_array_reduce(Environment $env, $array, $arrow, $initial = null)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("twig_array_reduce") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php at line 1299")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called twig_array_reduce:1299@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Extension/CoreExtension.php');
        die();
    }
}