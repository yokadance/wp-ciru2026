<?php
/**
 * Módulo: Hotelería
 * Muestra hoteles disponibles para el congreso
 * EDITAR: wp-admin → Apariencia → Hotelería
 */
defined( 'ABSPATH' ) || exit;

// Obtener datos de hoteles
$hoteles = get_option( 'congreso_hoteles_data', [] );

// Si no hay hoteles configurados, usar valores por defecto
if ( empty( $hoteles ) ) {
	$hoteles = [
		[
			'nombre' => 'The Grand',
			'descripcion' => 'Hotel de lujo en el centro de Montevideo',
			'direccion' => 'Dirección a confirmar',
			'precio' => 'Precio a confirmar',
			'amenities' => [
				'Wi-Fi gratuito',
				'Desayuno incluido',
				'Gimnasio',
				'Spa',
				'Estacionamiento'
			],
			'contacto' => '',
			'destacado' => true
		],
		[
			'nombre' => 'La Capilla',
			'descripcion' => 'Hotel boutique con encanto histórico',
			'direccion' => 'Dirección a confirmar',
			'precio' => 'Precio a confirmar',
			'amenities' => [
				'Wi-Fi gratuito',
				'Desayuno incluido',
				'Bar',
				'Restaurante'
			],
			'contacto' => '',
			'destacado' => false
		]
	];
}
?>

<section class="ciru-section ciru-hoteleria" id="hoteleria">
	<div class="ciru-container">

		<div class="ciru-hoteleria__header">
			<span class="ciru-eyebrow">Alojamiento</span>
			<h2 class="ciru-section-title">Hotelería</h2>
			<p style="color:var(--on-surface-variant);font-size:.95rem;max-width:38rem;margin:.75rem auto 0;">
				Opciones de alojamiento con tarifas especiales para asistentes al congreso
			</p>
		</div>

		<div class="ciru-hoteleria__grid">
			<?php foreach ( $hoteles as $hotel ) : ?>
				<div class="ciru-hotel-card <?php echo ! empty( $hotel['destacado'] ) ? 'is-featured' : ''; ?>">

					<?php if ( ! empty( $hotel['destacado'] ) ) : ?>
						<div class="ciru-hotel-card__badge">Recomendado</div>
					<?php endif; ?>

					<div class="ciru-hotel-card__header">
						<h3 class="ciru-hotel-card__nombre"><?php echo esc_html( $hotel['nombre'] ); ?></h3>
						<p class="ciru-hotel-card__descripcion"><?php echo esc_html( $hotel['descripcion'] ); ?></p>
					</div>

					<div class="ciru-hotel-card__body">
						<?php if ( ! empty( $hotel['direccion'] ) ) : ?>
							<div class="ciru-hotel-card__info">
								<span class="material-symbols-outlined">location_on</span>
								<span><?php echo esc_html( $hotel['direccion'] ); ?></span>
							</div>
						<?php endif; ?>

						<?php if ( ! empty( $hotel['precio'] ) ) : ?>
							<div class="ciru-hotel-card__precio">
								<?php echo esc_html( $hotel['precio'] ); ?>
							</div>
						<?php endif; ?>

						<?php if ( ! empty( $hotel['amenities'] ) ) : ?>
							<div class="ciru-hotel-card__amenities">
								<strong>Amenities:</strong>
								<ul>
									<?php foreach ( $hotel['amenities'] as $amenity ) : ?>
										<li>
											<span class="material-symbols-outlined">check_circle</span>
											<?php echo esc_html( $amenity ); ?>
										</li>
									<?php endforeach; ?>
								</ul>
							</div>
						<?php endif; ?>
					</div>

					<div class="ciru-hotel-card__footer">
						<?php if ( ! empty( $hotel['contacto'] ) ) : ?>
							<a href="<?php echo esc_url( $hotel['contacto'] ); ?>"
							   class="ciru-btn <?php echo ! empty( $hotel['destacado'] ) ? 'ciru-btn--primary' : 'ciru-btn--ghost'; ?>"
							   target="_blank"
							   rel="noopener">
								Reservar ahora
							</a>
						<?php else : ?>
							<a href="#contacto" class="ciru-btn ciru-btn--ghost">
								Consultar disponibilidad
							</a>
						<?php endif; ?>
					</div>

				</div>
			<?php endforeach; ?>
		</div>

	</div>
</section>
