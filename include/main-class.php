<?php
 include_once( ADMIN_DIRECTORY . '/form-fields.php' );
$pluginSettingOptions = (!empty(get_option( 'franchise_plugin_options' )) ? get_option( 'franchise_plugin_options') : array() );

$formFields = new FormFields();
// Block direct access to file
defined( 'ABSPATH' ) or die( 'Not Authorized!' );

class CompanyFranchise {
    public function __construct() {
        
        // Plugin uninstall hook
        register_uninstall_hook( CF_FILE, array('CompanyFranchise', 'plugin_uninstall') );

        // Plugin activation/deactivation hooks
        register_activation_hook( CF_FILE, array($this, 'plugin_activate') );
        register_deactivation_hook( CF_FILE, array($this, 'plugin_deactivate') );

        // Plugin Actions
        add_action( 'plugins_loaded', array($this, 'plugin_init') );
        add_action( 'wp_enqueue_scripts', array($this, 'plugin_enqueue_scripts') );
        add_action( 'admin_enqueue_scripts', array($this, 'plugin_enqueue_admin_scripts') );
        add_action( 'admin_menu', array($this, 'plugin_admin_menu_function') );
        //call register settings function
    	add_action( 'admin_init', array($this, 'plugin_register_settings') );
        
        add_action( 'add_meta_boxes_franchise', array($this, 'franchise_details_meta_box') );
        add_action( 'save_post', array($this, 'save_franchise_details_meta_box_data') );
        add_filter('use_block_editor_for_post_type', array($this, 'prefix_disable_gutenberg'), 10, 2);
        add_action( 'init', array($this, 'initFunc') );

        add_action( 'wp_ajax_nopriv_locationData', array($this, 'getLocationData') );
        add_action( 'wp_ajax_locationData', array($this, 'getLocationData') );

    }

    public static function plugin_uninstall() { }

    /**
     * Plugin activation function
     * called when the plugin is activated
     * @method plugin_activate
     */
    public function plugin_activate() { }

    /**
     * Plugin deactivate function
     * is called during plugin deactivation
     * @method plugin_deactivate
     */
    public function plugin_deactivate() { }

    /**
     * Plugin init function
     * init the polugin textDomain
     * @method plugin_init
     */
    function plugin_init() {
        // before all load plugin text domain
        load_plugin_textDomain( CF_TEXT_DOMAIN, false, dirname(CF_DIRECTORY_BASENAME) . '/languages' );
    }

