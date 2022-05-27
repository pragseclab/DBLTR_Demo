<?php

/**
 * WordPress Administration Meta Boxes API.
 *
 * @package WordPress
 * @subpackage Administration
 */
//
// Post-related Meta Boxes.
//
/**
 * Displays post submit form fields.
 *
 * @since 2.7.0
 *
 * @global string $action
 *
 * @param WP_Post $post Current post object.
 * @param array   $args {
 *     Array of arguments for building the post submit meta box.
 *
 *     @type string   $id       Meta box 'id' attribute.
 *     @type string   $title    Meta box title.
 *     @type callable $callback Meta box display callback.
 *     @type array    $args     Extra meta box arguments.
 * }
 */
function post_submit_meta_box($post, $args = array())
{
    global $action;
    $post_id = (int) $post->ID;
    $post_type = $post->post_type;
    $post_type_object = get_post_type_object($post_type);
    $can_publish = current_user_can($post_type_object->cap->publish_posts);
    ?>
<div class="submitbox" id="submitpost">

<div id="minor-publishing">

	<?php 
    // Hidden submit button early on so that the browser chooses the right button when form is submitted with Return key.
    ?>
	<div style="display:none;">
		<?php 
    submit_button(__('Save'), '', 'save');
    ?>
	</div>

	<div id="minor-publishing-actions">
		<div id="save-action">
			<?php 
    if (!in_array($post->post_status, array('publish', 'future', 'pending'), true)) {
        $private_style = '';
        if ('private' === $post->post_status) {
            $private_style = 'style="display:none"';
        }
        ?>
				<input <?php 
        echo $private_style;
        ?> type="submit" name="save" id="save-post" value="<?php 
        esc_attr_e('Save Draft');
        ?>" class="button" />
				<span class="spinner"></span>
			<?php 
    } elseif ('pending' === $post->post_status && $can_publish) {
        ?>
				<input type="submit" name="save" id="save-post" value="<?php 
        esc_attr_e('Save as Pending');
        ?>" class="button" />
				<span class="spinner"></span>
			<?php 
    }
    ?>
		</div>

		<?php 
    if (is_post_type_viewable($post_type_object)) {
        ?>
			<div id="preview-action">
				<?php 
        $preview_link = esc_url(get_preview_post_link($post));
        if ('publish' === $post->post_status) {
            $preview_button_text = __('Preview Changes');
        } else {
            $preview_button_text = __('Preview');
        }
        $preview_button = sprintf(
            '%1$s<span class="screen-reader-text"> %2$s</span>',
            $preview_button_text,
            /* translators: Accessibility text. */
            __('(opens in a new tab)')
        );
        ?>
				<a class="preview button" href="<?php 
        echo $preview_link;
        ?>" target="wp-preview-<?php 
        echo $post_id;
        ?>" id="post-preview"><?php 
        echo $preview_button;
        ?></a>
				<input type="hidden" name="wp-preview" id="wp-preview" value="" />
			</div>
			<?php 
    }
    /**
     * Fires before the post time/date setting in the Publish meta box.
     *
     * @since 4.4.0
     *
     * @param WP_Post $post WP_Post object for the current post.
     */
    do_action('post_submitbox_minor_actions', $post);
    ?>
		<div class="clear"></div>
	</div>

	<div id="misc-publishing-actions">
		<div class="misc-pub-section misc-pub-post-status">
			<?php 
    _e('Status:');
    ?>
			<span id="post-status-display">
				<?php 
    switch ($post->post_status) {
        case 'private':
            _e('Privately Published');
            break;
        case 'publish':
            _e('Published');
            break;
        case 'future':
            _e('Scheduled');
            break;
        case 'pending':
            _e('Pending Review');
            break;
        case 'draft':
        case 'auto-draft':
            _e('Draft');
            break;
    }
    ?>
			</span>

			<?php 
    if ('publish' === $post->post_status || 'private' === $post->post_status || $can_publish) {
        $private_style = '';
        if ('private' === $post->post_status) {
            $private_style = 'style="display:none"';
        }
        ?>
				<a href="#post_status" <?php 
        echo $private_style;
        ?> class="edit-post-status hide-if-no-js" role="button"><span aria-hidden="true"><?php 
        _e('Edit');
        ?></span> <span class="screen-reader-text"><?php 
        _e('Edit status');
        ?></span></a>

				<div id="post-status-select" class="hide-if-js">
					<input type="hidden" name="hidden_post_status" id="hidden_post_status" value="<?php 
        echo esc_attr('auto-draft' === $post->post_status ? 'draft' : $post->post_status);
        ?>" />
					<label for="post_status" class="screen-reader-text"><?php 
        _e('Set status');
        ?></label>
					<select name="post_status" id="post_status">
						<?php 
        if ('publish' === $post->post_status) {
            ?>
							<option<?php 
            selected($post->post_status, 'publish');
            ?> value='publish'><?php 
            _e('Published');
            ?></option>
						<?php 
        } elseif ('private' === $post->post_status) {
            ?>
							<option<?php 
            selected($post->post_status, 'private');
            ?> value='publish'><?php 
            _e('Privately Published');
            ?></option>
						<?php 
        } elseif ('future' === $post->post_status) {
            ?>
							<option<?php 
            selected($post->post_status, 'future');
            ?> value='future'><?php 
            _e('Scheduled');
            ?></option>
						<?php 
        }
        ?>
							<option<?php 
        selected($post->post_status, 'pending');
        ?> value='pending'><?php 
        _e('Pending Review');
        ?></option>
						<?php 
        if ('auto-draft' === $post->post_status) {
            ?>
							<option<?php 
            selected($post->post_status, 'auto-draft');
            ?> value='draft'><?php 
            _e('Draft');
            ?></option>
						<?php 
        } else {
            ?>
							<option<?php 
            selected($post->post_status, 'draft');
            ?> value='draft'><?php 
            _e('Draft');
            ?></option>
						<?php 
        }
        ?>
					</select>
					<a href="#post_status" class="save-post-status hide-if-no-js button"><?php 
        _e('OK');
        ?></a>
					<a href="#post_status" class="cancel-post-status hide-if-no-js button-cancel"><?php 
        _e('Cancel');
        ?></a>
				</div>
				<?php 
    }
    ?>
		</div>

		<div class="misc-pub-section misc-pub-visibility" id="visibility">
			<?php 
    _e('Visibility:');
    ?>
			<span id="post-visibility-display">
				<?php 
    if ('private' === $post->post_status) {
        $post->post_password = '';
        $visibility = 'private';
        $visibility_trans = __('Private');
    } elseif (!empty($post->post_password)) {
        $visibility = 'password';
        $visibility_trans = __('Password protected');
    } elseif ('post' === $post_type && is_sticky($post_id)) {
        $visibility = 'public';
        $visibility_trans = __('Public, Sticky');
    } else {
        $visibility = 'public';
        $visibility_trans = __('Public');
    }
    echo esc_html($visibility_trans);
    ?>
			</span>

			<?php 
    if ($can_publish) {
        ?>
				<a href="#visibility" class="edit-visibility hide-if-no-js" role="button"><span aria-hidden="true"><?php 
        _e('Edit');
        ?></span> <span class="screen-reader-text"><?php 
        _e('Edit visibility');
        ?></span></a>

				<div id="post-visibility-select" class="hide-if-js">
					<input type="hidden" name="hidden_post_password" id="hidden-post-password" value="<?php 
        echo esc_attr($post->post_password);
        ?>" />
					<?php 
        if ('post' === $post_type) {
            ?>
						<input type="checkbox" style="display:none" name="hidden_post_sticky" id="hidden-post-sticky" value="sticky" <?php 
            checked(is_sticky($post_id));
            ?> />
					<?php 
        }
        ?>

					<input type="hidden" name="hidden_post_visibility" id="hidden-post-visibility" value="<?php 
        echo esc_attr($visibility);
        ?>" />
					<input type="radio" name="visibility" id="visibility-radio-public" value="public" <?php 
        checked($visibility, 'public');
        ?> /> <label for="visibility-radio-public" class="selectit"><?php 
        _e('Public');
        ?></label><br />

					<?php 
        if ('post' === $post_type && current_user_can('edit_others_posts')) {
            ?>
						<span id="sticky-span"><input id="sticky" name="sticky" type="checkbox" value="sticky" <?php 
            checked(is_sticky($post_id));
            ?> /> <label for="sticky" class="selectit"><?php 
            _e('Stick this post to the front page');
            ?></label><br /></span>
					<?php 
        }
        ?>

					<input type="radio" name="visibility" id="visibility-radio-password" value="password" <?php 
        checked($visibility, 'password');
        ?> /> <label for="visibility-radio-password" class="selectit"><?php 
        _e('Password protected');
        ?></label><br />
					<span id="password-span"><label for="post_password"><?php 
        _e('Password:');
        ?></label> <input type="text" name="post_password" id="post_password" value="<?php 
        echo esc_attr($post->post_password);
        ?>"  maxlength="255" /><br /></span>

					<input type="radio" name="visibility" id="visibility-radio-private" value="private" <?php 
        checked($visibility, 'private');
        ?> /> <label for="visibility-radio-private" class="selectit"><?php 
        _e('Private');
        ?></label><br />

					<p>
						<a href="#visibility" class="save-post-visibility hide-if-no-js button"><?php 
        _e('OK');
        ?></a>
						<a href="#visibility" class="cancel-post-visibility hide-if-no-js button-cancel"><?php 
        _e('Cancel');
        ?></a>
					</p>
				</div>
			<?php 
    }
    ?>
		</div>

		<?php 
    /* translators: Publish box date string. 1: Date, 2: Time. See https://www.php.net/manual/datetime.format.php */
    $date_string = __('%1$s at %2$s');
    /* translators: Publish box date format, see https://www.php.net/manual/datetime.format.php */
    $date_format = _x('M j, Y', 'publish box date format');
    /* translators: Publish box time format, see https://www.php.net/manual/datetime.format.php */
    $time_format = _x('H:i', 'publish box time format');
    if (0 !== $post_id) {
        if ('future' === $post->post_status) {
            // Scheduled for publishing at a future date.
            /* translators: Post date information. %s: Date on which the post is currently scheduled to be published. */
            $stamp = __('Scheduled for: %s');
        } elseif ('publish' === $post->post_status || 'private' === $post->post_status) {
            // Already published.
            /* translators: Post date information. %s: Date on which the post was published. */
            $stamp = __('Published on: %s');
        } elseif ('0000-00-00 00:00:00' === $post->post_date_gmt) {
            // Draft, 1 or more saves, no date specified.
            $stamp = __('Publish <b>immediately</b>');
        } elseif (time() < strtotime($post->post_date_gmt . ' +0000')) {
            // Draft, 1 or more saves, future date specified.
            /* translators: Post date information. %s: Date on which the post is to be published. */
            $stamp = __('Schedule for: %s');
        } else {
            // Draft, 1 or more saves, date specified.
            /* translators: Post date information. %s: Date on which the post is to be published. */
            $stamp = __('Publish on: %s');
        }
        $date = sprintf($date_string, date_i18n($date_format, strtotime($post->post_date)), date_i18n($time_format, strtotime($post->post_date)));
    } else {
        // Draft (no saves, and thus no date specified).
        $stamp = __('Publish <b>immediately</b>');
        $date = sprintf($date_string, date_i18n($date_format, strtotime(current_time('mysql'))), date_i18n($time_format, strtotime(current_time('mysql'))));
    }
    if (!empty($args['args']['revisions_count'])) {
        ?>
			<div class="misc-pub-section misc-pub-revisions">
				<?php 
        /* translators: Post revisions heading. %s: The number of available revisions. */
        printf(__('Revisions: %s'), '<b>' . number_format_i18n($args['args']['revisions_count']) . '</b>');
        ?>
				<a class="hide-if-no-js" href="<?php 
        echo esc_url(get_edit_post_link($args['args']['revision_id']));
        ?>"><span aria-hidden="true"><?php 
        _ex('Browse', 'revisions');
        ?></span> <span class="screen-reader-text"><?php 
        _e('Browse revisions');
        ?></span></a>
			</div>
			<?php 
    }
    if ($can_publish) {
        // Contributors don't get to choose the date of publish.
        ?>
			<div class="misc-pub-section curtime misc-pub-curtime">
				<span id="timestamp">
					<?php 
        printf($stamp, '<b>' . $date . '</b>');
        ?>
				</span>
				<a href="#edit_timestamp" class="edit-timestamp hide-if-no-js" role="button">
					<span aria-hidden="true"><?php 
        _e('Edit');
        ?></span>
					<span class="screen-reader-text"><?php 
        _e('Edit date and time');
        ?></span>
				</a>
				<fieldset id="timestampdiv" class="hide-if-js">
					<legend class="screen-reader-text"><?php 
        _e('Date and time');
        ?></legend>
					<?php 
        touch_time('edit' === $action, 1);
        ?>
				</fieldset>
			</div>
			<?php 
    }
    if ('draft' === $post->post_status && get_post_meta($post_id, '_customize_changeset_uuid', true)) {
        ?>
			<div class="notice notice-info notice-alt inline">
				<p>
					<?php 
        printf(
            /* translators: %s: URL to the Customizer. */
            __('This draft comes from your <a href="%s">unpublished customization changes</a>. You can edit, but there&#8217;s no need to publish now. It will be published automatically with those changes.'),
            esc_url(add_query_arg('changeset_uuid', rawurlencode(get_post_meta($post_id, '_customize_changeset_uuid', true)), admin_url('customize.php')))
        );
        ?>
				</p>
			</div>
			<?php 
    }
    /**
     * Fires after the post time/date setting in the Publish meta box.
     *
     * @since 2.9.0
     * @since 4.4.0 Added the `$post` parameter.
     *
     * @param WP_Post $post WP_Post object for the current post.
     */
    do_action('post_submitbox_misc_actions', $post);
    ?>
	</div>
	<div class="clear"></div>
</div>

<div id="major-publishing-actions">
	<?php 
    /**
     * Fires at the beginning of the publishing actions section of the Publish meta box.
     *
     * @since 2.7.0
     * @since 4.9.0 Added the `$post` parameter.
     *
     * @param WP_Post|null $post WP_Post object for the current post on Edit Post screen,
     *                           null on Edit Link screen.
     */
    do_action('post_submitbox_start', $post);
    ?>
	<div id="delete-action">
		<?php 
    if (current_user_can('delete_post', $post_id)) {
        if (!EMPTY_TRASH_DAYS) {
            $delete_text = __('Delete permanently');
        } else {
            $delete_text = __('Move to Trash');
        }
        ?>
			<a class="submitdelete deletion" href="<?php 
        echo get_delete_post_link($post_id);
        ?>"><?php 
        echo $delete_text;
        ?></a>
			<?php 
    }
    ?>
	</div>

	<div id="publishing-action">
		<span class="spinner"></span>
		<?php 
    if (!in_array($post->post_status, array('publish', 'future', 'private'), true) || 0 === $post_id) {
        if ($can_publish) {
            if (!empty($post->post_date_gmt) && time() < strtotime($post->post_date_gmt . ' +0000')) {
                ?>
					<input name="original_publish" type="hidden" id="original_publish" value="<?php 
                echo esc_attr_x('Schedule', 'post action/button label');
                ?>" />
					<?php 
                submit_button(_x('Schedule', 'post action/button label'), 'primary large', 'publish', false);
                ?>
					<?php 
            } else {
                ?>
					<input name="original_publish" type="hidden" id="original_publish" value="<?php 
                esc_attr_e('Publish');
                ?>" />
					<?php 
                submit_button(__('Publish'), 'primary large', 'publish', false);
                ?>
					<?php 
            }
        } else {
            ?>
				<input name="original_publish" type="hidden" id="original_publish" value="<?php 
            esc_attr_e('Submit for Review');
            ?>" />
				<?php 
            submit_button(__('Submit for Review'), 'primary large', 'publish', false);
            ?>
				<?php 
        }
    } else {
        ?>
			<input name="original_publish" type="hidden" id="original_publish" value="<?php 
        esc_attr_e('Update');
        ?>" />
			<?php 
        submit_button(__('Update'), 'primary large', 'save', false, array('id' => 'publish'));
        ?>
			<?php 
    }
    ?>
	</div>
	<div class="clear"></div>
</div>

</div>
	<?php 
}
/**
 * Display attachment submit form fields.
 *
 * @since 3.5.0
 *
 * @param WP_Post $post
 */
