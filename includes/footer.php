<?php
/**
 * Footer estandarizado para todas las páginas del proyecto
 * Incluye enlaces principales y copyright
 */

// Ajustar la ruta base según el contexto del archivo que incluye este footer
$basePathAdjustment = isset($footerBasePath) ? $footerBasePath : '';

// Enlaces adicionales opcionales
$additionalLinks = isset($footerAdditionalLinks) ? $footerAdditionalLinks : '';
?>
<div class="footer">
    <p>
        <strong>PHP QR Code</strong> - Generador de Códigos QR<br>
        Desarrollado con ❤️ | 
        <a href="https://github.com/juancmacias/qr" target="_blank">GitHub</a><?php echo $additionalLinks; ?> | 
        <a href="<?php echo $basePathAdjustment; ?>LICENSE">Licencia LGPL 3</a>
    </p>
    <p style="margin-top:15px;font-size:14px;opacity:0.8;">
        © <?php echo date('Y'); ?> <a href="https://www.juancarlosmacias.es" target="_blank" title="Juan Carlos Macías">Juan Carlos Macías</a>
    </p>
</div>
