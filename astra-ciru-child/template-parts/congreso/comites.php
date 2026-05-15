<?php
/**
 * Módulo: Comités (Organizador y Científico)
 * Muestra miembros con foto, nombre, apellido y cargo
 * EDITAR: wp-admin → Apariencia → Comités
 *
 * Uso:
 * - Desde página específica: get_template_part( 'template-parts/congreso/comites', null, ['area' => 'cirugia'] );
 * - Desde home: muestra todos los comités con tabs
 */
defined( 'ABSPATH' ) || exit;

// Detectar si se especifica un área específica
$area = $args['area'] ?? 'todas'; // 'cirugia', 'enfermeria', 'instrumentacion', 'todas'

// Obtener datos de comités
$comites_data = get_option( 'congreso_comites_data', [] );

// Si no hay datos, usar valores por defecto
if ( empty( $comites_data ) ) {
	$comites_data = [
		'cirugia' => [
			'organizador' => [],
			'cientifico' => []
		],
		'enfermeria' => [
			'organizador' => [],
			'cientifico' => []
		],
		'instrumentacion' => [
			'organizador' => [],
			'cientifico' => []
		]
	];
}

// Si se solicita un área específica
if ( $area !== 'todas' && isset( $comites_data[ $area ] ) ) {
	$comite_organizador = $comites_data[ $area ]['organizador'] ?? [];
	$comite_cientifico = $comites_data[ $area ]['cientifico'] ?? [];
	?>

	<section class="ciru-section ciru-comites" id="comites">
		<div class="ciru-container">

			<?php if ( ! empty( $comite_organizador ) ) : ?>
				<div class="ciru-comites__grupo">
					<h2 class="ciru-section-title">Comité Organizador</h2>
					<div class="ciru-comites__grid">
						<?php foreach ( $comite_organizador as $miembro ) : ?>
							<?php echo congreso_miembro_card( $miembro ); ?>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $comite_cientifico ) ) : ?>
				<div class="ciru-comites__grupo">
					<h2 class="ciru-section-title">Comité Científico</h2>
					<div class="ciru-comites__grid">
						<?php foreach ( $comite_cientifico as $miembro ) : ?>
							<?php echo congreso_miembro_card( $miembro ); ?>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>

		</div>
	</section>

<?php
} else {
	// Mostrar con tabs para todas las áreas
	?>
	<section class="ciru-section ciru-comites" id="comites">
		<div class="ciru-container">

			<div class="ciru-comites__header">
				<span class="ciru-eyebrow">Organización</span>
				<h2 class="ciru-section-title">Comités</h2>
				<p style="color:var(--on-surface-variant);font-size:.95rem;max-width:38rem;margin:.75rem auto 0;">
					Conocé los equipos organizadores y científicos de cada área
				</p>

				<!-- Tabs de áreas -->
				<div class="ciru-precios__tabs" role="tablist">
					<button class="ciru-precios__tab is-active" role="tab" data-tab="comites-cirugia">
						Cirugía
					</button>
					<button class="ciru-precios__tab" role="tab" data-tab="comites-enfermeria">
						Enfermería
					</button>
					<button class="ciru-precios__tab" role="tab" data-tab="comites-instrumentacion">
						Instrumentación
					</button>
				</div>
			</div>

			<!-- Panel Cirugía -->
			<div class="ciru-precios__panel is-active" id="tab-comites-cirugia">
				<?php
				$org = $comites_data['cirugia']['organizador'] ?? [];
				$cient = $comites_data['cirugia']['cientifico'] ?? [];
				?>
				<?php if ( ! empty( $org ) ) : ?>
					<div class="ciru-comites__grupo">
						<h3 class="ciru-comites__subtitulo">Comité Organizador</h3>
						<div class="ciru-comites__grid">
							<?php foreach ( $org as $miembro ) : ?>
								<?php echo congreso_miembro_card( $miembro ); ?>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $cient ) ) : ?>
					<div class="ciru-comites__grupo">
						<h3 class="ciru-comites__subtitulo">Comité Científico</h3>
						<div class="ciru-comites__grid">
							<?php foreach ( $cient as $miembro ) : ?>
								<?php echo congreso_miembro_card( $miembro ); ?>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endif; ?>
			</div>

			<!-- Panel Enfermería -->
			<div class="ciru-precios__panel" id="tab-comites-enfermeria">
				<?php
				$org = $comites_data['enfermeria']['organizador'] ?? [];
				$cient = $comites_data['enfermeria']['cientifico'] ?? [];
				?>
				<?php if ( ! empty( $org ) ) : ?>
					<div class="ciru-comites__grupo">
						<h3 class="ciru-comites__subtitulo">Comité Organizador</h3>
						<div class="ciru-comites__grid">
							<?php foreach ( $org as $miembro ) : ?>
								<?php echo congreso_miembro_card( $miembro ); ?>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $cient ) ) : ?>
					<div class="ciru-comites__grupo">
						<h3 class="ciru-comites__subtitulo">Comité Científico</h3>
						<div class="ciru-comites__grid">
							<?php foreach ( $cient as $miembro ) : ?>
								<?php echo congreso_miembro_card( $miembro ); ?>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endif; ?>
			</div>

			<!-- Panel Instrumentación -->
			<div class="ciru-precios__panel" id="tab-comites-instrumentacion">
				<?php
				$org = $comites_data['instrumentacion']['organizador'] ?? [];
				$cient = $comites_data['instrumentacion']['cientifico'] ?? [];
				?>
				<?php if ( ! empty( $org ) ) : ?>
					<div class="ciru-comites__grupo">
						<h3 class="ciru-comites__subtitulo">Comité Organizador</h3>
						<div class="ciru-comites__grid">
							<?php foreach ( $org as $miembro ) : ?>
								<?php echo congreso_miembro_card( $miembro ); ?>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $cient ) ) : ?>
					<div class="ciru-comites__grupo">
						<h3 class="ciru-comites__subtitulo">Comité Científico</h3>
						<div class="ciru-comites__grid">
							<?php foreach ( $cient as $miembro ) : ?>
								<?php echo congreso_miembro_card( $miembro ); ?>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endif; ?>
			</div>

		</div>
	</section>
	<?php
}
?>
