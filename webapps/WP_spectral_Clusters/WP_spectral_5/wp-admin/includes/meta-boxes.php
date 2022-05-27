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


<div id="misc-publishing-actions">
	<div class="misc-pub-section curtime misc-pub-curtime">
		<span id="timestamp">
			<?php 
    $uploaded_on = sprintf(
        /* translators: Publish box date string. 1: Date, 2: Time. See https://www.php.net/manual/datetime.format.php */
        __('%1$s at %2$s'),
        /* translators: Publish box date format, see https://www.php.net/manual/datetime.format.php */
        date_i18n(_x('M j, Y', 'publish box date format'), strtotime($post->post_date)),
        /* translators: Publish box time format, see https://www.php.net/manual/datetime.format.php */
        date_i18n(_x('H:i', 'publish box time format'), strtotime($post->post_date))
    );
    /* translators: Attachment information. %s: Date the attachment was uploaded. */
    printf(__('Uploaded on: %s'), '<b>' . $uploaded_on . '</b>');
    ?>
		</span>
	</div><!-- .misc-pub-section -->

	<?php 
    /**
     * Fires after the 'Uploaded on' section of the Save meta box
     * in the attachment editing screen.
     *
     * @since 3.5.0
     * @since 4.9.0 Added the `$post` parameter.
     *
     * @param WP_Post $post WP_Post object for the current attachment.
     */
    do_action('attachment_submitbox_misc_actions', $post);
    ?>
</div><!-- #misc-publishing-actions -->
<div class="clear"></div>
</div><!-- #minor-publishing -->

<div id="major-publishing-actions">
	<div id="delete-action">
	<?php 
    if (current_user_can('delete_post', $post->ID)) {
        if (EMPTY_TRASH_DAYS && MEDIA_TRASH) {
            echo "<a class='submitdelete deletion' href='" . get_delete_post_link($post->ID) . "'>" . __('Move to Trash') . '</a>';
        } else {
            $delete_ays = !MEDIA_TRASH ? " onclick='return showNotice.warn();'" : '';
            echo "<a class='submitdelete deletion'{$delete_ays} href='" . get_delete_post_link($post->ID, null, true) . "'>" . __('Delete permanently') . '</a>';
        }
    }
    ?>
	</div>

	<div id="publishing-action">
		<span class="spinner"></span>
		<input name="original_publish" type="hidden" id="original_publish" value="<?php 
    esc_attr_e('Update');
    ?>" />
		<input name="save" type="submit" class="button button-primary button-large" id="publish" value="<?php 
    esc_attr_e('Update');
    ?>" />
	</div>
	<div class="clear"></div>
</div><!-- #major-publishing-actions -->

</div>

	<?php 
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
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("post_format_meta_box") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/meta-boxes.php at line 629")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called post_format_meta_box:629@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/meta-boxes.php');
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
    $defaults = array('taxonomy' => 'post_tag');
    if (!isset($box['args']) || !is_array($box['args'])) {
        $args = array();
    } else {
        $args = $box['args'];
    }
    $parsed_args = wp_parse_args($args, $defaults);
    $tax_name = esc_attr($parsed_args['taxonomy']);
    $taxonomy = get_taxonomy($parsed_args['taxonomy']);
    $user_can_assign_terms = current_user_can($taxonomy->cap->assign_terms);
    $comma = _x(',', 'tag delimiter');
    $terms_to_edit = get_terms_to_edit($post->ID, $tax_name);
    if (!is_string($terms_to_edit)) {
        $terms_to_edit = '';
    }
    ?>
