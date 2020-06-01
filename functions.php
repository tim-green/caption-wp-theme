<?php

$theme_version = '1.1.0';

	/**
	 * Caption will only works for WP 5.0 or later
	 *
	 * @since v1.0
	 */
	if ( version_compare( $GLOBALS['wp_version'], '5.0', '<' ) ) {
		wp_die( 'Sorry this theme requires atlease WordPress 5.0 or up' );
	}


	/**
	 * Set the content width in pixels
	 * This is to support retina featured image size
	 * @since v1.0
	 */
	function captionwp_content_width() {
		global $content_width;
	
		$content_width = apply_filters( 'captionwp_content_width', 600 );
	}
	add_action( 'after_setup_theme', 'captionwp_content_width', 0 );





/**
	 * Loading All CSS Stylesheets and Javascript Files
	 *
	 * @since v1.0
	 */
	function themes_starter_scripts_loader() {
		global $theme_version;

		// 1. Styles
		wp_enqueue_style( 'style', get_template_directory_uri() . '/style.css', false, $theme_version, 'all' );
		// wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/node_modules/bootstrap/dist/css/bootstrap.min.css', false, $theme_version, 'all' );
		wp_enqueue_style( 'main', get_template_directory_uri() . '/assets/build/app.min.css', false, $theme_version, 'all' ); // main.scss: Compiled Framework source + custom styles
		

		wp_enqueue_style( 'hack-font', '//cdn.jsdelivr.net/npm/hack-font@3.3.0/build/web/hack.css', false, $theme_version, 'all' ); // obtain hack font from cdn


		if ( is_rtl() ) {
			wp_enqueue_style( 'rtl', get_template_directory_uri() . '/assets/css/rtl.min.css', false, $theme_version, 'all' );
		}

		// 2. Scripts
		wp_enqueue_script( 'bootstrapjs', get_template_directory_uri() . '/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js', array( 'jquery' ), $theme_version, true );
		wp_enqueue_script( 'mainjs', get_template_directory_uri() . '/assets/js/main.min.js', false, $theme_version, true );

		wp_enqueue_script( 'bootstrapjsCDN', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js', false, $theme_version, true );
		wp_enqueue_script( 'popperCDN', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js', false, $theme_version, true );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
	add_action( 'wp_enqueue_scripts', 'themes_starter_scripts_loader' );

	/**
	 * Default Theme Settings
	 *
	 * @since v1.0
	 */
	function captionwp_setup() {
		// Make theme available for translation.
		load_theme_textdomain( 'captionwp' );
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );
		// Let WordPress manage the document title.
		add_theme_support( 'title-tag' );
		// Enable support for Post Thumbnails on posts and pages.
		add_theme_support( 'post-thumbnails' );
		// Set post thumbnail default size
		set_post_thumbnail_size( 300, 300, true );
		// Add custom thumbnail image size
		add_image_size( 'captionwp-featured', 1200, 900, true );
		// This theme uses wp_nav_menu() in header and footer.
		register_nav_menus(
			array(
				'primary' => __( 'Primary menu', 'captionwp' ),
			)
		);
		// Switch default core markup to output valid HTML5
		add_theme_support( 'html5',
			array(
				'search-form',
				'gallery',
				'caption',
				'comment-list'
			)
		);
	}
	add_action( 'after_setup_theme', 'captionwp_setup' );

	/**
	 * Custom Theme Image Sizes
	 *
	 * @since v1.0
	 */

	function captionwp_image_size_names( $size_names ) {
		$size_names = array_merge( $size_names, array(
			'featured' => __( 'Featured image', 'captionwp' )
		) );
	
		return $size_names;
	}
	add_filter( 'image_size_names_choose', 'captionwp_image_size_names' );

	
	/**
	 * Enqueue comment-reply script
	 *
	 * @since v1.0
	 */
	function captionwp_comments_scripts() {
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
	add_action( 'wp_enqueue_scripts', 'captionwp_comments_scripts' );


	/**
	 * Upgrade comment forms
	 *
	 * @since v1.0
	 */

	function captionwp_comment_form_defaults( $defaults ) {
		$args = array(
			'logged_in_as'         => '',
			'must_log_in'          => '',
			'title_reply_before'   => '',
			'title_reply_after'    => '',
			'title_reply'          => '',
			'title_reply_to'       => '',
			'comment_notes_before' => '',
			'cancel_reply_before'  => '',
			'cancel_reply_after'   => '',
			'submit_button'        => '<button name="%1$s" type="submit" id="%2$s" class="%3$s">%4$s</button>',
			'submit_field'         => '<div class="comments-submit">%1$s %2$s</div>',
		);
	
		return wp_parse_args( $args, $defaults );
	}
	add_filter( 'comment_form_defaults', 'captionwp_comment_form_defaults' );
	
	
	/**
	 * Remove labels from comment fields
	 *
	 * @since v1.0
	 */

	function captionwp_comment_form_fields( $fields ) {
		$commenter = wp_get_current_commenter();
	
		$requred = (string) null;
		if ( get_option( 'require_name_email' ) ) {
			$requred = ' required="required"';
		}
	
		$fields['comment'] = sprintf(
			'<p><textarea id="comment" name="comment" placeholder="%s" required></textarea></p>',
			esc_attr__( 'Leave a Reply', 'captionwp' )
		);
	
		$fields['author'] = sprintf(
			'<p><input id="author" name="author" type="text" value="%s" placeholder="%s" maxlength="245"%s></p>',
			esc_attr( $commenter['comment_author'] ),
			esc_attr__( 'Name', 'captionwp' ), $requred
		);
	
		$fields['email'] = sprintf(
			'<p><input id="email" name="email" type="email" value="%s" placeholder="%s" maxlength="100"%s></p>',
			esc_attr( $commenter['comment_author_email'] ),
			esc_attr__( 'Email', 'captionwp' ), $requred
		);
	
		$fields['url'] = sprintf(
			'<p><input id="url" name="url" type="url" value="%s" placeholder="%s" maxlength="200"></p>',
			esc_attr( $commenter['comment_author_url'] ),
			esc_attr__( 'Website', 'captionwp' )
		);
	
		return $fields;
	}
	add_filter( 'comment_form_fields', 'captionwp_comment_form_fields' );
	

	/**
	 * Remove comment reply link if user not logged in and comment registration required
	 *
	 * @since v1.0
	 */
	function captionwp_comment_reply_link( $link ) {
		if ( get_option( 'comment_registration' ) && ! is_user_logged_in() ) {
			$link = (string) null;
		}
	
		return $link;
	}
	add_filter( 'comment_reply_link', 'captionwp_comment_reply_link' );
	
	
	/**
	 * Delete cancel comment reply link to recreate it below
	 *
	 * @since v1.0
	 */

	add_filter( 'cancel_comment_reply_link', '__return_empty_string' );
	
	
	/**
	 * Delete cancel comment reply link to recreate it below
	 *
	 * @since v1.0
	 */
	function captionwp_comment_form_submit_button( $submit_button, $args ) {
		$link = remove_query_arg( array( 'replytocom', 'unapproved', 'moderation-hash' ) );
	
		$display = (string) null;
		if ( empty( $_GET['replytocom'] ) ) {
			$display = ' style="display: none;"';
		}
	
		$cancel_link = sprintf(
			'<a id="cancel-comment-reply-link" class="comment-reply-cancel" href="%1s"rel="nofollow"%3$s>%2$s</a>',
			esc_html( $link ) . '#respond',
			__( 'Cancel reply', 'captionwp' ), $display
		);
	
		return $submit_button . $cancel_link;
	}
	add_filter( 'comment_form_submit_button', 'captionwp_comment_form_submit_button', 10, 2 );
	
	
	/**
	 * Slightly upgrade password protected form
	 */
	function captionwp_password_form( $output ) {
		$output = sprintf(
			'<form class="post-password-form" action="%3$s" method="post">%1$s %2$s</form>',
	
			sprintf(
				'<input name="post_password" type="password" placeholder="%s">',
				esc_attr__( 'Your page password', 'captionwp' )
			),
	
			sprintf(
				'<button type="submit" class="submit">%s</button>',
				__( 'Enter', 'captionwp' )
			),
	
			esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) )
		);
	
		return $output;
	}
	add_filter( 'the_password_form', 'captionwp_password_form' );
	
	/**
	 * Add theme options to customizer
	 *
	 * @since v1.0
	 */
	function captionwp_customizer_settings( $wp_customize ) {
		$wp_customize->add_section( 'captionwp_settings',
			array(
				'title' => __( 'Theme settings', 'captionwp' ),
				'priority' => 50,
			)
		);
	
		// Show author in summary
		$wp_customize->add_setting( 'captionwp_summary_author', array(
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'absint',
		) );
	
		$wp_customize->add_control( 'captionwp_summary_author', array(
			'type' => 'checkbox',
			'section' => 'captionwp_settings',
			'priority' => 10,
			'label' => __( 'Show author in summary', 'captionwp' ),
		) );
	
		// Show custom post meta in summary
		$wp_customize->add_setting( 'captionwp_summary_meta', array(
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'absint',
		) );
	
		$wp_customize->add_control( 'captionwp_summary_meta', array(
			'type' => 'checkbox',
			'section' => 'captionwp_settings',
			'priority' => 10,
			'label' => __( 'Show custom meta in summary', 'captionwp' ),
		) );
	
		// Footer copy text
		$wp_customize->add_setting( 'captionwp_footer_copy', array(
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'wp_kses_post',
		) );
	
		$wp_customize->add_control( new WP_Customize_Code_Editor_Control(
			$wp_customize, 'captionwp_footer_copy', array(
				'label' => __( 'Footer description', 'captionwp' ),
				'section' => 'captionwp_settings',
				'code_type' => 'text/html',
				'priority' => 25
			)
		) );
	}
	add_action( 'customize_register', 'captionwp_customizer_settings' );
	
	
	 /**
	 * Include a skip to content link at the top of the page so that users can bypass the menu.
	 *
	 * @since v1.0
	 */
	function captionwp_skip_link() {
		printf(
			'<a class="skip screen-reader-text" href="#content">%s</a>',
			__( 'Skip to the content', 'captionwp' )
		);
	}
	
	add_action( 'wp_body_open', 'captionwp_skip_link', 5 );
	
	
	/**
	 * Shim for wp_body_open, ensuring backwards compatibility with versions of WordPress older than 5.
	 *
	 * @since v1.0
	 */
	if ( ! function_exists( 'wp_body_open' ) ) {
		function wp_body_open() {
			do_action( 'wp_body_open' );
		}
	}
	
	
	/**
	 * Template function: show post summary
	 *
	 * @since v1.0
	 */
	if( ! function_exists( 'captionwp_show_summary' ) ) {
		function captionwp_show_summary() {
			$fields = array(
				'date' => esc_html( get_the_date() ),
				'title' => esc_html( get_the_title() )
			);
	
			if ( get_theme_mod( 'captionwp_summary_author' ) === 1 ) {
				$fields['author'] = get_the_author_posts_link();
			}
	
			if ( get_theme_mod( 'captionwp_summary_meta' ) === 1 ) {
				foreach ( (array) get_post_custom_keys() as $key ) {
					if ( is_protected_meta( $key, 'post' ) ) {
						continue;
					}
	
					$values = array_map( 'esc_html', get_post_custom_values( $key ) );
					$fields[ $key ] = implode( ', ', $values );
				}
			}
	
			if ( get_the_tags() ) {
				$fields['tags'] = get_the_tag_list( null, ', ' );
			}
	
			$fields = apply_filters( 'captionwp_summary_fields', $fields );
	
			foreach ( $fields as $label => $value ) {
				printf(
					'<li><span>"%s"</span>: <strong>"%s"</strong></li>',
					esc_attr( $label ),
					wp_kses_post( $value )
				);
			}
		}
	}