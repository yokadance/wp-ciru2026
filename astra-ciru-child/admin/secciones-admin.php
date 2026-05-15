<?php
/**
 * Panel para activar/desactivar secciones del home
 * wp-admin → Apariencia → Secciones del Home
 */
defined( 'ABSPATH' ) || exit;

// Agregar menú
add_action( 'admin_menu', 'congreso_secciones_menu' );
function congreso_secciones_menu() {
	add_theme_page(
		'Secciones del Home',
		'Secciones del Home',
		'edit_theme_options',
		'congreso-secciones',
		'congreso_secciones_page'
	);
}

// Guardar datos
add_action( 'admin_init', 'congreso_save_secciones' );
function congreso_save_secciones() {
	if ( ! isset( $_POST['congreso_secciones_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( $_POST['congreso_secciones_nonce'], 'congreso_save_secciones' ) ) {
		return;
	}

	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	// Guardar estado de cada sección
	$secciones_activas = $_POST['secciones_activas'] ?? [];
	update_option( 'congreso_secciones_activas', $secciones_activas );

	// Guardar orden de secciones
	$orden = $_POST['secciones_orden'] ?? '';
	if ( ! empty( $orden ) ) {
		$orden_array = explode( ',', $orden );
		update_option( 'congreso_secciones_orden', $orden_array );
	}

	add_settings_error(
		'congreso_secciones',
		'congreso_secciones_saved',
		'✅ Secciones actualizadas correctamente',
		'success'
	);
}

// Página del admin
function congreso_secciones_page() {
	// Secciones disponibles
	$secciones_disponibles = [
		'hero' => [
			'nombre' => 'Hero / Portada',
			'descripcion' => 'Banner principal con imagen y título',
			'siempre_activo' => true
		],
		'countdown' => [
			'nombre' => 'Contador Regresivo',
			'descripcion' => 'Cuenta regresiva hasta el evento'
		],
		'bienvenida' => [
			'nombre' => 'Bienvenida',
			'descripcion' => 'Mensaje de bienvenida con texto destacado'
		],
		'timeline' => [
			'nombre' => 'Línea de Tiempo',
			'descripcion' => 'Cronograma de fechas importantes'
		],
		'video-destacado' => [
			'nombre' => 'Video Destacado',
			'descripcion' => 'Video promocional del congreso'
		],
		'precios' => [
			'nombre' => 'Inscripciones / Precios',
			'descripcion' => 'Tabla de precios con tabs por área'
		],
		'trabajos-libres' => [
			'nombre' => 'Trabajos Libres',
			'descripcion' => 'Reglamentos para presentación de trabajos'
		],
		'comites' => [
			'nombre' => 'Comités',
			'descripcion' => 'Comités organizador y científico'
		],
		'hoteleria' => [
			'nombre' => 'Hotelería',
			'descripcion' => 'Hoteles disponibles para el congreso'
		],
		'autoridades' => [
			'nombre' => 'Autoridades',
			'descripcion' => 'Miembros destacados de la organización'
		],
		'ubicacion' => [
			'nombre' => 'Ubicación',
			'descripcion' => 'Mapa y dirección del evento'
		],
		'contacto' => [
			'nombre' => 'Contacto',
			'descripcion' => 'Formulario de contacto'
		]
	];

	// Obtener configuración actual
	$secciones_activas = get_option( 'congreso_secciones_activas', array_keys( $secciones_disponibles ) );
	$orden_guardado = get_option( 'congreso_secciones_orden', array_keys( $secciones_disponibles ) );

	// Asegurar que el orden incluya todas las secciones
	$orden = [];
	foreach ( $orden_guardado as $id ) {
		if ( isset( $secciones_disponibles[ $id ] ) ) {
			$orden[] = $id;
		}
	}
	// Agregar secciones nuevas que no estén en el orden guardado
	foreach ( array_keys( $secciones_disponibles ) as $id ) {
		if ( ! in_array( $id, $orden ) ) {
			$orden[] = $id;
		}
	}

	?>
	<div class="wrap">
		<h1>⚙️ Gestionar Secciones del Home</h1>

		<?php settings_errors( 'congreso_secciones' ); ?>

		<div style="background: #fff; padding: 20px; border: 1px solid #ccc; border-radius: 4px; margin: 20px 0;">
			<h2>📝 Instrucciones</h2>
			<ul>
				<li>✅ Activá o desactivá las secciones que querés mostrar en el home</li>
				<li>✅ Arrastrá las secciones para cambiar el orden en que aparecen</li>
				<li>✅ Los cambios se aplican inmediatamente al guardar</li>
				<li>⚠️ La sección "Hero / Portada" siempre está activa</li>
			</ul>
		</div>

		<form method="post" action="">
			<?php wp_nonce_field( 'congreso_save_secciones', 'congreso_secciones_nonce' ); ?>

			<div style="background: #fff; padding: 20px; border: 1px solid #ccc; border-radius: 4px;">
				<h2>🎛️ Secciones Disponibles</h2>
				<p style="color: #666; margin-bottom: 20px;">
					Marcá las secciones que querés mostrar. Arrastrá para reordenar.
				</p>

				<input type="hidden" name="secciones_orden" id="secciones_orden" value="">

				<div id="secciones-list" style="display: flex; flex-direction: column; gap: 10px;">
					<?php foreach ( $orden as $id ) :
						$seccion = $secciones_disponibles[ $id ];
						$activa = in_array( $id, $secciones_activas );
						$disabled = ! empty( $seccion['siempre_activo'] );
						?>
						<div class="seccion-item" data-id="<?php echo esc_attr( $id ); ?>"
						     style="background: #f9f9f9; padding: 15px; border: 1px solid #ddd; border-radius: 4px; cursor: move; display: flex; align-items: center; gap: 15px;">

							<span style="font-size: 20px; color: #999;">☰</span>

							<label style="flex: 1; display: flex; align-items: center; gap: 10px; cursor: pointer; margin: 0;">
								<input type="checkbox"
								       name="secciones_activas[]"
								       value="<?php echo esc_attr( $id ); ?>"
								       <?php checked( $activa || $disabled ); ?>
								       <?php disabled( $disabled ); ?>
								       style="width: 20px; height: 20px;">
								<div style="flex: 1;">
									<strong style="font-size: 15px; display: block; margin-bottom: 3px;">
										<?php echo esc_html( $seccion['nombre'] ); ?>
										<?php if ( $disabled ) : ?>
											<span style="color: #999; font-weight: normal; font-size: 12px;">(siempre activo)</span>
										<?php endif; ?>
									</strong>
									<span style="color: #666; font-size: 13px;">
										<?php echo esc_html( $seccion['descripcion'] ); ?>
									</span>
								</div>
							</label>
						</div>
					<?php endforeach; ?>
				</div>
			</div>

			<p style="margin-top: 20px;">
				<button type="submit" class="button button-primary button-large">
					💾 Guardar Configuración
				</button>
			</p>
		</form>
	</div>

	<script>
	// Drag and drop simple
	(function() {
		const list = document.getElementById('secciones-list');
		const input = document.getElementById('secciones_orden');
		let draggedItem = null;

		// Actualizar orden en el input hidden
		function updateOrder() {
			const items = list.querySelectorAll('.seccion-item');
			const order = Array.from(items).map(item => item.dataset.id);
			input.value = order.join(',');
		}

		// Configurar drag and drop
		list.querySelectorAll('.seccion-item').forEach(item => {
			item.draggable = true;

			item.addEventListener('dragstart', function(e) {
				draggedItem = this;
				this.style.opacity = '0.5';
			});

			item.addEventListener('dragend', function(e) {
				this.style.opacity = '1';
			});

			item.addEventListener('dragover', function(e) {
				e.preventDefault();
				if (this === draggedItem) return;

				const rect = this.getBoundingClientRect();
				const midpoint = rect.top + rect.height / 2;

				if (e.clientY < midpoint) {
					list.insertBefore(draggedItem, this);
				} else {
					list.insertBefore(draggedItem, this.nextSibling);
				}
				updateOrder();
			});
		});

		// Inicializar orden
		updateOrder();
	})();
	</script>

	<style>
	.seccion-item:hover {
		background: #f0f0f0 !important;
		border-color: #45D8ED !important;
	}
	.seccion-item.dragging {
		opacity: 0.5;
	}
	</style>
	<?php
}
