<?php
/**
 * Near Foundation Admin Plugin functions and definitions
 *
 *
 * @package Near Foundation
 */


function get_page_id_by_slug($slug){
    global $wpdb;
    $id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name LIKE '".$slug."%' AND post_type = 'page' LIMIT 1");
    return $id;
}
