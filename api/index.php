<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Force Vercel-specific serverless overrides
$_ENV['VIEW_COMPILED_PATH'] = '/tmp';
$_ENV['LOG_CHANNEL'] = 'stderr';
putenv('VIEW_COMPILED_PATH=/tmp');
putenv('LOG_CHANNEL=stderr');

// Catch any fatal PHP startup/compilation errors
register_shutdown_function(function() {
    $error = error_get_last();
    if ($error !== null && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        echo "<pre>Fatal Error captured in api/index.php:\n";
        print_r($error);
        echo "</pre>";
    }
});

try {
    // Forward request to Laravel public index.php
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    echo "<pre>Uncaught Exception in api/index.php:\n";
    echo $e->getMessage() . "\n";
    echo $e->getTraceAsString();
    echo "</pre>";
}
