<?php
/**
 * Panel simple para editar hoteler ya con JSON
 * wp-admin → Apariencia → Hotelería
 */
defined( 'ABSPATH' ) || exit;

// Agregar menú
add_action( 'admin_menu', 'congreso_hoteleria_menu' );
function congreso_hoteleria_menu() {
	add_theme_page(
		'Hotelería',
		'Hotelería',
		'edit_theme_options',
		'congreso-hoteleria',
		'congreso_hoteleria_page'
	);
}

// Guardar datos
add_action( 'admin_init', 'congreso_save_hoteleria' );
function congreso_save_hoteleria() {
	if ( ! isset( $_POST['congreso_hoteleria_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( $_POST['congreso_hoteleria_nonce'], 'congreso_save_hoteleria' ) ) {
		return;
	}

	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	$json_input = wp_unslash( $_POST['congreso_hoteleria_json'] ?? '' );
	$hoteleria_data = json_decode( $json_input, true );

	if ( json_last_error() === JSON_ERROR_NONE ) {
		update_option( 'congreso_hoteles_data', $hoteleria_data );
		add_settings_error(
			'congreso_hoteleria',
			'congreso_hoteleria_saved',
			'✅ Hotelería actualizada correctamente',
			'success'
		);
	} else {
		add_settings_error(
			'congreso_hoteleria',
			'congreso_hoteleria_error',
			'❌ Error en el JSON: ' . json_last_error_msg(),
			'error'
		);
	}
}

// Página del admin
function congreso_hoteleria_page() {
	// Obtener datos actuales
	$hoteleria_data = get_option( 'congreso_hoteles_data', [] );

	// Si está vacío, proporcionar datos de ejemplo
	if ( empty( $hoteleria_data ) ) {
		$hoteleria_data = [
			[
				'nombre' => 'The Grand',
				'descripcion' => 'Hotel de lujo en el centro de Montevideo',
				'direccion' => 'Dirección a confirmar',
				'precio' => 'Precio a confirmar',
				'amenities' => [
					'Wi-Fi gratuito',
					'Desayuno incluido',
					'Gimnasio',
					'Spa',
					'Estacionamiento'
				],
				'contacto' => '',
				'destacado' => true
			],
			[
				'nombre' => 'La Capilla',
				'descripcion' => 'Hotel boutique con encanto histórico',
				'direccion' => 'Dirección a confirmar',
				'precio' => 'Precio a confirmar',
				'amenities' => [
					'Wi-Fi gratuito',
					'Desayuno incluido',
					'Bar',
					'Restaurante'
				],
				'contacto' => '',
				'destacado' => false
			]
		];
	}

	$json_string = json_encode( $hoteleria_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE );
	?>
	<div class="wrap">
		<h1>🏨 Editar Hotelería</h1>

		<?php settings_errors( 'congreso_hoteleria' ); ?>

		<div style="background: #fff; padding: 20px; border: 1px solid #ccc; border-radius: 4px; margin: 20px 0;">
			<h2>📝 Instrucciones</h2>
			<ul>
				<li>✅ Edita el JSON abajo para agregar/eliminar/modificar hoteles</li>
				<li>✅ Puedes agregar todos los hoteles que quieras</li>
				<li>✅ El campo <code>destacado</code> marca hoteles recomendados (true/false)</li>
				<li>✅ El campo <code>contacto</code> es la URL de reserva (opcional)</li>
				<li>⚠️ Asegúrate de que el JSON sea válido</li>
			</ul>

			<h3>Ejemplo de hotel:</h3>
			<pre style="background: #f5f5f5; padding: 10px; border-radius: 4px;">{
  "nombre": "The Grand",
  "descripcion": "Hotel de lujo en el centro",
  "direccion": "Av. 18 de Julio 1234",
  "precio": "USD 150 por noche",
  "amenities": [
    "Wi-Fi gratuito",
    "Desayuno incluido",
    "Gimnasio",
    "Spa"
  ],
  "contacto": "https://thegrand.com/reservas",
  "destacado": true
}</pre>
		</div>

		<form method="post" action="">
			<?php wp_nonce_field( 'congreso_save_hoteleria', 'congreso_hoteleria_nonce' ); ?>

			<h2>📋 JSON de Hotelería</h2>
			<p>Edita el JSON directamente. Los cambios se aplican inmediatamente al guardar.</p>

			<textarea
				name="congreso_hoteleria_json"
				rows="30"
				style="width: 100%; font-family: monospace; font-size: 14px; padding: 10px;"
			><?php echo esc_textarea( $json_string ); ?></textarea>

			<p>
				<button type="submit" class="button button-primary button-large">
					💾 Guardar Hotelería
				</button>
			</p>
		</form>

		<div style="background: #fffbcc; padding: 15px; border-left: 4px solid #ffeb3b; margin-top: 20px;">
			<h3>💡 Tip: Campos disponibles</h3>
			<ul>
				<li><strong>nombre</strong> (requerido): Nombre del hotel</li>
				<li><strong>descripcion</strong> (opcional): Descripción breve</li>
				<li><strong>direccion</strong> (opcional): Dirección del hotel</li>
				<li><strong>precio</strong> (opcional): Precio por noche</li>
				<li><strong>amenities</strong> (opcional): Array de servicios incluidos</li>
				<li><strong>contacto</strong> (opcional): URL para reservas</li>
				<li><strong>destacado</strong> (opcional): true para marcar como recomendado</li>
			</ul>
		</div>
	</div>
	<?php
}
