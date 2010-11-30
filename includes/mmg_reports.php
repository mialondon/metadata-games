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
 