<?php
/**
 * Módulo: Mensaje de Bienvenida
 *
 * EDITAR:
 *   - foto_id: ID de adjunto de WordPress con la foto del Presidente
 *   - Nombre, cargo, y texto del mensaje debajo
 *   - La cita flotante (ciru-bienvenida__quote) se edita en $quote_text
 */
defined( 'ABSPATH' ) || exit;

$foto_id    = null;   // EDITAR: ID de adjunto WP con la foto del presidente
$quote_text = '«Ciencia, Humanismo y Excelencia»';
?>

<section class="ciru-section ciru-bienvenida" id="bienvenida">
	<div class="ciru-container">
		<div class="ciru-bienvenida__grid">

			<!-- Columna izquierda: foto + quote flotante -->
			<div class="ciru-bienvenida__photo-col">

				<div class="ciru-bienvenida__photo-wrap">
					<?php if ( $foto_id && wp_get_attachment_image( $foto_id, 'large' ) ) : ?>
						<?php echo wp_get_attachment_image( $foto_id, 'large', false, [ 'alt' => 'Presidente del Congreso' ] ); ?>
					<?php else : ?>
						<div class="ciru-bienvenida__photo-placeholder">
							<span class="material-symbols-outlined">person</span>
						</div>
					<?php endif; ?>
				</div>

				<div class="ciru-bienvenida__quote">
					<p><?php echo esc_html( $quote_text ); ?></p>
				</div>

			</div>

			<!-- Columna derecha: texto -->
			<div class="ciru-bienvenida__text">

				<span class="ciru-eyebrow">Estimados Colegas</span>
				<h2 class="ciru-section-title">Mensaje de Bienvenida</h2>

				<p>Es un honor para la Sociedad de Cirugía del Uruguay invitarlos al <strong>76º Congreso Uruguayo de Cirugía</strong>, que se realizará los días <strong>2, 3 y 4 de diciembre de 2026</strong> en The Grand Hotel, Punta del Este, Maldonado.</p>

				<p>Bajo el lema <strong>«Ciencia, Humanismo y Excelencia»</strong>, este congreso reunirá a destacados especialistas nacionales e internacionales para compartir los últimos avances en cirugía, promover el intercambio científico y fortalecer los lazos de la comunidad quirúrgica latinoamericana.</p>

				<p>Además, contaremos con las <strong>XXXV Jornadas Integradas de Enfermería Quirúrgica</strong> y las <strong>XXXI Jornadas Integradas de Instrumentación Quirúrgica (AUIQ)</strong>, realizadas en forma simultánea, lo que enriquecerá aún más el intercambio multidisciplinario.</p>

				<p>El <strong>Precongreso</strong> se llevará a cabo el <strong>1º de diciembre en el Hospital de Clínicas</strong>, con actividades académicas de gran valor formativo.</p>

				<p>Punta del Este nos ofrece un marco incomparable para este encuentro científico, combinando excelencia académica con la calidez de nuestro país.</p>

				<p><strong>¡Los esperamos!</strong></p>

				<div class="ciru-bienvenida__firma">
					Dr. Roberto Valiñas
					<span>Presidente</span>
					<span>Sociedad de Cirugía del Uruguay</span>
				</div>

			</div>

		</div>
	</div>
</section>
