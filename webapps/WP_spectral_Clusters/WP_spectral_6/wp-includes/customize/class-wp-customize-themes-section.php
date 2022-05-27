<?php

/**
 * Customize API: WP_Customize_Themes_Section class
 *
 * @package WordPress
 * @subpackage Customize
 * @since 4.4.0
 */
/**
 * Customize Themes Section class.
 *
 * A UI container for theme controls, which are displayed within sections.
 *
 * @since 4.2.0
 *
 * @see WP_Customize_Section
 */
class WP_Customize_Themes_Section extends WP_Customize_Section
{
    /**
     * Section type.
     *
     * @since 4.2.0
     * @var string
     */
    public $type = 'themes';
    /**
     * Theme section action.
     *
     * Defines the type of themes to load (installed, wporg, etc.).
     *
     * @since 4.9.0
     * @var string
     */
    public $action = '';
    /**
     * Theme section filter type.
     *
     * Determines whether filters are applied to loaded (local) themes or by initiating a new remote query (remote).
     * When filtering is local, the initial themes query is not paginated by default.
     *
     * @since 4.9.0
     * @var string
     */
    public $filter_type = 'local';
    /**
     * Get section parameters for JS.
     *
     * @since 4.9.0
     * @return array Exported parameters.
     */
    public function json()
    {
        $exported = parent::json();
        $exported['action'] = $this->action;
        $exported['filter_type'] = $this->filter_type;
        return $exported;
    }
    /**
     * Render a themes section as a JS template.
     *
     * The template is only rendered by PHP once, so all actions are prepared at once on the server side.
     *
     * @since 4.9.0
     */
    protected function render_template()
    {
        ?>
		<li id="accordion-section-{{ data.id }}" class="theme-section">
			<button type="button" class="customize-themes-section-title themes-section-{{ data.id }}">{{ data.title }}</button>
			<?php 
        if (current_user_can('install_themes') || is_multisite()) {
            // @todo Upload support.
            ?>
			<?php 
        }
        ?>
			<div class="customize-themes-section themes-section-{{ data.id }} control-section-content themes-php">
				<div class="theme-overlay" tabindex="0" role="dialog" aria-label="<?php 
        esc_attr_e('Theme Details');
        ?>"></div>
				<div class="theme-browser rendered">
					<div class="customize-preview-header themes-filter-bar">
						<?php 
        $this->filter_bar_content_template();
        ?>
					</div>
					<?php 
        $this->filter_drawer_content_template();
        ?>
					<div class="error unexpected-error" style="display: none; ">
						<p>
							<?php 
        printf(
            /* translators: %s: Support forums URL. */
            __('An unexpected error occurred. Something may be wrong with WordPress.org or this server&#8217;s configuration. If you continue to have problems, please try the <a href="%s">support forums</a>.'),
            __('https://wordpress.org/support/forums/')
        );
        ?>
						</p>
					</div>
					<ul class="themes">
					</ul>
					<p class="no-themes"><?php 
        _e('No themes found. Try a different search.');
        ?></p>
					<p class="no-themes-local">
						<?php 
        printf(
            /* translators: %s: "Search WordPress.org themes" button text. */
            __('No themes found. Try a different search, or %s.'),
            sprintf('<button type="button" class="button-link search-dotorg-themes">%s</button>', __('Search WordPress.org themes'))
        );
        ?>
					</p>
					<p class="spinner"></p>
				</div>
			</div>
		</li>
		<?php 
    }
    /**
     * Render the filter bar portion of a themes section as a JS template.
     *
     * The template is only rendered by PHP once, so all actions are prepared at once on the server side.
     * The filter bar container is rendered by @see `render_template()`.
     *
     * @since 4.9.0
     */
    protected function filter_bar_content_template()
    {
        ?>
		<button type="button" class="button button-primary customize-section-back customize-themes-mobile-back"><?php 
        _e('Go to theme sources');
        ?></button>
		<# if ( 'wporg' === data.action ) { #>
			<div class="search-form">
				<label for="wp-filter-search-input-{{ data.id }}" class="screen-reader-text"><?php 
        _e('Search themes&hellip;');
        ?></label>
				<input type="search" id="wp-filter-search-input-{{ data.id }}" placeholder="<?php 
        esc_attr_e('Search themes&hellip;');
        ?>" aria-describedby="{{ data.id }}-live-search-desc" class="wp-filter-search">
				<div class="search-icon" aria-hidden="true"></div>
				<span id="{{ data.id }}-live-search-desc" class="screen-reader-text"><?php 
        _e('The search results will be updated as you type.');
        ?></span>
			</div>
			<button type="button" class="button feature-filter-toggle">
				<span class="filter-count-0"><?php 
        _e('Filter themes');
        ?></span><span class="filter-count-filters">
				<?php 
        /* translators: %s: Number of filters selected. */
        printf(__('Filter themes (%s)'), '<span class="theme-filter-count">0</span>');
        ?>
				</span>
			</button>
		<# } else { #>
			<div class="themes-filter-container">
				<label for="{{ data.id }}-themes-filter" class="screen-reader-text"><?php 
        _e('Search themes&hellip;');
        ?></label>
				<input type="search" id="{{ data.id }}-themes-filter" placeholder="<?php 
        esc_attr_e('Search themes&hellip;');
        ?>" aria-describedby="{{ data.id }}-live-search-desc" class="wp-filter-search wp-filter-search-themes" />
				<div class="search-icon" aria-hidden="true"></div>
				<span id="{{ data.id }}-live-search-desc" class="screen-reader-text"><?php 
        _e('The search results will be updated as you type.');
        ?></span>
			</div>
		<# } #>
		<div class="filter-themes-count">
			<span class="themes-displayed">
				<?php 
        /* translators: %s: Number of themes displayed. */
        printf(__('%s themes'), '<span class="theme-count">0</span>');
        ?>
			</span>
		</div>
		<?php 
    }
    /**
     * Render the filter drawer portion of a themes section as a JS template.
     *
     * The filter bar container is rendered by @see `render_template()`.
     *
     * @since 4.9.0
     */
    protected function filter_drawer_content_template()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("filter_drawer_content_template") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/customize/class-wp-customize-themes-section.php at line 195")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called filter_drawer_content_template:195@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/customize/class-wp-customize-themes-section.php');
        die();
    }
}