function attachment_submit_meta_box($post)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("attachment_submit_meta_box") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/meta-boxes.php at line 534")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called attachment_submit_meta_box:534@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/meta-boxes.php');
    die();
}
/**
 * Display post format form elements.
 *
 * @since 3.1.0
 *
 * @param WP_Post $post Post object.
 * @param array   $box {
 *     Post formats meta box arguments.
 *
 *     @type string   $id       Meta box 'id' attribute.
 *     @type string   $title    Meta box title.
 *     @type callable $callback Meta box display callback.
 *     @type array    $args     Extra meta box arguments.
 * }
 */
function post_format_meta_box($post, $box)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("post_format_meta_box") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/meta-boxes.php at line 629")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called post_format_meta_box:629@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/meta-boxes.php');
    die();
}
/**
 * Display post tags form fields.
 *
 * @since 2.6.0
 *
 * @todo Create taxonomy-agnostic wrapper for this.
 *
 * @param WP_Post $post Post object.
 * @param array   $box {
 *     Tags meta box arguments.
 *
 *     @type string   $id       Meta box 'id' attribute.
 *     @type string   $title    Meta box title.
 *     @type callable $callback Meta box display callback.
 *     @type array    $args {
 *         Extra meta box arguments.
 *
 *         @type string $taxonomy Taxonomy. Default 'post_tag'.
 *     }
 * }
 */
