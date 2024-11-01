<?php

/**
 * Plugin Name:       WP Studio Tabs
 * Plugin URI:        http://wp-studio.net
 * Description:       WP Studio Tabs allows you to create/manage simple animated tabs for your Wordpress website. 
 * Version:           1.0.9
 * Requires at least: 2.9
 * Author:            WP Studio
 * Author URI:        https://wp-studio.net/
 * Text Domain:       wpst__tabs
 **/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ):
	exit;
endif;

include('includes/metabox.php');
//include('includes/mobile-detect.php');

class WPStudio__Tabs {

  public function __construct() {

    $plugin_data = get_file_data(__FILE__, array('Version' => 'Version'), false);
    define('WPSTUDIO_PLUGIN_VER', $plugin_data['Version']);

    register_activation_hook( __FILE__, array(&$this,'wpstudio__tabs_activate'));
    register_deactivation_hook( __FILE__, array(&$this,'wpstudio__tabs_deactivate'));

    add_action( 'init', array(&$this, 'wpstudio__tabs_register_tabs_cpt'));
    add_action( 'wp_enqueue_scripts', array(&$this, 'load_jquery'));
    add_action( 'wp_enqueue_scripts', array(&$this, 'wpstudio__tabs_enqueues'));
    add_action( 'admin_enqueue_scripts', array(&$this, 'wpstudio__tabs_admin_enqueues'));
    add_action( 'wp_print_styles', array(&$this, 'wpstudio__tabs_load_css'));
    add_filter( 'manage_posts_columns' , array(&$this, 'wpstudio__tabs_add_shortcode_column'));
    add_action( 'manage_posts_custom_column' , array(&$this, 'wpstudio__tabs_posts_display_shortcode'), 10, 2 );
    add_action( 'add_meta_boxes', array(&$this, 'wpstudio__tabs_settings_metabox'));
    add_filter( 'widget_text','do_shortcode');
    
    if (!is_admin()):
      add_shortcode('tabs', array(&$this, 'wpstudio__tabs_create_shortcode'));
    endif;
  } //construct

  public function wpstudio__tabs_activate() {} //wpst_deactivate

  public function wpstudio__tabs_deactivate() {} //wpst_deactivate

  public function load_jquery() {
    if (!wp_script_is('jquery','enqueued')) {
      wp_enqueue_script( 'jquery' );
    }
  }

  public function wpstudio__tabs_enqueues() {
    wp_enqueue_style('styles-tabby', plugins_url('css/styles-tabby.css',__FILE__), '', PLUGIN_VER, '');
    wp_enqueue_style('styles', plugins_url('css/styles.css',__FILE__), '', PLUGIN_VER, '');
    wp_enqueue_script('scripts-tabby', plugins_url('js/scripts-tabby.js',__FILE__), array('jquery'), PLUGINS_VER, false);
    //wp_enqueue_script('scripts-polyfills', plugins_url('js/scripts-polyfills.js',__FILE__), array('jquery'), PLUGINS_VER, false);
    wp_enqueue_script('scripts', plugins_url('js/scripts.js',__FILE__), array('jquery'), PLUGIN_VER, true);
  }

  public function wpstudio__tabs_admin_enqueues() {
    wp_enqueue_style('dashicons');
    wp_enqueue_style( 'styles-admin', plugins_url('css/styles-admin.css',__FILE__), '', PLUGIN_VER, '');
    wp_enqueue_script('jquery-ui-sortable');
    wp_enqueue_script('wp-color-picker');
    wp_enqueue_script('scripts-admin', plugins_url('js/scripts-admin.js',__FILE__), array('jquery'), PLUGIN_VER, false);
  }

  public function wpstudio__tabs_load_css() {
    include( plugin_dir_path( __FILE__ ) . '/css/style.php');
  }

  public function wpstudio__tabs_register_tabs_cpt() {
    $labels = array (
      'name' => 'Tabsets',
      'add_new' => 'Add New',
      'add_new_item' => 'Add Tabs',
      'singular_name' => 'Add Tabs',
      'edit_item' => 'Edit Tabset',
      'new_item' => 'New Tabset',
      'all_items' => 'Manage Tabs',
      'view_item' => 'View Tabs',
      'search_items' => 'Search Tabsets',
      'not_found' => 'No tabsets found',
      'not_found_in_trash' => 'No tabsets found in the Trash',
      'menu_name' => 'Add Tabs'
    );

    register_post_type(
      'wpstudio__tabs', 
      array(
        'labels' => $labels,
        'show_ui' => true, 
        'show_in_menu' => 'edit.php?post_type=page',
        'supports' => array('title')
      )
    );
  }

  public function wpstudio__tabs_add_shortcode_column( $columns ) {
    return array_merge( $columns, 
      array( 'shortcode' => __( 'Shortcode', 'wpstudio__tabs' ) ) );
  }

