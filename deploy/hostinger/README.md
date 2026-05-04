# Despliegue en Hostinger

Paquete auto-instalable de WordPress con temas y configuración incluidos — **sin necesidad de importar SQL**.

## 🚀 Generación del paquete

```bash
make hostinger-package
```

Esto crea: `deploy/hostinger/congreso-ciru-hostinger-1.0.zip`

## 📦 Contenido del paquete

- WordPress core (última versión)
- Tema Astra (parent)
- Tema astra-ciru-child (tema del congreso)
- **Auto-setup plugin** (mu-plugin que configura todo automáticamente)

## 📋 Instalación en Hostinger

### Paso 1: Preparar base de datos

En el panel de Hostinger (cPanel):
1. **Bases de datos MySQL** → Crear nueva base de datos
2. Anotar:
   - Nombre de la base de datos: `u123456_congreso`
   - Usuario: `u123456_wpuser`
   - Contraseña: (la que elijas)
   - Host: `localhost`

### Paso 2: Subir archivos

**Opción A — File Manager (más fácil):**
1. File Manager → `public_html/`
2. Upload → seleccionar `congreso-ciru-hostinger-1.0.zip`
3. Clic derecho → Extract
4. Mover el contenido de `wordpress/` a `public_html/`

**Opción B — FTP:**
1. Conectar por FTP (credenciales en Hostinger)
2. Subir el contenido del zip extraído a `public_html/`

### Paso 3: Instalar WordPress

1. Navegar a tu dominio: `https://tudominio.com`
2. WordPress te redirige al instalador
3. Completar los datos de la base de datos (del Paso 1)
4. Crear usuario administrador
5. Clic en **Instalar WordPress**

### Paso 4: Auto-configuración (automático)

Al hacer login en `wp-admin` por primera vez, el sistema **automáticamente**:

- ✅ Activa el tema `astra-ciru-child`
- ✅ Crea las páginas:
  - Inicio (front page)
  - Postulaciones
  - Inscripciones
- ✅ Configura la página de inicio estática
- ✅ Configura permalinks a `/%postname%/`

Verás un mensaje verde confirmando que todo se configuró.

## 🎨 Personalización post-instalación

### Imágenes del hero

Las 3 imágenes del hero slider deben subirse manualmente:

1. **Media** → Subir archivos:
   - `hero-cirugia.jpg` (cirujanos en quirófano)
   - `hero-enfermeria.jpg` (enfermeras)
   - `hero-instrumentacion.jpg` (instrumentos quirúrgicos)

2. Colocarlas en: `wp-content/themes/astra-ciru-child/assets/images/`

### Plugins recomendados

Instalar vía wp-admin → Plugins → Añadir nuevo:

- **WP Mail SMTP** — para el envío de emails del formulario de contacto
  - Configurar con Elastic Mail: `smtp.elasticemail.com:2525`
- **Contact Form 7** (opcional, si se prefiere a Ajax nativo)
- **Yoast SEO** — para SEO

### Configuración final

- **Ajustes → Enlaces permanentes** → ya configurados automáticamente
- **Apariencia → Personalizar** → configurar logo, colores adicionales si es necesario
- **Ajustes → Generales** → verificar título del sitio y zona horaria

## 🔧 Solución de problemas

### El auto-setup no se ejecutó

Si por alguna razón el auto-setup no corrió:

1. **Plugins** → asegurarse que `congreso-auto-setup.php` existe en `wp-content/mu-plugins/`
2. **PHPMyAdmin** → tabla `wp_options` → buscar y **borrar** la fila `congreso_auto_setup_done`
3. Refrescar wp-admin → el setup se ejecutará nuevamente

### Permalinks no funcionan (404 en páginas)

1. Verificar que `.htaccess` existe en la raíz
2. **Ajustes → Enlaces permanentes** → Guardar cambios (regenera .htaccess)
3. Verificar permisos del archivo (644)

### El tema no se ve bien

1. Verificar que el tema child está **activado**: Apariencia → Temas
2. Limpiar caché del navegador (Ctrl+Shift+R)
3. Si Hostinger tiene cache, limpiarlo desde el panel

## 📞 Soporte

- Email: admin@congreso.org.uy
- Hosting: soporte de Hostinger (si problemas de servidor)
