<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generador de Códigos QR - PHP QR Code</title>
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
        
        .main-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        @media (max-width: 768px) {
            .main-content {
                grid-template-columns: 1fr;
            }
        }
        
        .card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        .card h2 {
            color: #333;
            margin-bottom: 20px;
            font-size: 1.5em;
            border-bottom: 3px solid #667eea;
            padding-bottom: 10px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 600;
        }
        
        .form-group input[type="text"],
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        
        .form-group textarea {
            resize: vertical;
            min-height: 80px;
            font-family: inherit;
        }
        
        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        
        .btn {
            width: 100%;
            padding: 14px 28px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .btn:active {
            transform: translateY(0);
        }
        
        .result-area {
            text-align: center;
        }
        
        .qr-image {
            background: #f8f9fa;
            border: 3px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            display: inline-block;
        }
        
        .qr-image img {
            display: block;
            max-width: 100%;
            height: auto;
        }
        
        .download-btn {
            display: inline-block;
            padding: 12px 24px;
            background: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            transition: background 0.3s;
        }
        
        .download-btn:hover {
            background: #218838;
        }
        
        .info-box {
            background: #e7f3ff;
            border-left: 4px solid #2196F3;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
            font-size: 14px;
        }
        
        .examples {
            margin-top: 20px;
        }
        
        .example-btn {
            display: inline-block;
            padding: 8px 16px;
            background: #f0f0f0;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin: 5px;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 13px;
        }
        
        .example-btn:hover {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }
        
        .footer {
            text-align: center;
            color: white;
            margin-top: 40px;
            padding: 20px;
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
    <?php
    require_once __DIR__ . '/../config.php';
    include __DIR__ . '/../lib/qrlib.php';
    
    $qrGenerated = false;
    $qrFilename = '';
    $qrData = '';
    $errorMessage = '';
    
    // Procesar formulario
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['data'])) {
        $qrData = trim($_POST['data']);
        
        if (empty($qrData)) {
            $errorMessage = 'Por favor, ingresa datos para generar el código QR.';
        } else {
            $errorCorrectionLevel = $_POST['level'] ?? 'M';
            $matrixPointSize = intval($_POST['size'] ?? 4);
            $margin = intval($_POST['margin'] ?? 2);
            
            // Validar parámetros
            if (!in_array($errorCorrectionLevel, ['L', 'M', 'Q', 'H'])) {
                $errorCorrectionLevel = 'M';
            }
            $matrixPointSize = min(max($matrixPointSize, 1), 10);
            $margin = min(max($margin, 0), 10);
            
            // Generar nombre único para el archivo
            $hash = md5($qrData . '|' . $errorCorrectionLevel . '|' . $matrixPointSize . '|' . $margin . '|' . time());
            $qrFilename = 'qr_' . $hash . '.png';
            $qrFullPath = TEMP_DIR . $qrFilename;
            
            try {
                QRcode::png($qrData, $qrFullPath, $errorCorrectionLevel, $matrixPointSize, $margin);
                $qrGenerated = true;
            } catch (Exception $e) {
                $errorMessage = 'Error al generar el código QR: ' . $e->getMessage();
            }
        }
    }
    ?>
    
    <div class="container">
        <?php 
        $headerTitle = '🔲 Generador de Códigos QR';
        $headerDescription = 'Crea códigos QR personalizados de forma rápida y sencilla';
        include __DIR__ . '/../includes/header.php'; 
        ?>
        
        <div class="main-content">
            <!-- Formulario de generación -->
            <div class="card">
                <h2>📝 Configuración</h2>
                
                <form method="POST" action="" id="qrForm">
                    <div class="form-group">
                        <label for="data">Texto o URL *</label>
                        <textarea 
                            name="data" 
                            id="data" 
                            placeholder="Ingresa texto, URL, vCard, WiFi, etc."
                            required><?php echo htmlspecialchars($_POST['data'] ?? ''); ?></textarea>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="level">Nivel de Corrección</label>
                            <select name="level" id="level">
                                <option value="L" <?php echo (($_POST['level'] ?? 'M') === 'L') ? 'selected' : ''; ?>>
                                    L - Bajo (~7%)
                                </option>
                                <option value="M" <?php echo (($_POST['level'] ?? 'M') === 'M') ? 'selected' : ''; ?>>
                                    M - Medio (~15%)
                                </option>
                                <option value="Q" <?php echo (($_POST['level'] ?? 'M') === 'Q') ? 'selected' : ''; ?>>
                                    Q - Alto (~25%)
                                </option>
                                <option value="H" <?php echo (($_POST['level'] ?? 'M') === 'H') ? 'selected' : ''; ?>>
                                    H - Muy Alto (~30%)
                                </option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="size">Tamaño del Píxel</label>
                            <select name="size" id="size">
                                <?php for ($i = 1; $i <= 10; $i++): ?>
                                <option value="<?php echo $i; ?>" <?php echo (($_POST['size'] ?? 4) == $i) ? 'selected' : ''; ?>>
                                    <?php echo $i; ?> px
                                </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="margin">Margen</label>
                        <select name="margin" id="margin">
                            <?php for ($i = 0; $i <= 10; $i++): ?>
                            <option value="<?php echo $i; ?>" <?php echo (($_POST['margin'] ?? 2) == $i) ? 'selected' : ''; ?>>
                                <?php echo $i; ?> módulos
                            </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn">Generar Código QR</button>
                </form>
                
                <div class="info-box">
                    <strong>💡 Consejo:</strong> Para códigos QR con logos o en áreas expuestas a daño, 
                    usa el nivel de corrección H (Muy Alto).
                </div>
                
                <div class="examples">
                    <strong>Ejemplos rápidos:</strong><br>
                    <button class="example-btn" onclick="setExample('https://www.juancarlosmacias.es')">
                        🌐 URL
                    </button>
                    <button class="example-btn" onclick="setExample('mailto:contacto@example.com?subject=Hola')">
                        ✉️ Email
                    </button>
                    <button class="example-btn" onclick="setExample('TEL:+34123456789')">
                        📞 Teléfono
                    </button>
                    <button class="example-btn" onclick="setExample('WIFI:T:WPA;S:MiRed;P:MiPassword;;')">
                        📶 WiFi
                    </button>
                    <button class="example-btn" onclick="setExample('geo:40.416775,-3.703790')">
                        📍 Ubicación
                    </button>
                </div>
            </div>
            
            <!-- Resultado -->
            <div class="card">
                <h2>🎯 Resultado</h2>
                
                <div class="result-area">
                    <?php if ($errorMessage): ?>
                        <div style="background:#f8d7da;color:#721c24;padding:15px;border-radius:6px;margin:20px 0;">
                            <strong>Error:</strong> <?php echo htmlspecialchars($errorMessage); ?>
                        </div>
                    <?php elseif ($qrGenerated): ?>
                        <div class="qr-image">
                            <img src="<?php echo getUrl($qrFilename ? 'temp/' . $qrFilename : ''); ?>" alt="Código QR">
                        </div>
                        
                        <p style="margin:15px 0;color:#666;word-break:break-all;">
                            <strong>Datos codificados:</strong><br>
                            <?php 
                            $displayData = $qrData;
                            if (function_exists('mb_strlen')) {
                                $displayData = htmlspecialchars(mb_substr($qrData, 0, 100)) . (mb_strlen($qrData) > 100 ? '...' : '');
                            } else {
                                $displayData = htmlspecialchars(substr($qrData, 0, 100)) . (strlen($qrData) > 100 ? '...' : '');
                            }
                            echo $displayData;
                            ?>
                        </p>
                        
                        <a href="<?php echo getUrl('temp/' . $qrFilename); ?>" 
                           download="codigo-qr.png" 
                           class="download-btn">
                            ⬇️ Descargar QR
                        </a>
                        
                        <div class="info-box" style="margin-top:20px;">
                            <strong>ℹ️ Información:</strong><br>
                            Nivel: <strong><?php echo $errorCorrectionLevel ?? 'M'; ?></strong> | 
                            Tamaño: <strong><?php echo $matrixPointSize ?? 4; ?>px</strong> | 
                            Margen: <strong><?php echo $margin ?? 2; ?></strong>
                        </div>
                    <?php else: ?>
                        <div style="padding:60px 20px;color:#999;">
                            <div style="font-size:64px;margin-bottom:20px;">📱</div>
                            <p>Completa el formulario y haz clic en "Generar Código QR"</p>
                            <p style="margin-top:10px;font-size:14px;">El código QR aparecerá aquí</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <?php 
        $footerBasePath = BASE_URL . BASE_PATH;
        $footerAdditionalLinks = ' | <a href="' . BASE_URL . BASE_PATH . '">Inicio</a>';
        include __DIR__ . '/../includes/footer.php'; 
        ?>
    </div>
    
    <script>
        function setExample(text) {
            document.getElementById('data').value = text;
            document.getElementById('data').focus();
        }
        
        // Auto-submit en cambios (opcional, comentado por defecto)
        /*
        document.querySelectorAll('#qrForm select').forEach(select => {
            select.addEventListener('change', () => {
                if (document.getElementById('data').value.trim()) {
                    document.getElementById('qrForm').submit();
                }
            });
        });
        */
    </script>
</body>
</html>
