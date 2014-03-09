<?php
/**
 * Functions for the 'funtagging' game 'Dora' 
 * 
 * Prints the containing div, calls functions necessary to print the object 
 * and input forms to the screen
 *  
 * Copyright (C) 2014 Mia Ridge
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
   
  list($object_id, $object_print_string) = printObject();
  
  // deal with submitted data, if any
  if($_POST['submitTags'] == "Tag!") {
    saveTurn('funtagging');
  } else { // is first load or possibly after a skipped object ###
   echo '<div class="messages">';
   echo '<p><img src="'. MMG_IMAGE_URL . 'Dora_pensive.gif" align="left"> "Hi, my name is Dora, and I\'m a junior curator.  It\'s my first day and I\'ve made a big mistake - I accidentally deleted all the information we were going to add to our collections online.  I need to re-label them, and quickly...</p>';
   echo '<p>Can you help?  <strong>Add words about the thing in the picture that would help someone find it on Google</strong> - how it looks, what it does, who might have used it - anything you can think of."</p>';
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
 * Prints the form for the 'add tags' activity - funtagging ('Dora') version 
 * 
 * @param $object_id
 * @since 0.1
 * 
 */
function printFormFunTag($object_id) {
$permalink = get_permalink($id); 
?>
<div class="wFormContainer">
<div class="wForm">

  <form action="<?php echo $permalink ?>" method="post">
  <input type="hidden" value="<?php echo $object_id ?>" name="object_id" />
  <fieldset>
  <legend>Add words ('tags') to describe this object</legend>
  <label class="preField" for="tags">Tags</label>
  <input type="text" id="mmgfunTagging" name="tags" class="tags" maxlength="300" value="" /><br />
   <span class="field-hint"><span>Tip: separate each tag with a comma, like this: tag, label, a phrase, name, names.</span></span>
  <div class="actions">
  <p class="submit"><input class="button primaryAction" name="submitTags" type="submit" value="Tag!" /></p>
  </div> 
  
  </fieldset>
  </form>
</div>
</div>   
  
<?php  
}

/*
 * Check how many turns the player has had this session (based on session cookie)
 */
function mmgGetTurnCount() {
  
  global $wpdb;
  
  // get how many turns they've had in this session for feedback
  $sql = "SELECT count(session_id) as num_turns FROM " . table_prefix . "turns WHERE session_id = '%s' AND game_code = 'funtagging'"; 
  $results = $wpdb->get_row ($wpdb->prepare ($sql, ($_COOKIE['PHPSESSID']))); 
  
  if (is_object($results)) {
    $count = $results->num_turns;
  } else {
    unset($count);
  }
  
  return $count;
}

/*
 * Builds up the string of Dora's messages in response to a turn
 * 
 * @param $score
 * @see mmgGetTurnCount
 * @uses $wpdb;
 */
function mmgGetDoraTurnMessages($score) {
  
  global $wpdb;
  
  $num_turns = mmgGetTurnCount();
  
  // if five turns, have filled a row and 'win'
  if ($num_turns % 5 == 0) {
    if ($num_turns > 5) {
      $message = '<div class="game_completed"><h3 class="game_completed">Hooray! You\'ve completed another level!</h3>'; // win message
    } else {
      $message = '<div class="game_completed"><h3 class="game_completed">Hooray! You\'ve completed a level!</h3>'; // first time they've tagged five objects
    }
    $game_marker_message = mmgDoraGameMarker();
    if (!empty($game_marker_message)) {
      $message .= $game_marker_message;
    }
    $message .= '</div>';
        
  } 
  
    $img_src = '<img src="'. MMG_IMAGE_URL;
    if ($score >= 40 || $num_turns % 5 == 0) {
      $img_src .= 'Dora_happy.gif"'; // wow!
    } else {
      $img_src .= 'Dora_talking.gif"'; // well done
    }
    $img_src .= ' align="left">';
  
    $message .= '<p>"' .$img_src;
    if ($score >= 40) {
      $message .= '<strong>Wow!</strong> ';
    } elseif ($score < 40 && $score >= 20) {
      $message .= '<strong>Well done!</strong> ';    
    } elseif ($score < 20 && $score > 5) {
      $message .=  '<strong>Thank you!</strong> ';
    } // also if one, for thank you.
    
    $message .=  'You added ' . $score/TAGSCORE . ' tag';
  
    if ($score > 5) {  // grammar for one tag
       $message .=  's '; 
    }
    $message .=  '  and you scored <strong>' . $score . '</strong> points.  I\'ve added your object to your collection over on the right.</p><p>'; // ### you have x objects
    
    if ($score <= 5) { // score = 5 - one tag.
      $message .=  ' <strong>Thank you!</strong>  But you only entered one tag - did you forget to put commas between your tags?  (Like this: \'one, two, three\' not \'one two three\'). Or try this hint - look for variations on words to describe the date or place, or perhaps the colours and materials of the object or image, what it would be like to use or who might have used it. ';
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
      $message .= " You don't have to use fancy words - everyday language is just what we need to help other visitors find these objects. ";
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
   
  return $message;  
  
}
/*
 * Take the object number and checks for other rows in the database about it
 * Uses object ID for comparison and turn_id to exclude their own tags just entered
 *
 * @param $object_id
 * @param $turn_id
 * @see mmgGetSiteTaggingAverages
 * @uses $wpdb
 *
 */
function mmgGetDoraTurnValidation($object_id, $turn_id) {
  global $wpdb;

  $sql = "SELECT turn_id, tag, count(tag) as numTags FROM ". table_prefix. "turn_tags ". table_prefix. "objects WHERE object_id = %d AND turn_id != %d GROUP BY tag ORDER BY numTags DESC"; // get number of times a tag was used too
  $results = $wpdb->get_results($wpdb->prepare ($sql, $object_id, $turn_id)); 
  
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
      $message .= ' On average, people have added '. $site_average .' tags per turn.';
    }    
  }
  
  return $message;
}