<div class="tagsdiv" id="<?php 
    echo $tax_name;
    ?>">
	<div class="jaxtag">
	<div class="nojs-tags hide-if-js">
		<label for="tax-input-<?php 
    echo $tax_name;
    ?>"><?php 
    echo $taxonomy->labels->add_or_remove_items;
    ?></label>
		<p><textarea name="<?php 
    echo "tax_input[{$tax_name}]";
    ?>" rows="3" cols="20" class="the-tags" id="tax-input-<?php 
    echo $tax_name;
    ?>" <?php 
    disabled(!$user_can_assign_terms);
    ?> aria-describedby="new-tag-<?php 
    echo $tax_name;
    ?>-desc"><?php 
    echo str_replace(',', $comma . ' ', $terms_to_edit);
    // textarea_escaped by esc_attr()
    ?></textarea></p>
	</div>
	<?php 
    if ($user_can_assign_terms) {
        ?>
	<div class="ajaxtag hide-if-no-js">
		<label class="screen-reader-text" for="new-tag-<?php 
        echo $tax_name;
        ?>"><?php 
        echo $taxonomy->labels->add_new_item;
        ?></label>
		<input data-wp-taxonomy="<?php 
        echo $tax_name;
        ?>" type="text" id="new-tag-<?php 
        echo $tax_name;
        ?>" name="newtag[<?php 
        echo $tax_name;
        ?>]" class="newtag form-input-tip" size="16" autocomplete="off" aria-describedby="new-tag-<?php 
        echo $tax_name;
        ?>-desc" value="" />
		<input type="button" class="button tagadd" value="<?php 
        esc_attr_e('Add');
        ?>" />
	</div>
	<p class="howto" id="new-tag-<?php 
        echo $tax_name;
        ?>-desc"><?php 
        echo $taxonomy->labels->separate_items_with_commas;
        ?></p>
	<?php 
    } elseif (empty($terms_to_edit)) {
        ?>
		<p><?php 
        echo $taxonomy->labels->no_terms;
        ?></p>
	<?php 
    }
    ?>
	</div>
	<ul class="tagchecklist" role="list"></ul>
</div>
	<?php 
    if ($user_can_assign_terms) {
        ?>
<p class="hide-if-no-js"><button type="button" class="button-link tagcloud-link" id="link-<?php 
        echo $tax_name;
        ?>" aria-expanded="false"><?php 
        echo $taxonomy->labels->choose_from_most_used;
        ?></button></p>
<?php 
    }
    ?>
	<?php 
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
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("post_excerpt_meta_box") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/meta-boxes.php at line 971")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called post_excerpt_meta_box:971@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/meta-boxes.php');
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
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("post_trackback_meta_box") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/meta-boxes.php at line 997")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called post_trackback_meta_box:997@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/meta-boxes.php');
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
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("post_custom_meta_box") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/meta-boxes.php at line 1042")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called post_custom_meta_box:1042@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/meta-boxes.php');
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
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("post_comment_status_meta_box") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/meta-boxes.php at line 1076")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called post_comment_status_meta_box:1076@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/meta-boxes.php');
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
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("post_comment_meta_box_thead") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/meta-boxes.php at line 1118")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called post_comment_meta_box_thead:1118@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/meta-boxes.php');
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
    wp_nonce_field('get-comments', 'add_comment_nonce', false);
    ?>
	<p class="hide-if-no-js" id="add-new-comment"><button type="button" class="button" onclick="window.commentReply && commentReply.addcomment(<?php 
    echo $post->ID;
    ?>);"><?php 
    _e('Add Comment');
    ?></button></p>
	<?php 
    $total = get_comments(array('post_id' => $post->ID, 'number' => 1, 'count' => true));
    $wp_list_table = _get_list_table('WP_Post_Comments_List_Table');
    $wp_list_table->display(true);
    if (1 > $total) {
        echo '<p id="no-comments">' . __('No comments yet.') . '</p>';
    } else {
        $hidden = get_hidden_meta_boxes(get_current_screen());
        if (!in_array('commentsdiv', $hidden, true)) {
            ?>
			<script type="text/javascript">jQuery(document).ready(function(){commentsBox.get(<?php 
            echo $total;
            ?>, 10);});</script>
			<?php 
        }
        ?>
		<p class="hide-if-no-js" id="show-comments"><a href="#commentstatusdiv" onclick="commentsBox.load(<?php 
        echo $total;
        ?>);return false;"><?php 
        _e('Show comments');
        ?></a> <span class="spinner"></span></p>
		<?php 
    }
    wp_comment_trashnotice();
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
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("post_slug_meta_box") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/meta-boxes.php at line 1172")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called post_slug_meta_box:1172@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/meta-boxes.php');
    die();
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
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("post_author_meta_box") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/meta-boxes.php at line 1192")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called post_author_meta_box:1192@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/meta-boxes.php');
    die();
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
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("post_revisions_meta_box") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/meta-boxes.php at line 1209")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called post_revisions_meta_box:1209@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/meta-boxes.php');
    die();
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
    ?>
<div class="submitbox" id="submitlink">

