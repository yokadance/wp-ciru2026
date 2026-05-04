<?php
/**
 * Módulo: Formulario de Contacto
 *
 * El envío usa wp_ajax (definido en functions.php), ruteado
 * a través del plugin WP Mail SMTP con Elastic Mail.
 *
 * EDITAR: datos de contacto en $info_items[]
 */
defined( 'ABSPATH' ) || exit;

$info_items = [
	[ 'icon' => 'mail',        'texto' => 'congreso@cirugia.org.uy' ],    // EDITAR
	[ 'icon' => 'phone',       'texto' => '+598 2 000 0000' ],            // EDITAR
	[ 'icon' => 'location_on', 'texto' => 'Montevideo, Uruguay' ],        // EDITAR
	[ 'icon' => 'schedule',    'texto' => 'Lun–Vie · 9:00 – 17:00' ],    // EDITAR
];
?>

<section class="ciru-section ciru-contacto" id="contacto">
	<div class="ciru-container">

		<div class="ciru-contacto__grid">

			<!-- Info de contacto -->
			<div>
				<span class="ciru-eyebrow">Consultas</span>
				<h2 class="ciru-contacto__info-title">¿Tenés alguna consulta?</h2>
				<p class="ciru-contacto__info-desc">
					Para consultas sobre inscripciones, postulaciones, hotelería
					o cualquier aspecto del congreso, no dudes en escribirnos.
					Nuestro equipo te responderá a la brevedad.
				</p>

				<div class="ciru-contacto__items">
					<?php foreach ( $info_items as $item ) : ?>
					<div class="ciru-contacto__item">
						<span class="material-symbols-outlined"><?php echo esc_html( $item['icon'] ); ?></span>
						<span><?php echo esc_html( $item['texto'] ); ?></span>
					</div>
					<?php endforeach; ?>
				</div>
			</div>

			<!-- Formulario -->
			<div class="ciru-form-card">
				<form id="congreso-contact-form" novalidate>

					<div class="ciru-form">

						<div class="ciru-form__field">
							<label class="ciru-form__label" for="cf-nombre">
								Nombre completo <span aria-hidden="true">*</span>
							</label>
							<input class="ciru-form__input" type="text" id="cf-nombre"
							       name="nombre" required autocomplete="name"
							       placeholder="Su nombre">
						</div>

						<div class="ciru-form__field">
							<label class="ciru-form__label" for="cf-email">
								Correo electrónico <span aria-hidden="true">*</span>
							</label>
							<input class="ciru-form__input" type="email" id="cf-email"
							       name="email" required autocomplete="email"
							       placeholder="su@email.com">
						</div>

						<div class="ciru-form__field ciru-form__field--full">
							<label class="ciru-form__label" for="cf-evento">Evento de interés</label>
							<select class="ciru-form__select" id="cf-evento" name="evento">
								<option value="">— Seleccione un evento —</option>
								<option value="76 Congreso Uruguayo de Cirugía">76º Congreso Uruguayo de Cirugía</option>
								<option value="XXXV Jornadas de Enfermería Quirúrgica">XXXV Jornadas de Enfermería Quirúrgica</option>
								<option value="XXXI Jornadas de Instrumentación Quirúrgica">XXXI Jornadas de Instrumentación Quirúrgica</option>
								<option value="XXXVI Jornadas de Residentes de Cirugía">XXXVI Jornadas de Residentes de Cirugía</option>
								<option value="Postulación de trabajo">Postulación de trabajo</option>
								<option value="Otro">Otro</option>
							</select>
						</div>

						<div class="ciru-form__field ciru-form__field--full">
							<label class="ciru-form__label" for="cf-asunto">Asunto</label>
							<input class="ciru-form__input" type="text" id="cf-asunto"
							       name="asunto" placeholder="Motivo de la consulta">
						</div>

						<div class="ciru-form__field ciru-form__field--full">
							<label class="ciru-form__label" for="cf-mensaje">
								Mensaje <span aria-hidden="true">*</span>
							</label>
							<textarea class="ciru-form__textarea" id="cf-mensaje"
							          name="mensaje" required rows="5"
							          placeholder="Escriba su consulta aquí…"></textarea>
						</div>

						<div id="form-feedback" class="ciru-form__feedback" role="alert" aria-live="polite"></div>

						<button type="submit" class="ciru-form__submit">
							Enviar Mensaje
						</button>

					</div>

				</form>
			</div>

		</div>

	</div>
</section>
