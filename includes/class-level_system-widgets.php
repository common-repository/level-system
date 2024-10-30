<?php

/**
 * Fired during plugin activation
 *
 * @link       https://sublimelinks.com
 * @since      1.0.0
 *
 * @package    Level_system
 * @subpackage Level_system/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Level_system
 * @subpackage Level_system/includes
 * @author     Simon Jakobsen <sublimelinks@gmail.com>
 */



class Level_system_Widgets extends WP_Widget {

    public function __construct(){
        $widget_ops = array( 
            'classname' => 'level_system_widget',
            'description' => 'Level System Widget',
        );
        parent::__construct( 'level_system_widget', 'Level System Widget', $widget_ops );
    }

    public function widget( $args, $instance ) {
        echo $args['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
        }
        
		
		$user_info = wp_get_current_user();
		$user_ID = $user_info->ID;
		$user_XP = $user_info->user_xp;
		?>
		
		<div class="level-system">
			
					<?php
						//Test the level system by adding an extension to the end of the URL. For instance: ?xp=1510
						$xpoverride = $_GET['xp'];
						if (isset($xpoverride)) { $user_XP = $xpoverride; }



						//init counter: Initialize the loop counter value
						//test counter: Evaluated for each loop iteration. If it evaluates to TRUE, the loop continues. If it evaluates to FALSE, the loop ends.
						//increment counter: Increases the loop counter value
						//Set the second parameter to a higher number for more levels
						for( $level; $level <= 30; $level++ ){
								$beginLevel = ( $level * 100 );

								if( $user_XP < 100 ){
									$beginLevel = ( $beginLevel - 100 );
								}

								$beginLevel = $nextLevel;
								$nextLevel = ( $level * 100 ) + 100;
								$nextLevel = ( $nextLevel * $level );


								if( ( $user_XP >= $beginLevel ) && ( $user_XP <= $nextLevel ) ){
									$actualLevel = $level;
									$actualNextLevel = $nextLevel;

									//tells how many experience points there is within the actual level
									$actualLevelPoints = ( $nextLevel - $beginLevel );

									//tells how many points there is from $xp to $beginLevel
									$currentPoints = ( $user_XP - $beginLevel );
								}
						}
		
						if($user_XP == null) {
							$user_XP = 0;
						}


						$percentage = ( $currentPoints / $actualLevelPoints ) * 100;
						$percentage = number_format( $percentage, 2 );
						$bar = $percentage . "%";		

						echo "<div class=row><div class=col-sm-12>Level: " . $actualLevel . "</div></div><br>";
						echo "<div class=row><div class=col-sm-12>Your XP: " . $user_XP . "</div></div><br>";
						echo $profile;
					?>
				
				
					
					<div class="row">
						
						
						<div class="progress center-block">
							<div class="progress-bar progress-bar-striped active" role="progressbar" style="width:<?php echo $bar;?>">
							<span class="sr-only"><?php echo "&nbsp;" . $user_XP . "&nbsp;/&nbsp;" . $actualNextLevel . "&nbsp;xp" ?></span>
							</div>
						</div>	
					</div>
					<br>
					<?php 
						echo "<div class=row><div class=col-sm-12><p>Percentages to next level: <b>" . ( 100 - $bar ) . "</b> %</p></div></div><br>";
						echo "<div class=row><div class=col-sm-12><p>Next level demands: <b>" . $actualNextLevel . "</b> xp point</p></div></div>";
					?>
					<div class="row">
						<div class="col-sm-12">
							Powered by <a href="https://sublimelinks.com" class="powered-by" target="_blank"> SublimeLinks</a>
						</div>
							
					</div>
			</div>
		<?php
		

		echo $args['after_widget'];
    }   

    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Level system', 'text_domain' );
    ?>
    <p>
    <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Level system title:', 'text_domain' ); ?></label> 
    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" 
		   name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" 
		   type="text" value="<?php echo esc_attr( $title ); ?>">
    </p>
    <?php 
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';

    return $instance;
    }

	


}
add_action('widgets_init', create_function('', 'return register_widget("Level_system_Widgets");'));