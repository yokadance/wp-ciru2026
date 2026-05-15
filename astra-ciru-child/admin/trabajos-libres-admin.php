<?php
/**
 * Panel para editar trabajos libres y reglamentos
 * wp-admin → Apariencia → Trabajos Libres
 */
defined( 'ABSPATH' ) || exit;

// Agregar menú
add_action( 'admin_menu', 'congreso_trabajos_libres_menu' );
function congreso_trabajos_libres_menu() {
	add_theme_page(
		'Trabajos Libres',
		'Trabajos Libres',
		'edit_theme_options',
		'congreso-trabajos-libres',
		'congreso_trabajos_libres_page'
	);
}

// Guardar datos
add_action( 'admin_init', 'congreso_save_trabajos_libres' );
function congreso_save_trabajos_libres() {
	if ( ! isset( $_POST['congreso_trabajos_libres_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( $_POST['congreso_trabajos_libres_nonce'], 'congreso_save_trabajos_libres' ) ) {
		return;
	}

	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	// Guardar reglamentos
	$json_input = wp_unslash( $_POST['congreso_trabajos_libres_json'] ?? '' );
	$trabajos_data = json_decode( $json_input, true );

	if ( json_last_error() === JSON_ERROR_NONE ) {
		update_option( 'congreso_trabajos_libres_data', $trabajos_data );
	}

	// Guardar URL de postulación
	$url_postulacion = esc_url_raw( $_POST['congreso_url_postulacion'] ?? '' );
	update_option( 'congreso_url_postulacion', $url_postulacion );

	add_settings_error(
		'congreso_trabajos_libres',
		'congreso_trabajos_libres_saved',
		'✅ Trabajos Libres actualizado correctamente',
		'success'
	);
}

// Página del admin
function congreso_trabajos_libres_page() {
	// Obtener datos actuales
	$trabajos_data = get_option( 'congreso_trabajos_libres_data', [] );
	$url_postulacion = get_option( 'congreso_url_postulacion', '#contacto' );

	// Si está vacío, proporcionar datos de ejemplo
	if ( empty( $trabajos_data ) ) {
		$trabajos_data = [
			'cirugia' => [
				'titulo' => 'Cirugía & Residentes',
				'items' => [
					'Los trabajos deben enviarse en formato digital',
					'Fecha límite: 15 de junio de 2026',
					'Extensión máxima: 300 palabras',
					'Se aceptan trabajos originales e inéditos'
				]
			],
			'enfermeria' => [
				'titulo' => 'Enfermería',
				'items' => [
					'Los trabajos deben enviarse en formato digital',
					'Fecha límite: 15 de junio de 2026',
					'Extensión máxima: 300 palabras',
					'Se aceptan trabajos originales e inéditos'
				]
			],
			'instrumentacion' => [
				'titulo' => 'Instrumentación',
				'items' => [
					'Los trabajos deben enviarse en formato digital',
					'Fecha límite: 15 de junio de 2026',
					'Extensión máxima: 300 palabras',
					'Se aceptan trabajos originales e inéditos'
				]
			]
		];
	}

	$json_string = json_encode( $trabajos_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE );
	?>
	<div class="wrap">
		<h1>📄 Editar Trabajos Libres</h1>

		<?php settings_errors( 'congreso_trabajos_libres' ); ?>

		<div style="background: #fff; padding: 20px; border: 1px solid #ccc; border-radius: 4px; margin: 20px 0;">
			<h2>📝 Instrucciones</h2>
			<ul>
				<li>✅ Edita los reglamentos para cada área (cirugía, enfermería, instrumentación)</li>
				<li>✅ Puedes agregar o quitar items de cada reglamento</li>
				<li>✅ Configura la URL del sistema de postulación (aplica para todas las áreas)</li>
				<li>⚠️ Asegúrate de que el JSON sea válido</li>
			</ul>

			<h3>Estructura del JSON:</h3>
			<pre style="background: #f5f5f5; padding: 10px; border-radius: 4px;">{
  "cirugia": {
    "titulo": "Cirugía & Residentes",
    "items": [
      "Los trabajos deben enviarse en formato digital",
      "Fecha límite: 15 de junio de 2026"
    ]
  },
  "enfermeria": { ... },
  "instrumentacion": { ... }
}</pre>
		</div>

		<form method="post" action="">
			<?php wp_nonce_field( 'congreso_save_trabajos_libres', 'congreso_trabajos_libres_nonce' ); ?>

			<h2>🔗 URL de Postulación</h2>
			<p>URL del sistema de postulación (aplica para todas las áreas)</p>
			<input
				type="url"
				name="congreso_url_postulacion"
				value="<?php echo esc_attr( $url_postulacion ); ?>"
				class="regular-text"
				placeholder="https://..."
				style="width: 100%; max-width: 600px; padding: 8px; font-size: 14px; margin-bottom: 2rem;"
			>

			<h2>📋 JSON de Reglamentos</h2>
			<p>Edita los reglamentos de cada área. Los cambios se aplican inmediatamente al guardar.</p>

			<textarea
				name="congreso_trabajos_libres_json"
				rows="30"
				style="width: 100%; font-family: monospace; font-size: 14px; padding: 10px;"
			><?php echo esc_textarea( $json_string ); ?></textarea>

			<p>
				<button type="submit" class="button button-primary button-large">
					💾 Guardar Trabajos Libres
				</button>
			</p>
		</form>
	</div>
	<?php
}
