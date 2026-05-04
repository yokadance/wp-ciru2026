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
$quote_text = '«La cirugía es ciencia, humanismo y excelencia en cada acto.»'; // EDITAR
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

				<span class="ciru-eyebrow">Bienvenidos</span>
				<h2 class="ciru-section-title">Mensaje de Bienvenida</h2>

				<!-- EDITAR: texto del mensaje de bienvenida -->
				<p>Es un honor darles la bienvenida al <strong>76º Congreso Uruguayo de Cirugía</strong>, un espacio de encuentro científico, debate académico y actualización profesional de primer nivel.</p>

				<p>En esta edición el congreso se celebra de forma simultánea junto a las <strong>XXXV Jornadas Integradas de Enfermería Quirúrgica</strong>, las <strong>XXXI Jornadas Integradas de Instrumentación Quirúrgica</strong> y las <strong>XXXVI Jornadas de Residentes de Cirugía</strong>, reafirmando el compromiso del equipo quirúrgico como unidad.</p>

				<p>Bajo el lema <em>«Ciencia, Humanismo y Excelencia»</em>, los convocamos a compartir días de aprendizaje, innovación y camaradería profesional en Montevideo.</p>

				<p>Los esperamos.</p>

				<div class="ciru-bienvenida__firma">
					<!-- EDITAR: nombre y cargo reales -->
					Dr. [Nombre Apellido]
					<span>Presidente del Congreso</span>
					<span>76º Congreso Uruguayo de Cirugía 2026</span>
				</div>

			</div>

		</div>
	</div>
</section>
