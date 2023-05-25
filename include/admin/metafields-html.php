<?php 
    global $formFields;
    global $pluginSettingOptions;
    // labelField parameters formLabel($title)
    // inputField parameters inputField($value, $name, $placeholder, $type, $id, $class, $readOnly = false)
    // selectField parameters selectField($selectedValue, $name, $id, $class, $options = array(), $multiple = false, $firstOptiontitle = 'Select Options')
    // Add a nonce field so we can check for it later.
    wp_nonce_field( 'franchise_details_nonce', 'franchise_details_nonce' );

    $cf_id = get_post_meta( $post->ID, 'cf_id', true );
    $cf_name = get_post_meta( $post->ID, 'cf_name', true );
    $cf_logo = get_post_meta( $post->ID, 'cf_logo', true );
    $cf_nap_number = get_post_meta( $post->ID, 'cf_nap_number', true );
    $your_local_team = get_post_meta( $post->ID, 'your_local_team', true );
    $local_testimonials = get_post_meta( $post->ID, 'local_testimonials', true );
    $cf_google_review_shortcode = get_post_meta( $post->ID, 'cf_google_review_shortcode', true );
    $side_ribbons = get_post_meta( $post->ID, 'side_ribbons', true );
    $reviews = get_post_meta( $post->ID, 'reviews', true );
    $city_pages = get_post_meta( $post->ID, 'city_pages', true );
    $pageId = get_post_meta( $post->ID, 'pageId', true );
    $cf_booknow_text = get_post_meta( $post->ID, 'cf_booknow_text', true );
    $cf_booknow_link = get_post_meta( $post->ID, 'cf_booknow_link', true );
    $services_menu_data = get_post_meta( $post->ID, 'services_menu_data', true );
    
    ?>
<div class="field-wrap-main">
    <?php
        _e($formFields->formLabel('Select Page'));
        _e($formFields->selectField($pageId, 'select_page_for_location', '', 'select2', array(), false, 'Select a option', 'page'));
    ?>
