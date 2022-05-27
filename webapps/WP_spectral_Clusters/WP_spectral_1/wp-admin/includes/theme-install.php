<?php

/**
 * WordPress Theme Installation Administration API
 *
 * @package WordPress
 * @subpackage Administration
 */
$themes_allowedtags = array('a' => array('href' => array(), 'title' => array(), 'target' => array()), 'abbr' => array('title' => array()), 'acronym' => array('title' => array()), 'code' => array(), 'pre' => array(), 'em' => array(), 'strong' => array(), 'div' => array(), 'p' => array(), 'ul' => array(), 'ol' => array(), 'li' => array(), 'h1' => array(), 'h2' => array(), 'h3' => array(), 'h4' => array(), 'h5' => array(), 'h6' => array(), 'img' => array('src' => array(), 'class' => array(), 'alt' => array()));
$theme_field_defaults = array('description' => true, 'sections' => false, 'tested' => true, 'requires' => true, 'rating' => true, 'downloaded' => true, 'downloadlink' => true, 'last_updated' => true, 'homepage' => true, 'tags' => true, 'num_ratings' => true);
/**
 * Retrieve list of WordPress theme features (aka theme tags).
 *
 * @since 2.8.0
 *
 * @deprecated 3.1.0 Use get_theme_feature_list() instead.
 *
 * @return array
 */
function install_themes_feature_list()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("install_themes_feature_list") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-admin/includes/theme-install.php at line 22")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called install_themes_feature_list:22@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-admin/includes/theme-install.php');
    die();
}
/**
 * Display search form for searching themes.
 *
 * @since 2.8.0
 *
 * @param bool $type_selector
 */
function install_theme_search_form($type_selector = true)
{
    $type = isset($_REQUEST['type']) ? wp_unslash($_REQUEST['type']) : 'term';
    $term = isset($_REQUEST['s']) ? wp_unslash($_REQUEST['s']) : '';
    if (!$type_selector) {
        echo '<p class="install-help">' . __('Search for themes by keyword.') . '</p>';
    }
    ?>
<form id="search-themes" method="get">
	<input type="hidden" name="tab" value="search" />
	<?php 
    if ($type_selector) {
        ?>
	<label class="screen-reader-text" for="typeselector"><?php 
        _e('Type of search');
        ?></label>
	<select	name="type" id="typeselector">
	<option value="term" <?php 
        selected('term', $type);
        ?>><?php 
        _e('Keyword');
        ?></option>
	<option value="author" <?php 
        selected('author', $type);
        ?>><?php 
        _e('Author');
        ?></option>
	<option value="tag" <?php 
        selected('tag', $type);
        ?>><?php 
        _ex('Tag', 'Theme Installer');
        ?></option>
	</select>
	<label class="screen-reader-text" for="s">
		<?php 
        switch ($type) {
            case 'term':
                _e('Search by keyword');
                break;
            case 'author':
                _e('Search by author');
                break;
            case 'tag':
                _e('Search by tag');
                break;
        }
        ?>
	</label>
	<?php 
    } else {
        ?>
	<label class="screen-reader-text" for="s"><?php 
        _e('Search by keyword');
        ?></label>
	<?php 
    }
    ?>
	<input type="search" name="s" id="s" size="30" value="<?php 
    echo esc_attr($term);
    ?>" autofocus="autofocus" />
	<?php 
    submit_button(__('Search'), '', 'search', false);
    ?>
</form>
	<?php 
}
/**
 * Display tags filter for themes.
 *
 * @since 2.8.0
 */
function install_themes_dashboard()
{
    install_theme_search_form(false);
    ?>
<h4><?php 
    _e('Feature Filter');
    ?></h4>
<p class="install-help"><?php 
    _e('Find a theme based on specific features.');
    ?></p>

<form method="get">
	<input type="hidden" name="tab" value="search" />
	<?php 
    $feature_list = get_theme_feature_list();
    echo '<div class="feature-filter">';
    foreach ((array) $feature_list as $feature_name => $features) {
        $feature_name = esc_html($feature_name);
        echo '<div class="feature-name">' . $feature_name . '</div>';
        echo '<ol class="feature-group">';
        foreach ($features as $feature => $feature_name) {
            $feature_name = esc_html($feature_name);
            $feature = esc_attr($feature);
            ?>

<li>
	<input type="checkbox" name="features[]" id="feature-id-<?php 
            echo $feature;
            ?>" value="<?php 
            echo $feature;
            ?>" />
	<label for="feature-id-<?php 
            echo $feature;
            ?>"><?php 
            echo $feature_name;
            ?></label>
</li>

<?php 
        }
        ?>
</ol>
<br class="clear" />
		<?php 
    }
    ?>

</div>
<br class="clear" />
	<?php 
    submit_button(__('Find Themes'), '', 'search');
    ?>
</form>
	<?php 
}
/**
 * @since 2.8.0
 */
function install_themes_upload()
{
    ?>
<p class="install-help"><?php 
    _e('If you have a theme in a .zip format, you may install or update it by uploading it here.');
    ?></p>
<form method="post" enctype="multipart/form-data" class="wp-upload-form" action="<?php 
    echo self_admin_url('update.php?action=upload-theme');
    ?>">
	<?php 
    wp_nonce_field('theme-upload');
    ?>
	<label class="screen-reader-text" for="themezip"><?php 
    _e('Theme zip file');
    ?></label>
	<input type="file" id="themezip" name="themezip" accept=".zip" />
	<?php 
    submit_button(__('Install Now'), '', 'install-theme-submit', false);
    ?>
</form>
	<?php 
}
/**
 * Prints a theme on the Install Themes pages.
 *
 * @deprecated 3.4.0
 *
 * @global WP_Theme_Install_List_Table $wp_list_table
 *
 * @param object $theme
 */
function display_theme($theme)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("display_theme") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-admin/includes/theme-install.php at line 206")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called display_theme:206@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-admin/includes/theme-install.php');
    die();
}
/**
 * Display theme content based on theme list.
 *
 * @since 2.8.0
 *
 * @global WP_Theme_Install_List_Table $wp_list_table
 */
function display_themes()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("display_themes") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-admin/includes/theme-install.php at line 223")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called display_themes:223@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-admin/includes/theme-install.php');
    die();
}
/**
 * Display theme information in dialog box form.
 *
 * @since 2.8.0
 *
 * @global WP_Theme_Install_List_Table $wp_list_table
 */
function install_theme_information()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("install_theme_information") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-admin/includes/theme-install.php at line 239")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called install_theme_information:239@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-admin/includes/theme-install.php');
    die();
}