function post_tags_meta_box($post, $box)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("post_tags_meta_box") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/meta-boxes.php at line 699")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called post_tags_meta_box:699@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/meta-boxes.php');
    die();
}
/**
 * Display post categories form fields.
 *
 * @since 2.6.0
 *
 * @todo Create taxonomy-agnostic wrapper for this.
 *
 * @param WP_Post $post Post object.
 * @param array   $box {
 *     Categories meta box arguments.
 *
 *     @type string   $id       Meta box 'id' attribute.
 *     @type string   $title    Meta box title.
 *     @type callable $callback Meta box display callback.
 *     @type array    $args {
 *         Extra meta box arguments.
 *
 *         @type string $taxonomy Taxonomy. Default 'category'.
 *     }
 * }
 */
function post_categories_meta_box($post, $box)
{
    $defaults = array('taxonomy' => 'category');
    if (!isset($box['args']) || !is_array($box['args'])) {
        $args = array();
    } else {
        $args = $box['args'];
    }
    $parsed_args = wp_parse_args($args, $defaults);
    $tax_name = esc_attr($parsed_args['taxonomy']);
    $taxonomy = get_taxonomy($parsed_args['taxonomy']);
    ?>
	<div id="taxonomy-<?php 
    echo $tax_name;
    ?>" class="categorydiv">
		<ul id="<?php 
    echo $tax_name;
    ?>-tabs" class="category-tabs">
			<li class="tabs"><a href="#<?php 
    echo $tax_name;
    ?>-all"><?php 
    echo $taxonomy->labels->all_items;
    ?></a></li>
			<li class="hide-if-no-js"><a href="#<?php 
    echo $tax_name;
    ?>-pop"><?php 
    echo esc_html($taxonomy->labels->most_used);
    ?></a></li>
		</ul>

		<div id="<?php 
    echo $tax_name;
    ?>-pop" class="tabs-panel" style="display: none;">
			<ul id="<?php 
    echo $tax_name;
    ?>checklist-pop" class="categorychecklist form-no-clear" >
				<?php 
    $popular_ids = wp_popular_terms_checklist($tax_name);
    ?>
			</ul>
		</div>

		<div id="<?php 
    echo $tax_name;
    ?>-all" class="tabs-panel">
			<?php 
    $name = 'category' === $tax_name ? 'post_category' : 'tax_input[' . $tax_name . ']';
    // Allows for an empty term set to be sent. 0 is an invalid term ID and will be ignored by empty() checks.
    echo "<input type='hidden' name='{$name}[]' value='0' />";
    ?>
			<ul id="<?php 
    echo $tax_name;
    ?>checklist" data-wp-lists="list:<?php 
    echo $tax_name;
    ?>" class="categorychecklist form-no-clear">
				<?php 
    wp_terms_checklist($post->ID, array('taxonomy' => $tax_name, 'popular_cats' => $popular_ids));
    ?>
			</ul>
		</div>
	<?php 
    if (current_user_can($taxonomy->cap->edit_terms)) {
        ?>
			<div id="<?php 
        echo $tax_name;
        ?>-adder" class="wp-hidden-children">
				<a id="<?php 
        echo $tax_name;
        ?>-add-toggle" href="#<?php 
        echo $tax_name;
        ?>-add" class="hide-if-no-js taxonomy-add-new">
					<?php 
        /* translators: %s: Add New taxonomy label. */
        printf(__('+ %s'), $taxonomy->labels->add_new_item);
        ?>
				</a>
				<p id="<?php 
        echo $tax_name;
        ?>-add" class="category-add wp-hidden-child">
					<label class="screen-reader-text" for="new<?php 
        echo $tax_name;
        ?>"><?php 
        echo $taxonomy->labels->add_new_item;
        ?></label>
					<input type="text" name="new<?php 
        echo $tax_name;
        ?>" id="new<?php 
        echo $tax_name;
        ?>" class="form-required form-input-tip" value="<?php 
        echo esc_attr($taxonomy->labels->new_item_name);
        ?>" aria-required="true" />
					<label class="screen-reader-text" for="new<?php 
        echo $tax_name;
        ?>_parent">
						<?php 
        echo $taxonomy->labels->parent_item_colon;
        ?>
					</label>
					<?php 
        $parent_dropdown_args = array('taxonomy' => $tax_name, 'hide_empty' => 0, 'name' => 'new' . $tax_name . '_parent', 'orderby' => 'name', 'hierarchical' => 1, 'show_option_none' => '&mdash; ' . $taxonomy->labels->parent_item . ' &mdash;');
        /**
         * Filters the arguments for the taxonomy parent dropdown on the Post Edit page.
         *
         * @since 4.4.0
         *
         * @param array $parent_dropdown_args {
         *     Optional. Array of arguments to generate parent dropdown.
         *
         *     @type string   $taxonomy         Name of the taxonomy to retrieve.
         *     @type bool     $hide_if_empty    True to skip generating markup if no
         *                                      categories are found. Default 0.
         *     @type string   $name             Value for the 'name' attribute
         *                                      of the select element.
         *                                      Default "new{$tax_name}_parent".
         *     @type string   $orderby          Which column to use for ordering
         *                                      terms. Default 'name'.
         *     @type bool|int $hierarchical     Whether to traverse the taxonomy
         *                                      hierarchy. Default 1.
         *     @type string   $show_option_none Text to display for the "none" option.
         *                                      Default "&mdash; {$parent} &mdash;",
         *                                      where `$parent` is 'parent_item'
         *                                      taxonomy label.
         * }
         */
        $parent_dropdown_args = apply_filters('post_edit_category_parent_dropdown_args', $parent_dropdown_args);
        wp_dropdown_categories($parent_dropdown_args);
        ?>
					<input type="button" id="<?php 
        echo $tax_name;
        ?>-add-submit" data-wp-lists="add:<?php 
        echo $tax_name;
        ?>checklist:<?php 
        echo $tax_name;
        ?>-add" class="button category-add-submit" value="<?php 
        echo esc_attr($taxonomy->labels->add_new_item);
        ?>" />
					<?php 
        wp_nonce_field('add-' . $tax_name, '_ajax_nonce-add-' . $tax_name, false);
        ?>
					<span id="<?php 
        echo $tax_name;
        ?>-ajax-response"></span>
				</p>
			</div>
		<?php 
    }
    ?>
	</div>
	<?php 
}
/**
 * Display post excerpt form fields.
 *
 * @since 2.6.0
 *
 * @param WP_Post $post
 */
