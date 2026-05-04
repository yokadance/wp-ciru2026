<?php
/**
 * Módulo: Cuenta Regresiva
 *
 * EDITAR: La fecha objetivo se configura en functions.php:
 *   wp_localize_script → congresoConfig.targetDate
 *   Formato: 'YYYY-MM-DDTHH:MM:SS'
 *
 * El texto descriptivo debajo del timer se edita directamente abajo.
 */
defined( 'ABSPATH' ) || exit;
?>

<section class="ciru-countdown" id="cuenta-regresiva" aria-label="Cuenta regresiva al congreso">
	<div class="ciru-container">

		<div class="ciru-countdown__grid" aria-live="off">

			<div class="ciru-countdown__card">
				<span class="ciru-countdown__number" id="countdown-days">--</span>
				<span class="ciru-countdown__text">Días</span>
			</div>

			<div class="ciru-countdown__card">
				<span class="ciru-countdown__number" id="countdown-hours">--</span>
				<span class="ciru-countdown__text">Horas</span>
			</div>

			<div class="ciru-countdown__card">
				<span class="ciru-countdown__number" id="countdown-minutes">--</span>
				<span class="ciru-countdown__text">Minutos</span>
			</div>

			<div class="ciru-countdown__card">
				<span class="ciru-countdown__number" id="countdown-seconds">--</span>
				<span class="ciru-countdown__text">Segundos</span>
			</div>

		</div>

	</div>
</section>
