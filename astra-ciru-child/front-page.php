<?php
/**
 * Front Page — 76º Congreso Uruguayo de Cirugía 2026
 *
 * Estructura modular: cada sección es un archivo independiente
 * en template-parts/congreso/ — edite allí el contenido.
 *
 * GESTIÓN DE SECCIONES: wp-admin → Apariencia → Secciones del Home
 * Desde allí se activan/desactivan y reordenan las secciones.
 *
 * NOTA TÉCNICA: header.php abre <div id="content"><div class="ast-container">
 * Los cerramos inmediatamente para lograr layout full-width real.
 * Los dos <div hidden> del final balancean las etiquetas de footer.php.
 */
defined( 'ABSPATH' ) || exit;

get_header();
?>

</div><!-- /ast-container — cerrado para full-width -->
</div><!-- /#content — cerrado para full-width -->

<main id="congreso-main" role="main">

	<?php
	// Mapa de secciones: ID => archivo template
	$secciones_map = [
		'hero'              => 'hero',
		'countdown'         => 'countdown',
		'bienvenida'        => 'bienvenida',
		'timeline'          => 'timeline',
		'video-destacado'   => 'video-destacado',
		'precios'           => 'precios',
		'trabajos-libres'   => 'trabajos-libres',
		'comites'           => 'comites',
		'hoteleria'         => 'hoteleria',
		'autoridades'       => 'autoridades',
		'ubicacion'         => 'ubicacion',
		'contacto'          => 'contacto',
	];

	// Obtener orden configurado de secciones
	$orden = congreso_get_secciones_orden();

	// Renderizar secciones en el orden configurado
	foreach ( $orden as $seccion_id ) {
		// Verificar si la sección existe y está activa
		if ( ! isset( $secciones_map[ $seccion_id ] ) ) {
			continue;
		}

		if ( ! congreso_seccion_activa( $seccion_id ) ) {
			continue;
		}

		// Renderizar la sección
		$template = $secciones_map[ $seccion_id ];
		get_template_part( 'template-parts/congreso/' . $template );
	}
	?>

</main>

<?php
// Footer del congreso
get_template_part( 'template-parts/congreso/footer-congreso' );
?>

<?php
// Dos <div> vacíos para balancear los que footer.php cierra:
//   </div><!-- ast-container -->
//   </div><!-- #content -->
?>
<div hidden><div hidden>

<?php get_footer(); ?>
