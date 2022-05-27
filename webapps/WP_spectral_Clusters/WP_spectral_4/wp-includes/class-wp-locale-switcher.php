<?php

/**
 * Locale API: WP_Locale_Switcher class
 *
 * @package WordPress
 * @subpackage i18n
 * @since 4.7.0
 */
/**
 * Core class used for switching locales.
 *
 * @since 4.7.0
 */
class WP_Locale_Switcher
{
    /**
     * Locale stack.
     *
     * @since 4.7.0
     * @var string[]
     */
    private $locales = array();
    /**
     * Original locale.
     *
     * @since 4.7.0
     * @var string
     */
    private $original_locale;
    /**
     * Holds all available languages.
     *
     * @since 4.7.0
     * @var array An array of language codes (file names without the .mo extension).
     */
    private $available_languages = array();
    /**
     * Constructor.
     *
     * Stores the original locale as well as a list of all available languages.
     *
     * @since 4.7.0
     */
    public function __construct()
    {
        $this->original_locale = determine_locale();
        $this->available_languages = array_merge(array('en_US'), get_available_languages());
    }
    /**
     * Initializes the locale switcher.
     *
     * Hooks into the {@see 'locale'} filter to change the locale on the fly.
     *
     * @since 4.7.0
     */
    public function init()
    {
        add_filter('locale', array($this, 'filter_locale'));
    }
    /**
     * Switches the translations according to the given locale.
     *
     * @since 4.7.0
     *
     * @param string $locale The locale to switch to.
     * @return bool True on success, false on failure.
     */
    public function switch_to_locale($locale)
    {
        $current_locale = determine_locale();
        if ($current_locale === $locale) {
            return false;
        }
        if (!in_array($locale, $this->available_languages, true)) {
            return false;
        }
        $this->locales[] = $locale;
        $this->change_locale($locale);
        /**
         * Fires when the locale is switched.
         *
         * @since 4.7.0
         *
         * @param string $locale The new locale.
         */
        do_action('switch_locale', $locale);
        return true;
    }
    /**
     * Restores the translations according to the previous locale.
     *
     * @since 4.7.0
     *
     * @return string|false Locale on success, false on failure.
     */
    public function restore_previous_locale()
    {
        $previous_locale = array_pop($this->locales);
        if (null === $previous_locale) {
            // The stack is empty, bail.
            return false;
        }
        $locale = end($this->locales);
        if (!$locale) {
            // There's nothing left in the stack: go back to the original locale.
            $locale = $this->original_locale;
        }
        $this->change_locale($locale);
        /**
         * Fires when the locale is restored to the previous one.
         *
         * @since 4.7.0
         *
         * @param string $locale          The new locale.
         * @param string $previous_locale The previous locale.
         */
        do_action('restore_previous_locale', $locale, $previous_locale);
        return $locale;
    }
    /**
     * Restores the translations according to the original locale.
     *
     * @since 4.7.0
     *
     * @return string|false Locale on success, false on failure.
     */
    public function restore_current_locale()
    {
        if (empty($this->locales)) {
            return false;
        }
        $this->locales = array($this->original_locale);
        return $this->restore_previous_locale();
    }
    /**
     * Whether switch_to_locale() is in effect.
     *
     * @since 4.7.0
     *
     * @return bool True if the locale has been switched, false otherwise.
     */
    public function is_switched()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("is_switched") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/class-wp-locale-switcher.php at line 145")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called is_switched:145@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/class-wp-locale-switcher.php');
        die();
    }
    /**
     * Filters the locale of the WordPress installation.
     *
     * @since 4.7.0
     *
     * @param string $locale The locale of the WordPress installation.
     * @return string The locale currently being switched to.
     */
    public function filter_locale($locale)
    {
        $switched_locale = end($this->locales);
        if ($switched_locale) {
            return $switched_locale;
        }
        return $locale;
    }
    /**
     * Load translations for a given locale.
     *
     * When switching to a locale, translations for this locale must be loaded from scratch.
     *
     * @since 4.7.0
     *
     * @global Mo[] $l10n An array of all currently loaded text domains.
     *
     * @param string $locale The locale to load translations for.
     */
    private function load_translations($locale)
    {
        global $l10n;
        $domains = $l10n ? array_keys($l10n) : array();
        load_default_textdomain($locale);
        foreach ($domains as $domain) {
            if ('default' === $domain) {
                continue;
            }
            unload_textdomain($domain);
            get_translations_for_domain($domain);
        }
    }
    /**
     * Changes the site's locale to the given one.
     *
     * Loads the translations, changes the global `$wp_locale` object and updates
     * all post type labels.
     *
     * @since 4.7.0
     *
     * @global WP_Locale $wp_locale WordPress date and time locale object.
     *
     * @param string $locale The locale to change to.
     */
    private function change_locale($locale)
    {
        // Reset translation availability information.
        _get_path_to_translation(null, true);
        $this->load_translations($locale);
        $GLOBALS['wp_locale'] = new WP_Locale();
        /**
         * Fires when the locale is switched to or restored.
         *
         * @since 4.7.0
         *
         * @param string $locale The new locale.
         */
        do_action('change_locale', $locale);
    }
}