<div id="minor-publishing">

	<?php 
    // Hidden submit button early on so that the browser chooses the right button when form is submitted with Return key.
    ?>
<div style="display:none;">
	<?php 
    submit_button(__('Save'), '', 'save', false);
    ?>
</div>

<div id="minor-publishing-actions">
<div id="preview-action">
	<?php 
    if (!empty($link->link_id)) {
        ?>
	<a class="preview button" href="<?php 
        echo $link->link_url;
        ?>" target="_blank"><?php 
        _e('Visit Link');
        ?></a>
<?php 
    }
    ?>
</div>
<div class="clear"></div>
</div>

<div id="misc-publishing-actions">
<div class="misc-pub-section misc-pub-private">
	<label for="link_private" class="selectit"><input id="link_private" name="link_visible" type="checkbox" value="N" <?php 
    checked($link->link_visible, 'N');
    ?> /> <?php 
    _e('Keep this link private');
    ?></label>
</div>
</div>

</div>

<div id="major-publishing-actions">
	<?php 
    /** This action is documented in wp-admin/includes/meta-boxes.php */
    do_action('post_submitbox_start', null);
    ?>
<div id="delete-action">
	<?php 
    if (!empty($_GET['action']) && 'edit' === $_GET['action'] && current_user_can('manage_links')) {
        printf(
            '<a class="submitdelete deletion" href="%s" onclick="return confirm( \'%s\' );">%s</a>',
            wp_nonce_url("link.php?action=delete&amp;link_id={$link->link_id}", 'delete-bookmark_' . $link->link_id),
            /* translators: %s: Link name. */
            esc_js(sprintf(__("You are about to delete this link '%s'\n  'Cancel' to stop, 'OK' to delete."), $link->link_name)),
            __('Delete')
        );
    }
    ?>
</div>

<div id="publishing-action">
	<?php 
    if (!empty($link->link_id)) {
        ?>
	<input name="save" type="submit" class="button button-primary button-large" id="publish" value="<?php 
        esc_attr_e('Update Link');
        ?>" />
<?php 
    } else {
        ?>
	<input name="save" type="submit" class="button button-primary button-large" id="publish" value="<?php 
        esc_attr_e('Add Link');
        ?>" />
<?php 
    }
    ?>
</div>
<div class="clear"></div>
</div>
	<?php 
    /**
     * Fires at the end of the Publish box in the Link editing screen.
     *
     * @since 2.5.0
     */
    do_action('submitlink_box');
    ?>
<div class="clear"></div>
</div>
	<?php 
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
    ?>
<div id="taxonomy-linkcategory" class="categorydiv">
	<ul id="category-tabs" class="category-tabs">
		<li class="tabs"><a href="#categories-all"><?php 
    _e('All categories');
    ?></a></li>
		<li class="hide-if-no-js"><a href="#categories-pop"><?php 
    _ex('Most Used', 'categories');
    ?></a></li>
	</ul>

	<div id="categories-all" class="tabs-panel">
		<ul id="categorychecklist" data-wp-lists="list:category" class="categorychecklist form-no-clear">
			<?php 
    if (isset($link->link_id)) {
        wp_link_category_checklist($link->link_id);
    } else {
        wp_link_category_checklist();
    }
    ?>
		</ul>
	</div>

	<div id="categories-pop" class="tabs-panel" style="display: none;">
		<ul id="categorychecklist-pop" class="categorychecklist form-no-clear">
			<?php 
    wp_popular_terms_checklist('link_category');
    ?>
		</ul>
	</div>

	<div id="category-adder" class="wp-hidden-children">
		<a id="category-add-toggle" href="#category-add" class="taxonomy-add-new"><?php 
    _e('+ Add New Category');
    ?></a>
		<p id="link-category-add" class="wp-hidden-child">
			<label class="screen-reader-text" for="newcat"><?php 
    _e('+ Add New Category');
    ?></label>
			<input type="text" name="newcat" id="newcat" class="form-required form-input-tip" value="<?php 
    esc_attr_e('New category name');
    ?>" aria-required="true" />
			<input type="button" id="link-category-add-submit" data-wp-lists="add:categorychecklist:link-category-add" class="button" value="<?php 
    esc_attr_e('Add');
    ?>" />
			<?php 
    wp_nonce_field('add-link-category', '_ajax_nonce', false);
    ?>
			<span id="category-ajax-response"></span>
		</p>
	</div>
