<?php
/*
 * Functions for the plugin
 * 
 * File information:
 * Contains functions to get the objects, run the turns, save data, etc
 * 
*/

/*
Copyright (C) 2014 Mia Ridge
*/

/**
 * Gets either a random object or a requested object, returns formatted text with the relevant
 * institution, image, source display url, interpretative date, interpretative place, accession number,
 * internal object ID and object description. Contains some customisations for quirks in images or data
 * for particular institutions.
 * 
 * Also deals with skipped objects based on the call from the previous page, updating the skipped count
 * 
 * Arguments: none (but it does access URL params)
 * Return values: object ID
 * 
 * @since 0.1
 * 
 */
function printObject() {

  list($temp_object_id, $skipped_ID) = checkForParams(); // check to see if an object ID has been supplied
  
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
    $object_description = urldecode($turn_object->description);

    $object_print_string;
 
	// start schema.org CreativeWork div here
	$object_print_string = '<div itemscope itemtype="http://schema.org/CreativeWork">';
 
    // print object name
    $object_name = urldecode($turn_object->name); 
    if ($object_name != 'None') { // Many Powerhouse objects don't have names  
       $object_print_string .= '<h2 class="objectname" itemprop="name"><a name="object">'.urldecode($turn_object->name).'</a></h2>';
    } else {
      // use the description instead
      $object_print_string .= '<h2 class="noobjectname"><a name="object">[untitled]</a></h2>';
      $object_print_string .= '<p class="objectdescription" itemprop="description">'.$object_description.'</p>';
    }
    
    // ### add test for date and place not being null and add commas appropriately

    # if it's a British Library Commons image, include a description for further context
    if ($institution = 'British Library on Flickr Commons') {
      $object_print_string .= '<p class="objectdescription" itemprop="description">'.$object_description.'</p>';
    }

    $object_print_string .= '<p class="source">';
    if ($source_display_url != '') {
      $object_print_string .= 'View <a href="'.$source_display_url.'" target="_blank" itemprop="sameAs">object on the '.$institution.' site</a> (opens in new window).';
    } else {
      $object_print_string .= 'Object from: '.$institution.'.';
    }
    $object_print_string .= '</p>';
    
    $object_print_string .= '<p class="tombstone">';
    
    if ($interpretative_date != '') {
      $object_print_string .= '<span itemprop="dateCreated"';
      if ($institution == 'British Library on Flickr Commons') { // mixing in schema.org/Book stuff
        $object_print_string .= ' itemprop="datePublished"  content="'.$interpretative_date.'"';
      } 
      $object_print_string .= '>Date: '. $interpretative_date . '</span>&nbsp;&nbsp;';
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
    $object_print_string .= '<img class="object_image" itemprop="image" src="'. $image_url .'" />';
    // add licence terms for Powerhouse
    if ($institution == 'Powerhouse Museum') {
      $object_print_string .= '<div class="object_image_credit">Thumbnails under license from Powerhouse Museum.</div>';
    } 
  
  } else {
    $object_print_string .= "<p>Whoops, that didn't work.  We can't find the object you're looking for - try refreshing the page. "; // different messages for specific objects sought but not found?
    printRefresh($object_id);
    $object_print_string .= "</p>";
  }   

	// end schema.org div
    $object_print_string .= "</div>";
  
  return array ($turn_object->object_id, $object_print_string);

} 
 

function printObjectBookmark($object_id) {

  list($temp_object_id, $skipped_ID) = checkForParams();  
  
    echo '<p class="saveurl">Tip: save this URL if you want more time to think or research: ';
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
    $obj_id = $wp_query->query_vars['obj_ID'];
    //return $obj_id;
  } else {
    unset($obj_id); // possibly pointless
  }
  
  if (isset($wp_query->query_vars['skipped_ID'])) {
    $skipped_ID = $wp_query->query_vars['skipped_ID'];
    //return $skipped_ID;
  } else {
    unset($skipped_ID); // possibly pointless
  }
  return array ($obj_id, $skipped_ID); 
  
  // also maybe gamecode (unless it's taken from the page slug etc)
} 


