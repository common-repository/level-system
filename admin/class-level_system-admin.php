<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://sublimelinks.com
 * @since      1.0.2
 *
 * @package    Level_system
 * @subpackage Level_system/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Level_system
 * @subpackage Level_system/admin
 * @author     Simon Jakobsen <sublimelinks@gmail.com>
 */
class Level_system_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.2
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.2
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.2
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->level_system_options = get_option($this->plugin_name);

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.2
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Level_system_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Level_system_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		
		if ( 'settings_page_level_system' == get_current_screen() -> id ) {
             // CSS stylesheet for Color Picker
             wp_enqueue_style( 'wp-color-picker' );            
             wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/level_system-admin.css', array( 'wp-color-picker' ), $this->version, 'all' );
         }
		
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/level_system-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.2
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Level_system_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Level_system_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		
		if ( 'settings_page_level_system' == get_current_screen() -> id ) {
            wp_enqueue_media();   
            wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/level_system-admin.js', array( 'jquery', 'wp-color-picker' ), $this->version, false );         
        }
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/level_system-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function add_plugin_admin_menu() {

		/*
		 * Add a settings page for this plugin to the Settings menu.
		 *
		 * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
		 *
		 *        Administration Menus: http://codex.wordpress.org/Administration_Menus
		 *
		 */
		add_options_page( 'WP Level System', 'WP Level System', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page')
		);
	}
	
	 /**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.2
	 */
	
	public function add_action_links( $links ) {
		/*
		*  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
		*/
	   $settings_link = array(
		'<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
	   );
	   return array_merge(  $settings_link, $links );
	
	}
	
	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.2
	 */
	
	public function display_plugin_setup_page() {
		include_once( 'partials/level-system-admin-display.php' );
	}

	public function options_update() {
		register_setting($this->plugin_name, $this->plugin_name, array($this, 'validate'));
	 }
	
	public function validate($input){
		// All checkboxes inputs
        $valid = array();
		
		//First Color Picker
		$valid['progress_bar_color'] = (isset($input['progress_bar_color']) && !empty($input['progress_bar_color'])) ? 		                                           						sanitize_text_field($input['progress_bar_color']) : '';

		if ( !empty($valid['progress_bar_color']) && !preg_match( '/^#[a-f0-9]{6}$/i', $valid['progress_bar_color']  ) ) { // if user insert a 			HEX 			color with #
			add_settings_error(
				'progress_bar_color',                     // Setting title
				'progress_bar_color_texterror',            // Error ID
				'Please enter a valid hex value color',     // Error message
				'error'                         // Type of message
			);
		}
			
			
		//Second Color Picker
		$valid['text_color'] = (isset($input['text_color']) && !empty($input['text_color'])) ? 		                                           							sanitize_text_field($input['text_color']) : '';

		if ( !empty($valid['text_color']) && !preg_match( '/^#[a-f0-9]{6}$/i', $valid['text_color']  ) ) {
			add_settings_error(
				'text_color',                     // Setting title
				'text_color_texterror',            // Error ID
				'Please enter a valid hex value color',     // Error message
				'error'                         // Type of message
			);
		}
		
		
		//Third Color Picker
		$valid['text_color_within_bar'] = (isset($input['text_color_within_bar']) && !empty($input['text_color_within_bar'])) ? 		                                 sanitize_text_field($input['text_color_within_bar']) : '';

		if ( !empty($valid['text_color_within_bar']) && !preg_match( '/^#[a-f0-9]{6}$/i', $valid['text_color_within_bar']  ) ) {
			add_settings_error(
				'text_color_within_bar',                     // Setting title
				'text_color_within_bar_texterror',            // Error ID
				'Please enter a valid hex value color',     // Error message
				'error'                         // Type of message
			);
		}
		
		//Width
		$valid['progress_width'] = (isset($input['progress_width']) && !empty($input['progress_width'])) ? 		                                           				sanitize_text_field($input['progress_width']) : '';
		
		return $valid;
	}
}
