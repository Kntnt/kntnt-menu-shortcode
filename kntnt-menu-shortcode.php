<?php

/**
 * Plugin main file.
 *
 * @wordpress-plugin
 * Plugin Name:       Kntnt Menu Shortcode
 * Plugin URI:        https://www.kntnt.com/
 * Description:       Provides the shortcode [menu …] where … is a menu slug or id that should be outputted. Optional arguments includes most of those accepted by wp_nav_menu().
 * Version:           1.0.0
 * Author:            Thomas Barregren
 * Author URI:        https://www.kntnt.com/
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       kntnt-menu-shortcode
 * Domain Path:       /languages
 */
 
namespace Kntnt\Menu_Shortcode;

defined( 'WPINC' ) && new Plugin();

class Plugin {

  // Se wp_nav_menu() for explanation.
  private static $defaults = [
    'menu' => '',
    'depth' => 0,
    'container' => 'div',
    'container_class' => '',
    'container_id' => '',
    'menu_class' => 'menu',
    'menu_id' => '',
    'before' => '',
    'after' => '',
    'link_before' => '',
    'link_after' => '',
    'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
    'item_spacing' => 'preserve',
  ];
      
  public function __construct() {
    add_shortcode( 'menu', [ $this, 'menu_shortcode' ] );
  }
  
  public function menu_shortcode( $atts ) {
    $atts = $this->shortcode_atts( self::$defaults, $atts );
    return wp_nav_menu( $atts );
  }
  
  // A more forgiving version of WP's shortcode_atts().
  private function shortcode_atts( $pairs, $atts, $shortcode = '' ) {

    $atts = (array) $atts;
    $out = [];
    $pos = 0;
    while( $name = key($pairs) ) {
      $default = array_shift( $pairs );
      if ( array_key_exists($name, $atts ) ) {
        $out[$name] = $atts[$name];
      }
      elseif ( array_key_exists( $pos, $atts ) ) {
        $out[$name] = $atts[$pos];
        ++$pos;
      }
      else {
        $out[$name] = $default;
      }
    }

    if ( $shortcode ) {
      $out = apply_filters( "shortcode_atts_{$shortcode}", $out, $pairs, $atts, $shortcode );
    }
    
    return $out;

  }

}
