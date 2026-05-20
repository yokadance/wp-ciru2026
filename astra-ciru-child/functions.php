<?php
defined( 'ABSPATH' ) || exit;

/* -------------------------------------------------------
   1. ENQUEUE ASSETS
------------------------------------------------------- */
function congreso_enqueue_assets() {
	wp_enqueue_style(
		'astra-parent',
		get_template_directory_uri() . '/style.css',
		[],
		wp_get_theme( get_template() )->get( 'Version' )
	);

	wp_enqueue_style(
		'material-symbols',
		'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=block',
		[],
		null
	);

	wp_enqueue_style(
		'congreso-style',
		get_stylesheet_directory_uri() . '/assets/css/congreso.css',
		[ 'astra-parent', 'material-symbols' ],
		time()  // FUERZA cache refresh usando timestamp
	);

	// CSS específico para forzar full-width en páginas de inscripciones/postulaciones
	if ( is_page_template( 'page-inscripciones.php' ) || is_page_template( 'page-postulaciones.php' ) ) {
		wp_enqueue_style(
			'congreso-force-fullwidth',
			get_stylesheet_directory_uri() . '/assets/css/force-fullwidth.css',
			[ 'congreso-style' ],
			time()
		);
	}

	wp_enqueue_script(
		'congreso-js',
		get_stylesheet_directory_uri() . '/assets/js/congreso.js',
		[],
		'1.0.0',
		true
	);

	wp_localize_script( 'congreso-js', 'congresoConfig', [
		'targetDate' => '2026-12-02T00:00:00', // 2 de Diciembre 2026
		'ajaxUrl'    => admin_url( 'admin-ajax.php' ),
		'nonce'      => wp_create_nonce( 'congreso_contact' ),
	] );
}
add_action( 'wp_enqueue_scripts', 'congreso_enqueue_assets' );

/* -------------------------------------------------------
   2. LAYOUT FULL-WIDTH EN FRONT PAGE (Astra hooks)
------------------------------------------------------- */
function congreso_is_full_width_page() {
	return is_front_page()
		|| is_page_template( 'page-inscripciones.php' )
		|| is_page_template( 'page-postulaciones.php' );
}

add_filter( 'astra_page_layout', function ( $layout ) {
	if ( congreso_is_full_width_page() ) {
		return 'page-builder';  // Layout sin contenedor
	}
	return $layout;
} );

add_filter( 'astra_post_layout', function ( $layout ) {
	if ( congreso_is_full_width_page() ) {
		return 'page-builder';
	}
	return $layout;
} );

// Deshabilitar contenedor de Astra
add_filter( 'astra_get_content_layout', function ( $layout ) {
	if ( congreso_is_full_width_page() ) {
		return 'page-builder';
	}
	return $layout;
} );

// Deshabilitar el título de página de Astra
add_filter( 'astra_the_title_enabled', function ( $enabled ) {
	if ( congreso_is_full_width_page() ) {
		return false;
	}
	return $enabled;
} );

// Breadcrumbs off
add_filter( 'astra_breadcrumbs_enabled', function ( $enabled ) {
	if ( congreso_is_full_width_page() ) {
		return false;
	}
	return $enabled;
} );

// Remover footer de Astra (Powered by WordPress, etc.)
add_action( 'wp', function () {
	// Remover footer bar de Astra
	remove_action( 'astra_footer', 'astra_footer_markup' );

	// Remover copyright bar
	add_filter( 'astra_footer_bar_display', '__return_false' );

	// Remover el copyright/credits de Astra
	add_filter( 'astra_footer_sml_layout', '__return_false' );

	// Desactivar widgets del footer de Astra
	add_filter( 'astra_footer_widget_row_1_col_1_enable', '__return_false' );
	add_filter( 'astra_footer_widget_row_1_col_2_enable', '__return_false' );
	add_filter( 'astra_footer_widget_row_1_col_3_enable', '__return_false' );
	add_filter( 'astra_footer_widget_row_1_col_4_enable', '__return_false' );
}, 20 );

// Ocultar footer de Astra con CSS como backup
add_action( 'wp_head', function () {
	echo '<style>.site-footer{display:none!important;}</style>';
} );

