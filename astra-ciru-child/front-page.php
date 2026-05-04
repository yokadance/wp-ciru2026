<?php
/**
 * Front Page — 76º Congreso Uruguayo de Cirugía 2026
 *
 * Estructura modular: cada sección es un archivo independiente
 * en template-parts/congreso/ — edite allí el contenido.
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
	// ── 1. HERO SLIDER ──────────────────────────────────
	get_template_part( 'template-parts/congreso/hero' );

	// ── 2. AUTORIDADES ──────────────────────────────────
	get_template_part( 'template-parts/congreso/autoridades' );

	// ── 3. BIENVENIDA ───────────────────────────────────
	get_template_part( 'template-parts/congreso/bienvenida' );

	// ── 4. CUENTA REGRESIVA ─────────────────────────────
	get_template_part( 'template-parts/congreso/countdown' );

	// ── 5. PRECIOS / INSCRIPCIONES ──────────────────────
	get_template_part( 'template-parts/congreso/precios' );

	// ── 6. POSTULACIONES ────────────────────────────────
	get_template_part( 'template-parts/congreso/postulaciones' );

	// ── 7. UBICACIÓN / MAPA ─────────────────────────────
	get_template_part( 'template-parts/congreso/ubicacion' );

	// ── 8. FORMULARIO DE CONTACTO ───────────────────────
	get_template_part( 'template-parts/congreso/contacto' );
	?>

</main>

<?php
// Dos <div> vacíos para balancear los que footer.php cierra:
//   </div><!-- ast-container -->
//   </div><!-- #content -->
?>
<div hidden><div hidden>

<?php get_footer(); ?>
