<?php

/**
 * Company Franchise
 *
 * @package     Company Franchise
 * @author      Thrive Agency
 * @copyright   2022 Thrive Agency
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: Company Franchise
 * Plugin URI:
 * Description: Change Content According to the Franchise
 * Version:     1.0
 * Author:      Thrive Agency
 * Author URI:  
 * Text Domain: compnay-franchise
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 */

// Block direct access to file
defined( 'ABSPATH' ) or die( 'Not Authorized!' );
// Plugin Defines
define( "CF_FILE", __FILE__ );
define( "CF_DIRECTORY", dirname(__FILE__) );
define( "ADMIN_DIRECTORY", CF_DIRECTORY. '/include/admin' );
define( "PUBLIC_DIRECTORY", CF_DIRECTORY. '/include/public' );
define( "CF_TEXT_DOMAIN", dirname(__FILE__) );
define( "CF_DIRECTORY_BASENAME", plugin_basename( CF_FILE ) );
define( "CF_DIRECTORY_PATH", plugin_dir_path( CF_FILE ) );
// var_dump(ADMIN_DIRECTORY);
define( "CF_DIRECTORY_URL", plugins_url( null, CF_FILE ) );

// Require the main class file
require_once( CF_DIRECTORY . '/include/main-class.php' );
