<?php
echo("Testing");
// 1. Force error reporting on for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 2. Force environment variables to use Vercel's writable /tmp directory
$_ENV['APP_CONFIG_CACHE'] = '/tmp/config.php';
$_ENV['APP_ROUTES_CACHE'] = '/tmp/routes.php';
$_ENV['VIEW_COMPILED_PATH'] = '/tmp';

// Redirect Laravel logs to standard output stream (Vercel Log Dashboard) instead of a file
$_ENV['LOG_CHANNEL'] = 'stderr';

// Prevent file session/cache engines from hitting the read-only disk
$_ENV['CACHE_STORE'] = 'array';
$_ENV['SESSION_DRIVER'] = 'cookie';

try {
    $laravelPublicIndex = __DIR__ . '/../public/index.php';
    
    if (!file_exists($laravelPublicIndex)) {
        throw new Exception("Vercel cannot find the Laravel index file at: " . realpath($laravelPublicIndex));
    }

    require $laravelPublicIndex;

} catch (\Throwable $e) {
    echo "<h2>Laravel Boot Failure on Vercel</h2>";
    echo "<p><strong>Error Message:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>File:</strong> " . $e->getFile() . " on line " . $e->getLine() . "</p>";
    echo "<pre><strong>Stack Trace:</strong>\n" . $e->getTraceAsString() . "</pre>";
}