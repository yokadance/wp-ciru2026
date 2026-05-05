<?php
/**
 * Template Name: Inscripciones
 *
 * Página dedicada al proceso de inscripción con los tres esquemas.
 * En WordPress Admin → Páginas → asignar este template a la página "Inscripciones".
 *
 * EDITAR: Actualice los precios y fechas de inscripción anticipada.
 */
defined( 'ABSPATH' ) || exit;
get_header();
?>

<style>
/* ESTILOS INLINE - NO DEPENDEN DE CACHE */
#congreso-page-inscripciones {
  width: 100vw !important;
  max-width: 100vw !important;
  margin: 0 !important;
  padding: 0 !important;
  overflow-x: hidden !important;
}
#congreso-page-inscripciones > * {
  width: 100% !important;
  max-width: 100vw !important;
}
/* GRIDS CON ANCHO FIJO */
.ciru-precios__panel {
  max-width: 1280px !important;
  margin: 0 auto !important;
}
.ciru-precios__grid {
  max-width: 1280px !important;
  margin: 0 auto !important;
}
.ciru-precios__grid--3 {
  display: grid !important;
  grid-template-columns: repeat(3, 1fr) !important;
  gap: 2rem !important;
}
.ciru-precios__grid--2 {
  display: grid !important;
  grid-template-columns: 1fr 1fr 1fr !important;
  gap: 2rem !important;
}
.ciru-precios__grid--2 .ciru-price-card:nth-child(1) {
  grid-column: 1 / 2 !important;
}
.ciru-precios__grid--2 .ciru-price-card:nth-child(2) {
  grid-column: 2 / 3 !important;
}
/* HEADER IGUAL QUE HOME */
.site-header .ast-container {
  max-width: 1280px !important;
  padding-left: 2rem !important;
  padding-right: 2rem !important;
}
</style>

</div><!-- /ast-container — cerrado para full-width -->
</div><!-- /#content — cerrado para full-width -->

<main id="congreso-page-inscripciones" role="main">

	<!-- Hero de página -->
	<div style="background:linear-gradient(135deg,#1A2E4A 0%,#3C619C 100%);padding:60px 0;color:#fff;">
		<div class="ciru-container" style="text-align:center;">
			<span class="ciru-eyebrow" style="color:#49BEAA;">76º Congreso Uruguayo de Cirugía</span>
			<h1 style="font-family:'Playfair Display',Georgia,serif;font-size:clamp(2rem,4vw,3rem);color:#fff;margin:8px 0 14px;">
				Inscripciones
			</h1>
			<p style="color:rgba(255,255,255,.7);max-width:580px;margin:0 auto;font-size:1rem;line-height:1.7;">
				Seleccioná tu modalidad de inscripción para el congreso o jornada correspondiente.
			</p>
		</div>
	</div>

	<!-- Reutiliza el módulo de precios -->
	<?php get_template_part( 'template-parts/congreso/precios' ); ?>

	<!-- Formulario de contacto para completar inscripción -->
	<div class="ciru-section" style="background:#F5F4E0;">
		<div class="ciru-container" style="text-align:center;max-width:680px;">
			<span class="ciru-eyebrow">¿Dudas sobre la inscripción?</span>
			<h2 class="ciru-section-title" style="margin-bottom:8px;">Contactanos</h2>
			<p style="font-size:.95rem;color:#5F6075;margin-bottom:28px;line-height:1.7;">
				Para completar tu inscripción o ante cualquier consulta sobre aranceles,
				facturación o modalidades de pago, escribinos.
			</p>
			<a href="<?php echo esc_url( home_url( '/#contacto' ) ); ?>" class="ciru-btn ciru-btn--primary">
				Ir al formulario de contacto
			</a>
		</div>
	</div>

</main>

<script>
// FORZAR LAYOUT CORRECTO - EJECUTA INMEDIATAMENTE
(function() {
  function forceLayout() {
    // Forzar todos los grids al mismo ancho
    const grids = document.querySelectorAll('.ciru-precios__grid');
    grids.forEach(grid => {
      grid.style.maxWidth = '1280px';
      grid.style.margin = '0 auto';
    });

    // Grid de 2 columnas usa 3 columnas para mantener ancho
    const grid2 = document.querySelectorAll('.ciru-precios__grid--2');
    grid2.forEach(g => {
      g.style.gridTemplateColumns = '1fr 1fr 1fr';
    });
  }

  // Ejecutar al cargar
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', forceLayout);
  } else {
    forceLayout();
  }

  // Ejecutar después de cada cambio de tab
  document.addEventListener('click', function(e) {
    if (e.target.classList.contains('ciru-precios__tab')) {
      setTimeout(forceLayout, 100);
    }
  });
})();
</script>

<?php
// Dos <div> vacíos para balancear los que footer.php cierra:
//   </div><!-- ast-container -->
//   </div><!-- #content -->
?>
<div hidden><div hidden>

<?php get_footer(); ?>
