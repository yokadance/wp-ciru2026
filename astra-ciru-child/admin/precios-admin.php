<?php
/**
 * Panel de administración para configurar precios
 * Menú: Apariencia → Configuración del Congreso
 */
defined( 'ABSPATH' ) || exit;

// Agregar menú en wp-admin
add_action( 'admin_menu', 'congreso_add_admin_menu' );
function congreso_add_admin_menu() {
	add_theme_page(
		'Configuración del Congreso',
		'Configuración del Congreso',
		'edit_theme_options',
		'congreso-config',
		'congreso_config_page'
	);
}

// Registrar settings
add_action( 'admin_init', 'congreso_register_settings' );
function congreso_register_settings() {
	register_setting( 'congreso_precios_group', 'congreso_precios_data' );
}

// Página de configuración
function congreso_config_page() {
	// Valores por defecto
	$default_data = [
		'cirugia' => [
			[ 'titulo' => 'Socio SCC', 'subtitulo' => 'Socio activo de la SCC', 'precio' => '250', 'moneda' => 'USD', 'periodo' => 'precio anticipado', 'precio_regular' => '300', 'featured' => false, 'badge' => '' ],
			[ 'titulo' => 'No Socio', 'subtitulo' => 'Cirujanos no afiliados', 'precio' => '350', 'moneda' => 'USD', 'periodo' => 'precio regular', 'precio_regular' => '', 'featured' => true, 'badge' => 'Más elegido' ],
			[ 'titulo' => 'Residente', 'subtitulo' => 'XXXVI Jornadas de Residentes', 'precio' => '150', 'moneda' => 'USD', 'periodo' => 'precio especial', 'precio_regular' => '', 'featured' => false, 'badge' => '' ],
		],
		'enfermeria' => [
			[ 'titulo' => 'Profesional', 'subtitulo' => 'Enfermeros/as en ejercicio', 'precio' => '3000', 'moneda' => 'UYU', 'periodo' => 'precio anticipado', 'precio_regular' => '3500', 'featured' => false, 'badge' => '' ],
			[ 'titulo' => 'Estudiante', 'subtitulo' => 'Estudiantes de enfermería', 'precio' => '2000', 'moneda' => 'UYU', 'periodo' => 'precio especial', 'precio_regular' => '', 'featured' => true, 'badge' => '' ],
		],
		'instrumentacion' => [
			[ 'titulo' => 'Asociado AUIQ', 'subtitulo' => 'Miembro de AUIQ', 'precio' => '3000', 'moneda' => 'UYU', 'periodo' => 'precio anticipado', 'precio_regular' => '3500', 'featured' => false, 'badge' => '' ],
			[ 'titulo' => 'No Asociado', 'subtitulo' => 'Instrumentistas no afiliados', 'precio' => '4000', 'moneda' => 'UYU', 'periodo' => 'precio regular', 'precio_regular' => '', 'featured' => true, 'badge' => '' ],
		],
	];

	$data = get_option( 'congreso_precios_data', $default_data );
	?>
	<div class="wrap">
		<h1>⚙️ Configuración del Congreso</h1>
		<p>Editá los precios e información de inscripciones. Los cambios se aplican inmediatamente.</p>

		<form method="post" action="options.php">
			<?php settings_fields( 'congreso_precios_group' ); ?>

			<style>
				.congreso-admin-tabs { border-bottom: 1px solid #ccc; margin: 20px 0; }
				.congreso-admin-tabs button { background: #f0f0f1; border: 1px solid #ccc; border-bottom: none; padding: 10px 20px; margin-right: 5px; cursor: pointer; }
				.congreso-admin-tabs button.active { background: white; font-weight: bold; }
				.congreso-tab-content { display: none; padding: 20px; background: white; border: 1px solid #ccc; }
				.congreso-tab-content.active { display: block; }
				.congreso-plan { background: #f9f9f9; padding: 20px; margin-bottom: 20px; border-left: 4px solid #2271b1; }
				.congreso-plan h3 { margin-top: 0; }
				.congreso-field { margin-bottom: 15px; }
				.congreso-field label { display: block; font-weight: bold; margin-bottom: 5px; }
				.congreso-field input[type="text"], .congreso-field input[type="number"], .congreso-field select { width: 100%; max-width: 400px; }
				.congreso-field input[type="checkbox"] { width: auto; margin-right: 5px; }
			</style>

			<div class="congreso-admin-tabs">
				<button type="button" class="congreso-tab-btn active" data-tab="cirugia">Cirugía & Residentes</button>
				<button type="button" class="congreso-tab-btn" data-tab="enfermeria">Enfermería</button>
				<button type="button" class="congreso-tab-btn" data-tab="instrumentacion">Instrumentación</button>
			</div>

			<?php foreach ( [ 'cirugia', 'enfermeria', 'instrumentacion' ] as $evento ) : ?>
			<div class="congreso-tab-content <?php echo $evento === 'cirugia' ? 'active' : ''; ?>" id="tab-<?php echo $evento; ?>">
				<h2><?php echo ucfirst( $evento ); ?></h2>

				<?php foreach ( $data[ $evento ] as $idx => $plan ) : ?>
				<div class="congreso-plan">
					<h3>Plan <?php echo $idx + 1; ?>: <?php echo esc_html( $plan['titulo'] ); ?></h3>

					<div class="congreso-field">
						<label>Título</label>
						<input type="text" name="congreso_precios_data[<?php echo $evento; ?>][<?php echo $idx; ?>][titulo]" value="<?php echo esc_attr( $plan['titulo'] ); ?>">
					</div>

					<div class="congreso-field">
						<label>Subtítulo / Descripción</label>
						<input type="text" name="congreso_precios_data[<?php echo $evento; ?>][<?php echo $idx; ?>][subtitulo]" value="<?php echo esc_attr( $plan['subtitulo'] ); ?>">
					</div>

					<div class="congreso-field">
						<label>Precio</label>
						<input type="number" name="congreso_precios_data[<?php echo $evento; ?>][<?php echo $idx; ?>][precio]" value="<?php echo esc_attr( $plan['precio'] ); ?>">
					</div>

					<div class="congreso-field">
						<label>Moneda</label>
						<select name="congreso_precios_data[<?php echo $evento; ?>][<?php echo $idx; ?>][moneda]">
							<option value="USD" <?php selected( $plan['moneda'], 'USD' ); ?>>USD</option>
							<option value="UYU" <?php selected( $plan['moneda'], 'UYU' ); ?>>UYU</option>
						</select>
					</div>

					<div class="congreso-field">
						<label>Etiqueta de período (ej: "precio anticipado")</label>
						<input type="text" name="congreso_precios_data[<?php echo $evento; ?>][<?php echo $idx; ?>][periodo]" value="<?php echo esc_attr( $plan['periodo'] ); ?>">
					</div>

					<div class="congreso-field">
						<label>Precio regular (tachado) - dejar vacío si no aplica</label>
						<input type="number" name="congreso_precios_data[<?php echo $evento; ?>][<?php echo $idx; ?>][precio_regular]" value="<?php echo esc_attr( $plan['precio_regular'] ?? '' ); ?>">
					</div>

					<div class="congreso-field">
						<label>Badge (ej: "Más elegido") - dejar vacío si no aplica</label>
						<input type="text" name="congreso_precios_data[<?php echo $evento; ?>][<?php echo $idx; ?>][badge]" value="<?php echo esc_attr( $plan['badge'] ?? '' ); ?>">
					</div>

					<div class="congreso-field">
						<label>
							<input type="checkbox" name="congreso_precios_data[<?php echo $evento; ?>][<?php echo $idx; ?>][featured]" value="1" <?php checked( ! empty( $plan['featured'] ) ); ?>>
							Destacar (fondo oscuro)
						</label>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
			<?php endforeach; ?>

			<?php submit_button( 'Guardar cambios' ); ?>
		</form>
	</div>

	<script>
	jQuery(document).ready(function($) {
		$('.congreso-tab-btn').on('click', function() {
			var tab = $(this).data('tab');
			$('.congreso-tab-btn').removeClass('active');
			$(this).addClass('active');
			$('.congreso-tab-content').removeClass('active');
			$('#tab-' + tab).addClass('active');
		});
	});
	</script>
	<?php
}
