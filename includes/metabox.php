<?php

function wpstudio__tabs_metaboxes_tabs_input($post) {

  global $post;

  wp_nonce_field( 'wpstudio__tabs_metaboxes_tabs_input', 'wpstudio__tabs_metaboxes_tabs_input_nonce' ); ?>

  <div id="wp-simple-tabs-nav">
    <h2 class="nav-tab-wrapper current">
      <a class="nav-tab nav-tab-active" href="javascript:;">Manage Tabs</a>
      <a class="nav-tab" href="javascript:;">Tab Settings</a>
    </h2>
      
    <?php include_once( 'manage-page.php' ); include_once( 'settings-page.php' ); include_once( 'custom-css.php' ); ?>

  </div> <!-- #wp-simple-tabs-nav -->
  <?php
}

function wpstudio__tabs_metaboxes_tabs_save($post_id) {

  // Check if our nonce is set.
  if (!isset($_POST['wpstudio__tabs_metaboxes_tabs_input_nonce']))
    return $post_id;

  // Verify that the nonce is valid.
  if (!wp_verify_nonce($_POST['wpstudio__tabs_metaboxes_tabs_input_nonce'], 'wpstudio__tabs_metaboxes_tabs_input'))
    return $post_id;

  // If this is an autosave, our form has not been submitted, so we don't want to do anything.
  if (defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE) 
    return $post_id;

  $meta_keys = array(
    'wpst_tabs_order' => '',
    'tabs_section_bg' => '',
    'tabs_section_padding_top' => '',
    'tabs_section_padding_bottom' => '',
    'tab_font_color' => '',
    'tab_current_font_color' => '',
    'tab_bg_color' => '',
    'tab_current_bg_color' => '',
    'tab_border_color' => '',
    'tab_current_border_color' => '',
    'tabs_custom_css' => '',
    'tab_show_border' => '',
    'tab_show_border_active' => ''
  );

  // Update the meta field in the database.
  foreach($meta_keys as $key => $value):
    if (!empty($_POST[$key])):
      update_post_meta($post_id, $key, sanitize_text_field($_POST[$key]));
    else: 
      update_post_meta($post_id, $key, $value);
    endif;
  endforeach;

  $tabs_order = get_post_meta($post_id, 'wpst_tabs_order', true);
  $tabs_order_array = explode(',', $tabs_order);
  $array = array();
  $i = 0;

  foreach ($tabs_order_array as $ordered_tab):

    $value = uniqid('tab-', false);

    if (!in_array($value, $array)):
      $array[] = $value;
    endif; 

    $id = !empty($ordered_tab) ? $ordered_tab : 'tab-1';

    update_post_meta($post_id, 'wpst_tab_id_'.$id, sanitize_text_field( $_POST['wpst_tab_id_'.$id]));
    update_post_meta($post_id, 'wpst_tab_label_'.$id, sanitize_text_field( $_POST['wpst_tab_label_'.$id]));
    update_post_meta($post_id, 'wpst_tab_content_'.$id, sanitize_text_field( $_POST['wpst_tab_content_'.$id]));
    update_post_meta($post_id, 'wpst_tab_active', sanitize_text_field( $_POST['wpst_tab_active']));

  endforeach;

}
add_action( 'save_post', 'wpstudio__tabs_metaboxes_tabs_save' );











