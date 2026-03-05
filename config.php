<?php
/**
 * Configuración de Entorno - PHP QR Code
 * 
 * Este archivo gestiona las configuraciones para diferentes entornos:
 * - Local/Prueba: http://www.misqr.qrr
 * - Producción: https://www.juancarlosmacias.es/qr
 */

// Cargar variables de entorno desde .env si existe
if (file_exists(__DIR__ . '/.env')) {
    $lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($name, $value) = explode('=', $line, 2);
        $_ENV[trim($name)] = trim($value);
    }
}

// Detectar entorno automáticamente
function detectEnvironment() {
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    
    // Entorno de producción
    if (strpos($host, 'juancarlosmacias.es') !== false) {
        return 'production';
    }
    
    // Entorno local/prueba
    if (strpos($host, 'misqr.qrr') !== false || strpos($host, 'localhost') !== false) {
        return 'local';
    }
    
    // Por defecto, entorno local
    return 'local';
}

// Establecer entorno
$ENVIRONMENT = $_ENV['ENVIRONMENT'] ?? detectEnvironment();

// Configuraciones por entorno
$config = [
    'local' => [
        'BASE_URL' => 'http://www.misqr.qrr',
        'BASE_PATH' => '/',
        'DEBUG' => true,
        'CACHE_ENABLED' => true,
        'QR_FIND_BEST_MASK' => true,
        'QR_PNG_MAXIMUM_SIZE' => 1024,
    ],
    'production' => [
        'BASE_URL' => 'https://www.juancarlosmacias.es',
        'BASE_PATH' => '/qr/',
        'DEBUG' => false,
        'CACHE_ENABLED' => true,
        'QR_FIND_BEST_MASK' => true,
        'QR_PNG_MAXIMUM_SIZE' => 2048,
    ]
];

// Aplicar configuración del entorno actual
$currentConfig = $config[$ENVIRONMENT];

// Definir constantes globales
define('ENVIRONMENT', $ENVIRONMENT);
define('BASE_URL', $currentConfig['BASE_URL']);
define('BASE_PATH', $currentConfig['BASE_PATH']);
define('DEBUG_MODE', $currentConfig['DEBUG']);
define('APP_CACHE_ENABLED', $currentConfig['CACHE_ENABLED']);

// Definir constantes específicas de QR
define('APP_QR_FIND_BEST_MASK', $currentConfig['QR_FIND_BEST_MASK']);
define('APP_QR_PNG_MAXIMUM_SIZE', $currentConfig['QR_PNG_MAXIMUM_SIZE']);

// Directorios del proyecto
define('ROOT_DIR', __DIR__);
define('TEMP_DIR', ROOT_DIR . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR);
define('CACHE_DIR', ROOT_DIR . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR);

// URLs web
define('TEMP_WEB_DIR', BASE_PATH . 'temp/');
define('CACHE_WEB_DIR', BASE_PATH . 'cache/');

// Configuración de errores según entorno
if (DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', ROOT_DIR . '/error.log');
}

// Crear directorios si no existen
if (!file_exists(TEMP_DIR)) {
    mkdir(TEMP_DIR, 0755, true);
}

if (!file_exists(CACHE_DIR)) {
    mkdir(CACHE_DIR, 0755, true);
}

/**
 * Obtener URL completa
 * @param string $path Ruta relativa
 * @return string URL completa
 */
function getUrl($path = '') {
    return BASE_URL . BASE_PATH . ltrim($path, '/');
}

/**
 * Verificar si estamos en producción
 * @return bool
 */
function isProduction() {
    return ENVIRONMENT === 'production';
}

/**
 * Verificar si estamos en local
 * @return bool
 */
function isLocal() {
    return ENVIRONMENT === 'local';
}

/**
 * Mostrar información de debug (solo en modo local)
 * @param mixed $data Datos a mostrar
 * @param string $label Etiqueta
 */
function debugInfo($data, $label = 'Debug') {
    if (DEBUG_MODE) {
        echo "<div style='background:#f0f0f0;border:1px solid #ccc;padding:10px;margin:10px 0;'>";
        echo "<strong>$label:</strong><br>";
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        echo "</div>";
    }
}
