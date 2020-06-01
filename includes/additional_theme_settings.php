<?php

/**
* add new header layout option called "Header for TCET"
*/
add_filter( 'redux/options/orgafresh_opt/field/alus_header_layout/register', 'add_tcet_header_option', 11);

  function add_tcet_header_option($field){
    $field['options']['layout_tcet'] = array(
        'title' => 'Layout for TCET',
        'img' => THEME_URL . '/assets/images/header/header_tcet.png'
    );

    return $field;
  }



/**
* add urls for header layout TCET
*/
add_filter( 'redux/options/orgafresh_opt/section/header', 'add_tcet_header_section_urls', 11);

  function add_tcet_header_section_urls($section){
    $section['fields'][] = array (
                          'id' => 'alus_login_url',
                          'type' => 'text',
                          'title' => esc_html__('Login url', 'orgafresh'),
                          'desc' => esc_html__('Url for login, leave this field empty to hide button' , 'orgafresh' ),
                          'required' => array('alus_header_layout','equals','layout_tcet'),
                          'compiler' => true,
                      );
    $section['fields'][] = array (
                          'id'   => 'alus_donate_url',
                          'type' => 'text',
                          'title' => esc_html__('Donate url', 'orgafresh'),
                          'desc' => esc_html__('Url for donate, leave this field empty to hide button' , 'orgafresh' ),
                          'required' => array('alus_header_layout','equals','layout_tcet'),
                          'compiler' => true,
                      );
    return $section;
  }


add_action('redux/options/orgafresh_opt/sections', 'add_footer_section');

// add_action('redux/loaded', 'add_footer_section');
// add_filter('redux/_url', 'test_filter');


function add_footer_section($sections){

  $available_menues = array();

  foreach (wp_get_nav_menus() as $key => $menu) {
    $available_menues[$menu->term_id] = $menu->name;
  }

  $sections[] = array(
        'title'            => __( 'Footer', 'redux-framework-demo' ),
        'id'               => 'velesh_footer',
        'desc'             => __( 'Configures footer settings', 'redux-framework-demo' ),
        'customizer_width' => '400px',
        'icon'             => 'el el-arrow-down',
        'priotity' => 1,
        'permissions' => 'manage_options',
        'fields' => array(
          array(
            'id' => 'velesh_footer_menu',
            'title' => esc_html__('Menu', 'orgafresh'),
            'type' => 'select',
            'options' => $available_menues,
          ),
          array(
            'id' => 'velesh_social_menu',
            'title' => esc_html__('Social Menu', 'orgafresh'),
            'desc' => esc_html__('Links will be displayed as icons','orgafresh'),
            'type' => 'select',
            'options' => $available_menues,
          ),
          array(
            'id' => 'velesh_footer_copyrights',
            'title' => esc_html__('Copyrights Text', 'orgafresh'),
            'type' => 'textarea',
            'compiler' => true,
            'rows' => '2',
          ),
        ),
  );


  return $sections;
}



