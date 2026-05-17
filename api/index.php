<?php

// Forward Vercel requests to the standard Laravel public/index.php
// require __DIR__ . '/../public/index.php';

echo "PHP is working on Vercel!";

// 1. Force error reporting on so nothing hides
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // 2. Check if the file even exists before loading it
    $laravelPublicIndex = __DIR__ . '/../public/index.php';
    
    if (!file_exists($laravelPublicIndex)) {
        throw new Exception("Vercel cannot find the Laravel index file at: " . realpath($laravelPublicIndex));
    }

    // 3. Attempt to load Laravel
    require $laravelPublicIndex;

} catch (\Throwable $e) {
    // 4. Catch the exact missing dependency or permission crash
    echo "<h2>Laravel Boot Failure on Vercel</h2>";
    echo "<p><strong>Error Message:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>File:</strong> " . $e->getFile() . " on line " . $e->getLine() . "</p>";
    echo "<pre><strong>Stack Trace:</strong>\n" . $e->getTraceAsString() . "</pre>";
}