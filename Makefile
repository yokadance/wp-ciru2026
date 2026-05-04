# =====================================================
# Makefile — 76º Congreso Uruguayo de Cirugía 2026
# Uso: make <comando>
# =====================================================

include .env
export

COMPOSE = docker compose
WP_CLI  = $(COMPOSE) --profile cli run --rm wpcli wp --allow-root

# ── Ciclo de vida ──────────────────────────────────
.PHONY: up down restart logs ps

## Iniciar todos los servicios
up:
	$(COMPOSE) up -d
	@echo ""
	@echo "  WordPress  →  http://localhost:$(WP_PORT)"
	@echo "  phpMyAdmin →  http://localhost:$(PMA_PORT)"
	@echo ""
	@echo "  Si es la primera vez, espere ~30s y ejecute: make setup"

## Detener todos los servicios
down:
	$(COMPOSE) down

## Reiniciar
restart:
	$(COMPOSE) restart

## Parchear wp-config.php para URL dinámica (funciona con localhost y DDNS)
fix-urls:
	@docker cp docker/fix-wp-urls.php congreso_wp:/tmp/fix-wp-urls.php
	@docker exec congreso_wp php /tmp/fix-wp-urls.php
	@docker exec congreso_wp rm /tmp/fix-wp-urls.php

## Ver logs en tiempo real
logs:
	$(COMPOSE) logs -f wordpress

## Estado de los contenedores
ps:
	$(COMPOSE) ps

# ── Setup inicial de WordPress ─────────────────────
.PHONY: setup

## Instalar WP, activar child theme y crear páginas base
setup:
	@echo "⏳ Esperando a que WordPress esté listo..."
	@sleep 10
	@echo "🔧 Instalando WordPress..."
	$(WP_CLI) core install \
		--url="$(WP_URL)" \
		--title="$(WP_TITLE)" \
		--admin_user="$(WP_ADMIN_USER)" \
		--admin_password="$(WP_ADMIN_PASSWORD)" \
		--admin_email="$(WP_ADMIN_EMAIL)" \
		--skip-email
	@echo "🎨 Activando child theme..."
	$(WP_CLI) theme activate astra-ciru-child
	@echo "📄 Creando páginas base..."
	$(WP_CLI) post create \
		--post_type=page \
		--post_title="Inicio" \
		--post_status=publish \
		--post_name=inicio
	$(WP_CLI) post create \
		--post_type=page \
		--post_title="Postulaciones" \
		--post_status=publish \
		--post_name=postulaciones \
		--page_template=page-postulaciones.php
	$(WP_CLI) post create \
		--post_type=page \
		--post_title="Inscripciones" \
		--post_status=publish \
		--post_name=inscripciones \
		--page_template=page-inscripciones.php
	@echo "⚙️  Configurando front page estática..."
	$(WP_CLI) option update show_on_front page
	$(WP_CLI) option update page_on_front \
		$$($(WP_CLI) post list --post_type=page --name=inicio --field=ID --format=ids)
	@echo "🔗 Configurando permalinks..."
	$(WP_CLI) rewrite structure '/%postname%/' --hard
	@echo ""
	@echo "✅ Setup completo."
	@echo "   Admin  →  $(WP_URL)/wp-admin"
	@echo "   User:  $(WP_ADMIN_USER)"
	@echo "   Pass:  $(WP_ADMIN_PASSWORD)"

# ── WP-CLI genérico ────────────────────────────────
.PHONY: wp

## Ejecutar cualquier comando WP-CLI: make wp cmd="plugin list"
wp:
	$(WP_CLI) $(cmd)

# ── Plugins útiles ─────────────────────────────────
.PHONY: plugins

## Instalar plugins recomendados para el congreso
plugins:
	@echo "📦 Instalando plugins..."
	# Email — WP Mail SMTP enruta wp_mail() a Elastic Mail via SMTP/API
	$(WP_CLI) plugin install wp-mail-smtp --activate
	$(WP_CLI) plugin install contact-form-7 --activate
	$(WP_CLI) plugin install classic-editor --activate
	$(WP_CLI) plugin install wordpress-seo --activate
	@echo ""
	@echo "✅ Plugins instalados."
	@echo ""
	@echo "  ⚙️  Configurar Elastic Mail en WP Mail SMTP:"
	@echo "     Admin → WP Mail SMTP → Settings → Mailer → Other SMTP"
	@echo "     Host: smtp.elasticemail.com  Port: 2525  Auth: LOGIN"
	@echo "     User: tu-email@dominio.com"
	@echo "     Pass: API Key de Elastic Mail (cuenta → Settings → SMTP)"

# ── Base de datos ──────────────────────────────────
.PHONY: db-export db-import

## Exportar base de datos: make db-export
db-export:
	$(COMPOSE) exec db mysqldump \
		-u $(DB_USER) -p$(DB_PASSWORD) $(DB_NAME) \
		> backup_$$(date +%Y%m%d_%H%M%S).sql
	@echo "✅ Backup guardado."

## Importar base de datos: make db-import FILE=backup.sql
db-import:
	$(COMPOSE) exec -T db mysql \
		-u $(DB_USER) -p$(DB_PASSWORD) $(DB_NAME) \
		< $(FILE)
	@echo "✅ Base de datos importada."

# ── Fly.io ────────────────────────────────────────
.PHONY: fly-db-create fly-wp-create fly-deploy fly-logs fly-ssh

## Crear app DB en Fly.io (solo la primera vez)
fly-db-create:
	fly apps create congreso-ciru-db
	fly volumes create db_data --app congreso-ciru-db --size 3 --region eze
	@echo "Configurar contraseñas:"
	@echo "  fly secrets set MYSQL_ROOT_PASSWORD=<pass> MYSQL_PASSWORD=<pass> --app congreso-ciru-db"
	fly deploy --config fly.db.toml --app congreso-ciru-db

## Crear app WordPress en Fly.io (solo la primera vez)
fly-wp-create:
	fly apps create congreso-ciru
	fly volumes create wp_content --app congreso-ciru --size 5 --region eze
	@echo "Configurar secrets:"
	@echo "  fly secrets set WORDPRESS_DB_PASSWORD=<pass> --app congreso-ciru"
	fly deploy --config fly.toml --app congreso-ciru

## Re-deployar WordPress (después de cambios en el tema)
fly-deploy:
	fly deploy --config fly.toml

## Ver logs de producción en tiempo real
fly-logs:
	fly logs --app congreso-ciru

## SSH al contenedor de producción
fly-ssh:
	fly ssh console --app congreso-ciru

# ── Hostinger ──────────────────────────────────────
.PHONY: hostinger-package

## Crear paquete auto-instalable para Hostinger (WordPress + temas + auto-setup)
hostinger-package:
	bash deploy/hostinger/build.sh

## Crear zip SOLO del child theme (para subir a un WP existente)
hostinger-theme:
	@rm -f astra-ciru-child.zip
	@zip -qr astra-ciru-child.zip astra-ciru-child/ -x "*.DS_Store"
	@echo "✅ astra-ciru-child.zip creado ($(shell ls -lh astra-ciru-child.zip | awk '{print $$5}'))"
	@echo "   Subir en: wp-admin → Apariencia → Temas → Añadir nuevo → Subir tema"

# ── Limpieza ───────────────────────────────────────
.PHONY: clean nuke

## Detener contenedores y eliminar volúmenes (¡borra la DB!)
clean:
	$(COMPOSE) down -v

## Limpieza total: contenedores + volúmenes + imágenes descargadas
nuke:
	$(COMPOSE) down -v --rmi local
	@echo "💥 Todo eliminado."
