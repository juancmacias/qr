<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP QR Code - Generador de Códigos QR</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            padding: 50px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        
        .logo {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .logo h1 {
            font-size: 3em;
            color: #1e3c72;
            margin-bottom: 10px;
        }
        
        .logo p {
            font-size: 1.2em;
            color: #666;
        }
        
        .welcome {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 12px;
            margin-bottom: 40px;
            text-align: center;
        }
        
        .welcome h2 {
            font-size: 2em;
            margin-bottom: 15px;
        }
        
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }
        
        .card {
            background: white;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            padding: 25px;
            text-align: center;
            transition: all 0.3s;
            cursor: pointer;
        }
        
        .card:hover {
            border-color: #667eea;
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }
        
        .card .icon {
            font-size: 3em;
            margin-bottom: 15px;
        }
        
        .card h3 {
            color: #333;
            margin-bottom: 10px;
            font-size: 1.3em;
        }
        
        .card p {
            color: #666;
            font-size: 0.95em;
            line-height: 1.5;
        }
        
        .card a {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            transition: transform 0.2s;
        }
        
        .card a:hover {
            transform: scale(1.05);
        }
        
        .features {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 12px;
            margin: 30px 0;
        }
        
        .features h2 {
            color: #333;
            margin-bottom: 20px;
            font-size: 1.8em;
        }
        
        .features ul {
            list-style: none;
            padding: 0;
        }
        
        .features li {
            padding: 12px 0;
            border-bottom: 1px solid #e0e0e0;
            color: #555;
            display: flex;
            align-items: center;
        }
        
        .features li:last-child {
            border-bottom: none;
        }
        
        .features li:before {
            content: '✓';
            display: inline-block;
            width: 30px;
            height: 30px;
            background: #28a745;
            color: white;
            border-radius: 50%;
            text-align: center;
            line-height: 30px;
            margin-right: 15px;
            font-weight: bold;
        }
        
        .info-box {
            background: #e7f3ff;
            border-left: 4px solid #2196F3;
            padding: 20px;
            margin: 20px 0;
            border-radius: 4px;
        }
        
        .info-box h3 {
            color: #2196F3;
            margin-bottom: 10px;
        }
        
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 2px solid #e0e0e0;
            color: #999;
        }
        
        .footer a {
            color: #667eea;
            text-decoration: none;
        }
        
        .footer a:hover {
            text-decoration: underline;
        }
        
        .env-status {
            background: white;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .env-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 14px;
        }
        
        .env-local {
            background: #cfe2ff;
            color: #084298;
        }
        
        .env-production {
            background: #d1e7dd;
            color: #0f5132;
        }
        
        .docs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin: 25px 0;
        }
        
        .doc-card {
            background: white;
            border: 2px solid #e3f2fd;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s;
            text-decoration: none;
            display: block;
        }
        
        .doc-card:hover {
            border-color: #2196F3;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(33, 150, 243, 0.2);
        }
        
        .doc-card .doc-icon {
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        
        .doc-card .doc-title {
            color: #1976d2;
            font-weight: 600;
            font-size: 1em;
            margin-bottom: 5px;
        }
        
        .doc-card .doc-desc {
            color: #666;
            font-size: 0.85em;
            line-height: 1.4;
        }
    </style>
</head>
<body>
    <?php
    require_once __DIR__ . '/config.php';
    
    $envClass = (ENVIRONMENT === 'production') ? 'env-production' : 'env-local';
    $envLabel = (ENVIRONMENT === 'production') ? '🚀 PRODUCCIÓN' : '💻 LOCAL';
    ?>
    
    <div class="container">
        <div class="logo">
            <h1>🔲 PHP QR Code</h1>
            <p>Generador Profesional de Códigos QR</p>
        </div>
        
        <div class="welcome">
            <h2>¡Bienvenido al Generador de QR!</h2>
            <p>Crea códigos QR personalizados para URLs, vCards, WiFi y mucho más</p>
        </div>
        
        <div class="env-status">
            <div>
                <strong>Estado del Sistema:</strong><br>
                <small style="color:#666;">Entorno actual detectado</small>
            </div>
            <span class="env-badge <?php echo $envClass; ?>">
                <?php echo $envLabel; ?>
            </span>
        </div>
        
        <div class="grid">
            <div class="card">
                <div class="icon">🎨</div>
                <h3>Generador Avanzado</h3>
                <p>Interfaz moderna y completa con múltiples opciones de personalización</p>
                <a href="public/generator.php">Ir al Generador</a>
            </div>
            
            <div class="card">
                <div class="icon">⚡</div>
                <h3>Generador Simple</h3>
                <p>Versión clásica, rápida y sencilla para generar QR básicos</p>
                <a href="index_home.php">Versión Clásica</a>
            </div>
        </div>
        
        <div class="features">
            <h2>✨ Características</h2>
            <ul>
                <li>Generación rápida de códigos QR en PNG</li>
                <li>Múltiples niveles de corrección de errores (L, M, Q, H)</li>
                <li>Tamaños personalizables de 1 a 10 píxeles</li>
                <li>Sistema de caché para optimizar rendimiento</li>
                <li>Soporte para URLs, vCards, WiFi, SMS y más</li>
                <li>Detección automática de entorno (local/producción)</li>
                <li>Interfaz moderna y responsive</li>
                <li>Código abierto bajo licencia LGPL 3</li>
            </ul>
        </div>
        
        <div class="info-box">
            <h3>📚 Documentación</h3>
            <p style="margin-bottom: 15px;">
                Explora nuestras guías y recursos para sacar el máximo provecho del generador de códigos QR
            </p>
            <div class="docs-grid">
                <a href="docs/viewer.php?file=README" class="doc-card">
                    <div class="doc-icon">📖</div>
                    <div class="doc-title">Documentación</div>
                    <div class="doc-desc">Guía completa</div>
                </a>
                
                <a href="docs/viewer.php?file=analisis-codigo.md" class="doc-card">
                    <div class="doc-icon">🔬</div>
                    <div class="doc-title">Análisis Técnico</div>
                    <div class="doc-desc">Detalles del código</div>
                </a>
            </div>
        </div>
        
        <div class="info-box" style="background:#f8d7da;border-left-color:#dc3545;">
            <h3 style="color:#721c24;">⚠️ Información del Entorno</h3>
            <div style="color:#721c24;">
                <p style="margin:10px 0;"><strong>Entorno Actual:</strong> <?php echo ENVIRONMENT; ?></p>
                <p style="margin:10px 0;"><strong>URL Base:</strong> <?php echo BASE_URL; ?></p>
                <p style="margin:10px 0;"><strong>Debug Mode:</strong> <?php echo DEBUG_MODE ? 'Activado' : 'Desactivado'; ?></p>
            </div>
        </div>
        
        <div class="footer">
            <p>
                <strong>PHP QR Code</strong> - Generador de Códigos QR<br>
                Desarrollado con ❤️ | 
                <a href="https://github.com/juancmacias/qr" target="_blank">GitHub</a> | 
                <a href="LICENSE">Licencia LGPL 3</a>
            </p>
            <p style="margin-top:15px;font-size:14px;">
                © <?php echo date('Y'); ?> Juan Carlos Macías
            </p>
        </div>
    </div>
</body>
</html>