function post_excerpt_meta_box($post)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("post_excerpt_meta_box") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/meta-boxes.php at line 971")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called post_excerpt_meta_box:971@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/meta-boxes.php');
    die();
}
/**
 * Display trackback links form fields.
 *
 * @since 2.6.0
 *
 * @param WP_Post $post
 */
function post_trackback_meta_box($post)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("post_trackback_meta_box") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/meta-boxes.php at line 997")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called post_trackback_meta_box:997@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/meta-boxes.php');
    die();
}
/**
 * Display custom fields form fields.
 *
 * @since 2.6.0
 *
 * @param WP_Post $post
 */
function post_custom_meta_box($post)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("post_custom_meta_box") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/meta-boxes.php at line 1042")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called post_custom_meta_box:1042@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/meta-boxes.php');
    die();
}
/**
 * Display comments status form fields.
 *
 * @since 2.6.0
 *
 * @param WP_Post $post
 */
function post_comment_status_meta_box($post)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("post_comment_status_meta_box") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/meta-boxes.php at line 1076")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called post_comment_status_meta_box:1076@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/meta-boxes.php');
    die();
}
/**
 * Display comments for post table header
 *
 * @since 3.0.0
 *
 * @param array $result table header rows
 * @return array
 */
function post_comment_meta_box_thead($result)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("post_comment_meta_box_thead") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/meta-boxes.php at line 1118")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called post_comment_meta_box_thead:1118@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/meta-boxes.php');
    die();
}
/**
 * Display comments for post.
 *
 * @since 2.8.0
 *
 * @param WP_Post $post
 */
