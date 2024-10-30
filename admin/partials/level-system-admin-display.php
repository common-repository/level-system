<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://sublimelinks.com
 * @since      1.0.2
 *
 * @package    Level_system
 * @subpackage Level_system/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">

<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

<form method="post" name="level_system_options" action="options.php">

<?php  

	$options = get_option($this->plugin_name);

	$progress_bar_color = $options['progress_bar_color'];
	$text_color = $options['text_color'];
	$progress_width = $options['progress_width'];
	$text_color_within_bar = $options['text_color_within_bar'];
?>
<br>
<div class="alert-info">
	Here you can customize everything within the level system. You can even test the level system in your browser, simply by typing: ?xp=100 to the end of your 	URL. Change the number all you want to see how it works in practice. It's recommended to test different XP. To see how your color picks looks for different XP 	   points.  
</div>
<br>	
<?php settings_fields($this->plugin_name); ?>

<h4>Color of the progress bar</h4>
<fieldset class="level_system-admin-colors">
	<legend class="screen-reader-text"><span><?php _e('Color of the progress bar', $this->plugin_name);?></span>tt</legend>
	<label for="<?php echo $this->plugin_name;?>-progress_bar_color">
		<input type="text" class="<?php echo $this->plugin_name;?>-color-picker" 
			   id="<?php echo $this->plugin_name;?>-progress_bar_color" 
			   name="<?php echo $this->plugin_name;?>[progress_bar_color]" value="<?php echo $progress_bar_color;?>" />
		<span><?php esc_attr_e('You might not pick a too light or white color', $this->plugin_name);?></span>
	</label>
</fieldset>
<br>
<h4>Color of the text</h4>
<fieldset class="level_system-admin-colors">
	<legend class="screen-reader-text"><span><?php _e('Color of the progress bar text', $this->plugin_name);?></span></legend>
	<label for="<?php echo $this->plugin_name;?>-text_color">
		<input type="text" class="<?php echo $this->plugin_name;?>-color-picker" 
			   id="<?php echo $this->plugin_name;?>-text_color" 
			   name="<?php echo $this->plugin_name;?>[text_color]" value="<?php echo $text_color;?>" />
		
	</label>
</fieldset>
<br>
<h4>Color of the text within the progress bar</h4>
<fieldset class="level_system-admin-colors">
	<legend class="screen-reader-text"><span><?php _e('Color of the text within the progress bar', $this->plugin_name);?></span></legend>
	<label for="<?php echo $this->plugin_name;?>-text_color_within_bar">
		<input type="text" class="<?php echo $this->plugin_name;?>-color-picker" 
			   id="<?php echo $this->plugin_name;?>-text_color_within_bar" 
			   name="<?php echo $this->plugin_name;?>[text_color_within_bar]" value="<?php echo $text_color_within_bar;?>" />
		<span><?php esc_attr_e('Color of the progress bar text', $this->plugin_name);?></span>
	</label>
</fieldset>
<br>
<h4>Width of the progress bar</h4>
<fieldset class="level_system-admin-colors">
	<legend class="screen-reader-text"><span><?php _e('Color of the progress bar text', $this->plugin_name);?></span></legend>
	<label for="<?php echo $this->plugin_name;?>-progress_width">
		<input type="text" class="<?php echo $this->plugin_name;?>" 
			   id="<?php echo $this->plugin_name;?>-progress_width" 
			   name="<?php echo $this->plugin_name;?>[progress_width]" value="<?php echo $progress_width;?>" />
		<span class="alert-info"><?php esc_attr_e('Write a number here. Declare either px or % immediately after your number. Let the field empty for default value.', $this->plugin_name);?></span>
	</label>
</fieldset>
<?php submit_button(__('Save all changes', $this->plugin_name), 'primary','submit', TRUE); ?>