/* -------------------------------------------------------
   3. BODY CLASSES
------------------------------------------------------- */
add_filter( 'body_class', function ( $classes ) {
	if ( is_front_page() ) {
		$classes[] = 'congreso-front-page';
	}
	return $classes;
} );

/* -------------------------------------------------------
   4. NAVIGATION MENUS
------------------------------------------------------- */
add_action( 'after_setup_theme', function () {
	register_nav_menus( [
		'primary'     => __( 'Menú Principal', 'congreso-ciru' ),
		'footer-col1' => __( 'Footer — Columna 1', 'congreso-ciru' ),
		'footer-col2' => __( 'Footer — Columna 2', 'congreso-ciru' ),
	] );
} );

/* -------------------------------------------------------
   5. CONTACT FORM AJAX
------------------------------------------------------- */
function congreso_handle_contact() {
	check_ajax_referer( 'congreso_contact', 'nonce' );

	$name    = sanitize_text_field( $_POST['nombre']  ?? '' );
	$email   = sanitize_email( $_POST['email']         ?? '' );
	$asunto  = sanitize_text_field( $_POST['asunto']  ?? 'Consulta' );
	$message = sanitize_textarea_field( $_POST['mensaje'] ?? '' );
	$evento  = sanitize_text_field( $_POST['evento']  ?? '' );

	if ( ! $name || ! is_email( $email ) || ! $message ) {
		wp_send_json_error( [ 'message' => 'Por favor complete todos los campos requeridos.' ] );
	}

	$to      = get_option( 'admin_email' );
	$subject = sprintf( '[Congreso Cirugía 2026] %s — %s', $asunto, $name );
	$body    = sprintf(
		"Nombre: %s\nEmail: %s\nEvento de interés: %s\n\n%s",
		$name, $email, $evento, $message
	);
	$headers = [
		'Content-Type: text/plain; charset=UTF-8',
		"Reply-To: {$name} <{$email}>",
	];

	if ( wp_mail( $to, $subject, $body, $headers ) ) {
		wp_send_json_success( [ 'message' => '¡Mensaje enviado! Nos pondremos en contacto a la brevedad.' ] );
	} else {
		wp_send_json_error( [ 'message' => 'Error al enviar. Por favor intente nuevamente o contáctenos por email.' ] );
	}
}
add_action( 'wp_ajax_congreso_contact',        'congreso_handle_contact' );
add_action( 'wp_ajax_nopriv_congreso_contact', 'congreso_handle_contact' );

/* -------------------------------------------------------
   6. HELPER: render price card
   Uso: congreso_price_card( $plan )
------------------------------------------------------- */
function congreso_price_card( array $plan ): void {
	$featured = ! empty( $plan['featured'] );
	$class    = 'ciru-price-card' . ( $featured ? ' is-featured' : '' );
	$btn_cls  = $featured ? 'ciru-btn--accent' : 'ciru-btn--ghost';
	?>
	<div class="<?php echo esc_attr( $class ); ?>">
		<?php if ( ! empty( $plan['badge'] ) ) : ?>
			<div class="ciru-price-card__badge"><?php echo esc_html( $plan['badge'] ); ?></div>
		<?php endif; ?>

		<h3 class="ciru-price-card__title"><?php echo esc_html( $plan['titulo'] ); ?></h3>
		<p class="ciru-price-card__subtitle"><?php echo esc_html( $plan['subtitulo'] ); ?></p>
		<hr class="ciru-price-card__hr">

		<span class="ciru-price-card__price-label"><?php echo esc_html( $plan['periodo'] ); ?></span>
		<div class="ciru-price-card__amount">
			<span class="ciru-price-card__currency"><?php echo esc_html( $plan['moneda'] ); ?></span>
			<span class="ciru-price-card__number"><?php echo esc_html( $plan['precio'] ); ?></span>
		</div>
		<?php if ( ! empty( $plan['precio_regular'] ) && $plan['precio_regular'] !== $plan['precio'] ) : ?>
			<span class="ciru-price-card__period">Precio regular: <?php echo esc_html( $plan['moneda'] ); ?> <?php echo esc_html( $plan['precio_regular'] ); ?></span>
		<?php endif; ?>

		<ul class="ciru-price-card__features">
			<?php foreach ( $plan['features'] as $feature ) : ?>
				<li>
					<span class="material-symbols-outlined">check_circle</span>
					<?php echo esc_html( $feature ); ?>
				</li>
			<?php endforeach; ?>
		</ul>

		<a href="<?php echo esc_url( $plan['href'] ); ?>" class="ciru-btn <?php echo esc_attr( $btn_cls ); ?>">
			Inscribirse
		</a>
	</div>
	<?php
}


