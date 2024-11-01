<?php

  global $post;

  $tag = 'tabs';

  // Return if there is no shortcode in post content
  if (!has_shortcode($post->post_content, $tag)) {
      return false;
  }

  // Get all shortcodes in the post content
  preg_match_all('/' . get_shortcode_regex() . '/s', $post->post_content, $matches, PREG_SET_ORDER);

  if (empty($matches)) {
      return false;
  }

  // Loop through shortcodes, parse shortcode attributes and get post ID
  foreach ($matches as $shortcode) {
    if ($tag === $shortcode[2]) {
      $atts = shortcode_parse_atts($shortcode[3]);
      $ids[] = $atts['id'];
    } elseif (!empty($shortcode[5]) && has_shortcode($shortcode[5], $tag)) {
      // nested shortcodes
      $shortcode = $this->parse_shortcode_id($shortcode[5]);
    }
  }
  // Return all the post IDs
  if (isset($ids)) {
    //return $ids;
  }

  $html  = '';
  $html .= '<style type="text/css">';

  if (isset($ids)):

    foreach ($ids as $id):

      $tabs_section_bg = get_post_meta ($id, 'tabs_section_bg', true);
      $tabs_section_padding_top = get_post_meta ($id, 'tabs_section_padding_top', true);
      $tabs_section_padding_bottom = get_post_meta ($id, 'tabs_section_padding_bottom', true);
      $tab_font_color = get_post_meta ($id, 'tab_font_color', true);
      $tab_bg_color = get_post_meta ($id, 'tab_bg_color', true);
      $tab_border_color = get_post_meta( $id, 'tab_border_color', true);
      $tab_current_font_color = get_post_meta ($id, 'tab_current_font_color', true);
      $tab_current_bg_color = get_post_meta ($id, 'tab_current_bg_color', true);
      $tab_current_border_color = get_post_meta ($id, 'tab_current_border_color', true);
      $tab_show_border = get_post_meta ($id, 'tab_show_border', true);
      $tab_show_border_active = get_post_meta ($id, 'tab_show_border_active', true); 
      
      $html .= '#wpst-tabset-'.$id.'.tabs-container { background-color: '. $tabs_section_bg .'; padding-top: '. $tabs_section_padding_top .'px; padding-bottom: '. $tabs_section_padding_bottom .'px; }';
      $html .= '#wpst-tabset-'.$id.'.tabs-container .tabs-menu li a { background-color: '. $tab_bg_color .'; color: '. $tab_font_color .'}';
      $html .= '#wpst-tabset-'.$id.'.tabs-container .tabs-menu [aria-selected="false"] { '.($tab_show_border==1 ? 'border: 1px solid '. $tab_border_color : '').'; border-bottom: 0; }';
      $html .= '#wpst-tabset-'.$id.'.tabs-container .tabs-menu [aria-selected="true"] { background-color: '. $tab_current_bg_color .'; color: '. $tab_current_font_color .'; '.($tab_show_border_active==1 ? 'border: 1px solid '. $tab_current_border_color : '').'; border-bottom: 0; }';
      
    endforeach;
    
  endif;

  $html .= '</style>';
  echo $html; 

  

 ?>