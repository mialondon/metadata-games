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
 
function factSeeker() {
  // deal with submitted data, if any
  if($_POST['submitTags'] == "Save your report") {
    saveTurn('factSeeker');
  } 
    
  echo '<div class="factSeeker">'; // put a background wash on here? ###
  $object_id = printObject(); 
    
  // call the form, give it the object_id for hidden field
  printFormFactSeeker($object_id);
  
  // make a function to deal with printing to the screen if obj not found
  printObjectBookmark($object_id);
      
  // make a function to print the 'need another? refresh' message

    // get a new object
    echo "<p>Not sure what to do with this object?  You can skip it... ";
    printRefresh();
    echo "</p>";
    
    echo '</div>'; 
    
    // temp proof-of-concept
    mmgSiteStats();

}


/**
 * Prints the form for the 'add tags' activity - funTagging version ###
 * @since 0.1
 * 
 */
function printFormFactSeeker($object_id)  {
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
  <p class="submit"><input class="button" name="submitTags" type="submit" value="Save your report" /></p>
  <p class="hint">The headline should 'sell' your fact. The source should provide evidence for your fact.</p>
  </fieldset>
  </form>
<?php  
}


?>