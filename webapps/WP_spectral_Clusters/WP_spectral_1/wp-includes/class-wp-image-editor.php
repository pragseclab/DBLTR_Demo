<?php

/**
 * Base WordPress Image Editor
 *
 * @package WordPress
 * @subpackage Image_Editor
 */
/**
 * Base image editor class from which implementations extend
 *
 * @since 3.5.0
 */
abstract class WP_Image_Editor
{
    protected $file = null;
    protected $size = null;
    protected $mime_type = null;
    protected $default_mime_type = 'image/jpeg';
    protected $quality = false;
    protected $default_quality = 82;
    /**
     * Each instance handles a single file.
     *
     * @param string $file Path to the file to load.
     */
    public function __construct($file)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("__construct") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/class-wp-image-editor.php at line 29")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called __construct:29@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/class-wp-image-editor.php');
        die();
    }
    /**
     * Checks to see if current environment supports the editor chosen.
     * Must be overridden in a subclass.
     *
     * @since 3.5.0
     *
     * @abstract
     *
     * @param array $args
     * @return bool
     */
    public static function test($args = array())
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("test") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/class-wp-image-editor.php at line 44")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called test:44@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/class-wp-image-editor.php');
        die();
    }
    /**
     * Checks to see if editor supports the mime-type specified.
     * Must be overridden in a subclass.
     *
     * @since 3.5.0
     *
     * @abstract
     *
     * @param string $mime_type
     * @return bool
     */
    public static function supports_mime_type($mime_type)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("supports_mime_type") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/class-wp-image-editor.php at line 59")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called supports_mime_type:59@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/class-wp-image-editor.php');
        die();
    }
    /**
     * Loads image from $this->file into editor.
     *
     * @since 3.5.0
     * @abstract
     *
     * @return true|WP_Error True if loaded; WP_Error on failure.
     */
    public abstract function load();
    /**
     * Saves current image to file.
     *
     * @since 3.5.0
     * @abstract
     *
     * @param string $destfilename
     * @param string $mime_type
     * @return array|WP_Error {'path'=>string, 'file'=>string, 'width'=>int, 'height'=>int, 'mime-type'=>string}
     */
    public abstract function save($destfilename = null, $mime_type = null);
    /**
     * Resizes current image.
     *
     * At minimum, either a height or width must be provided.
     * If one of the two is set to null, the resize will
     * maintain aspect ratio according to the provided dimension.
     *
     * @since 3.5.0
     * @abstract
     *
     * @param int|null $max_w Image width.
     * @param int|null $max_h Image height.
     * @param bool     $crop
     * @return true|WP_Error
     */
    public abstract function resize($max_w, $max_h, $crop = false);
    /**
     * Resize multiple images from a single source.
     *
     * @since 3.5.0
     * @abstract
     *
     * @param array $sizes {
     *     An array of image size arrays. Default sizes are 'small', 'medium', 'large'.
     *
     *     @type array $size {
     *         @type int  $width  Image width.
     *         @type int  $height Image height.
     *         @type bool $crop   Optional. Whether to crop the image. Default false.
     *     }
     * }
     * @return array An array of resized images metadata by size.
     */
    public abstract function multi_resize($sizes);
    /**
     * Crops Image.
     *
     * @since 3.5.0
     * @abstract
     *
     * @param int  $src_x   The start x position to crop from.
     * @param int  $src_y   The start y position to crop from.
     * @param int  $src_w   The width to crop.
     * @param int  $src_h   The height to crop.
     * @param int  $dst_w   Optional. The destination width.
     * @param int  $dst_h   Optional. The destination height.
     * @param bool $src_abs Optional. If the source crop points are absolute.
     * @return true|WP_Error
     */
    public abstract function crop($src_x, $src_y, $src_w, $src_h, $dst_w = null, $dst_h = null, $src_abs = false);
    /**
     * Rotates current image counter-clockwise by $angle.
     *
     * @since 3.5.0
     * @abstract
     *
     * @param float $angle
     * @return true|WP_Error
     */
    public abstract function rotate($angle);
    /**
     * Flips current image.
     *
     * @since 3.5.0
     * @abstract
     *
     * @param bool $horz Flip along Horizontal Axis
     * @param bool $vert Flip along Vertical Axis
     * @return true|WP_Error
     */
    public abstract function flip($horz, $vert);
    /**
     * Streams current image to browser.
     *
     * @since 3.5.0
     * @abstract
     *
     * @param string $mime_type The mime type of the image.
     * @return true|WP_Error True on success, WP_Error object on failure.
     */
    public abstract function stream($mime_type = null);
    /**
     * Gets dimensions of image.
     *
     * @since 3.5.0
     *
     * @return array {
     *     Dimensions of the image.
     *
     *     @type int $width  The image width.
     *     @type int $height The image height.
     * }
     */
    public function get_size()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_size") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/class-wp-image-editor.php at line 176")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_size:176@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/class-wp-image-editor.php');
        die();
    }
    /**
     * Sets current image size.
     *
     * @since 3.5.0
     *
     * @param int $width
     * @param int $height
     * @return true
     */
    protected function update_size($width = null, $height = null)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("update_size") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/class-wp-image-editor.php at line 189")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called update_size:189@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/class-wp-image-editor.php');
        die();
    }
    /**
     * Gets the Image Compression quality on a 1-100% scale.
     *
     * @since 4.0.0
     *
     * @return int Compression Quality. Range: [1,100]
     */
    public function get_quality()
    {
        if (!$this->quality) {
            $this->set_quality();
        }
        return $this->quality;
    }
    /**
     * Sets Image Compression quality on a 1-100% scale.
     *
     * @since 3.5.0
     *
     * @param int $quality Compression Quality. Range: [1,100]
     * @return true|WP_Error True if set successfully; WP_Error on failure.
     */
    public function set_quality($quality = null)
    {
        if (null === $quality) {
            /**
             * Filters the default image compression quality setting.
             *
             * Applies only during initial editor instantiation, or when set_quality() is run
             * manually without the `$quality` argument.
             *
             * The WP_Image_Editor::set_quality() method has priority over the filter.
             *
             * @since 3.5.0
             *
             * @param int    $quality   Quality level between 1 (low) and 100 (high).
             * @param string $mime_type Image mime type.
             */
            $quality = apply_filters('wp_editor_set_quality', $this->default_quality, $this->mime_type);
            if ('image/jpeg' === $this->mime_type) {
                /**
                 * Filters the JPEG compression quality for backward-compatibility.
                 *
                 * Applies only during initial editor instantiation, or when set_quality() is run
                 * manually without the `$quality` argument.
                 *
                 * The WP_Image_Editor::set_quality() method has priority over the filter.
                 *
                 * The filter is evaluated under two contexts: 'image_resize', and 'edit_image',
                 * (when a JPEG image is saved to file).
                 *
                 * @since 2.5.0
                 *
                 * @param int    $quality Quality level between 0 (low) and 100 (high) of the JPEG.
                 * @param string $context Context of the filter.
                 */
                $quality = apply_filters('jpeg_quality', $quality, 'image_resize');
            }
            if ($quality < 0 || $quality > 100) {
                $quality = $this->default_quality;
            }
        }
        // Allow 0, but squash to 1 due to identical images in GD, and for backward compatibility.
        if (0 === $quality) {
            $quality = 1;
        }
        if ($quality >= 1 && $quality <= 100) {
            $this->quality = $quality;
            return true;
        } else {
            return new WP_Error('invalid_image_quality', __('Attempted to set image quality outside of the range [1,100].'));
        }
    }
    /**
     * Returns preferred mime-type and extension based on provided
     * file's extension and mime, or current file's extension and mime.
     *
     * Will default to $this->default_mime_type if requested is not supported.
     *
     * Provides corrected filename only if filename is provided.
     *
     * @since 3.5.0
     *
     * @param string $filename
     * @param string $mime_type
     * @return array { filename|null, extension, mime-type }
     */
    protected function get_output_format($filename = null, $mime_type = null)
    {
        $new_ext = null;
        // By default, assume specified type takes priority.
        if ($mime_type) {
            $new_ext = $this->get_extension($mime_type);
        }
        if ($filename) {
            $file_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            $file_mime = $this->get_mime_type($file_ext);
        } else {
            // If no file specified, grab editor's current extension and mime-type.
            $file_ext = strtolower(pathinfo($this->file, PATHINFO_EXTENSION));
            $file_mime = $this->mime_type;
        }
        // Check to see if specified mime-type is the same as type implied by
        // file extension. If so, prefer extension from file.
        if (!$mime_type || $file_mime == $mime_type) {
            $mime_type = $file_mime;
            $new_ext = $file_ext;
        }
        // Double-check that the mime-type selected is supported by the editor.
        // If not, choose a default instead.
        if (!$this->supports_mime_type($mime_type)) {
            /**
             * Filters default mime type prior to getting the file extension.
             *
             * @see wp_get_mime_types()
             *
             * @since 3.5.0
             *
             * @param string $mime_type Mime type string.
             */
            $mime_type = apply_filters('image_editor_default_mime_type', $this->default_mime_type);
            $new_ext = $this->get_extension($mime_type);
        }
        if ($filename) {
            $dir = pathinfo($filename, PATHINFO_DIRNAME);
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            $filename = trailingslashit($dir) . wp_basename($filename, ".{$ext}") . ".{$new_ext}";
        }
        return array($filename, $new_ext, $mime_type);
    }
    /**
     * Builds an output filename based on current file, and adding proper suffix
     *
     * @since 3.5.0
     *
     * @param string $suffix
     * @param string $dest_path
     * @param string $extension
     * @return string filename
     */
    public function generate_filename($suffix = null, $dest_path = null, $extension = null)
    {
        // $suffix will be appended to the destination filename, just before the extension.
        if (!$suffix) {
            $suffix = $this->get_suffix();
        }
        $dir = pathinfo($this->file, PATHINFO_DIRNAME);
        $ext = pathinfo($this->file, PATHINFO_EXTENSION);
        $name = wp_basename($this->file, ".{$ext}");
        $new_ext = strtolower($extension ? $extension : $ext);
        if (!is_null($dest_path)) {
            if (!wp_is_stream($dest_path)) {
                $_dest_path = realpath($dest_path);
                if ($_dest_path) {
                    $dir = $_dest_path;
                }
            } else {
                $dir = $dest_path;
            }
        }
        return trailingslashit($dir) . "{$name}-{$suffix}.{$new_ext}";
    }
    /**
     * Builds and returns proper suffix for file based on height and width.
     *
     * @since 3.5.0
     *
     * @return string|false suffix
     */
    public function get_suffix()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_suffix") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/class-wp-image-editor.php at line 363")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_suffix:363@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/class-wp-image-editor.php');
        die();
    }
    /**
     * Check if a JPEG image has EXIF Orientation tag and rotate it if needed.
     *
     * @since 5.3.0
     *
     * @return bool|WP_Error True if the image was rotated. False if not rotated (no EXIF data or the image doesn't need to be rotated).
     *                       WP_Error if error while rotating.
     */
    public function maybe_exif_rotate()
    {
        $orientation = null;
        if (is_callable('exif_read_data') && 'image/jpeg' === $this->mime_type) {
            $exif_data = @exif_read_data($this->file);
            if (!empty($exif_data['Orientation'])) {
                $orientation = (int) $exif_data['Orientation'];
            }
        }
        /**
         * Filters the `$orientation` value to correct it before rotating or to prevemnt rotating the image.
         *
         * @since 5.3.0
         *
         * @param int    $orientation EXIF Orientation value as retrieved from the image file.
         * @param string $file        Path to the image file.
         */
        $orientation = apply_filters('wp_image_maybe_exif_rotate', $orientation, $this->file);
        if (!$orientation || 1 === $orientation) {
            return false;
        }
        switch ($orientation) {
            case 2:
                // Flip horizontally.
                $result = $this->flip(true, false);
                break;
            case 3:
                // Rotate 180 degrees or flip horizontally and vertically.
                // Flipping seems faster and uses less resources.
                $result = $this->flip(true, true);
                break;
            case 4:
                // Flip vertically.
                $result = $this->flip(false, true);
                break;
            case 5:
                // Rotate 90 degrees counter-clockwise and flip vertically.
                $result = $this->rotate(90);
                if (!is_wp_error($result)) {
                    $result = $this->flip(false, true);
                }
                break;
            case 6:
                // Rotate 90 degrees clockwise (270 counter-clockwise).
                $result = $this->rotate(270);
                break;
            case 7:
                // Rotate 90 degrees counter-clockwise and flip horizontally.
                $result = $this->rotate(90);
                if (!is_wp_error($result)) {
                    $result = $this->flip(true, false);
                }
                break;
            case 8:
                // Rotate 90 degrees counter-clockwise.
                $result = $this->rotate(90);
                break;
        }
        return $result;
    }
    /**
     * Either calls editor's save function or handles file as a stream.
     *
     * @since 3.5.0
     *
     * @param string|stream $filename
     * @param callable      $function
     * @param array         $arguments
     * @return bool
     */
    protected function make_image($filename, $function, $arguments)
    {
        $stream = wp_is_stream($filename);
        if ($stream) {
            ob_start();
        } else {
            // The directory containing the original file may no longer exist when using a replication plugin.
            wp_mkdir_p(dirname($filename));
        }
        $result = call_user_func_array($function, $arguments);
        if ($result && $stream) {
            $contents = ob_get_contents();
            $fp = fopen($filename, 'w');
            if (!$fp) {
                ob_end_clean();
                return false;
            }
            fwrite($fp, $contents);
            fclose($fp);
        }
        if ($stream) {
            ob_end_clean();
        }
        return $result;
    }
    /**
     * Returns first matched mime-type from extension,
     * as mapped from wp_get_mime_types()
     *
     * @since 3.5.0
     *
     * @param string $extension
     * @return string|false
     */
    protected static function get_mime_type($extension = null)
    {
        if (!$extension) {
            return false;
        }
        $mime_types = wp_get_mime_types();
        $extensions = array_keys($mime_types);
        foreach ($extensions as $_extension) {
            if (preg_match("/{$extension}/i", $_extension)) {
                return $mime_types[$_extension];
            }
        }
        return false;
    }
    /**
     * Returns first matched extension from Mime-type,
     * as mapped from wp_get_mime_types()
     *
     * @since 3.5.0
     *
     * @param string $mime_type
     * @return string|false
     */
    protected static function get_extension($mime_type = null)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_extension") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/class-wp-image-editor.php at line 505")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_extension:505@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/class-wp-image-editor.php');
        die();
    }
}