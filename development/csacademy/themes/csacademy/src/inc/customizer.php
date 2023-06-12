<?php
/**
 * CS Academy Theme Customizer
 *
 * @package CS_Academy
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function csacademy_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'csacademy_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'csacademy_customize_partial_blogdescription',
		) );
	}

	// Cursos
	$wp_customize->add_section( 'course_section',
		array(
			'title' => __( 'CS Academy: Lista de cursos', 'csacademy' ),
			'description' => esc_html__( 'Opções de exibição da lista de cursos', 'csacademy' ),
			'capability' => 'edit_theme_options',
		)
	);

	$wp_customize->add_setting( 'course_order_setting',
		array(
			'transport' => 'refresh',
			'type' => 'theme_mod',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		)
	);

	$wp_customize->add_control( 'course_order_setting',
		array(
			'label' => __( 'Ordem dos cursos', 'csacademy' ),
			'section' => 'course_section',
			'priority' => 10,
			'type' => 'select',
			'choices' => array(
				'DESC' => 'Do mais recente para o mais antigo',
				'ASC' => 'Do mais antigo para o mais recente'
			)
		)
	);

	// Rodapé
	$wp_customize->add_section( 'footer_section',
		array(
			'title' => __( 'CS Academy: Rodapé', 'csacademy' ),
			'description' => esc_html__( 'Opções de edição do rodapé', 'csacademy' ),
			'capability' => 'edit_theme_options',
		)
	);

	// Rodapé: sobre
	$wp_customize->add_setting( 'footer_about_setting',
		array(
			'transport' => 'refresh',
			'type' => 'theme_mod',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control( 'footer_about_setting',
		array(
			'label' => __( 'Sobre a empresa', 'csacademy' ),
			'section' => 'footer_section',
			'priority' => 10,
			'type' => 'textarea',
			'capability' => 'edit_theme_options',
		)
	);

	// Rodapé: copywright
	$wp_customize->add_setting( 'footer_note_setting',
		array(
			'transport' => 'refresh',
			'type' => 'theme_mod',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control( 'footer_note_setting',
		array(
			'label' => __( 'Informações de copywright', 'csacademy' ),
			'section' => 'footer_section',
			'priority' => 10,
			'type' => 'text',
			'capability' => 'edit_theme_options',
		)
	);
}
add_action( 'customize_register', 'csacademy_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function csacademy_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function csacademy_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function csacademy_customize_preview_js() {
	wp_enqueue_script( 'csacademy-customizer', get_template_directory_uri() . '/assets/js/customizer.min.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'csacademy_customize_preview_js' );
