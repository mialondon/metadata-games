<?php
/**
 * Functions for the 'detective' game
 * 
 * Prints the containing div, calls functions necessary to print the object 
 * and forms to the screen
 *  
 * Copyright (C) 2010 Mia Ridge
 * 
 * @since 0.3
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
  
  list($object_id, $object_print_string) = printObject();
  
  // deal with submitted data, if any
  if($_POST['submitTags'] == "Save your report") {
    saveTurn('factSeeker');
  // make variant thank you messages, depending on count/random ###
  echo '<p class="messages"><img src="'. MMG_IMAGE_URL . 'Donald_talking.png" align="left"> "Thank you! The object you investigated has been added to your case file and you have been awarded ' . $score . ' points towards your next promotion. Can you tag this object too?"</p>';
  } else { 
    // if first load - set game state how? ###
   echo '<div class="messages">';
   echo '<p><img src="'. MMG_IMAGE_URL . 'Donald_serious.png" align="left"> "Thanks for coming by the office to help us with The Case Of The Missing Records, Detective Holmes.  To help us solve the mystery, you\'ll need to use the clues on this page to find an interesting fact or link about this object.</p>';
   printObjectBookmark($object_id);
   echo '<p>It\'s a while since your last case with us, so in case you need a reminder: 1. pick an object below 2) use the clues available to help find an interesting fact or link about this object 3) report back to Headquarters. With any luck you\'ll get a promotion for your work."</p>';
   echo '</div>';   
  }
    
  echo '<div class="factSeeker">'; // put a background wash on here? ###
  echo $object_print_string; 
    
  // call the form, give it the object_id for hidden field
  printFormFactSeeker($object_id);
      
  // make a function to print the 'need another? refresh' message

    // get a new object
    echo "<p>Not sure what to do with this object?  You can skip it... ";
    printRefresh();
    echo "</p>";
    
    echo '</div>'; 

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