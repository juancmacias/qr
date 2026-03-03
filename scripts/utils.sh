#!/bin/bash
# Script de Utilidades para PHP QR Code
# Linux/Mac Shell Script

RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

show_menu() {
    clear
    echo ""
    echo "========================================"
    echo "  PHP QR Code - Utilidades"
    echo "========================================"
    echo ""
    echo "1. Limpiar caché de QR"
    echo "2. Limpiar archivos temporales"
    echo "3. Verificar permisos"
    echo "4. Ver estado del proyecto"
    echo "5. Crear backup"
    echo "6. Verificar requisitos"
    echo "7. Salir"
    echo ""
}

clean_cache() {
    echo ""
    echo -e "${BLUE}Limpiando caché de QR...${NC}"
    rm -f ../cache/mask_*/*.png 2>/dev/null
    rm -f ../cache/*.dat 2>/dev/null
    echo -e "${GREEN}✓ Caché limpiado correctamente${NC}"
    read -p "Presiona Enter para continuar..."
}

clean_temp() {
    echo ""
    echo -e "${BLUE}Limpiando archivos temporales...${NC}"
    rm -f ../temp/*.png 2>/dev/null
    rm -f ../temp/*.jpg 2>/dev/null
    rm -f ../temp/*.gif 2>/dev/null
    rm -f ../*.log 2>/dev/null
    echo -e "${GREEN}✓ Archivos temporales eliminados${NC}"
    read -p "Presiona Enter para continuar..."
}

check_permissions() {
    echo ""
    echo -e "${BLUE}Verificando permisos...${NC}"
    echo ""
    
    # Verificar directorios
    if [ -d "../cache" ]; then
        echo -e "${GREEN}✓${NC} Directorio cache/ existe"
        chmod 755 ../cache/ 2>/dev/null
    else
        echo -e "${RED}✗${NC} Directorio cache/ no existe"
        mkdir -p ../cache
        chmod 755 ../cache
        echo -e "${GREEN}✓${NC} Directorio cache/ creado"
    fi
    
    if [ -d "../temp" ]; then
        echo -e "${GREEN}✓${NC} Directorio temp/ existe"
        chmod 755 ../temp/ 2>/dev/null
    else
        echo -e "${RED}✗${NC} Directorio temp/ no existe"
        mkdir -p ../temp
        chmod 755 ../temp
        echo -e "${GREEN}✓${NC} Directorio temp/ creado"
    fi
    
    # Verificar .env
    if [ -f "../.env" ]; then
        echo -e "${GREEN}✓${NC} Archivo .env existe"
    else
        echo -e "${YELLOW}⚠${NC} Archivo .env no existe"
        if [ -f "../.env.example" ]; then
            cp ../.env.example ../.env
            echo -e "${GREEN}✓${NC} Archivo .env creado desde .env.example"
        fi
    fi
    
    echo ""
    read -p "Presiona Enter para continuar..."
}

show_status() {
    echo ""
    echo "========================================"
    echo "  Estado del Proyecto"
    echo "========================================"
    echo ""
    
    echo "Archivos PHP:"
    ls -1 ../*.php 2>/dev/null | wc -l
    echo ""
    
    echo "Archivos de configuración:"
    [ -f "../config.php" ] && echo -e "${GREEN}✓${NC} config.php" || echo -e "${RED}✗${NC} config.php"
    [ -f "../.env" ] && echo -e "${GREEN}✓${NC} .env" || echo -e "${RED}✗${NC} .env"
    [ -f "../.htaccess" ] && echo -e "${GREEN}✓${NC} .htaccess" || echo -e "${RED}✗${NC} .htaccess"
    echo ""
    
    echo "Directorios:"
    [ -d "../cache" ] && echo -e "${GREEN}✓${NC} cache/" || echo -e "${RED}✗${NC} cache/"
    [ -d "../temp" ] && echo -e "${GREEN}✓${NC} temp/" || echo -e "${RED}✗${NC} temp/"
    [ -d "../docs" ] && echo -e "${GREEN}✓${NC} docs/" || echo -e "${RED}✗${NC} docs/"
    [ -d "../lib" ] && echo -e "${GREEN}✓${NC} lib/" || echo -e "${RED}✗${NC} lib/"
    [ -d "../public" ] && echo -e "${GREEN}✓${NC} public/" || echo -e "${RED}✗${NC} public/"
    echo ""
    
    echo "Última modificación:"
    [ -f "../config.php" ] && ls -lh ../config.php | awk '{print "config.php: "$6" "$7" "$8}'
    [ -f "../index.php" ] && ls -lh ../index.php | awk '{print "index.php: "$6" "$7" "$8}'
    echo ""
    
    read -p "Presiona Enter para continuar..."
}

create_backup() {
    echo ""
    echo -e "${BLUE}Creando backup del proyecto...${NC}"
    
    timestamp=$(date +%Y%m%d_%H%M%S)
    backupdir="../backup_$timestamp"
    
    mkdir -p "$backupdir"
    
    echo "Copiando archivos..."
    cp ../*.php "$backupdir/" 2>/dev/null
    cp ../*.md "$backupdir/" 2>/dev/null
    cp ../.htaccess "$backupdir/" 2>/dev/null
    cp ../.env.example "$backupdir/" 2>/dev/null
    
    mkdir -p "$backupdir/docs"
    cp ../docs/*.* "$backupdir/docs/" 2>/dev/null
    
    mkdir -p "$backupdir/lib"
    cp ../lib/*.* "$backupdir/lib/" 2>/dev/null
    
    echo ""
    echo -e "${GREEN}✓ Backup creado en: $backupdir/${NC}"
    echo ""
    read -p "Presiona Enter para continuar..."
}

check_requirements() {
    echo ""
    echo "========================================"
    echo "  Verificación de Requisitos"
    echo "========================================"
    echo ""
    
    # PHP Version
    echo "PHP:"
    if command -v php &> /dev/null; then
        php_version=$(php -v | head -n 1)
        echo -e "${GREEN}✓${NC} $php_version"
    else
        echo -e "${RED}✗${NC} PHP no está instalado"
    fi
    echo ""
    
    # GD Extension
    echo "Extensión GD:"
    if php -m | grep -q "gd"; then
        echo -e "${GREEN}✓${NC} Extensión GD instalada"
    else
        echo -e "${RED}✗${NC} Extensión GD no está instalada"
    fi
    echo ""
    
    # Apache
    echo "Servidor Web:"
    if command -v apache2 &> /dev/null; then
        apache_version=$(apache2 -v | head -n 1)
        echo -e "${GREEN}✓${NC} $apache_version"
    elif command -v httpd &> /dev/null; then
        httpd_version=$(httpd -v | head -n 1)
        echo -e "${GREEN}✓${NC} $httpd_version"
    else
        echo -e "${YELLOW}⚠${NC} Apache no detectado (puede estar instalado de otra forma)"
    fi
    echo ""
    
    read -p "Presiona Enter para continuar..."
}

# Main loop
while true; do
    show_menu
    read -p "Selecciona una opción: " option
    
    case $option in
        1) clean_cache ;;
        2) clean_temp ;;
        3) check_permissions ;;
        4) show_status ;;
        5) create_backup ;;
        6) check_requirements ;;
        7) 
            echo ""
            echo "¡Gracias por usar PHP QR Code!"
            echo ""
            exit 0
            ;;
        *) 
            echo ""
            echo -e "${RED}Opción inválida${NC}"
            sleep 2
            ;;
    esac
done