/*
 * Gets the average number of tags (rounded up) per object across the site for the tagging game Dora/funtagging
 * @uses wpdb;
 */
function mmgGetSiteTaggingAverages() { 
  
  global $wpdb;
  
  $sqlTurns = "select count(turn_id) as numTurns from ". table_prefix. "turns WHERE game_code = 'funtagging'"; 
  $sqlTags = "select count(tag) as numTags from ". table_prefix. "turn_tags"; 
  $resultTurns = $wpdb->get_var($sqlTurns);
  $resultsTags = $wpdb->get_var($sqlTags);  
  $site_average = $resultsTags / $resultTurns;
  
  $site_average = round($site_average, 0, PHP_ROUND_HALF_UP);
  
  return $site_average;
}

/* 
 * Handles the 'you've finished a level' (five turns) stuff
 * Summarises how many points they got in that game (ie the last five turns),
 * plus how many tags per object (maybe object thumbnails or just point them to the RHS?)
 * and gives them the site average.
 *
 * @uses $wpdb
 * @uses $current_user
 */
function mmgDoraGameMarker() {
  global $wpdb;
  global $current_user;
    
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
  $last_turn_ids = $wpdb->get_results($sql); 
  if ($last_turn_ids) { // get number of tags over the last five turns
    foreach($last_turn_ids as $result) {
      $turn_ids .= $result->turn_id. ' ,';
    }
    $turn_ids = trim($turn_ids, ', ');
    
    $get_tags_sql = 'SELECT count(tag) as numTags FROM '. table_prefix. 'turn_tags WHERE turn_id IN ('.$turn_ids.')';
    //echo $get_tags_sql; // +++
    $player_average_tags;
    
    $game_results = $wpdb->get_var($get_tags_sql); 
    if ($game_results) {
      $numTags = $game_results;
      $player_average_tags = $numTags/5;
      $player_average_tags = round($player_average_tags, 0, PHP_ROUND_HALF_UP);
      //$img_src .= 'Dora_happy.gif"'; // wow!
      $game_score = TAGSCORE * $numTags;
      $message .= '<p class="game_congrats">You scored a grand total of ' . $game_score . ' points for this level. ';
      $message .= ' On average, you added ' . $player_average_tags . ' tags per object. You can check out the content you\'ve added by clicking on objects in your display case on the right.';
      
      mmgSaveGameScore($game_score, 'funtagging'); // store their game points
    }
  }
  
  if (!empty($player_average_tags)) {
  $site_average = mmgGetSiteTaggingAverages();
  
  if (!is_user_logged_in() ) {
    $save_scores_message = ' Did you know you can save your score by registering?  It only takes a minute.</p><p> ';
  }
  
  $game_score = $player_average_tags-$site_average; // could be negative
  
  if ($game_score >= 2) { // 2 above average
    $message .= ' Hey super tagger, you\'re smashing the game average ('.$site_average.')! '. $save_scores_message . ' Are you ready to play again and keep your lead?';    
  } elseif ($game_score > 0) { // 1 above average
    $message .= ' You\'re beating the game average ('.$site_average.'), go you! '. $save_scores_message . ' Are you ready to play again?';
  } elseif ($game_score == 0) {
    $message .= ' You\'re exactly on the game average ('.$site_average.')! '. $save_scores_message . ' Are you ready to have another go and see if you can do beat it?';  
  } elseif ($game_score < 0) {
    $message .= ' You\'re really close to the game average ('.$site_average.'). '. $save_scores_message . ' Are you ready to have another go and see if you can do better?'; 
  } else {
    $message .= ' That\'s not quite as much as the game average, but nevermind - have another go and see if you can improve your score. '. $save_scores_message ;
  }
  $message .= '</p>';

  // share
 /* $message .= '<p>And why not tell your friends? ';
  $message .= mmgGetShareLinks();
  $message .= '</p>'; */

  $message .= '<span class="play_again"><a href="#object" class="play_link">Help describe more objects</a></span>';
  }
  
  return $message;
  
}

/*
 * Stores the points awarded for a game win
 * e.g. completing a set (row of five objects) in Dora
 */
function mmgSaveGameScore($game_score, $game_code) {
  global $wpdb;
  global $current_user;
  $session_id = ($_COOKIE['PHPSESSID']); 
  $ip_address = $_SERVER['REMOTE_ADDR'];
  
  if (!empty($game_score)) {
    
  if(is_user_logged_in()) {
    get_currentuserinfo();
    $wp_username = $current_user->user_login; 
  } // will need to go back and update previous turns with login if they sign up - this may already be in @todo
  
  $wpdb->query( $wpdb->prepare( "
  INSERT INTO ". table_prefix."game_scores 
  (game_score, game_code, session_id, wp_username )
  VALUES ( %d, %s, %s, %s )" ,
  array( $game_score, $game_code, $session_id, $wp_username ) ) ); 
  $turn_id = mysql_insert_id();
  }

}

?>