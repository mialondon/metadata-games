<?php
/*
 * Functions for the mmg plugin
 * 
 * File information:
 * Contains functions to get the objects, print them to the screen, run the turns, save data, etc
 * 
 */

/*
 * Copyright (C) 2010 Mia Ridge
 */


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

  //$temp_object_id = checkForParams(); // check to see if an object ID has been supplied
  list($object_id, $skipped_ID) = checkForParams();
  
  // do the check here for whether they've skipped an object
  if (!empty($skipped_ID)) { 
    mmgUpdateSkipped($skipped_ID);
  } // if logic works that it's either skipped or passing an object, then merge this test with below
  
  if (!empty($temp_object_id)) { // get specific object 
    $turn_object = mmgGetObject($temp_object_id);
  } else { // get random object
    $turn_object = mmgGetObject();
  }
  
  if(is_object($turn_object)) {
    $institution = urldecode($turn_object->institution);
    $source_display_url = urldecode($turn_object->source_display_url);
    $image_url = urldecode($turn_object->image_url);
    $interpretative_date = urldecode($turn_object->interpretative_date);
    $interpretative_place = urldecode($turn_object->interpretative_place);
    $accession_number = urldecode($turn_object->accession_number);
    $object_id = urldecode($turn_object->object_id);
   

    $object_print_string;
 
    // print object name
    $object_name = urldecode($turn_object->name); 
    if ($object_name != 'None') { // Many Powerhouse objects don't have names  
       $object_print_string = '<h2 class="objectname">'.urldecode($turn_object->name).'</h2>';
    } else {
      // use the description instead
      $object_print_string = '<p class="objectdescription">'.urldecode($turn_object->description).'</p>';
    }
    
    // ### add test for date and place not being null and add commas appropriately
    $object_print_string .= '<p class="source">';
    if ($source_display_url != '') {
      $object_print_string .= 'View <a href="'.$source_display_url.'">object on the '.$institution.' site</a>.';
    } else {
      $object_print_string .= 'Object from: '.$institution.'.';
    }
    $object_print_string .= '</p>';
    
    $object_print_string .= '<p class="tombstone">';
    
    if ($interpretative_date != '') {
      $object_print_string .= 'Date: '. $interpretative_date . '&nbsp;&nbsp;';
    }
    if ($interpretative_place != '') {
      $object_print_string .= 'Place: '. $interpretative_place . '&nbsp;&nbsp;';
    }
    $object_print_string .= '(Accession num: '.$accession_number.')</p>';
    
    // Powerhouse objects have auto-cropped images that end up being a bit too mysterious for gameplay
    // so um, sneakily update the URL to get an uncropped version of the image
    if ($institution == 'Powerhouse Museum') {
      $image_url = str_replace("/thumbs/", "/TLF_mediums/", $image_url);
    } 
    $object_print_string .= '<img class="object_image" src="'. $image_url .'" />';
    // add licence terms for Powerhouse
    if ($institution == 'Powerhouse Museum') {
      $object_print_string .= '<div class="object_image_credit">Thumbnails under license from Powerhouse Museum.</div>';
    } 
  
  } else {
    $object_print_string .= "<p>Whoops, that didn't work.  We can't find the object you're looking for - try refreshing the page. "; // different messages for specific obj sought but not found?
    printRefresh($object_id);
    $object_print_string .= "</p>";
  }   
  
  return array ($turn_object->object_id, $object_print_string);

} 
 

function printObjectBookmark($object_id) {
  //$temp_object_id = checkForParams();
  list($temp_object_id, $skipped_ID) = checkForParams();  
  
    echo "<p>Tip: want more time to think about it and come back to this object later?  Save this URL: ";
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
    $obj_id = $wp_query->query_vars['obj_ID'];
    //return $obj_id;
  } else {
    unset($obj_id); // will probably kill something
  }
  
  if (isset($wp_query->query_vars['skipped_ID'])) {
    // sanitise the input ###
    $skipped_ID = $wp_query->query_vars['skipped_ID'];
    //return $skipped_ID;
  } else {
    unset($skipped_ID); // will probably kill something
  }
  return array ($obj_id, $skipped_ID); 
  
  // also maybe gamecode (unless it's taken from the page slug etc)
} 


/*
 * Print a 'refresh' link that reloads the page without an object.
 * Add a parameter to trigger function to save the ID of the skipped object
 */
function printRefresh($temp_object_id) {

 // $temp_object_id = checkForParams();

  $permalink = get_permalink( $id );
  echo '<a href="'.$permalink.'?skipped_ID='.$temp_object_id.'">Pick me to get a new object.</a>';
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
  
  if(!empty($obj_id)) { // get a specific object if requested
    $row = $wpdb->get_row ($wpdb->prepare ("SELECT * FROM ". table_prefix."objects WHERE object_id = $obj_id LIMIT 1"));
  } else {
    $row = randomRow(table_prefix.'objects', 'object_id'); // get from view that doesn't include shown objects
  }

  if(is_object($row)) {

  } else {
    $row = ''; // for some reason a row wasn't fetched
  }
  
  return $row;
}