/* -------------------------------------------------------
   7. PANEL DE ADMINISTRACIÓN
------------------------------------------------------- */
require_once get_stylesheet_directory() . '/admin/precios-admin-simple.php';
require_once get_stylesheet_directory() . '/admin/timeline-admin.php';
require_once get_stylesheet_directory() . '/admin/video-admin.php';
require_once get_stylesheet_directory() . '/admin/hoteleria-admin.php';
require_once get_stylesheet_directory() . '/admin/trabajos-libres-admin.php';

/* -------------------------------------------------------
   6b. HELPER: render miembro card (comités)
   Uso: congreso_miembro_card( $miembro )
------------------------------------------------------- */
function congreso_miembro_card( array $miembro ): string {
	$nombre = $miembro['nombre'] ?? '';
	$apellido = $miembro['apellido'] ?? '';
	$cargo = $miembro['cargo'] ?? '';
	$foto_url = $miembro['foto'] ?? '';

	// Si no hay foto, usar placeholder
	if ( empty( $foto_url ) ) {
		$foto_url = get_stylesheet_directory_uri() . '/assets/images/placeholder-avatar.png';
	}

	ob_start();
	?>
	<div class="ciru-miembro-card">
		<div class="ciru-miembro-card__foto">
			<img src="<?php echo esc_url( $foto_url ); ?>"
			     alt="<?php echo esc_attr( $nombre . ' ' . $apellido ); ?>"
			     loading="lazy">
		</div>
		<div class="ciru-miembro-card__info">
			<h4 class="ciru-miembro-card__nombre">
				<?php echo esc_html( $nombre . ' ' . $apellido ); ?>
			</h4>
			<?php if ( ! empty( $cargo ) ) : ?>
				<p class="ciru-miembro-card__cargo"><?php echo esc_html( $cargo ); ?></p>
			<?php endif; ?>
		</div>
	</div>
	<?php
	return ob_get_clean();
}
require_once get_stylesheet_directory() . '/admin/comites-admin.php';
require_once get_stylesheet_directory() . '/admin/secciones-admin.php';

/* -------------------------------------------------------
   8. HELPER: verificar si sección está activa
------------------------------------------------------- */
function congreso_seccion_activa( string $seccion_id ): bool {
	$secciones_activas = get_option( 'congreso_secciones_activas', [] );
	
	// Hero siempre está activo
	if ( $seccion_id === 'hero' ) {
		return true;
	}
	
	return in_array( $seccion_id, $secciones_activas );
}

function congreso_get_secciones_orden(): array {
	$orden_default = [
		'hero',
		'countdown',
		'bienvenida',
		'timeline',
		'video-destacado',
		'precios',
		'trabajos-libres',
		'comites',
		'hoteleria',
		'autoridades',
		'ubicacion',
		'contacto'
	];

	return get_option( 'congreso_secciones_orden', $orden_default );
}

/* -------------------------------------------------------
   8. SHORTCODES
------------------------------------------------------- */
add_shortcode( 'autoridades_congreso', function() {
    $ruta = get_stylesheet_directory() . '/template-parts/congreso/autoridades.php';

    if ( ! file_exists( $ruta ) ) {
        return '<p style="color:red;">❌ Archivo no encontrado: ' . esc_html( $ruta ) . '</p>';
    }

    ob_start();
    include $ruta;
    return ob_get_clean();
} );

add_shortcode( 'comite_organizador', function() {
    $ruta = get_stylesheet_directory() . '/template-parts/congreso/comites.php';

    if ( ! file_exists( $ruta ) ) {
        return '<p style="color:red;">❌ Archivo no encontrado: ' . esc_html( $ruta ) . '</p>';
    }

    ob_start();
    include $ruta;
    return ob_get_clean();
} );
