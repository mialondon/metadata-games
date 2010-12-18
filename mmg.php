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

// ### Add as plugin config setting so it's generalisable. Also db name, not just table names
if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == 'www.museumgames.org.uk' || $_SERVER['HTTP_HOST'] == 'museumgames.org.uk') {
  define("table_prefix", "wp_mmg_");
} elseif ($_SERVER['HTTP_HOST'] == 'www.museumgam.es' || $_SERVER['HTTP_HOST'] == 'museumgam.es')  {
  define("table_prefix", "wplive_mmg_");
}

// include the game-specific files
require_once(dirname(__FILE__) . "/includes/mmg_simpletagging.php");
require_once(dirname(__FILE__) . "/includes/mmg_simplefact.php");
require_once(dirname(__FILE__) . "/includes/mmg_funtagging.php");
require_once(dirname(__FILE__) . "/includes/mmg_factseeker.php");
require_once(dirname(__FILE__) . "/includes/mmg_reports.php");
require_once(dirname(__FILE__) . "/includes/mmg_widgets.php");

// these should really be made into config options ###
define('MMG_IMAGE_URL',  WP_CONTENT_URL.'/plugins/'. basename(dirname(__FILE__)) . '/includes/images/');
define('MMG_PLUGIN_URL',  WP_PLUGIN_URL.'/includes/'. basename(dirname(__FILE__)));
define("FACTSCORE", "250");
define("TAGSCORE", "5");
define("PATH_TO_DONALD_PAGE", WP_CONTENT_URL. "/dagmar/"); // path to page with Donald game shortcode, from WordPress root
define("PATH_TO_DORA_PAGE", WP_CONTENT_URL. "/charlie/"); // path to page with Donald game shortcode, from WordPress root
define("PATH_TO_UGCREPORTS_PAGE", WP_CONTENT_URL. "/reports/"); // path to page with Donald game shortcode, from WordPress root

/* for live */
// define("PATH_TO_DONALD_PAGE", "/donald/"); // path to page with Donald game shortcode, from WordPress root
// define("PATH_TO_DORA_PAGE", "/dora/"); // path to page with Donald game shortcode, from WordPress root
// define("PATH_TO_UGCREPORTS_PAGE", "/content-added-so-far/"); // path to page with Donald game shortcode, from WordPress root


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
/*
 *
 * Not sure if I should include mmgSaveNewUserPoints() here but as it's called each time there's
 * a shortcode (ie we're on a game page), maybe it's the best place for it
 * 
 */
function gameShortCode($atts, $content=null) {
  
  if(@is_file(ABSPATH.'/wp-content/plugins/mmg/mmg_functions.php')) {
      include_once(ABSPATH.'/wp-content/plugins/mmg/mmg_functions.php'); 
  }
  
  extract(shortcode_atts(array( // lowercase cos the short tags are, elsewhere camel.
  "gametype" => 'simpletagging' // default
  ), $atts));
  if ($gametype == 'simplefacts') {
    simpleFacts();
  } elseif ($gametype == 'funtagging') {
    funtagging();
  } elseif ($gametype == 'factseeker') { // Dec 14 - using mmgFactseekerChoice until have versions on shortcodes
    mmgFactseekerChoice();
    // factseeker();
  } elseif ($gametype == 'objectugcreport') {
    mmgListObjectUGC(); 
  } else {
    // simple tag game as default
    simpleTagging();
  }
  
  $GLOBALS['my_game_code'] = $gametype; // so it's accessible in the widget

}

// Add the shortcode
add_shortcode('mmgame', 'gameShortCode');

/* adding a filter for object ID and gamecode so players can return via a link */
function parameter_objID($oVars) {
    $oVars[] = "obj_ID"; 
    return $oVars;
}

// hook add_query_vars function into query_vars
add_filter('query_vars', 'parameter_objID');

function parameter_gamecode($gVars) {
    $gVars[] = "gamecode";    // not used?
    return $gVars;
}
add_filter('query_vars', 'parameter_gamecode');

/* adding a filter for skipped object ID */
function parameter_skippedID($oVars) {
    $oVars[] = "skipped_ID"; 
    return $oVars;
}
add_filter('query_vars', 'parameter_skippedID');

// add widget, trying smashing book method this time
class mmgHello extends WP_Widget {
  
  function mmgHello() {
	parent::WP_Widget(false, $name = 'mmg Hello');
  }
  
  function widget($args, $instance) {
	extract( $args );
	?>
		<?php echo $before_widget; ?>
			<?php echo $before_title
				. $instance['title'] // will be settable by widget users
				. $after_title; ?>
                        <?php if (!empty ($GLOBALS['my_game_code'])) {
                         drawCompletionBox($GLOBALS['my_game_code']);
                        }
                        // experiment
                        //mmgGetRandomGamePage(); // ###
                        ?>
		<?php echo $after_widget; ?>
	<?php
  }
  
  function update($new_instance, $old_instance) {
	return $new_instance;
  }
  
  // use something like this to trap for nasties on the way into the update function
  // $instance['music'] = strip_tags( $new_instance['music'] );
  
/* Users can't set the title, so commenting this out for now.
   function form($instance) {
	$title = esc_attr($instance['title']);
	?>
          <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label>
          </p>
	<?php
  } */
}

add_action('widgets_init', create_function('', 'return register_widget("mmgHello");'));

/*
 * Adding login widget
 * To Do: change header message depending on whether user is logged in
 * Picks up some of the things that Theme My Login doesn't do, like showing profile and logout link
 *
*/
class mmgLoginWidget extends WP_Widget {
  
  function mmgLoginWidget() {
	parent::WP_Widget(false, $name = 'mmg login widget');
  }
  
  function widget($args, $instance) {
    extract( $args );
      ?>
	<?php if ( is_user_logged_in() ) { // only show if the user is logged in
        echo $before_widget; ?>
  	<?php echo $before_title;
          if (!empty($instance['title'])) {
            echo $instance['title']; // if settable by widget users
          } else {
            echo 'Manage your account';
          }
	echo $after_title; ?>
        <?php  ?><ul><li>
        <a href="<?php echo wp_logout_url( get_permalink() ); ?>" title="Logout">Logout</a>  
        </li></ul>
        <?php echo $after_widget; ?>
	<?php }
  }
  
  function update($new_instance, $old_instance) {
	return $new_instance;
  }

}

add_action('widgets_init', create_function('', 'return register_widget("mmgLoginWidget");'));


/*
 * Displays user scores by game, even if they're not registeret yet
 *
*/
class mmgScoreWidget extends WP_Widget {
  
  function mmgScoreWidget() {
	parent::WP_Widget(false, $name = 'mmg score widget');
  }
  
  function widget($args, $instance) {
    extract( $args );
      ?>
	<?php echo $before_widget; ?>
  	<?php echo $before_title;
          if (!empty($instance['title'])) {
            echo $instance['title']; // if settable by widget users
          } else {
            echo 'Your score for this game:';
          }
	echo $after_title; ?>
        <?php if (!empty ($GLOBALS['my_game_code'])) {
                  $scoreString = mmgGetUserScoreByGame();
                  echo $scoreString;
              }
              if (!is_user_logged_in() ) {
                echo 'Login or register to save your points';
              }
        ?>
	  <?php echo $after_widget; ?>
	<?php
  }
  
  function update($new_instance, $old_instance) {
	return $new_instance;
  }

}

add_action('widgets_init', create_function('', 'return register_widget("mmgScoreWidget");'));
?>