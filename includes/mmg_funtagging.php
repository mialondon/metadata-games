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
 * The main function for the 'Dora' game.
 * Prints the containing div, calls functions necessary to print the object 
 * and forms to the screen
 * 
 * @since 0.1
 * 
 */
 
function funtagging() {
  
  echo '<div class="funtagging mmgContent">';
  
  // check to see if there's a logged in user and add their points if not already saved
  if ( is_user_logged_in() ) {
    mmgSaveNewUserPoints();
  }
    
  list($object_id, $object_print_string) = printObject();
  
  // deal with submitted data, if any
  if($_POST['submitTags'] == "Tag!") {
    saveTurn('funtagging');
  } else { // is first load or possibly after a skipped object ###
   echo '<div class="funtagging mmgContent">';
   echo '<div class="messages">';
   echo '<p><img src="'. MMG_IMAGE_URL . 'Dora_pensive.gif" align="left"> "Hi, my name is Dora, and I\'m a junior curator.  It\'s my first day and I\'ve made a big mistake - I accidentally deleted all the information we were going to add to our collections online.  I need to re-label them, and quickly...</p>';
   echo '<p>Can you help?  <strong>Add words about the thing in the picture that would help someone find it on Google</strong> - how it looks, what does, who might have used it - anything you can think of."</p>';
   echo '</div>';   
  }
  
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
   <span class="field-hint" id="tfa_Source-H"><span>Tip: separate each tag with a comma, like this: tag, label, a phrase, name, names.</span></span>
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

/*
 * Builds up the string of Dora's messages in response to a turn
 * Takes in $score, $num_turns - $score is compulsory, $num_turns might be empty
 * @uses $wpdb;
 */
function mmgGetDoraTurnMessages($score) {
  
  global $wpdb;
  
  // get how many turns they've had in this session for feedback
  $sql = "SELECT count(session_id) as num_turns FROM " . table_prefix . "turns WHERE session_id = '". ($_COOKIE['PHPSESSID']) ."' ";
  $results = $wpdb->get_row ($wpdb->prepare ($sql));
  
  if (is_object($results)) {
    $num_turns = $results->num_turns;
    
    if ($num_turns % 5 == 0) { // it's a 'game'!  Woo, yeah.
      $message = '<div class="game_completed"><p class="game_completed">Hooray!  You completed a row!</p></div>';
      $game_marker_message = mmgDoraGameMarker();
      if (!empty($game_marker_message)) {
        $message .= $game_marker_message;
      }
    } else { // carry on
      $img_src = '<img src="'. MMG_IMAGE_URL;
      if ($score >= 40) {
        $img_src .= 'Dora_happy.gif"'; // wow!
      } else {
        $img_src .= 'Dora_talking.gif"'; // well done
      }
      $img_src .= ' align="left">';
      
      $message = '<p>"' .$img_src;
      if ($score >= 40) {
        $message .= '<strong>Wow!</strong> ';
      } elseif ($score < 40 && $score >= 20) {
        $message .= '<strong>Well done!</strong> ';    
      } elseif ($score < 20 && $score > 5) {
        $message .=  '<strong>Thank you!</strong> ';
      } // also if one, for thank you.
      
      $message .=  'You added ' . $score/TAGSCORE . ' tag';
    
      if ($score > 5) {  // grammar for one tag - is greater than working?
         $message .=  's '; 
      }
      $message .=  '  and you scored <strong>' . $score . '</strong> points.  I\'ve added your object to your collection over on the right.</p><p>'; // ### you have x objects
      
      if ($score <= 5) { // score = 5 - one tag.
        $message .=  ' <strong>Thank you!</strong>  But you only entered one tag - did you forget to put commas between your tags?  (Like this: \'one, two, three\' not \'one two three\'). Or try this hint - look for variations on words to describe the date or place, or perhaps the colours and materials of the object, what it would be like to use or who might have used it. ';
      }
    
      // make variant thank you messages, depending on count/random ###
      if ($num_turns < 5 && ($score < 20 && $score > 5)) {
        $message .= 'Don\'t forget to try variations on words to describe the dates, places, colours and materials of the thing, or perhaps relevant subjects or people. ';
        }
      
      if ($num_turns == 1) { // first entry
        if ($score > 5) {
        $message .= ' What a great start. ';
        }
        $message .= ' Can you tag another? '; 
      } 
      if ($num_turns == 2 ) { // random message
        $message .= " Don't feel you have to use fancy words - everyday language is just what we need to help other visitors find these objects. ";
      }
      if ($num_turns % 3 == 0 && $num_turns % 2 != 0 ) { // random message
        $message .= ' Can you tag five objects to fill a row?  ';
      }
      if ($num_turns % 6 == 0 ) { // random message
        $message .= ' Why not share this game with your friends?  (Or are you scared they might beat your score?) ';
      } 
      if ($num_turns % 11 == 0 ) { // random message
        $message .= ' Every tag helps. ';
      }  
      $message .= '</p>';    
    
    }
  
  } else {
    $message = ''; // something went wrong - no turns, not even the one just submitted.  
  }
  
  return $message;  
  
}
/*
 * Take the object number and checks for other rows in the database about it
 * Uses object ID for comparison and turn_id to exclude their own tags just entered
 *
 */
function mmgGetDoraTurnValidation($object_id, $turn_id) {
  global $wpdb;

  $sql = "SELECT turn_id, tag, count(tag) as numTags FROM ". table_prefix. "turn_tags ". table_prefix. "objects WHERE object_id = '". $object_id ."' AND turn_id != '". $turn_id ."' GROUP BY tag ORDER BY numTags DESC"; // get number of times a tag was used too
  $results = $wpdb->get_results($wpdb->prepare ($sql));
  
  if ($results) { // have specific UGC for that object
    $message = 'Other people added these tags for the same object (the number of times is in brackets): ';
    $i;
    foreach ($results as $result) {
      if ($i != 0) {
        $message .= ', ';
      }
      $message .= ' ' . $result->tag . ' ('. $result->numTags .')' ;
      $i++;
    }
  } else { // get site averages
    $message = 'Cool! You\'re the first person to tag this object.';
    $site_average = mmgGetSiteTaggingAverages();
    if (!empty($site_average)) {
      $message .= ' On average, people have added '. $site_average .' tags per go.';
    }    
  }
  
  return $message;
}
/*
 * Gets the average number of tags per object across the site for the tagging game Dora/funtagging
 * ### needs avg figure to be rounded down!
 * @uses wpdb;
 */
function mmgGetSiteTaggingAverages() { 
  
  global $wpdb;
  
  $sqlTurns = "select count(turn_id) as numTurns from ". table_prefix. "turns WHERE game_code = 'funtagging'"; 
  $sqlTags = "select count(tag) as numTags from ". table_prefix. "turn_tags"; 
  $resultTurns = $wpdb->get_var($wpdb->prepare ($sqlTurns));
  $resultsTags = $wpdb->get_var($wpdb->prepare ($sqlTags));
  $site_average = $resultsTags / $resultTurns;
  
  $site_average = round($site_average, 1);
  
  return $site_average;
}

/* 
 * Handles the 'you've finished a game (five turns) stuff
 * Summarises how many points they got in that game (ie the last five turns),
 * plus how many tags per object (maybe object thumbnails or just point them to the RHS?)
 * and gives them the site average.
 * Also offers option to tweet or Facebook about it.
 */
function mmgDoraGameMarker() {
  global $wpdb;
    
  // get last five turns for that session id or user name (order by turn id desc, limit 5)
  $sql = "SELECT turn_id FROM ". table_prefix. "turns WHERE game_code = 'funtagging' ";    
  if(is_user_logged_in()) {
    get_currentuserinfo();
    $sql .= " AND wp_username = '" . $current_user->user_login ."' "; 
  } else {
    $session_stuff = ($_COOKIE['PHPSESSID']);
    if (!empty($session_stuff)) {
      $sql .= " AND session_id = '" . $session_stuff ."' ";
    }
  } 
  $sql .= ' ORDER BY turn_id DESC LIMIT 5' ;
  //echo $sql; // +++
  $last_turn_ids = $wpdb->get_results($wpdb->prepare ($sql));
  if ($last_turn_ids) { // get number of tags over the last five turns
    foreach($last_turn_ids as $result) {
      $turn_ids .= $result->turn_id. ' ,';
    }
    $turn_ids = trim($turn_ids, ', ');
    
    $get_tags_sql = 'SELECT count(tag) as numTags FROM wp_mmg_turn_tags WHERE turn_id IN ('.$turn_ids.')';
    //echo $get_tags_sql; // +++
    $player_average_tags;
    
    $game_results = $wpdb->get_var($wpdb->prepare ($get_tags_sql));
    if ($game_results) {
      $numTags = $game_results;
      $player_average_tags = $numTags/5;
      $img_src .= 'Dora_happy.gif"'; // wow! 
      $message .= '<p class="game_congrats"><img src="' . MMG_IMAGE_URL.$img_src .' align="left">"You scored a grand total of ' . TAGSCORE * $numTags . ' points for this game. ';
      $message .= ' On average, you added ' . $player_average_tags . ' tags for each object.';      
    }
  }
  
  if (!empty($player_average_tags)) {
  $site_average = mmgGetSiteTaggingAverages();
  
  if ($player_average_tags >= ($site_average+1)) { // 2 above average
    $message .= ' You\'re a super tagger!  You\'re smashing the game average ('.$site_average.'), go you! Are you ready to play again and keep your lead?';    
  } elseif ($player_average_tags > ($site_average)) { // 1 above average
    $message .= ' You\'re beating the game average ('.$site_average.'), go you! Are you ready to play again?';    
  } elseif (($player_average_tags+1) < ($site_average)) {
    $message .= ' You\'re really close to the game average ('.$site_average.'). Are you ready to have another go and see if you can do better?'; 
  } else {
    $message .= ' That\'s not quite as much as the game average, but nevermind - have another go and see if you can improve your score. ';
  }
  $message .= '</p>';
  // for when I can get online and fix it...
  $message .= '<p>And why not tell your friends?  Tweet your score or share it on Facebook...</p>';

  }
  
  return $message;
  
}

?>