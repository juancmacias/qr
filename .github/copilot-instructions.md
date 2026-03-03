# Generador de QR
Este proyecto es un generador de códigos QR que permite a los usuarios crear códigos QR personalizados para compartir información de manera rápida y eficiente. El generador de QR es fácil de usar y ofrece una variedad de opciones de personalización, como colores, tamaños y estilos de código QR.

## 📋 Requisitos del Sistema

### Requisitos Obligatorios
- **PHP:** Versión 5.0 o superior (recomendado PHP 7.x o 8.x para mejor rendimiento)
- **Extensión GD2:** Biblioteca GD de PHP con soporte para:
  - Generación de imágenes PNG
  - Soporte de JPEG
- **Servidor Web:** Apache, Nginx, o cualquier servidor compatible con PHP

### Requisitos Opcionales
- **Permisos de Escritura:** Para el directorio `cache/` si `QR_CACHEABLE=true`
- **Memoria PHP:** Mínimo 64MB (recomendado 128MB para imágenes grandes)
- **Espacio en Disco:** Para almacenar cache y archivos temporales

### Verificación de Requisitos
Puedes verificar si tu sistema cumple con los requisitos ejecutando:
```php
<?php
// Verificar versión de PHP
echo "PHP Version: " . phpversion() . "\n";

// Verificar extensión GD
if (extension_loaded('gd')) {
    echo "GD Extension: Instalada\n";
    $gd_info = gd_info();
    echo "PNG Support: " . ($gd_info['PNG Support'] ? "Sí" : "No") . "\n";
    echo "JPEG Support: " . ($gd_info['JPEG Support'] ? "Sí" : "No") . "\n";
} else {
    echo "GD Extension: NO instalada (REQUERIDA)\n";
}
?>
```

## 🚀 Instalación

### Método 1: Instalación Simple
1. Descarga o clona este repositorio:
```bash
git clone https://github.com/juancmacias/qr.git
cd qr
```

2. Configura los permisos del directorio `cache/` (si usarás caché):
```bash
chmod -R 755 cache/
```

3. ¡Listo! Ya puedes usar la biblioteca.

### Método 2: Instalación para Producción
1. Clona el repositorio en tu servidor web:
```bash
cd /var/www/html
git clone https://github.com/juancmacias/qr.git
```

2. Configura los permisos necesarios:
```bash
chmod -R 755 qr/cache/
chown -R www-data:www-data qr/cache/
```

3. Ajusta la configuración en `qrconfig.php` según tus necesidades.

## ⚙️ Configuración

### Archivo de Configuración: `qrconfig.php`

```php
// Habilitar/deshabilitar caché
define('QR_CACHEABLE', true);

// Directorio de caché (asegúrate de que sea escribible)
define('QR_CACHE_DIR', dirname(__FILE__).DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR);

// Directorio para logs de errores
define('QR_LOG_DIR', dirname(__FILE__).DIRECTORY_SEPARATOR);

// Buscar la mejor máscara (true = mejor calidad pero más lento)
define('QR_FIND_BEST_MASK', true);

// Búsqueda aleatoria de máscara (para rendimiento)
define('QR_FIND_FROM_RANDOM', false);

// Máscara por defecto cuando QR_FIND_BEST_MASK = false
define('QR_DEFAULT_MASK', 2);

// Tamaño máximo permitido para imágenes PNG (en píxeles)
define('QR_PNG_MAXIMUM_SIZE', 1024);
```

### Configuraciones Recomendadas

#### Para Desarrollo (Máxima Calidad)
```php
define('QR_CACHEABLE', true);
define('QR_FIND_BEST_MASK', true);
define('QR_FIND_FROM_RANDOM', false);
```

#### Para Producción (Balance)
```php
define('QR_CACHEABLE', true);
define('QR_FIND_BEST_MASK', true);
define('QR_PNG_MAXIMUM_SIZE', 2048);
```

#### Para Alto Rendimiento (Máxima Velocidad)
```php
define('QR_CACHEABLE', false);
define('QR_FIND_BEST_MASK', false);
define('QR_DEFAULT_MASK', 2);
```

## 💻 Uso e Implementación

### Uso Básico