  public function wpstudio__tabs_posts_display_shortcode( $column, $post_id ) {
    if ($column == 'shortcode'): ?>
      <span style="margin:0; font-family: monospace"><?= '[tabs id=&quot;'.$post_id.'&quot;]'; ?></span><br/>
      <span style="margin:0; font-family: monospace"><?= '&lt;?php echo do_shortcode(\'[tabs id=&quot;'.$post_id.'&quot;]\') ?>'; ?></span>
      <?php		
    endif;
  }

  public function wpstudio__tabs_settings_metabox() {
    $screens = array( 'wpstudio__tabs' );
    foreach ( $screens as $screen ):
      add_meta_box('wpstudio__tabs_metabox',__( 'WP Studio Tabs','wpstudio__tabs' ),'wpstudio__tabs_metaboxes_tabs_input', $screen);
    endforeach;
  }

  public function wpstudio__tabs_create_shortcode($atts) {

    $atts = shortcode_atts(
      array (
        'id' => 1,
      ), $atts);

      global $post;
      
      $post_id = $atts['id'];
      $tabs_section_bg = get_post_meta( $post_id, 'tabs_section_bg', true );
      $tab_font_color = get_post_meta( $post_id, 'tab_font_color', true ); 
      $tab_active = get_post_meta( $post_id, 'wpst_tab_active', true);

      $post_status = get_post_status($post_id);
      
      ob_start(); 
      
      if ($post_status !== 'trash'): ?>

      <section id="wpst-tabset-<?= $post_id; ?>"  class="tabs-container">
        <div class="tabs">
          <ul class="tabs-menu">
          <?php 
          
            $tabs_order = get_post_meta($post_id, 'wpst_tabs_order', true);
            $tabs_order_array = explode(',', $tabs_order);
            $tabs_idx = 0;
            $active_idx = array();

            foreach ($tabs_order_array as $ordered_tab):
              $active_idx = ($tab_active == 'wpst_tab_active_'.$ordered_tab ? $tabs_idx : 'undefined');
              $id = !empty($ordered_tab) ? $ordered_tab : 'tab-1'; 
              $wpst_tab_label = get_post_meta($post_id, 'wpst_tab_label_'.$id, true);
              $wpst_tab_content = get_post_meta($post_id, 'wpst_tab_content_'.$id, true);
              $html  = '';
              $html .= '<li><a href="#'.$id.'"'.($active_idx !== 'undefined' ? ' data-tabby-default' : '').'>'.$wpst_tab_label.'</a></li>';
              $tabs_idx++;
              echo $html; 
            endforeach; ?>
          </ul>


          <?php 
      
          $content_idx = 1;

          foreach ($tabs_order_array as $ordered_tab): 
            $id = !empty($ordered_tab) ? $ordered_tab : 'tab-1'; 
            $wpst_tab_label = get_post_meta($post_id, 'wpst_tab_label_'.$id, true);
            $wpst_tab_content = get_post_meta($post_id, 'wpst_tab_content_'.$id, true);

            $tml  = '';
            $tml .= '<div id="'.$id.'">';
            $tml .= '<p>'.esc_attr($wpst_tab_content).'</p>';
            
            $content_idx++; 
            
            $tml .= '</div><!-- .content -->';

            //echo $tml; 
          endforeach; ?>

          <ul class="tabs-content">

          <?php 

            $tabs_order = get_post_meta($post_id, 'wpst_tabs_order', true);
            $tabs_order_array = explode(',', $tabs_order);
            $tabs_idx = 0;
            $active_idx = array();

            foreach ($tabs_order_array as $ordered_tab):
              $active_idx = ($tab_active == 'wpst_tab_active_'.$ordered_tab ? $tabs_idx : 'undefined');
              $id = !empty($ordered_tab) ? $ordered_tab : 'tab-1'; 
              $wpst_tab_label = get_post_meta($post_id, 'wpst_tab_label_'.$id, true);
              $wpst_tab_content = get_post_meta($post_id, 'wpst_tab_content_'.$id, true);
              $html  = '';
              $html .= '<li>';
              $html .= '<a role="tab-vertical" href="#'.$id.'"'.($active_idx !== 'undefined' ? ' data-tabby-default' : '').'>'.$wpst_tab_label.'</a>';
              $html .= '<div id="'.$id.'">';
              $html .= '<p>'.esc_attr($wpst_tab_content).'</p>';
              $html .= '</div>';
              $html .= '</li>';
              $tabs_idx++;
              echo $html; 
            endforeach; ?>

          </ul> <!-- data-tabs -->
          
        </div><!-- #tabs -->
     
        
         
        
      </section>

      <?php endif; ?>

      <?php $output = ob_get_clean(); return $output; 
  }
} //class

new WPStudio__Tabs(); ?>