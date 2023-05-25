<?php 
    add_meta_box(
        'franchise-details',
        __( 'Franchises Data', CF_TEXT_DOMAIN),
        array($this, 'franchise_details_meta_box_callback')
    );
?>