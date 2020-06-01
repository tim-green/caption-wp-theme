<?php
/**
 * Header
 * @package captionwp
 * @since 1.1
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <?php wp_head(); ?>
</head>

<?php
	$navbar_scheme = get_theme_mod( 'navbar_scheme', 'navbar-light bg-light' ); // get custom meta-value
	$navbar_position = get_theme_mod( 'navbar_position', 'static' ); // get custom meta-value

	$search_enabled = get_theme_mod( 'search_enabled', '1' ); // get custom meta-value
?>

<body <?php body_class(); ?>>

<?php wp_body_open();?>

<header class="header">
    <h2 class="site-title"><?php echo esc_attr( get_bloginfo( 'name', 'display' ) );?>
    </h2>
    
<?php
        if ( has_nav_menu( 'primary' ) ) {
            wp_nav_menu( array(
                'theme_location' => 'primary',
                'container' => 'nav',
                'container_class' => 'header-menu',
                'items_wrap' => '<ul class="menu">%3$s</ul>',
                'echo' => true,
                'depth' => 1
            ) );
        }
    ?>
</header>