@echo off
REM Script de Utilidades para PHP QR Code
REM Windows Batch Script

:menu
cls
echo.
echo ========================================
echo  PHP QR Code - Utilidades
echo ========================================
echo.
echo 1. Limpiar cache de QR
echo 2. Limpiar archivos temporales
echo 3. Verificar permisos
echo 4. Ver estado del proyecto
echo 5. Crear backup
echo 6. Salir
echo.
set /p option="Selecciona una opcion: "

if "%option%"=="1" goto clean_cache
if "%option%"=="2" goto clean_temp
if "%option%"=="3" goto check_perms
if "%option%"=="4" goto status
if "%option%"=="5" goto backup
if "%option%"=="6" goto end

:clean_cache
echo.
echo Limpiando cache de QR...
del /q ..\cache\mask_0\*.png 2>nul
del /q ..\cache\mask_1\*.png 2>nul
del /q ..\cache\mask_2\*.png 2>nul
del /q ..\cache\mask_3\*.png 2>nul
del /q ..\cache\mask_4\*.png 2>nul
del /q ..\cache\mask_5\*.png 2>nul
del /q ..\cache\mask_6\*.png 2>nul
del /q ..\cache\mask_7\*.png 2>nul
del /q ..\cache\*.dat 2>nul
echo Cache limpiado correctamente!
pause
goto menu

:clean_temp
echo.
echo Limpiando archivos temporales...
del /q ..\temp\*.png 2>nul
del /q ..\temp\*.jpg 2>nul
del /q ..\temp\*.gif 2>nul
del /q ..\*.log 2>nul
echo Archivos temporales eliminados!
pause
goto menu

:check_perms
echo.
echo Verificando permisos...
if exist ..\cache\ (
    echo [OK] Directorio cache/ existe
) else (
    echo [ERROR] Directorio cache/ no existe
    mkdir ..\cache
    echo [OK] Directorio cache/ creado
)

if exist ..\temp\ (
    echo [OK] Directorio temp/ existe
) else (
    echo [ERROR] Directorio temp/ no existe
    mkdir ..\temp
    echo [OK] Directorio temp/ creado
)

if exist ..\.env (
    echo [OK] Archivo .env existe
) else (
    echo [WARNING] Archivo .env no existe
    echo Copiando desde .env.example...
    copy ..\.env.example ..\.env >nul
    echo [OK] Archivo .env creado
)
pause
goto menu

:status
echo.
echo ========================================
echo  Estado del Proyecto
echo ========================================
echo.
echo Archivos PHP:
dir /b ..\.php | find /c ".php"
echo.
echo Archivos de configuracion:
if exist ..\config.php echo [OK] config.php
if exist ..\.env echo [OK] .env
if exist ..\.htaccess echo [OK] .htaccess
echo.
echo Directorios:
if exist ..\cache\ echo [OK] cache/
if exist ..\temp\ echo [OK] temp/
if exist ..\docs\ echo [OK] docs/
if exist ..\lib\ echo [OK] lib/
if exist ..\public\ echo [OK] public/
echo.
echo Ultima modificacion de archivos clave:
if exist ..\config.php dir ..\config.php | find "config.php"
if exist ..\index.php dir ..\index.php | find "index.php"
echo.
pause
goto menu

:backup
echo.
echo Creando backup del proyecto...
set timestamp=%date:~-4,4%%date:~-10,2%%date:~-7,2%_%time:~0,2%%time:~3,2%%time:~6,2%
set timestamp=%timestamp: =0%
set backupdir=..\backup_%timestamp%

mkdir %backupdir% 2>nul

echo Copiando archivos...
xcopy ..\*.php %backupdir%\ /Y /Q >nul
xcopy ..\*.md %backupdir%\ /Y /Q >nul
xcopy ..\.htaccess %backupdir%\ /Y /Q >nul 2>nul
xcopy ..\.env.example %backupdir%\ /Y /Q >nul

mkdir %backupdir%\docs 2>nul
xcopy ..\docs\*.* %backupdir%\docs\ /Y /Q >nul

mkdir %backupdir%\lib 2>nul
xcopy ..\lib\*.* %backupdir%\lib\ /Y /Q >nul

echo.
echo [OK] Backup creado en: %backupdir%\
echo.
pause
goto menu

:end
echo.
echo Gracias por usar PHP QR Code!
echo.
timeout /t 2 >nul
exit

