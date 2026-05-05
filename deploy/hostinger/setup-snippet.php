<?php
/**
 * Snippet para Code Snippets plugin
 * IMPORTANTE: Configurar como "Run snippet everywhere" (no "Run once")
 * El snippet se auto-desactiva después de ejecutar
 */

add_action( 'admin_init', 'congreso_setup_pages_and_menu' );

function congreso_setup_pages_and_menu() {
	// Solo ejecutar UNA vez
	if ( get_option( 'congreso_setup_done' ) ) {
		return;
	}

	// Solo si es admin
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// ── 1. CREAR PÁGINAS ──────────────────────────────────────────────
	$pages = [
		[ 'title' => 'Inicio',         'slug' => 'inicio',         'template' => '' ],
		[ 'title' => 'Postulaciones',  'slug' => 'postulaciones',  'template' => 'page-postulaciones.php' ],
		[ 'title' => 'Inscripciones',  'slug' => 'inscripciones',  'template' => 'page-inscripciones.php' ],
	];

	$home_id = 0;
	foreach ( $pages as $p ) {
		$existing = get_page_by_path( $p['slug'] );
		if ( $existing ) {
			if ( $p['slug'] === 'inicio' ) {
				$home_id = $existing->ID;
			}
			continue;
		}

		$page_id = wp_insert_post([
			'post_title'   => $p['title'],
			'post_name'    => $p['slug'],
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => '',
		]);

		if ( $page_id && ! is_wp_error( $page_id ) ) {
			if ( ! empty( $p['template'] ) ) {
				update_post_meta( $page_id, '_wp_page_template', $p['template'] );
			}

			if ( $p['slug'] === 'inicio' ) {
				$home_id = $page_id;
			}
		}
	}

	// ── 2. CONFIGURAR HOMEPAGE ────────────────────────────────────────
	if ( $home_id ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home_id );
	}

	// ── 3. CREAR MENÚ DE NAVEGACIÓN ───────────────────────────────────
	$menu_name = 'Menú Principal';

	// Verificar si el menú ya existe
	$menu_exists = wp_get_nav_menu_object( $menu_name );

	if ( ! $menu_exists ) {
		$menu_id = wp_create_nav_menu( $menu_name );

		if ( ! is_wp_error( $menu_id ) ) {
			// Agregar páginas al menú
			$menu_items = [
				[ 'title' => 'Inicio', 'slug' => 'inicio' ],
				[ 'title' => 'Postulaciones', 'slug' => 'postulaciones' ],
				[ 'title' => 'Inscripciones', 'slug' => 'inscripciones' ],
			];

			$menu_order = 1;
			foreach ( $menu_items as $item ) {
				$page = get_page_by_path( $item['slug'] );
				if ( $page ) {
					wp_update_nav_menu_item( $menu_id, 0, [
						'menu-item-title'     => $item['title'],
						'menu-item-object-id' => $page->ID,
						'menu-item-object'    => 'page',
						'menu-item-type'      => 'post_type',
						'menu-item-status'    => 'publish',
						'menu-item-position'  => $menu_order++,
					] );
				}
			}

			// Asignar menú a ubicación principal de Astra
			$locations = get_theme_mod( 'nav_menu_locations' );
			if ( ! is_array( $locations ) ) {
				$locations = [];
			}
			$locations['primary'] = $menu_id;
			set_theme_mod( 'nav_menu_locations', $locations );
		}
	}

	// ── 4. CONFIGURAR PERMALINKS ──────────────────────────────────────
	update_option( 'permalink_structure', '/%postname%/' );
	flush_rewrite_rules();

	// ── 5. MARCAR COMO COMPLETADO ────────────────────────────────────
	update_option( 'congreso_setup_done', true );

	// Mostrar mensaje de éxito
	add_action( 'admin_notices', function() {
		echo '<div class="notice notice-success is-dismissible">';
		echo '<p><strong>✅ Setup completado:</strong> Páginas creadas, menú configurado.</p>';
		echo '<p>Podés desactivar este snippet ahora.</p>';
		echo '</div>';
	});
}
