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
		'2.0.0'  // FIX DEFINITIVO: ancho 100% forzado + scrollbar permanente
	);

	wp_enqueue_script(
		'congreso-js',
		get_stylesheet_directory_uri() . '/assets/js/congreso.js',
		[],
		'1.0.0',
		true
	);

	wp_localize_script( 'congreso-js', 'congresoConfig', [
		'targetDate' => '2026-09-15T00:00:00', // EDITAR: fecha del congreso
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
require_once get_stylesheet_directory() . '/admin/precios-admin.php';
