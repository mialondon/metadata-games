<?php
/**
 * Functions for reporting levels of activity and content generated
 * 
 * Copyright (C) 2014 Mia Ridge
 * 
 * @since 0.2
 * 
 */
 
function mmgSiteStats() {
  global $wpdb;

  // number of objects tagged
  $sql = 'SELECT count(DISTINCT object_id) AS num_objects FROM '. table_prefix.'turns ';

  $results = $wpdb->get_row($sql);

  if(is_object($results)) {
    echo 'So far players like you have improved <strong>'. $results->num_objects . ' records</strong> for <strong>3 museums and libraries</strong> through games on this site.';
  } 
  
}

// for any object ID 
/*
 * Uses obj_ID param as added for obj bookmark
 */
function mmgListObjectUGC() {
  
  global $wp_query;
  global $wpdb;
  
  if (isset($wp_query->query_vars['obj_ID'])) {
    // sanitise the input? ###
    $obj_id = $wp_query->query_vars['obj_ID'];
    
    // print the object to the screen
    list($object_id, $object_print_string) = printObject();
    echo $object_print_string;
  
    // get UGC
    $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM ". table_prefix."turns WHERE object_id = '%d' ORDER BY game_code", $obj_id));

    if($results) { // is array, not object
      $count=count($results);
      $message = '<p>So far people have added content in '. count($results) . ' turn';
      if ($count > 1) {  // grammar for one tag
       $message .=  's '; 
      }
      $message .=  ' about this object.</p>';
      // if object exists in turns, get data from each table with related data by game type
      // get tags
      $message .= '<div class="ugctags"><h3>Tags</h3><p>';
      $tag_string = mmgPrintUGCTags($obj_id);
      if (!empty($tag_string)) {
        $message .= $tag_string;
      } else { // 'no tags yet, why not add some'? 
        $message .= 'No tags yet. Why not <a href="' . PATH_TO_DORA_PAGE . '?obj_ID='.$obj_id.'" title="Help Dora with this object" target="_blank">help Dora by adding some?</a>';
      }
      
      $message .= '</p></div>';
    
      // get facts
      $message .= '<div class="ugcfact">';
      $fact_string = mmgPrintUGCFacts($obj_id);
      if (!empty($fact_string)) {
        $message .= $fact_string;
      } else {// 'no facts yet, why not add some'? 
        $message .= '<h3>Facts</h3><p>No facts yet. Why not <a href="' . PATH_TO_DONALD_PAGE . '?obj_ID='.$obj_id.'" title="find an interesting fact about this object" target="_blank">take the fact challenge with this object?</a></p>';
      }      
      $message .= '</div>';
      // ### add links to add your own tags or facts with URLs based on config settings
    
      echo $message;
      
    } else {
      echo 'No player content for this object yet.';
    }

    
  } elseif(isset($wp_query->query_vars['report'])) {
    $report_type = $wp_query->query_vars['report'];
    if($report_type == 'facts') {
      $sql = "SELECT count( object_id ) AS numUGC, object_id FROM ". table_prefix."turns WHERE game_code = 'factseeker' GROUP BY object_id ORDER BY numUGC DESC";
      $results = $wpdb->get_results($sql);
    
      foreach ($results as $result) {
        echo '<p><a href="?obj_ID='.$result->object_id.'">'.$result->object_id.'</a> has '.$result->numUGC .' facts</p>';
      }
      } else {
        echo 'Sorry, report type not found.';
      }
    
  } else { // no parameter
    echo '<h2>The objects listed below have data created by players</h2><p>Follow a link to see what\'s been added for that object so far.  If you see anything objectionable, report it!</p>';
    $sql = "SELECT count( object_id ) AS numUGC, object_id FROM ". table_prefix."turns GROUP BY object_id ORDER BY numUGC DESC";
    $results = $wpdb->get_results($sql);
    
    foreach ($results as $result) {
      echo '<p><a href="?obj_ID='.$result->object_id.'">'.$result->object_id.'</a> has '.$result->numUGC .' tags or facts</p>';
    }
  }
  
}

function mmgPrintUGCFacts($object_id) {
  $fact_string;
  
  global $wpdb;
  
  // get facts
  $factssql = "SELECT ". table_prefix."turns.*, ". table_prefix."turn_facts.fact_headline, ". table_prefix."turn_facts.fact_summary, ". table_prefix."turn_facts.fact_source FROM ". table_prefix."turns JOIN ". table_prefix."turn_facts ";
  $factssql .= " WHERE ". table_prefix."turns.turn_id = ". table_prefix."turn_facts.turn_id AND ". table_prefix."turns.object_id = %d";
  //echo $factssql;
  $factresults = $wpdb->get_results($wpdb->prepare($factssql, $object_id)); 
  // print facts
  if($factresults) { // is array, not object
    foreach ($factresults as $factresult) {
      $fact_string .= '<h3>Headline: ' . stripslashes($factresult->fact_headline) . '</h3><p>Summary: ' . stripslashes(urldecode($factresult->fact_summary)) . '<br />Source: ' . stripslashes(urldecode($factresult->fact_source)). '</p>';
    }
  } else {
    $fact_string = '';
  }
  
  return $fact_string;
   
}

function mmgPrintUGCTags($object_id) {
  
  $tag_string;
  global $wpdb;
  
  // get tags
  $tagssql = "SELECT ". table_prefix."turns.*, ". table_prefix."turn_tags.tag FROM ". table_prefix."turns JOIN ". table_prefix."turn_tags ";
  $tagssql .= " WHERE ". table_prefix."turns.turn_id = ". table_prefix."turn_tags.turn_id AND ". table_prefix."turns.object_id = %d";
  //echo $tagssql;
  $tagresults = $wpdb->get_results($wpdb->prepare($tagssql, $object_id)); 
  if($tagresults) { // is array, not object  
    foreach ($tagresults as $tagresult) {
      $tag_string .= ' ' . stripslashes($tagresult->tag) . ', ';
    }
  } else {
      $tag_string = '';
  }
  $tag_string = trim($tag_string, ', '); // remove last comma
  return $tag_string;
}
?>