/*
 * Print a 'refresh' link that reloads the page without an object.
 * Add a parameter to trigger function to save the ID of the skipped object
 */
function printRefresh($temp_object_id) {

  $permalink = get_permalink( $id );
  echo ' <a href="'.$permalink.'?skipped_ID='.$temp_object_id.'">Get a different object.</a>';
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

/*
 * quite possibly a mess and not used yet
 * This seemed to assume many more games would be added and that people would want to play a random game
 */
function mmgGetRandomGamePage() {
  //$pages = &get_pages(); // get only game pages 
  //$pageInd = rand(0, count($pages) - 1);
  //echo $pages[$pageInd]->post_content;
        $pages = get_pages();
        $pageInd = rand(0, count($pages) - 1);
//        $pages[$pageInd]->post_content; ?>
<a href="<?php echo get_page_link($page[$pageInd]->ID) ?>"><?php echo $page[$pageInd]->post_title ?></a>
<?php
}



////////////// database stuff

// set up variables ###
global $wpdb;

// get and display random object
function mmgGetObject($obj_id = null) {
  
  global $wpdb;
  
  if(!empty($obj_id)) { // get a specific object if requested
    $row = $wpdb->get_row ("SELECT * FROM ". table_prefix."objects WHERE object_id = $obj_id LIMIT 1");
  } else {
    $row = randomRow(table_prefix.'objects', 'object_id'); // get from view that doesn't include shown objects
  }

  if(is_object($row)) {

  } else {
    $row = ''; // for some reason a row wasn't fetched
  }
  
  return $row;
}

/*
 * Returns a 'random' object, with some caveats - it chhecks the objects table first,
 * in case there are objects that haven't yet been shown (e.g. new objects) then
 * selects from the least-shown objects in the objects_shown table
 *
 */ 

// get random row from object table 
  function randomRow($table, $column) {
    //echo $table ." " . $column;
  global $wpdb;
  $exclude_ids;
  
  // get objects user has already seen
  $sql = mmgSQLObjectsByUser('');
  //echo '<h1>from mmgsqlobjectsbyuser: '. $sql . '</h1>'; // +++
  if (!empty($sql)) { // there's a session or username
    $user_objects = $wpdb->get_results ($sql);  
    if ($user_objects) { // if query returns results
      foreach ($user_objects as $user_object) {
        $exclude_ids .= $user_object->object_id.', ';
      }
      $exclude_ids = trim($exclude_ids, ', ');
    } else {
      unset($exclude_ids);
    }    
  } else {
    unset($exclude_ids);
  }  
  
  // debugging
  // echo '<h1>Session cookie: '. ($_COOKIE['PHPSESSID']) .'</h1>'; // +++

  
  // get a random ID from objects not shown table
  $random_row_sql = "SELECT $column FROM $table WHERE object_id NOT IN (SELECT object_id FROM ". table_prefix."objects_shown) ";
  if (!empty($exclude_ids)) { 
    $random_row_sql .=" AND object_id NOT IN (".$exclude_ids .") ";
  }  
  $random_row_sql .= " ORDER BY RAND(NOW()) LIMIT 1"; // 
  //echo $random_row_sql;
  $random_row = $wpdb->get_row ($random_row_sql);
  
  if ($random_row) { // then object that hasn't been shown before exists
    $random_row_id = $random_row->object_id;
    //echo 'in object not shown before exists'; // +++
  } else { // get object that has been shown before
    $random_row_sql = "SELECT $column FROM ". table_prefix."objects_shown ";
      if (!empty($exclude_ids)) { // is this the right test?  If has no data ###
        $random_row_sql .=" WHERE object_id NOT IN (".$exclude_ids .") ";
      }
      $random_row_sql .= "ORDER BY show_count ASC, RAND(NOW()) LIMIT 1";
      // echo '<h1>from $random_row_sql in objects shown before : '. $random_row_sql . '</h1>'; // +++
      $random_row = $wpdb->get_row ($random_row_sql); 
      if ($random_row) {
        $random_row_id = $random_row->object_id;
      } 
  }

  if ($random_row_id < 1) { // just in case something went horribly wrong, at least don't die - but is this test working? It's IDs that are there but don't exist in obj table that kill things ###
    $get_random_object_sql = "SELECT * FROM $table ORDER BY RAND(NOW()) LIMIT 1";
  } else { // get the full record for that ID and life is good
    $get_random_object_sql = "SELECT * FROM $table WHERE object_id = '$random_row_id' LIMIT 1";  }
  
  // echo $get_random_object_sql; // uncomment if 'seen all the objects' message shows
  
  $random_row = $wpdb->get_row ($get_random_object_sql);
  
  // if no result, we've run out of objects that you haven't seen yet
  // or the objects_shown table is referencing objects no longer in the main table
  if (!$random_row) {
    $get_random_object_sql = "SELECT * FROM $table ORDER BY RAND(NOW()) LIMIT 1";
    $random_row = $wpdb->get_row ($get_random_object_sql);
  } // hopefully that should do it  
  
  if ($random_row) {
    // check whether it's been shown before
    $temp_id = $wpdb->get_row ($wpdb->prepare ("SELECT object_id FROM ". table_prefix."objects_shown WHERE object_id = %d", $random_row_id));
    if(is_object($temp_id)) {  // then update
      $wpdb->query( $wpdb->prepare( "
      UPDATE ". table_prefix."objects_shown
      SET show_count = show_count+1
      WHERE object_id = %d", $temp_id->object_id) );  
    } else { // insert as not already there
      $wpdb->query( $wpdb->prepare( "
      INSERT INTO ". table_prefix."objects_shown 
      (object_id, show_count)
      VALUES ( %d, %d)" ,
      array($random_row_id, 1) ) ); 
    }
  } else {
    //echo '<h1>Something went wrong, or you\'ve seen all the objects!  Use the contact form to request more objects or report this error - you might even get a special award for your achievements.</h1>';
    echo '<h1>Whoops! Something went wrong, please let me know by tweeting @mia_out or emailing me via the contact page. Terribly sorry about that!</h1>'; // general emergency text, assuming reloading works    
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
  $object_id = $_POST['object_id'];
  // game code, game version
  $session_id = ($_COOKIE['PHPSESSID']); 
  $ip_address = $_SERVER['REMOTE_ADDR'];

  if(is_user_logged_in()) {
    get_currentuserinfo();
    $wp_username = $current_user->user_login; // could also use display name but KISS for now as getting the username you want is easy
  } 
  
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

/*
 * Returns the sql needed to get the objects with UGC from a particular user or session ID
 * just to save having different versions to keep in sync
 * Uses $game_code (optional - you may not want it for all actions).
 * @uses $current_user;
 */
function mmgSQLObjectsByUser($game_code) {

  global $current_user;
  $session_stuff = ($_COOKIE['PHPSESSID']);
    
  // objects for this user
  $sql = "SELECT " . table_prefix. "turns.object_id, image_url, turn_id FROM ". table_prefix. "turns, ". table_prefix. "objects WHERE ". table_prefix. "turns.object_id = ". table_prefix. "objects.object_id ";
  
  if ($game_code != '') {
   $sql .= " AND game_code = '" . $game_code . "' ";
  }
  
  if(is_user_logged_in()) {
    get_currentuserinfo();
    $sql .= " AND wp_username = '" . $current_user->user_login ."'  ORDER BY turn_id"; 
  } elseif (!empty($session_stuff)) {  
      $sql .= " AND session_id = '" . $session_stuff ."'  ORDER BY turn_id";
  } else {
    unset($sql); // function should return nothing as no username or session so no objects to get ###
  }
  
  return $sql;
  
}

/**
 * Take the object id, get the thumbnail, add it to the next free spot in the completion box
 * 
 * @since 0.3
 * @uses $wpdb
 * 
 */
function drawCompletionBox($game_code) {
  echo "<h3>Objects you've played in this game</h3>";

  // store object id for player (table or view???? ####)
  
  // get the object ID, write it to the completion box (then do images)
  
  global $wpdb;
  global $current_user;
  $i = 1; // for table row end

  // number of objects tagged
  $sql = mmgSQLObjectsByUser($game_code);
  
  $results = $wpdb->get_results($sql);

  echo '<table border="0" class="completion_box" width="280" cellpadding="0" cellspacing="0"><tr';

  if ($results) {
    
    $c = $wpdb->num_rows; // how many result rows overall?
    $tc = 5 - ($c % 5); // how many empty cells to fill?
    $num_rows = $c/5; // how many rows are filled this turn?
    $num_rows = (int) $num_rows; // really, honestly, I want an int
    
    if ($c > 4) { // first row is full
      echo ' class="filled_row"';
    }
    echo '>';
    
    foreach ($results as $result) {
      echo '<td>'; 
      // should update view to get object title for alt text/title tip ###
      echo '<a href="' . PATH_TO_UGCREPORTS_PAGE . '?obj_ID=' . $result->object_id .'" title="View all content added about this object"><img class="widget_thumbnail" src="'. urldecode($result->image_url) .'" width="35" /></a>';
      echo "</td>";
      if ($i % 5 == 0) { // is the end of a row
        echo '</tr><tr'; 
        if ($num_rows > 1) { // next row is not full
          echo ' class="filled_row"';
          $num_rows = $num_rows-1; // reduce number of rows left
        } else {
          echo ' class="completion_box"'; // row not filled
        }
        echo '>';
      }
      $i++;
    }
    while ($tc > 0) { // fill empty cells with '?' to encourage filling
      echo '<td><span class="next_box">'.$tc.'</span></td>'; 
      $tc = $tc-1;
    }
  } else {  // 'no results yet';
    $tc = 5;
    echo '>';
    while ($tc > 0) { // fill empty cells with '?' to encourage filling
      echo '<td><span class="next_box">?</span></td>'; 
      $tc = $tc-1;
    }
  }

  echo '</tr></table>';
  
  // aww, a nice message
  mmgSiteStats();
}

/**
 * Save tags to mmg_turn_tags
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
    
  //$tags = $_POST['tags']; // Not needed!
  $object_id = $_POST['object_id'];
  $fact_headline = $_POST['fact_headline'];
  $fact_summary = $_POST['fact_summary'];
  $fact_source = $_POST['fact_source']; 
  
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
     
  //$tags = $_POST['tags']; // Not needed!
  $object_id = $_POST['object_id'];
  $fact_headline = $_POST['fact_headline'];
  $fact_summary = $_POST['fact_summary'];
  $fact_source = $_POST['fact_source']; 
  
  //echo '<p class="turn_results">You added fact: '.$_POST['fact_summary'] .' and you scored ' . $score . ' points!</p>';
  
    $wpdb->query( $wpdb->prepare( "
    INSERT INTO ". table_prefix."turn_facts 
    (turn_id, object_id, fact_headline, fact_summary, fact_source )
    VALUES ( %d, %d, %s, %s, %s )" ,
    array( $turn_id, $object_id, $fact_headline, $fact_summary, $fact_source ) ) ); 

  // update the turn table with their score
  $wpdb->query( $wpdb->prepare( "
  UPDATE ". table_prefix."turns
  SET turn_score = %d 
  WHERE turn_id = %d" . $turn_id . " "
  ), FACTSCORE, $turn_id );   
    
    cp_alterPoints( cp_currentUser(), FACTSCORE); 
     
}

function saveTagsWithScores($turn_id) { 

  global $wpdb;
  $tags = $_POST['tags'];
  $object_id = $_POST['object_id'];  
    
  // find out how many tags submitted (for the score)
  // remove extra , from the end first
  $tags = rtrim($tags, " ,");
  $tags = ltrim($tags, " ,"); // hmm ###
  if (!empty($tags)) {
  $tag_array = explode(",",$tags);
  $count=count($tag_array);
  
  $score = $count * TAGSCORE;
   
  // for each comma-separated tag, add a row to the tags table
  for($i=0;$i<$count;$i++)
  {
    $wpdb->query( $wpdb->prepare( "
    INSERT INTO ". table_prefix."turn_tags 
    (turn_id, object_id, tag )
    VALUES ( %d, %d, %s )" ,
    array( $turn_id, $object_id, trim($tag_array[$i]) ) ) ); 
  }
  
  // update the turn table with their score
  $wpdb->query( $wpdb->prepare( "
  UPDATE ". table_prefix."turns
  SET turn_score = %s 
  WHERE turn_id = %d ", $score, $turn_id ) );   
//  SET turn_score = " . $score . "
//  WHERE turn_id = " . $turn_id . " "
//  ) ); 
  
  echo '<div class="messages">';
  $response_string = mmgGetDoraTurnMessages($score);
  echo $response_string;

  $validation_string = mmgGetDoraTurnValidation($object_id, $turn_id); 
  echo $validation_string;  
  
  echo '"</div>'; // needs a full stop or not?
  
  // add points to the users' account (if they have one).
  // not sure about relying so directly on someone else's plugin, maybe move this into a separate file and keep the local points option? ###
  cp_alterPoints( cp_currentUser(), $score); // this is doubling up, but just for now ###
  } else {
    echo '<p class="messages"><img src="'. MMG_IMAGE_URL . 'Dora_umwhat.gif" align="left"> "Whoops! Did I miss them, or did you forget to add tags?"</p>';
  }
  
}

/*
 * update the database with the ID of the skipped object
 */
function mmgUpdateSkipped($skipped_ID) {
  global $wpdb;

  // update wp_mmg_objects_shown with the ID of that object
  $test_id = $wpdb->get_row ($wpdb->prepare ("SELECT object_id FROM ". table_prefix."objects_shown WHERE object_id = %d", $skipped_ID ));
  if(is_object($test_id)) {  // then update
    $wpdb->query( $wpdb->prepare( "
    UPDATE ". table_prefix."objects_shown
    SET skip_count = skip_count+1
    WHERE object_id = %d ", $skipped_ID ));
  } else { // insert as not already there
    $wpdb->query( $wpdb->prepare( "
    INSERT INTO ". table_prefix."objects_shown 
    (object_id, skip_count)
    VALUES ( %d, %d)" ,
    array($skipped_ID, 1) ) ); 
  }
  
}


/* add function documentation ###
 * Gets scores by username or session id 
 * ie if user is logged in then by username otherwise by session with message to sign up
 *
 * @uses $wpdb, $current_user;
*/
function mmgGetUserScoreByGame() {
  $scoreString = '<ul>'; 
 
  if (!empty ($GLOBALS['my_game_code'])) {
    global $wpdb;
    global $current_user;
  
    // number of objects tagged
    if (!is_user_logged_in() ) {
      $sql = "SELECT sum(turn_score) as player_score FROM ". table_prefix."turns WHERE game_code = '".$GLOBALS['my_game_code']."' AND session_id = '". ($_COOKIE['PHPSESSID']) ."' ";

    } else {
      $sql = "SELECT sum(turn_score) as player_score FROM ". table_prefix."turns WHERE game_code = '".$GLOBALS['my_game_code']."' AND wp_username = '". $current_user->user_login ."' ";  
    }
  
    $results = $wpdb->get_row($sql);

    if(is_object($results)) {
      if ($results->player_score > 0) {
          $scoreString .= '<li class="mmg_score">' . $results->player_score . ' points.';
      } else { // sql returned results row but no points for that game
          $scoreString .=  '<li>No points for this game yet.  Start playing to earn points';  
      }
    }
  } else { // might not be a game page? ###
    $scoreString .=  '<li>No points for this game yet.  Start playing to earn points and help a museum.';
  }
   
  $scoreString .= '</li></ul>'; 

  return $scoreString;
}

/*
 * when a user registers, save the points they've earned in that session (by session id).
 * Check that their points haven't already been saved; add them if not and update marker
 * Go back and update their previous rows with their username
 *
 * @uses $wpdb, $current_user
 */
function mmgSaveNewUserPoints() {
  
  global $wpdb;
  global $current_user;
  $session_id = ($_COOKIE['PHPSESSID']);
  
  // update their previous turn rows now that they have a username
    $wpdb->query( $wpdb->prepare( "UPDATE ". table_prefix."turns SET wp_username = '%s' WHERE session_id = '%d' ", $current_user->user_login, $session_id ) );  // hmm re ''

  // check that we haven't registered their score already by testing cubepoints score
  $current_user_score = (int) cp_displayPoints($current_user->ID, 1, 0);
    if ($current_user_score <= 0) { // no points recorded in cubepoints yet
  
    // get their total score from the turns table
    $results = $wpdb->get_row ($wpdb->prepare ("SELECT sum(turn_score) as player_score FROM ". table_prefix."turns WHERE session_id = '%d' ", $session_id ));
// temp while updating prepare
// $sql = "SELECT sum(turn_score) as player_score FROM ". table_prefix."turns WHERE session_id = '". $session_id ."' ";    

    
  
    if(is_object($results)) {
      $score = $results->player_score;
      //echo '<h1> $score = ' . $score . '.</h1>';
      if ($score > 0) {
        cp_alterPoints(cp_currentUser(), $score); // they're not logged in, they've only just registered!
      } // else sql returned results row but no points for that game. 
    }
  }

}

/*
 * gets a random bunch of objects and draws up a 3x3 (?) block for object selection
 * for e.g. Donald or all objects with UGC for reports
 * God only knows what to do about image sizes - faking it in img tag for now (evil, sorry) ###
 * @uses $wpdb
 */
function mmgDisplayObjectBlocks($callingFunction) {
  
  global $wpdb;
  $object_id;
  $i = 1;
  
  if ($callingFunction == 'donald') {
    // get x random objects
    
    while ($i < 9) { // for 8 objects
      echo '<div class="factseeker child">';       
    
      $object_to_print = randomRow(table_prefix.'objects', 'object_id');
      
      if ($object_to_print) {
        list($object_id, $object_string_to_print) = mmgPrintObjectBlock($object_to_print);
        echo $object_string_to_print;
      $i++; 
      }

      // link to game page - needs WP base URL? ###
     echo '<p class="play_factseeker"><a href="'. '?obj_ID=' . $object_id .'" class="play_link">Take the fact challenge for this object</a></p>';
     echo '<div style="clear:both"></div></div>';    
    }

  }
  
  // if called for Donald, get 9 random objects - hopefully really random - it'll be a good test
  // if called for UGC reports, get all, ordered by dates
  
  // for each object, call mmgPrintObjectBlock($object_id, block_type)
  // block types are: donald, ugc report by object, ugc report by user
  
  // print link to appropriate place e.g. Donald game page, object UGC report, etc.
  
}

function mmgPrintObjectBlock($my_object) {
  
    if(is_object($my_object)) {
    $institution = urldecode($my_object->institution);
    $source_display_url = urldecode($my_object->source_display_url);
    $image_url = urldecode($my_object->image_url);
    $interpretative_date = urldecode($my_object->interpretative_date);
    $interpretative_place = urldecode($my_object->interpretative_place);
    $accession_number = urldecode($my_object->accession_number);
    $object_id = urldecode($my_object->object_id);
    $object_name = urldecode($my_object->name);
    $object_description = urldecode($my_object->description);
  
    $object_print_string;

    // print object name
    if ($object_name != 'None') { // Many Powerhouse objects don't have names  
       $object_print_string .= '<h3 class="objectname">'.$object_name.'</h3>';
    } else {
      // use the description instead
      $object_print_string = '<h3 class="noobjectname">[untitled]</h3>'; 
    }

     // print image. Get smaller Science Museum images for this layout, keep Powerhouse small size
    if ($institution == 'Science Museum') {
      $image_url = str_replace("size=Small", "size=Inline", $image_url);
    } 
    $object_print_string .= '<div class="float_left"><img class="object_image" src="'. $image_url .'" />';
    $object_print_string .= '</div>';
    
    if (!empty($object_description)) {
      if (strlen($object_description) > 249) {
        $object_description = substr($object_description, 0, 249) . '...';
      }
      $object_print_string .= '<p class="objectdescription">'.$object_description.'</p>';
    }
    
    

    // ### add test for date and place not being null and add commas appropriately
    $object_print_string .= '<p class="summary">';
    if ($source_display_url != '') {
      $object_print_string .= 'Object from: '.$institution.'. ';
    }    
    if ($interpretative_date != '') {
      $object_print_string .= 'Date: '. $interpretative_date . '&nbsp;&nbsp;';
    }
    if ($interpretative_place != '') {
      $object_print_string .= 'Place: '. $interpretative_place . '&nbsp;&nbsp;';
    }
    $object_print_string .= ' (Accession num: '.$accession_number.')</p>';
  
      // add licence terms for Powerhouse
    if ($institution == 'Powerhouse Museum') {
      $object_print_string .= '<p class="object_image_credit">Image credit: Powerhouse Museum.</p>';
    }
  
  } 
  
  return array ($object_id, $object_print_string);
 
}

/*
 * Work up links for sharing
 */
function mmgGetShareLinks() {
  // http://www.facebook.com/sharer.php?u=http%3A%2F%2Flocalhost%2Fwordpress%2Fcharlie%2F&t=Charlie
  
  // <a rel="nofollow" target="_blank" style="background: transparent url(http://localhost/wordpress/wp-content/plugins/share-and-follow/default/16/facebook.png) no-repeat top left;padding-left:20px;line-height:20px;" class="facebook"  href="http://www.facebook.com/sharer.php?u=http%3A%2F%2Flocalhost%2Fwordpress%2Fcharlie%2F&amp;t=Charlie" title="Recommend this post : Charlie on Facebook"><span class="head">Recommend on Facebook</span></a>
  
  
  // http://twitter.com/home/?status=Come+and+play+these+games+too%21++-+http%3A%2F%2Flocalhost%2Fwordpress%2Fcharlie%2F"
  // <a rel="nofollow" target="_blank" style="background: transparent url(http://localhost/wordpress/wp-content/plugins/share-and-follow/default/16/twitter.png) no-repeat top left;padding-left:20px;line-height:20px;" class="twitter" href="http://twitter.com/home/?status=Come+and+play+these+games+too%21++-+http%3A%2F%2Flocalhost%2Fwordpress%2Fcharlie%2F" title="Tweet this post : Charlie on Twitter"><span class="head">Tweet about it</span></a>
  $permalink = get_permalink($id);
  $permalink = urlencode($permalink);
  
  $twitter = '<a rel="nofollow" target="_blank" style="background: transparent url(http://localhost/wordpress/wp-content/plugins/share-and-follow/default/16/twitter.png) no-repeat top left;padding-left:20px;line-height:20px;"';
  $facebook = 'http://www.facebook.com/sharer.php?u=' . $permalink;
  
  return $links;
  
}

?>