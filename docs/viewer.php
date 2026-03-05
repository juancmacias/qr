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
            background-attachment: fixed;
            min-height: 100vh;
            padding: 20px;
            padding-bottom: 60px;
            line-height: 1.6;
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
        
        .nav-section {
            background: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            text-align: center;
        }
        
        .nav-button {
            display: inline-block;
            padding: 12px 24px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s;
            margin: 5px;
        }
        
        .nav-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .content {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            color: #333;
        }
        
        .content h1 {
            color: #667eea;
            font-size: 2em;
            margin: 30px 0 20px 0;
            padding-bottom: 10px;
            border-bottom: 2px solid #e0e0e0;
        }
        
        .content h2 {
            color: #667eea;
            font-size: 1.6em;
            margin: 25px 0 15px 0;
        }
        
        .content h3 {
            color: #764ba2;
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
            background: white;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        .sidebar h3 {
            color: #667eea;
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
            background: #f0f0f0;
            color: #667eea;
            transform: translateX(5px);
        }
        
        .doc-link.active {
            background: #667eea;
            color: white;
        }
        
        .env-badge {
            display: inline-block;
            padding: 4px 12px;
            background: rgba(255,255,255,0.2);
            border-radius: 12px;
            font-size: 12px;
            margin-left: 10px;
        }
        
        .footer {
            margin-top: 40px;
            padding: 20px;
            text-align: center;
            color: white;
        }
        
        .footer a {
            color: white;
            text-decoration: none;
        }
        
        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php 
        $headerTitle = '📚 Documentación PHP QR Code';
        $headerDescription = 'Guías, referencias y análisis técnico del generador de códigos QR';
        $showEnvBadge = false;
        include __DIR__ . '/../includes/header.php'; 
        ?>
        
        <div class="nav-section">
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
        
        <?php 
        $footerBasePath = '../';
        $footerAdditionalLinks = ' | <a href="../index.php">Inicio</a>';
        include __DIR__ . '/../includes/footer.php'; 
        ?>
    </div>
</body>
</html>
