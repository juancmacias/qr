# Configuración de Entornos

## 📌 URLs del Proyecto

### Entorno Local/Prueba
- **URL:** http://www.misqr.qrr
- **Path:** `/`

### Entorno de Producción
- **URL:** https://www.juancarlosmacias.es/qr
- **Path:** `/qr/`

## 🚀 Configuración Inicial

### 1. Configuración Básica

El proyecto detecta automáticamente el entorno basándose en el dominio:
- `www.misqr.qrr` → Entorno local
- `juancarlosmacias.es` → Entorno de producción
- `localhost` → Entorno local

### 2. Configuración Manual (Opcional)

Si necesitas forzar un entorno específico:

1. Copia `.env.example` a `.env`:
```bash
cp .env.example .env
```

2. Edita `.env` y establece el entorno:
```ini
ENVIRONMENT=local
# o
ENVIRONMENT=production
```

## 📝 Uso en el Código

### Incluir Configuración

Al inicio de cualquier archivo PHP:
```php
<?php
require_once __DIR__ . '/config.php';
```

### Constantes Disponibles

```php
// Información del entorno
ENVIRONMENT          // 'local' o 'production'
BASE_URL            // URL base del sitio
BASE_PATH           // Path base (/ o /qr/)
DEBUG_MODE          // true/false

// Directorios
ROOT_DIR            // Directorio raíz del proyecto
TEMP_DIR            // Directorio temporal (absoluto)
CACHE_DIR           // Directorio de caché (absoluto)

// URLs web
TEMP_WEB_DIR        // Directorio temporal (relativo para HTML)
CACHE_WEB_DIR       // Directorio de caché (relativo para HTML)

// Configuración QR
APP_QR_FIND_BEST_MASK    // Optimización de calidad
APP_QR_PNG_MAXIMUM_SIZE  // Tamaño máximo de imagen
```

### Funciones Auxiliares

```php
// Obtener URL completa
$url = getUrl('temp/imagen.png');
// Local: http://www.misqr.qrr/temp/imagen.png
// Producción: https://www.juancarlosmacias.es/qr/temp/imagen.png

// Verificar entorno
if (isProduction()) {
    // Código solo para producción
}

if (isLocal()) {
    // Código solo para local
}

// Debug (solo se muestra en local)
debugInfo($data, 'Información de debug');
```

## 🔧 Configuración Apache

### Local (hosts)

Agrega a tu archivo hosts:
```
127.0.0.1 www.misqr.qrr
```

### Virtual Host Local

```apache
<VirtualHost *:80>
    ServerName www.misqr.qrr
    DocumentRoot "e:/wwwserver/N_JCMS/qr"
    
    <Directory "e:/wwwserver/N_JCMS/qr">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

### Producción

El archivo `.htaccess` ya está configurado para:
- Proteger archivos sensibles (.env, config.php)
- Optimizar rendimiento
- Mejorar seguridad

## 📦 Despliegue

### Deploy a Producción

1. **Subir archivos** (excluyendo):
   - `.env` (crear uno nuevo en servidor)
   - `temp/*` (archivos temporales)
   - `.git/` (si usas Git)

2. **Configurar permisos:**
```bash
chmod 755 temp/
chmod 755 cache/
chmod 644 config.php
chmod 644 .htaccess
```

3. **Verificar entorno:**
   - Acceder a `https://www.juancarlosmacias.es/qr/`
   - Debe detectar automáticamente el entorno de producción

### Sincronización Segura

Excluir de sincronización:
```
.env
temp/*.png
cache/*.png
*.log
```

## 🔍 Verificación

### Verificar Configuración Actual

Crea un archivo `check-config.php`:
```php
<?php
require_once __DIR__ . '/config.php';

echo "<h2>Información del Entorno</h2>";
echo "<table border='1' cellpadding='10'>";
echo "<tr><th>Variable</th><th>Valor</th></tr>";
echo "<tr><td>Entorno</td><td>" . ENVIRONMENT . "</td></tr>";
echo "<tr><td>Base URL</td><td>" . BASE_URL . "</td></tr>";
echo "<tr><td>Base Path</td><td>" . BASE_PATH . "</td></tr>";
echo "<tr><td>Debug Mode</td><td>" . (DEBUG_MODE ? 'ON' : 'OFF') . "</td></tr>";
echo "<tr><td>Temp Dir</td><td>" . TEMP_DIR . "</td></tr>";
echo "<tr><td>Cache Dir</td><td>" . CACHE_DIR . "</td></tr>";
echo "</table>";
```

## ⚙️ Configuraciones Personalizadas

### Por Entorno

Edita `config.php` para ajustar configuraciones específicas:

```php
'local' => [
    'BASE_URL' => 'http://www.misqr.qrr',
    'DEBUG' => true,
    'QR_FIND_BEST_MASK' => true,  // Mejor calidad, más lento
    'QR_PNG_MAXIMUM_SIZE' => 1024,
],
'production' => [
    'BASE_URL' => 'https://www.juancarlosmacias.es/qr',
    'DEBUG' => false,
    'QR_FIND_BEST_MASK' => true,
    'QR_PNG_MAXIMUM_SIZE' => 2048,  // Mayor tamaño en producción
]
```

## 🐛 Troubleshooting

### Problema: No detecta el entorno correcto
**Solución:** Crea `.env` y fuerza el entorno:
```ini
ENVIRONMENT=local
```

### Problema: Errores de permisos en temp/ o cache/
**Solución:**
```bash
chmod -R 755 temp/
chmod -R 755 cache/
```

### Problema: URLs incorrectas en producción
**Solución:** Verifica que `BASE_PATH` incluya el subdirectorio `/qr/`:
```php
'BASE_PATH' => '/qr/',  // No olvidar la barra final
```

### Problema: No funcionan los archivos .htaccess
**Solución:** Verifica que Apache tenga `AllowOverride All` activado.

## 📚 Recursos

- [Documentación Principal](README)
- [Análisis de Código](doc/analisis-codigo.md)
- [Instrucciones de Copilot](.github/copilot-instructions.md)
