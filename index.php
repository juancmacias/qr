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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            background-attachment: fixed;
            min-height: 100vh;
            padding: 20px;
            padding-bottom: 60px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .header {
            text-align: center;
            color: white;
            margin-bottom: 30px;
        }
        
        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }
        
        .header p {
            font-size: 1.1em;
            opacity: 0.9;
        }
        
        .welcome {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 12px;
            margin-bottom: 40px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
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
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
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
            background: white;
            padding: 30px;
            border-radius: 12px;
            margin: 30px 0;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
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
            background: white;
            border-left: 4px solid #2196F3;
            padding: 20px;
            margin: 20px 0;
            border-radius: 4px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        .info-box h3 {
            color: #2196F3;
            margin-bottom: 10px;
        }
        
        .footer {
            text-align: center;
            margin-top: 40px;
            padding: 20px;
            color: white;
        }
        
        .footer a {
            color: white;
            text-decoration: none;
        }
        
        .footer a:hover {
            text-decoration: underline;
        }
        
        .env-badge {
            display: inline-block;
            padding: 4px 12px;
            background: rgba(255,255,255,0.2);
            border-radius: 12px;
            font-size: 12px;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <?php require_once __DIR__ . '/config.php'; ?>
    
    <div class="container">
        <?php 
        $headerTitle = '🔲 PHP QR Code';
        $headerDescription = 'Generador Profesional de Códigos QR';
        include __DIR__ . '/includes/header.php'; 
        ?>
        
        <div class="welcome">
            <h2>¡Bienvenido al Generador de QR!</h2>
            <p>Crea códigos QR personalizados para URLs, vCards, WiFi y mucho más</p>
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
        
        <div class="info-box" style="background:#f8d7da;border-left-color:#dc3545;box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
            <h3 style="color:#721c24;">⚠️ Información del Entorno</h3>
            <div style="color:#721c24;">
                <p style="margin:10px 0;"><strong>Entorno Actual:</strong> <?php echo ENVIRONMENT; ?></p>
                <p style="margin:10px 0;"><strong>URL Base:</strong> <?php echo BASE_URL; ?></p>
                <p style="margin:10px 0;"><strong>Debug Mode:</strong> <?php echo DEBUG_MODE ? 'Activado' : 'Desactivado'; ?></p>
            </div>
        </div>
        
        <?php include __DIR__ . '/includes/footer.php'; ?>
    </div>
</body>
</html>
