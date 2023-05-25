<?php
class FormFields 
{
    /** Html Form Label */
    public function formLabel($title){
        $label = '<div class="field-label"><label>'.$title.'</label></div>';
        return $label;
    }

    /** Html Form Input field */
    public function inputField($value, $name, $placeholder = '', $type, $id, $class, $readOnly = false){
        if($type == 'checkbox'){
            $value = ($value == 'yes' ? 'checked' : '');
        }
        if($type != 'checkbox'){
            $value = 'value="'.$value.'"';
        }
        $input .= '<div class="field-wrap">';
            $input .= '<input id="'.$id.'" class="'.$class.'" type="'.$type.'" '.$value.' name="'.$name.'" placeholder="'.$placeholder.'" '.($readOnly? 'readonly' : '').'/>';
        $input .= '</div>';
        return $input;
    }

    /** Html Form Select field */
    public function selectField($selectedValue, $name, $id, $class, $options = array(), $multiple = false, $firstOptiontitle = 'Select Options', $type = 'normal', $parent = false){
        if ($type == 'menu_items'){
            global $pluginSettingOptions;
            $menuItems = wp_get_nav_menu_items($pluginSettingOptions['main_menu']);
            $menuItemsArray = array();
            foreach ($menuItems as $menuItem) {
                if($parent){
                    if($menuItem->menu_item_parent != '0')
                        continue;
                }
                $menuItemsArray[] = array(
                        'value' => $menuItem->ID,
                        'title' => $menuItem->title,
                    );
            }
            $options = $menuItemsArray;
        }
        if ($type == 'menu'){
            $menus = wp_get_nav_menus();
            $menusArray = array();
            foreach ($menus as $menu) {
            $menusArray[] = array(
                    'value' => $menu->term_id,
                    'title' => $menu->name,
                );
            }
            $options = $menusArray;
        }
        if($type == 'page'){
            $pages = get_pages();
            $pagesArray = array();
            foreach ($pages as $page) {
            $pagesArray[] = array(
                    'value' => $page->ID,
                    'title' => $page->post_title,
                );
            }
            $options = $pagesArray;
        }
        $select .= '<div class="field-wrap">';
        $select .= '<select id="'.$id.'" class="'.$class.'" '.($multiple ? 'multiple' : '').' name="'.$name.'">';
        $select .= '<option value="">'.$firstOptiontitle.'</option>';
        foreach ($options as $option) {
                    $select .= '<option value="'.$option['value'].'" '. ($option['value'] == $selectedValue ? 'selected' : '' ).' >'.$option['title'].'</option>';
                }
                $select .= '</select>';
                $select .= '</div>';
        return $select;
    }
    public function selectImage($imgId, $size, $name){
        if( $image = wp_get_attachment_image_src( $imgId, $size) ) {

            $html.= '<a href="#" class="misha-upl"><img src="' . $image[0] . '" style="width:200px;"/></a>';
            $html.= '<a href="#" class="misha-rmv" style="margin-left:10px">Remove image</a>';
            $html.= '<input type="hidden" name="'.$name.'" value="' . $imgId . '">';
        
        } else {
        
            $html.= '<a href="#" class="misha-upl">Upload image</a>';
            $html.= '<a href="#" class="misha-rmv" style="display:none; margin-left:10px">Remove image</a>';
            $html.= '<input type="hidden" name="'.$name.'" value="">';
        
        } 
        return $html;
    }
}
    
?>