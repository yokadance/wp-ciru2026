<?php
/**
 * Panel para editar comités organizador y científico
 * wp-admin → Apariencia → Comités
 */
defined( 'ABSPATH' ) || exit;

// Agregar menú
add_action( 'admin_menu', 'congreso_comites_menu' );
function congreso_comites_menu() {
	add_theme_page(
		'Comités',
		'Comités',
		'edit_theme_options',
		'congreso-comites',
		'congreso_comites_page'
	);
}

// Guardar datos
add_action( 'admin_init', 'congreso_save_comites' );
function congreso_save_comites() {
	if ( ! isset( $_POST['congreso_comites_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( $_POST['congreso_comites_nonce'], 'congreso_save_comites' ) ) {
		return;
	}

	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	$json_input = wp_unslash( $_POST['congreso_comites_json'] ?? '' );
	$comites_data = json_decode( $json_input, true );

	if ( json_last_error() === JSON_ERROR_NONE ) {
		update_option( 'congreso_comites_data', $comites_data );
		add_settings_error(
			'congreso_comites',
			'congreso_comites_saved',
			'✅ Comités actualizados correctamente',
			'success'
		);
	} else {
		add_settings_error(
			'congreso_comites',
			'congreso_comites_error',
			'❌ Error en el JSON: ' . json_last_error_msg(),
			'error'
		);
	}
}

// Página del admin
function congreso_comites_page() {
	// Obtener datos actuales
	$comites_data = get_option( 'congreso_comites_data', [] );

	// Si está vacío, proporcionar datos de ejemplo
	if ( empty( $comites_data ) ) {
		$comites_data = [
			'cirugia' => [
				'organizador' => [
					[
						'nombre' => 'Juan',
						'apellido' => 'Pérez',
						'cargo' => 'Presidente del Comité',
						'foto' => ''
					],
					[
						'nombre' => 'María',
						'apellido' => 'González',
						'cargo' => 'Secretaria',
						'foto' => ''
					]
				],
				'cientifico' => [
					[
						'nombre' => 'Carlos',
						'apellido' => 'Rodríguez',
						'cargo' => 'Coordinador Científico',
						'foto' => ''
					]
				]
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

	$json_string = json_encode( $comites_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE );
	?>
	<div class="wrap">
		<h1>👥 Editar Comités</h1>

		<?php settings_errors( 'congreso_comites' ); ?>

		<div style="background: #fff; padding: 20px; border: 1px solid #ccc; border-radius: 4px; margin: 20px 0;">
			<h2>📝 Instrucciones</h2>
			<ul>
				<li>✅ Edita los comités para cada área (cirugía, enfermería, instrumentación)</li>
				<li>✅ Cada área tiene dos comités: organizador y científico</li>
				<li>✅ Puedes agregar todos los miembros que quieras en cada comité</li>
				<li>✅ El campo <code>foto</code> debe ser la URL completa de la imagen</li>
				<li>⚠️ Asegúrate de que el JSON sea válido</li>
			</ul>

			<h3>Estructura del JSON:</h3>
			<pre style="background: #f5f5f5; padding: 10px; border-radius: 4px;">{
  "cirugia": {
    "organizador": [
      {
        "nombre": "Juan",
        "apellido": "Pérez",
        "cargo": "Presidente",
        "foto": "https://ejemplo.com/foto.jpg"
      }
    ],
    "cientifico": [ ... ]
  },
  "enfermeria": { ... },
  "instrumentacion": { ... }
}</pre>

			<h3>💡 Cómo subir fotos:</h3>
			<ol>
				<li>Ve a <strong>Medios → Añadir nuevo</strong></li>
				<li>Sube la foto del miembro</li>
				<li>Copia la URL del archivo</li>
				<li>Pega la URL en el campo <code>"foto"</code> del JSON</li>
			</ol>
		</div>

		<form method="post" action="">
			<?php wp_nonce_field( 'congreso_save_comites', 'congreso_comites_nonce' ); ?>

			<h2>📋 JSON de Comités</h2>
			<p>Edita los comités de cada área. Los cambios se aplican inmediatamente al guardar.</p>

			<textarea
				name="congreso_comites_json"
				rows="30"
				style="width: 100%; font-family: monospace; font-size: 14px; padding: 10px;"
			><?php echo esc_textarea( $json_string ); ?></textarea>

			<p>
				<button type="submit" class="button button-primary button-large">
					💾 Guardar Comités
				</button>
			</p>
		</form>

		<div style="background: #fffbcc; padding: 15px; border-left: 4px solid #ffeb3b; margin-top: 20px;">
			<h3>💡 Tip: Campos disponibles</h3>
			<ul>
				<li><strong>nombre</strong> (requerido): Nombre del miembro</li>
				<li><strong>apellido</strong> (requerido): Apellido del miembro</li>
				<li><strong>cargo</strong> (opcional): Cargo o rol en el comité</li>
				<li><strong>foto</strong> (opcional): URL de la foto del miembro</li>
			</ul>
		</div>
	</div>
	<?php
}
