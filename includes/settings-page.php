<?php 

  global $post;

  $tabs_section_bg = get_post_meta ($post->ID, 'tabs_section_bg', true);
  $tabs_section_padding_top = get_post_meta ($post->ID, 'tabs_section_padding_top', true);
  $tabs_section_padding_bottom = get_post_meta ($post->ID, 'tabs_section_padding_bottom', true);
  $tab_font_color = get_post_meta ($post->ID, 'tab_font_color', true); 
  $tab_current_font_color = get_post_meta ($post->ID, 'tab_current_font_color', true);
  $tab_bg_color = get_post_meta ($post->ID, 'tab_bg_color', true); 
  $tab_current_bg_color = get_post_meta ($post->ID, 'tab_current_bg_color', true);
  $tab_border_color = get_post_meta ($post->ID, 'tab_border_color', true);
  $tab_current_border_color = get_post_meta ($post->ID, 'tab_current_border_color', true); 
  $tab_show_border = get_post_meta ($post->ID, 'tab_show_border', true); 
  $tab_show_border_active = get_post_meta ($post->ID, 'tab_show_border_active', true); ?>

  <div class="inside wpst-tab-settings hidden">
    <table class="form-table-full">
      <tbody>
        <tr>
          <th scope="row" colspan="6">
            <h3>Tab Group Settings</h3>
          </th>
        </tr>
      </tbody>
    </table>

    <table class="form-table">
      <tbody>
        <tr>
          <td style="width:16.6666666667%">
            <label for="tabs_section_bg">Section Background Color</label>
          </td>
          <td>
            <input type="text" name="tabs_section_bg" id="tabs-section-bg" class="color-field" value="<?= $tabs_section_bg; ?>"/> 
          </td>
        </tr>

        <tr>
          <td class="input-small">
            <label for="tab_font_color">Section Top Padding</label>
          </td>
          <td>
            <input class="section-padding" type="text" name="tabs_section_padding_top" id="tabs-section-padding-top" value="<?= $tabs_section_padding_top; ?>"/> px
          </td>
        </tr>

        <tr>
          <td class="input-small">
            <label for="tab_font_color">Section Bottom Padding</label>
          </td>
          <td>
            <input class="section-padding" type="text" name="tabs_section_padding_bottom" id="tabs-section-padding-bottom" value="<?= $tabs_section_padding_bottom; ?>"/> px
          </td>
        </tr>
      </tbody>
    </table>

    <table class="form-table-full">
      <tbody>
        <tr>
          <th scope="row" colspan="6">
            <h3>Tab Settings</h3>
          </th>
        </tr>
      </tbody>
    </table>

    <table class="form-table">
      <tbody>
        <tr>
          <td scope="row">
            <label for="tab_font_color">Tab Background Color</label>
          </td>
          <td>
            <input type="text" name="tab_bg_color" id="tab-bg-color" class="color-field" value="<?= $tab_bg_color; ?>"/>
          </td>
          <td scope="row">
            <label for="tab_font_color">Active Tab Background Color</label>
          </td>
          <td>
            <input type="text" name="tab_current_bg_color" id="tab-current-bg-color" class="color-field cc-color-picker-field wp-color-picker" value="<?= $tab_current_bg_color; ?>"/>
          </td>
        </tr>

        <tr>
          <td scope="row">
            <label for="tab_font_color">Tab Border Color</label>
          </td>
          <td>
            <input type="text" name="tab_border_color" id="tab-border-color" class="color-field" value="<?= $tab_border_color; ?>"/>
          </td>
          <td scope="row">
            <label for="tab_font_color">Active Tab Border Color</label>
          </td>
          <td>
            <input type="text" name="tab_current_border_color" id="tab-current-border-color" class="color-field" value="<?= $tab_current_border_color; ?>"/>
          </td>
        </tr>

        <tr>
          <td scope="row">
            <label for="tab_font_color">Tab Font Color</label>
          </td>
          <td>
            <input type="text" name="tab_font_color" id="tab-font-color" class="color-field" value="<?= $tab_font_color; ?>"/>
          </td>
          
          <td scope="row">
            <label for="tab_font_color">Active Tab Font Color</label>
          </td>
          <td>
            <input type="text" name="tab_current_font_color" id="tab-current-font-color" class="color-field" value="<?= $tab_current_font_color; ?>"/>
          </td>
        </tr>

        <tr> 
          <td scope="row"> 
            <label for="tab_show_border">Show Inactive Tab Border</label>
          </td> 
          <td>
            <input type="checkbox" name="tab_show_border" id="tab-show-border" value="1" <?php checked( $tab_show_border, 1, true ); ?> />
          </td> 
      
          <td scope="row"> 
            <label for="tab_show_border_active">Show Active Tab Border</label>
          </td> 
          <td>
            <input type="checkbox" name="tab_show_border_active" id="tab-show-border-active" value="1" <?php checked( $tab_show_border_active, 1, true ); ?> />
          </td> 
        </tr>
      </tbody>
    </table>
  </div> <!-- .inside -->