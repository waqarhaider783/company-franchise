<?php 
register_post_type( 'franchise',
    array(
    'labels' => array(
        'name' => __( 'Franchises' ),
        'singular_name' => __( 'Franchise' )
    ),
    'public' => true,
    // 'rewrite'   => array( 'slug' => '', 'with_front' => false),
    'capability_type' => 'post',
    'hierarchical' => false,
    'show_in_rest' => true,
    'publicly_queryable'    => false,
    'supports' => array('title'),
    'menu_icon' => 'dashicons-store',
    'menu_position' => 5
    )
);
flush_rewrite_rules();
?>