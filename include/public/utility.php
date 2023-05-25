<?php

/**
 * @global $post WP_Post
 * @return bool
 */
/**
 * Get plugin setting options
 */
/**
 * Get Default Logo
 */
function getDefaultLogo(){
    global $pluginSettingOptions;
    if(empty($pluginSettingOptions['default_logo'])){
        return false;
    }
    else{
        $defaultLogo = '<img src="'.getImageUrl($pluginSettingOptions['default_logo'], 'medium').'" alt="Location Logo" id="siteLogo" />';
        return $defaultLogo;
    }
}
function getImageUrl($imageId, $size = 'full'){
	return wp_get_attachment_image_src( $imageId, $size)[0];

}

////// LOCATIONS FUNCTIONS

// isMain();
// idLocation();
// titleLocation();
// phoneLocation();
// addressLocation();
// areasLocation();
// zipCodesLocation();
// stateLocation();
// mapLocation();
// socialLinksLocation();

function isLocation(){

	global $post;

	// Is current post/page a location page? (e.g. restoration1.com/austin/)
	$locationId = get_post_meta( get_the_ID(), 'locationId', true );
	// var_dump($locationId);
	if ( get_post_type($locationId) === 'franchise' ) { 
		return true;
	}

	// if ( $template == "templates/franchise-page.php" ) {
	// 	return true;
	// }

	if ( isset( $post->post_parent ) && $post->post_parent ) {
		// Otherwise, is current post/page a child of a location page?
		$locationId = get_post_meta( $post->post_parent, 'locationId', true );
		// var_dump(get_post_type($locationId));
		if ( get_post_type($locationId) === 'franchise' ) { 
			return true;
		}
	}

	return false;
}

////// GET LOCATION ID
function idLocation(){
	global $post;
	if ($post->post_parent)	{
		$ancestors=get_post_ancestors($post->ID);
		$root=count($ancestors)-1;
		$parent = $ancestors[$root];
		$locationId = get_post_meta($parent, 'locationId', true );
		return $locationId;
	} else {
		$locationId = get_post_meta($post->ID, 'locationId', true );
		$parent = $locationId;
		return $parent;
	}
}

function getIdFromCookie(){
	if ( isLocation() == false ){
		if(isset($_COOKIE['franchise_id'])) {
			return $_COOKIE['franchise_id'];
		}
	}else{
		return idLocation();
	}
}

function locationPermalink(){
	return get_permalink(getIdFromCookie());
}

//// Mobile Menu
function mobileMenu(){
	wp_nav_menu( array( 'menu' => 263, 'menu_class' => 'nav nav-pills', 'after' => '<span></span>' ) );
}

//// TITLE LOCATION
function titleLocation(){
	echo get_the_title(getIdFromCookie());
}

//// LOCATION ID
function dbIdLocation(){
	if( ! class_exists('ACF') )
		return;

	return get_field( "franchise_id", getIdFromCookie() );
}

//// LOCATION NAME
function nameLocation(){
	if( ! class_exists('ACF') )
		return;

	return get_field( "franchise_name", getIdFromCookie() );
}

//// LOCATION LOGO
function logoLocation(){
	if( ! class_exists('ACF') )
		return;

	return get_field( "location_logo", getIdFromCookie() );
}

//// PHONE LOCATION
function phoneLocation(){
	if( ! class_exists('ACF') )
		return;

	return get_field( "napnumber", getIdFromCookie() );
}

//// YOUR LOCAL TEAM PAGE URL
function yourLocalTeamPageLocation(){
	if( ! class_exists('ACF') )
		return;

	return get_field( "about_us__your_local_team_page", getIdFromCookie() );
}

//// YOUR LOCAL TEAM PAGE URL
function emailLocation(){
	if( ! class_exists('ACF') )
		return;

	return get_field( "email", getIdFromCookie() );
}

//// LOCATION SIDE RIBBONS
function sideRibbonLocation( $field_name ){
	if( ! class_exists('ACF') )
		return;

	$sideRibbonFields = get_field( 'side_ribbon_fields', getIdFromCookie() );
	if($sideRibbonFields)
		return $sideRibbonFields[$field_name];
}

