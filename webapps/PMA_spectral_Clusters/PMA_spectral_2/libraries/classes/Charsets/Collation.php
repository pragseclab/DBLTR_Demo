<?php

/**
 * Value object class for a collation
 */
declare (strict_types=1);
namespace PhpMyAdmin\Charsets;

use function count;
use function explode;
use function implode;
/**
 * Value object class for a collation
 */
final class Collation
{
    /**
     * The collation name
     *
     * @var string
     */
    private $name;
    /**
     * A description of the collation
     *
     * @var string
     */
    private $description;
    /**
     * The name of the character set with which the collation is associated
     *
     * @var string
     */
    private $charset;
    /**
     * The collation ID
     *
     * @var int
     */
    private $id;
    /**
     * Whether the collation is the default for its character set
     *
     * @var bool
     */
    private $isDefault;
    /**
     * Whether the character set is compiled into the server
     *
     * @var bool
     */
    private $isCompiled;
    /**
     * Used for determining the memory used to sort strings in this collation
     *
     * @var int
     */
    private $sortLength;
    /**
     * The collation pad attribute
     *
     * @var string
     */
    private $padAttribute;
    /**
     * @param string $name         Collation name
     * @param string $charset      Related charset
     * @param int    $id           Collation ID
     * @param bool   $isDefault    Whether is the default
     * @param bool   $isCompiled   Whether the charset is compiled
     * @param int    $sortLength   Sort length
     * @param string $padAttribute Pad attribute
     */
    private function __construct(string $name, string $charset, int $id, bool $isDefault, bool $isCompiled, int $sortLength, string $padAttribute)
    {
        $this->name = $name;
        $this->charset = $charset;
        $this->id = $id;
        $this->isDefault = $isDefault;
        $this->isCompiled = $isCompiled;
        $this->sortLength = $sortLength;
        $this->padAttribute = $padAttribute;
        $this->description = $this->buildDescription();
    }
    /**
     * @param array $state State obtained from the database server
     */
    public static function fromServer(array $state) : self
    {
        return new self($state['Collation'] ?? '', $state['Charset'] ?? '', (int) ($state['Id'] ?? 0), isset($state['Default']) && ($state['Default'] === 'Yes' || $state['Default'] === '1'), isset($state['Compiled']) && ($state['Compiled'] === 'Yes' || $state['Compiled'] === '1'), (int) ($state['Sortlen'] ?? 0), $state['Pad_attribute'] ?? '');
    }
    public function getName() : string
    {
        return $this->name;
    }
    public function getDescription() : string
    {
        return $this->description;
    }
    public function getCharset() : string
    {
        return $this->charset;
    }
    public function getId() : int
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getId") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Charsets/Collation.php at line 106")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getId:106@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Charsets/Collation.php');
        die();
    }
    public function isDefault() : bool
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("isDefault") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Charsets/Collation.php at line 110")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called isDefault:110@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Charsets/Collation.php');
        die();
    }
    public function isCompiled() : bool
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("isCompiled") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Charsets/Collation.php at line 114")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called isCompiled:114@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Charsets/Collation.php');
        die();
    }
    public function getSortLength() : int
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getSortLength") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Charsets/Collation.php at line 118")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getSortLength:118@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Charsets/Collation.php');
        die();
    }
    public function getPadAttribute() : string
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getPadAttribute") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Charsets/Collation.php at line 122")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getPadAttribute:122@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Charsets/Collation.php');
        die();
    }
    /**
     * Returns description for given collation
     *
     * @return string collation description
     */
    private function buildDescription() : string
    {
        $parts = explode('_', $this->getName());
        $name = __('Unknown');
        $variant = null;
        $suffixes = [];
        $unicode = false;
        $unknown = false;
        $level = 0;
        foreach ($parts as $part) {
            if ($level === 0) {
                /* Next will be language */
                $level = 1;
                /* First should be charset */
                $this->getNameForLevel0(
                    $unicode,
                    // By reference
                    $unknown,
                    // Same
                    $part,
                    $name,
                    // By reference
                    $variant
                );
                continue;
            }
            if ($level === 1) {
                /* Next will be variant unless changed later */
                $level = 4;
                /* Locale name or code */
                $found = true;
                $this->getNameForLevel1(
                    $unicode,
                    $unknown,
                    $part,
                    $name,
                    // By reference, will be changed
                    $level,
                    // Also
                    $found
                );
                if ($found) {
                    continue;
                }
                // Not parsed token, fall to next level
            }
            if ($level === 2) {
                /* Next will be variant */
                $level = 4;
                /* Germal variant */
                if ($part === 'pb') {
                    $name = _pgettext('Collation', 'German (phone book order)');
                    continue;
                }
                $name = _pgettext('Collation', 'German (dictionary order)');
                // Not parsed token, fall to next level
            }
            if ($level === 3) {
                /* Next will be variant */
                $level = 4;
                /* Spanish variant */
                if ($part === 'trad') {
                    $name = _pgettext('Collation', 'Spanish (traditional)');
                    continue;
                }
                $name = _pgettext('Collation', 'Spanish (modern)');
                // Not parsed token, fall to next level
            }
            if ($level === 4) {
                /* Next will be suffix */
                $level = 5;
                /* Variant */
                $found = true;
                $variantFound = $this->getVariant($part);
                if ($variantFound === null) {
                    $found = false;
                } else {
                    $variant = $variantFound;
                }
                if ($found) {
                    continue;
                }
                // Not parsed token, fall to next level
            }
            if ($level < 5) {
                continue;
            }
            /* Suffixes */
            $suffixes = $this->addSuffixes($suffixes, $part);
        }
        return $this->buildName($name, $variant, $suffixes);
    }
    private function buildName(string $result, ?string $variant, array $suffixes) : string
    {
        if ($variant !== null) {
            $result .= ' (' . $variant . ')';
        }
        if (count($suffixes) > 0) {
            $result .= ', ' . implode(', ', $suffixes);
        }
        return $result;
    }
    private function getVariant(string $part) : ?string
    {
        switch ($part) {
            case '0900':
                return 'UCA 9.0.0';
            case '520':
                return 'UCA 5.2.0';
            case 'mysql561':
                return 'MySQL 5.6.1';
            case 'mysql500':
                return 'MySQL 5.0.0';
            default:
                return null;
        }
    }
    private function addSuffixes(array $suffixes, string $part) : array
    {
        switch ($part) {
            case 'ci':
                $suffixes[] = _pgettext('Collation variant', 'case-insensitive');
                break;
            case 'cs':
                $suffixes[] = _pgettext('Collation variant', 'case-sensitive');
                break;
            case 'ai':
                $suffixes[] = _pgettext('Collation variant', 'accent-insensitive');
                break;
            case 'as':
                $suffixes[] = _pgettext('Collation variant', 'accent-sensitive');
                break;
            case 'ks':
                $suffixes[] = _pgettext('Collation variant', 'kana-sensitive');
                break;
            case 'w2':
            case 'l2':
                $suffixes[] = _pgettext('Collation variant', 'multi-level');
                break;
            case 'bin':
                $suffixes[] = _pgettext('Collation variant', 'binary');
                break;
            case 'nopad':
                $suffixes[] = _pgettext('Collation variant', 'no-pad');
                break;
        }
        return $suffixes;
    }
    private function getNameForLevel0(bool &$unicode, bool &$unknown, string $part, ?string &$name, ?string &$variant) : void
    {
        switch ($part) {
            case 'binary':
                $name = _pgettext('Collation', 'Binary');
                break;
            // Unicode charsets
            case 'utf8mb4':
                $variant = 'UCA 4.0.0';
            // Fall through to other unicode
            case 'ucs2':
            case 'utf8':
            case 'utf16':
            case 'utf16le':
            case 'utf16be':
            case 'utf32':
                $name = _pgettext('Collation', 'Unicode');
                $unicode = true;
                break;
            // West European charsets
            case 'ascii':
            case 'cp850':
            case 'dec8':
            case 'hp8':
            case 'latin1':
            case 'macroman':
                $name = _pgettext('Collation', 'West European');
                break;
            // Central European charsets
            case 'cp1250':
            case 'cp852':
            case 'latin2':
            case 'macce':
                $name = _pgettext('Collation', 'Central European');
                break;
            // Russian charsets
            case 'cp866':
            case 'koi8r':
                $name = _pgettext('Collation', 'Russian');
                break;
            // Chinese charsets
            case 'gb2312':
            case 'gbk':
                $name = _pgettext('Collation', 'Simplified Chinese');
                break;
            case 'big5':
                $name = _pgettext('Collation', 'Traditional Chinese');
                break;
            case 'gb18030':
                $name = _pgettext('Collation', 'Chinese');
                $unicode = true;
                break;
            // Japanese charsets
            case 'sjis':
            case 'ujis':
            case 'cp932':
            case 'eucjpms':
                $name = _pgettext('Collation', 'Japanese');
                break;
            // Baltic charsets
            case 'cp1257':
            case 'latin7':
                $name = _pgettext('Collation', 'Baltic');
                break;
            // Other
            case 'armscii8':
            case 'armscii':
                $name = _pgettext('Collation', 'Armenian');
                break;
            case 'cp1251':
                $name = _pgettext('Collation', 'Cyrillic');
                break;
            case 'cp1256':
                $name = _pgettext('Collation', 'Arabic');
                break;
            case 'euckr':
                $name = _pgettext('Collation', 'Korean');
                break;
            case 'hebrew':
                $name = _pgettext('Collation', 'Hebrew');
                break;
            case 'geostd8':
                $name = _pgettext('Collation', 'Georgian');
                break;
            case 'greek':
                $name = _pgettext('Collation', 'Greek');
                break;
            case 'keybcs2':
                $name = _pgettext('Collation', 'Czech-Slovak');
                break;
            case 'koi8u':
                $name = _pgettext('Collation', 'Ukrainian');
                break;
            case 'latin5':
                $name = _pgettext('Collation', 'Turkish');
                break;
            case 'swe7':
                $name = _pgettext('Collation', 'Swedish');
                break;
            case 'tis620':
                $name = _pgettext('Collation', 'Thai');
                break;
            default:
                $name = _pgettext('Collation', 'Unknown');
                $unknown = true;
                break;
        }
    }
    private function getNameForLevel1(bool $unicode, bool $unknown, string $part, ?string &$name, int &$level, bool &$found) : void
    {
        switch ($part) {
            case 'general':
                break;
            case 'bulgarian':
            case 'bg':
                $name = _pgettext('Collation', 'Bulgarian');
                break;
            case 'chinese':
            case 'cn':
            case 'zh':
                if ($unicode) {
                    $name = _pgettext('Collation', 'Chinese');
                }
                break;
            case 'croatian':
            case 'hr':
                $name = _pgettext('Collation', 'Croatian');
                break;
            case 'czech':
            case 'cs':
                $name = _pgettext('Collation', 'Czech');
                break;
            case 'danish':
            case 'da':
                $name = _pgettext('Collation', 'Danish');
                break;
            case 'english':
            case 'en':
                $name = _pgettext('Collation', 'English');
                break;
            case 'esperanto':
            case 'eo':
                $name = _pgettext('Collation', 'Esperanto');
                break;
            case 'estonian':
            case 'et':
                $name = _pgettext('Collation', 'Estonian');
                break;
            case 'german1':
                $name = _pgettext('Collation', 'German (dictionary order)');
                break;
            case 'german2':
                $name = _pgettext('Collation', 'German (phone book order)');
                break;
            case 'german':
            case 'de':
                /* Name is set later */
                $level = 2;
                break;
            case 'hungarian':
            case 'hu':
                $name = _pgettext('Collation', 'Hungarian');
                break;
            case 'icelandic':
            case 'is':
                $name = _pgettext('Collation', 'Icelandic');
                break;
            case 'japanese':
            case 'ja':
                $name = _pgettext('Collation', 'Japanese');
                break;
            case 'la':
                $name = _pgettext('Collation', 'Classical Latin');
                break;
            case 'latvian':
            case 'lv':
                $name = _pgettext('Collation', 'Latvian');
                break;
            case 'lithuanian':
            case 'lt':
                $name = _pgettext('Collation', 'Lithuanian');
                break;
            case 'korean':
            case 'ko':
                $name = _pgettext('Collation', 'Korean');
                break;
            case 'myanmar':
            case 'my':
                $name = _pgettext('Collation', 'Burmese');
                break;
            case 'persian':
                $name = _pgettext('Collation', 'Persian');
                break;
            case 'polish':
            case 'pl':
                $name = _pgettext('Collation', 'Polish');
                break;
            case 'roman':
                $name = _pgettext('Collation', 'West European');
                break;
            case 'romanian':
            case 'ro':
                $name = _pgettext('Collation', 'Romanian');
                break;
            case 'ru':
                $name = _pgettext('Collation', 'Russian');
                break;
            case 'si':
            case 'sinhala':
                $name = _pgettext('Collation', 'Sinhalese');
                break;
            case 'slovak':
            case 'sk':
                $name = _pgettext('Collation', 'Slovak');
                break;
            case 'slovenian':
            case 'sl':
                $name = _pgettext('Collation', 'Slovenian');
                break;
            case 'spanish':
                $name = _pgettext('Collation', 'Spanish (modern)');
                break;
            case 'es':
                /* Name is set later */
                $level = 3;
                break;
            case 'spanish2':
                $name = _pgettext('Collation', 'Spanish (traditional)');
                break;
            case 'swedish':
            case 'sv':
                $name = _pgettext('Collation', 'Swedish');
                break;
            case 'thai':
            case 'th':
                $name = _pgettext('Collation', 'Thai');
                break;
            case 'turkish':
            case 'tr':
                $name = _pgettext('Collation', 'Turkish');
                break;
            case 'ukrainian':
            case 'uk':
                $name = _pgettext('Collation', 'Ukrainian');
                break;
            case 'vietnamese':
            case 'vi':
                $name = _pgettext('Collation', 'Vietnamese');
                break;
            case 'unicode':
                if ($unknown) {
                    $name = _pgettext('Collation', 'Unicode');
                }
                break;
            default:
                $found = false;
        }
    }
}