#### 1. Inclusión de la Biblioteca
```php
<?php
// Incluir la biblioteca principal
include "qrlib.php";

// O usar la versión merged (todo en un archivo)
include "phpqrcode.php";
?>
```

#### 2. Generar QR Simple
```php
<?php
include "qrlib.php";

// Generar y guardar en archivo
QRcode::png('Hola Mundo', 'output.png');

// Generar con parámetros personalizados
QRcode::png(
    'https://github.com/juancmacias/qr',  // Texto a codificar
    'qr-github.png',                        // Archivo de salida
    'H',                                    // Nivel de corrección (L, M, Q, H)
    10,                                     // Tamaño de píxel
    2                                       // Margen
);
?>
```

#### 3. Generar QR Directamente al Navegador
```php
<?php
include "qrlib.php";

// Importante: No debe haber ninguna salida antes de esto
header('Content-Type: image/png');
QRcode::png('Texto a codificar');
?>
```

### Ejemplos Avanzados

#### Generar QR con Diferentes Niveles de Corrección
```php
<?php
include "qrlib.php";

// L = Low (~7% corrección)
QRcode::png('https://example.com', 'qr-low.png', 'L', 4, 2);

// M = Medium (~15% corrección)
QRcode::png('https://example.com', 'qr-medium.png', 'M', 4, 2);

// Q = Quartile (~25% corrección)
QRcode::png('https://example.com', 'qr-quartile.png', 'Q', 4, 2);

// H = High (~30% corrección) - Ideal si agregarás logo
QRcode::png('https://example.com', 'qr-high.png', 'H', 4, 2);
?>
```

#### Formulario Web Interactivo
```php
<!DOCTYPE html>
<html>
<head>
    <title>Generador de QR</title>
</head>
<body>
    <h1>Generador de Códigos QR</h1>
    <form method="POST">
        <label>Texto o URL:</label><br>
        <input type="text" name="text" size="50" required><br><br>
        
        <label>Nivel de Corrección:</label><br>
        <select name="level">
            <option value="L">Bajo (L)</option>
            <option value="M" selected>Medio (M)</option>
            <option value="Q">Alto (Q)</option>
            <option value="H">Muy Alto (H)</option>
        </select><br><br>
        
        <label>Tamaño:</label><br>
        <input type="number" name="size" value="4" min="1" max="10"><br><br>
        
        <input type="submit" value="Generar QR">
    </form>
    
    <?php
    if ($_POST) {
        include "qrlib.php";
        
        $text = $_POST['text'];
        $level = $_POST['level'];
        $size = intval($_POST['size']);
        $filename = 'temp/qr_' . time() . '.png';
        
        QRcode::png($text, $filename, $level, $size, 2);
        
        echo "<h2>QR Generado:</h2>";
        echo "<img src='$filename' alt='QR Code'><br>";
        echo "<a href='$filename' download>Descargar QR</a>";
    }
    ?>
</body>
</html>
```

#### Integración con Base de Datos
```php
<?php
include "qrlib.php";

// Conectar a base de datos
$mysqli = new mysqli("localhost", "user", "password", "database");

// Obtener datos
$result = $mysqli->query("SELECT id, url FROM productos");

while ($row = $result->fetch_assoc()) {
    $filename = "qr_producto_" . $row['id'] . ".png";
    
    // Generar QR para cada producto
    QRcode::png($row['url'], "productos/$filename", 'M', 4, 2);
    
    // Actualizar base de datos con ruta del QR
    $mysqli->query("UPDATE productos SET qr_image='$filename' WHERE id=" . $row['id']);
}

echo "QR generados para todos los productos";
?>
```

## 🎨 Parámetros y Opciones

### Método `QRcode::png()`
```php
QRcode::png($text, $outfile, $level, $size, $margin, $saveandprint);
```

| Parámetro | Tipo | Descripción | Valores | Por Defecto |
|-----------|------|-------------|---------|-------------|
| `$text` | string | Texto o datos a codificar | Cualquier string | Requerido |
| `$outfile` | string/false | Archivo de salida o false para navegador | Ruta o false | false |
| `$level` | string | Nivel de corrección de errores | L, M, Q, H | L |
| `$size` | int | Tamaño de cada módulo en píxeles | 1-10 | 3 |
| `$margin` | int | Margen en módulos alrededor del QR | 0-10 | 4 |
| `$saveandprint` | bool | Guardar y mostrar simultáneamente | true/false | false |

