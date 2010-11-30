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
  
  list($object_id, $object_print_string) = printObject();
  
  
  // deal with submitted data, if any
  if($_POST['submitTags'] == "Tag!") {
    saveTurn('funtagging');
  } else { 
    // if first load - set game state how? ###
   echo '<div class="messages">';
   echo '<p><img src="'. MMG_IMAGE_URL . 'Dora_pensive.png" align="left"> "The disk drive containing most of the information we need to put our collections online has disappeared... Can you help us re-label some of our objects?</p>';
   echo '<p>Quick - add some words to describe this object using words that would help someone find it on Google."</p>';
   echo '</div>';   
  }
  
  echo '<div class="funtagging">';
  
  echo $object_print_string; 
    
  // call the form, give it the object_id for hidden field
  printFormFunTag($object_id);
      
  // get a new object
  echo "<p>Not sure what to do with this object?  You can skip it... ";
  printRefresh($object_id);
  echo "</p>";
  
  // make a function to deal with printing to the screen if obj not found
  printObjectBookmark($object_id);
  
  echo '</div>'; // end of game-specific div
    
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
  <legend>Add words to describe this object</legend>
  <label class="preField" for="tags">Tags</label>
  <input type="text" name="tags" class="tags" size="60" maxlength="300" value="" />
  <p class="submit"><input class="button" name="submitTags" type="submit" value="Tag!" /></p>
  <!--<span class="field-hint-inactive" id="tfa_tags-H"><span>Tip: separate each tag with a comma, like this: tag, label, words to describe things, name.</span></span>-->
  <p class="hint">Tip: separate each tag with a comma, like this: tag, label, words to describe things, name.</p>
  </fieldset>
  </form>
  
  </div>
</form></div>
</div>   
  
<?php  
}


?>