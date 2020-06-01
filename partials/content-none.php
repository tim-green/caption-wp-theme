<?php
/**
 * Template Part: content part what is common
 * @package captionwp
 * @since 1.1
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post' ); ?>>
    <div class="card link-card">
        <?php
            printf(
                '<a class="card-permalink" href="%s"></a>',
                esc_url( get_permalink() )
            );
        ?>

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
</article>