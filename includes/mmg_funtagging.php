<?php
/**
 * Functions for the first go at a proper game - 'funtagging'
 * 
 * Prints the containing div, calls functions necessary to print the object 
 * and forms to the screen
 *  
 * Copyright (C) 2010 Mia Ridge
 * 
 * @since 0.2
 * 
 */

/**
 * 
 * Prints the containing div, calls functions necessary to print the object 
 * and forms to the screen
 * 
 * @since 0.1
 * 
 */
 
function funtagging() {
  
  // check to see if there's a logged in user and add their points if not already saved
  if ( is_user_logged_in() ) {
    mmgSaveNewUserPoints();
  }  
  
  list($object_id, $object_print_string) = printObject();
  
  // deal with submitted data, if any
  if($_POST['submitTags'] == "Tag!") {
    saveTurn('funtagging');
  } else { 
    // if first load - set game state how? ###
   echo '<div class="messages">';
   echo '<p><img src="'. MMG_IMAGE_URL . 'Dora_pensive.gif" align="left"> "Hi, my name is Dora, and I\'m a junior curator.  It\'s my first day and I\'ve made a big mistake - I accidentally deleted all the information we were going to add to our collections online.  I need to re-label them, and quickly...</p>';
   echo '<p>Can you help?  <strong>Add words about the thing in the picture that would help someone find it on Google</strong> - how it looks, what does, who might have used it - anything you can think of."</p>';
   echo '</div>';   
  }
  
  echo '<div class="funtagging">';
  
  echo $object_print_string; 
    
  // call the form, give it the object_id for hidden field
  printFormFunTag($object_id);
      
  // get a new object
    echo "<p>Not sure about this object?";
  printRefresh($object_id);
  echo " (It won't affect your points.)</p>";
  
  // make a function to deal with printing to the screen if obj not found
  printObjectBookmark($object_id);
  
  echo '</div>'; // end of game-specific div
  
  // why on earth is this here? ###
  extract(shortcode_atts(array( // lowercase cos the short tags are, elsewhere camel.
  "gametype" => 'simpletagging' // default
  ), $atts));

}


/**
 * Prints the form for the 'add tags' activity - funtagging version ###
 * @since 0.1
 * 
 */
function printFormFunTag($object_id) {
$permalink = get_permalink($id); 
?>
<div class="wFormContainer">
<div class="wForm wFormdefaultWidth">
  <div id="tfa_tags-D" class="oneField">

  <form action="<?php echo $permalink ?>" method="post">
  <input type="hidden" value="<?php echo $object_id ?>" name="object_id" />
  <fieldset>
  <legend>Add words ('tags') to describe this object</legend>
  <label class="preField" for="tags">Tags</label>
  <input type="text" name="tags" class="tags" size="60" maxlength="300" value="" /><br />
   <span class="field-hint" id="tfa_Source-H"><span>Tip: separate each tag with a comma, like this: tag, label, words to describe things, name.</span></span>
  <div class="actions">
  <p class="submit"><input class="button primaryAction" name="submitTags" type="submit" value="Tag!" /></p>
  </div> 
  
  </fieldset>
  </form>
  
  </div>
</form></div>
</div>   
  
<?php  
}


?>