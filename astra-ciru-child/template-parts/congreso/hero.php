<?php
/**
 * Módulo: Hero Slider — columna única, diseño original
 *
 * EDITAR: Modifique el array $slides[] para cambiar títulos, subtítulos,
 * fechas, lugares, gradientes y colores de cada evento.
 */
defined( 'ABSPATH' ) || exit;

// URL base de imágenes del hero
$img_base = get_stylesheet_directory_uri() . '/assets/images/';

$slides = [
	[
		'id'        => 'cirugia',
		'tag'       => 'Evento Principal',
		'titulo'    => '76º Congreso<br>Uruguayo de Cirugía',
		'subtitulo' => 'Ciencia, Humanismo y Excelencia',
		'fecha'     => 'Fecha por confirmar · 2026',      // EDITAR
		'lugar'     => 'Montevideo, Uruguay',               // EDITAR
		'btn1'      => [ 'texto' => 'Inscribirse',   'href' => '#inscripciones' ],
		'btn2'      => [ 'texto' => 'Ver Programa',  'href' => '#programa' ],
		'color_tag' => '#45d8ed',
		// Overlay oscuro sobre la foto: izquierda más cubierta para legibilidad del texto
		'gradient'  => 'linear-gradient(105deg, rgba(0,53,58,.92) 0%, rgba(0,53,58,.72) 45%, rgba(0,53,58,.35) 100%)',
		'foto'      => $img_base . 'hero-cirugia.jpg',    // EDITAR: guardar imagen aquí
		'tab_label' => 'Cirugía',
		'tab_color' => '#45d8ed',
	],
	[
		'id'        => 'enfermeria',
		'tag'       => 'Evento Simultáneo',
		'titulo'    => 'XXXV Jornadas Integradas<br>de Enfermería Quirúrgica',
		'subtitulo' => 'Ciencia, Humanismo y Excelencia',
		'fecha'     => 'Fecha por confirmar · 2026',      // EDITAR
		'lugar'     => 'Montevideo, Uruguay',               // EDITAR
		'btn1'      => [ 'texto' => 'Inscribirse',   'href' => '#inscripciones' ],
		'btn2'      => [ 'texto' => 'Ver Programa',  'href' => '#programa-enfermeria' ],
		'color_tag' => '#45d8ed',
		'gradient'  => 'linear-gradient(105deg, rgba(0,40,28,.92) 0%, rgba(0,60,40,.72) 45%, rgba(0,40,28,.35) 100%)',
		'foto'      => $img_base . 'hero-enfermeria.jpg', // EDITAR
		'tab_label' => 'Enfermería',
		'tab_color' => '#45d8ed',
	],
	[
		'id'        => 'instrumentacion',
		'tag'       => 'Evento Simultáneo',
		'titulo'    => 'XXXI Jornadas Integradas de<br>Instrumentación Quirúrgica',
		'subtitulo' => 'Ciencia, Humanismo y Excelencia',
		'fecha'     => 'Fecha por confirmar · 2026',      // EDITAR
		'lugar'     => 'Montevideo, Uruguay',               // EDITAR
		'btn1'      => [ 'texto' => 'Inscribirse',   'href' => '#inscripciones' ],
		'btn2'      => [ 'texto' => 'Ver Programa',  'href' => '#programa-instrumentacion' ],
		'color_tag' => '#45d8ed',
		'gradient'  => 'linear-gradient(105deg, rgba(43,18,0,.92) 0%, rgba(100,48,0,.72) 45%, rgba(43,18,0,.35) 100%)',
		'foto'      => $img_base . 'hero-instrumentacion.jpg', // EDITAR
		'tab_label' => 'Instrumentación',
		'tab_color' => '#45d8ed',
	],
];
?>

<section class="ciru-hero" id="inicio" aria-label="Slider principal del congreso">

	<div class="ciru-hero__slides" data-slides>
		<?php foreach ( $slides as $i => $s ) : ?>
		<div class="ciru-hero__slide <?php echo $i === 0 ? 'is-active' : ''; ?>"
		     data-slide-index="<?php echo esc_attr( $i ); ?>"
		     style="--slide-gradient:<?php echo esc_attr( $s['gradient'] ); ?>;">

			<!-- Foto de fondo -->
			<?php if ( ! empty( $s['foto'] ) ) : ?>
				<img class="ciru-hero__slide-bg-photo"
				     src="<?php echo esc_url( $s['foto'] ); ?>"
				     alt=""
				     aria-hidden="true"
				     loading="<?php echo $i === 0 ? 'eager' : 'lazy'; ?>">
			<?php endif; ?>

			<!-- Overlay sobre la foto -->
			<div class="ciru-hero__slide-bg"></div>

			<div class="ciru-hero__content">
				<div class="ciru-hero__content-inner">

					<span class="ciru-hero__badge" style="background:<?php echo esc_attr( $s['color_tag'] ); ?>;color:#001f24;">
						<?php echo esc_html( $s['tag'] ); ?>
					</span>

					<h1 class="ciru-hero__title">
						<?php echo wp_kses( $s['titulo'], [ 'br' => [] ] ); ?>
					</h1>

					<p class="ciru-hero__subtitle">
						<?php echo esc_html( $s['subtitulo'] ); ?>
					</p>

					<div class="ciru-hero__meta">
						<span class="ciru-hero__meta-item">
							<span class="material-symbols-outlined">calendar_month</span>
							<?php echo esc_html( $s['fecha'] ); ?>
						</span>
						<span class="ciru-hero__meta-item">
							<span class="material-symbols-outlined">location_on</span>
							<?php echo esc_html( $s['lugar'] ); ?>
						</span>
					</div>

					<div class="ciru-hero__actions">
						<a href="<?php echo esc_url( $s['btn1']['href'] ); ?>" class="ciru-btn ciru-btn--accent">
							<?php echo esc_html( $s['btn1']['texto'] ); ?>
						</a>
						<a href="<?php echo esc_url( $s['btn2']['href'] ); ?>" class="ciru-btn ciru-btn--outline">
							<?php echo esc_html( $s['btn2']['texto'] ); ?>
						</a>
					</div>

				</div>
			</div>
		</div>
		<?php endforeach; ?>
	</div>

	<!-- Dots de navegación (verticales, lado derecho) -->
	<div class="ciru-hero__dots" role="tablist" aria-label="Navegación de slides">
		<?php foreach ( $slides as $i => $s ) : ?>
		<button class="ciru-hero__dot <?php echo $i === 0 ? 'is-active' : ''; ?>"
		        data-slide-target="<?php echo esc_attr( $i ); ?>"
		        role="tab"
		        aria-label="<?php echo esc_attr( $s['tab_label'] ); ?>">
		</button>
		<?php endforeach; ?>
	</div>

	<!-- Tabs inferiores (shortcuts por evento) -->
	<div class="ciru-hero__event-bar">
		<?php foreach ( $slides as $i => $s ) : ?>
		<button class="ciru-hero__event-tab <?php echo $i === 0 ? 'is-active' : ''; ?>"
		        data-slide-target="<?php echo esc_attr( $i ); ?>"
		        style="--tab-color:<?php echo esc_attr( $s['tab_color'] ); ?>;">
			<?php echo esc_html( $s['tab_label'] ); ?>
		</button>
		<?php endforeach; ?>
	</div>

	<!-- Barra de progreso -->
	<div class="ciru-hero__progress" aria-hidden="true">
		<div class="ciru-hero__progress-bar" data-progress></div>
	</div>

</section>
