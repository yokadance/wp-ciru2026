<?php
/**
 * Módulo: Trabajos Libres - Reglamentos por área
 * Muestra reglamentos con sistema de tabs
 * EDITAR: wp-admin → Apariencia → Trabajos Libres
 */
defined( 'ABSPATH' ) || exit;

// Obtener reglamentos de cada área
$reglamentos = get_option( 'congreso_trabajos_libres_data', [] );

// Si no hay datos, usar valores por defecto
if ( empty( $reglamentos ) ) {
	$reglamentos = [
		'cirugia' => [
			'titulo' => 'Cirugía & Residentes',
			'items' => [
				'Los trabajos deben enviarse en formato digital',
				'Fecha límite: 15 de junio de 2026',
				'Extensión máxima: 300 palabras',
				'Se aceptan trabajos originales e inéditos',
				'Evaluación por comité científico'
			]
		],
		'enfermeria' => [
			'titulo' => 'Enfermería',
			'items' => [
				'Los trabajos deben enviarse en formato digital',
				'Fecha límite: 15 de junio de 2026',
				'Extensión máxima: 300 palabras',
				'Se aceptan trabajos originales e inéditos',
				'Evaluación por comité científico'
			]
		],
		'instrumentacion' => [
			'titulo' => 'Instrumentación',
			'items' => [
				'Los trabajos deben enviarse en formato digital',
				'Fecha límite: 15 de junio de 2026',
				'Extensión máxima: 300 palabras',
				'Se aceptan trabajos originales e inéditos',
				'Evaluación por comité científico'
			]
		]
	];
}

$url_postulacion = get_option( 'congreso_url_postulacion', '#contacto' );
?>

<section class="ciru-section ciru-trabajos-libres" id="trabajos-libres">
	<div class="ciru-container">

		<div class="ciru-trabajos-libres__header">
			<span class="ciru-eyebrow">Presentación de Trabajos</span>
			<h2 class="ciru-section-title">Trabajos Libres</h2>
			<p style="color:var(--on-surface-variant);font-size:.95rem;max-width:38rem;margin:.75rem auto 0;">
				Conocé los reglamentos para presentar trabajos científicos en cada área
			</p>

			<!-- Tabs de áreas -->
			<div class="ciru-trabajos-libres__tabs ciru-precios__tabs" role="tablist">
				<button class="ciru-precios__tab is-active" role="tab" data-tab="cirugia-tl">
					Cirugía & Residentes
				</button>
				<button class="ciru-precios__tab" role="tab" data-tab="enfermeria-tl">
					Enfermería
				</button>
				<button class="ciru-precios__tab" role="tab" data-tab="instrumentacion-tl">
					Instrumentación
				</button>
			</div>
		</div>

		<!-- Panel Cirugía -->
		<div class="ciru-trabajos-libres__panel ciru-precios__panel is-active" id="tab-cirugia-tl">
			<div class="ciru-trabajos-libres__content">
				<div class="ciru-trabajos-libres__reglamento">
					<h3 class="ciru-trabajos-libres__titulo">
						<?php echo esc_html( $reglamentos['cirugia']['titulo'] ?? 'Cirugía & Residentes' ); ?>
					</h3>
					<ul class="ciru-trabajos-libres__list">
						<?php if ( ! empty( $reglamentos['cirugia']['items'] ) ) : ?>
							<?php foreach ( $reglamentos['cirugia']['items'] as $item ) : ?>
								<li>
									<span class="material-symbols-outlined">check_circle</span>
									<?php echo esc_html( $item ); ?>
								</li>
							<?php endforeach; ?>
						<?php endif; ?>
					</ul>
				</div>
			</div>
		</div>

		<!-- Panel Enfermería -->
		<div class="ciru-trabajos-libres__panel ciru-precios__panel" id="tab-enfermeria-tl">
			<div class="ciru-trabajos-libres__content">
				<div class="ciru-trabajos-libres__reglamento">
					<h3 class="ciru-trabajos-libres__titulo">
						<?php echo esc_html( $reglamentos['enfermeria']['titulo'] ?? 'Enfermería' ); ?>
					</h3>
					<ul class="ciru-trabajos-libres__list">
						<?php if ( ! empty( $reglamentos['enfermeria']['items'] ) ) : ?>
							<?php foreach ( $reglamentos['enfermeria']['items'] as $item ) : ?>
								<li>
									<span class="material-symbols-outlined">check_circle</span>
									<?php echo esc_html( $item ); ?>
								</li>
							<?php endforeach; ?>
						<?php endif; ?>
					</ul>
				</div>
			</div>
		</div>

		<!-- Panel Instrumentación -->
		<div class="ciru-trabajos-libres__panel ciru-precios__panel" id="tab-instrumentacion-tl">
			<div class="ciru-trabajos-libres__content">
				<div class="ciru-trabajos-libres__reglamento">
					<h3 class="ciru-trabajos-libres__titulo">
						<?php echo esc_html( $reglamentos['instrumentacion']['titulo'] ?? 'Instrumentación' ); ?>
					</h3>
					<ul class="ciru-trabajos-libres__list">
						<?php if ( ! empty( $reglamentos['instrumentacion']['items'] ) ) : ?>
							<?php foreach ( $reglamentos['instrumentacion']['items'] as $item ) : ?>
								<li>
									<span class="material-symbols-outlined">check_circle</span>
									<?php echo esc_html( $item ); ?>
								</li>
							<?php endforeach; ?>
						<?php endif; ?>
					</ul>
				</div>
			</div>
		</div>

		<!-- Botón único de postulación -->
		<div class="ciru-trabajos-libres__cta">
			<a href="<?php echo esc_url( $url_postulacion ); ?>" class="ciru-btn ciru-btn--primary">
				<span class="material-symbols-outlined">upload_file</span>
				Postular Trabajo
			</a>
			<p class="ciru-trabajos-libres__note">
				El sistema de postulación aplica para todas las áreas
			</p>
		</div>

	</div>
</section>
