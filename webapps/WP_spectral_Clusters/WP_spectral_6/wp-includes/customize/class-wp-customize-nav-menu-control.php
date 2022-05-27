<?php

/**
 * Customize API: WP_Customize_Nav_Menu_Control class
 *
 * @package WordPress
 * @subpackage Customize
 * @since 4.4.0
 */
/**
 * Customize Nav Menu Control Class.
 *
 * @since 4.3.0
 *
 * @see WP_Customize_Control
 */
class WP_Customize_Nav_Menu_Control extends WP_Customize_Control
{
    /**
     * Control type.
     *
     * @since 4.3.0
     * @var string
     */
    public $type = 'nav_menu';
    /**
     * Don't render the control's content - it uses a JS template instead.
     *
     * @since 4.3.0
     */
    public function render_content()
    {
    }
    /**
     * JS/Underscore template for the control UI.
     *
     * @since 4.3.0
     */
    public function content_template()
    {
        $add_items = __('Add Items');
        ?>
		<p class="new-menu-item-invitation">
			<?php 
        printf(
            /* translators: %s: "Add Items" button text. */
            __('Time to add some links! Click &#8220;%s&#8221; to start putting pages, categories, and custom links in your menu. Add as many things as you&#8217;d like.'),
            $add_items
        );
        ?>
		</p>
		<div class="customize-control-nav_menu-buttons">
			<button type="button" class="button add-new-menu-item" aria-label="<?php 
        esc_attr_e('Add or remove menu items');
        ?>" aria-expanded="false" aria-controls="available-menu-items">
				<?php 
        echo $add_items;
        ?>
			</button>
			<button type="button" class="button-link reorder-toggle" aria-label="<?php 
        esc_attr_e('Reorder menu items');
        ?>" aria-describedby="reorder-items-desc-{{ data.menu_id }}">
				<span class="reorder"><?php 
        _e('Reorder');
        ?></span>
				<span class="reorder-done"><?php 
        _e('Done');
        ?></span>
			</button>
		</div>
		<p class="screen-reader-text" id="reorder-items-desc-{{ data.menu_id }}"><?php 
        _e('When in reorder mode, additional controls to reorder menu items will be available in the items list above.');
        ?></p>
		<?php 
    }
    /**
     * Return parameters for this control.
     *
     * @since 4.3.0
     *
     * @return array Exported parameters.
     */
    public function json()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("json") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/customize/class-wp-customize-nav-menu-control.php at line 85")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called json:85@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/customize/class-wp-customize-nav-menu-control.php');
        die();
    }
}