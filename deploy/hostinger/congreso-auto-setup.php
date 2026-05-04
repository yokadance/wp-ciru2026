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

	// ── 4. PERMALINKS ─────────────────────────────────────────────────
	update_option( 'permalink_structure', '/%postname%/' );
	flush_rewrite_rules();

	// ── 5. MARCAR COMO COMPLETADO ────────────────────────────────────
	update_option( 'congreso_auto_setup_done', true );

	// Mensaje admin
	add_action( 'admin_notices', function() {
		echo '<div class="notice notice-success is-dismissible">';
		echo '<p><strong>✅ Congreso Auto-Setup completado:</strong> Tema activado, páginas creadas, front page configurada.</p>';
		echo '</div>';
	} );
}