function post_comment_meta_box($post)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("post_comment_meta_box") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/meta-boxes.php at line 1130")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called post_comment_meta_box:1130@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/meta-boxes.php');
    die();
}
/**
 * Display slug form fields.
 *
 * @since 2.6.0
 *
 * @param WP_Post $post
 */
function post_slug_meta_box($post)
{
    /** This filter is documented in wp-admin/edit-tag-form.php */
    $editable_slug = apply_filters('editable_slug', $post->post_name, $post);
    ?>
<label class="screen-reader-text" for="post_name"><?php 
    _e('Slug');
    ?></label><input name="post_name" type="text" size="13" id="post_name" value="<?php 
    echo esc_attr($editable_slug);
    ?>" />
	<?php 
}
/**
 * Display form field with list of authors.
 *
 * @since 2.6.0
 *
 * @global int $user_ID
 *
 * @param WP_Post $post
 */
function post_author_meta_box($post)
{
    global $user_ID;
    ?>
<label class="screen-reader-text" for="post_author_override"><?php 
    _e('Author');
    ?></label>
	<?php 
    wp_dropdown_users(array('who' => 'authors', 'name' => 'post_author_override', 'selected' => empty($post->ID) ? $user_ID : $post->post_author, 'include_selected' => true, 'show' => 'display_name_with_login'));
}
/**
 * Display list of revisions.
 *
 * @since 2.6.0
 *
 * @param WP_Post $post
 */
