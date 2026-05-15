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
			<div class="ciru-precios__table-wrap">
				<table class="ciru-precios__table">
					<thead>
						<tr>
							<th>Categoría</th>
							<th>Hasta 01-Oct-2026</th>
							<th>Hasta 01-Dic-2026</th>
							<th>En Sede</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><strong>Cirujanos Socios SCU</strong></td>
							<td>USD 200</td>
							<td>USD 250</td>
							<td>USD 300</td>
						</tr>
						<tr>
							<td><strong>Cirujanos No Socios</strong></td>
							<td>USD 250</td>
							<td>USD 300</td>
							<td>USD 350</td>
						</tr>
						<tr class="destacado">
							<td><strong>Residentes Socios SCU</strong></td>
							<td>USD 100</td>
							<td>USD 120</td>
							<td>USD 150</td>
						</tr>
						<tr>
							<td><strong>Residentes No Socios</strong></td>
							<td>USD 120</td>
							<td>USD 150</td>
							<td>USD 180</td>
						</tr>
						<tr>
							<td><strong>Estudiantes</strong></td>
							<td>USD 50</td>
							<td>USD 60</td>
							<td>USD 80</td>
						</tr>
						<tr>
							<td><strong>Extranjeros</strong></td>
							<td>USD 300</td>
							<td>USD 350</td>
							<td>USD 400</td>
						</tr>
					</tbody>
				</table>
				<div class="ciru-precios__benefits">
					<h4>Incluye:</h4>
					<ul>
						<li>Acceso a todas las sesiones científicas</li>
						<li>Material del congreso (digital)</li>
						<li>Certificado de asistencia</li>
						<li>Coffee breaks</li>
					</ul>
				</div>
				<div class="ciru-precios__cta">
					<a href="https://sige.grupoelis.com.uy/events/76-congreso-uruguayo-de-cirugia-2-3-y-4-de-diciembre-de-2026/home"
					   class="ciru-btn ciru-btn--accent"
					   target="_blank"
					   rel="noopener">
						Inscribirse Ahora
					</a>
				</div>
			</div>
		</div>

		<!-- Panel Enfermería -->
		<div class="ciru-precios__panel" id="tab-enfermeria">
			<div class="ciru-precios__table-wrap">
				<table class="ciru-precios__table">
					<thead>
						<tr>
							<th>Categoría</th>
							<th>Hasta 01-Oct-2026</th>
							<th>Hasta 01-Dic-2026</th>
							<th>En Sede</th>
						</tr>
					</thead>
					<tbody>
						<tr class="destacado">
							<td><strong>Enfermería Quirúrgica</strong></td>
							<td>USD 80</td>
							<td>USD 100</td>
							<td>USD 120</td>
						</tr>
						<tr>
							<td><strong>Estudiantes</strong></td>
							<td>USD 50</td>
							<td>USD 60</td>
							<td>USD 80</td>
						</tr>
					</tbody>
				</table>
				<div class="ciru-precios__benefits">
					<h4>Incluye:</h4>
					<ul>
						<li>Acceso a todas las jornadas</li>
						<li>Material científico (digital)</li>
						<li>Certificado de asistencia</li>
						<li>Coffee breaks</li>
					</ul>
				</div>
				<div class="ciru-precios__cta">
					<a href="https://sige.grupoelis.com.uy/events/76-congreso-uruguayo-de-cirugia-2-3-y-4-de-diciembre-de-2026/home"
					   class="ciru-btn ciru-btn--accent"
					   target="_blank"
					   rel="noopener">
						Inscribirse Ahora
					</a>
				</div>
			</div>
		</div>

		<!-- Panel Instrumentación -->
		<div class="ciru-precios__panel" id="tab-instrumentacion">
			<div class="ciru-precios__table-wrap">
				<table class="ciru-precios__table">
					<thead>
						<tr>
							<th>Categoría</th>
							<th>Hasta 01-Oct-2026</th>
							<th>Hasta 01-Dic-2026</th>
							<th>En Sede</th>
						</tr>
					</thead>
					<tbody>
						<tr class="destacado">
							<td><strong>Instrumentación Quirúrgica (AUIQ)</strong></td>
							<td>USD 80</td>
							<td>USD 100</td>
							<td>USD 120</td>
						</tr>
						<tr>
							<td><strong>Estudiantes</strong></td>
							<td>USD 50</td>
							<td>USD 60</td>
							<td>USD 80</td>
						</tr>
					</tbody>
				</table>
				<div class="ciru-precios__benefits">
					<h4>Incluye:</h4>
					<ul>
						<li>Acceso a todas las jornadas</li>
						<li>Material científico (digital)</li>
						<li>Certificado de asistencia</li>
						<li>Coffee breaks</li>
					</ul>
				</div>
				<div class="ciru-precios__cta">
					<a href="https://sige.grupoelis.com.uy/events/76-congreso-uruguayo-de-cirugia-2-3-y-4-de-diciembre-de-2026/home"
					   class="ciru-btn ciru-btn--accent"
					   target="_blank"
					   rel="noopener">
						Inscribirse Ahora
					</a>
				</div>
			</div>
		</div>

	</div>
</section>
