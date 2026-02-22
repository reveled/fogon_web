# Fogón Criollo — Contexto para Claude Code

## Stack
- WordPress en Herd (local)
- Tema hijo: hello-theme-child-master
- Servidor: Hostinger SSH puerto 65002

## Rutas clave
- Local: ~/Herd/fogoncriollo.com
- Producción: ~/domains/fogoncriollo.com/public_html

## Comandos frecuentes
- Subir código: git add . && git commit -m "" && git push
- Sincronizar uploads: ./sync-to-prod.sh push
- Traer uploads: ./sync-to-prod.sh pull

## NO tocar
- wp-config.php
- wp-content/uploads/
- Base de datos directamente