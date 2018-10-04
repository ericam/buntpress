<?php
/**
 * buntpress Theme Customizer.
 *
 * @package buntpress
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function buntpress_customize_register( $wp_customize ) {
  $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
  $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
  $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

  // Add our social link options.
    $wp_customize->add_section(
        'buntpress_social_links_section',
        array(
            'title'       => esc_html__( 'Social Links', 'buntpress' ),
            'description' => esc_html__( 'These are the settings for social links. Please limit the number of social links to 5.', 'buntpress' ),
            'priority'    => 90,
        )
    );

    // Create an array of our social links for ease of setup.
    $social_networks = array( 'twitter', 'facebook', 'instagram' );

    // Loop through our networks to setup our fields.
    foreach( $social_networks as $network ) {

      $wp_customize->add_setting(
          'buntpress_' . $network . '_link',
          array(
              'default' => '',
              'sanitize_callback' => 'buntpress_sanitize_customizer_url'
          )
      );
      $wp_customize->add_control(
          'buntpress_' . $network . '_link',
          array(
              'label'   => sprintf( esc_html__( '%s Link', 'buntpress' ), ucwords( $network ) ),
              'section' => 'buntpress_social_links_section',
              'type'    => 'text',
          )
      );
    }

    // Add our Footer Customization section section.
    $wp_customize->add_section(
        'buntpress_footer_section',
        array(
            'title'    => esc_html__( 'Footer Customization', 'buntpress' ),
            'priority' => 90,
        )
    );

    // Add our copyright text field.
    $wp_customize->add_setting(
        'buntpress_copyright_text',
        array(
            'default' => ''
        )
    );
    $wp_customize->add_control(
        'buntpress_copyright_text',
        array(
            'label'       => esc_html__( 'Copyright Text', 'buntpress' ),
            'description' => esc_html__( 'The copyright text will be displayed in the footer.', 'buntpress' ),
            'section'     => 'buntpress_footer_section',
            'type'        => 'text',
            'sanitize'    => 'html'
        )
    );

    // Add our Banner Customization section section.
    $wp_customize->add_section(
        'buntpress_banner_section',
        array(
            'title'    => esc_html__( 'Banner Customization', 'buntpress' ),
            'priority' => 90,
        )
    );

    // Add our donate text field.
    $wp_customize->add_setting(
        'buntpress_donate_text',
        array(
            'default' => ''
        )
    );
    $wp_customize->add_control(
        'buntpress_donate_text',
        array(
            'label'       => esc_html__( 'Donate Text', 'buntpress' ),
            'description' => esc_html__( 'The donate text will be displayed in a banner at the top of the page.', 'buntpress' ),
            'section'     => 'buntpress_banner_section',
            'type'        => 'text',
            'sanitize'    => 'html'
        )
    );
}
add_action( 'customize_register', 'buntpress_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function buntpress_customize_preview_js() {
    wp_enqueue_script( 'buntpress_customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'buntpress_customize_preview_js' );

/**
 * Sanitize our customizer text inputs.
 */
function buntpress_sanitize_customizer_text( $input ) {
    return sanitize_text_field( force_balance_tags( $input ) );
}

/**
 * Sanitize our customizer URL inputs.
 */
function buntpress_sanitize_customizer_url( $input ) {
    return esc_url( $input );
}
