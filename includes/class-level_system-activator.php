<?php

/**
 * Fired during plugin activation
 *
 * @link       https://sublimelinks.com
 * @since      1.0.2
 *
 * @package    Level_system
 * @subpackage Level_system/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.2
 * @package    Level_system
 * @subpackage Level_system/includes
 * @author     Simon Jakobsen <sublimelinks@gmail.com>
 */
class Level_system_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.2
	 */

	public static function activate() {
		global $wpdb;
		$users = $wpdb->prefix . "users";
		$comments = $wpdb->prefix . "comments";
		$charset_collate = $wpdb->get_charset_collate();

		$createTableUsers = "CREATE TABLE $users (
			ID bigint(20) unsigned NOT NULL auto_increment,
			user_login varchar(60) NOT NULL default '',
			user_pass varchar(64) NOT NULL default '',
			user_nicename varchar(50) NOT NULL default '',
			user_email varchar(100) NOT NULL default '',
			user_url varchar(100) NOT NULL default '',
			user_registered datetime NOT NULL default '0000-00-00 00:00:00',
			user_activation_key varchar(60) NOT NULL default '',
			user_status int(11) NOT NULL default '0',
			user_xp bigint(20) NOT NULL default '0',
			display_name varchar(250) NOT NULL default '',
			PRIMARY KEY  (ID),
			KEY user_login_key (user_login),
			KEY user_nicename (user_nicename) 
		)	$charset_collate";
		
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $createTableUsers );
		
		
		$updateUserXP = "UPDATE $users 
			JOIN $comments 
				ON $users.ID = $comments.user_id
			SET $users.user_xp = $users.user_xp + 10
				WHERE $comments.user_id > 0";
		
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $updateUserXP );

		
	}
}