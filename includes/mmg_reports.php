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
  
  //$wpdb->show_errors(); // harumph ###
  
    // get UGC
    $sql = "SELECT * FROM ". table_prefix."turns WHERE object_id = '" . $obj_id . "' ";
    echo $sql;
    $results = $wpdb->get_results($wpdb->prepare($sql)); 

  //var_dump($results); // also harumph ###

    if($results) { // is array, not object
      echo 'So far ' . count($results) . ' turns have added content about this object.';
    } else {
      echo 'No player content for this object yet.';
    }

    
  } else {
    echo '<p>No ID given; print a list instead</p>';
  }
  
}

 
?>