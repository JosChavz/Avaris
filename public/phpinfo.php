<?php
// Check if XDebug is installed
if (!extension_loaded('xdebug')) {
    echo "XDebug is NOT installed or enabled!\n";
    echo "Extensions loaded: " . implode(', ', get_loaded_extensions()) . "\n";
    exit(1);
}

// Check XDebug version
echo "XDebug is installed.\n";
echo "XDebug version: " . phpversion('xdebug') . "\n";

// Try using XDebug 3 function if available
if (function_exists('xdebug_info')) {
    echo "xdebug_info() is available (XDebug 3+)\n";
    // Don't actually call it here as it outputs a lot of HTML
} else {
    echo "xdebug_info() is NOT available - you have an older version of XDebug.\n";
}

// Show XDebug configuration
echo "\nXDebug Configuration:\n";
$config = ini_get_all('xdebug');
if (is_array($config)) {
    foreach ($config as $key => $value) {
        echo "$key: {$value['local_value']}\n";
    }
} else {
    echo "Could not retrieve XDebug configuration.\n";
}

// Show if XDebug is in debug mode
if (function_exists('xdebug_is_debugger_active')) {
    echo "\nDebugger active: " . (xdebug_is_debugger_active() ? "YES" : "NO") . "\n";
}