<?php
spl_autoload_register(function ($class) {
    $prefix = 'PhpOffice\\PhpSpreadsheet\\';
    $base_dir = __DIR__ . '/src/PhpSpreadsheet/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

// Cargar manualmente dependencias necesarias
require_once __DIR__ . '/../Psr/SimpleCache/CacheInterface.php';
require_once __DIR__ . '/../MyCache/ArrayCache.php';
require_once __DIR__ . '/../ZipStream/Option/Archive.php';
require_once __DIR__ . '/../ZipStream/ZipStream.php';
