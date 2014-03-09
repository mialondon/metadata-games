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

  echo '<div class="factseeker mmgContent">';
  // deal with submitted data, if any
  if($_POST['submitTags'] == "Send your report") {
    saveTurn('factseeker');
  // make variant thank you messages, depending on count/random ###
  echo '<div class="messages"><p><img src="'. MMG_IMAGE_URL . 'Donald_talking.png" align="left"> "Thank you, Holmes! Your report has been sent to the team for review.  The object has been added to your case file on the right, and you have been awarded <strong>' . FACTSCORE . '</strong> merit points towards your next promotion (assuming the evidence checks out when we verify it).</p><p>Can you investigate this object too?  If you\'re not sure about it, that\'s ok... ';
  printRefresh($object_id);
  echo '"</p></div>';
  } else { 
    // if first load - set game state how? ###
  echo '<div class="messages">';
  echo '<p><img src="'. MMG_IMAGE_URL . 'Donald_serious.png" align="left"> "Hello, Holmes!  Thank goodness you\'re here!</p><p>Can you help us solve The Case Of The Mystery Objects?  The dastardly Moriarty has left behind these objects, but we don\'t know why. Can you <strong>use the information on this page to find an interesting fact or link about the thing in the image below</strong>?</p>';
  echo '<p>You may need to hunt around for some relevant facts - try searching books or the internet. Then <strong>report back</strong> to Headquarters by filling in the form below.  If you succeed, you\'ll get <strong>' . FACTSCORE . ' merit points</strong> towards a promotion for your hard work!</p>';
  echo "<p>Not sure you can ferret out a fact about this object?";
  printRefresh($object_id);
  echo " Don't worry, skipping until you find an object you can work with won't affect your chances for promotion...</p>";
  echo '</div>';   
  }
    
  echo $object_print_string; 
  
  printObjectBookmark($object_id); // save object URL?
    
  // call the form, give it the object_id for hidden field
  printFormFactSeeker($object_id);
  
  echo '</div>'; 

}


/*
 * variation of Donald with choice of objects first - at the moment it's basically a copy of factseeker() so some duplication, but I'll refactor later.
 */
function mmgFactseekerChoice() {
  // get object ID parameter, if there is one
  list($temp_object_id, $skipped_ID) = checkForParams();  

  echo '<div class="factseeker mmgContent">';
  // deal with submitted data, if any
  if($_POST['submitTags'] == "Send your report") {
    saveTurn('factseeker');
    // make variant thank you messages, depending on count/random ###
    echo '<div class="messages"><p><img src="'. MMG_IMAGE_URL . 'Donald_happy.png" align="left"> "Thank you, Holmes! Your report has been sent to the team for review.  The object has been added to your case file on the right, and you have been awarded <strong>' . FACTSCORE . '</strong> merit points towards your next promotion (assuming the evidence checks out when we verify it).</p><p>Here are some more objects left by Moriarty, do any of these catch your eye?</p></div>';
    
    $objects_print_string = mmgDisplayObjectBlocks('donald'); 
    
    echo $objects_print_string;
  
  } elseif(!empty($temp_object_id)) { // object chosen
    echo '<div class="messages">';
    echo '<p><img src="'. MMG_IMAGE_URL . 'Donald_talking.png" align="left">Ah, an interesting choice. Well, let\'s see what you can find out about it.  You may need to hunt around for some relevant facts - try searching books or the internet. Then <strong>report back</strong> to Headquarters by filling in the form below.  If you succeed, you\'ll get <strong>' . FACTSCORE . ' merit points</strong> towards a promotion for your hard work!</p><p>If it\'s been a while since your last case with us, here\'s a hint to get you going: if you can\'t find anything specific about this object, try to find something about the general type of object, who might have used it, or what it\'s used for instead.</p></div>';
    
    printObjectBookmark($temp_object_id); // save object URL
    
    list($object_id, $object_print_string) = printObject($temp_object_id);
    
    echo $object_print_string;
      
    // call the form, give it the object_id for hidden field
    printFormFactSeeker($temp_object_id);
    
  }
  else { 
    // if first load or clean URL
    echo '<div class="messages">';
    echo '<p><img src="'. MMG_IMAGE_URL . 'Donald_serious.png" align="left"> "Hello, Holmes!  Thank goodness you\'re here!</p><p>Can you help us solve The Case Of The Mystery Objects?  The dastardly Moriarty has left behind these objects, but we don\'t know why. Can you <strong>use the information on this page to find an interesting fact or link about one of the things in the images below</strong>?</p>';
    echo '<p>You may need to hunt around for some relevant facts - try searching books or the internet. Then <strong>report back</strong> to Headquarters by filling in the form below.  If you succeed, you\'ll get <strong>' . FACTSCORE . ' merit points</strong> towards a promotion for your hard work!</p>';
    echo '<p>I\'ve selected some objects at random - take your pick. I know you like to prepare, so this link will open a new window and show you some <a href="' . PATH_TO_UGCREPORTS_PAGE . '?report=facts" title="View other facts added" target="_blank">previous examples of reports submitted</a>.</p>';
    echo '</div>';
    
    $objects_print_string = mmgDisplayObjectBlocks('donald'); 
    
    echo $objects_print_string;

  }  
  echo '</div>';   
}

/**
 * Print 'Donald thank you message on fact submit
 */
function mmgDonaldThankYou() {
  
}


/**
 * Prints the form for the 'add tags' activity - funtagging version ###
 * @since 0.1
 * 
 */
function printFormFactSeeker($object_id)  {
  $permalink = get_permalink($id); 
?><div ><div class="wFormContainer">
				<h3 class="wFormTitle"><span>Mystery object report form</span></h3>
		<div class="wForm wFormdefaultWidth">
  <form action="<?php echo $permalink ?>" method="post"  id="id2599208" class="labelsAbove hintsSide">
  <input type="hidden" value="<?php echo $object_id ?>" name="object_id" />
  <fieldset class="wfSection">
  <legend>Add the information you've discovered about this object to your report</legend>
  <div class="oneField">
  <label class="preField" for="fact_headline">Report title</label><br />
  <input id="mmgFactHeadline" type="text" name="fact_headline" class="fact" maxlength="100" value="" /><br /><span class="field-hint"><span>Our investigators are busy - let them know why they should check out this information.</span></span><br /><br />
</div>

<div class="oneField">
  <label class="preField" for="fact_summary">Information discovered</label><br />
  <textarea id="mmgFactSummary" name="fact_summary" rows="4" class="primaryAction"></textarea>
<br /><span class="field-hint"><span>Summarise your information in your own words (short quotes from your source are ok).</span></span><br /><br />
</div>
  
  <div class="oneField">
  <label class="preField" for="fact_source">Source</label><br />
  <input type="text" id="mmgFactSource" name="fact_source" class="fact" maxlength="300" value="" /><br /><span class="field-hint"><span>The link, book or person who provided the original evidence.</span></span><br /><br />
</div>
</fieldset>
  
<div class="actions">
  <p class="submit"><input class="button primaryAction" name="submitTags" type="submit" value="Send your report" /></p>
  </div>
  </form>
</div></div></div>
<?php  
}


?>