// For General Ribbons
function sideRibbonGeneral( $field_name ){
	if( ! class_exists('ACF') )
		return;

	$sideRibbonFieldsGeneral = get_field( 'side_ribbon_fields_general' , 5 );
	if($sideRibbonFieldsGeneral)
		return $sideRibbonFieldsGeneral[$field_name];
}

// LOCATION CUSTOM MENU ITEM UNDER ABOUT US
function localCustomizableMenuItemLocation(){
	if( ! class_exists('ACF') )
		return;

	return get_field( "local_customizable_menu_item", getIdFromCookie() );
}

// GET HOUSE CALL REVIEWS SCRIPT
function housecallProDetailsLocation( $field_name ){
	if( ! class_exists('ACF') )
		return;

	$sideRibbonFields = get_field( 'housecall_pro_details', getIdFromCookie() );
	if($sideRibbonFields)
		return $sideRibbonFields[$field_name];
}

// GET LINK OF LOCATION TESTIMONIAL PAGE
function testimonialPageLocation(){
	if( ! class_exists('ACF') )
		return;

	return get_field( "local_testimonials_page", getIdFromCookie() );
}

// GET CITY PAGES LINKS
function cityPagesLocation(){
	if( ! class_exists('ACF') )
		return;

	return get_field( "city_pages", getIdFromCookie() );
}

//// ADDRESS LOCATION
function addressLocation(){
	echo get_post_meta(  getIdFromCookie(), 'cmb_home_location_address', true );
}

function hideAddress(){
	return get_post_meta(  getIdFromCookie(), 'cmb_home_location_hide_address', true );
}

//// LOCAL MAIL
function localSiteEmail(){
	echo get_post_meta( getIdFromCookie(), 'cmb_home_location_email', true );
}

//// AREAS LOCATION
function areasLocation(){
	echo get_post_meta( getIdFromCookie(), 'cmb_home_location_areas', true );
}

function localSite(){
	return get_post_meta( getIdFromCookie(), 'cmb_home_location_website', true );
}

//// ZIP CODES LOCATION
function zipCodesLocation(){
	echo get_post_meta( getIdFromCookie(), 'cmb_home_location_zip_codes', true );
}

//// MAP LOCATION
function mapLocation(){
	echo get_post_meta( getIdFromCookie(), 'cmb_home_location_map', true );
}

//// STATE LOCATION
function stateLocation(){
	echo get_post_meta( getIdFromCookie(), 'cmb_home_location_state', true );
}

//// GET PERMALINK LOCATION
function getPermalinkLocation(){
	echo get_permalink(getIdFromCookie());
}

//// GET SERVICES LOCATION
function menu_services_shortcode(){
	ob_start();
	$services = get_post_meta( getIdFromCookie(), 'cmb_home_location_services', true );
	if (!empty($services)){
		echo '<div class="menu-services menu-service-sidebar"><ul>';
		foreach ( $services as $key => $entry ):
			echo '<li class="service-'.$entry.'"><a href="'.get_the_permalink($entry).'">'.get_the_title($entry).'</a></li>' ;
		endforeach;
		echo '</ul></div>';
	}else{
		wp_nav_menu( array( 'theme_location' => 'services-menu') );
	}
	return ob_get_clean();
}
add_shortcode('menu_services', 'menu_services_shortcode');

// SOCIAL LINKS LOCATION
function socialLinksLocation(){
	$socialLinks = get_post_meta(  getIdFromCookie(), 'cmb_home_location_social_links', true );
	if (!empty($socialLinks)) {
		foreach ($socialLinks as $link) {
			echo '<a href="' . $link . '" target="_blank" rel="noopener"></a>';
		}
	}else{
		echo '<a href="https://www.facebook.com/Restoration1Headquarters/" target="_blank" rel="noopener"><span>Facebook Social Link</span></a><a href="https://twitter.com/Restoration1HDQ" target="_blank" rel="noopener"><span>Twitter Social Link</span></a><a href="https://www.linkedin.com/company/restoration-1-headquarters" target="_blank" rel="noopener"><span>LinkedIn Social Link</span></a>';
	}
}

