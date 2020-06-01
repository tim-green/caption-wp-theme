<?php
/**
 * Template Part: page content
 * @package captionwp
 * @since 1.1
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post' ); ?>>
    <div class="card">
        <figure class="card-thumbnail">
            <?php
                the_post_thumbnail( 'captionwp-featured',
                    array( 'class' => 'card-thumbnail-image' )
                );
            ?>
        </figure>

        <ul class="card-summary">
            <?php
                if ( function_exists( 'captionwp_show_summary' ) ) {
                    captionwp_show_summary();
                }
            ?>
        </ul>
    </div>

    <div class="entry">
        <?php
            the_content();

            wp_link_pages(
                array(
                    'before' => '<div class="page-links">',
                    'after'  => '</div>',
                    'next_or_number' => 'next'
                )
            );
        ?>
    </div>
</article>