<?php
/**
 * Módulo: Precios / Inscripciones
 *
 * EDITAR: Actualice precios, modalidades y links en los arrays
 * $precios_cirugia, $precios_enfermeria, $precios_instrumentacion.
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

/* ── CIRUGÍA / RESIDENTES ────────────────────────────── */
$precios_cirugia = [
	[
		'titulo'         => 'Socio SCC',
		'subtitulo'      => 'Socio activo de la Sociedad de Cirugía del Uruguay',
		'precio'         => '000',       // EDITAR
		'moneda'         => 'USD',
		'periodo'        => 'precio anticipado',
		'precio_regular' => '000',       // EDITAR — dejar igual si no hay descuento
		'featured'       => false,
		'badge'          => null,
		'features'       => [
			'Acceso a todas las sesiones científicas',
			'Material digital del congreso',
			'Coffee breaks incluidos',
			'Certificado de asistencia',
		],
		'href'           => '#contacto',
	],
	[
		'titulo'         => 'No Socio',
		'subtitulo'      => 'Cirujanos no afiliados a la SCC',
		'precio'         => '000',       // EDITAR
		'moneda'         => 'USD',
		'periodo'        => 'precio regular',
		'precio_regular' => '',
		'featured'       => true,
		'badge'          => 'Más elegido',
		'features'       => [
			'Acceso a todas las sesiones científicas',
			'Material digital del congreso',
			'Coffee breaks incluidos',
			'Certificado de asistencia',
			'Acceso a talleres prácticos',
		],
		'href'           => '#contacto',
	],
	[
		'titulo'         => 'Residente',
		'subtitulo'      => 'XXXVI Jornadas de Residentes de Cirugía',
		'precio'         => '000',       // EDITAR
		'moneda'         => 'USD',
		'periodo'        => 'precio especial',
		'precio_regular' => '',
		'featured'       => false,
		'badge'          => null,
		'features'       => [
			'Acceso a todas las sesiones científicas',
			'Material digital del congreso',
			'Coffee breaks incluidos',
			'Certificado de asistencia',
		],
		'href'           => '#contacto',
	],
];

/* ── ENFERMERÍA ──────────────────────────────────────── */
$precios_enfermeria = [
	[
		'titulo'         => 'Profesional',
		'subtitulo'      => 'Enfermeros/as en ejercicio',
		'precio'         => '0000',      // EDITAR
		'moneda'         => 'UYU',
		'periodo'        => 'precio anticipado',
		'precio_regular' => '0000',      // EDITAR
		'featured'       => false,
		'badge'          => null,
		'features'       => [
			'Acceso a todas las jornadas',
			'Material científico digital',
			'Coffee breaks incluidos',
			'Certificado de asistencia',
		],
		'href'           => '#contacto',
	],
	[
		'titulo'         => 'Estudiante',
		'subtitulo'      => 'Estudiantes de enfermería',
		'precio'         => '0000',      // EDITAR
		'moneda'         => 'UYU',
		'periodo'        => 'precio especial',
		'precio_regular' => '',
		'featured'       => true,
		'badge'          => null,
		'features'       => [
			'Acceso a todas las jornadas',
			'Material científico digital',
			'Coffee breaks incluidos',
			'Certificado de asistencia',
		],
		'href'           => '#contacto',
	],
];

/* ── INSTRUMENTACIÓN ─────────────────────────────────── */
$precios_instrumentacion = [
	[
		'titulo'         => 'Asociado AUIQ',
		'subtitulo'      => 'Miembro de la Asociación Uruguaya de Instrumentistas Quirúrgicos',
		'precio'         => '0000',      // EDITAR
		'moneda'         => 'UYU',
		'periodo'        => 'precio anticipado',
		'precio_regular' => '0000',      // EDITAR
		'featured'       => false,
		'badge'          => null,
		'features'       => [
			'Acceso a todas las jornadas',
			'Material científico digital',
			'Coffee breaks incluidos',
			'Certificado de asistencia',
		],
		'href'           => '#contacto',
	],
	[
		'titulo'         => 'No Asociado',
		'subtitulo'      => 'Instrumentistas no afiliados a AUIQ',
		'precio'         => '0000',      // EDITAR
		'moneda'         => 'UYU',
		'periodo'        => 'precio regular',
		'precio_regular' => '',
		'featured'       => true,
		'badge'          => null,
		'features'       => [
			'Acceso a todas las jornadas',
			'Material científico digital',
			'Coffee breaks incluidos',
			'Certificado de asistencia',
		],
		'href'           => '#contacto',
	],
];
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
			<div class="ciru-precios__grid ciru-precios__grid--2">
				<?php foreach ( $precios_enfermeria as $plan ) : ?>
					<?php congreso_price_card( $plan ); ?>
				<?php endforeach; ?>
			</div>
		</div>

		<!-- Panel Instrumentación -->
		<div class="ciru-precios__panel" id="tab-instrumentacion">
			<div class="ciru-precios__grid ciru-precios__grid--2">
				<?php foreach ( $precios_instrumentacion as $plan ) : ?>
					<?php congreso_price_card( $plan ); ?>
				<?php endforeach; ?>
			</div>
		</div>

	</div>
</section>
