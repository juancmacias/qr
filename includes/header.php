<?php
/**
 * Header estandarizado para todas las páginas del proyecto
 * Cabecera con título y descripción centrados sobre el fondo degradado
 */

// Configuración del header (debe ser definida antes de incluir este archivo)
$headerTitle = isset($headerTitle) ? $headerTitle : '🔲 PHP QR Code';
$headerDescription = isset($headerDescription) ? $headerDescription : 'Generador de Códigos QR';
$showEnvBadge = isset($showEnvBadge) ? $showEnvBadge : true;
?>
<div class="header">
    <h1><?php echo $headerTitle; ?></h1>
    <p>
        <?php echo $headerDescription; ?>
        <?php if ($showEnvBadge && defined('ENVIRONMENT')): ?>
            <span class="env-badge"><?php echo strtoupper(ENVIRONMENT); ?></span>
        <?php endif; ?>
    </p>
</div>
