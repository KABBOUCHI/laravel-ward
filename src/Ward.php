<?php

namespace KABBOUCHI\Ward;

use Closure;

class Ward
{
    const MAX_FILE_SIZE = 52428800;
    /**
     * The callback that should be used to authenticate Horizon users.
     *
     * @var \Closure
     */
    public static $authUsing;
    /**
     * @var string file
     */
    private static $file;

    private static $levels_classes = [
        'debug'     => 'text-blue',
        'info'      => 'text-blue',
        'notice'    => 'text-blue',
        'warning'   => 'text-orange',
        'error'     => 'text-red',
        'critical'  => 'text-red',
        'alert'     => 'text-red',
        'emergency' => 'text-red',
        'processed' => 'text-blue',
    ];
    private static $levels_imgs = [
        'debug'     => 'exclamation-circle',
        'info'      => 'exclamation-circle',
        'notice'    => 'exclamation-circle',
        'warning'   => 'exclamation-triangle',
        'error'     => 'exclamation-triangle',
        'critical'  => 'exclamation-triangle',
        'alert'     => 'exclamation-triangle',
        'emergency' => 'exclamation-triangle',
        'processed' => 'exclamation-circle'
    ];
    /**
     * Log levels that are used.
     *
     * @var array
     */
    private static $log_levels = [
        'emergency',
        'alert',
        'critical',
        'error',
        'warning',
        'notice',
        'info',
        'debug',
        'processed'
    ];

    /**
     * Determine if the given request can access the Horizon dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public static function check($request)
    {
        return (static::$authUsing ?: function () {
            return app()->environment('local');
        })($request);
    }

    /**
     * Set the callback that should be used to authenticate Horizon users.
     *
     * @param  \Closure  $callback
     * @return static
     */
    public static function auth(Closure $callback)
    {
        static::$authUsing = $callback;

        return new static;
    }

    /**
     * @param  string  $file
     */
    public static function setFile($file)
    {
        $file = self::pathToLogFile($file);
        if (app('files')->exists($file)) {
            self::$file = $file;
        }
    }

    /**
     * @param  string  $file
     * @return string
     *
     * @throws \Exception
     */
    public static function pathToLogFile($file)
    {
        $logsPath = storage_path('logs');
        if (app('files')->exists($file)) { // try the absolute path
            return $file;
        }
        $file = $logsPath.'/'.$file;
        // check if requested file is really in the logs directory
        if (dirname($file) !== $logsPath) {
            throw new \Exception('No such log file');
        }

        return $file;
    }

    /**
     * @return string
     */
    public static function getFileName()
    {
        return basename(self::$file);
    }

    /**
     * @return array
     */
    public static function all()
    {
        $log = [];
        $pattern = '/\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}([\+-]\d{4})?\].*/';
        if (! self::$file) {
            $log_file = self::getFiles();
            if (! count($log_file)) {
                return [];
            }
            self::$file = $log_file[0];
        }
        if (app('files')->size(self::$file) > self::MAX_FILE_SIZE) {
            return;
        }
        $file = app('files')->get(self::$file);
        preg_match_all($pattern, $file, $headings);
        if (! is_array($headings)) {
            return $log;
        }
        $log_data = preg_split($pattern, $file);
        if ($log_data[0] < 1) {
            array_shift($log_data);
        }
        foreach ($headings as $h) {
            for ($i = 0, $j = count($h); $i < $j; $i++) {
                foreach (self::$log_levels as $level) {
                    if (strpos(strtolower($h[$i]), '.'.$level) || strpos(strtolower($h[$i]), $level.':')) {
                        preg_match('/^\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}([\+-]\d{4})?)\](?:.*?(\w+)\.|.*?)'.$level.': (.*?)( in .*?:[0-9]+)?$/i', $h[$i], $current);
                        if (! isset($current[4])) {
                            continue;
                        }
                        $log[] = [
                            'context'     => $current[3],
                            'level'       => $level,
                            'level_class' => self::$levels_classes[$level],
                            'level_img'   => self::$levels_imgs[$level],
                            'date'        => $current[1],
                            'text'        => $current[4],
                            'in_file'     => isset($current[5]) ? $current[5] : null,
                            'stack'       => preg_replace("/^\n*/", '', $log_data[$i])
                        ];
                    }
                }
            }
        }

        return array_reverse($log);
    }

    /**
     * @param  bool  $basename
     * @return array
     */
    public static function getFiles($basename = false)
    {
        $files = glob(storage_path().'/logs/*.log');
        $files = array_reverse($files);
        $files = array_filter($files, 'is_file');
        if ($basename && is_array($files)) {
            foreach ($files as $k => $file) {
                $files[$k] = basename($file);
            }
        }

        return array_values($files);
    }
}
