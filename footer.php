<?php
/**
 * The template for displaying Comments.
 * @package captionwp
 * @since 1.1
 */
?>

<footer class="footer">
<?php
        if ( get_theme_mod( 'captionwp_footer_copy' ) ) {
            printf(
                '<div class="footer-copy">%s</div>',
                wp_kses_post( get_theme_mod( 'captionwp_footer_copy', '' ) )
            );
        }
    ?>
</footer>

<?php wp_footer(); ?>

</body>
</html>