    function plugin_admin_menu_function() {
        //create main top-level menu with empty content
        add_options_page( __('Franchises Settings', CF_TEXT_DOMAIN), __('Company Franchise', CF_TEXT_DOMAIN), 'manage_options', 'cf-general', array($this, 'plugin_settings_page'), 'dashicons-admin-generic', 4 );

    }
    function plugin_register_settings() {
        global $pluginSettingOptions;
        register_setting( 'franchise_plugin_options', 'franchise_plugin_options', array($this, 'franchise_plugin_options_validate', 3) );
        add_settings_section( 'franchise_default_settings', '', '', 'franchise_plugin' );
        /**
         * Default Logo Field
         */
        add_settings_field( 'default_logo', 'Logo', array($this, 'franchise_default_fields'), 'franchise_plugin', 'franchise_default_settings', array('fieldType' => 'image', 'fieldName' => 'default_logo') );
        
        /**
         * Header Button Field 
         */
        add_settings_field( 'header_button_text', 'Header Button Text', array($this, 'franchise_default_fields'), 'franchise_plugin', 'franchise_default_settings', array('fieldType' => 'text', 'fieldName' => 'header_button_text') );
        add_settings_field( 'header_button_link', 'Header Button Link', array($this, 'franchise_default_fields'), 'franchise_plugin', 'franchise_default_settings', array('fieldType' => 'page', 'fieldName' => 'header_button_link') );
        /**
         * Side Ribbon Fields 
         */
        for ($i=1; $i < 7; $i++) { 
            add_settings_field( 'default_ribbon_text_'.$i.'', 'Ribbon Text #'.$i.'', array($this, 'franchise_default_fields'), 'franchise_plugin', 'franchise_default_settings', array('fieldType' => 'text', 'fieldName' => 'default_ribbon_text_'.$i.'', 'class' => ($i == 1 ? 'firstRibbonTr sideRibbonField' : 'sideRibbonField' ) ) );
            add_settings_field( 'default_ribbon_icon_'.$i.'', 'Ribbon Icon #'.$i.'', array($this, 'franchise_default_fields'), 'franchise_plugin', 'franchise_default_settings', array('fieldType' => 'image', 'fieldName' => 'default_ribbon_icon_'.$i.'', 'class' => 'sideRibbonField') );
            add_settings_field( 'default_ribbon_link_'.$i.'', 'Ribbon Link #'.$i.'', array($this, 'franchise_default_fields'), 'franchise_plugin', 'franchise_default_settings', array('fieldType' => 'text', 'fieldName' => 'default_ribbon_link_'.$i.'', 'class' => ($i == 6 ? 'lastRibbonTr sideRibbonField' : 'sideRibbonField' )) );
        }

        /**
         * Call us Text and icon
         */
        // $header_call_text = get_post_meta( $post->ID, 'header_call_text', true );
        add_settings_field( 'header_call_text', 'Call us text', array($this, 'franchise_default_fields'), 'franchise_plugin', 'franchise_default_settings', array('fieldType' => 'text', 'fieldName' => 'header_call_text' ) );

        add_settings_field( 'main_menu', 'Default Main Menu ', array($this, 'franchise_default_fields'), 'franchise_plugin', 'franchise_default_settings', array('fieldType' => 'menu', 'fieldName' => 'main_menu'));
        if(!empty($pluginSettingOptions['main_menu'])){
            add_settings_field( 'main_menu_item_about', 'Default About Menu', array($this, 'franchise_default_fields'), 'franchise_plugin', 'franchise_default_settings', array('fieldType' => 'menu_items', 'fieldName' => 'main_menu_item_about'));

            add_settings_field( 'main_menu_item_testmonial', 'Default Testmonials Menu', array($this, 'franchise_default_fields'), 'franchise_plugin', 'franchise_default_settings', array('fieldType' => 'menu_items', 'fieldName' => 'main_menu_item_testmonial'));

            // add_settings_field( 'main_menu_item_services', 'Default Services Menu', array($this, 'franchise_default_fields'), 'franchise_plugin', 'franchise_default_settings', array('fieldType' => 'menu_items', 'fieldName' => 'main_menu_item_services'));

            
            add_settings_field( 'main_menu_item_location', 'Default Location Menu', array($this, 'franchise_default_fields'), 'franchise_plugin', 'franchise_default_settings', array('fieldType' => 'menu_items', 'fieldName' => 'main_menu_item_location'));
            add_settings_field( 'location_submenu_li_classes', 'Add classes for location submenu &lt;li>', array($this, 'franchise_default_fields'), 'franchise_plugin', 'franchise_default_settings', array('fieldType' => 'text', 'fieldName' => 'location_submenu_li_classes'));
            add_settings_field( 'location_submenu_a_classes', 'Add classes for location submenu &lt;a>', array($this, 'franchise_default_fields'), 'franchise_plugin', 'franchise_default_settings', array('fieldType' => 'text', 'fieldName' => 'location_submenu_a_classes'));
            add_settings_field( 'location_submenu_indicator_tag', 'Add tag for location submenu icon', array($this, 'franchise_default_fields'), 'franchise_plugin', 'franchise_default_settings', array('fieldType' => 'text', 'fieldName' => 'location_submenu_indicator_tag'));
        }
        
    }

