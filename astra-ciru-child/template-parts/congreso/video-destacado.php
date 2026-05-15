<?php
/**
 * Módulo: Video Destacado del Congreso
 * Muestra un video promocional en una sección destacada
 */
defined( 'ABSPATH' ) || exit;

// Obtener URL del video (YouTube o Vimeo)
$video_url = get_option( 'congreso_video_url', '' );
$video_titulo = get_option( 'congreso_video_titulo', 'Video Promocional del Congreso' );
$video_descripcion = get_option( 'congreso_video_descripcion', 'Conocé más sobre el evento del año' );

// Si no hay video configurado, no mostrar nada
if ( empty( $video_url ) ) {
	return;
}

// Extraer ID del video según plataforma
$video_embed = '';
if ( preg_match( '/youtube\.com\/watch\?v=([^&]+)/', $video_url, $matches ) ||
     preg_match( '/youtu\.be\/([^?]+)/', $video_url, $matches ) ) {
	// YouTube
	$video_id = $matches[1];
	$video_embed = "https://www.youtube.com/embed/{$video_id}?rel=0&modestbranding=1";
} elseif ( preg_match( '/vimeo\.com\/(\d+)/', $video_url, $matches ) ) {
	// Vimeo
	$video_id = $matches[1];
	$video_embed = "https://player.vimeo.com/video/{$video_id}?title=0&byline=0";
}
?>

<section class="ciru-section ciru-video-destacado" id="video">
	<div class="ciru-container">
		<div class="ciru-video-destacado__wrapper">

			<div class="ciru-video-destacado__content">
				<span class="ciru-eyebrow ciru-eyebrow--accent">Video Exclusivo</span>
				<h2 class="ciru-section-title"><?php echo esc_html( $video_titulo ); ?></h2>
				<p class="ciru-video-destacado__description">
					<?php echo esc_html( $video_descripcion ); ?>
				</p>
			</div>

			<div class="ciru-video-destacado__player">
				<?php if ( ! empty( $video_embed ) ) : ?>
					<div class="ciru-video-destacado__frame">
						<iframe
							src="<?php echo esc_url( $video_embed ); ?>"
							frameborder="0"
							allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
							allowfullscreen
							loading="lazy"
						></iframe>
					</div>
				<?php else : ?>
					<!-- Placeholder si no se puede embeber -->
					<div class="ciru-video-destacado__placeholder">
						<span class="material-symbols-outlined">play_circle</span>
						<p>Video no disponible</p>
					</div>
				<?php endif; ?>
			</div>

		</div>
	</div>
</section>
