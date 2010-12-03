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
 
function factseeker() {
  
  list($object_id, $object_print_string) = printObject();
  
  // deal with submitted data, if any
  if($_POST['submitTags'] == "Save your report") {
    saveTurn('factseeker');
  // make variant thank you messages, depending on count/random ###
  echo '<div class="messages"><p><img src="'. MMG_IMAGE_URL . 'Donald_talking.png" align="left"> "Thank you! The object you investigated has been added to your case file and you have been awarded ' . $score . ' points towards your next promotion. Can you tag this object too?"</p></div>';
  } else { 
    // if first load - set game state how? ###
  echo '<div class="messages">';
  echo '<p><img src="'. MMG_IMAGE_URL . 'Donald_serious.png" align="left"> "Hello, Holmes!  Thank god you\'re here - we couldn\'t solve The Case Of The Mystery Objects without you.  To help us work out why these objects have been left behind by the dastardly Moriarty, you\'ll need to use the clues on this page to find an interesting fact or link about this mysterious object.  You may need to hunt around for some relevant facts, but with luck and perseverance you\'ll get a promotion for your work.</p>';
  echo '<p>It\'s a while since your last case with us, so in case you need a reminder: <ul><li>use the clues available to help find an interesting fact or link about this object. If you aren\'t given enough information on the page to find something specific about this object, try to find something about the type of object or what it\'s used for instead.</li><li>report back to Headquarters with the form below."</li></ul></p>';
  //echo '<p>It\'s a while since your last case with us, so in case you need a reminder: 1. pick an object below 2) use the clues available to help find an interesting fact or link about this object 3) report back to Headquarters. With any luck you\'ll get a promotion for your work."</p>';
  echo '</div>';   
  }
    
  echo '<div class="factseeker">'; // put a background wash on here? ###
  echo $object_print_string; 
  
  printObjectBookmark($object_id); // save object URL?
    
  // call the form, give it the object_id for hidden field
  printFormFactSeeker($object_id);
      
  // make a function to print the 'need another? refresh' message

    // get a new object
    echo "<p>Not sure about this object?";
    printRefresh($object_id);
    echo "</p>";
    
    echo '</div>'; 

}


/**
 * Prints the form for the 'add tags' activity - funtagging version ###
 * @since 0.1
 * 
 */
function printFormFactSeeker($object_id)  {
  $permalink = get_permalink($id); 
?><div id="tfaContent"><div class="wFormContainer">
				<h3 class="wFormTitle"><span>Mystery object report</span></h3>
		<div class="wForm wFormdefaultWidth">
  <form action="<?php echo $permalink ?>" method="post"  id="id2599208" class="labelsAbove hintsSide">
  <input type="hidden" value="<?php echo $object_id ?>" name="object_id" />
  <fieldset id="tfa_addthedetailsfor" class="wfSection">
  <legend>Add the information you've discovered to your report about this object</legend>
  <!--<p class="hint">The headline should 'sell' your fact. The source should provide evidence for your fact.</p>-->
  <div id="tfa_Headline-D" class="oneField">
  <label class="preField" for="tfa_Headline" for="fact_headline">Headline</label><br />
  <input  id="tfa_Headline" type="text" name="fact_headline" class="fact" size="80" maxlength="100" value="" /><br /><span class="field-hint-inactive" id="tfa_Headline-H"><span>The headline should 'sell' your fact to the reader.</span></span><br /><br />
</div>

<div id="tfa_Factsummary-D" class="oneField">
  <label class="preField" for="fact_summary">Fact summary</label><br />
  <textarea name="fact_summary" cols="75" rows="4" id="tfa_Factsummary"></textarea>
<br /><span class="field-hint-inactive" id="tfa_Factsummary-H"><span>Summarise your fact in your own words (short quotes are ok).</span></span><br /><br />
</div>
  
  <div id="tfa_Source-D" class="oneField">
  <label class="preField" for="fact_source">Source</label><br />
  <input id="tfa_Source"  type="text" name="fact_source" class="fact" size="80" maxlength="300" value="" /><br /><span class="field-hint" id="tfa_Source-H"><span>The link, book or person who provided the original source.</span></span><br /><br />
</div>
</fieldset>
  
<div class="actions">
  <p class="submit"><input class="button primaryAction" name="submitTags" type="submit" value="Save your report" /></p>
  </div>
  </form>
</div></div></div>
<?php  
}


?>