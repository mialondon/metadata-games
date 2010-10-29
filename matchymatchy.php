<?php
/*
Plugin Name: mmg
Plugin URI: http://www.museumgames.org.uk/
Description: mmg is a plugin for a set of metadata games based around museum collections (games that help improve digitised museum collections) 
Version: 0.1
Author: Mia Ridge
Author URI: http://openobjects.org.uk
License: GPL2

*/

/*
Copyright (C) 2010 Mia Ridge

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

*/

/////////// set up activation and deactivation stuff
register_activation_hook(__FILE__,'mmg_install');

function mmg_install() {
	// do stuff when installed
	global $wp_version;
	if (version_compare($wp_version, "3", "<")) {
		deactivate_plugins(basename(__FILE__)); // deactivate plugin
		wp_die("This plugin requires WordPress Version 3 or higher.");	
	} else {
	  // go ahead and set up the custom tables needed
	  /* to do
     * http://abhirama.wordpress.com/2010/06/07/wordpress-plugin-and-widget-tutorial/
     * has a good setup script, at first glance

     * outside the script:
     * global $my_plugin_table;
global $my_plugin_db_version;
global $wpdb;
$my_plugin_table = $wpdb->prefix . 'my_plugin';
$my_plugin_version = '1.0';
     * 
     * inside the function
     *   global $wpdb;
  global $my_plugin_table;
  global $my_plugin_db_version;

  if ( $wpdb->get_var( "show tables like '$my_plugin_table'" ) != $my_plugin_table ) {
    $sql = "CREATE TABLE $my_plugin_table (".
       "id int NOT NULL AUTO_INCREMENT, ".
       "user_text text NOT NULL, ".
       "UNIQUE KEY id (id) ".
       ")";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

    add_option( "my_plugin_db_version", $my_plugin_db_version );
  }
     * 
     * 
     */ 
 }
}


register_deactivation_hook(__FILE__,'mmg_uninstall');

function mmg_uninstall() {
	// do stuff
	// maybe call export thingy too?	
	// presumably delete settings from db?
}


function mmg_export_data() {
	// let users export data generated through game play for use on collections etc
	// is this the same as backing up data?
}

/////////// set up option storing stuff
//setting it up now for use later
// create array of options
$mmg_options_arr=array(
	"mmg_option_game_length"=>'60', // default value of countdown timer
	//"mmg_option_2"=>'Some other value',
	);

// store them
update_option('mmg_plugin_options',$mmg_options_arr); 

// get them
//$mmg_options_arr = get_option('mmg_plugin_options');

// use them
//$mmg_option_game_length = $mmg_options_arr["mmg_option_game_length"];
// end option array setup

/* menu/options stuff
 * 
 * To Do - add option for table name with object data?
 * 
 */
// required in WP 3 but not earlier?
add_action('admin_menu', 'mmg_plugin_menu');

/////////// set up stuff for admin options pages
// add submenu item to existing WP menu
function mmg_plugin_menu() {
add_options_page('MMG settings page', 'MMG settings', 'administrator', __FILE__, 'mmg_settings_page');
}

// call register settings function before admin pages rendered
add_action('admin_init', 'mmg_register_settings');

function mmg_register_settings() {
	// register settings - array, not individual
	register_setting('mmg-settings-group', 'mmg_settings_values');
  // old way of registering a single field
  // register_setting('mmg-settings-group', 'mmg_option_game_length');
}

// write out the plugin options form. Form field name must match option name.
// add other options here as necessary.
function mmg_settings_page() {
?>
<div>
<h2><?php _e('mmg plugin options', 'mmg-plugin') ?></h2>
<form method="post" action="options.php">
<?php settings_fields('mmg-settings-group'); ?>
<?php _e('Game length (seconds)','mmg-plugin') ?> 

<?php /* old way of registering a single field <input type="text" name="mmg_option_game_length" value="<?php echo get_option('mmg_option_game_length'); ?>"> */ ?>

<?php mmg_setting_game_length(); ?>

<p class="submit"><input type="submit" class="button-primary" value=<?php _e('Save changes', 'mmg-plugin') ?> /></p>
</form>
</div>
<?php
}

// get options from array and display as fields
function mmg_setting_game_length() {
  // load options array
  $mmg_options = get_option('mmg_settings_values');
  
  $game_length = $mmg_options['mmg_option_game_length'];
  
  // display form field
  echo '<input type="text" name="mmg_settings_values[mmg_option_game_length]" 
  value="'.esc_attr($game_length).'" />';
}

/////////// set up shortcode
// Sample: [game gametype=simpletagging]
function gameShortCode($atts, $content=null) {
  // do stuff, probably by calling other functions depending on what params are added
  // explode attributes array
  extract(shortcode_atts(array(
  "gametype" => 'simpletagging' // default
  ), $atts));
  if ($gametype == 'mmg') {
    // call that game
    echo "getting mmg...";
  } else {
    // simple tag game as default
    if(@is_file(ABSPATH.'/wp-content/plugins/mmg/mmg_functions.php')) {
      include_once(ABSPATH.'/wp-content/plugins/mmg/mmg_functions.php');
      // call simpletagging
      simpleTagging();
    }
  }
}

// Add the shortcode
add_shortcode('game', 'gameShortCode');

?>