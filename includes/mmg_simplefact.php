<?php
/*
 * Functions for the 'simplefact' activity
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
function simpleFacts() {
  
  list($object_id, $object_print_string) = printObject();
  
  echo '<div class="simpleFacts mmgContent">';     
  // deal with submitted data, if any
  if($_POST['submitTags'] == "Add your fact") {
    saveTurn('simplefacts');
  } 

  echo $object_print_string; 
  
  // call the form, give it the object_id for hidden field
  factForm($object_id);
  
  // make a function to deal with printing to the screen if obj not found
  printObjectBookmark($object_id);  

    // get a new object
    echo "<p>Not sure about this object?";
    printRefresh($object_id);
    echo "</p>";
    
    echo '</div>'; 
    

}


/**
 * Prints the form for the 'add a fact' activity ### simple fact version
 * @since 0.1
 * 
 */
function factForm($object_id) {
  $permalink = get_permalink($id); 
?>
  <form action="<?php echo $permalink ?>" method="post">
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

