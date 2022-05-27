<?php

/**
 * Custom template tags for this theme
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */
if (!function_exists('twenty_twenty_one_posted_on')) {
    /**
     * Prints HTML with meta information for the current post-date/time.
     *
     * @since Twenty Twenty-One 1.0
     *
     * @return void
     */
    function twenty_twenty_one_posted_on()
    {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        $time_string = sprintf($time_string, esc_attr(get_the_date(DATE_W3C)), esc_html(get_the_date()));
        echo '<span class="posted-on">';
        printf(
            /* translators: %s: Publish date. */
            esc_html__('Published %s', 'twentytwentyone'),
            $time_string
        );
        echo '</span>';
    }
}
if (!function_exists('twenty_twenty_one_posted_by')) {
    /**
     * Prints HTML with meta information about theme author.
     *
     * @since Twenty Twenty-One 1.0
     *
     * @return void
     */
    function twenty_twenty_one_posted_by()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("twenty_twenty_one_posted_by") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-content/themes/twentytwentyone/inc/template-tags.php at line 41")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called twenty_twenty_one_posted_by:41@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-content/themes/twentytwentyone/inc/template-tags.php');
        die();
    }
}
if (!function_exists('twenty_twenty_one_entry_meta_footer')) {
    /**
     * Prints HTML with meta information for the categories, tags and comments.
     * Footer entry meta is displayed differently in archives and single posts.
     *
     * @since Twenty Twenty-One 1.0
     *
     * @return void
     */
    function twenty_twenty_one_entry_meta_footer()
    {
        // Early exit if not a post.
        if ('post' !== get_post_type()) {
            return;
        }
        // Hide meta information on pages.
        if (!is_single()) {
            if (is_sticky()) {
                echo '<p>' . esc_html_x('Featured post', 'Label for sticky posts', 'twentytwentyone') . '</p>';
            }
            $post_format = get_post_format();
            if ('aside' === $post_format || 'status' === $post_format) {
                echo '<p><a href="' . esc_url(get_permalink()) . '">' . twenty_twenty_one_continue_reading_text() . '</a></p>';
                // phpcs:ignore WordPress.Security.EscapeOutput
            }
            // Posted on.
            twenty_twenty_one_posted_on();
            // Edit post link.
            edit_post_link(sprintf(
                /* translators: %s: Name of current post. Only visible to screen readers. */
                esc_html__('Edit %s', 'twentytwentyone'),
                '<span class="screen-reader-text">' . get_the_title() . '</span>'
            ), '<span class="edit-link">', '</span><br>');
            if (has_category() || has_tag()) {
                echo '<div class="post-taxonomies">';
                /* translators: Used between list items, there is a space after the comma. */
                $categories_list = get_the_category_list(__(', ', 'twentytwentyone'));
                if ($categories_list) {
                    printf(
                        /* translators: %s: List of categories. */
                        '<span class="cat-links">' . esc_html__('Categorized as %s', 'twentytwentyone') . ' </span>',
                        $categories_list
                    );
                }
                /* translators: Used between list items, there is a space after the comma. */
                $tags_list = get_the_tag_list('', __(', ', 'twentytwentyone'));
                if ($tags_list) {
                    printf(
                        /* translators: %s: List of tags. */
                        '<span class="tags-links">' . esc_html__('Tagged %s', 'twentytwentyone') . '</span>',
                        $tags_list
                    );
                }
                echo '</div>';
            }
        } else {
            echo '<div class="posted-by">';
            // Posted on.
            twenty_twenty_one_posted_on();
            // Posted by.
            twenty_twenty_one_posted_by();
            // Edit post link.
            edit_post_link(sprintf(
                /* translators: %s: Name of current post. Only visible to screen readers. */
                esc_html__('Edit %s', 'twentytwentyone'),
                '<span class="screen-reader-text">' . get_the_title() . '</span>'
            ), '<span class="edit-link">', '</span>');
            echo '</div>';
            if (has_category() || has_tag()) {
                echo '<div class="post-taxonomies">';
                /* translators: Used between list items, there is a space after the comma. */
                $categories_list = get_the_category_list(__(', ', 'twentytwentyone'));
                if ($categories_list) {
                    printf(
                        /* translators: %s: List of categories. */
                        '<span class="cat-links">' . esc_html__('Categorized as %s', 'twentytwentyone') . ' </span>',
                        $categories_list
                    );
                }
                /* translators: Used between list items, there is a space after the comma. */
                $tags_list = get_the_tag_list('', __(', ', 'twentytwentyone'));
                if ($tags_list) {
                    printf(
                        /* translators: %s: List of tags. */
                        '<span class="tags-links">' . esc_html__('Tagged %s', 'twentytwentyone') . '</span>',
                        $tags_list
                    );
                }
                echo '</div>';
            }
        }
    }
}
if (!function_exists('twenty_twenty_one_post_thumbnail')) {
    /**
     * Displays an optional post thumbnail.
     *
     * Wraps the post thumbnail in an anchor element on index views, or a div
     * element when on single views.
     *
     * @since Twenty Twenty-One 1.0
     *
     * @return void
     */
    function twenty_twenty_one_post_thumbnail()
    {
        if (!twenty_twenty_one_can_show_post_thumbnail()) {
            return;
        }
        ?>

		<?php 
        if (is_singular()) {
            ?>

			<figure class="post-thumbnail">
				<?php 
            // Lazy-loading attributes should be skipped for thumbnails since they are immediately in the viewport.
            the_post_thumbnail('post-thumbnail', array('loading' => false));
            ?>
				<?php 
            if (wp_get_attachment_caption(get_post_thumbnail_id())) {
                ?>
					<figcaption class="wp-caption-text"><?php 
                echo wp_kses_post(wp_get_attachment_caption(get_post_thumbnail_id()));
                ?></figcaption>
				<?php 
            }
            ?>
			</figure><!-- .post-thumbnail -->

		<?php 
        } else {
            ?>

			<figure class="post-thumbnail">
				<a class="post-thumbnail-inner alignwide" href="<?php 
            the_permalink();
            ?>" aria-hidden="true" tabindex="-1">
					<?php 
            the_post_thumbnail('post-thumbnail');
            ?>
				</a>
				<?php 
            if (wp_get_attachment_caption(get_post_thumbnail_id())) {
                ?>
					<figcaption class="wp-caption-text"><?php 
                echo wp_kses_post(wp_get_attachment_caption(get_post_thumbnail_id()));
                ?></figcaption>
				<?php 
            }
            ?>
			</figure>

		<?php 
        }
        ?>
		<?php 
    }
}
if (!function_exists('twenty_twenty_one_the_posts_navigation')) {
    /**
     * Print the next and previous posts navigation.
     *
     * @since Twenty Twenty-One 1.0
     *
     * @return void
     */
    function twenty_twenty_one_the_posts_navigation()
    {
        the_posts_pagination(array('before_page_number' => esc_html__('Page', 'twentytwentyone') . ' ', 'mid_size' => 0, 'prev_text' => sprintf('%s <span class="nav-prev-text">%s</span>', is_rtl() ? twenty_twenty_one_get_icon_svg('ui', 'arrow_right') : twenty_twenty_one_get_icon_svg('ui', 'arrow_left'), wp_kses(__('Newer <span class="nav-short">posts</span>', 'twentytwentyone'), array('span' => array('class' => array())))), 'next_text' => sprintf('<span class="nav-next-text">%s</span> %s', wp_kses(__('Older <span class="nav-short">posts</span>', 'twentytwentyone'), array('span' => array('class' => array()))), is_rtl() ? twenty_twenty_one_get_icon_svg('ui', 'arrow_left') : twenty_twenty_one_get_icon_svg('ui', 'arrow_right'))));
    }
}