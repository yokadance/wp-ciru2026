<?php
/**
 * Plugin Name: Congreso Auto-Setup
 * Description: Configura automáticamente el sitio al primer acceso admin (crea páginas, activa tema, etc.). Se desactiva solo después de ejecutar.
 * Version: 1.0
 * Author: Congreso Cirugía 2026
 */

// Must-use plugin: se ejecuta automáticamente
add_action( 'admin_init', 'congreso_auto_setup_run' );

function congreso_auto_setup_run() {
	// Solo ejecutar UNA vez
	if ( get_option( 'congreso_auto_setup_done' ) ) {
		return;
	}

	// Solo en wp-admin y si el usuario es admin
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// ── 1. ACTIVAR CHILD THEME ──────────────────────────────────────
	if ( wp_get_theme()->get_template() !== 'astra' ) {
		switch_theme( 'astra-ciru-child' );
	}

	// ── 2. CREAR PÁGINAS ─────────────────────────────────────────────
	$pages = [
		[
			'title'    => 'Inicio',
			'slug'     => 'inicio',
			'template' => '',  // usa front-page.php automáticamente
		],
		[
			'title'    => 'Postulaciones',
			'slug'     => 'postulaciones',
			'template' => 'page-postulaciones.php',
		],
		[
			'title'    => 'Inscripciones',
			'slug'     => 'inscripciones',
			'template' => 'page-inscripciones.php',
		],
	];

	$home_id = 0;
	foreach ( $pages as $p ) {
		// Verificar si ya existe
		$existing = get_page_by_path( $p['slug'] );
		if ( $existing ) {
			if ( $p['slug'] === 'inicio' ) {
				$home_id = $existing->ID;
			}
			continue;
		}

		$page_id = wp_insert_post( [
			'post_title'   => $p['title'],
			'post_name'    => $p['slug'],
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => '',
		] );

		if ( $page_id && ! empty( $p['template'] ) ) {
			update_post_meta( $page_id, '_wp_page_template', $p['template'] );
		}

		if ( $p['slug'] === 'inicio' ) {
			$home_id = $page_id;
		}
	}

	// ── 3. CONFIGURAR FRONT PAGE ESTÁTICA ────────────────────────────
	if ( $home_id ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home_id );
	}

	// ── 4. CREAR MENÚ DE NAVEGACIÓN ──────────────────────────────────
	$menu_name = 'Menú Principal';
	$menu_id = wp_create_nav_menu( $menu_name );

	if ( ! is_wp_error( $menu_id ) ) {
		// Agregar páginas al menú en orden
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

		// Asignar menú a la ubicación del tema (Astra usa 'primary')
		$locations = get_theme_mod( 'nav_menu_locations' );
		$locations['primary'] = $menu_id;
		set_theme_mod( 'nav_menu_locations', $locations );
	}

	// ── 5. PERMALINKS ─────────────────────────────────────────────────
	update_option( 'permalink_structure', '/%postname%/' );
	flush_rewrite_rules();

	// ── 6. MARCAR COMO COMPLETADO ────────────────────────────────────
	update_option( 'congreso_auto_setup_done', true );

	// Mensaje admin
	add_action( 'admin_notices', function() {
		echo '<div class="notice notice-success is-dismissible">';
		echo '<p><strong>✅ Congreso Auto-Setup completado:</strong> Tema activado, páginas creadas, front page configurada.</p>';
		echo '</div>';
	} );
}
