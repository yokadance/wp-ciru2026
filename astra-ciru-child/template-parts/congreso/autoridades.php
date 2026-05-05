<?php
/**
 * Módulo: Autoridades del Congreso
 *
 * EDITAR: Complete nombre, cargo y foto de cada presidente.
 *   foto_id: ID de adjunto de WordPress (o null para ícono placeholder)
 *   card_color: color del borde inferior de la card (token CSS hex)
 */
defined( 'ABSPATH' ) || exit;

$autoridades = [
	[
		'cargo'      => 'Presidente del Congreso X',
		'nombre'     => 'Dr. [Nombre Apellido]',    // EDITAR
		'org'        => '76º Congreso Uruguayo de Cirugía',
		'card_color' => '#055db6',
		'foto_id'    => null,   // EDITAR: ID de adjunto WP
		'icon'       => 'medical_services',
	],
	[
		'cargo'      => 'Presidenta de las Jornadas',
		'nombre'     => 'Lic. [Nombre Apellido]',   // EDITAR
		'org'        => 'XXXV Jornadas de Enfermería Quirúrgica',
		'card_color' => '#45d8ed',
		'foto_id'    => null,   // EDITAR
		'icon'       => 'health_and_safety',
	],
	[
		'cargo'      => 'Presidente de las Jornadas',
		'nombre'     => '[Nombre Apellido]',          // EDITAR
		'org'        => 'XXXI Jornadas de Instrumentación Quirúrgica',
		'card_color' => '#F58634',
		'foto_id'    => null,   // EDITAR
		'icon'       => 'precision_manufacturing',
	],
];
?>

<section class="ciru-section ciru-autoridades" id="autoridades">
	<div class="ciru-container">

		<div class="ciru-autoridades__header">
			<div>
				<span class="ciru-eyebrow">Comité organizador</span>
				<h2 class="ciru-section-title">Autoridades</h2>
			</div>
			<p class="ciru-autoridades__header-right">
				Los presidentes de los tres eventos que conforman el
				76º Congreso Uruguayo de Cirugía 2026.
			</p>
		</div>

		<div class="ciru-autoridades__grid">
			<?php foreach ( $autoridades as $a ) : ?>
			<div class="ciru-autoridad-card" style="--card-color:<?php echo esc_attr( $a['card_color'] ); ?>;">

				<?php if ( ! empty( $a['foto_id'] ) && wp_get_attachment_image( $a['foto_id'], 'thumbnail' ) ) : ?>
					<div class="ciru-autoridad-card__icon">
						<?php echo wp_get_attachment_image( $a['foto_id'], 'thumbnail', false, [ 'alt' => esc_attr( $a['nombre'] ) ] ); ?>
					</div>
				<?php else : ?>
					<div class="ciru-autoridad-card__icon">
						<span class="material-symbols-outlined"><?php echo esc_html( $a['icon'] ); ?></span>
					</div>
				<?php endif; ?>

				<p class="ciru-autoridad-card__cargo"><?php echo esc_html( $a['cargo'] ); ?></p>
				<h3 class="ciru-autoridad-card__name"><?php echo esc_html( $a['nombre'] ); ?></h3>
				<p class="ciru-autoridad-card__org"><?php echo esc_html( $a['org'] ); ?></p>

			</div>
			<?php endforeach; ?>
		</div>

	</div>
</section>
