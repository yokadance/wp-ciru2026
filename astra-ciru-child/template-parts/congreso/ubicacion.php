<?php
/**
 * Módulo: Ubicación / Mapa
 *
 * EDITAR:
 *   1. $venue_nombre y $detalles abajo
 *   2. $map_url: generá el embed en openstreetmap.org → Exportar → HTML
 *   3. $map_link: link al mapa completo
 */
defined( 'ABSPATH' ) || exit;

$venue_nombre = 'Sede del Congreso';  // EDITAR: ej. 'Hotel Presidente'

$map_url  = 'https://www.openstreetmap.org/export/embed.html?bbox=-56.2085%2C-34.9110%2C-56.1685%2C-34.8910&layer=mapnik&marker=-34.9011%2C-56.1885';
$map_link = 'https://www.openstreetmap.org/?mlat=-34.9011&mlon=-56.1885#map=15/-34.9011/-56.1885';

$detalles = [
	[
		'icon'   => 'location_on',
		'titulo' => 'Dirección',
		'texto'  => 'Montevideo, Uruguay — sede por confirmar',  // EDITAR
	],
	[
		'icon'   => 'calendar_month',
		'titulo' => 'Fecha',
		'texto'  => 'Fecha por confirmar · 2026',                // EDITAR
	],
	[
		'icon'   => 'schedule',
		'titulo' => 'Horarios',
		'texto'  => 'Horarios por confirmar',                    // EDITAR
	],
	[
		'icon'   => 'directions_bus',
		'titulo' => 'Acceso',
		'texto'  => 'Accesible en transporte público · Estacionamiento disponible', // EDITAR
	],
];
?>

<section class="ciru-section ciru-ubicacion" id="ubicacion">
	<div class="ciru-container">

		<div class="ciru-ubicacion__card">

			<!-- Info del venue -->
			<div class="ciru-ubicacion__info">

				<span class="ciru-eyebrow">Sede del evento</span>
				<h2 class="ciru-ubicacion__venue"><?php echo esc_html( $venue_nombre ); ?></h2>

				<div class="ciru-ubicacion__details">
					<?php foreach ( $detalles as $d ) : ?>
					<div class="ciru-ubicacion__detail">
						<span class="material-symbols-outlined"><?php echo esc_html( $d['icon'] ); ?></span>
						<div>
							<h4><?php echo esc_html( $d['titulo'] ); ?></h4>
							<p><?php echo esc_html( $d['texto'] ); ?></p>
						</div>
					</div>
					<?php endforeach; ?>
				</div>

				<a href="<?php echo esc_url( $map_link ); ?>"
				   target="_blank" rel="noopener noreferrer"
				   class="ciru-btn ciru-btn--ghost">
					<span class="material-symbols-outlined">open_in_new</span>
					Ver en OpenStreetMap
				</a>

			</div>

			<!-- Mapa -->
			<div class="ciru-ubicacion__map">
				<iframe
					src="<?php echo esc_url( $map_url ); ?>"
					title="Mapa de ubicación del congreso"
					loading="lazy"
					allowfullscreen>
				</iframe>
				<span class="ciru-ubicacion__map-label">OpenStreetMap</span>
			</div>

		</div>

	</div>
</section>
