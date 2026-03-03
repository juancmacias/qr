<?php
/**
 * Visor de Documentación Markdown
 * Muestra archivos .md con formato básico
 */

// Obtener el archivo solicitado
$file = $_GET['file'] ?? 'README';
$file = basename($file); // Seguridad: solo nombre de archivo, sin rutas

// Lista de archivos permitidos
$allowed_files = [
    'INSTALL',
    'README',
    'VERSION',
    'analisis-codigo.md'
];

// Validar archivo
if (!in_array($file, $allowed_files)) {
    $file = 'README';
}

$filepath = __DIR__ . '/' . $file;

// Verificar que existe
if (!file_exists($filepath)) {
    die("Archivo no encontrado: $file");
}

// Leer contenido
$content = file_get_contents($filepath);

// Función simple para convertir markdown a HTML básico
function simpleMarkdownToHtml($text) {
    // Encabezados
    $text = preg_replace('/^### (.*?)$/m', '<h3>$1</h3>', $text);
    $text = preg_replace('/^## (.*?)$/m', '<h2>$1</h2>', $text);
    $text = preg_replace('/^# (.*?)$/m', '<h1>$1</h1>', $text);
    
    // Negrita
    $text = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $text);
    
    // Cursiva
    $text = preg_replace('/\*(.*?)\*/', '<em>$1</em>', $text);
    
    // Código inline
    $text = preg_replace('/`(.*?)`/', '<code>$1</code>', $text);
    
    // Enlaces
    $text = preg_replace('/\[(.*?)\]\((.*?)\)/', '<a href="$2" target="_blank">$1</a>', $text);
    
    // Bloques de código
    $text = preg_replace('/```(.*?)```/s', '<pre><code>$1</code></pre>', $text);
    
    // Listas
    $text = preg_replace('/^- (.*?)$/m', '<li>$1</li>', $text);
    $text = preg_replace('/(<li>.*<\/li>\n?)+/s', '<ul>$0</ul>', $text);
    
    // Párrafos (líneas que no son elementos HTML)
    $lines = explode("\n", $text);
    $result = [];
    $in_list = false;
    
    foreach ($lines as $line) {
        $trimmed = trim($line);
        if (empty($trimmed)) {
            $result[] = $line;
            continue;
        }
        
        // Si empieza con < es HTML, no envolver en <p>
        if (preg_match('/^</', $trimmed)) {
            $result[] = $line;
        } else {
            // Envolver en párrafo si no está vacío
            if (!empty($trimmed)) {
                $result[] = '<p>' . $line . '</p>';
            }
        }
    }
    
    return implode("\n", $result);
}

$html_content = simpleMarkdownToHtml($content);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($file); ?> - Documentación</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
            line-height: 1.6;
        }
        
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            padding: 50px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        
        .header {
            border-bottom: 3px solid #667eea;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .header h1 {
            color: #1e3c72;
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        
        .nav-button {
            display: inline-block;
            padding: 10px 20px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s;
            margin-right: 10px;
            margin-bottom: 10px;
        }
        
        .nav-button:hover {
            background: #764ba2;
            transform: translateY(-2px);
        }
        
        .content {
            color: #333;
        }
        
        .content h1 {
            color: #1e3c72;
            font-size: 2em;
            margin: 30px 0 20px 0;
            padding-bottom: 10px;
            border-bottom: 2px solid #e0e0e0;
        }
        
        .content h2 {
            color: #2a5298;
            font-size: 1.6em;
            margin: 25px 0 15px 0;
        }
        
        .content h3 {
            color: #667eea;
            font-size: 1.3em;
            margin: 20px 0 10px 0;
        }
        
        .content p {
            margin: 15px 0;
            color: #555;
            line-height: 1.8;
        }
        
        .content ul {
            margin: 15px 0;
            padding-left: 30px;
        }
        
        .content li {
            margin: 8px 0;
            color: #555;
        }
        
        .content code {
            background: #f5f5f5;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
            color: #e83e8c;
            font-size: 0.9em;
        }
        
        .content pre {
            background: #2d2d2d;
            color: #f8f8f2;
            padding: 20px;
            border-radius: 8px;
            overflow-x: auto;
            margin: 20px 0;
        }
        
        .content pre code {
            background: none;
            color: #f8f8f2;
            padding: 0;
        }
        
        .content a {
            color: #667eea;
            text-decoration: none;
            border-bottom: 1px solid #667eea;
        }
        
        .content a:hover {
            color: #764ba2;
            border-bottom-color: #764ba2;
        }
        
        .content strong {
            color: #333;
            font-weight: 600;
        }
        
        .sidebar {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        
        .sidebar h3 {
            color: #1e3c72;
            margin-bottom: 15px;
            font-size: 1.2em;
        }
        
        .doc-link {
            display: block;
            padding: 8px 12px;
            color: #555;
            text-decoration: none;
            border-radius: 4px;
            margin: 5px 0;
            transition: all 0.2s;
        }
        
        .doc-link:hover {
            background: white;
            color: #667eea;
            transform: translateX(5px);
        }
        
        .doc-link.active {
            background: #667eea;
            color: white;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #e0e0e0;
            text-align: center;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="../index.php" class="nav-button">← Volver al Inicio</a>
            <a href="viewer.php" class="nav-button">📚 Docs</a>
        </div>
        
        <div class="sidebar">
            <h3>📖 Documentación</h3>
            <?php
            $docs = [
                'README' => '🏠 Inicio',
                'INSTALL' => '📦 Instalación',
                'analisis-codigo.md' => '🔬 Análisis Técnico',
            ];
            
            foreach ($docs as $filename => $label) {
                $active = ($filename === $file) ? 'active' : '';
                echo "<a href='viewer.php?file=$filename' class='doc-link $active'>$label</a>\n";
            }
            ?>
        </div>
        
        <div class="content">
            <?php echo $html_content; ?>
        </div>
        
        <div class="footer">
            <p>PHP QR Code - Documentación | © <?php echo date('Y'); ?> Juan Carlos Macías</p>
        </div>
    </div>
</body>
</html>
