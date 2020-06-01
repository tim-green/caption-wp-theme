<?php
/**
 * Template Part: Search caption archive
 * @package captionwp
 * @since 1.1
 */
?>

<div class="caption">
    <?php
        printf(
            '<h1 class="caption-title">%s &laquo;%s&raquo;</h1>',
            esc_html__( 'Search results for:', 'captionwp' ),
            get_search_query()
        );
    ?>
</div>