// get random row from object table 
  function randomRow($table, $column) {
    //echo $table ." " . $column;
  global $wpdb;
  
  // get a random ID
  $random_row = $wpdb->get_row ($wpdb->prepare ("SELECT $column FROM $table ORDER BY RAND(NOW()) LIMIT 1")); // ### add test that ID isn't in wp_mmg_objects_shown or is somehow less likely to be
   
  $random_row_id = $random_row->object_id;
  
  // get the full record for that ID
  $random_row = $wpdb->get_row ($wpdb->prepare ("SELECT * FROM $table WHERE object_id = '$random_row_id' LIMIT 1"));
  
  // update wp_mmg_objects_shown with the ID of that object
  $test_id = $wpdb->get_row ($wpdb->prepare ("SELECT object_id FROM ". table_prefix."objects_shown WHERE object_id = " . $random_row_id . " "));
  if(is_object($test_id)) {  // then update
    $wpdb->query( $wpdb->prepare( "
    UPDATE ". table_prefix."objects_shown
    SET show_count = show_count+1
    WHERE object_id = " . $test_id->object_id . " "
    ) );  
  } else { // insert as not already there
    $wpdb->query( $wpdb->prepare( "
    INSERT INTO ". table_prefix."objects_shown 
    (object_id, show_count)
    VALUES ( %d, %d)" ,
    array($random_row_id, 1) ) ); 
  }

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

  global $wpdb; 
  global $current_user;
 
  // prepare data
  $object_id = $wpdb->prepare($_POST['object_id'] );
  // game code, game version
  $session_id = ($_COOKIE['PHPSESSID']); 
  $ip_address = $_SERVER['REMOTE_ADDR'];

  if(is_user_logged_in()) {
    get_currentuserinfo();
    $wp_username = $current_user->user_login; // could also use display name but KISS for now
  } // will need to go back and update previous turns with login if they sign up ###
  
  $wpdb->query( $wpdb->prepare( "
  INSERT INTO ". table_prefix."turns 
  (object_id, game_code, session_id, ip_address, wp_username )
  VALUES ( %d, %s, %s, %s, %s )" ,
  array( $object_id, $game_code, $session_id, $ip_address, $wp_username ) ) ); 
  $turn_id = mysql_insert_id();
  
  // call the appropriate save_$ugc functions with turn_id
  switch ($game_code) {
   case "simpletagging":
     saveTags($turn_id); 
     break;  
   case "simplefacts":
     saveFact($turn_id); 
     break; 
   case "funtagging": 
     saveTagsWithScores($turn_id);
     break;   
   case "factseeker":
     saveFactWithScores($turn_id); 
     break;  
  }

}

/**
 * Take the object id, get the thumbnail, add it to the next free spot in the completion box
 * 
 * @since 0.3
 * @uses $wpdb
 * 
 */
function drawCompletionBox($game_code) {
  echo "<h3>Objects you've tagged in this game</h3>";

  // store object id for player (table or view???? ####)
  
  // get the object ID, write it to the completion box (then do images)
  
  global $wpdb;
  global $current_user;

  // number of objects tagged
  $sql = "SELECT " . table_prefix. "turns.object_id, image_url, turn_id FROM ". table_prefix. "turns, ". table_prefix. "objects WHERE ". table_prefix. "turns.object_id = ". table_prefix. "objects.object_id AND game_code = '" . $game_code . "' "; // does case matter for game code? ###
  
  if(is_user_logged_in()) {
    get_currentuserinfo();
    $sql = $sql . " AND wp_username = '" . $current_user->user_login ."' "; // could also use display name but KISS for now
  } else {
    $sql = $sql . " AND session_id = '" .   $session_id = ($_COOKIE['PHPSESSID']) ."' "; 
  } 
  $sql = $sql . ' ORDER BY turn_id' ;
  
  $results = $wpdb->get_results($wpdb->prepare ($sql));
  
  //$wpdb->show_errors();
  //$wpdb->print_error();

  echo '<table border="0" bordercolor="#FFCC00" style="background-color:#FFFFCC" width="280" cellpadding="0" cellspacing="0"><tr>';

  if ($results) {
    
    $c = $wpdb->num_rows;
    $tc = 5 - ($c % 5); // how many empty cells to fill?
    $i = 1; // for table row end
    
    foreach ($results as $result) {
      echo '<td>';
      // echo $result->object_id; // should update view to get object title for alt text/title tip
      echo '<img class="widget_thumbnail" src="'. urldecode($result->image_url) .'" width="40" />';
      echo "</td>";
      if ($i % 5 == 0) {
        echo '</tr><tr>';
      }
      $i++;
    }
    while ($tc > 0) { // fill empty cells with '?' to encourage filling
      echo '<td><span class="next_box">?</span></td>';
      $tc = $tc-1;
    }
    echo '</tr></table>';
  } else {  // 'no results yet';
    $tc = 5;
    while ($tc > 0) { // fill empty cells with '?' to encourage filling
      echo '<td><span class="next_box">?</span></td>';
      $tc = $tc-1;
    }
  }

  echo '</tr></table>';
  
    // temp proof-of-concept
  mmgSiteStats();
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
  
  $score = 250; // 250 points per fact for now ### make a config setting
    
  $tags = $wpdb->prepare($_POST['tags'] );
  $object_id = $wpdb->prepare($_POST['object_id'] );
  $fact_headline = $wpdb->prepare($_POST['fact_headline'] );
  $fact_summary = $wpdb->prepare($_POST['fact_summary'] );
  $fact_source = $wpdb->prepare($_POST['fact_source'] ); 
  
  //echo '<p class="turn_results">You added fact: '.$_POST['fact_summary'] .' and you scored ' . $score . ' points!</p>';
  
    $wpdb->query( $wpdb->prepare( "
    INSERT INTO ". table_prefix."turn_facts 
    (turn_id, object_id, fact_headline, fact_summary, fact_source )
    VALUES ( %d, %d, %s, %s, %s )" ,
    array( $turn_id, $object_id, $fact_headline, $fact_summary, $fact_source ) ) ); 

  // update the turn table with their score
  $wpdb->query( $wpdb->prepare( "
  UPDATE ". table_prefix."turns
  SET turn_score = " . $score . "
  WHERE turn_id = " . $turn_id . " "
  ) );   
    
    cp_alterPoints( cp_currentUser(), $score); 
     
}

