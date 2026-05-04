<?php
/**
 * Módulo: Postulación de Trabajos — Bento Grid
 *
 * EDITAR: Actualice los links (href) y textos de cada celda.
 * La celda --main es el card principal (span 2×2), --dark y --plain
 * son celdas individuales, --accent ocupa 2 columnas.
 */
defined( 'ABSPATH' ) || exit;

$bases_url = get_permalink( get_page_by_path( 'postulaciones' ) ) ?: '#contacto';
?>

<section class="ciru-section ciru-postulaciones" id="postulaciones">
	<div class="ciru-container">

		<div class="ciru-postulaciones__header">
			<div>
				<span class="ciru-eyebrow">Presentación de trabajos</span>
				<h2 class="ciru-section-title">Postulación de Trabajos</h2>
			</div>
			<a href="<?php echo esc_url( $bases_url ); ?>" class="ciru-postulaciones__bases">
				<span class="material-symbols-outlined">download</span>
				Descargar bases
			</a>
		</div>

		<div class="ciru-bento">

			<!-- Celda principal (2 cols × 2 filas) -->
			<div class="ciru-bento__cell ciru-bento__cell--main">
				<div>
					<div class="ciru-bento__icon">
						<span class="material-symbols-outlined">biotech</span>
					</div>
					<h3 class="ciru-bento__title">Presentaciones Orales</h3>
					<p class="ciru-bento__desc">
						Exposición oral de trabajos originales de investigación científica ante jurado y auditorio.
						Los trabajos seleccionados acceden a los premios del congreso.
					</p>
				</div>
				<div>
					<p class="ciru-bento__meta">Investigación original · Jurado especializado</p>
					<a href="<?php echo esc_url( $bases_url ); ?>" class="ciru-btn ciru-btn--primary" style="margin-top:1rem;">
						Ver bases
						<span class="material-symbols-outlined">arrow_forward</span>
					</a>
				</div>
			</div>

			<!-- Celda oscura -->
			<div class="ciru-bento__cell ciru-bento__cell--dark">
				<div class="ciru-bento__icon">
					<span class="material-symbols-outlined">picture_as_pdf</span>
				</div>
				<h3 class="ciru-bento__title">Póster</h3>
				<p class="ciru-bento__desc">Presentación visual de resultados o casos clínicos en formato póster digital.</p>
				<p class="ciru-bento__meta">Digital · Impreso</p>
			</div>

			<!-- Celda plain -->
			<div class="ciru-bento__cell ciru-bento__cell--plain">
				<div class="ciru-bento__icon">
					<span class="material-symbols-outlined">videocam</span>
				</div>
				<h3 class="ciru-bento__title">Videos</h3>
				<p class="ciru-bento__desc">Técnicas quirúrgicas y procedimientos documentados en video de alta calidad.</p>
				<p class="ciru-bento__meta">Alta definición</p>
			</div>

			<!-- Celda plain -->
			<div class="ciru-bento__cell ciru-bento__cell--plain">
				<div class="ciru-bento__icon">
					<span class="material-symbols-outlined">emoji_events</span>
				</div>
				<h3 class="ciru-bento__title">Premio Fórum</h3>
				<p class="ciru-bento__desc">Premio especial al mejor trabajo presentado en el fórum de discusión científica.</p>
				<p class="ciru-bento__meta">Premio especial</p>
			</div>

			<!-- Celda accent (span 2 cols, row horizontal) -->
			<a href="<?php echo esc_url( $bases_url ); ?>" class="ciru-bento__cell ciru-bento__cell--accent">
				<div>
					<p class="ciru-bento__meta">Premio máximo</p>
					<h3 class="ciru-bento__title">Premio Ardao</h3>
					<p class="ciru-bento__desc" style="margin:0;">Máximo reconocimiento del congreso al mejor trabajo de investigación científica original.</p>
				</div>
				<span class="material-symbols-outlined ciru-bento__arrow">arrow_forward</span>
			</a>

		</div>

	</div>
</section>
