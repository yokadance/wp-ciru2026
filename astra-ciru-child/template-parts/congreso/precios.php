<?php
/**
 * Módulo: Precios / Inscripciones
 *
 * EDITAR PRECIOS: wp-admin → Apariencia → Configuración del Congreso
 *
 * Campos de cada plan:
 *   titulo       → nombre de la categoría
 *   subtitulo    → descripción breve
 *   precio       → valor (sin símbolo)
 *   moneda       → 'USD' | 'UYU'
 *   periodo      → etiqueta de período
 *   precio_regular → precio sin descuento (mostrado si difiere de precio)
 *   featured     → true = tarjeta destacada (fondo oscuro)
 *   badge        → etiqueta en la esquina ('Más popular') o null
 *   features     → array de beneficios incluidos
 *   href         → URL del proceso de inscripción
 */
defined( 'ABSPATH' ) || exit;

// Leer configuración desde WordPress options
$json_file = get_stylesheet_directory() . '/precios-config.json';
$default_features = [
	'Acceso a todas las sesiones científicas',
	'Material digital del congreso',
	'Coffee breaks incluidos',
	'Certificado de asistencia',
];

// Intentar leer de WordPress options primero, si no existe, importar del JSON
$precios_data = get_option( 'congreso_precios_data' );

if ( ! $precios_data && file_exists( $json_file ) ) {
	// Importar desde JSON solo la primera vez
	$json_content = file_get_contents( $json_file );
	$precios_data = json_decode( $json_content, true );
	update_option( 'congreso_precios_data', $precios_data );
}

if ( ! $precios_data ) {
	$precios_data = [
		'cirugia' => [],
		'enfermeria' => [],
		'instrumentacion' => [],
	];
}

// Asegurar que cada plan tenga features
foreach ( $precios_data as $evento => &$planes ) {
	if ( ! is_array( $planes ) ) continue;
	foreach ( $planes as &$plan ) {
		if ( empty( $plan['features'] ) ) {
			$plan['features'] = $default_features;
		}
	}
}

$precios_cirugia = $precios_data['cirugia'] ?? [];
$precios_enfermeria = $precios_data['enfermeria'] ?? [];
$precios_instrumentacion = $precios_data['instrumentacion'] ?? [];
?>

<section class="ciru-section ciru-precios" id="inscripciones">
	<div class="ciru-container">

		<div class="ciru-precios__header">
			<span class="ciru-eyebrow">Inscripciones</span>
			<h2 class="ciru-section-title">Elegí tu Evento</h2>
			<p style="color:var(--on-surface-variant);font-size:.95rem;max-width:38rem;margin:.75rem auto 0;">
				Seleccioná el congreso o jornada al que deseás asistir para ver los planes disponibles.
			</p>

			<!-- Pill tabs -->
			<div class="ciru-precios__tabs" role="tablist">
				<button class="ciru-precios__tab is-active" role="tab" data-tab="cirugia">
					Cirugía &amp; Residentes
				</button>
				<button class="ciru-precios__tab" role="tab" data-tab="enfermeria">
					Enfermería
				</button>
				<button class="ciru-precios__tab" role="tab" data-tab="instrumentacion">
					Instrumentación
				</button>
			</div>
		</div>

		<!-- Panel Cirugía -->
		<div class="ciru-precios__panel is-active" id="tab-cirugia">
			<div class="ciru-precios__grid ciru-precios__grid--3">
				<?php foreach ( $precios_cirugia as $plan ) : ?>
					<?php congreso_price_card( $plan ); ?>
				<?php endforeach; ?>
			</div>
		</div>

		<!-- Panel Enfermería -->
		<div class="ciru-precios__panel" id="tab-enfermeria">
			<div class="ciru-precios__grid ciru-precios__grid--3">
				<?php foreach ( $precios_enfermeria as $plan ) : ?>
					<?php congreso_price_card( $plan ); ?>
				<?php endforeach; ?>
			</div>
		</div>

		<!-- Panel Instrumentación -->
		<div class="ciru-precios__panel" id="tab-instrumentacion">
			<div class="ciru-precios__grid ciru-precios__grid--3">
				<?php foreach ( $precios_instrumentacion as $plan ) : ?>
					<?php congreso_price_card( $plan ); ?>
				<?php endforeach; ?>
			</div>
		</div>

	</div>
</section>
