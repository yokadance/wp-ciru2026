# 76º Congreso Uruguayo de Cirugía 2026

Child theme de WordPress basado en Astra — diseño modular, full-width, Material Design 3.

---

## 🚀 Inicio rápido (desarrollo local)

```bash
# 1. Configurar entorno
cp .env.example .env
# Editar .env con tus valores

# 2. Levantar Docker
make up

# 3. Setup inicial de WordPress (solo primera vez)
make setup

# 4. Abrir en navegador
open http://localhost:8080
```

**Admin:** http://localhost:8080/wp-admin  
User/Pass: ver `.env` (`WP_ADMIN_USER` / `WP_ADMIN_PASSWORD`)

---

## 📦 Deploy a producción

### Opción 1: Hostinger (WordPress existente)

```bash
# Crear zip del child theme
make hostinger-theme

# Subir en wp-admin → Apariencia → Temas → Subir tema
# Ver: deploy/hostinger/README-SIMPLE.md
```

### Opción 2: Git + CI/CD (automático)

Configurar una vez, luego cada `git push` deploya automáticamente:

```bash
# Setup (ver guía completa)
# deploy/GIT-CICD.md

git push  # ← deploy automático a Hostinger via FTP
```

---

## 📂 Estructura del proyecto

```
astra-ciru/
├── astra-ciru-child/          # ← Child theme (código principal)
│   ├── assets/
│   │   ├── css/congreso.css   # Estilos v3 (MD3)
│   │   ├── js/congreso.js     # Hero slider, countdown, form
│   │   └── images/            # Imágenes del hero
│   ├── template-parts/
│   │   └── congreso/          # Módulos (hero, precios, etc.)
│   ├── front-page.php         # Homepage full-width
│   ├── page-*.php             # Templates de páginas
│   └── functions.php          # Config y helpers
├── deploy/
│   ├── hostinger/             # Scripts para Hostinger
│   └── GIT-CICD.md            # Guía de Git + deploy automático
├── docker-compose.yml         # WordPress + MariaDB local
├── Makefile                   # Comandos útiles (make up, make setup, etc.)
└── .github/workflows/         # GitHub Actions (CI/CD)
```

---

## 🛠️ Comandos útiles

| Comando | Descripción |
|---------|-------------|
| `make up` | Levantar Docker (WordPress + DB) |
| `make down` | Detener contenedores |
| `make restart` | Reiniciar servicios |
| `make logs` | Ver logs de WordPress |
| `make setup` | Setup inicial (temas, páginas, config) |
| `make plugins` | Instalar plugins recomendados |
| `make fix-urls` | Fix para URL dinámica (localhost + DDNS) |
| `make hostinger-theme` | Crear zip del child theme para Hostinger |
| `make hostinger-package` | Crear paquete completo (WP + tema) |

---

## 🎨 Desarrollo del tema

### Editar CSS/JS

```bash
# Editar
code astra-ciru-child/assets/css/congreso.css

# Ver cambios en vivo
open http://localhost:8080
# (Ctrl+Shift+R para hard refresh)
```

### Estructura de módulos

Cada sección del home es un template-part independiente en `template-parts/congreso/`:

- `hero.php` — Slider 3 eventos
- `countdown.php` — Cuenta regresiva
- `bienvenida.php` — Mensaje presidente
- `autoridades.php` — Presidentes de cada evento
- `precios.php` — Inscripciones (3 tabs con pill-style)
- `postulaciones.php` — Postulación trabajos (bento grid)
- `ubicacion.php` — Mapa OpenStreetMap
- `contacto.php` — Formulario AJAX

---

## 🌐 Deploy modes

| Modo | Cuándo usar | Setup |
|------|-------------|-------|
| **Local** | Desarrollo | `make up` |
| **Hostinger** | Producción (shared hosting) | `deploy/hostinger/README-SIMPLE.md` |
| **Git + CI/CD** | Workflow profesional | `deploy/GIT-CICD.md` |

---

## 📝 Configuración

### Imágenes del hero

Subir 3 fotos a: `astra-ciru-child/assets/images/`
- `hero-cirugia.jpg`
- `hero-enfermeria.jpg`
- `hero-instrumentacion.jpg`

### Email (formulario de contacto)

Plugin: **WP Mail SMTP**  
SMTP: Elastic Mail (`smtp.elasticemail.com:2525`)  
Config: wp-admin → WP Mail SMTP

### Cuenta regresiva

Editar en `functions.php` línea 31:
```php
'targetDate' => '2026-09-15T00:00:00',  // Fecha del congreso
```

---

## 🔧 Troubleshooting

**Contenedores no levantan:**
```bash
make down
make up
```

**Error 500 al acceder:**
```bash
make logs  # Ver el error exacto
```

**Layout no es full-width:**
- Verificar que el tema child está activado
- Forzar recarga: Ctrl+Shift+R
- Limpiar cache de Hostinger si aplica

**Redirects a localhost (en producción):**
- Verificar que el fix de URL dinámica está aplicado
- En Hostinger: `wp-config.php` debe tener las constantes `WP_HOME`/`WP_SITEURL` dinámicas

---

## 📚 Docs

- [Deploy Hostinger (simple)](deploy/hostinger/README-SIMPLE.md)
- [Deploy Hostinger (paquete completo)](deploy/hostinger/README.md)
- [Git + CI/CD](deploy/GIT-CICD.md)

---

## 🤝 Contribuir

1. Fork del repo
2. Branch para tu feature: `git checkout -b feature/nueva-seccion`
3. Commit: `git commit -m "Add: nueva sección X"`
4. Push: `git push origin feature/nueva-seccion`
5. Pull Request

---

## 📧 Soporte

- **Desarrollo:** admin@congreso.org.uy
- **Hosting (Hostinger):** Soporte de Hostinger
- **GitHub Issues:** Para bugs/features