</div>

    <div class="field-wrap-main">
        <?php
            _e($formFields->formLabel('Franchise ID'));
            _e($formFields->inputField($cf_id, 'cf_id', '', 'number','','',false ));
        ?>
    </div>
    <div class="field-wrap-main">
        <?php
            _e($formFields->formLabel('Franchise Name'));
            _e($formFields->inputField($cf_name, 'cf_name', '', 'text','','',false ));
        ?>
    </div>
    <div class="field-wrap-main">
        <?php
            _e($formFields->formLabel('Franchise Logo'));
            _e($formFields->selectImage($cf_logo, 'medium', 'cf_logo'));
        ?>
    </div>
    <div class="field-wrap-main">
        <?php
            _e($formFields->formLabel('napNumber'));
            _e($formFields->inputField($cf_nap_number, 'cf_nap_number', '', 'text','','',false ));
        ?>
    </div>
    <div class="field-wrap-main">
        <?php
            _e($formFields->formLabel('Google Reviews Shortcode'));
            _e($formFields->inputField($cf_google_review_shortcode, 'cf_google_review_shortcode', '', 'text','','',false ));
        ?>
    </div>
    <div class="field-wrap-main">
        <?php
            _e($formFields->formLabel('About Us / Your Local Team Page'));
            _e($formFields->selectField($your_local_team, 'your_local_team', '', 'select2', array(), false, 'Select a option', 'page'));
        ?>
    </div>
    <div class="field-wrap-main">
        <?php
            _e($formFields->formLabel('Local Testimonials Page'));
            _e($formFields->selectField($local_testimonials, 'local_testimonials', '', 'select2', array(), false, 'Select a option', 'page'));
        ?>
    </div>
    <h3>Side Ribbon Fields</h3>
    <div class="add_row_main">
        <div class="add_row hide">
            <div class="field-wrap-main">
                <?php
                    _e($formFields->formLabel('Ribbon Label Name'));
                    _e($formFields->inputField('', 'side_ribbon[label_name][]', '', 'text','','',false ));
                ?>
            </div>
            <div class="field-wrap-main">
                <?php
                    _e($formFields->formLabel('Ribbon Icon'));
                    _e($formFields->selectImage('', 'medium', 'side_ribbon[ribbon_icon][]'));
                ?>
            </div>
            <div class="field-wrap-main">
                <?php
                    _e($formFields->formLabel('Ribbon Link'));
                    _e($formFields->inputField('', 'side_ribbon[ribbon_link][]', '', 'url','','',false ));
                ?>
            </div>
        </div>
        <?php if(!empty($side_ribbons)):
            foreach($side_ribbons as $side_ribbon):?>
                <div class="add_row">
                    <div class="field-wrap-main">
                        <?php
                            _e($formFields->formLabel('Ribbon Label Name'));
                            _e($formFields->inputField($side_ribbon[0], 'side_ribbon[label_name][]', '', 'text','','',false ));
                        ?>
                    </div>
                    <div class="field-wrap-main">
                        <?php
                            _e($formFields->formLabel('Ribbon Icon'));
                            _e($formFields->selectImage($side_ribbon[1], 'medium', 'side_ribbon[ribbon_icon][]'));
                        ?>
                    </div>
                    <div class="field-wrap-main">
                        <?php
                            _e($formFields->formLabel('Ribbon Link'));
                            _e($formFields->inputField($side_ribbon[2], 'side_ribbon[ribbon_link][]', '', 'url','','',false ));
                        ?>
                    </div>
                </div>
        <?php  endforeach; endif;?>

        <div class="button_right">
            <span class="button add_row_btn">Add Row</span>
            <span class="button remove_row_btn hide">Remove Row</span>
        </div>
    </div>




    <h3>Housecall Pro Details</h3>
    <div class="field-wrap-main">
        <?php
            _e($formFields->formLabel('Book Now Bar Text'));
            _e($formFields->inputField($cf_booknow_text, 'cf_booknow_text', '', 'text','','',false ));
        ?>
    </div>
    <div class="field-wrap-main">
        <?php
            _e($formFields->formLabel('Book Now Button Link'));
            _e($formFields->inputField($cf_booknow_link, 'cf_booknow_link', '', 'url','','',false ));
        ?>
    </div>

    <h3>Reviews</h3>
    <div class="add_row_main">
        <div class="add_row hide">
            <div class="field-wrap-main">
                <?php
                    _e($formFields->formLabel('Name'));
                    _e($formFields->inputField('', 'review[reviewer_name][]', '', 'text','','',false ));
                ?>
            </div>
            <div class="field-wrap-main">
                <?php
                    _e($formFields->formLabel('Reviews'));
                    _e($formFields->inputField('', 'review[reviewer_review][]', '', 'text','','',false ));
                ?>
            </div>
        </div>
        <?php if(!empty($reviews)):
            foreach($reviews as $review):?>
                <div class="add_row">
                    <div class="field-wrap-main">
                        <?php
                            _e($formFields->formLabel('Name'));
                            _e($formFields->inputField($review[0], 'review[reviewer_name][]', '', 'text','','',false ));
                        ?>
                    </div>
                    <div class="field-wrap-main">
                        <?php
                            _e($formFields->formLabel('Reviews'));
                            _e($formFields->inputField($review[1], 'review[reviewer_review][]', '', 'text','','',false ));
                        ?>
                    </div>
                </div>
        <?php  endforeach; endif;?>
        <div class="button_right">
            <span class="button add_row_btn">Add Row</span>
            <span class="button remove_row_btn hide">Remove Row</span>
        </div>
    </div>

    <h3>City Pages</h3>
    <div class="add_row_main">
        <div class="add_row hide">
            <div class="field-wrap-main">
                <?php
                    _e($formFields->formLabel('City Page'));
                    _e($formFields->selectField('', 'city_page[]', '', '', array(), false, 'Select a option', 'page'));
                ?>
            </div>
        </div>
        
        <?php if(!empty($city_pages)):
            foreach($city_pages as $city_page):?>
                <div class="add_row">
                    <div class="field-wrap-main">
                        <?php
                            _e($formFields->formLabel('City Page'));
                            _e($formFields->selectField($city_page, 'city_pages[]', '', 'select2', array(), false, 'Select a option', 'page'));
                        ?>
                    </div>
                </div>
        <?php  endforeach; endif;?>
        <div class="button_right">
            <span class="button add_row_btn">Add Row</span>
            <span class="button remove_row_btn hide">Remove Row</span>
        </div>
    </div>
