<?php
/**
 * Plugin Name: Coaching Centre Content Manager
 * Plugin URI:  https://coachingcentre.com
 * Description: Custom content manager for Coaching Centre. Manages Courses, Teachers, Testimonials, FAQs, and Meta Box fields.
 * Version:     1.0.0
 * Author:      Noman Al Sayed
 * Author URI:  https://coachingcentre.com
 * License:     GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: coaching-centre-manager
 * Domain Path: /languages
 * Requires at least: 6.0
 * Requires PHP: 7.4
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'CC_MANAGER_VERSION', '1.0.0' );
define( 'CC_MANAGER_DIR', plugin_dir_path( __FILE__ ) );
define( 'CC_MANAGER_URL', plugin_dir_url( __FILE__ ) );
// Compatibility aliases
if ( ! defined( 'XYZ_SCHOOL_MANAGER_DIR' ) ) {
    define( 'XYZ_SCHOOL_MANAGER_DIR', CC_MANAGER_DIR );
}
if ( ! defined( 'XYZ_SCHOOL_MANAGER_URL' ) ) {
    define( 'XYZ_SCHOOL_MANAGER_URL', CC_MANAGER_URL );
}


class CC_Manager {

    private static $instance = null;

    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->load_dependencies();
        $this->init();
    }

    private function load_dependencies() {
        require_once CC_MANAGER_DIR . 'includes/helpers.php';
        require_once CC_MANAGER_DIR . 'includes/class-cpts.php';
        require_once CC_MANAGER_DIR . 'includes/class-meta-boxes.php';
        require_once CC_MANAGER_DIR . 'includes/class-sample-data.php';
    }

    private function init() {
        new CC_Manager_CPTs();
        new XYZ_School_Meta_Boxes();

        register_activation_hook( __FILE__, [ $this, 'activate' ] );
    }

    public function activate() {
        $cpts = new CC_Manager_CPTs();
        $cpts->register_post_types();
        $cpts->register_taxonomies();
        $cpts->seed_default_terms();
        flush_rewrite_rules();

        CC_Manager_Sample_Data::seed();
    }
}

class_alias( 'CC_Manager', 'XYZ_School_Manager' );

function cc_manager() {
    return CC_Manager::instance();
}

function xyz_school_manager() {
    return cc_manager();
}

cc_manager();

