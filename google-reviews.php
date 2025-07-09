<?php
/**
 * Plugin Name: Google Reviews
 * Description: Exibe depoimentos em carrossel com controle via Elementor.
 * Version: 1.2
 * Author: Alan Borim - Apoio19
 * Author URI: https://apoio19.com.br
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function gre_register_elementor_widget( $widgets_manager ) {
    require_once(__DIR__ . '/widget-google-reviews.php');
    $widgets_manager->register( new \GRE_Google_Reviews_Widget() );
}
add_action('elementor/widgets/register', 'gre_register_elementor_widget');

function gre_enqueue_assets() {
    wp_enqueue_style('gre-style', plugin_dir_url(__FILE__) . 'style.css');
    wp_enqueue_script('gre-script', plugin_dir_url(__FILE__) . 'script.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'gre_enqueue_assets');
?>
