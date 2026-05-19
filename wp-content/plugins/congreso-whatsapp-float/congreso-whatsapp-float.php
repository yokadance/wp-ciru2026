<?php
/**
 * Plugin Name: Congreso WhatsApp Float
 * Description: Botón flotante de WhatsApp en la esquina inferior izquierda
 * Version: 1.0.0
 * Author: Congreso SCU
 * Text Domain: congreso-whatsapp
 */

defined( 'ABSPATH' ) || exit;

class Congreso_WhatsApp_Float {

	public function __construct() {
		add_action( 'wp_footer', [ $this, 'render_button' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ] );
		add_action( 'admin_menu', [ $this, 'add_settings_page' ] );
		add_action( 'admin_init', [ $this, 'register_settings' ] );
	}

	public function enqueue_styles() {
		wp_add_inline_style( 'wp-block-library', $this->get_inline_css() );
	}

	public function render_button() {
		$phone = get_option( 'cwf_phone', '+59899123456' );
		$message = get_option( 'cwf_message', 'Hola, necesito información sobre el 76º Congreso de Cirugía' );
		$enabled = get_option( 'cwf_enabled', '1' );

		if ( $enabled !== '1' ) {
			return;
		}

		// Limpiar y formatear número (quitar espacios, guiones, paréntesis)
		$phone_clean = preg_replace( '/[^0-9+]/', '', $phone );

		// URL de WhatsApp con mensaje pre-llenado
		$whatsapp_url = 'https://wa.me/' . $phone_clean . '?text=' . urlencode( $message );
		?>
		<a href="<?php echo esc_url( $whatsapp_url ); ?>"
		   class="cwf-whatsapp-float"
		   target="_blank"
		   rel="noopener noreferrer"
		   aria-label="Contactar por WhatsApp">
			<svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M16 0C7.164 0 0 7.164 0 16c0 2.828.74 5.48 2.032 7.788L0.696 30.196a1 1 0 001.108 1.108l6.408-1.336A15.934 15.934 0 0016 32c8.836 0 16-7.164 16-16S24.836 0 16 0z" fill="#25D366"/>
				<path d="M23.328 18.736c-.388-.196-2.3-1.136-2.656-1.264-.356-.128-.616-.196-.876.196-.26.392-1.008 1.264-1.236 1.524-.228.26-.456.292-.844.096-.388-.196-1.64-.604-3.124-1.928-1.156-1.032-1.936-2.308-2.164-2.696-.228-.388-.024-.6.172-.792.176-.176.388-.456.58-.684.192-.228.256-.392.388-.652.132-.26.068-.488-.032-.684-.1-.196-.876-2.112-1.2-2.892-.316-.76-.636-.656-.876-.668-.228-.012-.488-.016-.748-.016s-.68.096-.96.484c-.292.388-1.104 1.08-1.104 2.632s1.132 3.052 1.288 3.26c.156.208 2.212 3.376 5.356 4.736.748.324 1.332.516 1.788.66.752.24 1.436.204 1.976.124.604-.092 1.856-.76 2.116-1.492.26-.732.26-1.36.184-1.492-.076-.132-.336-.208-.724-.404z" fill="#fff"/>
			</svg>
			<span class="cwf-whatsapp-float__pulse"></span>
		</a>
		<?php
	}

	public function get_inline_css() {
		return <<<CSS
		.cwf-whatsapp-float {
			position: fixed;
			bottom: 24px;
			left: 24px;
			width: 64px;
			height: 64px;
			background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
			border-radius: 50%;
			display: flex;
			align-items: center;
			justify-content: center;
			box-shadow: 0 8px 24px rgba(37, 211, 102, 0.4), 0 4px 8px rgba(0, 0, 0, 0.15);
			z-index: 9999;
			transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
			text-decoration: none;
			cursor: pointer;
			animation: cwf-float-in 0.6s ease-out;
		}

		.cwf-whatsapp-float svg {
			width: 36px;
			height: 36px;
			position: relative;
			z-index: 2;
		}

		.cwf-whatsapp-float:hover {
			transform: translateY(-4px) scale(1.05);
			box-shadow: 0 12px 32px rgba(37, 211, 102, 0.5), 0 6px 12px rgba(0, 0, 0, 0.2);
		}

		.cwf-whatsapp-float:active {
			transform: translateY(-2px) scale(1.02);
		}

		.cwf-whatsapp-float__pulse {
			position: absolute;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			border-radius: 50%;
			background: rgba(37, 211, 102, 0.4);
			animation: cwf-pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
			pointer-events: none;
		}

		@keyframes cwf-pulse {
			0%, 100% {
				transform: scale(1);
				opacity: 1;
			}
			50% {
				transform: scale(1.2);
				opacity: 0.6;
			}
		}

		@keyframes cwf-float-in {
			from {
				transform: translateY(100px) scale(0);
				opacity: 0;
			}
			to {
				transform: translateY(0) scale(1);
				opacity: 1;
			}
		}

		/* Responsive */
		@media (max-width: 768px) {
			.cwf-whatsapp-float {
				bottom: 20px;
				left: 20px;
				width: 56px;
				height: 56px;
			}

			.cwf-whatsapp-float svg {
				width: 32px;
				height: 32px;
			}
		}

		/* Evitar conflicto con otros elementos flotantes */
		@media (max-width: 480px) {
			.cwf-whatsapp-float {
				bottom: 16px;
				left: 16px;
			}
		}
		CSS;
	}

