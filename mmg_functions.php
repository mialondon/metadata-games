<?php
/*
 * Functions for the plugin
 * 
 * File information:
 * Contains functions to get the objects, run the turns, save data, etc
 * 
*/

/*
Copyright (C) 2010 Mia Ridge
*/

/**
 * Sets up some stuff and prints the form for the 'add tags' activity
 * needs a good refactor as any shared functionality for general screens is moved out, etc
 * @since 0.1
 * 
 */
function simpleTagging() {
  // deal with submitted data, if any
  if($_POST['submitTags'] == "Tag!") {
  //if (isset($_POST['submitTags'])) {
    // do stuff
  save_turn('simpletagging');
  } else {
    //echo "not submitted.";
  }
    
  
  // get an object to display and write it to the screen
  $turn_object = mmg_get_object();
  
  if(is_object($turn_object)) {
    
    echo '<div class="something">';
    // print_r($turn_object);
    // print object name
    $object_name = urldecode($turn_object->name); 
    if ($object_name != 'None') {   
       echo '<h2 class="objectname">'.urldecode($turn_object->name).'</h2>';
    } else {
      // use the description instead  ### add test for Powerhouse objects as their descriptions are short
      echo '<h2 class="objectname">'.urldecode($turn_object->description).'</h2>';
    }
    
    // ### add test for date and place not being null and add commas appropriately
    echo '<p class="tombstone">'.urldecode($turn_object->interpretative_date).', '.urldecode($turn_object->interpretative_place).' (Accession num: '.urldecode($turn_object->accession_number).')</p>';
    
    echo '<img src="'. urldecode($turn_object->image_url).'" />';
    
    // call the form, give it the object_id for hidden field
    tag_form($turn_object->object_id);
    
    // get a new object
    echo "Skip it?";
    print_refresh();    
    
    echo '</div>'; 
    
  } else {
    echo "Whoops, that didn't work - try refreshing the page.";
    print_refresh();
  }  
  
}

/**
 * Sets up some stuff and calls the form for the 'add a fact' activity
 * @since 0.1
 * 
 */
function simpleFacts() {
  // deal with submitted data, if any
  if($_POST['submitTags'] == "Add your fact") {
  //if (isset($_POST['submitTags'])) {
    // do stuff
  save_turn('simplefacts');
  } else {
    //echo "not submitted.";
  }
    
  
  // get an object to display and write it to the screen
  $turn_object = mmg_get_object();
  
  if(is_object($turn_object)) {
    
    echo '<div class="something">';
    echo '<h2 class="objectname">'.urldecode($turn_object->name).'</h2>';
    echo '<p class="tombstone">'.urldecode($turn_object->interpretative_date).', '.urldecode($turn_object->interpretative_place).' (Accession num: '.urldecode($turn_object->accession_number).')</p>';
    
    echo '<img src="'. urldecode($turn_object->image_url).'" />';
    
    // call the form, give it the object_id for hidden field
    fact_form($turn_object->object_id);
    
    // get a new object
    echo "Skip it?";
    print_refresh();    
    
    echo '</div>'; 
    
  } else {
    echo "Whoops, that didn't work - try refreshing the page.";
    print_refresh();
  }  
  
}

/**
 * Prints the form for the 'add tags' activity
 * @since 0.1
 * 
 */
function tag_form($object_id) {
?>
  <form action="" method="post">

<!--<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">-->
  <input type="hidden" value="<?php echo $object_id ?>" name="object_id" />
  <fieldset>
  <legend>Add words to describe this object</legend>
  <label for="tags">Tags</label>
  <input type="text" name="tags" class="tags" size="80" maxlength="300" value="" />
  <p class="submit"><input class="button" name="submitTags" type="submit" value="Tag!" /></p>
  <p class="hint">Tip: separate each tag with a comma, like this: tag, label, words to describe things, name.</p>
  </fieldset>
  </form>
<?php  
}

/**
 * Prints the form for the 'add a fact' activity
 * @since 0.1
 * 
 */
function fact_form($object_id) {
?>
  <form action="" method="post">
  <input type="hidden" value="<?php echo $object_id ?>" name="object_id" />
  <fieldset>
  <legend>Add a fact about this object</legend>
  <label for="fact_headline">Headline</label><br />
  <input type="text" name="fact_headline" class="fact" size="80" maxlength="100" value="" /><br />
  <label for="fact_summary">Fact summary</label>
  <textarea name="fact_summary" cols="40" rows="5">
Find an interesting fact to share about this object.
</textarea>
  <label for="fact_source">Source</label>
  <input type="text" name="fact_source" class="fact" size="100" maxlength="300" value="" />
  <p class="submit"><input class="button" name="submitTags" type="submit" value="Add your fact" /></p>
  <p class="hint">The headline should 'sell' your fact. The source should provide evidence for your fact.</p>
  </fieldset>
  </form>
<?php  
}


