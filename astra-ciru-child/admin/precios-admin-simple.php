<?php
/**
 * Panel simple para editar precios con JSON
 * wp-admin → Apariencia → Editar Precios
 */
defined( 'ABSPATH' ) || exit;

// Agregar menú
add_action( 'admin_menu', 'congreso_precios_menu' );
function congreso_precios_menu() {
	add_theme_page(
		'Editar Precios',
		'Editar Precios',
		'edit_theme_options',
		'congreso-precios',
		'congreso_precios_page'
	);
}

// Guardar datos
add_action( 'admin_init', 'congreso_save_precios' );
function congreso_save_precios() {
	if ( ! isset( $_POST['congreso_precios_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( $_POST['congreso_precios_nonce'], 'congreso_save_precios' ) ) {
		return;
	}

	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	$json_input = wp_unslash( $_POST['congreso_precios_json'] ?? '' );
	$precios_data = json_decode( $json_input, true );

	if ( json_last_error() === JSON_ERROR_NONE ) {
		update_option( 'congreso_precios_data', $precios_data );
		add_settings_error(
			'congreso_precios',
			'congreso_precios_saved',
			'✅ Precios actualizados correctamente',
			'success'
		);
	} else {
		add_settings_error(
			'congreso_precios',
			'congreso_precios_error',
			'❌ Error en el JSON: ' . json_last_error_msg(),
			'error'
		);
	}
}

// Página del admin
function congreso_precios_page() {
	// Obtener datos actuales
	$precios_data = get_option( 'congreso_precios_data', [] );

	// Si está vacío, importar del JSON
	if ( empty( $precios_data ) ) {
		$json_file = get_stylesheet_directory() . '/precios-config.json';
		if ( file_exists( $json_file ) ) {
			$json_content = file_get_contents( $json_file );
			$precios_data = json_decode( $json_content, true );
		}
	}

	$json_string = json_encode( $precios_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE );
	?>
	<div class="wrap">
		<h1>💰 Editar Precios del Congreso</h1>

		<?php settings_errors( 'congreso_precios' ); ?>

		<div style="background: #fff; padding: 20px; border: 1px solid #ccc; border-radius: 4px; margin: 20px 0;">
			<h2>📝 Instrucciones</h2>
			<ul>
				<li>✅ Edita el JSON abajo para agregar/eliminar/modificar precios</li>
				<li>✅ Cada sección (<code>cirugia</code>, <code>enfermeria</code>, <code>instrumentacion</code>) es un array</li>
				<li>✅ Puedes agregar todos los precios que quieras en cada sección</li>
				<li>⚠️ Asegúrate de que el JSON sea válido (usa <a href="https://jsonlint.com" target="_blank">jsonlint.com</a> si tienes dudas)</li>
			</ul>

			<h3>Ejemplo de precio:</h3>
			<pre style="background: #f5f5f5; padding: 10px; border-radius: 4px;">{
  "titulo": "Profesional",
  "subtitulo": "Enfermeros/as en ejercicio",
  "precio": "3000",
  "moneda": "UYU",
  "periodo": "precio anticipado",
  "precio_regular": "3500",
  "featured": false,
  "badge": null,
  "features": [
    "Acceso a todas las jornadas",
    "Material científico digital",
    "Coffee breaks incluidos",
    "Certificado de asistencia"
  ],
  "href": "#contacto"
}</pre>
		</div>

		<form method="post" action="">
			<?php wp_nonce_field( 'congreso_save_precios', 'congreso_precios_nonce' ); ?>

			<h2>📋 JSON de Precios</h2>
			<p>Edita el JSON directamente. Los cambios se aplican inmediatamente al guardar.</p>

			<textarea
				name="congreso_precios_json"
				rows="30"
				style="width: 100%; font-family: monospace; font-size: 14px; padding: 10px;"
			><?php echo esc_textarea( $json_string ); ?></textarea>

			<p>
				<button type="submit" class="button button-primary button-large">
					💾 Guardar Precios
				</button>
			</p>
		</form>

		<div style="background: #fffbcc; padding: 15px; border-left: 4px solid #ffeb3b; margin-top: 20px;">
			<h3>💡 Tip: Validar JSON antes de guardar</h3>
			<p>
				1. Copia todo el contenido del textarea<br>
				2. Ve a <a href="https://jsonlint.com" target="_blank">jsonlint.com</a><br>
				3. Pega y haz clic en "Validate JSON"<br>
				4. Si hay errores, corrígelos antes de guardar aquí
			</p>
		</div>
	</div>
	<?php
}
