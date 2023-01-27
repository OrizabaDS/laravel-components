<?php

use Carbon\Carbon;

if ( ! function_exists('untrailingSlashit')) {
    function untrailingSlashIt(string $string)
    {
        return rtrim($string, '/\\');
    }
}


if ( ! function_exists('trailingSlashit')) {
    function trailingSlashIt(string $string)
    {
        return untrailingSlashIt($string) . '/';
    }
}


if ( ! function_exists('isLocalEnvironment')) {
    function isLocalEnvironment()
    {
        return (in_array(env('APP_ENV', ''), ['local', 'debug']) || boolval(env('APP_DEBUG', false)));
    }
}


if ( ! function_exists('logOnLocal')) {
    function logOnLocal(string $message, array $data = [], ?\Illuminate\Console\Command $command = null)
    {
        if (isLocalEnvironment()) {
            $backtrace      = null;
            $titlePrefix    = ' ******* INFO: ' . PHP_EOL;
            $backtraceLimit = env('APP_DEBUG_BACKTRACE_LIMIT', 2);

            if ($backtraceLimit > 0) {
                $backtrace = collect(debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, $backtraceLimit) ?? []);

                foreach ($backtrace as $backtraceEntry) {
                    $titlePrefix .= '  >>>>>>> ';

                    if (isset($backtraceEntry['file']) && isset($backtraceEntry['line'])) {
                        $titlePrefix .= $backtraceEntry['file'] . ':' . $backtraceEntry['line'];
                    }

                    if (isset($backtraceEntry['function'])) {
                        $titlePrefix .= ' => ' . $backtraceEntry['function'] . PHP_EOL;
                    }
                }
            }

            $postFix = empty($data) ? '' : ' ******* DATA: ';

            \Illuminate\Support\Facades\Log::info($titlePrefix . PHP_EOL . '<<<<<<<<< ' . $message . PHP_EOL . $postFix, $data);

            if (isset($command)) {
                $command->info($titlePrefix . PHP_EOL . '<<<<<<<<< ' . $message . PHP_EOL . $postFix . json_encode($data));
            }
        }
    }
}


if ( ! function_exists('getArraySubset')) {
    /**
     * Returns the given <keys> in <array>. Returns a formatted string,
     * a single value, or an array with the values for the keys.
     * If any of the <keys> is empty and $ignoreEmpty == true
     * that record will be filtered from the results
     *
     * @param array $array
     * @param string|array $keys
     * @param string $format
     * @param bool $ignoreEmpty
     *
     * @return array
     */
    function getArraySubset(array $array, string|array $keys, string $format = "", bool $ignoreEmpty = true): array
    {
        $parsedElements = array_map(function ($row) use ($keys) {

            // If any of the keys is empty return null
            $values = [];
            foreach (( is_array($keys) ? $keys : [$keys]) as $k){
                if( empty($row[$k]) )
                    return null;

                $values[] = $row[$k];
            }

            return empty($format) ? ( is_array($keys) ? $values : $values[0] ) : vsprintf($format, $values);
        }, $array);

        return $ignoreEmpty ? array_filter($parsedElements) : $parsedElements;
    }
}