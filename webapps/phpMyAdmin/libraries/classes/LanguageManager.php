<?php

declare (strict_types=1);
namespace PhpMyAdmin;

use PhpMyAdmin\Html\MySQLDocumentation;
use const E_USER_ERROR;
use function closedir;
use function count;
use function explode;
use function file_exists;
use function is_dir;
use function opendir;
use function preg_grep;
use function readdir;
use function strtolower;
use function trigger_error;
use function uasort;
use function ucfirst;
/**
 * Language selection manager
 */
class LanguageManager
{
    /**
     * Definition data for languages
     *
     * Each member contains:
     * - Language code
     * - English language name
     * - Native language name
     * - Match regular expression
     * - MySQL locale
     *
     * @var array
     */
    private static $languageData = array(
        'af' => array('af', 'Afrikaans', '', 'af|afrikaans', ''),
        'am' => array('am', 'Amharic', 'አማርኛ', 'am|amharic', ''),
        'ar' => array('ar', 'Arabic', '&#1575;&#1604;&#1593;&#1585;&#1576;&#1610;&#1577;', 'ar|arabic', 'ar_AE'),
        'ar_ly' => array('ar_LY', 'Arabic (Libya)', 'ليبي', 'ar[_-]ly|arabic (libya)|libian arabic', 'ar_LY'),
        'az' => array('az', 'Azerbaijani', 'Az&#601;rbaycanca', 'az|azerbaijani', ''),
        'bn' => array('bn', 'Bangla', 'বাংলা', 'bn|bangla', ''),
        'be' => array('be', 'Belarusian', '&#1041;&#1077;&#1083;&#1072;&#1088;&#1091;&#1089;&#1082;&#1072;&#1103;', 'be|belarusian', 'be_BY'),
        'be@latin' => array('be@latin', 'Belarusian (latin)', 'Bie&#0322;aruskaja', 'be[-_]lat|be@latin|belarusian latin', ''),
        'ber' => array('ber', 'Berber', 'Tamaziɣt', 'ber|berber', ''),
        'bg' => array('bg', 'Bulgarian', '&#1041;&#1098;&#1083;&#1075;&#1072;&#1088;&#1089;&#1082;&#1080;', 'bg|bulgarian', 'bg_BG'),
        'bs' => array('bs', 'Bosnian', 'Bosanski', 'bs|bosnian', ''),
        'br' => array('br', 'Breton', 'Brezhoneg', 'br|breton', ''),
        'brx' => array('brx', 'Bodo', 'बड़ो', 'brx|bodo', ''),
        'ca' => array('ca', 'Catalan', 'Catal&agrave;', 'ca|catalan', 'ca_ES'),
        'ckb' => array('ckb', 'Sorani', 'سۆرانی', 'ckb|sorani', ''),
        'cs' => array('cs', 'Czech', 'Čeština', 'cs|czech', 'cs_CZ'),
        'cy' => array('cy', 'Welsh', 'Cymraeg', 'cy|welsh', ''),
        'da' => array('da', 'Danish', 'Dansk', 'da|danish', 'da_DK'),
        'de' => array('de', 'German', 'Deutsch', 'de|german', 'de_DE'),
        'el' => array('el', 'Greek', '&Epsilon;&lambda;&lambda;&eta;&nu;&iota;&kappa;&#940;', 'el|greek', ''),
        'en' => array('en', 'English', '', 'en|english', 'en_US'),
        'en_gb' => array('en_GB', 'English (United Kingdom)', '', 'en[_-]gb|english (United Kingdom)', 'en_GB'),
        'eo' => array('eo', 'Esperanto', 'Esperanto', 'eo|esperanto', ''),
        'es' => array('es', 'Spanish', 'Espa&ntilde;ol', 'es|spanish', 'es_ES'),
        'et' => array('et', 'Estonian', 'Eesti', 'et|estonian', 'et_EE'),
        'eu' => array('eu', 'Basque', 'Euskara', 'eu|basque', 'eu_ES'),
        'fa' => array('fa', 'Persian', '&#1601;&#1575;&#1585;&#1587;&#1740;', 'fa|persian', ''),
        'fi' => array('fi', 'Finnish', 'Suomi', 'fi|finnish', 'fi_FI'),
        'fil' => array('fil', 'Filipino', 'Pilipino', 'fil|filipino', ''),
        'fr' => array('fr', 'French', 'Fran&ccedil;ais', 'fr|french', 'fr_FR'),
        'fy' => array('fy', 'Frisian', 'Frysk', 'fy|frisian', ''),
        'gl' => array('gl', 'Galician', 'Galego', 'gl|galician', 'gl_ES'),
        'gu' => array('gu', 'Gujarati', 'ગુજરાતી', 'gu|gujarati', 'gu_IN'),
        'he' => array('he', 'Hebrew', '&#1506;&#1489;&#1512;&#1497;&#1514;', 'he|hebrew', 'he_IL'),
        'hi' => array('hi', 'Hindi', '&#2361;&#2367;&#2344;&#2381;&#2342;&#2368;', 'hi|hindi', 'hi_IN'),
        'hr' => array('hr', 'Croatian', 'Hrvatski', 'hr|croatian', 'hr_HR'),
        'hu' => array('hu', 'Hungarian', 'Magyar', 'hu|hungarian', 'hu_HU'),
        'hy' => array('hy', 'Armenian', 'Հայերէն', 'hy|armenian', ''),
        'ia' => array('ia', 'Interlingua', '', 'ia|interlingua', ''),
        'id' => array('id', 'Indonesian', 'Bahasa Indonesia', 'id|indonesian', 'id_ID'),
        'ig' => array('ig', 'Igbo', 'Asụsụ Igbo', 'ig|igbo', ''),
        'it' => array('it', 'Italian', 'Italiano', 'it|italian', 'it_IT'),
        'ja' => array('ja', 'Japanese', '&#26085;&#26412;&#35486;', 'ja|japanese', 'ja_JP'),
        'ko' => array('ko', 'Korean', '&#54620;&#44397;&#50612;', 'ko|korean', 'ko_KR'),
        'ka' => array('ka', 'Georgian', '&#4325;&#4304;&#4320;&#4311;&#4323;&#4314;&#4312;', 'ka|georgian', ''),
        'kab' => array('kab', 'Kabylian', 'Taqbaylit', 'kab|kabylian', ''),
        'kk' => array('kk', 'Kazakh', 'Қазақ', 'kk|kazakh', ''),
        'km' => array('km', 'Khmer', 'ខ្មែរ', 'km|khmer', ''),
        'kn' => array('kn', 'Kannada', 'ಕನ್ನಡ', 'kn|kannada', ''),
        'ksh' => array('ksh', 'Colognian', 'Kölsch', 'ksh|colognian', ''),
        'ku' => array('ku', 'Kurdish', 'کوردی', 'ku|kurdish', ''),
        'ky' => array('ky', 'Kyrgyz', 'Кыргызча', 'ky|kyrgyz', ''),
        'li' => array('li', 'Limburgish', 'Lèmbörgs', 'li|limburgish', ''),
        'lt' => array('lt', 'Lithuanian', 'Lietuvi&#371;', 'lt|lithuanian', 'lt_LT'),
        'lv' => array('lv', 'Latvian', 'Latvie&scaron;u', 'lv|latvian', 'lv_LV'),
        'mk' => array('mk', 'Macedonian', 'Macedonian', 'mk|macedonian', 'mk_MK'),
        'ml' => array('ml', 'Malayalam', 'Malayalam', 'ml|malayalam', ''),
        'mn' => array('mn', 'Mongolian', '&#1052;&#1086;&#1085;&#1075;&#1086;&#1083;', 'mn|mongolian', 'mn_MN'),
        'ms' => array('ms', 'Malay', 'Bahasa Melayu', 'ms|malay', 'ms_MY'),
        'my' => array('my', 'Burmese', 'မြန်မာ', 'my|burmese', ''),
        'ne' => array('ne', 'Nepali', 'नेपाली', 'ne|nepali', ''),
        'nb' => array('nb', 'Norwegian', 'Norsk', 'nb|norwegian', 'nb_NO'),
        'nn' => array('nn', 'Norwegian Nynorsk', 'Nynorsk', 'nn|nynorsk', 'nn_NO'),
        'nl' => array('nl', 'Dutch', 'Nederlands', 'nl|dutch', 'nl_NL'),
        'pa' => array('pa', 'Punjabi', 'ਪੰਜਾਬੀ', 'pa|punjabi', ''),
        'pl' => array('pl', 'Polish', 'Polski', 'pl|polish', 'pl_PL'),
        'pt' => array('pt', 'Portuguese', 'Portugu&ecirc;s', 'pt|portuguese', 'pt_PT'),
        'pt_br' => array('pt_BR', 'Portuguese (Brazil)', 'Portugu&ecirc;s (Brasil)', 'pt[-_]br|portuguese (brazil)', 'pt_BR'),
        'rcf' => array('rcf', 'R&eacute;union Creole', 'Kr&eacute;ol', 'rcf|creole (reunion)', ''),
        'ro' => array('ro', 'Romanian', 'Rom&acirc;n&#259;', 'ro|romanian', 'ro_RO'),
        'ru' => array('ru', 'Russian', '&#1056;&#1091;&#1089;&#1089;&#1082;&#1080;&#1081;', 'ru|russian', 'ru_RU'),
        'si' => array('si', 'Sinhala', '&#3523;&#3538;&#3458;&#3524;&#3517;', 'si|sinhala', ''),
        'sk' => array('sk', 'Slovak', 'Sloven&#269;ina', 'sk|slovak', 'sk_SK'),
        'sl' => array('sl', 'Slovenian', 'Sloven&scaron;&#269;ina', 'sl|slovenian', 'sl_SI'),
        'sq' => array('sq', 'Albanian', 'Shqip', 'sq|albanian', 'sq_AL'),
        'sr@latin' => array('sr@latin', 'Serbian (latin)', 'Srpski', 'sr[-_]lat|sr@latin|serbian latin', 'sr_YU'),
        'sr' => array('sr', 'Serbian', '&#1057;&#1088;&#1087;&#1089;&#1082;&#1080;', 'sr|serbian', 'sr_YU'),
        'sv' => array('sv', 'Swedish', 'Svenska', 'sv|swedish', 'sv_SE'),
        'ta' => array('ta', 'Tamil', 'தமிழ்', 'ta|tamil', 'ta_IN'),
        'te' => array('te', 'Telugu', 'తెలుగు', 'te|telugu', 'te_IN'),
        'th' => array('th', 'Thai', '&#3616;&#3634;&#3625;&#3634;&#3652;&#3607;&#3618;', 'th|thai', 'th_TH'),
        'tk' => array('tk', 'Turkmen', 'Türkmençe', 'tk|turkmen', ''),
        'tr' => array('tr', 'Turkish', 'T&uuml;rk&ccedil;e', 'tr|turkish', 'tr_TR'),
        'tt' => array('tt', 'Tatarish', 'Tatar&ccedil;a', 'tt|tatarish', ''),
        'tzm' => array('tzm', 'Central Atlas Tamazight', 'Tamaziɣt', 'tzm|central atlas tamazight', ''),
        'ug' => array('ug', 'Uyghur', 'ئۇيغۇرچە', 'ug|uyghur', ''),
        'uk' => array('uk', 'Ukrainian', '&#1059;&#1082;&#1088;&#1072;&#1111;&#1085;&#1089;&#1100;&#1082;&#1072;', 'uk|ukrainian', 'uk_UA'),
        'ur' => array('ur', 'Urdu', 'اُردوُ', 'ur|urdu', 'ur_PK'),
        'uz@latin' => array('uz@latin', 'Uzbek (latin)', 'O&lsquo;zbekcha', 'uz[-_]lat|uz@latin|uzbek-latin', ''),
        'uz' => array('uz', 'Uzbek (cyrillic)', '&#1038;&#1079;&#1073;&#1077;&#1082;&#1095;&#1072;', 'uz[-_]cyr|uz@cyrillic|uzbek-cyrillic', ''),
        'vi' => array('vi', 'Vietnamese', 'Tiếng Việt', 'vi|vietnamese', 'vi_VN'),
        'vls' => array('vls', 'Flemish', 'West-Vlams', 'vls|flemish', ''),
        'zh_tw' => array('zh_TW', 'Chinese traditional', '&#20013;&#25991;', 'zh[-_](tw|hk)|chinese traditional', 'zh_TW'),
        // only TW and HK use traditional Chinese while others (CN, SG, MY)
        // use simplified Chinese
        'zh_cn' => array('zh_CN', 'Chinese simplified', '&#20013;&#25991;', 'zh(?![-_](tw|hk))([-_][[:alpha:]]{2,3})?|chinese simplified', 'zh_CN'),
    );
    /** @var array */
    private $availableLocales;
    /** @var array */
    private $availableLanguages = array();
    /** @var bool */
    private $langFailedConfig = false;
    /** @var bool */
    private $langFailedCookie = false;
    /** @var bool */
    private $langFailedRequest = false;
    /** @var LanguageManager */
    private static $instance;
    /**
     * Returns LanguageManager singleton
     *
     * @return LanguageManager
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new LanguageManager();
        }
        return self::$instance;
    }
    /**
     * Returns list of available locales
     *
     * @return array
     */
    public function listLocaleDir()
    {
        $result = ['en'];
        /* Check for existing directory */
        if (!is_dir(LOCALE_PATH)) {
            return $result;
        }
        /* Open the directory */
        $handle = @opendir(LOCALE_PATH);
        /* This can happen if the kit is English-only */
        if ($handle === false) {
            return $result;
        }
        /* Process all files */
        while (($file = readdir($handle)) !== false) {
            $path = LOCALE_PATH . '/' . $file . '/LC_MESSAGES/phpmyadmin.mo';
            if ($file === '.' || $file === '..' || !@file_exists($path)) {
                continue;
            }
            $result[] = $file;
        }
        /* Close the handle */
        closedir($handle);
        return $result;
    }
    /**
     * Returns (cached) list of all available locales
     *
     * @return array of strings
     */
    public function availableLocales()
    {
        if (!$this->availableLocales) {
            if (!isset($GLOBALS['PMA_Config']) || empty($GLOBALS['PMA_Config']->get('FilterLanguages'))) {
                $this->availableLocales = $this->listLocaleDir();
            } else {
                $this->availableLocales = preg_grep('@' . $GLOBALS['PMA_Config']->get('FilterLanguages') . '@', $this->listLocaleDir());
            }
        }
        return $this->availableLocales;
    }
    /**
     * Checks whether there are some languages available
     *
     * @return bool
     */
    public function hasChoice()
    {
        return count($this->availableLanguages()) > 1;
    }
    /**
     * Returns (cached) list of all available languages
     *
     * @return Language[] array of Language objects
     */
    public function availableLanguages()
    {
        if (!$this->availableLanguages) {
            $this->availableLanguages = [];
            foreach ($this->availableLocales() as $lang) {
                $lang = strtolower($lang);
                if (isset(static::$languageData[$lang])) {
                    $data = static::$languageData[$lang];
                    $this->availableLanguages[$lang] = new Language($data[0], $data[1], $data[2], $data[3], $data[4]);
                } else {
                    $this->availableLanguages[$lang] = new Language($lang, ucfirst($lang), ucfirst($lang), $lang, '');
                }
            }
        }
        return $this->availableLanguages;
    }
    /**
     * Returns (cached) list of all available languages sorted
     * by name
     *
     * @return Language[] array of Language objects
     */
    public function sortedLanguages()
    {
        $this->availableLanguages();
        uasort($this->availableLanguages, static function (Language $a, Language $b) {
            return $a->cmp($b);
        });
        return $this->availableLanguages;
    }
    /**
     * Return Language object for given code
     *
     * @param string $code Language code
     *
     * @return Language|false Language object or false on failure
     */
    public function getLanguage($code)
    {
        $code = strtolower($code);
        $langs = $this->availableLanguages();
        if (isset($langs[$code])) {
            return $langs[$code];
        }
        return false;
    }
    /**
     * Return currently active Language object
     *
     * @return Language Language object
     */
    public function getCurrentLanguage()
    {
        return $this->availableLanguages[strtolower($GLOBALS['lang'])];
    }
    /**
     * Activates language based on configuration, user preferences or
     * browser
     *
     * @return Language
     */
    public function selectLanguage()
    {
        // check forced language
        if (!empty($GLOBALS['PMA_Config']->get('Lang'))) {
            $lang = $this->getLanguage($GLOBALS['PMA_Config']->get('Lang'));
            if ($lang !== false) {
                return $lang;
            }
            $this->langFailedConfig = true;
        }
        // Don't use REQUEST in following code as it might be confused by cookies
        // with same name. Check user requested language (POST)
        if (!empty($_POST['lang'])) {
            $lang = $this->getLanguage($_POST['lang']);
            if ($lang !== false) {
                return $lang;
            }
            $this->langFailedRequest = true;
        }
        // check user requested language (GET)
        if (!empty($_GET['lang'])) {
            $lang = $this->getLanguage($_GET['lang']);
            if ($lang !== false) {
                return $lang;
            }
            $this->langFailedRequest = true;
        }
        // check previous set language
        if (!empty($GLOBALS['PMA_Config']->getCookie('pma_lang'))) {
            $lang = $this->getLanguage($GLOBALS['PMA_Config']->getCookie('pma_lang'));
            if ($lang !== false) {
                return $lang;
            }
            $this->langFailedCookie = true;
        }
        $langs = $this->availableLanguages();
        // try to find out user's language by checking its HTTP_ACCEPT_LANGUAGE variable;
        $accepted_languages = Core::getenv('HTTP_ACCEPT_LANGUAGE');
        if ($accepted_languages) {
            foreach (explode(',', $accepted_languages) as $header) {
                foreach ($langs as $language) {
                    if ($language->matchesAcceptLanguage($header)) {
                        return $language;
                    }
                }
            }
        }
        // try to find out user's language by checking its HTTP_USER_AGENT variable
        $user_agent = Core::getenv('HTTP_USER_AGENT');
        if (!empty($user_agent)) {
            foreach ($langs as $language) {
                if ($language->matchesUserAgent($user_agent)) {
                    return $language;
                }
            }
        }
        // Didn't catch any valid lang : we use the default settings
        if (isset($langs[$GLOBALS['PMA_Config']->get('DefaultLang')])) {
            return $langs[$GLOBALS['PMA_Config']->get('DefaultLang')];
        }
        // Fallback to English
        return $langs['en'];
    }
    /**
     * Displays warnings about invalid languages. This needs to be postponed
     * to show messages at time when language is initialized.
     *
     * @return void
     */
    public function showWarnings()
    {
        // now, that we have loaded the language strings we can send the errors
        if (!$this->langFailedConfig && !$this->langFailedCookie && !$this->langFailedRequest) {
            return;
        }
        trigger_error(__('Ignoring unsupported language code.'), E_USER_ERROR);
    }
    /**
     * Returns HTML code for the language selector
     *
     * @param Template $template     Template instance
     * @param bool     $use_fieldset whether to use fieldset for selection
     * @param bool     $show_doc     whether to show documentation links
     *
     * @return string
     *
     * @access public
     */
    public function getSelectorDisplay(Template $template, $use_fieldset = false, $show_doc = true)
    {
        $_form_params = ['db' => $GLOBALS['db'], 'table' => $GLOBALS['table']];
        // For non-English, display "Language" with emphasis because it's
        // not a proper word in the current language; we show it to help
        // people recognize the dialog
        $language_title = __('Language') . (__('Language') !== 'Language' ? ' - <em>Language</em>' : '');
        if ($show_doc) {
            $language_title .= MySQLDocumentation::showDocumentation('faq', 'faq7-2');
        }
        $available_languages = $this->sortedLanguages();
        return $template->render('select_lang', ['language_title' => $language_title, 'use_fieldset' => $use_fieldset, 'available_languages' => $available_languages, '_form_params' => $_form_params]);
    }
}