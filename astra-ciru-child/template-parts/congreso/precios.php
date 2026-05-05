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

// Leer configuración desde WordPress options (configurado en wp-admin)
$default_features = [
	'Acceso a todas las sesiones científicas',
	'Material digital del congreso',
	'Coffee breaks incluidos',
	'Certificado de asistencia',
];

$default_data = [
	'cirugia' => [
		[ 'titulo' => 'Socio SCC', 'subtitulo' => 'Socio activo de la SCC', 'precio' => '000', 'moneda' => 'USD', 'periodo' => 'precio anticipado', 'precio_regular' => '000', 'featured' => false, 'badge' => '', 'features' => $default_features ],
		[ 'titulo' => 'No Socio', 'subtitulo' => 'Cirujanos no afiliados', 'precio' => '000', 'moneda' => 'USD', 'periodo' => 'precio regular', 'precio_regular' => '', 'featured' => true, 'badge' => 'Más elegido', 'features' => array_merge( $default_features, [ 'Acceso a talleres prácticos' ] ) ],
		[ 'titulo' => 'Residente', 'subtitulo' => 'XXXVI Jornadas de Residentes', 'precio' => '000', 'moneda' => 'USD', 'periodo' => 'precio especial', 'precio_regular' => '', 'featured' => false, 'badge' => '', 'features' => $default_features ],
	],
	'enfermeria' => [
		[ 'titulo' => 'Profesional', 'subtitulo' => 'Enfermeros/as en ejercicio', 'precio' => '0000', 'moneda' => 'UYU', 'periodo' => 'precio anticipado', 'precio_regular' => '0000', 'featured' => false, 'badge' => '', 'features' => [ 'Acceso a todas las jornadas', 'Material científico digital', 'Coffee breaks incluidos', 'Certificado de asistencia' ] ],
		[ 'titulo' => 'Estudiante', 'subtitulo' => 'Estudiantes de enfermería', 'precio' => '0000', 'moneda' => 'UYU', 'periodo' => 'precio especial', 'precio_regular' => '', 'featured' => true, 'badge' => '', 'features' => [ 'Acceso a todas las jornadas', 'Material científico digital', 'Coffee breaks incluidos', 'Certificado de asistencia' ] ],
	],
	'instrumentacion' => [
		[ 'titulo' => 'Asociado AUIQ', 'subtitulo' => 'Miembro de AUIQ', 'precio' => '0000', 'moneda' => 'UYU', 'periodo' => 'precio anticipado', 'precio_regular' => '0000', 'featured' => false, 'badge' => '', 'features' => [ 'Acceso a todas las jornadas', 'Material científico digital', 'Coffee breaks incluidos', 'Certificado de asistencia' ] ],
		[ 'titulo' => 'No Asociado', 'subtitulo' => 'Instrumentistas no afiliados', 'precio' => '0000', 'moneda' => 'UYU', 'periodo' => 'precio regular', 'precio_regular' => '', 'featured' => true, 'badge' => '', 'features' => [ 'Acceso a todas las jornadas', 'Material científico digital', 'Coffee breaks incluidos', 'Certificado de asistencia' ] ],
	],
];

$precios_data = get_option( 'congreso_precios_data', $default_data );

// Asegurar que cada plan tenga features
foreach ( $precios_data as $evento => &$planes ) {
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
