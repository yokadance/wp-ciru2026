<?php
/**
 * Snippet para Code Snippets plugin
 * Ejecutar UNA VEZ con "Run snippet once" activado
 * Crea las 3 páginas y configura el sitio
 */

// Páginas a crear
$pages = [
	[ 'title' => 'Inicio',         'slug' => 'inicio',         'template' => '' ],
	[ 'title' => 'Postulaciones',  'slug' => 'postulaciones',  'template' => 'page-postulaciones.php' ],
	[ 'title' => 'Inscripciones',  'slug' => 'inscripciones',  'template' => 'page-inscripciones.php' ],
];

$home_id = 0;
foreach ( $pages as $p ) {
	$existing = get_page_by_path( $p['slug'] );
	if ( $existing ) {
		if ( $p['slug'] === 'inicio' ) $home_id = $existing->ID;
		continue;
	}

	$page_id = wp_insert_post([
		'post_title'   => $p['title'],
		'post_name'    => $p['slug'],
		'post_status'  => 'publish',
		'post_type'    => 'page',
	]);

	if ( $page_id && $p['template'] ) {
		update_post_meta( $page_id, '_wp_page_template', $p['template'] );
	}

	if ( $p['slug'] === 'inicio' ) $home_id = $page_id;
}

// Configurar homepage
if ( $home_id ) {
	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $home_id );
}

// Permalinks
update_option( 'permalink_structure', '/%postname%/' );
flush_rewrite_rules();

echo "✅ Páginas creadas y sitio configurado.";