</div>
	<?php 
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
    ?>
<fieldset><legend class="screen-reader-text"><span><?php 
    _e('Target');
    ?></span></legend>
<p><label for="link_target_blank" class="selectit">
<input id="link_target_blank" type="radio" name="link_target" value="_blank" <?php 
    echo isset($link->link_target) && '_blank' === $link->link_target ? 'checked="checked"' : '';
    ?> />
	<?php 
    _e('<code>_blank</code> &mdash; new window or tab.');
    ?></label></p>
<p><label for="link_target_top" class="selectit">
<input id="link_target_top" type="radio" name="link_target" value="_top" <?php 
    echo isset($link->link_target) && '_top' === $link->link_target ? 'checked="checked"' : '';
    ?> />
	<?php 
    _e('<code>_top</code> &mdash; current window or tab, with no frames.');
    ?></label></p>
<p><label for="link_target_none" class="selectit">
<input id="link_target_none" type="radio" name="link_target" value="" <?php 
    echo isset($link->link_target) && '' === $link->link_target ? 'checked="checked"' : '';
    ?> />
	<?php 
    _e('<code>_none</code> &mdash; same window or tab.');
    ?></label></p>
</fieldset>
<p><?php 
    _e('Choose the target frame for your link.');
    ?></p>
	<?php 
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
    global $link;
    if (!empty($deprecated)) {
        _deprecated_argument(__FUNCTION__, '2.5.0');
        // Never implemented.
    }
    $link_rel = isset($link->link_rel) ? $link->link_rel : '';
    // In PHP 5.3: $link_rel = $link->link_rel ?: '';
    $rels = preg_split('/\\s+/', $link_rel);
    if ('' !== $value && in_array($value, $rels, true)) {
        echo ' checked="checked"';
    }
    if ('' === $value) {
        if ('family' === $class && strpos($link_rel, 'child') === false && strpos($link_rel, 'parent') === false && strpos($link_rel, 'sibling') === false && strpos($link_rel, 'spouse') === false && strpos($link_rel, 'kin') === false) {
            echo ' checked="checked"';
        }
        if ('friendship' === $class && strpos($link_rel, 'friend') === false && strpos($link_rel, 'acquaintance') === false && strpos($link_rel, 'contact') === false) {
            echo ' checked="checked"';
        }
        if ('geographical' === $class && strpos($link_rel, 'co-resident') === false && strpos($link_rel, 'neighbor') === false) {
            echo ' checked="checked"';
        }
        if ('identity' === $class && in_array('me', $rels, true)) {
            echo ' checked="checked"';
        }
    }
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
    ?>
