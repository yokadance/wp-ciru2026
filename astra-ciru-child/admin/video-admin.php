<?php
/**
 * Panel para configurar video destacado del congreso
 * wp-admin → Apariencia → Video Destacado
 */
defined( 'ABSPATH' ) || exit;

// Agregar menú
add_action( 'admin_menu', 'congreso_video_menu' );
function congreso_video_menu() {
	add_theme_page(
		'Video Destacado',
		'Video Destacado',
		'edit_theme_options',
		'congreso-video',
		'congreso_video_page'
	);
}

// Guardar datos
add_action( 'admin_init', 'congreso_save_video' );
function congreso_save_video() {
	if ( ! isset( $_POST['congreso_video_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( $_POST['congreso_video_nonce'], 'congreso_save_video' ) ) {
		return;
	}

	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	$video_url = esc_url_raw( $_POST['congreso_video_url'] ?? '' );
	$video_titulo = sanitize_text_field( $_POST['congreso_video_titulo'] ?? '' );
	$video_descripcion = sanitize_textarea_field( $_POST['congreso_video_descripcion'] ?? '' );

	update_option( 'congreso_video_url', $video_url );
	update_option( 'congreso_video_titulo', $video_titulo );
	update_option( 'congreso_video_descripcion', $video_descripcion );

	add_settings_error(
		'congreso_video',
		'congreso_video_saved',
		'✅ Video actualizado correctamente',
		'success'
	);
}

// Página del admin
function congreso_video_page() {
	$video_url = get_option( 'congreso_video_url', '' );
	$video_titulo = get_option( 'congreso_video_titulo', 'Video Promocional del Congreso' );
	$video_descripcion = get_option( 'congreso_video_descripcion', 'Conocé más sobre el evento del año' );
	?>
	<div class="wrap">
		<h1>🎬 Configurar Video Destacado</h1>

		<?php settings_errors( 'congreso_video' ); ?>

		<div style="background: #fff; padding: 20px; border: 1px solid #ccc; border-radius: 4px; margin: 20px 0;">
			<h2>📝 Instrucciones</h2>
			<ul>
				<li>✅ Soporta videos de YouTube y Vimeo</li>
				<li>✅ Pegá la URL completa del video (ej: https://www.youtube.com/watch?v=XXXXX)</li>
				<li>✅ El video se mostrará en la página principal del sitio</li>
				<li>⚠️ Si dejás la URL vacía, no se mostrará ningún video</li>
			</ul>
		</div>

		<form method="post" action="" style="background: #fff; padding: 20px; border: 1px solid #ccc; border-radius: 4px;">
			<?php wp_nonce_field( 'congreso_save_video', 'congreso_video_nonce' ); ?>

			<table class="form-table" role="presentation">
				<tr>
					<th scope="row">
						<label for="congreso_video_url">URL del Video</label>
					</th>
					<td>
						<input
							type="url"
							id="congreso_video_url"
							name="congreso_video_url"
							value="<?php echo esc_attr( $video_url ); ?>"
							class="regular-text"
							placeholder="https://www.youtube.com/watch?v=..."
						>
						<p class="description">
							URL completa del video de YouTube o Vimeo
						</p>
					</td>
				</tr>

				<tr>
					<th scope="row">
						<label for="congreso_video_titulo">Título</label>
					</th>
					<td>
						<input
							type="text"
							id="congreso_video_titulo"
							name="congreso_video_titulo"
							value="<?php echo esc_attr( $video_titulo ); ?>"
							class="regular-text"
						>
						<p class="description">
							Título que aparece arriba del video
						</p>
					</td>
				</tr>

				<tr>
					<th scope="row">
						<label for="congreso_video_descripcion">Descripción</label>
					</th>
					<td>
						<textarea
							id="congreso_video_descripcion"
							name="congreso_video_descripcion"
							rows="3"
							class="large-text"
						><?php echo esc_textarea( $video_descripcion ); ?></textarea>
						<p class="description">
							Descripción breve del video
						</p>
					</td>
				</tr>
			</table>

			<p class="submit">
				<button type="submit" class="button button-primary button-large">
					💾 Guardar Configuración
				</button>
			</p>
		</form>

		<?php if ( ! empty( $video_url ) ) : ?>
			<div style="background: #e7f5ff; padding: 15px; border-left: 4px solid #1976d2; margin-top: 20px;">
				<h3>👁️ Vista previa</h3>
				<p><strong>URL actual:</strong> <?php echo esc_html( $video_url ); ?></p>
				<p><strong>Título:</strong> <?php echo esc_html( $video_titulo ); ?></p>
				<p><strong>Descripción:</strong> <?php echo esc_html( $video_descripcion ); ?></p>
			</div>
		<?php endif; ?>
	</div>
	<?php
}
