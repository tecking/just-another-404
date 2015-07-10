<?php

/*
 * Load stylesheets.
 */

add_action( 'wp_enqueue_scripts', 'ja4_enqueue_scripts' );
function ja4_enqueue_scripts() {
	if ( ! is_admin() ) {
		wp_enqueue_style( 'style', get_stylesheet_directory_uri() . '/style.css' );
		wp_enqueue_style( 'font', '//fonts.googleapis.com/css?family=Noto+Sans' );
	}
	return;
}


/*
 * Configurations for theme customizer.
 */

add_action( 'customize_register', array( 'JA4_Customize', 'register' ) );
class JA4_Customize {

	public static function register( $wp_customize ) {

		// Add new sections.
		$wp_customize -> add_setting( 'ja4_text_color_setting', array( 'default' => '#fff' ) );
		$wp_customize -> add_control(
			new WP_Customize_Color_Control( $wp_customize, 'ja4_text_color',
				array(
					'label'    => __( 'Text color', 'ja4' ),
					'section'  => 'colors',
					'settings' => 'ja4_text_color_setting',
				)
			)
		);

		$wp_customize -> add_setting( 'ja4_bkgd_color_setting', array( 'default' => '#eee' ) );
		$wp_customize -> add_control(
			new WP_Customize_Color_Control( $wp_customize, 'ja4_bkgd_color',
				array(
					'label'    => __( 'Background color', 'ja4' ),
					'section'  => 'colors',
					'settings' => 'ja4_bkgd_color_setting',
				)
			)
		);

		$wp_customize -> add_section( 'ja4_bkgd_image',
			array(
				'title'    => __( 'Background image', 'ja4' ),
				'priority' => 85,
			)
		);
		$wp_customize -> add_setting( 'ja4_bkgd_image_setting', array( 'default' => get_stylesheet_directory_uri() . '/img/cover.jpg' ) );
		$wp_customize -> add_control(
			new WP_Customize_Image_Control( $wp_customize, 'ja4_bkgd_image',
				array(
					'label'    => __( 'Background image', 'ja4' ),
					'section'  => 'ja4_bkgd_image',
					'settings' => 'ja4_bkgd_image_setting',
				)
			)
		);

		$wp_customize -> add_section( 'ja4_strings',
			array(
				'title'    => __( 'Page title and description', 'ja4' ),
				'priority' => 20,
			)
		);
		$wp_customize -> add_setting( 'ja4_page_title_setting', array( 'default' => 'Just another 404' ) );
		$wp_customize -> add_control(
			new WP_Customize_Control( $wp_customize, 'ja4_page_title',
				array(
					'label'    => __( 'Page title', 'ja4' ),
					'section'  => 'ja4_strings',
					'settings' => 'ja4_page_title_setting',
				)
			)
		);
		$wp_customize -> add_setting( 'ja4_page_description_setting', array( 'default' => 'There\'s not much here.' ) );
		$wp_customize -> add_control(
			new WP_Customize_Control( $wp_customize, 'ja4_page_description',
				array(
					'label'    => __( 'Description', 'ja4' ),
					'section'  => 'ja4_strings',
					'settings' => 'ja4_page_description_setting',
				)
			)
		);

		$wp_customize -> add_section( 'ja4_http_status',
			array(
				'title' => __( 'HTTP status code', 'ja4' ),
				'priority' => 120,
			)
		);
		$wp_customize -> add_setting( 'ja4_http_status_setting' );
		$wp_customize -> add_control(
			new WP_Customize_Control( $wp_customize, 'ja4_http_status',
				array(
					'label'    => __( 'HTTP status code', 'ja4' ),
					'section'  => 'ja4_http_status',
					'settings' => 'ja4_http_status_setting',
					'type'     => 'select',
					'choices'  => array (
						'404' => '404 Not Found',
						'403' => '403 Forbidden',
					),
				)
			)
		);

		// Remove built-in section.
		$wp_customize -> remove_section( 'static_front_page' );

	}

}


/*
 * Activate live CSS.
 */

add_action( 'wp_head', array( 'JA4_WP_Head', 'ja4_customize_css' ) );
add_action( 'wp_head', array( 'JA4_WP_Head', 'ja4_box_height' ) );
class JA4_WP_Head {

	public static function ja4_box_height() {

		if ( is_admin_bar_showing() ) {

			$str = '
			<style type="text/css">
			<!--
			html, body, #main, #content {
				height: 98%;
				height: -webkit-calc(100% - 32px);
				height: calc(100% - 32px);
			}
			@media screen and (max-width: 782px) {
				html, body, #main, #content {
					height: 96%;
					height: -webkit-calc(100% - 46px);
					height: calc(100% - 46px);
				}		
			}
			-->
			</style>';
			echo $str;
			
		}

	}

	public static function ja4_customize_css() {

		$str = '
		<style type="text/css">
		<!--
		body {
			color: ' . get_theme_mod( 'ja4_text_color_setting', '#fff' ) . ';
			background-color: ' . get_theme_mod( 'ja4_bkgd_color_setting', '#eee' ) . ';
			background-image: url(' . get_theme_mod( 'ja4_bkgd_image_setting', get_stylesheet_directory_uri() . '/img/cover.jpg' ) . ');
		}
		-->
		</style>';
		echo $str;

	}

}


/*
 * Customize headers.
 */

add_filter( 'wp_headers', 'ja4_set_headers' );
function ja4_set_headers( $headers ) {

	unset( $headers['X-Pingback'] );
	return $headers;

}


/*
 * Modify WP_Query().
 */

add_action( 'parse_query', 'ja4_parse_query' );
function ja4_parse_query( $query ) {

    $query->set_404();

}

add_filter( 'posts_request', 'ja4_posts_request' );
function ja4_posts_request( $input ) {

	return $input = null;

}