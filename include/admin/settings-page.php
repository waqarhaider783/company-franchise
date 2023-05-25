<h2>Franchise Plugin Settings</h2>
<form action="options.php" method="post" class="franchise_plugin_settings_form">
    <?php 
    global $formFields;
    global $pluginSettingOptions;
    settings_fields( 'franchise_plugin_options' );
    do_settings_sections( 'franchise_plugin' ); ?>
    <table class="form-table">
        <tbody class="add_row_main">
            <tr>
                <th scope="row" style="padding:0"><h3><?php _e($formFields->formLabel('Select Services Menu')); ?></h3></th>
            </tr>
            <tr>
                <td>
                    <div class="add_row hide">
                        <table class="">
                            <tbody>
                                <tr class="field-wrap-main">
                                    <th><?php _e($formFields->formLabel('Select Service')); ?></th>
                                    <td>
                                        <?php _e($formFields->selectField('', 'franchise_plugin_options[services_menu_items][]', '', '', array(), false, 'Select a option', 'menu_items', true));?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <?php 
                    if(!empty($pluginSettingOptions['services_menu_items'])):
                        foreach($pluginSettingOptions['services_menu_items'] as $services_menu_item):
                            if(!empty($services_menu_item)):?>
                                <div class="add_row">
                                    <table class="">
                                        <tbody>
                                            <tr class="field-wrap-main">
                                                <th><?php _e($formFields->formLabel('Select Service')); ?></th>
                                                <td>
                                                    <?php _e($formFields->selectField($services_menu_item, 'franchise_plugin_options[services_menu_items][]', '', 'select2', array(), false, 'Select a option', 'menu_items', true));?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                    <?php endif; endforeach; endif;?>
                </td>
            </tr>
            <tr>
                <td class="button_left" style="padding:0px">
                    <span class="button add_row_btn">Add Row</span>
                    <span class="button remove_row_btn hide">Remove Row</span>
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    <input name="submit" class="button button-primary" type="submit" value="<?php esc_attr_e( 'Save' ); ?>" />
</form>