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

// needs a good refactor as any shared functionality for general screens is moved out, etc
function simpleTagging() {
  // deal with submitted data, if any
  if($_POST['submitTags'] == "Tag!") {
  //if (isset($_POST['submitTags'])) {
    // do stuff
  save_tags();
  } else {
    //echo "not submitted.";
  }
    
  
  // get an object to display and write it to the screen
  $turn_object = mmg_get_object();
  
  if(is_object($turn_object)) {
    
    echo '<div class="something">';
    // print_r($turn_object);
    // print object name
    echo '<h2 class="objectname">'.urldecode($turn_object->name).'</h2>';
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

function tag_form($object_id) {
  // ok, let's go.
?>
  <form action="" method="post">

<!--<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">-->
  <input type="hidden" value="<?php echo $object_id ?>" name="object_id" />
  <fieldset>
  <legend>Add words to describe this object</legend>
  <label for="tags">Tags</label>
  <input type="text" name="tags" size="100" maxlength="300" value="" />  <input class="button" name="submitTags" type="submit" value="Tag!" />
  <p class="hint">Separate each tag with a comma, like this: tag, label, words to describe things, name.</p>
  </fieldset>
  </form>
<?php  
}

function save_tags() {
    // do stuff
  global $wpdb;
//  global $my_plugin_table; // ### should set this up
    
  $tags = $wpdb->escape($_POST['tags'] );
  $object_id = $wpdb->escape($_POST['object_id'] );
  echo "You added tags: ".$_POST['tags'];

// didn't like $wpdb->wp_mmg_turns
  $wpdb->query( $wpdb->prepare( "
  INSERT INTO wp_mmg_turns 
  ( turn_id, object_id, tags )
  VALUES ( %d, %d, %s )" ,
  array( 1, $object_id, $tags ) ) ); // turn ID is hardcoded for now, shame


// $query = "INSERT INTO wp_mmg_turns (object_id, tags) VALUES ('$object_id','$tags')";
// $wpdb->query( $query );
 
 // $wpdb->insert($wpdb->wp_mmg_turns, array ('object_id' => $object_id, 'tags' => $tags) );
// start here tomorrow ###

/*
  $user_text =  $wpdb->escape( $_POST['user_text'] );
  $query = "INSERT INTO $my_plugin_table (user_text) VALUES ('$user_text')";
  $wpdb->query( $query );
  echo 'success';
} */

    
}

function print_refresh() {
  // assume that people will need javascript to use the site generally?
  // onclick or onselect or something?
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