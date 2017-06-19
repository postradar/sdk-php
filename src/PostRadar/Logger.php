<?php
/*
 * Logger class
 */

namespace PostRadar;

class Logger
{
    public static $storage = [];
    public static $mode = null;
    public static $optional = null;
    public static $constructed = false;
    public static $prefix = '';
    public static $level = 3;
    public static $has_thread = false;
    public static $BIG_ENDIAN = false;
    public static $bigint = true;

    const ULTRA_VERBOSE = 5;
    const VERBOSE = 4;
    const NOTICE = 3;
    const WARNING = 2;
    const ERROR = 1;
    const FATAL_ERROR = 0;

    public static function class_exists()
    {
        self::$has_thread = class_exists('\Thread') && method_exists('\Thread', 'getCurrentThread');
        self::$BIG_ENDIAN = (pack('L', 1) === pack('N', 1));
        self::$bigint = PHP_INT_SIZE < 8;
    }

    /*
     * Constructor function
     * Accepts various logger modes:
     * 0 - No logger
     * 1 - Log to the default logger destination
     * 2 - Log to file defined in second parameter
     * 3 - Echo logs
     */
    public static function constructor($mode, $optional = null, $prefix = '', $level = self::NOTICE)
    {
        if ($mode === null) {
            throw new Exception('No mode was specified!');
        }
        self::$mode = $mode;
        self::$optional = $optional;
        self::$constructed = true;
        self::$prefix = $prefix === '' ? '' : ', '.$prefix;
        self::$level = $level;
        self::class_exists();
    }

    public static function log($params, $level = self::NOTICE)
    {
        if (!self::$constructed) {
            throw new Exception("The constructor function wasn't called! Please call the constructor function before using this method.");
        }
        if ($level > self::$level) {
            return false;
        }
        $prefix = self::$prefix;
        if (\PostRadar\Logger::$has_thread && is_object(\Thread::getCurrentThread())) {
            $prefix .= ' (t)';
        }
        foreach (is_array($params) ? $params : [$params] as $param) {
            if (!is_string($param)) {
                $param = json_encode($param, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            }
            $param = str_pad(basename(debug_backtrace()[0]['file'], '.php').$prefix.': ', 16 + strlen($prefix))."\t".$param;
            switch (self::$mode) {
                case 1:
                    error_log($param);
                    break;
                case 2:
                    error_log($param.PHP_EOL, 3, self::$optional);
                    break;
                case 3:
                    echo $param.PHP_EOL;
                    break;
                default:
                    break;
            }
        }
    }
}
