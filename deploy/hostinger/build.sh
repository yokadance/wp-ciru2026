#!/bin/bash
set -e

# =====================================================
# Build script: crea paquete WordPress completo para Hostinger
# Uso: bash deploy/hostinger/build.sh
# =====================================================

VERSION="1.0"
OUTPUT_DIR="deploy/hostinger/build"
ZIP_FILE="congreso-ciru-hostinger-${VERSION}.zip"

echo "🔨 Construyendo paquete para Hostinger..."

# ── 1. Limpiar build anterior ─────────────────────────
rm -rf "$OUTPUT_DIR"
mkdir -p "$OUTPUT_DIR"

# ── 2. Descargar WordPress core ────────────────────────
echo "📦 Descargando WordPress..."
cd "$OUTPUT_DIR"
curl -sO https://wordpress.org/latest.tar.gz
tar -xzf latest.tar.gz
rm latest.tar.gz
cd ../../..

WP_ROOT="$OUTPUT_DIR/wordpress"

# ── 3. Copiar temas ────────────────────────────────────
echo "🎨 Copiando temas..."
cp -r astra "$WP_ROOT/wp-content/themes/"
cp -r astra-ciru-child "$WP_ROOT/wp-content/themes/"

# ── 4. Copiar mu-plugin de auto-setup ──────────────────
echo "🔧 Copiando auto-setup plugin..."
mkdir -p "$WP_ROOT/wp-content/mu-plugins"
cp deploy/hostinger/congreso-auto-setup.php "$WP_ROOT/wp-content/mu-plugins/"

# ── 5. Crear .htaccess con permalinks ──────────────────
cat > "$WP_ROOT/.htaccess" <<'EOF'
# BEGIN WordPress
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
</IfModule>
# END WordPress
EOF

# ── 6. Crear README ────────────────────────────────────
cat > "$WP_ROOT/README-CONGRESO.txt" <<'EOF'
76º Congreso Uruguayo de Cirugía 2026 — WordPress Package
==========================================================

INSTRUCCIONES DE INSTALACIÓN EN HOSTINGER:

1. Crear base de datos MySQL en cPanel/Hostinger panel
   - Anotar: nombre DB, usuario, contraseña, host (localhost)

2. Subir este paquete:
   - Opción A (FTP): subir la carpeta 'wordpress' completa a public_html/
   - Opción B (File Manager): subir wordpress.zip, extraer en public_html/

3. Navegar a tu dominio en el navegador:
   - Te redirigirá al instalador de WordPress
   - Completar datos de la DB (del paso 1)
   - Crear usuario admin

4. Al primer login en wp-admin:
   - El sistema automáticamente:
     ✓ Activa el tema astra-ciru-child
     ✓ Crea las páginas (Inicio, Postulaciones, Inscripciones)
     ✓ Configura la página de inicio
     ✓ Configura permalinks

5. Listo! El sitio está operativo.

NOTAS:
- No es necesario importar SQL
- El auto-setup se ejecuta solo UNA vez
- Para reinstalar: borrar la opción 'congreso_auto_setup_done' en wp_options

Soporte: admin@congreso.org.uy
EOF

# ── 7. Comprimir ───────────────────────────────────────
echo "📦 Comprimiendo..."
cd "$OUTPUT_DIR"
zip -qr "../$ZIP_FILE" wordpress/
cd ../../..

echo ""
echo "✅ Paquete creado: deploy/hostinger/$ZIP_FILE"
echo ""
echo "PRÓXIMOS PASOS:"
echo "  1. Subir el archivo $ZIP_FILE a Hostinger (File Manager o FTP)"
echo "  2. Extraer en public_html/"
echo "  3. Navegar a tu dominio → completar instalador de WordPress"
echo "  4. Login en wp-admin → auto-setup se ejecuta automáticamente"
echo ""
