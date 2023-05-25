<?php 
// Check if our nonce is set.
if ( ! isset( $_POST['franchise_details_nonce'] ) ) {
    return;
}

// Verify that the nonce is valid.
if ( ! wp_verify_nonce( $_POST['franchise_details_nonce'], 'franchise_details_nonce' ) ) {
    return;
}

// If this is an autosave, our form has not been submitted, so we don't want to do anything.
if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
    return;
}

// Check the user's permissions.
if ( isset( $_POST['post_type'] ) && 'franchise' == $_POST['post_type'] ) {

    if ( ! current_user_can( 'edit_page', $post_id ) ) {
        return;
    }

}
else {

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
}

/* OK, it's safe for us to save the data now. */
    if ( ! isset( $_POST['cf_id'] ) || !isset( $_POST['cf_name'] ) || !isset( $_POST['cf_nap_number'] ) || !isset( $_POST['cf_google_review_shortcode'] ) || !isset( $_POST['cf_booknow_text'] ) || !isset( $_POST['cf_booknow_link'] )) {
        return;
    }

    // Sanitize user input.

    // foreach ($_POST['services_menu'] as $service_menu_items => $service_menu_items_val) {
    //     if(in_array('parent', $service_menu_items_val[$service_menu_items]) && !in_array('on', $service_menu_items_val[$service_menu_items]))
    //         continue;
    //     $services_menu[] = $service_menu_items_val;

    // }

    // foreach($services_menu as $services_child_menu_items_arr_key => $services_child_menu_items_arr_val){
    //     foreach ($services_child_menu_items_arr_val as $services_child_menu_item) {
    //         if(!in_array('on', $services_child_menu_item))
    //             continue;

    //         var_dump($services_child_menu_item);
    //     }
    //     var_dump($services_child_menu_items_arr_val);

    //         // $services_child_menu_items[] = $services_child_menu_items_arr;
    // }
    // var_dump($services_menu);
    // exit();

    $pageId = $_POST['select_page_for_location'];
    $cf_id = sanitize_text_field( $_POST['cf_id']);
    $cf_name = sanitize_text_field( $_POST[ 'cf_name']);
    $cf_logo = sanitize_text_field($_POST[ 'cf_logo']);
    $cf_nap_number = sanitize_text_field( $_POST['cf_nap_number']);
    $your_local_team = sanitize_text_field( $_POST['your_local_team']);
    $local_testimonials = sanitize_text_field( $_POST['local_testimonials']);
    $cf_google_review_shortcode = sanitize_text_field( $_POST['cf_google_review_shortcode']);
    /**
     * Ribbon fields
     */
    $side_ribbons = $_POST['side_ribbon'];
    $side_ribbon_arr = [];
    foreach($side_ribbons as $side_ribbon) { // loop through each inner array `label_name`, `ribbon_icon`, `ribbon_link` etc...
        foreach($side_ribbon as $side_ribbons_key => $side_ribbons_val) { // for each key (0, 1 etc) and value (ribbon text, ribbon icon etc) populate your $side_ribbon_arr
            if(empty($side_ribbons_val))
                continue;
            $side_ribbon_arr[$side_ribbons_key][] = $side_ribbons_val; // append $side_ribbons_val to the array at index $side_ribbons_key, if the array doesn't exist, create it and add $side_ribbons_val
        }
    }

    /**
     * Reviews Field
     */
    $reviews = $_POST['review'];
    $reviews_arr = [];
    foreach($reviews as $review) { // loop through each inner array `label_name`, `ribbon_icon`, `ribbon_link` etc...
        foreach($review as $reviews_key => $reviews_val) { // for each key (0, 1 etc) and value (ribbon text, ribbon icon etc) populate your $side_ribbon_arr
            if(empty($reviews_val))
                continue;
            $reviews_arr[$reviews_key][] = $reviews_val; // append $side_ribbons_val to the array at index $side_ribbons_key, if the array doesn't exist, create it and add $side_ribbons_val
        }
    }
    /**
     * City Pages
    */
    $city_pages = $_POST['city_page'];
    $city_pages_id = [];
    foreach($city_pages as $city_page_id) { // loop through each inner array `label_name`, `ribbon_icon`, `ribbon_link` etc...
        if(empty($city_page_id))
            continue;
        $city_pages_id[] = $city_page_id;
    }
    $cf_booknow_text = sanitize_text_field($_POST['cf_booknow_text']);
    $cf_booknow_link = sanitize_text_field($_POST['cf_booknow_link']);

    // Update the meta field in the database.
    update_post_meta( $pageId, 'locationId', $post_id);
    update_post_meta( $post_id, 'pageId', $pageId);
    update_post_meta( $post_id, 'cf_id',$cf_id);
    update_post_meta( $post_id, 'cf_name', $cf_name);
    update_post_meta( $post_id, 'cf_logo', $cf_logo);
    update_post_meta( $post_id, 'services_menu_data', $_POST['services_menu']);
    update_post_meta( $post_id, 'cf_nap_number', $cf_nap_number);
    update_post_meta( $post_id, 'your_local_team', $your_local_team);
    update_post_meta( $post_id, 'local_testimonials', $local_testimonials);
    update_post_meta( $post_id, 'cf_google_review_shortcode', $cf_google_review_shortcode);
    update_post_meta( $post_id, 'side_ribbons', $side_ribbon_arr);
    update_post_meta( $post_id, 'reviews', $reviews_arr);
    update_post_meta( $post_id, 'city_pages', $city_pages_id);
    update_post_meta( $post_id, 'cf_booknow_text',$cf_booknow_text );
    update_post_meta( $post_id, 'cf_booknow_link',$cf_booknow_link );

?>