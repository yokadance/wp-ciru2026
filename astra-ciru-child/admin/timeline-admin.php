<?php
/**
 * Panel simple para editar línea de tiempo con JSON
 * wp-admin → Apariencia → Línea de Tiempo
 */
defined( 'ABSPATH' ) || exit;

// Agregar menú
add_action( 'admin_menu', 'congreso_timeline_menu' );
function congreso_timeline_menu() {
	add_theme_page(
		'Línea de Tiempo',
		'Línea de Tiempo',
		'edit_theme_options',
		'congreso-timeline',
		'congreso_timeline_page'
	);
}

// Guardar datos
add_action( 'admin_init', 'congreso_save_timeline' );
function congreso_save_timeline() {
	if ( ! isset( $_POST['congreso_timeline_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( $_POST['congreso_timeline_nonce'], 'congreso_save_timeline' ) ) {
		return;
	}

	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	$json_input = wp_unslash( $_POST['congreso_timeline_json'] ?? '' );
	$timeline_data = json_decode( $json_input, true );

	if ( json_last_error() === JSON_ERROR_NONE ) {
		update_option( 'congreso_timeline_data', $timeline_data );
		add_settings_error(
			'congreso_timeline',
			'congreso_timeline_saved',
			'✅ Línea de tiempo actualizada correctamente',
			'success'
		);
	} else {
		add_settings_error(
			'congreso_timeline',
			'congreso_timeline_error',
			'❌ Error en el JSON: ' . json_last_error_msg(),
			'error'
		);
	}
}

// Página del admin
function congreso_timeline_page() {
	// Obtener datos actuales
	$timeline_data = get_option( 'congreso_timeline_data', [] );

	// Si está vacío, proporcionar datos de ejemplo
	if ( empty( $timeline_data ) ) {
		$timeline_data = [
			[
				'fecha' => '15 Mayo 2026',
				'titulo' => 'Apertura de Inscripciones',
				'descripcion' => 'Comienzan las inscripciones anticipadas con precios especiales',
				'destacado' => false
			],
			[
				'fecha' => '15 Junio 2026',
				'titulo' => 'Cierre Trabajos Libres',
				'descripcion' => 'Fecha límite para presentación de trabajos científicos',
				'destacado' => true
			],
			[
				'fecha' => '15 Sept 2026',
				'titulo' => 'Congreso de Cirugía',
				'descripcion' => 'Inicio del 76º Congreso Uruguayo de Cirugía',
				'destacado' => true
			]
		];
	}

	$json_string = json_encode( $timeline_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE );
	?>
	<div class="wrap">
		<h1>📅 Editar Línea de Tiempo</h1>

		<?php settings_errors( 'congreso_timeline' ); ?>

		<div style="background: #fff; padding: 20px; border: 1px solid #ccc; border-radius: 4px; margin: 20px 0;">
			<h2>📝 Instrucciones</h2>
			<ul>
				<li>✅ Edita el JSON abajo para agregar/eliminar/modificar eventos</li>
				<li>✅ Puedes agregar hasta 15 eventos en la línea de tiempo</li>
				<li>✅ Los eventos se muestran en orden de aparición en el array</li>
				<li>✅ El campo <code>destacado</code> marca eventos importantes (true/false)</li>
				<li>⚠️ Asegúrate de que el JSON sea válido</li>
			</ul>

			<h3>Ejemplo de evento:</h3>
			<pre style="background: #f5f5f5; padding: 10px; border-radius: 4px;">{
  "fecha": "15 Mayo 2026",
  "titulo": "Apertura de Inscripciones",
  "descripcion": "Comienzan las inscripciones anticipadas",
  "destacado": false
}</pre>
		</div>

		<form method="post" action="">
			<?php wp_nonce_field( 'congreso_save_timeline', 'congreso_timeline_nonce' ); ?>

			<h2>📋 JSON de Línea de Tiempo</h2>
			<p>Edita el JSON directamente. Los cambios se aplican inmediatamente al guardar.</p>

			<textarea
				name="congreso_timeline_json"
				rows="30"
				style="width: 100%; font-family: monospace; font-size: 14px; padding: 10px;"
			><?php echo esc_textarea( $json_string ); ?></textarea>

			<p>
				<button type="submit" class="button button-primary button-large">
					💾 Guardar Línea de Tiempo
				</button>
			</p>
		</form>

		<div style="background: #fffbcc; padding: 15px; border-left: 4px solid #ffeb3b; margin-top: 20px;">
			<h3>💡 Tip: Campos disponibles</h3>
			<ul>
				<li><strong>fecha</strong> (requerido): Fecha del evento (ej: "15 Mayo 2026")</li>
				<li><strong>titulo</strong> (requerido): Nombre del evento</li>
				<li><strong>descripcion</strong> (opcional): Descripción breve del evento</li>
				<li><strong>destacado</strong> (opcional): true para eventos importantes, false para normales</li>
			</ul>
		</div>
	</div>
	<?php
}
