<?php
/**
 * Template Name: Postulaciones de Trabajos
 *
 * Página dedicada a las 5 modalidades de postulación.
 * En WordPress Admin → Páginas → agregar/editar la página "Postulaciones"
 * y seleccionar este template en "Atributos de Página".
 *
 * EDITAR: Actualice los requisitos, fechas límite y links de los formularios.
 */
defined( 'ABSPATH' ) || exit;
get_header();

/* EDITAR: Fechas límite de postulación */
$fecha_limite = 'Por confirmar';   // EDITAR ej. '30 de junio de 2026'

$modalidades = [
	[
		'slug'     => 'poster',
		'icono'    => '🗂️',
		'titulo'   => 'Póster',
		'color'    => '#3C619C',
		'desc'     => 'Presentación visual de resultados de investigación, casos clínicos o revisiones bibliográficas.',
		'requisitos' => [
			'Formato digital A0 vertical (841 × 1189 mm)',
			'Resolución mínima 150 dpi',
			'Idioma: español',
			'Máximo 800 palabras de texto',
			'Incluir: introducción, objetivos, material y método, resultados y conclusiones',
		],
		'href'     => '#contacto',
	],
	[
		'slug'     => 'videos',
		'icono'    => '🎬',
		'titulo'   => 'Videos',
		'color'    => '#49BEAA',
		'desc'     => 'Documentación en video de técnicas quirúrgicas, procedimientos innovadores o casos de interés.',
		'requisitos' => [
			'Duración máxima: 10 minutos',
			'Formato: MP4 o MOV, resolución Full HD (1920×1080)',
			'Incluir subtítulos en español',
			'Audio claro con narración o música de fondo',
			'Sin marcas de agua o identificación institucional visible',
		],
		'href'     => '#contacto',
	],
	[
		'slug'     => 'oral',
		'icono'    => '🎤',
		'titulo'   => 'Presentaciones Orales',
		'color'    => '#33C6F4',
		'desc'     => 'Exposición ante jurado y auditorio de trabajos originales de investigación científica.',
		'requisitos' => [
			'Resumen de hasta 300 palabras',
			'Presentación PowerPoint: máximo 15 diapositivas',
			'Tiempo de exposición: 8 minutos + 5 de preguntas',
			'Trabajo no publicado previamente',
			'Idioma: español',
		],
		'href'     => '#contacto',
	],
	[
		'slug'     => 'forum',
		'icono'    => '🏆',
		'titulo'   => 'Premio Fórum',
		'color'    => '#F58634',
		'desc'     => 'Premio especial al mejor trabajo presentado en el fórum de discusión científica del congreso.',
		'requisitos' => [
			'Trabajo original no publicado',
			'Resumen extendido de hasta 500 palabras',
			'Debe participar también en la modalidad Oral',
			'Postulación explícita al Premio Fórum en el formulario',
			'Evaluación por comité científico',
		],
		'href'     => '#contacto',
	],
	[
		'slug'     => 'ardao',
		'icono'    => '🥇',
		'titulo'   => 'Premio Ardao',
		'color'    => '#C9A227',
		'desc'     => 'Máximo reconocimiento del congreso al mejor trabajo de investigación científica original.',
		'requisitos' => [
			'Trabajo de investigación básica o clínica original',
			'Manuscrito completo en formato IMRYD (máx. 3000 palabras)',
			'Evaluación ciega por jurado especializado',
			'Solo puede postularse una vez por edición',
			'Premio incluye diploma y publicación en revista',
		],
		'href'     => '#contacto',
	],
];
?>

<div id="congreso-page-postulaciones">

	<!-- Hero de página -->
	<div class="ciru-page-hero" style="background:linear-gradient(135deg,#1A2E4A 0%,#3C619C 100%);padding:60px 0;color:#fff;">
		<div class="ciru-container" style="text-align:center;">
			<span class="ciru-eyebrow" style="color:#49BEAA;">76º Congreso Uruguayo de Cirugía</span>
			<h1 style="font-family:'Playfair Display',Georgia,serif;font-size:clamp(2rem,4vw,3rem);color:#fff;margin:8px 0 14px;">
				Postulación de Trabajos
			</h1>
			<p style="color:rgba(255,255,255,.7);max-width:600px;margin:0 auto 24px;font-size:1rem;line-height:1.7;">
				Presentá tu investigación, caso clínico o técnica quirúrgica en una de las cinco modalidades disponibles.
			</p>
			<p style="color:#49BEAA;font-size:.85rem;font-weight:600;letter-spacing:.05em;">
				📅 Fecha límite de postulación: <?php echo esc_html( $fecha_limite ); ?>
			</p>
		</div>
	</div>

	<!-- Modalidades -->
	<div class="ciru-section" style="background:#fff;">
		<div class="ciru-container">
			<div style="display:grid;gap:32px;">
				<?php foreach ( $modalidades as $m ) : ?>
				<div style="border:1px solid #DDE3E9;border-left:5px solid <?php echo esc_attr( $m['color'] ); ?>;border-radius:8px;padding:32px 28px;display:grid;grid-template-columns:1fr auto;gap:24px;align-items:start;" class="ciru-post-detail">
					<div>
						<div style="display:flex;align-items:center;gap:12px;margin-bottom:12px;">
							<span style="font-size:2rem;"><?php echo esc_html( $m['icono'] ); ?></span>
							<h2 style="font-family:'Playfair Display',Georgia,serif;font-size:1.4rem;color:#1A252F;margin:0;">
								<?php echo esc_html( $m['titulo'] ); ?>
							</h2>
						</div>
						<p style="font-size:.95rem;color:#5F6075;line-height:1.7;margin:0 0 20px;">
							<?php echo esc_html( $m['desc'] ); ?>
						</p>
						<h4 style="font-size:.78rem;letter-spacing:.12em;text-transform:uppercase;color:#3C619C;margin:0 0 10px;font-family:'Inter',sans-serif;">
							Requisitos
						</h4>
						<ul style="margin:0;padding:0 0 0 18px;">
							<?php foreach ( $m['requisitos'] as $req ) : ?>
							<li style="font-size:.88rem;color:#3D5060;padding:4px 0;line-height:1.5;">
								<?php echo esc_html( $req ); ?>
							</li>
							<?php endforeach; ?>
						</ul>
					</div>
					<div style="flex-shrink:0;">
						<a href="<?php echo esc_url( $m['href'] ); ?>"
						   style="display:inline-block;background:<?php echo esc_attr( $m['color'] ); ?>;color:#fff;padding:12px 24px;border-radius:4px;font-size:.82rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;text-decoration:none;white-space:nowrap;">
							Postular trabajo →
						</a>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>

</div>

<?php get_footer(); ?>
