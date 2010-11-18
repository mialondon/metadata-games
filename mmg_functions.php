<?php
/*
 * Functions for the mmg plugin
 * 
 * File information:
 * Contains functions to get the objects, print them to the screen, run the turns, save data, etc
 * 
*/

/*
Copyright (C) 2010 Mia Ridge
*/

// ### Add as plugin config setting so it's generalisable. Also db name, not just table names
if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == 'www.museumgames.org.uk') {
  define("table_prefix", "wp_mmg_");
} elseif ($_SERVER['HTTP_HOST'] == 'www.museumgam.es')  {
  define("table_prefix", "wplive_mmg_");
}

// include the game-specific files
require_once(dirname(__FILE__) . "/includes/mmg_simpletagging.php");
require_once(dirname(__FILE__) . "/includes/mmg_simplefact.php");
require_once(dirname(__FILE__) . "/includes/mmg_funtagging.php");
require_once(dirname(__FILE__) . "/includes/mmg_factseeker.php");
require_once(dirname(__FILE__) . "/includes/mmg_reports.php");

define('MMG_IMAGE_URL',  WP_CONTENT_URL.'/plugins/'. basename(dirname(__FILE__)) . '/includes/images/');

/**
 * Gets either a random object or a requested object, prints it to screen
 * 
 * Arguments: none (but it does access URL params)
 * Return values: object ID
 * 
 * @since 0.1
 * 
 */
function printObject() {

  $temp_object_id = checkForParams(); // check to see if an object ID has been supplied
  
  if (!empty($temp_object_id)) { // get specific object 
    $turn_object = mmgGetObject($temp_object_id);
  } else { // get random object
    $turn_object = mmgGetObject();
  }
  
  if(is_object($turn_object)) {
    $institution = urldecode($turn_object->institution);
    $source_display_url = urldecode($turn_object->source_display_url);
    $image_url = urldecode($turn_object->image_url);
    
    // print object name
    $object_name = urldecode($turn_object->name); 
    if ($object_name != 'None') { // Many Powerhouse objects don't have names  
       echo '<h2 class="objectname">'.urldecode($turn_object->name).'</h2>';
    } else {
      // use the description instead
      echo '<p class="objectdescription">'.urldecode($turn_object->description).'</p>';
    }
    
    // ### add test for date and place not being null and add commas appropriately
    echo '<p class="source">Object from '.$institution.'.';
    if ($source_display_url != '') {
      echo ' View the <a href="'.$source_display_url.'">original object</a>.';
    }
    echo '</p>';
    
    echo '<p class="tombstone">'.urldecode($turn_object->interpretative_date).', '.urldecode($turn_object->interpretative_place).' (Accession num: '.urldecode($turn_object->accession_number).')</p>';
    
    // Powerhouse objects have auto-cropped images that end up being a bit too mysterious for gameplay
    // so um, sneakily update the URL to get an uncropped version of the image
    if ($institution == 'Powerhouse Museum') {
      $image_url = str_replace("/thumbs/", "/TLF_mediums/", $image_url);
    } 
    echo '<img class="object_image" src="'. $image_url .'" />';  
  
  } else {
    echo "<p>Whoops, that didn't work.  We can't find the object you're looking for - try refreshing the page. "; // different messages for specific obj sought but not found?
    printRefresh();
    echo "</p>";
  }   
  
  return $turn_object->object_id;
} 
 

function printObjectBookmark($object_id) {
  $temp_object_id = checkForParams();
  
    echo "<p>Want to think about it and come back to this object later?  Save this URL: ";
    if (!empty($temp_object_id)) { // if the page had loaded a requested object successfully, print that URL
      echo '<a href="'.curPageURL().'">'.curPageURL().'</a>'; // since this includes the params we only want this if the query is known to be successful
    } else { // get random object
      $permalink = get_permalink($id); 
      $pageURL = $permalink.'?obj_ID='.$object_id;

      echo '<a href="'.$pageURL.'">'.$pageURL.'</a>'; // 
    }
    echo "</p>";
  
}
 
