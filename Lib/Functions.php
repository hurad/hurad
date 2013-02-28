<?php

class Functions {

    /**
     * Test if a give filesystem path is absolute ('/foo/bar', 'c:\windows').
     *
     * @since 1.0.0
     *
     * @param string $path File path
     * @return bool True if path is absolute, false is not absolute.
     */
    public function path_is_absolute($path) {
        // this is definitive if true but fails if $path does not exist or contains a symbolic link
        if (realpath($path) == $path)
            return true;

        if (strlen($path) == 0 || $path[0] == '.')
            return false;

        // windows allows absolute paths like this
        if (preg_match('#^[a-zA-Z]:\\\\#', $path))
            return true;

        // a path starting with / or \ is absolute; anything else is relative
        return ( $path[0] == '/' || $path[0] == '\\' );
    }

    /**
     * Join two filesystem paths together (e.g. 'give me $path relative to $base').
     *
     * If the $path is absolute, then it the full path is returned.
     *
     * @since 1.0.0
     *
     * @param string $base
     * @param string $path
     * @return string The path with the base or absolute path.
     */
    public function path_join($base, $path) {
        if (Functions::path_is_absolute($path))
            return $path;

        return rtrim($base, '/') . '/' . ltrim($path, '/');
    }

    /**
     * Retrieve a list of protocols to allow in HTML attributes.
     *
     * @since 1.0
     * @see wp_kses()
     * @see esc_url()
     *
     * @return array Array of allowed protocols
     */
    public function allowed_protocols() {
        static $protocols;

        if (empty($protocols)) {
            $protocols = array('http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'gopher', 'nntp', 'feed', 'telnet', 'mms', 'rtsp', 'svn');
        }

        return $protocols;
    }

    /**
     * Determine if SSL is used.
     *
     * @since 1.0.0
     *
     * @return bool True if SSL, false if not used.
     */
    public function is_ssl() {
        if (isset($_SERVER['HTTPS'])) {
            if ('on' == strtolower($_SERVER['HTTPS']))
                return true;
            if ('1' == $_SERVER['HTTPS'])
                return true;
        } elseif (isset($_SERVER['SERVER_PORT']) && ( '443' == $_SERVER['SERVER_PORT'] )) {
            return true;
        }
        return false;
    }

    /**
     * Whether the current request is for a network or blog admin page
     *
     * Does not inform on whether the user is an admin! Use capability checks to
     * tell if the user should be accessing a section or not.
     *
     * @since 1.0.0
     *
     * @return bool True if inside Hurad administration pages.
     */
    public function is_admin() {
        $pos = strpos($_SERVER['REQUEST_URI'], 'admin');

        if ($pos === false) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
     * Convert integer number to format based on the locale.
     *
     * @since 1.0.0
     *
     * @param int $number The number to convert based on locale.
     * @param int $decimals Precision of the number of decimal places.
     * @return string Converted number in string format.
     */
    public function number_format_i18n($number, $decimals = 0) {
        $formatted = number_format($number, Functions::absint($decimals), Configure::read('decimal_point'), Configure::read('thousands_sep'));
        return Configure::read('HuradHook.obj')->apply_filters('number_format_i18n', $formatted);
    }

    /**
     * Converts value to nonnegative integer.
     *
     * @since 1.0.0
     *
     * @param mixed $maybeint Data you wish to have converted to a nonnegative integer
     * @return int An nonnegative integer
     */
    public function absint($maybeint) {
        return abs(intval($maybeint));
    }

    /**
     * Retrieve list of allowed mime types and file extensions.
     *
     * @since 1.0.0
     *
     * @return array Array of mime types keyed by the file extension regex corresponding to those types.
     */
    public function get_allowed_mime_types() {
        static $mimes = false;

        if (!$mimes) {
            // Accepted MIME types are set here as PCRE unless provided.
            $mimes = apply_filters('upload_mimes', array(
                'jpg|jpeg|jpe' => 'image/jpeg',
                'gif' => 'image/gif',
                'png' => 'image/png',
                'bmp' => 'image/bmp',
                'tif|tiff' => 'image/tiff',
                'ico' => 'image/x-icon',
                'asf|asx|wax|wmv|wmx' => 'video/asf',
                'avi' => 'video/avi',
                'divx' => 'video/divx',
                'flv' => 'video/x-flv',
                'mov|qt' => 'video/quicktime',
                'mpeg|mpg|mpe' => 'video/mpeg',
                'txt|asc|c|cc|h' => 'text/plain',
                'csv' => 'text/csv',
                'tsv' => 'text/tab-separated-values',
                'ics' => 'text/calendar',
                'rtx' => 'text/richtext',
                'css' => 'text/css',
                'htm|html' => 'text/html',
                'mp3|m4a|m4b' => 'audio/mpeg',
                'mp4|m4v' => 'video/mp4',
                'ra|ram' => 'audio/x-realaudio',
                'wav' => 'audio/wav',
                'ogg|oga' => 'audio/ogg',
                'ogv' => 'video/ogg',
                'mid|midi' => 'audio/midi',
                'wma' => 'audio/wma',
                'mka' => 'audio/x-matroska',
                'mkv' => 'video/x-matroska',
                'rtf' => 'application/rtf',
                'js' => 'application/javascript',
                'pdf' => 'application/pdf',
                'doc|docx' => 'application/msword',
                'pot|pps|ppt|pptx|ppam|pptm|sldm|ppsm|potm' => 'application/vnd.ms-powerpoint',
                'wri' => 'application/vnd.ms-write',
                'xla|xls|xlsx|xlt|xlw|xlam|xlsb|xlsm|xltm' => 'application/vnd.ms-excel',
                'mdb' => 'application/vnd.ms-access',
                'mpp' => 'application/vnd.ms-project',
                'docm|dotm' => 'application/vnd.ms-word',
                'pptx|sldx|ppsx|potx' => 'application/vnd.openxmlformats-officedocument.presentationml',
                'xlsx|xltx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml',
                'docx|dotx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml',
                'onetoc|onetoc2|onetmp|onepkg' => 'application/onenote',
                'swf' => 'application/x-shockwave-flash',
                'class' => 'application/java',
                'tar' => 'application/x-tar',
                'zip' => 'application/zip',
                'gz|gzip' => 'application/x-gzip',
                'rar' => 'application/rar',
                '7z' => 'application/x-7z-compressed',
                'exe' => 'application/x-msdownload',
                // openoffice formats
                'odt' => 'application/vnd.oasis.opendocument.text',
                'odp' => 'application/vnd.oasis.opendocument.presentation',
                'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
                'odg' => 'application/vnd.oasis.opendocument.graphics',
                'odc' => 'application/vnd.oasis.opendocument.chart',
                'odb' => 'application/vnd.oasis.opendocument.database',
                'odf' => 'application/vnd.oasis.opendocument.formula',
                // wordperfect formats
                'wp|wpd' => 'application/wordperfect',
            ));
        }

        return $mimes;
    }

}
