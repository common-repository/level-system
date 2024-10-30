<?php

/**
 * Register all actions and filters for the plugin
 *
 * @link       https://sublimelinks.com
 * @since      1.0.2
 *
 * @package    Level_system
 * @subpackage Level_system/includes
 */

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @package    Level_system
 * @subpackage Level_system/includes
 * @author     Simon Jakobsen <sublimelinks@gmail.com>
 */
class Level_system_Loader {

	/**
	 * The array of actions registered with WordPress.
	 *
	 * @since    1.0.2
	 * @access   protected
	 * @var      array    $actions    The actions registered with WordPress to fire when the plugin loads.
	 */
	protected $actions;

	/**
	 * The array of filters registered with WordPress.
	 *
	 * @since    1.0.2
	 * @access   protected
	 * @var      array    $filters    The filters registered with WordPress to fire when the plugin loads.
	 */
	protected $filters;

	/**
	 * Initialize the collections used to maintain the actions and filters.
	 *
	 * @since    1.0.2
	 */
	public function __construct() {

		$this->actions = array();
		$this->filters = array();

	}

	/**
	 * Add a new action to the collection to be registered with WordPress.
	 *
	 * @since    1.0.2
	 * @param    string               $hook             The name of the WordPress action that is being registered.
	 * @param    object               $component        A reference to the instance of the object on which the action is defined.
	 * @param    string               $callback         The name of the function definition on the $component.
	 * @param    int                  $priority         Optional. The priority at which the function should be fired. Default is 10.
	 * @param    int                  $accepted_args    Optional. The number of arguments that should be passed to the $callback. Default is 1.
	 */
	public function add_action( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->actions = $this->add( $this->actions, $hook, $component, $callback, $priority, $accepted_args );
	}

	/**
	 * Add a new filter to the collection to be registered with WordPress.
	 *
	 * @since    1.0.2
	 * @param    string               $hook             The name of the WordPress filter that is being registered.
	 * @param    object               $component        A reference to the instance of the object on which the filter is defined.
	 * @param    string               $callback         The name of the function definition on the $component.
	 * @param    int                  $priority         Optional. The priority at which the function should be fired. Default is 10.
	 * @param    int                  $accepted_args    Optional. The number of arguments that should be passed to the $callback. Default is 1
	 */
	public function add_filter( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->filters = $this->add( $this->filters, $hook, $component, $callback, $priority, $accepted_args );
	}

	/**
	 * A utility function that is used to register the actions and hooks into a single
	 * collection.
	 *
	 * @since    1.0.2
	 * @access   private
	 * @param    array                $hooks            The collection of hooks that is being registered (that is, actions or filters).
	 * @param    string               $hook             The name of the WordPress filter that is being registered.
	 * @param    object               $component        A reference to the instance of the object on which the filter is defined.
	 * @param    string               $callback         The name of the function definition on the $component.
	 * @param    int                  $priority         The priority at which the function should be fired.
	 * @param    int                  $accepted_args    The number of arguments that should be passed to the $callback.
	 * @return   array                                  The collection of actions and filters registered with WordPress.
	 */
	private function add( $hooks, $hook, $component, $callback, $priority, $accepted_args ) {

		$hooks[] = array(
			'hook'          => $hook,
			'component'     => $component,
			'callback'      => $callback,
			'priority'      => $priority,
			'accepted_args' => $accepted_args
		);

		return $hooks;

	}

	/**
	 * Register the filters and actions with WordPress.
	 *
	 * @since    1.0.2
	 */
	public function run() {

		foreach ( $this->filters as $hook ) {
			add_filter( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
		}

		foreach ( $this->actions as $hook ) {
			add_action( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
		}
		
		add_action( 'wp_insert_comment', 'giveUserXPOnNewComment' );
		function giveUserXPOnNewComment( $comment_id ){
			
			global $wpdb;
			$users = $wpdb->prefix . "users";
			$comments = $wpdb->prefix . "comments";
			
			$findUserIDInComment = $wpdb->get_var("SELECT user_id
				FROM $comments
				WHERE comment_ID = $comment_id");
			
			$updateUserXP = "UPDATE $users 
				SET user_xp = user_xp + 10
				WHERE ID = $findUserIDInComment";
			
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $updateUserXP );
			
		}
		
		
		add_action( 'delete_comment', function( $comment_id ) {
			
			global $wpdb;
			$users = $wpdb->prefix . "users";
			$comments = $wpdb->prefix . "comments";
			
			$findUserIDInComment = $wpdb->get_var("SELECT user_id
				FROM $comments
				WHERE comment_ID = $comment_id");
			
			$updateUserXP = "UPDATE $users 
				SET user_xp = user_xp - 10
				WHERE ID = $findUserIDInComment";
			
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $updateUserXP );
			
		} );
		
		
		function getColorFromDB(){
			$level_system_options_array_from_db = get_option("level_system");
			$progress_bar_color = implode( ', ', array_slice( $level_system_options_array_from_db, 0, 1 ) );
			$text_color = implode( ', ', array_slice( $level_system_options_array_from_db, 1, 1 ) );
			$text_color_within_bar = implode( ', ', array_slice( $level_system_options_array_from_db, 2, 1 ) );
			$progress_width = implode( ', ', array_slice( $level_system_options_array_from_db, 3, 1 ) );
			?>
			<style>
				.progress-bar{
					background-color:
						<?php 
							echo $progress_bar_color."!important; }";
						?>
						
				.level-system{
					color:
						<?php
							echo $text_color."!important; }";
						?>
						
				.sr-only{
					color:
						<?php
							echo $text_color_within_bar."!important; }";
						?>
					
				.progress{
					max-width:
						<?php
							echo $progress_width."!important; }";
						?>
			</style>
			<?php
			
		}
		add_action('wp_head', 'getColorFromDB');
		
	}

}
