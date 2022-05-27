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
    use Twig\FileExtensionEscapingStrategy;
    use Twig\NodeVisitor\EscaperNodeVisitor;
    use Twig\TokenParser\AutoEscapeTokenParser;
    use Twig\TwigFilter;
    final class EscaperExtension extends AbstractExtension
    {
        private $defaultStrategy;
        private $escapers = array();
        /** @internal */
        public $safeClasses = array();
        /** @internal */
        public $safeLookup = array();
        /**
         * @param string|false|callable $defaultStrategy An escaping strategy
         *
         * @see setDefaultStrategy()
         */
        public function __construct($defaultStrategy = 'html')
        {
            $this->setDefaultStrategy($defaultStrategy);
        }
        public function getTokenParsers()
        {
            return [new AutoEscapeTokenParser()];
        }
        public function getNodeVisitors()
        {
            return [new EscaperNodeVisitor()];
        }
        public function getFilters()
        {
            return [new TwigFilter('escape', 'twig_escape_filter', ['needs_environment' => true, 'is_safe_callback' => 'twig_escape_filter_is_safe']), new TwigFilter('e', 'twig_escape_filter', ['needs_environment' => true, 'is_safe_callback' => 'twig_escape_filter_is_safe']), new TwigFilter('raw', 'twig_raw_filter', ['is_safe' => ['all']])];
        }
        /**
         * Sets the default strategy to use when not defined by the user.
         *
         * The strategy can be a valid PHP callback that takes the template
         * name as an argument and returns the strategy to use.
         *
         * @param string|false|callable $defaultStrategy An escaping strategy
         */
        public function setDefaultStrategy($defaultStrategy)
        {
            if ('name' === $defaultStrategy) {
                $defaultStrategy = [FileExtensionEscapingStrategy::class, 'guess'];
            }
            $this->defaultStrategy = $defaultStrategy;
        }
        /**
         * Gets the default strategy to use when not defined by the user.
         *
         * @param string $name The template name
         *
         * @return string|false The default strategy to use for the template
         */
        public function getDefaultStrategy($name)
        {
            // disable string callables to avoid calling a function named html or js,
            // or any other upcoming escaping strategy
            if (!\is_string($this->defaultStrategy) && false !== $this->defaultStrategy) {
                return \call_user_func($this->defaultStrategy, $name);
            }
            return $this->defaultStrategy;
        }
        /**
         * Defines a new escaper to be used via the escape filter.
         *
         * @param string   $strategy The strategy name that should be used as a strategy in the escape call
         * @param callable $callable A valid PHP callable
         */
        public function setEscaper($strategy, callable $callable)
        {
            echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("setEscaper") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/vendor/twig/twig/src/Extension/EscaperExtension.php at line 84")                </p>            </div>        </div>    </div></body></html>');
            error_log('Removed function called setEscaper:84@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/vendor/twig/twig/src/Extension/EscaperExtension.php');
            die();
        }
        /**
         * Gets all defined escapers.
         *
         * @return callable[] An array of escapers
         */
        public function getEscapers()
        {
            echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getEscapers") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/vendor/twig/twig/src/Extension/EscaperExtension.php at line 93")                </p>            </div>        </div>    </div></body></html>');
            error_log('Removed function called getEscapers:93@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/vendor/twig/twig/src/Extension/EscaperExtension.php');
            die();
        }
        public function setSafeClasses(array $safeClasses = array())
        {
            echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("setSafeClasses") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/vendor/twig/twig/src/Extension/EscaperExtension.php at line 97")                </p>            </div>        </div>    </div></body></html>');
            error_log('Removed function called setSafeClasses:97@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/vendor/twig/twig/src/Extension/EscaperExtension.php');
            die();
        }
        public function addSafeClass(string $class, array $strategies)
        {
            echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("addSafeClass") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/vendor/twig/twig/src/Extension/EscaperExtension.php at line 105")                </p>            </div>        </div>    </div></body></html>');
            error_log('Removed function called addSafeClass:105@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/vendor/twig/twig/src/Extension/EscaperExtension.php');
            die();
        }
    }
    class_alias('Twig\\Extension\\EscaperExtension', 'Twig_Extension_Escaper');
}
namespace {
    use Twig\Environment;
    use Twig\Error\RuntimeError;
    use Twig\Extension\CoreExtension;
    use Twig\Extension\EscaperExtension;
    use Twig\Markup;
    use Twig\Node\Expression\ConstantExpression;
    use Twig\Node\Node;
    /**
     * Marks a variable as being safe.
     *
     * @param string $string A PHP variable
     *
     * @return string
     */
    function twig_raw_filter($string)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("twig_raw_filter") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/vendor/twig/twig/src/Extension/EscaperExtension.php at line 134")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called twig_raw_filter:134@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/vendor/twig/twig/src/Extension/EscaperExtension.php');
        die();
    }
    /**
     * Escapes a string.
     *
     * @param mixed  $string     The value to be escaped
     * @param string $strategy   The escaping strategy
     * @param string $charset    The charset
     * @param bool   $autoescape Whether the function is called by the auto-escaping feature (true) or by the developer (false)
     *
     * @return string
     */
    function twig_escape_filter(Environment $env, $string, $strategy = 'html', $charset = null, $autoescape = false)
    {
        if ($autoescape && $string instanceof Markup) {
            return $string;
        }
        if (!\is_string($string)) {
            if (\is_object($string) && method_exists($string, '__toString')) {
                if ($autoescape) {
                    $c = \get_class($string);
                    $ext = $env->getExtension(EscaperExtension::class);
                    if (!isset($ext->safeClasses[$c])) {
                        $ext->safeClasses[$c] = [];
                        foreach (class_parents($string) + class_implements($string) as $class) {
                            if (isset($ext->safeClasses[$class])) {
                                $ext->safeClasses[$c] = array_unique(array_merge($ext->safeClasses[$c], $ext->safeClasses[$class]));
                                foreach ($ext->safeClasses[$class] as $s) {
                                    $ext->safeLookup[$s][$c] = true;
                                }
                            }
                        }
                    }
                    if (isset($ext->safeLookup[$strategy][$c]) || isset($ext->safeLookup['all'][$c])) {
                        return (string) $string;
                    }
                }
                $string = (string) $string;
            } elseif (\in_array($strategy, ['html', 'js', 'css', 'html_attr', 'url'])) {
                return $string;
            }
        }
        if ('' === $string) {
            return '';
        }
        if (null === $charset) {
            $charset = $env->getCharset();
        }
        switch ($strategy) {
            case 'html':
                // see https://secure.php.net/htmlspecialchars
                // Using a static variable to avoid initializing the array
                // each time the function is called. Moving the declaration on the
                // top of the function slow downs other escaping strategies.
                static $htmlspecialcharsCharsets = array('ISO-8859-1' => true, 'ISO8859-1' => true, 'ISO-8859-15' => true, 'ISO8859-15' => true, 'utf-8' => true, 'UTF-8' => true, 'CP866' => true, 'IBM866' => true, '866' => true, 'CP1251' => true, 'WINDOWS-1251' => true, 'WIN-1251' => true, '1251' => true, 'CP1252' => true, 'WINDOWS-1252' => true, '1252' => true, 'KOI8-R' => true, 'KOI8-RU' => true, 'KOI8R' => true, 'BIG5' => true, '950' => true, 'GB2312' => true, '936' => true, 'BIG5-HKSCS' => true, 'SHIFT_JIS' => true, 'SJIS' => true, '932' => true, 'EUC-JP' => true, 'EUCJP' => true, 'ISO8859-5' => true, 'ISO-8859-5' => true, 'MACROMAN' => true);
                if (isset($htmlspecialcharsCharsets[$charset])) {
                    return htmlspecialchars($string, ENT_QUOTES | ENT_SUBSTITUTE, $charset);
                }
                if (isset($htmlspecialcharsCharsets[strtoupper($charset)])) {
                    // cache the lowercase variant for future iterations
                    $htmlspecialcharsCharsets[$charset] = true;
                    return htmlspecialchars($string, ENT_QUOTES | ENT_SUBSTITUTE, $charset);
                }
                $string = twig_convert_encoding($string, 'UTF-8', $charset);
                $string = htmlspecialchars($string, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
                return iconv('UTF-8', $charset, $string);
            case 'js':
                // escape all non-alphanumeric characters
                // into their \x or \uHHHH representations
                if ('UTF-8' !== $charset) {
                    $string = twig_convert_encoding($string, 'UTF-8', $charset);
                }
                if (!preg_match('//u', $string)) {
                    throw new RuntimeError('The string to escape is not a valid UTF-8 string.');
                }
                $string = preg_replace_callback('#[^a-zA-Z0-9,\\._]#Su', function ($matches) {
                    $char = $matches[0];
                    /*
                     * A few characters have short escape sequences in JSON and JavaScript.
                     * Escape sequences supported only by JavaScript, not JSON, are omitted.
                     * \" is also supported but omitted, because the resulting string is not HTML safe.
                     */
                    static $shortMap = array('\\' => '\\\\', '/' => '\\/', "\x08" => '\\b', "\f" => '\\f', "\n" => '\\n', "\r" => '\\r', "\t" => '\\t');
                    if (isset($shortMap[$char])) {
                        return $shortMap[$char];
                    }
                    // \uHHHH
                    $char = twig_convert_encoding($char, 'UTF-16BE', 'UTF-8');
                    $char = strtoupper(bin2hex($char));
                    if (4 >= \strlen($char)) {
                        return sprintf('\\u%04s', $char);
                    }
                    return sprintf('\\u%04s\\u%04s', substr($char, 0, -4), substr($char, -4));
                }, $string);
                if ('UTF-8' !== $charset) {
                    $string = iconv('UTF-8', $charset, $string);
                }
                return $string;
            case 'css':
                if ('UTF-8' !== $charset) {
                    $string = twig_convert_encoding($string, 'UTF-8', $charset);
                }
                if (!preg_match('//u', $string)) {
                    throw new RuntimeError('The string to escape is not a valid UTF-8 string.');
                }
                $string = preg_replace_callback('#[^a-zA-Z0-9]#Su', function ($matches) {
                    $char = $matches[0];
                    return sprintf('\\%X ', 1 === \strlen($char) ? \ord($char) : mb_ord($char, 'UTF-8'));
                }, $string);
                if ('UTF-8' !== $charset) {
                    $string = iconv('UTF-8', $charset, $string);
                }
                return $string;
            case 'html_attr':
                if ('UTF-8' !== $charset) {
                    $string = twig_convert_encoding($string, 'UTF-8', $charset);
                }
                if (!preg_match('//u', $string)) {
                    throw new RuntimeError('The string to escape is not a valid UTF-8 string.');
                }
                $string = preg_replace_callback('#[^a-zA-Z0-9,\\.\\-_]#Su', function ($matches) {
                    /**
                     * This function is adapted from code coming from Zend Framework.
                     *
                     * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (https://www.zend.com)
                     * @license   https://framework.zend.com/license/new-bsd New BSD License
                     */
                    $chr = $matches[0];
                    $ord = \ord($chr);
                    /*
                     * The following replaces characters undefined in HTML with the
                     * hex entity for the Unicode replacement character.
                     */
                    if ($ord <= 0x1f && "\t" != $chr && "\n" != $chr && "\r" != $chr || $ord >= 0x7f && $ord <= 0x9f) {
                        return '&#xFFFD;';
                    }
                    /*
                     * Check if the current character to escape has a name entity we should
                     * replace it with while grabbing the hex value of the character.
                     */
                    if (1 === \strlen($chr)) {
                        /*
                         * While HTML supports far more named entities, the lowest common denominator
                         * has become HTML5's XML Serialisation which is restricted to the those named
                         * entities that XML supports. Using HTML entities would result in this error:
                         *     XML Parsing Error: undefined entity
                         */
                        static $entityMap = array(
                            34 => '&quot;',
                            /* quotation mark */
                            38 => '&amp;',
                            /* ampersand */
                            60 => '&lt;',
                            /* less-than sign */
                            62 => '&gt;',
                        );
                        if (isset($entityMap[$ord])) {
                            return $entityMap[$ord];
                        }
                        return sprintf('&#x%02X;', $ord);
                    }
                    /*
                     * Per OWASP recommendations, we'll use hex entities for any other
                     * characters where a named entity does not exist.
                     */
                    return sprintf('&#x%04X;', mb_ord($chr, 'UTF-8'));
                }, $string);
                if ('UTF-8' !== $charset) {
                    $string = iconv('UTF-8', $charset, $string);
                }
                return $string;
            case 'url':
                return rawurlencode($string);
            default:
                static $escapers;
                if (null === $escapers) {
                    // merge the ones set on CoreExtension for BC (to be removed in 3.0)
                    $escapers = array_merge($env->getExtension(CoreExtension::class)->getEscapers(false), $env->getExtension(EscaperExtension::class)->getEscapers());
                }
                if (isset($escapers[$strategy])) {
                    return $escapers[$strategy]($env, $string, $charset);
                }
                $validStrategies = implode(', ', array_merge(['html', 'js', 'url', 'css', 'html_attr'], array_keys($escapers)));
                throw new RuntimeError(sprintf('Invalid escaping strategy "%s" (valid ones: %s).', $strategy, $validStrategies));
        }
    }
    /**
     * @internal
     */
    function twig_escape_filter_is_safe(Node $filterArgs)
    {
        foreach ($filterArgs as $arg) {
            if ($arg instanceof ConstantExpression) {
                return [$arg->getAttribute('value')];
            }
            return [];
        }
        return ['html'];
    }
}