function saveTagsWithScores($turn_id) { 

  global $wpdb;
  $tags = $wpdb->prepare($_POST['tags'] );
  $object_id = $wpdb->prepare($_POST['object_id'] );  
    
  // find out how many tags submitted (for the score)
  $tag_array = explode(",",$tags);
  $count=count($tag_array);
  
  // score is currently 5 points per tag.
  $score = $count * 5;  
  
  // make variant thank you messages, depending on count/random ###
  echo '<p class="messages"><img src="'. MMG_IMAGE_URL . 'Dora_talking.png" align="left"> "Thank you! You added ' . $count . ' tags and you scored <strong>' . $score . '</strong> points.  I\'ve added your object to your stash. Can you tag this object too?"</p>';
  
  // for each comma-separated tag, add a row to the tags table
  for($i=0;$i<$count;$i++)
  {
    $wpdb->query( $wpdb->prepare( "
    INSERT INTO ". table_prefix."turn_tags 
    (turn_id, object_id, tag )
    VALUES ( %d, %d, %s )" ,
    array( $turn_id, $object_id, $tag_array[$i] ) ) ); 
  }
  
  // update the turn table with their score
  $wpdb->query( $wpdb->prepare( "
  UPDATE ". table_prefix."turns
  SET turn_score = " . $score . "
  WHERE turn_id = " . $turn_id . " "
  ) );   
  
  // add points to the users' account (if they have one. If they don't, scores are saved in and calculated from
  // turns table. I can bulk add their scores when they join)
  // not sure about relying so directly on someone else's plugin, maybe move this into a separate file and keep the local points option? ###
  cp_alterPoints( cp_currentUser(), $score); // this is doubling up, but just for now ###
}

/*
 * update the database with the ID of the skipped object
 */
function mmgUpdateSkipped($skipped_ID) {
  global $wpdb;
  echo '<h1>$skipped_ID '.$skipped_ID.'</h1>';
  // update wp_mmg_objects_shown with the ID of that object
  $test_id = $wpdb->get_row ($wpdb->prepare ("SELECT object_id FROM ". table_prefix."objects_shown WHERE object_id = " . $skipped_ID . " "));
  if(is_object($test_id)) {  // then update
    $wpdb->query( $wpdb->prepare( "
    UPDATE ". table_prefix."objects_shown
    SET skip_count = skip_count+1
    WHERE object_id = " . $skipped_ID . " "
    ) );  
  } else { // insert as not already there
    $wpdb->query( $wpdb->prepare( "
    INSERT INTO ". table_prefix."objects_shown 
    (object_id, skip_count)
    VALUES ( %d, %d)" ,
    array($skipped_ID, 1) ) ); 
  }
  
}


/* add function documentation ### */
function mmgGetUserScoreByGame() {
 
  if (!empty ($GLOBALS['my_game_code'])) {
    global $wpdb;
  
    // number of objects tagged
    $sql = "SELECT sum(turn_score) as player_score FROM wp_mmg_turns WHERE game_code = '".$GLOBALS['my_game_code']."' AND session_id = '". ($_COOKIE['PHPSESSID']) ."' ";
    //SELECT count(DISTINCT object_id) AS num_objects FROM '. table_prefix.'turns ';
  
    $results = $wpdb->get_row ($wpdb->prepare ($sql));

    echo '<ul><li>';  
    if(is_object($results)) {
      if ($results->player_score > 0) {
          echo $results->player_score . ' points.';
      } else { // sql returned results row but no points for that game
          echo 'No points for this game yet.  Start playing to earn points';  
      }
    }
    echo '</li></ul>'; 
  } else {
    echo 'No points for this game yet.  Start playing to earn points and help a museum.';
  }
  
}

?>