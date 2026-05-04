# Git + CI/CD — Deploy automático a Hostinger

Al hacer `git push`, el tema se sube automáticamente a Hostinger vía FTP.

---

## 🚀 Setup inicial de Git

### 1. Inicializar repositorio (si no existe)

```bash
git init
git add .
git commit -m "Initial commit: 76º Congreso Uruguayo de Cirugía 2026"
```

### 2. Crear repo en GitHub

1. Ir a [github.com/new](https://github.com/new)
2. Nombre: `congreso-ciru-2026` (o el que prefieras)
3. **Privado** (contiene configuración del sitio)
4. No inicializar con README (ya tenés el proyecto local)

### 3. Conectar y pushear

```bash
git remote add origin https://github.com/TU-USUARIO/congreso-ciru-2026.git
git branch -M main
git push -u origin main
```

---

## ⚙️ Configurar CI/CD (GitHub → Hostinger)

### Paso 1 — Obtener credenciales FTP de Hostinger

Panel de Hostinger → **File Manager** → **FTP Accounts**

Anotar:
- **Server:** `ftp.tudominio.com` (o la IP del server)
- **Username:** `u123456789` (tu usuario FTP)
- **Password:** (tu contraseña FTP)

### Paso 2 — Agregar secrets en GitHub

1. GitHub repo → **Settings** → **Secrets and variables** → **Actions**
2. **New repository secret** (crear 3 secrets):
   - Name: `FTP_SERVER` → Value: `ftp.tudominio.com`
   - Name: `FTP_USERNAME` → Value: `u123456789`
   - Name: `FTP_PASSWORD` → Value: `tu-contraseña-ftp`

### Paso 3 — Listo!

✅ Cada `git push` a `main` dispara deploy automático  
✅ Solo sube archivos del child theme (`astra-ciru-child/`)  
✅ Ver progreso en: repo → **Actions** tab

---

## 📋 Flujo de trabajo diario

### 1. Editar tema localmente

```bash
# Editar archivos
code astra-ciru-child/assets/css/congreso.css

# Probar en local
make up
open http://localhost:8080
```

### 2. Commit y push

```bash
git add astra-ciru-child/
git commit -m "Update: mejorar espaciado en sección hero"
git push
```

→ **GitHub Actions hace deploy automático a Hostinger** 🚀

### 3. Ver logs del deploy

- GitHub repo → **Actions** tab
- Clic en el último workflow run
- Ver cada paso del deploy

---

## 🎯 Deploy manual (sin push)

Si querés deployar sin hacer commit/push:

GitHub repo → **Actions** → **Deploy to Hostinger** → **Run workflow**

---

## 🌿 Branches y ambientes

Estrategia recomendada:

- **`main`** → Producción (Hostinger)
- **`develop`** → Staging/testing

Para agregar ambiente de staging, duplicar `.github/workflows/deploy-hostinger.yml` y cambiar:

```yaml
on:
  push:
    branches: [ develop ]  # ← cambiar a develop
  
steps:
  - name: Deploy via FTP
    with:
      server-dir: /public_html/staging/wp-content/themes/astra-ciru-child/  # ← path staging
```

---

## 🔐 Secrets necesarios

| Secret | Valor | Dónde obtenerlo |
|--------|-------|----------------|
| `FTP_SERVER` | `ftp.tudominio.com` | Panel Hostinger → FTP Accounts |
| `FTP_USERNAME` | `u123456789` | Panel Hostinger → FTP Accounts |
| `FTP_PASSWORD` | `********` | Panel Hostinger → FTP Accounts |

---

## 🛠️ Troubleshooting

### "FTP connection failed"
- Verificar que los secrets NO tienen espacios extra al inicio/final
- Algunos hostings bloquean conexiones FTP desde IPs de GitHub → contactar soporte de Hostinger
- Probar FTP manualmente con FileZilla para confirmar credenciales

### "Workflow not triggering"
- Verificar que `.github/workflows/deploy-hostinger.yml` existe
- El push debe ser a branch `main` (o la configurada en `on.push.branches`)
- Ver tab **Actions** en GitHub → si aparece deshabilitado, habilitarlo

### "Files not updating on Hostinger"
- GitHub Actions sube solo archivos **modificados** (incremental)
- Para forzar subir todo: borrar la carpeta del tema en Hostinger y pushear
- Ver logs del workflow para confirmar qué archivos se subieron

---

## ⚡ Mejoras futuras

Ideas para extender el CI/CD:

- **Notifications:** Enviar mensaje a Slack/Discord cuando termina el deploy
- **Linting:** Validar CSS/PHP antes de deployar (`npm run lint`)
- **Rollback:** Script para volver a la versión anterior si algo falla
- **Preview:** Deploy automático de PRs a un subdominio staging

---

## 📚 Recursos

- [GitHub Actions Docs](https://docs.github.com/en/actions)
- [FTP Deploy Action](https://github.com/SamKirkland/FTP-Deploy-Action)
- [Hostinger FTP Setup](https://support.hostinger.com/en/articles/1583245-how-to-upload-files-using-ftp)
