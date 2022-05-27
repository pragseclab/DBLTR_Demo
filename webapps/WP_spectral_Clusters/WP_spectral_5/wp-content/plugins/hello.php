<?php

/**
 * @package Hello_Dolly
 * @version 1.7.2
 */
/*
Plugin Name: Hello Dolly
Plugin URI: http://wordpress.org/plugins/hello-dolly/
Description: This is not just a plugin, it symbolizes the hope and enthusiasm of an entire generation summed up in two words sung most famously by Louis Armstrong: Hello, Dolly. When activated you will randomly see a lyric from <cite>Hello, Dolly</cite> in the upper right of your admin screen on every page.
Author: Matt Mullenweg
Version: 1.7.2
Author URI: http://ma.tt/
*/
function hello_dolly_get_lyric()
{
    /** These are the lyrics to Hello Dolly */
    $lyrics = "Hello, Dolly\nWell, hello, Dolly\nIt's so nice to have you back where you belong\nYou're lookin' swell, Dolly\nI can tell, Dolly\nYou're still glowin', you're still crowin'\nYou're still goin' strong\nI feel the room swayin'\nWhile the band's playin'\nOne of our old favorite songs from way back when\nSo, take her wrap, fellas\nDolly, never go away again\nHello, Dolly\nWell, hello, Dolly\nIt's so nice to have you back where you belong\nYou're lookin' swell, Dolly\nI can tell, Dolly\nYou're still glowin', you're still crowin'\nYou're still goin' strong\nI feel the room swayin'\nWhile the band's playin'\nOne of our old favorite songs from way back when\nSo, golly, gee, fellas\nHave a little faith in me, fellas\nDolly, never go away\nPromise, you'll never go away\nDolly'll never go away again";
    // Here we split it into lines.
    $lyrics = explode("\n", $lyrics);
    // And then randomly choose a line.
    return wptexturize($lyrics[mt_rand(0, count($lyrics) - 1)]);
}
// This just echoes the chosen line, we'll position it later.
function hello_dolly()
{
    $chosen = hello_dolly_get_lyric();
    $lang = '';
    if ('en_' !== substr(get_user_locale(), 0, 3)) {
        $lang = ' lang="en"';
    }
    printf('<p id="dolly"><span class="screen-reader-text">%s </span><span dir="ltr"%s>%s</span></p>', __('Quote from Hello Dolly song, by Jerry Herman:'), $lang, $chosen);
}
// Now we set that function up to execute when the admin_notices action is called.
add_action('admin_notices', 'hello_dolly');
// We need some CSS to position the paragraph.
function dolly_css()
{
    echo "\n\t<style type='text/css'>\n\t#dolly {\n\t\tfloat: right;\n\t\tpadding: 5px 10px;\n\t\tmargin: 0;\n\t\tfont-size: 12px;\n\t\tline-height: 1.6666;\n\t}\n\t.rtl #dolly {\n\t\tfloat: left;\n\t}\n\t.block-editor-page #dolly {\n\t\tdisplay: none;\n\t}\n\t@media screen and (max-width: 782px) {\n\t\t#dolly,\n\t\t.rtl #dolly {\n\t\t\tfloat: none;\n\t\t\tpadding-left: 0;\n\t\t\tpadding-right: 0;\n\t\t}\n\t}\n\t</style>\n\t";
}
add_action('admin_head', 'dolly_css');