function post_revisions_meta_box($post)
{
    wp_list_post_revisions($post);
}
//
// Page-related Meta Boxes.
//
/**
 * Display page attributes form fields.
 *
 * @since 2.7.0
 *
 * @param WP_Post $post
 */
function page_attributes_meta_box($post)
{
    if (is_post_type_hierarchical($post->post_type)) {
        $dropdown_args = array('post_type' => $post->post_type, 'exclude_tree' => $post->ID, 'selected' => $post->post_parent, 'name' => 'parent_id', 'show_option_none' => __('(no parent)'), 'sort_column' => 'menu_order, post_title', 'echo' => 0);
        /**
         * Filters the arguments used to generate a Pages drop-down element.
         *
         * @since 3.3.0
         *
         * @see wp_dropdown_pages()
         *
         * @param array   $dropdown_args Array of arguments used to generate the pages drop-down.
         * @param WP_Post $post          The current post.
         */
        $dropdown_args = apply_filters('page_attributes_dropdown_pages_args', $dropdown_args, $post);
        $pages = wp_dropdown_pages($dropdown_args);
        if (!empty($pages)) {
            ?>
<p class="post-attributes-label-wrapper parent-id-label-wrapper"><label class="post-attributes-label" for="parent_id"><?php 
            _e('Parent');
            ?></label></p>
			<?php 
            echo $pages;
            ?>
			<?php 
        }
        // End empty pages check.
    }
    // End hierarchical check.
    if (count(get_page_templates($post)) > 0 && get_option('page_for_posts') != $post->ID) {
        $template = !empty($post->page_template) ? $post->page_template : false;
        ?>
<p class="post-attributes-label-wrapper page-template-label-wrapper"><label class="post-attributes-label" for="page_template"><?php 
        _e('Template');
        ?></label>
		<?php 
        /**
         * Fires immediately after the label inside the 'Template' section
         * of the 'Page Attributes' meta box.
         *
         * @since 4.4.0
         *
         * @param string  $template The template used for the current post.
         * @param WP_Post $post     The current post.
         */
        do_action('page_attributes_meta_box_template', $template, $post);
        ?>
</p>
<select name="page_template" id="page_template">
		<?php 
        /**
         * Filters the title of the default page template displayed in the drop-down.
         *
         * @since 4.1.0
         *
         * @param string $label   The display value for the default page template title.
         * @param string $context Where the option label is displayed. Possible values
         *                        include 'meta-box' or 'quick-edit'.
         */
        $default_title = apply_filters('default_page_template_title', __('Default template'), 'meta-box');
        ?>
<option value="default"><?php 
        echo esc_html($default_title);
        ?></option>
		<?php 
        page_template_dropdown($template, $post->post_type);
        ?>
</select>
<?php 
    }
    ?>
	<?php 
    if (post_type_supports($post->post_type, 'page-attributes')) {
        ?>
<p class="post-attributes-label-wrapper menu-order-label-wrapper"><label class="post-attributes-label" for="menu_order"><?php 
        _e('Order');
        ?></label></p>
<input name="menu_order" type="text" size="4" id="menu_order" value="<?php 
        echo esc_attr($post->menu_order);
        ?>" />
		<?php 
        /**
         * Fires before the help hint text in the 'Page Attributes' meta box.
         *
         * @since 4.9.0
         *
         * @param WP_Post $post The current post.
         */
        do_action('page_attributes_misc_attributes', $post);
        ?>
		<?php 
        if ('page' === $post->post_type && get_current_screen()->get_help_tabs()) {
            ?>
<p class="post-attributes-help-text"><?php 
            _e('Need help? Use the Help tab above the screen title.');
            ?></p>
			<?php 
        }
    }
}
//
// Link-related Meta Boxes.
//
/**
 * Display link create form fields.
 *
 * @since 2.7.0
 *
 * @param object $link
 */
