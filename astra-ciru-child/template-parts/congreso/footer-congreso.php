<?php
/**
 * Footer del Congreso
 * Información de contacto, enlaces y copyright
 */
defined( 'ABSPATH' ) || exit;
?>

<footer class="ciru-footer">
	<div class="ciru-container">

		<!-- Grid de columnas -->
		<div class="ciru-footer__grid">

			<!-- Columna 1: Información del evento -->
			<div class="ciru-footer__col">
				<h3 class="ciru-footer__title">76º Congreso Uruguayo de Cirugía</h3>
				<p class="ciru-footer__text">
					<strong>Ciencia, Humanismo y Excelencia</strong>
				</p>
				<ul class="ciru-footer__list">
					<li>
						<span class="material-symbols-outlined">calendar_month</span>
						<div>
							<strong>Precongreso:</strong> 1 de Diciembre · Hospital de Clínicas<br>
							<strong>Congreso:</strong> 2, 3 y 4 de Diciembre de 2026
						</div>
					</li>
					<li>
						<span class="material-symbols-outlined">location_on</span>
						<div>
							<strong>The Grand Hotel</strong><br>
							Punta del Este, Maldonado, Uruguay
						</div>
					</li>
				</ul>
			</div>

			<!-- Columna 2: Enlaces rápidos -->
			<div class="ciru-footer__col">
				<h4 class="ciru-footer__subtitle">Enlaces Rápidos</h4>
				<ul class="ciru-footer__links">
					<li><a href="#inicio">Inicio</a></li>
					<li><a href="#inscripciones">Inscripciones</a></li>
					<li><a href="/reglamento-trabajos-libres">Trabajos Libres</a></li>
					<li><a href="#hoteleria">Hotelería</a></li>
					<li><a href="#contacto">Contacto</a></li>
				</ul>
			</div>

			<!-- Columna 3: Organizadores -->
			<div class="ciru-footer__col">
				<h4 class="ciru-footer__subtitle">Organizan</h4>
				<ul class="ciru-footer__links">
					<li><strong>Sociedad de Cirugía del Uruguay</strong></li>
					<li>Jornadas de Enfermería Quirúrgica</li>
					<li>Jornadas de Instrumentación Quirúrgica (AUIQ)</li>
				</ul>
				<div class="ciru-footer__logos" style="margin-top: 1.5rem;">
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/logos/logo-scu.png"
					     alt="SCU"
					     style="max-height: 60px; margin-right: 1rem;">
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/logos/logo-auiq.png"
					     alt="AUIQ"
					     style="max-height: 60px;">
				</div>
			</div>

			<!-- Columna 4: Contacto -->
			<div class="ciru-footer__col">
				<h4 class="ciru-footer__subtitle">Contacto</h4>
				<ul class="ciru-footer__list">
					<li>
						<span class="material-symbols-outlined">mail</span>
						<a href="mailto:congreso@scu.org.uy">congreso@scu.org.uy</a>
					</li>
					<li>
						<span class="material-symbols-outlined">language</span>
						<a href="https://www.scu.org.uy" target="_blank" rel="noopener">www.scu.org.uy</a>
					</li>
				</ul>
			</div>

		</div>

	</div>
</footer>