<table class="links-table">
	<tr>
		<th scope="row"><label for="link_rel"><?php 
    /* translators: xfn: https://gmpg.org/xfn/ */
    _e('rel:');
    ?></label></th>
		<td><input type="text" name="link_rel" id="link_rel" value="<?php 
    echo isset($link->link_rel) ? esc_attr($link->link_rel) : '';
    ?>" /></td>
	</tr>
	<tr>
		<th scope="row"><?php 
    /* translators: xfn: https://gmpg.org/xfn/ */
    _e('identity');
    ?></th>
		<td><fieldset><legend class="screen-reader-text"><span><?php 
    /* translators: xfn: https://gmpg.org/xfn/ */
    _e('identity');
    ?></span></legend>
			<label for="me">
			<input type="checkbox" name="identity" value="me" id="me" <?php 
    xfn_check('identity', 'me');
    ?> />
			<?php 
    _e('another web address of mine');
    ?></label>
		</fieldset></td>
	</tr>
	<tr>
		<th scope="row"><?php 
    /* translators: xfn: https://gmpg.org/xfn/ */
    _e('friendship');
    ?></th>
		<td><fieldset><legend class="screen-reader-text"><span><?php 
    /* translators: xfn: https://gmpg.org/xfn/ */
    _e('friendship');
    ?></span></legend>
			<label for="contact">
			<input class="valinp" type="radio" name="friendship" value="contact" id="contact" <?php 
    xfn_check('friendship', 'contact');
    ?> />&nbsp;<?php 
    /* translators: xfn: https://gmpg.org/xfn/ */
    _e('contact');
    ?>
			</label>
			<label for="acquaintance">
			<input class="valinp" type="radio" name="friendship" value="acquaintance" id="acquaintance" <?php 
    xfn_check('friendship', 'acquaintance');
    ?> />&nbsp;<?php 
    /* translators: xfn: https://gmpg.org/xfn/ */
    _e('acquaintance');
    ?>
			</label>
			<label for="friend">
			<input class="valinp" type="radio" name="friendship" value="friend" id="friend" <?php 
    xfn_check('friendship', 'friend');
    ?> />&nbsp;<?php 
    /* translators: xfn: https://gmpg.org/xfn/ */
    _e('friend');
    ?>
			</label>
			<label for="friendship">
			<input name="friendship" type="radio" class="valinp" value="" id="friendship" <?php 
    xfn_check('friendship');
    ?> />&nbsp;<?php 
    /* translators: xfn: https://gmpg.org/xfn/ */
    _e('none');
    ?>
			</label>
		</fieldset></td>
	</tr>
	<tr>
		<th scope="row"> <?php 
    /* translators: xfn: https://gmpg.org/xfn/ */
    _e('physical');
    ?> </th>
		<td><fieldset><legend class="screen-reader-text"><span><?php 
    /* translators: xfn: https://gmpg.org/xfn/ */
    _e('physical');
    ?></span></legend>
			<label for="met">
			<input class="valinp" type="checkbox" name="physical" value="met" id="met" <?php 
    xfn_check('physical', 'met');
    ?> />&nbsp;<?php 
    /* translators: xfn: https://gmpg.org/xfn/ */
    _e('met');
    ?>
			</label>
		</fieldset></td>
	</tr>
	<tr>
		<th scope="row"> <?php 
    /* translators: xfn: https://gmpg.org/xfn/ */
    _e('professional');
    ?> </th>
		<td><fieldset><legend class="screen-reader-text"><span><?php 
    /* translators: xfn: https://gmpg.org/xfn/ */
    _e('professional');
    ?></span></legend>
			<label for="co-worker">
			<input class="valinp" type="checkbox" name="professional" value="co-worker" id="co-worker" <?php 
    xfn_check('professional', 'co-worker');
    ?> />&nbsp;<?php 
    /* translators: xfn: https://gmpg.org/xfn/ */
    _e('co-worker');
    ?>
			</label>
			<label for="colleague">
			<input class="valinp" type="checkbox" name="professional" value="colleague" id="colleague" <?php 
    xfn_check('professional', 'colleague');
    ?> />&nbsp;<?php 
    /* translators: xfn: https://gmpg.org/xfn/ */
    _e('colleague');
    ?>
			</label>
		</fieldset></td>
	</tr>
	<tr>
		<th scope="row"><?php 
    /* translators: xfn: https://gmpg.org/xfn/ */
    _e('geographical');
    ?></th>
		<td><fieldset><legend class="screen-reader-text"><span> <?php 
    /* translators: xfn: https://gmpg.org/xfn/ */
    _e('geographical');
    ?> </span></legend>
			<label for="co-resident">
			<input class="valinp" type="radio" name="geographical" value="co-resident" id="co-resident" <?php 
    xfn_check('geographical', 'co-resident');
    ?> />&nbsp;<?php 
    /* translators: xfn: https://gmpg.org/xfn/ */
    _e('co-resident');
    ?>
			</label>
			<label for="neighbor">
			<input class="valinp" type="radio" name="geographical" value="neighbor" id="neighbor" <?php 
    xfn_check('geographical', 'neighbor');
    ?> />&nbsp;<?php 
    /* translators: xfn: https://gmpg.org/xfn/ */
    _e('neighbor');
    ?>
			</label>
			<label for="geographical">
			<input class="valinp" type="radio" name="geographical" value="" id="geographical" <?php 
    xfn_check('geographical');
    ?> />&nbsp;<?php 
    /* translators: xfn: https://gmpg.org/xfn/ */
    _e('none');
    ?>
			</label>
		</fieldset></td>
	</tr>
	<tr>
		<th scope="row"><?php 
    /* translators: xfn: https://gmpg.org/xfn/ */
    _e('family');
    ?></th>
		<td><fieldset><legend class="screen-reader-text"><span> <?php 
    /* translators: xfn: https://gmpg.org/xfn/ */
    _e('family');
    ?> </span></legend>
			<label for="child">
			<input class="valinp" type="radio" name="family" value="child" id="child" <?php 
    xfn_check('family', 'child');
    ?> />&nbsp;<?php 
    /* translators: xfn: https://gmpg.org/xfn/ */
    _e('child');
    ?>
			</label>
			<label for="kin">
			<input class="valinp" type="radio" name="family" value="kin" id="kin" <?php 
    xfn_check('family', 'kin');
    ?> />&nbsp;<?php 
    /* translators: xfn: https://gmpg.org/xfn/ */
    _e('kin');
    ?>
			</label>
			<label for="parent">
			<input class="valinp" type="radio" name="family" value="parent" id="parent" <?php 
    xfn_check('family', 'parent');
    ?> />&nbsp;<?php 
    /* translators: xfn: https://gmpg.org/xfn/ */
    _e('parent');
    ?>
			</label>
			<label for="sibling">
			<input class="valinp" type="radio" name="family" value="sibling" id="sibling" <?php 
    xfn_check('family', 'sibling');
    ?> />&nbsp;<?php 
    /* translators: xfn: https://gmpg.org/xfn/ */
    _e('sibling');
    ?>
			</label>
			<label for="spouse">
			<input class="valinp" type="radio" name="family" value="spouse" id="spouse" <?php 
    xfn_check('family', 'spouse');
    ?> />&nbsp;<?php 
    /* translators: xfn: https://gmpg.org/xfn/ */
    _e('spouse');
    ?>
			</label>
			<label for="family">
			<input class="valinp" type="radio" name="family" value="" id="family" <?php 
    xfn_check('family');
    ?> />&nbsp;<?php 
    /* translators: xfn: https://gmpg.org/xfn/ */
    _e('none');
    ?>
			</label>
		</fieldset></td>
	</tr>
	<tr>
		<th scope="row"><?php 
    /* translators: xfn: https://gmpg.org/xfn/ */
    _e('romantic');
    ?></th>
		<td><fieldset><legend class="screen-reader-text"><span> <?php 
    /* translators: xfn: https://gmpg.org/xfn/ */
    _e('romantic');
    ?> </span></legend>
			<label for="muse">
			<input class="valinp" type="checkbox" name="romantic" value="muse" id="muse" <?php 
    xfn_check('romantic', 'muse');
    ?> />&nbsp;<?php 
    /* translators: xfn: https://gmpg.org/xfn/ */
    _e('muse');
    ?>
			</label>
			<label for="crush">
			<input class="valinp" type="checkbox" name="romantic" value="crush" id="crush" <?php 
    xfn_check('romantic', 'crush');
    ?> />&nbsp;<?php 
    /* translators: xfn: https://gmpg.org/xfn/ */
    _e('crush');
    ?>
			</label>
			<label for="date">
			<input class="valinp" type="checkbox" name="romantic" value="date" id="date" <?php 
    xfn_check('romantic', 'date');
    ?> />&nbsp;<?php 
    /* translators: xfn: https://gmpg.org/xfn/ */
    _e('date');
    ?>
			</label>
			<label for="romantic">
			<input class="valinp" type="checkbox" name="romantic" value="sweetheart" id="romantic" <?php 
    xfn_check('romantic', 'sweetheart');
    ?> />&nbsp;<?php 
    /* translators: xfn: https://gmpg.org/xfn/ */
    _e('sweetheart');
    ?>
			</label>
		</fieldset></td>
	</tr>

</table>
<p><?php 
    _e('If the link is to a person, you can specify your relationship with them using the above form. If you would like to learn more about the idea check out <a href="https://gmpg.org/xfn/">XFN</a>.');
    ?></p>
	<?php 
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
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("link_advanced_meta_box") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/meta-boxes.php at line 1849")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called link_advanced_meta_box:1849@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/meta-boxes.php');
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
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("post_thumbnail_meta_box") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/meta-boxes.php at line 1906")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called post_thumbnail_meta_box:1906@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/meta-boxes.php');
    die();
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
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("attachment_id3_data_meta_box") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/meta-boxes.php at line 1918")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called attachment_id3_data_meta_box:1918@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/meta-boxes.php');
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
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("register_and_do_post_meta_boxes") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/meta-boxes.php at line 1952")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called register_and_do_post_meta_boxes:1952@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-admin/includes/meta-boxes.php');
    die();
}