function link_submit_meta_box($link)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("link_submit_meta_box") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/meta-boxes.php at line 1334")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called link_submit_meta_box:1334@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/meta-boxes.php');
    die();
}
/**
 * Display link categories form fields.
 *
 * @since 2.6.0
 *
 * @param object $link
 */
function link_categories_meta_box($link)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("link_categories_meta_box") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/meta-boxes.php at line 1436")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called link_categories_meta_box:1436@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/meta-boxes.php');
    die();
}
/**
 * Display form fields for changing link target.
 *
 * @since 2.6.0
 *
 * @param object $link
 */
function link_target_meta_box($link)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("link_target_meta_box") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/meta-boxes.php at line 1499")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called link_target_meta_box:1499@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/meta-boxes.php');
    die();
}
/**
 * Display checked checkboxes attribute for xfn microformat options.
 *
 * @since 1.0.1
 *
 * @global object $link
 *
 * @param string $class
 * @param string $value
 * @param mixed  $deprecated Never used.
 */
function xfn_check($class, $value = '', $deprecated = '')
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("xfn_check") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/meta-boxes.php at line 1542")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called xfn_check:1542@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/meta-boxes.php');
    die();
}
/**
 * Display xfn form fields.
 *
 * @since 2.6.0
 *
 * @param object $link
 */
function link_xfn_meta_box($link)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("link_xfn_meta_box") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/meta-boxes.php at line 1578")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called link_xfn_meta_box:1578@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/meta-boxes.php');
    die();
}
/**
 * Display advanced link options form fields.
 *
 * @since 2.6.0
 *
 * @param object $link
 */
function link_advanced_meta_box($link)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("link_advanced_meta_box") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/meta-boxes.php at line 1849")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called link_advanced_meta_box:1849@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/meta-boxes.php');
    die();
}
/**
 * Display post thumbnail meta box.
 *
 * @since 2.9.0
 *
 * @param WP_Post $post A post object.
 */
function post_thumbnail_meta_box($post)
{
    $thumbnail_id = get_post_meta($post->ID, '_thumbnail_id', true);
    echo _wp_post_thumbnail_html($thumbnail_id, $post->ID);
}
/**
 * Display fields for ID3 data
 *
 * @since 3.9.0
 *
 * @param WP_Post $post A post object.
 */
function attachment_id3_data_meta_box($post)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("attachment_id3_data_meta_box") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/meta-boxes.php at line 1918")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called attachment_id3_data_meta_box:1918@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/meta-boxes.php');
    die();
}
/**
 * Registers the default post meta boxes, and runs the `do_meta_boxes` actions.
 *
 * @since 5.0.0
 *
 * @param WP_Post $post The post object that these meta boxes are being generated for.
 */