    function franchise_default_fields( array $args){
        global $formFields;
        global $pluginSettingOptions;
        $fieldType = $args['fieldType'];
        $fieldName = $args['fieldName'];
        switch ($fieldType) {
            case 'text':
                _e($formFields->inputField(esc_attr( $pluginSettingOptions[$fieldName]), 'franchise_plugin_options['.$fieldName.']', '', $fieldType,'','',false ));   
            break;

            case 'image':
                _e($formFields->selectImage( $pluginSettingOptions[$fieldName], 'medium', 'franchise_plugin_options['.$fieldName.']'));
            break;

            case 'page':
                _e($formFields->selectField($pluginSettingOptions[$fieldName], 'franchise_plugin_options['.$fieldName.']', '', 'select2', array(), false, 'Select a Page', 'page'));
            break;

            case 'menu':
                _e($formFields->selectField($pluginSettingOptions[$fieldName], 'franchise_plugin_options['.$fieldName.']', '', 'select2', array(), false, 'Select Menu Location', 'menu'));
            break;
            case 'menu_items':
                _e($formFields->selectField($pluginSettingOptions[$fieldName], 'franchise_plugin_options['.$fieldName.']', '', 'select2', array(), false, 'Select Menu Item', 'menu_items', true));
            break;

            default:
                _e($formFields->inputField(esc_attr( $pluginSettingOptions[$fieldName]), 'franchise_plugin_options['.$fieldName.']', '', $fieldType,'','',false ));   
            break;
        }
    }
    /**
     * Register the main Plugin Settings
     * @method plugin_register_settings
     */
    // function franchise_plugin_options_validate(  $value, $field, $name ) {
    //     if ( empty( $value ) ) {
    //         $value = get_option( $field ); // ignore the user's changes and use the old database value
    //         add_settings_error( 'my_option_notice', "invalid_$field", "$name is required." );
    //     }
    //     return $value;
    // }

    /**
     * Enqueue the main Plugin admin scripts and styles
     * @method plugin_enqueue_scripts
     */
    function plugin_enqueue_admin_scripts() {
        wp_register_style( 'cf-admin-style', CF_DIRECTORY_URL . '/assets/dist/css/admin-style.css', array(), null );
        wp_register_style( 'select2', CF_DIRECTORY_URL . '/assets/dist/css/select2.min.css', array(), null );
        wp_register_script( 'select2', CF_DIRECTORY_URL . '/assets/dist/js/select2.min.js', array(), null, true );
        wp_register_script( 'cf-admin-script', CF_DIRECTORY_URL . '/assets/dist/js/admin-script.min.js', array(), null, true );
        wp_enqueue_script('jquery');
        wp_enqueue_style('select2');
        wp_enqueue_style('cf-admin-style');
        wp_enqueue_script('select2');
        wp_enqueue_script('cf-admin-script');
        if ( ! did_action( 'wp_enqueue_media' ) ) {
            wp_enqueue_media();
        }
    }

    /**
     * Enqueue the main Plugin user scripts and styles
     * @method plugin_enqueue_scripts
     */
    function plugin_enqueue_scripts() {
        wp_register_style( 'cf-user-style', CF_DIRECTORY_URL . '/assets/dist/css/user-style.css', array(), null );
        wp_register_script( 'cookie', CF_DIRECTORY_URL . '/assets/dist/js/jquery.cookie.js', array(), null, true );
        wp_register_script( 'cf-user-script', CF_DIRECTORY_URL . '/assets/dist/js/user-script.min.js', array(), null, true );
        wp_localize_script('cf-user-script', 'locationId', array('locationId' => getIdFromCookie(), 'ajax_url' => admin_url( 'admin-ajax.php' )));
        wp_enqueue_script('jquery');
        wp_enqueue_script('cookie');
        wp_enqueue_style('cf-user-style');
        wp_enqueue_script('cf-user-script');
    }

    /**
     * Plugin main settings page
     * @method plugin_settings_page
     */
    function plugin_settings_page() { 
        include_once ( ADMIN_DIRECTORY . '/settings-page.php' );
     }

    function initFunc(){
        /**
         * Utility Functions
         */
        include_once( PUBLIC_DIRECTORY . '/utility.php' );
        getIdFromCookie();

        /**
         * Create Shortcodes
         */
        include_once ( PUBLIC_DIRECTORY . '/shortcodes.php' );
        
        /*
        * Create Franchise CPT
        */
        include_once ( ADMIN_DIRECTORY . '/register-post-type.php' );

        /***
         * Add Menu Theme Location
         */
        // register_nav_menu('cf-main-menu',__( 'Main Menu' ));
    }

    /** Add Meta boxes */
    function franchise_details_meta_box($post) {
        if($post->post_parent == 0)
            include_once ( ADMIN_DIRECTORY . '/add-metafields.php' );
    }
    
