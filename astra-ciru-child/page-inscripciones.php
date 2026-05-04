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

<div id="congreso-page-inscripciones">

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

</div>

<?php get_footer(); ?>