function checkForParams() {
  global $wp_query;
  if (isset($wp_query->query_vars['obj_ID'])) {
    // sanitise the input ###
   // echo "yes";
    $obj_id = $wp_query->query_vars['obj_ID'];
    return $obj_id;
  } else {
    // return nothing ###
  }
  
  // also maybe gamecode (unless it's taken from the page slug etc)
} 

function printRefresh() {

$permalink = get_permalink( $id );
echo '<a href="'.$permalink.'">Pick me to get a new object.</a>';
/*?>
<form>
<input type="button" class="button" value="get a different object" onclick="location.replace(document.URL)">
</form>
<?php */
}

/*
 * get the page url (hopefully with params) to print for people to come back later
 * From http://www.webcheatsheet.com/php/get_current_page_url.php
 * Use e.g. echo curPageURL();
 */
function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}






////////////// database stuff

// set up variables ###
global $wpdb;

// get and display random object
function mmgGetObject($obj_id = null) {
  
  global $wpdb;
  
  if(!empty($obj_id)) {
    //echo $obj_id;
    $row = $wpdb->get_row ($wpdb->prepare ("SELECT * FROM ". table_prefix."objects WHERE object_id = $obj_id LIMIT 1"));
  } else {
    $row = randomRow(table_prefix.'objects', 'object_id'); // change to table prefix stuff
  }

  if(is_object($row)) {
  
  /* session-based tests to check that the visitor hasn't seen 
   * that object in that session already ### 
   * get another row if they have
   */
   
  } else {
    $row = ''; // for some reason a row wasn't fetched
    //echo 'sucks to be you, dude';
  }
  
  return $row;
}


// get random row from object table 
  function randomRow($table, $column) {
    //echo $table ." " . $column;
  global $wpdb;
  
  // get a random ID
  $random_row = $wpdb->get_row ($wpdb->prepare ("SELECT $column FROM $table ORDER BY RAND(NOW()) LIMIT 1"));
   
  $random_row_id = $random_row->object_id;
  
  // get the full record for that ID
  $random_row = $wpdb->get_row ($wpdb->prepare ("SELECT * FROM $table WHERE object_id = $random_row_id LIMIT 1"));
  
  return $random_row;

  }
  
/**
 * Saves their turn.  Pass turn ID onto function to save UCG.
 * @since 0.1
 * @uses $wpdb
 * 
 * This also uses the session manager plugin's cookie to get a session ID, which is effectively a temporary user ID
 * 
 */
function saveTurn($game_code) {
  // ### check that $game_code isn't null

  global $wpdb; // would already be global, presumably?
 
  // prepare data
  $object_id = $wpdb->prepare($_POST['object_id'] );
  //$ip=@$REMOTE_ADDR; // if globals, otherwise...
  // game code, game version
  $session_id = ($_COOKIE['PHPSESSID']); 
  $ip_address = $_SERVER['REMOTE_ADDR'];
  
  // WordPress username $wp_username, if they have one an
  
  $wpdb->query( $wpdb->prepare( "
  INSERT INTO ". table_prefix."turns 
  (object_id, game_code, session_id, ip_address )
  VALUES ( %d, %s, %s, %s )" ,
  array( $object_id, $game_code, $session_id, $ip_address ) ) ); 
  $turn_id = mysql_insert_id();
  
  // call the appropriate save_$ugc functions with turn_id
  switch ($game_code) {
   case "simpletagging":
     saveTags($turn_id); 
     break;  
   case "simplefacts":
     saveFact($turn_id); 
     break; 
   case "funTagging": 
     saveTagsWithScores($turn_id); 
     break;   
   case "factSeeker":
     saveFactWithScores($turn_id); 
     break;  
  }

}

/**
 * Save tags. Updating to save tags to mmg_turn_tags rather than mmg_turn.
 * 
 * @since 0.1
 * @uses $wpdb
 * 
 */
