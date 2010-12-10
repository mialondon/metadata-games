<?php
/**
 * Functions for reporting levels of activity and content generated
 * 
 * Copyright (C) 2010 Mia Ridge
 * 
 * @since 0.2
 * 
 */

/**
 * 
 * 
 * @since 0.2
 * 
 */
 
function mmgSiteStats() {
  global $wpdb;

  // number of objects tagged
  $sql = 'SELECT count(DISTINCT object_id) AS num_objects FROM '. table_prefix.'turns ';

  $results = $wpdb->get_row ($wpdb->prepare ($sql));

  if(is_object($results)) {
    echo 'So far players have added information to <strong>'. $results->num_objects . ' objects</strong> through games on this site.';
  } 
  
}

// for any object ID (internal ID at first then maybe accession number...)
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
    $sql = "SELECT * FROM ". table_prefix."turns WHERE object_id = '" . $obj_id . "' ORDER BY game_code";
    //echo $sql;
    $results = $wpdb->get_results($wpdb->prepare($sql)); 

    if($results) { // is array, not object
      echo '<p>So far ' . count($results) . ' turns have added content about this object.</p>';
      // if object exists in turns, get data from each table with related data by game type
      // get tags
      echo '<div class="ugctags"><h3>Tags</h3><p>';
      $tag_string = mmgPrintUGCTags($obj_id);
      //$tag_string = rtrim($tag_string, ','); // doesn't work?
      echo $tag_string;
      echo '</p></div>';
    
      // get facts
      echo '<div class="ugcfact">';
      $fact_string = mmgPrintUGCFacts($obj_id);
      echo $fact_string;
      echo '</div>';
      // ### add links to add your own tags or facts with URLs based on config settings
    
      
    } else {
      echo 'No player content for this object yet.';
    }

    
  } else {
    echo '<h2>A list of objects with data created by players</h2><p>Follow a link to see what\'s been added for that object so far.  (At the moment it\'s by internal ID, not museum or accession number - sorry!  Also, some of the content is test content - I will be tidying that up.  If you see anything objectionable, let me know via the Contact page.)</p>';
    $sql = "SELECT count( object_id ) AS numUGC, object_id FROM ". table_prefix."turns GROUP BY object_id ORDER BY numUGC DESC";
    $results = $wpdb->get_results($wpdb->prepare($sql));
    
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
  $factssql .= " WHERE ". table_prefix."turns.turn_id = ". table_prefix."turn_facts.turn_id AND ". table_prefix."turns.object_id = '" . $object_id . "' ";
  //echo $factssql;
  $factresults = $wpdb->get_results($wpdb->prepare($factssql));
  // print facts
  if($factresults) { // is array, not object
    foreach ($factresults as $factresult) {
      $fact_string .= '<h3>Headline: ' . $factresult->fact_headline . '</h3><p>Summary: ' . urldecode($factresult->fact_summary) . '<br />Source: ' . $factresult->fact_source . '</p>';
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
  $tagssql .= " WHERE ". table_prefix."turns.turn_id = ". table_prefix."turn_tags.turn_id AND ". table_prefix."turns.object_id = '" . $object_id . "' ";
  //echo $tagssql;
  $tagresults = $wpdb->get_results($wpdb->prepare($tagssql));
  if($tagresults) { // is array, not object  
    foreach ($tagresults as $tagresult) {
      $tag_string .= ' ' . $tagresult->tag . ', ';
    }
  } else {
      $tag_string = '';
  }
  
  return $tag_string;
}
?>