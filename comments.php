<?php
/**
 * The template for displaying Comments.
 * @package captionwp
 * @since 1.1
 */

/*
	* If the current post is protected by a password and
	* the visitor has not yet entered the password we will
	* return early without loading the comments.
	*/
	if ( post_password_required() ) {
		return;
	}
?>
<div id="comments">
	<?php /*
        if ( have_comments() ) {
            printf(
                '<div class="comment-list">%s</div>',

                wp_list_comments(
                    array(
                        'echo' => false,
                        'style' => 'div'
                    )
                )
            );

            if ( function_exists( 'the_comments_navigation' ) ) {
                the_comments_navigation();
            }
        }

        comment_form(
            array(
                'submit_field' => '<div class="comment-submit">%1$s %2$s</div>'
            )
        ); */
	?>
</div><!-- /#comments -->