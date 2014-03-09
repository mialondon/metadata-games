<?php
/**
 * Functions for the 'simpletagging' activity
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
 
function simpleTagging() {
  
  list($object_id, $object_print_string) = printObject();
  
  echo '<div class="simpleTagging mmgContent">';  
  // deal with submitted data, if any
  if($_POST['submitTags'] == "Tag!") {
    saveTurn('simpletagging');
  } 
    
  echo $object_print_string; 
    
  // call the form, give it the object_id for hidden field
  tagForm($object_id);
  
  // make a function to deal with printing to the screen if obj not found
  printObjectBookmark($object_id);
      
  // make a function to print the 'need another? refresh' message

    // get a new object
    echo "<p>Not sure about this object?";
    printRefresh($object_id);
    echo "</p>";
    
    echo '</div>'; 

}


/**
 * Prints the form for the 'add tags' activity - simpletagging version ###
 * @since 0.1
 * 
 */
function tagForm($object_id) {
$permalink = get_permalink($id); 
?>
  <form action="<?php echo $permalink ?>" method="post">
  <input type="hidden" value="<?php echo $object_id ?>" name="object_id" />
  <fieldset>
  <legend>Add words to describe this object</legend>
  <label for="tags">Tags</label>
  <input type="text" id="mmgsimpleTagging" name="tags" class="tags" size="80" maxlength="300" value="" />
  <p class="submit"><input class="button" name="submitTags" type="submit" value="Tag!" /></p>
  <p class="hint">Tip: separate each tag with a comma, like this: tag, label, words to describe things, name.</p>
  </fieldset>
  </form>
<?php  
}


?>