<?php if(!empty($pluginSettingOptions['services_menu_items'])):?>
    <h3>Services</h3>
    <div class="add_row_main services_items">
        <div class="add_row">
            <div class="field-wrap-main">#</div>
            <div class="field-wrap-main"> <?php _e($formFields->formLabel('Active'));?> </div>
            <div class="field-wrap-main"> <?php _e($formFields->formLabel('Menu Id'));?> </div>
            <div class="field-wrap-main"> <?php _e($formFields->formLabel('Menu Title'));?> </div>
            <div class="field-wrap-main"> <?php _e($formFields->formLabel('Custom Link'));?> </div>
        </div>
        <?php 
            // echo '<pre>';
            // print_r($services_menu_data);
            // echo '</pre>';
        ?>
    <?php $servicesParentMenuIds = $pluginSettingOptions['services_menu_items']; 
            foreach($servicesParentMenuIds as $servicesParentMenuId):
                $parentMenuArr = $services_menu_data[$servicesParentMenuId][$servicesParentMenuId];
                $parentIsChecked = (in_array('on', $parentMenuArr) ? 'yes' : 'no' );
                $i = 1;?>
                <?php foreach (wp_get_nav_menu_items($pluginSettingOptions['main_menu']) as $r):
                    if($r->ID == $servicesParentMenuId):?>
                        <h4><?php _e($r->title) ?></h4>
                        <h5><?php _e('Parent Menu Item') ?></h5>
                        <div class="add_row">
                            <div class="field-wrap-main">
                                <?php _e($i); ?>
                            </div>
                            <div class="field-wrap-main">
                                <?php
                                    _e($formFields->formLabel(''));
                                    _e($formFields->inputField($parentIsChecked , 'services_menu['.$servicesParentMenuId.']['.$r->ID.'][]', '', 'checkbox','','',false ));
                                ?>
                            </div>
                            <div class="field-wrap-main">
                                <?php
                                    _e($formFields->formLabel(''));
                                    _e($formFields->inputField($r->ID, 'services_menu['.$servicesParentMenuId.']['.$r->ID.'][]', '', 'text','','',true ));
                                ?>
                            </div>
                            <div class="field-wrap-main">
                                <?php
                                    _e($formFields->formLabel(''));
                                    _e($formFields->inputField($r->title, 'services_menu['.$servicesParentMenuId.']['.$r->ID.'][]', '', 'text','','',true));
                                ?>
                            </div>
                            <div class="field-wrap-main">
                                <?php
                                    _e($formFields->formLabel(''));
                                    _e($formFields->inputField('', 'services_menu['.$servicesParentMenuId.']['.$r->ID.'][]', '', 'text','','',false ));
                                ?>
                            </div>
                            <div class="field-wrap-main">
                                <?php
                                    _e($formFields->formLabel(''));
                                    _e($formFields->inputField('parent', 'services_menu['.$servicesParentMenuId.']['.$r->ID.'][]', '', 'hidden','','',false ));
                                ?>
                            </div>
                        </div>
                        <h5><?php _e('Child Menu Items') ?></h5>
                        <p><b><?php _e('Note:') ?></b> <?php _e('If you unselect the parent menu item, then the child menu items will be unselect as well.') ?></p>
                        <?php endif; ?>
                        
                        <?php if ($r->menu_item_parent == $servicesParentMenuId):
                        $i++;
                        $childMenuArr = $services_menu_data[$servicesParentMenuId][$r->ID];
                        $childIsChecked = (in_array('on',$childMenuArr) ? ($parentIsChecked == 'yes' ? 'yes' : 'no' ) : 'no' );
                        ?>
                        <div class="add_row">
                            <div class="field-wrap-main">
                                <?php _e($i); ?>
                            </div>
                            <div class="field-wrap-main">
                                <?php
                                    _e($formFields->formLabel(''));
                                    _e($formFields->inputField($childIsChecked, 'services_menu['.$servicesParentMenuId.']['.$r->ID.'][]', '', 'checkbox','','',false ));
                                ?>
                            </div>
                            <div class="field-wrap-main">
                                <?php
                                    _e($formFields->formLabel(''));
                                    _e($formFields->inputField($r->ID, 'services_menu['.$servicesParentMenuId.']['.$r->ID.'][]', '', 'text','','',true ));
                                ?>
                            </div>
                            <div class="field-wrap-main">
                                <?php
                                    _e($formFields->formLabel(''));
                                    _e($formFields->inputField($r->title, 'services_menu['.$servicesParentMenuId.']['.$r->ID.'][]', '', 'text','','',true));
                                ?>
                            </div>
                            <div class="field-wrap-main">
                                <?php
                                    _e($formFields->formLabel(''));
                                    _e($formFields->inputField('', 'services_menu['.$servicesParentMenuId.']['.$r->ID.'][]', '', 'text','','',false ));
                                ?>
                            </div>
                            <div class="field-wrap-main">
                                <?php
                                    _e($formFields->formLabel(''));
                                    _e($formFields->inputField('child', 'services_menu['.$servicesParentMenuId.']['.$r->ID.'][]', '', 'hidden','','',false ));
                                ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
        <?php  endforeach; endif;?>
    </div>
