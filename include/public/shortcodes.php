<?php 
/**
 * Short Code for the items view on the website
 */

function franchiseLogoFunc(){
    if(getDefaultLogo())
        $logo = getDefaultLogo();
    else
        $logo = 'No logo found';
    return $logo;
}
add_shortcode('franchiseLogo', 'franchiseLogoFunc');

function headerContactFunc(){
    global $pluginSettingOptions;
    $buttonText = $pluginSettingOptions['header_button_text'];
    $buttonLink = $pluginSettingOptions['header_button_link'];
    $button = '<div id="headerButton"><a href="'.get_the_permalink($buttonLink).'" >'.$buttonText.'</a></div>';
    return $button;
}
add_shortcode('headerContact', 'headerContactFunc');


/**
 * Ribbons
 * Facebook
 * if home (conatct page) elseif (local team page) else nothing
 * House call pro
 * 
 * blog
 * 
 */
function siteRibbonFunc(){
    global $pluginSettingOptions;
    $ribbonArr = [];
    for ($i=1; $i < 4 ; $i++) { 
        $ribbonArr[]  = array(
            'text' => $pluginSettingOptions['default_ribbon_text_'.$i.''],
            'icon' => $pluginSettingOptions['default_ribbon_icon_'.$i.''],
            'link' => $pluginSettingOptions['default_ribbon_link_'.$i.'']
        );
    }
    $ribbon .= '<div id="siteRibbon">';
    $ribbon .= '<ul>';
        foreach ($ribbonArr as $ribbonArrKey) {
            if(empty($ribbonArrKey['icon']))
                continue;
            $ribbonIcon =  wp_get_attachment_image_src($ribbonArrKey['icon']);
            $ribbon .='<li><a href="'.$ribbonArrKey['link'].'" target="_blank"><img src="'.$ribbonIcon[0].'" alt="'.$ribbonArrKey['text'].'" /></a></li>';
        }
    $ribbon .= '</ul>';
    $ribbon .= '<div>';
    return $ribbon;
}
add_shortcode('siteRibbon', 'siteRibbonFunc');
?>