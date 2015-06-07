<?php
if ( ! is_user_logged_in() ) {
	header( get_theme_mod( 'ja4_http_status_setting', 'HTTP/1.0 404 Not Found' ) );
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo esc_html( wptexturize( get_theme_mod( 'ja4_page_title_setting', 'Just another 404' ) ) ); ?></title>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div id="main">
		<div id="content">
			<h1 id="page-title"><?php echo esc_html( wptexturize( get_theme_mod( 'ja4_page_title_setting', 'Just another 404' ) ) ); ?></h1>
			<p id="page-description"><?php echo esc_html( wptexturize( get_theme_mod( 'ja4_page_description_setting', 'There\'s not much here.' ) ) ); ?></p>
		</div>
	</div>

<?php wp_footer(); ?>
</body>
</html>