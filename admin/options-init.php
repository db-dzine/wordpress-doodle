<?php

    /**
     * For full documentation, please visit: http://docs.reduxframework.com/
     * For a more extensive sample-config file, you may look at:
     * https://github.com/reduxframework/redux-framework/blob/master/sample/sample-config.php
     */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }

    // This is your option name where all the Redux data is stored.
    $opt_name = "Wordpress_Doodle_options";

    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

    $theme = wp_get_theme(); // For use with some settings. Not necessary.

    $args = array(
        'opt_name' => 'Wordpress_Doodle_options',
        'use_cdn' => TRUE,
        'dev_mode' => FALSE,
        'display_name' => 'Wordpress Doodle',
        'display_version' => '1.0.1',
        'page_title' => 'Wordpress Doodle',
        'update_notice' => TRUE,
        'intro_text' => '',
        'footer_text' => '&copy; '.date('Y').' DB-Dzine',
        'admin_bar' => TRUE,
        'menu_type' => 'menu',
        'menu_icon' =>  plugin_dir_url( __FILE__ ) . 'img/menu-icon.png',
        'menu_title' => 'Doodle',
        'allow_sub_menu' => TRUE,
        'page_parent' => 'edit.php?post_type=doodles',
        'customizer' => TRUE,
        'default_mark' => '*',
        'hints' => array(
            'icon_position' => 'right',
            'icon_color' => 'lightgray',
            'icon_size' => 'normal',
            'tip_style' => array(
                'color' => 'light',
            ),
            'tip_position' => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect' => array(
                'show' => array(
'duration' => '500',
'event' => 'mouseover',
                ),
                'hide' => array(
'duration' => '500',
'event' => 'mouseleave unfocus',
                ),
            ),
        ),
        'output' => TRUE,
        'output_tag' => TRUE,
        'settings_api' => TRUE,
        'cdn_check_time' => '1440',
        'compiler' => TRUE,
        'page_permissions' => 'manage_options',
        'save_defaults' => TRUE,
        'show_import_export' => TRUE,
        'database' => 'options',
        'transient_time' => '3600',
        'network_sites' => TRUE,
    );

    Redux::setArgs( $opt_name, $args );

    /*
     * ---> END ARGUMENTS
     */

    /*
     * ---> START HELP TABS
     */

    $tabs = array(
        array(
            'id'      => 'help-tab',
            'title'   => __('Information', 'wordpress-doodle' ),
            'content' => __('<p>Need support? Please use the comment function on codecanyon.</p>', 'wordpress-doodle' )
        ),
    );
    Redux::setHelpTab( $opt_name, $tabs );

    // Set the help sidebar
    // $content = __('<p>This is the sidebar content, HTML is allowed.</p>', 'wordpress-doodle' );
    // Redux::setHelpSidebar( $opt_name, $content );


    /*
     * <--- END HELP TABS
     */


    /*
     *
     * ---> START SECTIONS
     *
     */

    Redux::setSection( $opt_name, array(
        'title'  => __('Settings', 'wordpress-doodle' ),
        'id'     => 'general',
        'desc'   => __('Need support? Please use the comment function on codecanyon.', 'wordpress-doodle' ),
        'icon'   => 'el el-home',
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => __('General', 'wordpress-doodle' ),
        'id'         => 'general-settings',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'enable',
                'type'     => 'checkbox',
                'title'    => __('Enable', 'wordpress-doodle' ),
                'subtitle' => __('Enable Doodle.', 'wordpress-doodle' ),
                'default'  => '1',
            ),
            array(
                'id'       => 'name',
                'type'     => 'text',
                'title'    => __( 'Your Name', 'wordpress-doodle' ),
                'subtitle' => __('This will be used for polls that are created by you.', 'wordpress-doodle'), 
                'default'  => '',
            ),
            array(
                'id'       => 'email',
                'type'     => 'text',
                'title'    => __( 'Doodle Email', 'wordpress-doodle' ),
                'subtitle' => __('Put your Doodle Email here.', 'wordpress-doodle'), 
                'default'  => '',
            ),
            array(
                'id'       => 'password',
                'type'     => 'text',
                'title'    => __( 'Doodle Password', 'wordpress-doodle' ),
                'subtitle' => __('Put your Doodle Password here.', 'wordpress-doodle'), 
                'default'  => '',
            ),
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => __('Advanced settings', 'wordpress-doodle' ),
        'desc'       => __('Custom stylesheet / javascript.', 'wordpress-doodle' ),
        'id'         => 'advanced',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'customCSS',
                'type'     => 'ace_editor',
                'mode'     => 'css',
                'title'    => __('Custom CSS', 'wordpress-doodle' ),
                'subtitle' => __('Add some stylesheet if you want.', 'wordpress-doodle' ),
            ),
            array(
                'id'       => 'customJS',
                'type'     => 'ace_editor',
                'mode'     => 'javascript',
                'title'    => __('Custom JS', 'wordpress-doodle' ),
                'subtitle' => __('Add some javascript if you want.', 'wordpress-doodle' ),
            ),           
        )
    ));


    /*
     * <--- END SECTIONS
     */
