@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../zircote/swagger-php/bin/swagger
php "%BIN_TARGET%" %*