/**
 * Saves their turn.  Pass turn ID onto function to save UCG.
 * @since 0.1
 * @uses $wpdb
 * 
 * This also uses the session manager plugin's cookie to get a session ID, which is effectively a temporary user ID
 * 
 */
function save_turn($game_code) {
  // ### check that $game_code isn't null

  global $wpdb; // would already be global, presumably?
 
  // prepare data
  $object_id = $wpdb->escape($_POST['object_id'] );
  //$ip=@$REMOTE_ADDR; // if globals, otherwise...
  // game code, game version
  $session_id = ($_COOKIE['PHPSESSID']); 
  $ip_address = $_SERVER['REMOTE_ADDR'];
  
  // WordPress username $wp_username, if they have one an
  
  $wpdb->query( $wpdb->prepare( "
  INSERT INTO wp_mmg_turns 
  (object_id, game_code, session_id, ip_address )
  VALUES ( %d, %s, %s, %s )" ,
  array( $object_id, $game_code, $session_id, $ip_address ) ) ); 
  $turn_id = mysql_insert_id();
  
  // call the appropriate save_$ugc functions with turn_id
  switch ($game_code) {
   case "simpletagging":
     save_tags($turn_id); 
     break;  
   case "simplefacts":
     save_fact($turn_id); 
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
function save_tags($turn_id) {
    // do stuff
  global $wpdb;
//  global $my_plugin_table; // ### should set this up
    
  $tags = $wpdb->escape($_POST['tags'] );
  $object_id = $wpdb->escape($_POST['object_id'] );
  echo "You added tags: ".$_POST['tags'];

  // for each comma-separated tag, add a row to the tags table
  
  $tag_array = explode(",",$tags);
  $count=count($tag_array);
  
  for($i=0;$i<$count;$i++)
  
  {
  // echo $tag_array[$i];
  
    $wpdb->query( $wpdb->prepare( "
    INSERT INTO wp_mmg_turn_tags 
    (turn_id, object_id, tag )
    VALUES ( %d, %d, %s )" ,
    array( $turn_id, $object_id, $tag_array[$i] ) ) ); 
  
  }
    
}

/**
 * Save tags. Updating to save tags to mmg_turn_tags rather than mmg_turn.
 * 
 * @since 0.1
 * @uses $wpdb
 * 
 */
function save_fact($turn_id) {
    // do stuff
  global $wpdb;
//  global $my_plugin_table; // ### should set this up
    
  $tags = $wpdb->escape($_POST['tags'] );
  $object_id = $wpdb->escape($_POST['object_id'] );
  $fact_headline = $wpdb->escape($_POST['fact_headline'] );
  $fact_summary = $wpdb->escape($_POST['fact_summary'] );
  $fact_source = $wpdb->escape($_POST['fact_source'] ); 
  echo "You added fact: ".$_POST['fact_summary'];
  
    $wpdb->query( $wpdb->prepare( "
    INSERT INTO wp_mmg_turn_facts 
    (turn_id, object_id, fact_headline, fact_summary, fact_source )
    VALUES ( %d, %d, %s, %s, %s )" ,
    array( $turn_id, $object_id, $fact_headline, $fact_summary, $fact_source ) ) ); 
     
}

function print_refresh() {
  // assume that people will need javascript to use the site generally so ok to rely on js?
  // onclick or onselect or something?
  // ### needs updating as reload() resubmits instead of loading afresh (der)
?>
<form>
<input type="button" class="button" value="get a different object" onclick="location.reload()">
</form>
<?php  
}








////////////// database stuff

// set up variables ###
global $wpdb;

// get and display random object
function mmg_get_object() {
  $row = random_row('wp_mmg_objects', 'object_id');
  if(is_object($row)) {
  
  /* session-based tests to check that the visitor hasn't seen 
   * that object in that session already ### 
   * get another row if they have
   */
   
  }
  
  return $row;
}


// get random row from object table 
  function random_row($table, $column) {
    //echo $table ." " . $column;
  global $wpdb;
  
  // get a random ID
  $random_row = $wpdb->get_row ($wpdb->prepare ("SELECT $column FROM $table AS r1 
  JOIN (SELECT ROUND( RAND( ) * ( SELECT MAX( object_id ) FROM $table) ) AS id) AS r2
  WHERE r1.object_id >= r2.id ORDER BY r1.object_id ASC LIMIT 1"));
  
  $random_row_id = $random_row->object_id;
  
  // get the full record for that ID
  $random_row = $wpdb->get_row ($wpdb->prepare ("SELECT * FROM $table WHERE object_id = $random_row_id LIMIT 1"));
  
  return $random_row;

  }

?>