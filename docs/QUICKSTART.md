# Quick Start - PHP QR Code

## 🚀 Inicio Rápido

### 1. Configurar Entorno Local

1. **Configurar hosts** (Windows: `C:\Windows\System32\drivers\etc\hosts`):
```
127.0.0.1 www.misqr.qrr
```

2. **Configurar Virtual Host** en Apache:
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

3. **Reiniciar Apache**

4. **Acceder a:**
   - Generador: http://www.misqr.qrr/
   - Verificación: http://www.misqr.qrr/check-config.php

### 2. Verificar Requisitos

```bash
# Verificar PHP
php -v

# Verificar extensión GD
php -m | grep gd
```

### 3. Permisos

```bash
chmod 755 temp/
chmod 755 cache/
```

## 📝 Uso Básico

```php
<?php
require_once 'config.php';
include 'qrlib.php';

// Generar QR simple
QRcode::png('Hola Mundo', TEMP_DIR . 'test.png');

// Mostrar en navegador
echo '<img src="' . getUrl('temp/test.png') . '" alt="QR Code">';
?>
```

## 🔗 Enlaces Útiles

- [Documentación Completa](README)
- [Configuración de Entornos](ENVIRONMENT.md)
- [Análisis de Código](doc/analisis-codigo.md)

## 📦 Deploy a Producción

```bash
# Excluir de la sincronización:
.env
temp/*.png
cache/*.png
*.log
```

**URL de producción:** https://www.juancarlosmacias.es/qr

## ⚡ Comandos Útiles

```bash
# Limpiar caché
rm -rf cache/mask_*/*.png

# Limpiar temp
rm -rf temp/*.png

# Ver logs de error
tail -f error.log
```

## 🆘 Soporte

Si tienes problemas, consulta [ENVIRONMENT.md](ENVIRONMENT.md) para troubleshooting detallado.
