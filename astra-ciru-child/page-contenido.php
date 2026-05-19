<?php
/**
 * Template Name: Página de Contenido
 * Template Post Type: page
 *
 * Plantilla para páginas de contenido estático: reglamentos, cartas, etc.
 * Layout full-width con hero banner superior y footer del congreso.
 */
defined( 'ABSPATH' ) || exit;

get_header();
?>

</div><!-- /ast-container — cerrado para full-width -->
</div><!-- /#content — cerrado para full-width -->

<?php while ( have_posts() ) : the_post(); ?>

<!-- Hero Banner -->
<section class="ciru-page-hero">
	<div class="ciru-page-hero__bg"></div>
	<div class="ciru-page-hero__pattern"></div>
	<div class="ciru-container">
		<div class="ciru-page-hero__content">
			<div class="ciru-page-hero__badge">76º Congreso Uruguayo de Cirugía</div>
			<h1 class="ciru-page-hero__title"><?php the_title(); ?></h1>
			<?php if ( has_excerpt() ) : ?>
				<p class="ciru-page-hero__excerpt"><?php echo get_the_excerpt(); ?></p>
			<?php endif; ?>
		</div>
	</div>
</section>

<!-- Contenido -->
<main class="ciru-page-contenido">
	<div class="ciru-container">
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'ciru-page-contenido__article' ); ?>>
			<div class="ciru-page-contenido__content">
				<?php
				// Asegurar que los shortcodes se procesen
				$content = get_the_content();
				$content = apply_filters( 'the_content', $content );
				$content = str_replace( ']]>', ']]&gt;', $content );
				echo $content;
				?>
			</div>
		</article>
	</div>
</main>

<?php endwhile; ?>

<?php
// Footer del congreso
get_template_part( 'template-parts/congreso/footer-congreso' );
?>

<!-- Divs de balance para footer.php -->
<div hidden><div hidden>

<?php get_footer(); ?>
