<?php
/**
 * Módulo: Línea de Tiempo
 * Muestra una línea de tiempo horizontal responsive
 * EDITAR: wp-admin → Apariencia → Línea de Tiempo
 */
defined( 'ABSPATH' ) || exit;

// Obtener datos de la línea de tiempo
$timeline_items = get_option( 'congreso_timeline_data', [] );

// Si no hay items, no mostrar nada
if ( empty( $timeline_items ) ) {
	return;
}
?>

<section class="ciru-section ciru-timeline-section" id="cronograma">
	<div class="ciru-container">
		<div class="ciru-timeline__header">
			<span class="ciru-eyebrow">Cronograma</span>
			<h2 class="ciru-section-title">Línea de Tiempo</h2>
			<p style="color:var(--on-surface-variant);font-size:.95rem;max-width:38rem;margin:.75rem auto 0;">
				Conocé las fechas importantes del evento
			</p>
		</div>

		<div class="ciru-timeline">
			<div class="ciru-timeline__track">
				<?php foreach ( $timeline_items as $index => $item ) : ?>
					<div class="ciru-timeline__item <?php echo ! empty( $item['destacado'] ) ? 'is-featured' : ''; ?>">
						<div class="ciru-timeline__dot"></div>
						<div class="ciru-timeline__card">
							<?php if ( ! empty( $item['fecha'] ) ) : ?>
								<div class="ciru-timeline__date"><?php echo esc_html( $item['fecha'] ); ?></div>
							<?php endif; ?>
							<h3 class="ciru-timeline__title"><?php echo esc_html( $item['titulo'] ); ?></h3>
							<?php if ( ! empty( $item['descripcion'] ) ) : ?>
								<p class="ciru-timeline__description"><?php echo esc_html( $item['descripcion'] ); ?></p>
							<?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>

		<!-- Controles de navegación (mobile) -->
		<div class="ciru-timeline__controls">
			<button class="ciru-timeline__nav ciru-timeline__nav--prev" aria-label="Anterior">
				<span class="material-symbols-outlined">chevron_left</span>
			</button>
			<button class="ciru-timeline__nav ciru-timeline__nav--next" aria-label="Siguiente">
				<span class="material-symbols-outlined">chevron_right</span>
			</button>
		</div>
	</div>
</section>