//// SHORTCODE BLOG LOCATION
if(!function_exists('blog_location')){
	function blog_location($atts, $content = null){
		ob_start();
		$content = trim(do_shortcode(shortcode_unautop($content)));
		extract(shortcode_atts(array("location" => ''), $atts));
		echo '<div class="list-blog">';
		$loop = new WP_Query(
			array(
				'post_type' => 'post',
				'posts_per_page' => 5,
				'tax_query' => array(
					array(
						'taxonomy' => 'category',
						'field'    => 'slug',
						'terms'    => $location,
					),
				),
			)
		);
		while ( $loop->have_posts() ) : $loop->the_post();
			get_template_part( 'template-parts/content-category', 'none' );
		endwhile; wp_reset_query();
		echo '</div><div id="pagination" class="clearfix">';
			if(function_exists('tw_pagination')) tw_pagination($loop);
		echo '</div>';
		return ob_get_clean();
	}
}
add_shortcode('blog', 'blog_location');

function validateServicesHeirarchy( $values ){

    $parent_is_active = false;
    foreach( $values as $value ){

        if( strpos( $value['field_5fc7bb0076034'] , 'DO NOT UNSELECT THIS IF ANY CHILD ITEM IS SELECTED' ) !== false ){
             $parent_is_active = $value['field_5fc8da25b4cb3'];
             continue;
        }
        if( $value['field_5fc8da25b4cb3'] && !$parent_is_active)
            return false;
    }
    return true;
}

function services_arr(){
	$services = array(
			'18216' 	=> 'Concrete Services(DO NOT UNSELECT THIS IF ANY CHILD ITEM IS SELECTED)',
			'18223' 		=> '- Concrete Repair & Maintenance',
			'18217' 		=> '- Concrete Crack & Joint Repair',
			'23613' 		=> '- Concrete Filling',
			'23606' 		=> '- Concrete Lifting',
			'23605' 		=> '- Concrete Leveling',
			'18218' 		=> '- Concrete Dye & Polishing',
			'23607' 		=> '- Concrete Mudjacking',
			'18224' 		=> '- Decorative Concrete Services',
			'25257'			=> '- Residential Concrete Demolition',
			'18225' 	=> 'Sealants & Cleaning(DO NOT UNSELECT THIS IF ANY CHILD ITEM IS SELECTED)',
			'18231' 		=> '- Waterproofing',
			'18229' 		=> '- Top-Coat Sealing',
			'18230' 		=> '- UV Resistant Top Coat',
			'18226' 		=> '- Epoxy/Aspartic & Polymer Coatings',
			'18228' 		=> '- Surface Cleaning',
			'18227' 		=> '- Pressure Washing',
			'23818'			=> '- Concrete Deep Seal',
			'24836'			=> '- Color Concrete Sealant',
			'24837'			=> '- Stamped Concrete Sealant',
			'24835'			=> '- Brick & Paver Sealant',
			'18232' 	=> 'Commercial Concrete Services(DO NOT UNSELECT THIS IF ANY CHILD ITEM IS SELECTED)',
			'25261'         => '- Commercial Concrete Demolition',
			'18233' 		=> '- Commercial concrete repair & maintenance',
			'18234' 		=> '- Commercial crack & joint repair',
			'18235' 		=> '- Commercial filling, lifting & leveling',
			'18236' 		=> '- Other Commercial Services',
			'18237' 	=> 'Other Services(DO NOT UNSELECT THIS IF ANY CHILD ITEM IS SELECTED)',
			'18241' 		=> '- Paver Repair & Maintenance',
			'18238' 		=> '- Brick Repair & Maintenance',
			'18239' 		=> '- Foundation Crack Repair',
			'18242' 		=> '- Rubber Surfacing',
			'18240' 		=> '- Overlays',
		);
	return $services;
}

