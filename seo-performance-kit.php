<?php
/**
 * Plugin Name: CodePlusDev SEO and Performance Kit
 * Plugin URI: https://codecanyon.net/user/codeplusdev
 * Description: A WordPress plugin to improve SEO and performance by automatically adding 'display=swap' to Google Fonts and enabling 'link rel="preload" as="font"'.
 * Version: 1.0.0
 * Author: CodePlusDev
 * Author URI: https://codeplus.dev
 * Text Domain: seo-performance-kit
 * License: GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Requires PHP: 5.6.x or later
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Add 'display=swap' to Google Fonts
add_action('wp_head', 'codeplusdev_add_display_swap', 99);
function codeplusdev_add_display_swap() {
    ob_start(function($buffer) {
        $buffer = preg_replace_callback('/href="https:\/\/fonts\.googleapis\.com\/css(.*?)"/', function($matches) {
            if (strpos($matches[1], 'display=swap') === false) {
                return 'rel="preload" as="font" href="https://fonts.googleapis.com/css' . $matches[1] . '&display=swap"';
            }
            return $matches[0];
        }, $buffer);
        return $buffer;
    });
}

// Add 'link rel="preload" as="font"'
add_action('wp_head', 'codeplusdev_preload_fonts', 99);
function codeplusdev_preload_fonts() {
    ob_start(function($buffer) {
        $buffer = preg_replace('/<link (.*?)href="(.*?\.woff2?)"(.*?)>/', '<link rel="preload" as="font" $1 href="$2" $3>', $buffer);
        return $buffer;
    });
}