function saveTags($turn_id) {
    // do stuff
  global $wpdb;
//  global $my_plugin_table; // ### should set this up
    
  $tags = $wpdb->prepare($_POST['tags'] );
  $object_id = $wpdb->prepare($_POST['object_id'] );
  echo '<p class="turn_results">You added tags: '.$_POST['tags'].'</p>';

  // for each comma-separated tag, add a row to the tags table
  
  $tag_array = explode(",",$tags);
  $count=count($tag_array);
  
  for($i=0;$i<$count;$i++)
  
  {
  // echo $tag_array[$i];
  
    $wpdb->query( $wpdb->prepare( "
    INSERT INTO ". table_prefix."turn_tags 
    (turn_id, object_id, tag )
    VALUES ( %d, %d, %s )" ,
    array( $turn_id, $object_id, $tag_array[$i] ) ) ); 
  
  }
    
}

/**
 * Save facts.
 * 
 * @since 0.1
 * @uses $wpdb
 * 
 */
function saveFact($turn_id) {
    // do stuff
  global $wpdb;
//  global $my_plugin_table; // ### should set this up
    
  $tags = $wpdb->prepare($_POST['tags'] );
  $object_id = $wpdb->prepare($_POST['object_id'] );
  $fact_headline = $wpdb->prepare($_POST['fact_headline'] );
  $fact_summary = $wpdb->prepare($_POST['fact_summary'] );
  $fact_source = $wpdb->prepare($_POST['fact_source'] ); 
  
  echo '<p class="turn_results">You added fact: '.$_POST['fact_summary'].'</p>';
  
    $wpdb->query( $wpdb->prepare( "
    INSERT INTO ". table_prefix."turn_facts 
    (turn_id, object_id, fact_headline, fact_summary, fact_source )
    VALUES ( %d, %d, %s, %s, %s )" ,
    array( $turn_id, $object_id, $fact_headline, $fact_summary, $fact_source ) ) ); 
     
}

/**
 * Save facts and adds to player score.
 * 
 * @since 0.3
 * @uses $wpdb
 * Also uses CubePoints plugin
 * 
 */
function saveFactWithScores($turn_id) {
    // do stuff
  global $wpdb;
    
  $tags = $wpdb->prepare($_POST['tags'] );
  $object_id = $wpdb->prepare($_POST['object_id'] );
  $fact_headline = $wpdb->prepare($_POST['fact_headline'] );
  $fact_summary = $wpdb->prepare($_POST['fact_summary'] );
  $fact_source = $wpdb->prepare($_POST['fact_source'] ); 
  
  echo '<p class="turn_results">You added fact: '.$_POST['fact_summary'] .' and you scored points!</p>';
  
    $wpdb->query( $wpdb->prepare( "
    INSERT INTO ". table_prefix."turn_facts 
    (turn_id, object_id, fact_headline, fact_summary, fact_source )
    VALUES ( %d, %d, %s, %s, %s )" ,
    array( $turn_id, $object_id, $fact_headline, $fact_summary, $fact_source ) ) ); 
    
    cp_alterPoints( cp_currentUser(), 150); // 150 points per fact for now ### make a $var
    // what if there's no user?  Add points to turn?
     
}

function saveTagsWithScores($turn_id) { 
    // do stuff
  global $wpdb;
//  global $my_plugin_table; // ### should set this up
    
  $tags = $wpdb->prepare($_POST['tags'] );
  $object_id = $wpdb->prepare($_POST['object_id'] );
  echo '<p class="messages"><img src="'. MMG_IMAGE_URL . 'Dora_talking.png" align="left"> "Thank you! You added tags: '.$_POST['tags']. ' and you scored 10 points. Can you tag this object too?"</p>'; // make a $variable ###

  // for each comma-separated tag, add a row to the tags table
  $tag_array = explode(",",$tags);
  $count=count($tag_array);
  
  for($i=0;$i<$count;$i++)
  {
    $wpdb->query( $wpdb->prepare( "
    INSERT INTO ". table_prefix."turn_tags 
    (turn_id, object_id, tag )
    VALUES ( %d, %d, %s )" ,
    array( $turn_id, $object_id, $tag_array[$i] ) ) ); 
  }
  
  // add points to the users' account (if they have one. If they don't, scores are saved in and calculated from
  // turns table. I can bulk add their scores when they join)
  // not sure about relying so directly on someone else's plugin, maybe move this into a separate file and keep the local points option? ###
  cp_alterPoints( cp_currentUser(), 10);
}

?>