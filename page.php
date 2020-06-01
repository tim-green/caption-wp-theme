<?php
/**
 * Template Name: Page post template
 * @package captionwp
 * @since 1.1
 */

	get_header();
?>

	<section class="content" id="content">
	<?php
        if ( have_posts() ) {
            while( have_posts() ) {
                the_post();

                // Get page content partial
                get_template_part( 'partials/content', 'page' );
            }
         } else {
            get_template_part( 'partials/caption', 'none' );
         }
    ?>
	</section>

<?php get_footer(); ?>