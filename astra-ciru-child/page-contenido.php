<?php
/**
 * Template Name: Página de Contenido
 * Template Post Type: page
 *
 * Plantilla para páginas de contenido estático: reglamentos, cartas, etc.
 * Layout full-width con tipografía optimizada para lectura.
 */
defined( 'ABSPATH' ) || exit;

get_header();
?>

</div><!-- /ast-container — cerrado para full-width -->
</div><!-- /#content — cerrado para full-width -->

<main class="ciru-page-contenido">
	<div class="ciru-container">

		<?php while ( have_posts() ) : the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class( 'ciru-page-contenido__article' ); ?>>

			<header class="ciru-page-contenido__header">
				<h1 class="ciru-page-contenido__title"><?php the_title(); ?></h1>
				<?php if ( has_excerpt() ) : ?>
					<div class="ciru-page-contenido__excerpt">
						<?php the_excerpt(); ?>
					</div>
				<?php endif; ?>
			</header>

			<div class="ciru-page-contenido__content">
				<?php the_content(); ?>
			</div>

		</article>

		<?php endwhile; ?>

	</div>
</main>

<?php
// Footer del congreso
get_template_part( 'template-parts/congreso/footer-congreso' );
?>

<!-- Divs de balance para footer.php -->
<div hidden><div hidden>

<?php get_footer(); ?>