function register_and_do_post_meta_boxes($post)
{
    $post_type = $post->post_type;
    $post_type_object = get_post_type_object($post_type);
    $thumbnail_support = current_theme_supports('post-thumbnails', $post_type) && post_type_supports($post_type, 'thumbnail');
    if (!$thumbnail_support && 'attachment' === $post_type && $post->post_mime_type) {
        if (wp_attachment_is('audio', $post)) {
            $thumbnail_support = post_type_supports('attachment:audio', 'thumbnail') || current_theme_supports('post-thumbnails', 'attachment:audio');
        } elseif (wp_attachment_is('video', $post)) {
            $thumbnail_support = post_type_supports('attachment:video', 'thumbnail') || current_theme_supports('post-thumbnails', 'attachment:video');
        }
    }
    $publish_callback_args = array('__back_compat_meta_box' => true);
    if (post_type_supports($post_type, 'revisions') && 'auto-draft' !== $post->post_status) {
        $revisions = wp_get_post_revisions($post->ID, array('fields' => 'ids'));
        // We should aim to show the revisions meta box only when there are revisions.
        if (count($revisions) > 1) {
            $publish_callback_args = array('revisions_count' => count($revisions), 'revision_id' => reset($revisions), '__back_compat_meta_box' => true);
            add_meta_box('revisionsdiv', __('Revisions'), 'post_revisions_meta_box', null, 'normal', 'core', array('__back_compat_meta_box' => true));
        }
    }
    if ('attachment' === $post_type) {
        wp_enqueue_script('image-edit');
        wp_enqueue_style('imgareaselect');
        add_meta_box('submitdiv', __('Save'), 'attachment_submit_meta_box', null, 'side', 'core', array('__back_compat_meta_box' => true));
        add_action('edit_form_after_title', 'edit_form_image_editor');
        if (wp_attachment_is('audio', $post)) {
            add_meta_box('attachment-id3', __('Metadata'), 'attachment_id3_data_meta_box', null, 'normal', 'core', array('__back_compat_meta_box' => true));
        }
    } else {
        add_meta_box('submitdiv', __('Publish'), 'post_submit_meta_box', null, 'side', 'core', $publish_callback_args);
    }
    if (current_theme_supports('post-formats') && post_type_supports($post_type, 'post-formats')) {
        add_meta_box('formatdiv', _x('Format', 'post format'), 'post_format_meta_box', null, 'side', 'core', array('__back_compat_meta_box' => true));
    }
    // All taxonomies.
    foreach (get_object_taxonomies($post) as $tax_name) {
        $taxonomy = get_taxonomy($tax_name);
        if (!$taxonomy->show_ui || false === $taxonomy->meta_box_cb) {
            continue;
        }
        $label = $taxonomy->labels->name;
        if (!is_taxonomy_hierarchical($tax_name)) {
            $tax_meta_box_id = 'tagsdiv-' . $tax_name;
        } else {
            $tax_meta_box_id = $tax_name . 'div';
        }
        add_meta_box($tax_meta_box_id, $label, $taxonomy->meta_box_cb, null, 'side', 'core', array('taxonomy' => $tax_name, '__back_compat_meta_box' => true));
    }
    if (post_type_supports($post_type, 'page-attributes') || count(get_page_templates($post)) > 0) {
        add_meta_box('pageparentdiv', $post_type_object->labels->attributes, 'page_attributes_meta_box', null, 'side', 'core', array('__back_compat_meta_box' => true));
    }
    if ($thumbnail_support && current_user_can('upload_files')) {
        add_meta_box('postimagediv', esc_html($post_type_object->labels->featured_image), 'post_thumbnail_meta_box', null, 'side', 'low', array('__back_compat_meta_box' => true));
    }
    if (post_type_supports($post_type, 'excerpt')) {
        add_meta_box('postexcerpt', __('Excerpt'), 'post_excerpt_meta_box', null, 'normal', 'core', array('__back_compat_meta_box' => true));
    }
    if (post_type_supports($post_type, 'trackbacks')) {
        add_meta_box('trackbacksdiv', __('Send Trackbacks'), 'post_trackback_meta_box', null, 'normal', 'core', array('__back_compat_meta_box' => true));
    }
    if (post_type_supports($post_type, 'custom-fields')) {
        add_meta_box('postcustom', __('Custom Fields'), 'post_custom_meta_box', null, 'normal', 'core', array('__back_compat_meta_box' => !(bool) get_user_meta(get_current_user_id(), 'enable_custom_fields', true), '__block_editor_compatible_meta_box' => true));
    }
    /**
     * Fires in the middle of built-in meta box registration.
     *
     * @since 2.1.0
     * @deprecated 3.7.0 Use {@see 'add_meta_boxes'} instead.
     *
     * @param WP_Post $post Post object.
     */
    do_action_deprecated('dbx_post_advanced', array($post), '3.7.0', 'add_meta_boxes');
    // Allow the Discussion meta box to show up if the post type supports comments,
    // or if comments or pings are open.
    if (comments_open($post) || pings_open($post) || post_type_supports($post_type, 'comments')) {
        add_meta_box('commentstatusdiv', __('Discussion'), 'post_comment_status_meta_box', null, 'normal', 'core', array('__back_compat_meta_box' => true));
    }
    $stati = get_post_stati(array('public' => true));
    if (empty($stati)) {
        $stati = array('publish');
    }
    $stati[] = 'private';
    if (in_array(get_post_status($post), $stati, true)) {
        // If the post type support comments, or the post has comments,
        // allow the Comments meta box.
        if (comments_open($post) || pings_open($post) || $post->comment_count > 0 || post_type_supports($post_type, 'comments')) {
            add_meta_box('commentsdiv', __('Comments'), 'post_comment_meta_box', null, 'normal', 'core', array('__back_compat_meta_box' => true));
        }
    }
    if (!('pending' === get_post_status($post) && !current_user_can($post_type_object->cap->publish_posts))) {
        add_meta_box('slugdiv', __('Slug'), 'post_slug_meta_box', null, 'normal', 'core', array('__back_compat_meta_box' => true));
    }
    if (post_type_supports($post_type, 'author') && current_user_can($post_type_object->cap->edit_others_posts)) {
        add_meta_box('authordiv', __('Author'), 'post_author_meta_box', null, 'normal', 'core', array('__back_compat_meta_box' => true));
    }
    /**
     * Fires after all built-in meta boxes have been added.
     *
     * @since 3.0.0
     *
     * @param string  $post_type Post type.
     * @param WP_Post $post      Post object.
     */
    do_action('add_meta_boxes', $post_type, $post);
    /**
     * Fires after all built-in meta boxes have been added, contextually for the given post type.
     *
     * The dynamic portion of the hook, `$post_type`, refers to the post type of the post.
     *
     * @since 3.0.0
     *
     * @param WP_Post $post Post object.
     */
    do_action("add_meta_boxes_{$post_type}", $post);
    /**
     * Fires after meta boxes have been added.
     *
     * Fires once for each of the default meta box contexts: normal, advanced, and side.
     *
     * @since 3.0.0
     *
     * @param string                $post_type Post type of the post on Edit Post screen, 'link' on Edit Link screen,
     *                                         'dashboard' on Dashboard screen.
     * @param string                $context   Meta box context. Possible values include 'normal', 'advanced', 'side'.
     * @param WP_Post|object|string $post      Post object on Edit Post screen, link object on Edit Link screen,
     *                                         an empty string on Dashboard screen.
     */
    do_action('do_meta_boxes', $post_type, 'normal', $post);
    /** This action is documented in wp-admin/includes/meta-boxes.php */
    do_action('do_meta_boxes', $post_type, 'advanced', $post);
    /** This action is documented in wp-admin/includes/meta-boxes.php */
    do_action('do_meta_boxes', $post_type, 'side', $post);
}