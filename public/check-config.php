<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación de Configuración - PHP QR Code</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            border-bottom: 3px solid #007bff;
            padding-bottom: 10px;
        }
        h2 {
            color: #555;
            margin-top: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        th {
            background: #007bff;
            color: white;
            font-weight: 600;
        }
        tr:hover {
            background: #f8f9fa;
        }
        .status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
        }
        .status.success {
            background: #d4edda;
            color: #155724;
        }
        .status.warning {
            background: #fff3cd;
            color: #856404;
        }
        .status.error {
            background: #f8d7da;
            color: #721c24;
        }
        .env-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 14px;
            margin: 10px 0;
        }
        .env-local {
            background: #cfe2ff;
            color: #084298;
        }
        .env-production {
            background: #d1e7dd;
            color: #0f5132;
        }
        .info-box {
            background: #e7f3ff;
            border-left: 4px solid #007bff;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .warning-box {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .code {
            background: #f4f4f4;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
            font-size: 13px;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }
        .card {
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
        }
        .card h3 {
            margin-top: 0;
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Verificación de Configuración</h1>
        
        <?php
        require_once __DIR__ . '/../config.php';
        
        // Clase de entorno
        $envClass = (ENVIRONMENT === 'production') ? 'env-production' : 'env-local';
        $envLabel = (ENVIRONMENT === 'production') ? '🚀 PRODUCCIÓN' : '💻 LOCAL/DESARROLLO';
        ?>
        
        <div class="info-box">
            <strong>Entorno Actual:</strong> 
            <span class="env-badge <?php echo $envClass; ?>">
                <?php echo $envLabel; ?> (<?php echo ENVIRONMENT; ?>)
            </span>
        </div>

        <h2>📋 Configuración Principal</h2>
        <table>
            <tr>
                <th>Variable</th>
                <th>Valor</th>
                <th>Estado</th>
            </tr>
            <tr>
                <td><strong>Entorno</strong></td>
                <td class="code"><?php echo ENVIRONMENT; ?></td>
                <td><span class="status success">✓ OK</span></td>
            </tr>
            <tr>
                <td><strong>Base URL</strong></td>
                <td class="code"><?php echo BASE_URL; ?></td>
                <td><span class="status success">✓ OK</span></td>
            </tr>
            <tr>
                <td><strong>Base Path</strong></td>
                <td class="code"><?php echo BASE_PATH; ?></td>
                <td><span class="status success">✓ OK</span></td>
            </tr>
            <tr>
                <td><strong>Debug Mode</strong></td>
                <td class="code"><?php echo DEBUG_MODE ? 'ON' : 'OFF'; ?></td>
                <td><span class="status <?php echo DEBUG_MODE ? 'warning' : 'success'; ?>">
                    <?php echo DEBUG_MODE ? '⚠ ACTIVADO' : '✓ DESACTIVADO'; ?>
                </span></td>
            </tr>
        </table>

        <h2>📁 Directorios</h2>
        <table>
            <tr>
                <th>Directorio</th>
                <th>Ruta</th>
                <th>Existe</th>
                <th>Escribible</th>
            </tr>
            <?php
            $directories = [
                'ROOT' => ROOT_DIR,
                'TEMP' => TEMP_DIR,
                'CACHE' => CACHE_DIR,
            ];
            
            foreach ($directories as $name => $path) {
                $exists = file_exists($path);
                $writable = $exists && is_writable($path);
                ?>
                <tr>
                    <td><strong><?php echo $name; ?></strong></td>
                    <td class="code"><?php echo $path; ?></td>
                    <td><span class="status <?php echo $exists ? 'success' : 'error'; ?>">
                        <?php echo $exists ? '✓ Sí' : '✗ No'; ?>
                    </span></td>
                    <td><span class="status <?php echo $writable ? 'success' : 'warning'; ?>">
                        <?php echo $writable ? '✓ Sí' : '✗ No'; ?>
                    </span></td>
                </tr>
            <?php } ?>
        </table>

        <h2>🌐 URLs Web</h2>
        <table>
            <tr>
                <th>Tipo</th>
                <th>URL Relativa</th>
                <th>URL Completa</th>
            </tr>
            <tr>
                <td><strong>Directorio Temporal</strong></td>
                <td class="code"><?php echo TEMP_WEB_DIR; ?></td>
                <td class="code"><?php echo getUrl(TEMP_WEB_DIR); ?></td>
            </tr>
            <tr>
                <td><strong>Directorio Caché</strong></td>
                <td class="code"><?php echo CACHE_WEB_DIR; ?></td>
                <td class="code"><?php echo getUrl(CACHE_WEB_DIR); ?></td>
            </tr>
        </table>

        <h2>⚙️ Configuración QR</h2>
        <table>
            <tr>
                <th>Parámetro</th>
                <th>Valor</th>
                <th>Descripción</th>
            </tr>
            <tr>
                <td><strong>QR_CACHEABLE</strong></td>
                <td class="code"><?php echo QR_CACHEABLE ? 'true' : 'false'; ?></td>
                <td>Caché de códigos QR</td>
            </tr>
            <tr>
                <td><strong>QR_FIND_BEST_MASK</strong></td>
                <td class="code"><?php echo APP_QR_FIND_BEST_MASK ? 'true' : 'false'; ?></td>
                <td>Optimización de calidad</td>
            </tr>
            <tr>
                <td><strong>QR_PNG_MAXIMUM_SIZE</strong></td>
                <td class="code"><?php echo APP_QR_PNG_MAXIMUM_SIZE; ?> px</td>
                <td>Tamaño máximo de imagen</td>
            </tr>
            <tr>
                <td><strong>QR_FIND_FROM_RANDOM</strong></td>
                <td class="code"><?php echo QR_FIND_FROM_RANDOM ? 'true' : 'false'; ?></td>
                <td>Búsqueda aleatoria de máscara</td>
            </tr>
        </table>

        <h2>🛠️ Información del Sistema</h2>
        <div class="grid">
            <div class="card">
                <h3>PHP</h3>
                <p><strong>Versión:</strong> <?php echo phpversion(); ?></p>
                <p><strong>SO:</strong> <?php echo PHP_OS; ?></p>
                <p><strong>SAPI:</strong> <?php echo php_sapi_name(); ?></p>
            </div>
            
            <div class="card">
                <h3>Extensiones</h3>
                <p><strong>GD:</strong> 
                    <?php echo extension_loaded('gd') ? '✓ Instalada' : '✗ No instalada'; ?>
                </p>
                <?php if (extension_loaded('gd')): 
                    $gd_info = gd_info();
                ?>
                <p><strong>PNG:</strong> <?php echo $gd_info['PNG Support'] ? '✓' : '✗'; ?></p>
                <p><strong>JPEG:</strong> <?php echo $gd_info['JPEG Support'] ? '✓' : '✗'; ?></p>
                <?php endif; ?>
            </div>
            
            <div class="card">
                <h3>Servidor</h3>
                <p><strong>Host:</strong> <?php echo $_SERVER['HTTP_HOST'] ?? 'N/A'; ?></p>
                <p><strong>Software:</strong> <?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'N/A'; ?></p>
                <p><strong>Protocolo:</strong> <?php echo $_SERVER['SERVER_PROTOCOL'] ?? 'N/A'; ?></p>
            </div>
        </div>

        <?php if (DEBUG_MODE): ?>
        <div class="warning-box">
            <strong>⚠️ Advertencia:</strong> El modo debug está ACTIVADO. 
            Asegúrate de desactivarlo en producción para evitar mostrar información sensible.
        </div>
        <?php endif; ?>

        <div class="info-box" style="margin-top: 30px;">
            <strong>💡 Consejo:</strong> Si los valores no son correctos, verifica:
            <ul style="margin: 10px 0 0 20px;">
                <li>El archivo <span class="code">.env</span> (si existe)</li>
                <li>El archivo <span class="code">config.php</span></li>
                <li>Los permisos de los directorios <span class="code">temp/</span> y <span class="code">cache/</span></li>
            </ul>
        </div>

        <p style="text-align: center; margin-top: 40px; color: #999;">
            <a href="../index.php" style="color: #007bff; text-decoration: none;">← Volver a la página principal</a>
        </p>
    </div>
</body>
</html>
