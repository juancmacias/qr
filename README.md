# 🔲 PHP QR Code Generator

Generador profesional de códigos QR con interfaz moderna y múltiples opciones de personalización.

## 📁 Estructura del Proyecto

```
qr/
├── 📄 index.php              # Interfaz principal del usuario (moderna)
├── 📄 index_home.php         # Página con ejemplos de código
├── 📄 config.php             # Configuración del entorno
├── 📄 LICENSE                # Licencia LGPL 3
│
├── 📂 lib/                   # Biblioteca QR completa
│   ├── qrlib.php            # Archivo principal de la biblioteca
│   ├── qrconfig.php         # Configuración interna de QR
│   ├── qrencode.php         # Motor de codificación
│   ├── qrimage.php          # Generación de imágenes
│   └── ...                  # Otros módulos de la biblioteca
│
├── 📂 public/                # Páginas públicas
│   ├── generator.php        # Generador avanzado con interfaz moderna
│   └── check-config.php     # Verificación de configuración
│
├── 📂 docs/                  # Documentación completa
│   ├── analisis-codigo.md   # Análisis detallado del código
│   ├── QUICKSTART.md        # Guía de inicio rápido
│   ├── SETUP.md             # Guía de configuración
│   ├── INSTALL              # Instrucciones de instalación
│   └── ...                  # Otros documentos
│
├── 📂 scripts/               # Utilidades y scripts
│   ├── utils.bat            # Utilidades para Windows
│   └── utils.sh             # Utilidades para Linux/Mac
│
├── 📂 cache/                 # Caché de QR (generado automáticamente)
├── 📂 temp/                  # Archivos temporales
├── 📂 tools/                 # Herramientas de desarrollo
└── 📂 bindings/              # Bindings para otras bibliotecas
```

## 🚀 Inicio Rápido

### Acceso Directo
- **Página Principal**: `index.php` (interfaz moderna)
- **Ejemplos de Código**: `index_home.php`
- **Generador Avanzado**: `public/generator.php`
- **Documentación**: `docs/viewer.php` (visor interactivo)
- **Verificar Config**: `public/check-config.php`

### Uso Básico en Código
```php
<?php
require_once __DIR__ . '/lib/qrlib.php';

// Generar QR simple
QRcode::png('Hola Mundo', 'mi-qr.png');

// Generar con opciones
QRcode::png(
    'https://ejemplo.com',  // Datos
    'qr-output.png',         // Archivo
    'H',                     // Nivel corrección (L, M, Q, H)
    10,                      // Tamaño
    2                        // Margen
);
?>
```

## ⚙️ Configuración

1. **Copia el archivo de ejemplo**:
   ```bash
   cp .env.example .env
   ```

2. **Edita `config.php`** según tu entorno:
   - Local: `http://www.misqr.qrr`
   - Producción: `https://www.juancarlosmacias.es/qr`

3. **Verifica los requisitos**:
   - PHP 5.0+ (recomendado 7.x o 8.x)
   - Extensión GD2 de PHP
   - Permisos de escritura en `cache/` y `temp/`

## 🛠️ Utilidades

### Windows
```cmd
cd scripts
utils.bat
```

### Linux/Mac
```bash
cd scripts
chmod +x utils.sh
./utils.sh
```

Opciones disponibles:
1. Limpiar caché de QR
2. Limpiar archivos temporales
3. Verificar permisos
4. Ver estado del proyecto
5. Crear backup
6. Verificar requisitos (solo Linux/Mac)

## 📖 Documentación

Para más información, consulta los documentos en la carpeta `docs/`:

- **[QUICKSTART.md](docs/QUICKSTART.md)** - Guía de inicio rápido
- **[SETUP.md](docs/SETUP.md)** - Guía de configuración completa
- **[analisis-codigo.md](docs/analisis-codigo.md)** - Análisis detallado del código
- **[INSTALL](docs/INSTALL)** - Instrucciones de instalación

## 🎨 Características

- ✅ Generación rápida de códigos QR en PNG
- ✅ Múltiples niveles de corrección de errores (L, M, Q, H)
- ✅ Personalización de tamaño y márgenes
- ✅ Interfaz web moderna e intuitiva
- ✅ Sistema de caché para mejor rendimiento
- ✅ Soporte para múltiples entornos (local/producción)
- ✅ Configuración flexible

## 📝 Licencia

Este proyecto está licenciado bajo LGPL 3.0. Ver archivo [LICENSE](LICENSE) para más detalles.

## 🔗 Enlaces

- **Repositorio**: https://github.com/juancmacias/qr
- **Autor**: Juan Carlos Macías

---

Para soporte o preguntas, consulta la documentación en `docs/` o abre un issue en GitHub.