### Niveles de Corrección de Errores

| Nivel | Nombre | Corrección | Uso Recomendado |
|-------|--------|------------|-----------------|
| **L** | Low | ~7% | URLs simples, textos cortos |
| **M** | Medium | ~15% | Uso general |
| **Q** | Quartile | ~25% | Entornos con posible daño |
| **H** | High | ~30% | QR con logos o diseños personalizados |

## 🔧 Funciones Útiles

### Herramientas de Depuración
```php
<?php
include "qrlib.php";

// Medir rendimiento
QRtools::timeBenchmark();

// Reconstruir caché
QRtools::buildCache();

// Generar en modo texto (para debugging)
$tab = QRcode::text('PHP QR Code');
QRspec::debug($tab, true);
?>
```

## 📱 Casos de Uso Comunes

### 1. URLs y Enlaces Web
```php
QRcode::png('https://github.com/juancmacias/qr', 'qr-web.png', 'M', 4, 2);
```

### 2. Información de Contacto (vCard)
```php
$vcard = "BEGIN:VCARD\n";
$vcard .= "VERSION:3.0\n";
$vcard .= "FN:Juan Carlos Macías\n";
$vcard .= "TEL:+34123456789\n";
$vcard .= "EMAIL:juan@example.com\n";
$vcard .= "END:VCARD";

QRcode::png($vcard, 'contacto.png', 'M', 4, 2);
```

### 3. WiFi (Conexión Automática)
```php
$wifi = "WIFI:T:WPA;S:NombreRed;P:ContraseñaSegura;;";
QRcode::png($wifi, 'wifi.png', 'H', 5, 2);
```

### 4. SMS o Llamadas
```php
// SMS
QRcode::png('SMSTO:+34123456789:Hola desde QR', 'sms.png', 'M', 4, 2);

// Llamada telefónica
QRcode::png('TEL:+34123456789', 'llamada.png', 'M', 4, 2);
```

### 5. Ubicación Geográfica
```php
$geo = "geo:40.416775,-3.703790";  // Latitud, Longitud
QRcode::png($geo, 'ubicacion.png', 'M', 4, 2);
```

### 6. Email
```php
$email = "mailto:usuario@example.com?subject=Asunto&body=Mensaje";
QRcode::png($email, 'email.png', 'M', 4, 2);
```

## ⚠️ Consideraciones Importantes

### Seguridad
- ⚠️ Valida y sanitiza siempre la entrada del usuario antes de generar QR
- ⚠️ No confíes ciegamente en datos escaneados de códigos QR
- ⚠️ Establece límites de tamaño para evitar ataques DoS

### Performance
- 💡 Usa caché en producción para mejorar rendimiento
- 💡 `QR_FIND_BEST_MASK=true` es lento pero produce mejores resultados
- 💡 Para alto volumen, considera generar QR en procesos batch

### Límites
- Tamaño máximo de datos varía según versión y nivel de corrección
- Versión 40 con nivel L puede almacenar hasta ~2953 bytes
- Versión 1 con nivel H solo ~17 bytes

## 🐛 Solución de Problemas

### Error: "GD extension not loaded"
```bash
# Ubuntu/Debian
sudo apt-get install php-gd
sudo service apache2 restart

# CentOS/RHEL
sudo yum install php-gd
sudo systemctl restart httpd
```

### Error: "Permission denied" en cache/
```bash
chmod -R 755 cache/
chown -R www-data:www-data cache/
```

### QR no se genera correctamente
- Verifica que no haya salida antes de `QRcode::png()`
- Asegúrate de que los headers no estén enviados
- Revisa los logs de PHP para errores

## 📚 Recursos Adicionales

- **Documentación completa:** Ver `doc/analisis-codigo.md`
- **Ejemplos:** Ver `index.php`
- **Especificación QR:** ISO/IEC 18004
- **Licencia:** LGPL 3