    function franchise_details_meta_box_callback( $post ) {
            include_once ( ADMIN_DIRECTORY . '/metafields-html.php' );
    }
    /**
     * When the post is saved, saves our custom data.
     *
     * @param int $post_id
     */
    function save_franchise_details_meta_box_data( $post_id ) {
            include_once ( ADMIN_DIRECTORY . '/save-metafields.php' );

    }
    function prefix_disable_gutenberg($current_status, $post_type)
    {
        if ($post_type === 'franchise') return false;
        return $current_status;
    }
    
    function getLocationMenuLink($default_menu_id, $location_menu_id, $sub_pages = false){
        if(!$sub_pages)
            return array('dafault_menu_id' => $default_menu_id,'url' => get_the_permalink($location_menu_id));

        if($sub_pages){
            $city_pages = $location_menu_id;
            $city_pages_arr = array();
            for ($i=0; $i < count($city_pages); $i++) { 
                $city_pages_arr[] = array(
                    'dafault_menu_id' => $default_menu_id,
                    'url' => get_the_permalink($city_pages[$i]),
                    'title' => get_the_title($city_pages[$i])
                );
            }
            return $city_pages_arr;
        }
    }
    function getLocationData(){
        if(empty($_POST['locationId']))
            return;
        global $pluginSettingOptions;

        $locationId = $_POST['locationId'];
        $default_about_menu_id = $pluginSettingOptions['main_menu_item_about'];
        $default_testmonial_menu_id =  $pluginSettingOptions['main_menu_item_testmonial'];
        $default_location_menu_id = $pluginSettingOptions['main_menu_item_location'];

        $location_about_menu_id = get_post_meta($locationId, 'your_local_team', true);
        $location_services_menu = get_post_meta($locationId, 'services_menu_data', true);
        $location_testmonial_menu_id = get_post_meta($locationId, 'local_testimonials', true);
        $location_city_pages = get_post_meta($locationId, 'city_pages', true);
        $cfLogoId = get_post_meta($locationId, 'cf_logo', true);
        $locationNumber = get_post_meta($locationId, 'cf_nap_number', true);
        $locationRibbons = get_post_meta($locationId, 'side_ribbons', true );
        $locationRibbonsArr= array();
        $locationSubmenuClasses = array();
        
        foreach ($locationRibbons as $locationRibbon) {
            $locationRibbonsArr[] = array(
                'ribbonIcon'=>getImageUrl((int)$locationRibbon[1]),
                'ribbonText'=>$locationRibbon[0],
                'ribbonLink' => $locationRibbon[2]
            );
        }
        if(!empty($locationNumber)){
            $locationNumber = array(
                'number' => get_post_meta($locationId, 'cf_nap_number', true),
                'text' => $pluginSettingOptions['header_call_text']
            );
        }
        $locationData = array(
            'locationLogo' => getImageUrl($cfLogoId),
            'locationRibbons' => $locationRibbonsArr
        );
        if(!empty($locationNumber))
            $locationData['locationNumber'] = $locationNumber;

        if(!empty($location_about_menu_id) && !empty($default_about_menu_id))
            $locationData['locationAbout'] = $this->getLocationMenuLink($default_about_menu_id, $location_about_menu_id);

        if(!empty($location_testmonial_menu_id) && !empty($default_testmonial_menu_id))
            $locationData['locationTestmonial'] = $this->getLocationMenuLink($default_testmonial_menu_id, $location_testmonial_menu_id);

        if(!empty($location_city_pages) && !empty($default_location_menu_id)){
            $locationSubmenuClasses['li_classes'] = $pluginSettingOptions['location_submenu_li_classes'];
            $locationSubmenuClasses['a_classes'] = $pluginSettingOptions['location_submenu_a_classes'];
            $locationSubmenuClasses['submenu_indicator'] = $pluginSettingOptions['location_submenu_indicator_tag'];
            $locationData['locationSubmenuClasses'] = $locationSubmenuClasses;
            $locationData['locationCityPages'] = $this->getLocationMenuLink($default_location_menu_id, $location_city_pages, true);
        }
        if(!empty($location_services_menu)){
            $locationData['servicesMenu'] = $location_services_menu;
        }
        
        wp_send_json_success($locationData);
        die();
    }
}

new CompanyFranchise;
