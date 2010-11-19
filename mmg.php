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
// Sample: [mmgame gametype=simpletagging]
function gameShortCode($atts, $content=null) {
  // do stuff, probably by calling other functions depending on what params are added
  // explode attributes array
  
  if(@is_file(ABSPATH.'/wp-content/plugins/mmg/mmg_functions.php')) {
      include_once(ABSPATH.'/wp-content/plugins/mmg/mmg_functions.php'); 
  }
  
  extract(shortcode_atts(array( // lowercase cos the short tags are, elsewhere camel.
  "gametype" => 'simpletagging' // default
  ), $atts));
  if ($gametype == 'simplefacts') {
    simpleFacts();
  } elseif ($gametype == 'funtagging') {
    funTagging();
  } elseif ($gametype == 'factseeker') {
    factSeeker(); 
  } else {
    // simple tag game as default
    simpleTagging();
  }
}

// Add the shortcode
add_shortcode('mmgame', 'gameShortCode');

/* adding a filter for object ID and gamecode so players can return via a link */
function parameter_objID($oVars) {
    $oVars[] = "obj_ID";    // represents the name of the product category as shown in the URL
    return $oVars;
}

// hook add_query_vars function into query_vars
add_filter('query_vars', 'parameter_objID');

function parameter_gamecode($gVars) {
    $gVars[] = "gamecode";    // represents the name of the product category as shown in the URL
    return $gVars;
}
add_filter('query_vars', 'parameter_gamecode');

// add widget
function mmgPlayerScoreWidgetInit()  
 { 
     // register widget
     // http://tut7.com/2010/06/17/how-to-write-a-%E2%80%9Cmost-popular-by-views%E2%80%9D-wordpress-plugin/
     // says parameters parameters are: id of the container,title on the widget page,content function
     wp_register_sidebar_widget('mmg_player_score', 'mmg player score', 'mmgPlayerScoreWidget_test'); 
 }
 
 add_action('init', 'mmgPlayerScoreWidgetInit');
 
// from http://codex.wordpress.org/Widgets_API, to learn
/**
 * FooWidget Class
 */
class mmgPlayerScoreWidget extends WP_Widget {
    /** constructor */
    function mmgPlayerScoreWidget() {
        parent::WP_Widget(false, $name = 'mmgPlayerScoreWidget');	
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {		
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        ?>
              <?php echo $before_widget; ?>
                  <?php if ( $title )
                        echo $before_title . $title . $after_title; ?>
                  Hello, other World!
              <?php echo $after_widget; ?>
        <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {				
	$instance = $old_instance;
	$instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {				
        $title = esc_attr($instance['title']);
        ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
        <?php 
    }

} // class mmgPlayerScoreWidget 

?>