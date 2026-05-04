# Deploy rápido a WordPress existente

Si ya tenés WordPress + Astra instalados en Hostinger, solo necesitás subir el child theme.

## 📦 Generar el zip del tema

```bash
make hostinger-theme
```

Esto crea: `astra-ciru-child.zip` (776KB)

## 🚀 Subir a Hostinger

### Via wp-admin (recomendado):

1. **Subir tema:**
   - wp-admin → Apariencia → Temas
   - Añadir nuevo → Subir tema
   - Seleccionar `astra-ciru-child.zip`
   - Instalar ahora → Activar

2. **Crear páginas:**
   - Instalar plugin: [Code Snippets](https://wordpress.org/plugins/code-snippets/)
   - Snippets → Add New
   - Copiar el código de `deploy/hostinger/setup-snippet.php`
   - Marcar "Only run once"
   - Save Changes and Activate
   - El snippet crea las 3 páginas y configura el sitio automáticamente

### Via FTP:

1. Conectar por FTP a Hostinger
2. Subir la carpeta `astra-ciru-child/` a `public_html/wp-content/themes/`
3. wp-admin → Apariencia → Temas → Activar "Astra Ciru Child"
4. Usar el snippet (paso 2 de arriba) para crear las páginas

## 🎨 Después de activar

- **Subir imágenes del hero** a: `wp-content/themes/astra-ciru-child/assets/images/`
  - `hero-cirugia.jpg`
  - `hero-enfermeria.jpg`
  - `hero-instrumentacion.jpg`

- **Configurar email** (opcional):
  - Instalar WP Mail SMTP
  - Configurar con Elastic Mail: `smtp.elasticemail.com:2525`

## 🔄 Actualizar el tema

Después de editar el tema localmente:

```bash
make hostinger-theme  # Re-genera el zip
```

Luego en Hostinger:
- Via FTP: reemplazar archivos del tema
- Via wp-admin: borrar tema viejo, subir el nuevo zip

---

**Nota:** El `setup-snippet.php` solo crea páginas. Si ya las creaste manualmente, no necesitás ejecutarlo.