	public function add_settings_page() {
		add_options_page(
			'WhatsApp Float',
			'WhatsApp Float',
			'manage_options',
			'congreso-whatsapp-float',
			[ $this, 'render_settings_page' ]
		);
	}

	public function register_settings() {
		register_setting( 'cwf_settings', 'cwf_phone' );
		register_setting( 'cwf_settings', 'cwf_message' );
		register_setting( 'cwf_settings', 'cwf_enabled' );
	}

	public function render_settings_page() {
		$phone = get_option( 'cwf_phone', '+59899123456' );
		$message = get_option( 'cwf_message', 'Hola, necesito información sobre el 76º Congreso de Cirugía' );
		$enabled = get_option( 'cwf_enabled', '1' );
		?>
		<div class="wrap">
			<h1>⚙️ Configuración WhatsApp Float</h1>

			<form method="post" action="options.php" style="max-width: 600px;">
				<?php settings_fields( 'cwf_settings' ); ?>

				<table class="form-table">
					<tr>
						<th scope="row">
							<label for="cwf_enabled">Activar Botón</label>
						</th>
						<td>
							<label>
								<input type="checkbox"
								       id="cwf_enabled"
								       name="cwf_enabled"
								       value="1"
								       <?php checked( $enabled, '1' ); ?>>
								Mostrar botón de WhatsApp
							</label>
						</td>
					</tr>

					<tr>
						<th scope="row">
							<label for="cwf_phone">Número de WhatsApp</label>
						</th>
						<td>
							<input type="text"
							       id="cwf_phone"
							       name="cwf_phone"
							       value="<?php echo esc_attr( $phone ); ?>"
							       class="regular-text"
							       placeholder="+59899123456">
							<p class="description">
								Formato internacional: <code>+598 99 123 456</code><br>
								Ejemplo Uruguay: <code>+598</code> + código área + número
							</p>
						</td>
					</tr>

					<tr>
						<th scope="row">
							<label for="cwf_message">Mensaje Predeterminado</label>
						</th>
						<td>
							<textarea id="cwf_message"
							          name="cwf_message"
							          rows="3"
							          class="large-text"
							          placeholder="Hola, necesito información sobre..."><?php echo esc_textarea( $message ); ?></textarea>
							<p class="description">
								Este mensaje se pre-llenará al abrir WhatsApp
							</p>
						</td>
					</tr>
				</table>

				<?php submit_button( 'Guardar Configuración' ); ?>
			</form>

			<hr style="margin: 2rem 0;">

			<h2>👁️ Vista Previa</h2>
			<div style="background: #f0f0f1; padding: 2rem; border-radius: 8px; position: relative; height: 200px;">
				<p style="color: #646970; margin-bottom: 1rem;">El botón aparecerá en la esquina inferior izquierda:</p>
				<div style="position: absolute; bottom: 24px; left: 24px;">
					<div style="
						width: 64px;
						height: 64px;
						background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
						border-radius: 50%;
						display: flex;
						align-items: center;
						justify-content: center;
						box-shadow: 0 8px 24px rgba(37, 211, 102, 0.4);
					">
						<svg width="36" height="36" viewBox="0 0 32 32" fill="none">
							<path d="M16 0C7.164 0 0 7.164 0 16c0 2.828.74 5.48 2.032 7.788L0.696 30.196a1 1 0 001.108 1.108l6.408-1.336A15.934 15.934 0 0016 32c8.836 0 16-7.164 16-16S24.836 0 16 0z" fill="#25D366"/>
							<path d="M23.328 18.736c-.388-.196-2.3-1.136-2.656-1.264-.356-.128-.616-.196-.876.196-.26.392-1.008 1.264-1.236 1.524-.228.26-.456.292-.844.096-.388-.196-1.64-.604-3.124-1.928-1.156-1.032-1.936-2.308-2.164-2.696-.228-.388-.024-.6.172-.792.176-.176.388-.456.58-.684.192-.228.256-.392.388-.652.132-.26.068-.488-.032-.684-.1-.196-.876-2.112-1.2-2.892-.316-.76-.636-.656-.876-.668-.228-.012-.488-.016-.748-.016s-.68.096-.96.484c-.292.388-1.104 1.08-1.104 2.632s1.132 3.052 1.288 3.26c.156.208 2.212 3.376 5.356 4.736.748.324 1.332.516 1.788.66.752.24 1.436.204 1.976.124.604-.092 1.856-.76 2.116-1.492.26-.732.26-1.36.184-1.492-.076-.132-.336-.208-.724-.404z" fill="#fff"/>
						</svg>
					</div>
				</div>
			</div>

			<hr style="margin: 2rem 0;">

			<h2>📱 URL Generada</h2>
			<?php
			$phone_clean = preg_replace( '/[^0-9+]/', '', $phone );
			$url = 'https://wa.me/' . $phone_clean . '?text=' . urlencode( $message );
			?>
			<p style="background: white; padding: 1rem; border: 1px solid #ddd; border-radius: 4px; word-break: break-all;">
				<code><?php echo esc_html( $url ); ?></code>
			</p>
		</div>
		<?php
	}
}

new Congreso_WhatsApp_Float();
